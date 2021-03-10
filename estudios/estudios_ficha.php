<?php
// cambios
require_once("../include/session.php");
$where_c_coste = " id_c_coste={$_SESSION['id_c_coste']} ";
$id_c_coste = $_SESSION['id_c_coste'];

$titulo_pagina="Es " . Dfirst("CONCAT(NUMERO,'-',NOMBRE)","Estudios_view", "ID_ESTUDIO={$_GET["id_estudio"]} AND $where_c_coste"  ) ;

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

$id_estudio=$_GET["id_estudio"];
 

// echo '<br><br><br><br><br>' ;

 $sql="SELECT ID_ESTUDIO,NUMERO,NOMBRE,`Nombre Completo`,EXPEDIENTE,`NO VAMOS`,Presentada,Estado ,`Presupuesto Tipo`,`PLAZO ENTREGA`, `Plazo Proyecto` "
         . ",hora_entrega,Organismo, URL_licitacion, id_obra_estudio, id_prod_estudio_costes,URL_Google_Maps ,Requisitos, Observaciones"
         . ",`Oferta Tecnica`,`Baja Tecnica`,PLAZO,`Oferta Final`,`Oferta Final` AS Oferta_Final_txt, (1-`Oferta Final`/`Presupuesto Tipo`) as `Baja_final`   ,iva,`Oferta Final`*iva AS importe_del_iva "
         . ",`Oferta Final`*(1+iva) AS Oferta_Final_IVA,`Oferta Final`*(1+iva) AS Oferta_Final_IVA_txt,tipo_subcentro,user, Fecha_Creacion"
         . " FROM Estudios_listado WHERE ID_ESTUDIO=$id_estudio AND $where_c_coste";

// echo $sql ;
 $result=$Conn->query($sql);
 $rs = $result->fetch_array(MYSQLI_ASSOC) ;
 
 $id_estudio=$rs['ID_ESTUDIO']  ;   // control de seguridad

if ($id_obra=$rs['id_obra_estudio']) 
{ require_once("../obras/obras_menutop_r.php"); }
else { require_once("../estudios/estudios_menutop_r.php"); }

 
 
 
 
//while ($a = $result->fetch_field()) {

//print_r ($rs);
//}
//echo "</pre>";
  $titulo="LICITACIÓN/ESTUDIO DE OBRA" ;
  $updates=[ 'Requisitos', 'id_obra_estudio',  'PLAZO','Baja Tecnica','Oferta Tecnica','iva','Baja Final','Oferta Final','NUMERO'
      ,'URL_licitacion','PLAZO ENTREGA','NO VAMOS','Fecha Apertura','EXPEDIENTE', 'NOMBRE' ,'Nombre Completo', 'LUGAR'
      , 'Organismo', 'Presupuesto Tipo', 'Plazo Proyecto' ,'Observaciones', 'hora_entrega', 'URL_Google_Maps','Presentada' ]  ;
  
//  $tabla_update="Estudios_de_Obra" ;
  $tabla_update="Estudios_listado" ;
  $id_update="ID_ESTUDIO" ;
  $id_valor=$id_estudio ;
  
//  $importe_iva=$rs['Presupuesto Tipo']*(1+getVar('iva_auto')) ;
  $importe_iva=$rs['Presupuesto Tipo']*(1+$rs['iva']) ;
  
  $link_anadir_obra_estudio= "../obras/obras_anadir.php?NOMBRE_COMPLETO={$rs['Nombre Completo']}.({$rs['Organismo']})&nombre_obra={$rs['NOMBRE']}&IMPORTE={$importe_iva}&ID_ESTUDIO=$id_estudio&tipo_subcentro=E"                 ;
  
  $selects["id_obra_estudio"]=["ID_OBRA","NOMBRE_OBRA","OBRAS",$link_anadir_obra_estudio,"../obras/obras_ficha.php?id_obra=","id_obra_estudio"] ;   // datos para clave foránea Y PARA AÑADIR PROVEEDOR NUEVO
//  $selects["id_prod_estudio_costes"]=["ID_PRODUCCION","CONCAT(PRODUCCION,' - (Baja est.:', COALESCE(FORMAT(margen_est*100,2),0),'%)'  )","Prod_view",'',"../obras/obras_prod_detalle.php?fmt_costes=checked&id_produccion=",'id_prod_estudio_costes'] ;   // Produccion por defecto de la obra-estudio
  $selects["id_prod_estudio_costes"]=["ID_PRODUCCION","PRODUCCION","PRODUCCIONES",'',"../obras/obras_prod_detalle.php?fmt_costes=checked&id_produccion=",'id_prod_estudio_costes','',true] ;   // Produccion por defecto de la obra-estudio
  $etiquetas["id_prod_estudio_costes"] = 'Estudio de costes de la Licitación' ;
  $tooltips["id_prod_estudio_costes"] = 'Relación Valorada principal de la OBRA-ESTUDIO que permite el Estudio de Costes de la Licitación' ;
  
  $sql_enc= encrypt2("SELECT margen_est FROM Prod_view WHERE ID_PRODUCCION={$rs["id_prod_estudio_costes"]};")  ;
  $spans_html["id_prod_estudio_costes"]="<span id='p_est_coste'></span><script>dfirst_ajax('p_est_coste','$sql_enc','progress_success' );</script>  ";


//  $selects["id_obra_estudio"]=["ID_ESTUDIO","NOMBRE","Estudios_de_Obra","" ,"../estudios/estudios_ficha.php?id_estudio=","ID_ESTUDIO"] ;   // datos para clave foránea
  $tooltips["id_obra_estudio"]='Puede crear y asociar a la Licitación una Obra vacía para facilitar el estudio de costes, solicitudes de presupuestos, etc... ';
  $selects["id_obra_estudio"]["valor_null"]=0;
  $selects["id_obra_estudio"]["valor_null_texto"]='sin obra-estudio';

  
