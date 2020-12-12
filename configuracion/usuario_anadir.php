<?php
require_once("../include/session.php");
$where_c_coste=" id_c_coste={$_SESSION['id_c_coste']} " ;	

// registramos el documento en la bbdd
require_once("../../conexion.php"); 
require_once("../include/funciones.php"); 

		

//$id_obra= getVar('id_obra_gg');
//$id_cuenta= isset($_GET["id_cuenta"]) ? $_GET["id_cuenta"] : getVar('id_cuenta_auto') ;
//$id_obra= isset($_GET["id_obra"]) ? $_GET["id_obra"] : getVar('id_obra_gg') ;
//$id_proveedor= isset($_GET["id_proveedor"]) ? $_GET["id_proveedor"] : getVar('id_proveedor_auto') ;
//
//$concepto= isset($_GET["concepto"]) ? $_GET["concepto"] : 'concepto nuevo' ;

//$id_proveedor= getVar('id_proveedor_auto');

//$fecha=date('Y-m-d');

if ($_SESSION["admin"]  OR $_SESSION["autorizado"])
{
    $sql="INSERT INTO `Usuarios` ( id_c_coste,usuario )    VALUES (  '{$_SESSION['id_c_coste']}','nuevo_usuario' );" ;
    // echo ($sql);
    $result=$Conn->query($sql);

     if ($result) //compruebo si se ha creado la obra
                 { 	$id_usuario=Dfirst( "MAX(id_usuario)", "Usuarios", "id_c_coste={$_SESSION["id_c_coste"]}" ) ; 
                    // TODO OK-> Entramos a pagina_inicio.php
    //	       echo "ficha personal creada satisfactoriamente." ;
    //		echo  "Ir a ficha personal <a href=\"../personal/personal_ficha.php?id_personal=$id_personal\" title='ver ficha'> $id_personal</a>" ;
                    echo "<META HTTP-EQUIV='REFRESH' CONTENT='0;URL=../configuracion/usuario_ficha.php?id_usuario=$id_usuario'>" ;

                 }
                   else
                 {
                    echo "Error al crear ficha nueva, inténtelo de nuevo.\n SQL: $sql " ;
                    echo  "<a href='javascript:history.back(-1);' title='Ir la página anterior'>Volver</a>" ;
                 }
}
else
{
    cc_die("ERROR, Usuario no autorizado a añadir nuevos Usuarios"); 
}    

?>