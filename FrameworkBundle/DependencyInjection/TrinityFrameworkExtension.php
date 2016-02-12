<?php

/*
 * This file is part of the Trinity project.
 */

namespace Trinity\FrameworkBundle\DependencyInjection;

use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Loader;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;


/**
 * This is the class that loads and manages your bundle configuration.
 *
 * To learn more see {@link http://symfony.com/doc/current/cookbook/bundles/extension.html}
 */
class TrinityFrameworkExtension extends Extension
{
    /**
     * {@inheritdoc}
     */
    public function load(array $configs, ContainerBuilder $container)
    {
        $configuration = new Configuration();
        $config = $this->processConfiguration($configuration, $configs);

        if (array_key_exists('locale', $config) && isset($config['locale'])) {
            $container->setParameter('trinity.framework.locale', $config['locale']);
        }
        if (array_key_exists('dynamo_logs', $config) && isset($config['dynamo_logs'])) {
            $container->setParameter('trinity.framework.dynamo_host', $config['dynamo_logs']['dynamo_host']);
            $container->setParameter('trinity.framework.dynamo_port', $config['dynamo_logs']['dynamo_port']);
            $container->setParameter('trinity.framework.aws_key', $config['dynamo_logs']['aws_key']);
            $container->setParameter('trinity.framework.aws_secret', $config['dynamo_logs']['aws_secret']);
            $container->setParameter('trinity.framework.aws_region', $config['dynamo_logs']['aws_region']);
        }

        $loader = new Loader\YamlFileLoader($container, new FileLocator(__DIR__.'/../Resources/config'));
        $loader->load('services.yml');
    }
}
