<?php
// cambios
require_once("../include/session.php");
$where_c_coste = " id_c_coste={$_SESSION['id_c_coste']} ";
$id_c_coste = $_SESSION['id_c_coste'];

$titulo = 'FACTURAS PROV.';

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
        $n_fra= isset($_GET["n_fra"])? $_GET["n_fra"] :  "" ;
        $observaciones=isset($_GET["observaciones"])? $_GET["observaciones"] :  "" ;
        $path_archivo=isset($_GET["path_archivo"])? $_GET["path_archivo"] :  "" ;
        $firmado=isset($_GET["firmado"])? $_GET["firmado"] :  "" ;
        $fecha1=isset($_GET["fecha1"])? $_GET["fecha1"] :  "" ;
        $fecha2=isset($_GET["fecha2"])? $_GET["fecha2"] :  "" ;
        $importe1=isset($_GET["importe1"])? $_GET["importe1"] :  "" ;
        $importe2=isset($_GET["importe2"])? $_GET["importe2"] :  "" ;
        $MES = isset($_GET["MES"]) ?  $_GET["MES"] :   ""  ;
        $Trimestre = isset($_GET["Trimestre"]) ?  $_GET["Trimestre"] :   ""  ;
        $Anno = isset($_GET["Anno"]) ?  $_GET["Anno"] :   ""  ;
        $NOMBRE_OBRA=isset($_GET["NOMBRE_OBRA"])? $_GET["NOMBRE_OBRA"] :  "" ;
        $iva=isset($_GET["iva"])? $_GET["iva"] :  "" ;
        $pdf=isset($_GET["pdf"])? $_GET["pdf"] :  "" ;
        $nomina=isset($_GET["nomina"])? $_GET["nomina"] :  "" ;
        $metadatos=isset($_GET["metadatos"])? $_GET["metadatos"] :  "" ;
        $conciliada=isset($_GET["conciliada"])? $_GET["conciliada"] :  "" ;
        $pagada=isset($_GET["pagada"])? $_GET["pagada"] :  "" ;
        $cobrada=isset($_GET["cobrada"])? $_GET["cobrada"] :  "" ;
        $grupo=isset($_GET["grupo"])? $_GET["grupo"] :  "" ;
        $agrupar = isset($_GET["agrupar"])? $_grupoGET["agrupar"] :  'ultimas_fras_reg' ;     
        
        $fmt_pdf = isset($_GET["fmt_pdf"]) ?  $_GET["fmt_pdf"] :  "checked";
        
        $menu = isset($_GET["menu"]) ?  $_GET["menu"] :  "";

    }
    else
    {
        $n_fra=$_POST["n_fra"] ;
        $observaciones=$_POST["observaciones"] ;
        $path_archivo=$_POST["path_archivo"] ;
        $firmado=$_POST["firmado"] ;
        $fecha1=$_POST["fecha1"] ;  
        $fecha2=$_POST["fecha2"] ;  
        $importe1=$_POST["importe1"] ;
        $importe2=$_POST["importe2"] ; 
        $MES=$_POST["MES"] ;
        $Trimestre=$_POST["Trimestre"] ;
        $Anno=$_POST["Anno"] ;
        $NOMBRE_OBRA=$_POST["NOMBRE_OBRA"] ;
        $iva=$_POST["iva"] ;
        $pdf=$_POST["pdf"] ;
        $nomina=$_POST["nomina"] ;
        $metadatos=$_POST["metadatos"] ;
        $conciliada=$_POST["conciliada"] ;
        $pagada=$_POST["pagada"] ;
        $cobrada=$_POST["cobrada"] ;
        $grupo=$_POST["grupo"] ;
        $agrupar =$_POST["agrupar"] ;    
        
        $fmt_pdf=isset($_POST["fmt_pdf"]) ? 'checked' : '' ;
        
        $menu =  "";
    }   
  

// Comprobamos si es el listado de un único proveedor o un listado global

$listado_global= (!isset($_GET["id_proveedor"])) ;

if (!$listado_global)                
  { 
    $id_proveedor=$_GET["id_proveedor"];         // Estamos viendo las Facturas de un único proveedor
    $proveedor=Dfirst("PROVEEDOR", "Proveedores", "ID_PROVEEDORES=$id_proveedor AND $where_c_coste" )  ;
   
    require_once("../proveedores/proveedores_menutop_r.php");          // añadimos el Menu de Proveedores
   if ($iniciar_form) { $agrupar = 'facturas' ;}                  // si no es Global, mejor agrupar por facturas del proveedor seleccionado
    
  }
  else
  { // si es listado_global añadimos  la variable del form 'proveedor'
     
     if($menu=='obras'){
        require_once("../obras/obras_menutop_r.php");
     }else{
        require_once("../bancos/bancos_menutop_r.php");          // añadimos el Menu de Proveedores  
     }
       if ($iniciar_form)    
    {  $proveedor=isset($_GET["proveedor"])? $_GET["proveedor"] :  "" ;}
    else
    { $proveedor=$_POST["proveedor"] ; }
  } 

  // inicializamos las variables o cogemos su valor del _POST

  
echo "<div >" ;	   
 
echo   "<br><a class='btn btn-link noprint' href='../proveedores/factura_proveedor_anadir.php' target='_blank' ><i class='fas fa-plus-circle'></i> Factura nueva</a>" ; // BOTON AÑADIR FACTURA


if ($listado_global)                // Estamos en pantalla de LISTADO GLOBALES (es decir, en toda la empresa)
{ 
    echo "<h1>FACTURAS DE PROVEEDORES</h1>"  ;
    
    echo "<div class='row' style='border-style: solid ; border-color:grey; margin-bottom: 25px; padding:10px'>" ;
    echo "<div class='col-lg-4'> " ;   

    echo "<form action='../proveedores/facturas_proveedores.php' method='post' id='form1' name='form1'>"    ;
    
    echo "<TABLE class='seleccion'>"  ;
   
    echo "<TR><TD>Proveedor o Cif</TD><TD><INPUT type='text' id='proveedor' name='proveedor' value='$proveedor'><button type='button' onclick=\"document.getElementById('proveedor').value='' \" >*</button></TD></TR>" ;
//    echo "<TR><TD>OBRA       </TD><TD><INPUT type='text' id='N_OBRA' name='N_OBRA' value='$N_OBRA'><button type='button' onclick=\"document.getElementById('N_OBRA').value='' \" >*</button></TD></TR>" ;
}
 else
{
    echo "<a class='btn btn-link noprint' href= '../proveedores/facturas_proveedores.php' >Facturas prov. global</a><br>" ;
     
    echo "<h1>FACTURAS DE <B>$proveedor</B></h1>"  ;

    echo "<div class='row' style='border-style: solid ; border-color:grey; margin-bottom: 25px; padding:10px'>" ;
    echo "<div class='col-lg-4'> " ;   

    echo "<form action='../proveedores/facturas_proveedores.php?id_proveedor=$id_proveedor' method='post' id='form1' name='form1'>"    ;
    
    echo "<TABLE class='seleccion'>"  ;
}    




