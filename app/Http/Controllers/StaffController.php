<?php

namespace App\Http\Controllers;

use Core\Controller;

class StaffController extends Controller
{
    /**
     * Shows staff dashboard view
     * @return void
     */
    public function index()
    {
        $this->view(
            'staff/dashboard', 
            'layouts/main-layouts/staff.layouts',
            'Staff Dashboard'
        );
    }
}