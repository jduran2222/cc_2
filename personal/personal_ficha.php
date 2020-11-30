<?php
// cambios
require_once("../include/session.php");
$where_c_coste = " id_c_coste={$_SESSION['id_c_coste']} ";
$id_c_coste = $_SESSION['id_c_coste'];

$titulo = 'Personal ficha';

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


$id_personal=$_GET["id_personal"];
 
// require_once("../personal/personal_menutop_r.php");
 //require("../proveedores/proveedores_menutop_r.php");

?>
	

  <?php              // DATOS   FICHA . PHP
 //echo "<pre>";
 $result=$Conn->query($sql="SELECT *   FROM Personal_View WHERE id_personal=$id_personal AND $where_c_coste");
 $rs = $result->fetch_array(MYSQLI_ASSOC) ;
 
 
// CONFIGURO EL MENU PERSONAL 
$GET_listado_personal="?nombre={$rs["NOMBRE"]}&agrupar=cal_nombres" ;
$GET_Nominas="?id_proveedor={$rs["id_proveedor_nomina"]}" ;
 
 require_once("../personal/personal_menutop_r.php");

 
//while ($a = $result->fetch_field()) {

//print_r ($rs);
//}
//echo "</pre>";
  $titulo="PERSONAL" ;
//  $updates=['NOMBRE','DNI','F_ALTA','BAJA', 'F_BAJA' , 'Observaciones', 'pagada']  ;
  $updates=['*']  ;
  $ocultos=['N_CUENTA']  ;
//  $visibles=['id_concepto_mo']  ;
//  $id_proveedor=$rs["ID_PROVEEDORES"] ;
  $tabla_update="PERSONAL" ;
  $id_update="ID_PERSONAL" ;
  $id_valor=$id_personal ;
  
  
  $delete_boton=1;
  
  if ($rs['TEL']) { $whassapp_envio= quita_simbolos( $rs['TEL'] )   ; }    //para poder enviar al interesado documentos por whassapp directamente
  
//  $selects["id_obra"]=["ID_OBRA","NOMBRE_OBRA","OBRAS","","../obras/obras_ficha.php?id_obra=","id_obra"] ;   // datos para clave foránea Y PARA AÑADIR PROVEEDOR NUEVO

  $selects["id_concepto_mo"]=["ID_CONCEPTO","CONCEPTO","Conceptos_View","../proveedores/concepto_anadir.php?id_proveedor=". getVar('id_proveedor_mo') ,"../proveedores/concepto_ficha.php?id_concepto=",'id_concepto_mo'] ;   // datos para clave foránea Y PARA AÑADIR PROVEEDOR NUEVO
  $tooltips["id_concepto_mo"]= 'Concepto de gasto asignado al empleado como coste de Hora de trabajo, se cargará a la obra al cargar el correspondiente Parte Diario donde aparezca el empleado. ';   // datos para clave foránea Y PARA AÑADIR PROVEEDOR NUEVO

  $selects["id_proveedor_nomina"]=["ID_PROVEEDORES","PROVEEDOR","Proveedores" 
      ,"../proveedores/proveedores_anadir.php?id_personal=$id_personal&proveedor={$rs['NOMBRE']}&cif={$rs['DNI']}","../proveedores/proveedores_ficha.php?id_proveedor=","id_proveedor_nomina"] ;   // datos para clave foránea Y PARA AÑADIR PROVEEDOR NUEVO
  $tooltips["id_proveedor_nomina"]= 'Proveedor asociado al empleado para el pago de nóminas, notas de gastos... ';   // datos para clave foránea Y PARA AÑADIR PROVEEDOR NUEVO

  $formats["BAJA"]="boolean" ;
  $etiquetas["BAJA"]= ["Baja laboral","indica si el trabajador está de Alta o Baja actualmente en la empresa"] ;
//  $etiqueta["BAJA"]="Baja laboral" ;

  if ($result->num_rows > 0) {                        // hacemos el if para evitar mostrar un error si la ficha o la consulta NO EXISTE
  $plantilla_get_url= "&" . http_build_query($rs) ;
  }
  ?>
  
                  
                    
  <div style="overflow:visible">	   
  <div id="main" class="mainc"> 
      
  <?php require("../include/ficha.php"); ?>
   
      <!--// FIN     **********    FICHA.PHP-->
 </div>
      
      
	
	<!-- WIDGET DOCUMENTOS  -->
	
