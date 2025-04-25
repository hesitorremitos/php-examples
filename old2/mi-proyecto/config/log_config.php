<?php
// models/Post.php
require_once 'config/log_config.php'; // Incluye la configuración del log

class Post {
    private $conn;

    public function __construct() {
        try {
            logMessage('DEBUG', "Post::__construct: Inicio.");
            // Utiliza la inyección de dependencias o una configuración global si está disponible
            global $db; // O utiliza la inyección de dependencias
            if ($db) {
                $this->conn = $db;
            } else {
                $this->conn = new PDO("mysql:host=localhost;dbname=blog_mvc;charset=utf8", "root", "");
                $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            }
             logMessage('DEBUG', "Post::__construct: Conexión a la base de datos establecida.");
            logMessage('DEBUG', "Post::__construct: Fin.");
        } catch (PDOException $e) {
            logMessage('ERROR', "Post::__construct: Error de conexión: " . $e->getMessage());
            throw $e; // Re-lanza la excepción para que se capture en el controlador
        }
    }

    public function getPostsByUserId($userId) {
        try {
            logMessage('DEBUG', "Post::getPostsByUserId: Inicio. userId = $userId");
            $sql = "SELECT * FROM posts WHERE user_id = :userId ORDER BY created_at DESC";
            $stmt = $this->conn->prepare($sql);
            $stmt->bindParam(":userId", $userId, PDO::PARAM_INT);
            $stmt->execute();
            $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
            logMessage('DEBUG', "Post::getPostsByUserId: Consulta ejecutada.");
            logMessage('DEBUG', "Post::getPostsByUserId: Fin.");
            return $result;
        } catch (PDOException $e) {
            logMessage('ERROR', "Post::getPostsByUserId: Error de la base de datos: " . $e->getMessage());
            return false;
        }
    }

    public function createPost($title, $content, $userId) {
        try {
            logMessage('DEBUG', "Post::createPost: Inicio. title = $title, content = $content, userId = $userId");
            $sql = "INSERT INTO posts (title, content, user_id, created_at, updated_at) VALUES (:title, :content, :userId, NOW(), NOW())";
            $stmt = $this->conn->prepare($sql);
            $stmt->bindParam(":title", $title, PDO::PARAM_STR);
            $stmt->bindParam(":content", $content, PDO::PARAM_STR);
            $stmt->bindParam(":userId", $userId, PDO::PARAM_INT);
            $stmt->execute();
            $result = $stmt->rowCount() > 0;
            logMessage('DEBUG', "Post::createPost: Consulta ejecutada. Resultado: " . ($result ? 'Éxito' : 'Fallo'));
             logMessage('DEBUG', "Post::createPost: Fin.");
            return $result;
        } catch (PDOException $e) {
            logMessage('ERROR', "Post::createPost: Error de la base de datos: " . $e->getMessage());
            return false;
        }
    }

    public function getAllPosts() {
        try {
             logMessage('DEBUG', "Post::getAllPosts: Inicio.");
            $sql = "SELECT * FROM posts ORDER BY created_at DESC";
            $stmt = $this->conn->prepare($sql);
            $stmt->execute();
            $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
             logMessage('DEBUG', "Post::getAllPosts: Consulta ejecutada.");
             logMessage('DEBUG', "Post::getAllPosts: Fin.");
            return $result;
        } catch (PDOException $e) {
            logMessage('ERROR', "Post::getAllPosts: Error de la base de datos: " . $e->getMessage());
            return [];
        }
    }

    public function getPostById($postId) {
        try {
             logMessage('DEBUG', "Post::getPostById: Inicio. postId = $postId");
            $sql = "SELECT * FROM posts WHERE id = :postId";
            $stmt = $this->conn->prepare($sql);
            $stmt->bindParam(":postId", $postId, PDO::PARAM_INT);
            $stmt->execute();
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
             logMessage('DEBUG', "Post::getPostById: Consulta ejecutada.");
             logMessage('DEBUG', "Post::getPostById: Fin.");
            return $result;
        } catch (PDOException $e) {
            logMessage('ERROR', "Post::getPostById: Error de la base de datos: " . $e->getMessage());
            return null;
        }
    }
}
?>