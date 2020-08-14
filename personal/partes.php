<?php
// cambios
require_once("../include/session.php");
$where_c_coste = " id_c_coste={$_SESSION['id_c_coste']} ";
$id_c_coste = $_SESSION['id_c_coste'];

$titulo = 'Partes diarios';

//INICIO
include_once('../templates/_inc_privado1_header.php');
include_once('../templates/_inc_privado2_navbar.php');

?>

        <!-- Contenido principal -->
        <div class="container-fluid bg-light">
            <div class="row">
                <!--****************** ESPACIO LATERAL  *****************-->
                <div class="col-12 col-md-4 col-lg-3"></div>
                <!--****************** ESPACIO LATERAL  *****************-->

                <!--****************** BUSQUEDA GLOBAL  *****************-->
                <div class="col-12 col-md-4 col-lg-9">

<?php 

// require_once("../personal/personal_menutop_r.php");


$iniciar_form=(!isset($_POST["agrupar"])) ;  // determinamos si debemos de inicializar el FORM con valores vacíos

// INICIALIZACION DE VARIABLES



// $nombre= isset($_POST["nombre"]) ? $_POST["nombre"] : "" ;
$nombre= isset($_GET["nombre"]) ? $_GET["nombre"] : ( isset($_POST["nombre"]) ? $_POST["nombre"] : "" )  ;
$maquinaria= isset($_GET["maquinaria"]) ? $_GET["maquinaria"] : ( isset($_POST["maquinaria"]) ? $_POST["maquinaria"] : "" )  ;
$fecha1= isset($_GET["fecha1"]) ? $_GET["fecha1"] : ( isset($_POST["fecha1"]) ? $_POST["fecha1"] : (isset($_GET["fechas"])?  $_GET["fechas"] : "" ) ) ;
$fecha2= isset($_GET["fecha2"]) ? $_GET["fecha2"] : ( isset($_POST["fecha2"]) ? $_POST["fecha2"] : (isset($_GET["fechas"])?  $_GET["fechas"] : "" ) )    ;

$observaciones= isset($_GET["observaciones"]) ? $_GET["observaciones"] : ( isset($_POST["observaciones"]) ? $_POST["observaciones"] : "" )  ;




// $maquinaria= isset($_POST["maquinaria"]) ? $_POST["maquinaria"] : "" ;

// $fecha1= isset($_POST["fecha1"]) ? $_POST["fecha1"] : "" ;
// $fecha2= isset($_POST["fecha2"]) ? $_POST["fecha2"] : "" ;
        
// $observaciones= isset($_POST["observaciones"]) ? $_POST["observaciones"] : "" ;
 $fecha_cal= isset($_GET["fecha_cal"]) ? $_GET["fecha_cal"] : ( isset($_POST["fecha_cal"]) ? $_POST["fecha_cal"] : date('Y-m-d') )  ;
 $agrupar= isset($_GET["agrupar"]) ? $_GET["agrupar"] : ( isset($_POST["agrupar"]) ? $_POST["agrupar"] : "cal_obras" )  ;
       
//        $fecha1=$_POST["fecha1"] ;  
//        $fecha2=$_POST["fecha2"] ;  
//        
//        $observaciones=$_POST["observaciones"] ;
////        $pagada=$_POST["pagada"] ;
//        $agrupar =$_POST["agrupar"] ;     
   
  

// Comprobamos si es el listado de un único proveedor o un listado global

$listado_global= (!isset($_GET["id_obra"])) ;

// --------- VARIABLES PARA TABLA_CALENDAR

// $fecha_cal=  isset($_GET["fecha_cal"]) ? $_GET["fecha_cal"] :  date('Y-m-d') ;

//if (isset($_GET["fecha_cal"]))  // cogemos la $fecha_cal (determina el MES) de $fecha1, $fecha2 o la fecha actual
//     {  $fecha_cal=$_GET["fecha_cal"] ; }
//elseif (!$fecha1=="")    
//     {  $fecha_cal=$fecha1 ; } 
//elseif (!$fecha2=="")    
//     {  $fecha_cal=$fecha2 ; } 
//else
//     {  $fecha_cal=date('Y-m-d') ; }   // si no hay otra fecha cogemos la de hoy
     
$fecha_db_cal="Fecha" ;   // determinamos el campo DATETIME que se ubicará el Calendario   

//      ----- FIN CONFIG. TABLA_CALENDAR





if (!$listado_global)                
  { 
    $id_obra=$_GET["id_obra"];         // Estamos viendo las Facturas de un único proveedor
    $obra=Dfirst("NOMBRE_OBRA", "OBRAS", "ID_OBRA=$id_obra AND $where_c_coste" )  ;
    require_once("../obras/obras_menutop_r.php");          // añadimos el Menu de Proveedores
//    $link_calendar_mes="partes.php?id_obra=$id_obra&fecha_cal=" ;  // link para avanzar o retroceder meses

//   echo "<a class='btn btn-primary' href= 'partes.php' >Partes de todas las obras</a><br>" ;
 
//   if ($iniciar_form) { $agrupar = 'facturas' ;}   // si no es Global, mejor agrupar por facturas del proveedor seleccionado
    
   
  }
  else
  { // si es listado_global añadimos  la variable del form 'proveedor'
      require_once("../personal/personal_menutop_r.php"); 
    if ($iniciar_form)    
    {   $obra="" ;}
    else
    {  $obra=$_POST["obra"] ; }
//    $link_calendar_mes="partes.php?fecha_cal=" ;  // link para avanzar o retroceder meses

  } 

  // inicializamos las variables o cogemos su valor del _POST

  ?>

