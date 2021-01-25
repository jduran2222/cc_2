<?php
// cambios
require_once("../include/session.php");
$where_c_coste = " id_c_coste={$_SESSION['id_c_coste']} ";
$id_c_coste = $_SESSION['id_c_coste'];

$titulo = 'REGISTROS PERSONAL';

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

<style>
    .borde_gris
    {
    width:100% ; 
    border-style:solid;
    border-width:1px; 
    border-color:silver;

    }

</style> 
<?php 


//  INICIALIZACION DE VARIABLES  
//  $id_personal= isset($_GET["id_personal"]) ?  $_GET["id_personal"] :  (isset($_POST["id_personal"]) ?  $_POST["id_personal"] :  "") ;
  $nombre= isset($_GET["nombre"]) ?  $_GET["nombre"] :  (isset($_POST["nombre"]) ?  $_POST["nombre"] :  "") ;
  $NOMBRE_OBRA    = isset($_GET["NOMBRE_OBRA"]) ?  $_GET["NOMBRE_OBRA"] :          (isset($_POST["NOMBRE_OBRA"]) ?  $_POST["NOMBRE_OBRA"] :  "") ;
  $tipo_doc = isset($_GET["tipo_doc"]) ?  $_GET["tipo_doc"] :    (isset($_POST["tipo_doc"]) ?  $_POST["tipo_doc"] :  "") ;
  $ref_doc  = isset($_GET["ref_doc"]) ?  $_GET["ref_doc"] :      (isset($_POST["ref_doc"]) ?  $_POST["ref_doc"] :  "") ;
  $observaciones=isset($_GET["observaciones"])?$_GET["observaciones"] :  (isset($_POST["observaciones"]) ?  $_POST["observaciones"] :  "") ;
  $fecha1   = isset($_GET["fecha1"]) ?  $_GET["fecha1"]     :    (isset($_POST["fecha1"]) ?  $_POST["fecha1"] :  "")  ;
  $fecha2   = isset($_GET["fecha2"]) ?  $_GET["fecha2"]     :    (isset($_POST["fecha2"]) ?  $_POST["fecha2"] :  "") ;
  $Dia  = isset($_GET["Dia"]) ?  $_GET["Dia"]   :    (isset($_POST["Dia"]) ?  $_POST["Dia"] :  "") ;
  $Semana  = isset($_GET["Semana"]) ?  $_GET["Semana"]   :    (isset($_POST["Semana"]) ?  $_POST["Semana"] :  "") ;
  $Mes  = isset($_GET["Mes"]) ?  $_GET["Mes"]     :    (isset($_POST["Mes"]) ?  $_POST["Mes"] :  "") ;
  $Trimestre   = isset($_GET["Trimestre"]) ?  $_GET["Trimestre"]     :    (isset($_POST["Trimestre"]) ?  $_POST["Trimestre"] :  "") ;
  $Anno= isset($_GET["Anno"]) ?  $_GET["Anno"] :  (isset($_POST["Anno"]) ?  $_POST["Anno"] :  "") ;
  $asignada_obra    = isset($_GET["asignada_obra"]) ?  $_GET["asignada_obra"]     :    (isset($_POST["asignada_obra"]) ?  $_POST["asignada_obra"] :  "") ;
  $agrupar  = isset($_GET["agrupar"]) ?  $_GET["agrupar"]   :    (isset($_POST["agrupar"]) ?  $_POST["agrupar"] :  "ultimas_registros");  



// Comprobamos si es el listado de un único proveedor o un listado global

// inicializamos las variables o cogemos su valor del _POST


?>

<div id="main" class="mainc_100" style="background-color:#fff">
    
    
<?php   // Iniciamos variables para tabla.php  background-color:#B4045


//  CONFIGURACION DEL WHERE A LOS FILTROS
$where=$where_c_coste;


$select_trimestre="CONCAT(YEAR(FECHA), '-', QUARTER(FECHA),'T')"  ;

