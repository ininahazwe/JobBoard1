<?php

namespace App\Controller;

use App\Entity\CvExperience;
use App\Entity\Profile;
use App\Form\CvExperienceType;
use App\Repository\CvExperienceRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/cms/cvexperience')]
class CvExperienceController extends AbstractController
{
    #[Route('/', name: 'cvexperience_index', methods: ['GET'])]
    public function index(CvExperienceRepository $cvExperienceRepository): Response
    {
        return $this->render('cvexperience/index.html.twig', [
            'cvexperiences' => $cvExperienceRepository->findAll(),
        ]);
    }

    #[Route('/new/{profileId}', name: 'cvexperience_new', methods: ['GET','POST'])]
    public function new(Request $request, $profileId): Response
    {
        $entityManager = $this->getDoctrine()->getManager();
        $profile = $entityManager->getRepository(Profile::class)->find($profileId);

        $user = $this->getUser()->getProfile();
        $cvExperience = new CvExperience();
        $form = $this->createForm(CvExperienceType::class, $cvExperience);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $cvExperience->setProfile($user);
            $entityManager->persist($cvExperience);
            $entityManager->flush();

            return $this->redirectToRoute('profile_show', ['id'=> $profile->getId()], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('cvexperience/new.html.twig', [
            'profile' => $profile,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'cvexperience_show', methods: ['GET'])]
    public function show(CvExperience $cvExperience): Response
    {
        return $this->render('cvexperience/show.html.twig', [
            'cvexperience' => $cvExperience,
        ]);
    }

    #[Route('/{id}/{profileId}/edit', name: 'cvexperience_edit', methods: ['GET','POST'])]
    public function edit(Request $request, CvExperience $cvExperience, $profileId): Response
    {
        $entityManager = $this->getDoctrine()->getManager();
        $profile = $entityManager->getRepository(Profile::class)->find($profileId);

        $form = $this->createForm(CvExperienceType::class, $cvExperience);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $cvExperience->updateTimestamps();
            $entityManager->flush();

            return $this->redirectToRoute('profile_show', ['id'=> $profile->getId()], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('cvexperience/edit.html.twig', [
            'cvexperience' => $cvExperience,
            'profile' => $profile,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'cvexperience_delete', methods: ['POST'])]
    public function delete(Request $request, CvExperience $cvExperience): Response
    {
        if ($this->isCsrfTokenValid('delete'.$cvExperience->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($cvExperience);
            $entityManager->flush();
        }

        return $this->redirectToRoute('cvexperience_index', [], Response::HTTP_SEE_OTHER);
    }
}
