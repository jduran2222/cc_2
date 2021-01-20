<?php 
require_once("../include/session.php"); 
$where_c_coste=" id_c_coste={$_SESSION['id_c_coste']} " ;

 //echo "El filtro es:{$_GET["filtro"]}"; 

$id_obra=$_GET["id_obra"]  ;

require_once("../../conexion.php");
require_once("../include/funciones.php");
 

//if ($id_obra=Dfirst("ID_OBRA", 'OBRAS', "ID_OBRA=$id_obra AND $where_c_coste"))    
if ($rs=Drow( 'OBRAS', "ID_OBRA=$id_obra AND $where_c_coste"))    
{
    
//   $id_prod_estudio_costes = Dfirst("id_prod_estudio_costes", "OBRAS", "ID_OBRA=$id_obra AND $where_c_coste  ")  ;
   $id_obra = $rs["ID_OBRA"] ; // confirmacion de SEGURIDAD
   $id_prod_estudio_costes = $rs["id_prod_estudio_costes"] ;
   $id_subobra_auto = $rs["id_subobra_auto"] ;
 
   $sql= "DELETE FROM `PRODUCCIONES_DETALLE`  WHERE ID_PRODUCCION=$id_prod_estudio_costes "  ;     // vaciamos la id_produccion_estudio_coste solamente, las otras RV , por seguridad, deben de hacerlo manualmente    
   $Conn->query($sql) ;
  
    
   $sql= "DELETE FROM `Udos`  WHERE ID_OBRA=$id_obra "  ;     // ejecuto DELETE
   $Conn->query($sql) ;
   
   $sql= "DELETE FROM `Capitulos`  WHERE ID_OBRA=$id_obra "  ;     // ejecuto DELETE
   $Conn->query($sql) ;

   $sql= "DELETE FROM `SubObras`  WHERE ID_OBRA=$id_obra AND ID_SUBOBRA<>'$id_subobra_auto' "  ;     // ejecuto DELETE
   $Conn->query($sql) ;

}
else
{
    echo cc_page_error( 'ERROR: Obra no encontrada al tratar de borrar PROYECTO') ;
}   
//echo "<script languaje='javascript' type='text/javascript'>window.close();</script>"; 


?>