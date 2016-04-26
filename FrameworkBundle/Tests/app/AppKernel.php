<?php

/*
 * This file is part of the Trinity project.
 */

use Symfony\Component\Config\Loader\LoaderInterface;
use Symfony\Component\HttpKernel\Kernel;


/**
 * Class AppKernel.
 */
class AppKernel extends Kernel
{
    public function registerBundles()
    {
        return array(
            new \Symfony\Bundle\FrameworkBundle\FrameworkBundle(),


            
            new \Trinity\FrameworkBundle\TrinityFrameworkBundle(),
            new \Trinity\Bundle\SettingsBundle\SettingsBundle(),
            new \Trinity\Bundle\LoggerBundle\LoggerBundle(),


            new Doctrine\Bundle\DoctrineBundle\DoctrineBundle(),
            new Doctrine\Bundle\FixturesBundle\DoctrineFixturesBundle(),
            new \Symfony\Bundle\SecurityBundle\SecurityBundle()
        );
    }


    /**
     * @param LoaderInterface $loader
     */
    public function registerContainerConfiguration(LoaderInterface $loader)
    {
        $loader->load(__DIR__.'/config.yml');
    }


    /**
     * @return string
     */
    public function getCacheDir()
    {
        return __DIR__.'/./cache';
    }


    /**
     * @return string
     */
    public function getLogDir()
    {
        return __DIR__.'/./logs';
    }
}
