<?php

namespace App\Search;

use App\Database\Connection;

class SearchService
{
    private $db;

    public function __construct()
    {
        $this->db = Connection::getInstance()->getConnection();
    }

    public function search($query, $tables)
    {
        $results = [];

        foreach ($tables as $table => $searchableFields) {
            $sql = "SELECT * FROM $table WHERE ";
            $conditions = [];
            $params = [];

            foreach ($searchableFields as $field) {
                $conditions[] = "$field LIKE ?";
                $params[] = "%$query%";
            }

            $sql .= implode(" OR ", $conditions);

            $stmt = $this->db->prepare($sql);
            $stmt->execute($params);

            $results[$table] = $stmt->fetchAll(\PDO::FETCH_ASSOC);
        }

        return $results;
    }
}
