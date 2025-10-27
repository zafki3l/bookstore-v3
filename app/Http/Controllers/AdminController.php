<?php

namespace App\Http\Controllers;

use App\Http\Middlewares\EnsureAdmin;
use App\Http\Requests\AdminRequest;
use App\Models\Address;
use App\Models\User;
use Core\Controller;
use ErrorHandlers\UserErrorHandler;
use Exception;
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
        private Address $address,
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

    /**
     * Shows add user view
     * @return void
     */
    public function create() : void
    {
        $this->view(
            'admin/addUser',
            'layouts/main-layouts/admin.layouts',
            'Create new user',
        );

        if (isset($_SESSION['errors'])) {
            unset($_SESSION['errors']);
        }
    }

    /**
     * Handles add user
     * @param \App\Http\Requests\AdminRequest $adminRequest
     * @return void
     */
    public function store(AdminRequest $adminRequest = new AdminRequest())
    {
        // Get request from user
        $request = $adminRequest->addUserRequest();

        // Errors handling
        $errors = $this->userErrorHandler($this->userErrorHandler, $request);
        if (!empty($errors)) {
            $_SESSION['errors'] = $errors;
            $this->back();
        }
        
        /**
         * Binding parameters into User and Address
         * Then create new user, address
         */
        $this->user->fill($request);
        $user_id = $this->user->createUser();

        $this->address->fill($request);
        $address_id = $this->address->createAddress();

        // Link user and address to user_address
        $this->user->linkAddress($user_id, $address_id);

        // Redirect back to dashboard if successfully
        $this->redirect('/admin/dashboard');
    }

    /**
     * Shows edit user view
     * @param int $user_id
     * @return void
     */
    public function edit(int $user_id) : void
    {
        $this->view(
            'admin/editUser',
            'layouts/main-layouts/admin.layouts',
            'Edit user',
            $this->user->getUserById($user_id)
        );
    }

    /**
     * Handles update user
     * @param int $user_id
     * @param \App\Http\Requests\AdminRequest $adminRequest
     * @return void
     */
    public function update(int $user_id, AdminRequest $adminRequest = new AdminRequest()) : void
    {
        // Get request from user
        $request = $adminRequest->updateUserRequest();

        // Errors handling
        $errors = $this->userErrorHandler($this->userErrorHandler, $request);
        if (!empty($errors)) {
            $_SESSION['errors'] = $errors;
            $this->back();
        }

        // Binding parameters
        $this->user->fill($request);
        $this->address->fill($request);

        // Update user information
        $this->user->updateUserById($user_id);
        $this->address->updateAddressById($request['address_id']);

        // Redirect back to dashboard if successfully
        $this->redirect('/admin/dashboard');
    }

    public function destroy(int $user_id)
    {
        
    }

    /**
     * Handles user Errors
     * @param \ErrorHandlers\UserErrorHandler $userErrorHandler
     * @param array $request
     * @return array<array|string>
     */
    private function userErrorHandler(UserErrorHandler $userErrorHandler, array $request) : array
    {
        $errors = [];

        try {
            // Email exist error handling
            if ($userErrorHandler->isEmailExist($request['email'], $this->user)) {
                $errors['email-existed'] = 'Email already existed!';
            }

            // Email validate error handling
            if ($userErrorHandler->isEmailInvalid($request['email'])) {
                $errors['email-invalid'] = 'Invalid email!';
            }

            // Empty input handling
            if ($userErrorHandler->emptyInput($request['first_name'])) {
                $errors['empty-firstname'] = 'First name can not be empty!'; 
            }

            if ($userErrorHandler->emptyInput($request['last_name'])) {
                $errors['empty-lastname'] = 'Last name can not be empty!'; 
            }

            if ($userErrorHandler->emptyInput($request['email'])) {
                $errors['empty-email'] = 'Email can not be empty!'; 
            }

            if ($userErrorHandler->emptyInput($request['gender'])) {
                $errors['empty-gender'] = 'Gender can not be empty!'; 
            }

            if ($userErrorHandler->emptyInput($request['password'])) {
                $errors['empty-password'] = 'Password can not be empty!'; 
            }
        } catch (Exception $e) {
            $errors['exception-error'][] = $e->getMessage();
        }

        return $errors;
    }
}