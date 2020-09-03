<?php
// cambios
require_once("../include/session.php");
$where_c_coste = " id_c_coste={$_SESSION['id_c_coste']} ";
$id_c_coste = $_SESSION['id_c_coste'];

$titulo = 'Gastos';

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


if (isset($_GET["id_obra"]))
  { $id_obra=$_GET["id_obra"];         // Estamos viendo los Gastos de una obra o máquinaria, no Gastos en forma Global
    $NOMBRE_OBRA=Dfirst("NOMBRE_OBRA", "OBRAS", "ID_OBRA=$id_obra AND $where_c_coste" )  ;
    $gastos_global=false  ;
    require_once("../obras/obras_menutop_r.php");          // añadimos el Menu de Obra o Máquina
  }
  else
  { $gastos_global=true ;
  }
  
  
  ?>


<div style="overflow:visible">	   
   
	<!--************ INICIO *************  -->

<div id="main" class="mainc_100" style="background-color:#fff">
	
<?php 

$solo_form=0;
if (!isset($_POST["PROVEEDOR"]))
{
//form vacio
  $solo_form=1;
//  $tipo_subcentro="OGAMEX";
//  $Obra="";
  $tipo_subcentro=isset($_GET["tipo_subcentro"])? $_GET["tipo_subcentro"] :  "OGAMEX" ;
  $Obra=isset($_GET["Obra"])? $_GET["Obra"] :  "" ;
  $PROVEEDOR=isset($_GET["PROVEEDOR"])? $_GET["PROVEEDOR"] :  "" ;
  $CONCEPTO=isset($_GET["CONCEPTO"])? $_GET["CONCEPTO"] :  "" ;
  $REF=isset($_GET["REF"])? $_GET["REF"] :  "" ;
  $Observaciones=isset($_GET["Observaciones"])? $_GET["Observaciones"] :  "" ;
  $fecha1=isset($_GET["fecha1"])? $_GET["fecha1"] :  "" ;
  $fecha2=isset($_GET["fecha2"])? $_GET["fecha2"] :  "" ;
  $Dia = isset($_GET["Dia"]) ?  $_GET["Dia"] :   ""  ;
  $Semana = isset($_GET["Semana"]) ?  $_GET["Semana"] :   ""  ;
  $Mes = isset($_GET["Mes"]) ?  $_GET["Mes"] :   ""  ;
  $Trimestre = isset($_GET["Trimestre"]) ?  $_GET["Trimestre"] :   ""  ;
  $Anno = isset($_GET["Anno"]) ?  $_GET["Anno"] :   ""  ;
  
  $CUENTA=isset($_GET["CUENTA"])? $_GET["CUENTA"] :  "" ;
  $SUBOBRA=isset($_GET["SUBOBRA"])? $_GET["SUBOBRA"] :  "" ;
  $TIPO_GASTO=isset($_GET["TIPO_GASTO"])? $_GET["TIPO_GASTO"] :  "" ;
  
  $agrupar=isset($_GET["agrupar"])? $_GET["agrupar"] :  "proveedor" ;

  $importe1=isset($_GET["importe1"])? $_GET["importe1"] :  "" ;
  $importe2=isset($_GET["importe2"])? $_GET["importe2"] :  "" ;
 
  $fmt_mensual = isset($_GET["fmt_mensual"]) ?  $_GET["fmt_mensual"] :  "" ;


} 
 else 
{

 if ($gastos_global)
 {
      $tipo_subcentro=$_POST["tipo_subcentro"];
      $Obra=$_POST["Obra"];
 }

    $fecha1=$_POST["fecha1"];
    $fecha2=$_POST["fecha2"];
    $Semana=$_POST["Semana"] ;
    $Dia=$_POST["Dia"] ;
    $Mes=$_POST["Mes"] ;
    $Trimestre=$_POST["Trimestre"] ;
    $Anno=$_POST["Anno"] ;
    $PROVEEDOR=$_POST["PROVEEDOR"];
    $CONCEPTO=$_POST["CONCEPTO"];                  //str_replace(" ","%",trim($_POST["CONCEPTO"]));
    $REF=$_POST["REF"];
    $Observaciones=$_POST["Observaciones"];
    $CUENTA=$_POST["CUENTA"];
    $TIPO_GASTO=$_POST["TIPO_GASTO"];
    $SUBOBRA=$_POST["SUBOBRA"];
    $agrupar=$_POST["agrupar"];  

    $importe1=$_POST["importe1"] ;
    $importe2=$_POST["importe2"] ;

    $fmt_mensual=isset($_POST["fmt_mensual"]) ? 'checked' : '' ;

     
 }


 ?>

<?php 

