<?php

namespace Labrin\CalendarBundle;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Extension\PrependExtensionInterface;
use Symfony\Component\HttpKernel\Bundle\Bundle;


class LabrinCalendarBundle extends Bundle  implements PrependExtensionInterface
{
    public function getPath(): string
    {
        return \dirname(__DIR__);
    }
    public function prepend(ContainerBuilder $container)
    {
        var_dump('prepend called');
        var_dump(  __DIR__ . '/../Resources/views');

        // Add Twig namespace mapping automatically
        $container->prependExtensionConfig('twig', [
            'paths' => [
                __DIR__ . '/../Resources/views' => 'Calendar'
            ],
        ]);
    }

}