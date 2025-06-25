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
        file_put_contents('/tmp/my-debug.log', "prepend called\n", FILE_APPEND);

        // Add Twig namespace mapping automatically
        $container->prependExtensionConfig('twig', [
            'paths' => [
                __DIR__ . '/../Resources/views' => 'Calendar'
            ],
        ]);
    }

}