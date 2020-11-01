<?php

//phpinfo();

/**
 * Front controller
 *
 * PHP version 7.3.6
 */

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

/*
 * Composer
 */
require '../vendor/autoload.php';

/**
 * Autoloader
 */
//spl_autoload_register(function ($class) {
//  $root = dirname(__DIR__); // get the parent directory
//  $file = $root . '/' . str_replace('\\', '/', $class) . '.php';
//  if (is_readable($file)) {
//    //require $root . '/' . str_replace('\\', '/', $class) . '.php';
//    require $file;
//  }
//});

/*
 * Error and Exception handling
 */
error_reporting(E_ALL);
set_error_handler('Core\Error::errorHandler');
set_exception_handler('Core\Error::exceptionHandler');

/**
 * Routing
 */
$router = new Core\Router();

// Add the routes
$router->add('', ['controller' => 'Insurances', 'action' => 'users-table']);
$router->add('{controller}/{action}');
$router->add('{controller}/{id:\d+}/{action}');
$router->add('admin/{controller}/{action}', ['namespace' => 'Admin']);

$router->dispatch($_SERVER['QUERY_STRING']);

