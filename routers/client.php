<?php
// This route handling function will only be executed when visiting http(s)://www.example.org/about

use App\Controllers\Client\AboutController;
use App\Controllers\Client\HomeController;
use App\Controllers\Client\ProductController;

$router->get('/', HomeController::class .'@index');
$router->get('/product/{id}', ProductController::class .'@show');
$router->get('/about', AboutController::class .'@index');