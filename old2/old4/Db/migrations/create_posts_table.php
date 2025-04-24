<?php

require '../Database.php';

use MiProyecto\Db\Database;

$host = 'localhost';
$dbname = 'dbnew☀️';
$username = 'root';
$password = '';
$port = '3308';

$db = new Database($host, $dbname, $username, $password, $port);
$pdo = $db->conectar();

if ($pdo) {
    $sql = "CREATE TABLE IF NOT EXISTS posts (
        id INT PRIMARY KEY AUTO_INCREMENT,
        title VARCHAR(255) NOT NULL,
        content TEXT,
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
        updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
        user_id INT,
        FOREIGN KEY (user_id) REFERENCES users(id)
    )";

    if ($db->ejecutarNonQuery($sql)) {
        echo "✅ Tabla 'posts' creada exitosamente.<br>";
    } else {
        echo "❌ Error al crear la tabla 'posts'.<br>";
    }

    $db->desconectar();
} else {
    echo "❌ No se pudo conectar a la base de datos para crear la tabla 'posts'.<br>";
}

?>