<?php
// cambios
require_once("../include/session.php");
$where_c_coste = " id_c_coste={$_SESSION['id_c_coste']} ";
$id_c_coste = $_SESSION['id_c_coste'];

$titulo_pagina="Remesa " . Dfirst("remesa","Remesas_View", "id_remesa={$_GET["id_remesa"]} AND $where_c_coste"  ) ;
$titulo = $titulo_pagina;

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


$id_remesa=$_GET["id_remesa"];

// require("../bancos/bancos_menutop_r.php");

 //require("../proveedores/proveedores_menutop_r.php");

?>
	

  <?php              // DATOS   FICHA . PHP
 //echo "<pre>";
 $result=$Conn->query($sql="SELECT id_remesa,id_mov_banco_remesa,remesa, tipo_remesa,f_vto,Actualizar_f_vto,remesa_nominas,IF(id_mov_banco_remesa>0,'MOV.BANCO','') AS mov_banco "
         . ",id_cta_banco,firmada, activa,Observaciones,importe,num_pagos, importe_cobros"
         . ", num_cobros, cobrada, fecha_creacion FROM Remesas_View WHERE id_remesa=$id_remesa AND $where_c_coste");
 $rs = $result->fetch_array(MYSQLI_ASSOC) ;
//while ($a = $result->fetch_field()) {

//print_r ($rs);
//}
//echo "</pre>";
$formats["firmada"]="semaforo" ;
$formats["activa"]="boolean" ;
$formats["remesa_nominas"]="boolean" ;
$formats["tipo_remesa"]="tipo_pago" ;
$formats["Actualizar_f_vto"]='boolean';




$selects["id_cta_banco"]=["id_cta_banco","banco","bancos_cuentas","../bancos/bancos_anadir_cta_banco_form.php","../bancos/bancos_mov_bancarios.php?id_cta_banco=","id_cta_banco"," AND Activo=1 " ] ;   // datos para clave foránea Y PARA AÑADIR PROVEEDOR NUEVO
//  $selects["id_remesa"]=["id_remesa","remesa","Remesas_View","../bancos/remesa_anadir.php","../bancos/remesa_ficha.php?id_remesa=","id_remesa"," AND activa=1 "] ;   // datos para clave foránea Y PARA AÑADIR PROVEEDOR NUEVO


$links["mov_banco"]=["../bancos/pago_ficha.php?id_mov_banco=", "id_mov_banco_remesa","ver el mov. bancario del cobro", "formato_sub"] ;

$id_cta_banco=$rs["id_cta_banco"] ;
$id_remesa=$rs["id_remesa"] ;
$tipo_remesa=$rs["tipo_remesa"] ;

 
$titulo="REMESA DE ".cc_format($rs["tipo_remesa"],"tipo_pago" ) ;
$updates=[ 'firmada', 'remesa','f_vto','Actualizar_f_vto', 'Observaciones', 'activa', 'id_cta_banco','remesa_nominas']  ;
$tabla_update="Remesas" ;
$id_update="id_remesa" ;
$id_valor=$id_remesa ;

$delete_boton=1 ;
$disabled_delete=Dfirst("id_remesa", "PAGOS"," id_remesa=$id_remesa") ;


?>
  
                  
                    
  <div style="overflow:visible">	   
  <div id="main" class="mainc"> 

  <!--<a class="btn btn-link noprint" title="remesa listado" target="_blank" href="../bancos/remesas_listado.php" ><i class='fas fa-globe-europe'></i> Listado Remesas</a>-->
  <!--<br><a class="btn btn-link noprint" title="imprimir" href=#  onclick="window.print();"><i class="fas fa-print"></i> Imprimir</a>-->
    
  <?PHP 
  echo   "<br><a class='btn btn-link noprint' href=\"../bancos/remesas_listado.php?tipo_remesa=tipo_remesa='$tipo_remesa'&conc=activa=1\" target='_blank' ><i class='fas fa-globe-europe'></i> Listado Remesas</a>" ;
  echo   "<br><a class='btn btn-link noprint' href='../bancos/remesa_anadir.php' target='_blank' ><i class='fas fa-plus-circle'></i> Añadir Remesa</a>" ;

  require("../include/ficha.php"); ?>
   
      <!--// FIN     **********    FICHA.PHP-->
 </div>