echo "<TR><TD class='seleccion' >Núm. Factura/ID_FRA_PROV   </TD><TD class='seleccion' ><INPUT type='text' id='n_fra'   name='n_fra'  value='$n_fra'><button type='button' onclick=\"document.getElementById('n_fra').value='' \" >*</button></TD></TR>" ;
echo "<TR><TD>Obra            </TD><TD><INPUT type='text' id='NOMBRE_OBRA'   name='NOMBRE_OBRA'  value='$NOMBRE_OBRA'><button type='button' onclick=\"document.getElementById('NOMBRE_OBRA').value='' \" >*</button></TD></TR>" ;
echo "<TR><TD>Fecha mín.     </TD><TD><INPUT type='date' id='fecha1'     name='fecha1'    value='$fecha1'><button type='button' onclick=\"document.getElementById('fecha1').value='' \" >*</button></TD></TR>" ;
echo "<TR><TD>Fecha máx.     </TD><TD><INPUT type='date' id='fecha2'     name='fecha2'    value='$fecha2'><button type='button' onclick=\"document.getElementById('fecha2').value='' \" >*</button></TD></TR>" ;
echo "<TR><TD>MES     </TD><TD><INPUT type='text' id='MES'     name='MES'    value='$MES'><button type='button' onclick=\"document.getElementById('MES').value='' \" >*</button></TD></TR>" ;
echo "<TR><TD>Trimestre     </TD><TD><INPUT type='text' id='Trimestre'     name='Trimestre'    value='$Trimestre'><button type='button' onclick=\"document.getElementById('Trimestre').value='' \" >*</button></TD></TR>" ;
echo "<TR><TD>Año     </TD><TD><INPUT type='text' id='Anno'     name='Anno'    value='$Anno'><button type='button' onclick=\"document.getElementById('Anno').value='' \" >*</button></TD></TR>" ;

echo "</TABLE></div><div class='col-lg-4'><TABLE class='seleccion'> " ;   

echo "<TR><TD>Importe min     </TD><TD><INPUT type='text' id='importe1'     name='importe1'    value='$importe1'><button type='button' onclick=\"document.getElementById('importe1').value='' \" >*</button></TD></TR>" ;
echo "<TR><TD>importe máx     </TD><TD><INPUT type='text' id='importe2'     name='importe2'    value='$importe2'><button type='button' onclick=\"document.getElementById('importe2').value='' \" >*</button></TD></TR>" ;
echo "<TR><TD>grupo   </TD><TD><INPUT type='text' id='grupo'   name='grupo'  value='$grupo'><button type='button' onclick=\"document.getElementById('grupo').value='' \" >*</button></TD></TR>" ;
echo "<TR><TD>observaciones   </TD><TD><INPUT type='text' id='observaciones'   name='observaciones'  value='$observaciones'><button type='button' onclick=\"document.getElementById('observaciones').value='' \" >*</button></TD></TR>" ;
echo "<TR><TD>Metadatos   </TD><TD><INPUT type='text' id='metadatos'   name='metadatos'  value='$metadatos'><button type='button' onclick=\"document.getElementById('metadatos').value='' \" >*</button></TD></TR>" ;


// RADIO BUTTON CHK
//Datos
$radio=$iva ;
$radio_name='iva' ;
$radio_options=["todas","con iva","sin iva"];
// código
$chk_todos =  ['','']  ; $chk_on = ['','']  ; $chk_off =  ['','']  ;
if ($radio=="") { $chk_todos = ["active","checked"] ;} elseif ($radio==1) { $chk_on =  ["active","checked"]  ;} elseif ($radio==0)  { $chk_off =  ["active","checked"]  ;}
//echo "<br><input type='radio' id='activa' name='activa' value='' $chk_todos />Todas las obras      <input type='radio' id='activa' name='activa' value='1' $chk_on />Activas  <input type='radio' id='activa' name='activa' value='0' $chk_off  />No Activas" ;
$radio_html= "<div class='btn-group btn-group-toggle' data-toggle='buttons'>"
     . "<label class='btn btn-default {$chk_todos[0]}'><input type='radio' id='{$radio_name}' name='$radio_name' value='' {$chk_todos[1]} />{$radio_options[0]}</label> "
     . "<label class='btn btn-default {$chk_on[0]}'><input type='radio' id='{$radio_name}1' name='$radio_name' value='1'  {$chk_on[1]} />{$radio_options[1]} </label>"
     . "<label class='btn btn-default {$chk_off[0]}'><input type='radio' id='{$radio_name}0' name='$radio_name' value='0' {$chk_off[1]}  />{$radio_options[2]}</label>"
     . "</div>"
     . "" ;
// FIN PADIO BUTTON CHK
echo "<TR><TD></td><td>$radio_html</TD></TR>" ;
// RADIO BUTTON CHK
//Datos
$radio=$pdf ;
$radio_name='pdf' ;
$radio_options=["todas","con PDF","sin PDF"];
// código
$chk_todos =  ['','']  ; $chk_on = ['','']  ; $chk_off =  ['','']  ;
if ($radio=="") { $chk_todos = ["active","checked"] ;} elseif ($radio==1) { $chk_on =  ["active","checked"]  ;} elseif ($radio==0)  { $chk_off =  ["active","checked"]  ;}
//echo "<br><input type='radio' id='activa' name='activa' value='' $chk_todos />Todas las obras      <input type='radio' id='activa' name='activa' value='1' $chk_on />Activas  <input type='radio' id='activa' name='activa' value='0' $chk_off  />No Activas" ;
$radio_html= "<div class='btn-group btn-group-toggle' data-toggle='buttons'>"
     . "<label class='btn btn-default {$chk_todos[0]}'><input type='radio' id='{$radio_name}' name='$radio_name' value='' {$chk_todos[1]} />{$radio_options[0]}</label> "
     . "<label class='btn btn-default {$chk_on[0]}'><input type='radio' id='{$radio_name}1' name='$radio_name' value='1'  {$chk_on[1]} />{$radio_options[1]} </label>"
     . "<label class='btn btn-default {$chk_off[0]}'><input type='radio' id='{$radio_name}0' name='$radio_name' value='0' {$chk_off[1]}  />{$radio_options[2]}</label>"
     . "</div>"
     . "" ;
echo "<TR><TD></td><td>$radio_html</TD></TR>" ;
// FIN PADIO BUTTON CHK

// RADIO BUTTON NOMINAS ULTIMA_VERSION
//Datos
$radio=$nomina ;
$radio_name='nomina' ;
$radio_options=["todas","Nominas","Proveedores"]; 
$radio_etiqueta="Tipo proveedor";
$radio_title="Permite filtrar las facturas o adeudos por nóminas del Personal o solo Proveedores";
// código
$chk_todos =  ['','']  ; $chk_on = ['','']  ; $chk_off =  ['','']  ;
if ($radio=="") { $chk_todos = ["active","checked"] ;} elseif ($radio==1) { $chk_on =  ["active","checked"]  ;} elseif ($radio==0)  { $chk_off =  ["active","checked"]  ;}
//echo "<br><input type='radio' id='activa' name='activa' value='' $chk_todos />Todas las obras      <input type='radio' id='activa' name='activa' value='1' $chk_on />Activas  <input type='radio' id='activa' name='activa' value='0' $chk_off  />No Activas" ;
$radio_html= "<div class='btn-group btn-group-toggle' data-toggle='buttons'>"
     . "<label class='btn btn-default {$chk_todos[0]}'><input type='radio' id='{$radio_name}' name='$radio_name' value='' {$chk_todos[1]} />{$radio_options[0]}</label> "
     . "<label class='btn btn-default {$chk_on[0]}'><input type='radio' id='{$radio_name}1' name='$radio_name' value='1'  {$chk_on[1]} />{$radio_options[1]} </label>"
     . "<label class='btn btn-default {$chk_off[0]}'><input type='radio' id='{$radio_name}0' name='$radio_name' value='0' {$chk_off[1]}  />{$radio_options[2]}</label>"
     . "</div>"
     . "" ;
