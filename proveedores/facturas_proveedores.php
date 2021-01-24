<?php
// cambios
require_once("../include/session.php");
$where_c_coste = " id_c_coste={$_SESSION['id_c_coste']} ";
$id_c_coste = $_SESSION['id_c_coste'];

$titulo = 'FRAS. PROV.';

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

$iniciar_form=(!isset($_POST["agrupar"])) ;  // determinamos si debemos de inicializar el FORM con valores vacíos

if ($iniciar_form) {
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
    $fmt_clientes = isset($_GET["fmt_clientes"]) ?  $_GET["fmt_clientes"] :  "";
    $menu = isset($_GET["menu"]) ?  $_GET["menu"] :  "";
}
else {
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
    $fmt_clientes=isset($_POST["fmt_clientes"]) ? 'checked' : '' ;
    $menu =  "";
}
  

// Comprobamos si es el listado de un único proveedor o un listado global

$listado_global= (!isset($_GET["id_proveedor"])) ;

if (!$listado_global) {
    // Estamos viendo las Facturas de un único proveedor
    $id_proveedor=$_GET["id_proveedor"];
    $proveedor=Dfirst("PROVEEDOR", "Proveedores", "ID_PROVEEDORES=$id_proveedor AND $where_c_coste" );
    // Añadimos el Menu de Proveedores
    require_once("../proveedores/proveedores_menutop_r.php");
    if ($iniciar_form) { // si no es Global, mejor agrupar por facturas del proveedor seleccionado
        $agrupar = 'facturas' ;
    }
  }
else { // si es listado_global añadimos  la variable del form 'proveedor'
    if($menu=='obras'){
        require_once("../obras/obras_menutop_r.php");
    }
    else { // Añadimos el Menu de Proveedores  
        require_once("../bancos/bancos_menutop_r.php");
    }
    if ($iniciar_form) {
        $proveedor=isset($_GET["proveedor"])? $_GET["proveedor"] :  "";
    }
    else { 
        $proveedor=$_POST["proveedor"];
    }
} 
// inicializamos las variables o cogemos su valor del _POST




   

?>

<div id="main" class="mainc_100" style="background-color:#fff">
    
    
<?php   // Iniciamos variables para tabla.php  background-color:#B4045


//$FECHA1= date_replace($FECHA1) ;
//$FECHA2= date_replace($FECHA2) ;
$where=$where_c_coste;

