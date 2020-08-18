<?php
// cambios
require_once("../include/session.php");
$where_c_coste = " id_c_coste={$_SESSION['id_c_coste']} ";
$id_c_coste = $_SESSION['id_c_coste'];

$_m.='\mov_banco';

$titulo = 'Mov. Bancario Ficha';

//INICIO
include_once('../templates/_inc_privado1_header.php');
include_once('../templates/_inc_privado2_navbar.php');

?>

        <!-- Contenido principal 
        <div class="container-fluid bg-light">
            <div class="row">
                <!--****************** ESPACIO LATERAL  *****************
                <div class="col-12 col-md-4 col-lg-3"></div>
                <!--****************** ESPACIO LATERAL  *****************

                <!--****************** BUSQUEDA GLOBAL  *****************
                <!--<div class="col-12 col-md-4 col-lg-9">-->	


<?php 

 //require("../proveedores/proveedores_menutop_r.php");

                          // DATOS   FICHA . PHP
 
 // dividir en dos un MOV_BANCOS
 
 //echo "<pre>";
 
 
$id_mov_banco=$_GET["id_mov_banco"];



$result=$Conn->query($sql="SELECT id_mov_banco,id_remesa,id_pago,id_cta_banco,numero,fecha_banco,Concepto,Concepto2,cargo,ingreso,observaciones,conc,user "
            . " FROM MOV_BANCOS_View WHERE id_mov_banco=$id_mov_banco AND $where_c_coste");
$rs = $result->fetch_array(MYSQLI_ASSOC) ;

$titulo_pagina="Mov " . $rs["Concepto"] ;


 $id_cta_banco=$rs["id_cta_banco"] ;
 $importe=$rs["cargo"] ;
 $ingreso=$rs["ingreso"] ;
 
  $titulo="MOVIMIENTO BANCO" ;
  $updates=["id_cta_banco",'fecha_banco','numero',  'Concepto', 'Concepto2','cargo','ingreso','observaciones',]  ;
  
  $etiquetas["numero"]=["Número Mov.","Número Movimiento bancario (opcional)"];
  $formats["conc"]="semaforo_txt_CONCILIADO";
  $formats["cargo"]="moneda";
  $formats["ingreso"]="moneda";
  $selects["id_cta_banco"]=["id_cta_banco","banco","bancos_cuentas","../bancos/bancos_anadir_cta_banco_form.php","../bancos/bancos_mov_bancarios.php?id_cta_banco=","id_cta_banco" ] ;   // datos para clave foránea Y PARA AÑADIR PROVEEDOR NUEVO

//  $id_pago=$rs["id_remesa"] ;
  $tabla_update="MOV_BANCOS" ;
  $id_update="id_mov_banco" ;
  $id_valor=$id_mov_banco ;
   
  $delete_boton=1;

 $sql_insert_mov_banco= "INSERT INTO `MOV_BANCOS` (`id_cta_banco`, `numero`, `fecha_banco`, `Concepto`, `Concepto2`, cargo, ingreso, observaciones, user)" 
             ." VALUES ( '$id_cta_banco', '{$rs["numero"]}', '{$rs["fecha_banco"]}', '{$rs["Concepto"]}', '{$rs["Concepto2"]}', '{$rs["cargo"]}' "
             . " ,'{$rs["ingreso"]}','{$rs["observaciones"]}', '{$_SESSION['user']}');" ;    
     
 $sql_insert_mov_banco_simetrico= "INSERT INTO `MOV_BANCOS` (`id_cta_banco`, `numero`, `fecha_banco`, `Concepto`, `Concepto2`, cargo, ingreso, observaciones, user)" 
             ." VALUES ( '$id_cta_banco', '{$rs["numero"]}', '{$rs["fecha_banco"]}', '{$rs["Concepto"]}', '{$rs["Concepto2"]}', '{$rs["ingreso"]}' "
             . " ,'{$rs["cargo"]}','{$rs["observaciones"]}', '{$_SESSION['user']}');" ;    
     

