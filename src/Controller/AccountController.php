<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
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
}
