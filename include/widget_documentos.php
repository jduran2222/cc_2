

<style>

@media only screen and (max-width:980px) {
  /* For mobile phones: antes 500px */
   img {
     width: 80%;
  }
 
}


    /*#wrap { width: 600px; height: 390px; padding: 0; overflow: hidden; }*/
    .frame { width: 800px; height: 520px; border: 1px solid black; }
    .frame {
        -ms-zoom: 0.55;
        -moz-transform: scale(0.55);
        -moz-transform-origin: 0 0;
        -o-transform: scale(0.55);
        -o-transform-origin: 0 0;
        -webkit-transform: scale(0.55);
        -webkit-transform-origin: 0 0;
    }

</style>

<?php  



// VARABLES A DEFINIR PREVIAMENTE
//$tipo_entidad='personal' ;
//$id_entidad=$id_personal;
//$id_subdir=$id_personal ;
//

require_once("../include/funciones_js.php");

$content_wd = "" ; // inicializo el contenedor de todo el widget


$result_wd=$Conn->query($sql="SELECT id_documento, documento,nombre_archivo, path_archivo FROM Documentos "
        . " WHERE tipo_entidad='$tipo_entidad' AND id_entidad=$id_entidad AND $where_c_coste ORDER BY orden, id_documento");

//$content_wd .= "<h2>Documentos ({$result_wd->num_rows})</h2>" ;


//$table_collapse= isset($tabla_expandida) ? ($tabla_expandida ?  'collapse in' : 'collapse') : 'collapse'  ;   // por defecto NO EXPANDIDA
$card_collapse= isset($tabla_expandida) ? ($tabla_expandida ?  '' : 'collapsed-card') : 'collapsed-card'  ;   // por defecto NO EXPANDIDA

//$content_wd .=  "<div class='div_boton_expand'><button data-toggle='collapse' class='btn btn-default btn-block btn-lg noprint' data-target='#div_documentos' style='text-align:left;'>"
//                             . " Documentos ({$result_wd->num_rows}) </button></div>"
//                              . "<div id='div_documentos' class='$table_collapse'>" ;

$titulo_wd = "Documentos ({$result_wd->num_rows})" ;                             
                             
                             
// upload documento
//$content_wd .= "<a class='btn btn-link btn-xs  noprint' href=\"../documentos/doc_upload_multiple_form.php?tipo_entidad=$tipo_entidad&id_subdir=$id_subdir&id_entidad=$id_entidad\" "
//        . "target='_blank' ><i class='fas fa-cloud-upload-alt'></i> Subir doc </a>" ;
$href_subir_doc = "../documentos/doc_upload_multiple_form.php?tipo_entidad=$tipo_entidad&id_subdir=$id_subdir&id_entidad=$id_entidad" ;


// documento por LINK
$fecha_doc=date('Y-m-d');

$sql_insert= "INSERT INTO `Documentos` (`id_c_coste`, `tipo_entidad`, `id_entidad`,`id_subdir`, `documento`, `nombre_archivo`,   `path_archivo`, `tamano`, `Observaciones` ,fecha_doc, user) "
        . "VALUES ( '{$_SESSION['id_c_coste']}', '$tipo_entidad', '$id_entidad', '$id_subdir', 'link', '','_VARIABLE1_', '0', '', '$fecha_doc', '{$_SESSION['user']}' );"   ;

$href='../include/sql.php?sql=' . encrypt2($sql_insert)  ;    
//$content_wd .= "<a class='btn btn-link btn-xs noprint ' href='#' "
//     . " onclick=\"js_href('$href' ,'1','', 'PROMPT_Introduce_link'  )\"   "
//     . "title='anexar documento por su link (URL, Dropbox, Google Drive, ...)' ><i class='fas fa-link'></i> Añadir link </a>" ;
$onclick_anadir_link = "js_href('$href' ,'1','', 'PROMPT_Introduce_link'  )" ;

