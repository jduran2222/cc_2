<style>

/*  <a> boton dentro_tabla prueba */ 

a.dentro_tabla {
    
  background: #eee; 
  color: grey; 
  /*display: inline-block;*/
  height: 20px;
  line-height: 20px;
  padding: 0 5px 0 5px;
  position: relative;
  margin: 0 5px 5px 0;
  text-decoration: none;
  -webkit-transition: color 0.2s;
  font-size: 7px ;
}
a.dentro_tabla_ppal {
    
  background: #eee; 
  color: blue; 
  /*display: inline-block;*/
  /*height: 20px;*/
  /*line-height: 20px;*/
  padding: 0 5px 0 5px;
  position: relative;
  margin: 0 5px 5px 0;
  text-decoration: none;
  /*-webkit-transition: color 0.2s;*/
  font-size: 7px ;
}


/*
a.dentro_tabla:hover {
  background-color: lightblue;
  color: white;
}*/
   
/* INICIO TOOLTIPS  */
 table th a {
    border-bottom: 1px dotted #aaa;
    color: #333;
    position: relative;
    text-decoration: none;
    border-bottom: 1px dotted white;
	
}
 
table th a:hover:before,
table th a:hover:after,
table th a:active:before,
table th a:active:after {
    opacity: 1;
}
 
table th a:before,
table th a:after {
    opacity: 0;
    pointer-events: none;
    position: absolute;
    transition: all 200ms ease-in;
}
 
table th a:before {
    background-color: #eee; 
    border-radius: 3px;
    bottom: 100%;
    content: attr(title);
    font-size: 18px;
    left: 100%;
    padding: .5em 1em;
    white-space: nowrap;
}
 
table th a:after {
    border: 5px solid;
    border-color: #eee transparent transparent #eee;
    content: '';
    left: calc(100% + 3px);
    top: -3px;
    transform: rotate(20deg);
}
	
	
	
/* FIN TOOLTIPS  */
	
	
	
	
table {
    font-family: "Trebuchet MS", Arial, Helvetica, sans-serif;
    border-collapse: collapse;
    /* tamaño fuente tabla */
    font-size: 1.0vw;                          
    width: 100%;
}

