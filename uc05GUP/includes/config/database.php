<?php
// Archivo: includes/config/database.php

class Database {
    private $db;

    public function __construct() {
        try {
            // Conexión a SQLite
            $this->db = new PDO('sqlite:' . __DIR__ . '/database.sqlite');
            $this->db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            die("Error de conexión a la base de datos: " . $e->getMessage());
        }
    }

    // Retornar la instancia de conexión
    public function getConnection() {
        return $this->db;
    }
}
?>
