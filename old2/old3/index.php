<?php
// file: ./db/db.php
// Definir el DSN (Data Source Name) para la conexión PDO
// El DSN incluye el host, el puerto y la codificación de caracteres (utf8mb4)
// Puedes usar utf8mb4 para soportar emojis y caracteres especiales
$host = 'localhost';
// Nombre del servidor MySQL
$dbname = 'dbnew☀️';    // Nombre de tu base de datos
$username = 'root'; // Tu nombre de usuario de MySQL
$password = '';    // Tu contraseña de MySQL
$port = '3308';    // Puerto de MySQL (opcional, si no es el predeterminado)
$dsn ="mysql:host=$host;port=$port;charset=utf8mb4"; 

$pdo=null; 
// Inicializar la variable $pdo como null
try {
    // Crear una nueva conexión PDO
    // La cadena de conexión debe tener el formato "driver:host=...;dbname=..."
    $pdo = new PDO($dsn,$username, $password, array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8mb4"));
    echo "✅ Conexión exitosa al servidor MySQL (paso 1).<br>";

    // Establecer el modo de error de PDO a excepciones (¡Importante hacerlo ANTES de cualquier consulta!)
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Establecer el modo de emulación de PDO a falso (opcional, pero recomendado para seguridad y consistencia)
    $pdo->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);


    

    // Crear la base de datos si no existe
    $sqlCreateDb ="CREATE DATABASE IF NOT EXISTS `$dbname` CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci";
    
    // Ejecutar la consulta de sql
    $pdo->exec($sqlCreateDb);

    echo "Base de datos $dbname creada o ya existe.<br>";
    // cerrar conexión anterior
    $pdo = null;
    
    // Conectar con la base de datos especificada
    // segunda conexión a la base de datos
    $pdo = new PDO("mysql:host=$host;port=$port;dbname=$dbname;charset=utf8mb4", $username, $password);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $pdo->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
        

    // No es necesario reconectar ni usar "USE database" con PDO al crear la instancia inicial con el dbname.
    // La conexión ya está establecida con la base de datos especificada.

     echo "🎉 ¡Conexión exitosa a la base de datos '$dbname'! 🎉";


} catch (PDOException $e) {
    echo "Error de conexión: " . $e->getMessage() . "<br>";
    die(); // Detener la ejecución si la conexión falla
} finally {
    // Asegurarse de cerrar la conexión PDO al finalizar (tanto en éxito como en error)
    if($pdo) {
        $pdo = null; // Cerrar la conexión PDO
    }
}

// A partir de aquí, puedes utilizar $pdo para realizar consultas a la base de datos

?>