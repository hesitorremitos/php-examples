<?php
// controllers/PostController.php
require_once 'models/Post.php';
require_once 'models/User.php';

class PostController {
    private $postModel;
    private $userModel;

    public function __construct() {
        try {
            $this->postModel = new Post();
            $this->userModel = new User();
        } catch (Exception $e) {
            echo "<strong>Error en PostController::__construct:</strong> " . $e->getMessage();
            // Podrías querer redirigir a una página de error aquí
        }
    }

    public function listarPorUsuario($user_id) {
        try {
            // Obtiene las publicaciones del usuario desde el modelo
            $posts = $this->postModel->getPostsByUserId($user_id);
            if ($posts === false) {
                throw new Exception("No se pudieron obtener los posts del usuario.");
            }

            // Obtiene la información del usuario para mostrarla en la vista
            $user = $this->userModel->getUserById($user_id);
             if ($user === false) {
                throw new Exception("No se pudo obtener el usuario.");
            }           

            // Incluye la vista para mostrar las publicaciones del usuario
            include 'views/user/posts.php'; // Asegúrate de que la ruta y el nombre del archivo sean correctos
        } catch (Exception $e) {
            echo "<strong>Error en PostController::listarPorUsuario:</strong> " . $e->getMessage();
            // Podrías querer mostrar un mensaje de error amigable al usuario
        }
    }

    public function crearFormulario($user_id) {
        try{
        // Incluye la vista para mostrar el formulario de creación de un nuevo post
        include 'views/posts/create.php'; // Asegúrate de que la ruta y el nombre del archivo sean correctos
        } catch (Exception $e) {
            echo "<strong>Error en PostController::crearFormulario:</strong> " . $e->getMessage();
        }
    }

    public function store() {
        try {
            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                $title = $_POST['title'];
                $content = $_POST['content'];
                $user_id = $_POST['user_id'];

                // Llama al método createPost del modelo
                $result = $this->postModel->createPost($title, $content, $user_id);
                if (!$result) {
                    throw new Exception("No se pudo crear la publicación.");
                }

                // Redirige a la página de visualización de posts del usuario
                header("Location: index.php?action=posts&user_id=$user_id");
                exit();
            } else {
                throw new Exception("Error: Este método solo admite solicitudes POST.");
            }
        } catch (Exception $e) {
            echo "<strong>Error en PostController::store:</strong> " . $e->getMessage();
        }
    }

    public function index() {
         try {
        // Obtiene todas las publicaciones
        $posts = $this->postModel->getAllPosts();
        include 'views/posts/index.php';
         } catch (Exception $e) {
             echo "<strong>Error en PostController::index:</strong> " . $e->getMessage();
         }
    }
}
?>