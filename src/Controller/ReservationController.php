<?php

namespace App\Controller;

use App\Entity\Reservation;
use App\Entity\Travels;
use App\Form\ReservationType;
use App\Repository\TravelsRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class ReservationController extends AbstractController
{
    #[Route('/reservation/{id}', name: 'app_reservation')]
    public function index($id, EntityManagerInterface $emi, TravelsRepository $travelsRepository, Request $request, Travels $travel): Response
    {
        //on va chercher l'id du voyage
        $travelPost = $travelsRepository->find($id);

        //on instancie l'entité reservation
        $reservation = new Reservation();

        //on crée le formulaire de réservation
        $reservForm = $this->createForm(ReservationType::class, $reservation, [
            'travelPost' => $travelPost
        ]);
        //on récupère la requette http
        $reservForm->handleRequest($request);
    
        //on gère le traitement du formulaire 
        if($reservForm->isSubmitted() && $reservForm->isValid()){
            
            $user = $this->getUser();           //on récupère l'utilisateur à l'orgine de la réservation
            $reservation->setUser($user);       //on l'intègre dans la réservation
            $reservation->setTravels($travelPost); //on intègre le voyage choisi pour la réservation
            $reservation->setCreatedAt(new \DateTimeImmutable('now'));

            //on persiste le formulaire
            $emi->persist($reservation);
            $emi->flush();

            //on affiche un message flash pour le succès
            $this->addFlash(
                'success',
                'Votre demande a bien été envoyée.'
            );

            return $this->redirectToRoute('show', ['id' => $id]);

        }

        return $this->render('reservation/reservation.html.twig', [
            'travelPost' => $travelPost,
            'reserv_form' => $reservForm->createView(),
        ]);
    }
}
