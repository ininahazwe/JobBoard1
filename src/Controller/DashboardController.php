<?php

namespace App\Controller;

use App\Entity\Profile;
use App\Repository\AnnonceRepository;
use App\Repository\CandidatureRepository;
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
    public function index(AnnonceRepository $annonceRepository, StandRepository $standRepository, ForumRepository $profileRepository, CandidatureRepository $candidatureRepository): Response
    {
        $annonces = $annonceRepository->findAll();
        $Allcandidatures = $annonceRepository->findAll();
        $profiles = $profileRepository->findAll();
        $stands = $standRepository->findAll();
        $user = $this->getUser();

        $standNom = [];
        $standCount = [];

        foreach($stands as $stand){
            $standNom[] = $stand->getNom();
            $standCount[] = count($stand->getAnnonces());
        }

        $candidatures = $candidatureRepository->countByDate();
        $dates = [];
        $candidaturesCount = [];

        foreach($candidatures as $candidature){
            $dates[] = $candidature['dateCandidatures'];
            $candidaturesCount[] = $candidature['count'];
        }

        return $this->render('dashboard/index.html.twig', [
            'forums' => $profiles,
            'stands' => $stands,
            'user' => $user,
            'annonces' => $annonces,
            'candidatures' => $Allcandidatures,
            'standNom' => json_encode($standNom),
            'standCount' => json_encode($standCount),
            'dates' => json_encode($dates),
            'candidaturesCount' => json_encode($candidaturesCount),
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

    #[Route('/stats', name: 'stats')]
    public function statistiques(StandRepository $standRepository, CandidatureRepository $candidatureRepository, ChartBuilderInterface $chartBuilder): Response
    {
        $stands = $standRepository->findAll();

        $standNom = [];
        $standCount = [];

        foreach($stands as $stand){
            $standNom[] = $stand->getNom();
            $standCount[] = count($stand->getAnnonces());
        }

        $candidatures = $candidatureRepository->countByDate();
        $dates = [];
        $candidaturesCount = [];

        foreach($candidatures as $candidature){
            $dates[] = $candidature['dateCandidatures'];
            $candidaturesCount[] = $candidature['count'];
        }

        return $this->render('dashboard/index.html.twig', [
                'standNom' => json_encode($standNom),
                'standCount' => json_encode($standCount),
                'dates' => json_encode($dates),
                'candidaturesCount' => json_encode($candidaturesCount),
        ]);
    }

}
