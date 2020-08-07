<?php
// cambios
require_once("../include/session.php");
$where_c_coste = " id_c_coste={$_SESSION['id_c_coste']} ";
$id_c_coste = $_SESSION['id_c_coste'];

$titulo = 'Maquinaria';

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

//require_once("../../conexion.php");
//require_once("../include/funciones.php");

$id_obra=$_GET["id_obra"];
//if (!isset($_SESSION['nombre_obra']))
//{
//   $_SESSION['nombre_obra']=Dfirst("NOMBRE_OBRA","OBRAS","id_obra=$id_obra AND $where_c_coste ") ;
//}

 require_once("../obras/obras_menutop_r.php");    

?>

 

 <?php              // DATOS   FICHA . PHP
 //echo "<pre>";
 $result=$Conn->query($sql="SELECT * FROM Maquinaria WHERE ID_OBRA=$id_obra AND $where_c_coste");
 $rs = $result->fetch_array(MYSQLI_ASSOC) ;

//while ($a = $result->fetch_field()) {

//print_r ($rs);
//}
//echo "</pre>";
  $titulo="MAQUINARIA:<br>{$rs["NOMBRE_OBRA"]}" ;
  //$updates=['NOMBRE_OBRA','NOMBRE_COMPLETO','GRUPOS','EXPEDIENTE', 'NOMBRE' ,'Nombre Completo', 'LUGAR', 'PROVINCIA', 'Presupuesto Tipo', 'Plazo Proyecto' ,'Observaciones']  ;
//  $updates=["NOMBRE_OBRA","id_documento_ppal", 'valor','F_Ini_amortizacion','Meses_amortizacion','id_concepto_mq','activa'] ;
  $updates=["NOMBRE_OBRA","id_documento_ppal", 'IMPORTE','id_concepto_mq','activa','tipo_subcentro'] ;
  
  $concepto_maquinaria='DIA ALQUILER ' . $rs["NOMBRE_OBRA"] ;
  $id_proveedor=getVar('id_proveedor_mo') ;
  $id_cuenta=getVar('id_cuenta_cargo_mq') ;
  

  
  $id_obra=$rs["ID_OBRA"] ;
  $tabla_update="OBRAS" ;
  $id_update="ID_OBRA" ;
  $id_valor=$id_obra ;
  
  $formats["activa"]='boolean' ;
  $formats["path_archivo"]='pdf_300_300' ;
  
  $ocultos=['CONCEPTO'] ;
 
  $etiquetas["id_documento_ppal"]='doc foto principal';
  $tooltips["id_documento_ppal"]='Permite seleccionar cual será la foto principal desde las existentes en Documentos para la Máquina';
  $etiquetas["path_archivo"]='foto principal';
//  $etiquetas["NOMBRE_OBRA"]=['Máquinaria','Número y nombre de la máquinaria'];
  $etiquetas["NOMBRE_OBRA"]=['Máquinaria',""];
  $etiquetas["IMPORTE"]=['Importe compra','Importe de la inversión o compra'];
  $etiquetas["id_concepto_mq"]=['Concepto Maquinaria','Concepto de gasto a aplicar por el uso de la Maquinaria Propia al registrarlo en un Parte Diario de una Obra. Ej: Hora RETROEXCAVADORA'];
  $selects["id_documento_ppal"]=["id_documento","nombre_archivo","Documentos","","../documentos/documento_ficha.php?id_documento=",
      "id_documento_ppal"," AND tipo_entidad=\'obra_doc\' AND id_entidad=$id_obra "] ;   // datos para clave foránea
  $selects["id_concepto_mq"]=["ID_CONCEPTO","CONCEPTO","Conceptos_View", "../proveedores/concepto_anadir.php?id_obra_concepto_mq=$id_obra&concepto=$concepto_maquinaria&id_proveedor=$id_proveedor&id_cuenta=$id_cuenta",
      '../proveedores/concepto_ficha.php?id_concepto=','id_concepto_mq' ] ;   // datos para clave foránea

  
      
  ?>
  
                  
                    
  <div style="overflow:visible">	   
  <div id="mainc" class="mainc"> 
      
  <?PHP require("../include/ficha.php"); ?>
   
      <!--// FIN     **********    FICHA.PHP-->
 </div>
      




 <div class="right2">
     
 
	
<?php 

$tabla_expandida=1;
$tipo_entidad='obra_doc' ;
$id_entidad=$id_obra;
$id_subdir=$id_obra ;
$size='200px' ;

require("../include/widget_documentos.php");

// require("../include/tabla.php"); echo $TABLE ; ?>
	
<!--  </div> -->
 </div>
	
<?php   // Iniciamos tabla_div  de ************ PRODUCCIONES *************

//$sql="SELECT ID_PRODUCCION, PRODUCCION, Ej_Material  from prod_PEM_f_view WHERE ID_OBRA=$id_obra AND $where_c_coste ORDER BY PRODUCCION LIMIT 7 ";
////$sql_T="SELECT '' AS AA, SUM(Ej_Material)  from prod_PEM_f_view WHERE ID_OBRA=$id_obra AND $where_c_coste ORDER BY PRODUCCION LIMIT 7 ";
//
//$formats["Ej_Material"]='moneda' ;
//
//$links["PRODUCCION"] = ["../obras/obras_prod_detalle.php?id_obra={$id_obra}&id_produccion=", "ID_PRODUCCION"] ;
////echo $sql;
//$result=$Conn->query($sql );
////$result_T=$Conn->query($sql_T );
//
//$titulo="PRODUCCIONES";
//$msg_tabla_vacia="No hay";

?>
	
<!--  <div class="right2"> -->
 <!--<div class="right2">-->
	
<?php 
//require("../include/tabla.php"); echo $TABLE ; 
//
//echo "<a class='btn btn-link btn-xs' href=\"../obras/obras_prod.php?id_obra=$id_obra\">ver todas las Producciones</a>" ;

?>


<!--  </div> -->
 <!--</div>-->


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

