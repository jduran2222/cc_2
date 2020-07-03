<style>
	
	
a.dentro_tabla {
    
  /*background: #eee;*/ 
  color: grey; 
  display: inline-block;
  /*height: 20px;*/
  /*line-height: 20px;*/
  padding: 0 5px 0 5px;
  position: relative;
  margin: 0 5px 5px 0;
  text-decoration: none;
  /*-webkit-transition: color 0.2s;*/
  font-size: 7px ;
}                
                
.tabla_ficha2, select {
    font-family: "Trebuchet MS", Arial, Helvetica, sans-serif;
    border-collapse: collapse;
	 font-size: 1.8vw; 
    /* width: 100%; */
	  width: 100%;
}

.tabla_ficha2 td {
    border: 1px solid #ddd;
    padding: 8px;
    font-size: 15px;
}


 .tabla_ficha2  tr:hover {background-color: #ddd;}
 .tabla_ficha2   tr {
    background-color:#ffffff;
}
 

@media only screen and (max-width:980px) {
  /* For mobile phones: antes 500px */
   .tabla_ficha2 {
    font-size: 2.2vw; 
  }
 } 
  
/*        * PENDIENTE DE BORRAR SI NO HAY PROBLEMAS.  juand, 24-abril-2018
 ***********************INICIO TOOLTIPS     ficha.php  
 #tabla_ficha th  {
    border-bottom: 1px dotted #aaa;
    color: #333;
    position: relative;
    text-decoration: none;
    border-bottom: 1px dotted white;
	
}
 
#tabla_ficha th :hover:before,
#tabla_ficha th :hover:after,
#tabla_ficha th :active:before,
#tabla_ficha th :active:after {
    opacity: 1;
}
 
#tabla_ficha th :before,
#tabla_ficha th :after {
    opacity: 0;
    pointer-events: none;
    position: absolute;
    transition: all 200ms ease-in;
}
 
#tabla_ficha th :before {
    background-color: #eee;
    border-radius: 3px;
    bottom: 100%;
    content: attr(title);
    font-size: 20px;
    left: 100%;
    padding: .5em 1em;
    white-space: nowrap;
}
 
#tabla_ficha th :after {
    border: 5px solid;
    border-color: #eee transparent transparent #eee;
    content: '';
    left: calc(100% + 3px);
    top: -3px;
    transform: rotate(20deg);
}
	
	
	
 FIN TOOLTIPS  
	
	
	
	
#tabla_ficha, select {
    font-family: "Trebuchet MS", Arial, Helvetica, sans-serif;
    border-collapse: collapse;
	 font-size: 1.8vw; 
     width: 100%; 
	  width: 100%;
}

#tabla_ficha td, #tabla_ficha th {
    border: 1px solid #ddd;
    padding: 8px;
}


	
#tabla_ficha   tr:nth-child(odd) {
    background-color:#f2f2f2;
}
#tabla_ficha   tr:nth-child(even) {
    background-color:#ffffff;
}
 
 #tabla_ficha  tr:hover {background-color: #ddd;}



#tabla_ficha th {
    padding-top: 12px;
    padding-bottom: 12px;
    text-align: left;
    background-color: #4CAF50;
    color: white;
 }
@media only screen and (max-width:980px) {
   For mobile phones: antes 500px 
   #tabla_ficha {
    font-size: 2.2vw; 
  }*/

	
</style>


<?php   /* ficha.php  muestra los campos de un único registro en forma de tabla
       
		require a incluir en .PHP 
		<?php require("../include/ficha.php");?>
		
		 Variables a definir previamente al require:
		
        $result=$Conn->query("SELECT * from TABLA WHERE ID_ficha=".$id_ficha );
        $titulo="AVALES";
        $msg_tabla_vacia="No hay avales";
 *      $visibles=[  campos id a mostrar  ]

*/

      // INICIO FICHA.PHP-->
      
?>

<?php    // BOTONES TAMAÑO FONT-SIZE
  $html_ficha = '' ;
  $html_ficha .= "<p align='center'><h1>$titulo    " ;
  
if (!isset($print_pdf))  
{   
  $html_ficha .= "<input type='button'  class='btn btn-success btn-lg' value='actualizar' onclick='javascript:window.location.reload();'/>" ;
  
 if (isset($delete_boton ))
 {
   if ($delete_boton )
   {
     $cadena_link="tabla=$tabla_update&wherecond=$id_update=".$rs["$id_update"] ; 
//     $html_ficha .= "<a class='dentro_tabla' href=# onclick=\"tabla_delete_row('$cadena_link')\">borrar</a> "; 
   
//     $html_ficha .= "<input type='button'  class='btn btn-danger btn-lg' value='eliminar' onclick=\"tabla_delete_row('$cadena_link')\"/>" ;
     $html_ficha .= "<a class='btn btn-danger' href=# onclick=\"ficha_delete('$cadena_link', '$titulo')\"><i class='far fa-trash-alt'></i></a> "; 
     
   }  
 }
 
 // por defecto ponemos el boton_cerrar salvo que indiquemos que no lo queremos con $boton_cerrar=0
 $boton_cerrar=isset($boton_cerrar )? $boton_cerrar : "1" ;
         
 if ($boton_cerrar)   {$html_ficha .= "<input type='button'  class='btn btn-warning btn-lg' value='cerrar ventana' onclick=\"window.close()\"/>" ;}
 
} 
  $html_ficha .= "</h1></p>" ;

  
  $idtabla="tabla_".rand() ;           // genero un idtabla aleatorio
  
  $html_ficha .= "<button type='button' class='btn btn-default btn-sm' onclick=ficha_down_font_size(document.getElementById('$idtabla'))><i class='fas fa-search-minus'></i></button>" ;
  $html_ficha .= "<button type='button' class='btn btn-default btn-sm' onclick=ficha_up_font_size(document.getElementById('$idtabla'))  ><i class='fas fa-search-plus'></i></button>" ;

  $html_ficha .= "<table  id='$idtabla' class='tabla_ficha2' >" ;
  
    
   
   if ($result->num_rows > 0)
   {
       $cont=0 ;
       $id_info="" ; 
//       $visibles= isset($visibles) ? $visibles : [] ;  // $visibles es array con campos ID_ que queremos mostrar
       $format_style='';
    foreach ($rs as $clave => $valor)
     {
      
        $cont++ ;
       $is_select= (isset($selects[$clave])) ; 
       $not_id_var= (strtoupper(substr($clave,0,3))<>"ID_" OR in_array($clave,$visibles) ) ;    // comprobamos si es ID_ para ocultarlo o si está excluido de ocultarlo
       $is_URL = (strtoupper(substr($clave,0,4))=="URL_") ;
       if ($is_fecha =((strtoupper(substr($clave,0,2))=="F_") or (strtoupper(substr($clave,0,5))=="FECHA"))) 
       {
           $valor_encode=$valor ;
           if (!isset($formats[$clave])) $valor=cc_format( $valor, 'fecha2',$format_style) ;  // formateamos las fechas si no tinen formato propio
       }
       else {
           $valor_encode=str_replace("\r\n"," ",$valor) ;           // sustituyo los saltos de línea por espacios para que funcione el 'prompt' del javascript         
       }
       $url_link = ($is_URL)? "<a class='dentro_tabla' href='$valor' target='_blank' >ver</a>"  : ""  ;
 
       
       if ($not_id_var)                                     // descartamos los valores de campos ID_
       { 
           
        // creamos cadena para el update   
        //$cadena_link="tabla=FACTURAS_PROV&wherecond=id_fra_prov=".$id_fra_prov."&field=".$clave."&nuevo_valor=";
        $cadena_link="tabla=$tabla_update&wherecond=$id_update=".$id_valor."&field=".$clave."&nuevo_valor=";     
        
       $format_style="" ;                                 //inicializo la align del TD
      if (isset($formats[$clave]))                              // FORMATEAMOS EL VALOR
        { 
                //cc_format($formats[$clave], $valor , $format_style) ;
               $valor=cc_format( $valor, $formats[$clave], $format_style) ;
        }   		  
        else
        {  $valor=cc_format( $valor, 'auto', $format_style,$clave ) ;    // no hay format predefinido, lo hacemos automaticamente según el nombre del campo '$clave'       
        }
        
        $html_ficha .= "<tr>" ;


        // ***** Inicio impresión del nombre del campo , su valor y sus links *********
        if (isset($links[$clave]))      // consulto si el campo es un link
         { 
          $html_ficha .=  "<td ALIGN=left><p>$clave:</p></td>" ;
          $html_ficha .= "<td   ><p id='p$cont'>$valor&zwnj;<a class='btn btn-link btn-xs' href= {$links[$clave][0]}{$rs[$links[$clave][1]]} target='_blank'>ver</a></p></td>";
         }      
          
          else
         {
              
         // si no es campo con links, compruebo si es campo actualizable  $UPDATES
              
         if (in_array($clave, $updates) OR in_array("*", $updates))   // el campo es actualizable (updates)
         {
                
                
                
//       DEBUG     $html_ficha .=  "<td ALIGN=left><A  class='tabla'  href=# onclick=\"ficha_update_str('$cadena_link','$clave','$valor_encode','p$cont' )\" >$clave : </A></td>" ;
                $html_ficha .=  "<td ALIGN=left><p>$clave:</p></td>" ;
                if ($is_fecha)
                {  //<input type="text" id="datepicker">
//                $valor_encode=str_replace("\r\n"," ",$valor) ;           // sustituyo los saltos de línea por espacios para que funcione el 'prompt' del javascript
               
                  $html_ficha .=  "<td><p id='p$cont'>$valor $url_link <A class='dentro_tabla' href=# onclick=\"ficha_update_str('$cadena_link','$clave','$valor_encode','p$cont' )\" ><i class='fas fa-pencil-alt'></i></A></p></td>" ;
//                  $html_ficha .=  "<td><p id='p$cont'><input type='text' id='datepicker' value='01/05/2018'></p></td>" ;
               
                }
                else
                {
                    
                   $html_ficha .=  "<td><p id='p$cont'>$valor $url_link <A class='dentro_tabla' href=# onclick=\"ficha_update_str('$cadena_link','$clave','$valor_encode','p$cont' )\" ><i class='fas fa-pencil-alt'></i></A></p></td>" ;
                }
         }
         else  // no es campo con links, ni campo actualizable, lo imprimo normalmente
         {
                $html_ficha .=  "<td ALIGN=left><p>$clave:</p></td>" ;
                $html_ficha .=  "<td><p id='p$cont'>$valor $url_link </p></td>" ;
            
         }
        }
        // *** fin de impresión *
        
        $html_ficha .=  "</tr>" ;
       }
       else  // es un ID_
       {  // consultamos si el campo ID_ está vinculado a un select y es editable
         if ($is_select)
         {
              $campo_ID=$selects[$clave][0] ;      // ["campo_ID", "campo_texto", "tabla_select",Opcional "link a nuevo"]
              $campo_texto=$selects[$clave][1] ;
              $tabla_select=$selects[$clave][2] ;
              
              $add_link_select=isset($selects[$clave][3])? "<a class='btn btn-link btn-xs' href='{$selects[$clave][3]}' target='_blank'>nuevo</a>" : "" ;
              
              $valor_texto=Dfirst($campo_texto,$tabla_select,"$campo_ID=$valor")   ;
              $cadena_link_encode=urlencode("tabla=$tabla_update&wherecond=$id_update=".$id_valor."&field=".$clave."&nuevo_valor="); //$cadena_link necesaria para update_ajax.php
              
              $cadena_select="cadena_link_encode=$cadena_link_encode&tabla_select=$tabla_select&campo_ID=$campo_ID&campo_texto=$campo_texto&select_id=select_$cont&filtro=" ;
 
              $html_ficha .=  "<tr>" ; 
              $html_ficha .=  "<td ALIGN=left><p>$clave:</p></td>" ;
              
              $html_ficha .=  "<td><p id='pcont999'>$valor_texto<a class='btn btn-link btn-xs' href=# onclick=\"ficha_update_select('$cadena_select','$campo_texto','$valor_texto','p$cont' )\" >cambiar</a>$add_link_select</p>" ;
              $html_ficha .=       "<div id='p$cont'></div></td>" ; 
              
              $html_ficha .=  "</tr>" ;

         }
         else
         {    // pintamos resto valores ID_ abajo en gris
             $id_info="$id_info, $clave: $valor " ;
         }
       }
    }
    if (!isset($print_pdf))  $html_ficha .=  "<tr><td ALIGN=left colspan=2 color='grey'><h5><small>$id_info</small></h5></td></tr>" ;   //pintamos los ID_ si no estamos imprimiendo pdf
   }
   else
   {$html_ficha .= "<tr><td><p>Ficha no encontrada</p></td></tr>" ;
   }
 
   $html_ficha .=   "</table>" ;   
//   eliminamos variables usadas
 unset( $titulo, $msg_tabla_vacia,  $add_link,  $links, $format, $format_style, $tooltips, $actions_row, $updates,$dblclicks ,$id_agrupamiento, $sin_botones ) ;

  ?>
      
 
      <!--   UPDATE `FACTURAS_PROV` SET `Modo_Envio_Pagare` = 'METALICO_' WHERE `FACTURAS_PROV`.`ID_FRA_PROV` = 3;-->
<script>
    
function ficha_down_font_size(id_tabla) {
    $( id_tabla).css( "font-size", "-=3" );
}

function ficha_up_font_size(id_tabla) {
    $( id_tabla ).css( "font-size", "+=3" );
}
    
    
 function ficha_select_onchange(select_id) {
     
    var x = document.getElementById(select_id);
    var i = x.selectedIndex;
    //document.getElementById("demo").innerHTML = x.options[i].text; 
   //var x = document.getElementById(select_id).value; 
//    var ok=window.confirm("Cambiar a "+ x.options[i].text  );       // ANULAMOS LA PREGUNTA DE ¿Cambiar a...?
     var ok=1 ;
//    alert("el nuevo valor es: "+valor) ;
   if (ok)
   { 
       nuevo_valor=x.options[i].value ;
       cadena_link=x.options[0].value ;      // la cadena_link va metida en la primera options.value
//       alert("el nuevo id es: "+cadena_link+nuevo_valor) ;
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
function ficha_update_select(cadena_select, prompt, valor0, pcont) {
    var nuevo_valor=window.prompt("Filtre la búsqueda y seleccione en la lista el nuevo "+prompt , valor0);
//    alert("el nuevo valor es: "+valor) ;
   if (!(nuevo_valor === null))
   { 
       
       var xhttp = new XMLHttpRequest();
     xhttp.onreadystatechange = function() {
    if (this.readyState == 4 && this.status == 200) {
        if (this.responseText.substr(0,5)=="ERROR")
        { alert(this.responseText) ;}                    // hay un error y lo muestro en pantalla
        else
        {   //alert(this.responseText) ;                                // debug
            document.getElementById(pcont).innerHTML = this.responseText ; }  // "pinto" en el <div> el select options
      //document.getElementById("sugerir_obra").innerHTML = this.responseText;
      }
  };
  xhttp.open("GET", "../include/select_ajax.php?"+cadena_select+nuevo_valor, true);
  xhttp.send();   
   }
   else
   {return;}
   
}   
//$( function() {
//    $( "#datepicker" ).datepicker();
//  } );
// 


$('#datepicker').datepicker({
    format: "dd/mm/yyyy"
});

function ficha_update_str(cadena_link, prompt, valor0, pcont) {
    
    //var valor0 = valor0_encode;
    //var valor0 = JSON.parse(valor0_encode);
    var nuevo_valor=window.prompt("Nuevo valor de "+prompt , valor0);
//    alert("el nuevo valor es: "+valor) ;
   if (!(nuevo_valor === null))
   { 
       
       var xhttp = new XMLHttpRequest();
     xhttp.onreadystatechange = function() {
    if (this.readyState == 4 && this.status == 200) {
        if (this.responseText.substr(0,5)=="ERROR")
        { alert(this.responseText) ;}                                        // hay un error y lo muestro en pantalla
        else
        { document.getElementById(pcont).innerHTML = this.responseText ; }  // "pinto" en la pantalla el campo devuelto por la BBDD tras el Update
        
      //document.getElementById("sugerir_obra").innerHTML = this.responseText;
      }
  };
  xhttp.open("GET", "../include/update_ajax.php?"+cadena_link+nuevo_valor, true);
  xhttp.send();   
   }
   else
   {return;}
   
}

function ficha_delete(cadena_link, titulo) {
    var nuevo_valor=window.confirm("¿Borrar "+titulo+"?");
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
//           location.reload(true);
          window.close();   // cerramos la pestaña tras borrar la ficha exitosamente
        }  
      }
  };
  xhttp.open("GET", "../include/delete_row_ajax.php?"+cadena_link, true);
  xhttp.send();   
   }
   else
   {return;}
   
}

</script>
       
  