//  $links["URL_licitacion"] = [$rs["URL_licitacion"], "", "", "formato_sub"] ;
//  $links["URL_licitacion"] = [$rs["URL_licitacion"], "", ""] ;
//  $links["Banco"] = ["../bancos/bancos_mov_bancarios.php?id_cta_banco=", "id_cta_banco", "", "formato_sub"] ;


  $links["URL_Google_Maps"] = [$rs["URL_Google_Maps"], "", "", "formato_sub"] ;
  $formats["URL_Google_Maps"]="textarea_20" ;
//  $etiquetas["URL_Google_Maps"]="$ICON-map-marker$SPAN URL Google Maps "  ;
  $etiquetas["URL_Google_Maps"]="<i class='fas fa-map-marker-alt'></i> URL Google Maps"  ;

  
  $formats["Nombre Completo"]='text_edit' ;
  $formats["NOMBRE"]='text_edit' ;
//  $color=str2color($rs["Estado"]) ;
//  $styles["Estado"]="style='color:$color ;'" ;
  $formats["Estado"]='h4_'.str2color($rs["Estado"]) ;   // formato H4 con el color aleatorio de STRING
//  $styles
  
  $formats["URL_licitacion"]='textarea_30' ;

  $formats["Baja_final"]='porcentaje' ;
  $formats["Baja Tecnica"]='porcentaje' ;
  $formats["Presupuesto Tipo"]='moneda' ;
  $formats["PLAZO ENTREGA"]='fecha' ;
  $formats['NO VAMOS']='boolean' ;
  $formats['Presentada']='boolean' ;
  $tooltips["NO VAMOS"]='Indica si NO VAMOS a la licitación, es decir, la DESCARTAMOS.' ;
  $etiquetas["Presupuesto Tipo"]='Presupuesto Tipo(sin iva)' ;
  
  $formats['Oferta_Final_txt']='num2txt_eur' ;
  $formats['Oferta_Final_IVA_txt']='num2txt_eur' ;
  $formats['importe_del_iva']='num2txt_eur' ;
 
  $delete_boton=1 ;
  $boton_cerrar=1 ;
  
  $nombre_estudio = $rs["NUMERO"]."-".substr($rs["NOMBRE"],0,100);
  $baja_tecnica =  $rs["Baja Tecnica"] ;
  $baja_final =  $rs["Baja_final"] ;
    
  ?>
  
                
                    
  <!--<div style="overflow:visible">-->	   
  <div >	   
  <div id="main" class="mainc_70"> 
      
  <?PHP require("../include/ficha.php"); ?>
   
      <!--// FIN     **********    FICHA.PHP-->
 </div>
      
      
	
	<!--  BOTONES ACCIONES  -->
	
<div class="right2">
	

<?php 


// Actualización tipo obra
$disable_adjudicar=  $rs["tipo_subcentro"]=="E" ? "": "disabled" ;
$title_adjudicar=  $rs["tipo_subcentro"]=="E" ? "Adjudica la licitación actual, pasando a subcentro tipo ESTUDIO a tipo OBRA": "Obra ya adjudicada" ;
$Oferta_Final_IVA= $rs["Oferta_Final_IVA"]  ;

$sql_update= "UPDATE `OBRAS` SET tipo_subcentro='O' , activa='1',IMPORTE='{$rs["Oferta_Final_IVA"]}' ,BAJA={$rs["Baja_final"]},COEF_BAJA=1-{$rs["Baja_final"]} ,EXPEDIENTE='{$rs["EXPEDIENTE"]}'"
                . " WHERE ID_OBRA=$id_obra AND $where_c_coste ; "  ;
$href='../include/sql.php?sql=' . encrypt2($sql_update)  ;    
echo "<br><button class='btn btn-primary btn-xs noprint' href='#' $disable_adjudicar "
     . " onclick=\"js_href('$href' ,'1' )\"   title='$title_adjudicar'>Adjudicar la licitación</button>" ;
      

 ?>
	 
</div>
	<!--  fin ficha estudio  -->
	
<div class="right2">
	

<?php 

$tipo_entidad='estudios' ;
$id_entidad=$id_estudio;
$id_subdir=$id_estudio ;
$size='100px' ;
$entidad=$nombre_estudio ;

require("../menu/LRU_registro.php"); require("../include/widget_documentos.php"); 


 ?>
	 
</div>
        
  <div class="right2">
	
  <?php 

//$tipo_entidad='obra_doc' ;
//$id_entidad=$id_obra;

  require("../agenda/widget_tareas.php");
 
 ?>
	 
  </div>
	
<div class="right2">
	
<?php 
//  WIDGET #FIRMAS 
//$tipo_entidad='estudios' ;
//$id_entidad=$id_estudio ;
//$flags_firma = ($conc ? "Cargada " : "" ) . ($pagada ? "Pagada " : " " ) . ($cobrada ? "Cobrada" : "" ) ;
$firma="Estudio $nombre_estudio (B.Técnica ".cc_format($baja_tecnica, 'porcentaje').") " ;

//$id_subdir=$id_proveedor ;
//$size='400px' ;
require("../include/widget_firmas.php");          // FIRMAS

 ?>
	 
</div>	
	
<?php           

$Conn->close();

?>
	 

</div>

                <!--</div>-->
                <!--****************** BUSQUEDA GLOBAL  *****************
            </div>
        </div>
        <!-- FIN Contenido principal -->
  <br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br>
  <br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br>
  <br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br>
  <br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br>
  <br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br>
 
<?php 

//FIN
include_once('../templates/_inc_privado3_footer.php');

