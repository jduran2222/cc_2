<?php
require_once("../include/session.php");
$where_c_coste=" id_c_coste={$_SESSION['id_c_coste']} " ;
?>

<HTML>
<HEAD>
     <title>UDO. Unidad de Obra</title>

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


$id_udo=$_GET["id_udo"];

 require_once("../../conexion.php");
 require_once("../include/funciones.php");
 require_once("../menu/topbar.php");
 require_once("../menu/topbar.php");
// require("../obras/obras_menutop_r.php");

?>
	

  <?php              // DATOS   FICHA . PHP
 //echo "<pre>";
 //$result=$Conn->query($sql="SELECT * FROM Udos_View WHERE ID_UDO=$id_udo AND $where_c_coste");       //PDTE pasar a uso de Udos_View
 $result=$Conn->query($sql="SELECT * FROM Udos_View WHERE ID_UDO=$id_udo AND $where_c_coste" );
 $rs = $result->fetch_array(MYSQLI_ASSOC) ;
 
  $id_obra=$rs["ID_OBRA"] ;
  $links["NOMBRE_OBRA"]=["../obras/obras_ficha.php?id_obra=", "ID_OBRA"] ;
  $selects["ID_SUBOBRA"]=["ID_SUBOBRA","SUBOBRA","Subobra_View","../obras/subobra_anadir.php?id_obra=$id_obra","../obras/subobras_ficha.php?id_subobra=","ID_SUBOBRA","AND ID_OBRA=$id_obra"] ; 
  $titulo="FICHA COMPLETA UNIDAD DE OBRA (UDO)" ;
  $updates=['UDO','COD_PROYECTO','ud','TEXTO_UDO', 'PRECIO' ,'MED_PROYECTO', 'COSTE_EST', 'Estudio_coste', 'fecha_creacion', 'user' ]  ;
  $id_udo=$rs["ID_UDO"] ;
  $tabla_update="Udos" ;
  $id_update="id_udo" ;
  $id_valor=$id_udo ;
  $id_obra=$rs["ID_OBRA"] ;
    
  ?>
  
                  
                    
  <div style="overflow:visible">	   
  <div id="main" class="mainc"> 
      
  <?PHP require("../include/ficha.php"); ?>
   
      <!--// FIN     **********    FICHA.PHP-->
 </div>
      
      
	
	<!--  fin ficha estudio  -->
	
	
<?php            // ----- div---- UDO - PRODUCCIONS - MEDICIONES  tabla.php   -----

$med_proyecto=$rs["MED_PROYECTO"] ;
$med_proyecto= ($med_proyecto==0) ? 1 : $med_proyecto  ;
$sql="SELECT ID_PRODUCCION, PRODUCCION, suma_medicion, suma_medicion/$med_proyecto AS P_proyecto FROM Prod_det_suma  WHERE ID_UDO=$id_udo  ORDER BY PRODUCCION   ";
////echo $sql;
$result=$Conn->query($sql );
//
//$sql="SELECT '' as a,'' as b,'' as c, SUM(importe) as importe FROM Vales_view  WHERE ID_FRA_PROV=$id_fra_prov  AND $where_c_coste ";
////echo $sql;
//$result_T=$Conn->query($sql );
//
$formats["P_proyecto"]='porcentaje';
$formats["suma_medicion"]='fijo';
//
//$links["PRODUCCION"] = ["albaran_proveedor.php?id_vale=", "ID_VALE"] ;
$links["PRODUCCION"]=["../obras/obras_prod_detalle.php?id_obra=$id_obra&id_produccion=", "ID_PRODUCCION"] ;
//
//$aligns["importe"] = "right" ;
//$aligns["Pdte_conciliar"] = "right" ;
////$aligns["Importe_ejecutado"] = "right" ;
//
////$tooltips["conc"] = "Factura conciliada. Los Vales (albaranes de proveedor) suman el importe de la factura" ;
//
////$titulo="<a href=\"proveedores_documentos.php?id_proveedor=$id_proveedor\">Documentos (ver todos...)</a> " ;
$titulo="Producciones" ;
$msg_tabla_vacia="No hay registro en ninguna Producción";
$updates=[] ;
?>
	
<!--  <div class="right2"> -->
 <div class="right2">
	
<?php 
  require("../include/tabla.php"); echo $TABLE ; 
  
 ?>
	 
</div>
	
<!--************ DOCUMENTOS POF *************  -->
<div class="right2">
	

<?php 

$tipo_entidad='udo' ;
$id_entidad=$id_udo;
$id_subdir=0 ;
$size='400px' ;

require("../include/widget_documentos.php");
 ?>
	 
</div>
	
<?php  

$Conn->close();

?>
	 

</div>

<!--	<div style="background-color:#f1f1f1;text-align:center;padding:10px;margin-top:7px;font-size:12px;">FOOTER</div>-->
	
<?php require '../include/footer.php'; ?>
</BODY>
</HTML>