<div style="overflow:visible">	   
 
<div id="main" class="mainc_100" style="background-color:#fff">

<?php 

if ($listado_global)                // Estamos en pantalla de LISTADO GLOBALES (es decir, en toda la empres)
{ 
    echo "<h2>PARTES DIARIOS</h2>"  ;
    echo "<form action='../personal/partes.php' method='post' id='form1' name='form1'>"    ;
    
    echo "<TABLE >"  ;
   
    echo "<TR><TD>OBRA</TD><TD><INPUT type='text' id='obra' name='obra' value='$obra'><button type='button' onclick=\"document.getElementById('obra').value='' \" >*</button></TD></TR>" ;
//    echo "<TR><TD>OBRA       </TD><TD><INPUT type='text' id='N_OBRA' name='N_OBRA' value='$N_OBRA'><button type='button' onclick=\"document.getElementById('N_OBRA').value='' \" >*</button></TD></TR>" ;
}
 else
{
    echo "<a class='btn btn-link noprint' href= '../personal/partes.php' ><i class='fas fa-globe-europe'></i> Partes de todas las obras</a><br>" ;

    echo "<h3>PARTES DIARIOS<br><B>$obra</B></h3>"  ;
    echo "<form action='../personal/partes.php?id_obra=$id_obra' method='post' id='form1' name='form1'>"    ;
    
    echo "<TABLE align='center'>"  ;
}    

$fecha_hoy=date('Y-m-d');

echo "<TR><TD>Nombre  </TD><TD><INPUT type='text' id='nombre'   name='nombre'  value='$nombre'><button type='button' onclick=\"document.getElementById('nombre').value='' \" >*</button></TD></TR>" ;
echo "<TR><TD>Maquinaria  </TD><TD><INPUT type='text' id='maquinaria'   name='maquinaria'  value='$maquinaria'><button type='button' onclick=\"document.getElementById('maquinaria').value='' \" >*</button></TD></TR>" ;
echo "<TR><TD>Fecha mín.     </TD><TD><INPUT type='date' id='fecha1'     name='fecha1'    value='$fecha1'><button type='button' onclick=\"document.getElementById('fecha1').value='' \" >*</button><button type='button' onclick=\"document.getElementById('fecha1').value='$fecha_hoy' \" >Hoy</button></TD></TR>" ;
echo "<TR><TD>Fecha máx.     </TD><TD><INPUT type='date' id='fecha2'     name='fecha2'    value='$fecha2'><button type='button' onclick=\"document.getElementById('fecha2').value='' \" >*</button><button type='button' onclick=\"document.getElementById('fecha2').value='$fecha_hoy' \" >Hoy</button></TD></TR>" ;
echo "<TR><TD>Observaciones </TD><TD><INPUT type='text' id='observaciones' name='observaciones' value='$observaciones'><button type='button' onclick=\"document.getElementById('observaciones').value='' \" >*</button></TD></TR>" ;

echo "<INPUT type='hidden' id='fecha_cal' name='fecha_cal' value='$fecha_cal'>" ;

//echo "<TR><TD>Pagada    </TD><TD><INPUT type='text' id='pagada'    name='pagada'   value='$pagada'><button type='button' onclick=\"document.getElementById('pagada').value='' \" >*</button></TD></TR>" ;

echo "<TR><TD colspan=2 align='center' ><INPUT type='submit' class='btn btn-success btn-xl noprint' value='Actualizar' id='submit' name='submit'></TD></TR>" ;

echo "</TABLE>"  ;



$btnt['ultimos_partes']=['ultimos','Últimos Partes registrados', ''] ;
$btnt['partes']=['partes','Listado de partes seleccionados',''] ;
$btnt['meses']=['meses','Agrupados por meses',''] ;
$btnt['annos']=['años','Agrupados por Años',''] ;
$btnt['vacio1']=['','',''] ;
$btnt['obras']=['obras','Agrupados por obras',''] ;   //subobras_udos
$btnt['obras_mes']=['<i class="fas fa-list"></i> Mensual obras','Cuadro Mensual de obras y días del mes. Hay que seleccionar las fechas de inicio y fin de mes',''] ;   //subobras_udos
$btnt['cal_obras']=['<i class="far fa-calendar-alt"></i> Cal. Obras','Calendario de Partes de Obra', ''] ;
$btnt['vacio2']=['','',''] ;
//if ($listado_global) { $btnt['obras']=['obras','Agrupa por Obra',''] ;}
$btnt['nombres']=['Nombres','Detalle de los empleados que están registrados en los partes seleccionados',''] ;
$btnt['nombres_grupo']=['Nombres resumen','Resumen de los empleados que están registrados en los partes seleccionados',''] ;
$btnt['nombres_mes']=['<i class="fas fa-list"></i> Mensual Nombres','Cuadro Mensual de los empleados que están registrados en los partes seleccionados',''] ;
$btnt['cal_nombres']=['<i class="far fa-calendar-alt"></i> Cal. Nombres','Calendario con los empleados que están registrados en los partes seleccionados',''] ;
$btnt['vacio']=['','' ,'' ] ;
$btnt['maquinaria_mes']=['<i class="fas fa-list"></i> Mensual Maquinaria','Cuadro de presencia mensual de la Maquinaria' ,'' ] ;
$btnt['cal_maquinaria']=['<i class="far fa-calendar-alt"></i> Cal. Maquinaria','Calendario de presencia mensual de la Maquinaria' ,'' ] ;

