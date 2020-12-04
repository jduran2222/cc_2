<?php 
require_once("../include/session.php"); 
$where_c_coste=" id_c_coste={$_SESSION['id_c_coste']} " ;


$id_obra=$_GET["id_obra"]  ;
$id_produccion=$_GET["id_produccion"]  ;

require_once("../../conexion.php");
require_once("../include/funciones.php");
 

if ($id_produccion=Dfirst("ID_PRODUCCION", 'Prod_view', "ID_OBRA=$id_obra AND ID_PRODUCCION=$id_produccion AND $where_c_coste")) // confirm COHERENCIA d DATOS
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
    echo 'ERROR. Incoherencia en datos' ;
}   


?>