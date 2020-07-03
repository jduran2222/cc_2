<?php
require_once("../include/session.php");
$where_c_coste=" id_c_coste={$_SESSION['id_c_coste']} " ;

 require_once("../../conexion.php");
 require_once("../include/funciones.php");

$titulo_pagina="PROD. " . Dfirst("PRODUCCION","Prod_view", "ID_PRODUCCION={$_GET["id_produccion"]} AND $where_c_coste"  ) ;
?>

<HTML>
<HEAD>
     <title><?php echo $titulo_pagina ?></title> 

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


$id_obra=$_GET["id_obra"];
$id_produccion=$_GET["id_produccion"];

 require_once("../../conexion.php");
 require_once("../include/funciones.php");
 require_once("../menu/topbar.php");
 //require("../proveedores/proveedores_menutop_r.php");

echo '<br><br><br><br><br>';
 
  echo "<a class='btn btn-link noprint' href= '../obras/obras_prod_detalle.php?_m=$_m&id_obra=$id_obra&id_produccion=$id_produccion' "
          . " title='Ir al detalle la relaciones valoradas ' target='_blank'><i class='fas fa-list'></i> Detalle de Relación Valorada</a>" ;
 
 
 //echo "<pre>";
// $result=$Conn->query($sql="SELECT NOMBRE_OBRA,ID_PRODUCCION,ID_OBRA,PRODUCCION,F_certificacion,OPC_DEDUCIR,CERT_ANTERIOR , A_DEDUCIR,Observaciones,user,fecha_creacion FROM Prod_view WHERE ID_PRODUCCION=$id_produccion AND ID_OBRA=$id_obra AND $where_c_coste");
 $result=$Conn->query($sql="SELECT NOMBRE_OBRA,ID_PRODUCCION,ID_OBRA,PRODUCCION,F_certificacion,OPC_DEDUCIR,CERT_ANTERIOR , A_DEDUCIR,Observaciones"
         . ",Ej_Material,Valoracion,Val_iva_incluido,importe_final,user,fecha_creacion FROM Prod_view WHERE ID_PRODUCCION=$id_produccion AND ID_OBRA=$id_obra AND $where_c_coste");
 $rs = $result->fetch_array(MYSQLI_ASSOC) ;
//while ($a = $result->fetch_field()) {

//print_r ($rs);
//}
//echo "</pre>";
  $titulo="RELACIÓN VALORADA" ;
  


$tooltips["OPC_DEDUCIR"] = "OPCIÓN 1: Se deduce la producción CERT_ANTERIOR en el resumen de Certificación\nOPCIÓN 2: Se deduce el importe del campo A_DEDUCIR" ;

  
$selects["CERT_ANTERIOR"]=["ID_PRODUCCION","PRODUCCION","Prod_view","../obras/prod_anadir_form.php","../obras/obras_prod_detalle.php?id_obra=$id_obra&id_produccion=","CERT_ANTERIOR","AND ID_OBRA=$id_obra"] ;   // datos para clave foránea
  
$formats["A_DEDUCIR"] = 'moneda' ; 
$formats["Ej_Material"] = 'moneda' ; 
$formats["Valoracion"] = 'moneda' ; 
$formats["Val_iva_incluido"] = 'moneda' ; 
  
   
  
  
  
  
  
  
  $updates=['CERT_ANTERIOR','Observaciones','PRODUCCION','A_DEDUCIR','F_certificacion','OPC_DEDUCIR']  ;
//  $id_pago=$rs["id_remesa"] ;
  $tabla_update="PRODUCCIONES" ;
  $id_update="ID_PRODUCCION" ;
  $id_valor=$id_produccion ;
  $delete_boton=1 ;
  $boton_cerrar=1 ;
  

  
  

  
  ?>
  
                  
                    
  <div style="overflow:visible">	   
  <div id="main" class="mainc"> 
      
  <?PHP require("../include/ficha.php"); ?>
   
      <!--// FIN     **********    FICHA.PHP-->
 </div>
      
 <div class="right2">
	
<?php 
//  WIDGET DOCUMENTOS 
$tipo_entidad='rel_valorada' ;
$id_entidad=$id_produccion ;
//$id_subdir=$id_cliente ;
$id_subdir=0 ;
$size='200px' ;
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

