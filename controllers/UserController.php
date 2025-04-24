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
        require_once __DIR__ . '/../views/users/index.php';
    }
}
?>