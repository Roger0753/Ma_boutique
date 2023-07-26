<?php

namespace App\Controller\Admin;

use DateTimeImmutable;
use App\Entity\Product;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Response;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Field\SlugField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;
use EasyCorp\Bundle\EasyAdminBundle\Field\MoneyField;
use EasyCorp\Bundle\EasyAdminBundle\Field\BooleanField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;
use EasyCorp\Bundle\EasyAdminBundle\Context\AdminContext;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Router\AdminUrlGenerator;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;

class ProductCrudController extends AbstractCrudController
{      
    public const ACTION_DUPLICATE = 'duplicate';

    public static function getEntityFqcn(): string
    {
        return Product::class;
    }

    public function configureActions(Actions $actions): Actions
    {   
        $duplicate = Action::new(self::ACTION_DUPLICATE)
            ->linkToCrudAction('duplicateProduct')
            ->setCssClass('btn btn-info');

        return $actions
            ->add(Crud::PAGE_EDIT, $duplicate)
            ->reorder(Crud::PAGE_EDIT,[self::ACTION_DUPLICATE, Action::SAVE_AND_RETURN]);

    }

    
    public function configureFields(string $pageName): iterable
    {
        return [
            TextField::new('name'),
            SlugField::new('slug')->setTargetFieldName('name'),
            ImageField::new('illustration')
                ->setUploadDir('public/uploads/images')
                ->setBasePath('uploads/images')
                ->setFormTypeOption('mapped', true)
                ->setFormTypeOption('required', false)
                ->setUploadedFileNamePattern('[randomhash].[extension]'),

            TextField::new('subtitle'),
            TextEditorField::new('description'),
            MoneyField::new('price')->setCurrency('EUR'),
            AssociationField::new('Categorie'),
            BooleanField::new('active'),
            DateTimeField::new('updatedAt')->hideOnForm(),
            DateTimeField::new('createdAt')->hideOnForm(),
        ];
    }

    public function updateEntity(EntityManagerInterface $entityManager, $entityInstance): void
    {
        if (!$entityInstance instanceof Product) return;

        $entityInstance->setUpdatedAt(new \DateTimeImmutable);
        
        parent::updateEntity($entityManager, $entityInstance);
    }
    
    public function persistEntity(EntityManagerInterface $entityManager, $entityInstance): void
    {
        if (!$entityInstance instanceof Product) return;

        if ($entityInstance->getIllustration() === null) {
            $entityInstance->setIllustration('default.jpg');
        }
        
        $entityInstance->setCreatedAt(new \DateTimeImmutable);
        
        parent::persistEntity($entityManager, $entityInstance);
    }
    
    
    public function duplicateProduct(
        AdminContext $context, 
        AdminUrlGenerator $adminUrlGenerator,
        EntityManagerInterface $entityManager
    ): Response
    {   
        /** @var Product $product **/
        $product = $context->getEntity()->getInstance();
        $duplicatedProduct = clone $product;

        if ($duplicatedProduct->getIllustration() === null) {
            $duplicatedProduct->setIllustration('default.jpg');
        }
    
        parent::persistEntity($entityManager, $duplicatedProduct);
    
        $url = $adminUrlGenerator->setController(self::class)
            ->setAction(Action::DETAIL)
            ->setEntityId($duplicatedProduct->getId())
            ->generateUrl();
    
        return $this->redirect($url);
    }


    
}
