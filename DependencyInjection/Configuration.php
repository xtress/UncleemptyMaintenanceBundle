<?php

namespace Uncleempty\MaintenanceBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

/**
 * This is the class that validates and merges configuration from your app/config files
 *
 * To learn more see {@link http://symfony.com/doc/current/cookbook/bundles/extension.html#cookbook-bundles-extension-config-class}
 */
class Configuration implements ConfigurationInterface
{
    /**
     * {@inheritdoc}
     */
    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder();
        $rootNode = $treeBuilder->root('uncleempty_maintenance');

        $rootNode
            ->children()
                ->booleanNode('enabled')
                    ->defaultFalse()
                    ->info('Is maintenance enabled')
                ->end()
                ->arrayNode('allowance')
                    ->children()
                        ->scalarNode('path')
                            ->defaultNull()
                        ->end()
                        ->variableNode('ips')
                            ->defaultValue(array())
                        ->end()
                    ->end()
                ->end()
                ->arrayNode('denial')
                    ->children()
                        ->integerNode('response_code')
                            ->defaultValue(503)
                        ->end()
                        ->enumNode('response_type')
                            ->values(['string', 'class'])
                            ->defaultValue('string')
                            ->validate()
                                ->ifNotInArray(['string', 'class'])
                                    ->thenInvalid('Invalid response type "%s" set.')
                            ->end()
                        ->end()
                        ->scalarNode('response_class')
                            ->defaultNull()
                            ->info('This value is only used when response_type is "class" - when you need more complex answer, rather than a simple string.')
                        ->end()
                        ->scalarNode('response_message')
                            ->defaultValue('Service is temporarily on maintenance.')
                            ->info('This value is only used when response_type is "string".')
                        ->end()
                        ->scalarNode('response_maintenance_end_time')
                            ->defaultValue('00:00')
                            ->info('This value is only used when response_type is "string".')
                        ->end()
                    ->end()
                ->end()
            ->end()
        ;

        return $treeBuilder;
    }
}
