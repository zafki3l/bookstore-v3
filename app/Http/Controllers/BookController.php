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
        private Book $book
    ) {}

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

    public function store(BookRequest $bookRequest = new BookRequest()): void
    {
        $request = $bookRequest->addBookRequest();
        
        $this->book->fill($request);

        $this->book->cover = $this->uploadFile();

        $this->book->createBook();

        $this->redirect('/staff/books');
    }

    private function uploadFile(): string
    {
        if (!isset($_FILES['cover']) || $_FILES['cover']['error'] === UPLOAD_ERR_NO_FILE) {
            return 'no Image';
        }

        if ($_FILES['cover']['error'] !== UPLOAD_ERR_OK) {
            exit('There is something wrong');
        }

        $file_name = $_FILES['cover']['name'];

        $file_separator = explode('.', $file_name);
        $file_extension = strtolower(end($file_separator));

        if (!in_array($file_extension, $this->allowedFile())) {
            exit('Not allowed files');
        }

        if ($_FILES['cover']['size'] >= 10_000_000) {
            exit('File too big (Limit: 10 MB)');
        }

        $newFileName = uniqid('', true) . '.' . $file_extension;

        $fileDestination = __DIR__ . '/../../../public/images/books/' . $newFileName;
        move_uploaded_file($_FILES['cover']['tmp_name'], $fileDestination);

        return $newFileName;
    }

    private function allowedFile(): array
    {
        return ['jpg', 'jpeg', 'png', 'webp'];
    }
}