<div class="right2">
	
<?php 

$tipo_entidad='personal' ;
$id_entidad=$id_personal;
$id_subdir=$id_personal ;
$size='400px';

require("../menu/LRU_registro.php"); require("../include/widget_documentos.php");  

 ?>
	 
</div>
	
	
<?php            // ----- div VALES  tabla.php   -----

//$sql="SELECT ID_VALE,FECHA, ID_OBRA, NOMBRE_OBRA, REF,importe FROM Vales_view  WHERE ID_FRA_PROV=$id_fra_prov  AND $where_c_coste ORDER BY FECHA   ";
////echo $sql;
//$result=$Conn->query($sql );
//
//$sql="SELECT '' as a,'' as b,'' as c, SUM(importe) as importe FROM Vales_view  WHERE ID_FRA_PROV=$id_fra_prov  AND $where_c_coste ";
////echo $sql;
//$result_T=$Conn->query($sql );
//
//$formats["FECHA"]='fecha';
//$formats["importe"]='moneda';
//
//$links["FECHA"] = ["albaran_proveedor.php?id_vale=", "ID_VALE"] ;
//$links["NOMBRE_OBRA"]=["../obras/obras_ficha.php?id_obra=", "ID_OBRA"] ;
//
//$aligns["importe"] = "right" ;
//$aligns["Pdte_conciliar"] = "right" ;
////$aligns["Importe_ejecutado"] = "right" ;
//
////$tooltips["conc"] = "Factura conciliada. Los Vales (albaranes de proveedor) suman el importe de la factura" ;
//
////$titulo="<a href=\"proveedores_documentos.php?id_proveedor=$id_proveedor\">Documentos (ver todos...)</a> " ;
//$titulo="Vales conciliados" ;
//$msg_tabla_vacia="No hay vales conciliados a esta factura";

?>
	
<!--  <div class="right2"> -->
 <div class="right2">
	
<?php // require("../include/tabla.php"); echo $TABLE ; ?>
	 
</div>
	
<!--              FIN vales   -->
 
	
<?php            //  div PAGOS  tabla.php

//$sql="SELECT id_pago,Banco, tipo_doc, f_vto, importe,id_mov_banco,if(conc,'mov.banco','') as abonado,if(FProv > 1, 'X' , '') as P_multiple FROM Fras_Prov_Pagos_View  WHERE ID_FRA_PROV=$id_fra_prov  AND $where_c_coste ORDER BY f_vto   ";
////echo $sql;
//$result=$Conn->query($sql );
//
//$sql_T="SELECT '','' as a,'' as a1, SUM(importe),'' as a2,'' as a11 FROM Fras_Prov_Pagos_View  WHERE ID_FRA_PROV=$id_fra_prov  AND $where_c_coste ";
////echo $sql;
//$result_T=$Conn->query($sql_T );
//
//$formats["f_vto"]='fecha';
//$links["f_vto"] = ["../bancos/pago_ficha.php?id_pago=", "id_pago"] ;
//$links["abonado"]=["../bancos/pago_ficha.php?id_mov_banco=", "id_mov_banco"] ;
//
//$aligns["importe"] = "right" ;
//$aligns["abonado"] = "center" ;
//$aligns["P_multiple"] = "center" ;
////$aligns["Importe_ejecutado"] = "right" ;
//
//$tooltips["abonado"] = "Pago abonado. Clickar para ver el movimiento bancario" ;
//$tooltips["P_multiple"] = "Pago múltiple. Pago para varias facturas" ;
//
////$titulo="<a href=\"proveedores_documentos.php?id_proveedor=$id_proveedor\">Documentos (ver todos...)</a> " ;
//$titulo="Pagos emitidos" ;
//$msg_tabla_vacia="No hay Pagos emitidos en esta factura";

?>
	

 <div class="mainc">
	
<?php // require("../include/tabla.php"); echo $TABLE ; ?>
	
</div>	 
<!--              FIN pagos   -->	
	
<?php  

$Conn->close();

?>
	 

</div>

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

