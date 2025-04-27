<?php
require_once 'models/PersonaModel.php';

class PersonaController {
    private $personaModel;

    public function __construct() {
        $this->personaModel = new PersonaModel();
    }

    public function procesarFormulario() {
        // Permitir solicitudes desde cualquier origen
        header("Access-Control-Allow-Origin: *");
        header("Access-Control-Allow-Methods: POST");
        header("Content-Type: application/json");

        $json_data = file_get_contents("php://input");
        $data = json_decode($json_data, true);

        if ($data) {
            $nombre = isset($data['nombre']) ? $data['nombre'] : '';
            $ci = isset($data['ci']) ? $data['ci'] : '';
            $email = isset($data['email']) ? $data['email'] : '';
            $fecha_nac = isset($data['fecha_nac']) ? $data['fecha_nac'] : null;

            try {
                if ($this->personaModel->guardarPersona($nombre, $ci, $email, $fecha_nac)) {
                    echo json_encode(['mensaje' => 'Datos de la persona guardados correctamente.']);
                } else {
                    http_response_code(500);
                    echo json_encode(['error' => 'Error al guardar los datos.']);
                }
            } catch (Exception $e) {
                http_response_code(400); // O un código más específico
                echo json_encode(['error' => $e->getMessage()]);
            }
        } else {
            http_response_code(400);
            echo json_encode(['error' => 'No se recibieron datos válidos.']);
        }
    }
}

// Punto de entrada para las peticiones al controlador de Persona
$controller = new PersonaController();
$controller->procesarFormulario();
?>