$where=$NOMBRE_OBRA==""? $where : $where . " AND NOMBRE_OBRA LIKE '%".str_replace(" ","%",trim($NOMBRE_OBRA))."%'" ;
$where=$fecha1==""? $where : $where . " AND fecha_entrada >= '$fecha1' " ;
$where=$fecha2==""? $where : $where . " AND fecha_entrada <= '$fecha2' " ;
$where=$Mes==""? $where : $where . " AND DATE_FORMAT(fecha_entrada, '%Y-%m') = '$Mes' " ;
$where=$Trimestre==""? $where : $where . " AND $select_trimestre = '$Trimestre' " ;
$where=$Anno==""? $where : $where . " AND YEAR(fecha_entrada) = '$Anno' " ;
$where=$asignada_obra==""? $where : $where . " AND asignada_obra=$asignada_obra " ;
//$where=$grupo==""? $where : $where . " AND grupo LIKE '%".str_replace(" ","%",trim($grupo))."%'" ;
$where=$observaciones==""? $where : $where . " AND Observaciones LIKE '%".str_replace(" ","%",trim($observaciones))."%'" ;


// calculo del where_clientes por si se hace la COMPARCION con fras_clientes



$tabla_group=0 ;
$tabla_cuadros=0 ;
$tabla_mapa=0 ;

$agrupados=0 ;               // determina si cada línea es una factura_prov o representa un grupo para poder poner el boton de delete o update el campo observaciones

