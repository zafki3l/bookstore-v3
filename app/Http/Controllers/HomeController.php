<?php

namespace App\Http\Controllers;

use Core\Controller as Controller;

class HomeController extends Controller
{
    public function index() : void
    {
        $this->view(
            'homepage',
            'layouts/main-layouts/homepage.layouts',
            'Homepage'
        );
    }
}