<div class="right2">
	
<?php 
//  WIDGET #FIRMAS 
$tipo_entidad='remesa' ;
$id_entidad=$id_remesa ;
//$flags_firma = ($conc ? "Cargada " : "" ) . ($pagada ? "Pagada " : " " ) . ($cobrada ? "Cobrada" : "" ) ;
$firma="Remesa {$rs["remesa"]} de importe ".cc_format($rs["importe"], 'moneda')." ({$rs["num_pagos"]} pagos) " ;

//$id_subdir=$id_proveedor ;
//$size='400px' ;
require("../include/widget_firmas.php");          // FIRMAS

 ?>
	 
</div>	

      
      
<?php 


// Actualización de id_cta_banco de cada Pago de la Remesa
$sql_update= "UPDATE `PAGOS` SET id_cta_banco=$id_cta_banco  WHERE  id_remesa=$id_remesa AND id_cta_banco IN (select id_cta_banco from ctas_bancos where $where_c_coste) ; "  ;
$href='../include/sql.php?sql=' . encrypt2($sql_update)  ;    
echo "<br><br><br><br><br><a class='btn btn-link btn-xs noprint ' href='#' "
     . " onclick=\"js_href('$href' ,'1' )\"   "
     . "title='Actualiza los bancos de cada Pago' >Actualizar bancos en Pagos</a>" ;
      


// ----- div Pagos_View   tabla.php   -----

$sql="SELECT id_pago,id_remesa,id_mov_banco,id_cta_banco,id_proveedor,ID_CLIENTE,ID_FRA_PROV,ID_FRA_CLI,tipo_pago,Banco,observaciones "
        . ",PROVEEDOR,N_FRA_PROV,FECHA AS FECHA_FRA_PROV,CLIENTE,N_FRA_CLI,f_vto as f_vto_pago,importe,ingreso,"
        . "IBAN,BIC,email_pagos,FProv,Obs,fecha_banco,concepto as concepto_banco "
        . " FROM Pagos_View WHERE  id_remesa=$id_remesa AND $where_c_coste ";
//echo $sql;
$result=$Conn->query($sql );


if ($tipo_remesa=="P")
{
    $ocultos=["CLIENTE","N_FRA_CLI"] ;
    $remesa_pagos_select="" ; // hueco
}else
{
    $ocultos=["PROVEEDOR","N_FRA_PROV","FECHA_FRA_PROV"] ; 
    $remesa_pagos_select="'' AS A3," ; // hueco
    
}

$sql_T="SELECT $remesa_pagos_select '' AS A322,'' AS A31,'' AS A4,'' AS A5,'' AS A51,'Suma' AS D,'' AS A4,'' AS A2,SUM(importe) AS importe,SUM(ingreso) AS ingreso,'cobrados' AS C, COUNT(conc) as cobrados "
        . " FROM Pagos_View WHERE  id_remesa=$id_remesa AND $where_c_coste ";
//echo $sql;
$result_T=$Conn->query($sql_T );



$formats["f_vto"]='fecha';
$formats["importe"]='moneda';
$formats["tipo_pago"]='tipo_pago';
//$formats["IBAN"]='textarea_8_0';
//$formats["BIC"]='textarea_4_0';
$formats["email_pagos"]='textarea_5_10';
$formats["IBAN"]='textarea_8_4';
//$formats["conc"]='boolean';

$etiquetas["observaciones"] = "PAGO observaciones" ;

