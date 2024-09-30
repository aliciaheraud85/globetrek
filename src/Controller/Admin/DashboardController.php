<?php

namespace App\Controller\Admin;

use App\Entity\User;
use App\Entity\Comment;
use App\Entity\Contact;
use App\Entity\Travels;
use App\Entity\Categories;
use App\Entity\Reservation;
use App\Repository\UserRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Config\MenuItem;
use EasyCorp\Bundle\EasyAdminBundle\Config\UserMenu;
use EasyCorp\Bundle\EasyAdminBundle\Config\Dashboard;
use Symfony\Component\Security\Core\User\UserInterface;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractDashboardController;

class DashboardController extends AbstractDashboardController
{
    protected $userRepo;

    public function __construct(UserRepository $userRepo){
        $this->userRepo = $userRepo;
    }

    #[Route('/admin', name: 'admin')]
    public function index(): Response
    {
        //On définit le rôle minimum pour pouvoir accéder au backoffice
        if($this->isGranted('ROLE_EDITOR')){
            return $this->render('admin/dashboard.html.twig');
        }else{
            return $this->redirectToRoute('app_main');
        }
    }

    public function configureDashboard(): Dashboard
    {
        return Dashboard::new()
            ->setTitle('Globetrek - Plateforme d\'administration');
    }

    public function configureMenuItems(): iterable
    {
        yield MenuItem::linkToRoute('Retourner sur le site', 'fa-solid fa-arrow-rotate-left', 'app_main');

        if($this->isGranted('ROLE_EDITOR')){
            yield MenuItem::linkToDashboard('Dashboard', 'fa fa-home')->setPermission('ROLE_ADMIN');
        }

        if($this->isGranted('ROLE_EDITOR')){
            yield MenuItem::section('Annonces');
            yield MenuItem::subMenu('Annonces', 'fa-solid fa-plane')->setSubItems([
                MenuItem::linkToCrud('Créer une annonce', 'fa-solid fa-pen', Travels::class)->setAction(Crud::PAGE_NEW),
                MenuItem::linkToCrud('Voir les annonces', 'fas fa-eye', Travels::class),
            ]);
            yield MenuItem::section('Contact');
            yield MenuItem::subMenu('Contact', 'fa-regular fa-envelope')->setSubItems([
                MenuItem::linkToCrud('Voir les demandes de contact', 'fas fa-eye', Contact::class)
            ]);
        }

        if($this->isGranted('ROLE_MODO')){
            yield MenuItem::section('Avis');
            yield MenuItem::subMenu('Avis', 'fa fa-comment-dots')->setSubItems([
                MenuItem::linkToCrud('Voir les avis', 'fas fa-eye', Comment::class),
            ]);
        }

        if($this->isGranted('ROLE_ADMIN')){
            yield MenuItem::section('Catégories');
            yield MenuItem::subMenu('Categories', 'fa-solid fa-book-open-reader')->setSubItems([
                MenuItem::linkToCrud('Créer une catégorie', 'fas fa-newspaper', Categories::class)->setAction(Crud::PAGE_NEW),
                MenuItem::linkToCrud('Voir les catégories', 'fas fa-eye', Categories::class),
            ]);
            yield MenuItem::section('Réservations');
            yield MenuItem::subMenu('Reservations', 'fa-solid fa-dollar-sign')->setSubItems([
                MenuItem::linkToCrud('Voir les réservations', 'fas fa-eye', Reservation::class)
            ]);
        }

        if($this->isGranted('ROLE_SUPER_ADMIN')){
            yield MenuItem::section('Utilisateurs');
            yield MenuItem::subMenu('Utilisateurs', 'fa fa-user-circle')->setSubItems([
                MenuItem::linkToCrud('Utilisateurs', 'fas fa-plus-circle', User::class)->setAction(Crud::PAGE_NEW),
                MenuItem::linkToCrud('Voir les utilisateurs', 'fas fa-eye', User::class)
            ]);
        }
    }

    public function configureUserMenu(UserInterface $user): UserMenu
    {
        if(!$user instanceof User){
            throw new \Exception('Wrong user');
        }

        $avatar = 'divers/avatars/' . $user->getAvatar();

        return parent::configureUserMenu($user)
            ->setAvatarUrl($avatar);
    }
}
