<?php

namespace App\Database\Migrations;

use App\Database\Migration;

class CreateUsersTable extends Migration
{
    public function up()
    {
        $sql = "CREATE TABLE IF NOT EXISTS usuarios (
            id INT AUTO_INCREMENT PRIMARY KEY,
            nombre VARCHAR(100) NOT NULL,
            email VARCHAR(100) NOT NULL UNIQUE,
            contraseña VARCHAR(255) NOT NULL,
            role_id INT,
            sub_empresa_id INT,
            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
            updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
        )";

        $this->db->exec($sql);
    }

    public function down()
    {
        $sql = "DROP TABLE IF EXISTS usuarios";
        $this->db->exec($sql);
    }
}