echo "<TR title='$radio_title'><TD>$radio_etiqueta</td><td>$radio_html</TD></TR>" ;
// FIN PADIO BUTTON CHK


echo "<TR><TD>path archivo </TD><TD><INPUT type='text' id='path_archivo'   name='path_archivo'  value='$path_archivo' title='Filtra por el nombre del archivo PDF original'><button type='button' onclick=\"document.getElementById('path_archivo').value='' \" >*</button></TD></TR>" ;
echo "<TR><TD>firmado </TD><TD><INPUT type='text' id='firmado'   name='firmado'  value='$firmado' title='Estado de las Firmas. Filtrar por CONFORME, NO_CONF, PDTE...' ><button type='button' onclick=\"document.getElementById('firmado').value='' \" >*</button></TD></TR>" ;

echo "</TABLE></div><div class='col-lg-4'><TABLE class='seleccion'> " ;   


// RADIO BUTTON CHK
//Datos
$radio=$conciliada ;
$radio_name='conciliada' ;
$radio_options=["todas","Cargadas","No Cargadas"];
// código
$chk_todos =  ['','']  ; $chk_on = ['','']  ; $chk_off =  ['','']  ;
if ($radio=="") { $chk_todos = ["active","checked"] ;} elseif ($radio==1) { $chk_on =  ["active","checked"]  ;} elseif ($radio==0)  { $chk_off =  ["active","checked"]  ;}
//echo "<br><input type='radio' id='activa' name='activa' value='' $chk_todos />Todas las obras      <input type='radio' id='activa' name='activa' value='1' $chk_on />Activas  <input type='radio' id='activa' name='activa' value='0' $chk_off  />No Activas" ;
$radio_html= "<div class='btn-group btn-group-toggle' data-toggle='buttons'>"
     . "<label class='btn btn-default {$chk_todos[0]}'><input type='radio' id='{$radio_name}' name='$radio_name' value='' {$chk_todos[1]} />{$radio_options[0]}</label> "
     . "<label class='btn btn-default {$chk_on[0]}'><input type='radio' id='{$radio_name}1' name='$radio_name' value='1'  {$chk_on[1]} />{$radio_options[1]} </label>"
     . "<label class='btn btn-default {$chk_off[0]}'><input type='radio' id='{$radio_name}0' name='$radio_name' value='0' {$chk_off[1]}  />{$radio_options[2]}</label>"
     . "</div>"
     . "" ;
// FIN PADIO BUTTON CHK
echo "<TR><TD></td><td>$radio_html</TD></TR>" ;




//$radio=$pagada ;
//$chk_todos =  ""  ; $chk_on =  ""  ; $chk_off =  ""  ;
//if ($radio=="") { $chk_todos =   "checked"  ;} elseif ($radio==1) { $chk_on =   "checked"  ;} elseif ($radio==0)  { $chk_off =   "checked"  ;}
//echo "<TR><TD></td><td> <input type='radio' id='pagada' name='pagada' value='' $chk_todos />Todas    <input type='radio' id='pagada' name='pagada' value='1'  $chk_on />Pagadas  <input type='radio' id='pagada' name='pagada' value='0' $chk_off  />No Pagadas </TD></TR>" ;
// RADIO BUTTON CHK
//Datos
$radio=$pagada ;
$radio_name='pagada' ;
$radio_options=["todas","Pagadas","No Pagadas"];
// código
$chk_todos =  ['','']  ; $chk_on = ['','']  ; $chk_off =  ['','']  ;
if ($radio=="") { $chk_todos = ["active","checked"] ;} elseif ($radio==1) { $chk_on =  ["active","checked"]  ;} elseif ($radio==0)  { $chk_off =  ["active","checked"]  ;}
//echo "<br><input type='radio' id='activa' name='activa' value='' $chk_todos />Todas las obras      <input type='radio' id='activa' name='activa' value='1' $chk_on />Activas  <input type='radio' id='activa' name='activa' value='0' $chk_off  />No Activas" ;
$radio_html= "<div class='btn-group btn-group-toggle' data-toggle='buttons'>"
     . "<label class='btn btn-default {$chk_todos[0]}'><input type='radio' id='{$radio_name}' name='$radio_name' value='' {$chk_todos[1]} />{$radio_options[0]}</label> "
     . "<label class='btn btn-default {$chk_on[0]}'><input type='radio' id='{$radio_name}1' name='$radio_name' value='1'  {$chk_on[1]} />{$radio_options[1]} </label>"
     . "<label class='btn btn-default {$chk_off[0]}'><input type='radio' id='{$radio_name}0' name='$radio_name' value='0' {$chk_off[1]}  />{$radio_options[2]}</label>"
     . "</div>"
     . "" ;
// FIN PADIO BUTTON CHK
echo "<TR><TD></td><td>$radio_html</TD></TR>" ;

//$radio=$cobrada ;
//$chk_todos =  ""  ; $chk_on =  ""  ; $chk_off =  ""  ;
//if ($radio=="") { $chk_todos =   "checked"  ;} elseif ($radio==1) { $chk_on =   "checked"  ;} elseif ($radio==0)  { $chk_off =   "checked"  ;}
//echo "<TR><TD></td><td> <input type='radio' id='cobrada' name='cobrada' value='' $chk_todos />Todas    <input type='radio' id='cobrada' name='cobrada' value='1'  $chk_on />Cobradas  <input type='radio' id='cobrada' name='cobrada' value='0' $chk_off  />No cobrada aún </TD></TR>" ;
// RADIO BUTTON CHK
//Datos
$radio=$cobrada ;
$radio_name='cobrada' ;
$radio_options=["todas","Cobradas","No Cobradas"];
// código
$chk_todos =  ['','']  ; $chk_on = ['','']  ; $chk_off =  ['','']  ;
if ($radio=="") { $chk_todos = ["active","checked"] ;} elseif ($radio==1) { $chk_on =  ["active","checked"]  ;} elseif ($radio==0)  { $chk_off =  ["active","checked"]  ;}
//echo "<br><input type='radio' id='activa' name='activa' value='' $chk_todos />Todas las obras      <input type='radio' id='activa' name='activa' value='1' $chk_on />Activas  <input type='radio' id='activa' name='activa' value='0' $chk_off  />No Activas" ;
$radio_html= "<div class='btn-group btn-group-toggle' data-toggle='buttons'>"
     . "<label class='btn btn-default {$chk_todos[0]}'><input type='radio' id='{$radio_name}' name='$radio_name' value='' {$chk_todos[1]} />{$radio_options[0]}</label> "
     . "<label class='btn btn-default {$chk_on[0]}'><input type='radio' id='{$radio_name}1' name='$radio_name' value='1'  {$chk_on[1]} />{$radio_options[1]} </label>"
     . "<label class='btn btn-default {$chk_off[0]}'><input type='radio' id='{$radio_name}0' name='$radio_name' value='0' {$chk_off[1]}  />{$radio_options[2]}</label>"
     . "</div>"
     . "" ;
