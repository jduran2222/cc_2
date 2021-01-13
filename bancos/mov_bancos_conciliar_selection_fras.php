<?php
require_once("../include/session.php");
$where_c_coste=" id_c_coste={$_SESSION['id_c_coste']} " ;	


// registramos el documento en la bbdd
require_once("../../conexion.php"); 
require_once("../include/funciones.php"); 
		
// DESCRIPCION DEL FICHERO:
// PHP que realiza diferentes acciones según el MODO y los parámetros de entrada y sus valores. id_mov_banco = [id_mov_banco, CAJA_METALICO, ...]
 //MODOS: MOVS_A_FRA,  SOLO_PAGO
//  pares array_str(id_mov_banco1&id_fra_prov1 - id_mov_banco2&id_fra_prov2 - .....)   conciliacion automatica de mov bancos y facturas
//   (id_mov_banco1&id_fra_prov1 - id_mov_banco2&id_fra_prov2 - .....)   conciliacion automatica de mov bancos y facturas
// muchos mov_bancos a una única factura id_fra_prov_unica
//
// MOVS_A_FRA modo Movimientos a una unica Factura


// comprobamos si es  MODO muchos mov_bancos a una única Factura

$modo=isset($_GET["modo"]) ? $_GET["modo"]: ''  ; 
//$id_cta_banco=isset($_GET["id_cta_banco"]) ? $_GET["id_cta_banco"]: ''  ; 
$id_fra_prov_unica=isset($_GET["id_fra_prov_unica"]) ? $_GET["id_fra_prov_unica"]: ''  ; 
$importe_pago=isset($_GET["importe_pago"]) ? $_GET["importe_pago"]: null  ;          // es el importe del pago a crear. Si es null se calculará el PDTE_PAGO de la factura 


//logs( "importe_pago: $importe_pago" );




// variables de control de acciones
$abrir_factura=0;            // indica si abriremos la factura al final
$actualizar_datos_factura=0;

if ($id_fra_prov_unica=='FACTURA_NUEVA')
{
//    $id_proveedor = isset($_GET["id_proveedor"]) ? $_GET["id_proveedor"] : getVar('id_proveedor_auto') ;   // si no se indica el id_proveedor lo asigno a getVar('id_proveedor_auto')
        
  $id_fra_prov_unica= factura_proveedor_anadir() ;
  $abrir_factura=1;              // abrimos la factura al final por ser factura nueva
  $actualizar_datos_factura=1;

    /// pdte creamos factura y asociamos id a su $id_fra_prov_unica
}

//logs('JUAN2:'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI']);

if ($modo=='MOVS_A_FRA')         // aquí venimos de bancos_mov_bancarios.php y mandamos varios mov.bancos a una factura, creando el Pago previamente
{
    $array_str=rawurldecode($_GET["array_str"])   ;
    $array_str=  str_replace("'", "", $array_str) ;
    $array_str=  substr($array_str, 1, strlen($array_str)-2)   ;   // quitamos los paréntesis inicial y final
    $values_mov_banco_fras_array = explode(",", $array_str);   // el array viene de un table_selection_IN() y viene en formato ('xxxxx','yyyyy'...)
//    logs('JUAN_nuevo:'.$array_str);

}elseif (isset($_GET["array_str"]))                  // venimos con array_str  (MULTIPLES conciliaciones, table_selection_IN())
{  
    $array_str=rawurldecode($_GET["array_str"])   ;
//    logs('JUAN:'.$array_str);
    $values_mov_banco_fras_array = explode("-", $array_str);

}else    // no es Array_str, solo hay una conciliacion
{
    $id_mov_banco=isset($_GET["id_mov_banco"]) ? $_GET["id_mov_banco"]: 'CAJA_METALICO'  ;         // mantenemos este mal sistema de control por compatibilidad, juand enero2021
    $modo=isset($_GET["id_mov_banco"]) ? $modo: 'CAJA_METALICO'  ;         // si no viene el parámetro id_mov_banco , suponemos que va a PAGADO POR CAJA METALICO
    $id_fra_prov=$_GET["id_fra_prov"]  ;
    $values_mov_banco_fras_array[0]= $id_mov_banco.'&'.$id_fra_prov ;      // fabricamos un elemento del array para simularlo
}    
 
//   echo $array_str.'<br>'; 
      
