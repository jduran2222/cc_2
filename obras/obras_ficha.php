<?php
// cambios
require_once("../include/session.php");
$where_c_coste = " id_c_coste={$_SESSION['id_c_coste']} ";
$id_c_coste = $_SESSION['id_c_coste'];

$rs_obra= DRow("NOMBRE_OBRA","OBRAS", "ID_OBRA={$_GET["id_obra"]} AND $where_c_coste"  ) ;
$titulo_pagina="Obra " . $rs_obra["NOMBRE_OBRA"];
$titulo = $titulo_pagina; 

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


$id_obra=$rs_obra["ID_OBRA"];   // INTEGRIDAD DATOS. SEGURIDAD
//if (!isset($_SESSION['nombre_obra']))
//{
//   $_SESSION['nombre_obra']=Dfirst("NOMBRE_OBRA","OBRAS","id_obra=$id_obra AND $where_c_coste ") ;
//}

$tipo_subcentro=$rs_obra["tipo_subcentro"] ;

if ($tipo_subcentro=='M')
{
echo "<script language='javascript'>window.location='../maquinaria/maquinaria_ficha.php?id_obra=$id_obra'</script>"; 
}

require_once("../obras/obras_menutop_r.php");
require_once("../include/funciones_js.php");
?>



 <?php              // DATOS   FICHA . PHP

