
 <?php 
 
// echo "<div id='chart_div' ></div>" ;
// echo "JUAN DURAN" ;

 $idtabla="tabla_".rand() ;           // genero un idtabla aleatorio que usaremos para evitar conflictos con otras tabla.php o ficha.php


 ?>

<style>

/*  <a> boton dentro_tabla prueba */ 
div.div_edit:hover {
  /*border: 1px solid lightblue;*/
    background-color: white;
    /*min-height: 50px;*/
}
div.div_edit {
  /*border: 1px solid lightblue;*/
    /*background-color: white;*/
    min-height: 50px;
}


.box_wiki{
    display: none;
    width: 100%;
}

a:hover + .box_wiki,.box_wiki:hover{
    display: block;
    /*position: relative;*/
    position: absolute;
    z-index: 100;
}

	
	
table {
    /*font-family: "Trebuchet MS", Arial, Helvetica, sans-serif;*/
    /*font-family: "Verdana", Arial, Helvetica, sans-serif;*/
    border-collapse: collapse;
    /* tamaño fuente tabla */
    /*font-size: 0.8vw;*/                          
    width: 100%;
}

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


<?php   /* tabla.php  muestra una tabla
       
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
*/

require_once("../include/funciones.php");
require_once("../include/funciones_js.php");

// DEBUG VARIABLES arrays
logs("Inicio tabla.php  sql: $sql") ;
isset($sql_T) ? logs("Inicio tabla.php  sql_T: $sql_T") : '' ;

$debug=$admin;
//$debug=1;


// FIN DEBUG


// INICIALIZACION DE VARIABLES 
$TABLE=''; 



$updates= isset($updates)? $updates :  [] ;    // si no existe $updates lo inicializo vacío para poder hacer llamadas sin que dé error
$no_updates= isset($no_updates)? $no_updates :  [] ;    // inicializamos $no_update[]
$visibles= isset($visibles) ? $visibles : [] ;  // $visibles es array con campos ID_ que queremos mostrar
$ocultos= isset($ocultos) ? $ocultos : [] ;  // $ocultos es array con campos ID_ que NO queremos mostrar
//$cols_chart= isset($cols_chart) ? $cols_chart : [] ;  // $ocultos es array con campos ID_ que NO queremos mostrar

$titulo= isset($titulo) ? $titulo : ( !isset($print_pdf)?  'tabla' : '' ) ;
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

//$TABLE .=  "<P class='noprint'>$titulo $add_link_html</P>" ; 

$cont=0;
//$idtabla="tabla_".rand() ;           // genero un idtabla aleatorio
//$idtabla="tabla" ;                   // DEBUG

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