// $sql_insert_mov_banco=base64_encode($sql_insert_mov_banco) ;
 $sql_insert_mov_banco= encrypt2($sql_insert_mov_banco) ;
 

  
  ?>
  
                  
                    
  <div style="overflow:visible">	   
  <div id="main" class="mainc"> 
      
  <?php
  
   echo "<br><br><br><a class='btn btn-link bnt-lg' target='_blank' title='Duplica un mov. banco para poder descomponerlo en varios pagos o cobros de suma el importe original' "
           . " href=\"../include/sql.php?code=1&sql=$sql_insert_mov_banco \" >"
           . "<i class='far fa-copy'></i> Duplicar Mov. Banco</a> ";
   
   echo "<a class='btn btn-link bnt-lg' target='_blank' title='Duplica un mov. banco simetricamente, cambia cargo por importe y viceversa'"
           . " href=\"../include/sql.php?code=1&sql=$sql_insert_mov_banco_simetrico \" >"
           . "<i class='far fa-copy'></i> Duplicar Mov. Banco simétrico</a> ";

  require("../include/ficha.php"); ?>
   
      <!--// FIN     **********    FICHA.PHP-->
 </div>

      
      
      
<div class="right2">
	
<?php 
//  WIDGET DOCUMENTOS 
$tipo_entidad='mov_banco' ;
$id_entidad=$id_mov_banco ;
//$id_subdir=$id_cliente ;
$id_subdir=0 ;
$size='200px' ;
require("../include/widget_documentos.php");

 ?>
	 
</div>	      
 
      <!--  -->
      
<div class="right2">
	
  <?php 
 
  //COMPROBAMOS SI EXISTE ID_PAGO, es decir, si está conciliado el MOV_BANCO con un ID_PAGO
  $id_pago=$rs["id_pago"] ;
  $id_remesa=$rs["id_remesa"] ;
  $conciliado = $rs["conc"] ;
  if ($conciliado)
  {
//   $importe = Dfirst("importe","Vales_view","ID_VALE=$id_vale AND $where_c_coste" ) ;  
      
   $titulo = "<h1 style='font-weight: bold; color:green;'>CONCILIADO</h1>" ;
   
   if($id_pago)
   {    
       $titulo .= "<a class='btn btn-link noprint' href='../bancos/pago_ficha.php?_m=$_m&id_pago=$id_pago' target='_blank'>ver Pago</a>" ;

       if($id_fra_prov=Dfirst("id_fra_prov","Fras_Prov_Pagos_View", "id_pago=$id_pago"))
       {
           $titulo .= "<a class='btn btn-link noprint' href='../proveedores/factura_proveedor.php?_m=$_m&id_fra_prov=$id_fra_prov' target='_blank'>ver Factura Proveedor</a>" ;   
       }       
   }elseif ($id_remesa)
   {
      $titulo .= "<a class='btn btn-link noprint' href='../bancos/remesa_ficha.php?_m=$_m&id_remesa=$id_remesa' target='_blank'>ver REMESA</a>" ;   
   }
//   $titulo .= "<a class='btn btn-link btn-xs' href='../personal/parte_cargar_a_obra.php?id_parte=$id_parte&id_vale=$id_vale' >actualizar cargo</a>" ;
  }
   else
  {
   $titulo="<h1 style='font-weight: bold;color:red;'>NO CONCILIADO</h1>" ;   
//   $titulo .= "<a class='btn btn-primary' href='../personal/parte_cargar_a_obra.php?id_parte=$id_parte' >Cargar a obra</a>" ;
  }
   echo $titulo ;
 ?>
	 
  </div>            
      

	
<?php            // ----- div Pagos_View   tabla.php   -----

