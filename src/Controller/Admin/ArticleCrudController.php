<?php

namespace App\Controller\Admin;

use App\Entity\Article;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\SlugField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class ArticleCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Article::class;
    }

    public function configureFields(string $pageName): iterable
    {
        yield TextField::new('title', 'Titre');

        yield SlugField::new('slug', 'Slug')->setTargetFieldName('title');

        yield TextEditorField::new('content', 'Contenu');

        yield TextField::new('featuredText', 'Text associé');

        yield AssociationField::new('categories', 'Catégories');

        yield DateTimeField::new('createdAt', 'Date de création')->hideOnForm();

        yield DateTimeField::new('updatedAt', 'Date de mise à jour')->hideOnForm();


    }

}