// importar id_documento ya subido y PDTE_CLASIFICAR  (permitimos importar cualquier documento aun NO PDTE_CLASIFICAR, juand abril20)
//$sql_import= "UPDATE `Documentos` SET `tipo_entidad` = '$tipo_entidad', `id_entidad` = '$id_entidad', `id_subdir` = '$id_subdir'  "
//        . " WHERE  tipo_entidad = 'pdte_clasif' AND $where_c_coste AND id_documento=_VARIABLE1_ ; "  ;
$sql_import= "UPDATE `Documentos` SET `tipo_entidad` = '$tipo_entidad', `id_entidad` = '$id_entidad', `id_subdir` = '$id_subdir'  "
        . " WHERE   $where_c_coste AND id_documento=_VARIABLE1_ ; "  ;
        

$href='../include/sql.php?sql=' . encrypt2($sql_import)  ;    

//$content_wd .= "<a class='btn btn-link btn-xs noprint ' href='#' "
//     . " onclick=\"js_href('$href' ,'1','', 'PROMPT_Introduce_ID_DOCUMENTO'  )\"   "
//     . "title='Importar documento existente y pendiente de Clasificar a esta ficha. Indicar número de ID_DOCUMENTO' ><i class='fas fa-file-import'></i> Importar doc.</a>" ;
$onclick_importar_doc = "js_href('$href' ,'1','', 'PROMPT_Introduce_ID_DOCUMENTO'  )" ;



// generar DOCUMENTO desde Plantilla
// creamos un FORM 

$content_wd .="<div class='div_boton_expand'>"
            . "<button data-toggle='collapse' class='btn btn-link btn-xs noprint' data-target='#div_generar_doc' title='Genera un documento desde una plantilla con los datos de la entidad'>"
            . "Generar doc </button>"
            . "</div>"
            . "<div id='div_generar_doc' class='collapse in'  style='border:1px solid silver;'>" ;


$content_form_generar =  "<form action='../documentos/generar_PDF.php' method='post' id='form_generar' name='form_generar' target='_blank'>"    ;
 
$plantillas=scandir("../plantillas") ;
$select_plantillas= "<select class='btn btn-xs btn-default noprint'  name='plantilla_html'  id='plantilla_html' >"
        . "<option value='0'>Plantilla</option>" ;

foreach ($plantillas as $valor)
{
    $select_plantillas.= ($valor<>"." AND $valor<>"..") ?  "<option value='$valor'>$valor</option>" : "" ;             
}
$select_plantillas.= "  </select>" ;   
$content_form_generar .= $select_plantillas ;

$array_plantilla = isset($array_plantilla) ? $array_plantilla : "" ;
$array_plantilla_json= json_encode($array_plantilla) ;        // pasamos el array a JSON
$content_form_generar .= "<input type='hidden'  id='array_plantilla_json'  name='array_plantilla_json' value='$array_plantilla_json'>"   ;

//$href='../documentos/generar_PDF.php?plantilla=_VARIABLE1_ ' ;    

//$content_wd .= "<a class='btn btn-link btn-xs noprint btn_topbar' href='../documentos/generar_PDF.php?plantilla=pof.html$plantilla_get_url' target='_blank' "


// elección de EXT
$content_form_generar .= ""
 . "<div class='btn-group btn-xs' data-toggle='buttons'>"
 . "<label class='btn btn-default btn-xs active'><input type='radio' id='ext' name='ext' value='' checked />ver     </label> "
 . "<label class='btn btn-default btn-xs  '><input type='radio' id='ext' name='ext' value='.pdf'   />pdf</label>"
 . "<label class='btn btn-default  btn-xs '><input type='radio' id='ext' name='ext' value='.doc' title='Exporta a .DOC (en pruebas)'  />doc</label>"
 . "<label class='btn btn-default  btn-xs '><input type='radio' id='ext' name='ext' value='.xls' title='Exporta a .XLS (en pruebas)'  />xls</label>"
 . "</div>"
 . "" ;



$content_form_generar .= "<input type='submit' style='float:right;' class='btn btn-primary btn-xs noprint'"
     . " title='Genera un documento nuevo con la plantilla seleccionada y datos de la entidad'  id='submit' name='submit' value='generar doc' >" ;
$content_form_generar .= "</form>" ;

$content_wd .= $content_form_generar ;

$content_wd .= "</div>" ;


//$content_wd .= "<a class='btn btn-link btn-xs noprint btn_topbar' href='#'  "
//     . " onclick=\"generar_PDF('$plantilla_get_url')\"   "
//     . " title='Genera documento PDF desde plantilla y con datos de la ficha' ><i class='fas fa-link'></i> Generar doc.</a>" ;