foreach ( $btnt as $clave => $valor)
{
  $active= ($clave==$agrupar) ? " cc_active" : "" ; 
  $disabled= isset($valor[2]) ? $valor[2] : ""  ;
//  echo "<button $disabled id='btn_agrupar_$clave' class='cc_btnt$active' title='{$valor[1]}' onclick=\"getElementById('agrupar').value = '$clave'; document.getElementById('form1').submit(); \">{$valor[0]}</button>" ;  
  echo (substr($clave,0,5)=='vacio') ? "  " : "<button $disabled id='btn_agrupar_$clave' class='cc_btnt$active' title='{$valor[1]}' "
                    . " onclick=\"getElementById('agrupar').value = '$clave'; document.getElementById('form1').submit(); \">{$valor[0]}</button>" ;  
//  echo "<button class='cc_btnt$active' title='{$valor[1]}' onclick=\"getElementById('agrupar').value = '$clave'; document.getElementById('form1').submit(); \">{$valor[0]}</button>" ;  
                    
}           


?>


<!--<button   onclick="getElementById('agrupar').value = 'subcentros'; document.getElementById('form1').submit();">subcentros</button>-->

<input type="hidden"  id="agrupar"  name="agrupar" value='<?php echo $agrupar ; ?>'>


<!--</form>-->
			
<?php   // Iniciamos variables para tabla.php  background-color:#B4045


//$FECHA1= date_replace($FECHA1) ;
//$FECHA2= date_replace($FECHA2) ;
$where=$where_c_coste;  // inicializo la variable que hará el WHERE

if ($listado_global)                // Estamos en pantalla de LISTADO GLOBAL (toda la empresa no solo en un proveedor concreto)
{    
// adaptamos todos los filtros, quitando espacios a ambos lados con trim() y sustituyendo espacios por '%' para el LIKE 
$where=$obra==""? $where : $where . " AND NOMBRE_OBRA LIKE '%".str_replace(" ","%",trim($_POST["obra"]))."%'" ;
}
else
{
$where= $where . " AND ID_OBRA=$id_obra " ;    // Estamos en partes de una Obra o Maquinaria específica
}    

$where=$fecha1==""? $where : $where . " AND FECHA >= '$fecha1' " ;
$where=$fecha2==""? $where : $where . " AND FECHA <= '$fecha2' " ;
//$where=$importe1==""? $where : $where . " AND IMPORTE_IVA > $importe1" ;
//$where=$importe2==""? $where : $where . " AND IMPORTE_IVA < $importe2" ;
$where=$observaciones==""? $where : $where . " AND Observaciones LIKE '%".str_replace(" ","%",trim($observaciones))."%'" ;


$where_nombre = ($nombre=="")? "1=1" : "  NOMBRE LIKE '%".str_replace(" ","%",trim($nombre))."%'" ;

$where_maquinaria = ($maquinaria=="")? "1=1" : "  Maquinaria LIKE '%".str_replace(" ","%",trim($maquinaria))."%'" ;

$select_dias="" ;
for ($x = 1; $x <= 31; $x++) {
//    echo "The number is: $x <br>";
    $select_dias.= "SUM(Dia_mes=$x) AS d$x ,MAX((Dia_mes=$x)*ID_PARTE) AS ID_PARTE_d$x " ; 
    if ($x < 31)  {$select_dias.= " , " ;}
} 

 $sql_T="SELECT '' " ;
 
