<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\HomeController;
use App\Models\Address;
use App\Models\User;
use Configs\Database;
use Core\Container;
use Core\App;
use ErrorHandlers\UserErrorHandler;

$container = new Container();

$container->bind(Database::class, function () {
    return new Database();
});

$container->bind(User::class, function ($container) {
    return new User(
        $container->resolve(Database::class)
    );
});

$container->bind(Address::class, function ($container) {
    return new Address(
        $container->resolve(Database::class)
    );
});

$container->bind(UserErrorHandler::class, function () {
    return new UserErrorHandler();
});

$container->bind(AuthController::class, function ($container) {
    return new AuthController(
        $container->resolve(User::class),
        $container->resolve(Address::class),
        $container->resolve(UserErrorHandler::class)
    );
});

$container->bind(HomeController::class, function () {
    return new HomeController();
});

App::setContainer($container);