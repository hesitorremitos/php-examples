<?php
// models/libros.php

require_once 'db/db.php';

class Libros extends Database {
    private $db;

    public function __construct() {
        $this->db = new Database();
    }

    /**
     * Obtiene todos los libros de la base de datos.
     * @return array Un array asociativo con los datos de los libros, o un array vacío en caso de error o si no hay libros.
     */
    public function getLibros() {
        try {
            $conn = $this->db->getConnection();
            $stmt = $conn->prepare("SELECT * FROM libros");
            $stmt->execute();
            
            return $stmt->fetchAll(PDO::FETCH_ASSOC);

        } catch (PDOException $e) {
            // 🚨 ¡Error de base de datos! Loggear el error y devolver un array vacío.
            error_log("Error al obtener libros desde la base de datos: " . $e->getMessage());
            return [];
        } catch (Exception $e) {
            // 🚨 ¡Otro error! Loggear el error y devolver un array vacío.
            error_log("Error general al obtener libros: " . $e->getMessage());
            return [];
        }
    }
}
// Puedes agregar más métodos para interactuar con la tabla libros (crear, actualizar, eliminar, etc.)
// siguiendo un patrón similar de manejo de excepciones.
$libritos = new Libros();
