<?php 

class AuthController extends Controller
{
    private User $user;
    private Address $address;

    public function __construct(User $user = new User(), Address $address = new Address())
    {
        $this->user = $user;
        $this->address = $address;
    }
	
    // Shows login form
    public function showLogin()
    {
        ob_start();
        $this->renderView('auth/login');

        $data = [
            'title' => 'Login',
            'content' => ob_get_clean()
        ];

        $this->renderView('layouts/main-layouts/homepage.layouts', $data);
    }

    // Shows register form
    public function showRegister()
    {
        ob_start();
        $this->renderView('auth/register');

        $data = [
            'title' => 'Register',
            'content' => ob_get_clean()
        ];

        $this->renderView('layouts/main-layouts/homepage.layouts', $data);
    }

    // Login handler
    public function login(string $email, string $password)
    {
        $loginUser = $this->user->getUserByEmail($email);

        if ((empty($loginUser) || !password_verify($password, $loginUser[0]['password']))) {
            // Redirect về login nếu thông tin sai
            header('Location: /' . PROJECT_NAME . '/login');
            return;
        }

        // Redirect về homepage nếu login thành công
        header('Location: /' . PROJECT_NAME);
        return;
    }

    // Register handler
    public function register()
    {
        $user_id = $this->user->createUser();
        $address_id = $this->address->createAddress();

        // Insert $user_id và $address_id vào bảng users_address
        $this->user->linkAddress($user_id, $address_id);

        // Redirect tới login nếu dăng ký thành công
        header('Location: /' . PROJECT_NAME . '/login');
        return;
    }
}