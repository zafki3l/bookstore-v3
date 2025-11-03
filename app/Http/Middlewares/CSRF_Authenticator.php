<?php

namespace App\Http\Middlewares;

class CSRF_Authenticator
{

    public function verify()
    {
        if (!isset($_SESSION['CSRF-token'], $_POST['CSRF-token'])) {
            exit('Missing CSRF token');
        }

        $sessionToken = (string) $_SESSION['CSRF-token'];
        $formToken    = (string) $_POST['CSRF-token'];

        if (!hash_equals($sessionToken, $formToken)) {
            exit('405 error!');
        }

        if (time() >= $_SESSION['token-expire']) {
            exit('token expired');
        }

        unset($_SESSION['CSRF-token'], $_SESSION['token-expire']);
    }
}
