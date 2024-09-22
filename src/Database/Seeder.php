<?php

namespace App\Database;

use PDO;

abstract class Seeder
{
    protected $db;

    public function __construct(PDO $db)
    {
        $this->db = $db;
    }

    abstract public function run();
}