if ($gastos_global)                // Estamos en pantalla de GASTOS GLOBALES (toda la empresa no solo en una obra)
{ 
    echo "<h1>Gastos</h1>"  ;
    echo "<form action='../obras/gastos.php' method='post' id='form1' name='form1'>"    ;

    echo "<div class='row' style='border-style: solid ; border-color:grey; margin-bottom: 25px; padding:10px'>" ;
 
    echo "<div class='col-lg-4'> " ;   

    echo "<TABLE align='center'>"  ;
   
    echo "<TR><TD>Tipo Subcentro</TD><TD><INPUT type='text' id='tipo_subcentro' name='tipo_subcentro' value='$tipo_subcentro'><button type='button' onclick=\"document.getElementById('tipo_subcentro').value='OGAMEX' \" >*</button></TD></TR>" ;
    echo "<TR><TD>Obra       </TD><TD><INPUT type='text' id='Obra' name='Obra' value='$Obra'><button type='button' onclick=\"document.getElementById('Obra').value='' \" >*</button></TD></TR>" ;
}
 else
{
    echo "<a class='btn btn-link btn-lg noprint' href= '../obras/gastos.php'title='permite consultar los gastos de todas las obras a la vez' >$ICON-globe$SPAN Gastos globales</a><br>" ;
    echo "<a target='_blank' class='btn btn-link btn-lg' href='../proveedores/albaran_anadir.php?id_obra=$id_obra' title='añade un albarán de proveedor a la obra'><i class='fas fa-plus-circle'></i> añadir Gasto</a>" ;

    echo "<h1>Gastos de la obra <B>$NOMBRE_OBRA</B></h1>"  ;
    echo "<form action='gastos.php?id_obra=$id_obra' method='post' id='form1' name='form1'>"    ;

    echo "<div class='row' style='border-style: solid ; border-color:grey; margin-bottom: 25px; padding:10px'>" ;

    echo "<div class='col-lg-4'> " ;   
    
    echo "<TABLE align='center'>"  ;
}     
    

echo "<TR><TD>PROVEEDOR  </TD><TD><INPUT type='text' id='PROVEEDOR'  name='PROVEEDOR' value='$PROVEEDOR'><button type='button' onclick=\"document.getElementById('PROVEEDOR').value='' \" >*</button></TD></TR>" ;
echo "<TR><TD>CONCEPTO   </TD><TD><INPUT type='text' id='CONCEPTO'   name='CONCEPTO'  value='$CONCEPTO'><button type='button' onclick=\"document.getElementById('CONCEPTO').value='' \" >*</button></TD></TR>" ;
echo "<TR><TD>REF        </TD><TD><INPUT type='text' id='REF'        name='REF'       value=$REF><button type='button' onclick=\"document.getElementById('REF').value='' \" >*</button></TD></TR>" ;
echo "<TR><TD>Observaciones  </TD><TD><INPUT type='text' id='Observaciones'  name='Observaciones'       value=$Observaciones><button type='button' onclick=\"document.getElementById('Observaciones').value='' \" >*</button></TD></TR>" ;
echo "<TR><TD>Fecha1     </TD><TD><INPUT type='date' id='fecha1'     name='fecha1'    value='$fecha1'><button type='button' onclick=\"document.getElementById('fecha1').value='' \" >*</button></TD></TR>" ;
echo "<TR><TD>Fecha2     </TD><TD><INPUT type='date' id='fecha2'     name='fecha2'    value='$fecha2'><button type='button' onclick=\"document.getElementById('fecha2').value='' \" >*</button></TD></TR>" ;
echo "<TR><TD>Dia     </TD><TD><INPUT type='text' id='Dia'     name='Dia'    value='$Dia'><button type='button' onclick=\"document.getElementById('Dia').value='' \" >*</button></TD></TR>" ;
echo "<TR><TD>Semana     </TD><TD><INPUT type='text' id='Semana'     name='Semana'    value='$Semana'><button type='button' onclick=\"document.getElementById('Semana').value='' \" >*</button></TD></TR>" ;
echo "<TR><TD>Mes     </TD><TD><INPUT type='text' id='Mes'     name='Mes'    value='$Mes'><button type='button' onclick=\"document.getElementById('Mes').value='' \" >*</button></TD></TR>" ;
echo "<TR><TD>Trimestre     </TD><TD><INPUT type='text' id='Trimestre'     name='Trimestre'    value='$Trimestre'><button type='button' onclick=\"document.getElementById('Trimestre').value='' \" >*</button></TD></TR>" ;
echo "<TR><TD>Año     </TD><TD><INPUT type='text' id='Anno'     name='Anno'    value='$Anno'><button type='button' onclick=\"document.getElementById('Anno').value='' \" >*</button></TD></TR>" ;

echo "</TABLE></div><div class='col-lg-4'><TABLE> " ;   


echo "<TR><TD>CUENTA     </TD><TD><INPUT type='text' id='CUENTA'     name='CUENTA'    value='$CUENTA'><button type='button' onclick=\"document.getElementById('CUENTA').value='' \" >*</button></TD></TR>" ;
echo "<TR><TD>TIPO_GASTO </TD><TD><INPUT type='text' id='TIPO_GASTO' name='TIPO_GASTO' value='$TIPO_GASTO'><button type='button' onclick=\"document.getElementById('TIPO_GASTO').value='' \" >*</button></TD></TR>" ;
echo "<TR><TD>SUBOBRA    </TD><TD><INPUT type='text' id='SUBOBRA'    name='SUBOBRA'   value='$SUBOBRA'><button type='button' onclick=\"document.getElementById('SUBOBRA').value='' \" >*</button></TD></TR>" ;
echo "<TR><TD>Importe min     </TD><TD><INPUT type='text' id='importe1'     name='importe1'    value='$importe1'><button type='button' onclick=\"document.getElementById('importe1').value='' \" >*</button></TD></TR>" ;
echo "<TR><TD>importe máx     </TD><TD><INPUT type='text' id='importe2'     name='importe2'    value='$importe2'><button type='button' onclick=\"document.getElementById('importe2').value='' \" >*</button></TD></TR>" ;


