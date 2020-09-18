<?php
// cambios
require_once("../include/session.php");
$where_c_coste = " id_c_coste={$_SESSION['id_c_coste']} ";
$id_c_coste = $_SESSION['id_c_coste'];

$titulo = 'Portafirmas';

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


<!-- CONEXION CON LA BBDD Y MENUS -->
<?php // require_once("../bancos/bancos_menutop_r.php");?>


<div style="overflow:visible">	   
   
	<!--************ INICIO *************  -->

<div id="main" class="mainc_100" style="background-color:#fff">
	
<?php 

$usuario=$_SESSION["user"] ;
$id_usuario=$_SESSION["id_usuario"] ;

//$fecha_tareas_vistas=Dfirst("fecha_tareas_vistas","Usuarios_View"," $where_c_coste AND id_usuario={$_SESSION["id_usuario"]} " ) ;
//
//$fecha_tareas_vistas= $fecha_tareas_vistas ? $fecha_tareas_vistas : '2000-01-01' ;
//
//$result_UPDATE=$Conn->query("UPDATE `Usuarios` SET `fecha_tareas_vistas` = NOW() WHERE $where_c_coste AND id_usuario={$_SESSION["id_usuario"]}" );



$tipo_entidad=isset($_POST["tipo_entidad"])?$_POST["tipo_entidad"] : '' ;
$limite=isset($_POST["limite"])?$_POST["limite"] : 100 ;
$pdte=isset($_POST["pdte"])?$_POST["pdte"] : '1' ;
//$cobradas=isset($_POST["cobradas"])?$_POST["cobradas"] : '1=1' ;
$agrupar=isset($_POST["agrupar"])?$_POST["agrupar"] : 'listado' ;
 ?>

	
    <FORM action="../agenda/portafirmas.php" method="post" id="form1" name="form1">
        <p>Tipo entidad<INPUT id="tipo_entidad" type="text" name="tipo_entidad" value="<?php echo $tipo_entidad;?>"    ></p>
		
<!--                <br><input type="radio" name="terminada" value="1=1"> todas 
                <input type="radio" name="terminada" value="Terminada=1"> Tareas Terminadas
                <input type="radio" name="terminada" value="Terminada=0"> Tareas no Terminadas
                <br>-->
<?php
    $radio=$pdte ;
    $radio_name='pdte' ;
    $chk_todos =  ['','']  ; $chk_on = ['','']  ; $chk_off =  ['','']  ;
    if ($radio=="") { $chk_todos = ["active","checked"] ;} elseif ($radio==1) { $chk_on =  ["active","checked"]  ;} elseif ($radio==0)  { $chk_off =  ["active","checked"]  ;}
    //echo "<br><input type='radio' id='activa' name='activa' value='' $chk_todos />Todas las obras      <input type='radio' id='activa' name='activa' value='1' $chk_on />Activas  <input type='radio' id='activa' name='activa' value='0' $chk_off  />No Activas" ;
    echo "<br>"
         . "<div class='btn-group btn-group-toggle' data-toggle='buttons'>"
         . "<label class='btn btn-default {$chk_todos[0]}'><input type='radio' id='{$radio_name}' name='$radio_name' value='' {$chk_todos[1]} />todas     </label> "
         . "<label class='btn btn-default {$chk_on[0]}'><input type='radio' id='{$radio_name}1' name='$radio_name' value='1'  {$chk_on[1]} />Firmas pendientes   </label>"
         . "<label class='btn btn-default {$chk_off[0]}'><input type='radio' id='{$radio_name}0' name='$radio_name' value='0' {$chk_off[1]}  />Firmas no pendientes</label>"
         . "</div>"
         . "" ;

?>

 <br>
<INPUT type="submit" class='btn btn-success btn-xl' value='Actualizar' id="submit1" name="submit1">

                
<!--                <br><input type="radio" name="cobradas" value="1=1"> todas 
                <input type="radio" name="cobradas" value="cobrada=1"> cobradas
                <input type="radio" name="cobradas" value="cobrada=0"> no cobradas
                <br>-->
                
