<?php
// cambios
require_once("../include/session.php");
$where_c_coste = " id_c_coste={$_SESSION['id_c_coste']} ";
$id_c_coste = $_SESSION['id_c_coste'];

$titulo = 'Parte diario';

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

<?php 


$id_parte=$_GET["id_parte"];

// require("../menu/general_menutop_r"); 
 //require("../personal/personal_menutop_r.php");
 //require("../proveedores/proveedores_menutop_r.php");

?>
	

  <?php              // DATOS   FICHA . PHP
 //echo "<pre>";
 $result=$Conn->query($sql="SELECT ID_PARTE,ID_OBRA,ID_VALE,Fecha,Observaciones,Cargado,NOMBRE_OBRA,user,fecha_creacion FROM Partes_View WHERE ID_PARTE=$id_parte AND $where_c_coste");
 $rs = $result->fetch_array(MYSQLI_ASSOC) ;
 

 $id_parte_anterior=Dfirst("ID_PARTE",'Partes_View',"ID_OBRA={$rs["ID_OBRA"]} AND Fecha<='{$rs["Fecha"]}' AND   ID_PARTE<>$id_parte AND $where_c_coste  ORDER BY Fecha DESC")  ;
 $id_parte_siguiente=Dfirst("ID_PARTE",'Partes_View',"ID_OBRA={$rs["ID_OBRA"]} AND Fecha>='{$rs["Fecha"]}' AND   ID_PARTE<>$id_parte AND $where_c_coste  ORDER BY Fecha")  ;
 
 
 
  $titulo="PARTE DIARIO DE OBRA" ;
  
//    $selects["ID_OBRA"]=["ID_OBRA","NOMBRE_OBRA","OBRAS"] ;   // datos para clave foránea
//  $links["ID_OBRA"]=["../proveedores/proveedores_ficha.php?id_proveedor=", "ID_PROVEEDORES"] ;
//$links["NOMBRE_OBRA"]=["../obras/obras_ficha.php?id_obra=", "ID_OBRA"] ;
  $selects["ID_OBRA"]=["ID_OBRA","NOMBRE_OBRA","OBRAS","../obras/obras_anadir_form.php","../obras/obras_ficha.php?id_obra=","ID_OBRA"] ;   // datos para clave foránea Y PARA AÑADIR PROVEEDOR NUEVO


  
//  $updates=['NOMBRE','DNI','F_ALTA','BAJA', 'F_BAJA' , 'Observaciones', 'pagada']  ;
  
  $ocultos=['NOMBRE_OBRA', 'Cargado'] ;
  
  $updates=[ 'ID_OBRA' ,'Fecha', 'Observaciones']  ;
//  $id_proveedor=$rs["ID_PROVEEDORES"] ;
  $tabla_update="PARTES" ;
  $id_update="ID_PARTE" ;
  $id_valor=$id_parte ;
    
  $id_obra=$rs["ID_OBRA"] ;
  $fecha=$rs["Fecha"] ;
  $nombre_obra=$rs["NOMBRE_OBRA"] ;
  $fecha_txt = date_format(date_create($fecha),"d/m/Y");
  
  $delete_boton=1;

  ?>
  
                  
                    
<div style="overflow:visible">	   
  <div id="main" class="mainc"> 
      
<?php 
// boton AÑADIR PARTE
echo "<br><a class='btn btn-xs btn-link' href='../obras/obras_anadir_parte.php?id_obra=$id_obra'  target='_blank'><i class='fas fa-plus-circle'></i> añadir Parte</a>" ;


//importar parte dia anterior $boton_importar_parte='';
if ($id_parte_anterior)
{
    $sql_insert="INSERT INTO PARTES_PERSONAL (ID_PARTE,ID_PERSONAL,HO,HX,MD,DC,Plus,PC,id_por_cuenta,ejecutado_pc,id_subobra,Observaciones)"
            . " SELECT '$id_parte',ID_PERSONAL,HO,HX,MD,DC,Plus,PC,id_por_cuenta,ejecutado_pc,id_subobra,Observaciones FROM  PARTES_PERSONAL WHERE ID_PARTE=$id_parte_anterior ;" ;
    $sql_insert.=" _CC_NEW_SQL_ INSERT INTO Partes_Maquinas (ID_PARTE,id_obra,cantidad,id_subobra,Observaciones)"
            . " SELECT '$id_parte',id_obra,cantidad,id_subobra,Observaciones FROM  Partes_Maquinas WHERE ID_PARTE=$id_parte_anterior ;" ;

    $href='../include/sql.php?sql=' . encrypt2($sql_insert)     ;
    echo "<br><a class='btn btn-link btn-xs noprint ' href='#' "
         . " onclick=\"js_href('$href','1' )\"   "
         . "title='Importa el Personal y Maquinaria Propia del Parte anterior'><i class='fas fa-file-import'></i> Importar Parte anterior</a>" ;
}


