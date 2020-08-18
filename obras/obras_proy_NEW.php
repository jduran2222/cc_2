<?php
// cambios
require_once("../include/session.php");
$where_c_coste = " id_c_coste={$_SESSION['id_c_coste']} ";
$id_c_coste = $_SESSION['id_c_coste'];

$titulo = 'Prod. Detalle';

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



<!-- CONEXION CON LA BBDD Y MENUS -->
<?php 

require_once("../include/NumeroALetras.php");

?>


<div style="overflow:visible">	   
   
	<!--************ INICIO *************  -->

<div id="main" class="mainc" style="width:100%; background-color:#fff">
	
<?php 

$listado_global= (!isset($_GET["id_produccion"])) ;
$iniciar_form=(!isset($_POST["CAPITULO"])) ;  // determinamos si debemos de inicializar el FORM con valores vacíos

$style_hidden_if_global=$listado_global? " disabled " : ""  ; 

if (!$listado_global)                
  {
 $id_produccion=$_GET["id_produccion"];

 $id_obra=Dfirst("ID_OBRA", "Prod_view","ID_PRODUCCION=$id_produccion AND $where_c_coste" ) ;
 $PRODUCCION= Dfirst("PRODUCCION", "Prod_view","ID_PRODUCCION=$id_produccion AND $where_c_coste" ) ;
 $NOMBRE_COMPLETO= Dfirst("NOMBRE_COMPLETO", "OBRAS","ID_OBRA=$id_obra AND $where_c_coste" ) ;
 $EXPEDIENTE= Dfirst("EXPEDIENTE", "OBRAS","ID_OBRA=$id_obra AND $where_c_coste" ) ;
 
 require_once("../obras/obras_menutop_r.php");
 
  }
  else
  {
      
//    require("../menu/general_menutop_r"); 
    if ($iniciar_form)    
    {   $OBRA=  isset($_GET["OBRA"]) ?  $_GET["OBRA"] :  "" ;
        $PRODUCCION= isset($_GET["PRODUCCION"]) ?  $_GET["PRODUCCION"] :  "" ;
    }
    else
    {  $OBRA=$_POST["OBRA"] ; 
       $PRODUCCION=$_POST["PRODUCCION"] ;
    
    }   
      
  }
$solo_form=0;


if ($iniciar_form)
{
//form vacio
  $solo_form=1;
//  $tipo_subcentro="OGAMEX";
//  $NOMBRE_OBRA="";
//  $PRODUCCION="";
  $CAPITULO= isset($_GET["CAPITULO"]) ?  $_GET["CAPITULO"] :  "" ;
  $UDO = isset($_GET["UDO"]) ?  $_GET["UDO"] :  "" ;
  $FECHA1 = isset($_GET["FECHA1"]) ?  $_GET["FECHA1"] :  "" ;
  $FECHA2 = isset($_GET["FECHA2"]) ?  $_GET["FECHA2"] :  "" ;
  $SUBOBRA = isset($_GET["SUBOBRA"]) ?  $_GET["SUBOBRA"] :  "" ;
  $DETALLE = isset($_GET["DETALLE"]) ?  $_GET["DETALLE"] :  "" ;
  $fmt_costes = isset($_GET["fmt_costes"]) ?  $_GET["fmt_costes"] :  "" ;
  $fmt_resumen_cap = isset($_GET["fmt_resumen_cap"]) ?  $_GET["fmt_resumen_cap"] :  "" ;
  $fmt_texto_udo = isset($_GET["fmt_texto_udo"]) ?  $_GET["fmt_texto_udo"] :  "" ;
  $fmt_med_proyecto = isset($_GET["fmt_med_proyecto"]) ?  $_GET["fmt_med_proyecto"] :  "checked";
  $fmt_anadir_med = isset($_GET["fmt_anadir_med"]) ?  $_GET["fmt_anadir_med"] :  "checked";
  $fmt_seleccion = isset($_GET["fmt_seleccion"]) ?  $_GET["fmt_seleccion"] :  "checked";
  $agrupar = isset($_GET["agrupar"]) ?  $_GET["agrupar"] : "capitulos";  

} 
 else {
//$NOMBRE_OBRA=$_POST["NOMBRE_OBRA"];
$CAPITULO=$_POST["CAPITULO"];
$FECHA1=$_POST["FECHA1"];
$FECHA2=$_POST["FECHA2"];
//$PRODUCCION=$_POST["PRODUCCION"];
$UDO=str_replace(" ","%",$_POST["UDO"]);
$SUBOBRA=$_POST["SUBOBRA"];
$DETALLE=$_POST["DETALLE"];

$fmt_costes=isset($_POST["fmt_costes"]) ? 'checked' : '' ;
$fmt_resumen_cap=isset($_POST["fmt_resumen_cap"]) ? 'checked' : '' ;
$fmt_texto_udo=isset($_POST["fmt_texto_udo"]) ? 'checked' : '' ;
$fmt_med_proyecto=isset($_POST["fmt_med_proyecto"]) ? 'checked' : '' ;
$fmt_anadir_med=isset($_POST["fmt_anadir_med"]) ? 'checked' : '' ;
$fmt_seleccion=isset($_POST["fmt_seleccion"]) ? 'checked' : '' ;

$agrupar=$_POST["agrupar"];   
$crea_produccion=$_POST["crea_produccion"];   

     
 }

  $solo_form=0;

 ?>

    
    
<?php  
echo "<div class='noprint'><br><br><br><br></div>" ;

