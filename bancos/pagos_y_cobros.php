<?php
// cambios
require_once("../include/session.php");
$where_c_coste = " id_c_coste={$_SESSION['id_c_coste']} ";
$id_c_coste = $_SESSION['id_c_coste'];

$titulo = 'Pagos y Cobros';

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
<?php 

require_once("../bancos/bancos_menutop_r.php");


//require_once("../include/NumeroALetras.php"); 


?>


<div style="overflow:auto">	   
   
	<!--************ INICIO *************  -->

<div id="main" class="mainc_100" style=" background-color:white">
	
<?php 

// configuracion del modo Calendario TABLA_CALENDAR.PHP
$fecha_cal= isset($_GET["fecha_cal"]) ? $_GET["fecha_cal"] : ( isset($_POST["fecha_cal"]) ? $_POST["fecha_cal"] : date('Y-m-d') )  ;
//$link_calendar_mes="pagos_y_cobros.php?fecha_cal=" ;  // link para avanzar o retroceder meses

//$fecha_db="f_vto" ;   // determinamos el campo DATETIME que se ubicará el Calendario   

//$style_hidden_if_global=$listado_global? " disabled " : ""  ; 


  
  $tipo_pago= isset($_GET["tipo_pago"]) ?  $_GET["tipo_pago"] :  (isset($_POST["tipo_pago"]) ?  $_POST["tipo_pago"] :  "") ;
  $banco    = isset($_GET["banco"]) ?  $_GET["banco"] :          (isset($_POST["banco"]) ?  $_POST["banco"] :  "") ;
  $tipo_doc = isset($_GET["tipo_doc"]) ?  $_GET["tipo_doc"] :    (isset($_POST["tipo_doc"]) ?  $_POST["tipo_doc"] :  "") ;
  $ref_doc  = isset($_GET["ref_doc"]) ?  $_GET["ref_doc"] :      (isset($_POST["ref_doc"]) ?  $_POST["ref_doc"] :  "") ;
  $observaciones=isset($_GET["observaciones"])?$_GET["observaciones"] :  (isset($_POST["observaciones"]) ?  $_POST["observaciones"] :  "") ;
  $f_vto1   = isset($_GET["f_vto1"]) ?  $_GET["f_vto1"]     :    (isset($_POST["f_vto1"]) ?  $_POST["f_vto1"] :  "")  ;
  $f_vto2   = isset($_GET["f_vto2"]) ?  $_GET["f_vto2"]     :    (isset($_POST["f_vto2"]) ?  $_POST["f_vto2"] :  "") ;
  $importe1 = isset($_GET["importe1"]) ?  $_GET["importe1"] :    (isset($_POST["importe1"]) ?  $_POST["importe1"] :  "") ;
  $importe2 = isset($_GET["importe2"]) ?  $_GET["importe2"] :    (isset($_POST["importe2"]) ?  $_POST["importe2"] :  "") ;
  $ingreso1 = isset($_GET["ingreso1"]) ?  $_GET["ingreso1"] :    (isset($_POST["ingreso1"]) ?  $_POST["ingreso1"] :  "") ;
  $ingreso2 = isset($_GET["ingreso2"]) ?  $_GET["ingreso2"] :    (isset($_POST["ingreso2"]) ?  $_POST["ingreso2"] :  "") ;
  $remesa   = isset($_GET["remesa"]) ?  $_GET["remesa"]     :    (isset($_POST["remesa"]) ?  $_POST["remesa"] :  "") ;
  $cuenta   = isset($_GET["cuenta"]) ?  $_GET["cuenta"]     :    (isset($_POST["cuenta"]) ?  $_POST["cuenta"] :  "") ;
  $cobrado  = isset($_GET["cobrado"]) ?  $_GET["cobrado"]   :    (isset($_POST["cobrado"]) ?  $_POST["cobrado"] :  "") ;
  $proveedor= isset($_GET["proveedor"]) ?  $_GET["proveedor"] :  (isset($_POST["proveedor"]) ?  $_POST["proveedor"] :  "") ;
  $cliente  = isset($_GET["cliente"]) ?  $_GET["cliente"]   :    (isset($_POST["cliente"]) ?  $_POST["cliente"] :  "") ;
  $NG       = isset($_GET["NG"]) ?  $_GET["NG"]             :    (isset($_POST["NG"]) ?  $_POST["NG"] :  "") ;
  $agrupar  = isset($_GET["agrupar"]) ?  $_GET["agrupar"]   :    (isset($_POST["agrupar"]) ?  $_POST["agrupar"] :  "ultimos");  


//$fmt_costes=isset($_POST["fmt_costes"]) ? 'checked' : '' ;
//$fmt_resumen_cap=isset($_POST["fmt_resumen_cap"]) ? 'checked' : '' ;
//$fmt_texto_udo=isset($_POST["fmt_texto_udo"]) ? 'checked' : '' ;
//$fmt_med_proyecto=isset($_POST["fmt_med_proyecto"]) ? 'checked' : '' ;
//$fmt_anadir_med=isset($_POST["fmt_anadir_med"]) ? 'checked' : '' ;
//$fmt_seleccion=isset($_POST["fmt_seleccion"]) ? 'checked' : '' ;



    ?>    
 
 <!--<a class="btn btn-link noprint" title="va al listado de relaciones valoradas de la Obra" href="../obras/obras_prod.php?id_obra=<?php echo $id_obra;?>" ><span class="glyphicon glyphicon-arrow-left"></span> Volver a Producciones</a>-->    
 <!--<a class="btn btn-link noprint" title="imprimir" href=#  onclick="window.print();"><i class="fas fa-print"></i> Imprimir pantalla</a>-->
 <!--<a class="btn btn-link noprint" title="ver datos generales de la Produccion actual" target='_blank' href="../obras/prod_ficha.php?id_obra=<?php echo $id_obra;?>&id_produccion=<?php echo $id_produccion;?>" ><span class="glyphicon glyphicon-th-list"></span> ficha Produccion</a>-->    
 
<script>

function formato_prod_obra()
{ //    $('#fmt_costes').prop('checked',!($('#fmt_costes').prop('checked'))) ;
    $('#fmt_costes').prop('checked',false) ;
    $('#fmt_texto_udo').prop('checked',true) ;
    $('#fmt_med_proyecto').prop('checked',true) ;  
    $('#fmt_resumen_cap').prop('checked',false) ;  
    $('#fmt_anadir_med').prop('checked',true) ;  
    $('#fmt_seleccion').prop('checked',false) ;  
//    $('#btn_agrupar_udos').click() ;  
//   document.getElementbyID("btn_agrupar_udos").click();
//   document.getElementById('agrupar').value = 'udos'; document.getElementById('form1').submit();

//    window.print();
}
function formato_certif()
{ //    $('#fmt_costes').prop('checked',!($('#fmt_costes').prop('checked'))) ;
    $('#fmt_costes').prop('checked',false) ;
    $('#fmt_texto_udo').prop('checked',true) ;
    $('#fmt_med_proyecto').prop('checked',false) ;  
    $('#fmt_resumen_cap').prop('checked',true) ;  
    $('#fmt_anadir_med').prop('checked',false) ;  
    $('#fmt_seleccion').prop('checked',false) ;  
}

