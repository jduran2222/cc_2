<?php
// cambios
require_once("../include/session.php");
$where_c_coste = " id_c_coste={$_SESSION['id_c_coste']} ";
$id_c_coste = $_SESSION['id_c_coste'];

$titulo = 'Concepto';

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


$id_concepto=$_GET["id_concepto"];
 
 // DATOS   FICHA . PHP
 //echo "<pre>";
$sql="SELECT ID_CONCEPTO,CONCEPTO,COSTE,ID_PROVEEDOR,ID_CUENTA,ID_OBRA,user,Fecha_Creacion FROM Conceptos_View WHERE ID_CONCEPTO=$id_concepto AND $where_c_coste";
$sql="SELECT * FROM Conceptos_View WHERE ID_CONCEPTO=$id_concepto AND $where_c_coste";
 $result=$Conn->query($sql);
 $rs = $result->fetch_array(MYSQLI_ASSOC) ;

 $id_concepto=$rs["ID_CONCEPTO"] ;    // comprobamos hay un concepto con ese ID, en caso contrario habrá un error
 
  $titulo="CONCEPTO DE PROVEEDOR" ;
  
//  $selects["ID_OBRA"]=["ID_OBRA","NOMBRE_OBRA","OBRAS"] ;   // datos para clave foránea
  $selects["ID_OBRA"]=["ID_OBRA","NOMBRE_OBRA","OBRAS","","../obras/obras_ficha.php?id_obra=","ID_OBRA"] ;   // datos para clave foránea Y PARA AÑADIR PROVEEDOR NUEVO

  $selects["ID_CUENTA"]=["ID_CUENTA","CUENTA_TEXTO","CUENTAS"] ;   // datos para clave foránea
//  $selects["ID_PROVEEDOR"]=["ID_PROVEEDORES","PROVEEDOR","Proveedores","../proveedores/proveedores_anadir.php"] ;   // datos para clave foránea Y PARA AÑADIR PROVEEDOR NUEVO
  $selects["ID_PROVEEDOR"]=["ID_PROVEEDORES","PROVEEDOR","Proveedores","../proveedores/proveedores_anadir.php","../proveedores/proveedores_ficha.php?id_proveedor=","ID_PROVEEDOR"] ;   // datos para clave foránea Y PARA AÑADIR PROVEEDOR NUEVO

  $visibles=["id_usub"]; 
  $formats["id_usub"]="semaforo_txt_SUBCONTRATADO";
  
  $etiquetas["ID_CUENTA"]=["Cuenta de Gasto", "Cuenta del Plan General Contable (PGC) a la que pertenece el Concepto (opcional)"] ; 
  $etiquetas["ID_OBRA"]=["Obra inicial", "Obra en la que se creó el concepto originarimente"] ; 
  $etiquetas["id_usub"]=["Concepto subcontratado", "Indica si el Concepto de proveedor está o no está asociado a una unidad de obra subcontratada de un Subcontrato"] ;
  $etiquetas["descripcion"]=["Concepto subcontratado", "El Concepto de proveedor está asociado a una unidad de obra subcontratada"] ;
  if ($rs["id_usub"])
  {$links["descripcion"]=["../proveedores/usub_ficha.php?id=", "id_usub", "ver unidad de subcontrato" , "formato_sub"] ;
  }else
  {$ocultos=["descripcion"] ;}   


//$links["NOMBRE_OBRA"]=["../obras/obras_ficha.php?id_obra=", "ID_OBRA"] ;
//$links["PROVEEDOR"]=["../proveedores/proveedores_ficha.php?id_proveedor=", "ID_PROVEEDOR"] ;

  
  
//  $updates=['NOMBRE','DNI','F_ALTA','BAJA', 'F_BAJA' , 'Observaciones', 'pagada']  ;
  
  $updates=['CONCEPTO','COSTE',"ID_OBRA","ID_CUENTA","ID_PROVEEDOR"]  ;
//  $id_proveedor=$rs["ID_PROVEEDORES"] ;
  $tabla_update="CONCEPTOS" ;
  $id_update="ID_CONCEPTO" ;
  $id_valor=$id_concepto ;
  
  
  $delete_boton=1;
  if (Dfirst("ID_VALE","GASTOS_T","ID_CONCEPTO='$id_concepto'"))
  {        
    $disabled_delete=1;
    $delete_title="Por seguridad, para eliminar el Concepto debe de asegurarse que no está incluido en ningún Albarán" ;
  }
    
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
	
  <?php 
 
