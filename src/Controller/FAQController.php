<?php

namespace App\Controller;

use App\Entity\FAQ;
use App\Form\FAQType;
use App\Repository\FAQRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/cms/faq')]
class FAQController extends AbstractController
{
    #[Route('/', name: 'faq_index', methods: ['GET'])]
    public function index(FAQRepository $fAQRepository): Response
    {
        return $this->render('faq/index.html.twig', [
            'faqs' => $fAQRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'faq_new', methods: ['GET','POST'])]
    public function new(Request $request): Response
    {
        $fAQ = new FAQ();
        $form = $this->createForm(FAQType::class, $fAQ);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($fAQ);
            $entityManager->flush();

            $this->addFlash('success', 'Ajout réussi');

            return $this->redirectToRoute('faq_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('faq/new.html.twig', [
            'faq' => $fAQ,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'faq_show', methods: ['GET'])]
    public function show(FAQ $fAQ): Response
    {
        return $this->render('faq/show.html.twig', [
            'faq' => $fAQ,
        ]);
    }

    #[Route('/{id}/edit', name: 'faq_edit', methods: ['GET','POST'])]
    public function edit(Request $request, FAQ $fAQ): Response
    {
        $form = $this->createForm(FAQType::class, $fAQ);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $fAQ->updateTimestamps();
            $this->getDoctrine()->getManager()->flush();

            $this->addFlash('success', 'Mise à jour réussie');

            return $this->redirectToRoute('faq_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('faq/edit.html.twig', [
            'faq' => $fAQ,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'faq_delete', methods: ['POST'])]
    public function delete(Request $request, FAQ $fAQ): Response
    {
        if ($this->isCsrfTokenValid('delete'.$fAQ->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($fAQ);
            $entityManager->flush();
        }

        return $this->redirectToRoute('faq_index', [], Response::HTTP_SEE_OTHER);
    }
}