// BOTONES iMPRIMIR pdf (ANULADO , DA ERRORES)  Y cALENDARIO pARTES
// echo "<br><a class='btn btn-link btn-sm' href='../personal/parte_pdf.php?id_parte=$id_parte' ><i class='fas fa-print'></i> Imprimir PDF</a>" ;
 echo "<br><a class='btn btn-link btn-sm' href='../personal/partes.php?_m=$_m&id_obra=$id_obra' ><i class='far fa-calendar-alt'></i> Cal. Partes Obra <b>{$rs["NOMBRE_OBRA"]}</b></a>" ;

 
 
 
 
 echo "<br><br>";
// botones PARTE ANTERIOR   PARTE SUGUIENTE
 
 $html_anterior_siguiente="<div style='width:100%'>";
 $html_anterior_siguiente.= $id_parte_anterior ? "<div style='float:left'>   <a class='btn btn-link btn-xs'  title='Parte anterior' href='../personal/parte.php?_m=$_m&id_parte=$id_parte_anterior' >"
         . "<i class='fas fa-arrow-left'></i> Parte anterior</a></div>" 
         : "" ;
 $html_anterior_siguiente.= $id_parte_siguiente? "<div style='float:right'><a class='btn btn-link btn-xs' title='Parte siguiente' href='../personal/parte.php?_m=$_m&id_parte=$id_parte_siguiente' >"
         . " Parte siguiente <i class='fas fa-arrow-right'></i></a></div>" 
         : "";
 $html_anterior_siguiente.="</div>";

 echo $html_anterior_siguiente ;
     
     


  
  require("../include/ficha.php"); ?>
   
      <!--// FIN     **********    FICHA.PHP-->
  </div>
      
<!-- CONTROL CARGO A OBRA.  ID_VALE-->    
    
  <div class="right2">
	
  <?php 
 
  //COMPROBAMOS SI EXISTE VALE
  if ($id_vale=$rs["ID_VALE"])
  {
   $importe = Dfirst("importe","Vales_view","ID_VALE=$id_vale AND $where_c_coste" ) ;   
   $titulo = "<h2 style='font-weight: bold; color:green;'>CARGO M.O. y Maq. A OBRA: $importe €</h2>" ;
   $titulo .= "<a class='btn btn-link btn-xs noprint' href='../proveedores/albaran_proveedor.php?_m=$_m&id_vale=$id_vale' target='_blank' "
           . "title='ver el Albarán donde se ha cargado el coste del Personal propio y la Maquinaria Propia de este Parte'>ver Albarán de cargo...</a>" ;
   $titulo .= "<a class='btn btn-link btn-xs noprint'  href='../personal/parte_cargar_a_obra.php?id_parte=$id_parte&id_vale=$id_vale' "
           . "title='Si se modifica el Parte tras cargar a obra, hay que actualizar el Albarán de cargo de Personal y Maquinaria propia' >"
           . "<i class='fas fa-redo'></i> actualizar cargo</a>" ;
//   $titulo .= "<a class='btn btn-link btn-xs noprint' href='../proveedores/albaran_parte_eliminar.php?id_parte=$id_parte' target='_blank' >"
//           . "<i class='far fa-trash-alt'></i> eliminar cargo</a>" ;
   $titulo .= "<a class='btn btn-link btn-xs noprint' href='../personal/parte_cargar_a_obra.php?id_parte=$id_parte&&id_vale=$id_vale&delete_vale=1' target='_blank' >"
           . "<i class='far fa-trash-alt'></i> eliminar cargo</a>" ;
  }
   else
  {
   $titulo="<h1 style='font-weight: bold;color:red;'>NO CARGADO A OBRA</h1>" ;   
   $titulo .= "<a class='btn btn-primary' href='../personal/parte_cargar_a_obra.php?id_parte=$id_parte' >Cargar a obra</a>" ;
  }
   echo $titulo ;
 ?>
	 
  </div>      
	
	<!--  DOCUMENTOS  -->
	
  <div class="right2">
	
  <?php 

  $tipo_entidad='parte' ;
  $id_entidad=$id_parte;
  $id_subdir=$rs["ID_OBRA"] ;

  $entidad="Parte de $nombre_obra ($fecha_txt)" ;
  require("../menu/LRU_registro.php"); require("../include/widget_documentos.php");  

 
 ?>
	 
  </div>
	
	
