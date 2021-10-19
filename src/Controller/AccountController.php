<?php

namespace App\Controller;

use App\Entity\File;
use App\Entity\Profile;
use App\Form\ProfileType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/account')]
class AccountController extends AbstractController
{
    #[Route('/profile', name: 'user_profile')]
    public function parametres(): Response
    {
        $user = $this->getUser();

        return $this->render('profile/show.html.twig',[
            'user' => $user
        ]);
    }

    #[Route('/{id}/edit', name: 'user_profile_edit', methods: ['GET','POST'])]
    public function edit(Request $request, Profile $profile): Response
    {
        $user = $this->getUser();
        $form = $this->createForm(ProfileType::class, $profile);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $images = $form->get('photo')->getData();
            foreach($images as $image){
                $fichier = md5(uniqid()) . '.' . $image->guessExtension();
                $nomFichier = $image->getClientOriginalName();
                $image->move($this->getParameter('files_directory'), $fichier);
                $img = new File();
                $img->setUser($user);
                $img->setNom($fichier);
                $img->setNomFichier($nomFichier);
                $img->setType(File::TYPE_AVATAR);
                $profile->addPhoto($img);
            }

            $profile->updateTimestamps();

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($profile);
            $entityManager->flush();

            $this->addFlash('success', 'Mise à jour réussie');
        }

        return $this->renderForm('profile/edit.html.twig', [
                'profile' => $profile,
                'form' => $form,
        ]);
    }
}
