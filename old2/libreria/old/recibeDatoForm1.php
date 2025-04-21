<?php
//convert to String
if(!$_POST){
header("Location: http://localhost/php-examples/formulario.html");
}
$name=$_POST['name'];
$genero=$_POST['genero'];
$paises=$_POST['paises'];
$terminos=$_POST['terminos'];
echo 'datos: ' . $name .'<br/>'. $genero .'<br/>'. $paises . '<br/>'. $terminos .'<br/>';

    