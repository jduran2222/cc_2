<?php
require_once("../include/session.php");
$where_c_coste=" id_c_coste={$_SESSION['id_c_coste']} " ;


 require_once("../../conexion.php");
 require_once("../include/funciones.php");

$titulo_pagina="Es " . Dfirst("CONCAT(NUMERO,'-',NOMBRE)","Estudios_view", "ID_ESTUDIO={$_GET["id_estudio"]} AND $where_c_coste"  ) ;
?>

<HTML>
<HEAD>
     <title><?php echo $titulo_pagina ?></title> 

	<meta http-equiv="Content-type" content="text/html; charset=UTF-8" />
	<link rel='shortcut icon' type='image/x-icon' href='/favicon.ico' />
	
  <!--ANULADO 16JUNIO20<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">-->
        <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.6.3/css/all.css" integrity="sha384-UHRtZLI+pbxtHCWp1t77Bi1L4ZtiqrqD80Kn4Z8NTSRyMA2Fd33n5dQ8lWUE00s/" crossorigin="anonymous">
   <link rel="stylesheet" href="../css/estilos.css<?php echo (isset($_SESSION["is_desarrollo"]) AND $_SESSION["is_desarrollo"])? "?d=".date("ts") : "" ; ?>" type="text/css">

  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
  <!--ANULADO 16JUNIO20<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>-->
</HEAD>
<BODY>


<?php 



$id_estudio=$_GET["id_estudio"];

require_once("../menu/topbar.php");
 

 echo '<br><br><br><br><br>' ;

 $sql="SELECT ID_ESTUDIO,NUMERO,NOMBRE,`Nombre Completo`,EXPEDIENTE,`NO VAMOS`,Presentada,Estado ,`Presupuesto Tipo`,`PLAZO ENTREGA`, `Plazo Proyecto` "
         . ",hora_entrega,Organismo, URL_licitacion, id_obra_estudio, id_prod_estudio_costes,URL_Google_Maps ,Requisitos, Observaciones"
         . ",`Oferta Tecnica`,`Baja Tecnica`,PLAZO,`Oferta Final`,`Oferta Final` AS Oferta_Final_txt, (1-`Oferta Final`/`Presupuesto Tipo`) as `Baja_final`   ,iva,`Oferta Final`*iva AS importe_del_iva "
         . ",`Oferta Final`*(1+iva) AS Oferta_Final_IVA,`Oferta Final`*(1+iva) AS Oferta_Final_IVA_txt,user, Fecha_Creacion"
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
  
//  $visibles=['id_produccion_obra'] ;
//  $id_estudio=$rs["ID_ESTUDIO"] ;
//  $tabla_update="Estudios_de_Obra" ;
  $tabla_update="Estudios_de_Obra" ;
  $id_update="ID_ESTUDIO" ;
  $id_valor=$id_estudio ;
  
  $importe_iva=$rs['Presupuesto Tipo']*(1+getVar('iva_auto')) ;
  
  $link_anadir_obra_estudio= "../obras/obras_anadir.php?NOMBRE_COMPLETO={$rs['Nombre Completo']}.({$rs['Organismo']})&nombre_obra={$rs['NOMBRE']}&IMPORTE={$importe_iva}&ID_ESTUDIO=$id_estudio&tipo_subcentro=E"                 ;
  
  $selects["id_obra_estudio"]=["ID_OBRA","NOMBRE_OBRA","OBRAS",$link_anadir_obra_estudio,"../obras/obras_ficha.php?id_obra=","id_obra_estudio"] ;   // datos para clave foránea Y PARA AÑADIR PROVEEDOR NUEVO
  $selects["id_prod_estudio_costes"]=["ID_PRODUCCION","CONCAT(PRODUCCION,' - (Baja est.:', COALESCE(FORMAT(margen_est*100,2),0),'%)'  )","Prod_view",'',"../obras/obras_prod_detalle.php?fmt_costes=checked&id_produccion=",'id_prod_estudio_costes'] ;   // Produccion por defecto de la obra-estudio
  $etiquetas["id_prod_estudio_costes"] = 'Estudio de costes de la Licitación' ;
  $tooltips["id_prod_estudio_costes"] = 'Relación Valorada principal de la OBRA-ESTUDIO que permite el Estudio de Costes de la Licitación' ;
  

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
  $baja_final =  $rs["Baja_final"] ;
    
  ?>
  
                
                    
  <!--<div style="overflow:visible">-->	   
  <div >	   
  <div id="main" class="mainc_70"> 
      
  <?PHP require("../include/ficha.php"); ?>
   
      <!--// FIN     **********    FICHA.PHP-->
 </div>
      
      
	
	<!--  fin ficha estudio  -->
	
<div class="right2">
	

<?php 

$tipo_entidad='estudios' ;
$id_entidad=$id_estudio;
$id_subdir=$id_estudio ;
$size='100px' ;

require("../include/widget_documentos.php");
 ?>
	 
</div>
	
<div class="right2">
	
<?php 
//  WIDGET #FIRMAS 
$tipo_entidad='estudios' ;
$id_entidad=$id_estudio ;
//$flags_firma = ($conc ? "Cargada " : "" ) . ($pagada ? "Pagada " : " " ) . ($cobrada ? "Cobrada" : "" ) ;
$firma="Estudio $nombre_estudio (B.final ".cc_format($baja_final, 'porcentaje').") " ;

//$id_subdir=$id_proveedor ;
//$size='400px' ;
require("../include/widget_firmas.php");          // FIRMAS

 ?>
	 
</div>	
	
<?php           

$Conn->close();

?>
	 

</div>

<!--	<div style="background-color:#f1f1f1;text-align:center;padding:10px;margin-top:7px;font-size:12px;">FOOTER</div>-->
	
<?php require '../include/footer.php'; ?>
</BODY>

</HTML>