$select_NOMBRE_OBRA= ($listado_global) ? " , NOMBRE_OBRA " : ""     ;
 
 switch ($agrupar) {
    case "ultimos_partes":
//     $sql="SELECT * FROM Partes_Personal_View WHERE $where  ORDER BY Fecha DESC LIMIT 50 " ;
      $sql="SELECT ID_PARTE, ID_OBRA, ID_PARTE AS nid_Parte  $select_NOMBRE_OBRA,Fecha,NumP, importe_parte,Observaciones FROM Partes_ViewC "
            . " WHERE ID_PARTE IN (SELECT ID_PARTE FROM Partes_Personal_View WHERE $where AND $where_nombre) ORDER BY fecha_creacion  DESC LIMIT 50 " ;
//        echo $sql;
     $sql_T="SELECT '' " ;
     $col_sel="ID_PARTE" ;
    
     
    // AÑADE BOTON DE 'BORRAR' PARTE . SOLO BORRARÁ SI ESTÁ VACÍO DE PERSONAL 
    $actions_row=[];
    $actions_row["id"]="ID_PARTE";
    $actions_row["delete_link"]="1";     
    break;
     case "partes":
//     $sql="SELECT * FROM Partes_Personal_View WHERE $where AND $where_nombre  ORDER BY Fecha DESC LIMIT 50 " ;
      $sql="SELECT ID_PARTE, ID_OBRA, ID_PARTE AS nid_Parte  $select_NOMBRE_OBRA,Fecha,NumP, importe_parte,Observaciones FROM Partes_ViewC "
            . " WHERE ID_PARTE IN (SELECT ID_PARTE FROM Partes_Personal_View WHERE $where AND $where_nombre) ORDER BY Fecha " ;
     $sql_T="SELECT '' " ;
     $col_sel="ID_PARTE" ;
     
    // AÑADE BOTON DE 'BORRAR' PARTE . SOLO BORRARÁ SI ESTÁ VACÍO DE PERSONAL 
    $actions_row=[];
    $actions_row["id"]="ID_PARTE";
    $actions_row["delete_link"]="1";     
    break;
   case "cal_obras":
       
         
//     $sql="SELECT * FROM Partes_Personal_View WHERE $where AND $where_nombre  ORDER BY Fecha DESC LIMIT 50 " ;
//      $sql="SELECT ID_PARTE, ID_OBRA, NOMBRE_OBRA,Fecha,NumP, Cargado,Observaciones FROM Partes_View WHERE $where AND $where_nombre ORDER BY  Fecha  " ;
    $no_cargado= "<span style=\'color:red;\' title=\'Parte No Cargado a obra\'> (NC)</span>" ;  
    if ($listado_global)    
    {
//     $sql="SELECT ID_PARTE, ID_OBRA, MID(NOMBRE_OBRA,1,20) as link_calendario,Fecha,NumP,IF(Cargado,'', '$no_cargado' ) as cc "
//            . "FROM Partes_View WHERE $where AND $where_nombre ORDER BY  Fecha,NOMBRE_OBRA   " ;
    $sql="SELECT ID_PARTE, ID_OBRA, CONCAT(MID(NOMBRE_OBRA,1,20),'...') as link_calendario,Observaciones as id_link_calendario_TOOLTIP,Fecha,' ' as a1,NumP,' ' as br,(NumV) AS Num_otros_alb, "
            . " ' ' as br3, fotos, ' ' as br7, NumProd, IF(Cargado,'','$no_cargado') as cc "
            . " FROM Partes_ViewC WHERE ID_PARTE IN (SELECT ID_PARTE FROM Partes_Personal_View WHERE $where AND $where_nombre) ORDER BY  Fecha,NOMBRE_OBRA   " ;
    }else
    { $sql="SELECT ID_PARTE, ID_OBRA, CONCAT(MID(NOMBRE_OBRA,1,20),'...') as link_calendario,Observaciones as id_link_calendario_TOOLTIP,Fecha,'<br>' as a1,NumP,importe_parte,'<br>' as br,(NumV) AS Num_otros_alb, "
            . "importe_otros_alb,'<br>' as br3, fotos,'<br>' as br7, NumProd,importe_prod, IF(Cargado,'','$no_cargado') as cc "
            . " FROM Partes_ViewC WHERE ID_PARTE IN (SELECT ID_PARTE FROM Partes_Personal_View WHERE $where AND $where_nombre) ORDER BY  Fecha,NOMBRE_OBRA   " ;
    }
    
    $sql_T="SELECT '' " ;
    
    $link_calendar_dia="../personal/partes.php?agrupar=partes&fechas=" ;
    
    break;
   case "cal_nombres":
       
     
//     $sql="SELECT * FROM Partes_Personal_View WHERE $where  ORDER BY Fecha DESC LIMIT 50 " ;
//      $sql="SELECT ID_PARTE, ID_OBRA, NOMBRE_OBRA,Fecha,NumP, Cargado,Observaciones FROM Partes_View WHERE $where ORDER BY  Fecha  " ;
    if ($listado_global)    
    {
        $sql="SELECT ID_PARTE,ID_PERSONAL ,ID_OBRA,Fecha,CONCAT(NOMBRE,' (' ,MID(NOMBRE_OBRA,1,10),')') as link_calendario ,Observaciones as id_link_calendario_TOOLTIP"
                . " ,HO,IF(HX>0,CONCAT('+<b>',HX,'</b>'),'')"
                . "  FROM Partes_Personal_View WHERE $where AND $where_nombre ORDER BY  Fecha,NOMBRE  " ;
//        $sql="SELECT ID_PARTE,ID_PERSONAL ,ID_OBRA,Fecha,CONCAT(NOMBRE,' (' ,MID(NOMBRE_OBRA,1,12),')') as link_calendario ,HO,IF(HX>0,HX,7)  FROM Partes_Personal_View WHERE $where ORDER BY  Fecha,NOMBRE  " ;
    }else
    { $sql="SELECT ID_PARTE,ID_PERSONAL ,ID_OBRA,Fecha,NOMBRE as link_calendario ,Observaciones as id_link_calendario_TOOLTIP"
            . ",HO,IF(HX>0,CONCAT('+<b>',HX,'</b>'),'') FROM Partes_Personal_View WHERE $where AND $where_nombre ORDER BY  Fecha,NOMBRE  " ;
    }        
    $sql_T="SELECT '' " ;
//    echo $sql ;
    
    break;
    case "obras":
     $sql="SELECT  ID_OBRA $select_NOMBRE_OBRA ,COUNT(ID_PARTE) AS Num_Partes,SUM(HO) AS Num_Horas_Ordinarias_HO,SUM(HX) AS Num_Horas_Extras_HX   FROM Partes_Personal_View "
            . " WHERE $where AND $where_nombre GROUP BY ID_OBRA ORDER BY  NOMBRE_OBRA  " ;
     $sql_T="SELECT  'Suma' ,COUNT(ID_PARTE) AS Num_Partes,SUM(HO) AS Num_Horas_Ordinarias_HO,SUM(HX) AS Num_Horas_Extras_HX   FROM Partes_Personal_View WHERE $where AND $where_nombre   " ;
//     $sql="SELECT  ID_OBRA $select_NOMBRE_OBRA ,COUNT(ID_PARTE) AS Num_Partes  FROM Partes_Personal_View WHERE $where GROUP BY ID_OBRA ORDER BY  NOMBRE_OBRA  " ;
//     $sql_T="SELECT  'Suma'   FROM Partes_Personal_View WHERE $where   " ;
//     echo $sql;
//     echo $sql_T;
     //$sql_T="SELECT '','Suma' , SUM(IMPORTE) as importe  FROM ConsultaGastos_View WHERE $where    " ;
    break;
   case "obras_mes":
     $sql="SELECT ID_OBRA,NOMBRE_OBRA,COUNT( ID_OBRA ) AS Dias  ,  $select_dias FROM Partes_Obras_View "
           . "WHERE ID_PARTE IN (SELECT ID_PARTE FROM Partes_Personal_View WHERE $where AND $where_nombre) GROUP BY ID_OBRA  ORDER BY NOMBRE_OBRA " ;
//     $sql_T="SELECT '' AS a,'' AS b,'' AS c,'' AS d, SUM(IMPORTE_IVA) AS IMPORTE_IVA,SUM(pdte_conciliar) AS pdte_conciliar  FROM Partes_Personal_View WHERE $where  " ;   
     break;

   case "nombres":
      $sql="SELECT id,ID_OBRA,ID_PARTE,ID_PERSONAL,Fecha,NOMBRE  $select_NOMBRE_OBRA,HO,HX FROM Partes_Personal_View WHERE $where AND $where_nombre  ORDER BY  Fecha  " ;
      $sql_T="SELECT '' AS a,'' AS b,'' AS c,SUM(HO),SUM(HX) FROM Partes_Personal_View WHERE $where AND $where_nombre ORDER BY  Fecha  " ;
     break;
    case "nombres_grupo":
      $sql="SELECT id,ID_PARTE,ID_PERSONAL,NOMBRE,SUM(HO) AS HO,SUM(HX) AS HX FROM Partes_Personal_View WHERE $where AND $where_nombre GROUP BY ID_PERSONAL ORDER BY  NOMBRE  " ;
      $sql_T="SELECT '' AS c,SUM(HO),SUM(HX) FROM Partes_Personal_View WHERE $where AND $where_nombre   " ;
     break;
 
    case "nombres_mes":
     $sql="SELECT  ID_PERSONAL,NOMBRE,COUNT( ID_PERSONAL ) AS Dias , SUM(HO) AS HO,SUM(HX) AS HX,SUM(HX) AS HX,SUM(MD) AS MD,SUM(DC) AS DC "
            . ", $select_dias FROM Partes_Personal_View WHERE $where AND $where_nombre GROUP BY ID_PERSONAL  ORDER BY NOMBRE " ;
//     $sql_T="SELECT '' AS a,'' AS b,'' AS c,'' AS d, SUM(IMPORTE_IVA) AS IMPORTE_IVA,SUM(pdte_conciliar) AS pdte_conciliar  FROM Partes_Personal_View WHERE $where  " ;   
//        echo $sql;
     break;
     case "maquinaria_mes":
     $sql="SELECT id_parte,id_obra_mq,id_concepto_mq,Maquinaria,CONCEPTO,COSTE,SUM(cantidad) AS Cantidad,SUM(cantidad)*COSTE AS Importe ,  $select_dias"
             . "   FROM Partes_Maquinas_View WHERE $where AND $where_maquinaria GROUP BY id_obra_mq  ORDER BY Maquinaria " ;
     $sql_T="SELECT '' as a,'' as a2, '' as aa,'Suma', SUM(cantidad)*COSTE AS Importe "
             . "   FROM Partes_Maquinas_View WHERE $where AND $where_maquinaria " ;
//     echo $sql;    
//     $sql_T="SELECT '' AS a,'' AS b,'' AS c,'' AS d, SUM(IMPORTE_IVA) AS IMPORTE_IVA,SUM(pdte_conciliar) AS pdte_conciliar  FROM Partes_Personal_View WHERE $where  " ;   
     break;
   case "cal_maquinaria":
    if ($listado_global)    
    {
//     $sql="SELECT id_parte,id_obra_mq,id_concepto_mq,Maquinaria,CONCEPTO,COSTE,SUM(cantidad) AS Cantidad,SUM(cantidad)*COSTE AS Importe ,  $select_dias"
//             . "   FROM Partes_Maquinas_View WHERE $where $where_maquinaria GROUP BY id_obra_mq  ORDER BY Maquinaria " ;
        
        $sql="SELECT id_parte,id_obra_mq ,ID_OBRA,Fecha,CONCAT(Maquinaria,' (' ,MID(NOMBRE_OBRA,1,10),')') as link_calendario,'' as id_link_calendario_TOOLTIP  "
                . "  FROM Partes_Maquinas_View WHERE $where AND $where_maquinaria ORDER BY  Fecha,Maquinaria  " ;
//        $sql="SELECT ID_PARTE,ID_PERSONAL ,ID_OBRA,Fecha,CONCAT(NOMBRE,' (' ,MID(NOMBRE_OBRA,1,12),')') as link_calendario ,HO,IF(HX>0,HX,7)  FROM Partes_Personal_View WHERE $where ORDER BY  Fecha,NOMBRE  " ;
    }else
    {
//        $sql="SELECT ID_PARTE,ID_PERSONAL ,ID_OBRA,Fecha,NOMBRE as link_calendario ,HO,IF(HX>0,CONCAT('+<b>',HX,'</b>'),'') FROM Partes_Personal_View WHERE $where ORDER BY  Fecha,NOMBRE  " ;
        $sql="SELECT id_parte,id_obra_mq ,ID_OBRA,Fecha,Maquinaria as link_calendario ,cantidad "
                . "  FROM Partes_Maquinas_View WHERE $where AND $where_maquinaria ORDER BY  Fecha,Maquinaria  " ;
        
    }        
    $sql_T="SELECT '' " ;
//    echo $sql ;
    
    break;

    case "meses":
    $sql="SELECT DATE_FORMAT(Fecha, '%Y-%m') as MES, SUM(NumP) AS Num_Partes, SUM(importe_parte) AS importe_parte FROM Partes_ViewC "
            . " WHERE ID_PARTE IN (SELECT ID_PARTE FROM Partes_Personal_View WHERE $where AND $where_nombre) GROUP BY MES ORDER BY MES " ;
    $sql_T="SELECT 'Total', SUM(NumP) AS Num_Partes, SUM(importe_parte) AS importe_parte FROM Partes_ViewC "
            . " WHERE ID_PARTE IN (SELECT ID_PARTE FROM Partes_Personal_View WHERE $where AND $where_nombre)  " ;

    
    break;
   case "annos":
//    $sql="SELECT  DATE_FORMAT(FECHA, '%Y') as anno,SUM(IMPORTE_IVA) as IMPORTE_IVA,SUM(pdte_conciliar) AS pdte_conciliar  FROM Fras_Prov_View WHERE $where  GROUP BY anno  ORDER BY anno  " ;
//    $sql_T="SELECT '' AS D, SUM(IMPORTE_IVA) as IMPORTE_IVA,SUM(pdte_conciliar) AS pdte_conciliar  FROM Fras_Prov_View WHERE $where  " ;
// 
    $sql="SELECT DATE_FORMAT(Fecha, '%Y') as ANNO, SUM(NumP) AS Num_Partes, SUM(importe_parte) AS importe_parte FROM Partes_ViewC "
            . " WHERE ID_PARTE IN (SELECT ID_PARTE FROM Partes_Personal_View WHERE $where AND $where_nombre) GROUP BY ANNO ORDER BY ANNO " ;
    $sql_T="SELECT 'Total', SUM(NumP) AS Num_Partes, SUM(importe_parte) AS importe_parte FROM Partes_ViewC "
            . " WHERE ID_PARTE IN (SELECT ID_PARTE FROM Partes_Personal_View WHERE $where AND $where_nombre)  " ;

    break;
   
  
 }

 if (!$listado_global)   
 {
     echo "<a class='btn btn-link noprint' href= '../obras/obras_anadir_parte.php?_m=$_m&id_obra=$id_obra' ><i class='fas fa-plus-circle'></i> Añadir parte</a><br>" ;
//     echo   "<a class='btn btn-primary' href='../proveedores/factura_proveedor_anadir.php'  >Añadir Factura proveedor</a>" ; // BOTON AÑADIR FACTURA

 }
 else
 {
    // Creamos el combo <select> con los NOMBRE_OBRA para Añadir Parte de Obra a cualqier obra
 ?>
<div class="container" style="border-width:1px; border-style:solid;">
<!--    <div class="form-group">-->
 <!--<h3>Selección</h3>-->
      Añadir Parte a Obra:
      <select  id="id_obra" style="width: 30%;">
       <?php echo DOptions_sql("SELECT ID_OBRA,NOMBRE_OBRA FROM OBRAS WHERE $where_c_coste AND activa ORDER BY activa DESC,NOMBRE_OBRA ") ?>
      </select>
      <a class='btn btn-link' href='#'  onclick='add_parte_obra_href();'><i class="fas fa-plus-circle"></i> añadir Parte</a>
     
      <?php if (isset($col_sel))  echo "<br><a class='btn btn-link' href='#' onclick='partes_pdf_sel_href()' title='Listado de partes para enviar a PDF' >enviar a PDF seleccionados</a><br>" ; ?>

<!--    </div>-->
</div>
 
<?php
 }
 