<!--                <br>Filas<select name="limite" form="form1" value="<?php echo $limite ;?>" >
  			<option value="10">10</option>
  			<option value="30" >30</option>
  			<option value="100" selected>100</option>
  			<option value="999999999">todos</option>
		</select>-->
        
<?php
echo "<br><br><div id='myDIV' class='noprint'>" ;

$btnt['listado']=['listado',''] ;
$btnt['tipo_entidad']=['tipo entidad','Agrupa por tipo entidad'] ;
$btnt['usuario']=['usuario','Agrupa por usuario emisor de la firma'] ;
//$btnt['meses']=['meses',''] ;
//$btnt['trimestres']=['trimestres',''] ;
//$btnt['annos']=['años',''] ;
//$btnt['vacio2']=['','',''] ;
//$btnt['cuadros']=["<span class='glyphicon glyphicon-th-large'></span> cuadros",'Muestra las facturas seleccionadas en forma de cuadros'] ;

foreach ( $btnt as $clave => $valor)
{
  $active= ($clave==$agrupar) ? "cc_active" : "" ;  
  echo (substr($clave,0,5)=='vacio') ? "   " : "<button class='cc_btnt $active' title='{$valor[1]}' onclick=\"getElementById('agrupar').value = '$clave'; document.getElementById('form1').submit(); \">{$valor[0]}</button>" ;  
}  

//echo "</form>" ;
echo "</div>"  ;

?>
<!--                <br>
                <br>Agrupar <input type="radio" name="agrupar" value="listado"> listado 
                <input type="radio" name="agrupar" value="tipo_entidad"> tipo_entidad
                <input type="radio" name="agrupar" value="usuario"> usuario
                <br>-->
<input type="hidden"  id="agrupar"  name="agrupar" value="<?php echo $agrupar;?>"> 

</FORM>
			
<?php   // Iniciamos variables para tabla.php  background-color:#B4045

$where = "True" ;
$where .= ($pdte=='') ? '' : " AND pdte=$pdte"  ;
$where .= ($tipo_entidad) ? " AND CONCAT(tipo_entidad,IFNULL(firma,'')) LIKE '%$tipo_entidad%' " : ""  ;