table td, table th {
 
     border: 1px solid #ddd;
    padding: 3px;
    /*height: 20px;*/
}


	
table   tr:nth-child(odd) {
    background-color:#f2f2f2;
}
table   tr:nth-child(even) {
    background-color:#ffffff;
}
 
 table  tr:hover {background-color: #ddd;}



table th {
    cursor: pointer;
    padding-top: 6px;
    padding-bottom: 6px;
   /* text-align: left; */
    background-color: lightskyblue;
    color: white;
    
 }
@media only screen and (max-width:980px) {
  /* For mobile phones: antes 500px */
   table {
    font-size: 1.8vw; 
  }
  option {
   font-size: 4.2vw;   
  /*transform: scale(2);*/  
}
  
}

@media print{
    
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
   
   .glyphicon {
       display:none;
   }
   .dentro_tabla_ppal {
       display:none;
   }
   .dentro_tabla {
       display:none;
   }
   
   thead {
            display:table-header-group;
            margin-bottom:2px;
             /*padding-top: 500px ;*/
            
/*            top:8cm;*/
        }
   table td {
            border : none ;
            font-size: 8pt ;
            font-family:arial;
        }
/*   table   {
      margin-top:8cm;
      margin-bottom:8cm;
       padding-top: 500px ;
        }*/
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
        $format (moneda, fijo, porcentaje, fecha, dbfecha, boolean...)
 *      $format_style
        $tooltips
        $actions_row  -> acciones a nivel row (edit, delete ,onclick1_link...)   
 *      $updates    -> array de campos que se pueden actualizar online (ajax)
 *      $actions_row["onclick1_link"]   permite añadir un boton al final con acción de onclick, usa tambien $rs["$id_update_onclick1"]
 *      $dblclicks["CAPITULO"] = ["CAPITULO", 'literal']   columnas que copian el valor al filtro
        $id_agrupamiento En tablas con SUBGRUPOS agrupamiento, variable que indica qué campo agrupará  Ej. ID_CLIENTE.  (VER tbla_group.php)
*/

require_once("../include/funciones.php");
 require_once("../include/funciones_js.php");

     $_SESSION["zz"]= 1000 ;
 
// DEBUG VARIABLES arrays


if (0)        // DEBUG
{   
 echo "<pre>" ;       
// print_r($tabla_subgrupo);  
 echo "\$add_link".var_dump($add_link)."<br>";
echo "\$links".var_dump($links)."<br>";
echo "\$format".var_dump($format)."<br>";
echo "\$aligns".var_dump($aligns)."<br>";
echo "\$tooltips".var_dump($tooltips)."<br>";
echo "\$actions_row".var_dump($actions_row)."<br>";
echo "\$updates".var_dump($updates)."<br>";
echo "\$dblclicks".var_dump($dblclicks)."<br>";
echo "\$id_agrupamiento".var_dump($id_agrupamiento)."<br>";
 echo "</pre>" ;       
}


// FIN DEBUG


 

if (!isset($updates)) {$updates=[] ;}                  // si no existe $updates lo inicializo vacío para poder hacer llamadas sin que dé error

$titulo=isset($titulo) ? $titulo : "" ;

$add_link_html= (isset($add_link)) ? "<a class='btn btn-warning noprint' href='#' onclick=\"tabla_add_row( '{$tabla_update}' , '{$add_link['field_parent']}', '{$add_link['id_parent']}'  ) ;\"  ><i class='fas fa-plus-circle'></i> añadir fila</a> " : "" ;
echo  "<P class='noprint'>$titulo $add_link_html</P>" ; 
//if (isset($dblclicks)) {echo "<h6 class='noprint'>Doble click copia a filtro</h6>" ; }
$cont=0;
$idtabla="tabla_".rand() ;           // genero un idtabla aleatorio
//$idtabla="tabla" ;                   // DEBUG

//******************************************************** TOTALES **************************
$tr_totales="" ;
if (isset($result_T)  )   // Hay TOTALES?
  {   
	if ($result_T->num_rows > 0)
	{	  
        //echo "<tfoot><tr>";
          $tr_totales .= "<tr>" ;  
          if (isset($col_sel)  ) {$tr_totales .= "<td class='noprint'></td>" ;  }       // Si hay columna de Selección añadimos una columna vacía a los TOTALES
              
	    while ( $rs_T = $result_T->fetch_array(MYSQLI_ASSOC) )              // ROW único de TOTALES	
	  {
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
		   
                  // $align.=" style='background-color: coral' ;" ;
//		   $tr_totales .=  "<td {$format_style} style='border-top: 1px solid #C00; font-style: italic; font-weight: bold; '>{$valor}</td>"; 			
		   $tr_totales .=  "<td {$format_style} >{$valor}</td>"; 			
		   //echo "<th style='text-align:right;' >{$valor}</th>"; 		
		 }
                  if (isset($actions_row)) { $tr_totales .=  "<td></td>"; }
	  }  
	   $tr_totales .=  "</tr>";
//           echo $tr_totales ;
	 }		
  }
  if (isset($result_T2)  )   // ----- TOTALES 2  ----------
  {   
	if ($result_T2->num_rows > 0)
	{	  
        //echo "<tfoot><tr>";
          $tr_totales .= "<tr>" ;  
          if (isset($col_sel)  ) {$tr_totales .= "<td class='noprint'></td>" ;  }       // Si hay columna de Selección añadimos una columna vacía a los TOTALES
          
	    while ( $rs_T2 = $result_T2->fetch_array(MYSQLI_ASSOC) )              // ROW único de TOTALES	
	  {
	     foreach ($rs_T2 as $clave => $valor)               //  VALORES de los TOTALES
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
		   
                  // $align.=" style='background-color: coral' ;" ;
		   $tr_totales .=  "<td {$format_style} style='font-style: italic; font-weight: bold '>{$valor}</td>"; 			
		   //echo "<th style='text-align:right;' >{$valor}</th>"; 		
		 }
                  if (isset($actions_row)) { $tr_totales .=  "<td></td>"; }
	  }  
	   $tr_totales .=  "</tr>";
//           echo $tr_totales ;
	 }		
  }
   if (isset($result_T3)  )   // ----- TOTALES 3  ----------
  {   
	if ($result_T3->num_rows > 0)
	{	  
        //echo "<tfoot><tr>";
          $tr_totales .= "<tr>" ;  
          if (isset($col_sel)  ) {$tr_totales .= "<td class='noprint'></td>" ;  }       // Si hay columna de Selección añadimos una columna vacía a los TOTALES
          
	    while ( $rs_T3 = $result_T3->fetch_array(MYSQLI_ASSOC) )              // ROW único de TOTALES	
	  {
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
		   
                  // $align.=" style='background-color: coral' ;" ;
		   $tr_totales .=  "<td {$format_style} style='font-style: italic; font-weight: bold '>{$valor}</td>"; 			
		   //echo "<th style='text-align:right;' >{$valor}</th>"; 		
		 }
                  if (isset($actions_row)) { $tr_totales .=  "<td></td>"; }
	  }  
	   $tr_totales .=  "</tr>";
//           echo $tr_totales ;
	 }		
  }
