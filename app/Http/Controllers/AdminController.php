<?php

namespace App\Http\Controllers;

use App\Http\Middlewares\EnsureAdmin;
use App\Models\User;
use Core\Controller;
use ErrorHandlers\UserErrorHandler;
use Traits\HttpResponseTrait;

/**
 * Class Admin Controller
 * Handles User Management and other Admin logics
 */
class AdminController extends Controller
{
    use HttpResponseTrait;

    // Constructor
    public function __construct(
        private EnsureAdmin $ensureAdmin,
        private User $user,
        private UserErrorHandler $userErrorHandler
    ) {
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
            'Admin Dashboard',
            $this->user->getAllUser()
        );
    }
}