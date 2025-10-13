<?php

abstract class Model
{
    protected Database $db;

    public function __construct(Database $db = new Database())
    {
        $this->db = $db;
    }

    public function getAll(string $sql)
    {
        $conn = $this->db->connect();

        $stmt = $conn->prepare($sql);
        $stmt->execute();
        
        $data = [];

        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $data[] = $row;
        }

        $stmt = null;
        $conn = null;

        return $data;
    }

    public function getByParams(array $params, string $sql)
    {
        $conn = $this->db->connect();

        $stmt = $conn->prepare($sql);

        $stmt->execute($params);

        $data = [];

        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $data[] = $row;
        }

        $stmt = null;
        $conn = null;

        return $data;
    }

    public function insert(string $table, array $data) : int
    {
        $conn = $this->db->connect();

        $column = implode(', ', array_keys($data)); // column1, column2, column3
        $placeholders = implode(', ', array_fill(0, count(array_keys($data)), '?')); // ?, ?, ?

        $sql = "INSERT INTO " . $table . "({$column}) VALUES ({$placeholders})";

        $stmt = $conn->prepare($sql);

        $stmt->execute(array_values($data));

        $id = $conn->lastInsertId();

        $stmt = null;
        $conn = null;

        return $id;
    }
}
