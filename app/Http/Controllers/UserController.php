<?php

namespace App\Http\Controllers;

use App\Models\User;

class UserController
{
    public function __construct(private User $user)
    {
    }

    public function getAll()
    {
        $users = $this->user->getAllUser();

        return $users;
    }
}