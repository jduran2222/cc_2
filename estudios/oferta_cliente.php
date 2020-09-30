<?php
// cambios
require_once("../include/session.php");
$where_c_coste = " id_c_coste={$_SESSION['id_c_coste']} ";
$id_c_coste = $_SESSION['id_c_coste'];

$titulo = 'Presupuesto cliente';

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


 $count_error=0;
while (!($id_oferta=isset($_GET["id_oferta"])? $_GET["id_oferta"] : Dfirst("ID_OFERTA","Ofertas_View","$where_c_coste AND guid='{$_GET["guid"]}' ")) AND $count_error<50)
{$count_error++ ;}   

if (!$id_oferta) { die("<BR><BR><BR><BR><BR><BR><BR>ERROR EN CREACION DE PRESUPUESTO"); }


//echo "<BR><BR><BR><BR><BR><BR><BR>ID_OFERTA:" . $id_oferta ;


 //require("../proveedores/proveedores_menutop_r.php");
$sql="SELECT * FROM Ofertas_View WHERE ID_OFERTA=$id_oferta AND $where_c_coste";

$result=$Conn->query($sql);
$rs = $result->fetch_array(MYSQLI_ASSOC);

$iva_factor=(1+$rs["iva"]) ;   // lo usaré para el total del detalle de la factura
$iva_txt=trim(cc_format($rs["iva"],'porcentaje0'));
        
//$pdte_provision=$rs["pdte_provision"] ;

 $titulo="PRESUPUESTO A CLIENTE {$rs["NUMERO"]} " ;
  $updates=['*' ,'NUMERO' , 'FECHA','NOMBRE_OFERTA','OBRA','iva','Condiciones','SITUACION','Enviada','forma_pago']  ;

  $selects["ID_CLIENTE"]=["ID_CLIENTE","CLIENTE","Clientes","../clientes/clientes_anadir_form.php","../clientes/clientes_ficha.php?id_cliente=","ID_CLIENTE"] ;   // datos para clave foránea Y PARA AÑADIR PROVEEDOR NUEVO
//  $selects["ID_OBRA"]=["ID_OBRA","NOMBRE_OBRA","OBRAS","../obras/obras_anadir_form.php","../obras/obras_ficha.php?id_obra=","ID_OBRA"] ;   // datos para clave foránea Y PARA AÑADIR PROVEEDOR NUEVO

$links["CLIENTE"] = ["../clientes/clientes_ficha.php?id_cliente=", "ID_CLIENTE"] ;
//$links["OBRA"] = ["../obras/obras_ficha.php?id_obra=", "ID_OBRA"] ;

$formats["provisionada"]="semaforo_txt_PROVISIONADO COBRO";
$formats["pdte_provision"]="moneda";
$formats["Cobrado"]="moneda";
$formats["Pdte_Cobro"]="moneda";
$formats["Aceptado"]="semaforo_txt_Aceptado";
$formats["Rechazado"]="semaforo_not";
$formats["Enviada"]="boolean";
$formats["Cerrada"]="boolean";
//$formats["provisionada"]="semaforo_txt_PROVISIONADA";
//$formats["provisionada"]="semaforo";



$id_oferta=$rs["ID_OFERTA"] ;
$tabla_update="OFERTAS" ;
$id_update="ID_OFERTA" ;
$id_valor=$id_oferta ;

$delete_boton=1;

$serie_fra=date('Y')."-%";
  
//  $num_fra_ultima=Dfirst("MAX(N_FRA)", "Fras_Cli_Listado", "N_FRA LIKE '$serie_fra' AND  $where_c_coste ") ;
  
  
  ?>
	
<div style="overflow:visible">	   
  <div id="main" class="mainc"> 
  <!--<img src="../img/construcloud64.svg" >-->	  
   

	 <?php require("../include/ficha.php"); ?>
   
  <!--// FIN     **********    FICHA.PHP-->
  
 </div>

    
<div class="right2">
	
<?php 

// preparamos el ARRAY para hacer el PRESUPUESTO PDF con generar_PDF 
foreach ($rs as $key => $value)
{
   if (!$value) {$rs[$key]=' ';}
}
$array_plantilla = $rs ;      // copiamos array para datos para la Generación de Documentos con PLANTILLAS HTML
$array_plantilla["FECHA_TXT"]=  cc_format($rs["FECHA"], "fecha_es") ; // ponemos la fecha en formato legible



