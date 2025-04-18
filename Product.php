<?php
//file: Product.php
require_once "./Connection.php";


class Product extends Connection {
    // ⚙️ Campos de la tabla 'products'
    public ?int $id = null;
    public ?string $name = null;
    public ?string $description = null;
    public ?string $created_at = null;


    /**
     * 🔗 Constructor de la clase Product.
     * Establece la conexión a la base de datos al instanciar la clase padre.
     */
    public function __construct() {
        parent::__construct(); // ✅ Llama al constructor de la clase padre (Connection) para establecer la conexión
    }


    /**
     * 📜 Obtiene todos los productos de la base de datos y los muestra en la consola.
     *
     * @return void
     */
    public function getAll(): void {
        echo "\n[+] Obteniendo todos los productos...\n";
        if ($this->connection) {
            $stmt = $this->connection->prepare("SELECT id, name FROM products"); // ✍️ Seleccionamos solo id y name para este ejemplo
            if ($stmt) {
                $stmt->execute();
                $result = $stmt->get_result();


                if ($result->num_rows > 0) {
                    echo "[+] Se encontraron " . $result->num_rows . " productos:\n";
                    while ($row = $result->fetch_assoc()) {
                        echo "  ID: " . $row['id'] . "\tNombre: " . $row['name'] . "\n";
                    }
                } else {
                    echo "[i] No se encontraron productos en la base de datos.\n";
                }
                $stmt->close(); // 🔒 Cierra la declaración preparada
            } else {
                echo "[-] Error al preparar la consulta getAll(): " . $this->connection->error . "\n";
            }
        } else {
            echo "[-] No hay conexión a la base de datos para getAll().\n";
        }
    }


    /**
     * 🔍 Busca un producto por su ID y muestra su información en la consola.
     *
     * @param int $id El ID del producto a buscar.
     * @return ?array<string, mixed> Un array asociativo con la información del producto o null si no se encuentra.
     */
    public function find(int $id): ?array {
        echo "\n[+] Buscando producto con ID: " . $id . "...\n";
        $product = null;
        if ($this->connection) {
            $stmt = $this->connection->prepare("SELECT id, name, description, created_at FROM products WHERE id = ?");
            if ($stmt) {
                $stmt->bind_param('i', $id);
                $stmt->execute();
                $result = $stmt->get_result();
                $product = $result->fetch_assoc();


                if ($product) {
                    echo "[+] Producto encontrado:\n";
                    print_r($product);
                } else {
                    echo "[i] No se encontró ningún producto con el ID: " . $id . ".\n";
                }
                $stmt->close();
            } else {
                echo "[-] Error al preparar la consulta find(): " . $this->connection->error . "\n";
            }
        } else {
            echo "[-] No hay conexión a la base de datos para find().\n";
        }
        return $product;
    }


    /**
     * ➕ Crea un nuevo producto en la base de datos y muestra el resultado en la consola.
     *
     * @param string $name La nombre del producto.
     * @param string $description La descripción del producto.
     * @return ?int El ID del nuevo producto insertado o null en caso de error.
     */
    public function create(string $name, string $description): ?int {
        echo "\n[+] Intentando crear un nuevo producto: Nombre = '" . $name . "', Descripción = '" . $description . "'...\n";
        $newProductId = null;
        if ($this->connection) {
            $stmt = $this->connection->prepare("INSERT INTO products (name, description, created_at) VALUES (?, ?, NOW())"); // ⏱️ 'NOW()' para la fecha de creación
            if ($stmt) {
                $stmt->bind_param('ss', $name, $description);
                if ($stmt->execute()) {
                    $newProductId = $this->connection->insert_id; // 🔑 Obtenemos el ID del último registro insertado
                    echo "[+] Producto creado con ID: " . $newProductId . "\n";
                } else {
                    echo "[-] Error al ejecutar la consulta create(): " . $stmt->error . "\n";
                }
                $stmt->close();
            } else {
                echo "[-] Error al preparar la consulta create(): " . $this->connection->error . "\n";
            }
        } else {
            echo "[-] No hay conexión a la base de datos para create().\n";
        }
        return $newProductId;
    }
}


$product = new Product();
$product->find(2);
$product->create("power", "bost x100");
$product->getAll(); // Llamamos a getAll para ver la lista de productos después de la creación


// Ejemplo de qué está haciendo el sql (esto es solo un comentario, no se ejecuta)
// -- SELECT * FROM products WHERE id = 2;
// -- INSERT INTO products (name, description, created_at) VALUES ('power', 'bost x100', NOW());
// -- SELECT * FROM products;

—--------

<?php
//file: User.php
include 'Connection.php';


class User extends Connection{
    // Definimos los atributos del Usuario
    public $id;
    public $name;
    public $age;
    public $email;
    public $password;
    public $created_at;
    public $updated_at;


    // Registro de un nuevo usuario
    public function create(){
        $this->connect();
        $stmt = mysqli_prepare(
            $this->connection,
            "INSERT INTO users (name, age, email, password) VALUES (?, ?, ?, ?)"
        );
        $stmt->bind_param("siss", $this->name, $this->age, $this->email, $this->password);
        $stmt->execute();
        $stmt->close();
    }


    // Obtener todos los usuarios
    public function getAll(){
        $this->connect();
        $stmt = mysqli_prepare($this->connection, "SELECT * FROM users");
        $stmt->execute();
        $result = $stmt->get_result();
        // Lista de usuarios
        $users = array();


        // Recorremos el resultado y lo guardamos en un array
        while ($row = $result->fetch_assoc()) {
            array_push($users, $row);
        }
        return $users;
    }


    // Obtener un usuario por su id
    public function getFirst($id){
        $this->connect();
        $stmt = mysqli_prepare($this->connection, "SELECT * FROM users WHERE id = ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_assoc();
    }


    // Actualizar un usuario
    public function update($id){
        $this->connect();
        $stmt = mysqli_prepare(
            $this->connection,
            "UPDATE users SET name = ?, age = ?, email = ?, password = ? WHERE id = ?"
        );
        $stmt->bind_param("sissi", $this->name, $this->age, $this->email, $this->password, $id);
        $stmt->execute();
        $stmt->close();
    }


    // Eliminar un usuario
    public function delete($id){
        $this->connect();
        $stmt = mysqli_prepare($this->connection, "DELETE FROM users WHERE id = ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $stmt->close();
    }    
}