//---------------------------------------------------- FIN TOTALES ----------------------------




//if (isset($result_S))       // Hay subgrupos DESPLEGABLES a anidar, creamos el ARRAY de ANIDACION
// {
//  $tabla_subgrupo = $result_S->fetch_all(MYSQLI_ASSOC); 
//                                     
//  foreach($tabla_subgrupo as $x => $x_value)
//  {
//   $tabla_subgrupo2[array_values($x_value)[0]]=$x_value ;        // El primer valor de la fila ahora será también la clave del nuevo array $tabla_subgrupo2
//   }
//  
////     print_r($tabla_subgrupo);  // debug
////     echo "*****************" ;
////     print_r($tabla_subgrupo2);      
////   
// }   


  $id_subgrupo=0 ;                                          

 if ($result->num_rows > 0)
  { 

  //  ******************** BOTONES SOBRE TABLA   ****************

  if (!isset($print_pdf))   // en las páginas para imprimir a PDF quitamos los botones
  {  
//echo "<input type='button' id=\"btnexport\" onclick=\"tabletoXLS($idtabla)\" value=\" Export Table data into Excel \" />";  
     
    echo "<button type='button' class='btn btn-link btn-xs noprint'  id=\"btnexport\" >Exportar xls</button>";  
    echo "<button type='button' class='btn btn-link btn-xs noprint'  onclick=selectElementContents(document.getElementById('$idtabla'))  >copy</button>";
   
//        BOTONOS AUMENTO DISMINUCIÓN TAMAÑO FUENTE        
//    echo "<p id='font-size'></p>" ;
//    echo "<button type='button' class='btn btn-default btn-sm' id='down'><i class='fas fa-search-minus'></i></button>" ;
//     echo "<button type='button' class='btn btn-default btn-sm' id='up'><i class='fas fa-search-plus'></i></button>" ;
//     
   echo "<button type='button' class='btn btn-link btn-xs noprint' onclick=tabla_down_font_size(document.getElementById('$idtabla'))><i class='fas fa-search-minus'></i></button>" ;
   echo "<button type='button' class='btn btn-link btn-xs noprint' onclick=tabla_up_font_size(document.getElementById('$idtabla'))  ><i class='fas fa-search-plus'></i></button>" ;
     
   //  BOTON SELECTION
   if (isset($col_sel)) {echo "<button type='button' class='btn btn-link btn-xs noprint' onclick=ver_table_selection()  >seleccion</button>" ;  }  

   if ($_SESSION["admin"]) {echo "<button type='button' class='btn btn-link btn-xs noprint' onclick=show_ID()  >show ID</button>" ;  }  
   
   // BOTONES DEFINIDOS POR USUARIO
   if (isset($buttons)) 
   {   foreach ($buttons as $value)
       {
          echo $value ; 
       }
   }
	  
  }  
    
//   echo "<div id='div3' >";      //debug  <div class='table-responsive'>   
   echo "<div id='div3' class='container-fluid' >";     
	
  
//   echo "<div><table  id=\"$idtabla\" class='table2' >";
   echo "<div  class='row'>";
   
   $colum=0 ;
    
   $is_subtotal=isset($col_subtotal) ;
   
   while($rs = $result->fetch_array(MYSQLI_ASSOC))               // tabla de valores
   {
          $colum++ ;
          
          if ($colum==600)
              {
               $colum=0 ;
               echo "</div><div class='row'>";       // salto de fila de cuadros .row
          }
          
	  if ($cont==0)   // --------------- ENCABEZADOS ------------------------
	  {
           $cont= mt_rand (1,1000000)  ;       // inicializamos el contador con rand() para evitar que se solapen los TD y otros elementos           
           if ($is_subtotal) { $subtotal=$rs[$col_subtotal]   ;}           
//	   echo "<thead><tr>";
           $c=0 ;
           $c_sel=0;
           if (isset($col_sel)  )
               {
//               echo  "<th class='noprint'><input onclick=\"selection_todo('$idtabla');\" type=\"checkbox\" id=\"selection_todo\" value=\"0\"></td>" ;  $c++ ;$c_sel=1;
               }       // Si hay columna de Selección añadimos una columna vacía a los TOTALES
	   
           foreach ($rs as $clave => $valor) //  encabezados
           {
		   $not_id_var= isset($print_id)?  $print_id : (strtoupper(substr($clave,0,2))<>"ID") ;         // $print_id indica que se imprima los campos ID_ tambien
                   $class_hide_id= $not_id_var ? "" : "class='hide_id'" ;
                   $hide_id= $not_id_var ? "" : "hide_id" ;
                  
        	    if (isset($tooltips[$clave]))  //¿este campo tiene tooltip? 
		      { 
                      }
		      else
		      {
                       $c++ ;
		      }
		   
           }
         
	  }
          $cont++ ;
          
//          $div_size_height=$div_size*1.5 ;
          echo "<div class='col-xs-12 col-sm-4 col-md-3' style='height:$div_size_height ; width:$div_size_width ; border: 1px solid grey; float:left' onmouseover='this.style.zIndex=10;' onmouseout='this.style.zIndex=0;'  ;' >" ;         // cambio <tr> por <div>
          


	  
	  foreach ($rs as $clave => $valor)  //  ************************* VALORES ******************
            { 
                
//                if (isset($array_sumas[$clave])) { $array_sumas[$clave]+= $valor ; }  // sumo los SUBTOTALES 
                   
		   $not_id_var= isset($print_id)?  $print_id : (strtoupper(substr($clave,0,2))<>"ID") ;         // $print_id indica que se imprima los campos ID_ tambien
                   $class_hide_id= $not_id_var ? "" : "class='hide_id'" ;
                   $hide_id= $not_id_var ? "" : "hide_id" ;
                   
               if ($not_id_var)
               {   $format_style="" ;                                 //inicializo la align del TD
		   if (isset($formats[$clave]))                                                                      // determinamos los FORMAT y los ALIGN por defecto a esos format
		   { 
                       $valor=cc_format( $valor, $formats[$clave],$format_style) ;
		   }    // determinamos las FORMAT
                   else { // "intuimos" si es fecha
//                       if ((strtoupper(substr($clave,0,2))=="F_") or (strtoupper(substr($clave,0,5))=="FECHA"))
//                       { $valor=cc_format( $valor, 'fecha',$format_style) ; }         
                       $valor=cc_format( $valor, 'auto', $format_style,$clave ) ;    // no hay format predefinido, lo hacemos automaticamente según el nombre del campo '$clave'       
                   }
		   if (isset($aligns[$clave])) { $format_style=" style='text-align:{$aligns[$clave]} ; ' " ; }     // $aligns[] si se ha especificado una ALIGN la determino
                   
                   // $UPDATES={} -COLUMNAS EDITABLES veo que columnas son actualizables y compruebo que existan en el row
//                   if ((in_array($clave, $updates) AND isset($rs["$id_update"])) OR (in_array("*", $updates) )) 
                   if (in_array($clave, $updates)  OR in_array("*", $updates) )          // comprobamos si el campo es editable o si todos son editables
                       { 
                         $cadena_link="tabla=$tabla_update&wherecond=$id_update=".$rs["$id_update"]."&field=".$clave."&nuevo_valor="; 
                         $update_onclick="<a class='dentro_tabla' title='editar' href=# onclick=\"tabla_update_str('$cadena_link','$clave','$valor')\" ><i class='fas fa-pencil-alt'></i></a> ";
                         }
                       else
                       {$update_onclick="" ;}  
                       
                   // $dblclicks[] para copiar el valor al filtro    
                   $dblclick_text="" ;
                   if (isset($dblclicks[$clave]))
                       { $dblclick_text="ondblclick=\"dblclick_col(this, '{$dblclicks[$clave][0]}','{$dblclicks[$clave][1]}' )\" "  ;
                         //$dblclick_text="ondblclick=\"dblclick_col(1,2,3 )\" "  ;
                       
                       } 
                  
                   // $LINKS -> hacemos el link <a href...> a la entidad. Ponemos el character &zwnj para delimitar texto y link    
                   //    intercalo el character   &#8204;       para delimitar el valor del campo con los links
		   if (isset($links[$clave]))                                 
                      { // hay link 
                                // title del link  por defecto 'ver ficha'
                         $title=(isset($links[$clave][2]))? "{$links[$clave][2]}": "ver ficha" ;
                         
                         if (isset($links[$clave][3]))
                         { 
                             // hay formato especial de link
                             if ($links[$clave][3]=='formato_sub')   // FORMATO TRADICIONAL DE SUBRRAYADO (es incompatible con sortTable (ordenar tabla))
                             { 
//                                 echo "<td  $format_style $dblclick_text ><a  href= {$links[$clave][0]}{$rs[$links[$clave][1]]} title='$title' target='_blank'>{$valor}</a>{$update_onclick}</td>";        
                                 echo "<div  $format_style $dblclick_text ><a  href= {$links[$clave][0]}{$rs[$links[$clave][1]]} title='$title' target='_blank'>{$valor}</a>{$update_onclick}</div>";        

                             }elseif ($links[$clave][3]=='ppal')     // FORMATO link principal
                             {  
                                 $format_style= ($format_style=='') ? 'style=cursor:pointer;' : str_replace('style=' ,'style=cursor:pointer;',$format_style) ;
                                 
//                                 echo "<td $format_style $dblclick_text  onclick=\"document.getElementById('a$cont').click()\" >{$valor}&#8204;"
//                                    . "<a id='a$cont' class='noprint' href=\"{$links[$clave][0]}{$rs[$links[$clave][1]]}\"     title='$title' target='_blank'></a>{$update_onclick}</td>";  }
                                 echo "<div $format_style $dblclick_text  onclick=\"document.getElementById('a$cont').click()\" >{$valor}&#8204;"
                                    . "<a id='a$cont' class='noprint' href=\"{$links[$clave][0]}{$rs[$links[$clave][1]]}\"     title='$title' target='_blank'></a>{$update_onclick}</div>";  }
                       
                         }    
                         else
                         { // NO HAY formato especial de link. Ponemos el link por defecto   
//                             echo "<td $format_style $dblclick_text >{$valor}&#8204;<a class='dentro_tabla noprint' href='{$links[$clave][0]}{$rs[$links[$clave][1]]}'     title='$title' target='_blank'><span class='glyphicon glyphicon-new-window noprint'></span></a>{$update_onclick}</td>"; 
                             echo "<div $format_style $dblclick_text >{$valor}&#8204;<a class='dentro_tabla noprint' href='{$links[$clave][0]}{$rs[$links[$clave][1]]}'     title='$title' target='_blank'><span class='glyphicon glyphicon-new-window noprint'></span></a>{$update_onclick}</div>"; 
                         }
                             
                     }
		     else  
		     { // no hay links
//                        echo "<td $class_hide_id $format_style $dblclick_text>{$valor}&#8204;{$update_onclick}</td>";
                        echo "<div $class_hide_id $format_style $dblclick_text>{$valor}&#8204;{$update_onclick}</div>";
                      }  

  
                           
               }                      
        } 
           // ACCION ROW botones de acciones en ULTIMA COLUMNA que compenten a toda la fila (edit, delete...)
           if (isset($actions_row["id"]))                          
                     {
                      $id_link=$rs[$actions_row["id"]] ;
//                      echo "<td align='center'>" ;
                      echo "<div align='center'>" ;
                       if (isset($actions_row["update_link"])) { echo "<a class='dentro_tabla noprint' href=\"{$actions_row["update_link"]}{$id_link}\"><i class='fas fa-pencil-alt'></i></a> ";  }
                       if (isset($actions_row["delete_link"])) 
                           {
                           $cadena_link="tabla=$tabla_update&wherecond=$id_update=".$rs["$id_update"] ; 
                           echo "<a class='btn btn-danger btn-xs noprint' href=# onclick=\"tabla_delete_row('$cadena_link')\"  title='eliminar fila'><i class='far fa-trash-alt'></i></a> "; 
                           }
                       if (isset($actions_row["onclick1_link"]))     // está activado el boton onclick1
                           {
                          
                           //sustituimos en la cadena $actions_row["onclick1_link"] la _VARIABLE1_ por su valor en cada row de $rs["$id_update_onclick1"] 
                           $cadena_onclick=str_replace("_VARIABLE1_",$rs["$onclick1_VARIABLE1_"],$actions_row["onclick1_link"]);
                           if (isset($onclick1_VARIABLE2_)) { $cadena_onclick=str_replace("_VARIABLE2_",$rs["$onclick1_VARIABLE2_"],$cadena_onclick);}   // si hy _VAR2_ la sustituimos
                           echo $cadena_onclick ;
                           }    
//                      echo "</td>";
                      echo "</div>";
                      }
//	echo "</tr>";	  
	echo "</div>";	  
  }
  // imprimimos el último SUBTOTAL
   if ($is_subtotal)
    {   
                  echo "<tr>" ;
                  if (isset($col_sel)  ) {echo  "<td class='noprint'></td>" ;  }                  //si hay col_sel añadimos su hueco
                  echo "<td colspan='$colspan' align='right'><b>SUBTOTAL</b></td>";
                  foreach ($array_sumas as $clave => $valor)
                      { echo "<td align='right'><b>".cc_format($array_sumas[$clave], $formats[$clave])."</b></td>"  ; }
                  echo "</td></tr>";

//                  $subtotal=$rs[$col_subtotal] ;
//                  echo "<tr><td colspan='7'><b><big>$subtotal</big></b></td></tr>";
//                  foreach ($array_sumas as $clave => $valor) { $array_sumas[$clave] = 0 ; }       // inicializo los SUBTOTALES suma
               
    }
   
  
  ////////////////////////
  
 //   echo "</tbody></table>";
  echo "</div>";
   echo "</div>";
    echo "</div>";
   
  if (isset($result_T)  )   // Hay TOTALES?
  {   
	if ($result_T->num_rows > 0)
	{	  

        echo "<br><br><br><br><br><br><table style='width: 50%; border: 1px solid black'>$tr_totales</table><br><br><br>" ;

	 }		
  }	
  
   
  }
 else 
 { 
     $msg_tabla_vacia=isset($msg_tabla_vacia) ? $msg_tabla_vacia :'' ;
     echo  "<p>$msg_tabla_vacia</p>" ;
     
 }

  // INICIALIZAMOS TODAS LAS VARIABLES Y ARRAYS DE TABLA.PHP PARA EVITAR INTERFERENCIAS CON NUEVAS REQUERY EN EL MISMO PHP.
   
      //  $result=$Conn->query("SELECT id_aval , Motivo, Importe from Avales WHERE ID_OBRA=".$id_obra );
        unset( $col_sel,$array_sumas,$valign,$colspan,$col_subtotal,$print_id, $titulo, $msg_tabla_vacia,  $add_link,  $links, $format, $format_style, $tooltips, $actions_row, $updates,$dblclicks ,$id_agrupamiento, $buttons ) ;

