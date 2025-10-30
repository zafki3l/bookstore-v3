<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\UserController;

// Dashboard
$router->get('/admin/dashboard', [AdminController::class, 'index']);
$router->get('/admin/users/create', [UserController::class, 'create']);
$router->post('/admin/users', [UserController::class, 'store']);
$router->get('/admin/users/{id}/edit', [UserController::class, 'edit']);
$router->put('/admin/users/{id}', [UserController::class, 'update']);
$router->delete('/admin/users/{id}', [UserController::class, 'destroy']);