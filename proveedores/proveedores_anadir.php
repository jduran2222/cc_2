<?php
require_once("../include/session.php");
?>
<?php



$proveedor =  isset($_GET["proveedor"]) ?  $_GET["proveedor"] : (isset($_POST["proveedor"]) ?  $_POST["proveedor"] : 'proveedor nuevo'  ) ;
$cif =  isset($_GET["cif"]) ?  $_GET["cif"] : (isset($_POST["cif"]) ?  $_POST["cif"] : 'B99999999'  ) ;

$id_fra_prov =  isset($_GET["id_fra_prov"]) ?  $_GET["id_fra_prov"] : "" ;  // variables que harán actualizar campos de otras tablas
$id_personal =  isset($_GET["id_personal"]) ?  $_GET["id_personal"] : "" ;
$id_pof_proveedor =  isset($_GET["id_pof_proveedor"]) ?  $_GET["id_pof_proveedor"] : "" ;

$tipo_prov= ($id_personal)? "N"  :  "G" ;    // indicamos el tipo de proveedor Nomina, General, Banco, 

//if (isset($_POST["proveedor"]))
//{
//    $proveedor=strtoupper(ltrim(rtrim($_POST["proveedor"]))) ;
//    $cif= str_replace( [" ","-",".", "," ] ,"", strtoupper($_POST["cif"]) ) ;  // quitamos simbolos y hacemos mayusculas
//}
// else
//{
//    $proveedor='proveedor nuevo' ;
//    $cif= 'B99999999'  ;  // quitamos simbolos y hacemos mayusculas
////    $concepto='Gastos de proveedor' ;// variables que harán actualizar campos de otras tablas
//$id_personal =  isset($_GET["id_personal"]) ?  $_GET["id_personal"] : "" ;

//if (isset($_POST["proveedor"]))
//{
//    $proveedor=strtoupper(ltrim(rtrim($_POST["proveedor"]))) ;
//    $cif= str_replace( [" ","-",".", "," ] ,"", strtoupper($_POST["cif"]) ) ;  // quitamos simbolos y hacemos mayusculas
//}
// else
//{
//    $proveedor='proveedor nuevo' ;
//    $cif= 'B99999999'  ;  // quitamos simbolos y
//    
//}

// registramos el documento en la bbdd
require_once("../../conexion.php"); 
require_once("../include/funciones.php"); 

		

$sql="INSERT INTO `Proveedores` ( `id_c_coste`,proveedor, CIF,tipo_prov, `user` )    VALUES ( {$_SESSION["id_c_coste"]} , '$proveedor', '$cif' , '$tipo_prov' , '{$_SESSION["user"]}' );" ;
 //echo ($sql);
$result=$Conn->query($sql);
          
 if ($result) //compruebo si se ha creado el cliente
           {   $id_proveedor=Dfirst( "MAX(ID_PROVEEDORES)", "Proveedores", " $where_c_coste " ) ; 
           
                // creamos el CONCEPTO POR DEFECTO
                $id_obra_gg = getVar("id_obra_gg") ;
                $id_cuenta =  ($id_personal)?  getVar("id_cuenta_mo")  :  getVar("id_cuenta_auto") ;  // si el proveedor es PROVEEDOR-NOMINA el concepto es CUENTA GASTO 'MANO OBRA APLICADA'
                


                $sql4 =  "INSERT INTO `CONCEPTOS` ( ID_PROVEEDOR,ID_OBRA,ID_CUENTA,CONCEPTO,COSTE,`user` ) ";
                $sql4 .= "VALUES ( '$id_proveedor', '$id_obra_gg','$id_cuenta' ,'Gastos de $proveedor' ,'1', '{$_SESSION["user"]}' );" ;

    //                    echo ($sql4);
                $result4=$Conn->query($sql4);

                // rescato el nuevo id_concepto creado y lo asigno a la variable id_concepto_auto
                $id_concepto_auto=Dfirst( "MAX(ID_CONCEPTO)", "CONCEPTOS", "ID_PROVEEDOR=$id_proveedor AND COSTE=1" ) ; 

                // registro su valor en su Proveedor
                $result5=$Conn->query("UPDATE `Proveedores` SET `id_concepto_auto` = $id_concepto_auto WHERE ID_PROVEEDORES=$id_proveedor;" );
                
               // si venimos de la ficha de una factura proveedor le cambiamos el proveedor a la factura
                if ($id_fra_prov) {
                $result_UPDATE=$Conn->query("UPDATE `FACTURAS_PROV` SET `ID_PROVEEDORES` = $id_proveedor WHERE ID_FRA_PROV=$id_fra_prov" );
               }
               // si venimos de la ficha de PERSONAL le cambiamos el proveedor aL ID_PERSONAL
                if ($id_personal) {
                $result_UPDATE=$Conn->query("UPDATE `PERSONAL` SET `id_proveedor_nomina` = $id_proveedor WHERE ID_PERSONAL=$id_personal  AND $where_c_coste" );
               }
               // si venimos de la ficha de POF PROVEEDOR le cambiamos el proveedor aL ID_PERSONAL
                if ($id_pof_proveedor) {
                $result_UPDATE=$Conn->query("UPDATE `POF_DETALLE` SET `id_proveedor` = $id_proveedor WHERE id=$id_pof_proveedor" );
               }

                
//	       echo  "Ir al proveedor <a href='../proveedores/proveedores_ficha.php?id_proveedor=$id_proveedor' title='ver proveedor'> $proveedor</a>" ;
                if ($id_personal) {
                    echo "<META HTTP-EQUIV='REFRESH' CONTENT='0;URL=../personal/personal_ficha.php?id_personal=$id_personal'>" ;
                }
                else {
                    echo "<META HTTP-EQUIV='REFRESH' CONTENT='0;URL=../proveedores/proveedores_ficha.php?id_proveedor=$id_proveedor'>" ;
                }   
	   }
	    else
	   {
	       echo "Error al crear proveedor, inténtelo de nuevo " ;
	       echo  "<a href='javascript:history.back(-1);' title='Ir la página anterior'>Volver</a>" ;
	   }
       

?>