<?php            // ----- div PARTES PERSONAL  tabla.php   -----<!--  DETALLE DEL PARTE -->





//$sql="SELECT id,ID_PERSONAL,NOMBRE,DNI,HO,HX,MD,DC,Observaciones FROM Partes_Personal_View  WHERE ID_PARTE=$id_parte  AND $where_c_coste    ";
$sql="SELECT id,ID_PERSONAL,NOMBRE,DNI,HO,HX, ID_SUBOBRA , Observaciones  FROM Partes_Personal_View  WHERE ID_PERSONAL<>0 AND ID_PARTE=$id_parte  AND $where_c_coste    ";
//echo $sql;
$result=$Conn->query($sql );

$sql_T="SELECT 'Suma' ,COUNT(ID_PERSONAL) as B,SUM(HO) as HO, '' FROM Partes_Personal_View  WHERE ID_PARTE=$id_parte  AND $where_c_coste    ";
//echo $sql;
$result_T=$Conn->query($sql_T );

$updates=['HO','HX','MD','DC','ID_SUBOBRA','Observaciones','DDDD']  ;
$visibles=['ID_SUBOBRA'] ;

$tabla_update="PARTES_PERSONAL" ;
$id_update="id" ;

$actions_row=[];
$actions_row["id"]="id";
$actions_row["delete_link"]="1";


$selects["ID_SUBOBRA"]=["ID_SUBOBRA","SUBOBRA","Subobra_View","../obras/subobra_anadir.php?id_obra=$id_obra","../obras/subobra_ficha.php?id_subobra=","ID_SUBOBRA","AND ID_OBRA=$id_obra"] ;   // datos para clave foránea Y PARA AÑADIR PROVEEDOR NUEVO

$links["NOMBRE"] = ["../personal/personal_ficha.php?id_personal=", "ID_PERSONAL"] ;


$titulo="Personal de Obra ($result->num_rows". cc_format( "solo_icon", "icon_usuarios") ." )" ;
$msg_tabla_vacia="No hay personal";


$add_link_html= "<div >Añadir Personal:<select id='id_personal' style='width: 50%;' > "
               . "<option value='0' >Selecciona personal...</option>" 
              . DOptions_sql("SELECT ID_PERSONAL,CONCAT(NOMBRE,'       (',DNI,')') FROM PERSONAL WHERE BAJA=0 AND $where_c_coste ORDER BY NOMBRE ")
              .  "</select>"
              . "<input type='text' id='horas' size='1' value='8' style='text-align:right;' /> horas  <input type='text' id='observaciones_mo' size='10' value='' placeholder='Observaciones'  />"
              . " <a class='btn btn-warning btn-xs' href='#'  onclick='add_parte_personal( $id_parte );'><i class='fas fa-user-plus'></i> Añadir</a>" 
                ."<a class='btn btn-link btn-xs' href='#' onclick=\"window.open('../personal/personal_ficha.php?id_personal='+document.getElementById('id_personal').value ) \"   "
               ." title='Ver la ficha del empleado' >ver Personal</a>     "
               ."<a class='btn btn-link btn-xs' href='../personal/personal_anadir.php' target='_blank' ><i class='fas fa-plus-circle'></i> Nuevo Personal</a>"
                ."    </div>" ;
        
$tabla_expandida=0;$tabla_footer='<br>' ;


?>

        
<div  style="background-color:Khaki;float:left;width:100%;padding:0 20px;" >
     
<?php 

require("../include/tabla.php"); echo $TABLE ; ?>
 
    
</div>    
    <!--//////   MAQUINARIA PROPIA  ///////-->
    
  <?php            
  

//$sql="SELECT id,ID_PERSONAL,NOMBRE,DNI,HO,HX,MD,DC,Observaciones FROM Partes_Personal_View  WHERE ID_PARTE=$id_parte  AND $where_c_coste    ";
$sql="SELECT id,id_obra_mq,Maquinaria,id_concepto_mq,CONCEPTO AS Concepto, cantidad as Cantidad,ID_SUBOBRA , Observaciones FROM Partes_Maquinas_View  WHERE ID_PARTE=$id_parte  AND $where_c_coste    ";
//echo $sql;
$result=$Conn->query($sql );

