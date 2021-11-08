<?php

namespace App\Controller;

use App\Entity\Pavillon;
use App\Form\PavillonType;
use App\Repository\PavillonRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/pavillons')]
class PavillonController extends AbstractController
{
    #[Route('/', name: 'pavillon_index', methods: ['GET'])]
    public function index(PavillonRepository $pavillonRepository): Response
    {
        return $this->render('pavillon/index.html.twig', [
            'pavillons' => $pavillonRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'pavillon_new', methods: ['GET','POST'])]
    public function new(Request $request): Response
    {
        $pavillon = new Pavillon();
        $form = $this->createForm(PavillonType::class, $pavillon);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($pavillon);
            $entityManager->flush();

            $this->addFlash('success', 'Ajout réussi');

            return $this->redirectToRoute('pavillon_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('pavillon/new.html.twig', [
            'pavillon' => $pavillon,
            'form' => $form,
        ]);
    }

    #[Route('/{slug}', name: 'pavillon_show', methods: ['GET'])]
    public function show(Pavillon $pavillon): Response
    {
        return $this->render('pavillon/show.html.twig', [
            'pavillon' => $pavillon,
        ]);
    }

    #[Route('/{id}/edit', name: 'pavillon_edit', methods: ['GET','POST'])]
    public function edit(Request $request, Pavillon $pavillon): Response
    {
        $form = $this->createForm(PavillonType::class, $pavillon);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            $this->addFlash('success', 'Mise à jour réussie');

            return $this->redirectToRoute('pavillon_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('pavillon/edit.html.twig', [
            'pavillon' => $pavillon,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'pavillon_delete', methods: ['POST'])]
    public function delete(Request $request, Pavillon $pavillon): Response
    {
        if ($this->isCsrfTokenValid('delete'.$pavillon->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($pavillon);
            $entityManager->flush();
        }

        return $this->redirectToRoute('pavillon_index', [], Response::HTTP_SEE_OTHER);
    }
}
