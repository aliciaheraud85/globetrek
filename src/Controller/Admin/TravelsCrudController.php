<?php

namespace App\Controller\Admin;

use App\Entity\Travels;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Config\Filters;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;
use EasyCorp\Bundle\EasyAdminBundle\Field\BooleanField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IntegerField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextareaField;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;

class TravelsCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Travels::class;
    }

    
    public function configureFields(string $pageName): iterable
    {
        return [
            IntegerField::new('id')->onlyOnIndex(),
            TextField::new('title')->setColumns('col-md-6'),
            TextField::new('subtitle')->setColumns('col-md-6'),
            TextareaField::new('description')->setColumns('col-md-12'),
            TextareaField::new('details')->setColumns('col-md-12'),
            
            $image1 = ImageField::new('image1')
                ->setUploadDir('public/divers/images')
                ->setBasePath('divers/image')
                ->setSortable(false) //l'image ne peut pas être null
                ->setFormTypeOption('required', false)->setColumns('col-md-3'),
            $image2 = ImageField::new('image2')
                ->setUploadDir('public/divers/images')
                ->setBasePath('divers/image')
                ->setSortable(false) //l'image ne peut pas être null
                ->setFormTypeOption('required', false)->setColumns('col-md-3'),
            $image3 = ImageField::new('image3')
                ->setUploadDir('public/divers/images')
                ->setBasePath('divers/image')
                ->setSortable(false) //l'image ne peut pas être null
                ->setFormTypeOption('required', false)->setColumns('col-md-3'),
            $image4 = ImageField::new('image4')
                ->setUploadDir('public/divers/images')
                ->setBasePath('divers/image')
                ->setSortable(false) //l'image ne peut pas être null
                ->setFormTypeOption('required', false)->setColumns('col-md-3'),
            
            TextField::new('date1')->setColumns('col-md-4'),
            TextField::new('date2')->setColumns('col-md-4'),
            TextField::new('date3')->setColumns('col-md-4'),

            TextField::new('price1')->setColumns('col-md-4'),
            TextField::new('price2')->setColumns('col-md-4'),
            TextField::new('price3')->setColumns('col-md-4'),

            AssociationField::new('categories')->setColumns('col-md-2'),

            AssociationField::new('user')->setColumns('col-md-6'),

            DateField::new('createdAt')->OnlyOnIndex()->setColumns('col-md-2'),

            $isPublished = BooleanField::new('isPublished')->setColumns('col-md-2')->setLabel('Publié'),


            
        ];
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            ->setEntityLabelInSingular('Voyages')
            ->setDefaultSort(['createdAt' => 'DESC'])
            ->setPaginatorPageSize(10)
        ;
    }

    public function configureFilters(Filters $filters): Filters
    {
        return $filters
            ->add('user')
            ->add('title')
            ->add('categories')
            ->add('createdAt')
        ;
    }

    public function configureActions(Actions $actions): Actions
    {
        return $actions
            ->setPermission(Action::DELETE, 'ROLE_ADMIN')
        ;
    }
    
}