// comprobamos si id_prod_estudio_coste está actualizado y en caso negativo lo actualizamos (hacemos un clon del Proyecto en la RV Estudio de Coste)
if (!cc_is_ESTUDIO_COSTE_actualizado($id_obra))  {  cc_actualiza_ESTUDIO_COSTE($id_obra); }
 
 
if ($tipo_subcentro=='O')     // consulta para las OBRAS
{
// $sql="SELECT ID_OBRA,activa,tipo_subcentro,NOMBRE_OBRA,NOMBRE_COMPLETO,EXPEDIENTE,ID_CLIENTE,TIPO_LICITACION,IMPORTE,BAJA,COEF_BAJA,iva_obra, importe_sin_iva   "
//         . ",GG_BI,ID_ESTUDIO,id_prod_estudio_costes,id_produccion_obra"
//         . ",Plazo,Situacion,URL_Google_Maps ,Agenda_Obra,GRUPOS, Observaciones "
//         . ",'Fechas' as EXPAND_1 , F_Contrato,Fecha_Plan_SS,F_Aper_C_Trabajo "
//         . " ,F_Acta_Rep,F_Fin_Plazo,Plazo_dias, Porcentaje_Plazo"
//         . " ,F_A_Recepcion"
//              . " , '-' AS FIN_EXPAND, 'Control Económico' as EXPAND_2 ," 
//         . "importe_sin_iva as Importe_Obra,Estudio_Costes_inicial,importe_sin_iva - Estudio_Costes_inicial AS  Beneficio_Inicial"
//         . ", Cartera_pdte,Porcentaje_Plazo as Porcentaje_Plazo_ , Valoracion  ,Gastos as Gasto_real,Valoracion-Gastos as Beneficio_real,Valoracion-Gasto_est as Beneficio_estimado "
//         . ", VENTAS,GASTOS_EX, VENTAS-GASTOS_EX AS Beneficios"
//         . ", Facturado,Facturado_iva,Cobrado,Pdte_Cobro"
//         . ",'' AS FIN_EXPAND_2,'Datos certificaciones' as EXPAND_3, id_subobra_auto,D_OBRA ,Pie_CERTIFCACION,'' AS FIN_EXPAND_3, user,fecha_creacion FROM Obras_View WHERE ID_OBRA=$id_obra AND $where_c_coste";
 // PROVISIONALMENTE USAMOS ESTE SQL MENOS CARGADO PARA AGILIZAR LA CARGA.
 // HABRIA QUE CARGAR POR AJAX LA PARTE ECONOMICA QUE HAY EN OBRAS_VIEW
 $sql="SELECT ID_OBRA,activa,tipo_subcentro,NOMBRE_OBRA,NOMBRE_COMPLETO,EXPEDIENTE,ID_CLIENTE,TIPO_LICITACION,IMPORTE/(1+iva_obra) AS importe_sin_iva,IMPORTE,BAJA,COEF_BAJA,iva_obra"
         . " ,GG_BI,ID_ESTUDIO,id_prod_estudio_costes,id_produccion_obra"
         . " ,Plazo,Situacion,URL_Google_Maps ,Agenda_Obra, Observaciones "
         . " ,F_Contrato,Fecha_Plan_SS,F_Aper_C_Trabajo "
         . " ,F_Acta_Rep,F_Fin_Plazo"
         . " ,F_A_Recepcion"
         . " ,user,fecha_creacion FROM OBRAS WHERE ID_OBRA=$id_obra AND $where_c_coste"; 
 
// $sql="SELECT * FROM OBRAS WHERE ID_OBRA=$id_obra AND $where_c_coste";
 
}elseif($tipo_subcentro=='E')  // consulta para las OBRA-ESTUDIO
{
 $sql="SELECT ID_OBRA,activa,tipo_subcentro,NOMBRE_OBRA,NOMBRE_COMPLETO,IMPORTE/(1+iva_obra) AS IMPORTE_SIN_IVA,TIPO_LICITACION, IMPORTE,ID_ESTUDIO,id_prod_estudio_costes,id_produccion_obra"
         . ",iva_obra,GG_BI,Situacion,URL_Google_Maps "
         . ", user,fecha_creacion FROM OBRAS WHERE ID_OBRA=$id_obra AND $where_c_coste";
    
}elseif($tipo_subcentro=='G' OR $tipo_subcentro=='A')
{
 $sql="SELECT ID_OBRA,activa,tipo_subcentro,NOMBRE_OBRA,importe_sin_iva,IMPORTE,id_prod_estudio_costes,id_produccion_obra,GRUPOS, Valoracion  ,Gastos as Gasto_real,Valoracion-Gastos as Beneficio_real,VENTAS,GASTOS_EX, VENTAS-GASTOS_EX AS Beneficios"
         . ",Situacion,URL_Google_Maps, TIPO_LICITACION "
         . ", user,fecha_creacion FROM OBRAS WHERE ID_OBRA=$id_obra AND $where_c_coste";
    
}elseif($tipo_subcentro=='M')
{
 $sql="SELECT ID_OBRA,activa,tipo_subcentro,NOMBRE_OBRA,IMPORTE/(1+iva_obra) AS IMPORTE_SIN_IVA, IMPORTE"
         . ",iva_obra,GRUPOS,Situacion,URL_Google_Maps "
         . ", F_Contrato "
              . " ,'----------RESUMEN ECONOMICO----------' as a ,"
         . " ,Gastos,VENTAS,GASTOS_EX"
         . ", user,fecha_creacion FROM OBRAS WHERE ID_OBRA=$id_obra AND $where_c_coste";
    
}else
{
  $sql="SELECT *  FROM Obras_View WHERE ID_OBRA=$id_obra AND $where_c_coste";
}  
// echo "<br><br><br><br><br>$sql" ;
echo "<br><br><br><br>" ;
  
//$ocultos=["Pie_CERTIFCACION"] ;

 $result=$Conn->query($sql) ;
 $rs = $result->fetch_array(MYSQLI_ASSOC) ;
//while ($a = $result->fetch_field()) {

