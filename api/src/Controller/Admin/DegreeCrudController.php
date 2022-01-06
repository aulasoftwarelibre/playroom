<?php

namespace App\Controller\Admin;

use App\Entity\Degree;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\ChoiceField;
use EasyCorp\Bundle\EasyAdminBundle\Field\FormField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class DegreeCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Degree::class;
    }

    /**
     * @inheritDoc
     */
    public function configureFields(string $pageName): iterable
    {
        yield FormField::addPanel('General');
        yield IdField::new('id')
            ->onlyOnIndex();

        yield TextField::new('name');
        yield TextField::new('slug')
            ->onlyOnDetail();
        yield ChoiceField::new('type')
            ->allowMultipleChoices(false)
            ->setChoices(array_flip(Degree::TYPES));
        yield ChoiceField::new('family')
            ->allowMultipleChoices(false)
            ->setChoices(array_flip(Degree::FAMILIES));
    }
}