//echo $sql ;
$result=$Conn->query($sql) ;
if (isset($sql_T)) {$result_T=$Conn->query($sql_T) ;} 

echo "<font size=1 color=silver>Agrupar por : $agrupar <br> {$result->num_rows} filas </font> " ;

  $updates=[ 'Observaciones']  ;
//  $ocultos=['link_calendario_TOOLTIP' ]  ;
//  $id_proveedor=$rs["ID_PROVEEDORES"] ;
  $tabla_update="PARTES" ;
  $id_update="ID_PARTE" ;
//  $id_valor=$id_parte ;

$formats["Fecha"] = "fecha" ;  
$formats["importe_parte"] = "moneda" ;  
$formats["importe_otros_alb"] = "moneda" ;  
$formats["Num_otros_alb"] = "icon_albaranes" ;  
$formats["Cargado"] = "boolean" ;  
$formats["NumP"] = "icon_usuarios" ;  
$formats["fotos"] = "icon_fotos" ;  
$formats["NumProd"] = "icon_produccion" ;  
  
$dblclicks=[];
$dblclicks["NOMBRE"]="nombre" ;
$dblclicks["NOMBRE_OBRA"]="obra" ;
$dblclicks["MES"]="fecha1" ;
//$dblclicks["CONCEPTO"]="CONCEPTO" ;
//$dblclicks["TIPO_GASTO"]="TIPO_GASTO" ;

