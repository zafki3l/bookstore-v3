<?php

namespace App\Http\Controllers;

use App\Http\Middlewares\EnsureStaff;
use App\Models\Book;
use Core\Controller;

class BookController extends Controller
{
    public function __construct(
        private EnsureStaff $ensureStaff,
        private Book $book
    ) {
        $this->ensureStaff->handle();
    }

    public function index()
    {
        $books = $this->book->getAllBook();

        return $this->view(
            'staff/books/index', 
            'staff.layouts',
            [
                'title' => 'Books Management',
                'books' => $books
            ]
        );
    }
}