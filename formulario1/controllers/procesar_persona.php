<?php
require 'Persona.php'; // Incluye la clase Persona

// Permitir solicitudes desde cualquier origen
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST");
header("Content-Type: application/json");

// Datos de conexión a la base de datos
$host = 'localhost'; // Cambia si tu servidor MySQL está en otro host
$dbname = 'pruebanga'; // Reemplaza con el nombre de tu base de datos
$user = 'root'; // Reemplaza con tu nombre de usuario de MySQL
$password = ''; // Reemplaza con tu contraseña de MySQL
$port = 3308; // Especificamos el puerto

try {
    $pdo = new PDO("mysql:host=$host;port=$port;dbname=$dbname;charset=utf8mb4", $user, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    http_response_code(500); // Internal Server Error
    echo json_encode(['error' => 'Error al conectar a la base de datos: ' . $e->getMessage()]);
    exit();
}

// Recibir y decodificar los datos JSON
$json_data = file_get_contents("php://input");
$data = json_decode($json_data, true);

if ($data) {
    $nombre = isset($data['nombre']) ? $data['nombre'] : '';
    $ci = isset($data['ci']) ? $data['ci'] : '';
    $email = isset($data['email']) ? $data['email'] : '';
    $fecha_nac = isset($data['fecha_nac']) ? $data['fecha_nac'] : null; // Permitir valores NULL para la fecha

    // Crear una instancia de la clase Persona (opcional, si solo vas a guardar los datos)
    $persona = new Persona($nombre, $ci, $email, $fecha_nac);

    try {
        // Preparar la consulta SQL para la inserción
        $stmt = $pdo->prepare("INSERT INTO personas (nombre, ci, email, fecha_nac) VALUES (:nombre, :ci, :email, :fecha_nac)");

        // Bind de los parámetros
        $stmt->bindParam(':nombre', $persona->nombre);
        $stmt->bindParam(':ci', $persona->ci);
        $stmt->bindParam(':email', $persona->email);
        $stmt->bindParam(':fecha_nac', $persona->fecha_nac);

        // Ejecutar la consulta
        if ($stmt->execute()) {
            // Éxito al guardar los datos
            echo json_encode(['mensaje' => 'Datos de la persona guardados correctamente en la base de datos.']);
        } else {
            // Error al ejecutar la consulta
            http_response_code(500); // Internal Server Error
            echo json_encode(['error' => 'Error al guardar los datos en la base de datos.']);
        }
    } catch (PDOException $e) {
        // Error con la base de datos (por ejemplo, clave única violada)
        http_response_code(400); // Bad Request
        echo json_encode(['error' => 'Error al guardar los datos: ' . $e->getMessage()]);
    }
} else {
    // Si no se recibieron datos JSON válidos
    http_response_code(400); // Bad Request
    echo json_encode(['error' => 'No se recibieron datos válidos.']);
}
?>