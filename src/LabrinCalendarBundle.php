<?php

namespace Labrin\CalendarBundle;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Extension\PrependExtensionInterface;
use Symfony\Component\HttpKernel\Bundle\Bundle;
use Symfony\Component\Routing\Loader\Configurator\RoutingConfigurator;


class LabrinCalendarBundle extends Bundle  implements PrependExtensionInterface
{
    public function getPath(): string
    {
        return \dirname(__DIR__);
    }
    public function prepend(ContainerBuilder $container)
    {
        // Add Twig namespace mapping automatically
        $container->prependExtensionConfig('twig', [
            'paths' => [
                __DIR__ . '/../Resources/views' => 'Calendar'
            ],
        ]);
    }
    public function configureRoutes(RoutingConfigurator $routes): void
    {
        $routes->import(__DIR__.'/../Resources/config/routes.yaml')
            ->prefix('/calendar');
    }
}