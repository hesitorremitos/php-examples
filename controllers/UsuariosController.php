<?php
// controllers/UsuariosController.php

require_once 'models/UsuariosModel.php';

class UsuariosController {

    private $usuarioModelo;

    public function __construct() {
        $this->usuarioModelo = new UsuariosModel();
    }

    public function registrarUsuario() {
        // Verifica si la solicitud es POST (formulario enviado)
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $nombre = trim($_POST['nombre']);
            $email = trim($_POST['email']);
            $contrasenaPlana = $_POST['contrasena'];

            $errores = [];

            if (empty($nombre)) {
                $errores['nombre'] = "El nombre es obligatorio.";
            } elseif (strlen($nombre) > 255) {
                $errores['nombre'] = "El nombre no puede tener más de 255 caracteres.";
            }

            if (empty($email)) {
                $errores['email'] = "El email es obligatorio.";
            } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $errores['email'] = "El email no es válido.";
            } elseif ($this->usuarioModelo->existeEmail($email)) {
                $errores['email'] = "Este email ya está registrado.";
            }

            if (empty($contrasenaPlana)) {
                $errores['contrasena'] = "La contraseña es obligatoria.";
            } elseif (strlen($contrasenaPlana) < 6) {
                $errores['contrasena'] = "La contraseña debe tener al menos 6 caracteres.";
            }

            if (empty($errores)) {
                $contrasenaHash = password_hash($contrasenaPlana, PASSWORD_DEFAULT);
                if ($this->usuarioModelo->crearUsuario($nombre, $email, $contrasenaHash)) {
                    $_SESSION['mensaje_exito'] = "Usuario registrado correctamente.";
                    header('Location: index.php');
                    exit();
                } else {
                    $datos = [
                        'errores' => ['general' => "Error al registrar el usuario."],
                        'nombre' => $nombre,
                        'email' => $email,
                    ];
                }
            } else {
                $datos = [
                    'errores' => $errores,
                    'nombre' => $nombre,
                    'email' => $email,
                ];
            }
        } else {
            // Si es GET, inicializar datos vacíos para el formulario
            $datos = [
                'errores' => [],
                'nombre' => $_SESSION['nombre_temporal'] ?? '',
                'email' => $_SESSION['email_temporal'] ?? '',
            ];
            // Limpiar datos temporales de la sesión
            unset($_SESSION['nombre_temporal']);
            unset($_SESSION['email_temporal']);
            unset($_SESSION['errores_registro']);
        }

        // Cargar la vista de registro con los datos
        require_once './views/registro_usuario.php';
    }

    public function mostrarInicio() {
        $datosUsuarios = $this->usuarioModelo->getUsuarios();
        $datos = ['usuarios' => $datosUsuarios];
        require_once './views/inicio.php';
    }
}