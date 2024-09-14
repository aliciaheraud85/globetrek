<?php

namespace App\Controller;

use App\Repository\TravelsRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class MainController extends AbstractController
{

    private $repo;
    private$emi;

    public function __construct(TravelsRepository $repo, EntityManagerInterface $emi){
        $this->repo = $repo;
        $this->emi = $emi;
    }


    #[Route('/', name: 'app_main')]
    public function index(): Response
    {

        // $posts = $this->repo->findBy([], ['createdAt'=> 'DESC', ], 6);

        return $this->render('main/index.html.twig', [
            // 'posts' => $posts
        ]);
    }
}
