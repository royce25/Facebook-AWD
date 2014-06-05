<?php
/**
 * @author AHWEBDEV (Alexandre Hermann) [hermann.alexandre@ahwebev.fr]
 */
use Composer\Autoload\ClassLoader;

$vendorDir = __DIR__ . DIRECTORY_SEPARATOR . 'vendors';
require $vendorDir . '/autoload/ClassLoader.php';
$loader = new ClassLoader();
$map = require $vendorDir . '/autoload/namespaceMap.php';
$classMap = require $vendorDir . '/autoload/classMap.php';
foreach ($map as $namespace => $path) {
    $loader->add($namespace, $path);
}
if ($classMap) {
    $loader->addClassMap($classMap);
}
$loader->register(true);
