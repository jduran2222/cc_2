<?php 
 require_once("../include/session.php");

 $time0=microtime(true);
 
// echo "<div id='chart_div' ></div>" ;
// echo "JUAN DURAN" ;
// 
//

// restituimos variables por si venimos por AJAX  

 if ($tabla_ajax=isset($_GET["idtabla"]))
 {
//    logs( "TABLA_AJAX: ENTRAMOS" );

//   $idtabla=$_GET["idtabla"] ;
   
//    echo "LONGITUD en ajax: " . strlen( $_GET['json_vars_enc']  );
   
//   $vars_user= json_decode(decrypt2($_GET['vars_json_enc']) , true ) ;             // desencriptamos y decodificamos el json
   $vars_user= $_SESSION[$_GET['idtabla']]  ;             // cogemos las variables de esta idTabla guardadas en SESSION
   if (is_array($vars_user) OR $_SESSION["admin_debug"])   // evitamos un error que no localizo, juand, marzo21
       {  foreach ( $vars_user as $clave => $valor) { ${$clave} = $valor ; } ; }  // restauramos las variables para continuar la tabla.php como si estuviéramos en el PHP original
   
//   echo pre(($vars_user));
   //logs( "TABLA_AJAX: ".pre($vars_user) );
//   echo "CHART_ON:". $chart_ON ;
   
   
 } 
 
logs("TABLA AJAX antes:$sql isset(result):   " . (isset($result)          )); 

//unset($result) ;
//echo (isset($result))? "SI RESULT" : "no hay result";
//echo "<br>";
//echo (isset($result->num_rows))? "SI RESULT num_rows" : "no hay result num_rows";


//$result=$Conn->query( $sql );