if (!$listado_global)     
  {
  echo "<a class='btn btn-link noprint' href= '../obras/obras_prod_detalle.php?OBRA=SIN_OBRA' title='Ir a las producciones de todas las obras'><i class='fas fa-globe-europe'></i> Prod. detalle Global</a>" ;

    ?>    
 
 <a class="btn btn-link noprint" title="va al listado de Producciones de la Obra" href="../obras/obras_prod.php?id_obra=<?php echo $id_obra;?>" ><span class="glyphicon glyphicon-arrow-left"></span> Volver a Producciones</a>    
 <a class="btn btn-link noprint" title="imprimir" href=#  onclick="window.print();"><i class="fas fa-print"></i> Imprimir pantalla</a>
 <a class="btn btn-link noprint" title="ver datos generales de la Produccion actual" target='_blank' href="../obras/prod_ficha.php?id_obra=<?php echo $id_obra;?>&id_produccion=<?php echo $id_produccion;?>" ><span class="glyphicon glyphicon-th-list"></span> ficha Produccion</a>    
 
<script>

function formato_prod_obra()
{ //    $('#fmt_costes').prop('checked',!($('#fmt_costes').prop('checked'))) ;
    $('#fmt_costes').prop('checked',false) ;
    $('#fmt_texto_udo').prop('checked',true) ;
    $('#fmt_med_proyecto').prop('checked',true) ;  
    $('#fmt_resumen_cap').prop('checked',false) ;  
    $('#fmt_anadir_med').prop('checked',true) ;  
    $('#fmt_seleccion').prop('checked',false) ;  
//    $('#btn_agrupar_udos').click() ;  
//   document.getElementbyID("btn_agrupar_udos").click();
//   document.getElementById('agrupar').value = 'udos'; document.getElementById('form1').submit();

//    window.print();
}
function formato_certif()
{ //    $('#fmt_costes').prop('checked',!($('#fmt_costes').prop('checked'))) ;
    $('#fmt_costes').prop('checked',false) ;
    $('#fmt_texto_udo').prop('checked',true) ;
    $('#fmt_med_proyecto').prop('checked',false) ;  
    $('#fmt_resumen_cap').prop('checked',true) ;  
    $('#fmt_anadir_med').prop('checked',false) ;  
    $('#fmt_seleccion').prop('checked',false) ;  
    
//     $('#UDO_72152').val('123') ;
//    $('#btn_agrupar_udos').click() ;  
//   document.getElementbyID("btn_agrupar_udos").click();
//   document.getElementById('agrupar').value = 'udos'; document.getElementById('form1').submit();

//    window.print();
}
</script>    

 
 <h3><span class='noprint'>PROYECTO</span></h3>
 
         <!--ENCABEZADOS PARA IMPRESION-->
 <!--<div class='divHeader'>-->
 <div >
   <h4 class='border'><?php echo $NOMBRE_COMPLETO;?></h4>
   <h6>EXPEDIENTE: <?php echo $EXPEDIENTE;?></h6>
 </div>  
   <h3><?php echo $PRODUCCION;?></h3>

   
<!--  <div class='divFooter'>
   <h6 class='border'>Página</h6> 
 </div>  
   -->
    <div class='row noprint' style='border-style: solid ; border-color:grey; margin-bottom: 5px; padding:10px'>
 
   
   <form class='noprint' action="../obras/obras_prod_detalle.php?id_obra=<?php echo $id_obra;?>&id_produccion=<?php echo $id_produccion;?>" method="post" id="form1" name="form1">
    <div class='col-lg-4'>
           
<TABLE class="noprint">
<!--    <TR><TD color=red colspan=2 bgcolor=PapayaWhip align=center>
            
        </TD></TR>-->

<?php 

  }
  else
  {

?>
     <h1>PRODUCCIONES DETALLE BUSQUEDA GLOBAL <i class='fas fa-globe-europe'></i></h1>
     
     <div class='row noprint' style='border-style: solid ; border-color:grey; margin-bottom: 5px; padding:10px'>
    <div class='col-lg-4'>
  

   <form class='noprint' action="../obras/obras_prod_detalle.php" method="post" id="form1" name="form1">
<!--<div class="form-group">-->           
<TABLE class="noprint">
      
    <TR><TD>OBRA   </TD><TD><INPUT  type="text" id="OBRA" name="OBRA" value="<?php echo $OBRA;?>"><button type="button" onclick="document.getElementById('OBRA').value='' ; ">*</button></TD></TR>
    <TR><TD>PRODUCCION   </TD><TD><INPUT   type="text" id="PRODUCCION" name="PRODUCCION" value="<?php echo $PRODUCCION;?>"><button type="button" onclick="document.getElementById('PRODUCCION').value='' ; ">*</button></TD></TR>
<?php 

  }

?>
    
<!--<TR><TD>CAPITULO   </TD><TD><INPUT class="form-control" type="text" id="CAPITULO" name="CAPITULO" value="<?php echo $CAPITULO;?>"><button type="button" onclick="document.getElementById('CAPITULO').value='' ; ">*</button></TD></TR>-->    
<TR><TD>CAPITULO   </TD><TD><INPUT  type="text" id="CAPITULO" name="CAPITULO" value="<?php echo $CAPITULO;?>"><button type="button" onclick="document.getElementById('CAPITULO').value='' ; ">*</button></TD></TR>
<TR><TD>Unidad de obra (UDO)</TD><TD><INPUT   type="text" id="UDO" name="UDO" value="<?php echo $UDO;?>"><button type="button" onclick="document.getElementById('UDO').value='' ; ">*</button></TD></TR>

</TABLE></div><div class='col-lg-4'><TABLE> 


<TR><TD>FECHA1     </TD><TD><INPUT  type="date" id="FECHA1" name="FECHA1" value="<?php echo $FECHA1;?>"><button type="button" onclick="document.getElementById('FECHA1').value='' ; ">*</button></TD></TR>
<TR><TD>FECHA2     </TD><TD><INPUT type="date" id="FECHA2" name="FECHA2" value="<?php echo $FECHA2;?>"><button type="button" onclick="document.getElementById('FECHA2').value='' ; ">*</button></TD></TR>

</TABLE></div><div class='col-lg-4'><TABLE> 

<TR><TD>SUBOBRA    </TD><TD><INPUT type="text" id="SUBOBRA" name="SUBOBRA" value="<?php echo $SUBOBRA;?>"><button type="button" onclick="document.getElementById('SUBOBRA').value='' ; ">*</button></TD></TR>
<TR><TD>Detalle    </TD><TD><INPUT type="text" id="DETALLE" name="DETALLE" value="<?php echo $DETALLE;?>"><button type="button" onclick="document.getElementById('DETALLE').value='' ; ">*</button></TD></TR>

<TR><TD></TD><TD><INPUT type="submit" class='btn btn-success btn-xl' style='width: 15vw;'  value="actualizar consulta" id="submit" name="submit"></TD></TR>

<input type="hidden"  id="agrupar"  name="agrupar" value="<?php echo $agrupar;?>"> 
<input type="hidden"  id="agrupar"  name="crea_produccion" value="0"> 

</TABLE></div></div>


<div class='noprint'>
Formato:&nbsp; 
        <label><INPUT type="checkbox" id="fmt_seleccion" name="fmt_seleccion" <?php echo $fmt_seleccion;?>  >&nbsp;Selección&nbsp;&nbsp;</label>
        <label><INPUT type="checkbox" id="fmt_costes" name="fmt_costes" <?php echo $fmt_costes;?>  >&nbsp;Costes Est.&nbsp;&nbsp;</label>
        <label><INPUT type="checkbox" id="fmt_texto_udo" name="fmt_texto_udo" <?php echo $fmt_texto_udo;?>  >&nbsp;Texto udo&nbsp;&nbsp;</label>
        <label><INPUT type="checkbox" id="fmt_med_proyecto" name="fmt_med_proyecto" <?php echo $fmt_med_proyecto;?>  >&nbsp;MED_PROYECTO&nbsp;&nbsp;</label>
        <label><INPUT type="checkbox" id="fmt_resumen_cap" name="fmt_resumen_cap" <?php echo $fmt_resumen_cap;?>  >&nbsp;Resumen capitulos&nbsp;&nbsp;</label>
        <label><INPUT type="checkbox" id="fmt_anadir_med" title='añade una columna donde poder añadir mediciones' name="fmt_anadir_med" <?php echo $fmt_anadir_med;?>  >&nbsp;Columna Añadir Med.&nbsp;&nbsp;</label>
         <a class="btn btn-link btn-xs noprint" title="imprimir la producción con formato de Certificación sin costes, con texto_udo y con resumen" href=#  onclick="formato_certif();"><i class="fas fa-print"></i> formato certificacion</a>
         <a class="btn btn-link btn-xs noprint" title="formato de formulario para registrar Producciones de Obra" href=#  onclick="formato_prod_obra();"><i class="fas fa-hard-hat"></i> formato prod. obra</a>

       
</div>         
         
<?php  

$style_hidden_if_global=$listado_global? " disabled " : ""  ;

echo "<div id='myDIV' class='noprint' style='margin-top: 25px; padding:10px'>" ; 


$btnt['capitulos']=['capitulos','', ''] ;
$btnt['cap_udos']=['cap-udos','',''] ;
$btnt['udos']=['udos','',''] ;
$btnt['detalle']=['detalle','Muestra las Producción con cada detalle de Medición',''] ;
$btnt['subobras']=['subobras','Agrupa por subobras',''] ;
$btnt['costes']=['costes','', $style_hidden_if_global] ;
$btnt['obras']=['obras','Agrupa por Obra',''] ;
$btnt['meses']=['meses','',''] ;
$btnt['fechas']=['fechas','',''] ;
$btnt['comparadas']=['comparadas','',''] ;
$btnt['EDICION']=['MODO EDICION','' ,$style_hidden_if_global ] ;

