

<?php 

// VARABLES A DEFINIR PREVIAMENTE
//$tipo_entidad='personal' ;
//$id_entidad=$id_personal;
//$id_subdir=$id_personal ;
//


//echo "<h2>Documentos ({$result->num_rows})</h2>" ;

//echo  "<div class='div_boton_expand'><button data-toggle='collapse' class='btn btn-default btn-block btn-lg' data-target='#div_firmas'>"
//                             . " Firmas ({$result->num_rows}) </button></div>"
//                              . "<div id='div_firmas' class='collapse in'>" ;


require_once("../include/funciones_js.php");

$observaciones_firma = isset($observaciones_firma) ? $observaciones_firma : '' ;

$sql_insert= "INSERT INTO `Firmas` (`tipo_entidad`, `id_entidad`,`id_usuario`, firma ,observaciones, id_usuario_emisor,  user) "
        . "VALUES ( '$tipo_entidad', '$id_entidad', '_VARIABLE1_' , '$firma','_VARIABLE2_' , '{$_SESSION['id_usuario']}', '{$_SESSION['user']}' );"   ;

// campo usuario q quien envio la firma        
$add_link_html= "<div style='width:100% ; border-style:solid;border-width:2px; border-color:silver ;font-size:xx-small;'>" 
               . "<br>Añadir firma: <select  id='id_usuario_wf'   style='width: 30%; border-color:silver;color:grey; '>"
               . DOptions_sql("SELECT id_usuario, usuario FROM Usuarios WHERE activo AND $where_c_coste ORDER BY usuario  ", "Selecciona Usuario...") 
               . "  </select>" ;    

// añadimos campo observaciones (opcional)
$add_link_html.= "<input type='text' id='id_observaciones' placeholder='Mensaje...  (opcional)'>"  ;

//añadimos boton para 'añadir firma' al Portafirmas
$href='../include/sql.php?sql=' . encrypt2($sql_insert)  ;    
$add_link_html.= "<a class='btn btn-warning btn-xs noprint' href='#' "
     . " onclick=\"js_href('$href' ,'1','', 'id_usuario_wf', 'id_observaciones'  )\"   "
     . "title='añadir firma de usuario' ><i class='fas fa-pen-nib'></i></a>" ;

$add_link_html.= "<br></div>" ;


$tabla_expandida= 0;





$result=$Conn->query($sql="SELECT id_firma, id_usuario, usuario, pdte, conforme, no_conforme, observaciones,user FROM Firmas_View WHERE tipo_entidad='$tipo_entidad' AND id_entidad=$id_entidad AND $where_c_coste ");

if ($firmas=$result->num_rows)
{
  $result_T=$Conn->query($sql="SELECT '' as a, SUM(pdte) as pdtes, SUM(conforme) as conformes, SUM(no_conforme) as no_conformes "
            . " FROM Firmas_View WHERE tipo_entidad='$tipo_entidad' AND id_entidad=$id_entidad AND $where_c_coste ");
  $rs_T = $result_T->fetch_array(MYSQLI_ASSOC) ;
  
  $conforme_txt = ($rs_T["no_conformes"]) ? "<font color=red>NO CONFORME</font>" : 
                  ( ($rs_T["pdtes"]) ? "<font color=orange>PDTE FIRMAS</font>" :  
                  (($rs_T["conformes"]==$firmas) ? "<font color=green>CONFORME</font>" :
                   "Error en conformidad"))  ;
//  $tabla_expandida= !($rs_T["conformes"]==$firmas)  ;   // si es CONFORME no expandimos las firmas
  
}else
{
//  $conforme_txt = "no hay firmas" ;    
  $conforme_txt = "" ;    // no mostramos ningun mensaje porque hay 0 firmas  , juand, sep-2020
}    

$updates=['pdte','conforme','no_conforme', 'observaciones'] ;
$formats["pdte"]='boolean' ;
$formats["conforme"]='semaforo' ;
$formats["no_conforme"]='semaforo_not' ;

$tabla_update="Firmas" ;
$id_update="id_firma" ;
//  $id_valor=$id_pago ;
$actions_row["id"]="id_firma";
$actions_row["delete_link"]="1";
$actions_row["delete_confirm"]=0;
        
$titulo="Firmas ($firmas) $conforme_txt" ;       
$msg_tabla_vacia="No hay firmas";
$tabla_style=" style='font-size:xx-small;' " ;

require("../include/tabla.php"); echo $TABLE ;  // firmas
 

//
//
//echo "<a class='btn btn-link noprint' href=\"../documentos/doc_upload_multiple_form.php?tipo_entidad=$tipo_entidad&id_subdir=$id_subdir&id_entidad=$id_entidad\" "
//        . "target='_blank' ><i class='fas fa-cloud-upload-alt'></i> Subir doc.(pdf, jpg, xls...) </a>" ;
//
//$fecha_doc=date('Y-m-d');
//
//$sql_insert= "INSERT INTO `Documentos` (`id_c_coste`, `tipo_entidad`, `id_entidad`,`id_subdir`, `documento`, `nombre_archivo`,   `path_archivo`, `tamano`, `Observaciones` ,fecha_doc, user) "
//        . "VALUES ( '{$_SESSION['id_c_coste']}', '$tipo_entidad', '$id_entidad', '$id_subdir', 'link', '','_VARIABLE1_', '0', '', '$fecha_doc', '{$_SESSION['user']}' );"   ;
//
//$href='../include/sql.php?sql=' . encrypt2($sql_insert)  ;    
//echo "<a class='btn btn-link btn-xs noprint btn_topbar' href='#' "
//     . " onclick=\"js_href('$href' ,'1','', 'PROMPT_Introduce_link'  )\"   "
//     . "title='anexar documento por su link (URL, Dropbox, Google Drive, ...)' ><i class='fas fa-link'></i> Añadir LINK </a>" ;
//


 
 ?>