// FIN PADIO BUTTON CHK
echo "<TR><TD></td><td>$radio_html</TD></TR>" ;


echo "<TR><TD colspan=2 align=center><INPUT type='submit' class='btn btn-success btn-xl noprint' value='Actualizar' id='submit' name='submit'></TD></TR>" ;

echo "</TABLE></div></div>"  ;

echo "<input type='hidden'  id='agrupar'  name='agrupar' value='$agrupar'>" ;

echo "<div class='noprint'>";

echo "Formato:   ";
echo   "<label><INPUT type='checkbox' id='fmt_pdf' name='fmt_pdf'  $fmt_pdf  >    ver PDF</label><br><br>" ;


//         <a class="btn btn-link btn-xs noprint" title="formato para realizar un Estudio de costes de un Proyecto o Liciación" href=#  onclick="formato_estudio_costes();"><i class="fas fa-euro-sign"></i> modo Estudio de Costes</a>
//         <a class="btn btn-link btn-xs noprint" title="formato de formulario para registrar Producciones de Obra" href=#  onclick="formato_prod_obra();"><i class="fas fa-hard-hat"></i> modo Producción Obra</a>
//         <a class="btn btn-link btn-xs noprint" title="imprimir la producción con formato de Certificación sin costes, con texto_udo y con resumen" href=#  onclick="formato_certif();"><i class="fas fa-print"></i> modo Certificacion</a>

       
echo "</div>" ;         


echo "<div id='myDIV' class='noprint'>" ;

$btnt['ultimas_fras_reg']=['ultimas registradas','muestra las últimas facturas registradas'] ;
$btnt['facturas']=['facturas','Listado de todas las facturas según el filtro'] ;
if ($listado_global) 
{   
    $btnt['prov_fras']=['prov-fras',''] ;
    $btnt['proveedor']=['proveedor',''] ;
}
$btnt['obras']=['obras',''] ;
$btnt['vacio3']=['','',''] ;
$btnt['meses']=['meses',''] ;
$btnt['trimestres']=['trimestres',''] ;
$btnt['annos']=['años',''] ;
$btnt['vacio2']=['','',''] ;
$btnt['grupo']=['grupo','Agrupa las facturas por grupos '] ;

$btnt['cuadros']=["<span class='glyphicon glyphicon-th-large'></span> cuadros",'Muestra las facturas seleccionadas en forma de cuadros'] ;

foreach ( $btnt as $clave => $valor)
{
  $active= ($clave==$agrupar) ? "cc_active" : "" ;  
  echo (substr($clave,0,5)=='vacio') ? "   " : "<button class='cc_btnt $active' title='{$valor[1]}' onclick=\"getElementById('agrupar').value = '$clave'; document.getElementById('form1').submit(); \">{$valor[0]}</button>" ;  
}  

//echo "</form>" ;
echo "</div>"  ;

?>

<div id="main" class="mainc_100" style="background-color:#fff">
    
    
<?php   // Iniciamos variables para tabla.php  background-color:#B4045


//$FECHA1= date_replace($FECHA1) ;
//$FECHA2= date_replace($FECHA2) ;
$where=$where_c_coste;

if ($listado_global)                // Estamos en pantalla de LISTADO GLOBAL (toda la empresa no solo en un proveedor concreto)
{    
// adaptamos todos los filtros, quitando espacios a ambos lados con trim() y sustituyendo espacios por '%' para el LIKE 
$where=$proveedor==""? $where : $where . " AND filtro LIKE '%".str_replace(" ","%",trim($proveedor))."%'" ;
}
else 
{
$where= $where . " AND ID_PROVEEDORES=$id_proveedor " ;    // Estamos en gastos de una Obra o Maquinaria específica
}    


$select_trimestre="CONCAT(YEAR(FECHA), '-', QUARTER(FECHA),'T')"  ;


$where=$n_fra==""? $where : $where . " AND CONCAT(ID_FRA_PROV,N_FRA) LIKE '%".str_replace(" ","%",trim($n_fra))."%'" ;
$where=$NOMBRE_OBRA==""? $where : $where . " AND NOMBRE_OBRA LIKE '%".str_replace(" ","%",trim($NOMBRE_OBRA))."%'" ;
$where=$fecha1==""? $where : $where . " AND FECHA >= '$fecha1' " ;
$where=$fecha2==""? $where : $where . " AND FECHA <= '$fecha2' " ;
$where=$MES==""? $where : $where . " AND DATE_FORMAT(FECHA, '%Y-%m') = '$MES' " ;
$where=$Trimestre==""? $where : $where . " AND $select_trimestre = '$Trimestre' " ;
$where=$Anno==""? $where : $where . " AND YEAR(FECHA) = '$Anno' " ;
$where=$importe1==""? $where : $where . " AND IMPORTE_IVA >= $importe1" ;
$where=$importe2==""? $where : $where . " AND IMPORTE_IVA <= $importe2" ;
$where=$iva==""? $where : ($iva>0 ? $where . " AND iva>0 " : $where . " AND iva=0 ") ;
$where=$pdf==""? $where : $where . " AND PDF=$pdf " ;
$where=$nomina==""? $where : $where . " AND nomina=$nomina " ;
$where=$conciliada==""? $where : $where . " AND conc=$conciliada " ;
$where=$pagada==""? $where : $where . " AND pagada=$pagada " ;
$where=$cobrada==""? $where : $where . " AND cobrada=$cobrada " ;
$where=$grupo==""? $where : $where . " AND grupo LIKE '%".str_replace(" ","%",trim($grupo))."%'" ;
$where=$observaciones==""? $where : $where . " AND Observaciones LIKE '%".str_replace(" ","%",trim($observaciones))."%'" ;
$where=$metadatos==""? $where : $where . " AND metadatos LIKE '%".str_replace(" ","%",trim($metadatos))."%'" ;
$where=$path_archivo==""? $where : $where . " AND path_archivo LIKE '%".str_replace(" ","%",trim($path_archivo))."%'" ;
$where=$firmado==""? $where : $where . " AND firmado LIKE '%".str_replace(" ","%",trim($firmado))."%'" ;
//$where=$FECHA2==""? $where : $where . " AND FECHA <= STR_TO_DATE('$FECHA2','%Y-%m-%d') " ;

?>

<!--EXPAND SELECCION -->    
  
<br><button type='button' class='btn btn-xs btn-link noprint' id='exp_seleccion' data-toggle='collapse' data-target='#div_seleccion'>Operar con facturas seleccionadas <i class="fa fa-angle-down" aria-hidden="true"></i></button>
<div id='div_seleccion' class='collapse'>
  
