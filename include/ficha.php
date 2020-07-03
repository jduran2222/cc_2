<style>
    
 
/*     Icon when the collapsible content is shown 
div.div_boton_expand .btn:after {
  font-family: "Glyphicons Halflings";
  content: "\e080";
  content: "\e113";
}

 Icon when the collapsible content is hidden 
div.div_boton_expand .btn.collapsed:after {
      font-family: "Glyphicons Halflings";

  content: "\e114";
}
    */
    
    
.transparente{
    opacity:0.15 ;
    padding: 2px;
}
 .transparente:hover{
    opacity:0.5 ;
}

    
    
div.div_edit:hover {
  /*border: 1px solid lightblue;*/
    background-color: #ffffcc;
    /*min-height: 50px;*/
}
div.div_edit {
  /*border: 1px solid lightblue;*/
    /*background-color: #ffffcc;*/
    min-height: 70px;
    white-space: normal;
}

.redimensionable {
/*    width:10em;
    height:4em;
    margin:1em;*/
    /*border:1px solid #d9d9d9;*/
    /* overflow puede tomar cualquier valor excepto visible*/
    overflow:hidden;
    /*resize puede ser: horizontal, vertical o both */
    resize:both;
  }

/*a.dentro_tabla_ficha {
    
  background: #eee; 
  color: grey; 
  display: inline-block;
  height: 20px;
  line-height: 20px;
  padding: 0 5px 0 5px;
  position: relative;
  margin: 0 5px 5px 0;
  text-decoration: none;
  -webkit-transition: color 0.2s;
  font-size: 9px ;
}                */
                
.tabla_ficha2  select {
    /*font-family: "Trebuchet MS", Arial, Helvetica, sans-serif;*/
    border-collapse: collapse;
    font-size: 1.8vw; 
    width: 100%;
}