$content_wd .= "<br>" ;
$size=isset($size)? $size : '100px' ;
$resolucion=isset($resolucion)? $resolucion : '_large.jpg' ;     // por defecto mostramos el tamaño grande

if ($result_wd->num_rows > 0)
 {  
    
    

    
    //$content_wd .= "<a href=\"$path_archivo\" >descargar PDF</a><br>" ;
     while ($rs_wd = $result_wd->fetch_array(MYSQLI_ASSOC))
        {
	
         $path_archivo=$rs_wd["path_archivo"] ;
         $id_documento=$rs_wd["id_documento"] ;
         
         
	//$content_wd .= "<a href=\"$path_archivo_large.png\" ><img src=\"$path_archivo_medium.png\" >  </a>" ;
	//$content_wd .= "<a href=\"$path_archivo_large.jpg\" ><img src=\"$path_archivo_large.jpg\" >  </a>" ;
        $content_wd .= "<div style='margin: 20px ; border:1px solid white;'>" ;  
//        $content_wd .= "<h5>".cc_format($rs_wd["documento"],'textarea_30')."</h5>" ; 
        
        $dir_raiz=$_SESSION["dir_raiz"] ;
        
        $is_link=(like($path_archivo,'http%')) ;     // determina si es un archivo local o un link
        $is_local= !$is_link  ;
        $is_foto_link_mostrable= ( like($path_archivo,'https%jpg') OR  like($path_archivo,'https%jpeg') OR  like($path_archivo,'https%png') ) ;
        
        
        $link_pdf = str_replace("web/","" , $dir_raiz) . str_replace("../../","" , $path_archivo)  ;

        $content_wd .= $rs_wd["documento"] ? "<a class='btn btn-link btn-xs noprint transparente' href=\"$path_archivo\" target='_blank' title='$path_archivo'>{$rs_wd["documento"]}</a>"."<br>" : "" ; 
//        $content_wd .= "<a class='btn btn-link btn-xs noprint transparente' href=\"$path_archivo\" target='_blank' title='$path_archivo'>".cc_format($path_archivo,'textarea_50')."</a>" ; //INNECESARIO, juand, jun20

//        $content_wd .= 'JUAN DURAN' ;
        // BOTONES CAMBIO TAMAÑO 
        $id_imagen="img_" . $id_documento ;
        $content_wd .= "<br><button type='button' class='btn btn-link btn-xs noprint transparente' onclick=down_img_size(document.getElementById('$id_imagen'))  title='disminuir tamaño imagen'><i class='fas fa-search-minus'></i></button>" ;
        $content_wd .= "<button type='button' class='btn btn-link btn-xs noprint transparente' onclick=up_img_size(document.getElementById('$id_imagen')) title='aumentar tamaño imagen' ><i class='fas fa-search-plus'></i></button>" ;
        $content_wd .= "<a class='btn btn-link btn-xs noprint transparente' href=\"$path_archivo\" target='_blank' title='descargar PDF'><i class='fas fa-cloud-download-alt'></i></a>" ;
//        $content_wd .= "<a class='btn btn-link noprint transparente' href='https://api.whatsapp.com/send?text={$dir_raiz}documentos/documento_ficha.php?id_documento=$id_documento' target='_blank' title='compartir link por WhassApp'><img src='../img/whassapp.jpg'></a>" ;
//        $content_wd .= "<a class='btn btn-link noprint transparente' href='https://api.whatsapp.com/send?text={$link_pdf}' target='_blank' title='compartir link por WhassApp'><img width='30'  src='../img/whassapp.jpg'></a>" ;
//        $content_wd .= "<a class='btn btn-link noprint transparente' href='https://api.whatsapp.com/send?text={$link_pdf}' target='_blank' title='compartir link por WhassApp'><i class='fab fa-whatsapp'></i></a>" ;
        $content_wd .= "<a class='btn btn-link btn-xs noprint transparente' href='https://wa.me/?text={$link_pdf}' target='_blank' title='compartir link por WhassApp'><i class='fab fa-whatsapp'></i></a>" ;
        $content_wd .= isset($whassapp_envio) ?  "<a class='btn btn-link noprint transparente' href='https://wa.me/$whassapp_envio?text={$link_pdf}' target='_blank' title='compartir link por WhassApp al INTERESADO'><i class='fab fa-whatsapp'></i>Int</a>" :"" ;
        $content_wd .= "<a class='btn btn-link btn-xs noprint transparente' href='../documentos/documento_ficha.php?_m=$_m&id_documento=$id_documento' target='_blank' title='ficha del documento'><i class='far fa-calendar-alt'></i></a>" ;
        $content_wd .= "<a class='btn btn-link btn-xs noprint transparente' href=# onclick=\"copyToClipboard( '$link_pdf' )\"  title='copy a portapapeles el link del documento'>"
                . "<i class='far fa-copy'></i></i></a>" ;
        // ROTACIONES    //anulado, innecesario aquí, juand jun20
//        $href_90="../documentos/doc_rotar_ajax.php?id_documento=$id_documento&path_archivo=$path_archivo&grados=90" ;
//        $href_270="../documentos/doc_rotar_ajax.php?id_documento=$id_documento&path_archivo=$path_archivo&grados=270" ;
//        $content_wd .= "<a class='btn btn-link noprint transparente' href=# onclick=\"js_href( '$href_270'  )\"   title='rotar documento -90º' >"
//                . "<i class='fas fa-undo'></i></a>" ;
//        $content_wd .= "<a class='btn btn-link noprint transparente' href=# onclick='js_href( \"$href_90\"  )'   title='rotar documento 90º'>"
//                . "<i class='fas fa-redo'></i></a>" ;



        //BOTON IMAGEN PREDETERMINADA
         // marcar como PREDETERMINADO el primer documento que se suba si existe el campo DOC_LOGO
        
        
        // vemos si existe el campo 'doc_logo' para poder hacer predeterminada la imagen en la entidad
       if (isset($rs["doc_logo"])) 
       {  
         $sql_update= "UPDATE `$tabla_update` SET doc_logo='$id_documento'  WHERE  $id_update='$id_valor'  ; "  ;        
//         if (!$rs["doc_logo"] )   // SI hay campo doc_logo y es vacío  (ANULAMOS PROV. el hacer predet. el primer doc de la entidad de forma automática
//            {
//                $Conn->query($sql_update ) ;     // si no hay doc_logo predeterminado, le asignamos el primer documento que haya
//                $pdte_doc_logo=False ;
//            }  
        $href='../include/sql.php?sql=' . encrypt2($sql_update)  ;         
        $content_wd .= "<a class='btn btn-link btn-xs noprint transparente' href=# onclick=\"js_href('$href' ,'1' )\"   title='hace este documento como imagen predeterminada de la entidad'>Predet.</a> "; 
       }
//        $links["nid_documento"] = ["../documentos/documento_ficha.php?id_documento=", "id_documento", "ver ficha documento", 'ppal'] ;

        //BOTON DELETE
        $content_wd .= "<a class='btn btn-link btn-xs noprint transparente' href=# onclick=\"delete_doc( $id_documento ,'$path_archivo')\"  title='eliminar documento'><i class='far fa-trash-alt'></i></a> "; 
        
//        $links["nid_documento"] = ["../documentos/documento_ficha.php?id_documento=", "id_documento", "ver ficha documento", 'ppal'] ;
	
        
     
       $path_archivo = ($is_local)? $path_archivo.$resolucion : $path_archivo  ;     // si es local añado la extension _large.jpg o la que corresponda
               
       if ( $is_local OR $is_foto_link_mostrable) 
       {
            $content_wd .= "<br><a style='font-size:0px'   href=\"$path_archivo\" target='_blank' ><img id='$id_imagen' width='$size' src=\"$path_archivo\"></a>" ;
       }else   // es un link no mostrable
       {    
            $content_wd .= "<br><div onclick=\"alert('5h555');\" ><a href=\"$path_archivo\" target='_blank' >"
                    . "<iframe class='frame' id='$id_imagen' width='$size' src=\"$path_archivo\" target='_blank'  onclick=\"alert('5555');\"></iframe></a></div>" ;
       } 
       
        $content_wd .= "</div>" ;  

        
        
        if (isset($size_sec)) $size=$size_sec ;   // si hay size_secundario lo cambio tras imprimir el primer doc.
               
        }
	// mostrar_tumbail(id_documento) ;
 }
 
