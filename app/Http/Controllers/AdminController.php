<?php

namespace App\Http\Controllers;

use App\Http\Middlewares\EnsureAdmin;
use App\Models\User;
use Core\Controller;
use Core\Paginator;
use Traits\HttpResponseTrait;

/**
 * Class Admin Controller
 */
class AdminController extends Controller
{
    use HttpResponseTrait;

    // Constructor
    public function __construct(
        private EnsureAdmin $ensureAdmin,
        private User $user,
    ) {
        $this->ensureAdmin->handle();
    }

    /**
     * Shows admin dashboard view
     * @return void
     */
    public function index() : void
    {
        $user = $this->user;

        $search = $_GET['search'] ?? null;

        $result_per_page = Paginator::DEFAULT_RESULT_PER_PAGE;

        // Get the current page
        $page = isset($_GET['page']) ? (int) $_GET['page'] : 1;

        // Get the total of records
        $total_results = $search ? $user->countSearchUser($search) : $user->countUser();

        // Calculate pagination
        $pagination = Paginator::paginate($total_results, $result_per_page, $page);

        // Get the user list
        $users = $search ? $user->searchUser($search, $pagination['start_from'], $result_per_page) : $user->getAllUser($pagination['start_from'], $result_per_page);

        $this->view(
            'admin/dashboard', 
            'layouts/main-layouts/admin.layouts',
            'Admin Dashboard',
            [
                'users' => $users,
                'page' => $page,
                'total_pages' => $pagination['total_pages'],
                'result_per_page' => $result_per_page
            ]
        );
    }
}