//print_r ($rs); 
//}
//echo "</pre>";
  $titulo="OBRA: <b>{$rs["NOMBRE_OBRA"]}</b>" ; 
  //$updates=['NOMBRE_OBRA','NOMBRE_COMPLETO','GRUPOS','EXPEDIENTE', 'NOMBRE' ,'Nombre Completo', 'LUGAR', 'PROVINCIA', 'Presupuesto Tipo', 'Plazo Proyecto' ,'Observaciones']  ;
  $updates=[ 'id_subobra_auto', "ID_ESTUDIO","ID_CLIENTE","id_produccion_obra2222",'id_prod_estudio_costes2222', "NOMBRE_OBRA","NOMBRE_COMPLETO","GRUPOS","EXPEDIENTE","FECHA_INICIO","TIPO_LICITACION","IMPORTE","BAJA","COEF_BAJA","iva_obra","UTE" 
      ,'Plazo','F_Contrato','Fecha_Plan_SS','F_Aper_C_Trabajo','F_Acta_Rep','F_Fin_Plazo','F_A_Recepcion','Situacion','activa'  
      ,'tipo_subcentro','D_OBRA','Pie_CERTIFCACION','','','','','','','','',"LUGAR","Agenda_Obra","Observaciones","GG_BI", 'URL_Google_Maps'] ;
//  $updates=["*"] ;
//  $selects["tipo_subcentro"]=["tipo_subcentro","subcentro","tipos_subcentro","","","tipo_subcentro","","NO_WHERE_C_COSTE"] ;   // datos para clave foránea  
  $selects["ID_CLIENTE"]=["ID_CLIENTE","CLIENTE","Clientes","../clientes/clientes_anadir_form.php","../clientes/clientes_ficha.php?id_cliente=","ID_CLIENTE"] ;   // datos para clave foránea
//  $selects["id_prod_estudio_costes"]=["ID_PRODUCCION","PRODUCCION","Prod_view" 
//      ,"../obras/add_produccion_ajax.php?id_obra=$id_obra&produccion=ESTUDIO COSTES&id_actualizar=id_prod_estudio_costes"  
//          ,"../obras/obras_prod_detalle.php?fmt_costes=checked&id_obra=$id_obra&id_produccion=","id_prod_estudio_costes"  
//      ,"AND ID_OBRA=$id_obra","", "CONCAT(PRODUCCION,' - (Baja est. ', COALESCE(FORMAT(margen_est*100,2),0),'%)'  )"] ;   // datos para clave foránea
//  $selects["id_produccion_obra"]=["ID_PRODUCCION","PRODUCCION","Prod_view" 
//      ,"../obras/add_produccion_ajax.php?id_obra=$id_obra&produccion=PRODUCCION OBRA&id_actualizar=id_produccion_obra" 
//          ,"../obras/obras_prod_detalle.php?id_obra=$id_obra&id_produccion=","id_produccion_obra" 
//      ,"AND ID_OBRA=$id_obra", ""  ,"CONCAT(PRODUCCION,' - ( Ej.', COALESCE(FORMAT(p_ejecucion*100,2),0),'%)'  )"] ;   // datos para clave foránea

  // anulamos los porcentajes de Estud_coste y Prod_Obra
  $selects["id_prod_estudio_costes"]=["ID_PRODUCCION","PRODUCCION","PRODUCCIONES" 
      ,"../obras/add_produccion_ajax.php?id_obra=$id_obra&produccion=ESTUDIO COSTES&id_actualizar=id_prod_estudio_costes"  
          ,"../obras/obras_prod_detalle.php?fmt_costes=checked&id_obra=$id_obra&id_produccion=","id_prod_estudio_costes"  
      ,"AND ID_OBRA=$id_obra","1"] ;   // datos para clave foránea
  
  $sql_enc= encrypt2("SELECT margen_est FROM Prod_view WHERE ID_PRODUCCION='{$rs["id_prod_estudio_costes"]}';")  ;
  $spans_html["id_prod_estudio_costes"]="<span id='p_est_coste'></span><script>dfirst_ajax('p_est_coste','$sql_enc','progress_success' );</script>  ";

  $selects["id_produccion_obra"]=["ID_PRODUCCION","PRODUCCION","PRODUCCIONES" 
      ,"../obras/add_produccion_ajax.php?id_obra=$id_obra&produccion=PRODUCCION OBRA&id_actualizar=id_produccion_obra" 
          ,"../obras/obras_prod_detalle.php?id_obra=$id_obra&id_produccion=","id_produccion_obra" 
      ,"AND ID_OBRA=$id_obra", "1"  ] ;   // datos para clave foránea

  $sql_enc= encrypt2("SELECT p_ejecucion FROM Prod_view WHERE ID_PRODUCCION={$rs["id_produccion_obra"]};")  ;
  $spans_html["id_produccion_obra"]="<div id='p_prod'></div><script>dfirst_ajax('p_prod','$sql_enc','progress_danger' );</script>  ";
  
  $selects["ID_ESTUDIO"]=["ID_ESTUDIO","NOMBRE","Estudios_de_Obra","" ,"../estudios/estudios_ficha.php?id_estudio=","ID_ESTUDIO"] ;   // datos para clave foránea
  $selects["ID_ESTUDIO"]["valor_null"]=0;
  $selects["ID_ESTUDIO"]["valor_null_texto"]='sin Estudio';
  
  $selects["id_subobra_auto"]=["ID_SUBOBRA","SUBOBRA","Subobra_View","../obras/subobra_anadir.php?id_obra=$id_obra","../obras/subobra_ficha.php?id_subobra=","id_subobra_auto","AND ID_OBRA=$id_obra"] ; 
  $tooltips["id_subobra_auto"]= 'Subobra donde se imputarán por defecto todos los gastos y las nuevas Unidades de Obra que se creen en el Proyecto de la Obra';


