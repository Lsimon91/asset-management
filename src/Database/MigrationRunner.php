<?php

namespace App\Database;

use PDO;

class MigrationRunner
{
    private $db;
    private $migrations = [];

    public function __construct(PDO $db)
    {
        $this->db = $db;
    }

    public function addMigration(Migration $migration)
    {
        $this->migrations[] = $migration;
    }

    public function runMigrations()
    {
        foreach ($this->migrations as $migration) {
            $migration->up();
        }
    }

    public function rollbackMigrations()
    {
        foreach (array_reverse($this->migrations) as $migration) {
            $migration->down();
        }
    }
}
