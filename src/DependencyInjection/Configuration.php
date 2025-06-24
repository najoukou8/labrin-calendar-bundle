<?php

namespace Labrin\CalendarBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

class Configuration implements ConfigurationInterface
{
    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder('labrin_calendar');

        $treeBuilder->getRootNode()
            ->children()
            // Define your configuration tree here
            // Example:
            // ->scalarNode('some_param')->defaultValue('default')->end()
            ->end();

        return $treeBuilder;
    }
}