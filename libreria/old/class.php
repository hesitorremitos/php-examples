<?php
class Person{
    public $name, $email, $phone, $address, $city, $mood,$ocupacion;
    function __construct($name,$email,$phone, $address,$city,$mood, $ocupacion ) {
        $this->name = $name;
        $this->email = $email;
        $this->phone = $phone;
        $this->address = $address;
        $this->city = $city;
        $this->mood = $mood;
        $this->ocupacion = $ocupacion;
    }
    public function getName() {
        return 'accediendo a name: ' . $this->name;
    }
}
$adam= new Person('adam','adam@.com', '123456789', '1234', 'new york', 'happy', 'developer');
echo $adam->getName() . '<br>' . $adam->email . '<br>' . $adam->phone . '<br>' . $adam->address . '<br>' . $adam->city . '<br>' . $adam->mood . '<br>'
. $adam->ocupacion . '<br>';

class Estudiante extends Person{
    public $sueldo;
function __construct($name,$email,$phone, $address,$city,$mood, $ocupacion,$sueldo ) {
    parent::__construct($name,$email,$phone,$address,$city,$mood,$ocupacion);
    $this->sueldo = $sueldo;

}
}
echo '----------' . '<br>';
$estudianteOne = new Estudiante('miguel','miguel@.com', '123456789', '1234', 'new york', 'just-work!','estudiante',1000);
echo $estudianteOne->getName() . '<br>' . $estudianteOne->email . '<br>' . $estudianteOne->phone . '<br>' . $estudianteOne->address . '<br>' . $estudianteOne->city . '<br>' . $estudianteOne->mood . '<br>'
. $estudianteOne->ocupacion . '<br>'
. $estudianteOne->sueldo . '<br>';