<div class="noprint" style="border-width:1px; border-style:solid;">
  <b>Acciones a realizar con facturas seleccionadas:</b>
    <div style="margin:10px">
      <!--<label for="id_personal">Selecciona personal:</label>-->
      Añadir a remesa de pagos
      <!--<select class="form-control" id="id_personal" style="width: 30%;">-->
      <select id="id_remesa" style="font-size: 15px; width: 20%;">
          <OPTION value="0" selected>*crear remesa nueva*</OPTION>
       <?php echo DOptions_sql("SELECT id_remesa,CONCAT(remesa,'  Importe:',FORMAT(IFNULL(importe,0),2),'€ -Num.Pagos',IFNULL(num_pagos,0)) FROM Remesas_View WHERE activa=1 AND firmada=0 AND $where_c_coste ORDER BY f_vto ") ?>
      </select>
      <a class='btn btn-warning btn-xs' href='#' onclick="genera_remesa()" title='Añade/Genera remesa con las facturas seleccionadas' >Añadir a remesa</a>
      <a class='btn btn-link btn-xs' href='#' onclick="window.open('../bancos/remesa_ficha.php?id_remesa='+document.getElementById('id_remesa').value ) " title='abre la remesa seleccionada' >ver remesa</a>
    </div>
      <div style="margin:10px">
      <!--<label for="id_personal">Selecciona personal:</label>-->
      Cargar a obra
      <!--<select class="form-control" id="id_personal" style="width: 30%;">-->
      <select id="id_obra" style="font-size: 15px; width: 20%;">        
       <?php echo DOptions_sql("SELECT ID_OBRA,NOMBRE_OBRA FROM OBRAS WHERE $where_c_coste AND  activa ORDER BY activa DESC,NOMBRE_OBRA ") ?>
      </select>
      <a class='btn btn-warning btn-xs' href='#' onclick="cargar_a_obra_sel_href()" title='Carga las facturas seleccionadas a una obra' >cargar</a>
    </div>
      <div style="margin:10px">
      <!--<label for="id_personal">Selecciona personal:</label>-->
      Registrar como pago en metálico
      <a class='btn btn-warning btn-xs' href='#' onclick="mov_bancos_conciliar_fras_caja_metalico ()" title='Registra las facturas como pagadas en metálico. Crea id_pago y un mov.banco en la Cuenta Metalico' >pagar con CAJA METALICO</a>

     <?php   
          // pago con cuenta a seleccionar
   echo "<div style='width:100% ; border-style:solid;border-width:2px; border-color:silver ;'>" ;
   echo "Pagar con cuenta: <select  id='id_cta_banco' style='width: 40%; '>" ;
   echo DOptions_sql("SELECT id_cta_banco, Banco FROM ctas_bancos WHERE Activo AND $where_c_coste ORDER BY Banco  ") ;
   echo "  </select>" ;    
   echo " <a class='btn btn-warning btn-xs' href='#'  onclick='mov_bancos_conciliar_fras_cta();'>pagar con este Banco</a>" ;    
   echo "</div>" ;
    
          // cambiar GRUPO
   echo "<div style='width:100% ; border-style:solid;border-width:2px; border-color:silver ;'>" ;
    $sql_update= "UPDATE `FACTURAS_PROV` SET grupo='_VARIABLE1_' WHERE  ID_FRA_PROV IN _VARIABLE2_ ; "  ;
    $href='../include/sql.php?sql=' . encrypt2($sql_update)  ;    
echo "Cambiar el grupo de las facturas seleccionadas: <a class='btn btn-warning btn-xs noprint ' href='#' "
     . " onclick=\"js_href('$href' ,'1','', 'PROMPT_Nombre_nuevo_grupo' ,'table_selection_IN()' )\"   "
     . "title='Cambia a otro grupo las facturas seleccionadas' > cambiar grupo</a>" ;

   echo "</div>" ; 
    
    ?> 
      

      
    </div>

</div>
</div>
<!--FIN SELECCION DE REMESA -->     
<!--EXPAND RESUMEN -->   
  
<br><button type='button' class='btn btn-xs btn-link noprint' id='exp_resumen' data-toggle='collapse' data-target='#div_resumen'>Resumen de importes  <i class="fa fa-angle-down" aria-hidden="true"></i></button>
<div id='div_resumen' class='collapse'>
  
<div  style="border-width:1px; border-style:solid;">
  <b>Resúmenes de importes:</b>
<?php

// CONSULTA para el RESUMEN DE IMPORTES
$sql="SELECT SUM(Base_Imponible) AS Base_Imponible, SUM(IMPORTE_IVA) - SUM(Base_Imponible) AS importe_de_iva, SUM(IMPORTE_IVA) AS IMPORTE_IVA,SUM(importe_vales) AS importe_cargado,SUM(importe_pagado) AS importe_pagado,"
        . "SUM(importe_cobrado) AS Importe_cobrado  FROM Fras_Prov_View WHERE $where  " ;   
$result=$Conn->query($sql) ;

//$rs = $result->fetch_array(MYSQLI_ASSOC) ;
// $titulo="RESUMEN DE IMPORTES" ;
require("../include/tabla.php"); echo $TABLE ;
//require("../include/ficha.php");


echo "</div>" ;
echo "</div>" ;

//<!--FIN EXPAND RESUMEN -->     


$select_fmt_pdf = $fmt_pdf ? " path_archivo, " : ""  ;               
$select_fmt_pdf_T = $fmt_pdf ? " '' as aa, " : ""  ;               





$tabla_group=0 ;
$tabla_cuadros=0 ;

