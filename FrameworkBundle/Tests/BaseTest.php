<?php

/*
 * This file is part of the Trinity project.
 */

namespace Trinity\FrameworkBundle\Tests;

use Braincrafted\Bundle\TestingBundle\Test\WebTestCase;
use ReflectionClass;

/**
 * Class BaseTest.
 */
abstract class BaseTest extends WebTestCase
{
    /**
     * @param string|object $class
     * @param string        $name
     *
     * @return \ReflectionMethod
     */
    protected static function getMethod($class, $name)
    {
        $class = new ReflectionClass($class);
        $method = $class->getMethod($name);
        $method->setAccessible(true);

        return $method;
    }

    /**
     * @param object $class
     * @param string $property
     * @param $value
     */
    protected function setPropertyValue($class, $property, $value)
    {
        $property = new \ReflectionProperty($class, $property);
        $property->setAccessible(true);
        $property->setValue($class, $value);
    }
}
