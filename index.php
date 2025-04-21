<?php

$host = 'localhost';      // Nombre del servidor MySQL
$dbname = 'nombre_de_tu_base_de_datos'; // Nombre de tu base de datos
$username = 'tu_usuario';    // Tu nombre de usuario de MySQL
$password = 'tu_contraseña';  // Tu contraseña de MySQL

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8mb4", $username, $password);
    // Establecer el modo de error de PDO a excepciones
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    echo "¡Conexión exitosa a la base de datos!";
} catch (PDOException $e) {
    echo "Error de conexión: " . $e->getMessage();
    die(); // Detener la ejecución si la conexión falla
}

// A partir de aquí, puedes utilizar $pdo para realizar consultas a la base de datos

?>