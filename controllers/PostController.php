<?php
require_once __DIR__ . '/../models/Post.php';
require_once __DIR__ . '/../models/User.php';

class PostController {
    private $post;
    private $user;

    public function __construct() {
        $this->post = new Post();
        $this->user = new User();
    }

    // Mostrar todas las publicaciones
    public function index() {
        $posts = $this->post->getAll();
        require_once __DIR__ . '/../views/posts/index.php';
    }

    // Mostrar formulario para crear publicación
    public function create($user_id) {
        // Verificar que el usuario existe
        if (!$this->user->getById($user_id)) {
            header('Location: /?error=Usuario no encontrado');
            exit;
        }
        require_once __DIR__ . '/../views/posts/create.php';
    }

    // Guardar una nueva publicación
    public function store($data) {
        // Validaciones
        if (empty($data['title']) || empty($data['content'])) {
            header('Location: /posts/create/' . $data['user_id'] . '?error=Título y contenido son obligatorios');
            exit;
        }
        if (!$this->user->getById($data['user_id'])) {
            header('Location: /?error=Usuario no encontrado');
            exit;
        }

        $this->post->title = $data['title'];
        $this->post->content = $data['content'];
        $this->post->user_id = $data['user_id'];

        if ($this->post->create()) {
            header('Location: /posts/show/' . $data['user_id'] . '?success=Publicación creada');
        } else {
            header('Location: /posts/create/' . $data['user_id'] . '?error=Error al crear publicación');
        }
    }

    // Listar publicaciones de un usuario
    public function show($user_id) {
        // Verificar que el usuario existe
        if (!$this->user->getById($user_id)) {
            header('Location: /?error=Usuario no encontrado');
            exit;
        }
        $posts = $this->post->getByUser($user_id);
        require_once __DIR__ . '/../views/posts/show.php';
    }
}
?>