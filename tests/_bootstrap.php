<?php

define('YII_ENV', 'test');

// Use the current installation of Craft
define('CRAFT_VENDOR_PATH', __DIR__.'/../vendor');

$devMode = true;

$vendorPath = realpath(CRAFT_VENDOR_PATH);
$craftPath = __DIR__.'/_craft';

error_reporting(E_ALL);
ini_set('display_errors', 1);
defined('YII_DEBUG') || define('YII_DEBUG', true);
defined('YII_ENV') || define('YII_ENV', 'dev');
defined('CRAFT_ENVIRONMENT') || define('CRAFT_ENVIRONMENT', '');

defined('CURLOPT_TIMEOUT_MS') || define('CURLOPT_TIMEOUT_MS', 155);
defined('CURLOPT_CONNECTTIMEOUT_MS') || define('CURLOPT_CONNECTTIMEOUT_MS', 156);

// Load the files
$srcPath = dirname(__DIR__).'/src';
$libPath = dirname(__DIR__).'/lib';
require $vendorPath.'/yiisoft/yii2/Yii.php';
require $srcPath.'/Craft.php';


