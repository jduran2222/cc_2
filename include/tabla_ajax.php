<?php

$idtabla="tabla_".rand() ;           // genero un idtabla aleatorio que usaremos para evitar conflictos con otras tabla.php o ficha.php en la misma página


$javascript_cargar= " cargar_ajax('div_$idtabla'  , '../include/tabla.php?idtabla=$idtabla' ); "  ;  // script que pide TABLE por AJAX

$script_name= $_SERVER["SCRIPT_NAME"] ;   


// seleccionamos variables que se usan en TABLA.PHP
$vars_vars=  ["selects","script_name", "divs", "javascript_cargar", "sql_S","result_S", "tabla_sumatorias", "idtabla" ,"columna_ficha","chart_button","table_button","chart_ocultos","print_pdf","visibles"
    , "sql","sql_T","sql_T2","sql_T3","tabla_style", "tabla_footer","add_link_html","no_updates" 
, "tabla_expandida","tabla_expandible", "tabla_update" , "id_update"  ,"col_sel","array_sumas","valign","colspan","col_subtotal","print_id", 
"titulo", "msg_tabla_vacia",  "add_link",  "links", "formats","aligns", "format_style", "tooltips", "etiquetas", "wikis", "actions_row",
"updates","dblclicks" ,"id_agrupamiento", "buttons" ,"cols_string","cols_number","chart_ON","ocultos","cols_line","onclick_VAR_TABLA1_","onclick_VAR_TABLA2_","onclick_VAR_TABLA3_" ] ;

$vars_user=[];

foreach ( $vars_vars as  $variable) { if (isset(${$variable})) {  $vars_user[$variable] = ${$variable} ; }  }    // construimos el array de variables         

$_SESSION[$idtabla]=$vars_user ;
//$vars_json_enc = encrypt2(json_encode($vars_user)) ;


//debug
//sort($vars_vars);
//ksort($vars_user);
////echo pre($vars_vars);
//echo pre($vars_user);

//$longitud_var=strlen(gzcompress($javascript_cargar)) ;

//echo $_SESSION["admin_debug"]?  "<button class='btn btn-link btn-xs noprint' type='button' onclick=\" $javascript_cargar \" ><i class='fas fa-redo'></i>refresh</button>    " :""  ;  // boton de REFRESCAR POR AJAX

echo "<div id='div_$idtabla'></div>"  ;  // <div> donde meteremos por javascript el $TABLE


echo "<script>$javascript_cargar</script>"  ;      // cargamos por javascript y ajax la TABLE por primera vez
require_once("../include/tabla_js.php");           //incluimos el código javascript que maneja la tabla (PDTE de dividirlo en js general para require_once y js_chart_idtabla con reguire para cada tabla
require("../include/tabla_js_chart_ID.php");       //incluimos el código javascript que maneja la tabla (PDTE de dividirlo en js general para require_once y js_chart_idtabla con reguire para cada tabla

$TABLE='' ; // inicializamos $TABLE y lo ponemos vacia para hacerlo compatible con la versión PHP

  // INICIALIZAMOS TODAS LAS VARIABLES Y ARRAYS DE TABLA.PHP PARA EVITAR INTERFERENCIAS CON NUEVAS REQUERY EN EL MISMO PHP.
unset( $divs,$tabla_sumatorias, $tabla_style, $tabla_footer,$add_link_html, $add_link,$sql, $sql_T, $sql_T2, $sql_T3,$sql_S,$result_S, $rst, 
        $result, $result_T, $rs_T,$result_T2, $rs_T2,$result_T3, $rs_T3, $tabla_expandida,$tabla_expandible, $tabla_update, $id_update,$col_sel,$array_sumas,$valign,$colspan,$col_subtotal,$print_id, 
        $titulo, $msg_tabla_vacia,  $add_link,  $links, $formats, $format_style, $tooltips, $actions_row,
        $updates,$dblclicks ,$id_agrupamiento, $buttons ,$cols_string,$cols_number,$chart_ON,$ocultos,$cols_line,$onclick_VAR_TABLA1_,$onclick_VAR_TABLA2_,$onclick_VAR_TABLA3_) ;

//unset( $idtabla) ;/// dejo sin unset el idtabla por si me hace falta en el PHP ppal(ej. abrir el gráfico)

//foreach ( $vars_vars as  $variable) { unset( ${$variable} ) ;  }    // elimino ( UNSET ) todas las variables NO FUNCIONA

//echo pre($vars_user);



?>