//echo  " </div>" ;

  // TERMINAMOS LA TABLA_DIV
?> 	
 <script>
     
     //  ---------------- TABLE FONT-SIZE -------------
//function getSize() {
//  size = $( "td" ).css( "font-size" );
//  size = parseInt(size, 10);
//  $( "#font-size" ).text(  size  );
//}
//
////get inital font size
//getSize();
//
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


     
// function tabletoXLS(idtabla)
// {
////     var table_html = document.getElementById(idtabla).html() ;
//     window.open('data:application/vnd.ms-excel,' + table_html);
//      //window.open('data:application/csv,charset=utf-8,' +  $('#dvData').html());
//      e.preventDefault();   
//     
     
  $(document).ready(function() {
$("#btnexport").click(function(e) {

    var a = document.createElement('a');
    //getting data from our div that contains the HTML table
    var data_type = 'data:application/vnd.ms-excel';
//    var data_type = 'data:application/csv,charset=utf-8';
    var table_div = document.getElementById('div3');
    var table_html = table_div.outerHTML.replace(/ /g, '%20');
//    var n=(table_html.indexOf("JUAN"))+4 ;
//    var n=(table_html.indexOf(String.fromCharCode(8204))) ;
//    alert((n)) ;
//    alert(table_html.charCodeAt(n)) ;
// 
    var table_html = table_html.replace(/€/g, '');
    var table_html = table_html.replace(/\u200C/g, "");  // quito characters limitador 
//    var table_html = table_html.replace(/'&zwnj;'/g, "Z");

//    alert(table_html.charCodeAt(n)) ;
//    alert(table_html.charAt(n)) ;
    a.href = data_type + ', ' + table_html;
    //setting the file name
    a.download = 'download.xls';
    //triggering the function
    a.click();
    //just in case, prevent default behaviour
    e.preventDefault();
});
});
 
     
     
     
     
     
function dblclick_col(e,input_id, tipo_copia) {
  
   //$(e).text('there');
  //var input = document.getElementById(input_id);
   
  // localizo caracter &zwnj; invisible para no copiar los <a href>
  //alert($(e).text().indexOf("\u200C")) ;
  
  var pos=$(e).text().indexOf("\u200C") ;   //localizamos caracter de marca invisible
//  copio al input (filtro) el valor del <TD> hasta la marca invisible
  document.getElementById(input_id).value=$(e).text().substring(0,pos) ;
 // input.innerHTML="juan" ;
  //alert($(e).text()) ;
  //alert(document.getElementById(input_id).value) ;  
}