foreach ( $btnt as $clave => $valor)
{
  $active= ($clave==$agrupar) ? " cc_active" : "" ; 
  $disabled= $valor[2]  ;
  echo "<button $disabled id='btn_agrupar_$clave' class='cc_btnt$active' title='{$valor[1]}' onclick=\"getElementById('agrupar').value = '$clave'; document.getElementById('form1').submit(); \">{$valor[0]}</button>" ;  
}           
  
echo '</div>' ;

//echo "<button  class='btn btn-warning' title='copia el resultado de la consulta a una produccion nueva' onclick=\"getElementById('crea_produccion').value = '1'; document.getElementById('form1').submit(); \">Consulta a prod. nueva</button>" ;  



?>        
         
         
</form>


			
<?php   // Iniciamos variables para tabla.php  background-color:#B4045


$where=" 1=1 " ;

if ($listado_global)     
  {
  $where=$OBRA==""? $where : $where . " AND NOMBRE_OBRA LIKE '%$OBRA%'" ;
  $where=$PRODUCCION==""? $where : $where . " AND PRODUCCION LIKE '%$PRODUCCION%'" ;
  }
 else
{
  if ($agrupar<>"EDICION") {$where=$where . " AND id_produccion=$id_produccion "; }  
}
  


//$where=$tipo_subcentro==""? $where : $where . " AND LOCATE(tipo_subcentro,'$tipo_subcentro')>0 " ;

$where=$CAPITULO==""? $where : $where . " AND CAPITULO LIKE '%$CAPITULO%'" ;
$where=$UDO==""? $where : $where . " AND CONCAT_WS(' ',UDO,IFNULL(TEXTO_UDO,'')) LIKE '%$UDO%'" ;
$where=$SUBOBRA==""? $where : $where . " AND SUBOBRA LIKE '%$SUBOBRA%'" ;
$where=$DETALLE==""? $where : $where . " AND Observaciones LIKE '%$DETALLE%'" ;
//$where=$TIPO_GASTO==""? $where : $where . " AND TIPO_GASTO LIKE '%$TIPO_GASTO%'" ;
//$where=$FECHA1=="01-01-1980"? $where : $where . " AND FECHA >= STR_TO_DATE($FECHA1,'%d-%m-%Y')" ;

if ($agrupar<>"EDICION") {$where=$FECHA1==""? $where : $where . " AND FECHA >= '$FECHA1' " ;}
if ($agrupar<>"EDICION")  {$where=$FECHA2==""? $where : $where . " AND FECHA <= '$FECHA2' " ; }


// SELECT A INCLUIR EN LOS SQL SEGUN EL FORMATO ///////////////////////////////////////////
$select_global = $listado_global ? "NOMBRE_OBRA, ID_PRODUCCION, PRODUCCION," : ""  ;               
$select_global_T = $listado_global ? "'' AS ag, '' AS bg," : ""  ;   

// SI ES formato Costes $fmt_costes añadimos las columnas gastos_est y beneficio
$select_COSTE_EST = $fmt_costes ? ", COSTE_EST" : ""  ;               
$select_COSTE_EST_T = $fmt_costes ? ", '' as COSTE_EST" : ""  ;               
$select_costes = $fmt_costes ? ", SUM(gasto_est) as gasto_est,(SUM(IMPORTE)- SUM(gasto_est)) as beneficio" : ""  ;               
//$select_costes_T = $fmt_costes ? ", SUM(gasto_est) as gasto_est, '<small>Benef. Estimado</small>' as leyenda_beneficio, ''" : ""  ;   
$select_costes_T = $fmt_costes ? ", SUM(gasto_est) as gasto_est, (SUM(IMPORTE)- SUM(gasto_est)) as beneficio " : ""  ;   
$select_costes_T2 = $fmt_costes ? ", SUM(gasto_est) as gasto_est,(SUM(IMPORTE)*(1+GG_BI)*COEF_BAJA- SUM(gasto_est)) as beneficio " : ""  ;   
$select_costes_T3 = $fmt_costes ? ", SUM(gasto_est)*(1+iva_obra) as gasto_est, (1- SUM(gasto_est)/(SUM(IMPORTE)*(1+GG_BI)*COEF_BAJA)) as margen " : ""  ;   


$select_UDO = $fmt_texto_udo ? " ,CONCAT('<b>',UDO,'</b><br><small>',TEXTO_UDO,'</small>') AS UDO " : " ,UDO "  ;               

//$select_JOIN_med_proyecto = $fmt_med_proyecto ? " JOIN Capitulos_importe ON ConsultaProd.ID_CAPITULO=Capitulos_importe.ID_CAPITULO  " : ""  ;               
//$select_MED_PROYECTO = $fmt_med_proyecto ? ", MED_PROYECTO,MED_PROYECTO*PRECIO as importe_proy, (MED_PROYECTO >= SUM(MEDICION) ) AS exceso,(MED_PROYECTO*PRECIO - SUM(MEDICION)*PRECIO) as importe_pdte " : ""  ;               
$select_MED_PROYECTO = $fmt_med_proyecto ? ", MED_PROYECTO,MED_PROYECTO*PRECIO as importe_proy, (MED_PROYECTO*PRECIO - SUM(MEDICION)*PRECIO) as importe_pdte_ej " : ""  ;               
$select_MED_PROYECTO_detalle = $fmt_med_proyecto ? ", MED_PROYECTO " : ""  ;               
$select_importe_proyecto = $fmt_med_proyecto ? ", importe_proyecto,  SUM(IMPORTE)/importe_proyecto AS P_ejec,importe_proyecto - SUM(IMPORTE) as importe_pdte_ej " : ""  ;               
$select_importe_proyecto_T = $fmt_med_proyecto ? ", SUM(importe_proyecto),  SUM(IMPORTE)/SUM(importe_proyecto) AS P_ejec ,SUM(importe_proyecto) - SUM(IMPORTE) as importe_pdte_ej " : ""  ;               
//$select_SUM_importe_proyecto = $fmt_med_proyecto ? ", SUM(importe_proyecto) " : ""  ;               
//$select_SUM_importe_proyecto_GG_BI = $fmt_med_proyecto ? ", SUM(importe_proyecto)*(1+GG_BI)*COEF_BAJA*(1+iva_obra) " : ""  ;               
$select_MED_PROYECTO_hueco = $fmt_med_proyecto ? ", '' AS hueco " : ""  ;               
$select_MED_PROYECTO_hueco_doble = $fmt_med_proyecto ? ", '' AS hueco,'' AS hueco2 " : ""  ;    

//$fmt_anadir_med=1;
$select_anadir_med = $fmt_anadir_med ? " ,CONCAT('<input  type=text size=3 id=UDO_' , ID_UDO, '>' ) AS Anadir_Med " : ""  ;               
$select_anadir_med_Udos_View = $fmt_anadir_med ? " ,CONCAT('<input  type=text size=3 id=UDO_' , Udos_View.ID_UDO, '>' ) AS Anadir_Med " : ""  ;               


$tipo_tabla='' ;       // indica si usamos tabla.php o tabla_group.php o tabla_pdf.php
//$tabla_pdf=0 ;             // usaremos TABLA_GROUP.PHP 


// defino totales para Agrupamiento 'capituos' y cap_udos'

