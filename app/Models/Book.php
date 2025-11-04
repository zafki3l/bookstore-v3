<?php

namespace App\Models;

use Configs\Database;
use Core\Model;
use DateTime;
use PDOException;
use Traits\ModelTrait;

class Book extends Model
{
    use ModelTrait;

    // CONSTANTS
    const STATUS_OUTSTOCK = 0;
    const STATUS_INSTOCK = 1;

    // Attributes
    private int $book_id;
    private string $name;
    private string $author;
    private string $publisher;
    private int $pages;
    private string $description;
    private float $price;
    private int $quantity;
    private int $status;
    private string $cover;
    private DateTime $created_at;
    private DateTime $updated_at;

    public function __construct(Database $db) 
    {
        parent::__construct($db);
    }

    public function getAllBook(): array
    {
        $sql = "SELECT * FROM books";

        try {
            return $this->getAll($sql);
        } catch (PDOException $e) {
            print $e->getMessage();
            return [];
        }
    }

    public function createBook(): int
    {
        try {
            return $this->insert('books', [
                'name' => $this->name,
                'author' => $this->author,
                'publisher' => $this->publisher,
                'pages' => $this->pages,
                'description' => $this->description,
                'price' => $this->price,
                'quantity' => $this->quantity,
                'cover' => $this->cover
            ]);
        } catch (PDOException $e) {
            print $e->getMessage();
            return 0;
        }
    }
}