//******************************************************** TOTALES **************************
$TR_totales="<tfoot>" ;
if (isset($result_T)  )   // Hay TOTALES?
  {   
	if ($result_T->num_rows > 0)
	{	  
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
                       //cc_format($formats[$clave], $valor , $format_style) ;
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
                   if ( !strpos($clave, '_FLAG') AND !strpos($clave, '_TOOLTIP') AND !strpos($clave, '_MODAL') AND !strpos($clave, '_FORMAT') AND !strpos($clave, '_COLOR') AND !strpos($clave, 'TH_COLOR')  )      // descartamos los encabezados de campos FORMATO CONDICIONAL _FORMAT
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
                   // evitamos las ETIQUETAS
                   if ( !strpos($clave, '_FLAG') AND !strpos($clave, '_TOOLTIP')AND !strpos($clave, '_MODAL') AND !strpos($clave, '_FORMAT') AND !strpos($clave, '_COLOR') AND !strpos($clave, 'TH_COLOR')  )      // descartamos los encabezados de campos FORMATO CONDICIONAL _FORMAT
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
                   if ( !strpos($clave, '_FLAG') AND !strpos($clave, '_TOOLTIP') AND !strpos($clave, '_MODAL') AND !strpos($clave, '_FORMAT') AND !strpos($clave, '_COLOR') AND !strpos($clave, 'TH_COLOR')  )      // descartamos los encabezados de campos FORMATO CONDICIONAL _FORMAT
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
  
//---------------------------------------------------- FIN TOTALES 3----------------------------
  $TR_totales .=  "</tfoot>";


  $id_subgrupo=0 ;                                          

 if ($result->num_rows > 0)
  { 

  //  ******************************************* BOTONES SOBRE TABLA   ****************

  if (!isset($print_pdf) AND $table_button)   // en las páginas para imprimir a PDF quitamos los botones
  {  
    $sql_encrypt= encrypt2($sql) ;
//    $titulo= isset($titulo) ? $titulo : 'tabla' ;
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
//    $titulo= isset($titulo) ? $titulo : '' ;
//    $tabla_expandible = 0 ;              // anulamos la tabla expandible
       
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
   
   // variable para el sistema de ETIQUETAS
   $script_name=$_SERVER["SCRIPT_NAME"] ;
   
   

   // EMPEZAMOS A RECORRER LA TABLA DE DATOS
   while($rst = $result->fetch_array(MYSQLI_ASSOC))               // 
   {
      $cont_TD++;      
      $cont_TR++;      
      
      
      
      
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
 
//               $is_visible si empieza por ID_ o es igual a ID
               $is_visible = ( (!preg_match("/^ID_|^ID$/i", $clave) OR in_array($clave,$visibles) ) AND ( !in_array($clave,$ocultos) ))  ; 
               
               $not_id_var= isset($print_id)?  $print_id : $is_visible  ;         // $print_id indica que se imprima los campos ID_ tambien
//               $class_hide_id= $not_id_var ? "" : "class='hide_id_$idtabla'" ;
               $class_hide_id= $not_id_var ? "" : "class='hide_id'" ;
               $hide_id= $not_id_var ? "" : "hide_id" ;
               
               // inicializamos variables
               

               // confirmamos que no es una _ETIQUETA auxiliar
               if ( !strpos($clave, '_FLAG') AND !strpos($clave, '_TOOLTIP') AND !strpos($clave, '_MODAL') AND !strpos($clave, '_FORMAT') AND !strpos($clave, '_COLOR') AND !strpos($clave, 'TH_COLOR')  )      // descartamos los encabezados de campos FORMATO CONDICIONAL _FORMAT
               { 
                   
                   //  ASIGNACION DE ETIQUETAS: POR CÓDIGO (sistema antiguo) por CLAVE_DB o por defecto
                   // solicitamos datos de CLAVES_DB
                   $claves_db = DRow("Claves", "clave='$clave' ", "(script_name='$script_name') DESC"  ) ;
                   $exist_clave_db = !(empty($claves_db)) ;                                              // si devuelve el array vacio, NO HAY CLAVE
                   $clave_db_heredada= isset($claves_db["script_name"])?  ($claves_db["script_name"]!=$script_name) : 0 ; // si no coinciden los PHP es clave HEREDADA

                   // Si hay clave_db NO ES HEREDADA y hay formato_db, lo ponemos en su array de formatos $formats[]
                   // SI QUEREMOS HEREDAR EL FORMATO HAY QUE HACERLO MANUALMENTE
                   if($exist_clave_db AND !$clave_db_heredada AND $claves_db["formato"]){ $formats[$clave]=$claves_db["formato"] ; }
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

                   
                  $TABLE .= "<th $class_hide_id $style_th_color   >"
                          . "<span style='cursor:pointer;' onclick=\"sortTable($c,'$idtabla',$c_sel)\" title='$tooltip_txt' >{$etiqueta_txt}</span>$div_tooltip_html</th>";                  
                  $c++ ;

                  // GOOGLE CHARTS  en pruebas 
                  // VARIABLES google chart
                  // definimos por defecto a COLS_STRING con la primera columnas VISIBLE y no oculta_chart
                  
                  // quitamos los booleanos , fechas y no visibles de columnas number si es $cols_number_automatico (datos)
                  $is_boolean= isset($formats[$clave])? (($formats[$clave]=='boolean') OR (substr($formats[$clave],0,8)=='semaforo'))  : 0 ;
                  $is_fecha =  isset($formats[$clave])? (substr($formats[$clave],0,5)=='fecha') : ($tipo_formato_por_clave=='fecha') ;
                  if ($cols_number_auto AND (  !$is_visible OR  $is_boolean OR $is_fecha ) )
                         {
                           $cols_number=array_diff($cols_number, [$clave]);  // sacamos esta columna de las cols automaticas de numeros
                         }
                      

                  
                  // calculamos quien puede ser la posible cols_string (LEYENDA del gráfico)
                  if (empty($cols_string) AND $is_visible AND !$is_boolean AND !in_array($clave,$chart_ocultos)) { $cols_string=[$clave] ; }
                  
                  
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
      // **********************   FIN ENCABEZADOS *************                              

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

      //************************** INICIAMOS FILA DE VALORES ************************
      $TABLE .= "<tr  id='TR_$cont_TR'>";
      
      // Columna de CHECKBOX DE SELECTION *****
      if (isset($col_sel)  ) {$TABLE .=  "<td class='noprint'><input type=\"checkbox\" id=\"{$rst[$col_sel]}\" value=\"{$rst[$col_sel]}\"></td>" ;  }       // Si hay columna de Selección añadimos una columna vacía a los TOTALES

      
      // inicializamos el array de tooltip de cada valor $vtooltips[]
      $vtooltips=[];
      $mtooltips=[];
 
       // GOOGLE CHARTS
       $json_rows_chart.=" $comma_rows { c : [ " ;
       $comma_rows_sec='' ;
//       $cols_count=1 ;
      
      // RECORREMOS LOS VALORES DE NUESTRA FILA
      $columna_ficha_html='';   // inicializamos la celda de la columna_ficha 
      foreach ($rst as $clave => $valor)  //  ******** VALORES ***************** VALORES ******************
       {
//          $TD_td =  "<td  class='class_$idtabla'  >" ;  // ponemos por defecto el <td>, luego podemos cambiarlo
          $TD_td =  "<td  >" ;  // ponemos por defecto el <td>, luego podemos cambiarlo

          $tipo_formato_por_clave=cc_formato_auto($clave);
          
          //deshacemos el guardado en HEX  por compatibilidad con el uso de HEX ya obsoleto desde 2019 donde se guardaban los texto en hexadecial para evitar problemas especial chars
           if(preg_match("/__HEX__/", $valor) ){ $valor = hex2bin ( preg_replace("/__HEX__/", "", $valor)) ; }
              
              
           $cont_TD++;  //contador de TD para su identificacion en javascript 

          // determinamos si es boolean
           $is_boolean= isset($formats[$clave])? (($formats[$clave]=='boolean') OR (substr($formats[$clave],0,8)=='semaforo'))  : 0 ;
           $is_text_edit = isset($formats[$clave])?  ( $formats[$clave]=='text_edit' ) : 0 ;  //campo textarea editable directamente       
           $is_div_edit  = isset($formats[$clave])?  ( $formats[$clave]=='div_edit' ) : 0 ;  //campo textarea editable directamente       
                   
           $is_text_moneda =  isset($formats[$clave]) ? (($formats[$clave])=='text_moneda') : 0 ;  //campo textarea editable directamente

//           $is_fecha = ((strtoupper(substr($clave,0,2))=="F_") OR (strtoupper(substr($clave,0,5))=="FECHA") OR ( isset($formats[$clave])? (substr($formats[$clave],0,5)=='fecha') : 0)) ;
           
           // es fecha si el formato es fecha o si los nombres
//           $is_fecha =  isset($formats[$clave])? (substr($formats[$clave],0,5)=='fecha') : ($tipo_formato_por_clave=='fecha') ;
           $is_fecha =  isset($formats[$clave])? (substr($formats[$clave],0,5)=='fecha') : ($tipo_formato_por_clave=='fecha') ;

           $is_update =  ( in_array($clave, $updates)  OR in_array("*", $updates) ) AND !(in_array($clave, $no_updates) )   ;  
           $is_select= (isset($selects[$clave])) ; 

           if ($is_doc_logo = ( $clave=='doc_logo'  )) 
           {
               logs("entramos a doc_logo");
               if ($valor) // si hay campo DOC_LOGO y su valor no es cero, calculamos el path_archivo del id_documento
               {             
                   $valor=Dfirst("path_archivo","Documentos"," id_documento=$valor ")  ;   //sustituimos el $valor por el path del archivo de id_documento = doc_logo
//                   $valor= ($valor==0) ? "" : $valor ; // para que no aparezca el CERO 
                  
               }else
               {
                   $valor= "../img/no_image.jpg"  ; // para que no aparezca el CERO 
               }
//               $formats[$clave]= "pdf_100_100" ; 
               logs("entramos a doc_logo valor1: $valor");
           }    


           // inicializamos codigo para doble click copiar a filtro'
           $dblclick_div=  '' ;
           $dblclick_ondblclick=  '' ;  //dblclick_ondblclick

           // subtotales cuando hay agrupación
           if (isset($array_sumas[$clave])) { $array_sumas[$clave]+= $valor ; }  // sumo los SUBTOTALES 

           // Gestión de CAMPOS ID_, ocultamos por defecto los campos ID_xxx y los ocultos y mostramos los visibles        
           $is_visible = ( (!preg_match("/^ID_|^ID$/i", $clave) OR in_array($clave,$visibles) OR in_array($clave,$updates) ) AND ( !in_array($clave,$ocultos) ))  ; 

           $not_id_var= isset($print_id)?  $print_id : $is_visible  ;         // $print_id indica que se imprima los campos ID_ tambien

           // Lo metemos en COLUMNAS OCULTAS POR SI SE QUIEREN MOSTRAR POR JAVASCRIPT
//           $class_hide_id= $not_id_var ? "" : "class='hide_id_$idtabla class_$idtabla'" ;     
           $class_hide_id= $not_id_var ? "" : "class='hide_id'" ;     
           $hide_id= $not_id_var ? "" : "hide_id" ;                 //class hide_id hace que se oculten las columnas hasta que pulsemos Show ID
          
           
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
                $cadena_link = $is_update  ?  "tabla=$tabla_update&wherecond=$id_update=".$rst["$id_update"]."&field=".$clave."&nuevo_valor=" :  ""; 

                
                //empezamos a PINTAR
                // PRIMERO COMPROBAMOS SI ES LINKABLE. SI ES LINKABLE NO ES EDITABLE (UPDATE)
                if (isset($links[$clave]))   //     ES LINKABLE.                 
                {          // hay link 
                //         
                               
//                                $href_link= $links[$clave][0] . $rst[$links[$clave][1]] ."&_m=$_m" ;            // FASE EXPERIMENTAL PARA EL MIGAS
                                $href_link= $links[$clave][0] . $rst[$links[$clave][1]]  ;    //anulado provisionalmente, juand, ene21 FASE EXPERIMENTAL PARA EL MIGAS
                                
                                 // creamos el div update_pencil_div por si el link fuera editable (update)
                                
                                 $update_pencil_div= ($is_update) ?   "<a class='btn btn-xs btn-link noprint transparente'  title='editar campo'   "
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
                                         $TD_td = "<td $class_hide_id   $format_style $dblclick_ondblclick >"  ;
                                         $TD_html = "$span_sort<span id='div$cont_TD'  ><a href='$href_link' title='$title' "
                                                 . " $link_target_blank>{$valor_txt_final}</a></span>{$update_pencil_div}{$div_extras_html}";        

                                     }elseif ($tipo_formato_link=='formato_sub_vacio')   // FORMATO TRADICIONAL DE SUBRRAYADO (es incompatible con sortTable (ordenar tabla)) pero son poner "ver"
                                     {
                                         $valor_txt_final=$valor_txt? $valor_txt : ''  ;  // evitamos que un valor vacio permita hacer el link
                                         
                                         $TD_td = "<td $class_hide_id   $format_style $dblclick_ondblclick >" ;
                                         $TD_html = "$span_sort<span id='div$cont_TD'  ><a href='$href_link' title='$title' "
                                                 . " $link_target_blank>{$valor_txt_final}</a></span>{$update_pencil_div}{$div_extras_html}";        

                                     }else              //if ($tipo_formato_link=='icon')     // FORMATO link principal
                                     {   
                                         $TD_td = "<td $class_hide_id  $format_style $dblclick_ondblclick   >" ;
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
                                    $TD_td = "<td $class_hide_id $format_style  ' >" ;
                                    $TD_html = "$span_sort<span style='$style_max_width_90 float:left;text-align:$format_align ' $dblclick_ondblclick  id='div$cont_TD'  >{$valor_txt}</span>"
                                                              . "{$update_pencil_div}{$link_div}{$div_extras_html}";


                                   }

               }        // $UPDATES={}. IMPRIMIMOS LAS -COLUMNAS EDITABLES veo que columnas son actualizables y compruebo que existan en el row
               elseif ( $is_update )   // IS_UPDATE, CELDA EDITABLE
               { 
                               // fabricamos la cadena_link
                               if ($is_boolean )  
                               {
                                 $checked= $valor ? 'checked' : '' ;
//                                 $valor_txt= $valor ? '1' : '0' ;
                                 $display= $valor ? 'display:inline;' : 'display:none;'  ;  //pintamos o no pitamos el check OK
                                 $background_color= ($formato_valor=='semaforo')?     ($valor ? "background-color:green;" : "background-color:red;" ) 
                                                  : (($formato_valor=='semaforo_not')? ( $valor ? "background-color:red;" : "background-color:green;")
                                                  : ( $valor ? "background-color:royalblue;" : "background-color:white;") )  ;
                                 

                                 $TD_html =   "<div style='cursor: pointer;text-align:center;$background_color' id='td_$cont_TD' value='$checked'   "
                                         .    "onclick=\"tabla_update_onchange('$cadena_link',document.getElementById('span_$cont_TD').style.display,'$tipo_dato','span_$cont_TD','td_$cont_TD' )\"  >"
                                         . "$span_sort"
                                         . "<p id='span_$cont_TD' style='$display' ><i class='fas fa-check'></i></p>"
                                       . "{$div_extras_html} </div>"  ;

//                                  $TD_html = "juan" ;

 

                               }elseif ($is_div_edit)  // FUTURO div_edit       $is_div_edit
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



                               }elseif ($is_text_edit) 
                               {                       // UPDATE TEXT_EDIT          TEXTAREA                                                                                   //// ****DEBUG 1***

                                   $TD_html = "<textarea class='textarea_tabla' rows='3' id='textarea1' name='textarea1' "
                                            . " onchange=\"tabla_update_onchange('$cadena_link',this.value )\"   >$valor</textarea>$div_extras_html" ;




                               }elseif ($is_text_moneda) 
                               {                       // UPDATE TEXT_EDIT                                                                                             //// ****DEBUG 1***

        
                                   $valor_txt = cc_format($valor, 'moneda') ;
                                   $TD_html =   "$span_sort"
                                            . "<textarea class='textarea_tabla' style='border:none; text-align:right; resize: none;' rows='1' cols='13' id='div$cont_TD' name='textarea1' onclick='this.select()' "
                                            . " onchange=\"tabla_update_onchange('$cadena_link',this.value,'num','div$cont_TD' )\"   >$valor_txt</textarea>$div_extras_html";




                               }elseif ($is_fecha) // campo FECHA  EDITABLE
                               {
                                     $fecha0=substr($valor,0,10) ;

                    //              $TABLE .=  $TD_etiqueta ;
                                   $TD_html = "$span_sort"
                                       . "<input type='date' id='datepicker2' value='$fecha0' "
                                       . " onchange=\"tabla_update_onchange('$cadena_link',this.value,'fecha' )\" > " ;                                                                    // hacemos el JAVASCRIPT para actualizar la FECHA

                               }elseif ( $is_select) // es SELECT, es decir, podemos seleccionarlo de una lista a buscar
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
                                  $link_nuevo_target_blank = preg_match("/^javascript/i", $link_nuevo) ? '' : "target='_blank'" ;

                                  // **PROVISIONAL*** a todos las busquedas de SELECT les añado el $where_id_c_coste
                                  $valor_txt_sel= ($valor<>"") ?  Dfirst($campo_mostrado,$tabla_select,"$campo_ID='$valor' $where_c_coste_txt ") : ""  ;   //evitamos un error en Dfirst si $valor es NULL              
                                  $valor_txt_sel= $valor_txt_sel ?  $valor_txt_sel : "";   // quitamos el valor 0

                                  // PROVISIONAL UNOS DÍAS HASTA VER QUÉ FICHAS REQUIEREN AÑADIR LOS SELECT AL UPDATES[]
                    //                if (!$is_update) { $valor_txt_sel = '¡¡ ATENCION!! AÑADIR EL SELECT AL UPDATES SI PROCEDE (juand)' ;}
                                  // LINK PARA VER LA ENTIDAD
                                  
                                  //debug
//                                  pre($rs);
                                  
                                  $add_link_select_ver = $link_ver ? "<a href='{$link_ver}{$rst[$id_campo]}&_m=$_m' target='_blank'>$valor_txt_sel</a>" : "$valor_txt_sel" ;

                                  if ($is_update)   // INCOHERENCIA, está dentro de un if ($is_update) ?? (lo mantengo por precaución, juand feb21)
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
                                          $cadena_select_enc= encrypt2( "href=$select_href&cadena_link_encode=$cadena_link_encode&tabla_select=$tabla_select&campo_ID=$campo_ID&campo_texto=$campo_texto&select_id=select_$cont_TD&filtro=") ;


                                          // sistema showInt   
                                          // PONEMOS EL INPUT
                                          $add_link_select_cambiar="<INPUT class='noprint' style='font-size: 70% ;font-style: italic ;' id='input_$cont_TD' size='7'  "
                                                  . "  onkeyup=\"tabla_update_select_showHint('$cadena_select_enc','$campo_texto','$valor_txt_sel','p$cont_TD','$otro_where' ,this.value)\" placeholder='buscar...' value=''  >" ;
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
                                                                  . " {tabla_update_select_showHint_ENTER('p$cont_TD');  }});"
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

                                  $TD_html = "$span_sort <span id='p_span_$cont_TD'>$add_link_select_ver $add_link_select_cambiar $add_link_select $add_link_select_valor_null $add_link_select_cambiar_div_sugerir</span>"
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
                                $TD_td = "<td $class_hide_id $format_style  ' >";
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

                               $TD_td = "<td $class_hide_id $format_style   >" ;
                               $TD_html =  "$span_sort<span style='$style_max_width_90 float:$format_align;text-align:$format_align ' $dblclick_ondblclick  id='div$cont_TD'  >{$valor_txt}</span>"
                                        . "{$div_extras_html}";
//                                $TABLE .= $TD_html ;        
                               
                              
                }  

                $TABLE.= $TD_td  . $TD_html . "</td>" ;
               
                $columna_ficha_html.= $is_visible? "<div><span style='float:left;color:silver;'>{$etiquetas["$clave"]}:&nbsp;&nbsp; </span>$TD_html</div>"   : "" ;
//                $columna_ficha_html.= $not_id_var? "<div>".$clave .":". $TD_html."</div>"   : "" ;

           }	//************* FIN DE PINTADO EL VALOR  VISIBLE               
       } //  ******** FIN DE FOREACH CLAVE -> VALOR
       

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
          $TABLE .= "<td colspan='$colspan' align='right'><b>SUBTOTAL</b></td>";
          foreach ($array_sumas as $clave => $valor)
              { $TABLE .= "<td align='right'><b>".cc_format($array_sumas[$clave], $formats[$clave])."</b></td>"  ; }
          $TABLE .= "</td></tr>";              
    }
   
  
  ////////////////////////
  
   $TABLE .= $TR_totales ;        // IMPRIMO <TR> DE TOTALES si no hay TOTALES es la cadena VACIA
  
   $TABLE .= "</tbody></table>";
   $TABLE .= "</div>";
   
   //  creamos el EXPAND  
   
//   if ($tabla_expandible)
//   {  
//      $table_collapse= $tabla_expandida ?  'collapse in' : 'collapse' ;
//      $TABLE =  "<div class='div_boton_expand'><button data-toggle='collapse' class='btn btn-default btn-block btn-lg' data-target='#div_exp$idtabla'>"
//                             . " $titulo </button></div>"
//                              . "<div id='div_exp$idtabla' class='$table_collapse'>" 
//                               .$add_link_html.$TABLE 
//                               ."</div>";
//    }
//    else
//    {
//        
//     $TABLE =  "<P class='noprint'>$titulo</P> $add_link_html" . $TABLE ;               // ponemos el título  a´principio
//  
//    }    

   
 }   /// **************************** FIN <DIV> Y <TABLE> **********************
  
  
 else 
 {      // consulta VACIA
//     $TABLE =  "<P class='noprint'>$titulo</P> $add_link_html" . $TABLE ;               // ponemos el título  a´principio
     $msg_tabla_vacia=isset($msg_tabla_vacia) ? $msg_tabla_vacia :'' ;
     $TABLE .=  "<p>$msg_tabla_vacia</p>" ;
     
 }

 // imprimimos
//    if ($tabla_expandible)
//   {  
//      $table_collapse= $tabla_expandida ?  'collapse in' : 'collapse' ;
//      $TABLE =  "<div class='div_boton_expand'><button data-toggle='collapse' class='btn btn-default btn-block btn-lg noprint' data-target='#div_exp$idtabla' style='text-align:left;'>"
//                             . " $titulo <div style='float:right;'></div></button></div>"
//                              . "<div id='div_exp$idtabla' class='$table_collapse'>"
//                              . "<div  class='only_print'><h4  style=' text-align: center;' >$titulo</h4></div>" 
//                               .$add_link_html.$TABLE .$tabla_footer
//                               ."</div>";
//    }
//    else
//    {
//        
////     $TABLE =  "<P class='noprint'>$titulo</P> $add_link_html" . $TABLE .$tabla_footer ;               // ponemos el título  a´principio
//     $TABLE =  "<P>$titulo</P> $add_link_html" . $TABLE .$tabla_footer ;               // ponemos el título  a´principio
//  
//    }    

    
  
$TABLE = <<<EOT
        
        
            <div class="card  $tabla_collapse">
              <div class="card-header border-0">

                <h2 class="card-title">
                  <button type="button" class="btn btn-tool btn-sm noprint" data-card-widget="collapse">
                    <i class="far fa-calendar-alt noprint"></i> $titulo
                  </button>
                </h2>
                <div class="card-tools">
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

//                   <!-- button with a dropdown -->
//                  <div class="btn-group">
//                    <button type="button" class="btn btn-tool btn-sm noprint dropdown-toggle" data-toggle="dropdown" data-offset="-52">
//                      <i class="fas fa-bars"></i></button>
//                  </div>

 
 
// echo $TABLE ;
//$TABLE .=  " </div>" ;

  // TERMINAMOS LA TABLA_DIV  
        
//echo "{ $json_cols_chart , $json_rows_chart } " ;        
        
?>
  
 <script>

$(document).ready(function(){
$('th.columna_ficha').hide() ;  // por defecto, ocultamos la COLUMNA_FICHA
$('td.columna_ficha').hide() ;

if (<?php echo $_SESSION["android"];?>) { show_FICHA_ON();}
//   $('#chart_button<?php // echo $idtabla; ?>').click();
//   console.log("LISTO!!");
});

function show_ID_<?php echo $idtabla;?>()
 { 
//     alert('<?php echo $idtabla;?>');
// $('table th.hide').each( function() { $(this).show() ; }   );
// $('table td.hide').each( function() { $(this).show() ; }   );
if ( typeof show_ID.show == 'undefined' ) {
        // It has not... perform the initialization
        show_ID.show = 1;
    }
 

if ( show_ID.show == 1) 
{   
 $('th.hide_id_<?php echo $idtabla;?>').show() ;
 $('td.hide_id_<?php echo $idtabla;?>').show() ;
 show_ID.show = 0 ;
 }
 else
{   
 $('th.hide_id_<?php echo $idtabla;?>').hide() ;
 $('td.hide_id_<?php echo $idtabla;?>').hide() ;
 show_ID.show = 1 ;
 }
     
//  alert(show_ID.show);
//   alert('hola') ;
 
 
  return ;
}
function show_ID()
 { 
// $('table th.hide').each( function() { $(this).show() ; }   );
// $('table td.hide').each( function() { $(this).show() ; }   );
if ( typeof show_ID.show == 'undefined' ) {
        // It has not... perform the initialization
        show_ID.show = 1;
    }
 

if ( show_ID.show == 1) 
{   
 $('th.hide_id').show() ;
 $('td.hide_id').show() ;
 show_ID.show = 0 ;
 }
 else
{   
 $('th.hide_id').hide() ;
 $('td.hide_id').hide() ;
 show_ID.show = 1 ;
 }
     
  return ;
}

function show_FICHA()
 { 
     
// $('table th.hide').each( function() { $(this).show() ; }   );
// $('table td.hide').each( function() { $(this).show() ; }   );
if ( typeof show_FICHA.show == 'undefined' ) {
        // It has not... perform the initialization
        show_FICHA.show = 1;
    }
 

if ( show_FICHA.show == 1) 
{   
 $('th').hide() ;   // quitamos todas
 $('td').hide() ;
 $('th.columna_ficha').show() ;         // ponemos solo las fichas
 $('td.columna_ficha').show() ;
 show_FICHA.show = 0 ;
 }
 else
{   
 $('th').show() ;   // ponemos todas
 $('td').show() ;   
 $('th.hide_id_<?php echo $idtabla;?>').hide() ;      // ocultamos las ocultas tipo ID
 $('td.hide_id_<?php echo $idtabla;?>').hide() ;
 $('th.columna_ficha').hide() ;  // quitamos las FICHA
 $('td.columna_ficha').hide() ;
 show_FICHA.show = 1 ;
 }
     
//  alert(show_ID.show);
//   alert('hola') ;
 
 
  return ;
}
function show_FICHA_ON()
 { 
     
 $('th.class_<?php echo $idtabla;?>').hide() ;   // quitamos todas
 $('td.class_<?php echo $idtabla;?>').hide() ;
 $('th.class_<?php echo $idtabla;?>columna_ficha').show() ;         // ponemos solo las fichas
 $('td.class_<?php echo $idtabla;?>columna_ficha').show() ;
 
  return ;
}


function tabla_update_onchange(cadena_link, nuevo_valor, tipo_dato , elementId , idlabel_chk ) {
   //valores por defecto
     tipo_dato = tipo_dato || 'str'; 
     elementId = elementId || '';
     idlabel_chk = idlabel_chk || '';
      
//    alert(cadena_link+nuevo_valor) ; 
 
var refrescar=false ;  // en principio NO REFRESCAMOS , salvo que se necesite

 
// if (tipo_dato=='semaforo' || tipo_dato=='semaforo_not' || tipo_dato=='boolean')
 if (tipo_dato=='boolean')
 {
//        nuevo_valor= nuevo_valor ? 1 : 0  ;
        nuevo_valor= (nuevo_valor=='none') ? 1 : 0  ; // CAMBIO EL VALOR
        
        var display = (nuevo_valor) ? 'inline' : 'none'  ; // si es valor es 1 (true) 
        document.getElementById(elementId).style.display = display ;
       
    //    alert(document.getElementById(idlabel_chk).style.backgroundColor ) ;          //style.backgroundColor = "red"
        if (document.getElementById(idlabel_chk).style.backgroundColor == 'red')        // si es rojo lo pasamos a verde y al reves
            {document.getElementById(idlabel_chk).style.backgroundColor='green' ;}  
            else if (document.getElementById(idlabel_chk).style.backgroundColor=='green')
            { document.getElementById(idlabel_chk).style.backgroundColor='red' ;}   
            else if (document.getElementById(idlabel_chk).style.backgroundColor=='royalblue')
            { document.getElementById(idlabel_chk).style.backgroundColor='white' ;}   
            else if (document.getElementById(idlabel_chk).style.backgroundColor=='white')
            { document.getElementById(idlabel_chk).style.backgroundColor='royalblue' ;}   
 }
 else if (tipo_dato=='num')
 {
//   nuevo_valor=dbNumero(nuevo_valor)  ;
//   alert(nuevo_valor) ;
 } 
 
 
//  cadena_link=encodeURIComponent(cadena_link) ;
nuevo_valor=encodeURIComponent(nuevo_valor) ;
//alert(nuevo_valor) ;

     var xhttp = new XMLHttpRequest();
     xhttp.onreadystatechange =
     function()
     {   if (this.readyState == 4 && this.status == 200)
         
         {    if (this.responseText.substr(0,5)=="ERROR")
               {
                   alert(this.responseText) ;
               }                   // mostramos el ERROR
               else
               {  
//                   alert(this.responseText) ;     //debug
                    if (elementId)
                    {
                      if (tipo_dato=='boolean'){
                          // repintamos el OK con el valor de la BD que ya hemos cambiado al inicio de la función
                        display = (this.responseText=='1') ? 'inline' : 'none'  ; // si es valor es 1 (true) 
                        document.getElementById(elementId).style.display = display ;
   
                      }else{
  //                        alert('dentro') ; 
                        document.getElementById(elementId).innerHTML = this.responseText ;
                        document.getElementById(elementId).value = this.responseText ;
                        }
                    }
                    if (refrescar)
                    {location.reload();
                    }                               // NO REFRESCOr la página (salvo  para comodidad del usuario 
                }  // refresco la pantalla tras edición
          }
      };

 xhttp.open("GET", "../include/update_ajax.php?"+cadena_link+nuevo_valor+"&tipo_dato="+tipo_dato, true); 
 xhttp.send();   
   
}


function tabla_update_str(cadena_link, prompt, valor0, idcont,nuevo_valor, tipo_dato) {
    
 // apaño provisional y chapucero para calcular formulas en num   
     nuevo_valor = nuevo_valor || '';
     tipo_dato = tipo_dato || '';
     var cadena_tipo_dato='' ;   
    if (tipo_dato) {cadena_tipo_dato="&tipo_dato="+tipo_dato ;} // si es campo numérico lo paso a formato dbNumero  ej: 1254.51

//cadena_tipo_dato="&tipo_dato=num" ;

//        alert(idcont) ;
////    document.getElementById(idcont).innerHTML = 'FEDERICO' ;
//    alert( document.getElementById(idcont).innerHTML  );

    var refrescar=false ;  // en principio NO REFRESCAMOS , salvo que se necesite
    
    var valor0Num=dbNumero(valor0) ;
    var esNumero=(!isNaN(valor0Num)) ;
    //alert(esNumero) ;
    if (esNumero) {valor0=valor0Num ;} // si es campo numérico lo paso a formato dbNumero  ej: 1254.51
    
//    var nuevo_valor=window.prompt("Nuevo valor de "+prompt , valor0);
    // el valor nuevo_valor es opcional, si no se pasa, se pregunta por él y se intenta NO REFRESCAR si todo va bien.
    if ( nuevo_valor === '' )
    {   
      nuevo_valor=window.prompt("Nuevo valor de "+prompt , valor0);
      refrescar=false ;  // NO REFRESCO la página para comodidad del usuario,comprobaré que el UPDATE ha sido exitoso por ajax.
    }   
   
    
    
//    alert("el nuevo valor es: "+valor) ;
   if (!(nuevo_valor === null))
   { 
//       if (esNumero) {nuevo_valor=dbNumero(nuevo_valor)  ;}        // vuelvo a dar formato dbNumero
         nuevo_valor=encodeURIComponent(nuevo_valor) ;

       var xhttp = new XMLHttpRequest();
     xhttp.onreadystatechange =
     function()
     {   if (this.readyState == 4 && this.status == 200)
         
         {    if (this.responseText.substr(0,5)=="ERROR")
               { alert(this.responseText) ;
               }                   // mostramos el ERROR
               else
               {  
//                   alert(this.responseText) ;     //debug
                 document.getElementById(idcont).innerHTML = this.responseText ;
                 if (refrescar)
                 {location.reload();
                 }                               // NO REFRESCOr la página (salvo  para comodidad del usuario 
               }  // refresco la pantalla tras edición
          }
      };
  xhttp.open("GET", "../include/update_ajax.php?"+cadena_link+nuevo_valor+cadena_tipo_dato, true);
  xhttp.send();   
   }
   else
   {return;}
   
}

//funciones para el SELECT
function tabla_update_select_showHint_ENTER(pcont) {

// hago click en el primer elemento de la lista 'li'
document.getElementById(pcont).getElementsByTagName("ul")[0].getElementsByTagName("li")[0].getElementsByTagName("a")[0].click() ;

}   


function tabla_update_select_showHint(cadena_select_enc, prompt, valor0, pcont, otro_where, str) {
//    var nuevo_valor=window.prompt("Filtre la búsqueda y seleccione en la lista el nuevo "+prompt , valor0);
    var nuevo_valor=str;
    
    if (str.length < 3) { 
      document.getElementById(pcont).innerHTML = "";
    return;
    }

    
//    alert("el nuevo valor es: "+valor) ;
         
     var xhttp = new XMLHttpRequest();
     xhttp.onreadystatechange = function() {
    if (this.readyState == 4 && this.status == 200) {
        if (this.responseText.substr(0,5)=="ERROR")
        { alert(this.responseText) ;}                    // hay un error y lo muestro en pantalla
        else
        {   
//            alert(this.responseText) ;                                // debug
//            document.getElementById("sugerir").innerHTML = this.responseText;
            document.getElementById(pcont).innerHTML = this.responseText ; }  // "pinto" en el <div> el select options
//  
      }
  };
  
  xhttp.open("GET", "../include/select_ajax_showhint.php?tipo_pagina=tabla&url_enc="+cadena_select_enc+"&url_raw="+encodeURIComponent( nuevo_valor+"&otro_where="+otro_where) , true);
  xhttp.send();   
 
}   

//function onClickAjax(id_obra, nombre_obra) {
////alert(val);
////document.getElementById("obra").value = val;
//window.location="obras_ficha.php?id_obra="+id_obra+"&nombre_obra="+nombre_obra;
//
////$("#txtHint").hide();
//}
function tabla_select_onchange_showHint(id,cadena_link,href) {
 
    
    // valores por defecto    
 href = href || ""     ;        // por defecto no hay msg

       nuevo_valor=id ;      // es el id_valor seleccionado
       //       
       var xhttp = new XMLHttpRequest();
     xhttp.onreadystatechange = function() {
    if (this.readyState == 4 && this.status == 200) {
        
        if (this.responseText.substr(0,5)=="ERROR")
        { alert(this.responseText) ;}                   // mostramos el ERROR
        else
        {  
            
            if (href)  {js_href(href,1) ; }   // si hay algún href lo ejecutamos al terminar el UPDATE y refrescamos
            location.reload(true); }  // refresco la pantalla tras edición
       
      }
   };
   xhttp.open("GET", "../include/update_ajax.php?"+cadena_link+nuevo_valor, true);
   xhttp.send();   
   
}  

// FIN  SELECT  SHOHINT *************




function tabla_down_font_size(idtabla) {
    $( idtabla ).css( "font-size", "-=3" );
//    $( ".tabla2" ).css( "font-size", "-=3" );
}

function tabla_up_font_size(idtabla) {
    $( idtabla ).css( "font-size", "+=3" );
//    $( "table" ).css( "font-size", "+=3" );
}


//$( "#up" ).on( "click", function() {
//
//  // parse font size, if less than 50 increase font size
////  D1 if ((size + 2) <= 50) {
//   $( "table" ).css( "font-size", "+=3" );
////  d2  $( "th" ).css( "font-size", "+=3" );
////  d2  $( "td" ).css( "font-size", "+=3" );
//// D1   $( "#font-size" ).text(  size += 3 );
//// D1   }
//});
//
//$( "#down" ).on( "click", function() {
//// D1 if ((size - 2) >= 8) {
//    $( "table" ).css( "font-size", "-=3" );
////     $( "th" ).css( "font-size", "-=3" );
////    $( "td" ).css( "font-size", "-=3" );
////// D1   $( "#font-size" ).text(  size -= 3  );
//// D1 }
//});
////  ---------------- FIN FONT-SIZE -------------
//  
//  
//  
//  
    // seleccion automatica de toda la tabla  
    function selectElementContents(el) {
        var body = document.body, range, sel;
        if (document.createRange && window.getSelection)
        {
            range = document.createRange();
            sel = window.getSelection();
            sel.removeAllRanges();
            try {
                range.selectNodeContents(el);
                sel.addRange(range);
            } catch (e) {
                range.selectNode(el);
                sel.addRange(range);
            }
            document.execCommand("copy");   //copiamos al portapapeles toda la selección
        } else if (body.createTextRange) 
        {
//            alert("debug") ;
            range = body.createTextRange();
            range.moveToElementText(el);
            range.select();
            range.execCommand("Copy");
        }
    }


// ANTIGUA FUNCION EXPORT_XLS , HOY FELIZMENTE ELIMINADA POR EXPORT_XLS.PHP DE FABRICACION PROPIA, juand, ene19     
//// function tabletoXLS(idtabla)
//// {
//////     var table_html = document.getElementById(idtabla).html() ;
////     window.open('data:application/vnd.ms-excel,' + table_html);
////      //window.open('data:application/csv,charset=utf-8,' +  $('#dvData').html());
////      e.preventDefault();   
////     
//     
//  $(document).ready(function() {
//$("#btnexport").click(function(e) {
//
//    var a = document.createElement('a');
//    //getting data from our div that contains the HTML table
//    var data_type = 'data:application/vnd.ms-excel';
////    var data_type = 'data:application/csv,charset=utf-8';
//    var table_div = document.getElementById('div3');
//    var table_html = table_div.outerHTML.replace(/ /g, '%20');
////    var n=(table_html.indexOf("JUAN"))+4 ;
////    var n=(table_html.indexOf(String.fromCharCode(8204))) ;
////    alert((n)) ;
////    alert(table_html.charCodeAt(n)) ;
//// 
//    var table_html = table_html.replace(/€/g, '');
////    var table_html = table_html.replace(/\u200C/g, "");  // quito characters limitador 
////    var table_html = table_html.replace(/'&zwnj;'/g, "Z");
//
////    alert(table_html.charCodeAt(n)) ;
////    alert(table_html.charAt(n)) ;
//    a.href = data_type + ', ' + table_html;
//    //setting the file name
//    a.download = 'download.xls';
//    //triggering the function
//    a.click();
//    //just in case, prevent default behaviour
//    e.preventDefault();
//});
//});
// 
     
     
     
     
   
   
   
     
function dblclick_col(e,input_id) {
  
//   alert(input_id) ;
//   alert($(e).prop('id')) ;
//   alert(typeof e) ;

var str = (typeof e === 'object') ? $(e).text() : e ;

//alert(str) ;

str = (str.match( /\d{4}-\d{2}-\d{2}/ ) ) ? str.substr(0,10) : str ;    //  si es FECHA solo cogemos el DATE, los prmeros 10 char

 if (input_id.indexOf("*"))                              // comprobamos si es del estiolo FECHA1 y FECHA2  (FECHA*)
 {
   document.getElementById(input_id.replace('*','1')).value=str ; 
   document.getElementById(input_id.replace('*','2')).value=str ; 
//   document.getElementById(input_id.replace('*','1')).value="2019-11-08" ; 
//   document.getElementById(input_id.replace('*','2')).value="2019-11-09" ; 
 }else
 {
  document.getElementById(input_id).value=str ;
//  document.getElementById("FECHA2").value="2019-11-08" ;
 }
 
// document.getElementById("form1").submit();
}

function sortTable(n, idtabla, c_sel) {
  var tfoot, table, rows, switching, i, x, y, shouldSwitch, dir, switchcount = 0;
  table = document.getElementById(idtabla);
//  alert( n +'-'+idtabla+'-'+c_sel) ;
  switching = true;
  // Set the sorting direction to ascending:
  dir = "asc"; 
  /* Make a loop that will continue until
  no switching has been done: */
  
 // alert('entro a ordenar. switching='+switching)  ;

  
  
 rows = table.getElementsByTagName("TR");
 tfoot= table.getElementsByTagName("TFOOT")[0].getElementsByTagName("TR");   //COMPROBAMOS SI HAY ÚLTIMA ROWS tfoot (TOTALES)
  
// alert(tfoot.length)       ;
 
  while (switching)
  {
     // alert('entro al while')  ;
     
    // Start by saying: no switching is done:
    switching = false;
//    rows = table.getElementsByTagName("TR");
//   ANULAMOS EL CAMBIO DE ICONO EN CABECEROS POR CONSUMIR MUCHOS RECURSOS (juand, ene19)
//    // control de cabeceros y flechas de Sort (juand, marzo-18)
//    //alert(rows[0].getElementsByTagName("TH")[n].innerHTML) ;             //DEBUG
////    var th=rows[0].getElementsByTagName("TH") ;  // COJO EL ARRAY DE CABECEROS TH
//    //alert(th.length)  ;
//    for (i = 0; i <= (th.length - 1 ); i++) 
//    {  // les quito a todos los cabeceros TH las flechas
//        //alert(th[i].innerHTML) ;      //debug
//        th[i].innerHTML = th[i].innerHTML.replace("▲","") ;  
//        th[i].innerHTML = th[i].innerHTML.replace("▼","") ;
////        th[i].innerHTML = th[i].innerHTML + "<span class='glyphicon glyphicon-resize-vertical'></span>" ;
//    }
//    if ( dir == "asc")       // pongo la flecha correspondiente al cabecero que ordenamos
//       {th[n-c_sel].innerHTML = th[n-c_sel].innerHTML + "▲"  ;}
//      else
//       {th[n-c_sel].innerHTML = th[n-c_sel].innerHTML + "▼"  ;}
//      // fin ANULACION control cabeceros  , juand ene19
    
    /* Loop through all table rows (except the
    first, which contains table headers): */
//    tfoot= table.getElementsByTagName("TFOOT");   //COMPROBAMOS SI HAY ÚLTIMA ROWS tfoot (TOTALES)
    //alert(tfoot.length) ;
    for (i = 1; i < (rows.length - 1 -tfoot.length ); i++)   //recorremos todas las filas menos las de totales que están al final
//    for (i = 1; i < (rows.length - 3); i++)   //recorremos todas las filas menos las de totales que están al final
    { 
          // alert('entro al for')  ;

          // Start by saying there should be no switching:
          shouldSwitch = false;
          /* Get the two elements you want to compare,
          one from current row and one from the next: */

          // alert('i + 1 ='+(i+1)); 

          x =  rows[i].getElementsByTagName("TD")[n] ;
          y =  rows[i + 1].getElementsByTagName("TD")[n] ;

          // alert('valor de y.innerHTML.toLowerCase() ='+y.innerHTML.toLowerCase()); 

    //      x = rows[i].getElementsByTagName("TD")[n].getElementById("valor_sort");
    //      y = rows[i + 1].getElementsByTagName("TD")[n].getElementById("valor_sort");


          /* Check if the two rows should switch place,
          based on the direction, asc or desc: */
          if (dir == "asc")
          {
                // alert('entro al if ASC i=')  ;

                    if (x.innerHTML.toLowerCase() > y.innerHTML.toLowerCase())
                    {
                      // If so, mark as a switch and break the loop:
                      shouldSwitch= true;
                     // alert('voy a hacer break')  ;
                      break;
                    }

          } else if (dir == "desc")
          {
                // alert('entro al if DESC')  ;

                    if (x.innerHTML.toLowerCase() < y.innerHTML.toLowerCase())
                    {
                      // If so, mark as a switch and break the loop:
                      shouldSwitch= true;
                      // alert('voy a hacer break en desc')  ;
                      break;
                    }
          }
          // alert('fin bucle for')  ;

    }
    // alert('salgo del for '+shouldSwitch)  ;

    if (shouldSwitch)
    {
      /* If a switch has been marked, make the switch
      and mark that a switch has been done: */
      rows[i].parentNode.insertBefore(rows[i + 1], rows[i]);
      switching = true;
      // Each time a switch is done, increase this count by 1:
      switchcount ++; 
      // alert('hago cambio filas')  ;
      
    } else
    {
          /* If no switching has been done AND the direction is "asc",
          set the direction to "desc" and run the while loop again. */
          // alert('intento cambiar orden')  ;

          if (switchcount == 0 && dir == "asc") 
          {
                // alert('cambio orden a DESC DESC DESC')  ;
                dir = "desc";
                switching = true;
          }
    }
  }

}





function tabla_delete_row(cadena_link, id , confirm) {
    //valores por defecto
     id = id || '';
     confirm = confirm || '1';
   
    
    if (confirm=='1')                 // variable que permite no confirmar y borrar diectamente la fila
    {   var nuevo_valor=window.confirm("¿Borrar fila? "); }
   else {  var nuevo_valor=1; }
   
//    alert("el nuevo valor es: "+valor) ;
   if (!(nuevo_valor === null) && nuevo_valor)
   { 
       
       var xhttp = new XMLHttpRequest();
     xhttp.onreadystatechange = function() {
    if (this.readyState == 4 && this.status == 200) {
        if (this.responseText.substr(0,5)=="ERROR")
        { alert(this.responseText) ;}                   // mostramos el ERROR
        else
        {  //alert(this.responseText) ;     //debug
          // si existe TR es que vamos a ocultar la fila TR sin refrescar , en otro caso, refrescamos
          if (id!='') {    $("#" + id).toggle('fast')  ;     }     // ocultamos la TR de forma transitoria
          else  {  location.reload(true); }
        }   
       
      }
  };
  xhttp.open("GET", "../include/delete_row_ajax.php?url_enc="+cadena_link, true);
  xhttp.send();   
   }
   else
   {return;}
   
}


 function table_selection()
 { var array_str="" ;
 $('table input:checkbox:checked').each(
    function() {
        
        if (!(array_str=="" )) array_str+= "-" ;
        if ($(this).val()!=0) array_str+= $(this).val() ;
        //alert("El checkbox con valor " + $(this).val() + " está seleccionado");
    }
  );
  
//   alert(array_str) ;
 
 
  return array_str;
}

function ver_table_selection()
 { var array_str="" ;
 $('table input:checkbox:checked').each(
    function() {
        
        if (!(array_str=="" )) array_str+= "-" ;
        array_str+= $(this).val() ;
        //alert("El checkbox con valor " + $(this).val() + " está seleccionado");
    }
  );
  
   alert(array_str) ;
 
 
  return array_str;
}



function table_selection_IN()
 { var array_str="(" ;
 $('table input:checkbox:checked').each(
    function() {
        
        if (!(array_str=="(" )) array_str+= "," ;   // meto el separador
        array_str+= "'" + $(this).val() + "'"  ;
        //alert("El checkbox con valor " + $(this).val() + " está seleccionado");
    }
  );
  
  array_str+= ")"  ;
//   alert(array_str) ;
 
 
  return array_str;
}

function selection_todoF(idtabla)
 { 
// var valor = document.getElementById("selection_todo").checked;

//alert("select todo");


// $('.table2 input:checkbox').each(
 $( '#' + idtabla + ' input:checkbox').each(
    function() {
         $(this)[0].checked = document.getElementById("selection_todo").checked ;
//        alert("El checkbox con valor " + $(this).val() + " está seleccionado");
    }
  );
   
  return ;
}

 
 
</script>

<!--GRAFICOS--> 

<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>

<script type="text/javascript">

  // GRAFICOS   Load the Visualization API and the corechart package.
  google.charts.load('current', {'packages':['corechart']});

  // Set a callback to run when the Google Visualization API is loaded.
//  google.charts.setOnLoadCallback(drawChart);

  // Callback that creates and populates a data table,
  // instantiates the pie chart, passes in the data and
  // draws it.
  
//var data = new google.visualization.DataTable();

//    var options = {'title':'Gráfico',
//                   'width':2000,
//                   'height':1200};

  var data<?php echo $idtabla; ?>;
  var options<?php echo $idtabla; ?>;
  var chart<?php echo $idtabla; ?>;

  function drawChart<?php echo $idtabla; ?>() {

    // Create the data table.
//     data = new google.visualization.DataTable();
//    data.addColumn('string', 'Año');
//    data.addColumn('number', 'Facturacion');
//    data.addRows([
//      ['Setas', 3],
//      ['Onions', 1],
//      ['Aceitunas', 1],
//      ['Zucchini', 1],
//    ]);


 
// var data = new google.visualization.DataTable(
//   {
//     cols: [
//            {id: 'task', label: 'Employee Name', type: 'string'},
//            {id: 'startDate', label: 'Start Date', type: 'number'},
//            {id: 'linea2', label: 'linea2', type: 'number'}
//           ],
//     rows: [
//            { c: [  {v: 'Mike' }, {v: 15, f: 'etiqueta' }, {v: 15, f: 'etiqueta' }  ]    },
//            { c: [  {v: 'Bob'  }, {v: 14 }, {v: 14 }    ] },
//            { c: [  {v: 'Alice'}, {v: 18 }, {v: 38 }    ] },
//            { c: [  {v: 'Frank'}, {v: 25 }, {v: 15 }    ] },
//            { c: [  {v: 'Floyd'}, {v: 10 }, {v: 16 }    ] },
//            { c: [  {v: 'Fritz'}, {v: 30 }, {v: 40 }    ] } 
//           ]
//   }
//) 
//  
     data<?php echo $idtabla; ?> = new google.visualization.DataTable(  <?php echo "{ $json_cols_chart , $json_rows_chart } " ; ?> ) ;
  
  

    // Set chart options
     options<?php echo $idtabla; ?> = {'title':'<?php echo $titulo; ?>',
                   'width':800,
                   'height':400 ,
                   seriesType: 'bars'
                   <?php echo $serie_line_txt; ?>  };
//
    // Instantiate and draw our chart, passing in some options.
//    var chart = new google.visualization.PieChart(document.getElementById('chart_div'));
//    var chart = new google.visualization.BarChart(document.getElementById('chart_div'));
//     chart = new google.visualization.LineChart(document.getElementById('chart_div<?php echo $idtabla; ?>'));
//    chart<?php echo $idtabla; ?> = new google.visualization.ColumnChart(document.getElementById('chart_div<?php echo $idtabla; ?>'));
    chart<?php echo $idtabla; ?> = new google.visualization.ComboChart(document.getElementById('chart_div<?php echo $idtabla; ?>'));
    chart<?php echo $idtabla; ?>.draw(data<?php echo $idtabla; ?>, options<?php echo $idtabla; ?>);
  }
  
function boton_chart<?php echo $idtabla; ?>() {
    
//     data.addRows([
//      ['PSOE', 3],
//      ['IU', 1],
//      ['VOX', 1],
//      ['PODEMOS', 1],
//      ['UPYD', 4]
//    ]);

   //dataResponse is your Datatable with A,B,C,D columns        
var view<?php echo $idtabla; ?> = new google.visualization.DataView(data<?php echo $idtabla; ?>);
view<?php echo $idtabla; ?>.setColumns( JSON.parse( "["+ document.getElementById('view_setColumns<?php echo $idtabla; ?>').value + "]" ) ); //here you set the columns you want to display
//view.setColumns([ 0,1  ]); //here you set the columns you want to display

//Visualization Go draw!
//visualizationPlot.draw(view, options);
chart<?php echo $idtabla; ?>.draw(view<?php echo $idtabla; ?>, options<?php echo $idtabla; ?>);
//alert(document.getElementById('view_setColumns').value);  

}
  
  
  
//   PARA PODER OCULTAR COLUMNAS CON CHECKBOX
//   var hideSal = document.getElementById("hideSales");
//   hideSal.onclick = function()
//   {
//      view = new google.visualization.DataView(data);
//      view.hideColumns([1]); 
//      chart.draw(view, options);
//   }
//   var hideExp = document.getElementById("hideExpenses");
//   hideExp.onclick = function()
//   {
//      view = new google.visualization.DataView(data);
//      view.hideColumns([2]); 
//      chart.draw(view, options);
//   }

  
</script>
<?php
  // INICIALIZAMOS TODAS LAS VARIABLES Y ARRAYS DE TABLA.PHP PARA EVITAR INTERFERENCIAS CON NUEVAS REQUERY EN EL MISMO PHP.
   
      //  $result=$Conn->query("SELECT id_aval , Motivo, Importe from Avales WHERE ID_OBRA=".$id_obra );
unset( $tabla_style, $tabla_footer,$add_link_html, $add_link, $result_T, $rs_T,$result_T2, $rs_T2,$result_T3, $rs_T3, $tabla_expandida,$tabla_expandible, $tabla_update, $id_update,$col_sel,$array_sumas,$valign,$colspan,$col_subtotal,$print_id, 
        $titulo, $msg_tabla_vacia,  $add_link,  $links, $formats, $format_style, $tooltips, $actions_row,
        $updates,$dblclicks ,$id_agrupamiento, $buttons ,$cols_string,$cols_number,$chart_ON,$ocultos,$cols_line) ;


?>

 <!--SISTEMA DATATABLE DE BUSQUEDA Y PAGINACION-->
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/dt/dt-1.10.16/datatables.min.css"/>
<!--<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">-->
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/v/dt/dt-1.10.16/datatables.min.js"></script>



<!--<script>
    $(document).ready(function() {
        $('#<?php echo $idtabla; ?>').DataTable();            // ANULADO PROVISIONALMENTE el sistema de busqueda y paginación
    } );
</script> -->
 <!--FIN SISTEMA DATATABLE DE BUSQUEDA Y PAGINACION-->
