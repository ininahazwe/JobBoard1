<?php

namespace App\Controller;

use App\Entity\Annonce;
use App\Entity\Forum;
use App\Entity\Stand;
use App\Repository\AnnonceRepository;
use App\Repository\BlogRepository;
use App\Repository\FAQRepository;
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
        $forums = $forumRepository->findAll();
        return $this->render('home/index.html.twig', [
            'blogs' => $blog,
            'forums' => $forum,
            'stands' => $stand,
            'allForums' => $forums
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

    #[Route('/stands/{slug}', name: 'stand_page', methods: ['GET'])]
    public function stand(Stand $stand): Response
    {
        return $this->render('home/stand_page.html.twig', [
                'stand' => $stand,
        ]);
    }

    #[Route('/forums', name: 'forums_all', methods: ['GET'])]
    public function forums(ForumRepository $forumRepository): Response
    {
        return $this->render('home/forums.html.twig', [
                'forums' => $forumRepository->findAll(),
        ]);
    }

    #[Route('/forums/{slug}', name: 'forum_page', methods: ['GET'])]
    public function forum(Forum $forum): Response
    {
        return $this->render('home/forum_page.html.twig', [
                'forum' => $forum,
        ]);
    }

    #[Route('/faq', name: 'faq_all', methods: ['GET'])]
    public function faq(FAQRepository $FAQRepository): Response
    {
        return $this->render('home/faq.html.twig', [
                'faqs' => $FAQRepository->findAll(),
        ]);
    }

}
