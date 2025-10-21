<?php

class AuthErrorHandler
{
    // Check is email exist
    public function isEmailExist($email) : bool
    {
        $user = new User();
        $result = $user->getUserByEmail($email);

        if (!empty($result)) {
            return true;
        } else {
            return false;
        }
    }

    // Check email is valid
    public function emailValidate($email) : bool 
    {
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            return true;
        } else {
            return false;
        }
    }

    // Check password is correct
    public function isPasswordCorrect($db_password, $user_input)
    {
        if (password_verify($user_input, $db_password)) {
            return true;
        } else {
            return false;
        }
    }

    // Check password is not mismatch
    public function passwordMisMatch($password, $password_confirmation) : bool
    {
        if ($password !== $password_confirmation) {
            return true;
        } else {
            return false;
        }
    }

    // Check empty first name
    public function emptyFirstName($first_name) : bool
    {
        if (empty($first_name)) {
            return true;
        } else {
            return false;
        }
    }

    // Check empty last name
    public function emptyLastName($last_name) : bool
    {
        if (empty($last_name)) {
            return true;
        } else {
            return false;
        }
    }

    // Check empty email
    public function emptyEmail($email) : bool
    {
        if (empty($email)) {
            return true;
        } else {
            return false;
        }
    }

    //Check empty gender
    public function emptyGender($gender) : bool
    {
        if (empty($gender)) {
            return true;
        } else {
            return false;
        }
    }

    // Check empty password
    public function emptyPassword($password) : bool
    {
        if (empty($password)) {
            return true;
        } else {
            return false;
        }
    }

    // Check is password confirm
    public function isPasswordConfirm($password_confirmation) : bool
    {
        if (empty($password_confirmation)) {
            return true;
        } else {
            return false;
        }
    }
}