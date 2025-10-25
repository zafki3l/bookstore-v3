<?php

namespace App\Http\Controllers;

use App\Http\Middlewares\EnsureAdmin;
use Core\Controller;

/**
 * Class Admin Controller
 * Handles User Management and other Admin logics
 */
class AdminController extends Controller
{
    public function __construct(private EnsureAdmin $ensureAdmin) 
    {
        $this->ensureAdmin->handle();
    }

    /**
     * Shows admin dashboard view
     * @return void
     */
    public function index() : void
    {
        $this->view(
            'admin/dashboard', 
            'layouts/main-layouts/admin.layouts',
            'Admin Dashboard'
        );
    }
}