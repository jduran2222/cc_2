<?php
require_once("../include/session.php");
$where_c_coste=" id_c_coste={$_SESSION['id_c_coste']} " ;	


// registramos el documento en la bbdd
require_once("../../conexion.php"); 
require_once("../include/funciones.php"); 

		
$id_obra=$_GET["id_obra"];
//$fecha=date('Y-m-d');

         
 if ($id_subobra=  DInsert_into('SubObras', '( ID_OBRA,SUBOBRA ,`user` ) ', "(  '$id_obra', 'subobra nueva' , '{$_SESSION["user"]}' )", 'ID_SUBOBRA', "ID_OBRA=$id_obra")) //compruebo si se ha creado la obra
             {  // 	$id_pof=Dfirst( "MAX(ID_POF)", "POF_lista", "id_c_coste={$_SESSION["id_c_coste"]}" ) ; 
	        // TODO OK-> Entramos a pagina_inicio.php
//	       echo "POF creada satisfactoriamente." ;
//		echo  "Ir a POF <a href=\"../pof/pof.php?id_pof=$id_pof\" title='ver pof'> $id_pof</a>" ;
                echo "<META HTTP-EQUIV='REFRESH' CONTENT='0;URL=../obras/subobra_ficha.php?id_subobra=$id_subobra'>" ;

	     }
	       else
	     {
		echo "<BR><BR><BR>Error al crear SUBOBRA, inténtelo de nuevo " ;
		echo  "<BR><a href='javascript:window.close();' title='cerrar'>CERRAR</a>" ;
	     }
       

?>