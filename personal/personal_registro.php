<?php

$titulo = 'Registro Entrada';

include_once('../templates/_inc_registro1_header.php');

require_once("../../conexion.php");
require_once("../include/funciones.php");
require_once("../include/funciones_js.php");


//desencriptamos el $_GET
if (isset($_GET['url_enc']))         // venimos ENCRYPTADOS, desencriptamos, juntamos las dos url y metemos en GET las variables
{    
    $url_dec=decrypt2($_GET['url_enc']) ;
    $url_raw= isset($_GET['url_raw']) ? rawurldecode(($_GET['url_raw'])) : ""  ;
    parse_str( $url_dec.$url_raw , $_GET ) ;
} else {
    cc_die("ERROR EN PARÁMETROS") ;
}

//---------


$id_personal= isset($_GET["id_personal"]) ? $_GET["id_personal"] : cc_die("ERROR EN PARÁMETROS. Falta IDENTIFICADOR DEL EMPLEADO")  ;

// CONFIRMAMOS QUE EL ID_PERSONAL EXISTE
if (!($rs_personal = DRow("PERSONAL","ID_PERSONAL='$id_personal'"))) { cc_die("ERROR TRABAJADOR INEXISTENTE")  ;} 

$where_c_coste = " id_c_coste={$rs_personal['id_c_coste']} ";

if (!$path_logo_empresa=Dfirst("path_archivo", "Documentos", "tipo_entidad='empresa' AND $where_c_coste")."_medium.jpg" ) $path_logo_empresa="../img/no_logo.jpg" ; 

$rs_registro = DRow("Personal_Registros","ID_PERSONAL='$id_personal' AND ISNULL(fecha_salida) ORDER BY fecha_creacion DESC");

if ($rs_registro)
{
    $fecha_entrada=$rs_registro['fecha_entrada'] ;
    
    $content="Estado actual: <b style='color:green;'>Trabajando</b>"
            . "<BR> Entrada realizada <b>". dateformat_friendly($fecha_entrada)  ."</b> <small style='color:silver;'>($fecha_entrada)</small>" ;
   
    
    $sql_update= "UPDATE `Personal_Registros` SET fecha_salida=NOW()  WHERE id_registro='{$rs_registro['id_registro']}' ; "  ;
    $href='../include/sql.php?sql=' . encrypt2($sql_update)  ;    
    $content.= "<br><a class='btn btn-danger btn-lg btn-block' href='#'  "
         . " onclick=\"js_href('$href' ,'1' )\"   title='Registra la SALIDA del empleado'>REGISTRAR SALIDA</a>" ;
     
    $sql_delete= "DELETE FROM `Personal_Registros` WHERE id_registro='{$rs_registro['id_registro']}'    ; "  ;
    $href='../include/sql.php?sql=' . encrypt2($sql_delete)  ;     
    $content.= "<br><br><a class='btn btn-link btn-xs ' href='#'  "
         . " onclick=\"js_href('$href' ,'1', '¿Desea eliminar la ENTRADA actual?' )\"   title='Elimina el Registro de ENTRADA actual'>Eliminar ENTRADA actual</a>" ;
     
    
}
else
{
    $content="Estado actual: <b style='color:red;'>Fuera Centro Trabajo</b>";
    $ip= quita_simbolos_mysql( "IP {$_SERVER['REMOTE_ADDR']}-{$_SERVER['HTTP_USER_AGENT']}" ) ;
    $sql_insert= "INSERT INTO `Personal_Registros` (ID_PERSONAL, `fecha_entrada`, `coord_latitud`, `coord_longitud`,ip,observaciones ,user)" 
                                   ." VALUES ( '$id_personal',      NOW(), '_VAR_SQL1_', '_VAR_SQL2_' ,'$ip',  '' , 'auto');" ;    

     $href='../include/sql.php?sql=' . encrypt2($sql_insert)  ;       
     $content.= "<br><br><a class='btn btn-success btn-lg btn-block' href='#'  "
         . " onclick=\"js_href('$href' ,'1', '', 'id_latitud','id_longitud' )\"   title='Registra una nueva ENTRADA al centro de trabajo'>REGISTRAR ENTRADA</a>" ;
   
}   



$url_ver_registros=encrypt2("titulo=Registros del empleado: {$rs_personal['NOMBRE']}&sin_inicio_session=1"
. "&sql=select id_registro AS num_registro, fecha_entrada, TIME(fecha_entrada) AS hora_entrada, "
        . "IFNULL(fecha_salida,'') as fecha_salida ,IFNULL(TIME(fecha_salida),'pendiente')  AS hora_salida"
        . " , TIMEDIFF(fecha_salida,fecha_entrada )  AS horas_minutos"
        . " ,-(UNIX_TIMESTAMP(fecha_entrada)-UNIX_TIMESTAMP(IFNULL(fecha_salida,fecha_entrada)))/3600 AS horas "
        . ", coord_latitud, coord_longitud "
        . " FROM Personal_Registros WHERE ID_PERSONAL=$id_personal ORDER BY fecha_creacion DESC ")
?>

  <div class="login-box">
    <div class="login-logo">

      <img width="128px" src="../img/logo_cc_blanco.svg" alt="Logo ConstruCloud 2.0"/>
     <br>
      <a href="../"><strong>Constru</strong>Cloud 2.0</a>
      <img width="128px" src="<?php echo $path_logo_empresa; ?>" alt="Logo empresa"/>
    </div>
    <!-- /.login-logo -->
    <div class="card">
      <div class="card-body login-card-body">
        <p class="login-box-msg">Registro Entrada y Salida</p>

          <div class="input-group mb-3">
              <p>Nombre: <b><?php echo $rs_personal['NOMBRE']; ?></b></p>
          </div>
          <div class="input-group mb-3">
              <p ><?php echo $content; ?></p>
        
          </div>

        <hr>
  
        <p class="mb-0 text-center">
            <a class="text-muted" target='_blank' href="../include/tabla_general.php?url_enc=<?php echo $url_ver_registros ; ?>" class="text-center">ver todos los Registros</a>
        </p>
        <p id=""></p>
        <input type="hidden" id="id_latitud">
        <input type="hidden" id="id_longitud">
      </div>
      <!-- /.login-card-body -->
    </div>
  </div>
  <!-- /.login-box -->

<?php 
include_once('../templates/_inc_registro3_footer.php');
?>
<script>
$(document).ready(function() {
  getLocation();  
} )   
var x = document.getElementById("id_latitud");
var y = document.getElementById("id_longitud");
function getLocation() {
  if (navigator.geolocation) {
    navigator.geolocation.getCurrentPosition(showPosition);
  } else {
  x.value = ""  ;
  y.value = "" ;
  }
}

function showPosition(position) {
    
  x.value =  position.coords.latitude ;
  y.value =  position.coords.longitude;
}
</script>