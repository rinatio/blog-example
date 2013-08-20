<?php
set_include_path(get_include_path() . PATH_SEPARATOR . __DIR__ . '/../');
require __DIR__ . '/../app/autoloader.php';
spl_autoload_register('autoload');

$front = \app\component\Front::instance();
$config = require(__DIR__ . '/../app/config/main.php');
$front->run($config);