$links["NOMBRE_OBRA"] = ["../obras/obras_ficha.php?id_obra=", "ID_OBRA"] ;
$links["Maquinaria"] = ["../obras/obras_ficha.php?id_obra=", "id_obra_mq"] ;
$links["CONCEPTO"] = ["../proveedores/concepto_ficha.php?id_concepto=", "id_concepto_mq"]  ;
$links["NOMBRE"] = ["../personal/personal_ficha.php?id_personal=", "ID_PERSONAL"] ;
$links["nid_Parte"] = ["../personal/parte.php?id_parte=", "ID_PARTE"] ;
$links["link_calendario"] = ["../personal/parte.php?id_parte=", "ID_PARTE", "id_link_calendario_TOOLTIP"] ;
//$links["parte_obra"] = ["../personal/parte.php?id_parte=", "ID_PARTE"] ;


// links del Calendario Obras-Partes
$links["d1"] = ["../personal/parte.php?id_parte=", "ID_PARTE_d1","ver Parte", "formato_sub_vacio"] ;
$links["d2"] = ["../personal/parte.php?id_parte=", "ID_PARTE_d2","ver Parte", "formato_sub_vacio"] ;
$links["d3"] = ["../personal/parte.php?id_parte=", "ID_PARTE_d3","ver Parte", "formato_sub_vacio"] ;
$links["d4"] = ["../personal/parte.php?id_parte=", "ID_PARTE_d4","ver Parte", "formato_sub_vacio"] ;
$links["d5"] = ["../personal/parte.php?id_parte=", "ID_PARTE_d5","ver Parte", "formato_sub_vacio"] ;
$links["d6"] = ["../personal/parte.php?id_parte=", "ID_PARTE_d6","ver Parte", "formato_sub_vacio"] ;
$links["d7"] = ["../personal/parte.php?id_parte=", "ID_PARTE_d7","ver Parte", "formato_sub_vacio"] ;
$links["d8"] = ["../personal/parte.php?id_parte=", "ID_PARTE_d8","ver Parte", "formato_sub_vacio"] ;
$links["d9"] = ["../personal/parte.php?id_parte=", "ID_PARTE_d9","ver Parte", "formato_sub_vacio"] ;
$links["d10"] = ["../personal/parte.php?id_parte=", "ID_PARTE_d10","ver Parte", "formato_sub_vacio"] ;
$links["d11"] = ["../personal/parte.php?id_parte=", "ID_PARTE_d11","ver Parte", "formato_sub_vacio"] ;
$links["d12"] = ["../personal/parte.php?id_parte=", "ID_PARTE_d12","ver Parte", "formato_sub_vacio"] ;
$links["d13"] = ["../personal/parte.php?id_parte=", "ID_PARTE_d13","ver Parte", "formato_sub_vacio"] ;
$links["d14"] = ["../personal/parte.php?id_parte=", "ID_PARTE_d14","ver Parte", "formato_sub_vacio"] ;
$links["d15"] = ["../personal/parte.php?id_parte=", "ID_PARTE_d15","ver Parte", "formato_sub_vacio"] ;
$links["d16"] = ["../personal/parte.php?id_parte=", "ID_PARTE_d16","ver Parte", "formato_sub_vacio"] ;
$links["d17"] = ["../personal/parte.php?id_parte=", "ID_PARTE_d17","ver Parte", "formato_sub_vacio"] ;
$links["d18"] = ["../personal/parte.php?id_parte=", "ID_PARTE_d18","ver Parte", "formato_sub_vacio"] ;
$links["d19"] = ["../personal/parte.php?id_parte=", "ID_PARTE_d19","ver Parte", "formato_sub_vacio"] ;
$links["d20"] = ["../personal/parte.php?id_parte=", "ID_PARTE_d20","ver Parte", "formato_sub_vacio"] ;
$links["d21"] = ["../personal/parte.php?id_parte=", "ID_PARTE_d21","ver Parte", "formato_sub_vacio"] ;
$links["d22"] = ["../personal/parte.php?id_parte=", "ID_PARTE_d22","ver Parte", "formato_sub_vacio"] ;
$links["d23"] = ["../personal/parte.php?id_parte=", "ID_PARTE_d23","ver Parte", "formato_sub_vacio"] ;
$links["d24"] = ["../personal/parte.php?id_parte=", "ID_PARTE_d24","ver Parte", "formato_sub_vacio"] ;
$links["d25"] = ["../personal/parte.php?id_parte=", "ID_PARTE_d25","ver Parte", "formato_sub_vacio"] ;
$links["d26"] = ["../personal/parte.php?id_parte=", "ID_PARTE_d26","ver Parte", "formato_sub_vacio"] ;
$links["d27"] = ["../personal/parte.php?id_parte=", "ID_PARTE_d27","ver Parte", "formato_sub_vacio"] ;
$links["d28"] = ["../personal/parte.php?id_parte=", "ID_PARTE_d28","ver Parte", "formato_sub_vacio"] ;
$links["d29"] = ["../personal/parte.php?id_parte=", "ID_PARTE_d29","ver Parte", "formato_sub_vacio"] ;
$links["d30"] = ["../personal/parte.php?id_parte=", "ID_PARTE_d30","ver Parte", "formato_sub_vacio"] ;
$links["d31"] = ["../personal/parte.php?id_parte=", "ID_PARTE_d31","ver Parte", "formato_sub_vacio"] ;


