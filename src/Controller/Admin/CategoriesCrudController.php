<?php

namespace App\Controller\Admin;

use App\Entity\Categories;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IntegerField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;

class CategoriesCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Categories::class;
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            ->setEntityLabelInSingular('une catégorie')
            ->setPaginatorPageSize(10)
        ;
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            IntegerField::new('id')->onlyOnIndex(),
            TextField::new('name'),
        ];
    }
   
    public function configureActions(Actions $actions): Actions
    {
        return $actions
            ->setPermission(Action::DELETE, 'ROLE_ADMIN')
        ;
    }
}
