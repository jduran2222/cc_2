<?php
// cambios
require_once("../include/session.php");
$where_c_coste = " id_c_coste={$_SESSION['id_c_coste']} ";
$id_c_coste = $_SESSION['id_c_coste'];

$titulo = 'Fotos obra';

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

//$id_obra=$_GET["id_obra"];

//require_once("../menu/menu_migas.php");

$listado_global= (!isset($_GET["id_obra"])) ;        // SIEMPRE HAY LISTADO GLOBAL  (por ahora)


if (!$listado_global)   // no es LISTADO GLOBAL
{    
 $id_obra=$_GET["id_obra"];

// require("../menu/topbar.php");
 require_once("../obras/obras_menutop_r.php");

} 



$iniciar_form=(!isset($_POST["agrupar"])) ;  // determinamos si debemos de inicializar el FORM con valores vacíos

if ($iniciar_form)    
    {
        $tipo_entidad="obra_foto" ;
        $nombre_obra="" ;
        $documento="" ;
        $observaciones="" ;
        $fecha1="" ;  
        $fecha2="" ;  
        $tamano1="" ;
        $tamano2="" ;
        $agrupar = 'ultimos_docs' ;  
        
        
    }
    else
    {
        
        $nombre_obra=$_POST["nombre_obra"] ;
        $documento=$_POST["documento"] ;
        $observaciones=$_POST["observaciones"] ;
        $fecha1=$_POST["fecha1"] ;  
        $fecha2=$_POST["fecha2"] ;  
        $tamano1=$_POST["tamano1"] ;
        $tamano2=$_POST["tamano2"] ;
//        $conciliada=$_POST["conciliada"] ;
//        $fallo=$_POST["fallo"] ;
        $agrupar =$_POST["agrupar"] ;     
    }   
  


  ?>

<div style="overflow:visible">	   
 
<!--<div id="main" class="mainc_70" style="background-color:#fff">-->

<?php 

//function iif($exp, $true, $false)
//{
//    return $exp ? $true : $false ;
//}        
//

    echo "<h1>FOTOS DE OBRA</h1>"  ;
    $get_id_obra= $listado_global ? '' : "?id_obra=$id_obra"  ;

//    echo "<form action='../obras/obras_fotos.php".  iif($listado_global, "?id_obra=$id_obra", '')  ."' method='post' id='form1' name='form1'>"    ;
    echo "<form action='../obras/obras_fotos.php". ( !$listado_global ?  "?id_obra=$id_obra" : '' ) ."' method='post' id='form1' name='form1'>"    ;
    
    echo "<TABLE align='center' width='50%'>"  ;
   
//    echo "<TR><TD>Documento</TD><TD><INPUT type='text' id='documento' name='documento' value='$documento'><button type='button' onclick=\"document.getElementById('documento').value='' \" >*</button></TD></TR>" ;
//    echo "<TR><TD>OBRA       </TD><TD><INPUT type='text' id='N_OBRA' name='N_OBRA' value='$N_OBRA'><button type='button' onclick=\"document.getElementById('N_OBRA').value='' \" >*</button></TD></TR>" ;
//    echo "<a class='btn btn-primary' href= 'facturas_proveedores.php' >Facturas prov. global</a><br>" ;
     