.tabla_ficha2 td {
    border-top:  1px solid #ddd;
    border-bottom:  1px solid #ddd;
/*    border-right:  0px solid grey;
    border-left:  0px solid grey;*/
    padding: 15px;
    /*font-size: 15px;*/
}


 .tabla_ficha2  tr:hover {background-color: #ddd;}
 .tabla_ficha2  tr {
    background-color:#ffffff;
}
 

.textarea_ficha {
    /*height: 4em;*/
    width: 30em;
    border-width: 0px ;

}

.span_general {
    /*height: 4em;*/
    /*width: 30em;*/
    max-width: 30em;
    border-width: 0px ;

}


.etiqueta {
    /*text-align: right;*/
    text-align: left;
    /*background-color: #e9e7e7 ;*/
/*    color:grey ;*/
    font-style:italic;
    font-weight: bold;
}
.no_update {
    /*text-align: right;*/
    text-align: left;
    /*background-color: #e9e7e7 ;*/
/*    color:grey ;*/
    /*font-style:italic;*/
    /*font-weight: bold;*/
    font-size:x-small;
}

.float_left {
    /*border: 1px solid blue;*/
    float: left;
    /*cursor: pointer;*/
    padding-left: 10px ;
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


@media only screen and (max-width:980px) {
  /* For mobile phones: antes 500px */
 
   .tabla_ficha2  {
    font-size: 6vw; 
  }
    td p label {
    font-size: 6vw; 
  }
/*   .btn {
    font-size: 6vw; 
  }*/
/*  a.dentro_tabla_ficha {
    font-size: 6vw; 
  }*/
 .no_update {
    font-size: 6vw; 
  }

 } 
 	
</style>


<?php   /* ficha.php  muestra los campos de un único registro en forma de tabla
       
		require a incluir en .PHP 
		<?php require("../include/ficha.php");?>
		
		 Variables a definir previamente al require:
	// $visibles es array con campos ID_ que queremos mostrar	
        $result=$Conn->query("SELECT * from TABLA WHERE ID_ficha=".$id_ficha );
        $titulo="AVALES";
        $msg_tabla_vacia="No hay avales";
 *      $visibles=[  campos id a mostrar  ]
 * 
 * sintaxis $selects[ CAMPO_ID ] = [ CAMPO_ID , CAMPO_TXT , TABLA , link_nuevo , link_ver_ficha ,  , $OTRO_WHERE ]
 *          $selects[ CAMPO_ID ]["valor_null"] =  0;
 *          $selects[ CAMPO_ID ]["valor_null_title"] =  'sin remesa'; (opcional)
 *          $selects[ CAMPO_ID ]["href"] =  '.../proveedores/fra_prov_abono.php?...';  link a ejecutar tras la actualizacion (opcional)
 *          

*/

      // INICIO FICHA.PHP-->
      
 require_once("../include/funciones_js.php");
 logs("Inicio ficha.php  sql: $sql") ;
 
 $ficha_collapse= isset($ficha_expandida) ? ($ficha_expandida ?  '' : 'collapsed-card') : ''  ;   // por defecto  EXPANDIDA

 
 echo "<div id='div_ficha'> ";
 
 echo "<p align='left'><h2 style='text-align:left;' >$titulo    " ;
  
    
 if (isset($delete_boton ))
 {
   if ($delete_boton )
   {
     $cadena_link="tabla=$tabla_update&wherecond=$id_update=".$rs["$id_update"] ; 
     
     
   if (isset($disabled_delete))  
   { $disabled_delete = "disabled" ;
     $disabled_title=isset($disabled_tltle)? $disabled_tltle : "Elimine las filas de detalle antes de eliminar la Entidad principal" ;
   } else
   { $disabled_delete="" ;  
     $delete_title="Elimina la ficha actual" ;
   } 
     $titulo_sin_html= strip_tags($titulo)   ;
     echo "<a class='btn btn-danger btn-lg noprint transparente' $disabled_delete title='$delete_title'  href=# onclick=\"ficha_delete('$cadena_link', '$titulo_sin_html')\"><i class='far fa-trash-alt'></i></a> "; 
     
   }  
 }
  
  echo "</h2></p>" ;

  
   $idtabla="tabla_".rand() ;           // genero un idtabla aleatorio
 
  $content_ficha="" ; 
  $content_ficha .="<button type='button' class='btn btn-link btn-sm noprint transparente' onclick=ficha_down_font_size(document.getElementById('$idtabla'))><i class='fas fa-search-minus'></i></button>" ;
  $content_ficha .="<button type='button' class='btn btn-link btn-sm noprint transparente' onclick=ficha_up_font_size(document.getElementById('$idtabla'))  ><i class='fas fa-search-plus'></i></button>" ;


//  echo "<table id='$idtabla' class='tabla_ficha2' >" ;
  
    
   
if ($result->num_rows > 0)
{
   // INICIALIZAMOS LAS VARIABLES
   $cont_TD= mt_rand (1,1000000)  ;           // inicializamos el contador con rand() para evitar que se solapen los TD y otros elementos de diferentes tablas
   $id_info="solo admin:" ; 
   $id_info_user="creación: " ; 
   $visibles= isset($visibles) ? $visibles : [] ;  // $visibles es array con campos ID_ que queremos mostrar
   $ocultos= isset($ocultos) ? $ocultos : [] ;  // $ocultos es array con campos ID_ que NO queremos mostrar
   $format_style='';
      
   $fila_TD=100 ;  // determinará el orden de aparición de los TD
   $array_TD=[] ;   // inicializamos el array_TD de los item_TD
   $script_name=$_SERVER["SCRIPT_NAME"] ;
   foreach ($rs as $clave => $valor)
   {
       
       
       if(preg_match("/__HEX__/", (string) $valor) ){ $valor = hex2bin ( preg_replace("/__HEX__/", "", $valor)) ; }

       $is_requerido= isset($requeridos[$clave]) ?  $requeridos[$clave] : 0   ; // es requerido si tiene condicion de requerido y esta condicion se cumple, Ej. IMPORTE==0
       
       
         // determinamos que TIPO DE CAMPO 
       // is_select , es decir, campo seleccionable desde una lista a calcular
       $is_select= (isset($selects[$clave])) ; 

       // Hacemos visibles todos los campos no ID_, los $select, los no Ocultos y los Visibles explicitamente
       $is_visible= (($is_select OR (strtoupper(substr($clave,0,3))<>"ID_")  OR  in_array($clave,$visibles)) AND !in_array($clave,$ocultos) ) ; 
       $is_visible= ($is_visible AND (strtoupper($clave)<>"USER")  AND (strtoupper($clave)<>"FECHA_CREACION") AND (strtoupper($clave)<>"GUID"))  ;
       
       // empezamos A PINTAR
       // 
       if ($is_visible)   // si es VISIBLE lo imprimimos
       {     
       
       $cont_TD++ ;
       
       //  ASIGNACION DE ETIQUETAS: POR CÓDIGO (sistema antiguo) por CLAVE_DB o por defecto
       // solicitamos datos de CLAVES_DB
       
       $claves_db = DRow("Claves", "clave='$clave' ", "(script_name='$script_name') DESC"  ) ;
       $exist_clave_db = !(empty($claves_db)) ;                                              // si devuelve el array vacio, NO HAY CLAVE
       $clave_db_heredada= isset($claves_db["script_name"])?  ($claves_db["script_name"]!=$script_name) : 0 ; // si no coinciden los PHP es clave HEREDADA
       $en_linea_db=  $clave_db_heredada? 0 :  $claves_db["en_linea"] ;  // sin clave propia por defecto NO ALINEADA
       
       //compatibilidad con nuevo fotmato $etiquetas[clave]= [ etiqueta , tooltip ] ;
       if (isset($etiquetas[$clave]) AND is_array($etiquetas[$clave]))
       {
              $tooltips[$clave]=$etiquetas[$clave][1];         // el TOOLTIP viene como segundo parámetro de $etiquetas[]
              $wikis[$clave]=isset($etiquetas[$clave][2])? ($etiquetas[$clave][2]) : "" ;
              $etiquetas[$clave]=$etiquetas[$clave][0];
       }
       // si ya existe CLAVE_DB las usamos ante las etiquetas por código
       $clave_db_fila="";
       if(  $exist_clave_db AND !$clave_db_heredada )  // es clave PROPIA (asignamos prioritariamente las CLAVES_DB)
       {
              $etiquetas[$clave]=$claves_db["etiqueta"];
              $tooltips[$clave]=$claves_db["tooltip"];       
              $wikis[$clave]=$claves_db["wiki"] ;
              $clave_db_fila = $claves_db["fila_ficha"] ;  // si la clave propia tiene fila lo indicamos
              
       }elseif($exist_clave_db AND $clave_db_heredada)  // es clave_db HEREDADA, solo rellenamos las etiquetas vacías
       {
              $etiquetas[$clave]= isset( $etiquetas[$clave]) ?  $etiquetas[$clave] :  $claves_db["etiqueta"];
              $tooltips[$clave]= isset( $tooltips[$clave]) ?  $tooltips[$clave] :   $claves_db["tooltip"];       
              $wikis[$clave]=  isset( $wikis[$clave]) ?  $wikis[$clave] :    $claves_db["wiki"] ;
       }    
        // a falta de $etiqueta por código o CLAVE_DB improvisamos una
        //  inicializamos la $etiqueta_txt con su etiqueta o en su defecto el nombre del campo sin el 'ID_' y sin '_'
       $etiqueta_txt= isset($etiquetas[$clave]) ? $etiquetas[$clave] : str_replace('_',' ',( (strtoupper(substr($clave,0,3))=="ID_")? substr($clave,3)  :   $clave     ))  ; 
    
       //   FIN ASIGNACION DE ETIQUETAS
       
       // calculo del FORMATO
       // Primero miramos el formato por Clave , luego por array , luego por nombre de la $clave
       // si no trae formato lo ponemos por defecto según nombre de campo ($clave)
       $formats[$clave] = ($exist_clave_db AND $claves_db["formato"]) ?   $claves_db["formato"] 
                            : ( isset($formats[$clave])? $formats[$clave] : tipo_formato_por_clave($clave) );    

       // el campo es UPDATE , EDITABLE $update
       $no_updates= isset($no_updates) ? $no_updates : []  ;       // el array $no_updates contiene los campos NO EDITABLES
       $is_update= (((in_array($clave, $updates) OR in_array("*", $updates))) AND !(in_array($clave, $no_updates)) AND !( $clave=='doc_logo' )) ;
       
       // determinamos el tipo de campo
       $is_URL = (strtoupper(substr($clave,0,4))=="URL_")  ;  
       $is_EMAIL = (strtoupper(substr($clave,0,5)) =="EMAIL")  ;   
       $is_TEL = (strtoupper(substr($clave,0,3)) =="TEL" OR strtoupper(substr($clave,0,8)) =="WHATSAPP")  ;  
       $is_EXPAND = (strtoupper(substr($clave,0,6))=="EXPAND")  ;  
       $is_FIN_EXPAND = (strtoupper(substr($clave,0,10))=="FIN_EXPAND")  ;  
       $is_fecha = (substr($formats[$clave],0,5)=='fecha') ;
       $is_boolean=  (($formats[$clave]=='boolean') OR like($formats[$clave],'semaforo%'))   ;    // campo BOOLEAN . checkbox
       $is_text_edit = ( $formats[$clave]=='text_edit' ) ;  //campo textarea editable directamente       
       $is_div_edit  = ( $formats[$clave]=='div_edit' ) ;  //campo textarea editable directamente       
       $is_array =  (substr($formats[$clave],0,5)=='array')  ;  //campo textarea editable directamente       
       $is_numero= is_format_numero(  $formats[$clave]  ) ; //campo numerico que eliminará simbolos en su update
       
       if ($is_doc_logo = ( $clave=='doc_logo'  )  AND $valor ) //campo numerico que eliminará simbolos en su update
       {
           $valor=Dfirst("path_archivo","Documentos"," id_documento=$valor ")  ;   //sustituimos el $valor por el path del archivo de id_documento = doc_logo
           $formats[$clave]= "pdf" ;
       }
        
       
       // el campo hace un LINK
       $is_link = isset($links[$clave]) OR $is_URL OR $is_EMAIL ;       
       
      
       
       
       // INICIAMOS LA CADENA SPANS_HTML_TXT
       $spans_html_txt=isset($spans_html[$clave])? "<span class='btn btn-xs btn-link noprint transparente' >".$spans_html[$clave]."</span>" : "" ;        // extraemos su divs si es que hay
       
       // span de envío de email
       $spans_html_txt .= $is_EMAIL ? "<span class='btn btn-xs btn-link noprint transparente'  ><a  href='mailto:$valor'  title='enviar email a $valor' >"
                              . "<i class='far fa-envelope'></i></a></span>" : "" ;  
       // span de llamar y enviar whatsapp
       $spans_html_txt .= ($is_TEL) ?  "<span class='btn btn-xs btn-link noprint transparente'  ><a  href='tel:$valor'  title='llamar por teléfono a $valor' >"
                              . "<i class='fas fa-phone'></i></a></span>" : "" ;        
       $spans_html_txt .= ($is_TEL) ?  "<span class='btn btn-xs btn-link noprint transparente'  ><a  href='https://wa.me/$valor'  title='enviar Whatsapp a $valor' >"
                              . "<i class='fab fa-whatsapp'></i></a></span>" : "" ;        
       // span de copy a portapapeles  
       $valor_sin_comillas=  str_replace(">", "", $valor) ;
       $valor_sin_comillas=  str_replace('"', '\"', $valor_sin_comillas) ;
       $valor_sin_comillas=  str_replace("<", "", $valor_sin_comillas) ;
       $etiqueta_txt_sin_etiquetas=strip_tags($etiqueta_txt) ;                          // quitamos las ETIQUETAS <> para evitar que aparezcan en el siguiente title
       $spans_html_txt .= ($is_EXPAND OR $is_FIN_EXPAND OR $is_boolean OR $is_array) ? "" : "<span class='btn btn-xs btn-link noprint transparente' "
                            . "onclick=\"copyToClipboard('$valor_sin_comillas');this.style.color = '#000000' ;\"  title=\"copy $etiqueta_txt_sin_etiquetas a portapapeles \" >"
                              . "<i class='far fa-copy'></i></span>" ;
       

         
//window.clipboardData.getData('Text')
//       href='https://wa.me/$whassapp_envio?text={$link_pdf}'
       

       //  FIN SPANS_HTML_TXT
       
       
       // añadimos el tooltip a la etiqueta $etiqueta_txt
       $tooltip_txt = isset($tooltips[$clave])? $tooltips[$clave]  : ""  ;    
       $tooltip_txt= preg_replace("/\s*<br>\s*/","\n", $tooltip_txt) ;  // quitamos los espacios alrededor de <br> y lo sustituimos por \n
       $tooltip_txt_alert= str_replace("\n","\\n", $tooltip_txt) ;
       $div_tooltip_html = ($tooltip_txt) ? "<span class='btn btn-xs btn-link noprint transparente' onclick=\"alert('$tooltip_txt_alert')\" >"
                                        . "<i class='fas fa-info '  title='$tooltip_txt'></i></span>"  : "" ; 

       $tooltipWiki_txt = isset($wikis[$clave])? $wikis[$clave]  : ""  ;       
       $div_tooltip_html .= ($tooltipWiki_txt) ? ""
               . "<a class='btn btn-xs btn-link noprint transparente'  href='https://wiki.construcloud.es/index.php?title=$tooltipWiki_txt' title='ver ConstruWIKI' target='_blank'>"
               . "<i class='fab fa-wikipedia-w'></i></a>"
               . "<span class='box_wiki'><iframe src='https://wiki.construcloud.es/index.php?title=$tooltipWiki_txt' width = '500px' height = '300px'></iframe></span>"  : "" ; 
  
       
       
        // creamos cadena para el update   
        //Ejemplo: 
        //$cadena_link="tabla=FACTURAS_PROV&wherecond=id_fra_prov=".$id_fra_prov."&field=".$clave."&nuevo_valor=";
        $cadena_link="tabla=$tabla_update&wherecond=$id_update=".$id_valor."&field=".$clave."&nuevo_valor=";     
           
        // FORMATEAMOS EL VALOR a su formato o por defecto
        $format_style="" ;                                 //inicializo la align del TD_valor       
        
        $formato_valor= (isset($formats[$clave])) ? $formats[$clave] :  'auto' ;                                 
        $valor_txt=cc_format( $valor, $formato_valor , $format_style, $clave ) ;    // formateamos el valor
        $valor_txt=$valor_txt? $valor_txt : "<span class='btn btn-lg btn-link noprint transparente'  title='editar'> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; </span>"  ;                          // si el valor_txt es vacio ponemos unos guiones para poder pinchar y editar

        
        // <SPAN> HTML PARA GESTIÓN DE ETIQUETAS CON CLAVE_DB. Solo para ADMIN_CHAT 
         $clave_db_editar_html="";
         $clave_db_nuevo_html="";
        if ($_SESSION["admin_chat"]) 
        {
            $tooltip_clave_nueva= "Clave nueva:\n Etiqueta: $etiqueta_txt_sin_etiquetas\n Tooltip: $tooltip_txt\n formato: $formato_valor\n fila natural: $fila_TD" ;
            $clave_db_nuevo_html=  "<a class='btn btn-xs btn-link noprint transparente'  target='_blank'  title='$tooltip_clave_nueva'"
                   . " href=\"../configuracion/clave_ficha.php?clave=$clave&script_name=$script_name&etiqueta=$etiqueta_txt_sin_etiquetas&tooltip=$tooltip_txt&formato=$formato_valor\" >"
                        . "<i class='fas fa-plus-circle'></i></a>"   ; 
             
            if(isset($claves_db["clave"]))
            {
                
                $clave_resumen= "\n Etiqueta: {$claves_db["etiqueta"]}\n Tooltip: {$claves_db["tooltip"]}\n Wiki: {$claves_db["wiki"]}\n Formato: {$claves_db["formato"]}\n fila ficha: $clave_db_fila\n fila natural: $fila_TD" ;
                $clave_propia_txt= $clave_db_heredada?  "editar clave  HEREDADA $clave_resumen" : "editar clave PROPIA $clave_resumen" ;
                $clave_propia_LINK= $clave_db_heredada? "Eh" : "E";
                $clave_db_editar_html= "<a class='btn btn-xs btn-link noprint transparente' target='_blank'  title='$clave_propia_txt'"
                                   . " href=\"../configuracion/clave_ficha.php?id_clave={$claves_db["id_clave"]}\" >"
                                        . "$clave_propia_LINK</a>"   ; 


                if ($script_name==$claves_db["script_name"]) // clave propia
                {
                   // clave propia EDITAR
                    $clave_db_nuevo_html="";
                }  
            }
        }  
        
        $div_etiqueta_required= $is_requerido ? "<span style='color:red;' title='campo requerido, rellenelo o cambie el valor asignado por defecto' >(*)</span>" : '' ;
        $TD_etiqueta = "<span  >$etiqueta_txt </span>$div_etiqueta_required $div_tooltip_html $clave_db_editar_html $clave_db_nuevo_html" ;
        

        // TIPOS DE CAMPO VISIBLES: SELECT, UPDATE, LINKS, GENERAL
        // el campo IS_SELECT , campo SELECIONABLE deentre valores a calcular
        if ($is_select)
        {
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
             
              // calculamos el nombre del ID_ corespondiente, por ej. PROVEEDOR o NOMBRE_OBRA
//              $valor_txt_sel= ($valor<>"") ?  Dfirst($campo_texto,$tabla_select,"$campo_ID=$valor") : ""  ;   //evitamos un error en Dfirst si $valor es NULL     
              // **PROVISIONAL*** a todos las busquedas de SELECT les añado el $where_id_c_coste
              
              $valor_txt_sel= ($valor<>"") ?  Dfirst($campo_mostrado,$tabla_select,"$campo_ID='$valor' $where_c_coste_txt ") : ""  ;   //evitamos un error en Dfirst si $valor es NULL              
              $valor_txt_sel= $valor_txt_sel ?  $valor_txt_sel : "";   // quitamos el valor 0

              // PROVISIONAL UNOS DÍAS HASTA VER QUÉ FICHAS REQUIEREN AÑADIR LOS SELECT AL UPDATES[]
//                if (!$is_update) { $valor_txt_sel = '¡¡ ATENCION!! AÑADIR EL SELECT AL UPDATES SI PROCEDE (juand)' ;}
              // LINK PARA VER LA ENTIDAD
              $add_link_select_ver = $link_ver ? "<a class='btn btn-link' href='{$link_ver}{$rs[$id_campo]}&_m=$_m' target='_blank'>$valor_txt_sel</a>" : "$valor_txt_sel" ;

              if ($is_update)
              {
        //              LINKS EN CASO DE SER EDITABLE (UPDATES)
                      $add_link_select= $link_nuevo ? "<a class='btn btn-link noprint transparente' href='$link_nuevo' target='_blank' title='nuevo'>"
                                                          . "<i class='fas fa-plus-circle'></i></a>" : "" ;

                      
                      $cadena_link="tabla=$tabla_update&wherecond=$id_update=".$id_valor."&field=".$clave."&nuevo_valor=";     

                      $cadena_link_encode=urlencode($cadena_link); //$cadena_link necesaria para update_ajax.php

                      // HREF, link  a ejecutar tras la actualización del campo
                      $select_href  = isset($selects[$clave]['href']) ? $selects[$clave]['href'] : " " ; //por defecto un ESPACIO para evitar errores en el GET
                      // DEBUG MAY20
                      $cadena_select_enc= encrypt2( "href=$select_href&cadena_link_encode=$cadena_link_encode&tabla_select=$tabla_select&campo_ID=$campo_ID&campo_texto=$campo_texto&select_id=select_$cont_TD&filtro=") ;


                      // sistema showInt   
                      // PONEMOS EL INPUT
                      $add_link_select_cambiar="<INPUT class='noprint' style='font-size: 70% ;font-style: italic ;' id='input_$cont_TD' size='7'  "
                              . "  onkeyup=\"ficha_update_select_showHint('$cadena_select_enc','$campo_texto','$valor_txt_sel','p$cont_TD','$otro_where' ,this.value)\" placeholder='buscar...' value=''  >" ;
                      // LUPA busca todos, intruduce tres espacios en el INPUT
                      $add_link_select_cambiar.= "<span class='btn btn-link noprint transparente'  " 
                              . " onclick=\" $('#input_$cont_TD').val($('#input_$cont_TD').val()+'   ')  ; $('#input_$cont_TD').keyup()   \"   "
                              . " title='Buscar'> <i class='fas fa-search'></i></span>" ;
                      // FUNCION PASTE()
                       $add_link_select_cambiar.= "<span class='btn btn-link noprint transparente'  "
                              . " onclick=\" paste( function(nuevo_valor){  document.getElementById('input_$cont_TD').value=nuevo_valor ; $('#input_$cont_TD').keyup() } )  \"   "
                              . " title='paste from clipboard'> <i class='fas fa-paste'></i> </span>";
                             
                       
                      //    SCRIPT PARA PODER PULSAR ENTER
                      $add_link_select_cambiar.="<script>"
                                              . "var input_id = document.getElementById('input_$cont_TD');"
                                              . "input_id.addEventListener('keyup', function(event) {"
                                              . "      event.preventDefault();if (event.keyCode === 13) "
                                              . " {ficha_update_select_showHint_ENTER('p$cont_TD');  }});"
                                              . "</script>" ;
                        
                       $add_link_select_cambiar_div_sugerir= "<div class='sugerir' id='sugerir_$cont_TD'></div>" ;

                      // uso de cambiar a VALOR NULL  PARA HACER CERO EL ID_ (probablemente 0) y no seleccionarlo de la lista. Ej: quitar pago de remesa (id_remesa=0)
                      if (isset($selects[$clave]["valor_null"]))     // cuando queremos poner a CERO el ID_, por ejemplo quitar la remesa, hacer id_remesa=0 en un ID_PAGO
                      {   
                         $valor_null= $selects[$clave]["valor_null"] ; 
                         $valor_null_title = isset($selects[$clave]["valor_null_title"])? $selects[$clave]["valor_null_title"] : "quitar" ; 

                         $add_link_select_valor_null= "<span class='btn btn-xs btn-link noprint transparente' title='$valor_null_title' "
                                     . " onclick=\"ficha_update_str('$cadena_link','','','p$cont_TD','$valor_null' );location.reload(); \" ><i class='far fa-window-close'></i></span>" ;
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
             
              $TD_valor =  "<p id='pcont999'>$add_link_select_ver $add_link_select_cambiar $add_link_select $add_link_select_valor_null $add_link_select_cambiar_div_sugerir</p>"
                           . "<div id='p$cont_TD'></div>" ;
              
              
           // fin $IS_SELECT
              
           // campos UPDATE , EDITABLE   
         }elseif ($is_update)   // el campo es actualizable (UPDATES) 
         {
           // formateo $valor a $valor_encode para evitar problemas con el window.prompt()
           $valor_encode=str_replace("\r\n"," ",$valor) ;  // sustituyo los saltos de línea por espacios para que funcione el 'prompt' del javascript         
       
           // vemos los posibles tipos de campos       
           if ($is_fecha)     // UPDATE  FECHA
           {  //<input type="text" id="datepicker">
//              $fecha0=substr($valor0,0,10) ;
              $fecha0=substr($valor,0,10) ;
 
               $TD_valor =  "<input type='date' style='border:none;' id='p$cont_TD' value='$fecha0' "  
                   . " onchange=\"ficha_update_fecha('$cadena_link',this.value )\">  "
                   . "<span class='btn btn-link noprint transparente' onclick=\"ficha_update_str('$cadena_link','$clave','$valor_encode','p$cont_TD','', 'date' )\"  title='editar fecha manualmente'>$ICON-pencil$SPAN</span>"
                   . "<span class='btn btn-link noprint transparente'  onclick=\"paste( function(nuevo_valor){ ficha_update_str('$cadena_link','$clave','$valor_encode','p$cont_TD',nuevo_valor, 'date'  ); } ) \"  >"
                       . " <i class='fas fa-paste'></i> </span>"
                   . "$spans_html_txt" ;                                                                    // hacemos el JAVASCRIPT para actualizar la FECHA
                   // PENDIENTE DE PONER UN PENCIL-UPDATE DONDE METER LA FECHA CON COPIA PEGA EN FORMATO DD/MM/AAAA CON UN PROMPT    
               
           }elseif ($is_boolean)  // UPDATE BOOLEAN
           {
//              $checked= $valor0 ? 'checked' : '' ;
              $checked= $valor ? 'checked' : '' ;

              // background define los colores, si es '' se queda en primary (blue)
              $background_color= ($formato_valor=='semaforo')? ($valor ? "background-color:green;" : "background-color:red;" ) 
                             : ( ($formato_valor=='semaforo_not')? ($valor ? "background-color:red;" : "background-color:green;" ) : '' )  ;
              
              
               $TD_valor =   "<p><label id='label_$cont_TD' class='btn btn-primary' style='$background_color' for='chk1_$cont_TD'>"
                      . "<input type='checkbox' id='chk1_$cont_TD'  $checked onclick=\"ficha_update_boolean('$cadena_link',this.checked,'$formato_valor','','label_$cont_TD' )\" >"
                      . "&nbsp;&nbsp;$clave</label></p>$spans_html_txt"  ;
//                          . " onclick=\"alert(this.checked)\"></p>"
                                                                                       // hacemos el JAVASCRIPT para actualizar la FECHA
                     
           }elseif ($is_text_edit)   // UPDATE IS_TEXT_EDIT
           {
               // eltimamos numero de filas necesarias para buena visibilidad
              $rows=min( round(strlen($valor)/40) + substr_count($valor,"\n") , 25 ) ;  // calculo el número  necesario  de filas para mostrar todo el texto del textarea

              // metemos la etiqueta en el mismo <TD> que el textarea
              
              $TD_etiqueta = "<span class='etiqueta' style='text-align: left;'><span  >$etiqueta_txt </span>$div_etiqueta_required $div_tooltip_html "
                             . "$clave_db_editar_html $clave_db_nuevo_html</span>" ;   

//              // migracion a div contenteditable="true"
//              // anterior version TEXTAREA
              $TD_valor =  "<textarea class='textarea_ficha' rows='$rows' id='textarea1' name='textarea1' "
                        . " onchange=\"ficha_update_fecha('$cadena_link',this.value )\"   >$valor</textarea>"
                        ." $spans_html_txt"  ;
              
                
           }elseif ($is_div_edit)   // UPDATE IS_DIV_EDIT
           {
               // eltimamos numero de filas necesarias para buena visibilidad
              $rows=min( round(strlen($valor)/40) + substr_count($valor,"\n") , 25 ) ;  // calculo el número  necesario  de filas para mostrar todo el texto del textarea

              // metemos la etiqueta en el mismo <TD> que el textarea
              
              $TD_etiqueta =  "<span class='etiqueta' style='text-align: left;'><span  >$etiqueta_txt </span>$div_etiqueta_required $div_tooltip_html"
                      . " $clave_db_editar_html $clave_db_nuevo_html</span>" ;   // quitamos la Etiqueta


              $TD_valor = "<div id='div$cont_TD' contenteditable='true'  class='div_edit redimensionable'  "
                        . " onblur=\"ficha_update_div_edit('$cadena_link',this.innerHTML ,'div$cont_TD' )\"   >$valor</div>"
                         . ($admin? "<button onclick='alert($(\"#div$cont_TD\").html());' style='cursor:pointer;'  >VER</button>" : "" ) 
                        ." $spans_html_txt"  ;
//                        
                
           }elseif ($is_numero)  // UPDATE NUMERICO
           {    
               $TD_valor =  "<span style='cursor: pointer;'  onclick=\"ficha_update_numero('$cadena_link','$clave','$valor_encode','p$cont_TD' )\"  id='p$cont_TD' >$valor_txt  </span>"
                    . "<a class='btn btn-xs btn-link noprint transparente'  "
                       . " onclick=\"paste( function(nuevo_valor){ ficha_update_str('$cadena_link','$clave','$valor_encode','p$cont_TD' , nuevo_valor,'num' ); } ) \"  id='p$cont_TD' title='paste from clipboard' >"
                       . "<i class='fas fa-paste'></i></a>"
                       . "$spans_html_txt" ;
                
           }elseif ($is_URL)  // UPDATE URL 
           {    

               $add_link_url_valor_null= "<a class='btn btn-link btn-xs noprint transparente' title='eliminar url' "
                                     . " onclick=\"ficha_update_str('$cadena_link','','','p$cont_TD','  ' );location.reload(); \" ><i class='far fa-window-close'></i></a>" ;

//               $iframe_url="<span><iframe src='https://www.google.com/maps/embed?pb=!1m20!1m8!1m3!1d19217.859672675262!2d-4.845872!3d36.8689644!3m2!1i1024!2i768!4f13.1!4m9!3e3!4m3!3m2!1d36.8733291!2d-4.844917199999999!4m3!3m2!1d36.8629624!2d-4.8488729!5e1!3m2!1ses!2ses!4v1587670613507!5m2!1ses!2ses' "
//                       . " width='600' height='450' frameborder='0' style='border:0;' allowfullscreen='' aria-hidden='false' tabindex='0'>"
//                       . "</iframe></span>";
               
//               $iframe_url="<span><iframe src='https://www.google.es/maps/@36.5838484,-4.5510269,277m/data=!3m1!1e3?hl=es' "
//                       . " width='600' height='450' frameborder='0' style='border:0;' allowfullscreen='' aria-hidden='false' tabindex='0'>"
//                       . "</iframe></span>";
               
               $iframe_url="<span><iframe src='$valor' width = '300px' height = '100px'></iframe></span>";
               
               $TD_valor = "<span class='float_left' $format_style ><a class='btn btn-link btn-xs'  href= '$valor' title='ir a URL' target='_blank'>{$valor_txt}</a></span>"
                           . "<br><span class='float_left noprint transparente'   onclick=\"ficha_update_str('$cadena_link','$clave','$valor_encode','p$cont_TD' ,'','')\"  title='editar Url'>$ICON-pencil$SPAN</span>"
                           . "<span class='btn btn-xs btn-link noprint transparente'   onclick=\"paste( function(nuevo_valor){ ficha_update_str('$cadena_link','$clave','$valor_encode','p$cont_TD' , nuevo_valor ); } ) ;location.reload(); \" "
                       . " title='paste from clipboard'> <i class='fas fa-paste'></i> </span>"
                       . "$spans_html_txt $add_link_url_valor_null $iframe_url";        

                
           }elseif ($is_EMAIL)  // UPDATE EMAIL 
           {    

               $TD_valor = "<span  $format_style  class='btn btn-lg btn-link noprint'   style='cursor: pointer;'  onclick=\"ficha_update_str('$cadena_link','$clave','$valor_encode','p$cont_TD' )\" id='p$cont_TD' title='editar email' >{$valor_txt}</span>"
                           . "<span class='btn btn-xs btn-link noprint transparente' onclick=\"paste( function(nuevo_valor){ ficha_update_str('$cadena_link','$clave','$valor_encode','p$cont_TD', nuevo_valor ); } ) \"  "
                                   . " title='copia desde Clipboard' > <i class='fas fa-paste'></i> </span>"
//                           . "<span style='cursor: pointer;'  onclick=\"paste(   function(p) {prueba(p);} )\" title='copia desde Clipboard' > PASTE </span>"
                           ."$spans_html_txt";        

                
           }else       // campo UPDATE GENERAL          function(p) {  alert(p);}
           {                    
                    
              $TD_valor =  "<div class='span_general' $format_style  style='cursor: pointer;'   onclick=\"ficha_update_str('$cadena_link','$clave','$valor_encode','p$cont_TD' )\" id='p$cont_TD' title='editar' >$valor_txt </div>"
                    . "<span class='btn btn-xs btn-link noprint transparente' style='cursor:pointer;'   onclick=\" paste( function(nuevo_valor){  ficha_update_str('$cadena_link','$clave','$valor_encode','p$cont_TD' , nuevo_valor ) ; } )\" "
                      . " id='p$cont_TD' title='paste from clipboard' > <i class='fas fa-paste'></i> </span>"
                      . "$spans_html_txt";
              
              
              
            }
          // fin de campos EDITABLES  
          
          // campos LINKS[] LINKABLES  
         }elseif ($is_link)      // consulto si el campo es un LINK
         { 
            if ($is_URL and !isset($links[$clave]) )  // es un URL_ no UPDATE y no se ha especificado $LINK[]
            {   

                $link_href= $valor ;       // el link es a la propia URL_
                $valor_campo_id = '' ;     // no se añade valor de ningún campo
                $title= "Ir a URL" ;      
                $link_formato='formato_sub' ;  // formato subrayado
                
//                $div_valor_sec+=

            }
            else
            {    
                // configuro parametros para el $LINKS[]  
                $link_href=  $links[$clave][0] ;        // valor obligatorio
                $valor_campo_id= isset($rs[$links[$clave][1]]) ? $rs[$links[$clave][1]] : "" ; // evitamos un error si el link no lleva valor de campo asociado (ej. URL_Licitacion)          
                $title=(isset($links[$clave][2]))? "{$links[$clave][2]}": "ver ficha" ;
                $link_formato=(isset($links[$clave][3]))? "{$links[$clave][3]}": "" ;
                
            }
            
                     
            if ($link_formato)  // el LINK tiene un modo especial
            { // hay formato especial de link
              if ($link_formato=='formato_sub')   // LINK FORMATO_SUB. FORMATO TRADICIONAL DE SUBRRAYADO (es incompatible con sortTable (ordenar tabla))
              { 
                $TD_valor = "<span $format_style  ><a class='btn btn-link'  href= '{$link_href}$valor_campo_id' "
                        . "title='$title' target='_blank'>{$valor_txt}</a></span>$spans_html_txt";        

              }elseif($link_formato=='html')  // LINK FORMATO HTML
              { 
                $link_html= $links[$clave][4] ;   
                
                $TD_valor = "<span  $format_style  >{$valor_txt}<a class='btn btn-link'  href= {$link_href}$valor_campo_id title='$title' target='_blank'>$link_html</a></span>"
                        . "$spans_html_txt";        
                    
              }
              else
              { echo "ERROR EN FORMATO DE LINK"  ;
              }
              
            }
            else   // el LINK en modo GENERAL con pequeña 'ver' tras pintar el $valor_txt
            {    
               $TD_valor = "<div style=' float:left;'><p id='p$cont_TD'>$valor_txt</p></div>"
                       . "<div style=' float:left;'><a class='btn btn-xs transparente noprint' href= {$link_href}{$valor_campo_id} target='_blank'>ver</a></div>"
                       . "$spans_html_txt";
            }// fin 
         
            // si no es campo con links, compruebo si es campo actualizable  $UPDATES              
         }
                //NO SELECT NO UPDATE Y NO LINK EDITABLE. CAMPO  GENERAL.
         else  //  no es campo con links, ni campo actualizable, lo imprimo normalmente
         {
                $format_style= str_replace('text-align:right','text-align:left',$format_style)   ;             // cambiamos alineación a la izquierda

                $TD_valor =  "<span  class='no_update' id='p$cont_TD'  $format_style >$valor_txt</span>$spans_html_txt" ;
            
         }
        
        // *** Empieza impresión *
         
         
         if ($is_EXPAND)  //  EXPAND  
          {  
                  $item_TD =  "</table>" ;
                  $item_TD .=  "<div class='div_boton_expand'><button data-toggle='collapse' class='btn btn-link btn-block  btn-lg noprint' style='text-align:left;' data-target='#div_exp$cont_TD'>"
                             . " $valor_txt </button></div>"
                              . "<div id='div_exp$cont_TD' class='collapse'>" ;
                  $item_TD .=  "<table>" ;
             
             
             
         }elseif ($is_FIN_EXPAND)  //  EXPAND  
           {    
                  $item_TD=   "</table>" ;
                  $item_TD .=  "</div>" ;
                  $item_TD .=  "<table>" ;

                
           } else 
            {
                 $item_TD=  "" ;
//                 $item_TD.=  "<tr><td colspan='2'>" ;
//                 echo  "<TD class='etiqueta'>$TD_etiqueta</TD>" ;
//                 echo  "<TD>$TD_valor</TD>"  ;
                 $item_TD .=  "<div id='div_td' class='float_left'><span class='etiqueta'>$TD_etiqueta</span><br>" ;
                 $item_TD .=   "<span>$TD_valor</span></div>"  ;
//                 $item_TD .=   "</td></tr>" ;
                 
            }
         
         // registramos el $item_TD en el array de TD 
         $fila_array= $clave_db_fila ? (int)$clave_db_fila : $fila_TD ;
         $fila_array= isset($array_TD[$fila_array]) ? $fila_array + 1 : $fila_array ;  // si ese número de fila (array) ya existe le sumamos 10 para evitar duplicidades
         
         $array_TD[$fila_array]["TD"]= $item_TD ; 
         $array_TD[$fila_array]["en_linea"]= $en_linea_db ;
         $fila_TD += 100 ;    // aumentamos el orden natural fila_ficha
           
       
       // FIN DE CAMPO VISIBLE   
       }
       else  // no es VISIBLE
       {  
         
//         else
             // pintamos resto valores ID_ abajo en gris
           if ($clave=='user' OR $clave=='fecha_creacion' OR $clave=='fecha_modificacion' )
           { $id_info_user.= "  $valor  //   " ;}    
           elseif($_SESSION["admin"]) 
           { $id_info.= "$clave=". cc_format($valor,'textarea_10') ." "  ;}
           
         
       }
       
     
       
    // FIN DEL CAMPO   
    }  // fin del FOREACH 
    
    // pintamos CAMPOS NO VISIBLES. ponemos línea de ID_INFO en GRIS
     $item_TD_final =  "<tr><td colspan=2  style='text-align:left;color:silver;font-size:small;white-space: normal;'><h5 style='text-align:left'>$id_info_user $id_info</h5></td></tr>" ;   //pintamos los ID_INFO  campos ID ignorados
}
else
{
die ("<tr><td><h1>ERROR, FICHA NO ENCONTRADA</h1></td></tr>" );         // FICHA NO ENCONTRADA. ABORTAMOS LA PAGINA
echo "<tr><td><h1>ERROR, FICHA NO ENCONTRADA</h1></td></tr>" ;

}

// EXPAND final automatico de más datos...
$max_fila=max(array_keys($array_TD)) ;   // maximo orden de fila de un campo
if ($max_fila>10000)  // si tenemos campos con orden de fila mayor a 10.000 , tenemos Mas datos... o datos ocultos
{
    $cont_TD++ ;

    $item_TD =  "</table>" ;
    $item_TD .=  "<div class='div_boton_expand'><button data-toggle='collapse'   class='btn btn-link btn-block btn-lg noprint' style='border:none;text-align:left;' data-target='#div_exp$cont_TD'>"
             . " Más datos... </button></div>"
              . "<div id='div_exp$cont_TD' class='collapse'>" ;
    $item_TD .=  "<table>" ;

    $array_TD[10000]["TD"]= $item_TD ;
    $array_TD[10000]["en_linea"]= 0 ;

    $item_TD=   "</table>" ;
    $item_TD .=  "</div>" ;
    $item_TD .=  "<table>" ;

    $array_TD[19999]["TD"]= $item_TD ;
    $array_TD[19999]["en_linea"]= 0 ;
}
if ($max_fila>20000)  // si tenemos campos con orden de fila mayor a 20.000 , SON OCULTOS. solo se muestran a los ADMIN_CHAT
{
    $cont_TD++ ;

    $item_TD =  "</table>" ;
    $item_TD .=  "<div class='div_boton_expand'><button data-toggle='collapse'   class='btn btn-link btn-block btn-lg noprint' style='border:none;text-align:left;' data-target='#div_exp$cont_TD'>"
             . " Ocultos.. (solo admin_chat) </button></div>"
              . "<div id='div_exp$cont_TD' class='collapse'>" ;
    $item_TD .=  "<table>" ;

    $array_TD[20000]["TD"]= $item_TD ;
    $array_TD[20000]["en_linea"]= 0 ;

    $item_TD=   "</table>" ;
    $item_TD .=  "</div>" ;
    $item_TD .=  "<table>" ;

    $array_TD[99999]["TD"]= $item_TD ;
    $array_TD[99999]["en_linea"]= 0 ;
}

 
ksort($array_TD);   // ORDENAMOS EL ARRAY POR SU KEY
$content_ficha .="<table id='$idtabla' class='tabla_ficha2' >" ;

//echo implode($array_TD) ;

$td_abierto=0;
foreach ($array_TD as $value) {
    if (!$value["en_linea"])
    {  
        $content_ficha .=($td_abierto)?  "</td></tr>" : ""  ;  // si está abierto lo cerramos
         $content_ficha .= "<tr><td colspan='2'>" ;
        //                 echo  "<TD class='etiqueta'>$TD_etiqueta</TD>" ;
        //                 echo  "<TD>$TD_valor</TD>"  ;
         $content_ficha .=$value["TD"]  ;
//         echo  "</td></tr>" ;
         $td_abierto=1 ;
         
    }else   // el campo va en línea
    {
        $content_ficha .=(!$td_abierto)?  "<tr><td colspan='2'>" : ""  ;  // si NO está abierto lo abrimos
        $content_ficha .=$value["TD"]  ;
         $td_abierto=1 ;
    }    
    
}

$content_ficha .=($td_abierto)?  "</td></tr>" : ""  ;  // si está abierto lo cerramos



$content_ficha .=  $item_TD_final ;   
$content_ficha .=  "</table>" ;   





?>



            <!-- PINTAMO EN HTML -->
            <div class="card  <?php echo $ficha_collapse ;?>">
              <div class="card-header border-0">

                <h2 class="card-title">
                  <button type="button" class="btn btn-tool btn-sm" data-card-widget="collapse">
                    <i class="far fa-calendar-alt"></i> <?php echo "Datos generales";?>
                  </button>
                </h2>
                <!-- tools card -->
                <div class="card-tools">
                  <!-- button with a dropdown -->
                  <div class="btn-group">
                    <button type="button" class="btn btn-tool btn-sm dropdown-toggle" data-toggle="dropdown" data-offset="-52">
                      <i class="fas fa-bars"></i></button>
                    <div class="dropdown-menu" role="menu">
                       
                      <a href="<?php echo $href_subir_doc ;?>" target='_blank' class="dropdown-item"><i class='fas fa-cloud-upload-alt'></i> Subir doc</a>
                      <a href="#" onclick="<?php echo $onclick_anadir_link ;?>" target='_blank' class="dropdown-item"><i class='fas fa-link'></i> Añadir link </a>
                      <div class="dropdown-divider"></div>
                      <a href="#" class="dropdown-item">View calendar</a>
                    </div>
                  </div>
                  <button type="button" class="btn btn-tool btn-sm" data-card-widget="collapse">
                    <i class="fas fa-minus"></i>
                  </button>
                  <button type="button" class="btn btn-tool btn-sm" data-card-widget="maximize"><i class="fas fa-expand"></i>
                  </button>
                  
                  <button type="button" class="btn btn-tool btn-sm" data-card-widget="remove">
                    <i class="fas fa-times"></i>
                  </button>
                  
                </div>
                <!-- /. tools -->
              </div>
              <!-- /.card-header -->
              <div class="card-body pt-0">
                <!--The calendar -->
<!--                <div id="calendar" style="width: 100%"></div>-->
                 <?php echo $content_ficha ;?>

              </div>
              <!-- /.card-body -->
            </div>
            <!-- /.card -->













<?php 
echo   "</div>" ;   


//   eliminamos variables usadas
unset( $titulo, $msg_tabla_vacia,  $add_link,  $links, $formats, $format_style, $tooltips, $actions_row, $updates,$dblclicks ,$id_agrupamiento, $sin_botones ) ;
//unset de TABLA.PHP
// unset(  $tabla_update, $id_update ) ;  // NO LAS UNSET PARA USARLAS EN WIDGET_DOCUMENTOS PARA EL DOC PREDETERMINADO

 unset(  $tabla_footer,$add_link_html, $add_link, $ficha_expandida,$tabla_expandible, 
         $array_sumas,$valign,$colspan,$col_subtotal,$print_id,  $buttons ) ;


?>
 
      <!--   UPDATE `FACTURAS_PROV` SET `Modo_Envio_Pagare` = 'METALICO_' WHERE `FACTURAS_PROV`.`ID_FRA_PROV` = 3;-->
<script>

$( document ).ready(function() {
//    alert( $("#div_ficha").width() ) ;
     var w = $("#div_ficha").width()*.60 ;
//     var w = $("#div_td").width()*.9 ;
     $(".textarea_ficha").width( w ) ;  // ancho de los TEXT_EDIT
     $(".redimensionable").width( w ) ;   // ancho del los DIV_EDIT
//     $(".span_general").width( w ) ;   // ancho del los DIV_EDIT
});

function ficha_down_font_size(id_tabla) {
    $( id_tabla).css( "font-size", "-=3" );
}

function ficha_up_font_size(id_tabla) {
    $( id_tabla ).css( "font-size", "+=3" );
}
    
    

// INICIO SHOWHINT  

//function showHint(str,ts) {
//  var xhttp;
//  if (str.length == 0) { 
//    document.getElementById("sugerir").innerHTML = "";
//    return;
//  }
//  xhttp = new XMLHttpRequest();
//  xhttp.onreadystatechange = function() {
//    if (this.readyState == 4 && this.status == 200) {
//      document.getElementById("sugerir").innerHTML = this.responseText;
//    }
//  };
//  xhttp.open("GET", "../obras/obras_ajax.php?filtro="+str+"&tipo_subcentro="+ts, true);
//  xhttp.send();   
//}	


function ficha_update_select_showHint_ENTER(pcont) {

// hago click en el primer elemento de la lista 'li'
document.getElementById(pcont).getElementsByTagName("ul")[0].getElementsByTagName("li")[0].getElementsByTagName("a")[0].click() ;

}   


function ficha_update_select_showHint(cadena_select_enc, prompt, valor0, pcont, otro_where, str) {
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
//           alert(pcont) ;
//            var ul_id="ul_" + pcont.substr(1) ;
//            document.getElementById("ul_id").getElementsByTagName ("li")[1].getElementsByTagName ("a").click() ;
//            alert(document.getElementById(pcont).getElementsByTagName("ul")[0].getElementsByTagName("li")[0].getElementsByTagName("a")[0]) ;
            //
//            document.getElementById(pcont).getElementsByTagName("ul")[0].getElementsByTagName("li")[0].getElementsByTagName("a")[0].click() ;
//            document.getElementById("ul_id").getElementsByTagName("li")[0].getElementsByTagName("a").click() ;
            
      //document.getElementById("sugerir_obra").innerHTML = this.responseText;
      }
  };
  
  xhttp.open("GET", "../include/select_ajax_showhint.php?url_enc="+cadena_select_enc+"&url_raw="+encodeURIComponent( nuevo_valor+"&otro_where="+otro_where) , true);
  xhttp.send();   
 
}   

//function onClickAjax(id_obra, nombre_obra) {
////alert(val);
////document.getElementById("obra").value = val;
//window.location="obras_ficha.php?id_obra="+id_obra+"&nombre_obra="+nombre_obra;
//
////$("#txtHint").hide();
//}
function ficha_select_onchange_showHint(id,cadena_link,href) {
 
    
    // valores por defecto    
 href = href || ""     ;        // por defecto no hay msg

       nuevo_valor=id ;      // es el id_valor seleccionado
//       nuevo_valor=x.options[i].value ;
//       cadena_link=x.options[0].value ;      // la cadena_link va metida en la primera options.value
//       alert("el nuevo id es: "+cadena_link+nuevo_valor) ;
       var xhttp = new XMLHttpRequest();
     xhttp.onreadystatechange = function() {
    if (this.readyState == 4 && this.status == 200) {
        
        if (this.responseText.substr(0,5)=="ERROR")
        { alert(this.responseText) ;}                   // mostramos el ERROR
        else
        {  
            
//            alert(this.responseText) ;     //debug
//            alert('hecho') ;     //debug
            if (href)  {js_href(href,1) ; }   // si hay algún href lo ejecutamos al terminar el UPDATE y refrescamos
            location.reload(true); }  // refresco la pantalla tras edición
       
      }
   };
   xhttp.open("GET", "../include/update_ajax.php?"+cadena_link+nuevo_valor, true);
   xhttp.send();   
   
}  

// FIN SELECT SHOHINT *************



// SELECT TRADICIONAL
function ficha_update_select(cadena_select_enc, prompt, valor0, pcont, otro_where) {
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
        {   
//            alert(this.responseText) ;                                // debug
            document.getElementById(pcont).innerHTML = this.responseText ;
            // compruebo si hay un solo resultado (dos OPTIONS)
//            alert(pcont) ;                                // debug
            
             var select_id="select_" + pcont.substr(1) ;
             if (document.getElementById(select_id).length==2)   // ha respondido un único resultado (dos filas)
             {
//               alert(document.getElementById(select_id).selectedIndex) ;  
              document.getElementById(select_id).selectedIndex=1 ;          // selecciono la única OPTION (fila 1)
              ficha_select_onchange(select_id) ;                            // fuerzo a su registro
             }else
             {
              document.getElementById(select_id).size=10;
              document.getElementById(select_id).focus();       // abro el SELECT
              document.getElementById(select_id).click();
//              document.getElementById("label_"+select_id).focus();
//              document.getElementById("label_"+select_id).click();
              
//              document.getElementById(select_id).focus();       // abro el SELECT
//              document.getElementById(select_id).click();
             }    
//             alert(document.getElementById(select_id).selectedIndex) ;                                // debug
            
//             var x = document.getElementById(pcont);
//             var i = x.selectedIndex;
//
//            alert(i) ;                                // debug
//            alert(document.getElementById(select_id).options[1].text) ;
//            alert(document.getElementById(select_id).length) ;
        }  
      
      }
  };
  
  xhttp.open("GET", "../include/select_ajax.php?url_enc="+cadena_select_enc+"&url_raw="+encodeURIComponent( nuevo_valor+"&otro_where="+otro_where) , true);
  xhttp.send();   
   }
   else
   {return;}
   
}

