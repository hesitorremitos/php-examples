<?php
// controllers/LibrosController.php

require_once 'models/libros.php';

class LibrosController {
    private $libroModelo;

    public function __construct() {
        $this->libroModelo = new Libros();
    }

    /**
     * Muestra la lista de todos los libros disponibles.
     * Obtiene los datos del modelo y los pasa a la vista 'libros_vista.php'.
     */
    public function mostrarLibros() {
        // 📦 Obtener los datos de los libros desde el modelo
        $datosLibros = $this->libroModelo->getLibros();

        // ✅ Verificar si no se obtuvieron libros (array vacío)
        if (empty($datosLibros)) {
            $error = "No se encontraron libros o ocurrió un error al cargarlos.";
            require_once './views/error.php';
            return;
        }

        // 📂 Cargar la vista y pasar los datos como un array asociativo
        $datos = [
            'libros' => $datosLibros
        ];
        require_once './views/libros_vista.php';
    }
}