//echo "<TR><TD>Tipo entidad   </TD><TD><INPUT type='text' id='tipo_entidad'   name='tipo_entidad'  value='$tipo_entidad'><button type='button' onclick=\"document.getElementById('tipo_entidad').value='' \" >*</button></TD></TR>" ;
echo "<TR><TD>Obra   </TD><TD><INPUT type='". ($listado_global? 'hidden' : 'text' ) ."' id='nombre_obra'   name='nombre_obra'  value='$nombre_obra'><button type='button' onclick=\"document.getElementById('nombre_obra').value='' \" >*</button></TD></TR>" ;
echo "<TR><TD>documento   </TD><TD><INPUT type='text' id='documento'   name='documento'  value='$documento'><button type='button' onclick=\"document.getElementById('documento').value='' \" >*</button></TD></TR>" ;
echo "<TR><TD>Fecha mín.     </TD><TD><INPUT type='date' id='fecha1'     name='fecha1'    value='$fecha1'><button type='button' onclick=\"document.getElementById('fecha1').value='' \" >*</button></TD></TR>" ;
echo "<TR><TD>Fecha máx.     </TD><TD><INPUT type='date' id='fecha2'     name='fecha2'    value='$fecha2'><button type='button' onclick=\"document.getElementById('fecha2').value='' \" >*</button></TD></TR>" ;
echo "<TR><TD>Tamaño min (kb)    </TD><TD><INPUT type='text' id='tamano1'     name='tamano1'    value='$tamano1'><button type='button' onclick=\"document.getElementById('tamano1').value='' \" >*</button></TD></TR>" ;
echo "<TR><TD>Tamaño máx (kb)    </TD><TD><INPUT type='text' id='tamano2'     name='tamano2'    value='$tamano2'><button type='button' onclick=\"document.getElementById('tamano2').value='' \" >*</button></TD></TR>" ;
echo "<TR><TD>observaciones   </TD><TD><INPUT type='text' id='observaciones'   name='observaciones'  value='$observaciones'><button type='button' onclick=\"document.getElementById('observaciones').value='' \" >*</button></TD></TR>" ;

//$radio=$fallo ;
//$chk_todos =  ""  ; $chk_on =  ""  ; $chk_off =  ""  ;
//if ($radio=="") { $chk_todos =   "checked"  ;} elseif ($radio==1) { $chk_on =   "checked"  ;} elseif ($radio==0)  { $chk_off =   "checked"  ;}
//echo "<TR><TD></td><td> <input type='radio' id='fallo' name='fallo' value='' $chk_todos />Todos    <input type='radio' id='fallo' name='fallo' value='1'  $chk_on />con fallo  <input type='radio' id='fallo' name='fallo' value='0' $chk_off  />sin fallo </TD></TR>" ;



//echo "<TR><TD>Conciliada </TD><TD><INPUT type='text' id='conciliada' name='conciliada' value='$conciliada'><button type='button' onclick=\"document.getElementById('conciliada').value='' \" >*</button></TD></TR>" ;
//echo "<TR><TD>Pagada    </TD><TD><INPUT type='checkbox' id='pagada'    name='pagada'   value='$pagada'></TD></TR>" ;

//echo "<TR><TD></td><td><input type='radio' id='conciliada' name='conciliada' value='' checked />Todas      <input type='radio' id='conciliada' name='conciliada' value='1' />Conciliadas     <input type='radio' id='conciliada' name='conciliada' value='0' />No Conciliadas</TD></TR>" ;
//echo "<TR><TD></td><td> <input type='radio' id='pagada' name='pagada' value='' checked />Todas    <input type='radio' id='pagada' name='pagada' value='1' />Pagadas  <input type='radio' id='pagada' name='pagada' value='0' />No Pagadas </TD></TR>" ;


echo "<TR><TD colspan=2 align=center><INPUT type='submit' class='btn btn-success btn-xl' value='Actualizar' id='submit' name='submit'></TD></TR>" ;

echo "</TABLE>"  ;

?>




<!--<button class='btn btn-info btn-sm'  onclick="getElementById('agrupar').value = 'ultimos_docs'; document.getElementById('form1').submit();">ultimas fotos</button>
<button class='btn btn-info btn-sm'  onclick="getElementById('agrupar').value = 'documentos'; document.getElementById('form1').submit();">fotos</button>
<button class='btn btn-info btn-sm'  onclick="getElementById('agrupar').value = 'cuadros'; document.getElementById('form1').submit();">cuadros</button>
<button class='btn btn-info btn-sm'  onclick="getElementById('agrupar').value = 'tipo_entidad'; document.getElementById('form1').submit();">tipo_entidad</button>
<button class='btn btn-info btn-sm'  onclick="getElementById('agrupar').value = 'dias'; document.getElementById('form1').submit();">dias</button>
<button class='btn btn-info btn-sm'  onclick="getElementById('agrupar').value = 'meses'; document.getElementById('form1').submit();">meses</button>-->