// AGRUPAMIENTO Y CONFECCION DE SENTENCIA SQL

 switch ($agrupar) { 
    case "ultimos_registros":
     $sql="SELECT *,CONCAT( 'https://www.google.es/maps/place/',coord_latitud,',', coord_longitud) AS URL_Google_Maps FROM Personal_Registros_View WHERE $where  ORDER BY fecha_creacion DESC LIMIT 100 " ;
//     echo $sql;
//     $sql_T="SELECT '' " ;
     $col_sel="id_registro" ;

    break;
    case "registros":
     $sql="SELECT * FROM Personal_Registros_View WHERE $where  ORDER BY fecha_entrada  " ;
     $sql_T="SELECT 'SUMA...', COUNT(id_registro) AS num_registros, SUM(horas) AS horas FROM Personal_Registros_View WHERE $where    " ;
        
 //     echo $sql;
     $col_sel="id_registro" ;
    break;
    case "nombres":
     $sql="SELECT ID_PERSONAL,NOMBRE,DNI,COUNT(id_registro) AS num_registros, SUM(horas) AS horas FROM Personal_Registros_View WHERE $where GROUP BY ID_PERSONAL ORDER BY NOMBRE  " ;
     $sql_T="SELECT '' as aa1,'' as aa2,COUNT(id_registro) AS num_registros, SUM(horas) AS horas FROM Personal_Registros_View WHERE $where GROUP BY ID_PERSONAL ORDER BY NOMBRE  " ;
        
     break;
    case "nombres_registro":
        
     $sql="SELECT * FROM Personal_Registros_View WHERE $where  ORDER BY NOMBRE  " ;
     $sql_T="SELECT * FROM Personal_Registros_View WHERE $where    " ;

     
     $sql_S="SELECT ID_PERSONAL,NOMBRE,DNI,COUNT(id_registro) AS num_registros, SUM(horas) AS horas FROM Personal_Registros_View WHERE $where GROUP BY ID_PERSONAL ORDER BY NOMBRE  " ;
     $sql_T="SELECT '' as aa1,'' as aa2,COUNT(id_registro) AS num_registros, SUM(horas) AS horas FROM Personal_Registros_View WHERE $where GROUP BY ID_PERSONAL ORDER BY NOMBRE  " ;

     $id_agrupamiento="ID_PERSONAL" ;
     // permite editar el coste_est
//    $updates=['MED_PROYECTO','COSTE_EST']  ;
    $anchos_ppal=[30,20,20,20,20,20,20,20,20,20,20,20,20,20] ;
    
//    $tabla_update="Udos" ;
//    $id_update="ID_UDO" ;
//    $id_clave="ID_UDO" ;
     $tabla_group=1 ;
     $col_sel="id_registro" ;

    
     break; 
    case "dias":
     $sql="SELECT ID_PERSONAL,NOMBRE,DNI,COUNT(id_registro) AS num_registros, SUM(horas) AS horas FROM Personal_Registros_View WHERE $where GROUP BY ID_PERSONAL ORDER BY NOMBRE  " ;
     $sql_T="SELECT '' as aa1,'' as aa2,COUNT(id_registro) AS num_registros, SUM(horas) AS horas FROM Personal_Registros_View WHERE $where GROUP BY ID_PERSONAL ORDER BY NOMBRE  " ;
    $agrupados=1 ;
     break;
    case "obras":
     $sql="SELECT ID_OBRA,NOMBRE_OBRA,COUNT(id_registro) AS num_registros, SUM(horas) AS horas FROM Personal_Registros_View WHERE $where GROUP BY ID_OBRA ORDER BY NOMBRE_OBRA  " ;
     $sql_T="SELECT '' as aa1,'' as aa2,COUNT(id_registro) AS num_registros, SUM(horas) AS horas FROM Personal_Registros_View WHERE $where GROUP BY ID_OBRA  " ;
    $agrupados=1 ;
     break;
    case "meses":
    
    $sql="SELECT  DATE_FORMAT(FECHA, '%Y-%m') as MES,COUNT( ID_FRA_PROV ) as Fras,SUM(Base_Imponible) AS Base_Imponible, SUM(IMPORTE_IVA)  - SUM(Base_Imponible) AS  iva_soportado "
            . ",SUM(IMPORTE_IVA) as IMPORTE_IVA,SUM(pdte_conciliar) AS pdte_conciliar"
            . " FROM Fras_Prov_View WHERE $where  GROUP BY MES  ORDER BY MES  " ;

    $sql_T="SELECT 'Totales' AS D,COUNT( ID_FRA_PROV ) as Fras,SUM(Base_Imponible) AS Base_Imponible, SUM(IMPORTE_IVA)  - SUM(Base_Imponible) AS  iva_soportado, SUM(IMPORTE_IVA) as IMPORTE_IVA,SUM(pdte_conciliar) AS pdte_conciliar  FROM Fras_Prov_View WHERE $where   " ;

 
    $agrupados=1 ;
     break;
     
     
    case "trimestres":
        
   
    $sql="SELECT  $select_trimestre as Trimestre,COUNT( ID_FRA_PROV ) as Fras,SUM(Base_Imponible) AS Base_Imponible, SUM(IMPORTE_IVA)  - SUM(Base_Imponible) AS  iva_soportado"
            . ",SUM(IMPORTE_IVA) as IMPORTE_IVA,SUM(pdte_conciliar) AS pdte_conciliar"
            . "  FROM Fras_Prov_View WHERE $where  GROUP BY Trimestre  ORDER BY Trimestre  " ;
    $sql_T="SELECT 'Totales' AS D,COUNT( ID_FRA_PROV ) as Fras,SUM(Base_Imponible) AS Base_Imponible, SUM(IMPORTE_IVA)  - SUM(Base_Imponible) AS  iva_soportado, SUM(IMPORTE_IVA) as IMPORTE_IVA,SUM(pdte_conciliar) AS pdte_conciliar  FROM Fras_Prov_View WHERE $where   " ;
    
    $agrupados=1 ;
     break;
    case "annos":
   
    $sql="SELECT  DATE_FORMAT(FECHA, '%Y') as Anno,COUNT( ID_FRA_PROV ) as Fras,SUM(Base_Imponible) AS Base_Imponible, SUM(IMPORTE_IVA)  - SUM(Base_Imponible) AS  iva_soportado "
            . " , SUM(IMPORTE_IVA) as IMPORTE_IVA,SUM(pdte_conciliar) AS pdte_conciliar"
            . "  FROM Fras_Prov_View WHERE $where  GROUP BY Anno  ORDER BY Anno  " ;
    $sql_T="SELECT 'Totales' AS D,COUNT( ID_FRA_PROV ),SUM(Base_Imponible) AS Base_Imponible, SUM(IMPORTE_IVA)  - SUM(Base_Imponible) AS  iva_soportado,"
            . " SUM(IMPORTE_IVA) as IMPORTE_IVA,SUM(pdte_conciliar) AS pdte_conciliar "
            . " FROM Fras_Prov_View WHERE $where  " ;
   
    
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
// $updates=['Observaciones','grupo']  ;
// $tabla_update="FACTURAS_PROV" ;
// $id_update="ID_FRA_PROV" ;
// 
//$actions_row=[];                                    // ANULAMOS LA POSIBILIDAD DE BORRAR FACTURA EN EL LISTADO. HAY QUE ENTRAR Y BORRAR DESDE DENTRO POR SEGURIDAD.
//$actions_row["id"]="ID_FRA_PROV";
//$actions_row["delete_link"]="1"; 
}
//echo   "<br><a class='btn btn-link noprint' href='../proveedores/factura_proveedor_anadir.php' target='_blank' ><i class='fas fa-plus-circle'></i> Factura nueva</a>" ; // BOTON AÑADIR FACTURA
//echo   "<a class='btn btn-primary' href='#' onclick=\"genera_remesa()\" title='Genera remesa con las facturas seleccionadas' >Generar Remesa Nueva</a>" ; // BOTON AÑADIR FACTURA
//echo   "<a class='btn btn-primary' href='#' onclick=\"cargar_a_obra()\" title='Carga las facturas seleccionadas a una obra' >Cargar fras a obra</a>" ; 


