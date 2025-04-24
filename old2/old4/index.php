<?php

// **Configuración de la Base de Datos**
$host = 'localhost';
$dbname = 'dbnew☀️';
$username = 'root';
$password = '';
$port = '3308';

// **Autocarga de Clases (Recomendado usar Composer en proyectos grandes)**
spl_autoload_register(function ($className) {
    $namespaceRoot = 'MiProyecto\\';
    if (strpos($className, $namespaceRoot) === 0) {
        $path = str_replace($namespaceRoot, '', $className);
        $path = str_replace('\\', '/', $path);
        $filePath = __DIR__ . '/' . $path . '.php';
        if (file_exists($filePath)) {
            require_once $filePath;
        }
    }
});

use MiProyecto\Db\Database;
use MiProyecto\Controllers\UserController;
use MiProyecto\Controllers\PostController;

// **Inicializar la Conexión a la Base de Datos**
try {
    $db = new Database($host, $dbname, $username, $password, $port);
    $pdo = $db->conectar();
    if (!$pdo) {
        die("Error al conectar con la base de datos en index.php.");
    }
} catch (\Exception $e) {
    die("Excepción al conectar con la base de datos en index.php: " . $e->getMessage());
}

// **Inicializar los Controladores (Pasando la conexión PDO como dependencia)**
$userController = new UserController($db);
$postController = new PostController($db);

// **Obtener la Acción de la URL**
$accion = $_GET['accion'] ?? 'listarUsuarios';

// **Enrutamiento de la Petición**
try {
    switch ($accion) {
        case 'listarUsuarios':
            $userController->listarUsuarios();
            break;
        case 'verPublicaciones':
            if (isset($_GET['user_id']) && is_numeric($_GET['user_id'])) {
                $postController->verPublicaciones(intval($_GET['user_id']));
            } else {
                echo "ID de usuario no válido para ver las publicaciones.";
            }
            break;
        case 'mostrarFormularioCrear':
            if (isset($_GET['user_id']) && is_numeric($_GET['user_id'])) {
                $postController->mostrarFormularioCrear(intval($_GET['user_id']));
            } else {
                echo "ID de usuario no válido para mostrar el formulario de creación.";
            }
            break;
        case 'registrarPublicacion':
            $postController->registrarPublicacion($_POST);
            break;
        default:
            echo "Acción no válida.";
    }
} catch (\Exception $e) {
    // Manejar cualquier excepción general que ocurra en los controladores
    echo "Ocurrió un error: " . $e->getMessage();
}

// **Cerrar la Conexión al Final de la Ejecución (Opcional)**
// $db->desconectar();

?>