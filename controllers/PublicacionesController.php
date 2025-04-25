<?php
// controller/PublicacionesController.php

require_once 'db/db.php';
require_once 'models/publicaciones.php';

class PublicacionesController {
    private $publicacionModelo;

    public function __construct() {
        $this->publicacionModelo = new Publicaciones();
    }

    public function listarPublicacionesPorUsuario($userId) {
        $publicaciones = $this->publicacionModelo->obtenerPublicacionesPorUsuario($userId);
        // Cargar la vista y pasar los datos
        require_once 'views/listar_publicaciones.php';
    }

    public function mostrarFormularioCrearPublicacion($userId) {
        // Cargar la vista del formulario
        require_once 'views/crear_publicacion.php';
    }

    public function crearNuevaPublicacion() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $userId = $_POST['user_id'];
            $title = $_POST['title'];
            $content = $_POST['content'];

            if ($this->publicacionModelo->crearPublicacion($userId, $title, $content)) {
                $_SESSION['mensaje_exito_publicacion'] = "Publicación creada correctamente.";
                header("Location: index.php?accion=ver_publicaciones&user_id=" . $userId);
                exit(); // Detener la ejecución después de la redirección
            } else {
                $_SESSION['mensaje_error_publicacion'] = "Error al crear la publicación.";
                header("Location: index.php?accion=crear_publicacion_form&user_id=" . $userId);
                exit(); // Detener la ejecución después de la redirección
            }
        } else {
            echo "Acceso no permitido.";
        }
    }
}

// Para manejar las acciones basadas en la URL (ejemplo básico - ESTO DEBERÍA ESTAR EN index.php)
// if (isset($_GET['accion'])) {
//     $publicacionesController = new PublicacionesController();
//     if ($_GET['accion'] === 'ver_publicaciones' && isset($_GET['user_id'])) {
//         $publicacionesController->listarPublicacionesPorUsuario($_GET['user_id']);
//     } elseif ($_GET['accion'] === 'crear_publicacion_form' && isset($_GET['user_id'])) {
//         $publicacionesController->mostrarFormularioCrearPublicacion($_GET['user_id']);
//     } elseif ($_GET['accion'] === 'crear_publicacion') {
//         $publicacionesController->crearNuevaPublicacion();
//     }
// }