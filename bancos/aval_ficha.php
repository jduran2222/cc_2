<?php
// cambios
require_once("../include/session.php");
$where_c_coste = " id_c_coste={$_SESSION['id_c_coste']} ";
$id_c_coste = $_SESSION['id_c_coste'];

$titulo = 'Aval Ficha';

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


$id_aval=$_GET["id_aval"];

//require("../proveedores/proveedores_menutop_r.php");

?>
	

  <?php              // DATOS   FICHA . PHP
 //echo "<pre>";
 $result=$Conn->query($sql="SELECT * FROM Avales WHERE id_aval=$id_aval AND $where_c_coste");
 $rs = $result->fetch_array(MYSQLI_ASSOC) ;
//while ($a = $result->fetch_field()) {

//print_r ($rs);
//}
//echo "</pre>";
  $titulo="AVAL" ;
  
  

  
  $updates=['*']  ;
//  $id_pago=$rs["id_remesa"] ;
  $tabla_update="Avales" ;
  $id_update="ID_AVAL" ;
  $id_valor=$id_aval ;
  $delete_boton=1 ;
  $boton_cerrar=1 ;
  
  $formats["Solicitado"]='boolean' ;
  $formats["Recogido"]='boolean' ;
//  $links["PROVEEDOR"]=["../proveedores/proveedores_ficha.php?id_proveedor=", "ID_PROVEEDORES"] ;
//  $links["RAZON_SOCIAL"]=["../proveedores/proveedores_ficha.php?id_proveedor=", "ID_PROVEEDORES"] ;
//  
//  $selects["ID_OBRA"]=["ID_OBRA","NOMBRE_OBRA","OBRAS"] ;   // datos para clave foránea 
  $selects["ID_OBRA"]=["ID_OBRA","NOMBRE_OBRA","OBRAS","","../obras/obras_ficha.php?id_obra=","ID_OBRA"] ;   // datos para clave foránea Y PARA AÑADIR PROVEEDOR NUEVO

 $selects["id_linea_avales"]=["id_linea_avales","banco","Lineas_Avales","","../bancos/l_avales_ficha.php?id_linea_avales=","id_linea_avales"] ;   // datos para clave foránea 

$etiquetas["F_Recogida"]=['F prevista recogida',"Fecha prevista de recogida por devolución.\n Es decir, la fecha prevista de finalización del periodo de garantia (UN AÑO habitualmente desde final de la obra) "]; 

  
  

  
  ?>
  
                  
                    
  <div style="overflow:visible">	   
  <div id="main" class="mainc"> 
      
  <?PHP require("../include/ficha.php"); ?>
   
      <!--// FIN     **********    FICHA.PHP-->
 </div>
      
 <div class="right2">
	
<?php 
//  WIDGET DOCUMENTOS 
$tipo_entidad='aval' ;
$id_entidad=$id_aval ;
//$id_subdir=$id_cliente ;
$id_subdir=0 ;
$size='400px' ;
require("../include/widget_documentos.php");

 ?>
	 
</div>	     
	
	
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