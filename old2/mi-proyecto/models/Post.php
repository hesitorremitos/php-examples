<?php
// models/Post.php

class Post {
    private $conn;

    public function __construct() {
        // Utiliza la inyección de dependencias o una configuración global si está disponible
        global $db; // O utiliza la inyección de dependencias
        if ($db) {
            $this->conn = $db;
        } else {
            $this->conn = new PDO("mysql:host=localhost;dbname=blog_mvc;charset=utf8", "root", "");
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        }
    }

    public function getPostsByUserId($userId) {
        try {
            $sql = "SELECT * FROM posts WHERE user_id = :userId ORDER BY created_at DESC";
            $stmt = $this->conn->prepare($sql);
            $stmt->bindParam(":userId", $userId, PDO::PARAM_INT);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log("Database Error: " . $e->getMessage());
            return false; // Importante: retornar false en caso de error
        }
    }

    public function createPost($title, $content, $userId) {
        try {
            $sql = "INSERT INTO posts (title, content, user_id, created_at, updated_at) VALUES (:title, :content, :userId, NOW(), NOW())";
            $stmt = $this->conn->prepare($sql);
            $stmt->bindParam(":title", $title, PDO::PARAM_STR);
            $stmt->bindParam(":content", $content, PDO::PARAM_STR);
            $stmt->bindParam(":userId", $userId, PDO::PARAM_INT);
            $stmt->execute();
            return true;
        } catch (PDOException $e) {
            error_log("Database Error: " . $e->getMessage());
            return false;
        }
    }

      public function getAllPosts() {
        try {
            $sql = "SELECT * FROM posts ORDER BY created_at DESC";
            $stmt = $this->conn->prepare($sql);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log("Database Error: " . $e->getMessage());
            return [];
        }
    }

    public function getPostById($postId) {
         try {
            $sql = "SELECT * FROM posts WHERE id = :postId";
            $stmt = $this->conn->prepare($sql);
            $stmt->bindParam(":postId", $postId, PDO::PARAM_INT);
            $stmt->execute();
            return $stmt->fetch(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
             error_log("Database Error: " . $e->getMessage());
            return null;
        }
    }
}
?>