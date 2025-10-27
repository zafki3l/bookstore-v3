<?php

use App\Http\Controllers\AdminController;

// Dashboard
$router->get('/admin/dashboard', [AdminController::class, 'index']);
$router->get('/admin/users/create', [AdminController::class, 'create']);
$router->post('/admin/users', [AdminController::class, 'store']);
$router->get('/admin/users/edit', [AdminController::class, 'edit']);