//COMPROBAMOS SI EXISTE ID_PAGO, es decir, si está conciliada, PINTAMOS EL DIV Prosibles ID_PAGO
if (!$conciliado)
{
    
// WIDGET DE PAGOS CONCILIABLES    
//$sql="SELECT id_pago,f_vto,PROVEEDOR,id_proveedor,observaciones,importe,ingreso FROM Pagos_View "
//        . " WHERE  id_cta_banco=$id_cta_banco AND conc=0 AND (importe='$importe' AND ingreso='$ingreso') AND $where_c_coste ORDER BY f_vto DESC ";

    // buscamos pagos en cualquier id_cta_banco y no solo en la del mov_banco en cuestion
$sql="SELECT id_pago,f_vto,PROVEEDOR,id_proveedor,observaciones,importe,ingreso FROM Pagos_View "
        . " WHERE  conc=0 AND (importe='$importe' AND ingreso='$ingreso') AND $where_c_coste ORDER BY f_vto DESC ";
//echo $sql;
$result=$Conn->query($sql );

$updates=[];
//$updates=['MOTIVO', 'F_solicitud', 'Observaciones'] ;
//  $tabla_update="Avales" ;
//  $id_update="ID_AVAL" ;

//$formats["f_vto"]='fecha';
$formats["importe"]='moneda';
$formats["ingreso"]='moneda';

$links["observaciones"] = ["../bancos/pago_ficha.php?id_pago=", "id_pago"] ;
$links["PROVEEDOR"]=["../proveedores/proveedores_ficha.php?id_proveedor=", "id_proveedor"] ;

// accion de CONCILIAR el MOV_BANCO con el ID_PAGO
$onclick1_VARIABLE1_="id_pago" ;           // paso de variables para dar instrucciones al boton 'add' para añadir un detalle a la udo
//$onclick1_VARIABLE2_="" ;     // idem

// OBSOLETA TRAS EL CAMBIO DE BBDD ELIMINANDO PAGOS_MOV_BANCOS
//$sql_insert="INSERT INTO PAGOS_MOV_BANCOS ( id_mov_banco,id_pago ) " . 
//          " VALUES ( '$id_mov_banco', _VARIABLE1_ );"  ;
$sql_insert="UPDATE PAGOS SET id_mov_banco='$id_mov_banco' WHERE id_pago=_VARIABLE1_ ;"  ;


 $sql_insert=encrypt2($sql_insert) ;

$href="../include/sql.php?code=1&sql=$sql_insert&variable1=_VARIABLE1_";
//$actions_row["onclick1_link"]="<a class='btn btn-warning btn-xs' target='_blank' title='concilia el mov.banco con el Pago' href=\"../include/sql.php?code=1&sql=$sql_insert&variable1=_VARIABLE1_ \" >conciliar</a> ";
$actions_row["onclick1_link"]="<a class='btn btn-warning btn-xs' title='concilia el mov.banco con el Pago' href='#'  onclick=\"js_href('$href')\"   >conciliar</a> ";
$actions_row["id"]="id_pago";
  

//$tooltips["conc"] = "Factura conciliada. Los Vales (albaranes de proveedor) suman el importe de la factura" ;

//$titulo="<a href=\"proveedores_documentos.php?id_proveedor=$id_proveedor\">Documentos (ver todos...)</a> " ;
//$titulo="Posibles REMESAS, PAGOS, COBROS O TRASPASOS a conciliar " ;
$titulo="PAGOS conciliables... ($result->num_rows)" ;
$msg_tabla_vacia="";

//echo "<div id='main' class='mainc' style='background-color:orange'>" ;
echo "<div class='mainc' style='background-color:lightgrey ;width:60%;' >" ;
//echo "<div class='mainc'  >" ;
     
//echo "<a class='btn btn-primary' target='_blank' href= '../bancos/aval_anadir.php?id_linea_avales=$id_linea_avales' ><i class='fas fa-plus-circle'></i>Añadir Aval</a><br>" ;

require("../include/tabla.php"); echo $TABLE ; 
//echo "<br>"  ;
//echo "</div>" ;

// WIDGET DE REMESAS CONCILIABLES    
//$sql="SELECT id_pago,f_vto,PROVEEDOR,id_proveedor,observaciones,importe,ingreso FROM Pagos_View "
//        . " WHERE  id_cta_banco=$id_cta_banco AND conc=0 AND (importe='$importe' AND ingreso='$ingreso') AND $where_c_coste ORDER BY f_vto DESC ";

    // buscamos pagos en cualquier id_cta_banco y no solo en la del mov_banco en cuestion
//$sql="SELECT id_remesa,fecha_creacion,remesa,id_cta_banco,num_pagos FROM Remesas_View "
//        . " WHERE cobrada=0 AND id_cta_banco=$id_cta_banco AND firmada=1 AND importe='$importe' AND $where_c_coste ORDER BY fecha_creacion DESC ";
$sql="SELECT id_remesa,fecha_creacion,remesa,importe,id_cta_banco,num_pagos FROM Remesas_View "
        . " WHERE cobrada=0 AND id_cta_banco=$id_cta_banco AND firmada=1 AND importe=$importe AND  $where_c_coste ORDER BY fecha_creacion DESC ";
//echo $sql;
$result=$Conn->query($sql );

$updates=[];
//$updates=['MOTIVO', 'F_solicitud', 'Observaciones'] ;
//  $tabla_update="Avales" ;
//  $id_update="ID_AVAL" ;

//$formats["f_vto"]='fecha';
//$formats["importe"]='moneda';
//$formats["ingreso"]='moneda';

//$links["observaciones"] = ["../bancos/pago_ficha.php?id_pago=", "id_pago"] ;
$links["remesa"] = ["../bancos/remesa_ficha.php?id_remesa=", "id_remesa", "ver Remesa", "formato_sub"] ;

// accion de CONCILIAR el MOV_BANCO con el ID_PAGO
$onclick1_VARIABLE1_="id_remesa" ;           // paso de variables para dar instrucciones al boton 'add' para añadir un detalle a la udo
//$onclick1_VARIABLE2_="" ;     // idem

// OBSOLETA TRAS EL CAMBIO DE BBDD ELIMINANDO PAGOS_MOV_BANCOS
//$sql_insert="INSERT INTO PAGOS_MOV_BANCOS ( id_mov_banco,id_pago ) " . 
//          " VALUES ( '$id_mov_banco', _VARIABLE1_ );"  ;
$sql_insert="UPDATE Remesas SET id_mov_banco_remesa='$id_mov_banco' WHERE id_remesa=_VARIABLE1_ ;"  ;


 $sql_insert=encrypt2($sql_insert) ;

$href="../include/sql.php?code=1&sql=$sql_insert&variable1=_VARIABLE1_";
//$actions_row["onclick1_link"]="<a class='btn btn-warning btn-xs' target='_blank' title='concilia el mov.banco con el Pago' href=\"../include/sql.php?code=1&sql=$sql_insert&variable1=_VARIABLE1_ \" >conciliar</a> ";
$actions_row["onclick1_link"]="<a class='btn btn-warning btn-xs' title='concilia el mov.banco con la Remesa' href='#'  onclick=\"js_href('$href')\"   >conciliar</a> ";
$actions_row["id"]="id_remesa";
  

//$tooltips["conc"] = "Factura conciliada. Los Vales (albaranes de proveedor) suman el importe de la factura" ;

//$titulo="<a href=\"proveedores_documentos.php?id_proveedor=$id_proveedor\">Documentos (ver todos...)</a> " ;
//$titulo="Posibles REMESAS, PAGOS, COBROS O TRASPASOS a conciliar " ;
$titulo="REMESAS conciliables... ($result->num_rows)" ;
$msg_tabla_vacia="";

//echo "<div id='main' class='mainc' style='background-color:orange'>" ;
//echo "<div class='mainc' style='background-color:lightgrey ;width:60%;' >" ;
//echo "<div class='mainc'  >" ;
     
//echo "<a class='btn btn-primary' target='_blank' href= '../bancos/aval_anadir.php?id_linea_avales=$id_linea_avales' ><i class='fas fa-plus-circle'></i>Añadir Aval</a><br>" ;

require("../include/tabla.php"); echo $TABLE ; 
//echo "<br>"  ;
//echo "</div>" ;






// WIDGET DE FACTURAS PROVEEDOR CONCILIABLES    
//$sql="SELECT id_pago,f_vto,PROVEEDOR,id_proveedor,observaciones,importe,ingreso FROM Pagos_View WHERE  id_cta_banco=$id_cta_banco AND conc=0 AND importe='$importe' AND ingreso='$ingreso') AND $where_c_coste ";
$sql="SELECT ID_FRA_PROV,ID_PROVEEDORES,PROVEEDOR,N_FRA,FECHA,IMPORTE_IVA,Observaciones,conc,pagada "
     . " FROM Fras_Prov_View WHERE pagada=0 AND $importe<>0 AND IMPORTE_IVA='$importe' AND $where_c_coste ORDER BY FECHA DESC " ;

//echo $sql;
$result=$Conn->query($sql );

$updates=[];
//$updates=['MOTIVO', 'F_solicitud', 'Observaciones'] ;
//  $tabla_update="Avales" ;
//  $id_update="ID_AVAL" ;

//$formats["f_vto"]='fecha';
$formats["IMPORTE_IVA"]='moneda';
$formats["conc"]='boolean';
$formats["pagada"]='boolean';

$links["N_FRA"] = ["../proveedores/factura_proveedor.php?id_fra_prov=", "ID_FRA_PROV"] ;
$links["PROVEEDOR"]=["../proveedores/proveedores_ficha.php?id_proveedor=", "ID_PROVEEDORES"] ;


// accion de CONCILIAR el MOV_BANCO con el ID_PAGO
$onclick1_VARIABLE1_="ID_FRA_PROV" ;           // paso de variables para dar instrucciones al boton 'add' para añadir un detalle a la udo
//$onclick1_VARIABLE2_="" ;     // idem

//$sql_insert="INSERT INTO PAGOS_MOV_BANCOS ( id_mov_banco,id_pago ) " . 
//          " VALUES ( '$id_mov_banco', _VARIABLE1_ );"  ;

//

$href="../bancos/mov_bancos_conciliar_selection_fras.php?id_mov_banco=$id_mov_banco&id_fra_prov=_VARIABLE1_";
//$actions_row["onclick1_link"]="<a class='btn btn-warning btn-xs' target='_blank' title='concilia el mov.banco con el Pago' href=\"../include/sql.php?code=1&sql=$sql_insert&variable1=_VARIABLE1_ \" >conciliar</a> ";
$actions_row["onclick1_link"]="<a class='btn btn-warning btn-xs' title='concilia el mov.banco con la factura creando un id_pago' href='#'  onclick=\"js_href('$href')\"   >conciliar</a> ";
//

//$actions_row["onclick1_link"]="<a class='btn btn-warning btn-xs' target='_blank' title='concilia el mov.banco con la factura creando un id_pago ' "
//                  . "href=\"../bancos/mov_bancos_conciliar_selection_fras.php?id_mov_banco=$id_mov_banco&id_fra_prov=_VARIABLE1_ \" >conciliar</a> ";
$actions_row["id"]="ID_FRA_PROV";




//$tooltips["conc"] = "Factura conciliada. Los Vales (albaranes de proveedor) suman el importe de la factura" ;

//$titulo="<a href=\"proveedores_documentos.php?id_proveedor=$id_proveedor\">Documentos (ver todos...)</a> " ;
//$titulo="Posibles REMESAS, PAGOS, COBROS O TRASPASOS a conciliar " ;
$titulo="FACTURAS Proveedor conciliables...($result->num_rows) " ;
$msg_tabla_vacia="";

//echo "<div id='main' class='mainc' style='background-color:orange'>" ;
//echo "<div class='mainc' style='background-color:lightgrey ;width:60%;' >" ;
     
//echo "<a class='btn btn-primary' target='_blank' href= '../bancos/aval_anadir.php?id_linea_avales=$id_linea_avales' ><i class='fas fa-plus-circle'></i>Añadir Aval</a><br>" ;

require("../include/tabla.php"); echo $TABLE ; 
//echo "<br>"  ;
//echo "</div>" ;





// WIDGET DE FACTURAS CLIENTES CONCILIABLES    
//$sql="SELECT id_pago,f_vto,PROVEEDOR,id_proveedor,observaciones,importe,ingreso FROM Pagos_View WHERE  id_cta_banco=$id_cta_banco AND conc=0 AND importe='$importe' AND ingreso='$ingreso') AND $where_c_coste ";
$sql="SELECT ID_FRA,ID_OBRA,ID_CLIENTE,NOMBRE_OBRA,CLIENTE,N_FRA,FECHA_EMISION,CONCEPTO,IMPORTE_IVA,Cobrada,Observaciones "
        . " FROM Facturas_View WHERE Cobrada=0 AND $ingreso<>0 AND IMPORTE_IVA='$ingreso' AND $where_c_coste ORDER BY FECHA_EMISION " ;

//echo $sql;
$result=$Conn->query($sql);

$updates=[];
//$updates=['MOTIVO', 'F_solicitud', 'Observaciones'] ;
//  $tabla_update="Avales" ;
//  $id_update="ID_AVAL" ;

//$formats["f_vto"]='fecha';
$formats["IMPORTE_IVA"]='moneda';
$formats["Cobrada"]='boolean';
$formats["pagada"]='boolean';

$links["N_FRA"] = ["../clientes/factura_cliente.php?id_fra=", "ID_FRA", '', 'formato_sub'] ;
$links["FECHA_EMISION"] = ["../clientes/factura_cliente.php?id_fra=", "ID_FRA", '', 'formato_sub'] ;
$links["NOMBRE_OBRA"]=["../obras/obras_ficha.php?id_obra=", "ID_OBRA"] ;
$links["CLIENTE"] = ["../clientes/clientes_ficha.php?id_cliente=", "ID_CLIENTE"] ;


// accion de CONCILIAR el MOV_BANCO con el ID_PAGO
//$onclick1_VARIABLE1_="id_pago" ;           // paso de variables para dar instrucciones al boton 'add' para añadir un detalle a la udo
////$onclick1_VARIABLE2_="" ;     // idem
//
//$sql_insert="INSERT INTO PAGOS_MOV_BANCOS ( id_mov_banco,id_pago ) " . 
//          " VALUES ( '$id_mov_banco', _VARIABLE1_ );" ;
//
//$actions_row["onclick1_link"]="<a class='btn btn-link btn-xs' title='concilia el mov.banco con el Pago' href=\"../include/sql.php?sql=base64_encode($sql_insert) \" >conciliar</a> ";
//$actions_row["id"]="id_pago";
//  

//$tooltips["conc"] = "Factura conciliada. Los Vales (albaranes de proveedor) suman el importe de la factura" ;

//$titulo="<a href=\"proveedores_documentos.php?id_proveedor=$id_proveedor\">Documentos (ver todos...)</a> " ;
//$titulo="Posibles REMESAS, PAGOS, COBROS O TRASPASOS a conciliar " ;
$titulo="FACTURAS Clientes conciliables...($result->num_rows) " ;
$msg_tabla_vacia="";

//echo "<div id='main' class='mainc' style='background-color:orange'>" ;
//echo "<div class='mainc' style='background-color:lightgrey ;width:60%;' >" ;
     
//echo "<a class='btn btn-primary' target='_blank' href= '../bancos/aval_anadir.php?id_linea_avales=$id_linea_avales' ><i class='fas fa-plus-circle'></i>Añadir Aval</a><br>" ;

require("../include/tabla.php"); echo $TABLE ; 
//echo "<br>"  ;
//echo "</div>" ;



// WIDGET DE TRASPASOS INTERNOS CONCILIABLES    
//$sql="SELECT id_pago,f_vto,PROVEEDOR,id_proveedor,observaciones,importe,ingreso FROM Pagos_View WHERE  id_cta_banco=$id_cta_banco AND conc=0 AND importe='$importe' AND ingreso='$ingreso') AND $where_c_coste ";
$sql="SELECT id_mov_banco,id_cta_banco,Banco,fecha_banco,Concepto,cargo,ingreso,observaciones "
        . " FROM MOV_BANCOS_View WHERE conc=0 AND ingreso='$importe' AND cargo='$ingreso' AND $where_c_coste ORDER BY fecha_banco DESC " ;

//echo $sql;
$result=$Conn->query($sql );

$updates=[];
//$updates=['MOTIVO', 'F_solicitud', 'Observaciones'] ;
//  $tabla_update="Avales" ;
//  $id_update="ID_AVAL" ;

//$formats["f_vto"]='fecha';
//$formats["IMPORTE_IVA"]='moneda';
//$formats["Cobrada"]='boolean';
//$formats["pagada"]='boolean';
$formats["cargo"]="moneda";


$links["Banco"] = ["../bancos/bancos_mov_bancarios.php?id_cta_banco=", "id_cta_banco", "", "formato_sub"] ;
$links["Concepto"] = ["../bancos/pago_ficha.php?id_mov_banco=", "id_mov_banco","ver movimiento bancario" ,"formato_sub"] ;
$links["fecha_banco"] = ["../bancos/pago_ficha.php?id_mov_banco=", "id_mov_banco","ver movimiento bancario" ,"formato_sub"] ;
//$links["CLIENTE"] = ["../clientes/clientes_ficha.php?id_cliente=", "ID_CLIENTE"] ;


// accion de CONCILIAR el MOV_BANCO con el ID_PAGO
$onclick1_VARIABLE1_="id_mov_banco" ;           // paso de variables para dar instrucciones al boton 'add' para añadir un detalle a la udo
//$onclick1_VARIABLE2_="" ;     // idem

//$sql_insert="INSERT INTO PAGOS_MOV_BANCOS ( id_mov_banco,id_pago ) " . 
//          " VALUES ( '$id_mov_banco', _VARIABLE1_ );"  ;


$href="../bancos/mov_bancos_conciliar_traspaso.php?id_mov_banco1=$id_mov_banco&id_mov_banco2=_VARIABLE1_";
//$actions_row["onclick1_link"]="<a class='btn btn-warning btn-xs' target='_blank' title='concilia el mov.banco con el Pago' href=\"../include/sql.php?code=1&sql=$sql_insert&variable1=_VARIABLE1_ \" >conciliar</a> ";
$actions_row["onclick1_link"]="<a class='btn btn-warning btn-xs' title='concilia el mov.banco como TRASPASO INTERNO entre cuentas' href='#'  onclick=\"js_href('$href')\"   >conciliar</a> ";

//$actions_row["onclick1_link"]="<a class='btn btn-warning btn-xs' target='_blank' title='concilia el mov.banco como TRASPASO INTERNO entre cuentas ' "
//                  . "href=\"../bancos/mov_bancos_conciliar_traspaso.php?id_mov_banco1=$id_mov_banco&id_mov_banco2=_VARIABLE1_ \" >conciliar</a> ";
$actions_row["id"]="id_mov_banco";



$titulo="TRASPASOS INTERNOS conciliables...($result->num_rows) " ;
$msg_tabla_vacia="";

//echo "<div id='main' class='mainc' style='background-color:orange'>" ;
//echo "<div class='mainc' style='background-color:lightgrey ;width:60%;' >" ;
     
//echo "<a class='btn btn-primary' target='_blank' href= '../bancos/aval_anadir.php?id_linea_avales=$id_linea_avales' ><i class='fas fa-plus-circle'></i>Añadir Aval</a><br>" ;

require("../include/tabla.php"); echo $TABLE ; 
//echo "<br>"  ;
echo "</div>" ;

}
	
//              FIN vales   -->
?>
	
<?php  

$Conn->close();

?>

</div>

                </div>
                <!--****************** BUSQUEDA GLOBAL  *****************
            </div>
        </div>
        <!-- FIN Contenido principal -->

<?php 

//FIN
include_once('../templates/_inc_privado3_footer.php');