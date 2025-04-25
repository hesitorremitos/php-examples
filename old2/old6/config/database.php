<?php
class Database {
    // config/database.php
    private $host = 'localhost';
    private $port = '3308'; // Puerto personalizado para MySQL
    private $db_name = 'db5';
    private $username = 'root';
    private $password = '';
    private $conn;

    public function connect() {
        $this->conn = null;
        try {
            // Incluir el puerto en la cadena de conexión
            $this->conn = new PDO(
                "mysql:host=$this->host;port=$this->port;dbname=$this->db_name",
                $this->username,
                $this->password
            );
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            // Mensaje de error más claro
            echo 'Error de conexión a la base de datos: ' . $e->getMessage();
        }
        return $this->conn;
    }
}
?>