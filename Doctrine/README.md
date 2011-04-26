DoctrineExtension
=================

``` bash

    wget --no-check-certificate https://github.com/docteurklein/SilexExtensions/raw/master/silex_doctrine_extension.phar

```

usage: 

``` php

    <?php

    require_once __DIR__.'/silex.phar';
    require_once __DIR__.'/silex_doctrine_extension.phar';

    use Silex\Extension\DoctrineExtension;

    $app = new Silex\Application;
     
     $app['autoloader']->registerNamespace('Entity', __DIR__);
     
     $app->register(new DoctrineExtension, array(
         'doctrine.dbal.connection_options' => array(
             'driver' => 'pdo_mysql',
             'dbname' => 'training',
             'host' => 'localhost',
         ),
         'doctrine.orm' => true,
         'doctrine.orm.entities' => array(
             array('type' => 'annotation', 'path' => __DIR__.'/Entity', 'namespace' => 'Entity'),
         ),
         'doctrine.common.class_path'    => __DIR__.'/vendor/doctrine_common/lib',
         'doctrine.dbal.class_path'    => __DIR__.'/vendor/doctrine_dbal/lib',
         'doctrine.orm.class_path'    => __DIR__.'/vendor/doctrine_orm/lib',
     ));


```