$agrupados=0 ;               // determina si cada línea es una factura_prov o representa un grupo para poder poner el boton de delete o update el campo observaciones


 switch ($agrupar) { 
    case "ultimas_fras_reg":
     $sql="SELECT ID_FRA_PROV, $select_fmt_pdf   ID_PROVEEDORES,N_FRA,FECHA,PROVEEDOR,Base_Imponible, iva, "
            . "IMPORTE_IVA,ID_OBRA, NOMBRE_OBRA, firmado_TOOLTIP, firmado, pdte_conciliar,conc as cargada,pagada,cobrada,pdte_pago,grupo,Observaciones "
            . " FROM Fras_Prov_View WHERE $where  ORDER BY Fecha_Creacion DESC LIMIT 100 " ;
//     echo $sql;
     $sql_T="SELECT '' " ;
     $col_sel="ID_FRA_PROV" ;

    break;
    case "facturas":
     $sql="SELECT ID_FRA_PROV, $select_fmt_pdf   ID_PROVEEDORES,PROVEEDOR,N_FRA,FECHA,Base_Imponible, iva, "
            . "IMPORTE_IVA,ID_OBRA, NOMBRE_OBRA, firmado_TOOLTIP, firmado, pdte_conciliar,conc as cargada,pagada,cobrada,pdte_pago,grupo,Observaciones "
            . " FROM Fras_Prov_View WHERE $where  ORDER BY Fecha_Creacion " ;
        
//     $sql="SELECT $select_fmt_pdf  ID_FRA_PROV,ID_PROVEEDORES,PROVEEDOR,N_FRA,FECHA,Base_Imponible, iva, IMPORTE_IVA,"
//         . "ID_OBRA, NOMBRE_OBRA,grupo,Observaciones, firmado_TOOLTIP, firmado, pdte_conciliar,conc as cargada,pagada,cobrada,pdte_pago, concepto "
//            . " FROM Fras_Prov_View WHERE $where  ORDER BY FECHA DESC " ;
     $sql_T="SELECT $select_fmt_pdf_T '' AS c,'' AS c1,'Totales' AS d,'' AS f11,SUM(Base_Imponible) AS Base_Imponible,'' AS f, SUM(IMPORTE_IVA) AS IMPORTE_IVA,'' AS a41,'' AS a1 "
             . ",SUM(pdte_conciliar) as pdte_conciliar,'' AS a31,'' AS a11,'' AS b1,'' AS c1,SUM(pdte_pago) AS pdte_pago  FROM Fras_Prov_View WHERE $where  " ;   
     //$sql_T="SELECT '','Suma' , SUM(IMPORTE) as importe  FROM ConsultaGastos_View WHERE $where    " ;
//     echo $sql;

     $col_sel="ID_FRA_PROV" ;

    break;
    case "cuadros":
     $sql="SELECT path_archivo as pdf_500,ID_FRA_PROV,ID_PROVEEDORES,PROVEEDOR,N_FRA,FECHA,Base_Imponible, iva, IMPORTE_IVA,"
         . "ID_OBRA, NOMBRE_OBRA,grupo,Observaciones, firmado_TOOLTIP, firmado, pdte_conciliar,conc as cargada,pagada,cobrada, concepto "
            . " FROM Fras_Prov_View WHERE $where  ORDER BY FECHA DESC " ;
     $formats["pdf_500"] = 'pdf_500_500' ;   
     $linkss["pdf_500"] = ["../proveedores/factura_proveedor.php?id_fra_prov=", "ID_FRA_PROV","ver factura",""] ;
     $tabla_cuadros=1;   
     $div_size_width=500 ;
     $div_size_height=$div_size_width*1.5 ;
//     $sql_T="SELECT '' AS b,'' AS b8,'' AS c,'' AS c2,'Totales' AS d,SUM(Base_Imponible) AS Base_Imponible,'' AS f, SUM(IMPORTE_IVA) AS IMPORTE_IVA,'' AS a1,'' AS b1,'' AS c1,'' AS c3  FROM Fras_Prov_View WHERE $where  " ;   
     //$sql_T="SELECT '','Suma' , SUM(IMPORTE) as importe  FROM ConsultaGastos_View WHERE $where    " ;
//     $col_sel="ID_FRA_PROV" ;
//    $formats["pdf_500"]="pdf_500" ;                //"pdf_800" ;

    break;
    case "prov_fras":
//     $sql="SELECT ID_PROVEEDORES,PROVEEDOR,SUM(Base_Imponible) AS Base_Imponible,SUM(IMPORTE_IVA) AS IMPORTE_IVA, SUM(pdte_conciliar) AS pdte_conciliar  FROM Fras_Prov_View WHERE $where GROUP BY ID_PROVEEDORES  ORDER BY PROVEEDOR " ;
//     $sql_T="SELECT 'Totales' AS c,'' AS d,SUM(Base_Imponible) AS Base_Imponible, SUM(IMPORTE_IVA) AS IMPORTE_IVA,SUM(pdte_conciliar) AS pdte_conciliar  FROM Fras_Prov_View WHERE $where  " ;   
     $sql="SELECT $select_fmt_pdf ID_FRA_PROV,ID_PROVEEDORES,PROVEEDOR,N_FRA,FECHA,Base_Imponible, iva, IMPORTE_IVA,ID_OBRA, grupo, Observaciones,pdte_conciliar,conc as cargada,pagada,cobrada  FROM Fras_Prov_View WHERE $where  ORDER BY PROVEEDOR  " ;
     $sql_T="SELECT 'Totales' AS a,$select_fmt_pdf_T'' AS c,'' AS d,SUM(Base_Imponible) AS Base_Imponible,'' AS f, SUM(IMPORTE_IVA) AS IMPORTE_IVA,'' AS a1,'' AS b1,'' AS b15,'' AS c1,'' AS c3,'' AS c6  FROM Fras_Prov_View WHERE $where  " ;   

//     $sql_S="SELECT ID_CAPITULO,$select_global CAPITULO , SUM(IMPORTE) as importe,SUM(gasto_est) as gasto_est,(SUM(IMPORTE)- SUM(gasto_est)) as beneficio  FROM ConsultaProd WHERE $where   GROUP BY ID_CAPITULO ORDER BY CAPITULO " ;
     $sql_S="SELECT ID_PROVEEDORES,PROVEEDOR,SUM(Base_Imponible) AS Base_Imponible, SUM(IMPORTE_IVA)  - SUM(Base_Imponible) AS  iva_soportado,SUM(IMPORTE_IVA) AS IMPORTE_IVA, SUM(pdte_conciliar) AS pdte_conciliar  FROM Fras_Prov_View WHERE $where GROUP BY ID_PROVEEDORES  ORDER BY PROVEEDOR " ;

     $id_agrupamiento="ID_PROVEEDORES" ;
     // permite editar el coste_est
//    $updates=['MED_PROYECTO','COSTE_EST']  ;
    $anchos_ppal=[30,20,20,20,20,20,20,20,20,20,20,20,20,20] ;
    
//    $tabla_update="Udos" ;
//    $id_update="ID_UDO" ;
//    $id_clave="ID_UDO" ;
    $tabla_group=1 ;
    $col_sel="ID_FRA_PROV" ;

    
     break; 
    case "proveedor":
     $sql="SELECT ID_PROVEEDORES,PROVEEDOR,CIF, COUNT(ID_FRA_PROV) AS Fras,SUM(Base_Imponible) AS Base_Imponible, SUM(IMPORTE_IVA)  - SUM(Base_Imponible) AS  iva_soportado,SUM(IMPORTE_IVA) AS IMPORTE_IVA, SUM(pdte_conciliar) AS pdte_conciliar  FROM Fras_Prov_View WHERE $where GROUP BY ID_PROVEEDORES  ORDER BY PROVEEDOR " ;
     $sql_T="SELECT 'Totales' AS c,'' as a  , COUNT(ID_FRA_PROV) AS Fras, SUM(Base_Imponible) AS Base_Imponible, SUM(IMPORTE_IVA)  - SUM(Base_Imponible) AS  iva_soportado, SUM(IMPORTE_IVA) AS IMPORTE_IVA,SUM(pdte_conciliar) AS pdte_conciliar  FROM Fras_Prov_View WHERE $where  " ;   
    $agrupados=1 ;
     break;
    case "obras":
     $sql="SELECT ID_OBRA,NOMBRE_OBRA,SUM(Base_Imponible) AS Base_Imponible,SUM(IMPORTE_IVA) AS IMPORTE_IVA, SUM(pdte_conciliar) AS pdte_conciliar  FROM Fras_Prov_View WHERE $where GROUP BY ID_OBRA  ORDER BY NOMBRE_OBRA " ;
     $sql_T="SELECT 'Totales' AS c,'' AS d,SUM(Base_Imponible) AS Base_Imponible, SUM(IMPORTE_IVA) AS IMPORTE_IVA,SUM(pdte_conciliar) AS pdte_conciliar  FROM Fras_Prov_View WHERE $where  " ;   
    $agrupados=1 ;
     break;
    case "meses":
    $sql="SELECT  DATE_FORMAT(FECHA, '%Y-%m') as MES,COUNT( ID_FRA_PROV ) as Fras,SUM(Base_Imponible) AS Base_Imponible, SUM(IMPORTE_IVA)  - SUM(Base_Imponible) AS  iva_soportado,SUM(IMPORTE_IVA) as IMPORTE_IVA,SUM(pdte_conciliar) AS pdte_conciliar  FROM Fras_Prov_View WHERE $where  GROUP BY MES  ORDER BY MES  " ;
    $sql_T="SELECT 'Totales' AS D,COUNT( ID_FRA_PROV ) as Fras,SUM(Base_Imponible) AS Base_Imponible, SUM(IMPORTE_IVA)  - SUM(Base_Imponible) AS  iva_soportado, SUM(IMPORTE_IVA) as IMPORTE_IVA,SUM(pdte_conciliar) AS pdte_conciliar  FROM Fras_Prov_View WHERE $where   " ;
    $agrupados=1 ;
     break;
    case "trimestres":
//    $sql="SELECT  DATE_FORMAT(FECHA, '%Y-%m') as MES,SUM(Base_Imponible) AS Base_Imponible,SUM(IMPORTE_IVA) as IMPORTE_IVA,SUM(pdte_conciliar) AS pdte_conciliar  FROM Fras_Prov_View WHERE $where  GROUP BY MES  ORDER BY MES  " ;
    $sql="SELECT  $select_trimestre as Trimestre,COUNT( ID_FRA_PROV ) as Fras,SUM(Base_Imponible) AS Base_Imponible, SUM(IMPORTE_IVA)  - SUM(Base_Imponible) AS  iva_soportado,SUM(IMPORTE_IVA) as IMPORTE_IVA,SUM(pdte_conciliar) AS pdte_conciliar  FROM Fras_Prov_View WHERE $where  GROUP BY TRIMESTRE  ORDER BY TRIMESTRE  " ;
    $sql_T="SELECT 'Totales' AS D,COUNT( ID_FRA_PROV ) as Fras,SUM(Base_Imponible) AS Base_Imponible, SUM(IMPORTE_IVA)  - SUM(Base_Imponible) AS  iva_soportado, SUM(IMPORTE_IVA) as IMPORTE_IVA,SUM(pdte_conciliar) AS pdte_conciliar  FROM Fras_Prov_View WHERE $where   " ;
    $agrupados=1 ;
     break;
    case "annos":
    $sql="SELECT  DATE_FORMAT(FECHA, '%Y') as Anno,COUNT( ID_FRA_PROV ) as Fras,SUM(Base_Imponible) AS Base_Imponible, SUM(IMPORTE_IVA)  - SUM(Base_Imponible) AS  iva_soportado "
            . " , SUM(IMPORTE_IVA) as IMPORTE_IVA,SUM(pdte_conciliar) AS pdte_conciliar  FROM Fras_Prov_View WHERE $where  GROUP BY Anno  ORDER BY Anno  " ;
    $sql_T="SELECT 'Totales' AS D,COUNT( ID_FRA_PROV ),SUM(Base_Imponible) AS Base_Imponible, SUM(IMPORTE_IVA)  - SUM(Base_Imponible) AS  iva_soportado, SUM(IMPORTE_IVA) as IMPORTE_IVA,SUM(pdte_conciliar) AS pdte_conciliar  FROM Fras_Prov_View WHERE $where  " ;
    $agrupados=1 ;
     break;
    case "grupo":
    $sql="SELECT  grupo,COUNT( ID_FRA_PROV ) as Fras,SUM(Base_Imponible) AS Base_Imponible, SUM(IMPORTE_IVA)  - SUM(Base_Imponible) AS  iva_soportado "
            . " , SUM(IMPORTE_IVA) as IMPORTE_IVA,SUM(pdte_conciliar) AS pdte_conciliar  FROM Fras_Prov_View WHERE $where  GROUP BY grupo  ORDER BY grupo  " ;
    $sql_T="SELECT 'Totales' AS D,COUNT( ID_FRA_PROV ),SUM(Base_Imponible) AS Base_Imponible, SUM(IMPORTE_IVA)  - SUM(Base_Imponible) AS  iva_soportado, SUM(IMPORTE_IVA) as IMPORTE_IVA,SUM(pdte_conciliar) AS pdte_conciliar  FROM Fras_Prov_View WHERE $where  " ;
    $agrupados=1 ;
     break;
 }

