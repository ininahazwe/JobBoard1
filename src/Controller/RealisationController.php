<?php

namespace App\Controller;

use App\Entity\Profile;
use App\Entity\Realisation;
use App\Form\RealisationType;
use App\Repository\RealisationRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/realisation')]
class RealisationController extends AbstractController
{
    #[Route('/', name: 'realisation_index', methods: ['GET'])]
    public function index(RealisationRepository $realisationRepository): Response
    {
        return $this->render('realisation/index.html.twig', [
            'realisations' => $realisationRepository->findAll(),
        ]);
    }

    #[Route('/new/{profileId}', name: 'realisation_new', methods: ['GET','POST'])]
    public function new(Request $request, $profileId): Response
    {
        $entityManager = $this->getDoctrine()->getManager();
        $profile = $entityManager->getRepository(Profile::class)->find($profileId);

        $user = $this->getUser()->getProfile();

        $realisation = new Realisation();
        $form = $this->createForm(RealisationType::class, $realisation);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $realisation->setProfile($user);
            $entityManager->persist($realisation);
            $entityManager->flush();

            return $this->redirectToRoute('profile_show', ['id'=> $profile->getId()], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('realisation/new.html.twig', [
                'profile' => $profile,
                'form' => $form,
        ]);
    }

    #[Route('/{id}/{profileId}/edit', name: 'realisation_show', methods: ['GET'])]
    public function show(Realisation $realisation): Response
    {
        return $this->render('realisation/show.html.twig', [
            'realisation' => $realisation,
        ]);
    }

    #[Route('/{id}/edit', name: 'realisation_edit', methods: ['GET','POST'])]
    public function edit(Request $request, Realisation $realisation, $profileId): Response
    {
        $entityManager = $this->getDoctrine()->getManager();
        $profile = $entityManager->getRepository(Profile::class)->find($profileId);

        $form = $this->createForm(RealisationType::class, $realisation);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $realisation->updateTimestamps();
            $entityManager->flush();

            return $this->redirectToRoute('profile_show', ['id'=> $profile->getId()], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('realisation/edit.html.twig', [
            'realisation' => $realisation,
                'profile' => $profile,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'realisation_delete', methods: ['POST'])]
    public function delete(Request $request, Realisation $realisation): Response
    {
        if ($this->isCsrfTokenValid('delete'.$realisation->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($realisation);
            $entityManager->flush();
        }

        return $this->redirectToRoute('realisation_index', [], Response::HTTP_SEE_OTHER);
    }
}