function ficha_select_onchange(select_id) {
     
    var x = document.getElementById(select_id);
    var i = x.selectedIndex;
    //document.getElementById("demo").innerHTML = x.options[i].text; 
   //var x = document.getElementById(select_id).value; 
//    var ok=window.confirm("Cambiar a "+ x.options[i].text  );       // ANULAMOS LA PREGUNTA DE ¿Cambiar a...?

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
// FIN SELECT TRADICIONAL


//$( function() {
//    $( "#datepicker" ).datepicker();
//  } );
// 

//debug anulado juand ene19
$('#datepicker').datepicker({
    format: "dd/mm/yyyy"
});
// $(document).on('ready', function(){
//  $("#datepicker").datepicker(); // initialize all datepickers at once
// }); 

function ficha_update_boolean(cadena_link, nuevo_valor, tipo_dato , elementId , idlabel_chk ) {
    
    //valores por defecto
     tipo_dato = tipo_dato || 'boolean';
     elementId = elementId || '';
     idlabel_chk = idlabel_chk || '';
    

 nuevo_valor= nuevo_valor ? 1 : 0;
// alert(idlabel_chk) ;
 if ((tipo_dato==='semaforo') || (tipo_dato==='semaforo_not'))
 {
  
//    alert(document.getElementById(idlabel_chk).style.backgroundColor ) ;          //style.backgroundColor = "red"
    if (document.getElementById(idlabel_chk).style.backgroundColor == 'red')        // si es rojo lo pasamos a verde y al reves
        {document.getElementById(idlabel_chk).style.backgroundColor='green' ;}  
        else if
        (document.getElementById(idlabel_chk).style.backgroundColor=='green')
        { document.getElementById(idlabel_chk).style.backgroundColor='red' ;}   
 }
 
 var xhttp = new XMLHttpRequest();
 xhttp.open("GET", "../include/update_ajax.php?"+cadena_link+nuevo_valor, true);
 xhttp.send();   
   
}


function ficha_update_div_edit(cadena_link, nuevo_valor, elementId ) {
    
    //var valor0 = valor0_encode;
    //var valor0 = JSON.parse(valor0_encode);
//    var nuevo_valor=window.prompt("Nuevo valor de "+prompt , valor0);
//    var nuevo_valor= valor0;
//    alert("el nuevo valor es: "+valor) ;

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
//                   alert("dentro");
                   document.getElementById(elementId).innerHTML = this.responseText ;  // redibujamos el campo con lo guardado en bbdd
                   document.getElementById(elementId).value = this.responseText ;
                }  
          }
      };

  nuevo_valor=encodeURIComponent(nuevo_valor) ;
