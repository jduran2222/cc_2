<?php
// cambios
require_once("../include/session.php");
$where_c_coste = " id_c_coste={$_SESSION['id_c_coste']} ";
$id_c_coste = $_SESSION['id_c_coste'];

$titulo = 'Subcontratada';

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


$id=$_GET["id"];

 // require_once("../../conexion.php");
 // require_once("../include/funciones.php");
 // require_once("../menu/topbar.php");


 // require_once("../menu/topbar.php");


 
 // DATOS   FICHA . PHP
 //echo "<pre>";
//$sql="SELECT ID_CONCEPTO,CONCEPTO,COSTE,ID_PROVEEDOR,ID_CUENTA,ID_OBRA,user,Fecha_Creacion FROM Conceptos_View WHERE ID_CONCEPTO=$id_concepto AND $where_c_coste";
$sql="SELECT id,id_proveedor,id_obra,NOMBRE_OBRA,id_subcontrato,subcontrato,PROVEEDOR,cantidad_max,id_concepto,descripcion,COSTE,id_udo,Observaciones, "
        . " 'CONTROL ECONOMICO' as EXPAND,cantidad_max AS cantidad_max_,importe_sub AS importe_max,cantidad_suma as cantidad_gastada,importe_ejec as importe_gastado,  "
        . " cantidad_suma/cantidad_max as porc_gastado,  '' as FIN_EXPAND,fecha_creacion"
        . "  FROM Subcontratos_Web WHERE id=$id AND $where_c_coste";
//echo "<br><br><br><br><br><br><br>" ; 
//echo $sql ;  
 $result=$Conn->query($sql);
 $rs = $result->fetch_array(MYSQLI_ASSOC) ;

 $id=$rs["id"] ;    // comprobamos hay un concepto con ese ID, en caso contrario habrá un error
 $id_obra=$rs["id_obra"] ;   
 $id_proveedor=$rs["id_proveedor"] ;   

$titulo="UNIDAD SUBCONTRATADA (uSub)" ;

//  $selects["ID_OBRA"]=["ID_OBRA","NOMBRE_OBRA","OBRAS"] ;   // datos para clave foránea
$selects["ID_OBRA"]=["ID_OBRA","NOMBRE_OBRA","OBRAS","","../obras/obras_ficha.php?id_obra=","ID_OBRA"] ;   // datos para clave foránea Y PARA AÑADIR PROVEEDOR NUEVO

$selects["ID_CUENTA"]=["ID_CUENTA","CUENTA_TEXTO","CUENTAS"] ;   // datos para clave foránea
//  $selects["ID_PROVEEDOR"]=["ID_PROVEEDORES","PROVEEDOR","Proveedores","../proveedores/proveedores_anadir.php"] ;   // datos para clave foránea Y PARA AÑADIR PROVEEDOR NUEVO
//$selects["id_proveedor"]=["ID_PROVEEDORES","PROVEEDOR","Proveedores","../proveedores/proveedores_anadir.php" 
//  ,"../proveedores/proveedores_ficha.php?id_proveedor=","id_proveedor"] ;   // datos para clave foránea Y PARA AÑADIR PROVEEDOR NUEVO
$selects["id_concepto"]=["ID_CONCEPTO","CONCEPTO","Conceptos_View","../proveedores/concepto_anadir.php?id_usub=$id&id_proveedor=$id_proveedor"  
      ,"../proveedores/concepto_ficha.php?id_concepto=","id_concepto", " AND ID_PROVEEDOR=$id_proveedor "] ;  
$selects["id_udo"]=["ID_UDO","UDO","Udos_View","","../obras/udo_prod.php?id_udo=","id_udo","AND ID_OBRA=$id_obra"] ;   // datos para clave foránea
$tooltips["id_udo"]='Unidad de Obra del proyecto asociada a la Unidad subcontratada' ;


//  $links["ID_OBRA"]=["../proveedores/proveedores_ficha.php?id_proveedor=", "ID_PROVEEDORES"] ;
$links["NOMBRE_OBRA"]=["../obras/obras_ficha.php?id_obra=", "ID_OBRA","", "formato_sub"] ;
$links["PROVEEDOR"]=["../proveedores/proveedores_ficha.php?id_proveedor=", "id_proveedor" ,"", "formato_sub"] ;
$links["subcontrato"]=["../obras/subcontrato.php?id_subcontrato=", "id_subcontrato" ,"", "formato_sub"] ;

  
//  $updates=['NOMBRE','DNI','F_ALTA','BAJA', 'F_BAJA' , 'Observaciones', 'pagada']  ;
  
  $updates=['id_concepto','id_udo',"cantidad_max","precio_cobro","descripcion","Observaciones"]  ;
//  $id_proveedor=$rs["ID_PROVEEDORES"] ;
  $tabla_update="Subcontrato_conceptos" ;
  $id_update="id" ;
  $id_valor=$id;
  
  
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
  require("../include/ficha.php");
  ?>
   
      <!--// FIN     **********    FICHA.PHP-->
  </div>
      
	<!--  DOCUMENTOS  -->
	
  <div class="right2">
	
  <?php 

  $tipo_entidad='usub' ;
  $id_entidad=$id;
  $id_subdir=$rs["id_subcontrato"] ;

  require("../menu/LRU_registro.php"); require("../include/widget_documentos.php");  

 
 ?>
	 
  </div>

	
<?php  

$Conn->close();

?>
	 

                </div>
                <!--****************** BUSQUEDA GLOBAL  *****************
            </div>
        </div>
        <!-- FIN Contenido principal -->

<?php 

//FIN
include_once('../templates/_inc_privado3_footer.php');
