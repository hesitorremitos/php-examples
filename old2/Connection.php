<?php
//file: Connection.php
/**
 * ⚙️ Clase padre para la gestión de la conexión a la base de datos MySQLi (Consola).
 * Proporciona una conexión protegida y registra eventos en la consola.
 */
class Connection extends mysqli{
    /**
     * @var ?mysqli La instancia de la conexión a la base de datos. Null si no se ha establecido la conexión.
     */
    protected ?mysqli $connection = null;


    /**
     * @var string El host de la base de datos.
     */
    private string $host = "localhost";


    /**
     * @var string El nombre de usuario para la conexión a la base de datos.
     */
    private string $user = "root";


    /**
     * @var string La contraseña para la conexión a la base de datos.
     */
    private string $password = "";


    /**
     * @var string El nombre de la base de datos a la que se conectará.
     */
    private string $db = "backend";


    /**
     * @var int El puerto del servidor de la base de datos MySQL.
     */
    private int $port = 3308;


    /**
     * 🔗 Constructor de la clase Connection.
     * Intenta establecer la conexión a la base de datos al instanciar la clase.
     */
    public function __construct() {
        $this->connect();
    }


    /**
     * 🚪 Destructor de la clase Connection.
     * Cierra la conexión a la base de datos si aún está activa al destruir el objeto.
     */
    public function __destruct() {
        $this->disconnect();
    }


    /**
     * 🔗 Establece la conexión a la base de datos MySQLi.
     * Este método es protegido para que solo las clases hijas puedan iniciarlo.
     *
     * @return void
     */
    protected function connect(): void {
        echo "[+] Intentando conectar a la base de datos en {$this->host}:{$this->port}...\n";
        try {
            // 🛠️ Establecer la conexión usando mysqli_connect
            $this->connection = new mysqli(
                $this->host,
                $this->user,
                $this->password,
                $this->db,
                $this->port
            );


            // ⚠️ Verificar si la conexión fue exitosa
            if ($this->connection->connect_error) {
                throw new Exception("Error de conexión a la base de datos (" . $this->connection->connect_errno . "): " . $this->connection->connect_error);
            }


            // ⚙️ Establecer el conjunto de caracteres a UTF-8 para una mejor compatibilidad
            if (!$this->connection->set_charset("utf8")) {
                echo "[-] Error al establecer la codificación de caracteres: " . $this->connection->error . "\n";
            } else {
                echo "[+] Codificación de caracteres establecida a UTF-8.\n";
            }


            echo "[+] Conexión a la base de datos '{$this->db}' establecida con éxito.\n";


        } catch (Exception $e) {
            // 🚨 Capturar cualquier excepción ocurrida durante la conexión
            $errorMessage = "[-] Error en la conexión a la base de datos: " . $e->getMessage();
            error_log($errorMessage); // Log del error para un seguimiento posterior
            die("❌ ¡Error! No se pudo conectar a la base de datos. Por favor, revisa la configuración (host: {$this->host}, usuario: {$this->user}, base de datos: {$this->db}, puerto: {$this->port}).\n");
        }
    }


    /**
     * 🔒 Cierra la conexión a la base de datos si está activa.
     * Este método puede ser llamado por las clases hijas o automáticamente al destruir el objeto.
     *
     * @return void
     */
    protected function disconnect(): void {
        if ($this->connection instanceof mysqli) {
            if ($mysqli->connect_errno) {
                $this->connection->close();
                echo "[i] Conexión a la base de datos cerrada.\n";
            } else {
                echo "[i] La conexión a la base de datos ya estaba inactiva.\n";
            }
        } else {
            echo "[i] No hay conexión activa para cerrar.\n";
        }
    }


    /**
     * 🔄 Reestablece la conexión a la base de datos si se ha perdido.
     *
     * @return void
     */
    protected function reconnect(): void {
        if (!($this->connection instanceof mysqli) || !$this->connection->ping()) {
            echo "[+] Intentando reestablecer la conexión...\n";
            $this->connect();
        } else {
            echo "[i] La conexión a la base de datos aún está activa.\n";
        }
    }


    /**
     * ❓ Obtiene la instancia de la conexión a la base de datos.
     * Las clases hijas pueden usar este método para interactuar con la base de datos.
     * Asegura que la conexión esté activa antes de devolverla.
     *
     * @return ?mysqli La instancia de la conexión o null si no hay conexión.
     */
    protected function getConnection(): ?mysqli {
        $this->reconnect(); // Asegurarse de que la conexión esté activa antes de devolverla
        return $this->connection;
    }
}


// Ejemplo de cómo NO instanciar directamente la clase Connection (en consola)
// echo "\n[Ejemplo de uso de Connection (no directo)]\n";
// $conn = new Connection();
// $conexion = $conn->getConnection();
// if ($conexion) {
//     echo "[+] Conexión obtenida exitosamente desde getConnection().\n";
//     // No se recomienda cerrar aquí, las clases hijas gestionarán la conexión.
//     // $conexion->close();
// } else {
//     echo "[-] No se pudo obtener la conexión.\n";
// }
// unset($conn); // Forzar la llamada al destructor para ver el mensaje de cierre
// echo "[Fin del ejemplo]\n";


?>
