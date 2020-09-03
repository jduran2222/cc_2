<?php
// cambios
require_once("../include/session.php");
$where_c_coste = " id_c_coste={$_SESSION['id_c_coste']} ";
$id_c_coste = $_SESSION['id_c_coste'];

$titulo = 'Documentos';

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

$iniciar_form=(!isset($_POST["agrupar"])) ;  // determinamos si debemos de inicializar el FORM con valores vacíos

if ($iniciar_form)    
    {
        $id_documento="" ;
        $tipo_entidad="" ;
        $id_entidad="" ;
        $documento="" ;
        $nombre_archivo="" ;
        $path_archivo="" ;
        $observaciones="" ;
        $metadatos="" ;
        $fecha1="" ;  
        $fecha2="" ;  
        $MES="" ;  
        $Anno="" ;  
        $tamano1="" ;
        $tamano2="" ;
        $conciliada="" ;
        $fallo="" ;
        $agrupar = 'ultimos_docs' ;  
        
        // vemos si realmente queriamos ir a Clasificar los docs pdte_clasificar
        $clasificar=isset($_GET["clasificar"])  ;
        if ($clasificar)
         {
            $tipo_entidad="pdte_clasif" ;
            $agrupar = 'ultimos_docs' ;  
         }
        
        
        
    }
    else
    {
        $id_documento=$_POST["id_documento"] ;
        $tipo_entidad=$_POST["tipo_entidad"] ;
        $id_entidad=$_POST["id_entidad"] ;
        $clasificar=($tipo_entidad=="pdte_clasif") ;
        
        $documento=$_POST["documento"] ;
        $nombre_archivo=$_POST["nombre_archivo"] ;
        $path_archivo=$_POST["path_archivo"];
        
        $observaciones=$_POST["observaciones"] ;
        $metadatos=$_POST["metadatos"] ;

        $fecha1=$_POST["fecha1"] ;  
        $fecha2=$_POST["fecha2"] ;  
        
        $MES=$_POST["MES"] ;
//        $Trimestre=$_POST["Trimestre"] ;
        $Anno=$_POST["Anno"] ;
        
        $tamano1=$_POST["tamano1"] ;
        $tamano2=$_POST["tamano2"] ;
//        $conciliada=$_POST["conciliada"] ;
        $fallo=$_POST["fallo"] ;
        $agrupar =$_POST["agrupar"] ;     
    }   
  

// Comprobamos si es el listado de un único proveedor o un listado global

//$listado_global= (!isset($_GET["id_proveedor"])) ;
$listado_global= 1 ;        // SIEMPRE HAY LISTADO GLOBAL  (por ahora)


  ?>

<div style="overflow:visible">	   
 
<!--<div id="main" class="mainc_70" style="background-color:#fff">-->

<?php 

// INICIO DE FORM 
echo "<br><br><br><br>"  ;
echo "<br><a target='_blank' class='btn btn-link noprint'  href='../documentos/doc_upload_multiple_form.php'  ><i class='fas fa-cloud-upload-alt'></i> subir documento</a>" ;

echo "<h1>DOCUMENTOS</h1>"  ;
echo "<form action='../documentos/documentos.php' method='post' id='form1' name='form1'>"    ;    
echo "<TABLE align='center' width='50%'>"  ;
   

echo "<TR><TD>id_documento   </TD><TD><INPUT type='text' id='id_documento'   name='id_documento'  value='$id_documento'><button type='button' onclick=\"document.getElementById('id_documento').value='' \" >*</button></TD></TR>" ;
echo "<TR><TD>Tipo entidad   </TD><TD><INPUT type='text' id='tipo_entidad'   name='tipo_entidad'  value='$tipo_entidad'><button type='button' onclick=\"document.getElementById('tipo_entidad').value='' \" >*</button></TD></TR>" ;
echo "<TR><TD>documento   </TD><TD><INPUT type='text' id='documento'   name='documento'  value='$documento'><button type='button' onclick=\"document.getElementById('documento').value='' \" >*</button></TD></TR>" ;
echo "<TR><TD>nombre_archivo   </TD><TD><INPUT type='text' id='nombre_archivo'   name='nombre_archivo'  value='$nombre_archivo'><button type='button' onclick=\"document.getElementById('nombre_archivo').value='' \" >*</button></TD></TR>" ;
echo "<TR><TD>path_archivo   </TD><TD><INPUT type='text' id='path_archivo'   name='path_archivo'  value='$path_archivo'><button type='button' onclick=\"document.getElementById('path_archivo').value='' \" >*</button></TD></TR>" ;
echo "<TR><TD>Fecha mín.     </TD><TD><INPUT type='date' id='fecha1'     name='fecha1'    value='$fecha1'><button type='button' onclick=\"document.getElementById('fecha1').value='' \" >*</button></TD></TR>" ;
echo "<TR><TD>Fecha máx.     </TD><TD><INPUT type='date' id='fecha2'     name='fecha2'    value='$fecha2'><button type='button' onclick=\"document.getElementById('fecha2').value='' \" >*</button></TD></TR>" ;