<input type="hidden"  id="agrupar"  name="agrupar" value='<?php echo $agrupar ; ?>'>


<?php     //  TAB-BUTTONS

$style_hidden_if_global=$listado_global? " disabled " : ""  ; 

echo "<div id='myDIV' class='noprint' style='margin-top: 25px; padding:10px'>" ; 


$btnt['ultimos_docs']=["<i class='fas fa-list'></i> ultimas fotos",'', ''] ;
$btnt['documentos']=["<i class='fas fa-list'></i> lista",'',''] ;
$btnt['cuadros']=["<i class='fas fa-th'></i> cuadros",'',''] ;
//$btnt['cuadros2']=["<span class='glyphicon glyphicon-th-large'></span> cuadros",'',''] ;  // anulamos cuadros2 (fotos más grandes)
$btnt['obras']=['obras','',''] ;
$btnt['dias']=["<i class='far fa-calendar-alt'></i> dias",'',''] ;
$btnt['meses']=['meses','',''] ;
$btnt['annos']=['años','',''] ;
//$btnt['detalle']=['detalle','Muestra las Producción con cada detalle de Medición',''] ;
//$btnt['subobras']=['subobras','Agrupa por subobras',''] ;
//$btnt['costes']=['costes','', $style_hidden_if_global] ;
//$btnt['obras']=['obras','Agrupa por Obra',''] ;
//$btnt['meses']=['meses','',''] ;
//$btnt['fechas']=['fechas','',''] ;
//$btnt['comparadas']=['comparadas','',''] ;
//$btnt['EDICION']=['MODO EDICION','' ,$style_hidden_if_global ] ;

foreach ( $btnt as $clave => $valor)
{
  $active= ($clave==$agrupar) ? " cc_active" : "" ; 
  $disabled= $valor[2]  ;
  echo "<button $disabled id='btn_agrupar_$clave' class='cc_btnt$active' title='{$valor[1]}' onclick=\"getElementById('agrupar').value = '$clave'; document.getElementById('form1').submit(); \">{$valor[0]}</button>" ;  
}           
  
echo '</div>' ;

?>




</form>
<div id="main" class="mainc_70" style="background-color:#fff">
    
    
<?php   // Iniciamos variables para tabla.php  background-color:#B4045


//$FECHA1= date_replace($FECHA1) ;
//$FECHA2= date_replace($FECHA2) ;
$where=$where_c_coste;

  

//$where=$tipo_entidad==""? $where : $where . " AND tipo_entidad LIKE '%".str_replace(" ","%",trim($tipo_entidad))."%'" ;
$where=$where . " AND tipo_entidad='obra_foto' AND ". ($listado_global? "NOMBRE_OBRA LIKE '%$nombre_obra%' " : "id_entidad=$id_obra" ) ;

$where=$fecha1==""? $where : $where . " AND fecha_creacion >= '$fecha1' " ;
$where=$fecha2==""? $where : $where . " AND fecha_creacion <= '$fecha2' " ;
$where=$tamano1==""? $where : $where . " AND tamano/1000 > $tamano1" ;
$where=$tamano2==""? $where : $where . " AND tamano/1000 < $tamano2" ;
//$where=$conciliada==""? $where : $where . " AND conc=$conciliada " ;
//$where=$fallo==""? $where : $where . " AND fallo=$fallo " ;
$where=$observaciones==""? $where : $where . " AND Observaciones LIKE '%".str_replace(" ","%",trim($observaciones))."%'" ;
$where=$documento==""? $where : $where . " AND documento LIKE '%".str_replace(" ","%",trim($documento))."%'" ;
//$where=$FECHA2==""? $where : $where . " AND FECHA <= STR_TO_DATE('$FECHA2','%Y-%m-%d') " ;

$tabla_group=0 ;
$tabla_cuadros=0 ;

$fecha=date('Y-m-d'); 

