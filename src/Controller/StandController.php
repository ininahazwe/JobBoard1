<?php

namespace App\Controller;

use App\Entity\File;
use App\Entity\Stand;
use App\Form\StandType;
use App\Repository\StandRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/stands')]
class StandController extends AbstractController
{
    #[Route('/', name: 'stand_index', methods: ['GET'])]
    public function index(StandRepository $standRepository): Response
    {
        return $this->render('stand/index.html.twig', [
            'stands' => $standRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'stand_new', methods: ['GET','POST'])]
    public function new(Request $request): Response
    {
        $stand = new Stand();
        $form = $this->createForm(StandType::class, $stand);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $images = $form->get('logo')->getData();
            foreach($images as $image){
                $fichier = md5(uniqid()) . '.' . $image->guessExtension();
                $nomFichier = $image->getClientOriginalName();
                $image->move($this->getParameter('files_directory'), $fichier);
                $img = new File();
                $img->setStand($stand);
                $img->setNom($fichier);
                $img->setNomFichier($nomFichier);
                $img->setType(File::TYPE_LOGO);
                $stand->addLogo($img);
            }

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($stand);
            $entityManager->flush();

            $this->addFlash('success', 'Ajout réussi');

            return $this->redirectToRoute('stand_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('stand/new.html.twig', [
            'stand' => $stand,
            'form' => $form,
        ]);
    }

    #[Route('/{slug}', name: 'stand_show', methods: ['GET'])]
    public function show(Stand $stand): Response
    {
        return $this->render('stand/show.html.twig', [
            'stand' => $stand,
        ]);
    }

    #[Route('/{id}/edit', name: 'stand_edit', methods: ['GET','POST'])]
    public function edit(Request $request, Stand $stand): Response
    {
        $form = $this->createForm(StandType::class, $stand);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $images = $form->get('logo')->getData();
            foreach($images as $image){
                $fichier = md5(uniqid()) . '.' . $image->guessExtension();
                $nomFichier = $image->getClientOriginalName();
                $image->move($this->getParameter('files_directory'), $fichier);
                $img = new File();
                $img->setStand($stand);
                $img->setNom($fichier);
                $img->setNomFichier($nomFichier);
                $img->setType(File::TYPE_LOGO);
                $stand->addLogo($img);
            }

            $stand->updateTimestamps();
            $this->getDoctrine()->getManager()->flush();
            $this->addFlash('success', 'Mise à jour réussie');

            return $this->redirectToRoute('stand_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('stand/edit.html.twig', [
            'stand' => $stand,
            'form' => $form,
        ]);
    }

    #[Route('/{id}/publier', name: 'stand_publier', methods: ['GET'])]
    public function publier($id, Request $request, Stand $stand): Response
    {
        $entityManager = $this->getDoctrine()->getManager();
        $stand = $entityManager->getRepository(Stand::class)->find($id);
        $stand->setStatut(Stand::PUBLIE);
        $entityManager->persist($stand);
        $entityManager->flush();

        $this->addFlash('success', 'Publication réussie');

        if ($referer = $request->get('referer', false)) {
            $referer = base64_decode($referer);
            return $this->redirect(($referer));
        } else {
            return $this->redirectToRoute('stand_index');
        }
    }

    #[Route('/{id}/depublier', name: 'stand_depublier', methods: ['GET'])]
    public function depublier($id, Request $request, Stand $stand): Response
    {
        $entityManager = $this->getDoctrine()->getManager();
        $stand = $entityManager->getRepository(Stand::class)->find($id);
        $stand->setStatut(Stand::DEPUBLIE);
        $entityManager->persist($stand);
        $entityManager->flush();

        $this->addFlash('success', 'Dépublication réussie');

        if ($referer = $request->get('referer', false)) {
            $referer = base64_decode($referer);
            return $this->redirect(($referer));
        } else {
            return $this->redirectToRoute('stand_index');
        }
    }

    #[Route('/{id}', name: 'stand_delete', methods: ['POST'])]
    public function delete(Request $request, Stand $stand): Response
    {
        if ($this->isCsrfTokenValid('delete'.$stand->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($stand);
            $entityManager->flush();
        }

        return $this->redirectToRoute('stand_index', [], Response::HTTP_SEE_OTHER);
    }

    #[Route('/supprime/file/{id}', name: 'stand_delete_files', methods: ['DELETE'])]
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
}
