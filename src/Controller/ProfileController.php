<?php

namespace App\Controller;

use App\Data\SearchDataProfile;
use App\Entity\CvExperience;
use App\Entity\CvFormation;
use App\Entity\File;
use App\Entity\Profile;
use App\Form\CvExperienceType;
use App\Form\CvFormationType;
use App\Form\CvType;
use App\Form\ProfileType;
use App\Form\Search\SearchProfileForm;
use App\Repository\FileRepository;
use App\Repository\ProfileRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/profile')]
class ProfileController extends AbstractController {
    #[Route('/', name: 'profile_index', methods: ['GET'])]
    public function index(ProfileRepository $profileRepository): Response {
        return $this->render('profile/index.html.twig', [
                'profiles' => $profileRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'profile_new', methods: ['GET', 'POST'])]
    public function new(Request $request): Response {
        $profile = new Profile();
        $user = $this->getUser();
        $form = $this->createForm(ProfileType::class, $profile);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $images = $form->get('photo')->getData();
            foreach ($images as $image) {
                $fichier = md5(uniqid()) . '.' . $image->guessExtension();
                $nomFichier = $image->getClientOriginalName();
                $image->move($this->getParameter('files_directory'), $fichier);
                $img = new File();
                $img->setUser($user);
                $img->setNom($fichier);
                $img->setNomFichier($nomFichier);
                $img->setType(File::TYPE_AVATAR);
                $profile->addPhoto($img);
            }

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($profile);
            $entityManager->flush();

            $this->addFlash('success', 'Ajout réussi');

            return $this->redirectToRoute('profile_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('profile/new.html.twig', [
                'profile' => $profile,
                'form' => $form,
        ]);
    }

    #[Route('/cv/{id}', name: 'profile_my_cv', methods: ['GET', 'POST'])]
    public function GestionCV(Request $request, Profile $profile, FileRepository $fileRepository): Response {
        $entityManager = $this->getDoctrine()->getManager();
        $user = $this->getUser();
        $cVCandidat = $fileRepository->getCVByCandidat($profile, $user);
        $form = $this->createForm(CvType::class, $profile);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $images = $form->get('cv')->getData();
            foreach ($images as $image) {
                $fichier = md5(uniqid()) . '.' . $image->guessExtension();
                $nomFichier = $image->getClientOriginalName();
                $image->move($this->getParameter('files_directory'), $fichier);
                $img = new File();
                $img->setNom($fichier);
                $img->setUser($user);
                $img->setNomFichier($nomFichier);
                $img->setType(File::TYPE_CV);
                $img->setProfile($profile);
                $entityManager->persist($img);
                $profile->addCv($img);
            }

            $profile->updateTimestamps();
            $entityManager->persist($profile);
            $entityManager->flush();

            $this->addFlash('success', 'Ajout réussi');
        }

        return $this->renderForm('profile/new_cv.html.twig', [
                'profile' => $profile,
                'form' => $form,
                'cVCandidat' => $cVCandidat,
        ]);
    }

    #[Route('/cvtheque', name: 'cvtheque', methods: ['GET'])]
    public function cvtheque(FileRepository $fileRepository, ProfileRepository $profileRepository, Request $request): Response {

        $data = new SearchDataProfile();
        $data->page = $request->get('page', 1);
        $form = $this->createForm(SearchProfileForm::class, $data);
        $form->handleRequest($request);

        $profiles = $profileRepository->findSearch($data);

        if ($request->get('ajax')) {
            return new JsonResponse([
                    'content' => $this->renderView('profile/_profiles.html.twig', ['profiles' => $profiles]),
                    'pagination' => $this->renderView('profile/_pagination.html.twig', ['profiles' => $profiles]),
                    'pages' => ceil($profiles->getTotalItemCount() / $profiles->getItemNumberPerPage())
            ]);
        }

        return $this->render('profile/cvtheque.html.twig', [
                'profiles' => $profiles,
                'form' => $form->createView()
        ]);
    }

    #[Route('/{id}', name: 'profile_show', methods: ['GET'])]
    public function show(Profile $profile): Response {
        $user = $this->getUser();
        return $this->render('profile/show.html.twig', [
                'profile' => $profile,
                'user' => $user,
        ]);
    }

    #[Route('/{id}/edit', name: 'profile_edit', methods: ['GET','POST'])]
    public function edit(Request $request, Profile $profile): Response
    {
        $user = $this->getUser();
        $form = $this->createForm(ProfileType::class, $profile);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $images = $form->get('photo')->getData();
            foreach($images as $image){
                $fichier = md5(uniqid()) . '.' . $image->guessExtension();
                $nomFichier = $image->getClientOriginalName();
                $image->move($this->getParameter('files_directory'), $fichier);
                $img = new File();
                $img->setUser($user);
                $img->setNom($fichier);
                $img->setNomFichier($nomFichier);
                $img->setType(File::TYPE_AVATAR);
                $profile->addPhoto($img);
            }

            $profile->updateTimestamps();

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($profile);
            $entityManager->flush();

            $this->addFlash('success', 'Mise à jour réussie');
        }

        return $this->renderForm('profile/edit.html.twig', [
                'profile' => $profile,
                'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'profile_delete', methods: ['POST'])]
    public function delete(Request $request, Profile $profile): Response {
        if ($this->isCsrfTokenValid('delete' . $profile->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($profile);
            $entityManager->flush();
        }

        return $this->redirectToRoute('profile_index', [], Response::HTTP_SEE_OTHER);
    }

    #[Route('/supprime/file/{id}', name: 'profile_delete_files', methods: ['DELETE'])]
    public function deleteImage(File $file, Request $request): JsonResponse {
        $data = json_decode($request->getContent(), true);

        if ($this->isCsrfTokenValid('delete' . $file->getId(), $data['_token'])) {
            $nom = $file->getNom();
            unlink($this->getParameter('files_directory') . '/' . $nom);

            $em = $this->getDoctrine()->getManager();
            $em->remove($file);
            $em->flush();

            return new JsonResponse(['success' => 1]);
        } else {
            return new JsonResponse(['error' => 'Token Invalide'], 400);
        }
    }
}
