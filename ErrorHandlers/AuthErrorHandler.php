<?php

namespace ErrorHandlers;

class AuthErrorHandler
{
    // Check is email exist
    public function isEmailExist($email, $user) : bool
    {
        $result = $user->getUserByEmail($email);

        return !empty($result); 
    }

    // Check email is invalid
    public function isEmailInvalid($email) : bool 
    {
        return !filter_var($email, FILTER_VALIDATE_EMAIL); 
    }

    // Check password is correct
    public function isPasswordCorrect($db_password, $user_input)
    {
        return password_verify($user_input, $db_password);
    }

    // Check password is not mismatch
    public function passwordMisMatch($password, $password_confirmation) : bool
    {
        return $password !== $password_confirmation;
    }

    // Check empty first name
    public function emptyFirstName($first_name) : bool
    {
        return empty($first_name); 
    }

    // Check empty last name
    public function emptyLastName($last_name) : bool
    {
        return empty($last_name);
    }

    // Check empty email
    public function emptyEmail($email) : bool
    {
        return empty($email); 
    }

    //Check empty gender
    public function emptyGender($gender) : bool
    {
        return empty($gender);
    }

    // Check empty password
    public function emptyPassword($password) : bool
    {
        return empty($password);
    }

    // Check is password confirm
    public function isPasswordConfirm($password_confirmation) : bool
    {
        return empty($password_confirmation);
    }
}