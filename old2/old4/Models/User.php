<?php

namespace MiProyecto\Models;

use MiProyecto\Db\Database;

class User
{
    private Database $db;

    public function __construct()
    {
        $this->db = new Database('localhost', 'dbnew☀️', 'root', '', '3308');
    }

    public function obtenerTodosLosUsuarios(): array
    {
        $pdo = $this->db->conectar();
        if ($pdo) {
            $usuarios = $this->db->obtenerResultados("SELECT id, nombre, email FROM users"); // Ajusta los campos según tu tabla
            $this->db->desconectar();
            return $usuarios;
        }
        return [];
    }

    public function obtenerUsuarioPorId(int $id): ?array
    {
        $pdo = $this->db->conectar();
        if ($pdo) {
            $usuario = $this->db->obtenerFila("SELECT * FROM users WHERE id = :id", [':id' => $id]);
            $this->db->desconectar();
            return $usuario;
        }
        return null;
    }

    // Podrías tener otros métodos aquí para crear, actualizar, eliminar usuarios, etc.
}

?>