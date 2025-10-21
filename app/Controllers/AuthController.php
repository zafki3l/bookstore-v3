<?php

class AuthController extends Controller
{
    private User $user;
    private Address $address;
    private AuthErrorHandler $errorHandler;

    public function __construct(
        User $user = new User(),
        Address $address = new Address(),
        AuthErrorHandler $errorHandler = new AuthErrorHandler()
    ) {
        $this->user = $user;
        $this->address = $address;
        $this->errorHandler = $errorHandler;
    }

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
        $errorHandler = $this->errorHandler;

        $this->user->setEmail($email);
        $this->user->setPassword($password);

        if (!empty($this->loginErrorHandling($errorHandler))) {
            $_SESSION['errors'] = $this->loginErrorHandling($errorHandler);
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
        // Error handlers
        $errorHandler = $this->errorHandler;

        if (!empty($this->registerErrorHandling($errorHandler))) {
            $_SESSION['errors'] = $this->registerErrorHandling($errorHandler);
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

    private function loginErrorHandling(AuthErrorHandler $errorHandler) : array 
    {
        $errors = [];

        try {
            // Email not exist handling
            if (!$errorHandler->isEmailExist($this->user->getEmail())) {
                $errors['email-not-existed'][] = 'Email is not exist! create a new account!';
            }

            // empty email handling
            if ($errorHandler->emptyEmail($this->user->getEmail())) {
                $errors['empty-email'][] = 'Email can not be empty!';
            }

            // Check password is correct
            $userData = $this->user->getUserByEmail($this->user->getEmail());
            $db_password = $userData[0]['password'];

            if (!$errorHandler->isPasswordCorrect($db_password, $this->user->getPassword())) {
                $errors['incorrect-password'][] = 'Password incorrect!';
            }
        } catch (Exception $e) {
            // Exception error handling
            $errors['exception-error'][] = $e->getMessage();
        }

        return $errors;
    }
    
    private function registerErrorHandling(AuthErrorHandler $errorHandler) : array
    {
        $errors = [];

        try {
            // Email exist error handling
            if ($errorHandler->isEmailExist($this->user->getEmail())) {
                $errors['email-existed'][] = 'Email already existed!';
            }

            // Email validate error handling
            if ($errorHandler->emailValidate($this->user->getEmail())) {
                $errors['email-invalid'][] = 'Invalid email!';
            }

            // Password mismatch error handling
            if ($errorHandler->passwordMisMatch($this->user->getPassword(), $_POST['password-confirmation'])) {
                $errors['pwd-mismatch'][] = 'Password mismatch!';
            }

            // empty first name handling
            if ($errorHandler->emptyFirstName($this->user->getFirstName())) {
                $errors['empty-firstname'][] = 'First name can not be empty!';
            }

            // empty last name handling
            if ($errorHandler->emptyLastName($this->user->getLastName())) {
                $errors['empty-lastname'][] = 'Last name can not be empty!';
            }

            // empty email handling
            if ($errorHandler->emptyEmail($this->user->getEmail())) {
                $errors['empty-email'][] = 'Email can not be empty!';
            }

            // empty gender handling
            if ($errorHandler->emptyGender($this->user->getGender())) {
                $errors['empty-gender'][] = 'Gender can not be empty!';
            }

            // empty password handling
            if ($errorHandler->emptyPassword($this->user->getPassword())) {
                $errors['empty-password'][] = 'Password can not be empty!';
            }

            // Password is not confirm handling
            if ($errorHandler->isPasswordConfirm($_POST['password-confirmation'])) {
                $errors['pwd-confirm-error'][] = 'Please confirm your password!';
            }
        } catch (Exception $e) {
            // Exception error handling
            $errors['exception-error'][] = $e->getMessage();
        }

        return $errors;
    }
}