$links["observaciones"] = ["../bancos/pago_ficha.php?id_pago=", "id_pago", "ver pago", "formato_sub"] ;
$links["PROVEEDOR"]=["../proveedores/proveedores_ficha.php?id_proveedor=", "id_proveedor", "ver Proveedor", "formato_sub_vacio"] ;
$links["N_FRA_PROV"]=["../proveedores/factura_proveedor.php?id_fra_prov=", "ID_FRA_PROV" , "ver Factura Proveedor", "formato_sub_vacio"] ;
//$links["FECHA_FRA_PROV"]=["../proveedores/factura_proveedor.php?id_fra_prov=", "ID_FRA_PROV" , "ver Factura Proveedor", "formato_sub_vacio"] ;
$links["CLIENTE"] = ["../clientes/clientes_ficha.php?id_cliente=","ID_CLIENTE", "ver Cliente", "formato_sub_vacio"] ;
$links["N_FRA_CLI"]=["../clientes/factura_cliente.php?id_fra=", "ID_FRA_CLI" , "ver Factura Ciente", "formato_sub_vacio"] ;



$links["fecha_banco"]=["../bancos/pago_ficha.php?id_mov_banco=", "id_mov_banco","ver el mov. bancario del cobro", "formato_sub_vacio"] ;
$links["concepto_banco"]=["../bancos/pago_ficha.php?id_mov_banco=", "id_mov_banco","ver el mov. bancario del cobro", "formato_sub_vacio"] ;
$links["Banco"] = ["../bancos/bancos_mov_bancarios.php?id_cta_banco=", "id_cta_banco"] ;




if ($rs["activa"])          // si la remesa sigue activa permitimos eliminar Pagos y modificar importes
{   
//  $id_pago=$rs["id_pago"] ;
  $updates=["importe"];  
  $tabla_update="PAGOS" ;
  $id_update="id_pago" ;
//  $id_valor=$id_pago ;
  $actions_row["id"]="id_pago";
  $actions_row["delete_link"]="1";
}  
  
$firmada_disabled= ($rs["firmada"]? "disabled" : "") ;

//$aligns["Importe_ejecutado"] = "right" ;

//$tooltips["conc"] = "Factura conciliada. Los Vales (albaranes de proveedor) suman el importe de la factura" ;

//$titulo="<a href=\"proveedores_documentos.php?id_proveedor=$id_proveedor\">Documentos (ver todos...)</a> " ;
$titulo="Pagos asociados a la remesa" ;
$msg_tabla_vacia="No hay pagos asociados a esta Remesa";

?>

<div class="right2 noprint">
	
<a class="btn btn-primary noprint" <?php echo $firmada_disabled ;?> title="Generar Remesa XML si la remesa no está firmada aún"  href=# 
   onclick="window.open('../bancos/remesa_generar_XML.php?id_remesa=<?php echo $id_remesa;?>','_blank');location.reload();" >Generar remesa XML</a>
<!--<a class="btn btn-primary noprint" title="Generar Remesa XML" target="_blank" href=# 
   onclick="js_href('../bancos/remesa_generar_XML.php?id_remesa=<?php echo $id_remesa;?>',0,'','PROMPT_Actualizamos a fecha de hoy?','','<?php echo date("Y-m-d");?>')" >Generar remesa XML</a>-->
<a class="btn btn-primary noprint" title="remesa_enviar_emails" target="_blank" href="../bancos/remesa_enviar_emails.php?id_remesa=<?php echo $id_remesa;?>">Notificar por email</a>

</div>

<div class="right2"  style="background-color:activeborder   ;float:left;width:30%;padding:0 20px;">

<?php            // ----- div COBRADA   -----
   
if ($rs["cobrada"])
{  
    echo "<h1 style='font-weight: bold;color:green;'>COBRADA</h1>" ;   
}
else
{
    echo "<h1 style='font-weight: bold;color:red;'>NO COBRADA</h1>" ;       
}    
?>
    
    
</div>



 <!--<div id="main" class="mainc" style="background-color:orange">-->
 <div  style="background-color:#ffffcc;float:left;width:100%;padding:0 20px;" >
	
<?php require("../include/tabla.php"); echo $TABLE ; ?>
	 
</div>
	
<!--              FIN vales   -->

	
<?php  

$Conn->close();

?>
	 

</div>
                   </div>
             
                  <br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br>
                  <br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br>
  <br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br>
  <br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br>
  <br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br>


                <!--****************** BUSQUEDA GLOBAL  *****************
            </div>
        </div>
        <!-- FIN Contenido principal -->

<?php 

//FIN
include_once('../templates/_inc_privado3_footer.php');