$formats["d1"] = "cuadro_mes" ;$formats["d2"] = "cuadro_mes" ;$formats["d3"] = "cuadro_mes" ;$formats["d4"] = "cuadro_mes" ;$formats["d5"] = "cuadro_mes" ;$formats["d6"] = "cuadro_mes" ;$formats["d7"] = "cuadro_mes" ;
$formats["d8"] = "cuadro_mes" ;$formats["d9"] = "cuadro_mes" ;$formats["d10"] = "cuadro_mes" ;$formats["d11"] = "cuadro_mes" ;$formats["d12"] = "cuadro_mes" ;$formats["d13"] = "cuadro_mes" ;$formats["d14"] = "cuadro_mes" ;
$formats["d15"] = "cuadro_mes" ;$formats["d16"] = "cuadro_mes" ;$formats["d17"] = "cuadro_mes" ;$formats["d18"] = "cuadro_mes" ;$formats["d19"] = "cuadro_mes" ;$formats["d20"] = "cuadro_mes" ;$formats["d21"] = "cuadro_mes" ;
$formats["d22"] = "cuadro_mes" ;$formats["d23"] = "cuadro_mes" ;$formats["d24"] = "cuadro_mes" ;$formats["d25"] = "cuadro_mes" ;$formats["d26"] = "cuadro_mes" ;$formats["d27"] = "cuadro_mes" ;$formats["d28"] = "cuadro_mes" ;
$formats["d29"] = "cuadro_mes" ;$formats["d30"] = "cuadro_mes" ;$formats["d31"] = "cuadro_mes" ;