echo "<TR><TD>MES     </TD><TD><INPUT type='text' id='MES'     name='MES'    value='$MES'><button type='button' onclick=\"document.getElementById('MES').value='' \" >*</button></TD></TR>" ;
//echo "<TR><TD>Trimestre     </TD><TD><INPUT type='text' id='Trimestre'     name='Trimestre'    value='$Trimestre'><button type='button' onclick=\"document.getElementById('Trimestre').value='' \" >*</button></TD></TR>" ;
echo "<TR><TD>Año     </TD><TD><INPUT type='text' id='Anno'     name='Anno'    value='$Anno'><button type='button' onclick=\"document.getElementById('Anno').value='' \" >*</button></TD></TR>" ;


echo "<TR><TD>Tamaño min (kb)    </TD><TD><INPUT type='text' id='tamano1'     name='tamano1'    value='$tamano1'><button type='button' onclick=\"document.getElementById('tamano1').value='' \" >*</button></TD></TR>" ;
echo "<TR><TD>Tamaño máx (kb)    </TD><TD><INPUT type='text' id='tamano2'     name='tamano2'    value='$tamano2'><button type='button' onclick=\"document.getElementById('tamano2').value='' \" >*</button></TD></TR>" ;
echo "<TR><TD>observaciones   </TD><TD><INPUT type='text' id='observaciones'   name='observaciones'  value='$observaciones'><button type='button' onclick=\"document.getElementById('observaciones').value='' \" >*</button></TD></TR>" ;
echo "<TR><TD>Metadatos   </TD><TD><INPUT type='text' id='metadatos'   name='metadatos'  value='$metadatos'><button type='button' onclick=\"document.getElementById('metadatos').value='' \" >*</button></TD></TR>" ;
echo "<TR><TD>id_entidad   </TD><TD><INPUT type='text' id='id_entidad'   name='v'  value='$id_entidad'><button type='button' onclick=\"document.getElementById('id_entidad').value='' \" >*</button></TD></TR>" ;


$radio=$fallo ;
$chk_todos =  ""  ; $chk_on =  ""  ; $chk_off =  ""  ;
if ($radio=="") { $chk_todos =   "checked"  ;} elseif ($radio==1) { $chk_on =   "checked"  ;} elseif ($radio==0)  { $chk_off =   "checked"  ;}
echo "<TR><TD></td><td> <input type='radio' id='fallo' name='fallo' value='' $chk_todos />Todos    <input type='radio' id='fallo' name='fallo' value='1'  $chk_on />con fallo  <input type='radio' id='fallo' name='fallo' value='0' $chk_off  />sin fallo </TD></TR>" ;



//echo "<TR><TD>Conciliada </TD><TD><INPUT type='text' id='conciliada' name='conciliada' value='$conciliada'><button type='button' onclick=\"document.getElementById('conciliada').value='' \" >*</button></TD></TR>" ;
//echo "<TR><TD>Pagada    </TD><TD><INPUT type='checkbox' id='pagada'    name='pagada'   value='$pagada'></TD></TR>" ;

//echo "<TR><TD></td><td><input type='radio' id='conciliada' name='conciliada' value='' checked />Todas      <input type='radio' id='conciliada' name='conciliada' value='1' />Conciliadas     <input type='radio' id='conciliada' name='conciliada' value='0' />No Conciliadas</TD></TR>" ;
//echo "<TR><TD></td><td> <input type='radio' id='pagada' name='pagada' value='' checked />Todas    <input type='radio' id='pagada' name='pagada' value='1' />Pagadas  <input type='radio' id='pagada' name='pagada' value='0' />No Pagadas </TD></TR>" ;


