<?php

ob_start();
session_start();

header ("Content-Type:text/html; charset=UTF-8", false);

// запрет кэширования
header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");
header("Last-Modified: " . gmdate("D, d M Y H:i:s")." GMT");
header("Cache-Control: no-cache, must-revalidate");
header("Cache-Control: post-check=0,pre-check=0", false);
header("Cache-Control: max-age=0", false);
header("Pragma: no-cache");

// Общие настройки
ini_set('display_errors',1);
error_reporting(E_ALL);
mb_internal_encoding('utf-8');


define('ROOT', dirname(__FILE__));

require_once(ROOT.'/components/Autoload.php');

require __DIR__ . '/vendor/autoload.php';



// регистрация функции автозагрузки
spl_autoload_register('myAutoload');

// Вызов Router
$router = new \components\Router();
$router->run();

ob_end_flush();
