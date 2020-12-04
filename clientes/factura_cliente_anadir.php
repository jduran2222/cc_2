<?php
require_once("../include/session.php");
$where_c_coste=" id_c_coste={$_SESSION['id_c_coste']} " ;	


// registramos el documento en la bbdd
require_once("../../conexion.php"); 
require_once("../include/funciones.php"); 

	 	
if (isset($_GET["id_certificacion"]))
{
//        $result2 = $Conn->query($sql);
    $id_certificacion=$_GET["id_certificacion"] ;
    $rs = $Conn->query("SELECT * FROM Certificaciones_View WHERE id=$id_certificacion AND $where_c_coste ")->fetch_array();

    $id_certificacion=$rs["id"]  ;        // SEGURIDAD 
    $id_obra=  $rs["ID_OBRA"] ;
    $id_cliente=  $rs["ID_CLIENTE"] ;
    $importe_iva=  $rs["IMPORTE"] ;
    $iva=  $rs["iva_obra"] ;

    // si el concepto es vacío lo rellenamos por defecto con los datos de la certificación y actualizamos el Concepto en la BBDD
    if (!$rs["CONCEPTO"])
    {
       $mes_txt= cc_format($rs["FECHA"], 'mes_txt') ;
       $concepto= "Certificación Nº{$rs["NUM"]} $mes_txt ";
//       $concepto= "Certificación  Nº{$rs["NUM"]}  Octubre-2020";
//       logs("CONCEPTO: $concepto");
       $result2=$Conn->query("UPDATE `CERTIFICACIONES` SET CONCEPTO='$concepto'   WHERE id='$id_certificacion'  AND ID_OBRA='$id_obra'  ; " );
//        logs("RESULT UPDATE CONCEPTO $result2")         ;

    }else
    {
       $concepto= $rs["CONCEPTO"] ;
    }  
    
    

}    
else    
{    
    $id_obra=  (isset($_GET["id_obra"]))? ($_GET["id_obra"]) : getVar('id_obra_gg');
    $id_cliente= (isset($_GET["id_obra"]))? Dfirst("ID_CLIENTE", "OBRAS", "ID_OBRA=$id_obra AND $where_c_coste")   : getVar('id_cliente_auto');
    $concepto= (isset($_GET["concepto"]))? $_GET["concepto"]   : "";
    $importe_iva= (isset($_GET["importe_iva"]))? $_GET["importe_iva"]   : "";
    $iva= (isset($_GET["iva"]))? $_GET["iva"]   : 0.21 ;
}

$id_cta_banco= getVar('id_cta_banco_auto');
$fecha=date('Y-m-d');


// CALCULO NUMERO NUEVA FACTURA
$n_fra_nuevo=siguiente_n_fra() ;

$sql="INSERT INTO `FRAS_CLI` ( `ID_CLIENTE`,ID_OBRA,N_FRA,FECHA_EMISION,CONCEPTO,id_cta_banco,`user` )".
     "VALUES (  '$id_cliente','$id_obra','$n_fra_nuevo' ,'$fecha' ,'$concepto' ,'$id_cta_banco', '{$_SESSION["user"]}' );" ;
// echo ($sql);
$result=$Conn->query($sql);
 logs("RESULT INSERT FRAS_CLI $result")         ;
 
 if ($result) //compruebo si se ha creado la obra
             { 	
              $id_fra=Dfirst( "MAX(ID_FRA)", "Fras_Cli_Listado", " ID_CLIENTE=$id_cliente AND $where_c_coste" ) ;  
//  	       echo "factura  creada satisfactoriamente." ;
            
              // SI SE HA INDICADO EL IMPORTE SE AÑADE UN detalle  ALA FACTUA PARA QUE 
              if ($importe_iva)
              { 
                  $precio=$importe_iva/(1+$iva) ;
                  $sql="INSERT INTO `Fra_Cli_Detalles` ( `id_fra`,Cantidad,Detalle,Precio )".
                     "VALUES (  '$id_fra','1','$concepto' ,'$precio');" ;
                // echo ($sql);
                if (!($result=$Conn->query($sql))) { echo "<BR>ERROR en creacion de DETALLE DE FACTURA"; }
              }
	        // TODO OK-> Entramos a pagina_inicio.php
	       logs( "factura  creada satisfactoriamente, id_fra: $id_fra") ;
//		echo  "Ir a factura  <a href=\"../clientes/factura_cliente.php?id_fra=$id_fra\" > $id_fra</a>" ;
//               '../clientes/fra_cliente_generar_cobro_ajax.php?id_fra=
                echo "<META HTTP-EQUIV='REFRESH' CONTENT='0;URL=../clientes/fra_cliente_generar_cobro_ajax.php?id_fra=$id_fra'>" ;

	     }
	       else
	     {
		echo "Error al crear factua , inténtelo de nuevo " ;
		echo  "<a href='javascript:history.back(-1);' title='Ir la página anterior'>Volver</a>" ;
	     }
       

?>