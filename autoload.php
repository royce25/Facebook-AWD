<?php

use Composer\Autoload\ClassLoader;

/**
 * @author AHWEBDEV (Alexandre Hermann) [hermann.alexandre@ahwebev.fr]
 */
$vendorDir = __DIR__ . DIRECTORY_SEPARATOR . 'vendors';
require $vendorDir . '/Composer/ClassLoader.php';
$loader = new ClassLoader();
$map = require $vendorDir . '/Composer/namespaceMap.php';
foreach ($map as $namespace => $path) {
    $loader->add($namespace, $path);
}
$classMap = require $vendorDir . '/Composer/classMap.php';
if ($classMap) {
    $loader->addClassMap($classMap);
}
$loader->register(true);
?>
