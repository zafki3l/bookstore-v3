<?php

namespace App\Http\Controllers;

use App\Http\Middlewares\EnsureStaff;
use App\Http\Requests\BookRequest;
use App\Models\Book;
use Core\Controller;
use Traits\HttpResponseTrait;

class BookController extends Controller
{
    use HttpResponseTrait;

    public function __construct(
        private EnsureStaff $ensureStaff,
        private Book $book
    ) {
        $this->ensureStaff->handle();
    }

    public function index(): mixed
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

    public function create(): mixed
    {
        return $this->view(
            'staff/books/addBook',
            'staff.layouts',
            ['title' => 'Add new book']
        );
    }

    public function store(BookRequest $bookRequest = new BookRequest())
    {
        $request = $bookRequest->addBookRequest();
        
        $this->book->fill($request);

        $this->book->cover = 'No image';

        $this->book->createBook();

        $this->redirect('/staff/books');
    }
}