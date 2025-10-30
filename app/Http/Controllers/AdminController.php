<?php

namespace App\Http\Controllers;

use App\Http\Middlewares\EnsureAdmin;
use App\Models\User;
use Core\Controller;
use Traits\HttpResponseTrait;

/**
 * Class Admin Controller
 */
class AdminController extends Controller
{
    use HttpResponseTrait;

    // Constructor
    public function __construct(
        private EnsureAdmin $ensureAdmin,
        private User $user,
    ) {
        $this->ensureAdmin->handle();
    }

    /**
     * Shows admin dashboard view
     * @return void
     */
    public function index() : void
    {
        $users = $this->user->getAllUser();

        if (isset($_GET['search'])) {
            $users = $this->user->searchUser($_GET['search']);
        }
        
        $this->view(
            'admin/dashboard', 
            'layouts/main-layouts/admin.layouts',
            'Admin Dashboard',
            $users
        );
    }
}