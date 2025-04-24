<?php
require_once __DIR__ . '/../config/database.php';

class Post {
    private $conn;
    private $table = 'posts';

    public $id;
    public $title;
    public $content;
    public $created_at;
    public $updated_at;
    public $user_id;

    public function __construct() {
        $database = new Database();
        $this->conn = $database->connect();
    }

    // Crear una publicación
    public function create() {
        $query = "INSERT INTO $this->table (title, content, user_id) VALUES (:title, :content, :user_id)";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':title', $this->title);
        $stmt->bindParam(':content', $this->content);
        $stmt->bindParam(':user_id', $this->user_id);
        return $stmt->execute();
    }

    // Listar publicaciones por usuario
    public function getByUser($user_id) {
        $query = "SELECT * FROM $this->table WHERE user_id = :user_id ORDER BY created_at DESC";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':user_id', $user_id);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Listar todas las publicaciones
    public function getAll() {
        $query = "SELECT p.*, u.username FROM $this->table p JOIN users u ON p.user_id = u.id ORDER BY p.created_at DESC";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
?>