<?php

echo "Este es un mensaje impreso con PHP";
echo "<hr>";
echo "<br>";
echo "<br>";


/*Declaración de variables en PHP*/
echo "<h3>Declaración de variables en PHP</h3>";
$n1=5;
$n2=7.5;
$suma = $n1 + $n2;
echo "El primer número es: " . $n1;
echo "<br>";
echo "El segundo número es: " . $n2;
echo "<br>";
echo "La suma es: " . $suma;
echo "<br>";

/*Utilizando bucles en php*/
echo "<h3>Utilizando bucles en php</h3>";
for ($i=1; $i<=10; $i++){
    echo "<br>";
    echo "Número: " . $i;
}

/*Utilizando arrays en php*/
echo "<h3>Utilizando arrays en php</h3>";
/*Crear un array con los nombres de mis clientes*/
$clientes[0] = "Juan";
$clientes[1] = "Karina";
$clientes[2] = "Fernando";
$clientes[3] = "Cesar";
$clientes[4] = "Luana";
$clientes[5] = "Jorge";
$clientes[6] = "Pedro";
$clientes[7] = "Ramon";

for($j=0; $j<count($clientes); $j++){
    echo "<br>";
    echo $clientes[$j];
}

echo "<h3>Utilizando la función print_r</h3>";
print_r($clientes);

echo "<pre>";
print_r($clientes);
echo "</pre>";



echo "<h3>Utilizando la función var_dump</h3>";
echo "<pre>";
var_dump($clientes);
echo "</pre>";