//echo "<TR><TD colspan=2 ></TD></TR>" ;
//echo "<INPUT type='submit' class='btn btn-success btn-xl' value='Actualizar' id='submit' name='submit'>" ;
echo "<TR><TD colspan=2 align=center><INPUT type='submit' class='btn btn-success btn-xl noprint' value='Actualizar' id='submit' name='submit'></TD></TR>" ;

echo  "</TABLE>"  ;
echo "</div>" ;
echo "</div>" ;
echo "<center>"
        . "<font size=4 align='left' class='noprint'>Agrupar por:<br>"  ;

// FORMATOS fmt_xxxx
echo "<div class='noprint'>";

   echo " <br><br> ";
   echo "<label><INPUT type='checkbox' id='fmt_mensual' name='fmt_mensual' $fmt_mensual >&nbsp;Desglose mensual&nbsp;&nbsp;</label>" ;

    //<a class="btn btn-link btn-xs noprint" title="formato para realizar un Estudio de costes de un Proyecto o Liciación" href=#  onclick="formato_estudio_costes();"><i class="fas fa-euro-sign"></i> modo Estudio de Costes</a>

echo  "</div> " ;

// BOTONES AGRUPAMIENTO


echo "<div id='myDIV'>" ; 

$btnt['obra']=['obra',''] ;
$btnt['proveedor']=['proveedor',''] ;
$btnt['prov_concepto']=['proveedor-concepto',''] ;
$btnt['concepto']=['concepto',''] ;
$btnt['subobra']=['subobra',''] ;
$btnt['albaran']=['Albaranes',''] ;
$btnt['albaran_no_conc']=['Albaranes No Conc.',''] ;
$btnt['detalle']=['detalle',''] ;
$btnt['vacio']=['detalle',''] ;
$btnt['dias']=['dias',''] ;
$btnt['semanas']=['semanas',''] ;
$btnt['meses']=['meses',''] ;
$btnt['trimestres']=['trimestres',''] ;
$btnt['annos']=['años',''] ;
$btnt['vacio2']=['años',''] ;
$btnt['tipo_gasto']=['tipo gasto','Mano de Obra, Maquinaria propia, Subcontrata...'] ;
$btnt['cuentas']=['cuentas','Agrupar por Cuentas Contables'] ;
$btnt['tipo_subcentro_gasto']=['tipo subcentro',''] ;
$btnt['albaranes_pdf']=['Albaranes PDF',''] ;


foreach ( $btnt as $clave => $valor)
{
  $active= ($clave==$agrupar) ? " cc_active" : "" ;  
  echo (substr($clave,0,5)=='vacio') ? "   " : "<button class='cc_btnt$active' title='{$valor[1]}' onclick=\"getElementById('agrupar').value = '$clave'; document.getElementById('form1').submit(); \">{$valor[0]}</button>" ;  
}  


?>






<input type="hidden"  id="agrupar"  name="agrupar" value='<?php echo $agrupar ; ?>'>
</form>

</font>

</center>
<!--</form>-->
			
<?php   // Iniciamos variables para tabla.php  background-color:#B4045


//$fecha1= date_replace($fecha1) ;
//$fecha2= date_replace($fecha2) ;
$where="1=1 ";
$where_vales="1=1 ";

if ($gastos_global)                // Estamos en pantalla de GASTOS GLOBALES (toda la empresa no solo en una obra)
{    
$where=$tipo_subcentro==""? $where : $where . " AND LOCATE(tipo_subcentro,'$tipo_subcentro')>0 " ;
$where=$Obra==""? $where : $where . " AND NOMBRE_OBRA LIKE '%".str_replace(" ","%",trim($Obra))."%'" ;
$where_vales=$Obra==""? $where_vales : $where_vales . " AND NOMBRE_OBRA LIKE '%".str_replace(" ","%",trim($Obra))."%'" ;

}
else
{
$where= $where . " AND ID_OBRA=$id_obra " ;    // Estamos en gastos de una Obra o Maquinaria específica
$where_vales= $where_vales . " AND ID_OBRA=$id_obra " ;    // Estamos en gastos de una Obra o Maquinaria específica

}    

$select_semana="DATE_FORMAT(FECHA, '%Y semana %u')"  ;
$select_trimestre="CONCAT(YEAR(FECHA), '-', QUARTER(FECHA),'T')"  ;

$where=$PROVEEDOR==""? $where : $where . " AND PROVEEDOR LIKE '%".str_replace(" ","%",trim($PROVEEDOR))."%'" ;
$where_vales=$PROVEEDOR==""? $where_vales : $where_vales . " AND PROVEEDOR LIKE '%".str_replace(" ","%",trim($PROVEEDOR))."%'" ;

