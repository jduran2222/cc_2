<?php
require_once("../include/session.php");
$where_c_coste=" id_c_coste={$_SESSION['id_c_coste']} " ;	


// registramos el documento en la bbdd
require_once("../../conexion.php"); 
require_once("../include/funciones.php"); 


//$fecha=date('Y-m-d');

$hashtag = isset($_GET["hashtag"]) ? $_GET["hashtag"] : '' ;
//$indice = isset($_GET["indice"]) ? $_GET["indice"] : '' ;
//$id_entidad = isset($_GET["id_entidad"]) ? $_GET["id_entidad"] : 0 ;

$numero_nuevo=Dfirst('MAX(Numero)','Procedimientos',$where_c_coste) + 1  ;

$sql="INSERT INTO `Procedimientos` ( id_c_coste,numero,hashtag, user) "
        . "   VALUES (  '{$_SESSION['id_c_coste']}','$numero_nuevo','$hashtag','{$_SESSION['user']}' );" ;
  // echo ($sql);
$result=$Conn->query($sql);
           
if ($result) //compruebo si se ha creado la obra
             { 	
              $id_procedimiento=Dfirst( "MAX(id_procedimiento)", "Procedimientos", "id_c_coste={$_SESSION["id_c_coste"]}" ) ; 
	        // TODO OK-> Entramos a pagina_inicio.php
//	       echo "factura proveedor creada satisfactoriamente." ;
//		echo  "Ir a factura proveedor <a href=\"../proveedores/factura_proveedor.php?id_fra_prov=$id_fra_prov\" title='ver fra_prov'> $id_fra_prov</a>" ;
                echo "<META HTTP-EQUIV='REFRESH' CONTENT='0;URL=../agenda/procedimiento_ficha.php?id_procedimiento=$id_procedimiento'>" ;

	     }
	       else
	     {
		echo "Error al crear registro, inténtelo de nuevo " ;
		echo  "<a href='javascript:history.back(-1);' title='Ir la página anterior'>Volver</a>" ;
	     }
       

?>