foreach ($values_mov_banco_fras_array as $values_mov_banco_fras)    
{
       $array_id = explode("&", $values_mov_banco_fras);            // creamos el array del par ( $id_mov_banco ,  $id_fra_prov )

    if (count($array_id)==2)          // es un par  ( $id_mov_banco ,  $id_fra_prov )  ?
    {     
        $id_mov_banco=$array_id[0]  ;
        $id_fra_prov=$array_id[1]  ;
    }
    elseif (count($array_id)==1 AND $id_fra_prov_unica )          // es un unico  ( $id_mov_banco )  estamos en modo MOVS_A_FRA
    {     
        $id_mov_banco=$array_id[0]  ;
        $id_fra_prov=$id_fra_prov_unica  ;
        $abrir_factura=1;
    }
    else                              // solo viene un parámetro por fila, es el id_fra_prov y se paga por CAJA_METALICO
    {
         $id_mov_banco= isset($_GET["id_mov_banco"]) ? $_GET["id_mov_banco"] :  'CAJA_METALICO'  ;         // compatibilizamos con la opcion de pagar con cualquier CTA_BANCO
         $modo=isset($_GET["id_mov_banco"]) ? $modo: 'CAJA_METALICO'  ;         // si no viene el parámetro id_mov_banco , suponemos que va a PAGADO POR CAJA METALICO

         $id_fra_prov=$array_id[0]  ;   
   }    
    
//        logs("MOV-FRA: $id_mov_banco - $id_fra_prov");
        
    if ($id_mov_banco)   // evitamos ERROR si id_mov_banco=0    
    {if (concilia_mov_banco_fra_prov($modo, $id_mov_banco,$id_fra_prov, $importe_pago))
       { // echo "CONCILACION CREADA: $id_mov_banco - $id_fra_prov"       ;
//         echo "<script languaje='javascript' type='text/javascript'>window.close();</script>"; 
          $id_mov_banco_valido=$id_mov_banco ;  // cogemos cualquier mov banco válido para rellenar los datos de la FACTURA_NUEVA

        }   //DEBUG 
       else 
       {  
           //echo "ERROR EN CONCILIACION: $id_mov_banco - $id_fra_prov"  ;  //anulado, juand, ene21 porque sigue saliendo el error sin serlo
       }  
      
       
//      echo $array_id[0].' & '.$array_id[1].'<br>'; 
      
      //echo "<META HTTP-EQUIV='REFRESH' CONTENT='0;URL=../bancos/conciliar_fra_prov_mov_banco.php?$values_mov_banco_fras'>" ;
    }         
           
}

// si es FACTURA_NUEVA registramos sus posibles datos de N_FRA, FECHA e IMPORTE con los datos del los MOVS_BANCOS

if ($actualizar_datos_factura)
{
    $importe_fra=Dfirst("importe_pagado", "Fras_prov_pagosV", "id_fra_prov=$id_fra_prov_unica") ;
    $fecha_fra=Dfirst("fecha_banco", "MOV_BANCOS", "id_mov_banco=$id_mov_banco_valido") ;
    $n_fra=Dfirst("Concepto", "MOV_BANCOS", "id_mov_banco=$id_mov_banco_valido") ;
    
    $sql_update= "UPDATE `FACTURAS_PROV` SET N_FRA='$n_fra' ,  FECHA='$fecha_fra' ,  IMPORTE_IVA='$importe_fra'  WHERE  ID_FRA_PROV=$id_fra_prov_unica ; "  ;
    $resultado=$Conn->query($sql_update) ;

    logs( "Actualizar Factura prov:    $sql_update , Resultado: $resultado");
}    

      
//echo ("<br>CONCILIACION MOV. BANCOS Y FACTURAS TERMINADA SATISTACTORIAMENTE");     
//echo "<META HTTP-EQUIV='REFRESH' CONTENT='0;URL=../bancos/remesa_ficha.php?id_remesa=$id_remesa'>" ;

  if ($abrir_factura)
  {   
    echo "<META HTTP-EQUIV='REFRESH' CONTENT='0;URL=../proveedores/factura_proveedor.php?id_fra_prov=$id_fra_prov'>" ;   // abrimos la unica o última factura que hemos tratado
  } else
  {   
    echo "<script languaje='javascript' type='text/javascript'>window.close();</script>" ;
  } 
      

?>