$where=$CONCEPTO==""? $where : $where . " AND CONCEPTO LIKE '%".str_replace(" ","%",trim($CONCEPTO))."%'" ;
$where=$REF==""? $where : $where . " AND REF LIKE '%".str_replace(" ","%",trim($REF))."%'" ;
$where_vales=$REF==""? $where_vales : $where_vales . " AND REF LIKE '%".str_replace(" ","%",trim($REF))."%'" ;
$where=$Observaciones==""? $where : $where . " AND Observaciones LIKE '%".str_replace(" ","%",trim($Observaciones))."%'" ;
$where_vales=$Observaciones==""? $where_vales : $where_vales . " AND Observaciones LIKE '%".str_replace(" ","%",trim($Observaciones))."%'" ;
$where=$CUENTA==""? $where : $where . " AND (CUENTA LIKE '%".str_replace(" ","%",trim($CUENTA))."%' "
                                      . " OR CUENTA_TEXTO LIKE '%".str_replace(" ","%",trim($CUENTA))."%' ) " ;
$where=$TIPO_GASTO==""? $where : $where . " AND GASTO LIKE '%".str_replace(" ","%",trim($TIPO_GASTO))."%'" ;
$where=$SUBOBRA==""? $where : $where . " AND SUBOBRA LIKE '%".str_replace(" ","%",trim($SUBOBRA))."%'" ;

//$where=$fecha1=="01-01-1980"? $where : $where . " AND FECHA >= STR_TO_DATE($fecha1,'%d-%m-%Y')" ;
//$where=$fecha1==""? $where : $where . " AND FECHA >= STR_TO_DATE('$fecha1','%Y-%m-%d') " ;
//$where=$fecha2==""? $where : $where . " AND FECHA <= STR_TO_DATE('$fecha2','%Y-%m-%d') " ;

$where=$fecha1==""? $where : $where . " AND FECHA >= '$fecha1' " ;
$where=$fecha2==""? $where : $where . " AND FECHA <= '$fecha2' " ;
$where=$Dia==""? $where : $where . " AND DATE_FORMAT(FECHA, '%Y-%m-%d')='$Dia' " ;
$where=$Semana==""? $where : $where . " AND $select_semana = '$Semana' " ;
$where=$Mes==""? $where : $where . " AND DATE_FORMAT(FECHA, '%Y-%m') = '$Mes' " ;
$where=$Trimestre==""? $where : $where . " AND $select_trimestre = '$Trimestre' " ;
$where=$Anno==""? $where : $where . " AND YEAR(FECHA) = '$Anno' " ;

$where_vales=$fecha1==""? $where_vales : $where_vales . " AND FECHA >= '$fecha1' " ;
$where_vales=$fecha2==""? $where_vales : $where_vales . " AND FECHA <= '$fecha2' " ;

$where_vales=$importe1==""? $where_vales : $where_vales . " AND IFNULL(importe,0) >= $importe1" ;
$where_vales=$importe2==""? $where_vales : $where_vales . " AND IFNULL(importe,0) <= $importe2" ;


$tabla_group=0 ;

$select_NOMBRE_OBRA= $gastos_global ? ", NOMBRE_OBRA " : "" ;

$c_importe='importe';
$c_fecha='FECHA';
$select_MENSUAL= $fmt_mensual ? ", SUM(importe*(MONTH($c_fecha)=1)) AS Enero, SUM(importe*(MONTH($c_fecha)=2)) AS Febrero, SUM(importe*(MONTH($c_fecha)=3)) AS Marzo "
        . ", SUM(importe*(MONTH($c_fecha)=4)) AS Abril, SUM(importe*(MONTH($c_fecha)=5)) AS Mayo, SUM(importe*(MONTH($c_fecha)=6)) AS Junio"
        . ", SUM(importe*(MONTH($c_fecha)=7)) AS Julio, SUM(importe*(MONTH($c_fecha)=8)) AS Agosto, SUM(importe*(MONTH($c_fecha)=9)) AS Septiembre"
        . ", SUM(importe*(MONTH($c_fecha)=10)) AS Octubre, SUM(importe*(MONTH($c_fecha)=11)) AS Noviembre, SUM(importe*(MONTH($c_fecha)=12)) AS Diciembre"  
        : "";
            
        
