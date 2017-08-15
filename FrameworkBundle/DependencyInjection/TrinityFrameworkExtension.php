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
     * @throws \Exception
     */
    public function load(array $configs, ContainerBuilder $container)
    {
        $configuration = new Configuration();
        $config        = $this->processConfiguration($configuration, $configs);

        if (array_key_exists('locale', $config) && isset($config['locale'])) {
            $container->setParameter('trinity.framework.locale', $config['locale']);
        }
        if (array_key_exists('exception_ttl', $config) && isset($config['exception_ttl'])) {
            $container->setParameter('trinity.framework.exception_ttl', $config['exception_ttl']);
        } else {
            $container->setParameter('trinity.framework.exception_ttl', 0);
        }


        $loader = new Loader\YamlFileLoader($container, new FileLocator(__DIR__ . '/../Resources/config'));
        $loader->load('services.yml');
    }
}