echo "<TR><TD colspan=2 align=center><INPUT type='submit' class='btn btn-success btn-xl' value='Actualizar' id='submit' name='submit'></TD></TR>" ;

echo "</TABLE>"  ;

?>

<center>
<font size=4 align="left">Agrupar por:<br>

<button class='btn btn-info btn-sm'  onclick="getElementById('agrupar').value = 'ultimos_docs'; document.getElementById('form1').submit();">ultimos_docs</button>
<button class='btn btn-info btn-sm'  onclick="getElementById('agrupar').value = 'documentos'; document.getElementById('form1').submit();">documentos</button>
<button class='btn btn-info btn-sm'  onclick="getElementById('agrupar').value = 'tipo_entidad'; document.getElementById('form1').submit();">tipo_entidad</button>
<button class='btn btn-info btn-sm'  onclick="getElementById('agrupar').value = 'id_entidad'; document.getElementById('form1').submit();">id_entidad</button>
<button class='btn btn-info btn-sm'  onclick="getElementById('agrupar').value = 'meses'; document.getElementById('form1').submit();">meses</button>
<button class='btn btn-info btn-sm'  onclick="getElementById('agrupar').value = 'annos'; document.getElementById('form1').submit();">años</button>

<input type="hidden"  id="agrupar"  name="agrupar" value='<?php echo $agrupar ; ?>'>

</font>

</center>
</form>
<div id="main" class="mainc_100" style="background-color:#fff">
    
    
<?php   // Iniciamos variables para tabla.php  background-color:#B4045


//$FECHA1= date_replace($FECHA1) ;
//$FECHA2= date_replace($FECHA2) ; 

$where = isset($_GET["admin"])? "1=1" : $where_c_coste;   // si definimos admin vemos todos los documentos de todas las empresas

if ($listado_global)                // Estamos en pantalla de LISTADO GLOBAL (toda la empresa no solo en un proveedor concreto)
{    
// adaptamos todos los filtros, quitando espacios a ambos lados con trim() y sustituyendo espacios por '%' para el LIKE 
//$where=$proveedor==""? $where : $where . " AND filtro LIKE '%".str_replace(" ","%",trim($_POST["proveedor"]))."%'" ;
}
else
{
//$where= $where . " AND ID_PROVEEDORES=$id_proveedor " ;    // Estamos en gastos de una Obra o Maquinaria específica
}    

$where=$id_documento==""? $where : $where . " AND id_documento=$id_documento " ;
$where=$tipo_entidad==""? $where : $where . " AND tipo_entidad LIKE '%".str_replace(" ","%",trim($tipo_entidad))."%'" ;
$where=$id_entidad==""? $where : $where . " AND id_entidad=$id_entidad" ;
$where=$fecha1==""? $where : $where . " AND fecha_creacion >= '$fecha1' " ;
$where=$fecha2==""? $where : $where . " AND fecha_creacion <= '$fecha2' " ;
$where=$tamano1==""? $where : $where . " AND tamano/1000 > $tamano1" ;
$where=$tamano2==""? $where : $where . " AND tamano/1000 < $tamano2" ;
//$where=$conciliada==""? $where : $where . " AND conc=$conciliada " ;
$where=$fallo==""? $where : $where . " AND fallo=$fallo " ;
$where=$observaciones==""? $where : $where . " AND Observaciones LIKE '%".str_replace(" ","%",trim($observaciones))."%'" ;
$where=$documento==""? $where : $where . " AND documento LIKE '%".str_replace(" ","%",trim($documento))."%'" ;
$where=$nombre_archivo==""? $where : $where . " AND nombre_archivo LIKE '%".str_replace(" ","%",trim($nombre_archivo))."%'" ;
$where=$path_archivo==""? $where : $where . " AND path_archivo LIKE '%".str_replace(" ","%",trim($path_archivo))."%'" ;
$where=$metadatos==""? $where : $where . " AND metadatos LIKE '%".str_replace(" ","%",trim($metadatos))."%'" ;

