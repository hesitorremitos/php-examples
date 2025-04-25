<?php
// index.php

// Autocarga simple
require_once 'controllers/UserController.php';
require_once 'controllers/PostController.php';

// Acción por defecto
$action = $_GET['action'] ?? 'home';

// Enrutamiento manual estilo básico
try {
    switch ($action) {
        case 'home':
            $controller = new UserController();
            $controller->index();
            break;

        case 'posts':
            if (isset($_GET['user_id'])) {
                $controller = new PostController();
                $controller->listarPorUsuario($_GET['user_id']);
            } else {
                throw new Exception("Falta el parámetro user_id para la acción 'posts'.");
            }
            break;

        case 'create_post':
            if (isset($_GET['user_id'])) {
                $controller = new PostController();
                $controller->crearFormulario($_GET['user_id']);
            } else {
                throw new Exception("Falta el parámetro user_id para la acción 'create_post'.");
            }
            break;
        case 'store_post':
            $controller = new PostController();
            $controller->store();
            break;

        default:
            throw new Exception("Ruta no reconocida: $action");
            break;
    }
} catch (Exception $e) {
    echo "<strong>Error en index.php:</strong> " . $e->getMessage();
}

?>