function sortTable(n, idtabla, c_sel) {
  var tfoot, table, rows, switching, i, x, y, shouldSwitch, dir, switchcount = 0;
  table = document.getElementById(idtabla);
  //alert(idtabla) ;
  switching = true;
  // Set the sorting direction to ascending:
  dir = "asc"; 
  /* Make a loop that will continue until
  no switching has been done: */
  
        
        
  while (switching) {
    // Start by saying: no switching is done:
    switching = false;
    rows = table.getElementsByTagName("TR");
  
    // control de cabeceros y flechas de Sort (juand, marzo-18)
    //alert(rows[0].getElementsByTagName("TH")[n].innerHTML) ;             //DEBUG
    var th=rows[0].getElementsByTagName("TH") ;  // COJO EL ARRAY DE CABECEROS TH
    //alert(th.length)  ;
    for (i = 0; i <= (th.length - 1 ); i++) {  // les quito a todos los cabeceros TH las flechas
        //alert(th[i].innerHTML) ;      //debug
        th[i].innerHTML = th[i].innerHTML.replace("▲","") ;  
        th[i].innerHTML = th[i].innerHTML.replace("▼","") ;
//        th[i].innerHTML = th[i].innerHTML + "<span class='glyphicon glyphicon-resize-vertical'></span>" ;
    }
    if ( dir == "asc")       // pongo la flecha correspondiente al cabecero que ordenamos
       {th[n-c_sel].innerHTML = th[n-c_sel].innerHTML + "▲"  ;}
      else
       {th[n-c_sel].innerHTML = th[n-c_sel].innerHTML + "▼"  ;}
    //       fin control cabeceros
    
    /* Loop through all table rows (except the
    first, which contains table headers): */
    tfoot= table.getElementsByTagName("TFOOT");   //COMPROBAMOS SI HAY ÚLTIMA ROWS tfoot (TOTALES)
    //alert(tfoot.length) ;
    for (i = 1; i < (rows.length - 1 -tfoot.length); i++) {
      // Start by saying there should be no switching:
      shouldSwitch = false;
      /* Get the two elements you want to compare,
      one from current row and one from the next: */
      x = rows[i].getElementsByTagName("TD")[n];
      y = rows[i + 1].getElementsByTagName("TD")[n];
      /* Check if the two rows should switch place,
      based on the direction, asc or desc: */
      if (dir == "asc") {
        //alert(x.innerHTML.toLowerCase()) ;  
        if (x.innerHTML.toLowerCase() > y.innerHTML.toLowerCase()) {
          // If so, mark as a switch and break the loop:
          shouldSwitch= true;
          break;
        }
      } else if (dir == "desc") {
        if (x.innerHTML.toLowerCase() < y.innerHTML.toLowerCase()) {
          // If so, mark as a switch and break the loop:
          shouldSwitch= true;
          break;
        }
      }
    }
    if (shouldSwitch) {
      /* If a switch has been marked, make the switch
      and mark that a switch has been done: */
      rows[i].parentNode.insertBefore(rows[i + 1], rows[i]);
      switching = true;
      // Each time a switch is done, increase this count by 1:
      switchcount ++; 
    } else {
      /* If no switching has been done AND the direction is "asc",
      set the direction to "desc" and run the while loop again. */
      if (switchcount == 0 && dir == "asc") {
        dir = "desc";
        switching = true;
      }
    }
  }
}