function formato_estudio_costes()
{ //    $('#fmt_costes').prop('checked',!($('#fmt_costes').prop('checked'))) ;
    $('#fmt_costes').prop('checked',true) ;
    $('#fmt_texto_udo').prop('checked',true) ;
    $('#fmt_med_proyecto').prop('checked',true) ;  
    $('#fmt_resumen_cap').prop('checked',true) ;  
    $('#fmt_anadir_med').prop('checked',false) ;  
    $('#fmt_seleccion').prop('checked',false) ;  
}

</script>    

 
 <h1><span class='noprint'>PAGOS Y COBROS</span></h1>
 
         <!--ENCABEZADOS PARA IMPRESION-->
 <!--<div class='divHeader'>-->
 <div >
   <h4 class='border'><?php // echo $NOMBRE_COMPLETO;?></h4>
   <h6>EXPEDIENTE: <?php // echo $EXPEDIENTE;?></h6>
 </div>  
   <h3><?php // echo $PRODUCCION;?></h3>

   
<!--  <div class='divFooter'>
   <h6 class='border'>Página</h6> 
 </div>  
   -->
    <div class='row noprint' style='border-style: solid ; border-color:grey; margin-bottom: 5px; padding:10px'>
 
   
   <form class='noprint' action="../bancos/pagos_y_cobros.php" method="post" id="form1" name="form1">
      <INPUT type='hidden' id='fecha_cal' name='fecha_cal' value='<?php echo $fecha_cal;?>'>
       
    <div class='col-lg-4'>
           
<TABLE class="noprint">
<!--    <TR><TD color=red colspan=2 bgcolor=PapayaWhip align=center>
            
        </TD></TR>-->

    
<!--<TR><TD>CAPITULO   </TD><TD><INPUT class="form-control" type="text" id="CAPITULO" name="CAPITULO" value="<?php echo $CAPITULO;?>"><button type="button" onclick="document.getElementById('CAPITULO').value='' ; ">*</button></TD></TR>-->    
<TR><TD>TIPO (P=pago, C=cobro, T=traspaso..) </TD><TD><INPUT  type="text" id="tipo_pago" name="tipo_pago" value="<?php echo $tipo_pago;?>"><button type="button" onclick="document.getElementById('tipo_pago').value='' ; ">*</button></TD></TR>
<TR><TD>Banco </TD><TD><INPUT   type="text" id="banco" name="banco" value="<?php echo $banco;?>"><button type="button" onclick="document.getElementById('banco').value='' ; ">*</button></TD></TR>
<TR><TD>tipo doc  </TD><TD><INPUT   type="text" id="tipo_doc" name="tipo_doc" value="<?php echo $tipo_doc;?>"><button type="button" onclick="document.getElementById('tipo_doc').value='' ; ">*</button></TD></TR>
<TR><TD>Observaciones </TD><TD><INPUT   type="text" id="observaciones" name="observaciones" value="<?php echo $observaciones;?>"><button type="button" onclick="document.getElementById('observaciones').value='' ; ">*</button></TD></TR>
<TR><TD>F. vencimiento desde</TD><TD><INPUT   type="date" id="f_vto1" name="f_vto1" value="<?php echo $f_vto1;?>"><button type="button" onclick="document.getElementById('f_vto1').value='' ; ">*</button></TD></TR>
<TR><TD>F. vencimiento hasta</TD><TD><INPUT   type="date" id="f_vto2" name="f_vto2" value="<?php echo $f_vto2;?>"><button type="button" onclick="document.getElementById('f_vto2').value='' ; ">*</button></TD></TR>

</TABLE></div><div class='col-lg-4'><TABLE> 


<TR><TD>Cargo desde     </TD><TD><INPUT  type="text" id="importe1" name="importe1" value="<?php echo $importe1;?>"><button type="button" onclick="document.getElementById('importe1').value='' ; ">*</button></TD></TR>
<TR><TD>Cargo hasta    </TD><TD><INPUT type="text" id="importe2" name="importe2" value="<?php echo $importe2;?>"><button type="button" onclick="document.getElementById('importe2').value='' ; ">*</button></TD></TR>
<TR><TD>Ingreso desde <TD><INPUT   type="text" id="ingreso1" name="ingreso1" value="<?php echo $ingreso1;?>"><button type="button" onclick="document.getElementById('ingreso1').value='' ; ">*</button></TD></TR>
<TR><TD>Ingreso hasta </TD><TD><INPUT   type="text" id="ingreso2" name="ingreso2" value="<?php echo $ingreso2;?>"><button type="button" onclick="document.getElementById('ingreso2').value='' ; ">*</button></TD></TR>


</TABLE></div><div class='col-lg-4'><TABLE> 

<TR><TD>Remesa    </TD><TD><INPUT type="text" id="remesa" name="remesa" value="<?php echo $remesa;?>"><button type="button" onclick="document.getElementById('remesa').value='' ; ">*</button></TD></TR>
<TR><TD>Cuenta    </TD><TD><INPUT type="text" id="cuenta" name="cuenta" value="<?php echo $cuenta;?>"><button type="button" onclick="document.getElementById('cuenta').value='' ; ">*</button></TD></TR>

<?php

// RADIO BUTTON CHK
//Datos
$radio=$cobrado ;
$radio_name='cobrado' ;
$radio_options=["todos","cobrados","no cobrados"];

// código
$chk_todos =  ['','']  ; $chk_on = ['','']  ; $chk_off =  ['','']  ;
if ($radio=="") { $chk_todos = ["active","checked"] ;} elseif ($radio==1) { $chk_on =  ["active","checked"]  ;} elseif ($radio==0)  { $chk_off =  ["active","checked"]  ;}
//echo "<br><input type='radio' id='activa' name='activa' value='' $chk_todos />Todas las obras      <input type='radio' id='activa' name='activa' value='1' $chk_on />Activas  <input type='radio' id='activa' name='activa' value='0' $chk_off  />No Activas" ;
$radio_html= "<div class='btn-group btn-group-toggle' data-toggle='buttons'>"
     . "<label class='btn btn-default {$chk_todos[0]}'><input type='radio' id='{$radio_name}' name='$radio_name' value='' {$chk_todos[1]} />{$radio_options[0]}</label> "
     . "<label class='btn btn-default {$chk_on[0]}'><input type='radio' id='{$radio_name}1' name='$radio_name' value='1'  {$chk_on[1]} />{$radio_options[1]} </label>"
     . "<label class='btn btn-default {$chk_off[0]}'><input type='radio' id='{$radio_name}0' name='$radio_name' value='0' {$chk_off[1]}  />{$radio_options[2]}</label>"
     . "</div>"
     . "" ;