$where=$MES==""? $where : $where . " AND DATE_FORMAT(fecha_creacion, '%Y-%m') = '$MES' " ;
//$where=$Trimestre==""? $where : $where . " AND $select_trimestre = '$Trimestre' " ;
$where=$Anno==""? $where : $where . " AND YEAR(fecha_creacion) = '$Anno' " ;

//$where=$FECHA2==""? $where : $where . " AND fecha_creacion <= STR_TO_DATE('$FECHA2','%Y-%m-%d') " ;

$agrupados=0 ;             // para indicar si cada línea es un documentos susceptible de ser deleted o es una agupacion


 switch ($agrupar) {
    case "ultimos_docs":
     $sql="SELECT id_documento,id_documento as nid_documento,path_archivo,tipo_entidad, fecha_doc,id_entidad,tamano,nombre_archivo,fallo,documento,Observaciones  "
            . ",CONCAT('tipo_entidad=',tipo_entidad,'&id_entidad=',id_entidad) as id_entidad_link,user, fecha_creacion FROM Documentos WHERE $where  ORDER BY Fecha_Creacion DESC LIMIT 100 " ;
     $sql_T="SELECT '' " ;
     $col_sel="id_documento" ;
    break;
    case "documentos":
     $sql="SELECT id_documento,id_documento as nid_documento,path_archivo,tipo_entidad, fecha_doc,id_entidad,tamano,nombre_archivo,fallo,documento,Observaciones, "
            . "CONCAT('tipo_entidad=',tipo_entidad,'&id_entidad=',id_entidad) as id_entidad_link,user,fecha_creacion FROM Documentos WHERE $where  ORDER BY tipo_entidad DESC " ;
     $sql_T="SELECT 'Totales' AS a,'' AS c,'' AS c1,'' AS d,COUNT(id_documento) as Num_docs ,SUM(tamano) AS tamano  FROM Documentos WHERE $where  " ;   
     $col_sel="id_documento" ;
    break;
    case "tipo_entidad":
     $sql="SELECT  tipo_entidad ,COUNT(id_documento) as Num_docs,SUM(tamano) AS tamano,SUM(tamano)/COUNT(id_documento) as tamano_medio ,'' as id_entidad_link "
            . " FROM Documentos  WHERE $where GROUP BY tipo_entidad  ORDER BY tipo_entidad " ;
     $sql_T="SELECT 'Totales' AS a,COUNT(id_documento) as Num_docs,SUM(tamano) AS tamano  FROM Documentos WHERE $where  " ;   
    $agrupados=1 ;
     break;
    case "id_entidad":
     $sql="SELECT  id_entidad as identif_entidad ,COUNT(id_documento) as Num_docs,SUM(tamano) AS tamano,SUM(tamano)/COUNT(id_documento) as tamano_medio ,'' as id_entidad_link "
            . " FROM Documentos  WHERE $where GROUP BY id_entidad  ORDER BY id_entidad " ;
     $sql_T="SELECT 'Totales' AS a,COUNT(id_documento) as Num_docs,SUM(tamano) AS tamano  FROM Documentos WHERE $where  " ;   
    $agrupados=1 ;
     break;
    case "meses":
    $sql="SELECT  DATE_FORMAT(fecha_creacion, '%Y-%m') as MES,COUNT(id_documento) as Num_docs,SUM(tamano) AS tamano,SUM(tamano)/COUNT(id_documento) as tamano_medio "
            . " FROM Documentos WHERE $where  GROUP BY MES  ORDER BY MES  " ;
    $sql_T="SELECT 'Totales' AS D,COUNT(id_documento) as Num_docs ,SUM(tamano) AS tamano  FROM Documentos WHERE $where   " ;
    $agrupados=1 ;
     break;
    case "annos":
    $sql="SELECT  DATE_FORMAT(fecha_creacion, '%Y') as anno,COUNT(id_documento) as Num_docs,SUM(tamano) AS tamano,SUM(tamano)/COUNT(id_documento) as tamano_medio "
            . " FROM Documentos WHERE $where  GROUP BY anno  ORDER BY anno  " ;
    $sql_T="SELECT 'Totales' AS D,COUNT(id_documento) as Num_docs ,SUM(tamano) AS tamano  FROM Documentos WHERE $where  " ;
    $agrupados=1 ;
     break;
   
  
 }

 
 