// inicializamos la consulta si no existen los results o venimos por AJAX sin objetos
//if (!isset($result) OR 1 ) {  $result=$Conn->query( $sql ); }
if (!isset($result->num_rows) AND isset($sql)) {  $result=$Conn->query( $sql ); }
if (!isset($result_T) AND isset($sql_T)) {  $result_T=$Conn->query( $sql_T ); }
if (!isset($result_T2) AND isset($sql_T2)) {  $result_T2=$Conn->query( $sql_T2 ); }
if (!isset($result_T3) AND isset($sql_T3)) {  $result_T3=$Conn->query( $sql_T3 ); }
if (!isset($result_S) AND isset($sql_S)) {  $result_S=$Conn->query( $sql_S ); }

 
//logs("TABLA AJAX: despues isset(result):" . (isset($result))  . $result->num_rows); 

 
 // evitamos el CSS si venimos por ajax
 if ( 0)       // pdte de quitar todo el <style> si no da problemas  (junad, feb-21)
 {    
 ?>

<style>

/*  <a> boton dentro_tabla prueba */ 
/*div.div_edit:hover {
  border: 1px solid lightblue;
    background-color: white;
    min-height: 50px;
}
div.div_edit {
  border: 1px solid lightblue;
    background-color: white;
    min-height: 50px;
}


.box_wiki{
    display: none;
    width: 100%;
}

a:hover + .box_wiki,.box_wiki:hover{
    display: block;
    position: relative;
    position: absolute;
    z-index: 100;
}*/

	
/*	
table {
    font-family: "Trebuchet MS", Arial, Helvetica, sans-serif;
    font-family: "Verdana", Arial, Helvetica, sans-serif;
    border-collapse: collapse;
     tamaño fuente tabla 
    font-size: 0.8vw;                          
    width: 100%;
}*/

table td {
 
    /*text-align: center;*/
     border-bottom: 1px solid #ddd;
    padding: 3px;
    /*white-space: nowrap;*/
    /*height: 20px;*/
}

td.nowrap{
  white-space: nowrap;

}


 table  tr:hover {background-color: #ddd;}



table th {
        /*text-align: center;*/
     border: 1px solid #ddd;
    padding: 3px;
    /*height: 20px;*/

    /*cursor: pointer;*/
    padding-top: 6px;
    padding-bottom: 6px;
    text-align: center; 
    /*color del fondo de TH*/
    background-color: #F2F4F4;      
    /*color: white;*/
    font-weight: bold;
      /*white-space: nowrap;*/
  
    
 }
 
.float_left {
    /*border: 1px solid blue;*/
    float: left;
    /*cursor: pointer;*/
}

.textarea_tabla {
    /*height: 4em;*/
    width: auto;
    border-width: 0px ;

}

 
@media only screen and (max-width:980px) {
  /* For mobile phones: antes 500px */
   table {
    font-size: 4vw; 
  }
   div {
     overflow: scroll;
  }
  option {
   font-size: 4.2vw;   
  /*transform: scale(2);*/  
}
  
}

@media print{
    font-size: 4.2vw; 
    a[href]:after {
      display: none;
      visibility: hidden;
   }
   
    a:link
    {
    color: black ;
    text-decoration:none;
    }

   
    
    textarea { border: none; }
    
   .noprint{
       display:none;
   }
   .topnav{
       display:none;
   }
   
   .sidenav{
       display:none;
   }
   
/*   .glyphicon {
       display:none;
   }*/
/*   .dentro_tabla_ppal {
       display:none;
   }
   .dentro_tabla {
       display:none;
   }*/
   
   thead {
            display:table-header-group;
            margin-bottom:2px;
             /*padding-top: 500px ;*/
            
/*            top:8cm;*/
        }
   table td {
            border : none ;
            /*font-size: 8pt ;*/
            /*font-family:arial;*/
        }

} 

 
  @page
    {margin-top:3cm;
     margin-left:1.5cm;
     margin-right:1.5cm;
     margin-bottom:3cm;
     
    }
    
       @media print {
            div.divHeader {
                
                position: fixed;
                top: 0cm;
                /*padding-top: 500px ;*/
                padding-bottom: 500px ;
/*                height: 320px;
                display:block;*/
              
                
            }
            
            div.divFooter {
                position: fixed;
                bottom: 0cm;
                
                
            }
            
        }
        
           @media screen {
            div.divHeader {
                display: none;
            }
            
           div.divFooter {
                display: none;
            }
         }
   
         
  th.hide_id_<?php echo $idtabla;?> { display: none; } // intento de controlar la tabla para independizar los show_ID
  td.hide_id_<?php echo $idtabla;?> { display: none; }
  
  th.hide_id { display: none; }
  td.hide_id { display: none; }
  
         
    
</style>


<?php 

 }  // fin del if  $tabla_ajax

/* tabla.php  muestra una tabla
       
		require a incluir en .PHP 
		<?php require("../include/tabla.php"); echo $TABLE ;?>
		
		 Variables a definir previamente al require:
		
        $result=$Conn->query("SELECT id_aval , Motivo, Importe from Avales WHERE ID_OBRA=".$id_obra );
        $titulo="AVALES";
        $msg_tabla_vacia="No hay avales";
        $add_link[field_parent,id_parent]    -> pone un boton link para añadir una fila
        $links
        $formats (moneda, fijo, porcentaje, fecha, dbfecha, boolean...)
 *      $align
        $tooltips
        $actions_row  -> acciones a nivel row (edit, delete ,onclick1_link...)   
 *      $updates    -> array de campos que se pueden actualizar online (ajax)
 *      $no_updates    -> array de campos que NO se pueden actualizar online (ajax)
 *      $actions_row["onclick1_link"]   permite añadir un boton al final con acción de onclick, usa tambien $rs["$id_update_onclick1"]
 *      $dblclicks["CAPITULO"] = ["CAPITULO", 'literal']   columnas que copian el valor al filtro
        $id_agrupamiento En tablas con SUBGRUPOS agrupamiento, variable que indica qué campo agrupará  Ej. ID_CLIENTE.  (VER tbla_group.php)
 *      $print_id indica que se imprima los campos ID_ tambien
*/

require_once("../include/funciones.php");
require_once("../include/funciones_js.php");

// DEBUG VARIABLES arrays
//logs("Inicio tabla.php  sql: $sql") ;
//isset($sql_T) ? logs("Inicio tabla.php  sql_T: $sql_T") : '' ;

$debug=$_SESSION["admin"];
//$debug=1;


// FIN DEBUG


// INICIALIZACION DE VARIABLES 
$idtabla= isset($idtabla)? $idtabla :  "tabla_".rand() ;           // genero un idtabla aleatorio que usaremos para evitar conflictos con otras tabla.php o ficha.php
$TABLE=''; 
//$TABLE="$sql<br>"; 

// variable para el sistema de ETIQUETAS
$script_name= isset($script_name)? $script_name : $_SERVER["SCRIPT_NAME"] ;   



$updates= isset($updates)? $updates :  [] ;    // si no existe $updates lo inicializo vacío para poder hacer llamadas sin que dé error
$no_updates= isset($no_updates)? $no_updates :  [] ;    // inicializamos $no_update[]
$visibles= isset($visibles) ? $visibles : [] ;  // $visibles es array con campos ID_ que queremos mostrar
$ocultos= isset($ocultos) ? $ocultos : [] ;  // $ocultos es array con campos ID_ que NO queremos mostrar
//$cols_chart= isset($cols_chart) ? $cols_chart : [] ;  // $ocultos es array con campos ID_ que NO queremos mostrar

$titulo= isset($titulo) ? $titulo : ( !isset($print_pdf)?  'tabla' : '' ) ;
$titulo= str_replace("_NUM_",$result->num_rows , $titulo) ;                  // añadimos el número de filas al título si marcamos titulo_num=true

$tabla_expandible= isset($tabla_expandible) ? $tabla_expandible : ( !isset($print_pdf)?  1 : 0 ) ;    // por defecto lo hacemos EXPANDIBLE

// ANULAMOS PROVISIONALEMNTE LA EXPANDIBILIDAD HASTA ENCAJAR ADMIN LTE JUNIO2020
//$tabla_expandible= 0 ;    // por defecto lo hacemos NO EXPANDIBLE

$tabla_style=isset($tabla_style) ? $tabla_style : '' ;     // style de la TABLE
$tabla_expandida=isset($tabla_expandida) ? $tabla_expandida : 1 ;     // por defecto la mostramos EXPANDIDA

$tabla_collapse= isset($tabla_expandida) ? ($tabla_expandida ?  '' : 'collapsed-card') : 'collapsed-card'  ;   // por defecto NO EXPANDIDA


$tabla_footer=isset($tabla_footer) ? $tabla_footer : '' ;     // por defecto vacia

// chart_ocultos
$chart_ocultos=isset($chart_ocultos) ? $chart_ocultos : [] ;     // por defecto vacia

$table_button=isset($table_button) ? $table_button : True ;     // botones de graficos. Por defecto SI
$chart_button=isset($chart_button) ? $chart_button : True ;     // botones de graficos. Por defecto SI

$columna_ficha=isset($columna_ficha) ? $columna_ficha : False ;     // ANULADO POR DEFECTO HASTA QUE FUNCIONE BIEN LOS HIDE SIN INTERFERIR CON OTRAS TABLAS Y FICHAS.PHP (juand,dic20) botones de graficos. Por defecto SI

//CODIGO PARA EL añadir fila $add_link

// si no está definido previamente add_link_html, lo definimos.
if(!isset($add_link_html))
{ 
  // construimos add_link_html si existe el array $add_link    
  if(isset($add_link)){
   $sql_insert="INSERT INTO $tabla_update ( {$add_link['field_parent']} ) VALUES ( {$add_link['id_parent']} )"    ;   
   $href='../include/sql.php?sql=' . encrypt2($sql_insert)  ;  
  
   $add_link_html = "<p><a class='btn btn-xs btn-link noprint' href='#' onclick=\"js_href('$href','1'  )\"  >"
            . "<i class='fas fa-plus-circle'></i> añadir fila</a></p> " ;
  }else{
   $add_link_html="";   
  }
}
// fin definicion add_link_html


$cont=0;

// DEBUG
if (0)        // DEBUG
{   
echo "<pre>" ;       
// print_r($tabla_subgrupo);  
echo "\$add_link".var_dump($add_link)."<br>";
echo "\$links".var_dump($links)."<br>";
echo "\$formats".var_dump($formats)."<br>";
echo "\$aligns".var_dump($aligns)."<br>";
echo "\$tooltips".var_dump($tooltips)."<br>";
echo "\$actions_row".var_dump($actions_row)."<br>";
echo "\$updates".var_dump($updates)."<br>";
echo "\$no_updates".var_dump($no_updates)."<br>";
echo "\$visibles".var_dump($visibles)."<br>";
echo "\$ocultos".var_dump($ocultos)."<br>";
echo "\$dblclicks".var_dump($dblclicks)."<br>";
echo "\$id_agrupamiento".var_dump($id_agrupamiento)."<br>";
//echo "\$cols_string".var_dump($cols_string)."<br>";
//echo "\$cols_number".var_dump($cols_number)."<br>";
echo "</pre>" ;       
}
// FIN DEBUG



  $id_subgrupo=0 ;                                          

//  $tabla_ajax? logs( "TABLA_AJAX RESULT: ".$result->num_rows ) : "";  
//  echo $tabla_ajax? "AJAX RESULT".$result->num_rows : "taba normal" ;
 if ($result->num_rows > 0)
  { 

  //  ******************************************* BOTONES SOBRE TABLA   ****************

  if (!isset($print_pdf) AND $table_button)   // en las páginas para imprimir a PDF quitamos los botones
  {  
    $sql_encrypt= encrypt2($sql) ;
    $titulo_w_tags=substr(strip_tags($titulo),0,30).'_' ;
  if ($tabla_expandible)  
  { $TABLE .= "<button data-toggle='collapse' class='btn btn-link btn-xs noprint transparente' data-target='#expand_$idtabla'>...</button>" ;
    $TABLE .= "<div id='expand_$idtabla' class='collapse'>";  
  }
  else
  {
    $TABLE .= "<div>";  
  }    
    $TABLE .= "<a type='button' class='btn btn-link btn-xs noprint transparente'  href='../include/export_xls.php?sql=$sql_encrypt&titulo=$titulo_w_tags'  >Exportar xls</a>";  
    $TABLE .= "<button type='button' title='Copia la tabla al portapapeles para pegar en XLS, DOC...' "
                    . "class='btn btn-link btn-xs noprint transparente'  onclick=selectElementContents(document.getElementById('$idtabla'))  >copy</button>";
   
   $TABLE .= "<button type='button' class='btn btn-link btn-xs noprint transparente' onclick=tabla_down_font_size(document.getElementById('$idtabla'))><i class='fas fa-search-minus'></i></button>" ;
   $TABLE .= "<button type='button' class='btn btn-link btn-xs noprint transparente' onclick=tabla_up_font_size(document.getElementById('$idtabla'))  ><i class='fas fa-search-plus'></i></button>" ;
     
   //  BOTON SELECTION
   if (isset($col_sel)) {$TABLE .= "<button type='button' class='btn btn-link btn-xs noprint transparente' onclick=ver_table_selection()  >seleccion</button>" ;  }  

//   if ($_SESSION["admin"]) {$TABLE .= "<button type='button' class='btn btn-link btn-xs noprint transparente' onclick=show_ID_$idtabla()  >show ID adm</button>" ;  } #show_ID
   if ($_SESSION["admin"]) {$TABLE .= "<button type='button' class='btn btn-link btn-xs noprint transparente' onclick=show_ID()  >show ID adm</button>" ;  }  
//   $TABLE .= "<button type='button' class='btn btn-link btn-lg noprint transparente'  title='ver Gráficos' onclick=google.charts.setOnLoadCallback(drawChart);  >"
//                   . "<i class='fas fa-chart-bar'></i></button>" ;  
   
   // BOTONES DEFINIDOS POR USUARIO
   if (isset($buttons)) 
   {   foreach ($buttons as $value)
       {
          $TABLE .= $value ; 
       }
   }
   $TABLE .= "</div>" ; 	  
  }
   else{   // estamos en PRINT_PDF
       
   }  
  
  ///////*************************** FIN BOTONES SOBRE TABLA *******************
  
  /////////  *********** INICIAMOS <DIV> y <TABLE> **************************  
//    $TABLE .= "<div id='chart_HIDE$idtabla' ><button onclick='(\"#chart_div$idtabla\").hide();alert();'>HIDE</button></div>" ;
   // boton para ocultar gráfico
    // div que contiene el gráfico
   
   if($chart_button)
   {    
    $TABLE .= "<button type='button' id='chart_button$idtabla' class='btn btn-link btn-lg noprint transparente'  title='ver Gráficos (en PRUEBAS)' "
            . " onclick=\"$('#chart_div$idtabla').toggle('fast');"
                       . "$('#chart_HIDE$idtabla').toggle('fast');"
            .            " google.charts.setOnLoadCallback(drawChart$idtabla); \" >"
                   . "<i class='fas fa-chart-bar'></i></button>" ;  

    $TABLE .= "<div id='chart_HIDE$idtabla' style='display:none;' >" 
            . "<input type='text' class='noprint transparente' id='view_setColumns$idtabla' onkeyup = 'if(event.keyCode == 13) boton_chart$idtabla()' size='5' placeholder='0,1,2...' title='indicar columnas a mostrar del gráfico Ej:  0,1,3 '   >"
                   . "" ;  
    $TABLE .= "<button type='button' class='btn btn-link btn-xs noprint transparente'  title='Actualiza el gráfico' onclick='boton_chart$idtabla()'   >"
                   . "actualizar</button>" ;  
     // anulamos botosn cerrar ya que se cierra con el boton ppal
//    $TABLE .= "<button type='button' class='btn btn-link btn-xs noprint transparente' title='cerrar gráfico' "
////            . "onclick=\"document.getElementById('chart_div$idtabla').style.display = 'none'; "
//            . "onclick=\"$('#chart_div$idtabla').hide(300); "
//                      . "$('#chart_HIDE$idtabla').hide();\">cerrar</button>";   
     $TABLE .=  "</div>" ;
     
    $TABLE .= "<div id='chart_div$idtabla' style='display:none;'></div>" ;  // div para el gráfico
   } 
    
   if ($columna_ficha) {$TABLE .= "<div style=float:right;'><button type='button' class='btn btn-link btn-xs noprint transparente'  onclick=show_FICHA()  >show FICHA</button></div>" ;  }  
    
   // INICIAMOS LA TABLE
   $TABLE .= "<div><table  id=\"$idtabla\" $tabla_style >";   
    
   if (isset($chart_ON) AND $chart_ON )
   { echo "<script> $(document).ready(function(){ $('#chart_button$idtabla').click();})</script>" ; }
//   { echo "<script> $(document).ready(function(){  google.charts.setOnLoadCallback(drawChart$idtabla);})</script>" ; }

   
   $is_subtotal=isset($col_subtotal) ;
   
   $cont_TD= mt_rand (1,2000000)  ;  // creamos un contador de TD para cada celda. Lo inicializamos con random
   $cont_TR= mt_rand (1,2000000)  ;  // creamos un contador de TD para cada celda. Lo inicializamos con random
   
   
   // GOOGLE CHARTS, inicializo variables de trabajo
   $json_rows_chart=" rows : [ " ;
   $comma_rows="";
   
   
   

   // EMPEZAMOS A RECORRER LA TABLA DE DATOS
   while($rst = $result->fetch_array(MYSQLI_ASSOC))               // 
   {
      $cont_TD++;      
      $cont_TR++;      
      
//      echo "HEMOS ENTRADO";
//      echo pre($rst);
      
      
      if ($cont==0)   // --------------- #ENCABEZADOS ( solo lo ejecutamos una vez  )------------------
      {
                   $cont= mt_rand (1,1000000)  ;       // inicializamos el contador con rand() para evitar que se solapen los TD y otros elementos

                   if ($is_subtotal) { $subtotal=$rst[$col_subtotal]   ;}

                   $TABLE .= "<thead><tr>";  // iniciamos el cabecero principal
                   $c=0 ;
                   $c_sel=0;

                   // si hay SELECTION ponemos el la primera columna de los ENCABEZADOS la seleccion de TODO
                   if (isset($col_sel)  ) {$TABLE .=  "<th class='noprint'><input onclick=\"selection_todoF('$idtabla');\" type=\"checkbox\" id=\"selection_todo\""
                                                         . " value=\"0\"></td>" ;  $c++ ;$c_sel=1; }       // Si hay columna de Selección añadimos una columna vacía a los TOTALES
                   $style_th_color="";


                   // GOOGLE CHARTS
                   // inicializacion
                   // si no hay definidas columnas, las cogemos todas sabiendo que solo la primera será STRING y las otras NUMBER.
                   // además solo se dibujaran las columnas IS_VISIBLES
                   // si COLS_STRING no está definida se define con la primera col VISIBLE
                   // definimos por defecto COLS_NUMBER con todas las columnas

                   // Si existe, intersectamos el $cols_string con las columnas existentes, por defecto, el array vacio
                   $claves=array_keys($rst); // array de nombres de columnas (claves)

                   $cols_string=isset($cols_string) ? array_intersect($cols_string,$claves) : [] ;  // confirmamos que esté en las claves existentes
                   $cols_number_auto = !(isset($cols_number)) ;     // POR DEFECTO buscaremos las columnas a pintar
                   $cols_number= !($cols_number_auto )? $cols_number : array_diff($claves,$chart_ocultos) ;     // por defecto todas las columnas no chart_ocultas

                   $cols_line=isset($cols_line) ? $cols_line : [] ;  // columnas a pintar como línea en vez de barras



                   $json_cols_chart=" cols : [ " ;
                   $comma_cols='' ;


            //       $cols_count=1;
                   foreach ($rst as $clave => $valor) // pintamos los ENCABEZADOS 
                   {



                           // preparando las string para el GOOGLE CHARTS  (ANULADO PROVISIONAL)
            //              $json_cols_chart.= (isset($cols_chart[$clave]))? " $comma_cols { id: '$clave' , label : '{$cols_chart[$clave][0]}' , type : '{$cols_chart[$clave][1]}' } " : "" ;
            //              $comma_cols=',' ;

                           $tipo_formato_por_clave=cc_formato_auto($clave) ;
                           $cont_TD++;      // a cada posible iteracion incrementamos el contador para garanizar en cualquier intante un id diferente

//            //               $is_visible si empieza por ID_ o es igual a ID
//                           $is_visible = ( (!preg_match("/^ID_|^ID$/i", $clave) OR in_array($clave,$visibles) ) AND ( !in_array($clave,$ocultos) ))  ; 
//
//                           $not_id_var= isset($print_id)?  $print_id : $is_visible  ;         // $print_id indica que se imprima los campos ID_ tambien
//                           $class_hide_ids[$clave]= $not_id_var ? "" : "class='hide_id'" ;
//                           $hide_id= $not_id_var ? "" : "hide_id" ;

                           // inicializamos variables


                           // confirmamos que no es una _ETIQUETA auxiliar de la sentencia SQL
                           if ( !is_FLAG($clave)  )      // descartamos los encabezados de campos FORMATO CONDICIONAL _FORMAT
                           { 

                               //  ASIGNACION DE ETIQUETAS: POR CÓDIGO (sistema antiguo) por CLAVE_DB o por defecto.  Accedemos a Tabla de Mysql Claves
                               // solicitamos datos de CLAVES_DB
                               $claves_db = DRow("Claves", "clave='$clave' ", "(script_name='$script_name') DESC"  ) ;
                               $exist_clave_db = !(empty($claves_db)) ;                                              // si devuelve el array vacio, NO HAY CLAVE
                               $clave_db_heredada= isset($claves_db["script_name"])?  ($claves_db["script_name"]!=$script_name) : 0 ; // si no coinciden los PHP es clave HEREDADA

                               // Si hay clave_db NO ES HEREDADA y hay formato_db, lo ponemos en su array de formatos $formats[]
                               // SI QUEREMOS HEREDAR EL FORMATO HAY QUE HACERLO MANUALMENTE
                               if($exist_clave_db AND !$clave_db_heredada AND $claves_db["formato"]){ $formats[$clave]=$claves_db["formato"] ; }
//                               if($exist_clave_db  AND $claves_db["formato"]){ $formats[$clave]=$claves_db["formato"] ; }  // cambio criterio, tambien asigno claves heredadas (juand, feb21)
                               //si no se asigna formato por clave_db y tampoco trae lo estimamos
                               $format[$clave]= isset($format[$clave])? $format[$clave] : cc_formato_auto($clave) ;

                               //compatibilidad con nuevo fotmato $etiquetas[clave]= [ etiqueta , tooltip ] ;
                               if (isset($etiquetas[$clave]) AND is_array($etiquetas[$clave]))
                               {
                                      $tooltips[$clave]=$etiquetas[$clave][1];         // el TOOLTIP viene como segundo parámetro de $etiquetas[]
                                      $wikis[$clave]=isset($etiquetas[$clave][2])? ($etiquetas[$clave][2]) : "" ;
                                      $etiquetas[$clave]=$etiquetas[$clave][0];
                               }
                               // si ya existe CLAVE_DB las usamos ante las etiquetas por código
                               if(  $exist_clave_db AND !$clave_db_heredada )  // es clave PROPIA (asignamos prioritariamente las CLAVES_DB)
                               {
                                      $etiquetas[$clave]=$claves_db["etiqueta"];
                                      $tooltips[$clave]=$claves_db["tooltip"];       
                                      $wikis[$clave]=$claves_db["wiki"] ;
                               }elseif($exist_clave_db AND $clave_db_heredada)  // es clave_db HEREDADA, solo rellenamos las etiquetas vacías
                               {
                                      $etiquetas[$clave]= isset( $etiquetas[$clave]) ?  $etiquetas[$clave] :  $claves_db["etiqueta"];
                                      $tooltips[$clave]= isset( $tooltips[$clave]) ?  $tooltips[$clave] :   $claves_db["tooltip"];       
                                      $wikis[$clave]=  isset( $wikis[$clave]) ?  $wikis[$clave] :    $claves_db["wiki"] ;
                               }    
                                // a falta de $etiqueta por código o CLAVE_DB improvisamos una
                                //  inicializamos la $etiqueta_txt con su etiqueta o en su defecto el nombre del campo sin el 'ID_' y sin '_'
            //                   $etiqueta_txt= isset($etiquetas[$clave]) ? $etiquetas[$clave] : str_replace('_',' ',( (strtoupper(substr($clave,0,3))=="ID_")? substr($clave,3)  :   $clave     ))  ; 

                               if (!isset($etiquetas["$clave"])) { $etiquetas["$clave"] = cc_etiqueta($clave)  ;}  // si todavia no hay definida $etiqueta_txt, la calculamos por defecto y lo metemos en el array
                               $etiqueta_txt= $etiquetas["$clave"] ; 
                               // fabricamos el <div> para el TOOLTIP
                               $tooltip_txt = isset($tooltips[$clave])? $tooltips[$clave]  : ""  ;    
            //                   $tooltip_txt= str_replace("<br>","\n", $tooltip_txt) ;
                               $tooltip_txt= preg_replace("/\s*<br>\s*/","\n", $tooltip_txt) ;  // quitamos los espacios alrededor de <br> y lo sustituimos por \n
                               $tooltip_txt_alert= str_replace("\n","\\n", $tooltip_txt) ;
                               $div_tooltip_html = ($tooltip_txt) ? "<span class='btn btn-link btn-xs noprint transparente' style='cursor:pointer;border:none;margin:5px 5px;' onclick=\"alert('$tooltip_txt_alert')\" >"
                                                    . " <i class='fas fa-info '  title='$tooltip_txt'></i></span>"  : "" ; 

                               $tooltipWiki_txt = isset($wikis[$clave])? $wikis[$clave]  : ""  ;       
                               $div_tooltip_html .= ($tooltipWiki_txt) ? ""
                                       . "<a class='btn btn-xs btn-link noprint transparente'   href='https://wiki.construcloud.es/index.php?title=$tooltipWiki_txt' title='ver ConstruWIKI' target='_blank'>"
                                       . "<i class='fab fa-wikipedia-w'></i></a>"
                                       . "<span class='box_wiki'><iframe src='https://wiki.construcloud.es/index.php?title=$tooltipWiki_txt' width = '500px' height = '300px'></iframe></span>"  : "" ; 


                                // SPAN HTML PARA GESTIÓN DE ETIQUETAS CON CLAVE_DB. Solo para ADMIN_CHAT 
                                 $clave_db_editar_html="";
                                 $clave_db_nuevo_html="";
                                if ($_SESSION["admin_chat"])
                                {
                                    $formato_codigo= (isset($formats[$clave])) ? $formats[$clave] : " " ;  // calculo el formato a mandar para la ficha nueva de Clave_db 
                                    $clave_db_nuevo_html=  "<a class='btn btn-xs btn-link noprint transparente'  target='_blank'  title='nueva clave'"
                                           . " href=\"../configuracion/clave_ficha.php?clave=$clave&script_name=$script_name&etiqueta=$etiqueta_txt&tooltip=$tooltip_txt&formato=$formato_codigo\" >"
                                                . "<i class='fas fa-plus-circle'></i></a>"   ; 

                                    if(isset($claves_db["clave"]))
                                    {

                                        $clave_resumen= "\n Clave: {$claves_db["clave"]}\n Etiqueta: {$claves_db["etiqueta"]}\n Tooltip: {$claves_db["tooltip"]}\n Wiki: {$claves_db["wiki"]}" ;
                                        $clave_propia_txt= $clave_db_heredada?  "editar clave  HEREDADA $clave_resumen" : "editar clave PROPIA $clave_resumen" ;
                                        $clave_propia_LINK= $clave_db_heredada? "Eh" : "E";
                                        $clave_db_editar_html= "<a class='btn btn-xs btn-link noprint transparente' target='_blank' title='$clave_propia_txt'"
                                                           . " href=\"../configuracion/clave_ficha.php?id_clave={$claves_db["id_clave"]}\" >"
                                                                . "$clave_propia_LINK</a>"   ; 


                                        if ($script_name==$claves_db["script_name"]) // clave propia
                                        {
                                           // clave propia EDITAR
                                            $clave_db_nuevo_html=""; 
                                        }  
                                    }
                                }  

                               $div_tooltip_html.= " $clave_db_editar_html $clave_db_nuevo_html " ;

                               ////////////////   FIN ASIGNACION DE ETIQUETAS


                              // GOOGLE CHARTS  en pruebas 
                              // VARIABLES google chart
                              // definimos por defecto a COLS_STRING con la primera columnas VISIBLE y no oculta_chart

                              // quitamos los booleanos , fechas y no visibles de columnas number si es $cols_number_automatico (datos)
//                              $is_boolean= isset($formats[$clave])? (($formats[$clave]=='boolean') OR (substr($formats[$clave],0,8)=='semaforo'))  : 0 ;
//                              $is_fecha =  isset($formats[$clave])? (substr($formats[$clave],0,5)=='fecha') : ($tipo_formato_por_clave=='fecha') ;
                              
                            // INDICADORES TIPO DE CAMPO determinamos si es boolean
                            //               $is_visible si empieza por ID_ o es igual a ID
//                               $is_visibles[$clave] = ( (!preg_match("/^ID_|^ID$/i", $clave) OR in_array($clave,$visibles) ) AND ( !in_array($clave,$ocultos) ))  ; 
                               $is_visibles[$clave] = ( (!preg_match("/^ID_|^ID$/i", $clave) OR in_array($clave,$visibles) OR in_array($clave,$updates) ) AND ( !in_array($clave,$ocultos) ))  ; 

                               $not_id_var= isset($print_id)?  $print_id : $is_visibles[$clave]  ;         // $print_id indica que se imprima los campos ID_ tambien
                               $class_hide_ids[$clave]= $not_id_var ? "" : "class='hide_id'" ;
//                               $hide_id= $not_id_var ? "" : "hide_id" ;

                               $is_booleans[$clave]= isset($formats[$clave])? (($formats[$clave]=='boolean') OR (substr($formats[$clave],0,8)=='semaforo'))  : 0 ;
                               $is_text_edits[$clave] = isset($formats[$clave])?  ( $formats[$clave]=='text_edit' ) : 0 ;  //campo textarea editable directamente       
                               $is_div_edits[$clave]  = isset($formats[$clave])?  ( $formats[$clave]=='div_edit' ) : 0 ;  //campo textarea editable directamente       
                               $is_text_monedas[$clave] =  isset($formats[$clave]) ? (($formats[$clave])=='text_moneda') : 0 ;  //campo textarea editable directamente
                               $is_fechas[$clave] =  isset($formats[$clave])? (substr($formats[$clave],0,5)=='fecha') : ($tipo_formato_por_clave=='fecha') ;
                               $is_updates[$clave] =  ( in_array($clave, $updates)  OR in_array("*", $updates) ) AND !(in_array($clave, $no_updates) )   ;  
                               $is_selects[$clave]= (isset($selects[$clave])) ; 

//                              
//                               $format_style = (isset($aligns[$clave])) ?   " style='text-align:{$aligns[$clave]} ; ' "    :  " style='text-align:left;' "  ;      // $aligns[] si se ha especificado una ALIGN la determino
//                               $formats[$clave]= (isset($formats[$clave])) ? $formats[$clave] :  cc_formato_auto($clave) ;  // el formato es el definido o por defecto según su clave
////                               $format_style=cc_format_style(  $formats[$clave] ) ;    // actualizamos por REFERENCIA la variable $format_style
//                               
////                               $tipo_dato= preg_match('/moneda|porcentaje|fijo|text_moneda/i', $formats[$clave]) ? 'num' :
////                                             (preg_match('/semaforo|semaforo_not|boolean/i', $formats[$clave]) ? 'boolean' : '') ;
//
//                               //inicializo la align del TD
//                               $format_aligns[$clave] = cc_format_align($format_style) ;   // esto se usa para los botones dentro del <TD>
//                               $format_style = (isset($styles[$clave])) ? str_replace("style='", "style='".$styles[$clave], $format_style)    :  $format_style  ;      // añadimos los styles particulares
//
//                               
                               
                               
                                
                               
                               
                               
                              // pintamos el encabezado 
                              $TABLE .= "<th $class_hide_ids[$clave] $style_th_color   >"
                                      . "<span style='cursor:pointer;' onclick=\"sortTable($c,'$idtabla',$c_sel)\" title='$tooltip_txt' >{$etiqueta_txt}</span>$div_tooltip_html</th>";                  
                              $c++ ;
                              
                              
                              
                              
                              if ($cols_number_auto AND (  !$is_visibles[$clave] OR  $is_booleans[$clave] OR $is_fechas[$clave] ) )
                                     {
                                       $cols_number=array_diff($cols_number, [$clave]);  // sacamos esta columna de las cols automaticas de numeros
                                     }



                              // Charts.  calculamos quien puede ser la posible cols_string (LEYENDA del gráfico)
                              if (empty($cols_string) AND $is_visibles[$clave] AND !$is_booleans[$clave] AND !in_array($clave,$chart_ocultos)) { $cols_string=[$clave] ; }


                              if (in_array($clave,$cols_string)  )
                                  {
                                      $json_cols_chart.= "   { id: '$clave' , label : '$clave' , type : 'string' } "  ;
                                      $cols_string=[$clave] ;  // determinamos esta única columna como string (leyenda) para la posterior lectura de valores
                                  }
                              elseif (in_array($clave,$cols_number) )  // al ir detras de cols_string nos aseguramos de que no entra la leyenda como dato number
                                  {   $json_cols_chart.= " , { id: '$clave' , label : '$clave' , type : 'number' }  "  ;  }


                           }elseif (strpos($clave, 'TH_COLOR'))
                           {
                             $style_th_color= $style_th_color ? "" : "style='background-color:#D5D8DC;'"  ;
                           }       

                   }
                  // **********************   FIN pintar ENCABEZADOS *************                              

                   // CHART . calculamos las columnas que serán línes en vez de barras en el gráfico
                   $serie_line_txt="";
                   foreach ($cols_line as $col_line)
                     {
                       if (in_array($col_line,$cols_number))  // si la columna está entre las columnas determinamos su posición
                       { 
                           $col_line_pos=array_search($col_line,$cols_number) ;
                           $serie_line_txt.= " , series: { $col_line_pos : {type: 'line'}} " ;

                       }
                     }

                   $json_cols_chart.=" ] " ; // finalizo la json_cols del google charts

                   if (isset($actions_row)) { $TABLE .= "<th></th>"; }	// añado columna para los links de las acciones de fila  
                   if ($columna_ficha) { $TABLE .= "<th class='columna_ficha'>FICHA</th>"; }	// añado columna_ficha

                   $TABLE .= "</tr></thead><tbody>";	
                   if ($is_subtotal) $TABLE .= "<tr><td colspan='$colspan'><b><big>$subtotal</big></b></td></tr>";
      }  
      // **********************   FIN  ENCABEZADOS *************                              

      $cont++ ;
      
     // FIN de  CHART . calculamos las columnas que serán línes en vez de barras en el gráfico
     
      
      


      // GESTION DE SUBTOTALES. cuando tenemos agrupamiento y subtotales
      if ($is_subtotal)            
      { if ($subtotal<>$rst[$col_subtotal])
            { 
                // IMPRIMIMOS FILA DE SUBTOTALES 
              $TABLE .= "<tr>" ;
              if (isset($col_sel)  ) {$TABLE .=  "<td class='noprint'></td>" ;  }                  //si hay col_sel añadimos su hueco

              $TABLE .= "<td colspan='$colspan' align='right' ><i><b>Subtotal</b></i></td>";
              foreach ($array_sumas as $clave => $valor)
                  { $TABLE .= "<td align='right' nowrap><i><b>".cc_format($array_sumas[$clave], $formats[$clave])."</b></i></td>"  ; }
              $TABLE .= "</td></tr>";

              $subtotal=$rst[$col_subtotal] ;
              $TABLE .= "<tr><td colspan='$colspan'><b><big>$subtotal</big></b></td></tr>";
              foreach ($array_sumas as $clave => $valor) { $array_sumas[$clave] = 0 ; }       // inicializo los SUBTOTALES suma

            }
      }    ////////***************** FIN IMPRESION FILA SUBTOTALES

      //************************** INICIAMOS FILA DE #VALORES ************************
      $TABLE .= "<tr  id='TR_$cont_TR'>";
      
      // Columna de CHECKBOX DE SELECTION *****
      if (isset($col_sel)  ) {$TABLE .=  "<td class='noprint'><input type='checkbox' id=\"{$rst[$col_sel]}\" value=\"{$rst[$col_sel]}\"></td>" ;  }       // Si hay columna de Selección añadimos una columna vacía a los TOTALES

      
      // inicializamos el array de tooltip de cada valor $vtooltips[]
      $vtooltips=[];
      $mtooltips=[];
 
       // GOOGLE CHARTS
       $json_rows_chart.=" $comma_rows { c : [ " ;
       $comma_rows_sec='' ;
//       $cols_count=1 ;
      
      // RECORREMOS LOS VALORES DE NUESTRA FILA
      $columna_ficha_html='';   // inicializamos la celda de la columna_ficha 
      foreach ($rst as $clave => $valor)  //  ******** #VALORES ***************** VALORES ******************
           {
              $TD_td =  "<td  >" ;  // ponemos por defecto el <td>, luego podemos cambiarlo

              $tipo_formato_por_clave=cc_formato_auto($clave);

              //deshacemos el guardado en HEX  por compatibilidad con el uso de HEX ya obsoleto desde 2019 donde se guardaban los texto en hexadecial para evitar problemas especial chars
               if(preg_match("/__HEX__/", $valor) ){ $valor = hex2bin ( preg_replace("/__HEX__/", "", $valor)) ; }


               $cont_TD++;  //contador de TD para su identificacion en javascript 

//              // TIPO DE CAMPO determinamos si es boolean
//               $is_boolean= isset($formats[$clave])? (($formats[$clave]=='boolean') OR (substr($formats[$clave],0,8)=='semaforo'))  : 0 ;
//               $is_text_edit = isset($formats[$clave])?  ( $formats[$clave]=='text_edit' ) : 0 ;  //campo textarea editable directamente       
//               $is_div_edit  = isset($formats[$clave])?  ( $formats[$clave]=='div_edit' ) : 0 ;  //campo textarea editable directamente       
//
//               $is_text_moneda =  isset($formats[$clave]) ? (($formats[$clave])=='text_moneda') : 0 ;  //campo textarea editable directamente
//
//    //           $is_fecha = ((strtoupper(substr($clave,0,2))=="F_") OR (strtoupper(substr($clave,0,5))=="FECHA") OR ( isset($formats[$clave])? (substr($formats[$clave],0,5)=='fecha') : 0)) ;
//
//               // es fecha si el formato es fecha o si los nombres
//    //           $is_fecha =  isset($formats[$clave])? (substr($formats[$clave],0,5)=='fecha') : ($tipo_formato_por_clave=='fecha') ;
//               $is_fecha =  isset($formats[$clave])? (substr($formats[$clave],0,5)=='fecha') : ($tipo_formato_por_clave=='fecha') ;
//
//               $is_update =  ( in_array($clave, $updates)  OR in_array("*", $updates) ) AND !(in_array($clave, $no_updates) )   ;  
//               $is_select= (isset($selects[$clave])) ; 

               if ($is_doc_logo = ( $clave=='doc_logo'  )) 
               {
                   //logs("entramos a doc_logo");
                   if ($valor) // si hay campo DOC_LOGO y su valor no es cero, calculamos el path_archivo del id_documento
                   {             
                       $valor=Dfirst("path_archivo","Documentos"," id_documento=$valor ")  ;   //sustituimos el $valor por el path del archivo de id_documento = doc_logo
    //                   $valor= ($valor==0) ? "" : $valor ; // para que no aparezca el CERO 

                   }else
                   {
                       $valor= "../img/no_image.jpg"  ; // para que no aparezca el CERO 
                   }
    //               $formats[$clave]= "pdf_100_100" ; 
                   //logs("entramos a doc_logo valor1: $valor");
               }    


               // inicializamos codigo para doble click copiar a filtro'
               $dblclick_div=  '' ;
               $dblclick_ondblclick=  '' ;  //dblclick_ondblclick

               // subtotales cuando hay agrupación
               if (isset($array_sumas[$clave])) { $array_sumas[$clave]+= $valor ; }  // sumo los SUBTOTALES 

               // Gestión de CAMPOS ID_, ocultamos por defecto los campos ID_xxx y los ocultos y mostramos los visibles        
//               $is_visible = ( (!preg_match("/^ID_|^ID$/i", $clave) OR in_array($clave,$visibles) OR in_array($clave,$updates) ) AND ( !in_array($clave,$ocultos) ))  ; 

//               $not_id_var= isset($print_id)?  $print_id : $is_visible  ;         // $print_id indica que se imprima los campos ID_ tambien

               // Lo metemos en COLUMNAS OCULTAS POR SI SE QUIEREN MOSTRAR POR JAVASCRIPT
//               $class_hide_id= $not_id_var ? "" : "class='hide_id'" ;     
//               $hide_id= $not_id_var ? "" : "hide_id" ;                 //class hide_id hace que se oculten las columnas hasta que pulsemos Show ID


               // IF PARA VALORES DE CONTROL NO IMPRMIBLES (TOOLTIPS, FORMATS , COLOR...)

               // TOOLTIP POR VALOR  CAMPO : CAMPODEMITABLA_TOOLTIP  , XXXXXX_FORMAT
               if ( $pos=strpos($clave, '_FLAG')  )   // FORMATO CONDICIONAL: comprobamos si el campo es un campo _FORMAT de otro campo posterior
               {
                   // este campo es un VTOOLTIP 
                   $clave_formateada=substr($clave,0,$pos) ;    //Extraigo el nombre del campo a formatear
                   $flags[$clave_formateada]=$valor ;         // registro el VTOOLTIP  para la posterior impresión del CAMPO
               }                        
               elseif ( $pos=strpos($clave, '_TOOLTIP')  )   // FORMATO CONDICIONAL: comprobamos si el campo es un campo _FORMAT de otro campo posterior
               {
                   // este campo es un VTOOLTIP 
                   $clave_formateada=substr($clave,0,$pos) ;    //Extraigo el nombre del campo a formatear
                   $vtooltips[$clave_formateada]=$valor ;         // registro el VTOOLTIP  para la posterior impresión del CAMPO
               }                        
               elseif ( $pos=strpos($clave, '_MODAL')  )   // FORMATO CONDICIONAL: comprobamos si el campo es un campo _FORMAT de otro campo posterior
               {
                   // este campo es un VTOOLTIP 
                   $clave_formateada=substr($clave,0,$pos) ;    //Extraigo el nombre del campo a formatear
                   $mtooltips[$clave_formateada]=$valor ;         // registro el VTOOLTIP  para la posterior impresión del CAMPO
               }                        
               // FORMATO CONDICIONAL  CAMPO : CAMPODEMITABLA_FORMAT  , XXXXXX_FORMAT
               elseif ( $pos=strpos($clave, '_FORMAT')  )   // FORMATO CONDICIONAL: comprobamos si el campo es un campo _FORMAT de otro campo posterior
               {
                   // Hay FORMATO CONDICIONAL
                   $clave_formateada=substr($clave,0,$pos) ;    //Extraigo el nombre del campo a formatear
                   $formats[$clave_formateada]=$valor ;         // registro su FORMATO para la posterior impresión del CAMPO
               }   
                elseif ( $pos=strpos($clave, '_COLOR')  )   // COLOR CONDICIONAL:  ... PENDIENTE DE DESARROLLO ...
               {
                   $clave_formateada=substr($clave,0,$pos) ;
                   $formats[$clave_formateada]=$valor ;
               }       
               else     // INICIAMOS  VALOR VISIBLES .continuamos, es un campo de valores convencional
               {   
                   // sumamos las columnas sumatorias
                    if (isset($tabla_sumatorias[$clave])  AND (gettype($tabla_sumatorias[$clave])=='integer' OR gettype($tabla_sumatorias[$clave])=='double'  ))
                                     { $tabla_sumatorias[$clave]+=$valor   ; }      // SUMATORIAS DE TOTALES
                     
                    // google chart   
                      if ((in_array($clave,$cols_string) ))
                          { $json_rows_chart.= "  { v: '$valor' } "  ; }
                      elseif (in_array($clave,$cols_number))
                          { $json_rows_chart.= " , { v: '$valor' } "  ; }       // OJO !! introducimos la coma separadora


                   // inicializamos los div extras que irán dentro del TD tras el valor (button, tooltips, flags, links, etc)
                   $div_extras_html='';


                   // si hay vtooltip lo construimos
                    $tooltip_txt = isset($vtooltips[$clave])? $vtooltips[$clave]  : ""  ;    
                    $mtooltip_txt = isset($mtooltips[$clave])? $mtooltips[$clave]  : ""  ;    
    //                $tooltip_txt= str_replace("'","", $tooltip_txt) ;
    //                $tooltip_txt= str_replace("<br>","\n", $tooltip_txt) ;
                    $tooltip_txt= preg_replace("/\s*<br>\s*/","\n", $tooltip_txt) ;  // quitamos los espacios alrededor de <br> y lo sustituimos por \n
                    $tooltip_txt_alert= str_replace("\n","\\n", $tooltip_txt) ;
                    $div_tooltip_html = ($tooltip_txt) ? "<span class='btn btn-xs btn-link noprint transparente'   onclick='alert(\"$tooltip_txt_alert\")' >"
                                            . "<i class='fas fa-info'  title=\"$tooltip_txt\"></i></span>"  : "" ; 

                    $div_mtooltip_html = ($mtooltip_txt) ? boton_modal( 'D', 'Descompuesto' ,$mtooltip_txt)  : "" ; 


                    $div_extras_html.=$div_tooltip_html ;      //añado los div de TOOLTIPS al onjunto de DIVS_EXTRAS
                    $div_extras_html.=$div_mtooltip_html ;      //añado los div de TOOLTIPS al onjunto de DIVS_EXTRAS

                    // si hay flags lo añadimos al div extra
                    $div_extras_html .= (isset($flags[$clave])) ? "<div style='float:right' >$flags[$clave]</div>" : "";  //añado los div de FLAGS al onjunto de DIVS_EXTRAS

                    // si hay $divs lo añadimos al div extra 
                    if (isset($divs[$clave]))
                    {    
                        $div_html= str_replace('_VAR_', $rst[$divs[$clave][1]] , $divs[$clave][0]) ; // sustitucion de _VAR_ por su valor en funcion del campo 
                        $div_html= str_replace('_ID_', 'div'.$cont_TD , $div_html ) ; // sustitucion de _ID_ por el valor del ID del elemento HTML <DIV>

                        $div_extras_html .= $div_html  ; //añado los div de DIVS previa sustitucion de _VAR_ por su valor al onjunto de DIVS_EXTRAS
                    }
    //                $flag_txt = isset($flags[$clave])? $flags[$clave]  : ""  ;    
    //                $div_flag_html = ($flag_txt) ? "<div style='float:right' >$flag_txt</div>"  : "" ; 
    //                
    //                 $div_extras_html.=$div_flag_html ;


                   // FORMATEAMOS EL VALOR
                    
                      $format_style=" style='text-align:left;' ";   // por defecto left DEBUG
                    $formato_valor= (isset($formats[$clave])) ? $formats[$clave] :  cc_formato_auto($clave) ;  // el formato es el definido o por defecto según su clave
                    $valor_txt=cc_format( $valor, $formato_valor , $format_style, $clave ) ;    // formateamos el valor
                    $tipo_dato= preg_match('/moneda|porcentaje|fijo|text_moneda/i', $formato_valor) ? 'num' :
                                 (preg_match('/semaforo|semaforo_not|boolean/i', $formato_valor) ? 'boolean' : '') ;

                    //inicializo la align del TD
                    $format_style = (isset($aligns[$clave])) ?   " style='text-align:{$aligns[$clave]} ; ' "    :  $format_style  ;      // $aligns[] si se ha especificado una ALIGN la determino
                    $format_align = cc_format_align($format_style) ;   // esto se usa para los botones dentro del <TD>
                    $format_style = (isset($styles[$clave])) ? str_replace("style='", "style='".$styles[$clave], $format_style)    :  $format_style  ;      // añadimos los styles particulares

                  
                    
//                    $format_style=" style='text-align:left;' ";   // por defecto left DEBUG
//                    
//                    $format_style = (isset($aligns[$clave])) ?   " style='text-align:{$aligns[$clave]} ; ' "    :  " style='text-align:left;' "  ;      // $aligns[] si se ha especificado una ALIGN la determino
////                    $formato_valor= (isset($formats[$clave])) ? $formats[$clave] :  cc_formato_auto($clave) ;  // el formato es el definido o por defecto según su clave
//                    $valor_txt=cc_format( $valor, $formats[$clave] , $format_style, $clave ) ;    // formateamos el valor
////                    $valor_txt=cc_format( $valor, $formato_valor , $format_style, $clave ).$formato_valor ;    // formateamos el valor
//                    $tipo_dato= preg_match('/moneda|porcentaje|fijo|text_moneda/i', $formats[$clave]) ? 'num' :
//                                 (preg_match('/semaforo|semaforo_not|boolean/i', $formats[$clave]) ? 'boolean' : '') ;
//
//                    //inicializo la align del TD
//                    $format_align = cc_format_align($format_style) ;   // esto se usa para los botones dentro del <TD>
//                    $format_style = (isset($styles[$clave])) ? str_replace("style='", "style='".$styles[$clave], $format_style)    :  $format_style  ;      // añadimos los styles particulares
////                    $valor_txt=$valor_txt.$format_style;
//
////                    $auxiliar='';
//////                    $valor_txt=cc_format( $valor, $formats[$clave] , $auxiliar, $clave ) ;    // formateamos el valor
////                    $valor_txt=cc_format( $valor, $formats[$clave]  ). $formats[$clave] ;    // formateamos el valor 
//                    

                    // DBLCLICK o FILTRADO .  preparamos codigo javascript para DBLCLICK
                   $valor_sin_tags=strip_tags($valor) ;
                   $dblclick_ondblclick = isset($dblclicks[$clave]) ?    "ondblclick=\"document.getElementById('{$dblclicks[$clave]}').value='$valor_sin_tags';"
                                                                      . " document.getElementById('form1').submit();\"  "  : ""  ;
                   $dblclick_div = isset($dblclicks[$clave]) ?   "<button class='btn btn-xs btn-link noprint transparente'  "
                                                . "onclick=\"document.getElementById('{$dblclicks[$clave]}').value='$valor_sin_tags'; document.getElementById('form1').submit(); \" "
                                                . " title='copiar al Filtro' ><i class='fas fa-filter'></i></button>"  : ""  ;

                     $div_extras_html .= $dblclick_div ;                          

                   //fabricamos un span que no se pinta pero que permitirá ordenar la tabla     
                    $is_numero =    is_format_numero(  isset($formats[$clave]) ? $formats[$clave] :  cc_formato_auto($clave) ) ;                    
                    $span_sort= $is_numero ?  "<span style='opacity : 0 ; font-size: 0px ;' >"
                                    .str_pad(number_format(10000000000000+$valor,3,".",""),20," ", STR_PAD_LEFT)."</span>"   : "<span style='opacity : 0 ; font-size: 0px ;'>".$valor."</span>" ;


                    // formamos la cadena_link si es campo UPDATE EDITABLE y si está definida $table_update para hacer los update via javascript
                    $cadena_link = $is_updates[$clave]  ?  "tabla=$tabla_update&wherecond=$id_update=".$rst["$id_update"]."&field=".$clave."&nuevo_valor=" :  ""; 


                    //empezamos a PINTAR
                    // PRIMERO COMPROBAMOS SI ES LINKABLE. SI ES LINKABLE NO ES EDITABLE (UPDATE)
                    if (isset($links[$clave]))   //     ES LINKABLE.                 
                    {          // hay link 
                    //         

    //                                $href_link= $links[$clave][0] . $rst[$links[$clave][1]] ."&_m=$_m" ;            // FASE EXPERIMENTAL PARA EL MIGAS
                                    $href_link= $links[$clave][0] . $rst[$links[$clave][1]]  ;    //anulado provisionalmente, juand, ene21 FASE EXPERIMENTAL PARA EL MIGAS

                                     // creamos el div update_pencil_div por si el link fuera editable (update)

                                     $update_pencil_div= ($is_updates[$clave]) ?   "<a class='btn btn-xs btn-link noprint transparente'  title='editar campo'   "
                                                                         . " onclick=\"tabla_update_str('$cadena_link','$clave','$valor' ,'div$cont_TD','','')\" >"
                                                                        . "<i class='fas fa-pencil-alt'></i>"
                                                                       . "</a> "         :    ""    ;


                                        // title del link  por defecto 'ver ficha'
                                     $title= $tooltip_txt ? $tooltip_txt : 
                                             ((isset($links[$clave][2]))? "{$links[$clave][2]}": "ver ficha" );

                                     $tipo_formato_link= isset($links[$clave][3]) ? $links[$clave][3]   :  "SIN FORMATO"   ;
                                     $link_target_blank= isset($links[$clave][4]) ? ($links[$clave][4]? "target='_blank'" : "")   :  "target='_blank'"   ; //parametro 4,default es target blank
                                     if ($tipo_formato_link)  // tiene formato de link
                                     { 
                                         // hay formato especial de link
                                         if ($tipo_formato_link=='formato_sub')   // FORMATO TRADICIONAL DE SUBRRAYADO (es incompatible con sortTable (ordenar tabla))
                                         {
                                             $valor_txt_final=$valor_txt? $valor_txt : 'ver'  ;  // evitamos que un valor vacio impida hacer el link
    //                                         $valor_txt_final=$valor_txt? $valor_txt : ''  ;  // No mostramos 'ver' en caso de valor vacio, juand, dic-2020
                                             $TD_td = "<td $class_hide_ids[$clave]   $format_style $dblclick_ondblclick >"  ;
                                             $TD_html = "$span_sort<span id='div$cont_TD'  ><a href='$href_link' title='$title' "
                                                     . " $link_target_blank>{$valor_txt_final}</a></span>{$update_pencil_div}{$div_extras_html}";        

                                         }elseif ($tipo_formato_link=='formato_sub_vacio')   // FORMATO TRADICIONAL DE SUBRRAYADO (es incompatible con sortTable (ordenar tabla)) pero son poner "ver"
                                         {
                                             $valor_txt_final=$valor_txt? $valor_txt : ''  ;  // evitamos que un valor vacio permita hacer el link

                                             $TD_td = "<td $class_hide_ids[$clave]   $format_style $dblclick_ondblclick >" ;
                                             $TD_html = "$span_sort<span id='div$cont_TD'  ><a href='$href_link' title='$title' "
                                                     . " $link_target_blank>{$valor_txt_final}</a></span>{$update_pencil_div}{$div_extras_html}";        

                                         }else              //if ($tipo_formato_link=='icon')     // FORMATO link principal
                                         {   
                                             $TD_td = "<td $class_hide_ids[$clave]  $format_style $dblclick_ondblclick   >" ;
                                             $TD_html ="$span_sort<span id='div$cont_TD' style='float:left;width:90%' >{$valor_txt}</span>"    
                                                     . "{$update_pencil_div}<a class='btn btn-link btn-xs noprint transparente' id='a$cont'  href=\"$href_link\"   "
                                                     . "  title='$title' $link_target_blank> <i class='fas fa-external-link-alt'></i>"
                                                     . "</a>{$update_onclick}{$div_extras_html}";  

                                          }

                                     }else  ///SIN FORMATO DE LINK.   LINKABLE SIN FORMATO Y NO EDITABLE
                                     { 

                                        $link_div= "<a class='btn btn-link btn-xs noprint transparente' href='$href_link' title='$title'"
                                                   . " $link_target_blank> <i class='fas fa-external-link-alt'></i></a>" ;
                                        $style_max_width_90 = ($update_pencil_div OR $dblclick_div )? "max-width:90% ;"   :  ""   ;
                                        $TD_td = "<td $class_hide_ids[$clave] $format_style  ' >" ;
                                        $TD_html = "$span_sort<span style='$style_max_width_90 float:left;text-align:$format_align ' $dblclick_ondblclick  id='div$cont_TD'  >{$valor_txt}</span>"
                                                                  . "{$update_pencil_div}{$link_div}{$div_extras_html}";


                                       }

                   }        // $UPDATES={}. IMPRIMIMOS LAS -COLUMNAS EDITABLES veo que columnas son actualizables y compruebo que existan en el row
                   elseif ( $is_updates[$clave] )   // IS_UPDATE, CELDA EDITABLE
                   { 
                                   // fabricamos la cadena_link
                                   if ($is_booleans[$clave] )  
                                   {
                                     $checked= $valor ? 'checked' : '' ;
    //                                 $valor_txt= $valor ? '1' : '0' ;
                                     $display= $valor ? 'display:inline;' : 'display:none;'  ;  //pintamos o no pitamos el check OK
                                     $background_color= ($formats[$clave]=='semaforo')?     ($valor ? "background-color:green;" : "background-color:red;" ) 
                                                      : (($formats[$clave]=='semaforo_not')? ( $valor ? "background-color:red;" : "background-color:green;")
                                                      : ( $valor ? "background-color:royalblue;" : "background-color:white;") )  ;


                                     $TD_html =   "<div style='cursor: pointer;text-align:center;$background_color' id='td_$cont_TD' value='$checked'   "
                                             .    "onclick=\"tabla_update_onchange('$cadena_link',document.getElementById('span_$cont_TD').style.display,'$tipo_dato','span_$cont_TD','td_$cont_TD' )\"  >"
                                             . "$span_sort"
                                             . "<p id='span_$cont_TD' style='$display' ><i class='fas fa-check'></i></p>"
                                           . "{$div_extras_html} </div>"  ;

    //                                  $TD_html = "juan" ;



                                   }elseif ($is_div_edits[$clave])  // FUTURO div_edit       $is_div_edit
                                   {                       // UPDATE DIV_EDIT                                                                                             //// ****DEBUG 1***


    //                                // DIV EDIT  (PRUEBAS)  NO BORRAR
    //                                   $TABLE .=   "<td>"
    //                                            . "<div id='div$cont_TD' "
    //                                            . " onblur=\"tabla_update_onchange('$cadena_link',this.innerHTML,'div_edit' )\"   >$valor <a href='https://www.google.es' title='titulo'>link</a></div>$div_extras_html"
    //                                             ." </td>"  ;

                                       $div_extras_html=""; // PROVISIONALMENTE ANULAMOS LOS DIV_EXTRAS por que interfieren, abril20
                                       $TD_html =  "<div id='div$cont_TD' contenteditable='true' class='div_edit' "
                                                . " onblur=\"tabla_update_onchange('$cadena_link',this.innerHTML,'div_edit','div$cont_TD' )\"   >$valor</div>$div_extras_html" ;

    //                                    $TABLE .= ($debug)? "<button onclick='alert($(\"#div$cont_TD\").html());' style='cursor:pointer;'  >VER</button>" :"" ;

                                       //anulado , puede usarse: contenteditable="true"
    //                                   $TABLE .= "<script type='text/javascript'>" ;
    //                                   $TABLE .= "document.getElementById('div$cont_TD').contentEditable='true'; " ;
    //                                   $TABLE .= "</script>"  ;



                                   }elseif ($is_text_edits[$clave]) 
                                   {                       // UPDATE TEXT_EDIT          TEXTAREA                                                                                   //// ****DEBUG 1***

                                       $TD_html = "<textarea class='textarea_tabla' rows='3' id='textarea1' name='textarea1' "
                                                . " onchange=\"tabla_update_onchange('$cadena_link',this.value )\"   >$valor</textarea>$div_extras_html" ;




                                   }elseif ($is_text_monedas[$clave]) 
                                   {                       // UPDATE TEXT_EDIT                                                                                             //// ****DEBUG 1***


                                       $valor_txt = cc_format($valor, 'moneda') ;
                                       $TD_html =   "$span_sort"
                                                . "<textarea class='textarea_tabla' style='border:none; text-align:right; resize: none;' rows='1' cols='13' id='div$cont_TD' name='textarea1' onclick='this.select()' "
                                                . " onchange=\"tabla_update_onchange('$cadena_link',this.value,'num','div$cont_TD' )\"   >$valor_txt</textarea>$div_extras_html";




                                   }elseif ($is_fechas[$clave]) // campo FECHA  EDITABLE
                                   {
                                         $fecha0=substr($valor,0,10) ;

                        //              $TABLE .=  $TD_etiqueta ;
                                       $TD_html = "$span_sort"
                                           . "<input type='date' id='datepicker2' value='$fecha0' "
                                           . " onchange=\"tabla_update_onchange('$cadena_link',this.value,'fecha' )\" > " ;                                                                    // hacemos el JAVASCRIPT para actualizar la FECHA

                                   }elseif ( $is_selects[$clave]) // es SELECT, es decir, podemos seleccionarlo de una lista a buscar
                                   {
                                       //definimos variables para el SELECT
                                      $campo_ID=$selects[$clave][0] ;      // ["campo_ID", "campo_texto", "tabla_select",Opcional "link a nuevo",   link a VER ,   campo al link anterior,   otro_WHERE]
                                      $campo_texto=$selects[$clave][1] ;
                                      $tabla_select=$selects[$clave][2] ;
                                      $link_nuevo=isset($selects[$clave][3]) ? $selects[$clave][3] : "" ;
                                      $link_ver = isset($selects[$clave][4]) ? $selects[$clave][4] : "" ;
                                      $id_campo = isset($selects[$clave][5]) ? $selects[$clave][5] : "" ;
                                      $otro_where=isset($selects[$clave][6]) ? $selects[$clave][6] : "" ;   // solo sirve para el UPDATE y la nueva búsqueda
                                      $no_where_c_coste = isset($selects[$clave][7]) ? $selects[$clave][7] : "" ;
                                      $where_c_coste_txt = $no_where_c_coste ? "" : " AND $where_c_coste " ;
                                      $otro_where .= $where_c_coste_txt ;  
                                      $campo_mostrado=isset($selects[$clave][8]) ? $selects[$clave][8] : $campo_texto ;   // solo sirve pintar un valor diferente al de búsqueda
                                      $link_nuevo_target_blank = preg_match("/^javascript/i", $link_nuevo) ? '' : "target='_blank'" ;  //si no es javascript hacemos target blank

                                      // sustitución de {clave}
                                      if (like($link_nuevo,"%{%}%"))
                                      {  foreach ($rst as $clave2 => $valor2){ $link_nuevo= str_replace( "{".$clave2."}", $valor2, $link_nuevo) ; } ;                                     
                                      }    
                                      if (like($link_ver,"%{%}%"))
                                      {  foreach ($rst as $clave2 => $valor2){ $link_ver= str_replace( "{".$clave2."}", $valor2, $link_ver) ; };                                        
                                      }    
                                      
                                      // **PROVISIONAL*** a todos las busquedas de SELECT les añado el $where_id_c_coste
                                      $valor_txt_sel= ($valor<>"") ?  Dfirst($campo_mostrado,$tabla_select,"$campo_ID='$valor' $where_c_coste_txt ") : ""  ;   //evitamos un error en Dfirst si $valor es NULL              
                                      $valor_txt_sel= $valor_txt_sel ?  $valor_txt_sel : "";   // quitamos el valor 0

                                      // PROVISIONAL UNOS DÍAS HASTA VER QUÉ FICHAS REQUIEREN AÑADIR LOS SELECT AL UPDATES[]
                        //                if (!$is_updates[$clave]) { $valor_txt_sel = '¡¡ ATENCION!! AÑADIR EL SELECT AL UPDATES SI PROCEDE (juand)' ;}
                                      // LINK PARA VER LA ENTIDAD

                                      //debug
    //                                  pre($rs);
                                      $valor_id_campo=isset($rst[$id_campo])? $rst[$id_campo] : "" ;

                                      $add_link_select_ver = $link_ver ? "<a id='a_select_$cont_TD'  href='{$link_ver}$valor_id_campo&_m=$_m' target='_blank'>$valor_txt_sel</a>" : "$valor_txt_sel" ;

                                      if ($is_updates[$clave])   // INCOHERENCIA, está dentro de un if ($is_updates[$clave]) ?? (lo mantengo por precaución, juand feb21)
                                      {
                                //              LINKS EN CASO DE EL SELECT SER EDITABLE (UPDATES)  (entiendo que siempre el SELECT es EDITABLE!!)
                                              $add_link_select= $link_nuevo ? "<a class='btn btn-xs btn-link noprint transparente' href=\"$link_nuevo\"   $link_nuevo_target_blank    title='nuevo'>"
                                                                                  . "<i class='fas fa-plus-circle'></i></a>" : "" ;
                                              //debug
    //                                          echo pre($rst);


                                              $cadena_link="tabla=$tabla_update&wherecond=$id_update=".$rst[$id_update]."&field=".$clave."&nuevo_valor=";     

                                              $cadena_link_encode=urlencode($cadena_link); //$cadena_link necesaria para update_ajax.php

                                              // HREF, link  a ejecutar tras la actualización del campo
                                              $select_href  = isset($selects[$clave]['href']) ? $selects[$clave]['href'] : " " ; //por defecto un ESPACIO para evitar errores en el GET
                                              // DEBUG MAY20
                                              $cadena_select_enc= encrypt2( "idtabla=$idtabla&href=$select_href&cadena_link_encode=$cadena_link_encode&tabla_select=$tabla_select&campo_ID=$campo_ID&campo_texto=$campo_texto&select_id=select_$cont_TD&filtro=") ;


                                              // sistema showInt   
                                              // PONEMOS EL INPUT
                                              $add_link_select_cambiar="<INPUT class='noprint' style='font-size: 70% ;font-style: italic ;' id='input_$cont_TD' size='7'  "
                                                      . "  onkeyup=\"tabla_update_select_showHint('$cadena_select_enc','$campo_texto','$valor_txt_sel','$cont_TD','$otro_where' ,this.value)\" placeholder='buscar...' value=''  >" ;
                                              // LUPA busca todos, intruduce tres espacios en el INPUT
                                              $add_link_select_cambiar.= "<span class='btn btn-xs btn-link noprint transparente'  " 
                                                      . " onclick=\" $('#input_$cont_TD').val($('#input_$cont_TD').val()+'   ')  ; $('#input_$cont_TD').keyup()   \"   "
                                                      . " title='Buscar'> <i class='fas fa-search'></i></span>" ;
                                              // FUNCION PASTE()
                                               $add_link_select_cambiar.= "<span class='btn btn-xs btn-link noprint transparente'  "
                                                      . " onclick=\" paste( function(nuevo_valor){  document.getElementById('input_$cont_TD').value=nuevo_valor ; $('#input_$cont_TD').keyup() } )  \"   "
                                                      . " title='paste from clipboard'> <i class='fas fa-paste'></i> </span>";


                                              //    SCRIPT PARA PODER PULSAR ENTER
                                              $add_link_select_cambiar.="<script>"
                                                                      . "var input_id = document.getElementById('input_$cont_TD');"
                                                                      . "input_id.addEventListener('keyup', function(event) {"
                                                                      . "      event.preventDefault();if (event.keyCode === 13) "
                                                                      . " {tabla_update_select_showHint_ENTER('$cont_TD');  }});"
                                                                      . "</script>" ;

                                               $add_link_select_cambiar_div_sugerir= "<div class='sugerir' id='sugerir_$cont_TD'></div>" ;

                                              // uso de cambiar a VALOR NULL  PARA HACER CERO EL ID_ (probablemente 0) y no seleccionarlo de la lista. Ej: quitar pago de remesa (id_remesa=0)
                                              if (isset($selects[$clave]["valor_null"]))     // cuando queremos poner a CERO el ID_, por ejemplo quitar la remesa, hacer id_remesa=0 en un ID_PAGO
                                              {   
                                                 $valor_null= $selects[$clave]["valor_null"] ; 
                                                 $valor_null_title = isset($selects[$clave]["valor_null_title"])? $selects[$clave]["valor_null_title"] : "quitar" ; 

                                                 $add_link_select_valor_null= "<span class='btn btn-xs btn-link noprint transparente' title='$valor_null_title' "
                                                             . " onclick=\"tabla_update_str('$cadena_link','','','p$cont_TD','$valor_null','' );location.reload(); \" ><i class='far fa-window-close'></i></span>" ;
                                      //                                   tabla_update_str('$cadena_link','$clave','$valor' , 'div$cont_TD', '$tipo_dato')
                                                 }
                                              else
                                              {
                                                  $add_link_select_valor_null="" ;
                                              }    
                                      }
                                      else    // NO ES EDITABLE UPDATE
                                      {
                                              $add_link_select_cambiar='';
                                              $add_link_select='';
                                              $add_link_select_valor_null='';
                                              $add_link_select_cambiar_div_sugerir='';
                                      }
                                      //  IMPRESION DE CAMPO $SELECT[]
                        //              pintamos el TD_html
                                      $button_toggle_menu="<button class='btn btn-xs btn-link noprint transparente' onclick=\" $('#menu_span_$cont_TD').toggle('fast') ; \"><i class='fas fa-ellipsis-h'></i></button> " ;

                                      $TD_html = "$span_sort $add_link_select_ver $button_toggle_menu  <span id='menu_span_$cont_TD' style='display:none;'> $add_link_select_cambiar $add_link_select $add_link_select_valor_null "
                                                             . "$add_link_select_cambiar_div_sugerir</span>"
                                                   . "<div id='p$cont_TD'></div>" ;


                                   // fin $IS_SELECT

    //                                   $TD_html = "$span_sort $TD_valor" ;                                                                    // hacemos el JAVASCRIPT para actualizar la FECHA

                                   }

                                   else
                                   {       // UPDATE GENERAL EDITABLE (STRING o NUMERICO)                                                                                                 //// ****DEBUG 1***
                                   $update_onclick="";   //ANULAMOS ANTIGUO PROCEDIMIENTO DE ONCLICK EN TODO EL TD

                                     $update_pencil_div="<span class='btn btn-link btn-xs transparente noprint' style='float:right ; cursor:pointer;'  title='editar campo' "
                                                . " onclick=\"tabla_update_str('$cadena_link','$clave','$valor' , 'div$cont_TD','', '$tipo_dato')\"   >"
                                                . "<i class='fas fa-pencil-alt noprint'></i></span> ";


                                     $style_max_width_90 = ($update_pencil_div OR $dblclick_div )? "max-width:90% ;"   :  ""   ;
                                    $TD_td = "<td $class_hide_ids[$clave] $format_style  ' >";
                                    $TD_html =  "$span_sort<span style='$style_max_width_90 float:left;text-align:$format_align ' $dblclick_ondblclick  id='div$cont_TD'  >{$valor_txt}</span>"
                                                                  . "{$update_pencil_div}{$div_extras_html}";


            //                       $update_pencil_div='';
                                   }
                 }else
                    {   /// NO LINKABLE NO EDITABLE
                              // GENERAL NO EDITABLE
                                   $update_onclick="" ;
    //                               $update_pencil_div='';
                                   $style_max_width_90 = ($dblclick_div )? "max-width:90% ;"   :  ""   ;      // preveyendo poner un <span> para que simule el doblr click (copia a filtro) en mobile

                                   $TD_td = "<td $class_hide_ids[$clave] $format_style   >" ;
                                   $TD_html =  "$span_sort<span style='$style_max_width_90 float:$format_align;text-align:$format_align ' $dblclick_ondblclick  id='div$cont_TD'  >{$valor_txt}</span>"
                                            . "{$div_extras_html}";
    //                                $TABLE .= $TD_html ;        


                    }  

                    $TABLE.= $TD_td  . $TD_html . "</td>" ;

                    $columna_ficha_html.= $is_visibles[$clave]? "<div><span style='float:left;color:silver;'>{$etiquetas["$clave"]}:&nbsp;&nbsp; </span>$TD_html</div>"   : "" ;
    //                $columna_ficha_html.= $not_id_var? "<div>".$clave .":". $TD_html."</div>"   : "" ;

               }	//************* FIN DE PINTADO EL VALOR  VISIBLE               
       } //  ******** FIN DE FOREACH #VALORES   CLAVE -> VALOR
       

       // FINALIZADOS LOS <TD> DE VALORES     *************
       
       
       //*********     <TD> DE ACCIONES  **************
       //
       // ACCION ROW botones de acciones en ULTIMA COLUMNA que compenten a toda la fila (edit, delete...)
       $TD_html='';
       if (isset($actions_row["id"]) AND isset($rst[$actions_row["id"]]))  // comprobamos si está definido el campo y si existe en la consulta                        
       { 
           $var_id=$rst[$actions_row["id"]] ;
           
           // Iniciamos el <TD> de ACTION_ROW[]
           
           //  ACTION_ROW   UPDATE_LINK
           if (isset($actions_row["update_link"]))
           { $TD_html .= "<a class='btn btn-link btn-xs transparente noprint' href=\"{$actions_row["update_link"]}{$var_id}\" ><i class='fas fa-pencil-alt'></i></a> ";             
           }

           //  ACTION_ROW   DELETE_LINK
           if (isset($actions_row["delete_link"])) 
           {
           $cadena_link= encrypt2("tabla=$tabla_update&wherecond=$id_update=".$rst["$id_update"] ) ; 
           $delete_confirm= isset($actions_row["delete_confirm"]) ? $actions_row["delete_confirm"] : 1 ;
           $TD_html .= "<a class='btn btn-link transparente noprint'  onclick=\"tabla_delete_row('$cadena_link'  , 'TR_$cont_TR' , '$delete_confirm')\"  title='eliminar fila'><i class='far fa-trash-alt'></i></a> "; 
           }
           
           //  ACTION_ROW   ONCLICK1_LINK
           if (isset($actions_row["onclick1_link"]))     // está activado el boton onclick1
               {

//               echo $titulo;
               //sustituimos en la cadena $actions_row["onclick1_link"] la _VARIABLE1_ por su valor en cada row de $rst["$id_update_onclick1"] 
               $cadena_onclick=str_replace("_VAR_ID_",$var_id,$actions_row["onclick1_link"]);     // sustituimos si existe la variable _VAR_ID_
               if (isset($onclick_VAR_TABLA1_)) { $cadena_onclick=str_replace("_VAR_TABLA1_",$rst["$onclick_VAR_TABLA1_"],$cadena_onclick);}   // si hy _VAR2_ la sustituimos
               if (isset($onclick_VAR_TABLA2_)) { $cadena_onclick=str_replace("_VAR_TABLA2_",$rst["$onclick_VAR_TABLA2_"],$cadena_onclick);}   // si hy _VAR2_ la sustituimos
               if (isset($onclick_VAR_TABLA3_)) { $cadena_onclick=str_replace("_VAR_TABLA3_",$rst["$onclick_VAR_TABLA3_"],$cadena_onclick);}   // si hy _VAR2_ la sustituimos
               $TD_html .= $cadena_onclick ;
               }    
               
          $TABLE .= "<td align='center'>" . $TD_html. "</td>";    // FIN <TD> ACTION_ROW
          
          
          $columna_ficha_html.= "<div>". $TD_html ."</div>" ;        // meto los botones action , si los hay, a la columna_ficha
       }
       
       if ($columna_ficha)  // comprobamos si está definido el campo y si existe en la consulta                        
       { 
           
           // Iniciamos el <TD> de COLUMNA_FICHA
           $TABLE .= "<td class='columna_ficha'>" ;
           $TABLE .= $columna_ficha_html ;
           $TABLE .= "</td>";    // FIN <TD> ACTION_ROW
       }
       
       
	$TABLE .= "</tr>";	  // FIN DE <TR> FILA DE VALORES
       
    $json_rows_chart.=" ] } " ;         // FIN FILA INDIVIDUAL google CHART
    $comma_rows=",";          // comma separador de filas
    
        
  }

$json_rows_chart.=" ] " ;         // FIN del JSON_ROWS_CHART
  
  //     FIN DEL while ppal BUCLE DE DATOS DE TABLA  
  
  
  
  // imprimimos el último SUBTOTAL
   if ($is_subtotal)
    {   
          $TABLE .= "<tr>" ;
          if (isset($col_sel)  ) {$TABLE .=  "<td class='noprint'></td>" ;  }                  //si hay col_sel añadimos su hueco
          $TABLE .= "<td colspan='$colspan' align='right'><i><b>Subtotal</b></i></td>";
          foreach ($array_sumas as $clave => $valor)
              { $TABLE .= "<td align='right'><b>".cc_format($array_sumas[$clave], $formats[$clave])."</b></td>"  ; }
          $TABLE .= "</td></tr>";              
    }
   
  // imprimimos SUMATORIAS si existen
   if (isset($tabla_sumatorias) AND 1)
    {   
          $TABLE .= "<tr>" ;
          if (isset($col_sel)  ) {$TABLE .=  "<td class='noprint'></td>" ;  }                  //si hay col_sel añadimos su hueco
//          $TABLE .= "<td colspan='$colspan' align='right'><b>SUBTOTAL</b></td>";
          foreach ($claves as $clave)
              { 
                    if ( !is_FLAG($clave)  )      // descartamos los encabezados de campos FORMATO CONDICIONAL _FORMAT
                    {  
                      $format_style_sumatorios='';
                      $sumatorio_txt='';
                      if (isset($tabla_sumatorias[$clave]))  
                      {   
                          // comprobamos si empieza por '=' y es formula
                          if (preg_match(  "/^=/", $tabla_sumatorias[$clave]  )) 
                          {  // estamos en FORMULA. Sustituimos los campos por sus valoers numericos
                             $tabla_sumatorias[$clave]= str_replace('=', '', $tabla_sumatorias[$clave]) ;  // quitamos el signo =
                             foreach ($claves as $clave2)
                               {  // recorremos todos los valores agrupados y sustituimos si existen
                                 if(isset($tabla_sumatorias[$clave2]))
                                   { $tabla_sumatorias[$clave]=str_replace( "@@$clave2@@", $tabla_sumatorias[$clave2], $tabla_sumatorias[$clave]) ;     } 
                               }    
                             $tabla_sumatorias[$clave]=evalua_expresion_mysql($tabla_sumatorias[$clave]);  // evaluamos la expresión
                          }
                             
                          $formats[$clave]= isset($formats[$clave])? $formats[$clave] : cc_formato_auto($clave) ;  // ESTO DEBERÍA DE VENIR YA REALIZADO (hay que revisar la asignación de formats automatica
                          $sumatorio_txt= cc_format($tabla_sumatorias[$clave], $formats[$clave], $format_style_sumatorios) ;
                          //" style='text-align:{$aligns[$clave]}
                          
                      }
                         // sumamos background al estilo
//                         $format_style_sumatorios = cc_add_style($format_style_sumatorios , 'background-color:#F2F4F4') ;
                         $format_style_sumatorios =  isset($aligns[$clave])? cc_add_style($format_style_sumatorios , "text-align:{$aligns[$clave]};") : $format_style_sumatorios ;
                         
                         $TABLE .= "<th $class_hide_ids[$clave]  $format_style_sumatorios ><b>$sumatorio_txt </b></th>"  ; 
                    }
              }
          $TABLE .= "</th></tr>";              
    }
   
  
    //******************************************************** TOTALES **************************
    $TR_totales="<tfoot>" ;
//    logs("TABLA AJAX: antes de TOTALES");  

    if (isset($result_T)  )   // Hay TOTALES?
      {   
//           logs("TABLA AJAX: pasamos el primer if");
            if ($result_T->num_rows > 0)
            {	  
//              logs("TABLA AJAX: ENTRO A TOTALES");  

              $TR_totales .= "<tr>" ;  
              if (isset($col_sel)  ) {$TR_totales .= "<th class='noprint'></th>" ;  }       // Si hay columna de Selección añadimos una columna vacía a los TOTALES

              if ( !isset($rs_T) ? ($rs_T = $result_T->fetch_array(MYSQLI_ASSOC)) : $rs_T )              // ROW único de TOTALES	
              {
                  // VARIABLE PARA EL CAMBIO DE COLOR DE LAS COMUNAS DE LOS totales
                 $style_th_color="";
                 foreach ($rs_T as $clave => $valor)               //  VALORES de los TOTALES
                 { 

                       $format_style="" ;                                 //inicializo la align del TD
                       if (isset($formats[$clave]))                              // determinamos los FORMAT  de los TOTALES
                           { 
                           $valor=cc_format( $valor, $formats[$clave], $format_style) ;
                           }   
                         else 
                         {  $valor=cc_format( $valor, 'auto', $format_style,$clave ) ;    // no hay format predefinido, lo hacemos automaticamente según el nombre del campo '$clave'       
                         }

                       if (isset($aligns[$clave])) { $format_style=" style='text-align:{$aligns[$clave]} ; ' " ; }     // si se ha especificado una ALIGN la asigno a la variable

                      // $format_style.=" style='background-color: coral' ;" ;
                       $is_visible = ( (!preg_match("/^ID_|^ID$/i", $clave) OR in_array($clave,$visibles) ) AND ( !in_array($clave,$ocultos) ))  ; 
                       $not_id_var= isset($print_id)?  $print_id : $is_visible  ;         // $print_id indica que se imprima los campos ID_ tambien
                       // Lo metemos en COLUMNAS OCULTAS POR SI SE QUIEREN MOSTRAR POR JAVASCRIPT
    //                   $class_hide_id= $not_id_var ? "" : "class='hide_id_$idtabla'" ;   // intento de controlar los diferentes show_ID para varias tablas en la misma pagina  
                       $class_hide_id= $not_id_var ? "" : "class='hide_id'" ;     
                       $hide_id= $not_id_var ? "" : "hide_id" ;                 //class hide_id hace que se oculten las columnas hasta que pulsemos Show ID

                       // evitamos las ETIQUETAS
                       if ( !is_FLAG($clave)  )      // descartamos los encabezados de campos FORMATO CONDICIONAL _FORMAT
                       {
                           $TR_totales .=  "<th $class_hide_id  $style_th_color $format_style >{$valor}</th>"; 	
                       }elseif (strpos($clave, 'TH_COLOR'))
                       {
                           $style_th_color= $style_th_color ? "" : "style='background-color:#D5D8DC;'"  ;
                       }       


                 }
                      if (isset($actions_row)) { $TR_totales .=  "<th></th>"; }
              }  
               $TR_totales .=  "</tr>";
             }		
      }
      if (isset($result_T2)  )   // ----- TOTALES 2  ----------
      {   
            if ($result_T2->num_rows > 0)
            {	  
              $TR_totales .= "<tr>" ;  
              if (isset($col_sel)  ) {$TR_totales .= "<th class='noprint'></th>" ;  }       // Si hay columna de Selección añadimos una columna vacía a los TOTALES

                while ( $rs_T2 = $result_T2->fetch_array(MYSQLI_ASSOC) )              // ROW único de TOTALES	
              {
                 // VARIABLE PARA EL CAMBIO DE COLOR DE LAS COMUNAS DE LOS totales
                 $style_th_color="";
                 foreach ($rs_T2 as $clave => $valor)               //  VALORES de los TOTALES
              { 
                       $format_style="" ;                                 //inicializo la align del TD
                       if (isset($formats[$clave]))                              // determinamos los FORMAT  de los TOTALES
                           { 
                           $valor=cc_format( $valor, $formats[$clave], $format_style) ;
                           } 
                         else
                         {  $valor=cc_format( $valor, 'auto', $format_style,$clave ) ;    // no hay format predefinido, lo hacemos automaticamente según el nombre del campo '$clave'       
                         }

                       if (isset($aligns[$clave])) { $format_style=" style='text-align:{$aligns[$clave]} ; ' " ; }     // si se ha especificado una ALIGN la asigno a la variable

                      // $format_style.=" style='background-color: coral' ;" ;
    //		   $TR_totales .=  "<th {$format_style} style='font-style: italic; font-weight: bold '>{$valor}</th>"; 	
                       // evitamos las ETIQUETAS flags
                       if ( !is_FLAG($clave)  )      // descartamos los encabezados de campos FORMATO CONDICIONAL _FORMAT
                       {
                           $TR_totales .=  "<th   $style_th_color $format_style >{$valor}</th>"; 	
                       }elseif (strpos($clave, 'TH_COLOR'))
                       {
                           $style_th_color= $style_th_color ? "" : "style='background-color:#D5D8DC;'"  ;
                       }       
                     }
                      if (isset($actions_row)) { $TR_totales .=  "<th></th>"; }
              }  
               $TR_totales .=  "</tr>";
             }		
      }
       if (isset($result_T3)  )   // ----- TOTALES 3  ----------
      {   
            if ($result_T3->num_rows > 0)
            {	  
              $TR_totales .= "<tr>" ;  
              if (isset($col_sel)  ) {$TR_totales .= "<th class='noprint'></th>" ;  }       // Si hay columna de Selección añadimos una columna vacía a los TOTALES

                while ( $rs_T3 = $result_T3->fetch_array(MYSQLI_ASSOC) )              // ROW único de TOTALES	
              {
                 $style_th_color="";
                 foreach ($rs_T3 as $clave => $valor)               //  VALORES de los TOTALES
              { 
                       $format_style="" ;                                 //inicializo la align del TD
                       if (isset($formats[$clave]))                              // determinamos los FORMAT  de los TOTALES
                           { 
                           //cc_format($formats[$clave], $valor , $format_style) ;
                           $valor=cc_format( $valor, $formats[$clave], $format_style) ;
                           }   
                         else
                         {  $valor=cc_format( $valor, 'auto', $format_style,$clave ) ;    // no hay format predefinido, lo hacemos automaticamente según el nombre del campo '$clave'       
                         }

                       if (isset($aligns[$clave])) { $format_style=" style='text-align:{$aligns[$clave]} ; ' " ; }     // si se ha especificado una ALIGN la asigno a la variable

                      // $format_style.=" style='background-color: coral' ;" ;
                       // evitamos las ETIQUETAS
                       if ( !is_FLAG($clave)  )      // descartamos los encabezados de campos FORMATO CONDICIONAL _FORMAT
                       {
                           $TR_totales .=  "<th   $style_th_color $format_style >{$valor}</th>"; 	
                       }elseif (strpos($clave, 'TH_COLOR'))
                       {
                           $style_th_color= $style_th_color ? "" : "style='background-color:#D5D8DC;'"  ;
                       }       
                     }
                      if (isset($actions_row)) { $TR_totales .=  "<th></th>"; }
              }  
               $TR_totales .=  "</tr>";
             }		
      }

       $TR_totales .=  "</tfoot>";
       //---------------------------------------------------- FIN TOTALES 3----------------------------

       $TABLE .= $TR_totales ;        // IMPRIMO <TR> DE TOTALES si no hay TOTALES es la cadena VACIA

       $TABLE .= "</tbody></table>";
       $TABLE .= "</div>";



   
 }   /// **************************** FIN <DIV> Y <TABLE> **********************
  
  
 else 
 {      // consulta VACIA
     $msg_tabla_vacia=isset($msg_tabla_vacia) ? $msg_tabla_vacia :'' ;
     $TABLE .=  "<p>$msg_tabla_vacia</p>" ;
     
 }

 
if ($tabla_ajax)
{   
$tabla_tiempo= $_SESSION["admin_debug"]? "<span class='transparente small noprint ' > (".number_format(microtime(true)-$time0,3)." s)</span>" :"" ;
$refresh_ajax= isset($javascript_cargar)?  "$tabla_tiempo <button type='button' id='refresh_$idtabla' class='btn btn-tool btn-sm noprint'  onclick=\" $javascript_cargar \" title='Refrescar tabla'> <i class='fas fa-redo'></i></button>"  : ""  ;
}
else
{
$refresh_ajax="";    
}    
$TABLE = <<<EOT
        
        
            <div class="card  $tabla_collapse">
              <div class="card-header border-0">

                <h2 class="card-title">
                  <button type="button" class="btn btn-tool btn-sm noprint" data-card-widget="collapse">
                    <i class="far fa-calendar-alt noprint"></i> $titulo 
                  </button>
                </h2>
                <div class="card-tools">
                  $refresh_ajax
                  <button type="button" class="btn btn-tool btn-sm noprint" data-card-widget="collapse">
                    <i class="fas fa-minus"></i>
                  </button>
                  <button type="button" class="btn btn-tool btn-sm noprint" data-card-widget="maximize"><i class="fas fa-expand"></i>
                  </button>
                  
                  <button type="button" class="btn btn-tool btn-sm noprint" data-card-widget="remove">
                    <i class="fas fa-times"></i>
                  </button>
                  
                </div>
              </div>
              <div class="card-body pt-0">
                <!--The calendar -->
<!--                <div id="calendar" style="width: 100%"></div>-->
                 $add_link_html $TABLE  $tabla_footer 
              </div>
            </div>

EOT;

//$TABLE.= "<span class='small noprint transparente' > ".number_format(microtime(true)-$time0,3)."s</span>" ;
//                   <!-- button with a dropdown -->
//                  <div class="btn-group">
//                    <button type="button" class="btn btn-tool btn-sm noprint dropdown-toggle" data-toggle="dropdown" data-offset="-52">
//                      <i class="fas fa-bars"></i></button>
//                  </div>

 
 
// echo $TABLE ;
//$TABLE .=  " </div>" ;

  // TERMINAMOS LA TABLA_DIV  
        
//echo "{ $json_cols_chart , $json_rows_chart } " ;        
 
// evitamos el CSS si venimos por ajax
 if (!$tabla_ajax)
 {    
  require('../include/tabla_js_php2.php');     // Estamos en PHP seguimos la ruta habitual
  
        // INICIALIZAMOS TODAS LAS VARIABLES Y ARRAYS DE TABLA.PHP PARA EVITAR INTERFERENCIAS CON NUEVAS REQUERY EN EL MISMO PHP.
//  unset( $idtabla, $tabla_style, $tabla_footer,$add_link_html, $add_link,$rst, $result_T, $rs_T,$result_T2, $rs_T2,$result_T3, $rs_T3, $tabla_expandida,$tabla_expandible, $tabla_update, $id_update,$col_sel,$array_sumas,$valign,$colspan,$col_subtotal,$print_id, 
//        $titulo, $msg_tabla_vacia,  $add_link,  $links, $formats, $format_style, $tooltips, $actions_row,
//        $updates,$dblclicks ,$id_agrupamiento, $buttons ,$cols_string,$cols_number,$chart_ON,$ocultos,$cols_line) ;

  unset( $tabla_sumatorias,$idtabla, $tabla_style, $tabla_footer,$add_link_html, $add_link,$sql, $sql_T, $sql_T2, $sql_T3,$sql_S,$result_S, $rst, $result, $result_T, $rs_T,$result_T2, $rs_T2,$result_T3, $rs_T3, $tabla_expandida,$tabla_expandible, $tabla_update
          , $id_update,$col_sel,$array_sumas,$valign,$colspan,$col_subtotal,$print_id, 
        $titulo, $msg_tabla_vacia,  $add_link,  $links, $formats, $format_style, $tooltips, $actions_row,
        $updates,$dblclicks ,$id_agrupamiento, $buttons ,$cols_string,$cols_number,$chart_ON,$ocultos,$cols_line) ;

  
  
 }else
 {
     
    //logs( "TABLA_AJAX TABLE: ".$TABLE );

    echo $TABLE ;         // enviamos $TABLE por AJAX
 

 }    
 

   

?>

 <!--SISTEMA DATATABLE DE BUSQUEDA Y PAGINACION-->
<!--<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/dt/dt-1.10.16/datatables.min.css"/>
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/v/dt/dt-1.10.16/datatables.min.js"></script>-->



<!--<script>
    $(document).ready(function() {
        $('#<?php // echo $idtabla; ?>').DataTable();            // ANULADO PROVISIONALMENTE el sistema de busqueda y paginación
    } );
</script> -->
 <!--FIN SISTEMA DATATABLE DE BUSQUEDA Y PAGINACION-->
