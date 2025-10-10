<?php

class User extends Model
{
    public function __construct($db = new Database())
    {
        parent::__construct($db);
    }
	
    public function getAllUser()
    {
        $sql = "SELECT *
                FROM users_address ua
                JOIN users u ON ua.user_id = u.id
                JOIN address a ON ua.address_id = a.id";
        
        try {
            return $this->getAll($sql);
        } catch (PDOException $e) {
            print $e->getMessage();
        }
    }
}