echo  "<div >"
              . " <a class='btn btn-link btn-xs' href='#'  onclick=\"add_fotos( '$id_obra' , '$fecha' ) \" >"
             . "<i class='fas fa-plus-circle'></i> Añadir Fotos <span class='glyphicon glyphicon-camera'></span></a>" 
            . "  </div>   " ;


 switch ($agrupar) {
    case "ultimos_docs":
     $sql="SELECT id_documento,id_entidad, path_archivo,".($listado_global? "NOMBRE_OBRA, " : "" ) ."fecha_doc,tamano,documento,Observaciones,user FROM Documentos_fotos WHERE $where  ORDER BY Fecha_Creacion DESC LIMIT 200 " ;
     $sql_T="SELECT '' " ;
    break;
    case "documentos":
     $sql="SELECT id_documento,id_entidad, path_archivo,".($listado_global? "NOMBRE_OBRA, " : "" ) ." fecha_doc,tamano,documento,Observaciones,user FROM Documentos_fotos WHERE $where  ORDER BY fecha_doc  " ;
     $sql_T="SELECT 'Totales' AS a,'' AS c,'' AS d,COUNT(id_documento) ,SUM(tamano) AS tamano  FROM Documentos_fotos WHERE $where  " ;   
     //$sql_T="SELECT '','Suma' , SUM(IMPORTE) as tamano  FROM ConsultaGastos_View WHERE $where    " ;
    break;
    case "cuadros":
     $sql="SELECT id_documento,id_entidad,  path_archivo,".($listado_global? "NOMBRE_OBRA, " : "" ) ." fecha_doc,tamano,documento,Observaciones,user FROM Documentos_fotos WHERE $where  ORDER BY fecha_doc DESC  " ;
     $sql_T="SELECT 'Totales' AS a,'' AS c,'' AS d,COUNT(id_documento) ,SUM(tamano) AS tamano  FROM Documentos_fotos WHERE $where  " ;   
     //$sql_T="SELECT '','Suma' , SUM(IMPORTE) as tamano  FROM ConsultaGastos_View WHERE $where    " ;
     $tabla_cuadros=1;   
    break;
    case "cuadros2":
     $sql="SELECT id_documento,id_entidad,  path_archivo,".($listado_global? "NOMBRE_OBRA, " : "" ) ." fecha_doc,tamano,documento,Observaciones,user FROM Documentos_fotos WHERE $where  ORDER BY fecha_doc DESC " ;
     $sql_T="SELECT 'Totales' AS a,'' AS c,'' AS d,COUNT(id_documento) ,SUM(tamano) AS tamano  FROM Documentos_fotos WHERE $where  " ;   
     //$sql_T="SELECT '','Suma' , SUM(IMPORTE) as tamano  FROM ConsultaGastos_View WHERE $where    " ;
     $tabla_cuadros=1;   
    break;

    case "obras":
     $sql="SELECT id_entidad,id_documento, ".($listado_global? "NOMBRE_OBRA, " : "" ) ." COUNT(id_documento) AS fotos, SUM(tamano) AS tamano FROM Documentos_fotos WHERE $where GROUP BY id_entidad  ORDER BY NOMBRE_OBRA  " ;
     $sql_T="SELECT 'Totales' AS a,COUNT(id_documento) ,SUM(tamano) AS tamano  FROM Documentos_fotos WHERE $where  " ;   
     //$sql_T="SELECT '','Suma' , SUM(IMPORTE) as tamano  FROM ConsultaGastos_View WHERE $where    " ;
    break;


    case "dias":
     $sql="SELECT fecha_doc,COUNT(id_documento) as Fotos,id_documento,SUM(tamano) as tamano FROM Documentos_fotos WHERE $where GROUP BY fecha_doc ORDER BY fecha_doc " ;
     $sql_T="SELECT 'Totales' AS a,COUNT(id_documento) as Fotos ,SUM(tamano) AS tamano  FROM Documentos_fotos WHERE $where  " ;   
     //$sql_T="SELECT '','Suma' , SUM(IMPORTE) as tamano  FROM ConsultaGastos_View WHERE $where    " ;
    break;
    case "meses":
     $sql="SELECT DATE_FORMAT(fecha_doc, '%Y-%m') as MES,COUNT(id_documento) as Fotos,id_documento,SUM(tamano) as tamano FROM Documentos_fotos WHERE $where  GROUP BY MES  ORDER BY MES " ;
     $sql_T="SELECT 'Totales' AS a,COUNT(id_documento) as Fotos ,SUM(tamano) AS tamano  FROM Documentos_fotos WHERE $where  " ;   
     //$sql_T="SELECT '','Suma' , SUM(IMPORTE) as tamano  FROM ConsultaGastos_View WHERE $where    " ;
    break;
//    case "tipo_entidad":
//     $sql="SELECT id_entidad, id_documento, tipo_entidad ,COUNT(id_documento) as Num_docs,SUM(tamano) AS tamano ,'' as id_entidad_link FROM Documentos_fotos WHERE $where GROUP BY tipo_entidad  ORDER BY tipo_entidad " ;
//     $sql_T="SELECT 'Totales' AS a,COUNT(id_documento) ,SUM(tamano) AS tamano  FROM Documentos_fotos WHERE $where  " ;   
//     break;
//    case "meses":
//    $sql="SELECT  DATE_FORMAT(FECHA, '%Y-%m') as MES,SUM(Base_Imponible) AS Base_Imponible,SUM(IMPORTE_IVA) as IMPORTE_IVA,SUM(pdte_conciliar) AS pdte_conciliar  FROM Fras_Prov_View WHERE $where  GROUP BY MES  ORDER BY MES  " ;
//    $sql_T="SELECT 'Totales' AS D,SUM(Base_Imponible) AS Base_Imponible, SUM(IMPORTE_IVA) as IMPORTE_IVA,SUM(pdte_conciliar) AS pdte_conciliar  FROM Fras_Prov_View WHERE $where   " ;
//    break;
    case "annos":
     $sql="SELECT YEAR(fecha_doc) as ANNO,COUNT(id_documento) as Fotos,id_documento,SUM(tamano) as tamano FROM Documentos_fotos WHERE $where  GROUP BY YEAR(fecha_doc)  ORDER BY YEAR(fecha_doc) " ;
     $sql_T="SELECT 'Totales' AS a,COUNT(id_documento) as Fotos ,SUM(tamano) AS tamano  FROM Documentos_fotos WHERE $where  " ;   
    break;
   
  
 }

 
 
