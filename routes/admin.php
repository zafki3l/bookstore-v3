<?php

use App\Http\Controllers\AdminController;

// Dashboard
$router->get('/admin/dashboard', [AdminController::class, 'index']);
$router->get('/admin/add-user', [AdminController::class, 'showAddUser']);
$router->post('/admin/add-user', [AdminController::class, 'addUser']);