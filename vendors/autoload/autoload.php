<?php

/**
 * @author AHWEBDEV (Alexandre Hermann) [hermann.alexandre@ahwebev.fr]
 */
use Composer\Autoload\ClassLoader;

require __DIR__ . '/ClassLoader.php';
$loader = new ClassLoader();
$vendorDir = dirname(__DIR__);
$baseDir = dirname($vendorDir);
$wpPlugins = dirname($baseDir);
$map = array(
    'AHWEBDEV\\FacebookAWD' => $baseDir . '/src',
    'AHWEBDEV\\FacebookAWD\\Plugin' => $vendorDir,
    'AHWEBDEV\\Framework' => $vendorDir . '/AHWEBDEV/Framework/src',
    'AHWEBDEV\\Wordpress' => $vendorDir . '/AHWEBDEV/Wordpress/src',
    'Facebook' => $vendorDir . '/Facebook/src'
);
foreach ($map as $namespace => $path) {
    $loader->add($namespace, $path);
}

/* $classMap = array();
  if ($classMap) {
  $loader->addClassMap($classMap);
  } */

$loader->register(true);
