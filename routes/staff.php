<?php

use App\Http\Controllers\BookController;
use App\Http\Controllers\StaffController;
use App\Http\Middlewares\CSRF_Authenticator;
use App\Http\Middlewares\EnsureAuth;
use App\Http\Middlewares\EnsureStaff;

// Dashboard
$router->get('/staff/dashboard', [StaffController::class, 'dashboard']);

// Books
$router->middleware([EnsureAuth::class, EnsureStaff::class])->get('/staff/books', [BookController::class, 'index']);
$router->middleware([EnsureAuth::class, EnsureStaff::class])->get('/staff/books/create', [BookController::class, 'create']);
$router->middleware([EnsureAuth::class, EnsureStaff::class, CSRF_Authenticator::class])->post('/staff/books', [BookController::class, 'store']);