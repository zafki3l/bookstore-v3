<?php

namespace App\Controllers;

use Core\Controller as Controller;

class HomeController extends Controller
{
    public function index()
    {
        ob_start();
        $this->renderView('homepage');

        $data = [
            'title' => 'Homepage',
            'content' => ob_get_clean()
        ];

        $this->renderView('layouts/main-layouts/homepage.layouts', $data);
    }
}