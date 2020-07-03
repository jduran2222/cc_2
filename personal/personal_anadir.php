<?php
require_once("../include/session.php");
$where_c_coste=" id_c_coste={$_SESSION['id_c_coste']} " ;	

// registramos el documento en la bbdd
require_once("../../conexion.php"); 
require_once("../include/funciones.php"); 

		
$id_concepto_mo= getVar('id_concepto_hora_estandar');
$fecha=date('Y-m-d');

$sql="INSERT INTO `PERSONAL` ( `id_c_coste`,id_concepto_mo,NOMBRE,F_ALTA,`user` )    VALUES (  '{$_SESSION["id_c_coste"]}', '$id_concepto_mo','Apellidos, Nombre (nuevo)' ,'$fecha', '{$_SESSION["user"]}' );" ;
// echo ($sql);
$result=$Conn->query($sql);
          
 if ($result) //compruebo si se ha creado la obra
             { 	$id_personal=Dfirst( "MAX(ID_PERSONAL)", "PERSONAL", "id_c_coste={$_SESSION["id_c_coste"]}" ) ; 
	        // TODO OK-> Entramos a pagina_inicio.php
//	       echo "ficha personal creada satisfactoriamente." ;
//		echo  "Ir a ficha personal <a href=\"../personal/personal_ficha.php?id_personal=$id_personal\" title='ver ficha'> $id_personal</a>" ;
                echo "<META HTTP-EQUIV='REFRESH' CONTENT='0;URL=../personal/personal_ficha.php?id_personal=$id_personal'>" ;

	     }
	       else
	     {
		echo "Error al crear ficha personal, inténtelo de nuevo " ;
		echo  "<a href='javascript:history.back(-1);' title='Ir la página anterior'>Volver</a>" ;
	     }
       

?>