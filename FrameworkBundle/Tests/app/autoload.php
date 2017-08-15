<?php

/*
 * This file is part of the Trinity project.
 */

$loader = require __DIR__.'/../../../vendor/autoload.php';

use Doctrine\Common\Annotations\AnnotationRegistry;


AnnotationRegistry::registerLoader([$loader, 'loadClass']);


require __DIR__.'/AppKernel.php';