// FIN PADIO BUTTON CHK
echo "<TR><TD>$radio_name</td><td>$radio_html</TD></TR>" ;




?>
<TR><TD>Proveedor    </TD><TD><INPUT type="text" id="proveedor" name="proveedor" value="<?php echo $proveedor;?>"><button type="button" onclick="document.getElementById('proveedor').value='' ; ">*</button></TD></TR>
<TR><TD>Cliente    </TD><TD><INPUT type="text" id="cliente" name="cliente" value="<?php echo $cliente;?>"><button type="button" onclick="document.getElementById('cliente').value='' ; ">*</button></TD></TR>

<TR><TD></TD><TD><INPUT type="submit" class='btn btn-success btn-xl' style='width: 15vw;'  value="actualizar consulta" id="submit" name="submit"></TD></TR>

<input type="hidden"  id="agrupar"  name="agrupar" value="<?php echo $agrupar;?>"> 

</TABLE></div></div>


<!--<div class='noprint'>
Formato:&nbsp; 
        <label><INPUT type="checkbox" id="fmt_pagos_pdtes" name="fmt_pagos_pdtes" <?php echo $fmt_pagos_pdtes;?>  >&nbsp;pagos pdtes.&nbsp;&nbsp;</label>
        <label><INPUT type="checkbox" id="fmt_costes" name="fmt_cobros_pdtes" <?php echo $fmt_cobros_pdtes;?>  >&nbsp;cobros pdtes.&nbsp;&nbsp;</label>
        <label><INPUT type="checkbox" id="fmt_texto_udo" name="fmt_texto_udo" <?php echo $fmt_texto_udo;?>  >&nbsp;Texto udo&nbsp;&nbsp;</label>
        <label><INPUT type="checkbox" id="fmt_med_proyecto" name="fmt_med_proyecto" <?php echo $fmt_med_proyecto;?>  >&nbsp;MED_PROYECTO&nbsp;&nbsp;</label>
        <label><INPUT type="checkbox" id="fmt_resumen_cap" name="fmt_resumen_cap" <?php echo $fmt_resumen_cap;?>  >&nbsp;Resumen capitulos&nbsp;&nbsp;</label>
        <label><INPUT type="checkbox" id="fmt_anadir_med" title='añade una columna donde poder añadir mediciones' name="fmt_anadir_med" <?php echo $fmt_anadir_med;?>  >&nbsp;Columna Añadir Med.&nbsp;&nbsp;</label>
         <a class="btn btn-link btn-xs noprint" title="formato para realizar un Estudio de costes de un Proyecto o Liciación" href=#  onclick="formato_estudio_costes();"><i class="fas fa-euro-sign"></i> modo Estudio de Costes</a>
         <a class="btn btn-link btn-xs noprint" title="formato de formulario para registrar Producciones de Obra" href=#  onclick="formato_prod_obra();"><i class="fas fa-hard-hat"></i> modo Producción Obra</a>
         <a class="btn btn-link btn-xs noprint" title="imprimir la producción con formato de Certificación sin costes, con texto_udo y con resumen" href=#  onclick="formato_certif();"><i class="fas fa-print"></i> modo Certificacion</a>

       
</div>         
         -->
<?php  

//$style_hidden_if_global=$listado_global? " disabled " : ""  ;

echo "<div id='myDIV' class='noprint' style='margin-top: 25px; padding:10px'>" ; 


$btnt['ultimos']=['ultimos pagos','últimos pagos y cobros registrados', ''] ;
$btnt['listado']=['pagos','listado de los Pagos y Cobros filtrados',''] ;
$btnt['bancos']=['bancos','Agrapa por Banco los pagos y cobros previstos o realizados',''] ;
$btnt['tipo_doc']=['tipo_doc','Agrupa por tipo de documento emitido (cheque, transferencia, confirming, facturing, remesa...)',''] ;
$btnt['remesa']=['remesa','Agrupa por remesas',''] ;
$btnt['cuenta']=['cuenta','Agrupa por cuentas',''] ;
$btnt['proveedor']=['proveedor','Agrupa por proveedor',''] ;
//$btnt['cliente']=['cliente','', $style_hidden_if_global] ;
$btnt['cliente']=['cliente','', ''] ;
$btnt['fecha']=['fecha','Agrupa por Obra',''] ;
$btnt['meses']=['meses','',''] ;
$btnt['calendar']=['calendario','',''] ;
$btnt['annos']=['años','',''] ;
//$btnt['comparadas']=['comparadas','',''] ;
//$btnt['EDICION']=['MODO EDICION','' ,$style_hidden_if_global ] ;

foreach ( $btnt as $clave => $valor)
{
  $active= ($clave==$agrupar) ? " cc_active" : "" ; 
  $disabled= $valor[2]  ;
  echo "<button $disabled id='btn_agrupar_$clave' class='cc_btnt$active' title='{$valor[1]}' onclick=\"getElementById('agrupar').value = '$clave'; document.getElementById('form1').submit(); \">{$valor[0]}</button>" ;  
}           
  
echo '</div>' ;

//echo "<button  class='btn btn-warning' title='copia el resultado de la consulta a una produccion nueva' onclick=\"getElementById('crea_produccion').value = '1'; document.getElementById('form1').submit(); \">Consulta a prod. nueva</button>" ;  

  // Iniciamos variables para tabla.php  background-color:#B4045


$where=" $where_c_coste " ;

//$where=$tipo_subcentro==""? $where : $where . " AND LOCATE(tipo_subcentro,'$tipo_subcentro')>0 " ;

$where = $tipo_pago==""? $where : $where . " AND tipo_pago='$tipo_pago' " ;
$where = $banco   == ""? $where : $where . " AND      Banco LIKE '%$banco%'" ;
$where = $tipo_doc=="" ? $where : $where . " AND  tipo_doc  LIKE '%$tipo_doc%' " ;
$where = $ref_doc =="" ? $where : $where . " AND   ref_doc  LIKE '%$ref_doc%' " ;
$where=$observaciones==""? $where : $where . " AND observaciones LIKE '%$observaciones%'" ;

$where=$f_vto1 ==""? $where : $where . " AND f_vto >= '$f_vto1' " ;
$where=$f_vto2 ==""? $where : $where . " AND f_vto <= '$f_vto2' " ;

$where=$importe1 ==""? $where : $where . " AND importe >= '$importe1' " ;
$where=$importe2 ==""? $where : $where . " AND importe <= '$importe2' " ;

$where=$ingreso1 ==""? $where : $where . " AND ingreso >= '$ingreso1' " ;
$where=$ingreso2 ==""? $where : $where . " AND ingreso <= '$ingreso2' " ;

