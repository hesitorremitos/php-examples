<?php

/**
 * 🏫 Control de Asistencia Simple (Consola) - Con Creación de Base de Datos
 */

// --- Configuración de la Base de Datos ---
$host = "localhost";
$user = "root";
$password = "";
$db = "asistencia";
$port = 3308;

// --- Funciones para la Base de Datos ---

/**
 * 🔗 Establece la conexión a la base de datos (sin selección inicial).
 *
 * @return ?mysqli La instancia de la conexión o null en caso de error.
 */
function connectDBWithoutDB(): ?mysqli {
    global $host, $user, $password, $port;
    $conn = new mysqli($host, $user, $password, '', $port); // Sin especificar la base de datos inicialmente
    if ($conn->connect_error) {
        echo "[-] Error al conectar al servidor MySQL: " . $conn->connect_error . "\n";
        return null;
    }
    return $conn;
}

/**
 * 🔗 Establece la conexión a la base de datos específica.
 *
 * @return ?mysqli La instancia de la conexión o null en caso de error.
 */
function connectDB(): ?mysqli {
    global $host, $user, $password, $db, $port;
    $conn = new mysqli($host, $user, $password, $db, $port);
    if ($conn->connect_error) {
        echo "[-] Error al conectar a la base de datos '{$db}': " . $conn->connect_error . "\n";
        return null;
    }
    $conn->set_charset("utf8");
    return $conn;
}

/**
 * 🛠️ Crea la base de datos si no existe.
 *
 * @return bool True si la base de datos se creó o ya existe, false en caso de error.
 */
function crearBaseDeDatos(): bool {
    global $db;
    $conn = connectDBWithoutDB();
    if ($conn) {
        $sqlCreateDB = "CREATE DATABASE IF NOT EXISTS {$db}";
        if ($conn->query($sqlCreateDB) === TRUE) {
            echo "[+] Base de datos '{$db}' creada o ya existente.\n";
            $conn->close();
            return true;
        } else {
            echo "[-] Error al crear la base de datos '{$db}': " . $conn->error . "\n";
            $conn->close();
            return false;
        }
    }
    return false;
}

/**
 * 🛠️ Crea la tabla de asistencia si no existe.
 *
 * @param mysqli $conn La conexión a la base de datos.
 * @return bool True si la tabla se creó o ya existe, false en caso de error.
 */
function crearTablaAsistencia(mysqli $conn): bool {
    $sqlCreateTable = "CREATE TABLE IF NOT EXISTS asistencia (
        id INT AUTO_INCREMENT PRIMARY KEY,
        empleado_id INT NOT NULL,
        hora_entrada DATETIME NOT NULL,
        hora_salida DATETIME NULL,
        INDEX (empleado_id),
        INDEX (hora_entrada)
    )";
    if ($conn->query($sqlCreateTable) === TRUE) {
        echo "[+] Tabla 'asistencia' creada o ya existente.\n";
        return true;
    } else {
        echo "[-] Error al crear la tabla 'asistencia': " . $conn->error . "\n";
        return false;
    }
}

/**
 * ➕ Registra la entrada de un empleado.
 *
 * @param mysqli $conn La conexión a la base de datos.
 * @param int    $empleadoId El ID del empleado.
 * @return bool True si la entrada se registró correctamente, false en caso contrario.
 */
function registrarEntrada(mysqli $conn, int $empleadoId): bool {
    $stmt = $conn->prepare("INSERT INTO asistencia (empleado_id, hora_entrada) VALUES (?, NOW())");
    if ($stmt) {
        $stmt->bind_param('i', $empleadoId);
        if ($stmt->execute()) {
            echo "[+] Entrada registrada para el empleado ID " . $empleadoId . " a las " . date('Y-m-d H:i:s') . "\n";
            $stmt->close();
            return true;
        } else {
            echo "[-] Error al registrar la entrada: " . $stmt->error . "\n";
            $stmt->close();
            return false;
        }
    } else {
        echo "[-] Error al preparar la consulta de entrada: " . $conn->error . "\n";
        return false;
    }
}

/**
 * 🚪 Registra la salida de un empleado.
 *
 * @param mysqli $conn La conexión a la base de datos.
 * @param int    $empleadoId El ID del empleado.
 * @return bool True si la salida se registró correctamente, false en caso contrario.
 */
