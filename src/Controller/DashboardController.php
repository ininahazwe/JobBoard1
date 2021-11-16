<?php

namespace App\Controller;

use App\Repository\AnnonceRepository;
use App\Repository\ForumRepository;
use App\Repository\StandRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DashboardController extends AbstractController
{
    #[Route('/dashboard', name: 'dashboard')]
    public function index(AnnonceRepository $annonceRepository, StandRepository $standRepository, ForumRepository $forumRepository): Response
    {
        $annonces = $annonceRepository->findAll();
        $forums = $forumRepository->findAll();
        $stands = $standRepository->findAll();
        $user = $this->getUser();
        return $this->render('dashboard/index.html.twig', [
            'forums' => $forums,
            'stands' => $stands,
            'user' => $user,
            'annonces' => $annonces
        ]);
    }
}
