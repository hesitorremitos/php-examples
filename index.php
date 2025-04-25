<?php
// index.php

// Habilitar visualización de errores para desarrollo
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

ob_start();

// Iniciar sesión si no está activa
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

require_once './db/db.php';
require_once './controllers/LibrosController.php';
require_once './controllers/UsuariosController.php';
require_once './controllers/PublicacionesController.php';

$librosController = new LibrosController();
$usuariosController = new UsuariosController();
$publicacionesController = new PublicacionesController();

// Obtener la acción desde la URL, si no hay acción, asumir 'inicio' para la ruta raíz "/"
$accion = filter_input(INPUT_GET, 'accion', FILTER_SANITIZE_FULL_SPECIAL_CHARS) ?? 'inicio';

// Depuración: registrar la acción recibida
error_log("Acción recibida: $accion");

// Manejo de rutas
switch ($accion) {
    case 'registrar':
        $usuariosController->registrarUsuario();
        break;

    case 'ver_publicaciones':
        if (isset($_GET['user_id'])) {
            $userId = filter_input(INPUT_GET, 'user_id', FILTER_SANITIZE_NUMBER_INT);
            if ($userId !== false && $userId > 0) {
                $publicacionesController->listarPublicacionesPorUsuario($userId);
            } else {
                http_response_code(400);
                require_once 'views/error.php';
            }
        } else {
            http_response_code(400);
            require_once 'views/error.php';
        }
        break;

    case 'crear_publicacion_form':
        if (isset($_GET['user_id'])) {
            $userId = filter_input(INPUT_GET, 'user_id', FILTER_SANITIZE_NUMBER_INT);
            if ($userId !== false && $userId > 0) {
                $publicacionesController->mostrarFormularioCrearPublicacion($userId);
            } else {
                http_response_code(400);
                require_once 'views/error.php';
            }
        } else {
            http_response_code(400);
            require_once 'views/error.php';
        }
        break;

    case 'crear_publicacion':
        $publicacionesController->crearNuevaPublicacion();
        break;

    case 'ver_libros':
        error_log("Ejecutando LibrosController::mostrarLibros()");
        $librosController->mostrarLibros();
        break;

    case 'inicio':
        error_log("Ejecutando acción inicio: cargando todas las listas");
        // Obtener datos de todos los controladores
        $datos = [
            'libros' => $librosController->mostrarLibros(), // Debe modificarse para devolver datos
            'usuarios' => $usuariosController->mostrarInicio(), // Debe modificarse para devolver datos
            'publicaciones' => isset($_SESSION['user_id']) ? $publicacionesController->listarPublicacionesPorUsuario($_SESSION['user_id']) : [],
        ];
        require_once 'views/inicio.php';
        break;

    default:
        http_response_code(404);
        require_once 'views/error.php';
        break;
}

ob_end_flush();