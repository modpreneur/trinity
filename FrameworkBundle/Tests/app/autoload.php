<?php

    $loader = require __DIR__.'/../../../vendor/autoload.php';


    use Doctrine\Common\Annotations\AnnotationRegistry;



    AnnotationRegistry::registerLoader(array($loader, 'loadClass'));

    require __DIR__.'/AppKernel.php';