//  $links["URL_icon"] = [$rs["URL_Google_Maps"], "", "", "formato_sub"] ;

  
  $id_obra=$rs["ID_OBRA"] ;
  $tabla_update="OBRAS" ;
  $id_update="ID_OBRA" ;
  $id_valor=$id_obra ;

  $delete_boton=1 ;

//  $formats["URL_icon"]="icon_map-marker" ;
  $formats["URL_Google_Maps"]="textarea_20" ;
  
  $formats["TIPO_LICITACION"]="moneda" ;

  $formats["GG_BI"]="porcentaje0" ;
  $formats["BAJA"]="porcentaje" ;
  $formats["COEF_BAJA"]="fijo10" ;
  $formats["activa"]="boolean" ;
  $formats["Pie_CERTIFCACION"]='text_edit' ;
  $formats["Agenda_Obra"]='text_edit' ;

  $importe_sin_iva = isset($rs["importe_sin_iva"])? $rs["importe_sin_iva"] : 0 ;
  $valoracion = isset($rs["Valoracion"])? $rs["Valoracion"] : 0 ;
  
  $formats["Valoracion"]="moneda_porcentaje_sobre_$importe_sin_iva" ;
//  $formats["Val_iva_incluido"]="moneda" ;
  $formats["Gasto_est"]="moneda" ;
  $formats["Beneficio_real"]="moneda_porcentaje_sobre_$valoracion" ;
  $formats["Beneficio_estimado"]="moneda_porcentaje_sobre_$valoracion" ;
  $formats["VENTAS"]="moneda_porcentaje_sobre_$importe_sin_iva" ;
  $formats["Estudio_Costes_inicial"]="moneda" ;
  $formats["Beneficio_Inicial"]="moneda_porcentaje_sobre_$importe_sin_iva" ;
  $formats["Cartera_pdte"]="moneda_porcentaje_sobre_$importe_sin_iva" ;

