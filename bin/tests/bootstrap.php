<?php

$testdir = getenv('WP_TESTS');
require_once $testdir . '/tmp/wordpress-tests-lib/includes/functions.php';

function _manually_load_plugin()
{
    require dirname(__FILE__) . '/../../boot.php';
}

tests_add_filter('muplugins_loaded', '_manually_load_plugin');
require $testdir . '/tmp/wordpress-tests-lib/includes/bootstrap.php';