//echo "pagada es $pagada"  ;
//echo $sql ;
$result=$Conn->query($sql) ;
$result_T=$Conn->query($sql_T) ;

// AÑADE BOTON DE 'BORRAR' PARTE . SOLO BORRARÁ SI ESTÁ VACÍO DE PERSONAL 
 $updates=[ 'documento',  'Observaciones']  ;
 $tabla_update="Documentos" ;
 $id_update="id_documento" ;
 $actions_row=[];
 $actions_row["id"]="id_documento";
 $actions_row["delete_link"]="1";
    

$href="../documentos/documento_ficha.php?id_documento=_VAR_ID_" ;
$actions_row["onclick1_link"]="<a class='btn btn-link'  onclick=\"js_href2( '$href' ,0 )\"   title='abre ficha de la foto'><i class='far fa-calendar-alt'></i></a> " ;   // abre ficha doc.
//$onclick_VAR_TABLA1_="id_documento" ;  // variable a pasar

    // boton para poder ROTAR 90º la foto
$href_270="../documentos/doc_rotar_ajax.php?grados=270&id_documento=_VAR_ID_" ;
$actions_row["onclick2_link"]="<a class='btn btn-link' href=# onclick=\"js_href( '$href_270' ,0 )\"   title='rotar la foto -90º'><i class='fas fa-undo'></i></a> " ;   // acción de rotar
//$onclick_VAR_TABLA2_="id_documento" ;  // variable a pasar

