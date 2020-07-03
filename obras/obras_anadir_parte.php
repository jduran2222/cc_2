<?php
require_once("../include/session.php");
$where_c_coste=" id_c_coste={$_SESSION['id_c_coste']} " ;	


// registramos el documento en la bbdd
require_once("../../conexion.php"); 
require_once("../include/funciones.php"); 

		
$id_obra= $_GET["id_obra"];
$fecha= isset($_GET["fecha"]) ? ($_GET["fecha"]) : date('Y-m-d')   ;
$observaciones= isset($_GET["observaciones"]) ? ($_GET["observaciones"]) : ''   ;


$sql="INSERT INTO `PARTES` ( `ID_OBRA`,Fecha,Observaciones, `user` )    VALUES (  '$id_obra','$fecha','$observaciones' , '{$_SESSION["user"]}' );" ;
// echo ($sql);
$result=$Conn->query($sql);
          
 if ($result) //compruebo si se ha creado la obra
             { 	$id_parte=Dfirst( "MAX(ID_PARTE)", "Partes_View", "id_c_coste={$_SESSION["id_c_coste"]}" ) ; 
	        // TODO OK-> Entramos a pagina_inicio.php
//	       echo "Parte Diario creado satisfactoriamente." ;
//		echo  "Ir a Parte diario <a href='../personal/parte.php?id_parte=$id_parte' title='ver Parte Diario'> $id_parte</a>" ;
                echo "<META HTTP-EQUIV='REFRESH' CONTENT='0;URL=../personal/parte.php?id_parte=$id_parte'>" ;
                

	     }
	       else
	     {
		echo "Error al crear Parte Diario, inténtelo de nuevo " ;
		echo  "<a href='javascript:history.back(-1);' title='Ir la página anterior'>Volver</a>" ;
	     }
       

?>