$tipo_tabla='';


 switch ($agrupar) {
    case "listado":
//     $sql="SELECT id_remesa,remesa,activa,Observaciones,Banco,importe,num_pagos  FROM Remesas_View WHERE  (filtro LIKE '%$filtro%') AND $conc AND $where_c_coste  ORDER BY id_remesa DESC LIMIT $limite" ;
     $sql="SELECT  *, CONCAT('tipo_entidad=',tipo_entidad,'&id_entidad=',id_entidad) as id_entidad_link  FROM Firmas_View "
            . "WHERE  id_usuario=$id_usuario AND $where AND $where_c_coste  ORDER BY fecha_creacion DESC " ;
//    echo $sql ;

//     $sql_T="SELECT '' AS A1 , '' AS A2,SUM(importe) as importe,SUM(ingreso) as ingreso,'' AS B,'' AS C,'' as d,'' as f  FROM Pagos_View WHERE tipo_pago='$tipo' AND (filtro LIKE '%$filtro%') AND $conc AND $where_c_coste  ORDER BY f_vto LIMIT $limite" ;
    break;
    case "tipo_entidad":
//     $sql="SELECT id_remesa,remesa,activa,Observaciones,Banco,importe,num_pagos  FROM Remesas_View WHERE  (filtro LIKE '%$filtro%') AND $conc AND $where_c_coste  ORDER BY id_remesa DESC LIMIT $limite" ;
     $sql="SELECT  *,SHA1(tipo_entidad) as id_tipo_entidad, CONCAT('tipo_entidad=',tipo_entidad,'&id_entidad=',id_entidad) as id_entidad_link  FROM Firmas_View "
            . "WHERE  id_usuario=$id_usuario AND $where AND $where_c_coste  ORDER BY id_tipo_entidad " ;
//     $sql_T="SELECT  *,tipo_entidad as id_tipo_entidad, CONCAT('tipo_entidad=',tipo_entidad,'&id_entidad=',id_entidad) as id_entidad_link  FROM Firmas_View "
//            . "WHERE  id_usuario=$id_usuario AND $where AND $where_c_coste GROUP BY tipo_entidad ORDER BY tipo_entidad " ;
//    echo $sql ;

     $sql_S="SELECT  SHA1(tipo_entidad) as id_tipo_entidad,tipo_entidad, COUNT(id_firma) as Firmas  FROM Firmas_View "
            . "WHERE  id_usuario=$id_usuario AND $where AND $where_c_coste  GROUP BY id_tipo_entidad ORDER BY tipo_entidad " ;
//    echo $sql ;

//     $sql_S="SELECT ConsultaProd.ID_CAPITULO AS ID_CAPITULO, CAPITULO $select_importe_proyecto , SUM(IMPORTE) as importe   FROM "
//           . " ConsultaProd  JOIN Capitulos_importe ON ConsultaProd.ID_CAPITULO=Capitulos_importe.ID_CAPITULO "
//           . " WHERE $where  GROUP BY ID_CAPITULO ORDER BY CAPITULO " ;


     $id_agrupamiento="id_tipo_entidad" ;
     // permite editar el coste_est
//     $updates=['COSTE_EST']  ;
     $anchos_ppal=[30,20,20,20,20,20,20,20,20,20,20,20,20] ;
    
//     $tabla_update="Udos" ;
//     $id_update="ID_UDO" ;
     $id_clave="id_firma" ;
//     $tabla_group=1 ;             // usaremos TABLA_GROUP.PHP 
     $tipo_tabla='group' ;       // indica si usamos tabla.php o tabla_group.php

     
     break;
   case "usuario":
     $anchos_ppal=[30,20,20,20,20,20,20,20,20,20,20,20,20] ;

     $sql="SELECT SHA1(user) as id_user, user, tipo_entidad, firma, CONCAT('tipo_entidad=',tipo_entidad,'&id_entidad=',id_entidad) as id_entidad_link FROM Firmas_View "
            . "WHERE  id_usuario=$id_usuario AND $where AND $where_c_coste  ORDER BY id_user " ;

    $sql_S="SELECT SHA1(user) as id_user, user, COUNT(id_firma) as Firmas  FROM Firmas_View "
                . "WHERE  id_usuario=$id_usuario AND $where AND $where_c_coste  GROUP BY id_user ORDER BY user " ;
    $id_agrupamiento="id_user" ;
    $tipo_tabla='group' ;       // indica si usamos tabla.php o tabla_group.php

  break;
//   case "bancos":
//     $sql="SELECT  id_cta_banco, banco,SUM(importe) as importe, SUM(importe*conc) as importe_conc,  SUM(ingreso) as ingreso ,  SUM(ingreso*conc) as ingreso_conc FROM Pagos_View WHERE tipo_pago='P' AND (filtro LIKE '%$filtro%') AND $conc AND $where_c_coste  GROUP BY id_cta_banco " ;
//     $sql_T="SELECT  'Sumas' AS A2,SUM(importe) as importe, SUM(importe*conc) as importe_conc,  SUM(ingreso) as ingreso ,  SUM(ingreso*conc) as ingreso_conc  FROM Pagos_View WHERE tipo_pago='P' AND (filtro LIKE '%$filtro%') AND $conc AND $where_c_coste  " ;
//    break;
 }

//echo   "<a class='btn btn-link btn-lg' href='../agenda/tarea_anadir.php' target='_blank' ><i class='fas fa-plus-circle'></i> Añadir Tarea</a>" ;

