<?php

namespace App\Http\Controllers;

use App\Http\Middlewares\EnsureAdmin;
use App\Http\Requests\AdminRequest;
use App\Models\Address;
use App\Models\User;
use Core\Controller;
use Traits\HttpResponseTrait;

/**
 * Class Admin Controller
 * Handles User Management and other Admin logics
 */
class AdminController extends Controller
{
    use HttpResponseTrait;

    public function __construct(
        private EnsureAdmin $ensureAdmin,
        private User $user,
        private Address $address
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

        $this->view(
            'admin/dashboard', 
            'layouts/main-layouts/admin.layouts',
            'Admin Dashboard',
            $users
        );
    }

    public function showAddUser() : void
    {
        $this->view(
            'admin/addUser',
            'layouts/main-layouts/admin.layouts',
            'Create new user',
        );
    }

    public function addUser(AdminRequest $adminRequest = new AdminRequest())
    {
        $request = $adminRequest->addUserRequest();
        
        $this->user->fill($request);
        $user_id = $this->user->createUser();

        $this->address->fill($request);
        $address_id = $this->address->createAddress();

        $this->user->linkAddress($user_id, $address_id);

        $this->redirect('/admin/dashboard');
    }
}