<?php

namespace App\Controller;

use App\Entity\Travels;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/cart', name: 'cart_')]
class CartController extends AbstractController
{
    #[Route('/add/{id}', name: 'add')]
    public function add(Travels $travels, SessionInterface $session)
    {
        // //on récupère l'id du voyage
        //  $id = $travels->getId();

        // // je récupère le panier existant si il y en a un
        // $panier = $session->get('panier', []);

        // //on ajoute le voyage dans le panier si il n'y es pas encore



        // dd($session);
    }
}
