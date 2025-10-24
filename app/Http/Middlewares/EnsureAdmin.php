<?php

namespace App\Http\Middlewares;

use App\Models\User;
use Core\Middleware;
use Traits\HttpResponseTrait;

class EnsureAdmin
{
    use HttpResponseTrait;

    public function handle()
    {
        if (!Middleware::ensureAuth()) {
            $this->redirect('/login');
        }
        
        if ($_SESSION['user']['role'] !== User::ROLE_ADMIN) {
            http_response_code(403);
            die("403 Forbidden Error! You don't have permission to visit this site!");
        }
    }
}