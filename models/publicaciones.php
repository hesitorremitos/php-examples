<?php
// models/publicaciones.php
class Publicaciones extends Database {
    private $db;

    public function __construct() {
        $this->db = $this->getConnection();
    }

    public function obtenerPublicacionesPorUsuario($userId) {
        $stmt = $this->db->prepare("SELECT * FROM publicaciones WHERE user_id = :user_id");
        $stmt->bindParam(':user_id', $userId, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function crearPublicacion($userId, $title, $content) {
        $stmt = $this->db->prepare("INSERT INTO publicaciones (user_id, title, content) VALUES (:user_id, :title, :content)");
        $stmt->bindParam(':user_id', $userId, PDO::PARAM_INT);
        $stmt->bindParam(':title', $title);
        $stmt->bindParam(':content', $content);
        return $stmt->execute();
    }
}