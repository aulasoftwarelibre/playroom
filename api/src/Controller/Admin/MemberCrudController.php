<?php

namespace App\Controller\Admin;

use App\Entity\Member;
use App\Entity\User;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\BooleanField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ChoiceField;
use EasyCorp\Bundle\EasyAdminBundle\Field\FormField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextareaField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use Vich\UploaderBundle\Form\Type\VichImageType;

class MemberCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Member::class;
    }

    /**
     * @inheritDoc
     */
    public function configureFields(string $pageName): iterable
    {
        yield FormField::addPanel('General');
        yield TextField::new('email')
            ->hideOnIndex();
        yield TextField::new('alias');

        yield FormField::addPanel('Security');
        yield ChoiceField::new('roles')
            ->setChoices([
                'Usuario' => 'ROLE_USER',
                'Gestor' => 'ROLE_ADMIN',
                'Administrador' => 'ROLE_SUPER_ADMIN',
            ])
            ->allowMultipleChoices();

        yield FormField::addPanel('Profile');
        yield IdField::new('id')
            ->onlyOnIndex();

        yield TextField::new('firstname');
        yield TextField::new('lastname');

        yield AssociationField::new('degree')
            ->hideOnIndex();

        yield TextareaField::new('avatarFile')
            ->setFormType(VichImageType::class)
            ->onlyOnForms();
        yield ImageField::new('avatar.name')
            ->setBasePath('/images/avatars')
            ->setCssClass('ea-vich-image')
            ->onlyOnDetail();
    }
}