//echo $sql ;
$result=$Conn->query($sql) ;
if (isset($sql_T)) {$result_T=$Conn->query($sql_T) ; }    // consulta para los TOTALES
if (isset($sql_T2)) {$result_T2=$Conn->query($sql_T2) ; }    // consulta para los TOTALES
if (isset($sql_T3)) {$result_T3=$Conn->query($sql_T3) ; }    // consulta para los TOTALES
if (isset($sql_S)) {$result_S=$Conn->query($sql_S) ;  }     // consulta para los SUBGRUPOS , agrupación de filas (Ej. CLIENTES o CAPITULOS en listado de udos)

//echo $result_S->num_rows ; 
//$result_T=$Conn->query($sql_T) ;

//$links["f_vto"] = ["../bancos/remesa_ficha.php?id_remesa=", "id_remesa"] ;
//$links["observaciones"] = ["../bancos/pago_ficha.php?id_pago=", "id_pago"] ;
//$links["remesa"] = ["../bancos/remesa_ficha.php?id_remesa=", "id_remesa", "ver remesa completa", "formato_sub"] ;
//$links["NOMBRE_OBRA"]=["../obras/obras_ficha.php?id_obra=", "ID_OBRA"] ;

//$links["Tarea"] = ["../agenda/tarea_ficha.php?id=", "id",'', 'formato_sub'] ;

$links["firma"] =["../include/ficha_entidad.php?", "id_entidad_link", "ver entidad asociada al documento (Factura, Pof, ...)", 'formato_sub'] ;


$updates=['pdte','conforme','no_conforme', 'observaciones'] ;
$formats["pdte"]='boolean' ;
$formats["conforme"]='semaforo' ;
$formats["no_conforme"]='semaforo_not' ;


$dblclicks["tipo_entidad"]="tipo_entidad";

$tabla_update="Firmas" ;
$id_update="id_firma" ;
$actions_row=[];
$actions_row["id"]="id_firma";
$actions_row["delete_link"]="1";

// 
//$formats["Tarea"] = "text_edit" ;
$formats["Texto"] = "textarea" ;
$formats["prioridad"] = "text_edit" ;
$formats["Terminada"] = "boolean" ;
$formats["vista"] = "semaforo" ;
$formats["fecha_modificacion"] = "fecha_friendly" ;
//$formats["Terminada"] = "semaforo" ;
//$formats["ingreso_conc"] = "moneda" ;
//$formats["ingreso"] = "moneda" ;
//$formats["f_vto"] = "fecha" ;
//$formats["activa"] = "boolean" ;
//$formats["firmada"] = "semaforo" ;
//$formats["saldo"] = "moneda" ;
//$formats["cobrada"] = "boolean" ;
////$formats["ingresos"] = "moneda" ;
//$aligns["Importe_ejecutado"] = "right" ;
//$aligns["num_pagos"] = "center" ;
////$aligns["Pagada"] = "center" ;
$tooltips["Terminada"] = "Indica si la Tarea ha finalizado" ;
//$tooltips["Banco_Neg"] = "Indica el banco o línea de descuento donde está negociada" ;


$titulo="<h2>FIRMAS ({$result->num_rows})</h2>";
$msg_tabla_vacia="No hay.";

?>
<?php


if ($tipo_tabla=='group')
{ require("../include/tabla_group.php"); }
else if ($tipo_tabla=='pdf')
{ require("../include/tabla_pdf.php"); }
else 
{ require("../include/tabla.php"); echo $TABLE ; }


?>

 <br><br><br><br><br><br><br><br><br>
   
</div>

<!--************ FIN  *************  -->
	
	

<?php  

$Conn->close();

?>
	 
</div>

                </div>
                <!--****************** BUSQUEDA GLOBAL  *****************
            </div>
        </div>
        <!-- FIN Contenido principal -->

<?php 

//FIN
include_once('../templates/_inc_privado3_footer.php');

