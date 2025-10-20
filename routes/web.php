<?php

// Homepage
$router->get('/', function () {
    $controller = new HomeController();
    $controller->index();
});


// Auth Routes
$router->get('/login', function () {
    $controller = new AuthController();
    $controller->showLogin();
});

$router->post('/login', function () {
    $controller = new AuthController();
    $controller->login($_POST['email'], $_POST['password']);
});

$router->get('/register', function () {
    $controller = new AuthController();
    $controller->showRegister();
});

$router->post('/register', function () {
    $db = new Database();

    $user = new User(
        $db, 
        null, 
        trim($_POST['first_name']),
        trim($_POST['last_name']),
        trim($_POST['email']),
        trim($_POST['gender']),
        trim($_POST['password'])
    );

    $address = new Address(
        $db, 
        null,
        trim($_POST['street']),
        $_POST['city']
    );
    
    $controller = new AuthController($user, $address);
    $controller->register();
});