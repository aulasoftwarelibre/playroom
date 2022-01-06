<?php

namespace App\Controller\Admin;

use App\Entity\Room;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\FormField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextareaField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use Vich\UploaderBundle\Form\Type\VichImageType;

class RoomCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Room::class;
    }

    public function configureFields(string $pageName): iterable
    {
        // General
        yield FormField::addPanel("General");

        yield IdField::new("id")
            ->onlyOnIndex();
        yield TextField::new("name");
        yield TextareaField::new("description");
        yield TextField::new("slug");

        // Images
        yield FormField::addPanel("Images");

        yield TextareaField::new("imageFile")
            ->setFormType(VichImageType::class)
            ->onlyOnForms();
        yield ImageField::new("image.name")
            ->setBasePath("/images/rooms")
            ->setCssClass("ea-vich-image")
            ->onlyOnDetail();

        yield TextareaField::new("avatarFile")
            ->setFormType(VichImageType::class)
            ->onlyOnForms();
        yield ImageField::new("avatar.name")
            ->setBasePath("/images/avatars")
            ->setCssClass("ea-vich-image")
            ->onlyOnDetail();
    }

    /*
    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id'),
            TextField::new('title'),
            TextEditorField::new('description'),
        ];
    }
    */
}
