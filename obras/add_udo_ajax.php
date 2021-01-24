<?php 
require_once("../include/session.php"); 
$where_c_coste=" id_c_coste={$_SESSION['id_c_coste']} " ;

 //echo "El filtro es:{$_GET["filtro"]}";

$id_obra=$_GET["id_obra"]  ;
//$id_capitulo=$_GET["id_capitulo"]  ;
$id_capitulo= isset($_GET["id_capitulo"]) ? $_GET["id_capitulo"] : Dfirst("ID_CAPITULO", "Capitulos_View", "$where_c_coste AND ID_OBRA='$id_obra'")  ;

$udo= quita_simbolos_mysql( $_GET["udo"] )  ; 


require_once("../../conexion.php");
require_once("../include/funciones.php");

$id_subobra= Dfirst("id_subobra_auto","OBRAS","$where_c_coste AND ID_OBRA=$id_obra") ;
$id_subobra= $id_subobra ? $id_subobra : getVar("id_subobra_si") ;


//$id_subobra = 1 ;

if (DInsert_into("Udos", "(ID_OBRA, ID_CAPITULO , ID_SUBOBRA, UDO, user)" , "($id_obra, $id_capitulo, $id_subobra , '$udo','{$_SESSION["user"]}' )" ))      //{$_SESSION["user"]}
   { echo 1  ; }  
   else
   { 
       echo "ERROR al crear Unidad de Obra: " ;
       echo "($id_obra, $id_capitulo, $id_subobra ,  '$udo','{$_SESSION["user"]}' )"  ;}  
 

?>