$sql_T_resumen="SELECT $select_global_T 'Suma Ejecución Material........................' $select_MED_PROYECTO_hueco_doble , SUM(IMPORTE) as importe $select_costes_T  FROM ConsultaProd WHERE $where    " ;
$sql_T2_resumen="SELECT $select_global_T CONCAT('Suma Ejecución Contrata... GG+BI x COEF_BAJA:',COEF_BAJA)$select_MED_PROYECTO_hueco_doble , SUM(IMPORTE)*(1+GG_BI)*COEF_BAJA as importe $select_costes_T2  FROM ConsultaProd WHERE $where    " ;
$sql_T3_resumen="SELECT $select_global_T 'Suma Ejecución Contrata (iva incluido).. ' $select_MED_PROYECTO_hueco_doble , SUM(IMPORTE)*(1+GG_BI)*COEF_BAJA*(1+iva_obra)/IMPORTE_OBRA as P_ejec , SUM(IMPORTE)*(1+GG_BI)*COEF_BAJA*(1+iva_obra) as importe $select_costes_T3 FROM ConsultaProd WHERE $where    " ;

// FIN DE SELECT A INCLUIR EN SQL  //////////////////////////////////


// BOTONES A MOSTRAR SEGUN EL FORMATO, SELECCIÓN, ANADIR_MED...

$content_sel="" ;         // inicializamos el contenido del <div> SELECTION
$content_anadir_med="" ;