// echo "<br><font size=2 color=grey>Agrupar por : $agrupar "
//         . "<br> {$result->num_rows} filas </font> " ;

// CONFIGURACION CAMPOS Y FORMATOS DE TABLA

$links["URL_Google_Maps"] = ["","URL_Google_Maps", "ver en Google Maps",  "formato_sub_vacio"] ;
$formats["URL_Google_Maps"]="icon_map" ;

  
$dblclicks=[];
$dblclicks["nombre"]="nombre" ;
$dblclicks["grupo"]="grupo" ;
$dblclicks["NOMBRE_OBRA"]="NOMBRE_OBRA" ;
$dblclicks["CIF"]="proveedor" ;
$dblclicks["N_FRA"]="n_fra" ;
//$dblclicks["CONCEPTO"]="CONCEPTO" ;
//$dblclicks["TIPO_GASTO"]="TIPO_GASTO" ;
$dblclicks["Mes"]="Mes" ;
$dblclicks["Trimestre"]="Trimestre" ;
$dblclicks["Anno"]="Anno" ;



$links["NOMBRE_OBRA"] = ["../obras/obras_ficha.php?id_obra=", "ID_OBRA","ver Obra","formato_sub_vacio"] ;
//$links["PROVEEDOR"] = ["../proveedores/proveedores_ficha.php?id_proveedor=", "ID_PROVEEDORES","ver Proveedor","formato_sub"] ;
//$links["N_FRA"] = ["../proveedores/factura_proveedor.php?id_fra_prov=", "ID_FRA_PROV","ver factura","formato_sub"] ;
//$links["FECHA"] = ["../proveedores/factura_proveedor.php?id_fra_prov=", "ID_FRA_PROV","ver factura","formato_sub"] ;
//$links["path_archivo"] = ["../proveedores/factura_proveedor.php?id_fra_prov=", "ID_FRA_PROV","ver factura","formato_sub"] ;
//$links["Nid_fra_prov"] = ["../proveedores/factura_proveedor.php?id_fra_prov=", "ID_FRA_PROV","ver factura","formato_sub"] ;
//$links["NOMBRE_OBRA"]=["../obras/obras_ficha.php?id_obra=", "ID_OBRA"] ;

//$formats["Observaciones"] = "textarea" ;
//$formats["Enero"] = "moneda" ; $formats["Febrero"] = "moneda" ; $formats["Marzo"] = "moneda" ; $formats["Abril"] = "moneda" ; $formats["Mayo"] = "moneda" ; $formats["Junio"] = "moneda" ;
//$formats["Julio"] = "moneda" ; $formats["Agosto"] = "moneda" ; $formats["Septiembre"] = "moneda" ; $formats["Octubre"] = "moneda" ; $formats["Noviembre"] = "moneda" ; $formats["Diciembre"] = "moneda" ;

