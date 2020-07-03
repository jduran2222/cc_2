<?php
require_once("../include/session.php");
$where_c_coste=" id_c_coste={$_SESSION['id_c_coste']} " ;	

// registramos el documento en la bbdd
require_once("../../conexion.php"); 
require_once("../include/funciones.php"); 

		

//$id_obra= getVar('id_obra_gg');
$id_proveedor= isset($_GET["id_proveedor"]) ? $_GET["id_proveedor"] : getVar('id_proveedor_auto') ;
$id_obra= isset($_GET["id_obra"]) ? $_GET["id_obra"] : getVar('id_obra_gg') ;

$id_cuenta= isset($_GET["id_cuenta"]) ? $_GET["id_cuenta"] 
        : ( ($id_cuenta_auto=Dfirst("id_cuenta_auto","Proveedores","$where_c_coste AND ID_PROVEEDORES=$id_proveedor")) ?  $id_cuenta_auto 
        : getVar('id_cuenta_auto') ) ;


// posibles asociaciones a Entidades desde la que se crea el Concepto nuevo
$id_usub= isset($_GET["id_usub"]) ? $_GET["id_usub"] : "" ;  // si viene un USUB es porque esta asociado a una UNIDAD SUBCONTRATADA
$id_obra_concepto_mq=isset($_GET["id_obra_concepto_mq"]) ? $_GET["id_obra_concepto_mq"] : "" ;  // si viene un USUB es porque esta asociado a una UNIDAD SUBCONTRATADA

$concepto= isset($_GET["concepto"]) ? $_GET["concepto"] : 'concepto nuevo' ;

//$id_proveedor= getVar('id_proveedor_auto');

//$fecha=date('Y-m-d');

$sql="INSERT INTO `CONCEPTOS` ( ID_OBRA,ID_CUENTA,ID_PROVEEDOR,CONCEPTO,`user` )    VALUES (  '$id_obra','$id_cuenta' ,'$id_proveedor','$concepto' ,'{$_SESSION["user"]}' );" ;
// echo ($sql);
$result=$Conn->query($sql);
          
 if ($result) //compruebo si se ha creado la obra
             { 	$id_concepto=Dfirst( "MAX(ID_CONCEPTO)", "Conceptos_View", "id_c_coste={$_SESSION["id_c_coste"]}" ) ; 
	        // TODO OK-> Entramos a pagina_inicio.php
//	       echo "ficha personal creada satisfactoriamente." ;
//		echo  "Ir a ficha personal <a href=\"../personal/personal_ficha.php?id_personal=$id_personal\" title='ver ficha'> $id_personal</a>" ;
              // ejecutamos las vinculaciones a posibles Entidades
               if ($id_usub) {
                $result_UPDATE=$Conn->query("UPDATE `Subcontrato_conceptos` SET `id_concepto` = $id_concepto WHERE id=$id_usub" );
               }
               if ($id_obra_concepto_mq) {
                $result_UPDATE=$Conn->query("UPDATE `OBRAS` SET `id_concepto_mq` = $id_concepto WHERE ID_OBRA=$id_obra_concepto_mq" );
               }
                echo "<META HTTP-EQUIV='REFRESH' CONTENT='0;URL=../proveedores/concepto_ficha.php?id_concepto=$id_concepto'>" ;

	     }
	       else
	     {
		echo "Error al crear ficha nueva, inténtelo de nuevo " ;
		echo  "<a href='javascript:history.back(-1);' title='Ir la página anterior'>Volver</a>" ;
	     }
       

?>