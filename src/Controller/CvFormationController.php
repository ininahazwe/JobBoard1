<?php

namespace App\Controller;

use App\Entity\CvFormation;
use App\Entity\Profile;
use App\Form\CvFormationType;
use App\Repository\CvFormationRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/cms/cvformation')]
class CvFormationController extends AbstractController
{
    #[Route('/', name: 'cvformation_index', methods: ['GET'])]
    public function index(CvFormationRepository $cvFormationRepository): Response
    {
        return $this->render('cvformation/index.html.twig', [
            'cvformations' => $cvFormationRepository->findAll(),
        ]);
    }

    #[Route('/new/{profileId}', name: 'cvformation_new', methods: ['GET','POST'])]
    public function new(Request $request, $profileId): Response
    {
        $entityManager = $this->getDoctrine()->getManager();
        $profile = $entityManager->getRepository(Profile::class)->find($profileId);

        $user = $this->getUser()->getProfile();
        $cvFormation = new CvFormation();
        $form = $this->createForm(CvFormationType::class, $cvFormation);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $cvFormation->setProfile($user);
            $entityManager->persist($cvFormation);
            $entityManager->flush();

            return $this->redirectToRoute('profile_show', ['id'=> $profile->getId()], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('cvformation/new.html.twig', [
            'profile' => $profile,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'cvformation_show', methods: ['GET'])]
    public function show(CvFormation $cvFormation): Response
    {
        return $this->render('cvformation/show.html.twig', [
            'cvformation' => $cvFormation,
        ]);
    }

    #[Route('/{id}/{profileId}/edit', name: 'cvformation_edit', methods: ['GET','POST'])]
    public function edit(Request $request, CvFormation $cvFormation, $profileId): Response
    {
        $entityManager = $this->getDoctrine()->getManager();
        $profile = $entityManager->getRepository(Profile::class)->find($profileId);

        $form = $this->createForm(CvFormationType::class, $cvFormation);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $cvFormation->updateTimestamps();
            $entityManager->flush();

            return $this->redirectToRoute('profile_show', ['id'=> $profile->getId()], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('cvformation/edit.html.twig', [
            'cvformation' => $cvFormation,
            'profile' => $profile,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'cvformation_delete', methods: ['POST'])]
    public function delete(Request $request, CvFormation $cvFormation): Response
    {
        if ($this->isCsrfTokenValid('delete'.$cvFormation->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($cvFormation);
            $entityManager->flush();
        }

        return $this->redirectToRoute('cvformation_index', [], Response::HTTP_SEE_OTHER);
    }
}