$where=$remesa =="" ? $where : $where . " AND  remesa   LIKE '%$remesa%' " ;
$where=$cuenta =="" ? $where : $where . " AND  cuenta   LIKE '%$cuenta%' " ;
$where=$cobrado =="" ? $where : $where . " AND  conc=$cobrado " ;                    // un pago conciliado con el banco es un pago cobrado

$where=$proveedor  =="" ? $where : $where . " AND  PROVEEDOR    LIKE '%$proveedor%' " ;
$where=$cliente  =="" ? $where : $where . " AND  CLIENTE    LIKE '%$cliente%' " ;


//$where=$TIPO_GASTO==""? $where : $where . " AND TIPO_GASTO LIKE '%$TIPO_GASTO%'" ;
//$where=$FECHA1=="01-01-1980"? $where : $where . " AND FECHA >= STR_TO_DATE($FECHA1,'%d-%m-%Y')" ;

//if ($agrupar<>"EDICION") {$where=$FECHA1==""? $where : $where . " AND FECHA >= '$FECHA1' " ;}
//if ($agrupar<>"EDICION")  {$where=$FECHA2==""? $where : $where . " AND FECHA <= '$FECHA2' " ; }


//// SELECT A INCLUIR EN LOS SQL SEGUN EL FORMATO ///////////////////////////////////////////
//$select_global = $listado_global ? "NOMBRE_OBRA, ID_PRODUCCION, PRODUCCION," : ""  ;               
//$select_global_T = $listado_global ? "'' AS ag, '' AS bg,'' AS cg," : "'' AS cg,"  ;   
//
//// SI ES formato Costes $fmt_costes añadimos las columnas gastos_est y beneficio
////$select_COSTE_EST = $fmt_costes ? ",IF(PRECIO=COSTE_EST,'moneda_gris','moneda') AS COSTE_EST_FORMAT, COSTE_EST,Estudio_coste " : ""  ;               
//$select_COSTE_EST = $fmt_costes ? ", COSTE_EST,Estudio_coste " : ""  ;               
//$select_COSTE_EST_T = $fmt_costes ? ", '' as COSTE_EST, '' as acc " : ""  ;               
//$select_costes = $fmt_costes ? ", SUM(gasto_est) as gasto_est,(SUM(IMPORTE)- SUM(gasto_est)) as beneficio" : ""  ;               
////$select_costes_T = $fmt_costes ? ", SUM(gasto_est) as gasto_est, '<small>Benef. Estimado</small>' as leyenda_beneficio, ''" : ""  ;   
//$select_costes_T = $fmt_costes ? ", SUM(gasto_est) as gasto_est, (SUM(IMPORTE)- SUM(gasto_est)) as beneficio " : ""  ;   
//$select_costes_T2 = $fmt_costes ? ", SUM(gasto_est) as gasto_est,(SUM(IMPORTE)*(1+GG_BI)*COEF_BAJA- SUM(gasto_est)) as beneficio " : ""  ;   
//$select_costes_T3 = $fmt_costes ? ", SUM(gasto_est)*(1+iva_obra) as gasto_est, (1- SUM(gasto_est)/(SUM(IMPORTE)*(1+GG_BI)*COEF_BAJA)) as margen " : ""  ;   
//
//
//$select_UDO = $fmt_texto_udo ? " ,CONCAT('<b>',UDO,'</b><br><small>',TEXTO_UDO,'</small>') AS UDO " : " ,UDO "  ;               
//
////$select_JOIN_med_proyecto = $fmt_med_proyecto ? " JOIN Capitulos_importe ON ConsultaProd.ID_CAPITULO=Capitulos_importe.ID_CAPITULO  " : ""  ;               
////$select_MED_PROYECTO = $fmt_med_proyecto ? ", MED_PROYECTO,MED_PROYECTO*PRECIO as importe_proy, (MED_PROYECTO >= SUM(MEDICION) ) AS exceso,(MED_PROYECTO*PRECIO - SUM(MEDICION)*PRECIO) as importe_pdte " : ""  ;               
//$select_MED_PROYECTO = $fmt_med_proyecto ? ",IF(MED_PROYECTO=MEDICION,'fijo_gris','fijo') AS MEDICION_FORMAT, MED_PROYECTO,MED_PROYECTO*PRECIO as importe_proy, (MED_PROYECTO*PRECIO - SUM(MEDICION)*PRECIO) as importe_pdte_ej " : ""  ;               
//$select_MED_PROYECTO_detalle = $fmt_med_proyecto ? ", MED_PROYECTO " : ""  ;               
//$select_importe_proyecto = $fmt_med_proyecto ? ", importe_proyecto,  SUM(IMPORTE)/importe_proyecto AS P_ejec,importe_proyecto - SUM(IMPORTE) as importe_pdte_ej " : ""  ;               
//$select_importe_proyecto_T = $fmt_med_proyecto ? ", SUM(importe_proyecto),  SUM(IMPORTE)/SUM(importe_proyecto) AS P_ejec ,SUM(importe_proyecto) - SUM(IMPORTE) as importe_pdte_ej " : ""  ;               
////$select_SUM_importe_proyecto = $fmt_med_proyecto ? ", SUM(importe_proyecto) " : ""  ;               
////$select_SUM_importe_proyecto_GG_BI = $fmt_med_proyecto ? ", SUM(importe_proyecto)*(1+GG_BI)*COEF_BAJA*(1+iva_obra) " : ""  ;               
//$select_MED_PROYECTO_hueco = $fmt_med_proyecto ? ", '' AS hueco " : ""  ;               
//$select_MED_PROYECTO_hueco_doble = $fmt_med_proyecto ? ", '' AS hueco,'' AS hueco2 " : ""  ;    
//
////$fmt_anadir_med=1;
//$select_anadir_med = $fmt_anadir_med ? " ,CONCAT('<input  type=text size=3 id=UDO_' , ID_UDO, '>' ) AS Anadir_Med " : ""  ;               
//$select_anadir_med_Udos_View = $fmt_anadir_med ? " ,CONCAT('<input  type=text size=3 id=UDO_' , Udos_View.ID_UDO, '>' ) AS Anadir_Med " : ""  ;               


$tipo_tabla='' ;       // indica si usamos tabla.php o tabla_group.php o tabla_pdf.php
//$tabla_pdf=0 ;             // usaremos TABLA_GROUP.PHP 


// defino totales para Agrupamiento 'capituos' y cap_udos'

//$sql_T_resumen="SELECT $select_global_T 'Suma Ejecución Material........................' $select_MED_PROYECTO_hueco_doble , SUM(IMPORTE) as importe $select_costes_T  FROM ConsultaProd WHERE $where    " ;
//$sql_T2_resumen="SELECT $select_global_T CONCAT('Suma Ejecución Contrata... GG+BI x COEF_BAJA:',COEF_BAJA)$select_MED_PROYECTO_hueco_doble , SUM(IMPORTE)*(1+GG_BI)*COEF_BAJA as importe $select_costes_T2  FROM ConsultaProd WHERE $where    " ;
//$sql_T3_resumen="SELECT $select_global_T 'Suma Ejecución Contrata (iva incluido).. ' $select_MED_PROYECTO_hueco_doble , SUM(IMPORTE)*(1+GG_BI)*COEF_BAJA*(1+iva_obra)/IMPORTE_OBRA as P_ejec , SUM(IMPORTE)*(1+GG_BI)*COEF_BAJA*(1+iva_obra) as importe $select_costes_T3 FROM ConsultaProd WHERE $where    " ;