//$formats["Base_Imponible"] = "moneda" ;
//$formats["Base_Imp_cli"] = "moneda" ;
//$formats["firmado"] = "firmado" ;
//$formats["iva_soportado"] = "moneda" ;
//$formats["iva_devengado"] = "moneda" ;
//$formats["Iva_a_ingresar"] = "moneda" ;
//$formats["IMPORTE_IVA"] = "moneda" ;
//$formats["pdte_conciliar"] = "moneda" ;
//$etiquetas["IMPORTE_IVA"] = "Importe iva inc." ;
//$etiquetas["pdte_conciliar"] = "pdte cargar" ;
//$tooltips["pdte_conciliar"] = "importe pendiente de Cargar a obra de esta factura" ;
//$tooltips["Fras"] = "Número de facturas del periodo" ;
//$aligns["Fras"] = "center" ;
//
//$formats["pdte_pago"] = "moneda" ;
//$formats["path_archivo"]="pdf_100_500" ;                //"pdf_800" ;

//$formats["ingreso_conc"] = "moneda" ;
//$formats["ingreso"] = "moneda" ;
//$formats["FECHA"] = "dbfecha" ;
//$formats["cargada"] = "boolean" ;
//$formats["PDF"] = "boolean" ;
////$formats["pagada"] = "boolean" ;
////$formats["cobrada"] = "boolean" ;
//$formats["path"] = "textarea2" ;
//$links["path"] = ["../proveedores/factura_proveedor.php?id_fra_prov=", "ID_FRA_PROV","ver factura","formato_sub"] ;
//
//$formats["cargada"] = "semaforo_OK" ;
//$formats["pagada"] = "semaforo_OK" ;
//$formats["cobrada"] = "semaforo_OK" ;




//$aligns["Pagada"] = "center" ;
//$tooltips["cargada"] = "Indica si la factura está cargada a obra con Vales o Albaranos de proveedor" ;
//$tooltips["pagada"] = "Indica la factura tiene emitido documento de pago" ;


$titulo="";
$msg_tabla_vacia="No hay.";

$tabla_expandible=0;          // evitamos la tabla expandible que da problemas

// if (isset($content_sel))  echo $content_sel ;        // pintamos el contenido de Selection, los botones para las acciones con la selección


// if ($tabla_group)
// { require("../include/tabla_group.php"); }
// elseif ($tabla_cuadros)
// { require("../include/tabla_cuadros.php"); }    
// else
// { require("../include/tabla.php"); echo $TABLE ; }
    
// echo "</form>" ;

?>

</div>

<!--************ FIN  *************  -->
	
	

<?php  

// [FJSL 2020-12-05]: metemos los datos relacionados con la presentación y los fragmentos HTML:



$tituloEncabezado = 'Registro de Entrada y Salidas';
$enlaceForm = '../personal/registros_view.php';

//Montaje de fragmentos:
$html = '';
echo encabezadoPagina($tituloEncabezado);
echo iniciaForm($enlaceForm, 'POST', 'form1', 'form1');



// ARRAY BOTONES AGRUPACION

$filtros = [];

$filtros[] = [ "type" =>'block',"titulo" =>'Generales' ];
    $filtros['nombre'] = ["type" =>'text', "name" =>'nombre', "id" =>'nombre',"class" => '', "titulo" =>'Nombre del empleado',"value" => $nombre, "options" => [] ];
    $filtros['NOMBRE_OBRA'] = ["type" =>'text', "name" =>'NOMBRE_OBRA', "id" =>'NOMBRE_OBRA',"class" => '', "titulo" =>'Obra',"value" => $NOMBRE_OBRA, "options" => [] ];
    $filtros['observaciones'] = ["type" =>'text', "name" =>'observaciones', "id" =>'observaciones',"class" => '', "titulo" =>'Observaciones',"value" => $observaciones, "options" => [] ];

