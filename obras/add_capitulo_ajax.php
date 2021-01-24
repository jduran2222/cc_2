<?php 
require_once("../include/session.php"); 
$where_c_coste=" id_c_coste={$_SESSION['id_c_coste']} " ;

 //echo "El filtro es:{$_GET["filtro"]}";

$id_obra=$_GET["id_obra"]  ;
$capitulo= isset($_GET["capitulo"]) ? quita_simbolos_mysql( $_GET["capitulo"] ) : 'capitulo nuevo'  ;
$id_udo= isset($_GET["id_udo"]) ? $_GET["id_udo"] : 0  ;
$no_ajax= isset($_GET["no_ajax"])   ;  // para cuando lo llamamos por href y no por AJAX 

require_once("../../conexion.php");
require_once("../include/funciones.php");
 
if ($id_capitulo=DInsert_into("Capitulos", "(ID_OBRA,CAPITULO , user)" , "($id_obra,'$capitulo','{$_SESSION["user"]}' )", "ID_CAPITULO","ID_OBRA=$id_obra")  )           //{$_SESSION["user"]}
   { 
    if($id_udo){
        $result_UPDATE=$Conn->query("UPDATE `Udos` SET `ID_CAPITULO` = $id_capitulo WHERE ID_UDO=$id_udo  AND ID_OBRA=$id_obra" );
    }
    
     echo ($no_ajax) ?  "<script languaje='javascript' type='text/javascript'>window.close();</script>" : $id_capitulo  ;
    }  
   else
   { echo "ERROR: al crear capítulo" ; }  
 

?>