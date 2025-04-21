<?php
function sum($num1,$num2){
$result=$num1+$num2;
// echo $result;
return $result;
}
$resultadango=sum(3,2);
echo $resultadango;
$llamado=3;
function variable($llamado){
echo $llamado;
}
variable($llamado);
echo 1<=>1;
echo '<br>';
// declare(strict_types= 1);
function sum2(int $num1, int $num2){
    $result=$num1+$num2;
    echo $result;
}
function returnSum():int{
    $result='28';
    return $result;
}
echo 'segundo sum: '. returnSum('3','4') . '<br>';
echo 'primer sum: ' . sum(4,4) . '<br>';
?>