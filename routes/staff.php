<?php

use App\Http\Controllers\StaffController;

// Dashboard
$router->get('/staff/dashboard', [StaffController::class, 'dashboard']);