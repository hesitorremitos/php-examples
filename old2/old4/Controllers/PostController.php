<?php

namespace MiProyecto\Controllers;

use MiProyecto\Models\Post;

class PostController
{
    private Post $postModel;

    public function __construct()
    {
        $this->postModel = new Post();
    }

    public function mostrarFormularioCrear(int $userId)
    {
        // Aquí podríamos pasar el ID del usuario a la vista si fuera necesario
        include 'views/posts/crear.php';
    }

    public function registrarPublicacion(array $data)
    {
        if (isset($data['title'], $data['content'], $data['user_id']) &&
            !empty($data['title']) && !empty($data['content']) && is_numeric($data['user_id'])) {
            $title = htmlspecialchars($data['title']);
            $content = htmlspecialchars($data['content']);
            $userId = intval($data['user_id']);

            if ($this->postModel->registrarPublicacion($title, $content, $userId)) {
                // Redirigir a la lista de publicaciones del usuario o a otra página
                header("Location: index.php?accion=verPublicaciones&user_id=" . $userId . "&mensaje=publicacion_creada");
                exit();
            } else {
                $error = "Error al registrar la publicación.";
                include 'views/posts/crear.php'; // Volver a mostrar el formulario con un error
            }
        } else {
            $error = "Por favor, completa todos los campos.";
            include 'views/posts/crear.php'; // Volver a mostrar el formulario con un error
        }
    }

    public function verPublicaciones(int $userId)
    {
        $publicaciones = $this->postModel->obtenerPublicacionesPorUsuario($userId);
        include 'views/posts/listar.php';
    }

    public function listarTodasLasPublicaciones()
    {
        $publicaciones = $this->postModel->obtenerTodasLasPublicaciones();
        include 'views/posts/listar_todas.php'; // Podemos crear esta vista después si es necesario
    }
}

?>