//  $formats["VENTAS"]="moneda" ;
  $formats["GASTOS_EX"]="moneda" ;
  $formats["Facturado"]="moneda_porcentaje_sobre_$importe_sin_iva" ;
  $formats["Beneficio"]="moneda_porcentaje_sobre_".(isset($rs["VENTAS"])? $rs["VENTAS"] : 0) ;
  $formats["Facturado_iva"]="moneda" ;
  $formats["Cobrado"]="moneda" ;
  $formats["Pdte_Cobro"]="moneda" ;
  $formats["Gastos"]="moneda" ;

  $etiquetas["Valoracion"]='Importe Ejecutado (%s/contrato)' ;
  $tooltips["Valoracion"]= 'Valoración de PRODUCCION DE OBRA (sin iva) y su porcentaje sobre el contrato sin iva'  ;
  $wikis["Valoracion"]= "Relación_Valorada" ;
  $etiquetas["IMPORTE"]='Importe contrato iva incluido'  ;
  $tooltips["IMPORTE"]='Importe del Contrato de obras iva incluido'  ;
//  $tooltips["activa"]='Las obras activas son las que nos aparecerán en primer lugar para asignar albaranes, facturas, etc. desactivarlas cuando termine la obra.'  ;
  $etiquetas["IMPORTE_SIN_IVA"]='Importe contrato sin iva'  ;
  $etiquetas["URL_Google_Maps"]="$ICON-map-marker$SPAN URL Google Maps "  ; 
  $etiquetas["TIPO_LICITACION"]='Presup. Tipo de Licitación'  ;
  $etiquetas["ID_ESTUDIO"]='Licitación'  ;
  $etiquetas["COEF_BAJA"]='Coef. de Baja de Adj.'  ;
  $tooltips["COEF_BAJA"]='Es el Coeficiente de Baja de Adjudicación de una obra pública. Se aplica en las Certificaciones de obra previo a la facturación.'  ;
  
$BAJA= $rs["TIPO_LICITACION"]?  1- $rs["IMPORTE"]/$rs["TIPO_LICITACION"]  : 0 ;
 
  
$sql_span=encrypt2("UPDATE `OBRAS` SET `BAJA` = '$BAJA'   WHERE $where_c_coste AND ID_OBRA=$id_obra ; ") ;
$spans_html['BAJA'] = "<a class='btn btn-xs btn-link noprint transparente'  href='#'  onclick=\"js_href('../include/sql.php?code=1&sql=$sql_span')\"  title='Recalcula el Coeficiente de Baja' ><i class='fas fa-redo'></i></a>" ;

$COEF_BAJA= $rs["TIPO_LICITACION"]?   $rs["IMPORTE"]/$rs["TIPO_LICITACION"]  : 1 ;
$sql_span=encrypt2("UPDATE `OBRAS` SET `COEF_BAJA` = '$COEF_BAJA'   WHERE $where_c_coste AND ID_OBRA=$id_obra ; ") ;
// $href="../include/sql.php?code=1&sql=$sql_format_CIF"   ;
$spans_html['COEF_BAJA'] = "<a class='btn btn-xs btn-link noprint transparente'  href='#'  onclick=\"js_href('../include/sql.php?code=1&sql=$sql_span')\"  title='Recalcula el Coeficiente de Baja' ><i class='fas fa-redo'></i></a>" ;

  
  
  
  ?>
  
                  
                    
  <div style=" overflow: auto;">	   
  <div id="main" class="mainc"> 
      
  <?PHP require("../include/ficha.php"); ?>
   
      <!--// FIN     **********    FICHA.PHP-->
 </div>
      


	
<?php   // Iniciamos tabla_div  de ************ DOCUMENTOS *************

//$sql="SELECT id_documento, documento FROM Documentos  WHERE tipo_entidad='obra_doc' AND id_entidad=$id_obra AND $where_c_coste ORDER BY id_documento DESC LIMIT 5 ";
//
////echo $sql;
//$result=$Conn->query($sql );
//
//$titulo="Ultimos DOCUMENTOS";
//$msg_tabla_vacia="No hay";

?>
	
<!--  TAREAS ANULADO PROVISIONALMENTE MIENTRAS TAREAS NO ESTÉN VINCULADAS A ENTIDADES, juand mayo20-->
  <div class="right2">
	
  <?php 

