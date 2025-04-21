<?php
class Database {
    public static function conexion() {
        try {
            $db = new mysqli('localhost', 'root', '', 'libros',
            3308);
        return $db;
        } catch (Throwable $th) {
            //throw $th;
            echo 'error'. $th->getMessage() .'! '. $th->getCode() . '<br>';
            die('error en la conexión'); 
            
        }
    }
}