//$sql="SELECT 'Suma' ,COUNT(ID_PERSONAL) as B,SUM(HO) as HO,SUM(HX) as HX,SUM(MD) as MD,SUM(DC) as DC FROM Partes_Personal_View  WHERE ID_PARTE=$id_parte  AND $where_c_coste    ";
//$sql="SELECT 'Suma' ,COUNT(ID_PERSONAL) as B,SUM(HO) as HO FROM Partes_Personal_View  WHERE ID_PARTE=$id_parte  AND $where_c_coste    ";
//echo $sql;
//$result_T=$Conn->query($sql );

$updates=['Cantidad','ID_SUBOBRA', 'Observaciones']  ;
$visibles=['ID_SUBOBRA'] ;

$tabla_update="Partes_Maquinas" ;
$id_update="id" ;

$actions_row=[];
$actions_row["id"]="id";
//$actions_row["delete_link"]="../include/tabla_delete_row.php?tabla=PARTES_PERSONAL&where=id=";
$actions_row["delete_link"]="1";


//$id_clave="id" ;

//$formats["FECHA"]='fecha';
//$formats["importe"]='moneda';
//
$links["Maquinaria"] = ["../maquinaria/maquinaria_ficha.php?id_obra=", "id_obra_mq"] ;
$links["Concepto"] = ["../proveedores/concepto_ficha.php?id_concepto=", "id_concepto_mq"] ;
$selects["ID_SUBOBRA"]=["ID_SUBOBRA","SUBOBRA","Subobra_View","../obras/subobra_anadir.php?id_obra=$id_obra","../obras/subobra_ficha.php?id_subobra=","ID_SUBOBRA","AND ID_OBRA=$id_obra"] ;   // datos para clave foránea Y PARA AÑADIR PROVEEDOR NUEVO

$formats["path_archivo"]='pdf_100_500' ;

//$links["NOMBRE_OBRA"]=["../obras/obras_ficha.php?id_obra=", "ID_OBRA"] ;
//
//$aligns["importe"] = "right" ;
//$aligns["Pdte_conciliar"] = "right" ;
////$aligns["Importe_ejecutado"] = "right" ;

//$tooltips["conc"] = "Factura conciliada. Los Vales (albaranes de proveedor) suman el importe de la factura" ;

//$titulo="<a href=\"proveedores_documentos.php?id_proveedor=$id_proveedor\">Documentos (ver todos...)</a> " ;
$titulo="Maquinaria Propia ($result->num_rows". cc_format( "solo_icon", "icon_maquinaria") ." )" ;
$msg_tabla_vacia="No hay maquinaria";

$add_link_html= "<div >Añadir Maquinaria:<select id='id_obra_maq' style='width: 50%;' > "
               . "<option value='0' >Selecciona Maquinaria...</option>"         
              . DOptions_sql("SELECT ID_OBRA,CONCEPTO FROM Maquinaria WHERE activa=1 AND $where_c_coste ORDER BY CONCEPTO ")
              .  "</select>"
              . "<input type='text' id='cantidad_mq' size='3' value='0' style='text-align:right;' /> ud    "
              . "  <input type='text' id='observaciones_mq' size='10' value='' placeholder='Observaciones'  /> "
              . " <a class='btn btn-warning btn-xs' href='#'  onclick='add_parte_maquinaria($id_parte );'>Añadir</a>" 
                ." <a class='btn btn-link btn-xs' href='#' onclick=\"window.open('../maquinaria/maquinaria_ficha.php?id_obra='+document.getElementById('id_obra_maq').value ) \"    "
               ." title='Ver la ficha de maquinaria' >ver Maquinaria</a>"
            . "  </div>   " ;
        
$tabla_expandida=0;$tabla_footer='<br>' ;


?>

        <!--<div id="main" class="mainc">-->
<div  style="background-color: pink;float:left;width:100%;padding:0 20px;" >

     
<?php  require("../include/tabla.php"); echo $TABLE ; ?>  
    
    
	 
</div>
       <!--FIN MAQUINARIA PROPIA-->  
	
 
   <!--////// ////////////    ALBARANES     ASOCIADOS    /////////////////////-->
   
  <?php            
  

//$sql="SELECT id,ID_PERSONAL,NOMBRE,DNI,HO,HX,MD,DC,Observaciones FROM Partes_Personal_View  WHERE ID_PARTE=$id_parte  AND $where_c_coste    ";
$sql="SELECT ID_VALE,ID_PROVEEDORES,ID_FRA_PROV,path_archivo, PROVEEDOR, REF, importe, Observaciones,user FROM Vales_view  WHERE ID_OBRA=$id_obra AND FECHA='$fecha' AND $where_c_coste    ";
$sql_T="SELECT '' AS A, '' AS B, 'Suma', SUM(importe) as importe, '' AS A1, '' AS B1 FROM Vales_view  WHERE ID_OBRA=$id_obra AND FECHA='$fecha' AND $where_c_coste    ";
//echo $sql;
$result=$Conn->query($sql );
$result_T=$Conn->query($sql_T ); 

