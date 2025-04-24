<?php

namespace MiProyecto\Db; // El espacio de nombres ha cambiado a MiProyecto\Db

use PDO;
use PDOException;

class Database
{
    /**
     * @var string Host del servidor de la base de datos. 🏠
     */
    private string $host;

    /**
     * @var string Nombre de la base de datos. 🗃️
     */
    private string $dbname;

    /**
     * @var string Nombre de usuario para la conexión a la base de datos. 👤
     */
    private string $username;

    /**
     * @var string Contraseña para la conexión a la base de datos. 🔒
     */
    private string $password;

    /**
     * @var string Puerto del servidor de la base de datos. ⚓ (Por defecto suele ser 3306)
     */
    private string $port;

    /**
     * @var ?PDO Instancia de la conexión PDO. 🔗 Inicialmente null.
     */
    private ?PDO $pdo = null;

    /**
     * Constructor de la clase Database. Inicializa los parámetros de conexión.
     *
     * @param string $host     Host del servidor de la base de datos.
     * @param string $dbname   Nombre de la base de datos.
     * @param string $username Nombre de usuario de la base de datos.
     * @param string $password Contraseña de la base de datos.
     * @param string $port     Puerto del servidor de la base de datos (opcional, por defecto 3306).
     */
    public function __construct(string $host, string $dbname, string $username, string $password, string $port = '3306')
    {
        $this->host = $host;
        $this->dbname = $dbname;
        $this->username = $username;
        $this->password = $password;
        $this->port = $port;
    }

    /**
     * Establece y devuelve la conexión PDO a la base de datos.
     *
     * @return ?PDO La instancia de PDO si la conexión es exitosa, null si falla.
     */
    public function conectar(): ?PDO
    {
        // 🧐 Verificar si ya existe una conexión para evitar redundancias.
        if ($this->pdo === null) {
            $dsn = "mysql:host={$this->host};port={$this->port};charset=utf8mb4";

            try {
                // 🔑 Crear una nueva conexión PDO con manejo de UTF-8 y configuración de errores.
                $this->pdo = new PDO($dsn, $this->username, $this->password, [
                    PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8mb4", // ⚙️ Establecer la codificación a UTF-8.
                    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,           // 🚨 Reportar errores como excepciones.
                    PDO::ATTR_EMULATE_PREPARES => false,                    // 🛡️ Deshabilitar la emulación de preparaciones por seguridad.
                ]);

                echo "✅ Conexión exitosa al servidor MySQL.<br>";

                // 🏗️ Crear la base de datos si no existe.
                $this->crearBaseDeDatosSiNoExiste();
                // 🎯 Seleccionar la base de datos para las futuras operaciones.
                $this->seleccionarBaseDeDatos();

                echo "🎉 ¡Conexión exitosa a la base de datos '{$this->dbname}'! 🎉<br>";

            } catch (PDOException $e) {
                // ❌ Capturar cualquier error de conexión y mostrar el mensaje.
                echo "Error de conexión: " . $e->getMessage() . "<br>";
                die(); // 🛑 Detener la ejecución si la conexión falla.
            }
        }
        return $this->pdo; // 🔗 Devolver la instancia de la conexión PDO.
    }

    /**
     * Crea la base de datos si no existe. (Método privado)
     *
     * @return void
     */
    private function crearBaseDeDatosSiNoExiste(): void
    {
        $sqlCreateDb = "CREATE DATABASE IF NOT EXISTS `{$this->dbname}` CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci";
        try {
            $this->pdo->exec($sqlCreateDb);
            echo "Base de datos '{$this->dbname}' creada o ya existe.<br>";
        } catch (PDOException $e) {
            echo "Error al crear la base de datos: " . $e->getMessage() . "<br>";
            die();
        }
    }

    /**
     * Selecciona la base de datos para la conexión actual. (Método privado)
     *
     * @return void
     */
    private function seleccionarBaseDeDatos(): void
    {
        $dsnConDb = "mysql:host={$this->host};port={$this->port};dbname={$this->dbname};charset=utf8mb4";
        try {
            $this->pdo = new PDO($dsnConDb, $this->username, $this->password, [
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_EMULATE_PREPARES => false,
            ]);
        } catch (PDOException $e) {
            echo "Error al seleccionar la base de datos '{$this->dbname}': " . $e->getMessage() . "<br>";
            die();
        }
    }

    /**
     * Cierra la conexión PDO estableciendo la instancia a null. 🔌
     *
     * @return void
     */
    public function desconectar(): void
    {
        $this->pdo = null;
        echo "🔌 Conexión a la base de datos cerrada.<br>";
    }

    /**
     * Ejecuta una consulta SQL con parámetros opcionales.
     *
     * @param string $sql        La consulta SQL a ejecutar.
     * @param array  $parametros Un array de parámetros para enlazar a la consulta (opcional).
     * @return ?\PDOStatement El objeto PDOStatement resultante o null en caso de error.
     */
    public function ejecutarConsulta(string $sql, array $parametros = []): ?\PDOStatement
    {
        try {
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute($parametros);
            return $stmt;
        } catch (PDOException $e) {
            echo "Error al ejecutar la consulta: " . $e->getMessage() . "<br>";
            return null;
        }
    }

    /**
     * Obtiene la primera fila de resultados de una consulta.
     *
     * @param string $sql        La consulta SQL a ejecutar.
     * @param array  $parametros Un array de parámetros para enlazar a la consulta (opcional).
     * @return ?array Un array asociativo representando la primera fila, o null si no hay resultados.
     */
    public function obtenerFila(string $sql, array $parametros = []): ?array
    {
        $stmt = $this->ejecutarConsulta($sql, $parametros);
        return $stmt ? $stmt->fetch(PDO::FETCH_ASSOC) : null;
    }

    /**
     * Obtiene todos los resultados de una consulta.
     *
     * @param string $sql        La consulta SQL a ejecutar.
     * @param array  $parametros Un array de parámetros para enlazar a la consulta (opcional).
     * @return array Un array de arrays asociativos representando todos los resultados.
     */
    public function obtenerResultados(string $sql, array $parametros = []): array
    {
        $stmt = $this->ejecutarConsulta($sql, $parametros);
        return $stmt ? $stmt->fetchAll(PDO::FETCH_ASSOC) : [];
    }

    /**
     * Obtiene el ID de la última fila insertada.
     *
     * @return string El ID de la última fila insertada como una cadena.
     */
    public function obtenerUltimoIdInsertado(): string
    {
        return $this->pdo->lastInsertId();
    }
    /**
     * Ejecuta una consulta SQL sin esperar resultados.
     *
     * @param string $sql La consulta SQL a ejecutar.
     * @return bool True si la consulta se ejecutó con éxito, false en caso de error.
     */
    public function ejecutarNonQuery(string $sql): bool
    {
        try {
            return $this->pdo->exec($sql) !== false;
        } catch (PDOException $e) {
            echo "Error al ejecutar la consulta: " . $e->getMessage() . "<br>";
            return false;
        }
    }
}

?>