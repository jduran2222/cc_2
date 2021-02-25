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
 $result=$Conn->query($sql="SELECT *, 0 as prueba   FROM Personal_View WHERE ID_PERSONAL=$id_personal AND $where_c_coste");
 $rs = $result->fetch_array(MYSQLI_ASSOC) ;
 
 $id_personal=$rs["ID_PERSONAL"];   // COMPROBACION DE SEGURIDAD
 $nombre=$rs["NOMBRE"];   // COMPROBACION DE SEGURIDAD

// CONFIGURO EL MENU PERSONAL 
$GET_listado_personal="?nombre=$nombre&agrupar=cal_nombres" ;
$GET_Nominas="?id_proveedor={$rs["id_proveedor_nomina"]}" ;
$badget_partes=badge_sup(DFirst('COUNT(id)', 'PARTES_PERSONAL', "ID_PERSONAL=$id_personal"),'info') ;
$badget_nominas=badge_sup(DFirst('COUNT(ID_FRA_PROV)', 'FACTURAS_PROV', "ID_PROVEEDORES='{$rs["id_proveedor_nomina"]}' "),'info') ;

 
 require_once("../personal/personal_menutop_r.php");

 
$formats["prueba"]="boolean" ; 

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
  
  if ($rs['TEL']) { $whassapp_envio= quita_simbolos_telefono( $rs['TEL'] )   ; }    //para poder enviar al interesado documentos por whassapp directamente
  
//  $selects["id_obra"]=["ID_OBRA","NOMBRE_OBRA","OBRAS","","../obras/obras_ficha.php?id_obra=","id_obra"] ;   // datos para clave foránea Y PARA AÑADIR PROVEEDOR NUEVO

  $selects["id_concepto_mo"]=["ID_CONCEPTO","CONCEPTO","Conceptos_View","../proveedores/concepto_anadir.php?id_personal=$id_personal&id_proveedor={$rs["id_proveedor_nomina"]}" ,"../proveedores/concepto_ficha.php?id_concepto=",'id_concepto_mo'] ;   // datos para clave foránea Y PARA AÑADIR PROVEEDOR NUEVO
  $tooltips["id_concepto_mo"]= 'Concepto de gasto asignado al empleado como coste de Hora de trabajo, se cargará a la obra al cargar el correspondiente Parte Diario donde aparezca el empleado. ';   // datos para clave foránea Y PARA AÑADIR PROVEEDOR NUEVO

  $selects["id_proveedor_nomina"]=["ID_PROVEEDORES","PROVEEDOR","Proveedores" 
      ,"../proveedores/proveedores_anadir.php?id_personal=$id_personal&proveedor={$rs['NOMBRE']}&cif={$rs['DNI']}","../proveedores/proveedores_ficha.php?id_proveedor=","id_proveedor_nomina"] ;   // datos para clave foránea Y PARA AÑADIR PROVEEDOR NUEVO
  $tooltips["id_proveedor_nomina"]= 'Proveedor asociado al empleado para el pago de nóminas, notas de gastos... ';   // datos para clave foránea Y PARA AÑADIR PROVEEDOR NUEVO

//  $formats["BAJA"]="moneda" ; 
  $etiquetas["BAJA"]= ["Baja laboral","indica si el trabajador está de Alta o Baja actualmente en la empresa"] ;
//  $etiqueta["BAJA"]="Baja laboral" ;

  if ($result->num_rows > 0) {                        // hacemos el if para evitar mostrar un error si la ficha o la consulta NO EXISTE
  $plantilla_get_url= "&" . http_build_query($rs) ;
  }
  
// GENERAR_DOC relleno con espacios los elementos del array vacíos  futura ARRAY_QUITA_VACIOS
$array_plantilla = $rs ;      // copiamos array para datos para la Generación de Documentos con PLANTILLAS HTML
foreach ($array_plantilla as $key => $value){  if (!$value) {$array_plantilla[$key]=' ';} }

  
  ?>
  
                  
                    
  <div style="overflow:visible">	   
  <div id="main" class="mainc"> 
      
  <?php require("../include/ficha.php"); ?>
   
      <!--// FIN     **********    FICHA.PHP-->
 </div>
      
      
	
	<!-- BOTONERA  -->
	
<div class="right2" style="background-color: white">
	
<?php 

$url_enc=encrypt2("id_personal=$id_personal") ;
echo   "<a class='btn btn-xs btn-primary noprint' href='../personal/personal_registro.php?url_enc=$url_enc' target='_blank' >"
                         . "Registrar Jornada</a>" ;
$link_empleado="{$_SESSION['dir_raiz']}personal/personal_registro.php?url_enc=$url_enc" ;
//echo   "<a class='btn btn-primary noprint' href=# onclick=\"js_href2('https://wa.me/_VAR_HREF1_/?text=$link_empleado',0,'','PROMPT_Número de WhatsApp:','','$whassapp_envio')\" target='_blank' >"
//                         . "<i class='fab fa-whatsapp'></i> Enviar link por WhatsApp</a>" ;
$url_enc=encrypt2("sql=SELECT *  FROM Personal_Registros  WHERE ID_PERSONAL=$id_personal ORDER BY fecha_creacion DESC ;"
                 . "&titulo=Registros del Empleado: <b>$nombre</b>") ;
echo   "<br><a class='btn btn-xs btn-link noprint' href='../include/tabla_general.php?url_enc=$url_enc' target='_blank' title='ver Registros de Jornada de este empleado' >" 
                         . " ver Registros de Jornada</a>" ;


echo   "<hr><small title='link a enviar a empleado por whatsApp o email para uso en smartphone desde obra' >link a enviar a empleado:</small>".span_wiki('Registro_de_Jornada')
          . "<input class='form-control form-control-sm' type='text' value='$link_empleado' title='link a enviar al empleado para su Registro con smartphone'>" ;
echo   "<a class='btn btn-xs  btn-default noprint ' "
                            . "onclick=\"copyToClipboard('$link_empleado');this.style.color = '#000000' ;\"  title=\"copy link al portapapeles \" >"
                              . "<i class='far fa-copy'></i></a>" ;
echo   "<a class='btn btn-xs btn-success noprint' href=# onclick=\"js_href2('https://wa.me/?text=$link_empleado',0)\" target='_blank' title='enviar por whastapp'  >"
                         . "<i class='fab fa-whatsapp'></i></a>"
        . "<hr>" ;



 ?>
	 
</div>
	
	
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

