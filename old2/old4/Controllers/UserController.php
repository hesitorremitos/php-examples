<?php

namespace MiProyecto\Controllers;

use MiProyecto\Models\User;

class UserController
{
    private User $userModel;

    public function __construct()
    {
        $this->userModel = new User();
    }

    public function listarUsuarios()
    {
        $usuarios = $this->userModel->obtenerTodosLosUsuarios();
        include 'Views/posts/listar.php';
    }

    // Podrías tener otros métodos aquí para crear, editar, eliminar usuarios, etc.
}

?>