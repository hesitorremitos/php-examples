<?php

namespace MiProyecto\Models;

use MiProyecto\Db\Database;

class Post
{
    private Database $db;

    public function __construct()
    {
        $this->db = new Database('localhost', 'dbnew☀️', 'root', '', '3308');
    }

    public function registrarPublicacion(string $title, string $content, int $userId): bool
    {
        $pdo = $this->db->conectar();
        if ($pdo) {
            $sql = "INSERT INTO posts (title, content, user_id) VALUES (:title, :content, :user_id)";
            $stmt = $this->db->ejecutarConsulta($sql, [
                ':title' => $title,
                ':content' => $content,
                ':user_id' => $userId,
            ]);
            $this->db->desconectar();
            return $stmt !== null && $stmt->rowCount() > 0;
        }
        return false;
    }

    public function obtenerPublicacionesPorUsuario(int $userId): array
    {
        $pdo = $this->db->conectar();
        if ($pdo) {
            $sql = "SELECT * FROM posts WHERE user_id = :user_id ORDER BY created_at DESC";
            $publicaciones = $this->db->obtenerResultados($sql, [':user_id' => $userId]);
            $this->db->desconectar();
            return $publicaciones;
        }
        return [];
    }

    public function obtenerTodasLasPublicaciones(): array
    {
        $pdo = $this->db->conectar();
        if ($pdo) {
            $publicaciones = $this->db->obtenerResultados("SELECT * FROM posts ORDER BY created_at DESC");
            $this->db->desconectar();
            return $publicaciones;
        }
        return [];
    }

    // Podríamos añadir métodos para actualizar, eliminar, etc. en el futuro
}

?>