// FIN DE SELECT A INCLUIR EN SQL  //////////////////////////////////


// BOTONES A MOSTRAR SEGUN EL FORMATO, SELECCIÓN, ANADIR_MED...

$content_sel="" ;         // inicializamos el contenido del <div> SELECTION
$content_anadir_med="" ;

   
//// contenedor selection por defecto
//     $content_sel.="<div class='border noprint' >" ;
//     $content_sel.="<big>Seleccionados:</big> <a class='btn btn-danger btn-xs noprint btn_topbar' href='#' onclick='borrar_mediciones_udo($id_produccion)' title='Vacía las mediciones de las Udo seleccionadas' ><i class='far fa-trash-alt'></i> Borrar mediciones Udos seleccionadas</a>" ;
//     $content_sel.="<a class='btn btn-warning btn-xs noprint btn_topbar' href='#' onclick='prod_completa_udo($id_produccion)' title='Completa hasta Medicion de Proyecto (MED_PROYECTO) las Udos seleccionadas' >MED_PROYECTO a Udos seleccionadas</a>" ;
//     $content_sel.="</div>" ; 
//     
//    if ($fmt_anadir_med) $content_anadir_med="  <a class='btn btn-warning btn-xs noprint btn_topbar' href='#' onclick='prod_anade_med_udo($id_produccion)' title='Añade a cada unidad de obra la medición de la columna 'Añadir Med' >añade columna de mediciones </a>" ;
//
////    $sql="SELECT  ID_OBRA,ID_CAPITULO, CAPITULO AS ID_SUBTOTAL_CAPITULO,ID_UDO,ID_UDO AS _ID_UDO,ud $select_UDO $select_MED_PROYECTO,SUM(MEDICION) as MEDICION"
////           . " $select_anadir_med , PRECIO, SUM(IMPORTE) as importe $select_COSTE_EST $select_costes  FROM ConsultaProd WHERE $where  GROUP BY ID_UDO ORDER BY CAPITULO,ID_UDO " ;
//
////    $where_urlencode=rawurlencode($where) ;
//    $where_urlencode=base64_encode($where) ;
////    $where_urlencode=$where ;
//    echo " <a class='btn btn-warning btn-xs noprint btn_topbar' href='#' onclick=\"copy_prod_consulta($id_obra,$id_produccion,'$where_urlencode','$PRODUCCION')\" title='Crea una Relación Valorada nueva con la consulta actual' >crea Rel.Valorada nueva</a>" ;
  
// FIN BOTONES A MOSTRAR

?>
<!--EXPAND SELECCION -->    
  
<br><button type='button' class='btn btn-default noprint' id='exp_seleccion' data-toggle='collapse' data-target='#div_seleccion'>Operar con movimientos seleccionados <i class="fa fa-angle-down" aria-hidden="true"></i></button>
<div id='div_seleccion' class='collapse'>
  
<div class="noprint" style="border-width:1px; border-style:solid;">
  <b>Acciones a realizar con Pagos y Cobros seleccionados:</b>
    <div style="margin:10px">
          
 <?php

// eliminacion en grupo de seleccionados
//$where_id_cta_banco= $listado_global ? "1=1" : "id_cta_banco=$id_cta_banco" ;      // permitimos borrar en listado global
$sql_delete= "DELETE FROM `PAGOS` WHERE  id_pago IN _VAR_SQL1_ ; "  ;
$href='../include/sql.php?sql=' . encrypt2($sql_delete)  ;    
echo "<a class='btn btn-danger btn-xs noprint ' href='#' "
     . " onclick=\"js_href('$href' ,'1','¿Borrar Pagos o cobros seleccionados? Recuerde no pueden estar conciliados' ,'table_selection_IN()' )\"   "
     . "title='Borra los Pagos  seleccionados' ><i class='far fa-trash-alt'></i> Borrar Pagos seleccionadas</a>" ;
      
      

      
 ?>     
    </div>

</div>
</div>
<!--FIN BOTONES SELECCION  -->     

