<?php
// db/db.php

class Database {
    private $host = 'localhost';
    private $port = 3306;
    private $dbname = 'librosdb';
    private $username = 'root1'; // Cambia esto según tu configuración
    private $password = ''; // Cambia esto según tu configuración
    private $conn;

    /**
     * Establece la conexión a la base de datos usando PDO.
     * @return PDO|null La conexión PDO o null en caso de error.
     */
    public function getConnection() {
        if ($this->conn) {
            return $this->conn;
        }

        try {
            $dsn = "mysql:host={$this->host};port={$this->port};dbname={$this->dbname};charset=utf8mb4";
            $this->conn = new PDO($dsn, $this->username, $this->password, [
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                PDO::ATTR_EMULATE_PREPARES => false,
            ]);
            return $this->conn;
        } catch (PDOException $e) {
            error_log("Error de conexión a la base de datos: " . $e->getMessage());
            echo "Error de conexion: ".$e->getMessage();
            exit;
        }
    }

    /**
     * Cierra la conexión a la base de datos.
     */
    public function closeConnection() {
        $this->conn = null;
    }
}