$filtros[] = ["type" =>'col' ];
$filtros[] = [ "type" =>'block',"titulo" =>'Periodo' ];

    $filtros['fecha1'] = ["type" =>'date', "name" =>'fecha1', "id" =>'fecha1',"class" => '', "titulo" =>'Fecha mín.',"value" => $fecha1, "options" => [] ];
    $filtros['fecha2'] = ["type" =>'date', "name" =>'fecha2', "id" =>'fecha2',"class" => '', "titulo" =>'Fecha máx.',"value" => $fecha2, "options" => [] ];
    $filtros['MES'] = ["type" =>'text', "name" =>'MES', "id" =>'MES',"class" => '', "titulo" =>'Mes',"value" => $Mes, "options" => [] ];
    $filtros['Trimestre'] = ["type" =>'text', "name" =>'Trimestre', "id" =>'Trimestre',"class" => '', "titulo" =>'Trimestre',"value" => $Trimestre, "options" => [] ];
    $filtros['Anno'] = ["type" =>'text', "name" =>'Anno', "id" =>'Anno',"class" => '', "titulo" =>'Año',"value" => $Anno, "options" => [] ];

$filtros[] = ["type" =>'block', "titulo" =>'Asignada a Obra' ];
    $filtros['asignada_obra'] = ["type" =>'radio', "name" =>'asignada_obra', "id" =>'asignada_obra',"class" => '', "titulo" =>'asignada_obra',"value" => $asignada_obra, "options" => ['Todas','Asignada a obra','Sin asignar'] ];
//$filtros['path_archivo'] = ["type" =>'text', "name" =>'path_archivo', "id" =>'path_archivo',"class" => '', "titulo" =>'Nombre archivo',"value" => $path_archivo, "options" => [] ];
//$filtros['metadatos'] = ["type" =>'text', "name" =>'metadatos', "id" =>'metadatos',"class" => '', "titulo" =>'Metadatos',"value" => $metadatos, "options" => [] ];


//$filtros['firmado'] = ["type" =>'select', "name" =>'firmado', "id" =>'firmado',"class" => '', "titulo" =>'firmado',"value" => $firmado,
//                      "options" => [
//                                    ['',''] 
//                                    ,['sin firmas','sin firmas'] 
//                                    , ['CONFORME','CONFORME'] 
//                                    , ['PDTE','PDTE'] 
//                                    , ['NO_CONF','NO_CONF'] 
//                                   ]
//                       ] ; 
                          
//$filtros[] = ["type" =>'col'];
//$filtros[] = ["type" =>'block', "titulo" =>'Tipo factura' ];
//                          
//$filtros['iva'] = ["type" =>'radio', "name" =>'iva', "id" =>'iva',"class" => '', "titulo" =>'iva',"value" => $iva,
//                      "options" => ["todas","con iva","sin iva"] 
//                       ] ; 
//
//$filtros['nomina'] = ["type" =>'radio', "name" =>'nomina', "id" =>'nomina',"class" => '', "titulo" =>'Tipo ',"value" => $nomina,
//                      "options" => ["todas","Nominas","Proveedores"]
//                       ] ; 
//$filtros[] = [ "type" =>'block',"titulo" =>'Seguimiento' ];
//
//$filtros['firmado'] = ["type" =>'text_list', "name" =>'firmado', "id" =>'firmado',"class" => '', "titulo" =>'firmado',"value" => $firmado,
//                      "options" => ['sin firmas','CONFORME','PDTE','NO_CONF'] 
//                       ] ; 
//
//$filtros['conciliada'] = ["type" =>'radio', "name" =>'conciliada', "id" =>'conciliada',"class" => '', "titulo" =>'Cargada a Obra',"value" => $conciliada,
//                      "options" => ["todas","Cargadas","No Cargadas"]
//                       ] ; 
//$filtros['pagada'] = ["type" =>'radio', "name" =>'pagada', "id" =>'pagada',"class" => '', "titulo" =>'Pagada',"value" => $pagada,
//                      "options" => ["todas","pagadas","No Pagadas"] 
//                       ] ; 
//$filtros['cobrada'] = ["type" =>'radio', "name" =>'cobrada', "id" =>'cobrada',"class" => '', "titulo" =>'Cobrada proveedor',"value" => $cobrada,
//                      "options" => ["todas","Cobradas","No Cobradas"] 
//                       ] ; 
//                          
   // RADIO BUTTON CHK
    //Datos
