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

    public function __construct(
        private EnsureAdmin $ensureAdmin,
        private User $user,
    ) {
        $this->ensureAdmin->handle();
    }

    /**
     * Shows admin dashboard view
     * @return mixed
     */
    public function index(): mixed
    {
        $user = $this->user;

        $isSearching = isset($_GET['search']);
        $search = $isSearching ? $_GET['search'] : null;

        $current_page = isset($_GET['page']) ? (int) $_GET['page'] : 1;

        $total_records = $isSearching ? $user->countSearchUser($search) : $user->countUser();

        $pagination = Paginator::paginate($total_records, Paginator::DEFAULT_RESULT_PER_PAGE, $current_page); // Calculate the total pages and the start page

        $users = $isSearching ? $user->searchUser($search, $pagination['start_from'], Paginator::DEFAULT_RESULT_PER_PAGE) : $user->getAllUser($pagination['start_from'], Paginator::DEFAULT_RESULT_PER_PAGE);

        return $this->view(
            'admin/dashboard',
            'layouts/main-layouts/admin.layouts',
            'Admin Dashboard',
            [
                'users' => $users,
                'current_page' => $current_page,
                'total_pages' => $pagination['total_pages'],
                'result_per_page' => Paginator::DEFAULT_RESULT_PER_PAGE
            ]
        );
    }
}
