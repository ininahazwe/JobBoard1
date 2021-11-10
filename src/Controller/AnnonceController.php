<?php

namespace App\Controller;

use App\Entity\Annonce;
use App\Entity\File;
use App\Form\AnnonceType;
use App\Repository\AnnonceRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/cms/annonce')]
class AnnonceController extends AbstractController
{
    #[Route('/', name: 'annonce_index', methods: ['GET'])]
    public function index(AnnonceRepository $annonceRepository): Response
    {
        return $this->render('annonce/index.html.twig', [
            'annonces' => $annonceRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'annonce_new', methods: ['GET','POST'])]
    public function new(Request $request): Response
    {
        $annonce = new Annonce();
        $form = $this->createForm(AnnonceType::class, $annonce);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $images = $form->get('documents')->getData();
            foreach($images as $image){
                $fichier = md5(uniqid()) . '.' . $image->guessExtension();
                $nomFichier = $image->getClientOriginalName();
                $image->move($this->getParameter('files_directory'), $fichier);
                $img = new File();
                $img->setNom($fichier);
                $img->setAnnonce($annonce);
                $img->setNomFichier($nomFichier);
                $img->setType(File::TYPE_DOCUMENTS);
                $annonce->addDocument($img);
            }

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($annonce);
            $entityManager->flush();

            return $this->redirectToRoute('annonce_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('annonce/new.html.twig', [
            'annonce' => $annonce,
            'form' => $form,
        ]);
    }

    #[Route('/view/{slug}', name: 'annonce_show', methods: ['GET'])]
    public function show(Annonce $annonce): Response
    {
        return $this->render('annonce/show.html.twig', [
            'annonce' => $annonce,
        ]);
    }

    #[Route('/{id}/edit', name: 'annonce_edit', methods: ['GET','POST'])]
    public function edit(Request $request, Annonce $annonce): Response
    {
        $form = $this->createForm(AnnonceType::class, $annonce);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $images = $form->get('documents')->getData();
            foreach($images as $image){
                $fichier = md5(uniqid()) . '.' . $image->guessExtension();
                $nomFichier = $image->getClientOriginalName();
                $image->move($this->getParameter('files_directory'), $fichier);
                $img = new File();
                $img->setNom($fichier);
                $img->setAnnonce($annonce);
                $img->setNomFichier($nomFichier);
                $img->setType(File::TYPE_ILLUSTRATION);
                $annonce->addDocument($img);
            }

            $annonce->updateTimestamps();

            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('annonce_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('annonce/edit.html.twig', [
            'annonce' => $annonce,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'annonce_delete', methods: ['POST'])]
    public function delete(Request $request, Annonce $annonce): Response
    {
        if ($this->isCsrfTokenValid('delete'.$annonce->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($annonce);
            $entityManager->flush();
        }

        return $this->redirectToRoute('annonce_index', [], Response::HTTP_SEE_OTHER);
    }

    #[Route('/supprime/file/{id}', name: 'annonces_delete_files', methods: ['DELETE'])]
    public function deleteImage(File $file, Request $request): JsonResponse
    {
        $data = json_decode($request->getContent(), true);

        if($this->isCsrfTokenValid('delete'.$file->getId(), $data['_token'])){
            $nom = $file->getNom();
            unlink($this->getParameter('files_directory').'/'.$nom);

            $em = $this->getDoctrine()->getManager();
            $em->remove($file);
            $em->flush();

            return new JsonResponse(['success' => 1]);
        }else{
            return new JsonResponse(['error' => 'Token Invalide'], 400);
        }
    }

    #[Route('/favoris/ajout/{id}', name: 'annonce_ajout_favoris')]
    public function ajoutFavoris(Request $request, Annonce $annonce): RedirectResponse
    {
        if(!$annonce){
            throw new NotFoundHttpException('Pas d\'annonce trouvée');
        }
        $annonce->addFavori($this->getUser());

        $em = $this->getDoctrine()->getManager();
        $em->persist($annonce);
        $em->flush();

        if ($referer = $request->get('referer', false)) {
            $referer = base64_decode($referer);
            return $this->redirect(($referer));
        } else {
            return $this->redirectToRoute('annonce_page', ['slug'=> $annonce->getSlug()], Response::HTTP_SEE_OTHER);
        }
    }

    #[Route('/favoris/retrait/{id}', name: 'annonce_retrait_favoris')]
    public function retraitFavoris(Request $request, Annonce $annonce): RedirectResponse
    {
        if(!$annonce){
            throw new NotFoundHttpException('Pas d\'annonce trouvée');
        }
        $annonce->removeFavori($this->getUser());

        $em = $this->getDoctrine()->getManager();
        $em->persist($annonce);
        $em->flush();

        if ($referer = $request->get('referer', false)) {
            $referer = base64_decode($referer);
            return $this->redirect(($referer));
        } else {
            return $this->redirectToRoute('annonce_page', ['slug'=> $annonce->getSlug()], Response::HTTP_SEE_OTHER);
        }
    }

    #[Route('/selection', name: 'annonce_favoris')]
    public function showFavoris(Request $request, AnnonceRepository $annonceRepository): Response
    {
        $annonces = $annonceRepository->findAnnoncesEnFavori($this->getUser());

        return $this->render('annonce/favoris.html.twig', [
                'annonces' => $annonces,
        ]);
    }

    #[Route('/activer/{id}', name: 'annonce_activer')]
    public function activer(Annonce $annonce): Response
    {
        $annonce->setStatut(!$annonce->getStatut());

        $em = $this->getDoctrine()->getManager();
        $em->persist($annonce);
        $em->flush();

        return new Response("true");
    }
}
