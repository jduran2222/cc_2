<?php
require_once("../include/session.php");
$where_c_coste=" id_c_coste={$_SESSION['id_c_coste']} " ;
?>

<HTML>
<HEAD>
     <title>Aval</title>
	<meta http-equiv="Content-type" content="text/html; charset=UTF-8" />
	<link rel='shortcut icon' type='image/x-icon' href='/favicon.ico' />
	
  <!--ANULADO 16JUNIO20<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">-->
        <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.6.3/css/all.css" integrity="sha384-UHRtZLI+pbxtHCWp1t77Bi1L4ZtiqrqD80Kn4Z8NTSRyMA2Fd33n5dQ8lWUE00s/" crossorigin="anonymous">
   <link rel="stylesheet" href="../css/estilos.css<?php echo (isset($_SESSION["is_desarrollo"]) AND $_SESSION["is_desarrollo"])? "?d=".date("ts") : "" ; ?>" type="text/css">

  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
  <!--ANULADO 16JUNIO20<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>-->
</HEAD>
<BODY>



<?php 


$id_aval=$_GET["id_aval"];

 require_once("../../conexion.php");
 require_once("../include/funciones.php");
 //require("../proveedores/proveedores_menutop_r.php");
 require_once("../menu/topbar.php");
 require_once("../menu/topbar.php");

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

	<div style="background-color:#f1f1f1;text-align:center;padding:10px;margin-top:7px;font-size:12px;">FOOTER</div>
	
<?php require '../include/footer.php'; ?>
</BODY>
</HTML>