// IMPUTACION A SUBOBRA
if (!$gastos_global)
{
 
// generamos la lista de ID a imputar a la subobra por si no estamos en agrupar='detalle'     
$sql_id="SELECT id FROM ConsultaGastos_View WHERE $where AND $where_c_coste   " ;
$result_id=$Conn->query($sql_id);

$table_selection_IN = "(";   

while ($rs = $result_id->fetch_array(MYSQLI_ASSOC))
{
    $table_selection_IN.= $table_selection_IN<>"(" ? "," : ""; 
    $table_selection_IN.= $rs["id"]; 
}        
$table_selection_IN .= ")";   


//echo $table_selection_IN ;

//  <!--SELECCION DE SUBOBRA A IMPUTAR-->   

echo "<div class='container noprint' > "
    . "<button data-toggle='collapse' class='btn btn-link btn-xs' data-target='#div_imputar'>Imputar a SubObras  <i class='fa fa-angle-down' ></i></button> "
        . "<div id='div_imputar' class='collapse'> "
        . "<div class='form-group' style='border:1px solid silver;' > Imputar gastos a Subobra  <select id='id_subobra' style='font-size: 15px; width: 20%;'> ";

echo DOptions_sql("SELECT ID_SUBOBRA,SUBOBRA FROM SubObras WHERE ID_OBRA=$id_obra ORDER BY SUBOBRA ", "Selecciona SubObra...") ;
echo     "  </select>" ;
echo  ($agrupar=='detalle') ?
       "<a class='btn btn-link' href='#' onclick=\"imputar_a_subobra( '$id_obra' )\" title='Imputa los gastos seleccionados a la Subobra' >imputar gastos a Subobra</a> " 
    :  "<a class='btn btn-link' href='#' "
        . " onclick=\"js_href( '../obras/imputar_a_subobra.php?id_obra=$id_obra&id_subobra=_VARIABLE1_&table_selection_IN=$table_selection_IN','0','' , 'id_subobra' )\" title='Imputa los gastos  a la Subobra' >imputar gastos a Subobra</a> " ;
 
echo   "<a class='btn btn-link btn-xs' href='#' onclick=\"window.open('../obras/subobra_ficha.php?id_subobra='+document.getElementById('id_subobra').value ) \"   "
               ." title='Ver la ficha de la SubObra' >ver Subobra</a>  " ;


echo  "<a class='btn btn-link btn-xs' href='#' onclick=\"nueva_subobra( $id_obra )\" title='Crea subobra nueva' ><i class='fas fa-plus-circle'></i> nueva subobra</a> "
        . "</div>"
        . "</div>"
        . "</div>" ;
?>
    <!--FIN SELECCION DE SUBOBRA -->   
<script>
function imputar_a_subobra(id_obra) {
    
    //var valor0 = valor0_encode;
    //var valor0 = JSON.parse(valor0_encode);
   // var nuevo_valor=window.prompt("Nuevo valor de "+prompt , valor0);
//    alert("el nuevo valor es: "+valor) ;
//   alert('debug') ;
   var id_subobra=document.getElementById("id_subobra").value ;
//   var d= new Date() ;
//   var date_str=d.toISOString();

//   table_selection_IN()
   window.open('../obras/imputar_a_subobra.php?id_obra='+id_obra+'&id_subobra='+id_subobra+'&table_selection_IN='+table_selection_IN() );
//   window.open('../obras/obras_anadir_parte.php?id_obra='+id_obra, '_blank');
 //echo "<a class='btn btn-primary' href= '../obras/obras_anadir_parte.php?id_obra=$id_obra' >Añadir parte</a><br>" ;
        

    
    return ;
 }  
 function nueva_subobra(id_obra) {
    
    //var valor0 = valor0_encode;
    //var valor0 = JSON.parse(valor0_encode);
    var subobra=window.prompt("Subobra nueva:" );

   if (subobra){
    var sql="INSERT INTO SubObras (ID_OBRA,SUBOBRA) VALUES ("+id_obra+",'"+subobra+"' )"    ;   
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
 } 
    return ;
 }  
</script>    
    
<?php

 }   // FIN IMPUTACION A SUBOBRA



 switch ($agrupar) {
    case "obra":
     $sql="SELECT ID_OBRA,tipo_subcentro, NOMBRE_OBRA , SUM(IMPORTE) as importe $select_MENSUAL  FROM ConsultaGastos_View WHERE $where AND $where_c_coste  GROUP BY ID_OBRA ORDER BY NOMBRE_OBRA" ;
     $sql_T="SELECT '','Suma' , SUM(IMPORTE) as importe $select_MENSUAL FROM ConsultaGastos_View WHERE $where AND $where_c_coste   " ;
    break;
    case "tipo_subcentro_gasto":
     $sql="SELECT tipo_subcentro , SUM(IMPORTE) as importe $select_MENSUAL FROM ConsultaGastos_View WHERE $where AND $where_c_coste  GROUP BY tipo_subcentro " ;
     $sql_T="SELECT 'Suma' , SUM(IMPORTE) as importe $select_MENSUAL FROM ConsultaGastos_View WHERE $where AND $where_c_coste   " ;
    break;
   case "proveedor":
    $sql="SELECT ID_PROVEEDORES,PROVEEDOR , SUM(IMPORTE) as importe $select_MENSUAL  FROM ConsultaGastos_View WHERE $where AND $where_c_coste  GROUP BY ID_PROVEEDORES  ORDER BY PROVEEDOR  " ;
    $sql_T="SELECT 'Suma' , SUM(IMPORTE) as importe $select_MENSUAL FROM ConsultaGastos_View WHERE $where AND $where_c_coste   " ;
   break;
   case "prov_concepto":
//    $sql="SELECT NOMBRE_OBRA, PRODUCCION, ID_OBRA,CAPITULO ,ID_UDO,UDO,MED_PROYECTO,SUM(MEDICION) as MEDICION, PRECIO, SUM(IMPORTE) as importe  FROM ConsultaProd WHERE $where  GROUP BY ID_UDO ORDER BY CAPITULO,ID_UDO " ;

//     $sql="SELECT  ID_OBRA,ID_CAPITULO, CAPITULO ,ID_UDO,ud,UDO,MED_PROYECTO,SUM(MEDICION) as MEDICION, PRECIO,COSTE_EST, SUM(IMPORTE) as importe,COSTE_EST, SUM(gasto_est) as gasto_est  FROM ConsultaProd WHERE $where  GROUP BY ID_UDO ORDER BY CAPITULO,ID_UDO " ;
     $sql="SELECT ID_CONCEPTO,ID_PROVEEDORES,PROVEEDOR ,CONCEPTO,SUM(CANTIDAD) AS CANTIDAD, COSTE, SUM(IMPORTE) as importe  FROM ConsultaGastos_View WHERE $where AND $where_c_coste  GROUP BY ID_PROVEEDORES,ID_CONCEPTO  ORDER BY PROVEEDOR,CONCEPTO  " ;
     $sql_T="SELECT 'Suma' , SUM(IMPORTE) as importe  FROM ConsultaGastos_View WHERE $where AND $where_c_coste   " ;

//       $sql_S="SELECT ID_CAPITULO,$select_global CAPITULO , SUM(IMPORTE) as importe,SUM(gasto_est) as gasto_est,(SUM(IMPORTE)- SUM(gasto_est)) as beneficio  FROM ConsultaProd WHERE $where   GROUP BY ID_CAPITULO ORDER BY CAPITULO " ;
     $sql_S="SELECT ID_PROVEEDORES,PROVEEDOR , SUM(IMPORTE) as importe  FROM ConsultaGastos_View WHERE $where AND $where_c_coste  GROUP BY ID_PROVEEDORES  ORDER BY PROVEEDOR  " ;

       $id_agrupamiento="ID_PROVEEDORES" ;
     // permite editar el coste_est
    $updates=['MED_PROYECTO','COSTE_EST']  ;
    $anchos_ppal=[30,20,20,20,20,20,20] ;
    
  $tabla_update="Udos" ;
  $id_update="ID_UDO" ;
  $id_clave="ID_UDO" ;
  $tabla_group=1 ;
     break;

   case "concepto":
    $sql="SELECT ID_CONCEPTO,ID_PROVEEDORES,PROVEEDOR ,CONCEPTO,SUM(CANTIDAD) AS CANTIDAD, COSTE, SUM(IMPORTE) as importe,ID_CUENTA,CUENTA_TEXTO,id_usub as Usub  FROM ConsultaGastos_View WHERE $where AND $where_c_coste  GROUP BY ID_PROVEEDORES,ID_CONCEPTO  ORDER BY PROVEEDOR,CONCEPTO  " ;
    $sql_T="SELECT '' AS A,'' AS B,'' AS C,'' AS D, SUM(IMPORTE) as importe, '' as dd  FROM ConsultaGastos_View WHERE $where AND $where_c_coste   " ;
    break;
   case "subobra":
    $sql="SELECT ID_SUBOBRA,SUBOBRA ,  SUM(IMPORTE) as importe $select_MENSUAL FROM ConsultaGastos_View WHERE $where AND $where_c_coste  GROUP BY ID_SUBOBRA  ORDER BY SUBOBRA  " ;
    $sql_T="SELECT 'Suma' AS D, SUM(IMPORTE) as importe $select_MENSUAL  FROM ConsultaGastos_View WHERE $where AND $where_c_coste   " ;
    break;
   case "albaran":
    $sql="SELECT ID_VALE,ID_PROVEEDORES,ID_FRA_PROV,PROVEEDOR AS ID_SUBTOTAL_PROVEEDOR,FECHA,REF ,ID_PARTE AS NID_PARTE, SUM(IMPORTE) as importe,ID_FRA_PROV,N_FRA, Observaciones,user "
           . " FROM ConsultaGastos_View WHERE $where AND $where_c_coste  GROUP BY ID_VALE  ORDER BY PROVEEDOR ,FECHA " ;
    $sql_T="SELECT '' AS B,'TOTAL GASTO:' AS C, SUM(IMPORTE) as importe, '' as dd  FROM ConsultaGastos_View WHERE $where AND $where_c_coste   " ;

    $col_subtotal='ID_SUBTOTAL_PROVEEDOR' ;
    $array_sumas['importe']=0 ;
    $colspan=2 ;
    break;

   case "albaran_no_conc": // PROVISIONAL hasta poner checkbox de NO CONCILIADOS 
    $sql="SELECT ID_VALE,ID_PROVEEDORES,ID_FRA_PROV,PROVEEDOR AS ID_SUBTOTAL_PROVEEDOR,FECHA,REF ,ID_PARTE AS NID_PARTE, SUM(IMPORTE) as importe,ID_FRA_PROV ,N_FRA,Observaciones, user "
           . " FROM ConsultaGastos_View WHERE $where AND $where_c_coste AND facturado=0  GROUP BY ID_VALE  ORDER BY PROVEEDOR ,FECHA " ;
    $sql_T="SELECT '' AS B,'TOTAL GASTO:' AS C, SUM(IMPORTE) as importe, '' as dd  FROM ConsultaGastos_View WHERE $where AND $where_c_coste AND facturado=0   " ;

    $col_subtotal='ID_SUBTOTAL_PROVEEDOR' ;
    $array_sumas['importe']=0 ;
    $colspan=2 ;

    break;
   case "detalle":
    $sql="SELECT id,ID_VALE,ID_PROVEEDORES,ID_CONCEPTO,ID_FRA_PROV, FECHA,REF,PROVEEDOR,CONCEPTO, COSTE ,CANTIDAD, IMPORTE,ID_FRA_PROV AS facturado,N_FRA FROM ConsultaGastos_View WHERE $where AND $where_c_coste   ORDER BY FECHA,PROVEEDOR  " ;
    $sql_T="SELECT '' AS B,'' AS C,'' AS D, SUM(IMPORTE) as importe, '' as dd  FROM ConsultaGastos_View WHERE $where AND $where_c_coste   " ;
    
    $col_sel="id" ;
    
    break;
   case "dias":
    $sql="SELECT  DATE_FORMAT(FECHA, '%Y-%m-%d') as Dia,SUM(importe) as importe  FROM ConsultaGastos_View WHERE $where AND $where_c_coste  GROUP BY Dia  ORDER BY Dia  " ;
    $sql_T="SELECT '' AS D, SUM(IMPORTE) as importe  FROM ConsultaGastos_View WHERE $where AND $where_c_coste   " ;
    break;
   case "semanas":
    $sql="SELECT  $select_semana as Semana,SUM(importe) as importe  FROM ConsultaGastos_View WHERE $where AND $where_c_coste  GROUP BY Semana  ORDER BY Semana  " ;
    $sql_T="SELECT '' AS D, SUM(IMPORTE) as importe  FROM ConsultaGastos_View WHERE $where AND $where_c_coste   " ;
    break;
   case "meses":
    $sql="SELECT  DATE_FORMAT(FECHA, '%Y-%m') as Mes,SUM(importe) as importe  FROM ConsultaGastos_View WHERE $where AND $where_c_coste  GROUP BY Mes  ORDER BY Mes  " ;
    $sql_T="SELECT '' AS D, SUM(IMPORTE) as importe  FROM ConsultaGastos_View WHERE $where AND $where_c_coste   " ;
    break;
    case "trimestres":  
    $sql="SELECT  $select_trimestre as Trimestre,SUM(importe) as importe  FROM ConsultaGastos_View WHERE $where AND $where_c_coste  GROUP BY Trimestre  ORDER BY Trimestre  " ;
    $sql_T="SELECT '' AS D, SUM(IMPORTE) as importe  FROM ConsultaGastos_View WHERE $where AND $where_c_coste   " ;
    break;
   case "annos":
    $sql="SELECT  DATE_FORMAT(FECHA, '%Y') as anno,SUM(importe) as importe $select_MENSUAL FROM ConsultaGastos_View WHERE $where AND $where_c_coste  GROUP BY anno  ORDER BY anno  " ;
    $sql_T="SELECT '' AS D, SUM(IMPORTE) as importe $select_MENSUAL FROM ConsultaGastos_View WHERE $where AND $where_c_coste   " ;
    break;
   case "tipo_gasto":
    $gasto_total=Dfirst("SUM(IMPORTE)","ConsultaGastos_View"," $where AND $where_c_coste"  )   ;  //calculamos gasto_total para ver los porcentajes de tipo_gasto
    if ($gasto_total==0) {$gasto_total=1 ;}       // evitamos la division por cero
    $sql="SELECT  GASTO AS TIPO_GASTO, SUM(importe) as importe,SUM(importe)/$gasto_total as P_gasto $select_MENSUAL FROM ConsultaGastos_View WHERE $where AND $where_c_coste  GROUP BY GASTO  ORDER BY GASTO  " ;
    $sql_T="SELECT '' AS D, SUM(IMPORTE) as importe,SUM(IMPORTE)/$gasto_total as P_gasto $select_MENSUAL  FROM ConsultaGastos_View WHERE $where AND $where_c_coste   " ;
    break;
   case "cuentas":
    $sql="SELECT  ID_CUENTA, CUENTA,CUENTA_TEXTO,SUM(importe) as importe $select_MENSUAL FROM ConsultaGastos_View WHERE $where AND $where_c_coste  GROUP BY CUENTA  ORDER BY CUENTA  " ;
    $sql_T="SELECT '' AS A,'' AS D, SUM(IMPORTE) as importe  FROM ConsultaGastos_View WHERE $where AND $where_c_coste   " ;
    break;
   case "albaranes_pdf":
//    $sql="SELECT ID_VALE,ID_OBRA,ID_PROVEEDORES,path_archivo,ID_FRA_PROV $select_NOMBRE_OBRA,PROVEEDOR ,FECHA,REF , importe,ID_FRA_PROV AS facturado,Observaciones, user FROM Vales_view WHERE $where_vales AND $where_c_coste  ORDER BY FECHA,PROVEEDOR  " ;
    $sql="SELECT path_archivo,ID_VALE,ID_OBRA,ID_FRA_PROV $select_NOMBRE_OBRA,PROVEEDOR,FECHA,REF,ID_PROVEEDORES,importe,Observaciones,ID_FRA_PROV,N_FRA,user FROM Vales_view WHERE $where_vales AND $where_c_coste  ORDER BY FECHA,PROVEEDOR  " ;
    $sql_T="SELECT '' AS B,'' AS C,'TOTAL:' AS D, SUM(importe) as importe, '' as dd  FROM Vales_view WHERE $where_vales AND $where_c_coste   " ;
    break;

 }