if (!$listado_global)
{    
// contenedor selection por defecto
     $content_sel.="<div class='border noprint' >" ;
     $content_sel.="<big>Seleccionados:</big> <a class='btn btn-danger btn-xs noprint btn_topbar' href='#' onclick='borrar_mediciones_udo($id_produccion)' title='Vacía las mediciones de las Udo seleccionadas' ><i class='far fa-trash-alt'></i> Borrar mediciones Udos seleccionadas</a>" ;
     $content_sel.="<a class='btn btn-warning btn-xs noprint btn_topbar' href='#' onclick='prod_completa_udo($id_produccion)' title='Completa hasta Medicion de Proyecto (MED_PROYECTO) las Udos seleccionadas' >MED_PROYECTO a Udos seleccionadas</a>" ;
     $content_sel.="</div>" ; 
     
    if ($fmt_anadir_med) $content_anadir_med="  <a class='btn btn-warning btn-xs noprint btn_topbar' href='#' onclick='prod_anade_med_udo($id_produccion)' title='Añade a cada unidad de obra la medición de la columna 'Añadir Med' >añade columna de mediciones </a>" ;

//    $sql="SELECT  ID_OBRA,ID_CAPITULO, CAPITULO AS ID_SUBTOTAL_CAPITULO,ID_UDO,ID_UDO AS _ID_UDO,ud $select_UDO $select_MED_PROYECTO,SUM(MEDICION) as MEDICION"
//           . " $select_anadir_med , PRECIO, SUM(IMPORTE) as importe $select_COSTE_EST $select_costes  FROM ConsultaProd WHERE $where  GROUP BY ID_UDO ORDER BY CAPITULO,ID_UDO " ;

//    $where_urlencode=rawurlencode($where) ;
    $where_urlencode=base64_encode($where) ;
//    $where_urlencode=$where ;
    echo " <a class='btn btn-warning btn-xs noprint btn_topbar' href='#' onclick=\"copy_prod_consulta($id_obra,$id_produccion,'$where_urlencode','$PRODUCCION')\" title='copia consulta a prod. nueva' >consulta a prod.nueva</a>" ;
}  
// FIN BOTONES A MOSTRAR

 switch ($agrupar) {
   case "obras":
     $sql="SELECT ID_OBRA,NOMBRE_OBRA , SUM(IMPORTE) as importe  FROM ConsultaProd WHERE $where   GROUP BY ID_OBRA ORDER BY NOMBRE_OBRA " ;
     $sql_T="SELECT 'Suma' , SUM(IMPORTE) as importe  FROM ConsultaProd WHERE $where    " ;
   break;
      
   case "costes":
     $sql="SELECT ID_OBRA,tipo_subcentro, NOMBRE_OBRA , SUM(IMPORTE) as importe  FROM ConsultaGastos_View WHERE $where AND $where_c_coste  GROUP BY ID_OBRA ORDER BY NOMBRE_OBRA" ;
     $sql_T="SELECT '','Suma' , SUM(IMPORTE) as importe  FROM ConsultaGastos_View WHERE $where AND $where_c_coste   " ;
   break;

   case "capitulos":
     $sql="SELECT $select_global ID_OBRA,ConsultaProd.ID_CAPITULO, CAPITULO $select_importe_proyecto , SUM(IMPORTE) as importe $select_costes  FROM "
           . " ConsultaProd  JOIN Capitulos_importe ON ConsultaProd.ID_CAPITULO=Capitulos_importe.ID_CAPITULO "
           . " WHERE $where  GROUP BY ID_CAPITULO ORDER BY CAPITULO " ;

     $sql_T=$sql_T_resumen ;
     $sql_T2=$sql_T2_resumen ;
     $sql_T3=$sql_T3_resumen ;
        
     $updates=['CAPITULO']  ;
     $tabla_update="Capitulos" ;
     $id_update="ID_CAPITULO" ;
     $id_clave="ID_CAPITULO" ;
   break;
 
   case "udos":
     $sql="SELECT $select_global ID_OBRA,ID_CAPITULO, CAPITULO AS ID_SUBTOTAL_CAPITULO,ID_UDO,ID_UDO AS _ID_UDO,ud $select_UDO $select_MED_PROYECTO,SUM(MEDICION) as MEDICION"
           . " $select_anadir_med , PRECIO, SUM(IMPORTE) as importe $select_COSTE_EST $select_costes  FROM ConsultaProd WHERE $where  GROUP BY ID_UDO ORDER BY CAPITULO,ID_UDO " ;
     $sql="SELECT  ID_OBRA,ID_CAPITULO, CAPITULO AS ID_SUBTOTAL_CAPITULO,ID_UDO,ID_UDO AS _ID_UDO,ud $select_UDO $select_MED_PROYECTO, MED_PROYECTO"
           . " $select_anadir_med , PRECIO, MED_PROYECTO*PRECIO as IMPORTE $select_COSTE_EST $select_costes  FROM Proyecto_View WHERE 1=1  ORDER BY CAPITULO,ID_UDO " ;


//     $sql_T="SELECT  '' as a31,'' as a14,'' as a15 $select_MED_PROYECTO_hueco,'TOTAL ' , SUM(IMPORTE) as importe $select_COSTE_EST_T $select_costes  FROM ConsultaProd WHERE $where    " ;

   if (!$fmt_resumen_cap)      // si imprimimos el RESUMEN suponemos que es una certificacion y quitamos los totales
   {   
//     $sql_T2="SELECT $select_global_T  CONCAT('Suma Ejecución Contrata... GG+BI x COEF_BAJA:',COEF_BAJA) $select_MED_PROYECTO_hueco  ,'' as a1,'' as a2, '<center>P_Ejec</center>', SUM(IMPORTE)*(1+GG_BI)*COEF_BAJA as importe,'' as a5 $select_costes_T2  FROM ConsultaProd WHERE $where    " ;
//     $sql_T3="SELECT $select_global_T  'Suma Ejecución Contrata (iva incluido).. ' $select_MED_PROYECTO_hueco ,'' as a2a,'' as a3a, SUM(IMPORTE)*(1+GG_BI)*COEF_BAJA*(1+iva_obra)/IMPORTE_OBRA as P_ejec , SUM(IMPORTE)*(1+GG_BI)*COEF_BAJA*(1+iva_obra) as importe,'' as a5 $select_costes_T3 FROM ConsultaProd WHERE $where    " ;
   }


//echo $sql_T2 ;
     
// permite editar el coste_est
     $updates=['COSTE_EST']  ;
     $tabla_update="Udos" ;
     $id_update="ID_UDO" ;
     $id_clave="ID_UDO" ;
   
    if ($fmt_seleccion) { $col_sel="ID_UDO" ;}  // activo la Selection con el campo 'id' 
//     $content_sel="<div class='noprint border' >" ;
//     $content_sel.="<big>Seleccionados:</big> <a class='btn btn-danger btn-xs noprint' href='#' onclick='borrar_mediciones_udo($id_produccion)' title='Vacía las mediciones de las Udo seleccionadas' ><i class='far fa-trash-alt'></i> Borrar mediciones</a>" ;
//     $content_sel.="  <a class='btn btn-warning btn-xs noprint' href='#' onclick='completa_mediciones_udo()' title='Completa hasta Medicion de Proyecto (MED_PROYECTO) las Udos seleccionadas' >completa mediciones Udos</a>" ;
//     $content_sel.="</div>" ;
     
     $col_subtotal='ID_SUBTOTAL_CAPITULO' ;
     $array_sumas['importe']=0 ;
     if  ($fmt_costes)
         {
          $array_sumas['vacio']=0 ; 
          $formats['vacio'] = "vacio" ;
           $array_sumas['gasto_est']=0 ;
           $array_sumas['beneficio']=0 ;
         }
     $colspan=5 + ($select_MED_PROYECTO<>'');
     
     $valign["ud"]='top' ;               // PENDIENTE DE TERMINAR. VERTICAL-ALIGN
     $valign["importe"]='bottom' ;        
     
   break;

   case "cap_udos":
//    $sql="SELECT NOMBRE_OBRA, PRODUCCION, ID_OBRA,CAPITULO ,ID_UDO,UDO,MED_PROYECTO,SUM(MEDICION) as MEDICION, PRECIO, SUM(IMPORTE) as importe  FROM ConsultaProd WHERE $where  GROUP BY ID_UDO ORDER BY CAPITULO,ID_UDO " ;

//     $sql="SELECT $select_global ID_OBRA,ID_CAPITULO, CAPITULO ,ID_UDO,ud,UDO,MED_PROYECTO,SUM(MEDICION) as MEDICION, PRECIO,COSTE_EST, SUM(IMPORTE) as importe,COSTE_EST, SUM(gasto_est) as gasto_est  FROM ConsultaProd WHERE $where  GROUP BY ID_UDO ORDER BY CAPITULO,ID_UDO " ;
     $sql="SELECT $select_global ID_OBRA,ID_CAPITULO, ID_UDO,ID_UDO AS _ID_UDO,ud $select_UDO  $select_MED_PROYECTO "
           . " ,SUM(MEDICION) as MEDICION $select_anadir_med, PRECIO,SUM(IMPORTE) as importe $select_COSTE_EST $select_costes "
           . "FROM ConsultaProd WHERE $where  GROUP BY ID_UDO ORDER BY CAPITULO,ID_UDO " ;
//     echo $sql;
     $sql_T=$sql_T_resumen ;
     $sql_T2=$sql_T2_resumen ;
     $sql_T3=$sql_T3_resumen ;
 
//     $sql_S="SELECT ID_CAPITULO,$select_global CAPITULO , SUM(IMPORTE) as importe $select_costes  FROM ConsultaProd WHERE $where   GROUP BY ID_CAPITULO ORDER BY CAPITULO " ;

//     $sql_S="SELECT $select_global ID_OBRA,ConsultaProd.ID_CAPITULO, CAPITULO $select_importe_proyecto , SUM(IMPORTE) as importe $select_costes  FROM "
//           . " ConsultaProd  JOIN Capitulos_importe ON ConsultaProd.ID_CAPITULO=Capitulos_importe.ID_CAPITULO "
//           . " WHERE $where  GROUP BY ID_CAPITULO ORDER BY CAPITULO " ;

     $sql_S="SELECT ConsultaProd.ID_CAPITULO AS ID_CAPITULO, CAPITULO $select_importe_proyecto , SUM(IMPORTE) as importe   FROM "
           . " ConsultaProd  JOIN Capitulos_importe ON ConsultaProd.ID_CAPITULO=Capitulos_importe.ID_CAPITULO "
           . " WHERE $where  GROUP BY ID_CAPITULO ORDER BY CAPITULO " ;


     $id_agrupamiento="ID_CAPITULO" ;
     // permite editar el coste_est
     $updates=['COSTE_EST']  ;
     $anchos_ppal=[30,20,20,20,20,20,20] ;
    
     $tabla_update="Udos" ;
     $id_update="ID_UDO" ;
     $id_clave="ID_UDO" ;
//     $tabla_group=1 ;             // usaremos TABLA_GROUP.PHP 
     $tipo_tabla='group' ;       // indica si usamos tabla.php o tabla_group.php

     
    if ($fmt_seleccion) { $col_sel="ID_UDO" ;}  // activo la Selection con el campo 'id'
//     $content_sel="<a class='btn btn-danger btn-xs noprint' href='#' onclick='borrar_mediciones_udo($id_produccion)' title='Vacía las mediciones de esta Udo' >Borrar mediciones</a>" ;
//     $content_sel.="<a class='btn btn-warning btn-xs noprint' href='#' onclick='completa_mediciones_udo()' title='Completa hasta Medicion de Proyecto (MED_PROYECTO) las Udos seleccionados' >completa mediciones Udos</a>" ;
    break;

   case "fechas":
    $sql="SELECT  DATE_FORMAT(FECHA, '%Y-%m-%d') as fecha,SUM(importe) as importe  FROM ConsultaProd WHERE $where   GROUP BY fecha  ORDER BY fecha  " ;
    $sql_T="SELECT '' AS D, SUM(IMPORTE) as importe  FROM ConsultaProd WHERE $where  " ;
     break;
   case "meses":
    $sql="SELECT  DATE_FORMAT(FECHA, '%Y-%m') as MES,SUM(importe) as importe  FROM ConsultaProd WHERE $where   GROUP BY MES  ORDER BY MES  " ;
    $sql_T="SELECT '' AS D, SUM(IMPORTE) as importe  FROM ConsultaProd WHERE $where  " ;
    break;
   case "detalle":
   $sql="SELECT id, FECHA AS fecha, $select_global CAPITULO,ID_UDO,ud $select_UDO,Observaciones $select_MED_PROYECTO_detalle, "
          . " MEDICION , PRECIO,COSTE_EST, IMPORTE  FROM ConsultaProd WHERE $where ORDER BY CAPITULO,ID_UDO " ;
   
   $sql_T="SELECT $select_global_T '' as a122,'' as a112,'' as a12,'' as a31,'' as a39,'' as a14,'' as a15,'Suma' , SUM(IMPORTE) as importe  FROM ConsultaProd WHERE $where    " ;
   $actions_row["id"]="id";
   $actions_row["delete_link"]="1";
   $updates=['MEDICION','fecha','Observaciones']  ;
   $tabla_update="PRODUCCIONES_DETALLE" ;
  $id_update="id" ;
  $id_clave="id" ;
  
     if ($fmt_seleccion) { $col_sel="id" ;}  // activo la Selection con el campo 'id'

  
//  $content_sel="<div class='noprint border' >" ;
//  $content_sel.="<big>Seleccionados:</big>" ; 
//  $content_sel="<a class='btn btn-danger btn-xs noprint' href='#' onclick='sel_borrar_mediciones_detalle()' title='Borra detalles de medición seleccionados' >Borrar detalle mediciones</a>" ;
//  $content_sel.="</div>" ;
  
     break;
   case "EDICION":
   $onclick1_VARIABLE1_="ID_UDO" ;           // paso de variables para dar instrucciones al boton 'add' para añadir un detalle a la udo
   $onclick1_VARIABLE2_="MED_PROYECTO" ;     // idem
   $actions_row["onclick1_link"]="<a class='btn btn-link btn-xs' title='añade nuevo detalle de medición a la Udo' href=# onclick=\"add_detalle( $id_produccion, _VARIABLE1_ , '_VARIABLE2_' )\" >add</a> ";
   $actions_row["id"]="ID_UDO"; 
   
   $sql0="SELECT * FROM Prod_det_suma WHERE ID_PRODUCCION=$id_produccion   " ;    
   $sql="SELECT Udos_View.ID_UDO , CAPITULO,COD_PROYECTO AS Cod, ud $select_UDO, MED_PROYECTO, suma_medicion AS MEDICION $select_anadir_med_Udos_View,PRECIO $select_COSTE_EST, suma_medicion*PRECIO AS importe"
        . " FROM Udos_View LEFT JOIN ($sql0)  AS SQL0 ON Udos_View.ID_UDO=SQL0.ID_UDO    WHERE ID_OBRA=$id_obra AND $where " ;        
   
//   echo $sql ;
//   $sql_T="SELECT '' as a122,'' as a112,'' as a12,'' as a31,'' as a39,'' as a14,'' as a15,'Suma' , SUM(IMPORTE) as importe  FROM ConsultaProd WHERE ID_PRODUCCION=$id_produccion  " ;
   $sql_T="SELECT '' as a122,'' as a112,'' as a12,'' as a31,'' as a39,'' as a14 $select_COSTE_EST_T,'Suma' , SUM(IMPORTE) as importe  FROM ConsultaProd WHERE ID_PRODUCCION=$id_produccion AND $where  " ;
//   echo "<br>$sql_T" ;
   $updates=[]  ;
  $tabla_update="PRODUCCIONES_DETALLE" ;
  $id_update="ID_UDO" ;
  $id_clave="ID_UDO" ;
   
     break;
   case "comparadas":
//   $onclick1_VARIABLE1_="ID_UDO" ;           // paso de variables para dar instrucciones al boton 'add' para añadir un detalle a la udo
//   $onclick1_VARIABLE2_="MED_PROYECTO" ;     // idem
//   $actions_row["onclick1_link"]="<a class='btn btn-link btn-xs' title='añade nuevo detalle de medición a la Udo' href=# onclick=\"add_detalle( $id_produccion, _VARIABLE1_ , '_VARIABLE2_' )\" >add</a> ";
//   $actions_row["id"]="ID_UDO"; 
   
   $sql0="SELECT * FROM Prod_det_suma WHERE ID_PRODUCCION=$id_produccion   " ;    
   $sql2="SELECT ID_PRODUCCION,ID_UDO,suma_medicion  FROM Prod_det_suma WHERE ID_PRODUCCION=3052    " ;    
   
   $sql="SELECT Udos_View.ID_UDO, CAPITULO,COD_PROYECTO AS Cod, ud $select_UDO, MED_PROYECTO, SQL0.suma_medicion AS MEDICION1,SQL2.suma_medicion AS MEDICION2,PRECIO, "
           . " SQL0.suma_medicion*PRECIO AS importe1,  SQL2.suma_medicion*PRECIO AS importe2"
        . " FROM Udos_View LEFT JOIN ($sql0)  AS SQL0 ON Udos_View.ID_UDO=SQL0.ID_UDO"
                     . "   LEFT JOIN ($sql2)  AS SQL2 ON Udos_View.ID_UDO=SQL2.ID_UDO "
                     . "  WHERE ID_OBRA=$id_obra AND (SQL0.suma_medicion<>0 AND SQL2.suma_medicion <> 0) " ;   
   
   
//   echo $sql ;
//   $sql_T="SELECT '' as a122,'' as a112,'' as a12,'' as a31,'' as a39,'' as a14,'' as a15,'Suma' , SUM(IMPORTE) as importe  FROM ConsultaProd WHERE ID_PRODUCCION=$id_produccion  " ;
//   $sql_T="SELECT '' as a122,'' as a112,'' as a12,'' as a31,'' as a39,'' as a14,'' as a15,'Suma' , SUM(IMPORTE) as importe  FROM ConsultaProd WHERE ID_PRODUCCION=$id_produccion AND $where  " ;
   $updates=[]  ;
  $tabla_update="PRODUCCIONES_DETALLE" ;
  $id_update="ID_UDO" ;
  $id_clave="ID_UDO" ;
   
     break;
   case "subobras":
       
     $sql="SELECT ID_SUBOBRA, $select_global SUBOBRA , SUM(IMPORTE) as importe  FROM ConsultaProd WHERE $where   GROUP BY ID_SUBOBRA ORDER BY SUBOBRA " ;
     $sql_T="SELECT $select_global_T 'Suma' , SUM(IMPORTE) as importe  FROM ConsultaProd WHERE $where    " ;
    break;



   }

 
   
 $dblclicks=[] ;  
 $dblclicks["NOMBRE_OBRA"]="OBRA" ;
 $dblclicks["CAPITULO"]="CAPITULO" ;
 $dblclicks["UDO"]="UDO" ;
 $dblclicks["fecha"]="FECHA1" ;
 $dblclicks["SUBOBRA"]="SUBOBRA" ;
 //$links["CAPITULO"] = ["../obras/obras_ficha.php?id_obra=", "ID_OBRA"] ;
