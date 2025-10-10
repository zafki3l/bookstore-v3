<?php

class Model
{
    protected $db;

    public function __construct($db = new Database())
    {
        $this->db = $db;
    }

    public function getAll($sql)
    {
        $conn = $this->db->connect();

        $stmt = $conn->prepare($sql);
        $stmt->execute();
        
        $data = [];

        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $data[] = $row;
        }

        return $data;
    }
}