//echo "PDF es $pdf"  ;
//echo $sql ;
$result=$Conn->query($sql) ;
if (isset($sql_T)) {$result_T=$Conn->query($sql_T) ; }    // consulta para los TOTALES
if (isset($sql_T2)) {$result_T2=$Conn->query($sql_T2) ; }    // consulta para los TOTALES
if (isset($sql_T3)) {$result_T3=$Conn->query($sql_T3) ; }    // consulta para los TOTALES
if (isset($sql_S)) {$result_S=$Conn->query($sql_S) ; }     // consulta para los SUBGRUPOS , agrupación de filas (Ej. CLIENTES o CAPITULOS en listado de udos)

// AÑADE BOTON DE 'BORRAR' FACTURA . SOLO BORRARÁ SI ESTÁ VACÍO DE PERSONAL 
if (!$agrupados)
{    
 $updates=['Observaciones','grupo']  ;
 $tabla_update="FACTURAS_PROV" ;
 $id_update="ID_FRA_PROV" ;
 
$actions_row=[];                                    // ANULAMOS LA POSIBILIDAD DE BORRAR FACTURA EN EL LISTADO. HAY QUE ENTRAR Y BORRAR DESDE DENTRO POR SEGURIDAD.
$actions_row["id"]="ID_FRA_PROV";
$actions_row["delete_link"]="1"; 
}
//echo   "<br><a class='btn btn-link noprint' href='../proveedores/factura_proveedor_anadir.php' target='_blank' ><i class='fas fa-plus-circle'></i> Factura nueva</a>" ; // BOTON AÑADIR FACTURA
//echo   "<a class='btn btn-primary' href='#' onclick=\"genera_remesa()\" title='Genera remesa con las facturas seleccionadas' >Generar Remesa Nueva</a>" ; // BOTON AÑADIR FACTURA
//echo   "<a class='btn btn-primary' href='#' onclick=\"cargar_a_obra()\" title='Carga las facturas seleccionadas a una obra' >Cargar fras a obra</a>" ; 


echo "<br><font size=2 color=grey>Agrupar por : $agrupar <br> {$result->num_rows} filas </font> " ;

$dblclicks=[];
$dblclicks["PROVEEDOR"]="proveedor" ;
$dblclicks["grupo"]="grupo" ;
$dblclicks["NOMBRE_OBRA"]="NOMBRE_OBRA" ;
$dblclicks["CIF"]="proveedor" ;
$dblclicks["N_FRA"]="n_fra" ;
//$dblclicks["CONCEPTO"]="CONCEPTO" ;
//$dblclicks["TIPO_GASTO"]="TIPO_GASTO" ;
$dblclicks["MES"]="MES" ;
$dblclicks["Trimestre"]="Trimestre" ;
$dblclicks["Anno"]="Anno" ;



$links["NOMBRE_OBRA"] = ["../obras/obras_ficha.php?id_obra=", "ID_OBRA","ver Obra","formato_sub_vacio"] ;
$links["PROVEEDOR"] = ["../proveedores/proveedores_ficha.php?id_proveedor=", "ID_PROVEEDORES","ver Proveedor","formato_sub"] ;
$links["N_FRA"] = ["../proveedores/factura_proveedor.php?id_fra_prov=", "ID_FRA_PROV","ver factura","formato_sub"] ;
$links["FECHA"] = ["../proveedores/factura_proveedor.php?id_fra_prov=", "ID_FRA_PROV","ver factura","formato_sub"] ;
$links["path_archivo"] = ["../proveedores/factura_proveedor.php?id_fra_prov=", "ID_FRA_PROV","ver factura","formato_sub"] ;
//$links["Nid_fra_prov"] = ["../proveedores/factura_proveedor.php?id_fra_prov=", "ID_FRA_PROV","ver factura","formato_sub"] ;
//$links["NOMBRE_OBRA"]=["../obras/obras_ficha.php?id_obra=", "ID_OBRA"] ;

