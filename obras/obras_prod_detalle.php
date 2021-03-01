<?php
// cambios
require_once("../include/session.php");
$where_c_coste = " id_c_coste={$_SESSION['id_c_coste']} ";
$id_c_coste = $_SESSION['id_c_coste'];

// adaptación para abrir laPRODUCCION_OBRA o ESTUDIO_COSTE directamente

if ($_GET["id_produccion"]=="PRODUCCION_OBRA" OR $_GET["id_produccion"]=="ESTUDIO_COSTES")
{
    if (!isset($_GET["id_obra"])) 
        {die(cc_page_error( "ERROR EN ID_PRODUCCION"));}
        else 
            {
             $id_obra=$_GET["id_obra"] ;
             if ($_GET["id_produccion"]=="PRODUCCION_OBRA")   
             {
                $_GET["id_produccion"]=Dfirst("id_produccion_obra","OBRAS","ID_OBRA=$id_obra AND $where_c_coste") ;
             }
             else{
                $_GET["id_produccion"]=Dfirst("id_prod_estudio_costes","OBRAS","ID_OBRA=$id_obra AND $where_c_coste") ;

             }
        }    
}




$listado_global= (!isset($_GET["id_produccion"])) ;
$iniciar_form=(!isset($_POST["CAPITULO"])) ;  // determinamos si debemos de inicializar el FORM con valores vacíos

$titulo_pagina="Rv " . Dfirst("PRODUCCION","Prod_c_coste", "ID_PRODUCCION={$_GET["id_produccion"]} AND $where_c_coste"  ) ;
//$titulo_pagina="Rv " . Dfirst("PRODUCCION","PRODUCCIONES", "ID_PRODUCCION={$_GET["id_produccion"]} AND ID_OBRA="  ) ;
$titulo=$titulo_pagina ;  // para compatibiliidad con _inc_privado1_header  (pdte de homogeneizar , juand, feb21)

//INICIO
include_once('../templates/_inc_privado1_header.php');
include_once('../templates/_inc_privado2_navbar.php');


require_once("../include/NumeroALetras.php"); 
//require_once("../menu/menu_migas.php");

$style_hidden_if_global=$listado_global? " disabled " : ""  ; 