//    $radio=$cobrada ;
//    $radio_name='cobrada' ;
//    $radio_options=["todas","Cobradas","No Cobradas"];
//    // código
//    $chk_todos =  ['','']  ; $chk_on = ['','']  ; $chk_off =  ['','']  ;
//    if ($radio=="") { $chk_todos = ["active","checked"] ;} elseif ($radio==1) { $chk_on =  ["active","checked"]  ;} elseif ($radio==0)  { $chk_off =  ["active","checked"]  ;}
//    //echo "<br><input type='radio' id='activa' name='activa' value='' $chk_todos />Todas las obras      <input type='radio' id='activa' name='activa' value='1' $chk_on />Activas  <input type='radio' id='activa' name='activa' value='0' $chk_off  />No Activas" ;
//    $radio_html= "<div class='btn-group btn-group-toggle' data-toggle='buttons'>"
//         . "<label class='btn btn-default {$chk_todos[0]}'><input type='radio' id='{$radio_name}' name='$radio_name' value='' {$chk_todos[1]} />{$radio_options[0]}</label> "
//         . "<label class='btn btn-default {$chk_on[0]}'><input type='radio' id='{$radio_name}1' name='$radio_name' value='1'  {$chk_on[1]} />{$radio_options[1]} </label>"
//         . "<label class='btn btn-default {$chk_off[0]}'><input type='radio' id='{$radio_name}0' name='$radio_name' value='0' {$chk_off[1]}  />{$radio_options[2]}</label>"
//         . "</div>"
//         . "" ;
    // FIN PADIO BUTTON CHK
                         


//    //pdf
//    $valores = array();
//    $valores[] = array('id' => 'pdf', 'value' => '', 'texto' => 'Todas');
//    $valores[] = array('id' => 'pdf1', 'value' => '1', 'texto' => 'Con PDF');
//    $valores[] = array('id' => 'pdf0', 'value' => '0', 'texto' => 'Sin PDF');
////    $html .= filtroFormularioSimple('select', 'pdf', 'pdf', '', 'PDF', $params['pdf'], $valores);
//
//


$filtro_html = panelFiltros( $filtros);

// ARRAY BOTONES AGRUPACION

$btnAgrupaciones = [];
$btnAgrupaciones['ultimos_registros']=['ultimos registros','muestra últimos Registros'] ;
$btnAgrupaciones['registros']=['registros','Listado de todos según el filtro'] ;
$btnAgrupaciones['nombres_registro']=['nombres_registro',''] ;

$btnAgrupaciones['nombres']=['nombres',''] ;
$btnAgrupaciones['obras']=['obras',''] ;
$btnAgrupaciones['vacio3']=['','',''] ;
$btnAgrupaciones['dias']=['dias',''] ;
$btnAgrupaciones['semanas']=['semanas',''] ;
$btnAgrupaciones['meses']=['meses',''] ;
$btnAgrupaciones['trimestres']=['trimestres',''] ;
$btnAgrupaciones['annos']=['años',''] ;
$btnAgrupaciones['vacio2']=['','',''] ;
$btnAgrupaciones['mapa']=['mapa','ver Mapa '] ;

$agrupaciones = panelAgrupaciones($btnAgrupaciones,$agrupar);