//echo "pagada es $pagada"  ;
//echo $sql ;
$result=$Conn->query($sql) ;
$result_T=$Conn->query($sql_T) ;

// AÑADE BOTON DE 'BORRAR' PARTE . SOLO BORRARÁ SI ESTÁ VACÍO DE PERSONAL 
if (!$agrupados)
{    
$updates=[ 'documento',  'Observaciones']  ;
$tabla_update="Documentos" ;
$id_update="id_documento" ;
$actions_row=[];
$actions_row["id"]="id_documento";
//    $actions_row["delete_link"]="1";
}

//echo   "<a class='btn btn-primary' href='../proveedores/factura_proveedor_anadir.php' target='_blank' >Factura nueva</a>" ; // BOTON AÑADIR FACTURA
//echo   "<a class='btn btn-primary' href='#' onclick=\"genera_remesa()\" title='Genera remesa con las facturas seleccionadas' >Generar Remesa</a>" ; // BOTON AÑADIR FACTURA

 //  CREAMOS EL LINK PARA CADA TIPO DE ENTIDAD (FRA_PROV. PROVEEDOR, OBRA...)




if ($admin)
{   
    echo "SOLO ADMIN: (obsoleto retirar con el tiempo)<br>"; 
    echo "<a class='btn btn-warning' href='../documentos/doc_refresh_fallo.php' target='_blank'>Comprobar documentos sin entidad</a><br>"  ;
    echo "<a class='btn btn-danger' href='../documentos/doc_delete_sin_entidad.php' target='_blank'>Eliminar documentos sin Entidad asociada</a><br>"  ;
}   

echo "<a class='btn btn-warning' onclick=\"js_href('../documentos/doc_borrar_original_ajax.php?id_documentos='+table_selection() ,'1','' ,'table_selection_IN()' )\" "
      . " target='_blank' title='Elimina la foto original de los documentos seleccionados. No elimina el documento \n Sirve para ahorrar espacio' >Elimina solo Original</a><br>"  ;

//echo $sql;
echo "<br><font size=2 color=grey>Agrupar por : $agrupar <br> {$result->num_rows} filas </font> " ;

if ($clasificar)
  {
//   $actions_row["delete_link"]="1";
   $onclick1_VARIABLE1_="id_documento" ;           // paso de variables para dar instrucciones al boton 'add' para añadir un detalle a la udo
   $onclick1_VARIABLE2_="path_archivo" ;     // idem
   $actions_row["onclick1_link"]="<a class='btn btn-danger' title='Elimina el documento completamente' href=# onclick=\"delete_doc_listado(  _VARIABLE1_ , '_VARIABLE2_' )\" >"
           . "<i class='far fa-trash-alt'></i></a> ";


   $col_sel="id_documento" ;
   
   echo "<div class='container'>"  ;  
   echo "<h2>Clasificar documentos seleccionados como:</h2>" ;
   echo  "<div class='form-group'>"  ;
   echo    "Selecciona tipo de entidad a crear:"  ;
   echo     "<select  id='tipo_entidad_clasif' style='width: 30%;'>"  ;
//   echo      DOptions_sql("SELECT DISTINCT tipo_entidad,tipo_entidad FROM Documentos WHERE $where_c_coste ORDER BY tipo_entidad ") ;
 
   echo     "<option value='fra_prov'>Factura proveedor</option>"  ;
   echo     "<option value='albaran'>Albarán proveedor</option>"  ;
   echo     "<option value='obra_foto'>Fotos de obra</option>"  ;
//   echo     "<option value='fra_prov'>Factura proveedor</option>"  ;
   echo     "</select>"  ;
  echo    "<br>Selecciona obra:"  ;
   echo     "<select  id='id_obra' style='width: 30%;'>"  ;
   echo      DOptions_sql("SELECT ID_OBRA,NOMBRE_OBRA FROM OBRAS WHERE activa=1 AND $where_c_coste ORDER BY NOMBRE_OBRA ") ;
 
//   echo     "<option value='fra_prov'>Factura proveedor</option>"  ;
//   echo     "<option value='albaran'>Albarán proveedor</option>"  ;
//   echo     "<option value='obra_foto'>Fotos de obra</option>"  ;
////   echo     "<option value='fra_prov'>Factura proveedor</option>"  ;
   echo     "</select>"  ;
   echo   "<a class='btn btn-link btn-xs transparente' href='#'  onclick='clasificar_selection();'  title='Crea las entidades correspondientes de los documentos seleccionados'>Clasificar</a>"  ;
   echo  "</div>"  ;
   echo  "</div>" ;
   
   
   
//   echo   "<a class='btn btn-primary' href='#' onclick=\"clasificar_sel()\" title='Crea las entidades correspondientes de los documentos seleccionados' >Clasifica los documentos</a>" ; 
    
  }

  