$updates=['cantidad', 'Observaciones']  ;

$tabla_update="VALES" ;
$id_update="ID_VALE" ; 
 

$actions_row=[];
$actions_row["id"]="ID_VALE";
$actions_row["delete_link"]="1";


//$id_clave="id" ;

//$formats["FECHA"]='fecha';
//$formats["importe"]='moneda';

$formats["path_archivo"]="pdf_100_500" ;

//
$links["REF"] = ["../proveedores/albaran_proveedor.php?id_vale=", "ID_VALE", "ver Vale Albarán","formato_sub"] ;
$links["REF"] = ["../proveedores/albaran_proveedor.php?id_vale=", "ID_VALE", "ver Vale Albarán","formato_sub"] ;
$links["PROVEEDOR"]=["../proveedores/proveedores_ficha.php?id_proveedor=", "ID_PROVEEDORES", "ver proveedor"] ;

//$links["NOMBRE_OBRA"]=["../obras/obras_ficha.php?id_obra=", "ID_OBRA"] ;
//
//$aligns["importe"] = "right" ;
//$aligns["Pdte_conciliar"] = "right" ;
////$aligns["Importe_ejecutado"] = "right" ;

//$tooltips["conc"] = "Factura conciliada. Los Vales (albaranes de proveedor) suman el importe de la factura" ;

//$titulo="<a href=\"proveedores_documentos.php?id_proveedor=$id_proveedor\">Documentos (ver todos...)</a> " ;
//$titulo="Albaranes de proveedor ($result->num_rows <span class='glyphicon glyphicon-tags'></span>)" ;
$titulo="Albaranes de proveedor ($result->num_rows". cc_format( "solo_icon", "icon_albaranes") ." )" ;
$msg_tabla_vacia="No hay Albaranes";

$primera_option=" <option value='".getVar("id_proveedor_auto")."'>-proveedor pdte registrar-</option>   ";

$add_link_html= "<div  >Añadir albarán:<select id='id_proveedor' style='width: 50%;' >"
              . " <option value='".getVar("id_proveedor_auto")."'>-proveedor pdte registrar-</option>   "
              . DOptions_sql("SELECT DISTINCT ID_PROVEEDORES,PROVEEDOR FROM Vales_view WHERE ID_OBRA=$id_obra AND $where_c_coste  ORDER BY PROVEEDOR " , $primera_option)
              .  "</select>"
              . "<input type='text' id='importe' size='3' value='' placeholder='importe' /> €     "
              . "  <input type='text' id='ref' size='10' value='' placeholder='Referencia'  /> "
              . " <a class='btn btn-warning btn-xs' href='#'  onclick=\"add_albaran_vale( '$id_obra' , '$fecha', '0' ) \" >Añadir albarán</a>" 
              . " <a class='btn btn-warning btn-xs' href='#'  onclick=\"add_albaran_vale( '$id_obra' , '$fecha', '1' ) \" >Añadir albarán con foto</a>" 
            . "  </div>   " ; 
        
$tabla_expandida=0;$tabla_footer='<br>' ;



?>

 <div  style="background-color:beige;float:left;width:100%;padding:0 20px;" >
   
     
<?php  require("../include/tabla.php"); echo $TABLE ; ?>  
    
    
	 
</div>
       <!--FIN ALBARANES ASOCIADOS-->  
		
  <!--//////   FOTOS ASOCIADOS  ///////-->
  
   
  <?php            
  

//$sql="SELECT id,ID_PERSONAL,NOMBRE,DNI,HO,HX,MD,DC,Observaciones FROM Partes_Personal_View  WHERE ID_PARTE=$id_parte  AND $where_c_coste    ";
//$sql="SELECT ID_VALE,ID_PROVEEDORES,ID_FRA_PROV,NOMBRE_OBRA, FECHA, PROVEEDOR, REF, importe, Observaciones FROM Vales_view  WHERE ID_OBRA=$id_obra AND FECHA='$fecha' AND $where_c_coste    ";
//     $sql="SELECT id_documento,id_documento as nid_documento,path_archivo,tipo_entidad,id_entidad,fecha_doc,tamano,nombre_archivo,path_archivo as path_archivo2,fallo,documento,Observaciones,CONCAT('tipo_entidad=',tipo_entidad,'&id_entidad=',id_entidad) as id_entidad_link FROM Documentos WHERE $where  ORDER BY Fecha_Creacion DESC LIMIT 200 " ;

  $sql="SELECT id_documento,path_archivo,id_entidad,id_documento as nid_documento,tamano,nombre_archivo,documento,user,fecha_creacion FROM Documentos WHERE tipo_entidad='obra_foto' AND id_entidad=$id_obra AND fecha_doc='$fecha' AND $where_c_coste ORDER BY id_documento " ;
