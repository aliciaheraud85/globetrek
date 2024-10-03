<?php

namespace App\Controller;

use App\Entity\Comment;
use App\Entity\Contact;
use App\Entity\Travels;
use App\Form\CommentType;
use App\Form\ContactType;
use App\Entity\Categories;
use Symfony\Component\Mime\Email;
use App\Repository\CommentRepository;
use App\Repository\TravelsRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Mailer\MailerInterface;

class MainController extends AbstractController
{

    private $repo;
    private $emi;

    public function __construct(TravelsRepository $repo, EntityManagerInterface $emi){
        $this->repo = $repo;
        $this->emi = $emi;
    }


    #[Route('/', name: 'app_main')]
    public function index(Request $request, EntityManagerInterface $emi, MailerInterface $mailer): Response
    {

        $posts = $this->repo->findBy([], ['createdAt'=> 'DESC', ], 6);

        $contact = new Contact();

        //création formulaire de contact
        $contactForm = $this->createForm(ContactType::class, $contact);
        $contactForm->handleRequest($request);

        //verification du formulaire de contact et soumission
        if($contactForm->isSubmitted() && $contactForm->isValid()){
            $contact = $contactForm->getData();
            $emi->persist($contact);
            $emi->flush();
            
            //envoi de mail 
            $address = $contact->getEmail();
            $subject = $contact->getSubject();
            $message = $contact->getMessage();

            $email = (new Email())
                ->from($address)
                ->to('amin@globetrek.com')
                ->subject($subject)
                ->text($message);

            $mailer->send($email);

            $this->addFlash(
                'success',
                'Votre demande à bien été envoyé.'
            );

            return $this->redirectToRoute('app_main');
        }

        return $this->render('main/index.html.twig', [
            'posts' => $posts,
            'contact_form' => $contactForm->createView()
        ]);
    }

    #[Route('/travels/{id}', name: 'show', requirements: ['id' => '\d+'])]
    public function show(Travels $travels, $id, Request $request, TravelsRepository $travelrepo, EntityManagerInterface $emi, CommentRepository $creppo){
        if(!$travels){
            return $this->redirectToRoute('app_main');
        }

        $show = $travelrepo->find($id);
        $comments = new Comment(); //on instancie l'entité comment

        //On crée le formulaire de commentaire
        $commentForm = $this->createForm(CommentType::class, $comments);
        $commentForm->handleRequest($request);

        //On gère le traitement de formulaires
        if($commentForm->isSubmitted() && $commentForm->isValid()){
            $user = $this->getUser();
            $comments->setUser($user);
            $comments->setTravels($show);
            $comments->setCreatedAt(new \DateTimeImmutable('now'));
            
            //On persiste le commentaire
            $emi->persist($comments);
            $emi->flush();

            //on redirige pour éviter la resoumission du formulaire
            return $this->redirectToRoute('show', ['id' => $id]);
        }

        //on récupère les données pour le travel par le comment repository
        $allComments = $creppo->findCommentByPost($id);

        return $this->render('show/show.html.twig', [
            'postShow' => $show,
            'comments' => $allComments,
            'comment_form' => $commentForm->createView(),
        ]);
    }

    #[Route('categories/{id}', name:'categories')]
    public function travelsByCategories(Categories $categories, TravelsRepository $travelRepo): Response 
    {
        $posts = $travelRepo->findByCategories($categories);
        return $this->render('categories/categories.html.twig', [
             'posts' => $posts,
             'categories' => $categories
        ]);
    }
}
