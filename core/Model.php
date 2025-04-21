<?php

namespace Core;

use PDO;
use PDOException;

abstract class Model
{
    // Connect to the database
    protected $db;

    public function __construct()
    {
        $config = require __DIR__ . '/../config/database.php';
        extract($config);

        try {
            $this->db = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8mb4", $username, $password);
            $this->db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        } catch (PDOException $e) {
            die("Database connection failed: " . $e->getMessage());
        }
    }
}