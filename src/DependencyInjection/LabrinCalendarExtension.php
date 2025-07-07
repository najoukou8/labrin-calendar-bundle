<?php

namespace Labrin\CalendarBundle\DependencyInjection;

use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Extension\Extension;
use Symfony\Component\DependencyInjection\Loader\YamlFileLoader;

class LabrinCalendarExtension extends Extension
{
    public function load(array $configs, ContainerBuilder $container)
    {
        // Load services.yaml configuration
        $loader = new YamlFileLoader(
            $container,
            new FileLocator(__DIR__.'/../../Resources/config')
        );
        $loader->load('services.yaml');
        
    }

    public function getAlias(): string
    {
        return 'labrin_calendar';
    }
}