function update_col_prueba(cadena_link, prompt, valor0) {
  alert('juan') ;
}


function tabla_update_str(cadena_link, prompt, valor0) {

//        alert('juan') ;
    
    var valor0Num=dbNumero(valor0) ;
    var esNumero=(!isNaN(valor0Num)) ;
    //alert(esNumero) ;
    if (esNumero) {valor0=valor0Num ;} // si es campo numérico lo paso a formato dbNumero  ej: 1254.51
    
    var nuevo_valor=window.prompt("Nuevo valor de "+prompt , valor0);
//    alert("el nuevo valor es: "+valor) ;
   if (!(nuevo_valor === null))
   { 
       if (esNumero) {nuevo_valor=dbNumero(nuevo_valor)  ;}        // vuelvo a dar formato dbNumero
       
       var xhttp = new XMLHttpRequest();
     xhttp.onreadystatechange = function() {
    if (this.readyState == 4 && this.status == 200) {
        if (this.responseText.substr(0,5)=="ERROR")
        { alert(this.responseText) ;}                   // mostramos el ERROR
        else
        {  //alert(this.responseText) ;     //debug
            location.reload(true); }  // refresco la pantalla tras edición
        }
  };
  xhttp.open("GET", "../include/update_ajax.php?"+cadena_link+nuevo_valor, true);
  xhttp.send();   
   }
   else
   {return;}
   
}
function tabla_delete_row(cadena_link) {
    var nuevo_valor=window.confirm("¿Borrar fila? ");
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
           location.reload(true); 
        }  // refresco la pantalla tras edición
      }
  };
  xhttp.open("GET", "../include/delete_row_ajax.php?"+cadena_link, true);
  xhttp.send();   
   }
   else
   {return;}
   
}

