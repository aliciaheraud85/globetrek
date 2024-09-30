<?php

namespace App\Controller;

use App\Entity\Travels;
use App\Repository\TravelsRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;


class MainController extends AbstractController
{

    private $repo;
    private $emi;

    public function __construct(TravelsRepository $repo, EntityManagerInterface $emi){
        $this->repo = $repo;
        $this->emi = $emi;
    }


    #[Route('/', name: 'app_main')]
    public function index(): Response
    {

        $posts = $this->repo->findBy([], ['createdAt'=> 'DESC', ], 6);

        return $this->render('main/index.html.twig', [
            'posts' => $posts
        ]);
    }

    #[isGranted('ROLE_USER')]
    #[Route('/travels/{id}', name: 'show', requirements: ['id' => '\d+'])]
    public function show(Travels $travels, $id, Request $request, TravelsRepository $travelrepo, EntityManagerInterface $emi){
        if(!$travels){
            return $this->redirectToRoute('app_main');
        }

        $show = $travelrepo->find($id);

        return $this->render('show/show.html.twig', [
            'show' => $show
        ]);
    }
}
