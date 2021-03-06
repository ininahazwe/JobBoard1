<?php

namespace App\Controller;

use App\Data\SearchDataAnnonce;
use App\Entity\Newsletter\Users;
use App\Form\Newsletter\NewsletterUsersType;
use App\Form\Search\SearchAnnonceForm;
use App\Repository\AnimationRepository;
use App\Repository\CandidatureRepository;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use App\Entity\Annonce;
use App\Entity\Forum;
use App\Entity\Stand;
use App\Repository\AnnonceRepository;
use App\Repository\BlogRepository;
use App\Repository\FAQRepository;
use App\Repository\ForumRepository;
use App\Repository\StandRepository;
use App\Repository\TagRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    #[Route('/', name: 'home')]
    public function index(Request $request, AnnonceRepository $annonceRepository, BlogRepository $blogRepository, ForumRepository $forumRepository, StandRepository $standRepository, AnimationRepository $animationRepository): Response
    {
        $data = new SearchDataAnnonce();
        $data->page = $request->get('page', 1);
        $form = $this->createForm(SearchAnnonceForm::class, $data);
        $form->handleRequest($request);

        $annonces = $annonceRepository->findSearch($data);

        $blog = $blogRepository->findAll();
        $animation = $animationRepository->findAll();
        $stands = $standRepository->getAllActive();
        $alaUne = $standRepository->findAlaUne();
        $forum = $forumRepository->findLastInserted();
        $forums = $forumRepository->findAll();
        return $this->render('home/index.html.twig', [
            'blogs' => $blog,
            'annonces' => $annonces,
            'animations' => $animation,
            'forums' => $forum,
            'stands' => $stands,
            'standsUne' => $alaUne,
            'allForums' => $forums,
            'form' => $form->createView()
        ]);
    }

    #[Route('/job/all', name: 'annonces_all', methods: ['GET'])]
    public function annonces(Request $request, AnnonceRepository $annonceRepository, TagRepository $tagRepository): Response
    {
        $data = new SearchDataAnnonce();
        $data->page = $request->get('page', 1);
        $form = $this->createForm(SearchAnnonceForm::class, $data);
        $form->handleRequest($request);

        $tags = $tagRepository->findAll();
        $annonces = $annonceRepository->findSearch($data);

        if($request->get('ajax')){
            return new JsonResponse([
                    'content' => $this->renderView('home/annonces.html.twig', ['annonces' => $annonces]),
                    'pagination' => $this->renderView('annonce/_pagination.html.twig', ['annonces' => $annonces]),
                    'pages' => ceil($annonces->getTotalItemCount() / $annonces->getItemNumberPerPage())
            ]);
        }

        return $this->render('home/annonces.html.twig', [
                'annonces' => $annonces,
                'tags' => $tags,
                'form' => $form->createView()
        ]);
    }

    #[Route('/job/{slug}', name: 'annonce_page', methods: ['GET'])]
    public function annonce(Annonce $annonce, AnnonceRepository $annonceRepository, CandidatureRepository $candidatureRepository): Response
    {
        $hasCandidature = false;
        if ($this->getUser()){
            $hasCandidature = $candidatureRepository->hasCandidature($this->getUser(), $annonce);
        }

        $annonces = $annonceRepository->findAll();
        return $this->render('home/annonce_page.html.twig', [
                'annonces' => $annonces,
                'annonce' => $annonce,
                'hasCandidature' => $hasCandidature
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

    #[Route('/conseils-recherche-emploi', name: 'blog_conseils', methods: ['GET'])]
    public function conseils(BlogRepository $blogRepository): Response
    {
        return $this->render('blog/conseils.html.twig', [
                'blogs' => $blogRepository->getInterwiewType(),
        ]);
    }

    #[Route('/webtv', name: 'blog_webtv', methods: ['GET'])]
    public function webtv(BlogRepository $blogRepository): Response
    {
        return $this->render('blog/webtv.html.twig', [
                'blogs' => $blogRepository->getWebTvType(),
        ]);
    }

    #[Route('/newsletter-inscription', name: 'newsletter')]
    public function newsletter(Request $request, MailerInterface $mailer): Response
    {
        $user = new Users();
        $form = $this->createForm(NewsletterUsersType::class, $user);

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            $token = hash('sha256', uniqid());

            $user->setValidationToken($token);

            $em = $this->getDoctrine()->getManager();
            $em->persist($user);
            $em->flush();

            $email = (new TemplatedEmail())
                    ->from('newsletter@talents-handicap.com')
                    ->to($user->getEmail())
                    ->subject('Votre inscription ?? la newsletter')
                    ->htmlTemplate('email/inscription_newsletter.html.twig')
                    ->context(compact('user', 'token'))
            ;

            $mailer->send($email);

            $this->addFlash('success', 'Inscription en attente de validation');
            return $this->redirectToRoute('home');
        }

        return $this->render('newsletter/index.html.twig', [
                'form' => $form->createView(),
        ]);
    }
}
