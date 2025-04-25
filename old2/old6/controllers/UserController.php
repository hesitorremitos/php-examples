<?php
require_once __DIR__ . '/../models/User.php';

class UserController {
    private $user;

    public function __construct() {
        $this->user = new User();
    }

    // Mostrar lista de usuarios
    public function index() {
        $users = $this->user->getAll();
        if (empty($users)) {
            $message = 'No hay usuarios registrados. Crea uno nuevo para empezar.';
        }
        require_once __DIR__ . '/../views/users/index.php';
    }

    // Mostrar formulario para crear usuario
    public function create() {
        require_once __DIR__ . '/../views/users/create.php';
    }

    // Procesar creación de usuario
    public function store($data) {
        // Validaciones básicas
        if (empty($data['username']) || empty($data['email'])) {
            header('Location: /users/create?error=Nombre de usuario y correo son obligatorios');
            exit;
        }

        // Validar formato de correo (básico)
        if (!filter_var($data['email'], FILTER_VALIDATE_EMAIL)) {
            header('Location: /users/create?error=Correo electrónico inválido');
            exit;
        }

        $this->user->username = $data['username'];
        $this->user->email = $data['email'];

        if ($this->user->create()) {
            header('Location: /?success=Usuario creado correctamente');
        } else {
            header('Location: /users/create?error=Error al crear usuario');
        }
    }
}
?>