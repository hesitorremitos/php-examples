<?php
// models/UsuariosModel.php

require_once 'db/db.php'; // El modelo es responsable de la conexión

class UsuariosModel extends Database {
    private $db;

    public function __construct() {
        $this->db = new Database(); // Asumiendo que tienes una clase Database para la conexión
    }

    public function existeEmail($email) {
        $conn = $this->db->getConnection();
        $stmt = $conn->prepare("SELECT COUNT(*) FROM usuarios WHERE email = :email");
        $stmt->bindParam(':email', $email);
        $stmt->execute();
        return $stmt->fetchColumn() > 0;
    }

    public function crearUsuario($nombre, $email, $contrasenaHash) {
        $conn = $this->db->getConnection();
        $stmt = $conn->prepare("INSERT INTO usuarios (nombre, email, contrasena) VALUES (:nombre, :email, :contrasena)");
        $stmt->bindParam(':nombre', $nombre);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':contrasena', $contrasenaHash);
        return $stmt->execute();
    }

    public function getUsuarios() {
        $conn = $this->db->getConnection();
        $stmt = $conn->prepare("SELECT id, nombre, email FROM usuarios");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}

// Asegúrate de tener una clase Database en db/db.php que maneje la conexión PDO