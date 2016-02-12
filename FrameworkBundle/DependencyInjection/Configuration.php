<?php

/*
 * This file is part of the Trinity project.
 */

namespace Trinity\FrameworkBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;


/**
 * This is the class that validates and merges configuration from your app/config files.
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
        $rootNode = $treeBuilder->root('trinity_framework');
        $rootNode
            ->children()
                ->scalarNode('locale')
                    ->defaultValue('en')
                ->end()->end()//end locale
            ->children()
            ->arrayNode('dynamo_logs')
            ->children()
            ->scalarNode('dynamo_host')->isRequired()->cannotBeEmpty()->end()
            ->scalarNode('dynamo_port')->isRequired()->cannotBeEmpty()->end()
            ->scalarNode('aws_key')->isRequired()->cannotBeEmpty()->end()
            ->scalarNode('aws_secret')->isRequired()->cannotBeEmpty()->end()
            ->scalarNode('aws_region')->isRequired()->cannotBeEmpty()->end()
            ->end();
//
//
//        $rootNode
//            ->children()
//            ->arrayNode('connection')
//            ->children()
//            ->scalarNode('driver')
//            ->isRequired()
//            ->cannotBeEmpty()
//            ->end()
//            ->scalarNode('host')
//            ->defaultValue('localhost')
//            ->end()
//            ->scalarNode('username')->end()
//            ->scalarNode('password')->end()
//            ->booleanNode('memory')
//            ->defaultFalse()
//            ->end()
//            ->end()
//            ->append($this->addParametersNode())
//            ->end()
//            ->end()
//        ;


        // Here you should define the parameters that are allowed to
        // configure your bundle. See the documentation linked above for
        // more information on that topic.

        return $treeBuilder;
    }
}
