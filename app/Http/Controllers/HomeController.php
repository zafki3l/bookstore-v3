<?php

namespace App\Http\Controllers;

use Core\Controller as Controller;

/**
 * Class HomeController
 * Handles Homepage logics
 */
class HomeController extends Controller
{
    public function index() : mixed
    {
        return $this->view(
            'homepage',
            'layouts/main-layouts/homepage.layouts',
            'Homepage'
        );
    }
}