//  //COMPROBAMOS SI EXISTE VALE
//  if ($id_vale=$rs["ID_VALE"])
//  {
//   $importe = Dfirst("importe","Vales_view","ID_VALE=$id_vale AND $where_c_coste" ) ;   
//   $titulo = "<h1 style='font-weight: bold; color:green;'>CARGO A OBRA: $importe €</h1>" ;
//   $titulo .= "<a class='btn btn-link btn-xs' href='../proveedores/albaran_proveedor.php?id_vale=$id_vale' target='_blank'>vale de cargo</a>" ;
//   $titulo .= "<a class='btn btn-link btn-xs' href='../personal/parte_cargar_a_obra.php?id_parte=$id_parte&id_vale=$id_vale' >actualizar cargo</a>" ;
//  }
//   else
//  {
//   $titulo="<h1 style='font-weight: bold;color:red;'>NO CARGADO A OBRA</h1>" ;   
//   $titulo .= "<a class='btn btn-primary' href='../personal/parte_cargar_a_obra.php?id_parte=$id_parte' >Cargar a obra</a>" ;
//  }
//   echo $titulo ;
 ?>
	 
  <!--</div>-->      
	
	<!--  DOCUMENTOS  -->
	
  <div class="right2">
	
  <?php 

  $tipo_entidad='concepto' ;
  $id_entidad=$id_concepto;
  $id_subdir=$rs["ID_PROVEEDOR"] ;

  require("../menu/LRU_registro.php"); require("../include/widget_documentos.php");  

 
 ?>
	 
  </div>
	
	
<?php            // ----- div  tabla.php   -----<!--  DETALLE  -->

//$sql="SELECT id,ID_PERSONAL,NOMBRE,DNI,HO,HX,MD,DC,Observaciones FROM Partes_Personal_View  WHERE ID_PARTE=$id_parte  AND $where_c_coste    ";
$sql="SELECT id,ID_VALE,REF,FECHA,ID_OBRA,NOMBRE_OBRA,CANTIDAD,COSTE,IMPORTE,ID_FRA_PROV ,facturado, Observaciones  FROM ConsultaGastos_View  WHERE ID_CONCEPTO=$id_concepto  AND $where_c_coste    ";
//echo $sql;
$result=$Conn->query($sql );

//$sql="SELECT 'Suma' ,COUNT(ID_PERSONAL) as B,SUM(HO) as HO,SUM(HX) as HX,SUM(MD) as MD,SUM(DC) as DC FROM Partes_Personal_View  WHERE ID_PARTE=$id_parte  AND $where_c_coste    ";

$sql_T="SELECT 'Suma',' ','' as b1,SUM(CANTIDAD) as cantidad,COSTE,SUM(IMPORTE) as importe,'' as b2 FROM ConsultaGastos_View  WHERE ID_CONCEPTO=$id_concepto  AND $where_c_coste    ";
//$sql="SELECT 'Suma' ,COUNT(ID_PERSONAL) as B,SUM(HO) as HO, '','  ' FROM Partes_Personal_View  WHERE ID_PARTE=$id_parte  AND $where_c_coste    ";
//echo $sql;
$result_T=$Conn->query($sql_T );

$updates=[ 'Observaciones']  ;
$tabla_update="GASTOS_T" ;
$id_update="id" ;

$actions_row=[];
$actions_row["id"]="id";
//$actions_row["update_link"]="../include/update_row.php?tabla=Fra_Cli_Detalles&where=id=";
//$actions_row["delete_link"]="../include/tabla_delete_row.php?tabla=PARTES_PERSONAL&where=id=";
$actions_row["delete_link"]="1";


$links["NOMBRE_OBRA"] = ["../obras/obras_ficha.php?id_obra=", "ID_OBRA"] ;
$links["PROVEEDOR"] = ["../proveedores/proveedores_ficha.php?id_proveedor=", "ID_PROVEEDORES"] ;
$links["CONCEPTO"] = ["../proveedores/concepto_ficha.php?id_concepto=", "ID_CONCEPTO"]  ;
$links["REF"] = ["../proveedores/albaran_proveedor.php?id_vale=", "ID_VALE"] ;
$links["facturado"] = ["../proveedores/factura_proveedor.php?id_fra_prov=", "ID_FRA_PROV","ver factura" ,"formato_sub"] ;




//$id_clave="id" ;

$formats["facturado"]='boolean_factura';
//$formats["importe"]='moneda';
//
//$links["NOMBRE"] = ["../personal/personal_ficha.php?id_personal=", "ID_PERSONAL"] ;
//$links["NOMBRE_OBRA"]=["../obras/obras_ficha.php?id_obra=", "ID_OBRA"] ;
//
//$aligns["importe"] = "right" ;
//$aligns["Pdte_conciliar"] = "right" ;
////$aligns["Importe_ejecutado"] = "right" ;

//$tooltips["conc"] = "Factura conciliada. Los Vales (albaranes de proveedor) suman el importe de la factura" ;

//$titulo="<a href=\"proveedores_documentos.php?id_proveedor=$id_proveedor\">Documentos (ver todos...)</a> " ;
$titulo="" ;
$msg_tabla_vacia="No hay Albaranes";

?>

        <!--<div id="main" class="mainc">-->
<!--<div  style="background-color:Khaki;float:left;width:60%;padding:0 20px;" >-->
<div class='mainc' style="background-color:Khaki;" >


 <div class="container">
  <h2>Líneas de albaranes donde aparece el Concepto</h2>

</div>

     
<?php  require("../include/tabla.php"); echo $TABLE ; ?>
 
    <br><br><br>
</div>    
    <!--//////   MAQUINARIA PROPIA  ///////-->
    
 


	
<?php  

$Conn->close();

?>
	 


                </div>
  <br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br>
  <br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br>
  <br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br>

                <!--****************** BUSQUEDA GLOBAL  *****************
            </div>
        </div>
        <!-- FIN Contenido principal -->

<?php 

//FIN
include_once('../templates/_inc_privado3_footer.php');