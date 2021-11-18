<?php

namespace App\Controller;

use App\Entity\Email;
use App\Entity\File;
use App\Entity\Stand;
use App\Entity\User;
use App\Form\StandType;
use App\Form\UserType;
use App\Repository\StandRepository;
use App\Repository\UserRepository;
use App\Service\Mailer;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;
use Twig\Environment;
use Twig\Loader\ArrayLoader;

#[Route('/cms/stands')]
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
               $this->saveDoc($stand, $image, File::TYPE_LOGO);
            }
            $images = $form->get('documents')->getData();
            foreach($images as $image){
                $this->saveDoc($stand, $image, File::TYPE_DOCUMENTS);
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

    public function saveDoc($stand, $image, $type)
    {
        $fichier = md5(uniqid()) . '.' . $image->guessExtension();
        $nomFichier = $image->getClientOriginalName();
        $image->move($this->getParameter('files_directory'), $fichier);
        //$document->move($this->getParameter('files_directory'), $fichier);
        $img = new File();

        $img->setNom($fichier);
        $img->setNomFichier($nomFichier);
        if ($type == File::TYPE_LOGO){
            $img->setStand($stand);
            $img->setType($type);
            $stand->addLogo($img);
        }
        if ($type == File::TYPE_DOCUMENTS){
            $img->setStandDocuments($stand);
            $img->setType($type);
            $stand->addDocument($img);
        }

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
                $this->saveDoc($stand, $image, File::TYPE_LOGO);
            }
            $images = $form->get('documents')->getData();
            foreach($images as $image){
                $this->saveDoc($stand, $image, File::TYPE_DOCUMENTS);
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

    #[Route('/favoris/ajout/{id}', name: 'stand_ajout_favoris')]
    public function ajoutFavoris(Request $request, Stand $stand): RedirectResponse
    {
        if(!$stand){
            throw new NotFoundHttpException('Pas de stand trouvé');
        }
        $stand->addFavorisStand($this->getUser());

        $em = $this->getDoctrine()->getManager();
        $em->persist($stand);
        $em->flush();

        if ($referer = $request->get('referer', false)) {
            $referer = base64_decode($referer);
            return $this->redirect(($referer));
        } else {
            return $this->redirectToRoute('stands_all', [], Response::HTTP_SEE_OTHER);
        }
    }

    #[Route('/favoris/retrait/{id}', name: 'stand_retrait_favoris')]
    public function retraitFavoris(Request $request, Stand $stand): RedirectResponse
    {
        if(!$stand){
            throw new NotFoundHttpException('Pas de stand trouvé');
        }
        $stand->removeFavorisStand($this->getUser());

        $em = $this->getDoctrine()->getManager();
        $em->persist($stand);
        $em->flush();

        if ($referer = $request->get('referer', false)) {
            $referer = base64_decode($referer);
            return $this->redirect(($referer));
        } else {
            return $this->redirectToRoute('stands_all', [], Response::HTTP_SEE_OTHER);
        }
    }

    #[Route('/selection/favoris', name: 'stand_favoris')]
    public function showStandsFavoris(StandRepository $standRepository): Response
    {
        $stands = $standRepository->findStandsEnFavori($this->getUser());

        return $this->render('stand/favoris.html.twig', [
                'stands' => $stands,
        ]);
    }

    #[Route('/{id}/recruteurs', name: 'stand_recruteurs', methods: ['GET', 'POST'])]
    public function recruteurs(Request $request, Stand $stand): Response
    {
        $user = new User();

        $form = $this->createForm(UserType::class, $user);

        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->persist($stand);
        $entityManager->flush();

        return $this->render('stand/recruteurs.html.twig', [
                'user' => $user,
                'stand' =>$stand,
                'form' => $form->createView(),
        ]);
    }

    #[Route('/{id}/recruteur/create', name: 'stand_recruteurs_create', methods: ['GET', 'POST'])]
    public function recruteurCreate(Request $request, Stand $stand, UserRepository $userRepository, UserPasswordHasherInterface $userPasswordHasherInterface, Mailer $mailer): Response
    {
        $entityManager = $this->getDoctrine()->getManager();
        $user = new User();

        $form = $this->createForm(UserType::class, $user);
        $form->handleRequest($request);


        if ($form->isSubmitted() && $form->isValid()) {

            $userExist = $userRepository->findOneBy(['email' =>$form->get('email')->getData()]);
            $password = $userRepository->genererMDP();
            if ($userExist){
                $user = $userExist;
            }

            if (!$userExist) {
                $user->setPassword(
                        $userPasswordHasherInterface->hashPassword(
                                $user,
                                $password
                        )
                );
            }

            //if($form->get('roles')->getData() == null){
                $user->setRoles(['ROLE_RECRUTEUR']);
            //}

                $stand->addGestionnaire($user);


            $user->setIsVerified(User::ACCEPTEE);
            $entityManager->persist($user);
            $entityManager->persist($stand);
            $entityManager->flush();

            $email = $entityManager->getRepository(Email::class)->findOneBy(['code' => 'EMAIL_CREATION_RECRUTEUR']);

            $loader = new ArrayLoader([
                    'email' => $email->getContenu(),
            ]);

            $twig = new Environment($loader);
            $message = $twig->render('email',['user' => $this->getUser(), 'recruteur' => $user, 'password' => $password, 'stand' => $stand ]);

            $mailer->send([
                    'recipient_email' => $user->getEmail(),
                    'subject'         => $email->getSujet(),
                    'html_template'   => 'email/email_vide.html.twig',
                    'context'         => [
                            'message' => $message
                    ]
            ]);

            $this->addFlash('success', 'Ajout réussi');

            return $this->redirectToRoute('stand_recruteurs',['id' => $stand->getId()]);

        }

        return $this->render('user/new.html.twig', [
                'stand' => $stand,
                'form' => $form->createView(),
        ]);

    }

    #[Route('/{id}/recruteur/deleteRecruteur/{userID}', name: 'stand_recruteurs_delete', methods: ['GET', 'POST'])]
    public function deleteRecruteur($userID, Request $request, Stand $stand, UserRepository $userRepository): Response
    {
        $user = $userRepository->find($userID);
        $entityManager = $this->getDoctrine()->getManager();
        if ($stand->getGestionnaire()->contains($user)){
            $stand->removeGestionnaire($user);
        }

        $entityManager->persist($stand);
        $entityManager->flush();

        $this->addFlash('success', 'La suppression du recruteur '. $user->getFullname() .' est réussie');

        return $this->redirectToRoute('stand_recruteurs',['slug' => $stand->getSlug()]);
    }

    #[Route('/{id}/recruteur/generateMDP/{userID}', name: 'stand_recruteurs_generateMDP', methods: ['GET', 'POST'])]
    public function generateMDPRecruteurs($userID, Request $request, Stand $stand, UserRepository $userRepository, UserPasswordHasherInterface $userPasswordHasherInterface, Mailer $mailer): Response
    {
        $password = $userRepository->genererMDP();
        $user = $userRepository->find($userID);

        $user->setPassword(
                $userPasswordHasherInterface->hashPassword(
                        $user,
                        $password
                )
        );

        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->persist($user);
        $entityManager->flush();

        $email = $entityManager->getRepository(Email::class)->findOneBy(['code' => 'EMAIL_GENERATION_PASSWORD_RECRUTEUR']);

        $loader = new ArrayLoader([
                'email' => $email->getContenu(),
        ]);

        $twig = new Environment($loader);
        $message = $twig->render('email',['user' => $this->getUser(), 'recruteur' => $user, 'password' => $password ]);

        $mailer->send([
                'recipient_email' => $user->getEmail(),
                'subject'         => $email->getSujet(),
                'html_template'   => 'email/email_vide.html.twig',
                'context'         => [
                        'message' => $message
                ]
        ]);

        $this->addFlash('success', 'Envoi réussi');

        return $this->redirectToRoute('stand_recruteurs',['id' => $stand->getId()]);
    }
}