//echo "<br>".$sql ;
//echo "<br>".$sql_T ;
//$result=$Conn->query($sql) ;
//$result_T=$Conn->query($sql_T) ;
$result=$Conn->query($sql) ;
if (isset($sql_T)) {$result_T=$Conn->query($sql_T) ; }    // consulta para los TOTALES
if (isset($sql_T2)) {$result_T2=$Conn->query($sql_T2) ; }    // consulta para los TOTALES
if (isset($sql_T3)) {$result_T3=$Conn->query($sql_T3) ; }    // consulta para los TOTALES
if (isset($sql_S)) {$result_S=$Conn->query($sql_S) ; }     // consulta para los SUBGRUPOS , agrupación de filas (Ej. CLIENTES o CAPITULOS en listado de udos)


echo "<small style='color:silver;'>Agrupar por : $agrupar ( {$result->num_rows} filas) </small>";

$formats["Enero"] = "moneda" ; $formats["Febrero"] = "moneda" ; $formats["Marzo"] = "moneda" ; $formats["Abril"] = "moneda" ; $formats["Mayo"] = "moneda" ; $formats["Junio"] = "moneda" ;
$formats["Julio"] = "moneda" ; $formats["Agosto"] = "moneda" ; $formats["Septiembre"] = "moneda" ; $formats["Octubre"] = "moneda" ; $formats["Noviembre"] = "moneda" ; $formats["Diciembre"] = "moneda" ;


