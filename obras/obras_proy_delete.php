<?php 
require_once("../include/session.php"); 
$where_c_coste=" id_c_coste={$_SESSION['id_c_coste']} " ;

 //echo "El filtro es:{$_GET["filtro"]}";

$id_obra=$_GET["id_obra"]  ;

require_once("../../conexion.php");
require_once("../include/funciones.php");
 

if ($id_obra=Dfirst("ID_OBRA", 'OBRAS', "ID_OBRA=$id_obra AND $where_c_coste"))
{
   $sql= "DELETE FROM `Udos`  WHERE ID_OBRA=$id_obra "  ;     // ejecuto DELETE
   $Conn->query($sql) ;
   
   $sql= "DELETE FROM `Capitulos`  WHERE ID_OBRA=$id_obra "  ;     // ejecuto DELETE
   $Conn->query($sql) ;

}
else
{
    echo 'error' ;
}   
//echo "<script languaje='javascript' type='text/javascript'>window.close();</script>"; 


?>