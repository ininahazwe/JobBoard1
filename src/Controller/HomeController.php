<?php

namespace App\Controller;

use App\Entity\Annonce;
use App\Entity\Stand;
use App\Repository\AnnonceRepository;
use App\Repository\BlogRepository;
use App\Repository\ForumRepository;
use App\Repository\StandRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    #[Route('/', name: 'home')]
    public function index(BlogRepository $blogRepository, ForumRepository $forumRepository, StandRepository $standRepository): Response
    {
        $blog = $blogRepository->findAll();
        $stand = $standRepository->findAll();
        $forum = $forumRepository->findLastInserted();
        return $this->render('home/index.html.twig', [
            'blogs' => $blog,
            'forums' => $forum,
            'stands' => $stand
        ]);
    }

    #[Route('/job/all', name: 'annonces_all', methods: ['GET'])]
    public function annonces(AnnonceRepository $annonceRepository): Response
    {
        return $this->render('home/annonces.html.twig', [
                'annonces' => $annonceRepository->findAll(),
        ]);
    }

    #[Route('/job/{slug}', name: 'annonce_page', methods: ['GET'])]
    public function annonce(Annonce $annonce): Response
    {
        return $this->render('home/annonce_page.html.twig', [
                'annonce' => $annonce,
        ]);
    }

    #[Route('/salon/pavillon/liste-des-stands', name: 'stands_all', methods: ['GET'])]
    public function stands(StandRepository $standRepository): Response
    {
        return $this->render('home/stands.html.twig', [
                'stands' => $standRepository->findAll(),
        ]);
    }

    #[Route('/stand/{slug}', name: 'stand_page', methods: ['GET'])]
    public function stand(Stand $stand): Response
    {
        return $this->render('home/stand_page.html.twig', [
                'stand' => $stand,
        ]);
    }
}
