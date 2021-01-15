<?php
// cambios
require_once("../include/session.php");
$where_c_coste = " id_c_coste={$_SESSION['id_c_coste']} ";
$id_c_coste = $_SESSION['id_c_coste'];

$titulo = 'Personal ficha';

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


$id_personal=$_GET["id_personal"];
 
// require_once("../personal/personal_menutop_r.php");
 //require("../proveedores/proveedores_menutop_r.php");

?>
	

  <?php              // DATOS   FICHA . PHP
 //echo "<pre>";
 $result=$Conn->query($sql="SELECT *   FROM Personal_View WHERE id_personal=$id_personal AND $where_c_coste");
 $rs = $result->fetch_array(MYSQLI_ASSOC) ;
 
 
// CONFIGURO EL MENU PERSONAL 
$GET_listado_personal="?nombre={$rs["NOMBRE"]}&agrupar=cal_nombres" ;
$GET_Nominas="?id_proveedor={$rs["id_proveedor_nomina"]}" ;
 
 require_once("../personal/personal_menutop_r.php");

 
//while ($a = $result->fetch_field()) {

//print_r ($rs);
//}
//echo "</pre>";
  $titulo="PERSONAL" ;
//  $updates=['NOMBRE','DNI','F_ALTA','BAJA', 'F_BAJA' , 'Observaciones', 'pagada']  ; 
  $updates=['*']  ;
  $no_updates=['COSTE']  ;
  $ocultos=['N_CUENTA']  ;   
//  $visibles=['id_concepto_mo']  ;
//  $id_proveedor=$rs["ID_PROVEEDORES"] ;
  $tabla_update="PERSONAL" ;
  $id_update="ID_PERSONAL" ;
  $id_valor=$id_personal ;  
  
  
  $delete_boton=1;
  
  if ($rs['TEL']) { $whassapp_envio= quita_simbolos( $rs['TEL'] )   ; }    //para poder enviar al interesado documentos por whassapp directamente
  
//  $selects["id_obra"]=["ID_OBRA","NOMBRE_OBRA","OBRAS","","../obras/obras_ficha.php?id_obra=","id_obra"] ;   // datos para clave foránea Y PARA AÑADIR PROVEEDOR NUEVO

  $selects["id_concepto_mo"]=["ID_CONCEPTO","CONCEPTO","Conceptos_View","../proveedores/concepto_anadir.php?id_personal=$id_personal&id_proveedor={$rs["id_proveedor_nomina"]}" ,"../proveedores/concepto_ficha.php?id_concepto=",'id_concepto_mo'] ;   // datos para clave foránea Y PARA AÑADIR PROVEEDOR NUEVO
  $tooltips["id_concepto_mo"]= 'Concepto de gasto asignado al empleado como coste de Hora de trabajo, se cargará a la obra al cargar el correspondiente Parte Diario donde aparezca el empleado. ';   // datos para clave foránea Y PARA AÑADIR PROVEEDOR NUEVO

  $selects["id_proveedor_nomina"]=["ID_PROVEEDORES","PROVEEDOR","Proveedores" 
      ,"../proveedores/proveedores_anadir.php?id_personal=$id_personal&proveedor={$rs['NOMBRE']}&cif={$rs['DNI']}","../proveedores/proveedores_ficha.php?id_proveedor=","id_proveedor_nomina"] ;   // datos para clave foránea Y PARA AÑADIR PROVEEDOR NUEVO
  $tooltips["id_proveedor_nomina"]= 'Proveedor asociado al empleado para el pago de nóminas, notas de gastos... ';   // datos para clave foránea Y PARA AÑADIR PROVEEDOR NUEVO

  $formats["BAJA"]="boolean" ;
  $etiquetas["BAJA"]= ["Baja laboral","indica si el trabajador está de Alta o Baja actualmente en la empresa"] ;
//  $etiqueta["BAJA"]="Baja laboral" ;

  if ($result->num_rows > 0) {                        // hacemos el if para evitar mostrar un error si la ficha o la consulta NO EXISTE
  $plantilla_get_url= "&" . http_build_query($rs) ;
  }
  ?>
  
                  
                    
  <div style="overflow:visible">	   
  <div id="main" class="mainc"> 
      
  <?php require("../include/ficha.php"); ?>
   
      <!--// FIN     **********    FICHA.PHP-->
 </div>
      
      
	
	<!-- WIDGET DOCUMENTOS  -->
	
<div class="right2">
	
<?php 

$tipo_entidad='personal' ;
$id_entidad=$id_personal;
$id_subdir=$id_personal ;
$size='400px';

require("../menu/LRU_registro.php"); require("../include/widget_documentos.php");  

 ?>
	 
</div>
	
	

	
	
<?php  

$Conn->close();

?>
	 

</div>

                </div>
                
     <br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br>
  <br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br>
             
                <!--****************** BUSQUEDA GLOBAL  *****************
            </div>
        </div>
        <!-- FIN Contenido principal -->

<?php 

//FIN
include_once('../templates/_inc_privado3_footer.php');

