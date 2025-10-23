<?php

namespace App\Controllers;

use Core\Controller;
use App\Models\User;
use App\Models\Address;
use ErrorHandlers\AuthErrorHandler;
use Exception;

class AuthController extends Controller
{
    public function __construct(
        private User $user,
        private Address $address,
        private AuthErrorHandler $authErrorHandler
    ) {}

    // Shows login form
    public function showLogin(): void
    {
        ob_start();
        $this->renderView('auth/login');

        $data = [
            'title' => 'Login',
            'content' => ob_get_clean()
        ];

        $this->renderView('layouts/main-layouts/homepage.layouts', $data);
        if (isset($_SESSION['errors'])) {
            unset($_SESSION['errors']);
        }
    }

    // Shows register form
    public function showRegister(): void
    {
        ob_start();
        $this->renderView('auth/register');

        $data = [
            'title' => 'Register',
            'content' => ob_get_clean()
        ];

        $this->renderView('layouts/main-layouts/homepage.layouts', $data);
        if (isset($_SESSION['errors'])) {
            unset($_SESSION['errors']);
        }
    }

    // Login handler
    public function login(string $email, string $password): void
    {
        // Error handlers
        $authErrorHandler = $this->authErrorHandler;

        $this->user->email = $email;
        $this->user->password = $password;

        if (!empty($this->loginErrorHandling($authErrorHandler))) {
            $_SESSION['errors'] = $this->loginErrorHandling($authErrorHandler);
            header('Location: /' . PROJECT_NAME . '/login');
            exit();
        }

        $loginUser = $this->user->getUserByEmail($email);

        if ((empty($loginUser) || !password_verify($password, $loginUser[0]['password']))) {
            // Redirect back to login if failed
            header('Location: /' . PROJECT_NAME . '/login');
            exit();
        }

        // Set session for user and Redirect to homepage if successfully
        $_SESSION['user'] = [
            'user_id' => $loginUser[0]['user_id'],
            'address_id' => $loginUser[0]['address_id'],
            'first_name' => $loginUser[0]['first_name'],
            'last_name' => $loginUser[0]['last_name'],
            'email' => $loginUser[0]['email'],
            'gender' => $loginUser[0]['gender'],
            'street' => $loginUser[0]['street'],
            'city' => $loginUser[0]['city'],
            'role' => $loginUser[0]['role']
        ];

        header('Location: /' . PROJECT_NAME);
        exit();
    }

    // Logout handler
    public function logout()
    {
        if (session_status() == PHP_SESSION_ACTIVE) {
            session_destroy();

            header('Location: /' . PROJECT_NAME . '/login');
            exit();
        }
    }

    // Register handler
    public function register(): void
    {
        // Binding parameters
        $this->user->first_name = trim($_POST['first_name']);
        $this->user->last_name = trim($_POST['last_name']);
        $this->user->email = trim($_POST['email']);
        $this->user->gender = trim($_POST['gender']);
        $this->user->password = trim($_POST['password']);

        $this->address->street = trim($_POST['street']);
        $this->address->city = trim($_POST['city']);
        
        // Error handlers
        $authErrorHandler = $this->authErrorHandler;

        if (!empty($this->registerErrorHandling($authErrorHandler))) {
            $_SESSION['errors'] = $this->registerErrorHandling($authErrorHandler);
            header('Location: /' . PROJECT_NAME . '/register');
            exit();
        }

        // Add new user and address
        $user_id = $this->user->createUser();
        $address_id = $this->address->createAddress();

        // Insert $user_id and $address_id into users_address table
        $this->user->linkAddress($user_id, $address_id);

        // Redirect to login if register successfully
        header('Location: /' . PROJECT_NAME . '/login');
        exit();
    }

    private function loginErrorHandling(AuthErrorHandler $authErrorHandler) : array 
    {
        $errors = [];

        try {
            // Email not exist handling
            if (!$authErrorHandler->isEmailExist($this->user->email, $this->user)) {
                $errors['email-not-existed'][] = 'Email is not exist! create a new account!';
            }

            // empty email handling
            if ($authErrorHandler->emptyEmail($this->user->email)) {
                $errors['empty-email'][] = 'Email can not be empty!';
            }

            // Check password is correct
            $userData = $this->user->getUserByEmail($this->user->email);
            $db_password = $userData[0]['password'];

            if (!$authErrorHandler->isPasswordCorrect($db_password, $this->user->password)) {
                $errors['incorrect-password'][] = 'Password incorrect!';
            }
        } catch (Exception $e) {
            // Exception error handling
            $errors['exception-error'][] = $e->getMessage();
        }

        return $errors;
    }
    
    private function registerErrorHandling(AuthErrorHandler $authErrorHandler) : array
    {
        $errors = [];

        try {
            // Email exist error handling
            if ($authErrorHandler->isEmailExist($this->user->email, $this->user)) {
                $errors['email-existed'][] = 'Email already existed!';
            }

            // Email validate error handling
            if ($authErrorHandler->emailValidate($this->user->email)) {
                $errors['email-invalid'][] = 'Invalid email!';
            }

            // Password mismatch error handling
            if ($authErrorHandler->passwordMisMatch($this->user->password, $_POST['password-confirmation'])) {
                $errors['pwd-mismatch'][] = 'Password mismatch!';
            }

            // empty first name handling
            if ($authErrorHandler->emptyFirstName($this->user->first_name)) {
                $errors['empty-firstname'][] = 'First name can not be empty!';
            }

            // empty last name handling
            if ($authErrorHandler->emptyLastName($this->user->last_name)) {
                $errors['empty-lastname'][] = 'Last name can not be empty!';
            }

            // empty email handling
            if ($authErrorHandler->emptyEmail($this->user->email)) {
                $errors['empty-email'][] = 'Email can not be empty!';
            }

            // empty gender handling
            if ($authErrorHandler->emptyGender($this->user->gender)) {
                $errors['empty-gender'][] = 'Gender can not be empty!';
            }

            // empty password handling
            if ($authErrorHandler->emptyPassword($this->user->password)) {
                $errors['empty-password'][] = 'Password can not be empty!';
            }

            // Password is not confirm handling
            if ($authErrorHandler->isPasswordConfirm($_POST['password-confirmation'])) {
                $errors['pwd-confirm-error'][] = 'Please confirm your password!';
            }
        } catch (Exception $e) {
            // Exception error handling
            $errors['exception-error'][] = $e->getMessage();
        }

        return $errors;
    }
}
