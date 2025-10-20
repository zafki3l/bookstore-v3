<?php

class AuthErrorHandler
{
    public function isEmailExist($email) : bool
    {
        $user = new User();
        $result = $user->getUserByEmail($email);

        /**
         * If result is not empty then redirect back to register form with error
         */
        if (!empty($result)) {
            return true;
        } else {
            return false;
        }
    }

    public function emailValidate($email) : bool 
    {
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            return true;
        } else {
            return false;
        }
    }

    public function passwordMisMatch($password, $password_confirmation) : bool
    {
        if ($password !== $password_confirmation) {
            return true;
        } else {
            return false;
        }
    }

    public function emptyFirstName($first_name) : bool
    {
        if (empty($first_name)) {
            return true;
        } else {
            return false;
        }
    }

    public function emptyLastName($last_name) : bool
    {
        if (empty($last_name)) {
            return true;
        } else {
            return false;
        }
    }

    public function emptyEmail($email) : bool
    {
        if (empty($email)) {
            return true;
        } else {
            return false;
        }
    }

    public function emptyGender($gender) : bool
    {
        if (empty($gender)) {
            return true;
        } else {
            return false;
        }
    }

    public function emptyPassword($password) : bool
    {
        if (empty($password)) {
            return true;
        } else {
            return false;
        }
    }

    public function isPasswordConfirm($password_confirmation) : bool
    {
        if (empty($password_confirmation)) {
            return true;
        } else {
            return false;
        }
    }
}