<?php
// This route handling function will only be executed when visiting http(s)://www.example.org/about

use App\Controllers\Client\HomeController;

$router->get('/', HomeController::class .'@index');
$router->get('/about', function() {
    echo 'Trang gioi thieu';
});