if (!$listado_global)                
  {
 $id_produccion=$_GET["id_produccion"];

     $id_obra=Dfirst("ID_OBRA", "Prod_c_coste","ID_PRODUCCION=$id_produccion AND $where_c_coste" ) ;
     $PRODUCCION= Dfirst("PRODUCCION", "Prod_c_coste","ID_PRODUCCION=$id_produccion AND $where_c_coste" ) ;
     
     
     
     // DATOS GENERALES DE LA OBRA
     $rs_Obra= DRow( "OBRAS","ID_OBRA=$id_obra AND $where_c_coste" ) ;
     
     $NOMBRE_COMPLETO= $rs_Obra["NOMBRE_COMPLETO"];
     $EXPEDIENTE= $rs_Obra["EXPEDIENTE"];    
     $GG_BI=$rs_Obra["GG_BI"];
     $COEF_BAJA=$rs_Obra["COEF_BAJA"];
     $iva_obra=$rs_Obra["iva_obra"];
     $IMPORTE_contrato_iva=$rs_Obra["IMPORTE"];
     $Pie_CERTIFCACION=$rs_Obra["Pie_CERTIFCACION"];
     $id_prod_estudio_costes=$rs_Obra["id_prod_estudio_costes"];

     // si estamos en $id_prod_estudio_costes le clonamos el PPROYECTO
     if (!cc_is_ESTUDIO_COSTE_actualizado($id_obra, $id_prod_estudio_costes))  {      cc_actualiza_ESTUDIO_COSTE($id_obra); }
 
     require_once("../obras/obras_menutop_r.php");
    // require_once("../menu/menu_migas.php");

     
     // Registro LRU (si no estamos en Listado Global)
     $tipo_entidad='rel_valorada' ;
     $id_entidad=$id_produccion;
     $id_subdir=0 ;

     $entidad=$titulo_pagina ;
     require("../menu/LRU_registro.php"); 
     // FIN LRU


 
  }
  else
  {
      

    if ($iniciar_form)    
    {   $Obra=  isset($_GET["Obra"]) ?  $_GET["Obra"] :  "" ;
        $PRODUCCION= isset($_GET["PRODUCCION"]) ?  $_GET["PRODUCCION"] :  "" ;
    }
    else
    {  $Obra=$_POST["Obra"] ; 
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
  $Estudio_coste = isset($_GET["Estudio_coste"]) ?  $_GET["Estudio_coste"] :  "" ;
  $FECHA1 = isset($_GET["FECHA1"]) ?  $_GET["FECHA1"] :  "" ;
  $FECHA2 = isset($_GET["FECHA2"]) ?  $_GET["FECHA2"] :  "" ;
  
  $SUBOBRA = isset($_GET["SUBOBRA"]) ?  $_GET["SUBOBRA"] :  "" ;
  $DETALLE = isset($_GET["DETALLE"]) ?  $_GET["DETALLE"] :  "" ;
  $fmt_costes = isset($_GET["fmt_costes"]) ?  $_GET["fmt_costes"] :  "" ;
  $fmt_agrupar_cap = isset($_GET["fmt_agrupar_cap"]) ?  $_GET["fmt_agrupar_cap"] :  "checked" ;
  $fmt_resumen_cap = isset($_GET["fmt_resumen_cap"]) ?  $_GET["fmt_resumen_cap"] :  "" ;
  $fmt_texto_udo = isset($_GET["fmt_texto_udo"]) ?  $_GET["fmt_texto_udo"] :  "" ;
  $fmt_med_proyecto = isset($_GET["fmt_med_proyecto"]) ?  $_GET["fmt_med_proyecto"] :  "checked";
  $fmt_anadir_med = isset($_GET["fmt_anadir_med"]) ?  $_GET["fmt_anadir_med"] :  "";
  $fmt_seleccion = isset($_GET["fmt_seleccion"]) ?  $_GET["fmt_seleccion"] :  "";
  $fmt_logo = isset($_GET["fmt_logo"]) ?  $_GET["fmt_logo"] :  "checked";
  $fmt_doc = isset($_GET["fmt_doc"]) ?  $_GET["fmt_doc"] :  "";
  $fmt_subobras = isset($_GET["fmt_subobras"]) ?  $_GET["fmt_subobras"] :  "checked";
  $fmt_mensual = isset($_GET["fmt_mensual"]) ?  $_GET["fmt_mensual"] :  "";
  $fmt_no_print = isset($_GET["fmt_no_print"]) ?  $_GET["fmt_no_print"] :  "";
  $fmt_pre_med = isset($_GET["fmt_pre_med"]) ?  $_GET["fmt_pre_med"] :  "";
  $id_prod_comparada = isset($_GET["id_prod_comparada"]) ?  $_GET["id_prod_comparada"] : 0;  
  $agrupar = isset($_GET["agrupar"]) ?  $_GET["agrupar"] : "capitulos";  

} 
 else {
//$NOMBRE_OBRA=$_POST["NOMBRE_OBRA"];
$CAPITULO=$_POST["CAPITULO"];
$FECHA1=$_POST["FECHA1"];
$FECHA2=$_POST["FECHA2"];
//$PRODUCCION=$_POST["PRODUCCION"];
$UDO=str_replace(" ","%",$_POST["UDO"]);
$Estudio_coste=str_replace(" ","%",$_POST["Estudio_coste"]);
$SUBOBRA=$_POST["SUBOBRA"];
$DETALLE=$_POST["DETALLE"];

$fmt_costes=isset($_POST["fmt_costes"]) ? 'checked' : '' ;
$fmt_agrupar_cap=isset($_POST["fmt_agrupar_cap"]) ? 'checked' : '' ;
$fmt_resumen_cap=isset($_POST["fmt_resumen_cap"]) ? 'checked' : '' ;
$fmt_texto_udo=isset($_POST["fmt_texto_udo"]) ? 'checked' : '' ;
$fmt_med_proyecto=isset($_POST["fmt_med_proyecto"]) ? 'checked' : '' ;
$fmt_anadir_med=isset($_POST["fmt_anadir_med"]) ? 'checked' : '' ;
$fmt_seleccion=isset($_POST["fmt_seleccion"]) ? 'checked' : '' ;
$fmt_logo=isset($_POST["fmt_logo"]) ? 'checked' : '' ;
$fmt_doc=isset($_POST["fmt_doc"]) ? 'checked' : '' ;
$fmt_subobras=isset($_POST["fmt_subobras"]) ? 'checked' : '' ;
$fmt_mensual=isset($_POST["fmt_mensual"]) ? 'checked' : '' ;
$fmt_no_print=isset($_POST["fmt_no_print"]) ? 'checked' : '' ;
$fmt_pre_med=isset($_POST["fmt_pre_med"]) ? 'checked' : '' ;

$id_prod_comparada = isset($_POST["id_prod_comparada"]) ?  $_POST["id_prod_comparada"] : 0; 
$agrupar=$_POST["agrupar"];   
$crea_produccion=$_POST["crea_produccion"];   

     
 }
// RESTO DE VARIABLES
$Dia      = isset($_GET["Dia"])      ?  $_GET["Dia"]        :    (isset($_POST["Dia"])       ?  $_POST["Dia"]       :  "") ;
$Semana   = isset($_GET["Semana"]  ) ?  $_GET["Semana"]     :    (isset($_POST["Semana"])    ?  $_POST["Semana"]    :  "") ;
$Mes      = isset($_GET["Mes"])      ?  $_GET["Mes"]        :    (isset($_POST["Mes"])       ?  $_POST["Mes"]       :  "") ;
$Trimestre= isset($_GET["Trimestre"])?  $_GET["Trimestre"]  :    (isset($_POST["Trimestre"]) ?  $_POST["Trimestre"] :  "") ;
$Anno     = isset($_GET["Anno"])     ?  $_GET["Anno"]       :    (isset($_POST["Anno"])      ?  $_POST["Anno"]      :  "") ;

 
 
  $solo_form=0;

  
 ?>

 <div style="overflow:visible">	   
   
	<!--************ INICIO *************  -->

<div id="main" class="mainc" style="width:100%; background-color:#fff">
    <br><br><br><br>   

<?php  
//echo "<div class='noprint'><br><br><br><br></div>" ;      // hago espacio artificialmente para bajar el texto


if ($fmt_logo)
{    
    if (!$path_logo_empresa = Dfirst("path_logo", "Empresas_Listado", "$where_c_coste")) {$path_logo_empresa = "../img/no_logo.jpg";}
    echo "<div class='row'>"
           . "<div class='col-lg-6'>"
               . "<img width='200' src='{$path_logo_empresa}_large.jpg' > "
            . "</div>" ;
    
    $result_emp=$Conn->query("SELECT * FROM C_COSTES WHERE  $where_c_coste");
    $rs_emp = $result_emp->fetch_array(MYSQLI_ASSOC) ;

    echo     "<div class='col-lg-6'>"
               . "<div style='font-size: xx-small;text-align: right;'>{$rs_emp["nombre_centro_coste"]}<br>{$rs_emp["domicilio"]} - {$rs_emp["cod_postal"]} {$rs_emp["Municipio"]}<br>CIF: {$rs_emp["cif"]}<br>"
               . "Tels: {$rs_emp["tels"]} - email: {$rs_emp["email"]}<br>{$rs_emp["web"]}<br><br><br>"
               . "</div>"
            . "</div>"
        . "</div>" ;
      
}

$HTML_prod_comparadas="" ;
$titulo=$PRODUCCION ;

$boton_global='';
if (!$listado_global)     
  {
    $boton_global= "<a class='btn btn-link btn-xs noprint' href= '../obras/obras_prod_detalle.php?_m=$_m&Obra=SIN_OBRA' title='Ir a las relaciones valoradas de todas las obras'><i class='fas fa-globe-europe'></i> Prod. detalle Global</a>" ;
  
  // Estamos en PRODUCCIONES COMPARADAS
  if ($agrupar=='comparadas'  )
    {
     $HTML_prod_comparadas.= "<br><br><div style='border-style: solid ; border-color:grey; margin-bottom: 5px; padding:10px'><b>RELACIÓN VALORADA A COMPARAR</b><select id='id_prod_comparada' name='id_prod_comparada' style='font-size: 15px; width: 30%;'>" ;
     $HTML_prod_comparadas.= DOptions_sql("SELECT  ID_PRODUCCION , PRODUCCION  FROM PRODUCCIONES  WHERE ID_OBRA=$id_obra  ORDER BY PRODUCCION ") ;
     $HTML_prod_comparadas.= "</select>"
          . "<a class='btn btn-primary btn-xs noprint ' href=# onclick=\"document.getElementById('form1').submit(); \"  "
          . "title='Comparar Relaciones Valoradas' >COMPARAR</a>"
          ." <a class='btn btn-link btn-xs' href='#' onclick=\"window.open('../obras/obras_prod_detalle.php?id_obra=$id_obra&id_produccion='+document.getElementById('id_prod_comparada').value ) \"    "
          ." title='Ver la Relación Valorada seleccionada' >ver relación valorada</a>" ;
     if ($id_prod_comparada)
     { 
        $PRODUCCION_COMPARADA=Dfirst("PRODUCCION", "PRODUCCIONES", "ID_PRODUCCION=".$id_prod_comparada) ;
        $titulo =  "<br>Comparación de <b>$PRODUCCION</b> con <b>$PRODUCCION_COMPARADA</b>" ;
     }    
     $HTML_prod_comparadas.=   "</div><br><br>"; 
    }

   //  actualizar RV ESTUDIO DE COSTES
   if ($id_produccion==$rs_Obra["id_prod_estudio_costes"])
    {  // actualizamos la RV ESTUDIO DE COSTES haciéndola copia literal del Proyecto
        
      $HASH_proyecto=Dfirst("SUM((MED_PROYECTO+1)*ID_UDO)","Udos","ID_OBRA=$id_obra")  ;
      $HASH_estudio_coste=Dfirst("SUM((MEDICION+1)*ID_UDO)","PRODUCCIONES_DETALLE","ID_PRODUCCION={$rs_Obra["id_prod_estudio_costes"]} ")  ;
      
      // comprobamos si ha habido variaciones entre Proyecto y Estudio de Costes para actualizarlo
      if( $HASH_proyecto!=$HASH_estudio_coste)
      {
//                $fecha_med=date("Y-m-d");
                $sql_DELETE="DELETE FROM `PRODUCCIONES_DETALLE` WHERE ID_PRODUCCION={$rs_Obra["id_prod_estudio_costes"]} ; " ;
                $sql_INSERT="INSERT INTO `PRODUCCIONES_DETALLE` (ID_PRODUCCION,ID_UDO,MEDICION ,Fecha, user) "
                        . "   SELECT {$rs_Obra["id_prod_estudio_costes"]}  ,ID_UDO, MED_PROYECTO,'0000-00-00', '{$_SESSION["user"]}'  "
                        . "FROM `Udos` WHERE ID_OBRA=$id_obra ;" ;
        //        echo $sql_INSERT;
                $Conn->query($sql_DELETE);
                $Conn->query($sql_INSERT);
       }
        

     }
  
    
    // crear cetificacion
   $fecha=date('Y-m-d');
//   $importe_final=Dfirst("importe_final","Prod_view"," $where_c_coste AND ID_PRODUCCION=$id_produccion ")  ;
//   $importe_final="(SELECT importe_final FROM Prod_view $where_c_coste AND ID_PRODUCCION=$id_produccion )"  ;
//   $sql_insert= encrypt2( "INSERT INTO `CERTIFICACIONES` (`ID_OBRA`, `ID_PRODUCCION`, `NUM`, `FECHA`, `CONCEPTO`, `IMPORTE`, user)" 
//             ." VALUES ( '$id_obra', '$id_produccion', '1', '$fecha', '$PRODUCCION' ,$importe_final, '{$_SESSION['user']}');" ) ;    

   $sql_insert= encrypt2( "INSERT INTO `CERTIFICACIONES` (`ID_OBRA`, `ID_PRODUCCION`, `NUM`, `FECHA`, `CONCEPTO`, `IMPORTE`, user)" 
             ." SELECT $id_obra , $id_produccion , 1 , '$fecha' , '$PRODUCCION'  ,importe_final , '{$_SESSION['user']}' "
             . "FROM Prod_view WHERE $where_c_coste AND ID_PRODUCCION=$id_produccion           ;" ) ;    
             
   $href="../include/sql.php?code=1&sql=$sql_insert ";
      
//      echo "<a class='btn btn-link'  href='#'  onclick=\"js_href('$href' )\" >"
//                                                        . "<i class='fas fa-unlink'></i> DESCONCILIAR $titulo_txt - MOV. BANCO</a>" ;
    ?>    
 <!--BOTONES SUPERIORES-->
 <div class='noprint'>
     <br><br>
     <?php echo $boton_global; ?>
     <a class="btn btn-link btn-xs noprint" title="imprimir" href=#  onclick="window.print();"><i class="fas fa-print"></i> Imprimir pantalla</a>
     <a class="btn btn-link btn-xs noprint" title="ver datos generales de la Relacion Valorada actual" target='_blank' href="../obras/prod_ficha.php?_m=$_m&id_obra=<?php echo $id_obra;?>&id_produccion=<?php echo $id_produccion;?>" ><i class="far fa-calendar-alt"></i> ficha Rel. Valorada</a>    
     <a class="btn btn-link btn-xs noprint" title="Crea una Certificación con el importe de esta Relación Valorada" href="#" onclick="js_href('<?php echo $href; ?>',0,'Va a crear una Certificación nueva.\nUna vez creada vaya a Ventas para verla' )" ><i class="fas fa-pen-nib"></i> Certificar Rel.Val.</a>    
     <br><br>
 </div>
 
<script>

function formato_prod_obra()
{ //    $('#fmt_costes').prop('checked',!($('#fmt_costes').prop('checked'))) ;
    $('#fmt_costes').prop('checked',false) ;
    $('#fmt_agrupar_cap').prop('checked',true) ;
    $('#fmt_texto_udo').prop('checked',true) ;
    $('#fmt_med_proyecto').prop('checked',true) ;  
    $('#fmt_resumen_cap').prop('checked',false) ;  
    $('#fmt_anadir_med').prop('checked',true) ;  
    $('#fmt_seleccion').prop('checked',false) ;  
    $('#fmt_doc').prop('checked',true) ;  
    $('#fmt_subobras').prop('checked',false) ;  
    $('#fmt_mensual').prop('checked',false) ;  
    $('#fmt_no_print').prop('checked',false) ;  
    $('#fmt_pre_med').prop('checked',false) ;  

    $('#agrupar').val("EDICION") ;  //agrupar  document.getElementById("number").value
    
//        alert($('#agrupar').val())  ;
//    document.getElementById("form1").submit();
    document.getElementById('form1').submit(); 

//    $('#btn_agrupar_udos').click() ;  
//   document.getElementbyID("btn_agrupar_udos").click();
//   document.getElementById('agrupar').value = 'udos'; document.getElementById('form1').submit(); 

//    window.print();
}
function formato_certif()
{ //    $('#fmt_costes').prop('checked',!($('#fmt_costes').prop('checked'))) ;
    $('#fmt_costes').prop('checked',false) ;
    $('#fmt_agrupar_cap').prop('checked',true) ;
    $('#fmt_texto_udo').prop('checked',true) ;
    $('#fmt_med_proyecto').prop('checked',false) ;  
    $('#fmt_resumen_cap').prop('checked',true) ;  
    $('#fmt_anadir_med').prop('checked',false) ;  
    $('#fmt_seleccion').prop('checked',false) ;  
    $('#fmt_logo').prop('checked',false) ;  
    $('#fmt_doc').prop('checked',false) ;  
    $('#fmt_mensual').prop('checked',false) ;  
    $('#fmt_no_print').prop('checked',true) ;  
    $('#fmt_pre_med').prop('checked',false) ;  
    
    $('#agrupar').val("udos") ;  
    document.getElementById('form1').submit();
    

}

function formato_estudio_costes()
{ //    $('#fmt_costes').prop('checked',!($('#fmt_costes').prop('checked'))) ;
    $('#fmt_costes').prop('checked',true) ;
    $('#fmt_agrupar_cap').prop('checked',false) ;
    $('#fmt_texto_udo').prop('checked',true) ;
    $('#fmt_med_proyecto').prop('checked',false) ;  
    $('#fmt_resumen_cap').prop('checked',true) ;  
    $('#fmt_anadir_med').prop('checked',false) ;  
    $('#fmt_seleccion').prop('checked',false) ;  
    $('#fmt_doc').prop('checked',false) ;  
    $('#fmt_subobras').prop('checked',true) ;  //agrupar
    $('#fmt_mensual').prop('checked',false) ;  
    $('#fmt_no_print').prop('checked',false) ;  
    $('#fmt_pre_med').prop('checked',false) ;   
    
//    alert($('#agrupar').val())  ;
//    alert(document.getElementById("agrupar").value)  ;
    
    $('#agrupar').val("udos") ;  //agrupar  document.getElementById("number").value
    
//        alert($('#agrupar').val())  ;
//    document.getElementById("form1").submit();
    document.getElementById('form1').submit();
    
}

//formato_estudio_costes() ;

</script>    

 
         <!--ENCABEZADOS PARA IMPRESION-->
 <!--<div class='divHeader'>-->
 <div class='only_print' >
   <h4 class='border'><?php echo $NOMBRE_COMPLETO;?></h4>
   <h6>EXPEDIENTE: <?php echo $EXPEDIENTE;?></h6>
 </div>  
 <h3><span class='noprint'>RELACION VALORADA: </span><b><?php echo $titulo;?></b></h3>

   
<!--  <div class='divFooter'>
   <h6 class='border'>Página</h6> 
 </div>  
   -->
    <!--<div class='row noprint' style='border-style: solid ; border-color:grey; margin-bottom: 5px; padding:10px'>-->
  <div class='div_ppal_expand'>
   <button data-toggle='collapse' class="btn btn-default btn-block btn-lg noprint" style="text-align:left" data-target='#div_filtro'><i class="fas fa-sliders-h"></i> SELECCION DATOS<i class="fas fa-chevron-down"></i></button>
  </div>
   <div id='div_filtro' class='collapse'>
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
     <h1>RELACION VALORADA - BUSQUEDA GLOBAL <i class='fas fa-globe-europe'></i></h1>
     
     <div class='row noprint' style='border-style: solid ; border-color:grey; margin-bottom: 5px; padding:10px'>
  <div class='div_ppal_expand'>
   <button data-toggle='collapse' class="btn btn-default btn-block btn-lg noprint" style="text-align:left" data-target='#div_filtro'>SELECCION DATOS <i class="fas fa-chevron-down"></i></button>
  </div>
   <div id='div_filtro' class='collapse'>


   <form class='noprint' action="../obras/obras_prod_detalle.php" method="post" id="form1" name="form1">
    <div class='col-lg-4'>
<!--<div class="form-group">-->           
<TABLE class="noprint">
      
    <TR><TD>Obra   </TD><TD><INPUT  type="text" id="Obra" name="Obra" value="<?php echo $Obra;?>"><button type="button" onclick="document.getElementById('Obra').value='' ; ">*</button></TD></TR>
    <TR><TD>PRODUCCION   </TD><TD><INPUT   type="text" id="PRODUCCION" name="PRODUCCION" value="<?php echo $PRODUCCION;?>"><button type="button" onclick="document.getElementById('PRODUCCION').value='' ; ">*</button></TD></TR>
<?php 

  }

?>
    
<!--<TR><TD>CAPITULO   </TD><TD><INPUT class="form-control" type="text" id="CAPITULO" name="CAPITULO" value="<?php echo $CAPITULO;?>"><button type="button" onclick="document.getElementById('CAPITULO').value='' ; ">*</button></TD></TR>-->    
<TR><TD>CAPITULO   </TD><TD><INPUT  type="text" id="CAPITULO" name="CAPITULO" value="<?php echo $CAPITULO;?>"><button type="button" onclick="document.getElementById('CAPITULO').value='' ; ">*</button></TD></TR>
<TR><TD>Unidad de obra (UDO)</TD><TD><INPUT   type="text" id="UDO" name="UDO" value="<?php echo $UDO;?>"><button type="button" onclick="document.getElementById('UDO').value='' ; ">*</button></TD></TR>
<TR><TD>Estudio Coste</TD><TD><INPUT   type="text" id="Estudio_coste" name="Estudio_coste" value="<?php echo $Estudio_coste;?>"><button type="button" onclick="document.getElementById('Estudio_coste').value='' ; ">*</button></TD></TR>

</TABLE></div><div class='col-lg-4'><TABLE> 


<TR><TD>Fecha desde</TD><TD><INPUT  type="date" id="FECHA1" name="FECHA1" value="<?php echo $FECHA1;?>"><button type="button" onclick="document.getElementById('FECHA1').value='' ; ">*</button></TD></TR>
<TR><TD>Fecha hasta</TD><TD><INPUT type="date" id="FECHA2" name="FECHA2" value="<?php echo $FECHA2;?>"><button type="button" onclick="document.getElementById('FECHA2').value='' ; ">*</button></TD></TR>
<TR><TD>Dia</TD><TD><INPUT   type="text" id="Dia" name="Dia" value="<?php echo $Dia;?>"><button type="button" onclick="document.getElementById('Dia').value='' ; ">*</button></TD></TR>
<TR><TD>Semana</TD><TD><INPUT   type="text" id="Semana" name="Semana" value="<?php echo $Semana;?>"><button type="button" onclick="document.getElementById('Semana').value='' ; ">*</button></TD></TR>
<TR><TD>Mes</TD><TD><INPUT   type="text" id="Mes" name="Mes" value="<?php echo $Mes;?>"><button type="button" onclick="document.getElementById('Mes').value='' ; ">*</button></TD></TR>
<TR><TD>Trimestre</TD><TD><INPUT   type="text" id="Trimestre" name="Trimestre" value="<?php echo $Trimestre;?>"><button type="button" onclick="document.getElementById('Trimestre').value='' ; ">*</button></TD></TR>
<TR><TD>Año</TD><TD><INPUT   type="text" id="Anno" name="Anno" value="<?php echo $Anno;?>"><button type="button" onclick="document.getElementById('Anno').value='' ; ">*</button></TD></TR>

</TABLE></div><div class='col-lg-4'><TABLE> 

<TR><TD>Subobra    </TD><TD><INPUT type="text" id="SUBOBRA" name="SUBOBRA" value="<?php echo $SUBOBRA;?>"><button type="button" onclick="document.getElementById('SUBOBRA').value='' ; ">*</button></TD></TR>
<TR><TD>Detalle    </TD><TD><INPUT type="text" id="DETALLE" name="DETALLE" value="<?php echo $DETALLE;?>"><button type="button" onclick="document.getElementById('DETALLE').value='' ; ">*</button></TD></TR>

<!--<TR><TD></TD><TD></TD></TR>-->


</TABLE></div>
     
<input type="hidden"  id="agrupar"  name="agrupar" value="<?php echo $agrupar;?>"> 
<input type="hidden"  id="agrupar"  name="crea_produccion" value="0"> 

<!--<div class='col-lg-12 noprint'>-->    
<INPUT type="submit" class='btn btn-success btn-lg'  value="actualizar consulta" id="form1_submit" name="form1_submit">      
<!--</div>-->

 </div>

<!--<div class='col-lg-12 noprint'>-->    


     
<div class='noprint'>
<!--    <button data-toggle='collapse' style="text-align:left" class="btn btn-default btn-block btn-lg" data-target='#div_formato'>FORMATO <i class="fas fa-chevron-down"></i></button>

    <div id='div_formato' class='collapse in'>-->
<div class='div_ppal_expand'>
<!--<button data-toggle='collapse' class="btn btn-default btn-block btn-lg noprint" style="text-align:left" data-target='#div_modos'><i class="fas fa-sliders-h"></i> MODOS DE USO<i class="fas fa-chevron-down"></i></button>-->
</div>
<!--<div id='div_modos' class='collapse'>-->
    
<br><a class="btn btn-link btn-xs noprint" title="formato para realizar un Estudio de costes de un Proyecto o Liciación" href=#  onclick="formato_estudio_costes();"><i class="fas fa-euro-sign"></i> modo Estudio de Costes</a>
<br><a class="btn btn-link btn-xs noprint" title="formato de formulario para registrar Producciones de Obra" href=#  onclick="formato_prod_obra();"><i class="fas fa-hard-hat"></i> modo Producción Obra</a>
<br><a class="btn btn-link btn-xs noprint" title="imprimir la producción con formato de Certificación sin costes, con texto_udo y con resumen" href=#  onclick="formato_certif();"><i class="fas fa-print"></i> modo Certificacion</a>

<br>Modo personalizado: <br>
<label style="font-size: xx-small;color:grey;" title='Permite seleccionar udos para operar con ellas'><INPUT type="checkbox" id="fmt_seleccion" name="fmt_seleccion" <?php echo $fmt_seleccion;?>  >&nbsp;Selección&nbsp;&nbsp;</label>
<label style="font-size: xx-small;color:grey;" title='Añade una columna de Costes Estimados de cada Udo'><INPUT type="checkbox" id="fmt_costes" name="fmt_costes" <?php echo $fmt_costes;?>  >&nbsp;Costes Est.&nbsp;&nbsp;</label>
<label style="font-size: xx-small;color:grey;" title='Agrupa el listado de Udos por capítulos'><INPUT type="checkbox" id="fmt_agrupar_cap" name="fmt_agrupar_cap" <?php echo $fmt_agrupar_cap;?>  >&nbsp;Agrupar Capitulos&nbsp;&nbsp;</label>
<label style="font-size: xx-small;color:grey;" title='Muestra el texto completo de la Udo'><INPUT type="checkbox" id="fmt_texto_udo" name="fmt_texto_udo" <?php echo $fmt_texto_udo;?>  >&nbsp;Texto udo&nbsp;&nbsp;</label>
<label style="font-size: xx-small;color:grey;" title='Muestra la Medición de Proyecto'><INPUT type="checkbox" id="fmt_med_proyecto" name="fmt_med_proyecto" <?php echo $fmt_med_proyecto;?>  >&nbsp;Med.Proyecto&nbsp;&nbsp;</label>
<label style="font-size: xx-small;color:grey;" title='Añade un Resumen de Capítulos al final de la Relación Valorada'><INPUT type="checkbox" id="fmt_resumen_cap" name="fmt_resumen_cap" <?php echo $fmt_resumen_cap;?>  >&nbsp;Resumen capitulos&nbsp;&nbsp;</label>
<label style="font-size: xx-small;color:grey;" title='Desglosa en meses de Enero a Diciembre la Relación Valorada\n Se aconseja filtrar un año para evitar solapar meses de diferentes años'><INPUT type="checkbox" id="fmt_mensual" name="fmt_mensual" <?php echo $fmt_mensual;?>  >&nbsp;Desglose mensual&nbsp;&nbsp;</label>
<label style="font-size: xx-small;color:grey;" title='Añade una columna donde poder añadir mediciones. Agrupe por cap-udos, udos, subobra-udos o MODO EDICION'><INPUT type="checkbox" id="fmt_anadir_med" name="fmt_anadir_med" <?php echo $fmt_anadir_med;?>  >&nbsp;Columna Añadir Med.&nbsp;&nbsp;</label>
<label style="font-size: xx-small;color:grey;" title='Imprime el logo de la empresa'><INPUT type="checkbox" id="fmt_logo" name="fmt_logo" <?php echo $fmt_logo;?>  >&nbsp;Logo&nbsp;&nbsp;</label>
<label style="font-size: xx-small;color:grey;" title='Muestra los documentos , pdf, jpg... asociados a una Udo'><INPUT type="checkbox" id="fmt_doc" title='Muestra los documentos , pdf, jpg... asociados a una Udo' name="fmt_doc" <?php echo $fmt_doc;?>  >&nbsp;Doc. udo&nbsp;&nbsp;</label>
<label style="font-size: xx-small;color:grey;" title='Muestra todas las Subobras aunque no tengan Udos asignadas'><INPUT type="checkbox" id="fmt_subobras"  name="fmt_subobras" <?php echo $fmt_subobras;?>  >&nbsp;Subobras vacias&nbsp;&nbsp;</label>
<label style="font-size: xx-small;color:grey;" title='No muestra los capítulos con la etiqueta _NO_PRINT_ (ó simplificada _NP_ ), para poder imprimir certificaciones sin los capítulos auxiliares como p.ej. COSTES INDIRECTOS'><INPUT type="checkbox" id="fmt_no_print"  name="fmt_no_print" <?php echo $fmt_no_print;?>  >&nbsp;Quitar NP&nbsp;&nbsp;</label>
<label style="font-size: xx-small;color:grey;" title='Permite ver los Descompuestos de Precio y Mediciones del Proyecto'><INPUT type="checkbox" id="fmt_pre_med"  name="fmt_pre_med" <?php echo $fmt_pre_med;?>  >&nbsp;Descompuestos&nbsp;&nbsp;</label>

 
<!--</div>-->          
 <!--</div>-->         
</div>         
         
<?php  

$style_hidden_if_global=$listado_global? " disabled " : ""  ;

echo "<div id='myDIV' class='col-lg-12 noprint' style='margin-top: 25px; padding:10px'>" ; 


$btnt['capitulos']=['capitulos','Agrupa por Capítulos', ''] ;
$btnt['cap_udos']=['cap-udos','Agrupa por Capítulos desplegables',''] ;
$btnt['udos']=['udos','',''] ;
//$btnt['detalle_costes']=['estudio costes','formato que facilita el Estudio de Costes de la Relación Valorada',''] ;
$btnt['detalle']=['detalle','Muestra la Relación Valorada con cada detalle de Medición',''] ;
$btnt['vacio1']=['','',''] ;
$btnt['subobras']=['subobras','Agrupa por subobras',''] ;   //subobras_udos
$btnt['subobras_udos']=['subobras-udos','Agrupa por subobras y expande subobras',''] ;   //subobras_udos
$btnt['balance']=['balance','Balance económico por Subobras. Ingresos - Gastos reales imputados', $style_hidden_if_global] ;
$btnt['vacio2']=['','',''] ;
if ($listado_global) { $btnt['obras']=['obras','Agrupa por Obra',''] ;}
$btnt['comparadas']=['comparadas','Compara dos Relaciones Valoradas',''] ;
$btnt['EDICION']=['MODO EDICION','Permite añadir mediciones' ,$style_hidden_if_global ] ;
$btnt['vacio']=['','' ,'' ] ;
$btnt['dias']=['dias','Agrupa por Días' ,'' ] ;
$btnt['semanas']=['semanas','Agrupa por Semanas' ,'' ] ;
$btnt['meses']=['meses','Agrupa por Meses' ,'' ] ;
$btnt['trimestres']=['trimestres','Agrupa por Trimestres' ,'' ] ;
$btnt['annos']=['años','Agrupa por Años' ,'' ] ;
$btnt['vacio3']=['','' ,'' ] ;
$btnt['solo_resumen']=['solo resumen','' ,'' ] ;

echo "Agrupar por:<br>";
foreach ( $btnt as $clave => $valor)
{
  $active= ($clave==$agrupar) ? "cc_active" : "" ; 
  $disabled= isset($valor[2]) ? $valor[2] : ""  ;
//  echo "<button $disabled id='btn_agrupar_$clave' class='cc_btnt$active' title='{$valor[1]}' onclick=\"getElementById('agrupar').value = '$clave'; document.getElementById('form1').submit(); \">{$valor[0]}</button>" ;  
  echo (substr($clave,0,5)=='vacio') ? "   " : "<button $disabled id='btn_agrupar_$clave' class='btn-xs cc_btnt $active' title='{$valor[1]}' "
                    . " onclick=\"getElementById('agrupar').value = '$clave'; document.getElementById('form1').submit(); \">{$valor[0]}</button>" ;  
}           
  
echo '</div>' ;

//echo "<button  class='btn btn-warning' title='copia el resultado de la consulta a una produccion nueva' onclick=\"getElementById('crea_produccion').value = '1'; document.getElementById('form1').submit(); \">Consulta a prod. nueva</button>" ;  



echo $HTML_prod_comparadas ;

?>        
         
         
</form>

			
<?php   // Iniciamos variables para tabla.php  background-color:#B4045


$where=" 1=1 " ;

if ($listado_global)     
  {
  $where=$Obra==""? $where : $where . " AND NOMBRE_OBRA LIKE '%$Obra%'" ;
  $where=$PRODUCCION==""? $where : $where . " AND PRODUCCION LIKE '%$PRODUCCION%'" ;
  }
 else
{
  if ($agrupar<>"EDICION") {$where=$where . " AND id_produccion=$id_produccion "; }  
}
  


//$where=$tipo_subcentro==""? $where : $where . " AND LOCATE(tipo_subcentro,'$tipo_subcentro')>0 " ;
$CAPITULO_filtro= str_replace(" ", "%", $CAPITULO) ;
$SUBOBRA_filtro= str_replace(" ", "%", $SUBOBRA) ;
$DETALLE_filtro= str_replace(" ", "%", $DETALLE) ;

$where=$CAPITULO==""? $where : $where . " AND CAPITULO LIKE '%$CAPITULO_filtro%'" ;
$where=$UDO==""? $where : $where . " AND CONCAT_WS(' ',UDO,IFNULL(TEXTO_UDO,'')) LIKE '%$UDO%'" ;
$where=$Estudio_coste==""? $where : $where . " AND CONCAT_WS(' ',UDO,IFNULL(Estudio_coste,'')) LIKE '%$Estudio_coste%'" ;
$where=$SUBOBRA==""? $where : $where . " AND SUBOBRA LIKE '%$SUBOBRA_filtro%'" ;
$where=$DETALLE==""? $where : $where . " AND Observaciones LIKE '%$DETALLE_filtro%'" ;
//$where=$TIPO_GASTO==""? $where : $where . " AND TIPO_GASTO LIKE '%$TIPO_GASTO%'" ;
//$where=$FECHA1=="01-01-1980"? $where : $where . " AND FECHA >= STR_TO_DATE($FECHA1,'%d-%m-%Y')" ;

// no dibujamos ni imprimimos los Capitulos con la etiqueta _NO_PRINT (o _NP_ ) en su nombre
$where=$fmt_no_print==""? $where : $where . " AND CAPITULO NOT LIKE '%_NO_PRINT_%' AND CAPITULO NOT LIKE '%_np_%'" ;


$select_semana="DATE_FORMAT(fecha, '%Y semana %u')"  ;
$select_trimestre="CONCAT(YEAR(fecha), '-', QUARTER(fecha),'T')"  ;

   
$where_fecha="" ;
$where_fecha=$FECHA1==""? $where_fecha : $where_fecha . " AND FECHA >= '$FECHA1' " ;
$where_fecha=$FECHA2==""? $where_fecha : $where_fecha . " AND FECHA <= '$FECHA2' " ; 
$where_fecha=$Dia==""? $where_fecha : $where_fecha . " AND DATE_FORMAT(FECHA, '%Y-%m-%d')='$Dia' " ;
$where_fecha = $Semana==""? $where_fecha : $where_fecha . " AND $select_semana = '$Semana' " ;
$where_fecha = $Mes==""? $where_fecha : $where_fecha . " AND DATE_FORMAT(fecha, '%Y-%m') = '$Mes' " ;
$where_fecha = $Trimestre==""? $where_fecha : $where_fecha . " AND $select_trimestre = '$Trimestre' " ;
$where_fecha = $Anno==""? $where_fecha : $where_fecha . " AND YEAR(fecha) = '$Anno' " ;



if ($agrupar<>"EDICION") {$where .= $where_fecha;}

$where_gasto= "1=1" . $where_fecha ;
//$where_gasto.= $FECHA1=="" ? "" :  " AND FECHA >= '$FECHA1' " ;
//$where_gasto.= $FECHA2=="" ? "" :  " AND FECHA <= '$FECHA2' " ;

// SELECT A INCLUIR EN LOS SQL SEGUN EL FORMATO ///////////////////////////////////////////
$select_global = $listado_global ? "NOMBRE_OBRA, ID_PRODUCCION, PRODUCCION," : ""  ;               
//$select_global_T = $listado_global ? "'' AS ag, '' AS bg,'' AS cg," : "'' AS cg,"  ;   
$select_global_T = $listado_global ? "'' AS ag, '' AS bg,'' AS cg," : ""  ;   

// SI ES formato Costes $fmt_costes añadimos las columnas gastos_est y beneficio
//$select_COSTE_EST = $fmt_costes ? ",IF(PRECIO=COSTE_EST,'moneda_gris','moneda') AS COSTE_EST_FORMAT, COSTE_EST,Estudio_coste " : ""  ;               
$select_COSTE_EST = $fmt_costes ? ", COSTE_EST,'Tras un signo = puede introducir una fÓrmula con la que recalcular el Coste Estimado' AS Estudio_coste_TOOLTIP,Estudio_coste " : ""  ;               
$select_COSTE_EST_T = $fmt_costes ? ", '' as COSTE_EST, '' as acc " : ""  ;               
$select_costes = $fmt_costes ? ", SUM(gasto_est) as gasto_est,(SUM(IMPORTE)- SUM(gasto_est)) as beneficio_est" : ""  ;               
//$select_costes_T = $fmt_costes ? ", SUM(gasto_est) as gasto_est, '<small>Benef. Estimado</small>' as leyenda_beneficio, ''" : ""  ;   
$select_costes_T = $fmt_costes ? ", SUM(gasto_est) as gasto_est, (SUM(IMPORTE)- SUM(gasto_est)) as beneficio_est " : ""  ;   
$select_costes_T2 = $fmt_costes ? ", SUM(gasto_est) as gasto_est,(SUM(IMPORTE)*(1+GG_BI)*COEF_BAJA- SUM(gasto_est)) as beneficio_est " : ""  ;   
$select_costes_T3 = $fmt_costes ? ", SUM(gasto_est)*(1+iva_obra) as gasto_est, (1- SUM(gasto_est)/(SUM(IMPORTE)*(1+GG_BI)*COEF_BAJA)) as margen " : ""  ;   

$select_agrupar_CAPITULO = $fmt_agrupar_cap ? "CAPITULO AS ID_SUBTOTAL_CAPITULO," : "CAPITULO,"  ;   
$select_agrupar_CAPITULO_T = $fmt_agrupar_cap ? "" : "'' as acap,"  ;   


$udo_flags= "CONCAT(IF(path_archivo<>'','<i class=\"far fa-file-alt\"></i>','') , IF(ID_POF<>'',' (POF) ','')) ";
$select_UDO = $fmt_texto_udo ? " ,CONCAT('<b>',UDO,' ',$udo_flags,'</b><br><small>',COALESCE(TEXTO_UDO,''),'</small>') AS UDO "
        . "" : " ,TEXTO_UDO AS UDO_TOOLTIP ,$udo_flags AS UDO_FLAG , CONCAT('<b>',UDO,' ',$udo_flags,'</b>') AS UDO "  ;               

$select_UDO .= $fmt_pre_med ? " ,Descompuesto_PRECIO AS PRECIO_MODAL, Descompuesto_MED AS MED_PROYECTO_MODAL " : "" ;               



$select_doc = $fmt_doc ? ",path_archivo" : "" ;



$select_MED_PROYECTO = $fmt_med_proyecto ? ",IF(MED_PROYECTO=MEDICION,'fijo_gris','fijo') AS MEDICION_FORMAT, MED_PROYECTO,MED_PROYECTO*PRECIO as importe_proyecto, (MED_PROYECTO*PRECIO - SUM(MEDICION)*PRECIO) as importe_pdte_ej " : ""  ;               
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

$select_SUMA_MEDICION = ($UDO=="") ?  " , '' as asm " : " , SUM(MEDICION) as MEDICION "  ;

$tipo_tabla='' ;       // indica si usamos tabla.php o tabla_group.php o tabla_pdf.php
//$tabla_pdf=0 ;             // usaremos TABLA_GROUP.PHP 



// desglose mensual
$c_importe='importe';
$c_fecha='FECHA';
$select_MENSUAL= $fmt_mensual ? ", SUM(importe*(MONTH($c_fecha)=1)) AS Enero, SUM(importe*(MONTH($c_fecha)=2)) AS Febrero, SUM(importe*(MONTH($c_fecha)=3)) AS Marzo "
        . ", SUM(importe*(MONTH($c_fecha)=4)) AS Abril, SUM(importe*(MONTH($c_fecha)=5)) AS Mayo, SUM(importe*(MONTH($c_fecha)=6)) AS Junio"
        . ", SUM(importe*(MONTH($c_fecha)=7)) AS Julio, SUM(importe*(MONTH($c_fecha)=8)) AS Agosto, SUM(importe*(MONTH($c_fecha)=9)) AS Septiembre"
        . ", SUM(importe*(MONTH($c_fecha)=10)) AS Octubre, SUM(importe*(MONTH($c_fecha)=11)) AS Noviembre, SUM(importe*(MONTH($c_fecha)=12)) AS Diciembre"  
        : "";
// fin desglose mensual            

// defino totales para Agrupamiento 'capituos' y cap_udos'
$sql_T_resumen="SELECT $select_global_T 'Suma Ejecución Material........................' $select_MED_PROYECTO_hueco_doble , SUM(IMPORTE) as importe $select_costes_T $select_MENSUAL FROM ConsultaProd WHERE $where    " ;
$sql_T2_resumen="SELECT $select_global_T CONCAT('Suma Ejecución Contrata... GG+BI x COEF_BAJA:',COEF_BAJA)$select_MED_PROYECTO_hueco_doble , SUM(IMPORTE)*(1+GG_BI)*COEF_BAJA as importe $select_costes_T2  FROM ConsultaProd WHERE $where    " ;
$sql_T3_resumen="SELECT $select_global_T 'Suma Ejecución Contrata (iva incluido).. ' $select_MED_PROYECTO_hueco_doble , SUM(IMPORTE)*(1+GG_BI)*COEF_BAJA*(1+iva_obra)/IMPORTE_OBRA as P_ejec , SUM(IMPORTE)*(1+GG_BI)*COEF_BAJA*(1+iva_obra) as importe $select_costes_T3 FROM ConsultaProd WHERE $where    " ;



// FIN DE SELECT A INCLUIR EN SQL  //////////////////////////////////


// BOTONES A MOSTRAR SEGUN EL FORMATO, SELECCIÓN, ANADIR_MED...

$content_sel="" ;         // inicializamos el contenido del <div> SELECTION
$content_anadir_med="" ;

if (!$listado_global)
{    
// contenedor selection por defecto
     $content_sel.="<div class='div_ppal_expand'>" ; 
     $content_sel.="<button data-toggle='collapse' class='btn btn-default btn-lg' data-target='#div_seleccion'>Operar con selección <i class='fas fa-chevron-down'></i></button>"
             . "</div>"
             . "<div id='div_seleccion' class='collapse in'>" ; 
//     $content_sel.="<div style='border:1px solid grey;  ;'><h3>Operar con selección</h3>"  ;   // anulamos provionalmente el EXPAND
             

    if($agrupar=='detalle')  // borramos id detalles en otro caso borramos ID_UDO
    {    
     $content_sel.="<div class='noprint' style='width:100% ; border-style:solid;border-width:2px; border-color:silver ;'><a class='btn btn-danger btn-xs noprint ' href='#' onclick='sel_borrar_mediciones_detalle($id_produccion)'"
             . " title='Vacía las mediciones de las Udo seleccionadas' ><i class='far fa-trash-alt'></i> Borrar mediciones Udos seleccionadas</a></div>" ;
    }else 
    { $content_sel.="<div class='noprint' style='width:100% ; border-style:solid;border-width:2px; border-color:silver ;'><a class='btn btn-danger btn-xs noprint ' href='#' onclick='borrar_mediciones_udo($id_produccion)' "
            . "title='Vacía las mediciones de las Udo seleccionadas' ><i class='far fa-trash-alt'></i> Borrar mediciones Udos seleccionadas</a></div>" ;
    }
    
   // boton MED A PROYECTO
      $content_sel.="<div class='noprint' style='width:100% ; border-style:solid;border-width:2px; border-color:silver ;'>"
              . "<a class='btn btn-warning btn-xs noprint ' href='#' onclick='prod_completa_udo($id_produccion)' "
             . "title='Completa hasta Medicion de Proyecto (MED_PROYECTO) las Udos seleccionadas' >MED_PROYECTO a Udos seleccionadas</a>"
              . "</div>" ;
   
     // SUBOBRA
      $content_sel.= "<div class='noprint' style='width:100% ; border-style:solid;border-width:2px; border-color:silver ;'>"
              . "<b>SUBOBRAS</b>. Pasar Udos seleccionadas a Subobra: <select id='id_subobra' style='font-size: 15px; width: 20%;'>" ;
      $content_sel.= DOptions_sql("SELECT   Subobra_View.ID_SUBOBRA,  Subobra_View.SUBOBRA FROM Subobra_View  WHERE ID_OBRA=$id_obra AND $where_c_coste ORDER BY SUBOBRA ") ;
      $content_sel.= "</select>"; 
      $href='../include/sql.php?sql=' . encrypt2("UPDATE Udos SET ID_SUBOBRA = _VARIABLE1_  WHERE ID_OBRA=$id_obra AND ID_UDO IN _VARIABLE2_ ")     ;
     $content_sel.="<a class='btn btn-warning btn-xs noprint ' href='#' onclick=\"js_href('$href',0,'', 'id_subobra','table_selection_IN()' )\"   "
             . "title='Asigna a la Subobra las Udos seleccionadas' >asignar udos a subobra</a>" ;
     
     $href="../obras/subobra_ficha.php?id_subobra="   ;    
     $content_sel.="<a class='btn btn-link btn-xs noprint ' href='#' "
             . " onclick=\"window.open('$href' + document.getElementById('id_subobra').value ,'_blank' )\"   "
             . "title='abre la ficha de la SubObra' >ver SubObra</a>" ;

     $content_sel.="<a class='btn btn-link btn-xs noprint ' target='_blank' href='../obras/subobra_anadir.php?id_obra=$id_obra'  "
             . "title='Crea nueva SubObra' ><i class='fas fa-plus-circle'></i> añadir SubObra</a>"
             . "</div>" ; 
     // POF
      $content_sel.= "<div class='noprint' style='width:100% ; border-style:solid;border-width:2px; border-color:silver ;'>"
              . "<b>POF</b>. añadir Udos a la POF: <select id='id_pof' style='font-size: 15px; width: 20%;'>" ;
      $content_sel.= DOptions_sql("SELECT  ID_POF,NUM_NOMBRE_POF FROM POF_lista  WHERE ID_OBRA=$id_obra AND $where_c_coste ORDER BY NUMERO ") ;
      $content_sel.= "</select>"; 
      $sql_insert="INSERT INTO POF_CONCEPTOS (ID_POF, id_udo,CANTIDAD,CONCEPTO,DESCRIPCION,Precio_Cobro,user) " 
              .  " SELECT '_VARIABLE1_' AS ID_POF,ID_UDO AS id_udo ,MED_PROYECTO AS CANTIDAD,CONCAT(ud,' ',UDO) AS CONCEPTO,TEXTO_UDO AS DESCRIPCION, "
              .  "  Precio_Cobro , '{$_SESSION['user']}' AS user "  
              .  " FROM Udos_View WHERE ID_UDO IN  _VARIABLE2_ "  ;
      
      $href='../include/sql.php?sql=' . encrypt2($sql_insert)     ;
     $content_sel.="<a class='btn btn-warning btn-xs noprint ' href='#' "
             . " onclick=\"js_href('$href' + '&variable1='+ document.getElementById( 'id_pof' ).value + '&variable2='+ table_selection_IN()  )\"   "
             . "title='Añadir a la POF las Udos seleccionadas' >añadir Udos a POF</a>" ;
 
     $href="../pof/pof.php?id_pof="   ;    
     $content_sel.="<a class='btn btn-link btn-xs noprint ' href='#' "
             . " onclick=\"window.open('$href' + document.getElementById('id_pof').value ,'_blank' )\"   "
             . "title='ver POF' >ver POF</a>" ;
     
     
     $href="../pof/pof_anadir.php?id_obra=$id_obra&nombre_pof="   ;    
     $content_sel.="<a class='btn btn-link btn-xs noprint ' href='#' "
             . " onclick=\"js_href('$href' + window.prompt('Nombre de la POF: ' )  )\"   "
             . "title='Añadir a  POF ' ><i class='fas fa-plus-circle'></i> añadir POF</a>"
             . "</div>" ;
     
     $content_sel.="</div>" ; 
     
    if ($fmt_anadir_med) $content_anadir_med="  <a class='btn btn-warning btn-xs noprint ' href='#' onclick='prod_anade_med_udo($id_produccion)' title='Añade a cada unidad de obra la medición de la columna Añadir Med' >añade columna de mediciones </a>" ;
    $print_anadir_med=false ;
    
    $where_urlencode=base64_encode($where) ;
//    $where_urlencode=$where ; 
    
    echo "<a class='btn btn-xs btn-link noprint' title='añadir Capitulo al proyecto' href=# onclick= 'add_capitulo($id_obra)' >"
            . "<i class='fas fa-plus-circle'></i> añadir capítulo</a>";
    echo "<a class='btn btn-xs btn-link noprint' title='añadir Unidad de Obra (UdO) al primer Capitulo' href=# onclick= 'add_udo($id_obra)' >"
            . "<i class='fas fa-plus-circle'></i> añadir UdO</a>";

    echo "<a class='btn btn-xs btn-link noprint ' target='_blank' href='../obras/subobra_anadir.php?id_obra=$id_obra' ' "
             . "title='Crea nueva Subobra' ><i class='fas fa-plus-circle'></i> añadir SubObra</a>" ;

    echo " <a class='btn btn-xs btn-link  noprint ' href='#' onclick=\"copy_prod_consulta($id_obra,$id_produccion,'$where_urlencode','$PRODUCCION')\" "
            . "title='Crea una Relación Valorada nueva con la consulta actual' ><i class='fas fa-plus-circle'></i> copiar a nueva RV</a>" ;
}  
// FIN BOTONES A MOSTRAR

 switch ($agrupar) {
   case "obras":
     $sql="SELECT ID_OBRA,NOMBRE_OBRA , SUM(IMPORTE) as importe  FROM ConsultaProd WHERE $where   GROUP BY ID_OBRA ORDER BY NOMBRE_OBRA " ;
//     $sql_T="SELECT 'Suma' , SUM(IMPORTE) as importe  FROM ConsultaProd WHERE $where    " ;
   break;
   case "subobras":
     
       // elegimos la consulta en función de si mostramos las SUBOBRAS VACIAS
     $sql=  $fmt_subobras ?  " SELECT   Subobra_View.ID_SUBOBRA,  Subobra_View.SUBOBRA,  ConsultaProd.importe FROM Subobra_View  "
                            .  "LEFT OUTER JOIN (SELECT ID_SUBOBRA, SUM(importe) as importe FROM ConsultaProd WHERE $where GROUP BY ID_SUBOBRA ) AS ConsultaProd "
                             . " ON Subobra_View.ID_SUBOBRA = ConsultaProd.ID_SUBOBRA  "
                             . " WHERE ID_OBRA=$id_obra AND $where_c_coste "
                            .  " ORDER BY SUBOBRA" 
          : "SELECT ID_SUBOBRA,SUBOBRA , SUM(importe) as importe  FROM ConsultaProd WHERE $where   GROUP BY ID_SUBOBRA ORDER BY SUBOBRA " ;
     
//    echo $sql ;
     
//     $sql_T="SELECT 'Suma' , SUM(IMPORTE) as importe  FROM ConsultaProd WHERE $where    " ;
     
     $tabla_update="SubObras" ;
     $id_update="ID_SUBOBRA" ;
     $id_clave="ID_SUBOBRA" ;
     $actions_row["id"]="ID_SUBOBRA";
     $actions_row["delete_link"]="1";
     $actions_row["delete_confirm"]="0";


     
   break;
      
   case "balance": 
     
       
     $sql1=" (SELECT ID_SUBOBRA,SUBOBRA , SUM(IMPORTE) as importe, 0 AS gasto  FROM ConsultaProd WHERE $where   GROUP BY ID_SUBOBRA ) " ;
     $sql2=" (SELECT ID_SUBOBRA,SUBOBRA , 0 as importe, SUM(IMPORTE) AS gasto  FROM ConsultaGastos_View WHERE $where_gasto AND ID_OBRA=$id_obra GROUP BY ID_OBRA) " ;

     $sql= "SELECT ID_SUBOBRA,SUBOBRA , SUM(importe) as importe,SUM( gasto) AS gasto ,SUM(importe)-SUM( gasto) AS beneficio_real, 1-SUM( gasto)/SUM(importe) as margen "
             . " FROM (" . $sql1 ." UNION ALL ". $sql2 .") X GROUP BY ID_SUBOBRA" ; 
//     $sql_T= "SELECT 'Suma Ejecución Material...', SUM(importe) as importe,SUM( gasto) AS gasto FROM (" . $sql1 ." UNION ALL ". $sql2 .") X " ; 
   
$sql_T2="SELECT  CONCAT('Suma Ejecución Contrata... GG+BI x COEF_BAJA:',$COEF_BAJA), SUM(importe)*(1+$GG_BI)*$COEF_BAJA as importe,SUM( gasto) AS gasto  ,SUM(importe)*(1+$GG_BI)*$COEF_BAJA-SUM( gasto) AS beneficio_real"
        . ",( 1-SUM(gasto)/(SUM(importe)*(1+$GG_BI)*$COEF_BAJA)) as margen   FROM (" . $sql1 ." UNION ALL ". $sql2 .") X   " ;
$sql_T3="SELECT  'Porcentaje de Ejecución:' as leyenda,(SUM(importe)*(1+$GG_BI)*$COEF_BAJA)/($IMPORTE_contrato_iva/(1+$iva_obra)) as porc_ejecucion FROM (" . $sql1 ." UNION ALL ". $sql2 .") X   " ;

  
     
   break;

   case "capitulos":
     $sql="SELECT $select_global ID_OBRA,ConsultaProd.ID_CAPITULO, CAPITULO $select_importe_proyecto , SUM(IMPORTE) as importe $select_costes $select_MENSUAL FROM "
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
     $sql="SELECT $select_global ID_OBRA,ID_CAPITULO, $select_agrupar_CAPITULO ID_UDO,cod_proyecto, ud $select_UDO $select_doc $select_MED_PROYECTO,SUM(MEDICION) as MEDICION"
           . " $select_anadir_med , PRECIO, SUM(IMPORTE) as importe $select_COSTE_EST $select_costes  FROM ConsultaProd WHERE $where  GROUP BY ID_UDO ORDER BY CAPITULO,ID_UDO " ;

   $print_anadir_med=true ;

//     $sql_T="SELECT $select_global_T $select_agrupar_CAPITULO_T '' as a31 $select_anadir_med, '' as a14  $select_MED_PROYECTO_hueco,'TOTAL ' $select_SUMA_MEDICION , SUM(IMPORTE) as importe $select_COSTE_EST_T $select_costes  FROM ConsultaProd WHERE $where    " ;

   if (!$fmt_resumen_cap)      // si imprimimos el RESUMEN suponemos que es una certificacion y quitamos los totales
   {   
     $sql_T2="SELECT $select_global_T  CONCAT('Suma Ejecución Contrata... GG+BI x COEF_BAJA:',COEF_BAJA) $select_MED_PROYECTO_hueco  ,'' as a1,'' as a2, '<center>P_Ejec</center>', SUM(IMPORTE)*(1+GG_BI)*COEF_BAJA as importe,'' as a5 $select_costes_T2  FROM ConsultaProd WHERE $where    " ;
     $sql_T3="SELECT $select_global_T  'Suma Ejecución Contrata (iva incluido).. ' $select_MED_PROYECTO_hueco ,'' as a2a,'' as a3a, SUM(IMPORTE)*(1+GG_BI)*COEF_BAJA*(1+iva_obra)/IMPORTE_OBRA as P_ejec , SUM(IMPORTE)*(1+GG_BI)*COEF_BAJA*(1+iva_obra) as importe,'' as a5 $select_costes_T3 FROM ConsultaProd WHERE $where    " ;
   }


//    echo $sql ;
    //echo $sql_T2 ;
    //echo $sql_T2 ;

    // permite editar el coste_est
     $updates=['COSTE_EST']  ;
     $tabla_update="Udos" ;
     $id_update="ID_UDO" ;
     $id_clave="ID_UDO" ;
   
    if ($fmt_seleccion) { $col_sel="ID_UDO" ;}  // activo la Selection con el campo 'id' 
    
    // agrupamiento  SUBTOTALES
    if ($fmt_agrupar_cap)
    {    
     $col_subtotal='ID_SUBTOTAL_CAPITULO' ;
     $array_sumas['importe']=0 ;
     if  ($fmt_costes)
         {
          $array_sumas['vacio']=0 ; // COLUMNAS VACIAS EN SUBTOTALES. SALTO HUECOS
          $array_sumas['vacio2']=0 ;   // COLUMNAS VACIAS EN SUBTOTALES. SALTO HUECOS
          $formats['vacio'] = "vacio" ;
          $formats['vacio2'] = "vacio" ;
           $array_sumas['gasto_est']=0 ;
           $array_sumas['beneficio_est']=0 ;
         }
     $colspan= 5  + 3*($select_MED_PROYECTO<>'')+1*($select_anadir_med<>'')+1*($select_doc<>'') ;   // posición de celdas de subtotales de capítulos
    } 
     $valign["ud"]='top' ;               // PENDIENTE DE TERMINAR. VERTICAL-ALIGN
     $valign["importe"]='bottom' ;        
     
   break;
 
   case "cap_udos":
//    $sql="SELECT NOMBRE_OBRA, PRODUCCION, ID_OBRA,CAPITULO ,ID_UDO,UDO,MED_PROYECTO,SUM(MEDICION) as MEDICION, PRECIO, SUM(IMPORTE) as importe  FROM ConsultaProd WHERE $where  GROUP BY ID_UDO ORDER BY CAPITULO,ID_UDO " ;

//     $sql="SELECT $select_global ID_OBRA,ID_CAPITULO, CAPITULO ,ID_UDO,ud,UDO,MED_PROYECTO,SUM(MEDICION) as MEDICION, PRECIO,COSTE_EST, SUM(IMPORTE) as importe,COSTE_EST, SUM(gasto_est) as gasto_est  FROM ConsultaProd WHERE $where  GROUP BY ID_UDO ORDER BY CAPITULO,ID_UDO " ;
     $sql="SELECT $select_global ID_OBRA,ID_CAPITULO, ID_UDO,ud $select_UDO $select_doc  $select_MED_PROYECTO "
           . " ,SUM(MEDICION) as MEDICION $select_anadir_med, PRECIO,SUM(IMPORTE) as importe $select_COSTE_EST $select_costes "
           . "FROM ConsultaProd WHERE $where  GROUP BY ID_UDO ORDER BY CAPITULO,ID_UDO " ;
       
     $print_anadir_med=true ;
  
//     echo $sql;
     $sql_T=$sql_T_resumen ;
     $sql_T2=$sql_T2_resumen ;
     $sql_T3=$sql_T3_resumen ;
 

     $sql_S="SELECT ConsultaProd.ID_CAPITULO AS ID_CAPITULO, CAPITULO $select_importe_proyecto , SUM(IMPORTE) as importe   FROM "
           . " ConsultaProd  JOIN Capitulos_importe ON ConsultaProd.ID_CAPITULO=Capitulos_importe.ID_CAPITULO "
           . " WHERE $where  GROUP BY ID_CAPITULO ORDER BY CAPITULO " ;


     $id_agrupamiento="ID_CAPITULO" ;
     // permite editar el coste_est
     $updates=['COSTE_EST']  ;
     $anchos_ppal=[30,20,20,20,20,20,20,20,20,20,20,20,20] ;
    
     $tabla_update="Udos" ;
     $id_update="ID_UDO" ;
     $id_clave="ID_UDO" ;
//     $tabla_group=1 ;             // usaremos TABLA_GROUP.PHP 
     $tipo_tabla='group' ;       // indica si usamos tabla.php o tabla_group.php

     
    if ($fmt_seleccion) { $col_sel="ID_UDO" ;}  // activo la Selection con el campo 'id'
    break;

   case "subobras_udos":
     $sql="SELECT $select_global ID_OBRA,ID_SUBOBRA, ID_UDO,ud $select_UDO $select_doc  $select_MED_PROYECTO "
           . " ,SUM(MEDICION) as MEDICION $select_anadir_med, PRECIO,SUM(IMPORTE) as importe $select_COSTE_EST $select_costes "
           . "FROM ConsultaProd WHERE $where  GROUP BY ID_UDO ORDER BY SUBOBRA,ID_UDO " ;
//     echo $sql;
     $sql_T=$sql_T_resumen ;
     $sql_T2=$sql_T2_resumen ;
     $sql_T3=$sql_T3_resumen ;
 
     $print_anadir_med=true ;

     $sql_S="SELECT  ID_SUBOBRA, SUBOBRA  , SUM(IMPORTE) as importe $select_costes  FROM "
           . " ConsultaProd "
           . " WHERE $where  GROUP BY ID_SUBOBRA ORDER BY SUBOBRA " ;

//     echo $sql_S ;
     
     $id_agrupamiento="ID_SUBOBRA" ;
     // permite editar el coste_est
     $updates=['COSTE_EST']  ;
     $anchos_ppal=[30,20,20,20,20,20,20,20,20,20,20,20,20] ;
    
     $tabla_update="Udos" ;
     $id_update="ID_UDO" ;
     $id_clave="ID_UDO" ;
//     $tabla_group=1 ;             // usaremos TABLA_GROUP.PHP 
     $tipo_tabla='group' ;       // indica si usamos tabla.php o tabla_group.php

     
    if ($fmt_seleccion) { $col_sel="ID_UDO" ;}  // activo la Selection con el campo 'id'
    break;

   case "dias":
    $sql="SELECT  DATE_FORMAT(FECHA, '%Y-%m-%d') as fecha,SUM(importe) as importe  FROM ConsultaProd WHERE $where   GROUP BY fecha  ORDER BY fecha  " ;
//    $sql_T="SELECT '' AS D, SUM(IMPORTE) as importe  FROM ConsultaProd WHERE $where  " ;
     break;
   case "semanas":
    $sql="SELECT  $select_semana as Semana,SUM(importe) as importe  FROM ConsultaProd WHERE $where   GROUP BY Semana ORDER BY Semana  " ;
//    $sql_T="SELECT '' AS D, SUM(IMPORTE) as importe  FROM ConsultaProd WHERE $where  " ;
    break;
   case "meses":
    $sql="SELECT  DATE_FORMAT(FECHA, '%Y-%m') as MES,SUM(importe) as importe  FROM ConsultaProd WHERE $where   GROUP BY MES  ORDER BY MES  " ;
//    $sql_T="SELECT '' AS D, SUM(IMPORTE) as importe  FROM ConsultaProd WHERE $where  " ;
    break;
   case "trimestres":
    $sql="SELECT  $select_trimestre as Trimestre,SUM(importe) as importe  FROM ConsultaProd WHERE $where   GROUP BY Trimestre  ORDER BY Trimestre  " ;
//    $sql_T="SELECT '' AS D, SUM(IMPORTE) as importe  FROM ConsultaProd WHERE $where  " ;
    break;
   case "annos":
    $sql="SELECT  YEAR(FECHA) as Anno,SUM(importe) as importe $select_MENSUAL FROM ConsultaProd WHERE $where   GROUP BY Anno  ORDER BY Anno  " ;
//    $sql_T="SELECT '' AS D, SUM(IMPORTE) as importe $select_MENSUAL FROM ConsultaProd WHERE $where  " ;
    break;
   case "detalle":
   $sql="SELECT id, FECHA , $select_global CAPITULO,ID_UDO,ud $select_UDO,Observaciones $select_MED_PROYECTO_detalle, "
          . " MEDICION , PRECIO,COSTE_EST, IMPORTE  FROM ConsultaProd WHERE $where ORDER BY CAPITULO,ID_UDO " ;
   
//   $sql_T="SELECT $select_global_T '' as a122,'' as a112,'' as a12,'' as a31,'' as a39,'' as a14,'' as a15,'Suma' , SUM(IMPORTE) as importe  FROM ConsultaProd WHERE $where    " ;
   $actions_row["id"]="id";
   $actions_row["delete_link"]="1";
   $updates=['MEDICION','FECHA','Observaciones']  ;
   $tabla_update="PRODUCCIONES_DETALLE" ;
   $id_update="id" ;
   $id_clave="id" ;
  
   if ($fmt_seleccion) { $col_sel="id" ;}  // activo la Selection con el campo 'id'

  
     break;
   case "EDICION":
   $onclick_VAR_TABLA1_="ID_UDO" ;           // paso de variables para dar instrucciones al boton 'add' para añadir un detalle a la udo
   $onclick_VAR_TABLA2_="MED_PROYECTO" ;     // idem
   $actions_row["onclick1_link"]="<a class='btn btn-link btn-xs' title='añade nuevo detalle de medición a la Udo' href=# onclick=\"add_detalle( $id_produccion, _VAR_TABLA1_ , '_VAR_TABLA2_' )\" >add</a> ";
   $actions_row["id"]="ID_UDO"; 
   
   $sql0="SELECT * FROM Prod_det_suma WHERE ID_PRODUCCION=$id_produccion   " ;    
   $sql="SELECT Udos_View.ID_UDO , CAPITULO,COD_PROYECTO AS Cod, ud $select_UDO, MED_PROYECTO, suma_medicion AS MEDICION $select_anadir_med_Udos_View,PRECIO $select_COSTE_EST, suma_medicion*PRECIO AS importe"
        . " FROM Udos_View LEFT JOIN ($sql0)  AS SQL0 ON Udos_View.ID_UDO=SQL0.ID_UDO    WHERE ID_OBRA=$id_obra AND $where " ;        
   
   $print_anadir_med=true ;
//   echo $sql ;
//   $sql_T="SELECT '' as a122,'' as a112,'' as a12,'' as a31,'' as a39,'' as a14,'' as a15,'Suma' , SUM(IMPORTE) as importe  FROM ConsultaProd WHERE ID_PRODUCCION=$id_produccion  " ;
//   $sql_T="SELECT '' as a122,'' as a112,'' as a12,'' as a31,'' as a39,'' as a14 $select_COSTE_EST_T,'Suma' , SUM(IMPORTE) as importe  FROM ConsultaProd WHERE ID_PRODUCCION=$id_produccion AND $where  " ;
//   echo "<br>$sql_T" ;
   $updates=[]  ;
  $tabla_update="PRODUCCIONES_DETALLE" ;
  $id_update="ID_UDO" ;
  $id_clave="ID_UDO" ;
   
     break;
   case "comparadas":
//   $onclick_VAR_TABLA1_="ID_UDO" ;           // paso de variables para dar instrucciones al boton 'add' para añadir un detalle a la udo
//   $onclick_VAR_TABLA2_="MED_PROYECTO" ;     // idem
//   $actions_row["onclick1_link"]="<a class='btn btn-link btn-xs' title='añade nuevo detalle de medición a la Udo' href=# onclick=\"add_detalle( $id_produccion, _VARIABLE1_ , '_VARIABLE2_' )\" >add</a> ";
//   $actions_row["id"]="ID_UDO"; 
       
   if ($id_prod_comparada)
   {
   
   $sql0="SELECT * FROM Prod_det_suma WHERE ID_PRODUCCION=$id_produccion   " ;    
   $sql2="SELECT ID_PRODUCCION,ID_UDO,suma_medicion  FROM Prod_det_suma WHERE ID_PRODUCCION=$id_prod_comparada    " ;    
   
   $sql="SELECT Udos_View.ID_UDO, CAPITULO,COD_PROYECTO AS Cod, ud $select_UDO, MED_PROYECTO, SQL0.suma_medicion AS medicion1,SQL2.suma_medicion AS medicion2,"
           . "SQL0.suma_medicion - SQL2.suma_medicion AS Medicion_DIFERENCIA,PRECIO, "
           . " SQL0.suma_medicion*PRECIO AS importe1,  SQL2.suma_medicion*PRECIO AS importe2, SQL0.suma_medicion*PRECIO - SQL2.suma_medicion*PRECIO AS importe_DIFERENCIA "
        . " FROM Udos_View LEFT JOIN ($sql0)  AS SQL0 ON Udos_View.ID_UDO=SQL0.ID_UDO"
                     . "   LEFT JOIN ($sql2)  AS SQL2 ON Udos_View.ID_UDO=SQL2.ID_UDO "
                     . "  WHERE ID_OBRA=$id_obra AND (SQL0.suma_medicion<>0 OR SQL2.suma_medicion <> 0) " ;   
   
//   $sql_T="SELECT 'Suma' AS a,'' AS a2,'' AS a3,'' AS a4,'' AS a5,'' AS a6,'' AS a7,'' AS a8,'' AS a9, "
//           . " SUM(SQL0.suma_medicion*PRECIO) AS importe1,  SUM(SQL2.suma_medicion*PRECIO) AS importe2, SUM(SQL0.suma_medicion*PRECIO - SQL2.suma_medicion*PRECIO) AS importe_DIFERENCIA "
//        . " FROM Udos_View LEFT JOIN ($sql0)  AS SQL0 ON Udos_View.ID_UDO=SQL0.ID_UDO"
//                     . "   LEFT JOIN ($sql2)  AS SQL2 ON Udos_View.ID_UDO=SQL2.ID_UDO "
//                     . "  WHERE ID_OBRA=$id_obra AND (SQL0.suma_medicion<>0 OR SQL2.suma_medicion <> 0) " ;   
   
   
   $etiquetas["medicion1"]="Medición $PRODUCCION" ;
   $etiquetas["medicion2"]="Medición $PRODUCCION_COMPARADA" ;
   $etiquetas["importe1"]="Importe $PRODUCCION" ;
   $etiquetas["importe2"]="Importe $PRODUCCION_COMPARADA" ;
   }
   else
   {
    $sql="SELECT '' "   ;
   }    
   
   
   
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
//     $sql_T="SELECT $select_global_T 'Suma' , SUM(IMPORTE) as importe  FROM ConsultaProd WHERE $where    " ;
    break;
   case "solo_resumen":
       
     $sql="SELECT '' ; " ;
//     $sql_T="SELECT $select_global_T 'Suma' , SUM(IMPORTE) as importe  FROM ConsultaProd WHERE $where    " ;
       
       
    break;


   
   }
///////////// FIN CASE ///////////
 
   // sumatorias
 $tabla_sumatorias["importe"]=0 ;
 $tabla_sumatorias["gasto"]=0 ;
 $tabla_sumatorias["pdte_conciliar"]=0 ;
 $tabla_sumatorias["pdte_pago"]=0 ;
 $tabla_sumatorias["beneficio_real"]=0 ;
 $tabla_sumatorias["margen"]=0 ;
 $tabla_sumatorias["importe_proyecto"]=0 ;
 $tabla_sumatorias["importe_pdte_ej"]=0 ;
 $tabla_sumatorias["gasto_est"]=0 ;
 $tabla_sumatorias["beneficio_est"]=0 ;
 $tabla_sumatorias["P_ejec"]="= @@importe@@ / @@importe_proyecto@@ " ;
 $tabla_sumatorias["margen"]=0 ;
 $tabla_sumatorias["margen"]=0 ;
 
 $tabla_sumatorias["importe1"]=0 ;
 $tabla_sumatorias["importe2"]=0 ;
 $tabla_sumatorias["importe_DIFERENCIA"]=0 ;
 
 // si UDO está filtrado, también sumamos las mediciones
 if ($UDO<>"")
 {
    $tabla_sumatorias["MEDICION"]=0 ;
    $tabla_sumatorias["medicion1"]=0 ;
    $tabla_sumatorias["medicion2"]=0 ;

 }
        
   
$tabla_sumatorias_resumen = $tabla_sumatorias ;     
   
 
   
   
$formats["Enero"] = "moneda" ; $formats["Febrero"] = "moneda" ; $formats["Marzo"] = "moneda" ; $formats["Abril"] = "moneda" ; $formats["Mayo"] = "moneda" ; $formats["Junio"] = "moneda" ;
$formats["Julio"] = "moneda" ; $formats["Agosto"] = "moneda" ; $formats["Septiembre"] = "moneda" ; $formats["Octubre"] = "moneda" ; $formats["Noviembre"] = "moneda" ; $formats["Diciembre"] = "moneda" ;
   
   
 $divs=[] ;  
// $divs["Estudio_coste"]=[ "<div style='cursor: pointer;font-size:small  ; float:right; opacity:0.3'  onclick=\"alert('EN PRUEBAS:  _VAR_')\"  "
//                        . "title='recalcula Coste Estimado (en pruebas)'>recalc</div>" , 'Estudio_coste' ];
// $divs["Estudio_coste"]=[ "<div style='cursor: pointer;font-size:small  ; float:right; opacity:0.3'  onclick=\"alert(document.getElementById('_ID_VAR_').innerHTML)\"  "
//                        . "title='recalcula Coste Estimado (en pruebas)'>recalc</div>" , 'Estudio_coste' ];

 $divs["COSTE_EST"]=[ "<div style='cursor: pointer ; float:right; opacity:0.5' >"
                     . "<a class='btn btn-link btn-xs noprint'  onclick=\"eval_coste_tabla('_VAR_', '_ID_')\"  "
                        . "title='recalcula fórmula del estudio de coste (en pruebas2)'>recalc</a></div>" , 'ID_UDO' ];


 
 
 $dblclicks=[] ;  
 $dblclicks["NOMBRE_OBRA"]="OBRA" ;
 $dblclicks["CAPITULO"]="CAPITULO" ;
 $dblclicks["UDO"]="UDO" ;
 $dblclicks["fecha"]="FECHA*" ;
 $dblclicks["MES"]="FECHA*" ;
 $dblclicks["SUBOBRA"]="SUBOBRA" ;
 
  $dblclicks["Semana"]="Semana" ;
 $dblclicks["Mes"]="Mes" ;
 $dblclicks["Anno"]="Anno" ;

 //$links["CAPITULO"] = ["../obras/obras_ficha.php?id_obra=", "ID_OBRA"] ;
//echo $sql ;
//echo $sql_T ;
//echo $sql ;
//echo $sql ;
 
// ANULADO LO HACEMOS EN TABLA.PHP (por php o ajax) ya que no es necesario aquí (juand, feb21)
//$result=$Conn->query($sql) ;
//
//echo "<br><div class='noprint' style='opacity:0.4;'><small>Filas: {$result->num_rows} </small></div>" ;
////echo $sql ;
//
//if (isset($sql_T)) {$result_T=$Conn->query($sql_T) ; }    // consulta para los TOTALES
//if (isset($sql_T2)) {$result_T2=$Conn->query($sql_T2) ; }    // consulta para los TOTALES
//if (isset($sql_T3)) {$result_T3=$Conn->query($sql_T3) ; }    // consulta para los TOTALES
//if (isset($sql_S)) {$result_S=$Conn->query($sql_S) ; }     // consulta para los SUBGRUPOS , agrupación de filas (Ej. CLIENTES o CAPITULOS en listado de udos)



$links["NOMBRE_OBRA"] = ["../obras/obras_ficha.php?id_obra=", "ID_OBRA"] ;
$links["SUBOBRA"] = ["../obras/subobra_ficha.php?id_subobra=", "ID_SUBOBRA", "ver Subobra", "icon"] ;


if (!$listado_global)
{
$links["UDO"] = ["../obras/udo_prod.php?id_produccion=$id_produccion&id_udo=", "ID_UDO" ,"ver detalles de medición de la Unidad de Obra", ''] ;    
}    
else
{
$links["UDO"] = ["../obras/udo_prod.php?id_udo=", "ID_UDO", "ver ficha de la unidad de obra", ""] ;   
$links["PRODUCCION"]=["../obras/obras_prod_detalle.php?id_produccion=", "ID_PRODUCCION"] ;

}    
    
//$links["NOMBRE_OBRA"]=["../obras/obras_ficha.php?id_obra=", "ID_OBRA"] ;

$updates[]='Estudio_coste' ;
$updates[]='Fecha' ;

//$links["SUBOBRA"] = ["../obras/subobra_ficha.php?id_subobra=", "ID_SUBOBRA", "ver Subobra", "formato_sub"] ;


//$formats["Descompuesto_MED"] = "boton_modal" ;
//$formats["Descompuesto_PRECIO"] = "boton_modal" ;
$formats["Estudio_coste"] = "div_edit" ;
$formats["COSTE_EST"] = "text_moneda" ;
$tooltips["COSTE_EST"] = "Admite formula matemática a calcular y comentarios, anteponer =,  ejemplo\n = hormigon 50*.15 + mallazo 2.5" ;
$formats["margen"] = "porcentaje" ;
$formats["P_ejec"] = "porcentaje" ;
$formats["importe"] = "moneda" ;
$formats["beneficio_real"] = "moneda" ;
$formats["beneficio_est"] = "moneda" ;
$formats["gasto_est"] = "moneda" ;
$formats["COSTE"] = "moneda" ;
//$formats["COSTE_EST"] = "text_edit" ;
$formats["MED_PROYECTO"] = "fijo" ;
$formats["MEDICION"] = "fijo" ;
//$formats["fecha"] = "dbfecha" ;
//$formats["conc"] = "boolean" ;
$formats["PRECIO"] = "moneda" ;
$formats["exceso"] = "semaforo_OK" ;
//$formats["ingresos"] = "moneda" ;
$aligns["leyenda_beneficio"] = "right" ;

$formats["path_archivo"]="pdf_100" ;                //"pdf_800" ;
$formats["MES"]="mes" ;                //"pdf_800" ;



//$styles["_ID_UDO"] = "vertical-align: top;" ;
//$styles["ud"] = "vertical-align: top;" ;
//$styles["UDO"] = "vertical-align: top;" ;
//$styles["COD_PROYECTO"] = "vertical-align: top;" ;
$styles["MEDICION"] = "vertical-align: bottom;" ;
$styles["PRECIO"] = "vertical-align: bottom;" ;
$styles["importe"] = "vertical-align: bottom;" ;

//$aligns["Neg"] = "center" ;
//$aligns["Pagada"] = "center" ;
//$tooltips["conc"] = "Indica si el pago está conciliado" ;
//$tooltips["Banco_Neg"] = "Indica el banco o línea de descuento donde está negociada" ;
//echo '</form>' ;

$titulo = $titulo_pagina . " (_NUM_)";


//$titulo="<small>Produccion por $agrupar</small>";
$msg_tabla_vacia="No hay.";

if (isset($col_sel))  echo $content_sel ;           // si hay columna de SELECTION pinto el div con los botones acciones de selection
if (isset($fmt_anadir_med) AND $print_anadir_med)  echo $content_anadir_med ;   // si hay columna de añadir medicion el div con los botones acciones de selection

$tabla_expandible=0;


//echo "AQUI ESTA: ". isset($result) ;

unset($result);  // sigo sin encontrar quien crea el $result

if ($tipo_tabla=='group')
{ require("../include/tabla_group.php"); }
else if ($tipo_tabla=='pdf')
{ require("../include/tabla_pdf.php"); }
else 
{
    require("../include/tabla_ajax.php"); 
//    require("../include/tabla.php"); echo $TABLE ; 
    
    
}
 


//////////////// incluimos RESUMEN DE CAPITULOS

if ($fmt_resumen_cap AND !$listado_global)
{
    $sql="SELECT $select_global ID_OBRA,ConsultaProd.ID_CAPITULO, CAPITULO  , SUM(IMPORTE) as importe $select_importe_proyecto $select_costes   "
           . " FROM ConsultaProd  JOIN Capitulos_importe ON ConsultaProd.ID_CAPITULO=Capitulos_importe.ID_CAPITULO "
           . " WHERE $where  GROUP BY ID_CAPITULO ORDER BY CAPITULO " ;

    
//     $sql_T="SELECT $select_global_T 'Suma Ejecución Material........................' $select_MED_PROYECTO_hueco_doble  , SUM(IMPORTE) as importe $select_costes_T "
//             . "  FROM ConsultaProd WHERE $where    " ;

     $sql_Prod="SELECT A_DEDUCIR,CERT_ANTERIOR,F_certificacion,OPC_DEDUCIR  FROM PRODUCCIONES WHERE ID_PRODUCCION=$id_produccion    " ;
//     $sql_Obra="SELECT Pie_CERTIFCACION,iva_obra,COEF_BAJA,GG_BI,IMPORTE  FROM OBRAS WHERE ID_OBRA=$id_obra    " ;
     
//     $result=$Conn->query($sql) ;
//     $result_T=$Conn->query($sql_T) ;     // consulta para los TOTALES
//     $result_Obra=$Conn->query($sql_Obra) ;     // consulta para los TOTALES
     
     $result_Prod=$Conn->query($sql_Prod) ;     // consulta para prod
     $rs_Prod= $result_Prod->fetch_array(MYSQLI_ASSOC)  ;
     
     
     
$formats["margen"] = "porcentaje" ;
$formats["P_ejec"] = "porcentaje" ;
$formats["beneficio_real"] = "moneda" ;
$formats["beneficio_est"] = "moneda" ;
$formats["gasto_est"] = "moneda" ;
   

///////////////     CALCULO DE IMPORTES TOTALES     
     

     $importe_PEM=round(Dfirst("SUM(IMPORTE)","ConsultaProd",$where) ,2) ;
     $importe_COSTE_PEC=round(Dfirst("SUM(MEDICION*COSTE_EST)","ConsultaProd",$where) ,2) ;
     $importe_GG_BI=round($importe_PEM*$GG_BI,2) ;
     $importe_PEC=$importe_PEM+$importe_GG_BI ;
//     $importe_PEC= $importe_PEC ? $importe_PEC : 1 ;       // evitamos la division por CERO
     
     $importe_PEC_BAJA=round($importe_PEC*$COEF_BAJA,2) ;
//     $importe_PEC_BAJA= $importe_PEC_BAJA ? $importe_PEC_BAJA : 1 ;       // evitamos la division por CERO
     
     
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
     
//     echo "<script>var  importe_TOTAL = $importe_TOTAL ; </script>" ; 
     
//     $importe_a_descontar=Dfirst("","","") ;

 echo "<br><br>";

     
 echo "<p style='PAGE-BREAK-AFTER: always' ></p>";        // SALTO DE PAGINA AL IMPRIMIR
 
$titulo="RESUMEN DE <B>$PRODUCCION<B>";
$tabla_sumatorias = $tabla_sumatorias_resumen ;     // copiamos las mismas sumatorias que en el informe detallado
 
    require("../include/tabla_ajax.php"); 
//    require("../include/tabla.php"); echo $TABLE ;
 
//    for ($i = 0; $i <= 100; $i++) {
//     echo '<br>' ;   
//    echo NumeroALetras::convertir($i/100, 'euros', 'centimos')." (". trim( cc_format($i/100,'moneda')).")" ;;
//}

//        RESUMEN TOTALES
//    $importe_TOTAL=0.30 ;
//   $importe_TOTAL_letra = NumeroALetras::convertir($importe_TOTAL, 'euros', 'centimos')." (". trim( cc_format($importe_TOTAL,'moneda')).")" ;
   $importe_TOTAL_letra =  cc_format($importe_TOTAL,'num2txt_eur') ;
//   $numero=cc_format($numero,'moneda') ;
//   echo "$letras ($numero)" ;
  
   echo "<br><br><TABLE >" ;
   echo "<TR><TD width='300px'></TD><TD width='200px'>TOTAL EJECUCION MATERIAL</TD><TD align='right'>".cc_format($importe_PEM,'moneda')."</TD></TR>" ;
   echo "<TR><TD></TD><TD>GASTOS GENERALES Y B.I.".cc_format($GG_BI,'porcentaje0')."</TD><TD align='right'>".cc_format($importe_GG_BI,'moneda')."</TD></TR>" ;
   echo "<TR><TD></TD><TD></TD><TD align='right'>----------------</TD></TR>" ;
   echo "<TR><TD></TD><TD>TOTAL EJECUCION POR CONTRATA</TD><TD align='right'>".cc_format($importe_PEC,'moneda')."</TD>" ;
   echo  $fmt_costes ? "<TD align='right'>".cc_format($importe_COSTE_PEC,'moneda')."</TD>" : "" ;
   echo  $fmt_costes ? "<TD align='right'>".cc_format(1-$importe_COSTE_PEC/($importe_PEC?$importe_PEC:1),'porcentaje')."(margen sin Baja)</TD>" : "" ;
   echo  "</TR>" ;
   echo "<TR><TD></TD><TD>COEFICIENTE DE BAJA $COEF_BAJA</TD><TD align='right'>".cc_format($importe_PEC*$COEF_BAJA,'moneda')."</TD></TR>" ;
   echo "<TR><TD></TD><TD>A DESCONTAR CERTIFICACIONES ANTERIORES</TD><TD align='right'>".cc_format($A_DEDUCIR,'moneda')."</TD></TR>" ;
   echo "<TR><TD></TD><TD></TD><TD align='right'>----------------</TD></TR>" ;
   echo "<TR><TD></TD><TD>SUMA</TD><TD align='right'>".cc_format($importe_deducido,'moneda')."</TD>" ;
   echo  $fmt_costes ? "<TD align='right'>".cc_format($importe_COSTE_PEC,'moneda')."</TD>" : "" ;
   echo  $fmt_costes ? "<TD align='right'><b>".cc_format(1-$importe_COSTE_PEC/($importe_PEC_BAJA?$importe_PEC_BAJA:1),'porcentaje')."(margen)</b></TD>" : "" ;
   echo  "</TR>" ;

   echo "<TR><TD></TD><TD>I.V.A.  ".cc_format($iva_obra,'porcentaje0')."</TD><TD align='right'>".cc_format($importe_IVA,'moneda')."</TD>" ;
    echo  $fmt_costes ? "<TD align='right'>".cc_format($importe_COSTE_PEC*$iva_obra,'moneda')."</TD>" : "" ;
   echo  "</TR>" ;

   echo "<TR><TD></TD><TD></TD><TD align='right'>----------------</TD></TR>" ;
   echo "<TR><TD></TD><TD>IMPORTE TOTAL</TD><TD align='right'><b>".cc_format($importe_TOTAL,'moneda')."</b></TD>" ;
    echo  $fmt_costes ? "<TD align='right'>".cc_format($importe_COSTE_PEC+round($importe_COSTE_PEC*$iva_obra,2),'moneda')."</TD>" : "" ;
   echo  $fmt_costes ? "<TD align='right'>".cc_format($importe_TOTAL/($IMPORTE_contrato_iva?$IMPORTE_contrato_iva:1),'porcentaje')."(s/contrato)</TD>" : "" ;
    
    echo  "</TR>" ;
 
   echo "</TABLE>" ;

   echo "<br>" ;
   
//   echo "<h6><small>$importe_TOTAL_letra</small></h6>" ;
   echo "<h6>$importe_TOTAL_letra</h6>" ;

   echo "<br>" ;
   
   setlocale(LC_TIME, "es_ES");
   
//   echo "<h6>Málaga, a ".cc_format($F_certificacion,'fecha_es_semana')."</h6>" ; 
    $municipio= Dfirst("Municipio", "C_COSTES",$where_c_coste ) ;
   $fecha_txt= $F_certificacion ? utf8_encode(strftime( '%A %e de %B de %Y' , strtotime($F_certificacion) )) : " fecha de la firma electrónica" ;
    
   echo "<h6>$municipio, a ".$fecha_txt."</h6>" ; 
   
//   echo "<br><br>" ;
   
   echo "<textarea  rows=20 cols=120>$Pie_CERTIFCACION</textarea>" ;
   echo "<br><br><br>" ;

   
   
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
     
function add_capitulo(id_obra) {
    var nuevo_valor=window.prompt("Capítulo nuevo " );
//    alert("el nuevo valor es: "+valor) ;
   if (!(nuevo_valor === null || nuevo_valor === ""))
   { 
       
       var xhttp = new XMLHttpRequest();
     xhttp.onreadystatechange = function() {
    if (this.readyState == 4 && this.status == 200) {
        if (this.responseText.substr(0,5)=="ERROR")
        { alert(this.responseText) ;}
        else
        { // alert(this.responseText) ;     //debug
            location.reload(true); }  // refresco la pantalla con el n uevo caoítulo creado
      }
  };
  xhttp.open("GET", "../obras/add_capitulo_ajax.php?id_obra="+id_obra+"&capitulo="+nuevo_valor, true);
  xhttp.send();   
   }
   else
   {return;}
   
}
function add_udo(id_obra) {
    var nuevo_valor=window.prompt("La UDO se asignará al primer capítulo. \n Descripción de Unidad de obra: " );
//    alert("el nuevo valor es: "+valor) ;
   if (!(nuevo_valor === null || nuevo_valor === ""))
   { 
       
       var xhttp = new XMLHttpRequest();
     xhttp.onreadystatechange = function() {
    if (this.readyState == 4 && this.status == 200) {
        if (this.responseText.substr(0,5)=="ERROR")
        { alert(this.responseText) ;}
        else
        { //alert(this.responseText) ;     //debug
          location.reload(true); }  // refresco la pantalla con el n uevo capítulo creado
      }
  };
  xhttp.open("GET", "../obras/add_udo_ajax.php?id_obra="+id_obra+"&udo="+nuevo_valor, true);
  xhttp.send();   
   }
   else
   {return;}
   
}

     
function eval_coste_tabla(id_udo, elementId) {
    
    //var valor0 = valor0_encode;
    //var valor0 = JSON.parse(valor0_encode);
//    var medicion=window.prompt("Medicion "+prompt , '0.00');
//    alert("el nuevo valor es: "+valor) ;
//   alert(id_udo) ;
//   alert(elementId) ;
//   var id_personal=document.getElementById("id_personal").value ;
//   var sql="INSERT INTO PRODUCCIONES_DETALLE (ID_UDO,ID_PRODUCCION,Fecha,MEDICION ) VALUES ('"+ id_udo +"','"+ id_produccion +"' ,'2018-01-01','"+ medicion +"' )"    ;   
//   alert('hola') ;
    var xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function() {
    if (this.readyState == 4 && this.status == 200) {
//        if (this.responseText.substr(0,5)=="ERROR")  //match
        if (this.responseText.match(/ERROR/i))  //match
        { alert('ERROR'+this.responseText) ;}                                        // hay un error y lo muestro en pantalla
        else
        { //document.getElementById(pcont).innerHTML = this.responseText ;   // "pinto" en la pantalla el campo devuelto por la BBDD tras el Update
//            alert(this.responseText) ;   //debug
//              location.reload(true);  // refresco la pantalla tras edición
//           document.getElementById(id_textarea).innerHTML=this.responseText;
//           alert(elementId) ;
//           alert(document.getElementById(elementId).innerHTML) ;  
            document.getElementById(elementId).innerHTML = this.responseText ;
            document.getElementById(elementId).value = this.responseText ;
           
        }
      //document.getElementById("sugerir_obra").innerHTML = this.responseText;
      
    }
    }
     xhttp.open("GET", "../obras/udo_eval_coste_ajax.php?id_udo="+id_udo, true);
     xhttp.send();   
    
    
    return ;
 }

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

  xhttp.open("GET", "../include/delete_row_ajax.php?tabla=PRODUCCIONES_DETALLE&wherecond=id IN " + table_selection_IN() , true);
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
//    alert(table_selection_IN()) ;
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

//  xhttp.open("GET", "../include/tabla_delete_row_ajax.php?tabla=PRODUCCIONES_DETALLE&wherecond=ID_PRODUCCION=" + id_produccion +" AND ID_UDO IN " + table_selection_IN() , true);
  xhttp.open("GET", "../include/delete_row_ajax.php?tabla=PRODUCCIONES_DETALLE&wherecond=ID_PRODUCCION=" + id_produccion +" AND ID_UDO IN " + table_selection_IN() , true);
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
	
                <!--</div>-->
                
  <br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br>
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

