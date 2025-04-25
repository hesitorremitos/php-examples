<?php
// models/User.php
require_once __DIR__ . '/../config/database.php';
require_once 'config/log_config.php'; // Incluye la configuración del log

class User {
    private $conn;

    public function __construct() {
        try {
            logMessage('DEBUG', "User::__construct: Inicio.");
            $database = new Database();
            $this->conn = $database->getConnection();
            if (!$this->conn) {
                logMessage('ERROR', "User::__construct: No se pudo establecer la conexión a la base de datos.");
                die("No se pudo establecer la conexión a la base de datos.");
            }
             logMessage('DEBUG', "User::__construct: Conexión a la base de datos establecida.");
             logMessage('DEBUG', "User::__construct: Fin.");
        } catch (Exception $e) {
             logMessage('ERROR', "User::__construct: Excepción capturada: " . $e->getMessage());
             throw $e;
        }
    }

    public function getAll() {
        try {
            logMessage('DEBUG', "User::getAll: Inicio.");
            $sql = "SELECT * FROM users";
            $stmt = $this->conn->prepare($sql);
            $stmt->execute();
            $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
            logMessage('DEBUG', "User::getAll: Consulta ejecutada.");
             logMessage('DEBUG', "User::getAll: Fin.");
            return $result;
        } catch (PDOException $e) {
            logMessage('ERROR', "User::getAll: Error de la base de datos: " . $e->getMessage());
            return false;
        }
    }

    public function getUserById($userId) {
        try {
            logMessage('DEBUG', "User::getUserById: Inicio. userId = $userId");
            $sql = "SELECT * FROM users WHERE id = :userId";
            $stmt = $this->conn->prepare($sql);
            $stmt->bindParam(":userId", $userId, PDO::PARAM_INT);
            $stmt->execute();
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            logMessage('DEBUG', "User::getUserById: Consulta ejecutada.");
            if (!$result) {
                logMessage('WARNING', "User::getUserById: Usuario no encontrado.");
                return false;
            }
            logMessage('DEBUG', "User::getUserById: Fin.");
            return $result;
        } catch (PDOException $e) {
            logMessage('ERROR', "User::getUserById: Error de la base de datos: " . $e->getMessage());
            return false;
        }
    }
}

?>