//$content_wd .= "</div>" ;     // div del EXPAND

 
 ?>

            <!-- PINTAMOS EN HTML -->
            <div class="card <?php echo $card_collapse ;?>">
              <div class="card-header border-0">

                <h2 class="card-title">
                  <button type="button" class="btn btn-tool btn-sm" data-card-widget="collapse">
                    <i class="far fa-calendar-alt"></i> <?php echo $titulo_wd ;?>
                  </button>
                </h2>
                <!-- tools card -->
                <div class="card-tools">
                  <!-- button with a dropdown -->
                  <div class="btn-group">
                    <button type="button" class="btn btn-tool btn-sm dropdown-toggle" data-toggle="dropdown" data-offset="-52">
                      <i class="fas fa-bars"></i></button>
                    <div class="dropdown-menu" role="menu">
                       
                          <a href="<?php echo $href_subir_doc ;?>" target='_blank' class="dropdown-item small" title='Sube un documento asociado a esta entidad'><i class='fas fa-cloud-upload-alt'></i> Subir doc</a>
                          <a href="#" onclick="<?php echo $onclick_anadir_link ;?>" title='anexar documento por su link (URL, Dropbox, Google Drive, ...)' target='_blank' class="dropdown-item small"><i class='fas fa-link'></i> Añadir link </a>
                          <a href="#" onclick="<?php echo $onclick_importar_doc ;?>" title='Importar documento existente y pendiente de Clasificar a esta entidad. Indicar número de ID_DOCUMENTO' target='_blank' class="dropdown-item small"><i class='fas fa-file-import'></i> Importar doc</a>
                      <div class="dropdown-divider"></div>
                          <?php echo $content_form_generar ;?>
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
                 <?php echo $content_wd ;?>

              </div>
              <!-- /.card-body -->
            </div>
            <!-- /.card -->



