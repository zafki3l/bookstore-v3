<?php

namespace Core;

use Configs\Database;
use PDO;
use PDOStatement;

abstract class Model
{
    protected function __construct(protected Database $db) {}

    protected function getAll(string $sql): array
    {
        $stmt = $this->executeQuery($sql);

        $data = $this->fetchAll($stmt);

        $stmt = null;

        return $data;
    }

    protected function getByParams(array $params, string $sql): array
    {
        $stmt = $this->executeQuery($sql, $params);

        $data = $this->fetchAll($stmt);

        $stmt = null;

        return $data;
    }

    protected function insert(string $table, array $data): int
    {
        $columns = implode(', ', array_keys($data));
        $placeholders = implode(', ', array_fill(0, count($data), '?'));

        $sql = "INSERT INTO {$table} ({$columns}) VALUES ({$placeholders})";

        $conn = $this->db->connect();
        $stmt = $conn->prepare($sql);
        $stmt->execute(array_values($data));

        $id = $conn->lastInsertId();

        $stmt = null;

        return $id;
    }

    private function executeQuery(string $sql, array $params = []): PDOStatement
    {
        $conn = $this->db->connect();

        $stmt = $conn->prepare($sql);
        $stmt->execute($params);

        return $stmt;
    }

    private function fetchAll(PDOStatement $stmt) : array
    {
        $data = [];

        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $data[] = $row;
        }

        return $data;
    }
}