if ($listado_global)                // Estamos en pantalla de LISTADO GLOBAL (toda la empresa no solo en un proveedor concreto)
{    
// adaptamos todos los filtros, quitando espacios a ambos lados con trim() y sustituyendo espacios por '%' para el LIKE 
$where=$proveedor==""? $where : $where . " AND PROVEEDOR LIKE '%".str_replace(" ","%",trim($proveedor))."%'" ;
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


// calculo del where_clientes por si se hace la COMPARCION con fras_clientes
if ($fmt_clientes)
{
    $select_trimestre_cli="CONCAT(YEAR(FECHA_EMISION), '-', QUARTER(FECHA_EMISION),'T')"  ;
    $where_cli=$where_c_coste;

    $where_cli=$NOMBRE_OBRA==""? $where_cli : $where_cli . " AND NOMBRE_OBRA LIKE '%".str_replace(" ","%",trim($NOMBRE_OBRA))."%'" ;
    $where_cli=$fecha1==""? $where_cli : $where_cli . " AND FECHA_EMISION >= '$fecha1' " ;
    $where_cli=$fecha2==""? $where_cli : $where_cli . " AND FECHA_EMISION <= '$fecha2' " ;
    $where_cli=$MES==""? $where_cli : $where_cli . " AND DATE_FORMAT(FECHA_EMISION, '%Y-%m') = '$MES' " ;
    $where_cli=$Trimestre==""? $where_cli : $where_cli . " AND $select_trimestre_cli = '$Trimestre' " ;
    $where_cli=$Anno==""? $where_cli : $where_cli . " AND YEAR(FECHA_EMISION) = '$Anno' " ;

}




?>
 

<?php 
   


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
     $sql_T="SELECT $select_fmt_pdf_T '' AS c,'Totales' AS d,'' AS f11,SUM(Base_Imponible) AS Base_Imponible,'' AS f, SUM(IMPORTE_IVA) AS IMPORTE_IVA,'' AS a41,'' AS a1 "
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
    
        
        
   if(!$fmt_clientes)
   {    
    $sql="SELECT  DATE_FORMAT(FECHA, '%Y-%m') as MES,COUNT( ID_FRA_PROV ) as Fras,SUM(Base_Imponible) AS Base_Imponible, SUM(IMPORTE_IVA)  - SUM(Base_Imponible) AS  iva_soportado "
            . ",SUM(IMPORTE_IVA) as IMPORTE_IVA,SUM(pdte_conciliar) AS pdte_conciliar"
            . " FROM Fras_Prov_View WHERE $where  GROUP BY MES  ORDER BY MES  " ;

    $sql_T="SELECT 'Totales' AS D,COUNT( ID_FRA_PROV ) as Fras,SUM(Base_Imponible) AS Base_Imponible, SUM(IMPORTE_IVA)  - SUM(Base_Imponible) AS  iva_soportado, SUM(IMPORTE_IVA) as IMPORTE_IVA,SUM(pdte_conciliar) AS pdte_conciliar  FROM Fras_Prov_View WHERE $where   " ;

   }else
   {
    $sql_prov="SELECT  DATE_FORMAT(FECHA, '%Y-%m') as MES,SUM(Base_Imponible) AS Base_Imponible, SUM(IMPORTE_IVA)  - SUM(Base_Imponible) AS  iva_soportado "
            . ",SUM(IMPORTE_IVA) as IMPORTE_IVA"
            . ", 0 as Base_Imp_cli , 0 as Iva_devengado , 0 as Importe_iva_cli, -(SUM(IMPORTE_IVA)  - SUM(Base_Imponible)) as Iva_a_ingresar         "
            . " FROM Fras_Prov_View WHERE $where  GROUP BY MES  " ;
        
    $sql_cli="SELECT  DATE_FORMAT(FECHA_EMISION, '%Y-%m') as MES,0 AS Base_Imponible, 0 AS  iva_soportado, 0 AS IMPORTE_IVA "
            . ", SUM(Base_Imponible) as Base_Imp_cli , SUM(IMPORTE_IVA)  - SUM(Base_Imponible) AS  iva_devengado , SUM(IMPORTE_IVA) as Importe_iva_cli, SUM(IMPORTE_IVA)  - SUM(Base_Imponible) as Iva_a_ingresar         "
            . " FROM Facturas_View WHERE $where_cli  GROUP BY MES  " ;
        
        
    
     $sql= "SELECT MES , SUM(Base_Imponible) AS Base_Imponible,SUM(iva_soportado) AS iva_soportado,SUM(IMPORTE_IVA) as IMPORTE_IVA "
             . ",' ' as ID_TH_COLOR "
            . ", SUM(Base_Imp_cli) as Base_Imp_cli , SUM(iva_devengado)  AS  iva_devengado , SUM(Importe_iva_cli) as Importe_iva_cli, SUM(Iva_a_ingresar) as Iva_a_ingresar         "             
             . " FROM ( ( $sql_prov ) UNION ALL ($sql_cli ) ) X GROUP BY MES ORDER BY MES" ; 
     
     $sql_T= "SELECT 'Suma:' , SUM(Base_Imponible) AS Base_Imponible,SUM(iva_soportado) AS iva_soportado,SUM(IMPORTE_IVA) as IMPORTE_IVA  "
            . ", SUM(Base_Imp_cli) as Base_Imp_cli , SUM(iva_devengado)  AS  iva_devengado , SUM(Importe_iva_cli) as Importe_iva_cli, SUM(Iva_a_ingresar) as Iva_a_ingresar         "             
             . " FROM ( ( $sql_prov ) UNION ALL ($sql_cli ) ) X " ; 
         
   }    

    $agrupados=1 ;
     break;
     
     
    case "trimestres":
        
   if(!$fmt_clientes)
   {    
    $sql="SELECT  $select_trimestre as Trimestre,COUNT( ID_FRA_PROV ) as Fras,SUM(Base_Imponible) AS Base_Imponible, SUM(IMPORTE_IVA)  - SUM(Base_Imponible) AS  iva_soportado"
            . ",SUM(IMPORTE_IVA) as IMPORTE_IVA,SUM(pdte_conciliar) AS pdte_conciliar"
            . "  FROM Fras_Prov_View WHERE $where  GROUP BY Trimestre  ORDER BY Trimestre  " ;
    $sql_T="SELECT 'Totales' AS D,COUNT( ID_FRA_PROV ) as Fras,SUM(Base_Imponible) AS Base_Imponible, SUM(IMPORTE_IVA)  - SUM(Base_Imponible) AS  iva_soportado, SUM(IMPORTE_IVA) as IMPORTE_IVA,SUM(pdte_conciliar) AS pdte_conciliar  FROM Fras_Prov_View WHERE $where   " ;
   }
   else
   {
    $sql_prov="SELECT  $select_trimestre as Trimestre,SUM(Base_Imponible) AS Base_Imponible, SUM(IMPORTE_IVA)  - SUM(Base_Imponible) AS  iva_soportado "
            . ",SUM(IMPORTE_IVA) as IMPORTE_IVA"
            . ", 0 as Base_Imp_cli , 0 as Iva_devengado , 0 as Importe_iva_cli, -(SUM(IMPORTE_IVA)  - SUM(Base_Imponible)) as Iva_a_ingresar         "
            . " FROM Fras_Prov_View WHERE $where  GROUP BY Trimestre  " ;
        
    $sql_cli="SELECT  $select_trimestre_cli as Trimestre,0 AS Base_Imponible, 0 AS  iva_soportado, 0 AS IMPORTE_IVA "
            . ", SUM(Base_Imponible) as Base_Imp_cli , SUM(IMPORTE_IVA)  - SUM(Base_Imponible) AS  iva_devengado , SUM(IMPORTE_IVA) as Importe_iva_cli, SUM(IMPORTE_IVA)  - SUM(Base_Imponible) as Iva_a_ingresar         "
            . " FROM Facturas_View WHERE $where_cli  GROUP BY Trimestre  " ;
        
        
    
     $sql= "SELECT Trimestre , SUM(Base_Imponible) AS Base_Imponible,SUM(iva_soportado) AS iva_soportado,SUM(IMPORTE_IVA) as IMPORTE_IVA "
             . ",' ' as ID_TH_COLOR "
            . ", SUM(Base_Imp_cli) as Base_Imp_cli , SUM(iva_devengado)  AS  iva_devengado , SUM(Importe_iva_cli) as Importe_iva_cli, SUM(Iva_a_ingresar) as Iva_a_ingresar         "             
             . " FROM ( ( $sql_prov ) UNION ALL ($sql_cli ) ) X GROUP BY Trimestre ORDER BY Trimestre" ; 
     
     $sql_T= "SELECT 'Suma:' , SUM(Base_Imponible) AS Base_Imponible,SUM(iva_soportado) AS iva_soportado,SUM(IMPORTE_IVA) as IMPORTE_IVA  "
            . ", SUM(Base_Imp_cli) as Base_Imp_cli , SUM(iva_devengado)  AS  iva_devengado , SUM(Importe_iva_cli) as Importe_iva_cli, SUM(Iva_a_ingresar) as Iva_a_ingresar         "             
             . " FROM ( ( $sql_prov ) UNION ALL ($sql_cli ) ) X " ; 
       
   }    
    $agrupados=1 ;
     break;
    case "annos":


    if(!$fmt_clientes)
   {    
    $sql="SELECT  DATE_FORMAT(FECHA, '%Y') as Anno,COUNT( ID_FRA_PROV ) as Fras,SUM(Base_Imponible) AS Base_Imponible, SUM(IMPORTE_IVA)  - SUM(Base_Imponible) AS  iva_soportado "
            . " , SUM(IMPORTE_IVA) as IMPORTE_IVA,SUM(pdte_conciliar) AS pdte_conciliar"
            . "  FROM Fras_Prov_View WHERE $where  GROUP BY Anno  ORDER BY Anno  " ;
    $sql_T="SELECT 'Totales' AS D,COUNT( ID_FRA_PROV ),SUM(Base_Imponible) AS Base_Imponible, SUM(IMPORTE_IVA)  - SUM(Base_Imponible) AS  iva_soportado,"
            . " SUM(IMPORTE_IVA) as IMPORTE_IVA,SUM(pdte_conciliar) AS pdte_conciliar "
            . " FROM Fras_Prov_View WHERE $where  " ;
   }
   else
   {
    $sql_prov="SELECT  DATE_FORMAT(FECHA, '%Y') as Anno,SUM(Base_Imponible) AS Base_Imponible, SUM(IMPORTE_IVA)  - SUM(Base_Imponible) AS  iva_soportado "
            . ",SUM(IMPORTE_IVA) as IMPORTE_IVA"
            . ", 0 as Base_Imp_cli , 0 as Iva_devengado , 0 as Importe_iva_cli, -(SUM(IMPORTE_IVA)  - SUM(Base_Imponible)) as Iva_a_ingresar         "
            . " FROM Fras_Prov_View WHERE $where  GROUP BY Anno  " ;
        
    $sql_cli="SELECT  DATE_FORMAT(FECHA_EMISION, '%Y') as Anno,0 AS Base_Imponible, 0 AS  iva_soportado, 0 AS IMPORTE_IVA "
            . ", SUM(Base_Imponible) as Base_Imp_cli , SUM(IMPORTE_IVA)  - SUM(Base_Imponible) AS  iva_devengado , SUM(IMPORTE_IVA) as Importe_iva_cli, SUM(IMPORTE_IVA)  - SUM(Base_Imponible) as Iva_a_ingresar         "
            . " FROM Facturas_View WHERE $where_cli  GROUP BY Anno  " ;
        
        
    
     $sql= "SELECT Anno , SUM(Base_Imponible) AS Base_Imponible,SUM(iva_soportado) AS iva_soportado,SUM(IMPORTE_IVA) as IMPORTE_IVA "
             . ",' ' as ID_TH_COLOR "
            . ", SUM(Base_Imp_cli) as Base_Imp_cli , SUM(iva_devengado)  AS  iva_devengado , SUM(Importe_iva_cli) as Importe_iva_cli, SUM(Iva_a_ingresar) as Iva_a_ingresar         "             
             . " FROM ( ( $sql_prov ) UNION ALL ($sql_cli ) ) X GROUP BY Anno ORDER BY Anno" ; 
     
     $sql_T= "SELECT 'Suma:' , SUM(Base_Imponible) AS Base_Imponible,SUM(iva_soportado) AS iva_soportado,SUM(IMPORTE_IVA) as IMPORTE_IVA  "
            . ", SUM(Base_Imp_cli) as Base_Imp_cli , SUM(iva_devengado)  AS  iva_devengado , SUM(Importe_iva_cli) as Importe_iva_cli, SUM(Iva_a_ingresar) as Iva_a_ingresar         "             
             . " FROM ( ( $sql_prov ) UNION ALL ($sql_cli ) ) X " ; 
       
   }    

    
    
    $agrupados=1 ;
     break;
    case "grupo":
    $sql="SELECT  grupo,COUNT( ID_FRA_PROV ) as Fras,SUM(Base_Imponible) AS Base_Imponible, SUM(IMPORTE_IVA)  - SUM(Base_Imponible) AS  iva_soportado "
            . " , SUM(IMPORTE_IVA) as IMPORTE_IVA,SUM(pdte_conciliar) AS pdte_conciliar  FROM Fras_Prov_View WHERE $where  GROUP BY grupo  ORDER BY grupo  " ;
    $sql_T="SELECT 'Totales' AS D,COUNT( ID_FRA_PROV ),SUM(Base_Imponible) AS Base_Imponible, SUM(IMPORTE_IVA)  - SUM(Base_Imponible) AS  iva_soportado, SUM(IMPORTE_IVA) as IMPORTE_IVA,SUM(pdte_conciliar) AS pdte_conciliar  FROM Fras_Prov_View WHERE $where  " ;
    $agrupados=1 ;
     break;
    case "firmado":
    $sql="SELECT  firmado,COUNT( ID_FRA_PROV ) as Fras,SUM(Base_Imponible) AS Base_Imponible, SUM(IMPORTE_IVA)  - SUM(Base_Imponible) AS  iva_soportado "
            . " , SUM(IMPORTE_IVA) as IMPORTE_IVA,SUM(pdte_conciliar) AS pdte_conciliar  FROM Fras_Prov_View WHERE $where  GROUP BY firmado  ORDER BY firmado  " ;
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


// echo "<br><font size=2 color=grey>Agrupar por : $agrupar "
//         . "<br> {$result->num_rows} filas </font> " ;

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
$formats["Base_Imp_cli"] = "moneda" ;
$formats["firmado"] = "firmado" ;
$formats["iva_soportado"] = "moneda" ;
$formats["iva_devengado"] = "moneda" ;
$formats["Iva_a_ingresar"] = "moneda" ;
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

//Gestionar datos:
$tituloEncabezado = '';
$btnAgrupaciones = array();
//$agrupacionSeleccionada = $agrupar;
$btnAgrupaciones['ultimas_fras_reg']=['ultimas registradas','muestra las últimas facturas registradas'] ;
$btnAgrupaciones['facturas']=['facturas','Listado de todas las facturas según el filtro'] ;

//Condicionales por tipo de listado
if ($listado_global) { // Estamos en pantalla de LISTADO GLOBALES (es decir, en toda la empresa)
    $tituloEncabezado = 'Facturas Proveedores';
    $enlaceForm = '../proveedores/facturas_proveedores.php';
    //agrupaciones globales
    $btnAgrupaciones['proveedor']=['proveedor',''] ;
    $btnAgrupaciones['prov_fras']=['prov-fras',''] ;
}
else {
    $enlaceVolver = enlaceVolverCabeceraPagina('../proveedores/facturas_proveedores.php','(Volver a Facturas prov. global)');
    $tituloEncabezado = 'Facturas de ' . $proveedor . ' '.$enlaceVolver;
    $enlaceForm = '../proveedores/facturas_proveedores.php?id_proveedor='.$id_proveedor;
}
$btnAgrupaciones['obras']=['obras',''] ;
$btnAgrupaciones['vacio3']=['','',''] ;
$btnAgrupaciones['meses']=['meses',''] ;
$btnAgrupaciones['trimestres']=['trimestres',''] ;
$btnAgrupaciones['annos']=['años',''] ;
$btnAgrupaciones['vacio2']=['','',''] ;
$btnAgrupaciones['grupo']=['grupo','Agrupa las facturas por grupos '] ;
$btnAgrupaciones['firmado']=['firmado','Agrupa las facturas según estén firmadas, conformes, pendientes... '] ;
$btnAgrupaciones['cuadros']=["<span class='glyphicon glyphicon-th-large'></span> cuadros",'Muestra las facturas seleccionadas en forma de cuadros'] ;

//Montaje de fragmentos:
$html = '';
echo encabezadoPagina($tituloEncabezado);
echo iniciaForm($enlaceForm, 'POST', 'form1', 'form1');


$filtrosArr = array();


$filtros[] = [ "type" =>'block',"titulo" =>'Generales' ];
$filtros['proveedor'] = ["type" =>'text', "name" =>'proveedor', "id" =>'proveedor',"class" => '', "titulo" =>'Proveedor o CIF',"value" => $proveedor, "options" => [] ];
$filtros['n_fra']     = ["type" =>'text', "name" =>'n_fra', "id" =>'n_fra',"class" => '', "titulo" =>'Núm. Factura/ID_FRA_PROV',"value" => $n_fra, "options" => [] ];
$filtros['NOMBRE_OBRA'] = ["type" =>'text', "name" =>'NOMBRE_OBRA', "id" =>'NOMBRE_OBRA',"class" => '', "titulo" =>'Obra',"value" => $NOMBRE_OBRA, "options" => [] ];
$filtros['importe1'] = ["type" =>'text', "name" =>'importe1', "id" =>'importe1',"class" => '', "titulo" =>'Importe min	',"value" => $importe1, "options" => [] ];
$filtros['importe2'] = ["type" =>'text', "name" =>'importe2', "id" =>'importe2',"class" => '', "titulo" =>'Importe máx	',"value" => $importe2, "options" => [] ];
$filtros['grupo'] = ["type" =>'text', "name" =>'grupo', "id" =>'grupo',"class" => '', "titulo" =>'Grupo',"value" => $grupo, "options" => [] ];
$filtros['observaciones'] = ["type" =>'text', "name" =>'observaciones', "id" =>'observaciones',"class" => '', "titulo" =>'Observaciones',"value" => $observaciones, "options" => [] ];

$filtros[] = ["type" =>'col' ];
$filtros[] = [ "type" =>'block',"titulo" =>'Periodo' ];

$filtros['fecha1'] = ["type" =>'date', "name" =>'fecha1', "id" =>'fecha1',"class" => '', "titulo" =>'Fecha mín.',"value" => $fecha1, "options" => [] ];
$filtros['fecha2'] = ["type" =>'date', "name" =>'fecha2', "id" =>'fecha2',"class" => '', "titulo" =>'Fecha máx.',"value" => $fecha2, "options" => [] ];
$filtros['MES'] = ["type" =>'text', "name" =>'MES', "id" =>'MES',"class" => '', "titulo" =>'Mes',"value" => $MES, "options" => [] ];
$filtros['Trimestre'] = ["type" =>'text', "name" =>'Trimestre', "id" =>'Trimestre',"class" => '', "titulo" =>'Trimestre',"value" => $Trimestre, "options" => [] ];
$filtros['Anno'] = ["type" =>'text', "name" =>'Anno', "id" =>'Anno',"class" => '', "titulo" =>'Año',"value" => $Anno, "options" => [] ];

$filtros[] = ["type" =>'block', "titulo" =>'Fichero' ];
$filtros['pdf'] = ["type" =>'radio', "name" =>'pdf', "id" =>'pdf',"class" => '', "titulo" =>'pdf',"value" => $pdf, "options" => ['Todas','Con PDF','Sin PDF'] ];
$filtros['path_archivo'] = ["type" =>'text', "name" =>'path_archivo', "id" =>'path_archivo',"class" => '', "titulo" =>'Nombre archivo',"value" => $path_archivo, "options" => [] ];
$filtros['metadatos'] = ["type" =>'text', "name" =>'metadatos', "id" =>'metadatos',"class" => '', "titulo" =>'Metadatos',"value" => $metadatos, "options" => [] ];


//$filtros['firmado'] = ["type" =>'select', "name" =>'firmado', "id" =>'firmado',"class" => '', "titulo" =>'firmado',"value" => $firmado,
//                      "options" => [
//                                    ['',''] 
//                                    ,['sin firmas','sin firmas'] 
//                                    , ['CONFORME','CONFORME'] 
//                                    , ['PDTE','PDTE'] 
//                                    , ['NO_CONF','NO_CONF'] 
//                                   ]
//                       ] ; 
                          
$filtros[] = ["type" =>'col'];
$filtros[] = ["type" =>'block', "titulo" =>'Tipo factura' ];
                          
$filtros['iva'] = ["type" =>'radio', "name" =>'iva', "id" =>'iva',"class" => '', "titulo" =>'iva',"value" => $iva,
                      "options" => ["todas","con iva","sin iva"] 
                       ] ; 

$filtros['nomina'] = ["type" =>'radio', "name" =>'nomina', "id" =>'nomina',"class" => '', "titulo" =>'Tipo ',"value" => $nomina,
                      "options" => ["todas","Nominas","Proveedores"]
                       ] ; 
$filtros[] = [ "type" =>'block',"titulo" =>'Seguimiento' ];

$filtros['firmado'] = ["type" =>'text_list', "name" =>'firmado', "id" =>'firmado',"class" => '', "titulo" =>'firmado',"value" => $firmado,
                      "options" => ['sin firmas','CONFORME','PDTE','NO_CONF'] 
                       ] ; 

$filtros['conciliada'] = ["type" =>'radio', "name" =>'conciliada', "id" =>'conciliada',"class" => '', "titulo" =>'Cargada a Obra',"value" => $conciliada,
                      "options" => ["todas","Cargadas","No Cargadas"]
                       ] ; 
$filtros['pagada'] = ["type" =>'radio', "name" =>'pagada', "id" =>'pagada',"class" => '', "titulo" =>'Pagada',"value" => $pagada,
                      "options" => ["todas","pagadas","No Pagadas"] 
                       ] ; 
$filtros['cobrada'] = ["type" =>'radio', "name" =>'cobrada', "id" =>'cobrada',"class" => '', "titulo" =>'Cobrada proveedor',"value" => $cobrada,
                      "options" => ["todas","Cobradas","No Cobradas"] 
                       ] ; 
                          
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
                         


    //pdf
    $valores = array();
    $valores[] = array('id' => 'pdf', 'value' => '', 'texto' => 'Todas');
    $valores[] = array('id' => 'pdf1', 'value' => '1', 'texto' => 'Con PDF');
    $valores[] = array('id' => 'pdf0', 'value' => '0', 'texto' => 'Sin PDF');
//    $html .= filtroFormularioSimple('select', 'pdf', 'pdf', '', 'PDF', $params['pdf'], $valores);







$filtrosArr['firmado'] = $firmado;
$filtrosArr['conciliada'] = $conciliada;
$filtrosArr['iva'] = $iva;
$filtrosArr['pdf'] = $pdf;
$filtrosArr['nomina'] = $nomina;
$filtrosArr['pagada'] = $pagada;
$filtrosArr['cobrada'] = $cobrada;


//$filtro_html = panelFiltrosFacturasProveedor($listado_global, $filtrosArr);
$filtro_html = panelFiltros( $filtros);
//Para los elementos de operatividad
    $remesas = DOptions_sql("SELECT id_remesa,CONCAT(remesa,'  Importe:',FORMAT(IFNULL(importe,0),2),'€ -Num.Pagos',IFNULL(num_pagos,0)) FROM Remesas_View WHERE activa=1 AND firmada=0 AND $where_c_coste ORDER BY f_vto ");
    $cargas = DOptions_sql("SELECT ID_OBRA,NOMBRE_OBRA FROM OBRAS WHERE $where_c_coste AND  activa ORDER BY activa DESC,NOMBRE_OBRA ");
    $metalicos = '';
    $bancos = DOptions_sql("SELECT id_cta_banco, Banco FROM ctas_bancos WHERE Activo AND $where_c_coste ORDER BY Banco ");
    $sql_update= "UPDATE `FACTURAS_PROV` SET grupo='_VAR_SQL1_' WHERE  ID_FRA_PROV IN _VARIABLE2_ ; "  ;
    $grupos='../include/sql.php?sql=' . encrypt2($sql_update);
$operaciones = panelOperacionesFacturasProveedor($remesas,$cargas,$metalicos,$bancos,$grupos);
$agrupaciones = panelAgrupacionesFacturasProveedor($btnAgrupaciones,$agrupar);
//Para los elementos de resumen
        $sql_resumen="SELECT SUM(Base_Imponible) AS Base_Imponible, SUM(IMPORTE_IVA) - SUM(Base_Imponible) AS importe_de_iva, SUM(IMPORTE_IVA) AS IMPORTE_IVA,SUM(importe_vales) AS importe_cargado,SUM(importe_pagado) AS importe_pagado,"
        . "SUM(importe_cobrado) AS Importe_cobrado  FROM Fras_Prov_View WHERE $where  " ;   
        $datosResumen=$Conn->query($sql_resumen);
        $datosResumen = $datosResumen->fetch_array(MYSQLI_ASSOC);
$resumen = panelResumenFacturasProveedor($datosResumen);
//$labels = labelVerPdf($fmt_pdf);

$array_fmt=[
          ['fmt_pdf', $fmt_pdf , '(Ver PDF)', 'muestra los pdf de las factura']
         ,['fmt_clientes', $fmt_clientes , 'Compara F.Clientes', 'Muestra las Facturas de Clientes para los mismos periodos para comparar IVAs, y facturaciones de Ingeros y Gastos']
    ];

$labels = labelFormatos($array_fmt);
echo selectoresMenuFacturasProveedor($filtro_html,$operaciones,$agrupaciones,$resumen,$labels);
echo botonNuevaFacturaProveedor();
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
function mov_bancos_conciliar_fras_caja_metalico() {
    // var valor0 = valor0_encode;
    // var valor0 = JSON.parse(valor0_encode);
    // var nuevo_valor=window.prompt("Nuevo valor de "+prompt , valor0);
    // alert("el nuevo valor es: "+valor) ;
    // alert('debug') ;
    // var id_mov_banco=document.getElementById("id_mov_banco").value ;
    // var d= new Date() ;
    // var date_str=d.toISOString();
    window.open('../bancos/mov_bancos_conciliar_selection_fras.php?array_str=' + encodeURIComponent(table_selection()));
    // window.open('../obras/obras_anadir_parte.php?id_obra='+id_obra, '_blank');
    // echo "<a class='btn btn-primary' href= '../obras/obras_anadir_parte.php?id_obra=$id_obra' >Añadir parte</a><br>" ;
    return;
}
function mov_bancos_conciliar_fras_cta() {
    // var valor0 = valor0_encode;
    // var valor0 = JSON.parse(valor0_encode);
    // var nuevo_valor=window.prompt("Nuevo valor de "+prompt , valor0);
    // alert("el nuevo valor es: "+valor) ;
    // alert('debug') ;
    var id_cta_banco=document.getElementById("id_cta_banco").value ;
    // var d= new Date() ;
    // var date_str=d.toISOString();
    // mandamos el array con la seleccion de facturas y el numero de cuenta donde cerar el mov_banco y conciliarlas
    window.open('../bancos/mov_bancos_conciliar_selection_fras.php?array_str=' + encodeURIComponent(table_selection())+'&id_mov_banco=CTA_' + id_cta_banco);
    // window.open('../obras/obras_anadir_parte.php?id_obra='+id_obra, '_blank');
    // echo "<a class='btn btn-primary' href= '../obras/obras_anadir_parte.php?id_obra=$id_obra' >Añadir parte</a><br>" ;
    return;
}
function cargar_a_obra_sel_href() {
    // var valor0 = valor0_encode;
    // var valor0 = JSON.parse(valor0_encode);
    // var nuevo_valor=window.prompt("Nuevo valor de "+prompt , valor0);
    // alert("el nuevo valor es: "+valor) ;
    // alert('debug') ;
    var id_obra=document.getElementById("id_obra").value ;
    // var d= new Date() ;
    // var date_str=d.toISOString();
    // table_selection_IN()
    window.open('../proveedores/fra_prov_cargar_a_obra.php?id_fra_prov_sel='+table_selection_IN()+'&id_obra='+id_obra);
    // window.open('../obras/obras_anadir_parte.php?id_obra='+id_obra, '_blank');
    //echo "<a class='btn btn-primary' href= '../obras/obras_anadir_parte.php?id_obra=$id_obra' >Añadir parte</a><br>" ;
    return;
}
function genera_remesa() {
    var id_remesa=document.getElementById("id_remesa").value;
    // alert( id_remesa );
    window.open("../bancos/remesa_anadir_selection.php?id_remesa="+id_remesa+"&array_str=" + table_selection() );
    // window.open("../bancos/remesa_anadir_selection.php?id_remesa="+id_remesa+"&array_str=1");
    // window.open("../menu/pagina_inicio.php");
}
// function ver_remesa() {
//     var id_remesa=document.getElementById("id_remesa").value;
//     //  alert( table_selection() );
//     window.open("../bancos/remesa_ficha.php?id_remesa="+id_remesa );
//     //window.open("../menu/pagina_inicio.php");
// } 
// function cargar_a_obra(){
//     alert( 'PENDIENTE DE DESARROLLO' );
//     // window.open("../bancos/remesa_anadir_selection.php?array_str=" + table_selection() );
//     //window.open("../menu/pagina_inicio.php");   
// }
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