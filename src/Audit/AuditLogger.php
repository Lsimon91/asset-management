<?php

namespace App\Audit;

use App\Database\Connection;

class AuditLogger
{
    private $db;

    public function __construct()
    {
        $this->db = Connection::getInstance()->getConnection();
    }

    public function log($userId, $action, $details)
    {
        $stmt = $this->db->prepare("INSERT INTO audit_logs (user_id, action, details, created_at) VALUES (?, ?, ?, NOW())");
        $stmt->execute([$userId, $action, json_encode($details)]);
    }

    public function getAuditLogs($filters = [])
    {
        $sql = "SELECT * FROM audit_logs";
        $where = [];
        $params = [];

        if (isset($filters['user_id'])) {
            $where[] = "user_id = ?";
            $params[] = $filters['user_id'];
        }

        if (isset($filters['action'])) {
            $where[] = "action = ?";
            $params[] = $filters['action'];
        }

        if (isset($filters['from_date'])) {
            $where[] = "created_at >= ?";
            $params[] = $filters['from_date'];
        }

        if (isset($filters['to_date'])) {
            $where[] = "created_at <= ?";
            $params[] = $filters['to_date'];
        }

        if (!empty($where)) {
            $sql .= " WHERE " . implode(" AND ", $where);
        }

        $sql .= " ORDER BY created_at DESC";

        $stmt = $this->db->prepare($sql);
        $stmt->execute($params);

        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }
}
