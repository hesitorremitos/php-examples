<?php
// public/index.php
require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../controllers/UserController.php';
require_once __DIR__ . '/../controllers/PostController.php';

// Enrutamiento básico
$path = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$segments = explode('/', trim($path, '/'));

$userController = new UserController();
$postController = new PostController();

// Depuración: Mostrar la URL solicitada (quitar en producción)
if (defined('DEBUG') && DEBUG) {
    echo "URL solicitada: $path<br>";
    echo "Segmentos: " . print_r($segments, true) . "<br>";
}

if (empty($segments[0])) {
    // Mostrar lista de usuarios
    $userController->index();
} elseif ($segments[0] === 'users') {
    if ($segments[1] === 'create' || empty($segments[1])) {
        // Mostrar formulario para crear usuario
        $userController->create();
    } elseif ($segments[1] === 'store' && $_SERVER['REQUEST_METHOD'] === 'POST') {
        // Procesar creación de usuario
        $userController->store($_POST);
    } else {
        // Error: Subruta de usuarios no válida
        http_response_code(404);
        echo '404 - Ruta de usuarios no encontrada: /' . implode('/', $segments);
    }
} elseif ($segments[0] === 'posts') {
    if ($segments[1] === 'index' || empty($segments[1])) {
        // Mostrar todas las publicaciones
        $postController->index();
    } elseif ($segments[1] === 'create') {
        if (isset($segments[2]) && is_numeric($segments[2])) {
            // Mostrar formulario para crear publicación
            $postController->create($segments[2]);
        } else {
            // Error: Falta user_id
            http_response_code(400);
            echo '400 - Falta el ID del usuario para crear publicación';
        }
    } elseif ($segments[1] === 'store' && $_SERVER['REQUEST_METHOD'] === 'POST') {
        // Procesar creación de publicación
        $postController->store($_POST);
    } elseif ($segments[1] === 'show') {
        if (isset($segments[2]) && is_numeric($segments[2])) {
            // Mostrar publicaciones de un usuario
            $postController->show($segments[2]);
        } else {
            // Error: Falta user_id
            http_response_code(400);
            echo '400 - Falta el ID del usuario para ver publicaciones';
        }
    } else {
        // Error: Subruta de publicaciones no válida
        http_response_code(404);
        echo '404 - Ruta de publicaciones no encontrada: /' . implode('/', $segments);
    }
} else {
    // Error: Ruta principal no válida
    http_response_code(404);
    echo '404 - Página no encontrada: /' . implode('/', $segments);
}
?>