//$formats["Observaciones"] = "textarea" ;
$formats["Enero"] = "moneda" ; $formats["Febrero"] = "moneda" ; $formats["Marzo"] = "moneda" ; $formats["Abril"] = "moneda" ; $formats["Mayo"] = "moneda" ; $formats["Junio"] = "moneda" ;
$formats["Julio"] = "moneda" ; $formats["Agosto"] = "moneda" ; $formats["Septiembre"] = "moneda" ; $formats["Octubre"] = "moneda" ; $formats["Noviembre"] = "moneda" ; $formats["Diciembre"] = "moneda" ;

$formats["Base_Imponible"] = "moneda" ;
$formats["firmado"] = "firmado" ;
$formats["iva_soportado"] = "moneda" ;
$formats["IMPORTE_IVA"] = "moneda" ;
$formats["pdte_conciliar"] = "moneda" ;
$etiquetas["IMPORTE_IVA"] = "Importe iva inc." ;
$etiquetas["pdte_conciliar"] = "pdte cargar" ;
$tooltips["pdte_conciliar"] = "importe pendiente de Cargar a obra de esta factura" ;
$tooltips["Fras"] = "Número de facturas del periodo" ;
$aligns["Fras"] = "center" ;

$formats["pdte_pago"] = "moneda" ;
$formats["path_archivo"]="pdf_100_500" ;                //"pdf_800" ;

//$formats["ingreso_conc"] = "moneda" ;
//$formats["ingreso"] = "moneda" ;
//$formats["FECHA"] = "dbfecha" ;
//$formats["cargada"] = "boolean" ;
$formats["PDF"] = "boolean" ;
//$formats["pagada"] = "boolean" ;
//$formats["cobrada"] = "boolean" ;
$formats["path"] = "textarea2" ;
$links["path"] = ["../proveedores/factura_proveedor.php?id_fra_prov=", "ID_FRA_PROV","ver factura","formato_sub"] ;

$formats["cargada"] = "semaforo_OK" ;
$formats["pagada"] = "semaforo_OK" ;
$formats["cobrada"] = "semaforo_OK" ;




//$aligns["Pagada"] = "center" ;
//$tooltips["cargada"] = "Indica si la factura está cargada a obra con Vales o Albaranos de proveedor" ;
//$tooltips["pagada"] = "Indica la factura tiene emitido documento de pago" ;


$titulo="";
$msg_tabla_vacia="No hay.";

$tabla_expandible=0;          // evitamos la tabla expandible que da problemas

if (isset($content_sel))  echo $content_sel ;        // pintamos el contenido de Selection, los botones para las acciones con la selección


if ($tabla_group)
{ require("../include/tabla_group.php"); }
elseif ($tabla_cuadros)
{ require("../include/tabla_cuadros.php"); }    
else
{ require("../include/tabla.php"); echo $TABLE ; }
    
echo "</form>" ;

?>

</div>

<!--************ FIN  *************  -->
	
	

<?php  

$Conn->close();

?>
	 

</div>

<div style="background-color:#f1f1f1;text-align:center;padding:10px;margin-top:7px;font-size:30px;">
</div>
	
<script>
function mov_bancos_conciliar_fras_caja_metalico() {
    
    //var valor0 = valor0_encode;
    //var valor0 = JSON.parse(valor0_encode);
   // var nuevo_valor=window.prompt("Nuevo valor de "+prompt , valor0);
//    alert("el nuevo valor es: "+valor) ;
//   alert('debug') ;
//   var id_mov_banco=document.getElementById("id_mov_banco").value ;
//   var d= new Date() ;
//   var date_str=d.toISOString();
   
   window.open('../bancos/mov_bancos_conciliar_selection_fras.php?array_str=' + encodeURIComponent(table_selection()));
//   window.open('../obras/obras_anadir_parte.php?id_obra='+id_obra, '_blank');
 //echo "<a class='btn btn-primary' href= '../obras/obras_anadir_parte.php?id_obra=$id_obra' >Añadir parte</a><br>" ;
        

    
    return ;
 }
   function mov_bancos_conciliar_fras_cta() {
    
    //var valor0 = valor0_encode;
    //var valor0 = JSON.parse(valor0_encode);
   // var nuevo_valor=window.prompt("Nuevo valor de "+prompt , valor0);
//    alert("el nuevo valor es: "+valor) ;
//   alert('debug') ;
   var id_cta_banco=document.getElementById("id_cta_banco").value ;
//   var d= new Date() ;
//   var date_str=d.toISOString();
   // mandamos el array con la seleccion de facturas y el numero de cuenta donde cerar el mov_banco y conciliarlas
   window.open('../bancos/mov_bancos_conciliar_selection_fras.php?array_str=' + encodeURIComponent(table_selection())+'&id_mov_banco=CTA_' + id_cta_banco);
//   window.open('../obras/obras_anadir_parte.php?id_obra='+id_obra, '_blank');
 //echo "<a class='btn btn-primary' href= '../obras/obras_anadir_parte.php?id_obra=$id_obra' >Añadir parte</a><br>" ;
        

    
    return ;
 }
 function cargar_a_obra_sel_href() {
    
    //var valor0 = valor0_encode;
    //var valor0 = JSON.parse(valor0_encode);
   // var nuevo_valor=window.prompt("Nuevo valor de "+prompt , valor0);
//    alert("el nuevo valor es: "+valor) ;
//   alert('debug') ;
   var id_obra=document.getElementById("id_obra").value ;
//   var d= new Date() ;
//   var date_str=d.toISOString();

//   table_selection_IN()
   window.open('../proveedores/fra_prov_cargar_a_obra.php?id_fra_prov_sel='+table_selection_IN()+'&id_obra='+id_obra);
//   window.open('../obras/obras_anadir_parte.php?id_obra='+id_obra, '_blank');
 //echo "<a class='btn btn-primary' href= '../obras/obras_anadir_parte.php?id_obra=$id_obra' >Añadir parte</a><br>" ;
        

    
    return ;
 }

function genera_remesa()
{
    
 var id_remesa=document.getElementById("id_remesa").value ;

//    alert( id_remesa ) ;
 window.open("../bancos/remesa_anadir_selection.php?id_remesa="+id_remesa+"&array_str=" + table_selection() )   ;
// window.open("../bancos/remesa_anadir_selection.php?id_remesa="+id_remesa+"&array_str=1"  )   ;
 //window.open("../menu/pagina_inicio.php")   ;
    
}

//function ver_remesa()
//{
//    
// var id_remesa=document.getElementById("id_remesa").value ;
//
//  //  alert( table_selection() ) ;
// window.open("../bancos/remesa_ficha.php?id_remesa="+id_remesa )   ;
// //window.open("../menu/pagina_inicio.php")   ;
//    
//} 
//function cargar_a_obra()
//{
//    alert( 'PENDIENTE DE DESARROLLO' ) ;
//// window.open("../bancos/remesa_anadir_selection.php?array_str=" + table_selection() )   ;
// //window.open("../menu/pagina_inicio.php")   ;
//    
//}
// 
    
</script>
        
                </div>
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