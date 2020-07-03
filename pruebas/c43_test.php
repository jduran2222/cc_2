<?php

include_once("../include/c43.class.php");

$argv[1]="movimientos.csb";  //juand
$c43=new C43($argv[1]);

echo "STATUS= ".$c43->status."\n";
echo "MENSAJE= ".$c43->message."\n";

echo "<br><br><br><br><br><br>";

//var_dump($c43);
echo "<pre>" ;
print_r ($c43);

echo "</pre>" ;

?>
