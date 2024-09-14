<?php

namespace App\Controller\Admin;

use App\Entity\Travels;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IntegerField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextareaField;
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
                ->setFormTypeOption('required', false)->setColumns('col-md-2'),
            $image2 = ImageField::new('image2')
                ->setUploadDir('public/divers/images')
                ->setBasePath('divers/image')
                ->setSortable(false) //l'image ne peut pas être null
                ->setFormTypeOption('required', false)->setColumns('col-md-2'),
            $image3 = ImageField::new('image3')
                ->setUploadDir('public/divers/images')
                ->setBasePath('divers/image')
                ->setSortable(false) //l'image ne peut pas être null
                ->setFormTypeOption('required', false)->setColumns('col-md-2'),
            $image4 = ImageField::new('image4')
                ->setUploadDir('public/divers/images')
                ->setBasePath('divers/image')
                ->setSortable(false) //l'image ne peut pas être null
                ->setFormTypeOption('required', false)->setColumns('col-md-2'),

            
        ];
    }
    
}
