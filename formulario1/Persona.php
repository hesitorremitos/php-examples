<?php
class Persona{
    public $nombre,$ci,$email,$fecha_nac;
    public function __construct($nombre,$ci,$email,$fecha_nac){
        $this->nombre=$nombre;
        $this->ci=$ci;
        $this->email=$email;
        $this->fecha_nac=$fecha_nac;
    }
    public function saludar($nombre,$ci,$email,$fecha_nac){
        echo " saluda el ".$nombre."con ci: ".$ci." email: ".$email . " fecha nacimiento: ".$fecha_nac;
    }
}
?>