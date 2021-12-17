<?php

namespace App\Controller;

use App\Entity\File;
use App\Entity\Forum;
use App\Form\ForumType;
use App\Repository\ForumRepository;
use App\Repository\PavillonRepository;
use App\Repository\StandRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/cms/forum')]
class ForumController extends AbstractController
{
    #[Route('/', name: 'forum_index', methods: ['GET'])]
    public function index(ForumRepository $forumRepository): Response
    {
        return $this->render('forum/index.html.twig', [
            'forums' => $forumRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'forum_new', methods: ['GET','POST'])]
    public function new(Request $request): Response
    {
        $forum = new Forum();
        $form = $this->createForm(ForumType::class, $forum);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $images = $form->get('logo')->getData();
            foreach($images as $image){
                $fichier = md5(uniqid()) . '.' . $image->guessExtension();
                $nomFichier = $image->getClientOriginalName();
                $image->move($this->getParameter('files_directory'), $fichier);
                $img = new File();
                $img->setForum($forum);
                $img->setNom($fichier);
                $img->setNomFichier($nomFichier);
                $img->setType(File::TYPE_LOGO);
                $forum->addLogo($img);
            }

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($forum);
            $entityManager->flush();

            $this->addFlash('success', 'Ajout réussi');

            return $this->redirectToRoute('forum_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('forum/new.html.twig', [
            'forum' => $forum,
            'form' => $form,
        ]);
    }

    #[Route('/{slug}', name: 'forum_show', methods: ['GET'])]
    public function show(Forum $forum): Response
    {
        return $this->render('forum/show.html.twig', [
            'forum' => $forum,
        ]);
    }

    #[Route('/{id}/edit', name: 'forum_edit', methods: ['GET','POST'])]
    public function edit(Request $request, Forum $forum, PavillonRepository $pavillonRepository, StandRepository $standRepository): Response
    {
        $pavillon = $pavillonRepository->findAll();
        $stands = $standRepository->findAll();
        $form = $this->createForm(ForumType::class, $forum);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $images = $form->get('logo')->getData();
            foreach($images as $image){
                $fichier = md5(uniqid()) . '.' . $image->guessExtension();
                $nomFichier = $image->getClientOriginalName();
                $image->move($this->getParameter('files_directory'), $fichier);
                $img = new File();
                $img->setForum($forum);
                $img->setNom($fichier);
                $img->setNomFichier($nomFichier);
                $img->setType(File::TYPE_LOGO);
                $forum->addLogo($img);
            }

            $forum->updateTimestamps();
            $this->getDoctrine()->getManager()->flush();

            $this->addFlash('success', 'Mise à jour réussie');

            if ($referer = $request->get('referer', false)) {
                $referer = base64_decode($referer);
                return $this->redirect(($referer));
            } else {
                return $this->redirectToRoute('forum_index', [], Response::HTTP_SEE_OTHER);
            }
        }

        return $this->renderForm('forum/edit.html.twig', [
            'forum' => $forum,
            'form' => $form,
            'pavillons' => $pavillon,
            'stands' => $stands
        ]);
    }

    #[Route('/{id}/ouvrir', name: 'forum_ouvrir', methods: ['GET'])]
    public function ouvrir($id, Request $request, Forum $forum): Response
    {
        $entityManager = $this->getDoctrine()->getManager();
        $forum = $entityManager->getRepository(Forum::class)->find($id);
        $forum->setStatut(Forum::OUVERT);
        $entityManager->persist($forum);
        $entityManager->flush();

        $this->addFlash('success', 'Ouverture réussie');

        if ($referer = $request->get('referer', false)) {
            $referer = base64_decode($referer);
            return $this->redirect(($referer));
        } else {
            return $this->redirectToRoute('forum_index');
        }
    }

    #[Route('/{id}/fermer', name: 'forum_fermer', methods: ['GET'])]
    public function fermer($id, Request $request, Forum $forum): Response
    {
        $entityManager = $this->getDoctrine()->getManager();
        $forum = $entityManager->getRepository(Forum::class)->find($id);
        $forum->setStatut(Forum::FERME);
        $entityManager->persist($forum);
        $entityManager->flush();

        $this->addFlash('success', 'Fermeture réussie');

        if ($referer = $request->get('referer', false)) {
            $referer = base64_decode($referer);
            return $this->redirect(($referer));
        } else {
            return $this->redirectToRoute('forum_index');
        }
    }

    #[Route('/{id}', name: 'forum_delete', methods: ['POST'])]
    public function delete(Request $request, Forum $forum): Response
    {
        if ($this->isCsrfTokenValid('delete'.$forum->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($forum);
            $entityManager->flush();
        }

        return $this->redirectToRoute('forum_index', [], Response::HTTP_SEE_OTHER);
    }

    #[Route('/supprime/file/{id}', name: 'forum_delete_files', methods: ['DELETE'])]
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

    #[Route('/favoris/ajout/{id}', name: 'forum_ajout_favoris')]
    public function ajoutFavoris(Request $request, Forum $forum): RedirectResponse
    {
        if(!$forum){
            throw new NotFoundHttpException('Pas de forum trouvé');
        }
        $forum->addFavorisForum($this->getUser());

        $em = $this->getDoctrine()->getManager();
        $em->persist($forum);
        $em->flush();

        if ($referer = $request->get('referer', false)) {
            $referer = base64_decode($referer);
            return $this->redirect(($referer));
        } else {
            return $this->redirectToRoute('forums_all', [], Response::HTTP_SEE_OTHER);
        }
    }

    #[Route('/favoris/retrait/{id}', name: 'forum_retrait_favoris')]
    public function retraitFavoris(Request $request, Forum $forum): RedirectResponse
    {
        if(!$forum){
            throw new NotFoundHttpException('Pas de Forum trouvé');
        }
        $forum->removeFavorisForum($this->getUser());

        $em = $this->getDoctrine()->getManager();
        $em->persist($forum);
        $em->flush();

        if ($referer = $request->get('referer', false)) {
            $referer = base64_decode($referer);
            return $this->redirect(($referer));
        } else {
            return $this->redirectToRoute('forums_all', [], Response::HTTP_SEE_OTHER);
        }
    }

    #[Route('/selection/favoris', name: 'forum_favoris')]
    public function showForumsFavoris(ForumRepository $forumRepository): Response
    {
        $forums = $forumRepository->findForumsEnFavori($this->getUser());

        return $this->render('forum/favoris.html.twig', [
                'forums' => $forums,
        ]);
    }
}
