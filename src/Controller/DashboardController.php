<?php

namespace App\Controller;

use App\Entity\Profile;
use App\Repository\AnnonceRepository;
use App\Repository\ForumRepository;
use App\Repository\StandRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/dashboard')]
class DashboardController extends AbstractController
{
    #[Route('/', name: 'dashboard')]
    public function index(AnnonceRepository $annonceRepository, StandRepository $standRepository, ForumRepository $profileRepository): Response
    {
        $annonces = $annonceRepository->findAll();
        $profiles = $profileRepository->findAll();
        $stands = $standRepository->findAll();
        $user = $this->getUser();
        return $this->render('dashboard/index.html.twig', [
            'forums' => $profiles,
            'stands' => $stands,
            'user' => $user,
            'annonces' => $annonces
        ]);
    }

    #[Route('/{id}/inscription', name: 'inscription_cvtheque', methods: ['GET'])]
    public function inscriptionCvtheque($id, Request $request): Response
    {
        $entityManager = $this->getDoctrine()->getManager();
        $profile = $entityManager->getRepository(Profile::class)->find($id);
        $profile->setIsCvtheque(Profile::ISCVTHEQUE);
        $entityManager->persist($profile);
        $entityManager->flush();

        $this->addFlash('success', 'Bravo, Vous êtes dans notre CvThèque');

        if ($referer = $request->get('referer', false)) {
            $referer = base64_decode($referer);
            return $this->redirect(($referer));
        }
            return $this->redirectToRoute('dashboard');
    }
}
