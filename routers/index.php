<?php
// Create Router instance
use Bramus\Router\Router;
$router = new Router();
// Define routes
require 'admin.php';
require 'client.php';

// Run it!
$router->run();