$dblclicks=[];
$dblclicks["PROVEEDOR"]="PROVEEDOR" ;
$dblclicks["NOMBRE_OBRA"]="Obra" ;
$dblclicks["CONCEPTO"]="CONCEPTO" ;
$dblclicks["TIPO_GASTO"]="TIPO_GASTO" ;
$dblclicks["REF"]="REF" ;
$dblclicks["SUBOBRA"]="SUBOBRA" ;
$dblclicks["tipo_subcentro"]="tipo_subcentro" ;

$dblclicks["Dia"]="Dia" ;
$dblclicks["Semana"]="Semana" ;
$dblclicks["Mes"]="Mes" ;
$dblclicks["Trimestre"]="Trimestre" ;
$dblclicks["Anno"]="Anno" ;



$links["NOMBRE_OBRA"] = ["../obras/obras_ficha.php?id_obra=", "ID_OBRA"] ;
$links["PROVEEDOR"] = ["../proveedores/proveedores_ficha.php?id_proveedor=", "ID_PROVEEDORES"] ;
$links["CONCEPTO"] = ["../proveedores/concepto_ficha.php?id_concepto=", "ID_CONCEPTO"]  ;
$links["CONCEPTO"] = ["../proveedores/concepto_ficha.php?id_concepto=", "ID_CONCEPTO"] ;
$links["REF"] = ["../proveedores/albaran_proveedor.php?id_vale=", "ID_VALE", "ver Vale-albarán", "formato_sub"] ;
$links["FECHA"] = ["../proveedores/albaran_proveedor.php?id_vale=", "ID_VALE", "ver Vale-albarán", "formato_sub"] ;
$links["SUBOBRA"] = ["../obras/subobra_ficha.php?id_subobra=", "ID_SUBOBRA", "ver Subobra", "icon"] ;
//$links["NOMBRE_OBRA"]=["../obras/obras_ficha.php?id_obra=", "ID_OBRA"] ;
$links["N_FRA"] = ["../proveedores/factura_proveedor.php?id_fra_prov=", "ID_FRA_PROV","ver factura" ,"formato_sub"] ;
$links["Usub"] = ["../proveedores/usub_ficha.php?id=", "Usub","ver Usub" ,"formato_sub"] ;

