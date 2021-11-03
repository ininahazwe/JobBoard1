<?php

namespace App\Controller;

use App\Repository\AnnonceRepository;
use App\Repository\BlogRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    #[Route('/', name: 'home')]
    public function index(BlogRepository $blogRepository): Response
    {
        $blog = $blogRepository->findAll();
        return $this->render('home/index.html.twig', [
            'blogs' => $blog,
        ]);
    }

    #[Route('/job/all', name: 'annonces_all', methods: ['GET'])]
    public function jobs(AnnonceRepository $annonceRepository): Response
    {
        return $this->render('home/annonces.html.twig', [
                'annonces' => $annonceRepository->findAll(),
        ]);
    }
}