<?php



 switch ($agrupar) {
   case "ultimos":
     $sql="SELECT id_proveedor,ID_CLIENTE,ID_FRA_PROV, ID_FRA_CLI,id_pago,id_cta_banco,id_remesa,id_nota_gastos, tipo_pago,f_vto,tipo_doc,Ref_Doc,Banco,observaciones "
           . ",importe,ingreso,remesa,cuenta,PROVEEDOR,N_FRA_PROV,FProv,CLIENTE,N_FRA_CLI,FCli,conc as cobrado,NG "
           . " FROM Pagos_View WHERE $where ORDER BY f_vto DESC LIMIT 100 " ;
//     $sql="SELECT * "
//           . " FROM Pagos_View WHERE $where AND NG=1 ORDER BY f_vto DESC LIMIT 100 " ;
     $sql_T="SELECT COUNT(id_pago) as num_pagos,'' as a0,'' as a1,'' as a2,'' as a3, 'Suma' ,  SUM(importe) as importe, SUM(ingreso) as ingreso  FROM Pagos_View WHERE $where    " ;
     $col_sel="id_pago" ;
   break;
   case "listado":
     $sql="SELECT id_proveedor,ID_CLIENTE,ID_FRA_PROV, ID_FRA_CLI,id_pago,id_cta_banco,id_remesa,id_nota_gastos,tipo_pago,f_vto,tipo_doc,Ref_Doc,observaciones "
           . ",importe,ingreso,remesa,cuenta,PROVEEDOR,N_FRA_PROV,FProv,CLIENTE,N_FRA_CLI,FCli,conc as cobrado,NG "
           . " FROM Pagos_View WHERE $where ORDER BY f_vto   " ;
     $sql_T="SELECT COUNT(id_pago) as num_pagos,'' as a0,'' as a1,'' as a2,'' as a3, 'Suma' ,  SUM(importe) as importe, SUM(ingreso) as ingreso  FROM Pagos_View WHERE $where    " ;
     $col_sel="id_pago" ;
   break;
   case "tipo_doc":
     $sql="SELECT tipo_doc,COUNT(id_pago) as num_pagos, SUM(importe) as importe, SUM(ingreso) as ingreso "
           . " FROM Pagos_View WHERE $where  GROUP BY tipo_doc ORDER BY tipo_doc " ;
     $sql_T="SELECT 'Suma' , COUNT(id_pago) as num_pagos, SUM(importe) as importe, SUM(ingreso) as ingreso  FROM Pagos_View WHERE $where    " ;
   break;
   case "bancos":
     $sql="SELECT id_cta_banco,id_pago,Banco,COUNT(id_pago) as num_pagos, SUM(importe) as importe, SUM(ingreso) as ingreso "
           . " FROM Pagos_View WHERE $where  GROUP BY Banco ORDER BY Banco" ;
     $sql_T="SELECT 'Suma' , COUNT(id_pago) as num_pagos, SUM(importe) as importe, SUM(ingreso) as ingreso  FROM Pagos_View WHERE $where    " ;
   break;
   case "remesa":
     $sql="SELECT id_pago,id_remesa,remesa,f_vto_remesa,remesa,COUNT(id_pago) as num_pagos, SUM(importe) as importe, SUM(ingreso) as ingreso "
           . " FROM Pagos_View WHERE $where  GROUP BY id_remesa ORDER BY f_vto_remesa " ;
     $sql_T="SELECT 'Suma' , COUNT(id_pago) as num_pagos, SUM(importe) as importe, SUM(ingreso) as ingreso  FROM Pagos_View WHERE $where    " ;
   break;
   case "cuenta":
     $sql="SELECT id_pago,cuenta,COUNT(id_pago) as num_pagos, SUM(importe) as importe, SUM(ingreso) as ingreso "
           . " FROM Pagos_View WHERE $where  GROUP BY cuenta ORDER BY cuenta" ;
     $sql_T="SELECT 'Suma' , COUNT(id_pago) as num_pagos, SUM(importe) as importe, SUM(ingreso) as ingreso  FROM Pagos_View WHERE $where    " ;
   break;
   case "proveedor":
     $sql="SELECT id_proveedor,id_pago,PROVEEDOR,COUNT(id_pago) as num_pagos, SUM(importe) as importe, SUM(ingreso) as ingreso "
           . " FROM Pagos_View WHERE $where  GROUP BY id_proveedor ORDER BY PROVEEDOR" ;
     $sql_T="SELECT 'Suma' , COUNT(id_pago) as num_pagos, SUM(importe) as importe, SUM(ingreso) as ingreso  FROM Pagos_View WHERE $where    " ;
   break;
   case "cliente":
     $sql="SELECT ID_CLIENTE,id_pago,CLIENTE,COUNT(id_pago) as num_pagos, SUM(importe) as importe, SUM(ingreso) as ingreso "
           . " FROM Pagos_View WHERE $where  GROUP BY CLIENTE ORDER BY CLIENTE" ;
     $sql_T="SELECT 'Suma' , COUNT(id_pago) as num_pagos, SUM(importe) as importe, SUM(ingreso) as ingreso  FROM Pagos_View WHERE $where    " ;
   break;
   case "fecha":
//     $sql="SELECT id_pago,f_vto,COUNT(id_pago) as num_pagos, SUM(importe) as importe, SUM(ingreso) as ingreso "
//           . ", (@saldo_acum := @saldo_acum + 1) AS contador FROM Pagos_View  JOIN (SELECT  @saldo_acum := 10) r WHERE $where  GROUP BY f_vto ORDER BY f_vto" ;
   
       echo "<BR>RESULT->" . $result=$Conn->query("SET @saldo_acum = 20;") ;

       $sql="SELECT id_pago,f_vto,COUNT(id_pago) as num_pagos, SUM(importe) as importe, SUM(ingreso) as ingreso "
           . ", (@saldo_acum := @saldo_acum + 1) AS contador FROM Pagos_View  WHERE $where  GROUP BY f_vto ORDER BY f_vto " ;
       
//       SELECT t.id,
//         t.count,
//         @running_total := @running_total + t.count AS cumulative_sum
//    FROM TABLE t
//    JOIN (SELECT @running_total := 0) r
//ORDER BY t.id
       
       
     $sql_T="SELECT 'Suma' , COUNT(id_pago) as num_pagos, SUM(importe) as importe, SUM(ingreso) as ingreso  FROM Pagos_View WHERE $where    " ;
   break;
   case "meses":
     $sql="SELECT id_pago,DATE_FORMAT(f_vto, '%Y-%m') as MES,COUNT(id_pago) as num_pagos, SUM(importe) as importe, SUM(ingreso) as ingreso "
           . " FROM Pagos_View WHERE $where  GROUP BY MES ORDER BY MES" ;
     $sql_T="SELECT 'Suma' , COUNT(id_pago) as num_pagos, SUM(importe) as importe, SUM(ingreso) as ingreso  FROM Pagos_View WHERE $where    " ;
   break;
   case "calendar":
     $sql="SELECT id_pago,f_vto as fecha,'Num_pagos: ', COUNT(id_pago) as num_pagos,'<br><font color=red>Cargos:</font> ', SUM(importe) as importe,'<br><font color=green>Ingresos:</font> ', SUM(ingreso) as ingreso "
           . " FROM Pagos_View WHERE $where  GROUP BY f_vto ORDER BY f_vto" ;
     $tipo_tabla='calendar'  ;
     
//     $sql="SELECT ID_PARTE, ID_OBRA, MID(NOMBRE_OBRA,1,10) as link_calendario,Fecha,'<br>' as a1,NumP,importe_parte,'<br>' as br,(NumV-1) AS Num_otros_alb, "
//            . "importe_otros_alb  ,IF(importe_prod,'<br>Prod:','') as br2, importe_prod ,'<br>' as br3, fotos,IF(Cargado,'','<font color=red> (NC)</font>') as cc "
//            . " FROM Partes_ViewC WHERE $where ORDER BY  Fecha,NOMBRE_OBRA   " ;
     
//     $sql_T="SELECT 'Suma' , COUNT(id_pago) as num_pagos, SUM(importe) as importe, SUM(ingreso) as ingreso  FROM Pagos_View WHERE $where    " ;
   break;
   case "annos":
     $sql="SELECT id_pago,DATE_FORMAT(f_vto, '%Y') as ANNO,COUNT(id_pago) as num_pagos, SUM(importe) as importe, SUM(ingreso) as ingreso "
           . " FROM Pagos_View WHERE $where  GROUP BY ANNO ORDER BY ANNO" ;
     $sql_T="SELECT 'Suma' , COUNT(id_pago) as num_pagos, SUM(importe) as importe, SUM(ingreso) as ingreso  FROM Pagos_View WHERE $where    " ;
   break;
      
  }

$dblclicks["fecha"]="FECHA*" ;
$dblclicks["FECHA"]="FECHA*" ;
$dblclicks["MES"]="FECHA*" ;

$formats["MES"]="mes" ;                //"pdf_800" ;
$formats["cobrado"]="semaforo_OK" ;                //"pdf_800" ;

$formats["tipo_pago"]="tipo_pago" ;                //FORMATO ESPECIAL PARA tipo_pago