//echo $sql;
$result=$Conn->query($sql );

//$sql="SELECT 'Suma' ,COUNT(ID_PERSONAL) as B,SUM(HO) as HO,SUM(HX) as HX,SUM(MD) as MD,SUM(DC) as DC FROM Partes_Personal_View  WHERE ID_PARTE=$id_parte  AND $where_c_coste    ";
//$sql="SELECT 'Suma' ,COUNT(ID_PERSONAL) as B,SUM(HO) as HO FROM Partes_Personal_View  WHERE ID_PARTE=$id_parte  AND $where_c_coste    ";
//echo $sql;
//$result_T=$Conn->query($sql );

$updates=[ 'documento']  ;
$tabla_update="Documentos" ;
$id_update="id_documento" ;

$actions_row=[];
$actions_row["id"]="id_documento";
$actions_row["delete_link"]="1";
$actions_row["delete_confirm"]="0";

$links["nid_documento"] = ["../documentos/documento_ficha.php?id_documento=", "id_documento", "ver ficha documento",'formato_sub'] ;
$links["nombre_archivo"] = ["../documentos/documento_ficha.php?id_documento=", "id_documento", "ver ficha documento",'formato_sub'] ;

$formats["tamano"] = "kb" ;
$formats["path_archivo"] = "pdf_100_500" ;
$formats["documento"] = "text_edit" ;
//$formats["Observaciones"] = "textarea100" ;

//$tooltips["conc"] = "Factura conciliada. Los Vales (albaranes de proveedor) suman el importe de la factura" ;

//$titulo="<a href=\"proveedores_documentos.php?id_proveedor=$id_proveedor\">Documentos (ver todos...)</a> " ;
$titulo="Fotos ($result->num_rows". cc_format( "solo_icon", "icon_fotos") ." )" ;
$msg_tabla_vacia="No hay fotos";

$add_link_html= "<div >"
              . "<input type='text' id='comentario' size='10' value='' placeholder='Comentario' />      "
              . " <a class='btn btn-warning btn-xs' href='#'  onclick=\"add_fotos( '$id_obra' , '$fecha' ) \" >"
             . "<i class='fas fa-plus-circle'></i> Añadir Fotos <span class='glyphicon glyphicon-camera'></span></a>" 
            . "  </div>   " ;
        
$tabla_expandida=0;$tabla_footer='<br>' ;

// boton para poder ROTAR 90º la foto
$href_270="../documentos/doc_rotar_ajax.php?grados=270&id_documento=_VAR_TABLA1_" ;
$actions_row["onclick1_link"]="<a class='btn btn-link' href=# onclick=\"js_href( '$href_270'  )\"   title='rotar la foto -90º'><i class='fas fa-undo'></i></a> " ;   // acción de rotar
$onclick_VAR_TABLA1_="id_documento" ;  // variable a pasar



?>

 <div  style="background-color: #ffcc99 ;float:left;width:100%;padding:0 20px;" >
 
     
<?php  require("../include/tabla.php"); echo $TABLE ; ?>  
    
    
	 
</div>
       <!--FIN FOTOS ASOCIADOS-->  

 <!--////// ////////////   PRODUCCION DE OBRA   /////////////////////-->
   
  <?php            
  

//$sql="SELECT id,ID_PERSONAL,NOMBRE,DNI,HO,HX,MD,DC,Observaciones FROM Partes_Personal_View  WHERE ID_PARTE=$id_parte  AND $where_c_coste    ";
$id_produccion_obra=Dfirst("id_produccion_obra","OBRAS","ID_OBRA=$id_obra")  ;
$sql="SELECT id,ID_UDO,CAPITULO,UDO,Observaciones,MED_PROYECTO,MEDICION,PRECIO,importe FROM ConsultaProd  WHERE ID_OBRA=$id_obra AND FECHA='$fecha' AND ID_PRODUCCION= $id_produccion_obra  ORDER BY CAPITULO, ID_UDO  ";
$sql_T="SELECT '' as a1,'' as a2,'' as a3,'' as a4,'' as a5,'' as a6,SUM(importe) as importe FROM ConsultaProd  WHERE ID_OBRA=$id_obra AND FECHA='$fecha' AND ID_PRODUCCION= $id_produccion_obra    ";
//echo $sql;
$result=$Conn->query($sql );
$result_T=$Conn->query($sql_T );

