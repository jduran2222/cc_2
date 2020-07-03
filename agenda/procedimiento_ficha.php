<?php
require_once("../include/session.php");
$where_c_coste=" id_c_coste={$_SESSION['id_c_coste']} " ;
?>

<HTML>
<HEAD>
     <title>Procedimiento</title>

	<meta http-equiv="Content-type" content="text/html; charset=UTF-8" />
	<link rel='shortcut icon' type='image/x-icon' href='/favicon.ico' />
	
  <!--ANULADO 16JUNIO20<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">-->
        <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.6.3/css/all.css" integrity="sha384-UHRtZLI+pbxtHCWp1t77Bi1L4ZtiqrqD80Kn4Z8NTSRyMA2Fd33n5dQ8lWUE00s/" crossorigin="anonymous">
   <link rel="stylesheet" href="../css/estilos.css<?php echo (isset($_SESSION["is_desarrollo"]) AND $_SESSION["is_desarrollo"])? "?d=".date("ts") : "" ; ?>" type="text/css">

  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
  <!--ANULADO 16JUNIO20<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>-->
  <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>

</HEAD>
<BODY>
  

<?php 


//$id_concepto=$_GET["id_concepto"];

 require_once("../../conexion.php");
 require_once("../include/funciones.php");
 require_once("../menu/topbar.php");


 require_once("../menu/topbar.php");

$id_procedimiento=$_GET["id_procedimiento"] ;
 
 // DATOS   FICHA . PHP
 //echo "<pre>";
$sql="SELECT * FROM Procedimientos WHERE id_procedimiento=$id_procedimiento AND $where_c_coste ";
 $result=$Conn->query($sql);
 $rs = $result->fetch_array(MYSQLI_ASSOC) ;

 $id_procedimiento=$rs["id_procedimiento"] ;    // comprobamos hay un concepto con ese ID, en caso contrario habrá un error
 
 $formats["Obsoleta"]='boolean' ;
 
 $titulo="PROCEDIMIENTO" ;
  
//  $selects["ID_OBRA"]=["ID_OBRA","NOMBRE_OBRA","OBRAS"] ;   // datos para clave foránea
//  $selects["id_obra"]=["ID_OBRA","NOMBRE_OBRA","OBRAS","","../obras/obras_ficha.php?id_obra=","id_obra"] ;   // datos para clave foránea Y PARA AÑADIR PROVEEDOR NUEVO
//
//  $selects["ID_CUENTA"]=["ID_CUENTA","CUENTA_TEXTO","CUENTAS"] ;   // datos para clave foránea
////  $selects["ID_PROVEEDOR"]=["ID_PROVEEDORES","PROVEEDOR","Proveedores","../proveedores/proveedores_anadir.php"] ;   // datos para clave foránea Y PARA AÑADIR PROVEEDOR NUEVO
//  $selects["ID_PROVEEDOR"]=["ID_PROVEEDORES","PROVEEDOR","Proveedores","../proveedores/proveedores_anadir.php","../proveedores/proveedores_ficha.php?id_proveedor=","ID_PROVEEDOR"] ;   // datos para clave foránea Y PARA AÑADIR PROVEEDOR NUEVO

//  $links["ID_OBRA"]=["../proveedores/proveedores_ficha.php?id_proveedor=", "ID_PROVEEDORES"] ;
//$links["NOMBRE_OBRA"]=["../obras/obras_ficha.php?id_obra=", "ID_OBRA"] ;
//$links["PROVEEDOR"]=["../proveedores/proveedores_ficha.php?id_proveedor=", "ID_PROVEEDOR"] ;

  
//  $updates=['NOMBRE','DNI','F_ALTA','BAJA', 'F_BAJA' , 'Observaciones', 'pagada']  ;
  
  $updates=['*']  ;
  $formats["Tema"]='text_edit' ;
  $formats["Procedimiento"]='text_edit' ;
  $formats["Texto"]='text_edit' ;
  $formats["hashtag"]='text_edit' ;
  $formats["Obsoleto"]='boolean' ;
//  $etiquetas["Tarea"]='Título tarea' ;
//  $ocultos=['NOMBRE_OBRA']  ;
  
//  $id_proveedor=$rs["ID_PROVEEDORES"] ;
  $tabla_update="Procedimientos" ;
  $id_update="id_procedimiento" ;
  $id_valor=$id_procedimiento ;
  
  
  $delete_boton=1;
//  if (Dfirst("ID_VALE","GASTOS_T","ID_CONCEPTO=$id_concepto"))
//  {        
//    $disabled_delete=1;
//    $delete_title="Para eliminar el Concepto debe de asegurarse que no está incluido en ningún Vale" ;
//  }
    
//  $id_obra=$rs["ID_OBRA"] ;
//  $fecha=$rs["Fecha"] ;
//  
  
  ?>
  
                  
                    
<div style="overflow:visible">	   
  <div id="main" class="mainc"> 
      
  <?php 
  
//     echo "<a class='btn btn-primary' href='../personal/parte_pdf.php?id_parte=$id_parte' >imprimir PDF</a>" ;

  echo "<br><br><br>" ;
  require("../include/ficha.php"); ?>
   
      <!--// FIN     **********    FICHA.PHP-->
  </div>
      
<!-- CONTROL CARGO A OBRA.  ID_VALE-->    
    
  <!--<div class="right2">-->
	
  
	
	<!--  DOCUMENTOS  -->
	
  <div class="right2">
	
  <?php 

  $tipo_entidad='procedimiento' ;
  $id_entidad=$id_procedimiento;
  $id_subdir=0 ;

  require("../include/widget_documentos.php");
 
 ?>
	 
  </div>
	
<div class="right2">
	
<?php 
//  WIDGET FIRMAS 
//$tipo_entidad='fra_prov' ;
//$id_entidad=$id_fra_prov ;
$firma="Procedimiento: {$rs["Procedimiento"]}  " ;

//$id_subdir=$id_proveedor ;
//$size='400px' ;
require("../include/widget_firmas.php");          // FIRMAS

 ?>
	 
</div>	


	
<?php  

$Conn->close();

?>
	 


	<!--<div style="background-color:#f1f1f1;text-align:center;padding:10px;margin-top:7px;font-size:12px;">FOOTER</div>-->


               
        
        
        
        
<?php require '../include/footer.php'; ?>
</BODY>
</HTML>

