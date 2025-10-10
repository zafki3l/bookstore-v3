<?php

$router->get('/', function () {
    $controller = new HomeController();
    $controller->index();
});