<?php

namespace App\Controller;

use App\Entity\Profile;
use App\Entity\User;
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
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('profile_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('profile/edit.html.twig', [
                'profile' => $profile,
                'form' => $form,
                'user' => $user
        ]);
    }
}
