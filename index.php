<?php

    $loader = require_once "vendor/autoload.php";

    $URI = $_SERVER['REQUEST_URI'];

    $routes = NanoPHP\Routes::getRoutes();
    $router = new NanoPHP\Router($URI, $routes);