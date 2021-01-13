

<?php 

// VARABLES A DEFINIR PREVIAMENTE
//$tipo_entidad='personal' ;
//$id_entidad=$id_personal;
//$id_subdir=$id_personal ;
//



require_once("../include/funciones_js.php");

//$observaciones_firma = isset($observaciones_firma) ? $observaciones_firma : '' ;

$fecha_modificacion=date('Y-m-d H:i:s') ;    

$sql_insert="INSERT INTO `Tareas` ( id_c_coste,tipo_entidad,id_entidad, usuarios,Tarea , fecha_modificacion , user) "
        . "   VALUES (  '{$_SESSION['id_c_coste']}','$tipo_entidad' ,'$id_entidad' ,'_VAR_SQL1_' ,'_VAR_SQL2_','$fecha_modificacion' ,'{$_SESSION['user']}' );" ;

// campo usuario q quien envio la firma        
$add_link_html= "<div style='width:100% ; border-style:solid;border-width:2px; border-color:silver;font-size:xx-small; '>" 
               . "<br>Añadir Tarea: <select  id='usuarios' style='width: 30%; '>"
               . DOptions_sql("SELECT DISTINCT  usuarios, usuarios FROM Tareas_View WHERE usuarios LIKE '%{$_SESSION['user']}%' AND $where_c_coste ORDER BY fecha_creacion DESC LIMIT 20  ", "Selecciona Usuarios...") 
               . "  </select>" ;    

// añadimos campo observaciones (opcional)
$add_link_html.= "<input type='text' id='tarea' placeholder='Tarea...'>"  ;

//añadimos boton para 'añadir firma' al Portafirmas
$href='../include/sql.php?sql=' . encrypt2($sql_insert)  ;    
$add_link_html.= "<a class='btn btn-link btn-xs noprint' href='#' "
     . " onclick=\"js_href('$href' ,'1','', 'usuarios', 'tarea'  )\"   "
     . "title='añadir tarea' ><i class='fas fa-plus-circle'></i> Añadir Tarea</a>" ;

$add_link_html.= "<br></div>" ;


$tabla_expandida= 0;





$result=$Conn->query($sql="SELECT id, Terminada, Tarea,Texto,usuarios FROM Tareas_View WHERE  usuarios LIKE '%{$_SESSION["user"]}%'"
          . " AND tipo_entidad='$tipo_entidad' AND id_entidad='$id_entidad'  AND $where_c_coste ORDER BY   fecha_creacion DESC");



$updates=['Terminada','Texto', 'usuarios'] ;

$links["Tarea"] = ["../agenda/tarea_ficha.php?id=", "id",'', 'formato_sub'] ;

$formats["Terminada"]='boolean' ;
$formats["Texto"]='text_edit' ;
$formats["conforme"]='semaforo' ;
//$formats["no_conforme"]='semaforo_not' ;

$tabla_update="Tareas" ;
$id_update="id" ;
//  $id_valor=$id_pago ;
$actions_row["id"]="id";
$actions_row["delete_link"]="1";
$actions_row["delete_confirm"]=1;
        
$titulo="Tareas ({$result->num_rows})" ;       
$msg_tabla_vacia="No hay tareas";

//$tabla_style=" style='font-size:xx-small;' " ;
$tabla_style=" style='font-size:xx-small;' " ;

require("../include/tabla.php"); echo $TABLE ;  // firmas
 



 
 ?>