$links["Banco"] = ["../bancos/bancos_mov_bancarios.php?id_cta_banco=", "id_cta_banco", "", "formato_sub_vacio"] ;
$links["observaciones"] = ["../bancos/pago_ficha.php?id_pago=", "id_pago", "ver pago", "formato_sub"] ;
$links["remesa"] = ["../bancos/remesa_ficha.php?id_remesa=", "id_remesa", "ver Remesa", "formato_sub_vacio"] ;
//$links["f_vto"] = ["../bancos/pago_ficha.php?id_pago=", "id_pago", "ver pago", "formato_sub"] ;
$links["PROVEEDOR"]=["../proveedores/proveedores_ficha.php?id_proveedor=", "id_proveedor" , "ver Proveedor", "formato_sub_vacio"] ;
$links["N_FRA_PROV"]=["../proveedores/factura_proveedor.php?id_fra_prov=", "ID_FRA_PROV" , "ver Factura Proveedor", "formato_sub_vacio"] ;

$links["CLIENTE"] = ["../clientes/clientes_ficha.php?id_cliente=","ID_CLIENTE", "ver Cliente", "formato_sub_vacio"] ;
$links["N_FRA_CLI"]=["../clientes/factura_cliente.php?id_fra=", "ID_FRA_CLI" , "ver Factura Ciente", "formato_sub_vacio"] ;

$links["fecha_banco"]=["../bancos/pago_ficha.php?id_mov_banco=", "id_mov_banco","ver el mov. bancario del cobro", "formato_sub_vacio"] ;
$links["concepto_banco"]=["../bancos/pago_ficha.php?id_mov_banco=", "id_mov_banco","ver el mov. bancario del cobro", "formato_sub_vacio"] ;

$dblclicks=[] ;  
$dblclicks["NOMBRE_OBRA"]="OBRA" ;
$dblclicks["PROVEEDOR"]="proveedor" ;
$dblclicks["CLIENTE"]="cliente" ;
$dblclicks["remesa"]="remesa" ;
$dblclicks["tipo_doc"]="tipo_doc" ;
$dblclicks["CUENTA"]="cuenta" ;
//$dblclicks["f_vto"]="tipo_doc" ;

 //$links["CAPITULO"] = ["../obras/obras_ficha.php?id_obra=", "ID_OBRA"] ;
//echo $sql ;
//echo $sql_T ;
//echo $sql ;
//echo $sql ;
$result=$Conn->query($sql) ;

echo "<div class='noprint'>Filas: {$result->num_rows} <br></div>" ;
//echo $sql ;

if (isset($sql_T)) {$result_T=$Conn->query($sql_T) ; }    // consulta para los TOTALES
if (isset($sql_T2)) {$result_T2=$Conn->query($sql_T2) ; }    // consulta para los TOTALES
if (isset($sql_T3)) {$result_T3=$Conn->query($sql_T3) ; }    // consulta para los TOTALES
if (isset($sql_S)) {$result_S=$Conn->query($sql_S) ; }     // consulta para los SUBGRUPOS , agrupación de filas (Ej. CLIENTES o CAPITULOS en listado de udos)

//$links["NOMBRE_OBRA"] = ["../obras/obras_ficha.php?id_obra=", "ID_OBRA"] ;
//
//if (!$listado_global)
//{
////$links["UDO"] = ["../obras/udo_prod.php?id_produccion=$id_produccion&id_udo=", "ID_UDO","ver detalles de medición de la Unidad de Obra" ,"formato_sub"] ;    
//$links["UDO"] = ["../obras/udo_prod.php?id_produccion=$id_produccion&id_udo=", "ID_UDO" ,"ver detalles de medición de la Unidad de Obra", 'formato_sub'] ;    
//}    
//else
//{
//$links["UDO"] = ["../obras/udo_prod.php?id_udo=", "ID_UDO", "ver ficha de la unidad de obra", "formato_sub"] ;  
//$links["PRODUCCION"]=["../obras/obras_prod_detalle.php?id_produccion=", "ID_PRODUCCION"] ;
//
//}    
//    
//$links["NOMBRE_OBRA"]=["../obras/obras_ficha.php?id_obra=", "ID_OBRA"] ;
//
//$updates[]='Estudio_coste' ;
//
//$formats["Estudio_coste"] = "text_edit" ;
//$formats["COSTE_EST"] = "text_moneda" ;
//$tooltips["COSTE_EST"] = "Admite formula matemática a calcular, anteponer ==,  ejemplo\n == 50*.15 + 2.5" ;
//$formats["margen"] = "porcentaje" ;
//$formats["P_ejec"] = "porcentaje" ;
//$formats["importe"] = "moneda" ;
//$formats["beneficio"] = "moneda" ;
//$formats["gasto_est"] = "moneda" ;
//$formats["COSTE"] = "moneda" ;
////$formats["COSTE_EST"] = "text_edit" ;
//$formats["MED_PROYECTO"] = "fijo" ;
//$formats["MEDICION"] = "fijo" ;
////$formats["fecha"] = "dbfecha" ;
////$formats["conc"] = "boolean" ;
//$formats["PRECIO"] = "moneda" ;
//$formats["exceso"] = "semaforo_OK" ;
////$formats["ingresos"] = "moneda" ;
//$aligns["leyenda_beneficio"] = "right" ;
////$aligns["Neg"] = "center" ;
//$aligns["Pagada"] = "center" ;
//$tooltips["conc"] = "Indica si el pago está conciliado" ;
//$tooltips["Banco_Neg"] = "Indica el banco o línea de descuento donde está negociada" ;


//$titulo="<small>Produccion por $agrupar</small>";
$msg_tabla_vacia="No hay.";

if (isset($col_sel))  echo $content_sel ;           // si hay columna de SELECTION pinto el div con los botones acciones de selection
if (isset($fmt_anadir_med))  echo $content_anadir_med ;           // si hay columna de SELECTION pinto el div con los botones acciones de selection


if ($tipo_tabla=='group')
{ require("../include/tabla_group.php"); }
else if ($tipo_tabla=='pdf')
{ require("../include/tabla_pdf.php"); }
else if ($tipo_tabla=='calendar')
{ require("../include/tabla_calendar.php"); }
else 
{ require("../include/tabla.php"); echo $TABLE ; }
    
echo "</form>" ;


?>
 <script>

