<?php

use App\Http\Controllers\AdminController;

// Dashboard
$router->get('/admin/dashboard', [AdminController::class, 'index']);
$router->get('/admin/users/create', [AdminController::class, 'create']);
$router->post('/admin/users', [AdminController::class, 'store']);
$router->get('/admin/users/{id}/edit', [AdminController::class, 'edit']);
$router->put('/admin/users/{id}', [AdminController::class, 'update']);
$router->delete('/admin/users/{id}', [AdminController::class, 'destroy']);