//echo $sql ;
//echo $sql_T ;
//echo $sql ;
//echo $sql ;
$result=$Conn->query($sql) ;

echo "<div class='noprint'>Filas: {$result->num_rows} <br></div>" ;
//echo $sql ;

if (isset($sql_T)) {$result_T=$Conn->query($sql_T) ; }    // consulta para los TOTALES
if (isset($sql_T2)) {$result_T2=$Conn->query($sql_T2) ; }    // consulta para los TOTALES
if (isset($sql_T3)) {$result_T3=$Conn->query($sql_T3) ; }    // consulta para los TOTALES
if (isset($sql_S)) {$result_S=$Conn->query($sql_S) ; }     // consulta para los SUBGRUPOS , agrupación de filas (Ej. CLIENTES o CAPITULOS en listado de udos)

$links["NOMBRE_OBRA"] = ["../obras/obras_ficha.php?id_obra=", "ID_OBRA"] ;

if (!$listado_global)
{
//$links["UDO"] = ["../obras/udo_prod.php?id_produccion=$id_produccion&id_udo=", "ID_UDO","ver detalles de medición de la Unidad de Obra" ,"formato_sub"] ;    
$links["UDO"] = ["../obras/udo_prod.php?id_produccion=$id_produccion&id_udo=", "ID_UDO" ,"ver detalles de medición de la Unidad de Obra", 'ppal'] ;    
}    
else
{
$links["UDO"] = ["../obras/udo_prod.php?id_udo=", "ID_UDO", "ver ficha de la unidad de obra", "formato_sub"] ;  
$links["PRODUCCION"]=["../obras/obras_prod_detalle.php?id_produccion=", "ID_PRODUCCION"] ;

}    
    
//$links["NOMBRE_OBRA"]=["../obras/obras_ficha.php?id_obra=", "ID_OBRA"] ;

$formats["margen"] = "porcentaje" ;
$formats["P_ejec"] = "porcentaje" ;
$formats["importe"] = "moneda" ;
$formats["beneficio"] = "moneda" ;
$formats["gasto_est"] = "moneda" ;
$formats["COSTE"] = "moneda" ;
$formats["COSTE_EST"] = "moneda" ;
$formats["MED_PROYECTO"] = "fijo" ;
$formats["MEDICION"] = "fijo" ;
//$formats["fecha"] = "dbfecha" ;
//$formats["conc"] = "boolean" ;
$formats["PRECIO"] = "moneda" ;
$formats["exceso"] = "semaforo_OK" ;
//$formats["ingresos"] = "moneda" ;
$aligns["leyenda_beneficio"] = "right" ;
//$aligns["Neg"] = "center" ;
//$aligns["Pagada"] = "center" ;
//$tooltips["conc"] = "Indica si el pago está conciliado" ;
//$tooltips["Banco_Neg"] = "Indica el banco o línea de descuento donde está negociada" ;