//$sql="SELECT 'Suma' ,COUNT(ID_PERSONAL) as B,SUM(HO) as HO,SUM(HX) as HX,SUM(MD) as MD,SUM(DC) as DC FROM Partes_Personal_View  WHERE ID_PARTE=$id_parte  AND $where_c_coste    ";
//$sql="SELECT 'Suma' ,COUNT(ID_PERSONAL) as B,SUM(HO) as HO FROM Partes_Personal_View  WHERE ID_PARTE=$id_parte  AND $where_c_coste    ";
//echo $sql;
//$result_T=$Conn->query($sql );

$updates=['MEDICION', 'Observaciones']  ;
$tabla_update="PRODUCCIONES_DETALLE" ;
$id_update="id" ;


$actions_row=[];
$actions_row["id"]="id";
$actions_row["delete_link"]="1";

$links["UDO"] = ["../obras/udo_prod.php?id_produccion=$id_produccion_obra&id_udo=", "ID_UDO" ,"ver detalles de medición de la Unidad de Obra", 'ppal'] ;    


$titulo="Producción de Obra ($result->num_rows". cc_format( "solo_icon", "icon_produccion") ." )" ;
$msg_tabla_vacia="No hay produccion de obra";

$add_link_html= "<div >"
            . " <a class='btn btn-link btn-xl' target='_blank' href='../obras/obras_prod_detalle.php?id_produccion=$id_produccion_obra&agrupar=cap_udos&fmt_seleccion=checked'  >"
            . "ver PRODUCCION OBRA completa</a>"
            . "<br><input type='text' id='filtro' size='2' value='' style='text-align:right;' placeholder='filtro'/><i class='fas fa-search'></i>"
            . "<select id='id_udo' style='width: 50%;' >"
            . DOptions_sql("SELECT ID_UDO,CONCAT('(',ID_UDO,') ' ,CAPITULO,':  ',MED_PROYECTO, ' ',ud,' ',UDO) "
                    . "FROM Udos_View WHERE ID_OBRA=$id_obra AND $where_c_coste  ORDER BY CAPITULO, ID_UDO ", "Selecciona Unidad de Obra...")
            .  "</select>"
            . "<input type='text' id='medicion' size='3' value='0' placeholder='medicion' />      "
            . "  <input type='text' id='observaciones' size='10' value='' placeholder='observaciones'  /> "
            . " <a class='btn btn-warning btn-xs' href='#'  onclick=\"add_prod_obra( '$id_produccion_obra' , '$fecha' ) \" ><i class='fas fa-plus-circle'></i> Añadir Produccion Obra</a>" 
            . "  </div>   " ;
        
$tabla_expandida=0;$tabla_footer='<br>' ;




?>

 
     
 <div  style="background-color:beige;float:left;width:100%;padding:0 20px;" >
     
<?php  require("../include/tabla.php"); echo $TABLE ; ?>  
    
    
	 
</div>
</div>
 
 <script>
    

// filtro del <SELECT>    
$(document).ready(function() {
  $('#filtro').change(function() {
    var filter = $(this).val();
    filter=filter.replace(/ /g,".*")  ;
//    alert(filter) ;
//    var re = new RegExp('rebu', 'gi');
    var re = new RegExp(filter, 'gi');

    $('option').each(function() {
//      if ($(this).text().includes('SADA')) {
      if ($(this).text().match(re)) {
        $(this).show();
//        alert($(this).text()) ;
      } else {
        $(this).hide();
      }
//      $('select').val(filter);
//        $('select').selectedIndex = "1";
//        $('select').size = "4";
    })
//        $('select').selectedIndex = "1";
//        $('#id_concepto').size = 20;
//        $("#id_concepto").prop("selectedIndex", 2);
        $("#id_udo").prop("size", 10);
//        $('select').size(20);

  })
})


    
    
function ver_udo() {
    
var id_concepto=document.getElementById("id_udo").value ;
 
window.open('../obras/udo_prod.php?id_udo='+id_udo, '_blank');

return ;
 }



</script>
 
       <!--FIN PRODUCCION DE OBRA -->         
      
       
	
<?php  

$Conn->close();

?>
	 


<!--	<div style="background-color:#f1f1f1;text-align:center;padding:10px;margin-top:7px;font-size:12px;">FOOTER</div>-->