$tipo_entidad='obra_doc' ;
$id_entidad=$id_obra;

  require("../agenda/widget_tareas.php");
 
 ?>
	 
  </div>

<!--  DOCUMENTOS -->

 <div class="right2">
	
<?php 

$tipo_entidad='obra_doc' ;
$id_entidad=$id_obra;
$id_subdir=$id_obra ;
$size='200px' ;
$resolucion='_medium.jpg'  ;

require("../menu/LRU_registro.php"); require("../include/widget_documentos.php");  

// require("../include/tabla.php"); echo $TABLE ; ?>
	
<!--  </div> -->
 </div>
	
<?php   // Iniciamos tabla_div  de ************ PRODUCCIONES *************

$sql="SELECT ID_PRODUCCION, PRODUCCION, Ej_Material,p_ejecucion  from Prod_view WHERE ID_OBRA=$id_obra AND $where_c_coste ORDER BY PRODUCCION LIMIT 10 ";  //sustituimos por la de abajo para ahorrar cálculos
//$sql="SELECT ID_PRODUCCION, PRODUCCION   from PRODUCCIONES WHERE ID_OBRA=$id_obra  ORDER BY PRODUCCION LIMIT 7 ";
//$sql_T="SELECT '' AS AA, SUM(Ej_Material)  from prod_PEM_f_view WHERE ID_OBRA=$id_obra AND $where_c_coste ORDER BY PRODUCCION LIMIT 7 ";

$formats["Ej_Material"]='moneda' ;

$links["PRODUCCION"] = ["../obras/obras_prod_detalle.php?id_obra={$id_obra}&id_produccion=", "ID_PRODUCCION" ,'','formato_sub'] ;
//echo $sql;
//$result=$Conn->query($sql );
//$result_T=$Conn->query($sql_T );

$titulo="Relaciones Valoradas (_NUM_)";
$msg_tabla_vacia="No hay";

?>
	
<!--  <div class="right2"> -->
 <div class="right2">
	
<?php require("../include/tabla_ajax.php"); echo $TABLE ; 

echo "<a class='btn btn-link btn-xs' href=\"../obras/obras_prod.php?_m=$_m&id_obra=$id_obra\">ver todas las Relaciones Valoradas</a>" ;

?>


<!--  </div> -->
 </div>

<?php   // Iniciamos tabla_div  de ************ AVALES *************

$sql="SELECT ID_AVAL , MOTIVO, Importe from Avales WHERE ID_OBRA=$id_obra AND $where_c_coste" ;
$titulo="Avales (_NUM_)";
$msg_tabla_vacia="No hay avales";
$format=[];
$formats["Importe"]="moneda" ;
$links["MOTIVO"] = ["../bancos/aval_ficha.php?id_aval=", "ID_AVAL",'','formato_sub'] ;

$tabla_expandida=0;
echo "<br><br><br><br>"
?>
	
<!--  <div class="right2"> -->
 <div class="right2">
<a class="btn btn-link noprint" href="../bancos/aval_anadir.php?id_obra=<?php echo $id_obra ; ?>" target='_blank'><i class="fas fa-plus-circle"></i> Añadir aval</a><br>
     
	
<?php 

require("../include/tabla_ajax.php"); echo $TABLE ; ?>
	
<!--  </div> -->
 </div>


	
<?php 
// PROCEDIMIENTOS
echo "<div class='right2'>"  ;
$tipo_entidad='obra_doc' ;
require("../agenda/widget_procedimientos.php");
echo "</div>" ;
 ?>
	 
  

<?php  

$Conn->close();

?>
	 

</div>

                </div>
                <!--****************** BUSQUEDA GLOBAL  *****************
            </div>
        </div>
        <!-- FIN Contenido principal -->

<?php 

//FIN
include_once('../templates/_inc_privado3_footer.php');

