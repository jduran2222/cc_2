<?php
require_once("../include/session.php");
$where_c_coste=" id_c_coste={$_SESSION['id_c_coste']} " ;	


// registramos el documento en la bbdd
require_once("../../conexion.php"); 
require_once("../include/funciones.php"); 
		
concilia_traspaso_interno( $_GET["id_mov_banco1"] ,  $_GET["id_mov_banco2"]) ; 

echo "<script languaje='javascript' type='text/javascript'>window.close();</script>"; 