//Para los elementos de operatividad
//$remesas = DOptions_sql("SELECT id_remesa,CONCAT(remesa,'  Importe:',FORMAT(IFNULL(importe,0),2),'€ -Num.Pagos',IFNULL(num_pagos,0)) FROM Remesas_View WHERE activa=1 AND firmada=0 AND $where_c_coste ORDER BY f_vto ");
//$cargas = DOptions_sql("SELECT ID_OBRA,NOMBRE_OBRA FROM OBRAS WHERE $where_c_coste AND  activa ORDER BY activa DESC,NOMBRE_OBRA ");
//$metalicos = '';
//$bancos = DOptions_sql("SELECT id_cta_banco, Banco FROM ctas_bancos WHERE Activo AND $where_c_coste ORDER BY Banco ");
//$sql_update= "UPDATE `FACTURAS_PROV` SET grupo='_VAR_SQL1_' WHERE  ID_FRA_PROV IN _VARIABLE2_ ; "  ;
//$grupos='../include/sql.php?sql=' . encrypt2($sql_update);
//$operaciones = panelOperacionesFacturasProveedor($remesas,$cargas,$metalicos,$bancos,$grupos);




//$array_fmt=[
//          ['fmt_pdf', $fmt_pdf , '(Ver PDF)', 'muestra los pdf de las factura']
//         ,['fmt_clientes', $fmt_clientes , 'Compara F.Clientes', 'Muestra las Facturas de Clientes para los mismos periodos para comparar IVAs, y facturaciones de Ingeros y Gastos']
//    ];
//
//$labels = labelFormatos($array_fmt);
//echo selectoresMenu([[$filtro_html,'Filtro'],[$agrupaciones,'agrupar'],[$labels,'formato']]);
echo selectoresMenu([[$filtro_html,'Filtro'],[$agrupaciones,'agrupar']]);
if (!empty($agrupar)) {
    $comentario = 'Agrupado por: '.$agrupar;
    echo comentarioPrevioTabla($comentario);
}
if ($result->num_rows == 0) {
    $comentario = 'Sin filas';
}
else {
    $comentario = $result->num_rows . 'fila'.($result->num_rows == 1 ? '' : 's');
}
echo comentarioPrevioTabla($comentario);
// echo iniciaTabla('', '', 'seleccion');
// echo finalizaTabla();

echo iniciaDivision('','','col-12');
//TABLA FINAL
// pintamos el contenido de Selection, los botones para las acciones con la selección
if (isset($content_sel)) {
    echo $content_sel;      
}
if ($tabla_group) {
    require("../include/tabla_group.php");
}
elseif ($tabla_cuadros) {
    require("../include/tabla_cuadros.php");
}
else {
    require("../include/tabla.php");
    echo $TABLE;
}
echo finalizaDivision();
echo finalizaForm();

//Pintar resultado
echo $html;
// exit;
// [FJSL 2020-12-05]: FIN metemos los datos relacionados con la presentación y los fragmentos HTML:


$Conn->close();

?>
	 

</div>

<script>

//function cargar_a_obra_sel_href() {
//    // var valor0 = valor0_encode;
//    // var valor0 = JSON.parse(valor0_encode);
//    // var nuevo_valor=window.prompt("Nuevo valor de "+prompt , valor0);
//    // alert("el nuevo valor es: "+valor) ;
//    // alert('debug') ;
//    var id_obra=document.getElementById("id_obra").value ;
//    // var d= new Date() ;
//    // var date_str=d.toISOString();
//    // table_selection_IN()
//    window.open('../proveedores/fra_prov_cargar_a_obra.php?id_fra_prov_sel='+table_selection_IN()+'&id_obra='+id_obra);
//    // window.open('../obras/obras_anadir_parte.php?id_obra='+id_obra, '_blank');
//    //echo "<a class='btn btn-primary' href= '../obras/obras_anadir_parte.php?id_obra=$id_obra' >Añadir parte</a><br>" ;
//    return;
//}
//function genera_remesa() {
//    var id_remesa=document.getElementById("id_remesa").value;
//    // alert( id_remesa );
//    window.open("../bancos/remesa_anadir_selection.php?id_remesa="+id_remesa+"&array_str=" + table_selection() );
//    // window.open("../bancos/remesa_anadir_selection.php?id_remesa="+id_remesa+"&array_str=1");
//    // window.open("../menu/pagina_inicio.php");
//}

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