$dblclicks=[];
$dblclicks["tipo_entidad"]="tipo_entidad" ;

$dblclicks["MES"]="MES" ;
//$dblclicks["Trimestre"]="Trimestre" ;
$dblclicks["Anno"]="Anno" ;

//$dblclicks["TIPO_GASTO"]="TIPO_GASTO" ;

//$links["tipo_entidad"] = ["../include/ficha_entidad.php?", "id_entidad_link", "ver entidad asociada al documento (Factura, albarán, ...)"] ;
//$links["nombre_archivo"] = ["../documentos/documento_ficha.php?id_documento=", "id_documento", "ver ficha documento", 'ppal'] ;
$links["tipo_entidad"] =["../include/ficha_entidad.php?", "id_entidad_link", "ver entidad asociada al documento (Factura, albarán, ...)", 'formato_sub'] ;
$links["nid_documento"] = ["../documentos/documento_ficha.php?id_documento=", "id_documento", "ver ficha documento"] ;
//$links["N_FRA"] = ["../proveedores/factura_proveedor.php?id_fra_prov=", "ID_FRA_PROV","ver factura"] ;
//$links["Nid_fra_prov"] = ["../proveedores/factura_proveedor.php?id_fra_prov=", "ID_FRA_PROV","ver factura"] ;
//$links["NOMBRE_OBRA"]=["../obras/obras_ficha.php?id_obra=", "ID_OBRA"] ;

//$formats["Observaciones"] = "textarea" ;
//$formats["tamano"] = "kb" ;
$formats["tamano_medio"] = "kb" ;
$formats["path_archivo"] = "pdf_100_500" ;
//$formats["path_archivo2"] = "textarea" ;
$formats["nombre_archivo"] = "textarea" ;
$formats["documento"] = "text_edit" ;
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
//$aligns["Pagada"] = "center" ;
//$tooltips["conc"] = "Indica si la factura está conciliado con Vales o Albaranos de proveedor" ;
//$tooltips["pagada"] = "Indica la factura tiene emitido documento de pago" ;


$titulo="";
$msg_tabla_vacia="No hay.";
?>
<?php require("../include/tabla.php"); echo $TABLE ;?>

</div>

<!--************ FIN  *************  -->
	
	

<?php  

$Conn->close();

?>
	 

</div>

<div style="background-color:#f1f1f1;text-align:center;padding:10px;margin-top:7px;font-size:30px;">
</div>
	
<script>

function clasificar_selection()
{
  //  alert( table_selection() ) ;
 var tipo_entidad_clasif=document.getElementById("tipo_entidad_clasif").value ;
 var id_obra=document.getElementById("id_obra").value ;

if (window.confirm("Clasificar los documentos seleccionados como "+ tipo_entidad_clasif ) )
{

 window.open("../documentos/clasificar_selection.php?tipo_entidad=" + tipo_entidad_clasif + "&id_obra=" + id_obra+ "&array_str=" + table_selection() )   ;
  
}

}

function delete_doc_listado(id_documento,path_archivo) {
    var nuevo_valor=window.confirm("¿Borrar documento? ");
//    alert("el nuevo valor es: "+valor) ;
   if (!(nuevo_valor === null) && nuevo_valor)
   { 
       cadena_link="tabla='Documentos'&wherecond=id_documento=".id_documento ; 
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
  xhttp.open("GET", "../documentos/delete_doc_ajax.php?id_documento="+id_documento+"&path_archivo="+path_archivo, true);
  xhttp.send();   
   }
   else
   {return;}
   
}
    
    
</script>
        
                </div>
                <!--****************** BUSQUEDA GLOBAL  *****************
            </div>
        </div>
        <!-- FIN Contenido principal -->

<?php 

//FIN
include_once('../templates/_inc_privado3_footer.php');