function tabla_add_row(tabla,field_parent,id_parent) {
    
    //var valor0 = valor0_encode;
    //var valor0 = JSON.parse(valor0_encode);
   // var nuevo_valor=window.prompt("Nuevo valor de "+prompt , valor0);
//    alert("el nuevo valor es: "+valor) ;
//   alert('debug') ;
//   var id_personal=document.getElementById("id_personal").value ;
   var sql="INSERT INTO "+tabla+" ("+ field_parent+ ") VALUES ('" + id_parent + "')"    ;   
//   alert(sql) ;
    var xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function() {
    if (this.readyState == 4 && this.status == 200) {
        if (this.responseText.substr(0,5)=="ERROR")
        { alert(this.responseText) ;}                                        // hay un error y lo muestro en pantalla
        else
        { //document.getElementById(pcont).innerHTML = this.responseText ;   // "pinto" en la pantalla el campo devuelto por la BBDD tras el Update
//            alert(this.responseText) ;   //debug
              location.reload(true);  // refresco la pantalla tras edición
        }
      //document.getElementById("sugerir_obra").innerHTML = this.responseText;
      
    }
    }
     xhttp.open("GET", "../include/insert_ajax.php?sql="+sql, true);
     xhttp.send();   
    
    
    return ;
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
     
//  alert(show_ID.show);
//   alert('hola') ;
 
 
  return ;
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

function selection_todo(idtabla)
 { 
// var valor = document.getElementById("selection_todo").checked;
    
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