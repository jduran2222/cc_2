<?php 
require_once("../include/session.php"); 
$where_c_coste=" id_c_coste={$_SESSION['id_c_coste']} " ;

 //echo "El filtro es:{$_GET["filtro"]}";

$tabla=($_GET["tabla"])  ;
$wherecond=$_GET["wherecond"]  ;
$field=$_GET["field"]  ;

 require_once("../../conexion.php");
 require_once("../include/funciones.php");
 
echo Dfirst( "$field"  , "`$tabla`", $wherecond . " AND $where_c_coste") ; 
//echo "7" ; 
     
	  
 $Conn->close();



?>