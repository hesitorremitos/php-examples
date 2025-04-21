<?php
include_once("database.php");
class Libros extends Database{
    public $db;
    private $libros;

    function __construct(){
        $this->db=Database::conexion();
        echo "Conectado a la base de datos" . '<br>';
        // mostrar libros
        $this->db->query('SELECT * FROM libros');
        
    }
    public function __destruct(){
        echo '<br>';
        echo "Desconectado de la base de datos!" . '<br>';
    }

}
$librito=new Libros();



