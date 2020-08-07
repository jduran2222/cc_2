<?php
// cambios
require_once("../include/session.php");
$where_c_coste = " id_c_coste={$_SESSION['id_c_coste']} ";
$id_c_coste = $_SESSION['id_c_coste'];

$titulo = 'Línea de Avales';

//INICIO
include_once('../templates/_inc_privado1_header.php');
include_once('../templates/_inc_privado2_navbar.php');

?>

        <!-- Contenido principal -->
        <div class="container-fluid bg-light">
            <div class="row">
                <!--****************** ESPACIO LATERAL  *****************-->
                <div class="col-12 col-md-4 col-lg-3"></div>
                <!--****************** ESPACIO LATERAL  *****************-->

                <!--****************** BUSQUEDA GLOBAL  *****************-->
                <div class="col-12 col-md-4 col-lg-9">

<?php 


$id_linea_avales=$_GET["id_linea_avales"];
 //require("../proveedores/proveedores_menutop_r.php");

?>
	

  <?php              // DATOS   FICHA . PHP
 //echo "<pre>";
 $result=$Conn->query($sql="SELECT * FROM Lineas_Avales WHERE id_linea_avales=$id_linea_avales AND $where_c_coste");
 $rs = $result->fetch_array(MYSQLI_ASSOC) ;
//while ($a = $result->fetch_field()) {

//print_r ($rs);
//}
//echo "</pre>";
  $titulo="LINEA DE AVALES" ;
  $updates=['*']  ;
//  $id_pago=$rs["id_remesa"] ;
  $tabla_update="Lineas_Avales" ;
  $id_update="id_linea_avales" ;
  $id_valor=$id_linea_avales ;
    
  $etiquetas["banco"]='Entidad Avalista' ;
  $tooltips["banco"]='Entidad Avalista que emite el aval. Bnco, seguros de Credito y Caución, etc' ;
  
  
  ?>
  
                  
                    
  <div style="overflow:visible">	   
  <div id="main" class="mainc"> 
      
  <?PHP require("../include/ficha.php"); ?>
   
      <!--// FIN     **********    FICHA.PHP-->
 </div>
      
 <div class="right2">
	
<?php 
//  WIDGET DOCUMENTOS 
$tipo_entidad='l_avales' ;
$id_entidad=$id_linea_avales ;
//$id_subdir=$id_cliente ;
$id_subdir=0 ;
$size='200px' ;
require("../include/widget_documentos.php");

 ?>
	 
</div>	     
	
	<!--  FOTO FRA_PROV  -->
	
	
	
<?php            // ----- div Pagos_View   tabla.php   -----

$sql="SELECT * FROM Avales WHERE  id_linea_avales=$id_linea_avales AND $where_c_coste ";
//echo $sql;
$result=$Conn->query($sql );

$sql="SELECT '' AS A,'' AS S,'TOTAL ' AS D,SUM(importe) AS IMPORTE,'' AS C FROM Avales WHERE  id_linea_avales=$id_linea_avales AND $where_c_coste ";
//echo $sql;
$result_T=$Conn->query($sql );

$updates=['MOTIVO', 'F_solicitud', 'Observaciones'] ;
  $tabla_update="Avales" ;
  $id_update="ID_AVAL" ;

//$formats["f_vto"]='fecha';
$formats["IMPORTE"]='moneda';
$formats["Recogido"]='boolean';
$formats["Solicitado"]='boolean';

$links["observaciones"] = ["../bancos/pago_ficha.php?id_pago=", "id_pago"] ;
$links["PROVEEDOR"]=["../proveedores/proveedores_ficha.php?id_proveedor=", "id_proveedor"] ;
$links["MOTIVO"] = ["../include/ficha_general.php?url_enc=".encrypt2("tabla=Avales&id_update=ID_AVAL")."&id_valor=", "ID_AVAL"] ;



//$aligns["Importe_ejecutado"] = "right" ;

//$tooltips["conc"] = "Factura conciliada. Los Vales (albaranes de proveedor) suman el importe de la factura" ;

//$titulo="<a href=\"proveedores_documentos.php?id_proveedor=$id_proveedor\">Documentos (ver todos...)</a> " ;
$titulo="Avales" ;
$msg_tabla_vacia="No hay avales";

?>


 <!--<div id="main" class="mainc" style="background-color:orange">-->
 <div  style="background-color:yellowgreen;float:left;width:80%;padding:0 20px;" >

     
     
<?php 
echo "<a class='btn btn-primary' target='_blank' href= '../bancos/aval_anadir.php?id_linea_avales=$id_linea_avales' ><i class='fas fa-plus-circle'></i>Añadir Aval</a><br>" ;


require("../include/tabla.php"); 
echo $TABLE; 
?>
	 
</div>
	
<!--              FIN vales   -->

	
<?php  

$Conn->close();

?>
	 

</div>

                </div>
                <!--****************** BUSQUEDA GLOBAL  *****************-->
            </div>
        </div>
        <!-- FIN Contenido principal -->

<?php 

//FIN
include_once('../templates/_inc_privado3_footer.php');
