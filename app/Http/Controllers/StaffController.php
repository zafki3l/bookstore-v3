<?php

namespace App\Http\Controllers;

use App\Http\Middlewares\EnsureStaff;
use Core\Controller;

/**
 * Class StaffController
 * Handles Book Management, Order and other Staff logics
 */
class StaffController extends Controller
{
    public function __construct(EnsureStaff $ensureStaff)
    {
        $ensureStaff->handle();
    }
    /**
     * Shows staff dashboard view
     * @return mixed
     */
    public function dashboard(): mixed
    {
        return $this->view(
            'staff/dashboard', 
            'staff.layouts',
            ['title' => 'Staff Dashboard']
        );
    }
}