//  alert(nuevo_valor) ;
  xhttp.open("GET", "../include/update_ajax.php?"+cadena_link+nuevo_valor+"&tipo_dato=div_edit", true);
  xhttp.send();   
   
}
function ficha_update_fecha(cadena_link, nuevo_valor ) {
    
    //var valor0 = valor0_encode;
    //var valor0 = JSON.parse(valor0_encode);
//    var nuevo_valor=window.prompt("Nuevo valor de "+prompt , valor0);
//    var nuevo_valor= valor0;
//    alert("el nuevo valor es: "+valor) ;

 var xhttp = new XMLHttpRequest();
// xhttp.onreadystatechange = function() {
// if (this.readyState == 4 && this.status == 200) {
//      }
//  };
  nuevo_valor=encodeURIComponent(nuevo_valor) ;
//  alert(nuevo_valor) ;
  xhttp.open("GET", "../include/update_ajax.php?"+cadena_link+nuevo_valor+"&tipo_dato=date", true);
  xhttp.send();   
   
}
function ficha_update_numero(cadena_link, prompt, valor0, pcont) {
    
    //var valor0 = valor0_encode;
    //var valor0 = JSON.parse(valor0_encode);
    var nuevo_valor=window.prompt("Nuevo valor numérico o expresión (=...) de "+prompt , valor0);
//    alert("el nuevo valor es: "+valor) ;
   if (!(nuevo_valor === null))
   { 
       
       // si no es explresión a evaluar, ej:  == 3 * 4 , quitamos simbolos y comas, pasamos a formato numerico
//       if (! (nuevo_valor.substr(0,1) == "=")) 
//       {
////           nuevo_valor=dbNumero(nuevo_valor) ;
//       }    
       
       
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
  nuevo_valor=encodeURIComponent(nuevo_valor);
  
  xhttp.open("GET", "../include/update_ajax.php?"+cadena_link+nuevo_valor+"&tipo_dato=num", true);
  xhttp.send();   
   }
   else
   {return;}
   
}