<script>
function delete_doc(id_documento,path_archivo) {
    var nuevo_valor=window.confirm("¿Borrar documento? ");
//    alert("el nuevo valor es: "+valor) ;
   if (!(nuevo_valor === null) && nuevo_valor)
   { 
       cadena_link="tabla='Documentos'&wherecond=id_documento=".id_documento ; 
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
  xhttp.open("GET", "../documentos/delete_doc_ajax.php?id_documento="+id_documento+"&path_archivo="+path_archivo, true);
  xhttp.send();   
   }
   else
   {return;}
   
}
    
function down_img_size(id_imagen) {
   
    $( id_imagen ).css( "width", "-=100" );
}

function up_img_size(id_imagen) {

    $( id_imagen ).css( "width", "+=100" );

}

//function generar_PDF2(plantilla_get_url) {
//
//var plantilla=document.getElementById( "id_plantilla" ).value ;
//
//window.open( "../documentos/generar_PDF.php?plantilla="+plantilla+plantilla_get_url ,'_blank');  
//  
//return ;
//}
//
//function generar_PDF(plantilla_get_url) {
//
//var plantilla=document.getElementById( "id_plantilla" ).value ;
//
//var parametros="plantilla=" + plantilla + plantilla_get_url ;
////var parametros="plantilla=pof.html"  ;
//
////   document.body.style.cursor = 'wait';
//var xhttp = new XMLHttpRequest();
//xhttp.onreadystatechange = function() {
//if (this.readyState == 4 && this.status == 200) {
//        if (this.responseText.substr(0,5)=="ERROR")
//        { alert(this.responseText) ;}
//        else
//        {  
//          alert(this.responseText) ;     //debug
//         }  // refresco la pantalla tras editar Producción
//
//   }
//  };
//  
//  alert(parametros);
//  xhttp.open("POST", "../documentos/generar_PDF.php" , true);  // hacemos el href y eventualmente le añadimos dos parametros llamados variable 1 y 2 que el PHP sabá interpretar
//  xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
//  xhttp.setRequestHeader("Content-length", parametros.length);
//  xhttp.setRequestHeader("Connection", "close");
//
//  xhttp.send(parametros);  
////  alert( href + var1_link + var2_link );  // hacemos el href y eventualmente le añadimos dos parametros llamados variable 1 y 2 que el PHP sabá interpretar
//return ;
//}



</script>