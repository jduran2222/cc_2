<?php
require_once("../include/session.php");
$where_c_coste=" id_c_coste={$_SESSION['id_c_coste']} " ;


$tipo_entidad=$_GET["tipo_entidad"];                 // TABLA DONDE COGER EL REGISTRO-FICHA
$id_entidad=$_GET["id_entidad"];        // campo index primary (clave) a utilizar en la búsqueda


//
// require_once("../../conexion.php");
 require_once("../include/funciones.php");


$entidad_link = entidad_link($tipo_entidad) ;
echo ($entidad_link=="#") ?  cc_page_error("ENTIDAD SIN LINK ASOCIADO") : "<script> window.location='{$entidad_link}{$id_entidad}'; </script>"  ;



?>
	 