async function paste(funcion_parametro) {
  const text = await navigator.clipboard.readText();
//  document.getElementById('textarea22').value = text;
//  input.value = text;
//alert('1.-el portapapeles tiene: ' + text ) ;
funcion_parametro(text);
//return text.value ;
return  ;
}

function prueba(texto)
{
    alert('2.-esto es una prueba el texto es: ' + texto);
    alert('3.-nuevo valor de textarea:' + document.getElementById('textarea22').value);
}

function ficha_update_str(cadena_link, prompt, valor0, pcont, nuevo_valor,tipo_dato ) {
//     valores por defecto
     nuevo_valor = nuevo_valor || '';
     tipo_dato = tipo_dato || '';
//   
   var cad_tipo_dato = "";
   var refrescar=false ;
//   
//    alert(cadena_link) ;
    //var valor0 = valor0_encode;
    //var valor0 = JSON.parse(valor0_encode);
    
    // el valor nuevo_valor es opcional, si no se pasa, se pregunta por él y se intenta NO REFRESCAR si todo va bien.
    if ( nuevo_valor === '' )
    {   
      nuevo_valor=window.prompt("Nuevo valor de "+prompt , valor0);
      
      refrescar=false ;  // NO REFERSCO la página para comodidad del usuario,comprobaré que el UPDATE ha sido exitoso por ajax.
    } else if ( nuevo_valor === '_PASTE_FROM_CLIPBOARD_' )          // FUNCION OBSOLETA
    {  
//      nuevo_valor=paste();   // el parámetro nuevo_valor está definido, no se le consulta al usuario. Posiblemente es una actualización masiva. Hay que refrescar.
////      paste() ;
//      nuevo_valor=document.getElementById('textarea22').value;   
//      alert('supuestamente he terminado') ;
//      nuevo_valor=navigator.clipboard.readText();   // el parámetro nuevo_valor está definido, no se le consulta al usuario. Posiblemente es una actualización masiva. Hay que refrescar.
//      nuevo_valor=navigator.clipboard.readText();   // el parámetro nuevo_valor está definido, no se le consulta al usuario. Posiblemente es una actualización masiva. Hay que refrescar.
      refrescar=true ;     // variable para indicar si hay que refrescar pantalla tras la actualizacion       
    }    
     else
    {                          // el parámetro nuevo_valor está definido, no se le consulta al usuario. Posiblemente es una actualización masiva. Hay que refrescar.
//      refrescar=true ;     // variable para indicar si hay que refrescar pantalla tras la actualizacion    ( DESHABILITAMOS TEMPORALMENTE para mejorar efectividad de paste , juand, ene20   
    }    
    
if (tipo_dato === 'date')
   { cad_tipo_dato = '&tipo_dato=date'  ;
       refrescar=true ; 
   }else if (tipo_dato === 'num')
   { cad_tipo_dato = '&tipo_dato=num'  ;
       refrescar=false ; 
   }   
    
    
//    alert("el nuevo valor es: "+valor) ;
   if (!(nuevo_valor === null))
   { 
       nuevo_valor=encodeURIComponent(nuevo_valor) ;
       var xhttp = new XMLHttpRequest();
     xhttp.onreadystatechange = 
      function()
       {
            if (this.readyState == 4 && this.status == 200)
            {
                if (this.responseText.substr(0,5)=="ERROR")
                   { alert(this.responseText) ;
                   }                                        // hay un error y lo muestro en pantalla
                    else
                    { 
                        document.getElementById(pcont).innerHTML = this.responseText ;   // Aquí pinto el valor devuelto tras el Update por la BBDD y lo pinto en su celda
//                        $('#'+pcont).append( this.responseText) ;   // Aquí pinto el valor devuelto tras el Update por la BBDD y lo pinto en su celda
                        if (refrescar)
                        {location.reload();
                        }                               // NO REFRESCOr la página (salvo  para comodidad del usuario 
                    }  // "pinto" en la pantalla el campo devuelto por la BBDD tras el Update        
             }
       };
  xhttp.open("GET", "../include/update_ajax.php?"+cadena_link+nuevo_valor+cad_tipo_dato, true);
//  xhttp.open("GET", "../include/update_ajax.php?"+cadena_link+nuevo_valor, true);
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
       
  