//echo   "<a class='btn btn-primary' href='../proveedores/factura_proveedor_anadir.php' target='_blank' >Factura nueva</a>" ; // BOTON AÑADIR FACTURA
//echo   "<a class='btn btn-primary' href='#' onclick=\"genera_remesa()\" title='Genera remesa con las facturas seleccionadas' >Generar Remesa</a>" ; // BOTON AÑADIR FACTURA

 //  CREAMOS EL LINK PARA CADA TIPO DE ENTIDAD (FRA_PROV. PROVEEDOR, OBRA...)

  
    
//echo "<a class='btn btn-primary' href='../documentos/doc_refresh_fallo.php' target='_blank'>Comprobar existencia archivo (fallo)</a><br>"  ;
    
    
echo "<br><font size=2 color=grey>Agrupar por : $agrupar <br> {$result->num_rows} filas </font> " ;


//  



$dblclicks=[];
//$dblclicks[*]= "tipo_entidad" ;

//$links["tipo_entidad"] = ["../include/ficha_entidad.php?", "id_entidad_link", "ver entidad asociada al documento (Factura, albarán, ...)"] ;
$links["documento"] = ["../documentos/documento_ficha.php?id_documento=", "id_documento", "ver ficha documento", 'icon'] ;
//$links["nid_documento"] = ["../documentos/documento_ficha.php?id_documento=", "id_documento", "ver ficha documento", 'ppal'] ;
$links["path_archivo"] = ["../documentos/documento_ficha.php?id_documento=", "id_documento", "ver ficha documento", 'ppal'] ;
//$links["N_FRA"] = ["../proveedores/factura_proveedor.php?id_fra_prov=", "ID_FRA_PROV","ver factura"] ;
//$links["Nid_fra_prov"] = ["../proveedores/factura_proveedor.php?id_fra_prov=", "ID_FRA_PROV","ver factura"] ;
$links["NOMBRE_OBRA"]=["../obras/obras_ficha.php?id_obra=", "id_entidad"] ;

//$formats["Observaciones"] = "textarea" ;
$formats["tamano"] = "kb" ;
$formats["path_archivo"] = "pdf_200_500" ;
//$formats["iva"] = "porcentaje0" ;
//$formats["IMPORTE_IVA"] = "moneda" ;
//$formats["pdte_conciliar"] = "moneda" ;
//$formats["ingreso_conc"] = "moneda" ;
//$formats["ingreso"] = "moneda" ;
//$formats["FECHA"] = "dbfecha" ;
//$formats["conc"] = "boolean" ;
//$formats["PDF"] = "boolean" ;
$formats["fallo"] = "boolean" ;
//$formats["cobrada"] = "boolean" ;
$aligns["Fotos"] = "center" ;
//$tooltips["conc"] = "Indica si la factura está conciliado con Vales o Albaranos de proveedor" ;
//$tooltips["pagada"] = "Indica la factura tiene emitido documento de pago" ;


$titulo="";
$msg_tabla_vacia="No hay.";


if ($tabla_group)
{ require("../include/tabla_group.php"); }
elseif ($tabla_cuadros)
{ 
    $formats["path_archivo"] = ($agrupar=='cuadros2')? "pdf_350" : "pdf_250"  ;
    $div_size_width = substr($formats["path_archivo"], 4) + 20 ;                        // pixeles de ancho que queremos para el cuadro
    $div_size_height = $div_size_width  ;                        // pixeles de ancho que queremos para el cuadro
//     $actions_row=[];
//    $formats["path_archivo"] = 'textarea_10' ;
    require("../include/tabla_cuadros.php"); }    
else
{ require("../include/tabla.php"); echo $TABLE ; }
 

?>

</div>

<!--************ FIN  *************  -->
	
	

<?php  

$Conn->close();

?>
	 

</div>

<div style="background-color:#f1f1f1;text-align:center;padding:10px;margin-top:7px;font-size:30px;">
</div>
</div>
	
<script>

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
               
       
                </div>
     <br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br>
                <!--****************** BUSQUEDA GLOBAL  *****************
            </div>
        </div>
        <!-- FIN Contenido principal -->

<?php 

//FIN
include_once('../templates/_inc_privado3_footer.php');
