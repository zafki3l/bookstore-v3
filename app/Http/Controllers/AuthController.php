<?php

namespace App\Http\Controllers;

use App\Http\Requests\AuthRequest;
use Core\Controller;
use App\Models\User;
use App\Models\Address;
use ErrorHandlers\UserErrorHandler;
use Exception;
use Traits\HttpResponseTrait;

/**
 * Class AuthController
 * Handles login, register and logout.
 */
class AuthController extends Controller
{
    use HttpResponseTrait;

    // Constructor
    public function __construct(
        private User $user,
        private Address $address,
        private UserErrorHandler $userErrorHandler
    ) {}

    /**
     * Shows login form
     * @return void
     */
    public function showLogin(): void
    {
        $this->view(
            'auth/login',
            'layouts/main-layouts/homepage.layouts',
            'Login'
        );

        if (isset($_SESSION['errors'])) {
            unset($_SESSION['errors']);
        }
    }

    /**
     * shows register form
     * @return void
     */
    public function showRegister(): void
    {
        $this->view(
            'auth/register',
            'layouts/main-layouts/homepage.layouts',
            'Register'
        );
        
        if (isset($_SESSION['errors'])) {
            unset($_SESSION['errors']);
        }
    }

    /**
     * Handles user login
     * @param \App\Http\Requests\AuthRequest $authRequest
     * @return never
     */
    public function login(AuthRequest $authRequest = new AuthRequest()): void
    {
        // Get email & password from request
        $request = $authRequest->loginRequest();

        // Error handling
        $errors = $this->loginErrorHandling($this->userErrorHandler, $request);
        if (!empty($errors)) {
            $_SESSION['errors'] = $errors;
            $this->back();
        }
        
        // Fill request data into user
        $this->user->fill($request);

        // Get user password from database
        $db_user = $this->user->getUserByEmail($this->user->email);
        $db_password = $db_user[0]['password'];

        // Check if db_user not exist or password and db_password not matching then failed
        if ((empty($db_user) || !password_verify($this->user->password, $db_password))) {
            $this->back();
        }

        // Set session for user if successfully
        $_SESSION['user'] = $this->setSession($db_user);

        // Redirect user
        if ($_SESSION['user']['role'] == User::ROLE_ADMIN) {
            $this->redirect('/admin/dashboard');
        }

        if ($_SESSION['user']['role'] == User::ROLE_STAFF) {
            $this->redirect('/staff/dashboard');
        }

        $this->redirect('/');
    }

    /**
     * Handles user logout
     * @return void
     */
    public function logout()
    {
        if (session_status() == PHP_SESSION_ACTIVE) {
            session_destroy();

            $this->redirect('/login');
        }
    }

    /**
     * Handles user register
     * @param \App\Http\Requests\AuthRequest $authRequest
     * @return never
     */
    public function register(AuthRequest $authRequest = new AuthRequest()): void
    {
        // Get request data
        $request = $authRequest->registerRequest();

        // Error handling
        $errors = $this->registerErrorHandling($this->userErrorHandler, $request);
        if (!empty($errors)) {
            $_SESSION['errors'] = $errors;
            $this->back();
        }

        // Binding parameters into User and Address
        $this->user->fill($request);
        $this->address->fill($request);

        // Add new user and address
        $user_id = $this->user->createUser();
        $address_id = $this->address->createAddress();

        // Insert $user_id and $address_id into users_address table
        $this->user->linkAddress($user_id, $address_id);

        // Redirect to login if register successfully
        $this->redirect('/login');
    }

    /**
     * Summary of setSession
     * Set user session when successfully login
     * @param array $db_user
     * @return array
     */
    private function setSession(array $db_user) : array
    {
        return [
            'user_id' => $db_user[0]['user_id'],
            'address_id' => $db_user[0]['address_id'],
            'first_name' => $db_user[0]['first_name'],
            'last_name' => $db_user[0]['last_name'],
            'email' => $db_user[0]['email'],
            'gender' => $db_user[0]['gender'],
            'street' => $db_user[0]['street'],
            'city' => $db_user[0]['city'],
            'role' => $db_user[0]['role']
        ];
    }

    /**
     * Handles login errors
     * @param \ErrorHandlers\UserErrorHandler $userErrorHandler
     * @return array<array>
     */
    private function loginErrorHandling(UserErrorHandler $userErrorHandler, array $request) : array 
    {
        $errors = [];

        try {
            $userData = $this->user->getUserByEmail($request['email']);
            $user_role = $userData[0]['role'];

            // Email not exist handling
            if (!$userErrorHandler->isEmailExist($request['email'], $this->user) || 
                $user_role == User::ROLE_GUEST) {
                $errors['email-not-existed'] = 'Email is not exist! create a new account!';
            }

            // empty email handling
            if ($userErrorHandler->emptyInput($request['email'])) {
                $errors['empty-email'] = 'Email can not be empty!';
            }

            // Check password is correct
            
            $user_password = $userData[0]['password'];

            if (!$userErrorHandler->isPasswordCorrect($user_password, $request['password'])) {
                $errors['incorrect-password'] = 'Password incorrect!';
            }
        } catch (Exception $e) {
            // Exception error handling
            $errors['exception-error'] = $e->getMessage();
        }

        return $errors;
    }
    
    /**
     * Handles register errors
     * @param \ErrorHandlers\UserErrorHandler $userErrorHandler
     * @return array<array>
     */
    private function registerErrorHandling(UserErrorHandler $userErrorHandler, array $request) : array
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

            // Password mismatch error handling
            if ($userErrorHandler->passwordMisMatch($request['password'], $_POST['password-confirmation'])) {
                $errors['pwd-mismatch'] = 'Password mismatch!';
            }

            // empty first name handling
            if ($userErrorHandler->emptyInput($request['first_name'])) {
                $errors['empty-firstname'] = 'First name can not be empty!';
            }

            // empty last name handling
            if ($userErrorHandler->emptyInput($request['last_name'])) {
                $errors['empty-lastname'] = 'Last name can not be empty!';
            }

            // empty email handling
            if ($userErrorHandler->emptyInput($request['email'])) {
                $errors['empty-email'] = 'Email can not be empty!';
            }

            // empty gender handling
            if ($userErrorHandler->emptyInput($request['gender'])) {
                $errors['empty-gender'] = 'Gender can not be empty!';
            }

            // empty password handling
            if ($userErrorHandler->emptyInput($request['password'])) {
                $errors['empty-password'] = 'Password can not be empty!';
            }

            // Password is not confirm handling
            if ($userErrorHandler->isPasswordConfirm($_POST['password-confirmation'])) {
                $errors['pwd-confirm-error'] = 'Please confirm your password!';
            }
        } catch (Exception $e) {
            // Exception error handling
            $errors['exception-error'] = $e->getMessage();
        }

        return $errors;
    }
}
