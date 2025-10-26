<?php

namespace App\Http\Requests;

class AdminRequest
{
    public function addUserRequest() : array
    {
        return [
            'first_name' => trim($_POST['first_name']) ?? '',
            'last_name' => trim($_POST['last_name']) ?? '',
            'email' => trim($_POST['email']) ?? '',
            'gender' => trim($_POST['gender']) ?? '',
            'street' => trim($_POST['street']) ?? '',
            'city' => trim($_POST['city']) ?? '',
            'password' => trim($_POST['password']) ?? '',
            'role' => trim($_POST['role']) ?? 1
        ];
    }
}