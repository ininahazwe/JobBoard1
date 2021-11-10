<?php

namespace App\Controller;

use App\Repository\AnnonceRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DashboardController extends AbstractController
{
    #[Route('/dashboard', name: 'dashboard')]
    public function index(AnnonceRepository $annonceRepository): Response
    {
        $annonces = $annonceRepository->findAll();
        $user = $this->getUser();
        return $this->render('dashboard/index.html.twig', [
            'user' => $user,
            'annonces' => $annonces
        ]);
    }
}