//$titulo="<small>Produccion por $agrupar</small>";
$msg_tabla_vacia="No hay.";

if (isset($col_sel))  echo $content_sel ;           // si hay columna de SELECTION pinto el div con los botones acciones de selection
if (isset($fmt_anadir_med))  echo $content_anadir_med ;           // si hay columna de SELECTION pinto el div con los botones acciones de selection


if ($tipo_tabla=='group')
{ require("../include/tabla_group.php"); }
else if ($tipo_tabla=='pdf')
{ require("../include/tabla_pdf.php"); }
else 
{ require("../include/tabla.php"); echo $TABLE ; }
    
//////////////// incluimos RESUMEN DE CAPITULOS

if ($fmt_resumen_cap AND !$listado_global)
{
    $sql="SELECT $select_global ID_OBRA,ConsultaProd.ID_CAPITULO, CAPITULO $select_importe_proyecto , SUM(IMPORTE) as importe $select_costes   "
           . " FROM ConsultaProd  JOIN Capitulos_importe ON ConsultaProd.ID_CAPITULO=Capitulos_importe.ID_CAPITULO "
           . " WHERE $where  GROUP BY ID_CAPITULO ORDER BY CAPITULO " ;

    
     $sql_T="SELECT $select_global_T 'Suma Ejecución Material........................' $select_MED_PROYECTO_hueco_doble  , SUM(IMPORTE) as importe $select_costes_T "
             . "  FROM ConsultaProd WHERE $where    " ;

     $sql_Prod="SELECT A_DEDUCIR,CERT_ANTERIOR,F_certificacion,OPC_DEDUCIR  FROM PRODUCCIONES WHERE ID_PRODUCCION=$id_produccion    " ;
     $sql_Obra="SELECT Pie_CERTIFCACION,iva_obra,COEF_BAJA,GG_BI  FROM OBRAS WHERE ID_OBRA=$id_obra    " ;
     
     $result=$Conn->query($sql) ;
     $result_T=$Conn->query($sql_T) ;     // consulta para los TOTALES
     $result_Obra=$Conn->query($sql_Obra) ;     // consulta para los TOTALES
     $result_Prod=$Conn->query($sql_Prod) ;     // consulta para los TOTALES
     
     $rs_Obra= $result_Obra->fetch_array(MYSQLI_ASSOC)  ;
     $rs_Prod= $result_Prod->fetch_array(MYSQLI_ASSOC)  ;
     
     
//     $visibles=['iva_obra','COEF_BAJA','GG_BI']   ; //    evitamos que se impriman en pantalla
     
     $formats["margen"] = "porcentaje" ;
     $formats["P_ejec"] = "porcentaje" ;
//     $formats["importe"] = "moneda" ;
$formats["beneficio"] = "moneda" ;
$formats["gasto_est"] = "moneda" ;
//$formats["COSTE"] = "moneda" ;
//$formats["COSTE_EST"] = "moneda" ;
//$formats["MED_PROYECTO"] = "fijo" ;
//$formats["MEDICION"] = "fijo" ;
   

///////////////     CALCULO DE IMPORTES TOTALES     
     
     $GG_BI=$rs_Obra["GG_BI"];
     $COEF_BAJA=$rs_Obra["COEF_BAJA"];
     $iva_obra=$rs_Obra["iva_obra"];
     $Pie_CERTIFCACION=$rs_Obra["Pie_CERTIFCACION"];
//     $Pie_CERTIFCACION2=$rs_Obra["Pie_CERTIFCACION2"];
//     $firma1=$rs_Obra["firma1"]; $nombre1=$rs_Obra["nombre1"];
//     $firma2=$rs_Obra["firma2"]; $nombre2=$rs_Obra["nombre2"];
//     $firma3=$rs_Obra["firma3"]; $nombre3=$rs_Obra["nombre3"];
//     $firma4=$rs_Obra["firma4"]; $nombre4=$rs_Obra["nombre4"];
     
//     $importe_PEM=round($rs_Prod["importe"],2) ;
     $importe_PEM=round(Dfirst("SUM(IMPORTE)","ConsultaProd",$where) ,2) ;
     $importe_GG_BI=round($importe_PEM*$GG_BI,2) ;
     $importe_PEC=$importe_PEM+$importe_GG_BI ;
     
     $importe_PEC_BAJA=round($importe_PEC*$COEF_BAJA,2) ;
     
     $OPC_DEDUCIR=$rs_Prod["OPC_DEDUCIR"];
     $F_certificacion=$rs_Prod["F_certificacion"];
     
     if ($OPC_DEDUCIR==1)
     {
         $id_prod_cert_anterior=$rs_Prod["CERT_ANTERIOR"];
         $A_DEDUCIR=round( Dfirst("Valoracion","prod_PEM_f_view","ID_PRODUCCION=$id_prod_cert_anterior"), 2)                                               ;
     }else if ($OPC_DEDUCIR==2)            // importe directamente
     {
         $A_DEDUCIR=round($rs_Prod["A_DEDUCIR"], 2) ;
     }    
     
     $importe_deducido=$importe_PEC_BAJA-$A_DEDUCIR ;
     
     $importe_IVA=round($importe_deducido*$iva_obra,2) ;
     
     $importe_TOTAL=$importe_deducido+$importe_IVA ;
     
//     $importe_a_descontar=Dfirst("","","") ;

     
     
 echo "<br><br><br>";
 echo "RESUMEN DE $PRODUCCION";
 
    require("../include/tabla.php"); echo $TABLE ;
 
//    for ($i = 0; $i <= 100; $i++) {
//     echo '<br>' ;   
//    echo NumeroALetras::convertir($i/100, 'euros', 'centimos')." (". trim( cc_format($i/100,'moneda')).")" ;;
//}

//        RESUMEN TOTALES
//    $importe_TOTAL=0.30 ;
   $importe_TOTAL_letra = NumeroALetras::convertir($importe_TOTAL, 'euros', 'centimos')." (". trim( cc_format($importe_TOTAL,'moneda')).")" ;
//   $numero=cc_format($numero,'moneda') ;
//   echo "$letras ($numero)" ;
  
   echo "<br><br><TABLE >" ;
   echo "<TR><TD width='300px'></TD><TD width='200px'>TOTAL EJECUCION MATERIAL</TD><TD align='right'>".cc_format($importe_PEM,'moneda')."</TD></TR>" ;
   echo "<TR><TD></TD><TD>GASTOS GENERALES Y B.I.".cc_format($GG_BI,'porcentaje0')."</TD><TD align='right'>".cc_format($importe_GG_BI,'moneda')."</TD></TR>" ;
   echo "<TR><TD></TD><TD></TD><TD align='right'>----------------</TD></TR>" ;
   echo "<TR><TD></TD><TD>TOTAL EJECUCION POR CONTRATA</TD><TD align='right'>".cc_format($importe_PEC,'moneda')."</TD></TR>" ;
   echo "<TR><TD></TD><TD>COEFICIENTE DE BAJA $COEF_BAJA</TD><TD align='right'>".cc_format($importe_PEC,'moneda')."</TD></TR>" ;
   echo "<TR><TD></TD><TD>A DESCONTAR CERTIFICACIONES ANTERIORES</TD><TD align='right'>".cc_format($A_DEDUCIR,'moneda')."</TD></TR>" ;
   echo "<TR><TD></TD><TD></TD><TD align='right'>----------------</TD></TR>" ;
   echo "<TR><TD></TD><TD>SUMA</TD><TD align='right'>".cc_format($importe_deducido,'moneda')."</TD></TR>" ;
   echo "<TR><TD></TD><TD>I.V.A.  ".cc_format($iva_obra,'porcentaje0')."</TD><TD align='right'>".cc_format($importe_IVA,'moneda')."</TD></TR>" ;
   echo "<TR><TD></TD><TD></TD><TD align='right'>----------------</TD></TR>" ;
   echo "<TR><TD></TD><TD>IMPORTE TOTAL</TD><TD align='right'><b>".cc_format($importe_TOTAL,'moneda')."</b></TD></TR>" ;
   
   echo "</TABLE>" ;

   echo "<br>" ;
   
//   echo "<h6><small>$importe_TOTAL_letra</small></h6>" ;
   echo "<h6>$importe_TOTAL_letra</h6>" ;

   echo "<br>" ;
   
   setlocale(LC_TIME, "es_ES");
   
//   echo "<h6>Málaga, a ".cc_format($F_certificacion,'fecha_es_semana')."</h6>" ; 
   echo "<h6>Málaga, a ".utf8_encode(strftime( '%A %e de %B de %Y' , strtotime($F_certificacion) ))."</h6>" ; 
   
//   echo "<br><br>" ;
   
   echo "<textarea  rows=10 cols=100>$Pie_CERTIFCACION</textarea>" ;

   
   
//   echo "<br>" ;
//   echo "<h6>$Pie_CERTIFCACION2</h6>" ;
//   
   
//   echo "<br><br><TABLE >" ;
//   echo "<TR><TD align='center'>$firma1</TD><TD align='center'>$firma2</TD><TD align='center'>$firma3</TD><TD align='center'>$firma4</TD></TR>" ;
//   echo "<TR height='50px'><TD></TD><TD></TD><TD></TD><TD></TD></TR>" ;
//   echo "<TR><TD align='center'>$nombre1</TD><TD align='center'>$nombre2</TD><TD align='center'>$nombre3</TD><TD align='center'>$nombre4</TD></TR>" ;
//   echo "</TABLE>" ;


    
}