function registrarSalida(mysqli $conn, int $empleadoId): bool {
    $stmt = $conn->prepare("UPDATE asistencia SET hora_salida = NOW() WHERE empleado_id = ? AND DATE(hora_entrada) = CURDATE() AND hora_salida IS NULL ORDER BY hora_entrada DESC LIMIT 1");
    if ($stmt) {
        $stmt->bind_param('i', $empleadoId);
        if ($stmt->execute()) {
            if ($stmt->affected_rows > 0) {
                echo "[+] Salida registrada para el empleado ID " . $empleadoId . " a las " . date('Y-m-d H:i:s') . "\n";
                $stmt->close();
                return true;
            } else {
                echo "[i] No se encontró una entrada activa para registrar la salida del empleado ID " . $empleadoId . " hoy.\n";
                $stmt->close();
                return false;
            }
        } else {
            echo "[-] Error al registrar la salida: " . $stmt->error . "\n";
            $stmt->close();
            return false;
        }
    } else {
        echo "[-] Error al preparar la consulta de salida: " . $conn->error . "\n";
        return false;
    }
}

/**
 * 📊 Muestra el registro de asistencia de un empleado en un día específico.
 *
 * @param mysqli   $conn La conexión a la base de datos.
 * @param int      $empleadoId El ID del empleado.
 * @param string|null $fecha      La fecha en formato YYYY-MM-DD (opcional, hoy por defecto).
 * @return void
 */
function mostrarAsistencia(mysqli $conn, int $empleadoId, ?string $fecha = null): void {
    $fechaConsulta = $fecha ?? date('Y-m-d');
    echo "\n[+] Asistencia del empleado ID " . $empleadoId . " para el día " . $fechaConsulta . ":\n";
    $stmt = $conn->prepare("SELECT hora_entrada, hora_salida FROM asistencia WHERE empleado_id = ? AND DATE(hora_entrada) = ? ORDER BY hora_entrada ASC");
    if ($stmt) {
        $stmt->bind_param('is', $empleadoId, $fechaConsulta);
        $stmt->execute();
        $result = $stmt->get_result();
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                echo "  Entrada: " . $row['hora_entrada'];
                echo $row['hora_salida'] ? " - Salida: " . $row['hora_salida'] : " - Salida: Pendiente";
                echo "\n";
            }
        } else {
            echo "[i] No se encontraron registros de asistencia para este empleado en este día.\n";
        }
        $stmt->close();
    } else {
        echo "[-] Error al preparar la consulta de asistencia: " . $conn->error . "\n";
    }
}

// --- Interfaz de Consola ---

echo "👋 Control de Asistencia Simple (Consola) - Con Verificación de Base de Datos\n";

// Crear la base de datos si no existe
if (crearBaseDeDatos()) {
    // Conectar a la base de datos recién creada (o existente)
    $conn = connectDB();
    if ($conn) {
        // Crear la tabla de asistencia si no existe
        if (crearTablaAsistencia($conn)) {
            // --- Menú Principal ---
            while (true) {
                echo "\n--- Menú ---\n";
                echo "1. Registrar Entrada\n";
                echo "2. Registrar Salida\n";
                echo "3. Mostrar Asistencia por Empleado y Día\n";
                echo "4. Salir\n";
                $opcion = trim(fgets(STDIN));

                switch ($opcion) {
                    case '1':
                        echo "Ingrese el ID del empleado para registrar la entrada: ";
                        $empleadoIdEntrada = (int) trim(fgets(STDIN));
                        registrarEntrada($conn, $empleadoIdEntrada);
                        break;
                    case '2':
                        echo "Ingrese el ID del empleado para registrar la salida: ";
                        $empleadoIdSalida = (int) trim(fgets(STDIN));
                        registrarSalida($conn, $empleadoIdSalida);
                        break;
                    case '3':
                        echo "Ingrese el ID del empleado para mostrar la asistencia: ";
                        $empleadoIdAsistencia = (int) trim(fgets(STDIN));
                        echo "Ingrese la fecha (YYYY-MM-DD, dejar en blanco para hoy): ";
                        $fechaAsistencia = trim(fgets(STDIN));
                        mostrarAsistencia($conn, $empleadoIdAsistencia, $fechaAsistencia);
                        break;
                    case '4':
                        echo "¡Hasta luego!\n";
                        $conn->close();
                        exit(0);
                    default:
                        echo "Opción inválida. Por favor, intente de nuevo.\n";
                }
            }
        } else {
            echo "[-] No se pudo crear la tabla de asistencia. El programa finalizará.\n";
            $conn->close();
            exit(1);
        }
    } else {
        echo "[-] No se pudo conectar a la base de datos. El programa finalizará.\n";
        exit(1);
    }
} else {
    echo "[-] No se pudo crear la base de datos. El programa finalizará.\n";
    exit(1);
}

?>