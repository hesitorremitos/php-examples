<?php
require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../controllers/UserController.php';
require_once __DIR__ . '/../controllers/PostController.php';

// Enrutamiento básico
$path = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$segments = explode('/', trim($path, '/'));

$userController = new UserController();
$postController = new PostController();

if (empty($segments[0])) {
    // Mostrar lista de usuarios
    $userController->index();
} elseif ($segments[0] === 'posts') {
    if ($segments[1] === 'index' || empty($segments[1])) {
        $postController->index();
    } elseif ($segments[1] === 'create' && isset($segments[2])) {
        $postController->create($segments[2]);
    } elseif ($segments[1] === 'store' && $_SERVER['REQUEST_METHOD'] === 'POST') {
        $postController->store($_POST);
    } elseif ($segments[1] === 'show' && isset($segments[2])) {
        $postController->show($segments[2]);
    }
} else {
    // Página no encontrada
    http_response_code(404);
    echo '404 - Página no encontrada';
}
?>