$etiquetas["d1"] = "1" ;$etiquetas["d2"] = "2" ;$etiquetas["d3"] = "3" ;$etiquetas["d4"] = "4" ;$etiquetas["d5"] = "5" ;$etiquetas["d6"] = "6" ;$etiquetas["d7"] = "7" ;
$etiquetas["d8"] = "8" ;$etiquetas["d9"] = "9" ;$etiquetas["d10"] = "10" ;$etiquetas["d11"] = "11" ;$etiquetas["d12"] = "12" ;$etiquetas["d13"] = "13" ;$etiquetas["d14"] = "14" ;
$etiquetas["d15"] = "15" ;$etiquetas["d16"] = "16" ;$etiquetas["d17"] = "17" ;$etiquetas["d18"] = "18" ;$etiquetas["d19"] = "19" ;$etiquetas["d20"] = "20" ;$etiquetas["d21"] = "21" ;
$etiquetas["d22"] = "22" ;$etiquetas["d23"] = "23" ;$etiquetas["d24"] = "24" ;$etiquetas["d25"] = "25" ;$etiquetas["d26"] = "26" ;$etiquetas["d27"] = "27" ;$etiquetas["d28"] = "28" ;
$etiquetas["d29"] = "29" ;$etiquetas["d30"] = "30" ;$etiquetas["d31"] = "31" ;

//$formats["IMPORTE_IVA"] = "moneda" ;
//$formats["pdte_conciliar"] = "moneda" ;
//$formats["ingreso_conc"] = "moneda" ;
//$formats["ingreso"] = "moneda" ;
//$formats["f_vto"] = "fecha" ;
//$formats["conc"] = "boolean" ;
//$formats["pagada"] = "boolean" ;
$aligns["NumP"] = "center" ;
$tooltips["NumP"] = "Número de Personal registrado en el Parte Diario de trabajo" ;
//$tooltips["pagada"] = "Indica la factura tiene emitido documento de pago" ;


$titulo="Partes Diarios";
$msg_tabla_vacia="No hay.";

if (substr($agrupar, 0, 4)=="cal_")
{require("../include/tabla_calendar.php");}
else
{require("../include/tabla.php"); echo $TABLE ;}

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

 function partes_pdf_sel_href() {
    
    //var valor0 = valor0_encode;
    //var valor0 = JSON.parse(valor0_encode);
   // var nuevo_valor=window.prompt("Nuevo valor de "+prompt , valor0);
//    alert("el nuevo valor es: "+valor) ;
//   alert('debug') ;
//   var id_obra=document.getElementById("id_obra").value ;
//   var d= new Date() ;
//   var date_str=d.toISOString();

//   table_selection_IN()
   window.open('../personal/parte_pdf.php?id_parte_sel='+table_selection_IN());
//   window.open('../obras/obras_anadir_parte.php?id_obra='+id_obra, '_blank');
 //echo "<a class='btn btn-primary' href= '../obras/obras_anadir_parte.php?id_obra=$id_obra' >Añadir parte</a><br>" ;
        

    
    return ;
 }


 
 
 
function add_parte_obra_ajax() {
    
    //var valor0 = valor0_encode;
    //var valor0 = JSON.parse(valor0_encode);
   // var nuevo_valor=window.prompt("Nuevo valor de "+prompt , valor0);
//    alert("el nuevo valor es: "+valor) ;
//   alert('debug') ;
   var id_obra=document.getElementById("id_obra").value ;
   var d= new Date() ;
   var date_str=d.toISOString();
   var sql="INSERT INTO PARTES (ID_OBRA,Fecha) VALUES ('"+id_obra+"','"+ date_str.substring(0, 10) +"')"    ;   
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
 function add_parte_obra_href() {
    
    //var valor0 = valor0_encode;
    //var valor0 = JSON.parse(valor0_encode);
   // var nuevo_valor=window.prompt("Nuevo valor de "+prompt , valor0);
//    alert("el nuevo valor es: "+valor) ;
//   alert('debug') ;
   var id_obra=document.getElementById("id_obra").value ;
//   var d= new Date() ;
//   var date_str=d.toISOString();
   
   window.open('../obras/obras_anadir_parte.php?id_obra='+id_obra);
//   window.open('../obras/obras_anadir_parte.php?id_obra='+id_obra, '_blank');
 //echo "<a class='btn btn-primary' href= '../obras/obras_anadir_parte.php?id_obra=$id_obra' >Añadir parte</a><br>" ;
        

    
    return ;
 }
 
 
 
 
 
</script>
                
	
                </div>
                <!--****************** BUSQUEDA GLOBAL  *****************-->
            </div>
        </div>
        <!-- FIN Contenido principal -->

<?php 

//FIN
include_once('../templates/_inc_privado3_footer.php');

