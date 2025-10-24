<?php

use App\Http\Controllers\AdminController;

// Dashboard
$router->get('/admin/dashboard', [AdminController::class, 'index']);