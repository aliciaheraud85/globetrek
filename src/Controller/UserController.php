<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\UserType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class UserController extends AbstractController
{
    #[Route('/utilisateur/edition/{id}', name: 'user.edit')]
    public function edit(User $user, Request $request, EntityManagerInterface $emi): Response
    {
        //on vérifie que l'utilisateur est bien connecté
        if(!$this->getUser()){
            return $this->redirectToRoute('app_login');
        }

        //on vérifie que l'utilisateur courant est le même que celui qu'on a récupéré avec l'id (sécurité)
        if($this->getUser() !== $user){
            return $this->redirectToRoute('app_main');
        }

        //on crée le formulaire de modifications du user
        $userForm = $this->createForm(UserType::class, $user);

        //on vérifie et on valide les modifications
        $userForm->handleRequest($request);
        if($userForm->isSubmitted() && $userForm->isValid()){
            $user = $userForm->getData();
            $emi->persist($user);
            $emi->flush();

            return $this->redirectToRoute('app_main');
        }

        return $this->render('user/edit.html.twig', [
            'userForm' => $userForm->createView(),
        ]);
    }
}
