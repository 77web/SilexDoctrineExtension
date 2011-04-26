<?php

namespace SilexExtensions\Compiler;

use Symfony\Component\Finder\Finder;
use Symfony\Component\HttpKernel\Kernel;

/**
 * The Compiler class compiles the Doctrine Silex Extension.
 *
 * @author Florian Klein <florian.klein@free.fr>
 */
class DoctrineCompiler
{
    public function compile($pharFile = 'silex_doctrine_extension.phar')
    {
        if (file_exists($pharFile)) {
            unlink($pharFile);
        }

        $phar = new \Phar($pharFile, 0, 'Silex');
        $phar->setSignatureAlgorithm(\Phar::SHA1);

        $phar->startBuffering();

        $finder = new Finder();
        $finder->files()
            ->ignoreVCS(true)
            ->name('*.php')
            ->in(__DIR__.'/../../Doctrine/src')
        ;

        foreach ($finder as $file) {
            $this->addFile($phar, $file);
        }

        $phar['_cli_stub.php'] = $this->getStub();
        $phar['_web_stub.php'] = $this->getStub();
        $phar->setDefaultStub('_cli_stub.php', '_web_stub.php');

        $phar->stopBuffering();

        // $phar->compressFiles(\Phar::GZ);

        unset($phar);
    }

    protected function addFile($phar, $file, $strip = true)
    {
        $path = str_replace(realpath(__DIR__.'/../..').'/', '', $file->getRealPath());
        $content = file_get_contents($file);
        if ($strip) {
            $content = Kernel::stripComments(file_get_contents($file));
        }

        $phar->addFromString($path, $content);
    }

    protected function getStub()
    {
        return <<<EOF
<?php
/*
 * This file is part of the Silex framework.
 *
 * (c) Florian Klein <florian.klein@free.fr>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

require_once __DIR__.'/Doctrine/src/autoload.php';

__HALT_COMPILER();
EOF;
    }
}



