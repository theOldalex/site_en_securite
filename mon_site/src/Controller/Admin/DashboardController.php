<?php

namespace App\Controller\Admin;

use App\Entity\Auteur;
use App\Entity\Realisation;
use App\Entity\RERNG;
use App\Entity\User;
use App\Entity\Z5600;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use EasyCorp\Bundle\EasyAdminBundle\Config\MenuItem;
use EasyCorp\Bundle\EasyAdminBundle\Config\Dashboard;
use EasyCorp\Bundle\EasyAdminBundle\Router\AdminUrlGenerator;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractDashboardController;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\EasyAdminBundle;




class DashboardController extends AbstractDashboardController
{
    /**
     * @Route("/admin", name="admin")
     */
    public function index(): Response
    {
        return parent::index();
    }

    public function configureDashboard(): Dashboard
    {
        return Dashboard::new()
            ->setTitle('<img src="logo.PNG">');
    }

    public function configureMenuItems(): iterable
    {
        yield MenuItem::linktoDashboard('Dashboard', 'fa fa-home');
        yield MenuItem::linkToCrud('Users', 'fa-solid fa fa-user', User::class);
        yield MenuItem::linkToCrud('Auteurs', 'fa-solid fa fa-user', Auteur::class);
        yield MenuItem::linkToCrud('Z5600', 'fa fa-train', Z5600::class);
        yield MenuItem::linkToCrud('RERNG', 'fa fa-train', RERNG::class);
        yield MenuItem::linkToCrud('Réalisations', 'fa fa-file-image', Realisation::class);
        
    }
}
