<?php

require 'vendor/autoload.php';
Dotenv\Dotenv::createImmutable(__DIR__)->load();
require 'routers/index.php';
