<?php 
require_once("../include/session.php"); 
$where_c_coste=" id_c_coste={$_SESSION['id_c_coste']} " ;

 //echo "El filtro es:{$_GET["filtro"]}";

$id_obra=$_GET["id_obra"]  ;
$produccion=$_GET["produccion"]  ;
$id_actualizar= isset($_GET["id_actualizar"])? $_GET["id_actualizar"] : ""   ;

require_once("../../conexion.php");
require_once("../include/funciones.php");
 
if ($id_produccion=DInsert_into("PRODUCCIONES", "(ID_OBRA,PRODUCCION , user)" , "($id_obra,'$produccion','{$_SESSION["user"]}' )", "ID_PRODUCCION", "ID_OBRA=$id_obra AND PRODUCCION='$produccion'"))              //{$_SESSION["user"]}
   { 
   if ($id_actualizar) { $result_UPDATE=$Conn->query("UPDATE `OBRAS` SET `$id_actualizar` = $id_produccion WHERE $where_c_coste AND ID_OBRA=$id_obra" );}
   echo "<script languaje='javascript' type='text/javascript'>window.close();</script>"; // cerramos la ventana si es que se ha abierto por no ser AJAX
   }  
   else
   { echo "ERROR: al crear PRODUCCION" ; }  
 

?>