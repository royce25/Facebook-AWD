<?php

/**
 * @author AHWEBDEV (Alexandre Hermann) [hermann.alexandre@ahwebev.fr]
 */
use Composer\Autoload\ClassLoader;

require __DIR__ . '/ClassLoader.php';
$loader = new ClassLoader();

$map = require __DIR__ . '/namespaceMap.php';
foreach ($map as $namespace => $path) {
    $loader->add($namespace, $path);
}

$classMap = require __DIR__ . '/classMap.php';
if ($classMap) {
    $loader->addClassMap($classMap);
}

$loader->register(true);
