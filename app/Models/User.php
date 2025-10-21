<?php

class User extends Model
{
    private ?int $user_id;
    private ?string $first_name;
    private ?string $last_name;
    private ?string $email;
    private ?string $gender;
    private ?string $password;
    private ?int $role;
    private ?DateTime $created_at;
    private ?DateTime $updated_at;

    public function __construct(
        Database $db = new Database(),
        ?int $user_id = null,
        ?string $first_name = null,
        ?string $last_name = null,
        ?string $email = null,
        ?string $gender = null,
        ?string $password = null,
        ?int $role = null,
        ?DateTime $created_at = null,
        ?DateTime $updated_at = null
    ) {
        parent::__construct($db);
        $this->user_id = $user_id;
        $this->first_name = $first_name;
        $this->last_name = $last_name;
        $this->email = $email;
        $this->gender = $gender;
        $this->password = $password;
        $this->role = $role;
        $this->created_at = $created_at;
        $this->updated_at = $updated_at;
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

    public function getUserByEmail($email): array
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
                'password' => password_hash($this->password, PASSWORD_DEFAULT)
            ]);
        } catch (PDOException $e) {
            print $e->getMessage();
            return 0;
        }
    }

    public function linkAddress($user_id, $address_id): int
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

    public function getUserId(): ?int
    {
        return $this->user_id;
    }

    public function getFirstName(): ?string
    {
        return $this->first_name;
    }

    public function getLastName(): ?string
    {
        return $this->last_name;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function getGender(): ?string
    {
        return $this->gender;
    }

    public function getPassword(): ?string
    {
        return $this->password;
    }

    public function getRole(): ?int
    {
        return $this->role;
    }

    public function getCreatedAt(): ?DateTime
    {
        return $this->created_at;
    }

    public function getUpdatedAt(): ?DateTime
    {
        return $this->updated_at;
    }

    public function setUserId(?int $user_id): void
    {
        $this->user_id = $user_id;
    }

    public function setFirstName(?string $first_name): void
    {
        $this->first_name = $first_name;
    }

    public function setLastName(?string $last_name): void
    {
        $this->last_name = $last_name;
    }

    public function setEmail(?string $email): void
    {
        $this->email = $email;
    }

    public function setGender(?string $gender): void
    {
        $this->gender = $gender;
    }

    public function setPassword(?string $password): void
    {
        $this->password = $password;
    }

    public function setRole(?int $role): void
    {
        $this->role = $role;
    }

    public function setCreatedAt(?DateTime $created_at): void
    {
        $this->created_at = $created_at;
    }

    public function setUpdatedAt(?DateTime $updated_at): void
    {
        $this->updated_at = $updated_at;
    }
}
