<?php

namespace App\Controller\Admin;

use App\Entity\User;
use App\Entity\Product;
use App\Entity\Categorie;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Config\MenuItem;
use EasyCorp\Bundle\EasyAdminBundle\Config\Dashboard;
use EasyCorp\Bundle\EasyAdminBundle\Router\AdminUrlGenerator;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractDashboardController;

class DashboardController extends AbstractDashboardController
{   
    private $adminUrlGenerator;

    public function __construct(AdminUrlGenerator $adminUrlGenerator)
    {
        $this->adminUrlGenerator = $adminUrlGenerator;
    }

    #[Route('/admin', name: 'admin')]
    public function index(): Response
    {
        $url = $this->adminUrlGenerator
            ->setController(UserCrudController::class)
            ->generateUrl();

        return $this->redirect($url);

        // Option 1. You can make your dashboard redirect to some common page of your backend
        //
        // $adminUrlGenerator = $this->container->get(AdminUrlGenerator::class);
        // return $this->redirect($adminUrlGenerator->setController(OneOfYourCrudController::class)->generateUrl());

        // Option 2. You can make your dashboard redirect to different pages depending on the user
        //
        // if ('jane' === $this->getUser()->getUsername()) {
        //     return $this->redirect('...');
        // }

        // Option 3. You can render some custom template to display a proper dashboard with widgets, etc.
        // (tip: it's easier if your template extends from @EasyAdmin/page/content.html.twig)
        //
        // return $this->render('some/path/my-dashboard.html.twig');
    }

    public function configureDashboard(): Dashboard
    {
        return Dashboard::new()
            ->setTitle('MaBoutique');
    }

    public function configureMenuItems(): iterable
    {
        yield MenuItem::linkToDashboard('Dashboard', 'fa fa-home');

        yield MenuItem::subMenu('Users', 'fas fa-user', User::class)->setSubItems([
            MenuItem::linkToCrud('Create User', 'fa fa-user', User::class)->setAction(Crud::PAGE_NEW),
            MenuItem::linkToCrud('Show User', 'fa fa-eye', User::class)
        ]);

        yield MenuItem::subMenu('Categorie', 'fas fa-list', Categorie::class)->setSubItems([
            MenuItem::linkToCrud('Create Categorie', 'fa fa-list', Categorie::class)->setAction(Crud::PAGE_NEW),
            MenuItem::linkToCrud('Show Categorie', 'fa fa-eye', Categorie::class)
        ]);

        yield MenuItem::subMenu('Product', 'fas fa-tag', Product::class)->setSubItems([
            MenuItem::linkToCrud('Create Product', 'fa fa-tag', Product::class)->setAction(Crud::PAGE_NEW),
            MenuItem::linkToCrud('Show Product', 'fa fa-eye', Product::class)
        ]);

    }

    /**
     * Get the value of adminUrlGenerator
     */
    public function getAdminUrlGenerator()
    {
        return $this->adminUrlGenerator;
    }

    /**
     * Set the value of adminUrlGenerator
     */
    public function setAdminUrlGenerator($adminUrlGenerator): self
    {
        $this->adminUrlGenerator = $adminUrlGenerator;

        return $this;
    }
}