//function prod_anade_med_udo(id_produccion)
//{  // añade la medicion de los INPUT a cada UDO
//
//    //    alert(id_produccion);
////     var nuevo_valor=window.confirm("¿Completar mediciones de UDO hasta MED_PROYETO? ");
////    alert("el nuevo valor es: "+valor) ;
//
//// contruimos el array_str de pares (ID_UDO, MEDICION)
//var array_str="" ;
// $('table input:text').each(
//    function() {
//        
////        array_str+=  $(this).attr('id') + '&' + $(this).val() ;
//        var id=$(this).prop('id') ;
//        
//        if (id.substring(0,4)=='UDO_')
//        {
//            
//          var id_udo=id.substring(4)  ;
////          if (id_udo==72152) $(this).val('123') ;
//          var medicion=$(this).val()  ;
//          if (medicion)
//          {
//              if (!(array_str=="" )) { array_str+= ";" } ;  // inserto el separador de filas
//              array_str+=  id_udo + '&' + medicion ;         // inserto la fila, el par de datos
//          } 
//        }
//    }
//  );
//  
////  array_str+= ")"  ;
//  
////  alert(array_str);  // debug
//  
//     var xhttp = new XMLHttpRequest();
//     xhttp.onreadystatechange = function() {
//    if (this.readyState == 4 && this.status == 200) {
//        if (this.responseText.substr(0,5)=="ERROR")
//        { alert(this.responseText) ;}                   // mostramos el ERROR
//        else
//        {  //alert(this.responseText) ;     //debug
//           location.reload(true); }  // refresco la pantalla tras edición
//      }
//  };
//  
////  $cadena_link="tabla=$tabla_update&wherecond=$id_update=".$rs["$id_update"] ; 
//
//  xhttp.open("GET", "../obras/prod_add_detalle_ajax.php?id_produccion=" + id_produccion + "&array_str=" + encodeURIComponent(array_str) , true);
//  xhttp.send();   
////    alert(table_selection_IN());
//  
//    
//  return ;  
//        
//}
//     
//function sel_borrar_mediciones_detalle()
// { 
//
//    var nuevo_valor=window.confirm("¿Borrar fila? ");
////    alert("el nuevo valor es: "+valor) ;
//   if (!(nuevo_valor === null) && nuevo_valor)
//   { 
//       
//       var xhttp = new XMLHttpRequest();
//     xhttp.onreadystatechange = function() {
//    if (this.readyState == 4 && this.status == 200) {
//        if (this.responseText.substr(0,5)=="ERROR")
//        { alert(this.responseText) ;}                   // mostramos el ERROR
//        else
//        {  //alert(this.responseText) ;     //debug
//           location.reload(true); }  // refresco la pantalla tras edición
//      }
//  };
//  
////  $cadena_link="tabla=$tabla_update&wherecond=$id_update=".$rs["$id_update"] ; 
//
//  xhttp.open("GET", "../include/tabla_delete_row_ajax.php?tabla=PRODUCCIONES_DETALLE&wherecond=id IN " + table_selection_IN() , true);
//  xhttp.send();   
//   }
//   else
//   {return;}
// 
//}
//
//function prod_completa_udo(id_produccion)
//{
////    alert(id_produccion);
////     var nuevo_valor=window.confirm("¿Completar mediciones de UDO hasta MED_PROYETO? ");
////    alert("el nuevo valor es: "+valor) ;
//
//  
//     var xhttp = new XMLHttpRequest();
//     xhttp.onreadystatechange = function() {
//    if (this.readyState == 4 && this.status == 200) {
//        if (this.responseText.substr(0,5)=="ERROR")
//        { alert(this.responseText) ;}                   // mostramos el ERROR
//        else
//        {  //alert(this.responseText) ;     //debug
//           location.reload(true); }  // refresco la pantalla tras edición
//      }
//  };
//  
////  $cadena_link="tabla=$tabla_update&wherecond=$id_update=".$rs["$id_update"] ; 
//
//  xhttp.open("GET", "../obras/prod_completa_udo_prod.php?id_produccion=" + id_produccion + "&table_selection_IN=" + table_selection_IN() , true);
//  xhttp.send();   
////    alert(table_selection_IN());
//  
//    
//  return ;  
//}
//
//function borrar_mediciones_udo(id_produccion)
// { 
//
//    var nuevo_valor=window.confirm("¿Borrar filas? ");
////    alert("el nuevo valor es: "+valor) ;
//   if (!(nuevo_valor === null) && nuevo_valor)
//   { 
//       
//       var xhttp = new XMLHttpRequest();
//     xhttp.onreadystatechange = function() {
//    if (this.readyState == 4 && this.status == 200) {
//        if (this.responseText.substr(0,5)=="ERROR")
//        { alert(this.responseText) ;}                   // mostramos el ERROR
//        else
//        {  //alert(this.responseText) ;     //debug
//           location.reload(true); }  // refresco la pantalla tras edición
//      }
//  };
//  
////  $cadena_link="tabla=$tabla_update&wherecond=$id_update=".$rs["$id_update"] ; 
//
//  xhttp.open("GET", "../include/tabla_delete_row_ajax.php?tabla=PRODUCCIONES_DETALLE&wherecond=ID_PRODUCCION=" + id_produccion +" AND ID_UDO IN " + table_selection_IN() , true);
//  xhttp.send();   
//   }
//   else
//   {return;}
// 
//}
//     
//     
//     
//     
//function add_detalle( id_produccion, id_udo, med_proyecto ) {
//    var nuevo_valor=window.prompt("Medición", med_proyecto);
////    alert("el nuevo valor es: "+valor) ;
//   if (!(nuevo_valor === null) )
//   { 
//       
//       var xhttp = new XMLHttpRequest();
//     xhttp.onreadystatechange = function() {
//    if (this.readyState == 4 && this.status == 200) {
//        if (this.responseText.substr(0,5)=="ERROR")
//        { alert(this.responseText) ;}                   // mostramos el ERROR
//        else
//        { //alert(this.responseText) ;       //debug
//          location.reload(true) ; }  // refresco page
//        
//      //document.getElementById("sugerir_obra").innerHTML = this.responseText;
//      }
//  };
//  xhttp.open("GET", "../obras/prod_add_detalle_ajax.php?id_produccion="+id_produccion+"&id_udo="+id_udo+"&medicion="+nuevo_valor, true);
//  xhttp.send();   
//   }
//   else
//   {return;}
//   
//}
//
// function copy_prod_consulta(id_obra,id_produccion,where,produccion0) {
////    var d = new Date();
////    var f=d.getFullYear() + "-" + (d.getMonth()+1) + "-" + d.getDate() ;
//     var produccion=window.prompt("Nombre de la nueva producción: ", produccion0  );
//
////    where=encodeURI(where) ;
//    alert(where) ;
//
//    
//   if (produccion)
//   {    
//       var xhttp = new XMLHttpRequest();
//     xhttp.onreadystatechange = function() {
//    if (this.readyState == 4 && this.status == 200) {
//        if (this.responseText.substr(0,5)=="ERROR")
//        { alert(this.responseText) ;}
//        else
//        {  //alert(this.responseText) ;     //debug
//            location.reload(true); }  // refresco la pantalla tras editar Producción
//      }
//  };
//  xhttp.open("GET", "../obras/prod_copy_ajax.php?id_obra="+id_obra+"&id_produccion="+id_produccion+"&where="+where+"&produccion="+produccion, true);
//  xhttp.send();   
//   }  
//    //alert("el nuevo valor es: "+ fecha) ;
//   
//   return ;
//   
//   
//}

</script>   
   
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

