<?php

namespace App\Models;

use Core\Model;
use Configs\Database;
use PDOException;
use DateTime;
use Traits\ModelTrait;

class User extends Model
{
    use ModelTrait;

    //Constants
    const ROLE_GUEST = 0;
    const ROLE_USER = 1;
    const ROLE_STAFF = 2;
    const ROLE_ADMIN = 3;
    
    // Attributes
    private int $user_id;
    private string $first_name;
    private string $last_name;
    private string $email;
    private string $gender;
    private string $password;
    private int $role;
    private DateTime $created_at;
    private DateTime $updated_at;

    // Constructor
    public function __construct(Database $db) 
    {
        parent::__construct($db);
    }

    public function getAllUser(): array
    {
        $sql = "SELECT *
                FROM users_address ua
                JOIN users u ON ua.user_id = u.id
                JOIN address a ON ua.address_id = a.id";

        try {
            return $this->getAll($sql);
        } catch (PDOException $e) {
            print $e->getMessage();
            return [];
        }
    }

    public function getUserByEmail(string $email): array
    {
        $params = [$email];
        $sql = "SELECT u.id as 'user_id',
                        a.id as 'address_id',
                        u.first_name as 'first_name',
                        u.last_name as 'last_name',
                        u.email as 'email',
                        u.gender as 'gender',
                        a.street as 'street',
                        a.city as 'city',
                        u.password as 'password',
                        u.role as 'role'
                FROM users_address ua
                JOIN users u ON ua.user_id = u.id
                JOIN address a ON ua.address_id = a.id
                WHERE email = ?";

        try {
            return $this->getByParams($params, $sql);
        } catch (PDOException $e) {
            print $e->getMessage();
            return [];
        }
    }

    public function createUser(): int
    {
        try {
            return $this->insert('users', [
                'first_name' => $this->first_name,
                'last_name' => $this->last_name,
                'email' => $this->email,
                'gender' => $this->gender,
                'password' => password_hash($this->password, PASSWORD_DEFAULT),
                'role' => $this->role
            ]);
        } catch (PDOException $e) {
            print $e->getMessage();
            return 0;
        }
    }

    public function linkAddress(int $user_id, int $address_id): int
    {
        try {
            return $this->insert('users_address', [
                'user_id' => $user_id,
                'address_id' => $address_id
            ]);
        } catch (PDOException $e) {
            print $e->getMessage();
            return 0;
        }
    }
}
