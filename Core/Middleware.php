<?php

namespace Core;

use Traits\HttpResponseTrait;

class Middleware
{
    public static function ensureAuth() : bool
    {
        return isset($_SESSION['user']) ? true : false;
    }
}