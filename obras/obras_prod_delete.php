<?php 
require_once("../include/session.php"); 
$where_c_coste=" id_c_coste={$_SESSION['id_c_coste']} " ;

require_once("../../conexion.php");
require_once("../include/funciones.php");


if (!$rs_obra=Drow( "OBRAS" , " $where_c_coste AND ID_OBRA={$_GET["id_obra"]}")) { cc_die("ERROR, datos inconsistentes") ;}
if (!$id_produccion=Dfirst("ID_PRODUCCION", "PRODUCCIONES", "ID_OBRA={$rs_obra["id_obra"]}  AND ID_PRODUCCION{$_GET["id_produccion"]} " )) { cc_die("ERROR, datos inconsistentes") ;}

 
//if ($id_produccion=Dfirst("ID_PRODUCCION", 'Prod_view', "ID_OBRA=$id_obra AND ID_PRODUCCION=$id_produccion AND $where_c_coste")) // confirm COHERENCIA d DATOS

if ($id_produccion<>$rs_obra["id_prod_estudio_costes"] AND $id_produccion<>$rs_obra["id_produccion_obra"] ) // las idESTUDIO COSTES y id PRODCCION OBRA no pueden borrarse
{
  $sql= "DELETE FROM `PRODUCCIONES_DETALLE`  WHERE ID_PRODUCCION=$id_produccion "  ;     // ejecuto DELETE
     
  logs( $sql );
  $Conn->query($sql) ;
   
  $sql= "DELETE FROM `PRODUCCIONES`  WHERE ID_PRODUCCION=$id_produccion AND ID_OBRA=$id_obra "  ;     // ejecuto DELETE

  logs( $sql );
  $Conn->query($sql) ;
   
//      echo "<br>". $sql .  "  Resultado: " . $Conn->query($sql) ;

   
   echo "<script languaje='javascript' type='text/javascript'>window.close();</script>";     // cerramos pantalla

}
else
{
    echo 'ERROR. las Relaciones valoradas ESTUDIO DE COSTES y PRODUCCION OBRA no pueden borrarse' ;
}   


?>