//$formats["facturado"]='boolean_FACTURADO';

$formats["path_archivo"]="pdf_100_400" ;


$formats["P_gasto"] = "porcentaje" ;
$formats["importe"] = "moneda" ;
$formats["COSTE"] = "moneda" ;
$formats["ingreso_conc"] = "moneda" ;
$formats["ingreso"] = "moneda" ;
$formats["f_vto"] = "fecha" ;
$formats["conc"] = "boolean" ;
$formats["saldo"] = "moneda" ;
$formats["CANTIDAD"] = "fijo" ;
//$formats["ingresos"] = "moneda" ;
$aligns["FRA_PROV"] = "center" ;
//$aligns["Neg"] = "center" ;
//$aligns["Pagada"] = "center" ;
$tooltips["conc"] = "Indica si el pago está conciliado" ;
//$tooltips["Banco_Neg"] = "Indica el banco o línea de descuento donde está negociada" ;

$tabla_expandible=0;

$titulo="";
$msg_tabla_vacia="No hay.";

if ($tabla_group)
{ require("../include/tabla_group.php"); }
else
{ require("../include/tabla.php"); echo $TABLE ; }


?>
<!--</form>-->

</div>

<!--************ FIN  *************  -->
	
	

<?php  

$Conn->close();

?>
	 

</div>
  <br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br>
  <br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br>
  <br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br>
  <br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br>

                <!--</div>-->
                <!--****************** BUSQUEDA GLOBAL  *****************
            </div>
        </div>
        <!-- FIN Contenido principal -->

<?php 

//FIN
include_once('../templates/_inc_privado3_footer.php');