// preparamos la TABLA para Generar el presupuesto
$sql="SELECT id,n_linea,CANTIDAD,UDO,PRECIO, CANTIDAD*PRECIO AS IMPORTE"
        . " FROM OFERTAS_DETALLES WHERE ID_OFERTA=$id_oferta  ORDER BY n_linea,id" ;
$sql_T="SELECT '' as a,'' as a1,'Suma' as a11,'' as a111,SUM(CANTIDAD*PRECIO) AS IMPORTE"
        . " FROM OFERTAS_DETALLES WHERE ID_OFERTA=$id_oferta " ;
$sql_T2="SELECT '' as a,'' as a1,'Iva Incluido  ($iva_txt)' as a11,'' as ad ,SUM(CANTIDAD*PRECIO)*$iva_factor AS IMPORTE"
        . " FROM OFERTAS_DETALLES WHERE ID_OFERTA=$id_oferta " ;
//echo $sql ;


$updates=["n_linea","CANTIDAD","UDO","PRECIO"] ;
$tabla_update="OFERTAS_DETALLES" ;
$id_update="id" ;
$actions_row=[];
$actions_row["id"]="id"; 
$actions_row["delete_link"]="1"; 

$add_link['field_parent']='ID_OFERTA'  ;
$add_link['id_parent']=$id_oferta  ;       


$links=[];
//$links["Detalle"] = ["factura_cliente_detalle.php?id=", "id"] ;
//$links["abonado"]=["../bancos/pago_ficha.php?id_mov_banco=", "id_mov_banco"] ;

$format=[];
//$formats["Cantidad"]="text_edit";
$formats["UDO"]="text_edit";
//$formats["importe"]="moneda";
$formats["importe_iva"]="moneda";
$formats["PRECIO"]="text_moneda";



$result=$Conn->query( $sql );
$result_T=$Conn->query( $sql_T );
$result_T2=$Conn->query( $sql_T2 );
$titulo='';
$msg_tabla_vacia="No hay";
require("../include/tabla.php");

$array_plantilla["HTML_TABLA"]=urlencode($TABLE) ; // añadimos la tabla de DETALLES

// DATOS DE EMPRESA PARA IMPRESION
$result_emp=$Conn->query("SELECT *, CIF AS cif_empresa FROM C_COSTES WHERE  $where_c_coste");
$rs_emp = $result_emp->fetch_array(MYSQLI_ASSOC) ;

$array_plantilla = array_merge($array_plantilla,$rs_emp) ;

//  WIDGET DOCUMENTOS 
$tipo_entidad='oferta_cli' ;
$id_entidad=$id_oferta ;
//$id_subdir=$id_cliente ;
$id_subdir=0 ;
$size='200px' ;
$size_sec='100px' ;
require("../include/widget_documentos.php");
	 
echo "</div>" ;	

//echo $TABLE ; 

//$array_plantilla_json= urlencode(json_encode($array_plantilla)) ;        // pasamos el array a JSON


?>
<div class="mainc_100">
    
<!--<a class="btn btn-primary" target="_blank" href="../documentos/generar_PDF.php?plantilla_html=oferta_cliente.html&array_plantilla_json=
    <?php // echo $array_plantilla_json; ?>" title="ver presupuesto en pantalla">ver Presupuesto</a>-->

<form action='../documentos/generar_PDF.php?plantilla_html=oferta_cliente.html' method='post' id='form_generar' name='form_generar' target='_blank'>
<input type='hidden'  id='array_plantilla_json'  name='array_plantilla_json' value='<?php echo $array_plantilla_json; ?>'>
<input type='submit' class='btn btn-primary  noprint' title='imprimir Presupuesto'  id='submit' name='submit' value='imprimir Presupuesto' >
</form>
    
<?php
echo $TABLE ;      // OFERTAS DETALLE
echo "<br><br><br><br>" ;
?>
        
</div>
  
<?php

$Conn->close();

?>
    
                </div>
      <br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br>
  <br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br>

                <!--****************** BUSQUEDA GLOBAL  *****************
            </div>
        </div>
        <!-- FIN Contenido principal -->

<?php 

//FIN
include_once('../templates/_inc_privado3_footer.php');

