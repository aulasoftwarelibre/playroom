<?php

namespace App\Controller\Admin;

use App\Entity\Room;
use EasyCorp\Bundle\EasyAdminBundle\Config\Dashboard;
use EasyCorp\Bundle\EasyAdminBundle\Config\MenuItem;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractDashboardController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DashboardController extends AbstractDashboardController
{
    #[Route('/admin', name: 'dashboard')]
    public function index(): Response
    {
        return parent::index();
    }

    public function configureDashboard(): Dashboard
    {
        return Dashboard::new()
            ->setTitle('PlayRoom');
    }

    /**
     * @return \Generator
     *
     * @psalm-return \Generator<int, \EasyCorp\Bundle\EasyAdminBundle\Config\Menu\CrudMenuItem|\EasyCorp\Bundle\EasyAdminBundle\Config\Menu\DashboardMenuItem|\EasyCorp\Bundle\EasyAdminBundle\Config\Menu\SectionMenuItem, mixed, void>
     */
    public function configureMenuItems(): iterable
    {
        yield MenuItem::linkToDashboard('Dashboard', 'fa fa-home');
        yield MenuItem::section('Organization');
        yield MenuItem::linkToCrud('Rooms', 'fas fa-cube', Room::class);
    }
}