?>
 <script>

function prod_anade_med_udo(id_produccion)
{  // añade la medicion de los INPUT a cada UDO

    //    alert(id_produccion);
//     var nuevo_valor=window.confirm("¿Completar mediciones de UDO hasta MED_PROYETO? ");
//    alert("el nuevo valor es: "+valor) ;

// contruimos el array_str de pares (ID_UDO, MEDICION)
var array_str="" ;
 $('table input:text').each(
    function() {
        
//        array_str+=  $(this).attr('id') + '&' + $(this).val() ;
        var id=$(this).prop('id') ;
        
        if (id.substring(0,4)=='UDO_')
        {
            
          var id_udo=id.substring(4)  ;
//          if (id_udo==72152) $(this).val('123') ;
          var medicion=$(this).val()  ;
          if (medicion)
          {
              if (!(array_str=="" )) { array_str+= ";" } ;  // inserto el separador de filas
              array_str+=  id_udo + '&' + medicion ;         // inserto la fila, el par de datos
          } 
        }
    }
  );
  
//  array_str+= ")"  ;
  
//  alert(array_str);  // debug
  
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
  
//  $cadena_link="tabla=$tabla_update&wherecond=$id_update=".$rs["$id_update"] ; 

  xhttp.open("GET", "../obras/prod_add_detalle_ajax.php?id_produccion=" + id_produccion + "&array_str=" + encodeURIComponent(array_str) , true);
  xhttp.send();   
//    alert(table_selection_IN());
  
    
  return ;  
        
}
     
function sel_borrar_mediciones_detalle()
 { 

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
           location.reload(true); }  // refresco la pantalla tras edición
      }
  };
  
//  $cadena_link="tabla=$tabla_update&wherecond=$id_update=".$rs["$id_update"] ; 

  xhttp.open("GET", "../include/tabla_delete_row_ajax.php?tabla=PRODUCCIONES_DETALLE&wherecond=id IN " + table_selection_IN() , true);
  xhttp.send();   
   }
   else
   {return;}
 
}

function prod_completa_udo(id_produccion)
{
//    alert(id_produccion);
//     var nuevo_valor=window.confirm("¿Completar mediciones de UDO hasta MED_PROYETO? ");
//    alert("el nuevo valor es: "+valor) ;

  
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
  
//  $cadena_link="tabla=$tabla_update&wherecond=$id_update=".$rs["$id_update"] ; 

  xhttp.open("GET", "../obras/prod_completa_udo_prod.php?id_produccion=" + id_produccion + "&table_selection_IN=" + table_selection_IN() , true);
  xhttp.send();   
//    alert(table_selection_IN());
  
    
  return ;  
}

function borrar_mediciones_udo(id_produccion)
 { 

    var nuevo_valor=window.confirm("¿Borrar filas? ");
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
           location.reload(true); }  // refresco la pantalla tras edición
      }
  };
  
//  $cadena_link="tabla=$tabla_update&wherecond=$id_update=".$rs["$id_update"] ; 

  xhttp.open("GET", "../include/tabla_delete_row_ajax.php?tabla=PRODUCCIONES_DETALLE&wherecond=ID_PRODUCCION=" + id_produccion +" AND ID_UDO IN " + table_selection_IN() , true);
  xhttp.send();   
   }
   else
   {return;}
 
}
     
     
     
     
function add_detalle( id_produccion, id_udo, med_proyecto ) {
    var nuevo_valor=window.prompt("Medición", med_proyecto);
//    alert("el nuevo valor es: "+valor) ;
   if (!(nuevo_valor === null) )
   { 
       
       var xhttp = new XMLHttpRequest();
     xhttp.onreadystatechange = function() {
    if (this.readyState == 4 && this.status == 200) {
        if (this.responseText.substr(0,5)=="ERROR")
        { alert(this.responseText) ;}                   // mostramos el ERROR
        else
        { //alert(this.responseText) ;       //debug
          location.reload(true) ; }  // refresco page
        
      //document.getElementById("sugerir_obra").innerHTML = this.responseText;
      }
  };
  xhttp.open("GET", "../obras/prod_add_detalle_ajax.php?id_produccion="+id_produccion+"&id_udo="+id_udo+"&medicion="+nuevo_valor, true);
  xhttp.send();   
   }
   else
   {return;}
   
}

 function copy_prod_consulta(id_obra,id_produccion,where,produccion0) {
//    var d = new Date();
//    var f=d.getFullYear() + "-" + (d.getMonth()+1) + "-" + d.getDate() ;
     var produccion=window.prompt("Nombre de la nueva producción: ", produccion0  );

//    where=encodeURI(where) ;
    alert(where) ;

    
   if (produccion)
   {    
       var xhttp = new XMLHttpRequest();
     xhttp.onreadystatechange = function() {
    if (this.readyState == 4 && this.status == 200) {
        if (this.responseText.substr(0,5)=="ERROR")
        { alert(this.responseText) ;}
        else
        {  //alert(this.responseText) ;     //debug
            location.reload(true); }  // refresco la pantalla tras editar Producción
      }
  };
  xhttp.open("GET", "../obras/prod_copy_ajax.php?id_obra="+id_obra+"&id_produccion="+id_produccion+"&where="+where+"&produccion="+produccion, true);
  xhttp.send();   
   }  
    //alert("el nuevo valor es: "+ fecha) ;
   
   return ;
   
   
}

</script>   
   
</div>

<!--************ FIN  *************  -->
	
	

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

