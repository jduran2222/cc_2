<?php
require_once("../include/session.php");
$where_c_coste=" id_c_coste={$_SESSION['id_c_coste']} " ;
?>

<HTML>
<HEAD>
     <title>Tarea</title>

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

$id=$_GET["id"] ;
 
 // DATOS   FICHA . PHP
 //echo "<pre>";
$sql="SELECT * FROM Tareas_View WHERE id=$id AND $where_c_coste";
 $result=$Conn->query($sql);
 $rs = $result->fetch_array(MYSQLI_ASSOC) ;

 $id=$rs["id"] ;    // comprobamos hay un concepto con ese ID, en caso contrario habrá un error
 
 $formats["Terminada"]='boolean' ;
 
 $titulo="TAREA" ;
  
//  $selects["ID_OBRA"]=["ID_OBRA","NOMBRE_OBRA","OBRAS"] ;   // datos para clave foránea
  $selects["id_obra"]=["ID_OBRA","NOMBRE_OBRA","OBRAS","","../obras/obras_ficha.php?id_obra=","id_obra"] ;   // datos para clave foránea Y PARA AÑADIR PROVEEDOR NUEVO
//
//  $selects["ID_CUENTA"]=["ID_CUENTA","CUENTA_TEXTO","CUENTAS"] ;   // datos para clave foránea
////  $selects["ID_PROVEEDOR"]=["ID_PROVEEDORES","PROVEEDOR","Proveedores","../proveedores/proveedores_anadir.php"] ;   // datos para clave foránea Y PARA AÑADIR PROVEEDOR NUEVO
//  $selects["ID_PROVEEDOR"]=["ID_PROVEEDORES","PROVEEDOR","Proveedores","../proveedores/proveedores_anadir.php","../proveedores/proveedores_ficha.php?id_proveedor=","ID_PROVEEDOR"] ;   // datos para clave foránea Y PARA AÑADIR PROVEEDOR NUEVO

//  $links["ID_OBRA"]=["../proveedores/proveedores_ficha.php?id_proveedor=", "ID_PROVEEDORES"] ;
//$links["NOMBRE_OBRA"]=["../obras/obras_ficha.php?id_obra=", "ID_OBRA"] ;
//$links["PROVEEDOR"]=["../proveedores/proveedores_ficha.php?id_proveedor=", "ID_PROVEEDOR"] ;

  
//  $updates=['NOMBRE','DNI','F_ALTA','BAJA', 'F_BAJA' , 'Observaciones', 'pagada']  ;
  
  $updates=['*']  ;
  $formats["usuarios"]='text_edit' ;
  $formats["Tarea"]='text_edit' ;
  $etiquetas["Tarea"]='Título tarea' ;
//  $ocultos=['NOMBRE_OBRA']  ;
  
//  $id_proveedor=$rs["ID_PROVEEDORES"] ;
  $tabla_update="Tareas" ;
  $id_update="id" ;
  $id_valor=$id ;
  
  
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

  $tipo_entidad='tarea' ;
  $id_entidad=$id;
  $id_subdir=0 ;

  require("../include/widget_documentos.php");
 
 ?>
	 
  </div>
	


	
<?php  

$Conn->close();

?>
	 


	<!--<div style="background-color:#f1f1f1;text-align:center;padding:10px;margin-top:7px;font-size:12px;">FOOTER</div>-->


               
        
        
        
        
<?php require '../include/footer.php'; ?>
</BODY>
</HTML>

