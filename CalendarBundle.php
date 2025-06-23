<?php

namespace App\CalendarBundle;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Extension\PrependExtensionInterface;
use Symfony\Component\HttpKernel\Bundle\Bundle;

class CalendarBundle extends Bundle  implements PrependExtensionInterface
{
    public function prepend(ContainerBuilder $container)
    {
        // Add Twig namespace mapping automatically
        $container->prependExtensionConfig('twig', [
            'paths' => [
                __DIR__ . '/Resources/views' => 'Calendar'
            ],
        ]);
    }
}