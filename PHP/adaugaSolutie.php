<?php

$cod = $_POST['input_cod'];

echo $cod;


$file='main.c';
file_put_contents($file, $cod);

echo '<br>';


//echo $output;

?>



