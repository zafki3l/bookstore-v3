<?php

use App\Http\Controllers\BookController;
use App\Http\Controllers\StaffController;

// Dashboard
$router->get('/staff/dashboard', [StaffController::class, 'dashboard']);

// Books
$router->get('/staff/books', [BookController::class, 'index']);
$router->get('/staff/books/create', [BookController::class, 'create']);
$router->post('/staff/books', [BookController::class, 'store']);