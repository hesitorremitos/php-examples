<?php
require_once 'config/database.php';

class PersonaModel {
    private $pdo;

    public function __construct() {
        try {
            $this->pdo = new PDO("mysql:host=" . DatabaseConfig::$host . ";port=" . DatabaseConfig::$port . ";dbname=" . DatabaseConfig::$dbname . ";charset=utf8mb4", DatabaseConfig::$user, DatabaseConfig::$password);
            $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            die("Error al conectar a la base de datos: " . $e->getMessage());
        }
    }

    public function guardarPersona($nombre, $ci, $email, $fecha_nac) {
        try {
            $stmt = $this->pdo->prepare("INSERT INTO personas (nombre, ci, email, fecha_nac) VALUES (:nombre, :ci, :email, :fecha_nac)");
            $stmt->bindParam(':nombre', $nombre);
            $stmt->bindParam(':ci', $ci);
            $stmt->bindParam(':email', $email);
            $stmt->bindParam(':fecha_nac', $fecha_nac);
            return $stmt->execute();
        } catch (PDOException $e) {
            throw new Exception("Error al guardar la persona: " . $e->getMessage());
        }
    }
}
?>