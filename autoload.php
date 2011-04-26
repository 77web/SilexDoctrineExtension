<?php

require_once __DIR__.'/vendor/Symfony/Component/ClassLoader/UniversalClassLoader.php';

use Symfony\Component\ClassLoader\UniversalClassLoader;
$loader = new UniversalClassLoader();
$loader->registerNamespaces(array(
    'Symfony'           => __DIR__.'/vendor',
    'Silex'             => array(__DIR__.'/Doctrine/src'),
    'SilexExtensions'   => __DIR__,
));
$loader->register();
