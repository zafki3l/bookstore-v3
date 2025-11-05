<?php

namespace App\Http\Requests;

use App\Models\Book;

/**
 * Class BookRequest
 * Get requests related to books
 */
class BookRequest
{
    public function addBookRequest(): array
    {
        return [
            'name' => trim($_POST['name']),
            'author' => trim($_POST['author']),
            'publisher' => trim($_POST['publisher']),
            'pages' => (int) trim($_POST['pages']) ?? 0,
            'description' => trim($_POST['description']),
            'price' => (float) trim($_POST['price']) ?? 0,
            'quantity' => (int) trim($_POST['quantity']) ?? 0,
            'status' => (int) ($_POST['quantity'] > 0) ? Book::STATUS_INSTOCK : Book::STATUS_OUTSTOCK,
        ];
    }
}   