<script>       
function add_parte_personal(id_parte) {
    
    //var valor0 = valor0_encode;
    //var valor0 = JSON.parse(valor0_encode);
   // var nuevo_valor=window.prompt("Nuevo valor de "+prompt , valor0);
//    alert("el nuevo valor es: "+valor) ;
//   alert('debug') ;
   var id_personal=document.getElementById("id_personal").value ;
   var horas=document.getElementById("horas").value ;
   var observaciones_mo=document.getElementById("observaciones_mo").value ;
   var sql="INSERT INTO PARTES_PERSONAL (ID_PARTE,ID_PERSONAL, HO, Observaciones) VALUES ('"+id_parte+"','"+ id_personal +"','"+ horas +"','"+ observaciones_mo +"')"    ;   
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
 
    
    function add_parte_maquinaria(id_parte) {
    
    //var valor0 = valor0_encode;
    //var valor0 = JSON.parse(valor0_encode);
   // var nuevo_valor=window.prompt("Nuevo valor de "+prompt , valor0);
//    alert("el nuevo valor es: "+valor) ;
//   alert('debug') ;
   var id_obra_maq=document.getElementById("id_obra_maq").value ;
   var cantidad_mq=document.getElementById("cantidad_mq").value ;
   var observaciones_mq=document.getElementById("observaciones_mq").value ;
   var sql="INSERT INTO Partes_Maquinas (id_parte,id_obra,cantidad,Observaciones ) VALUES ('"+id_parte+"','"+ id_obra_maq +"','"+ cantidad_mq +"','"+ observaciones_mq +"')"    ;   
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
 
    function add_albaran_vale(id_obra, fecha, add_foto) {
    
    //var valor0 = valor0_encode;
    //var valor0 = JSON.parse(valor0_encode);
   // var nuevo_valor=window.prompt("Nuevo valor de "+prompt , valor0);
//    alert("el nuevo valor es: "+valor) ;
//   alert('debug') ;
   var id_proveedor=document.getElementById("id_proveedor").value ;
   var importe=document.getElementById("importe").value ;
   var ref=document.getElementById("ref").value ;
    
//   var d= new Date() ;
//   var date_str=d.toISOString();
   
   window.open('../proveedores/albaran_anadir.php?id_obra='+id_obra+'&id_proveedor='+id_proveedor+'&fecha='+fecha+'&ref='+ref+'&importe='+importe+'&add_foto='+add_foto); 
    
    
    return ;
 }
    function add_prod_obra(id_produccion, fecha) {
    
    //var valor0 = valor0_encode;
    //var valor0 = JSON.parse(valor0_encode);
   // var nuevo_valor=window.prompt("Nuevo valor de "+prompt , valor0);
//    alert("el nuevo valor es: "+valor) ;
//   alert('debug') ;
   var id_udo=document.getElementById("id_udo").value ;
   var medicion=document.getElementById("medicion").value ;
   var observaciones=document.getElementById("observaciones").value ;
    
//   var d= new Date() ;
//   var date_str=d.toISOString();
   
//   xhttp.open("GET", "../obras/prod_add_detalle_ajax.php?id_produccion="+id_produccion+"&id_udo="+id_udo+"&medicion="+nuevo_valor, true);

   window.open("../obras/prod_add_detalle_ajax.php?id_produccion="+id_produccion+"&id_udo="+id_udo+"&medicion="+medicion+"&observaciones=" + observaciones+"&fecha=" + fecha);
    
    
    return ;
 }
 
function add_fotos(id_obra, fecha) {
    
    //var valor0 = valor0_encode;
    //var valor0 = JSON.parse(valor0_encode);
   // var nuevo_valor=window.prompt("Nuevo valor de "+prompt , valor0);
//    alert("el nuevo valor es: "+valor) ;
//   alert('PENDIENTE DESARROLLO (juand)') ;
//   var id_proveedor=document.getElementById("id_proveedor").value ;
//   var importe=document.getElementById("importe").value ;
//   var ref=document.getElementById("ref").value ;
//    
////   var d= new Date() ;
////   var date_str=d.toISOString();
//   
   window.open('../documentos/doc_upload_multiple_form.php?tipo_entidad=obra_foto&id_entidad='+id_obra+'&fecha_doc='+fecha, '_blank');
//    
//    
    return ;
 }
 
 
</script>
               
        
        
        
        
<?php
    
echo $html_anterior_siguiente ;

?>
                </div>
  <br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br>
  <br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br>
  <br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br>

                <!--****************** BUSQUEDA GLOBAL  *****************
            </div>
        </div>
        <!-- FIN Contenido principal -->

<?php 

//FIN
include_once('../templates/_inc_privado3_footer.php');