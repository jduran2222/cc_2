<?php
// cambios
require_once("../include/session.php");
$where_c_coste = " id_c_coste={$_SESSION['id_c_coste']} ";
$id_c_coste = $_SESSION['id_c_coste'];

$titulo = 'Búsqueda Global';

// PRUEBA DE GITHUB, JUAND, ENERO2021, VERSION 2 GITHUB

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


 //echo "<pre>";
 // print_r($rs);
 //echo "</pre>";
 //echo "</pre>";
 echo "<br><br><br>";

    
$filtro = isset($_GET["filtro"]) ? urldecode($_GET["filtro"]) : $_POST["filtro"] ;

if(substr($filtro, 0, 1)=='#')
{
 header("Location: busqueda_texto.php");
 echo "<script>window.open('busqueda_texto.php?ht=1&filtro=".str_replace("#","",$filtro)."');</script>" ;
}else
{   

$ajax= ( isset($_GET["filtro"]) AND  isset($_GET["ajax"]) )  ;


// si venimos por ajax no ponemos el FORM y controlamos lo que devolvemos
if( !$ajax ) 
{    
    
?>

    

<!--<div class="container-fluid">-->	
<div class="row">
<!--    <div class="col-sm-2">
        <img src="../img/construcloud128.jpg" >
        <a class="boton" title="" href="../menu/pagina_inicio.php" >Inicio</a>

    </div>
    --> 
  <div class="col-sm-12" style="background-color: lightblue">
    <form action="../menu/busqueda_global.php" method="post" id="form1" name="form1">
        <br><br><br><h1>Buscar entidad:<INPUT type="text" size='20' name="filtro" value="<?php echo $filtro ; ?>">
                         <button type="submit" class="btn btn-default btn-lg">
                                <i class="fas fa-search"></i> 
                            </button></h1>
    </form>
    </div>
    
</div>		
	
<div class="row">
    <h1>Resultados de la búsqueda: "<b><?php echo $filtro ?></b>"</h1>
    <h4 style='color:silver'>Tiempo de búsqueda <input style='border:none;color:silver'  type="text" id="tiempo" name="tiempo" size="20"></h4>
</DIV>   
<div class="row">    
<!--<div class="col-sm-2"></div>-->
<div class="col-sm-12">
<?php

} // fin de pintar el FORM si no es ajax

//echo "<h1 >Resultados de la búsqueda:<b> $filtro </b></h1>" ;
$filtro= str_replace("_", "%", trim($filtro) ) ;           // cambiamos los espacios por '%' (* asterísticos en SQL)
$filtro= str_replace(" ", "%", $filtro ) ;           // cambiamos los espacios por '%' (* asterísticos en SQL)
$limite=10 ;

$time0=microtime(true);


$content="";

if ($filtro<>"")
{    
   $g=0;                // contador global de links
 
  $content.= "<table class='table table-hover table-striped table-bordered' >"  ;
  $content.= "<tr><td>RESULTADOS"  ;
 
  
 // buscamos PROVEEDORES
 $result=$Conn->query("SELECT ID_PROVEEDORES AS ID,PROVEEDOR AS TEXTO1, RAZON_SOCIAL AS TEXTO2,CIF AS TEXTO3  FROM Proveedores WHERE  CONCAT_WS(' - ','@PROVEEDOR' ,PROVEEDOR,RAZON_SOCIAL, CIF) LIKE '%$filtro%' AND $where_c_coste ORDER BY ID_PROVEEDORES DESC LIMIT $limite");
 
 if ($result->num_rows > 0)
 {  
     $c=0 ;
    $content.= "</td></tr></table><br><table class='table table-hover table-striped table-bordered'><tr><td><p style='font-size: 40px;'><i class='fas fa-shopping-cart'></i>&nbsp;PROVEEDORES  ({$result->num_rows}):</p>" ;
    while($rs = $result->fetch_array(MYSQLI_ASSOC))    // cojo la de mayor usuarios permitidos 
    {
     $c++ ;   $g++ ;
     $content.= "</td></tr><tr><td><a id='a_link' style='font-size: 40px;' target='_blank' href='../proveedores/proveedores_ficha.php?id_proveedor={$rs["ID"]}'>{$rs["TEXTO1"]}</a> ,  {$rs["TEXTO2"]} <font size=5 color=grey>({$rs["TEXTO3"]})</font>"   ;
    }
    if ($c==$limite) {$content.= ".....<a class='btn btn-link btn-xs' href='../proveedores/proveedores_buscar.php' >Buscar más proveedores</a> " ; }
    
 }
 
// buscamos Estudios_de_Obra 
if ($_SESSION["permiso_licitacion"])    
{
    $result=$Conn->query("SELECT ID_ESTUDIO,NUMERO,NOMBRE,`PLAZO ENTREGA` FROM Estudios_view WHERE  CONCAT('@licitacion',NUMERO,'-',NOMBRE,COALESCE(`Nombre Completo`,'')) LIKE '%$filtro%' AND $where_c_coste ORDER BY NUMERO DESC LIMIT $limite");
 if ($result->num_rows > 0)
 {  
     $c=0 ;
    $content.= "</td></tr></table><br><table class='table table-hover table-striped table-bordered'><tr><td><p style='font-size: 40px;'><i class='fas fa-globe-europe'></i>&nbsp;LICITACIONES ({$result->num_rows}):</p>" ;
    while($rs = $result->fetch_array(MYSQLI_ASSOC))    // cojo la de mayor usuarios permitidos 
    {
     $c++ ;   $g++ ;
     $content.= "</td></tr><tr><td><a id='a_link' style='font-size: 40px;' target='_blank' href='../estudios/estudios_ficha.php?id_estudio={$rs["ID_ESTUDIO"]}'>@licitacion{$rs["NUMERO"]}-{$rs["NOMBRE"]}</a>...<font size=5 color=grey>({$rs["PLAZO ENTREGA"]})</font>"   ;
    }
    if ($c==$limite) {$content.= ".....<a class='btn btn-link btn-xs' href='../estudios/estudios_buscar.php' >Buscar más estudios de obra</a> " ; }
    
 }
}
 // buscamos Ofertas de Obra
 $result=$Conn->query("SELECT ID_OFERTA,NUMERO,NOMBRE_OFERTA AS NOMBRE,FECHA    FROM Ofertas_View WHERE  NOMBRE_OFERTA LIKE '%$filtro%' AND $where_c_coste ORDER BY NUMERO DESC LIMIT $limite");
 //$result=$Conn->query("SELECT ID_ESTUDIO,NUMERO,NOMBRE,`PLAZO ENTREGA`   FROM Estudios_view WHERE  filtro2 LIKE '%$filtro%' AND $where_c_coste ORDER BY NUMERO DESC LIMIT $limite");
 
 if ($result->num_rows > 0)
 {  
     $c=0 ;
    $content.= "</td></tr></table><br><table class='table table-hover table-striped table-bordered'><tr><td><p style='font-size: 40px;'><i class='fas fa-globe-europe'></i>&nbsp;OFERTAS A CLIENTES ({$result->num_rows}):</p>" ;
    while($rs = $result->fetch_array(MYSQLI_ASSOC))    // cojo la de mayor usuarios permitidos 
    {
     $c++ ;   $g++ ;
     $content.= "</td></tr><tr><td><a id='a_link' style='font-size: 40px;' target='_blank' href='../estudios/oferta_ficha.php?id_oferta={$rs["ID_OFERTA"]}'>{$rs["NUMERO"]}-{$rs["NOMBRE"]}</a>...<font size=5 color=grey>({$rs["FECHA"]})</font>"   ;
    }
    if ($c==$limite) {$content.= ".....<a class='btn btn-link btn-xs' href='../estudios/ofertas_clientes.php' >Buscar más Ofertas a Clientes</a> " ; }
    
 }
 
 // buscamos OBRAS
if ($_SESSION["permiso_obras"])     
{
  // buscamos todas ls OBRAS (subcentros mejor dicho) que NO sean Estudios tipo_subcentro=='E'  
 $result=$Conn->query("SELECT ID_OBRA AS ID,'' AS NUMERO, NOMBRE_OBRA AS NOMBRE,FECHA_INICIO AS FECHA  FROM OBRAS "
         . " WHERE   CONCAT('@OBRA.',NOMBRE_OBRA,COALESCE(NOMBRE_COMPLETO,'')) LIKE '%$filtro%' "
         . " AND $where_c_coste AND tipo_subcentro<>'E' ORDER BY NOMBRE_OBRA DESC LIMIT $limite");
 //(tipo_subcentro='O' OR tipo_subcentro='M' OR tipo_subcentro='G') AND
 if ($result->num_rows > 0)
 {  
     $c=0 ;
    $content.= "</td></tr></table><br><table class='table table-hover table-striped table-bordered'><tr><td><p style='font-size: 40px;'><span class='glyphicon glyphicon-road'></span>&nbsp;OBRAS ({$result->num_rows}):</p>" ;
    while($rs = $result->fetch_array(MYSQLI_ASSOC))    // cojo la de mayor usuarios permitidos 
    {
     $c++ ;   $g++ ;
     $content.= "</td></tr><tr><td><a id='a_link' style='font-size: 40px;' target='_blank' href='../obras/obras_ficha.php?id_obra={$rs["ID"]}'>@obra {$rs["NOMBRE"]}</a>...<font size=5 color=grey>({$rs["FECHA"]})</font>"   ;
    }
    if ($c==$limite) {$content.= ".....<a class='btn btn-link btn-xs' href='../obras/obras_buscar.php?tipo_subcentro=O' >Buscar más Obras</a> " ; }
    
 }
 
 // buscamos PRODUCCION DE OBRAS
 $result=$Conn->query("SELECT *  FROM Prod_view WHERE CONCAT('@rel_val',NOMBRE_OBRA,' ',PRODUCCION) LIKE '%$filtro%' AND $where_c_coste ORDER BY NOMBRE_OBRA DESC, fecha_creacion DESC LIMIT $limite");
 
 if ($result->num_rows > 0)
 {  
     $c=0 ;
    $content.= "</td></tr></table><br><table class='table table-hover table-striped table-bordered'><tr><td><p style='font-size: 40px;'><i class='fas fa-globe-europe'></i>&nbsp;RELACIONES VALORADAS ({$result->num_rows}):</p>" ;
    while($rs = $result->fetch_array(MYSQLI_ASSOC))    // cojo la de mayor usuarios permitidos 
    {
     $c++ ;   $g++ ;
     $content.= "</td></tr><tr><td><a id='a_link' style='font-size: 40px;' target='_blank' href='../obras/obras_prod_detalle.php?id_obra={$rs["ID_OBRA"]}&id_produccion={$rs["ID_PRODUCCION"]}'>@rel_val {$rs["NOMBRE_OBRA"]} / {$rs["PRODUCCION"]}</a>...<font size=5 color=grey>({$rs["fecha_creacion"]})</font>"   ;
    }
    //if ($c==$limite) {$content.= ".....<a class='btn btn-link btn-xs' href='../obras/obras_prod_detalle.php?id_produccion={$rs["NOMBRE"]}' >Buscar más Obras</a> " ; }
    
 }
 // buscamos MAQUINARIA
 $result=$Conn->query("SELECT ID_OBRA AS ID,'' AS NUMERO, NOMBRE_OBRA AS NOMBRE,FECHA_INICIO AS FECHA  FROM OBRAS WHERE tipo_subcentro='M' AND CONCAT('@maquinaria',NOMBRE_OBRA,NOMBRE_COMPLETO) LIKE '%$filtro%' AND $where_c_coste ORDER BY NOMBRE_OBRA DESC LIMIT $limite");
 
 if ($result->num_rows > 0)
 {  
     $c=0 ;
    $content.= "</td></tr></table><br><table class='table table-hover table-striped table-bordered'><tr><td><p style='font-size: 40px;'><i class='fas fa-globe-europe'></i>&nbsp;MAQUINARIA ({$result->num_rows}):</p>" ;
    while($rs = $result->fetch_array(MYSQLI_ASSOC))    // cojo la de mayor usuarios permitidos 
    {
     $c++ ;   $g++ ;
     $content.= "</td></tr><tr><td><a id='a_link' style='font-size: 40px;' target='_blank' href='../obras/obras_ficha.php?id_obra={$rs["ID"]}'>@maquinaria {$rs["NOMBRE"]}</a>...<font size=5 color=grey>({$rs["FECHA"]})</font>"   ;
    }
    if ($c==$limite) {$content.= ".....<a class='btn btn-link btn-xs' href='../obras/obras_buscar.php?tipo_subcentro=M' >Buscar más Maquinaria</a> " ; }
    
 }
 // buscamos OBRAS -> POF 
 $result=$Conn->query("SELECT *  FROM POF_lista WHERE CONCAT('@pof',NOMBRE_OBRA,'-',NUMERO,'-',NOMBRE_POF) LIKE '%$filtro%' AND $where_c_coste ORDER BY fecha_creacion DESC LIMIT $limite");
 
 if ($result->num_rows > 0)
 {  
     $c=0 ;
    $content.= "</td></tr></table><br><table class='table table-hover table-striped table-bordered'><tr><td><p style='font-size: 40px;'><i class='fas fa-globe-europe'></i>&nbsp;POF DE OBRAS ({$result->num_rows}):</p>" ;
    while($rs = $result->fetch_array(MYSQLI_ASSOC))    // cojo la de mayor usuarios permitidos 
    {
     $c++ ;   $g++ ;
     $content.= "</td></tr><tr><td><a id='a_link' style='font-size: 40px;' target='_blank' href='../pof/pof.php?id_pof={$rs["ID_POF"]}'>@pof {$rs["NOMBRE_OBRA"]} / {$rs["NUMERO"]}-{$rs["NOMBRE_POF"]}</a>...<font size=5 color=grey>({$rs["fecha_creacion"]})</font>"   ;
    }
    //if ($c==$limite) {$content.= ".....<a class='btn btn-link btn-xs' href='../obras/obras_prod_detalle.php?id_produccion={$rs["NOMBRE"]}' >Buscar más Obras</a> " ; }
    
 }

 // buscamos OBRAS -> POF -> PROVEEDOR
 $result=$Conn->query("SELECT *,CONCAT('<b>',NOMBRE_OBRA,'</b> pof:<b> ',NUMERO,'-',NOMBRE_POF,' </b>prov: <b>',NUM,'-',PROVEEDOR,'</b>') AS filtro  "
         . " FROM POF_prov_View WHERE CONCAT('@pof_prov',NOMBRE_OBRA,NUMERO,'-',NOMBRE_POF,'PROVEEDOR',NUM,'-',PROVEEDOR) LIKE '%$filtro%' AND $where_c_coste "
         . " ORDER BY NOMBRE_OBRA DESC, fecha_creacion DESC LIMIT $limite");
 
 if ($result->num_rows > 0)
 {  
     $c=0 ;
    $content.= "</td></tr></table><br><table class='table table-hover table-striped table-bordered'><tr><td><p style='font-size: 40px;'><i class='fas fa-globe-europe'></i>&nbsp;PROVEEDOR POF OBRA  ({$result->num_rows}):</p>" ;
    while($rs = $result->fetch_array(MYSQLI_ASSOC))    // cojo la de mayor usuarios permitidos 
    {
     $c++ ;   $g++ ;
     $content.= "</td></tr><tr><td><a id='a_link' style='font-size: 40px;' target='_blank' href='../pof/pof_proveedor_ficha.php?id={$rs["id"]}'>pof_prov {$rs["filtro"]} </a>"
     . "...<font size=5 color=grey>Importe ".cc_format($rs["Importe_Prov"],"moneda")."</font>"   ;
    }
    //if ($c==$limite) {$content.= ".....<a class='btn btn-link btn-xs' href='../obras/obras_prod_detalle.php?id_produccion={$rs["NOMBRE"]}' >Buscar más Obras</a> " ; }
    
 }
 // buscamos OBRAS -> SUBCONTRATOS 
 $result=$Conn->query("SELECT *,CONCAT('@subcontrato ',NOMBRE_OBRA,'/',subcontrato,'/',PROVEEDOR) AS leyenda  FROM Subcontratos_todos_View WHERE CONCAT('@subcontrato ',NOMBRE_OBRA,'/',subcontrato,'/',PROVEEDOR) LIKE '%$filtro%' AND $where_c_coste ORDER BY NOMBRE_OBRA DESC, fecha_creacion DESC LIMIT $limite");
 
 if ($result->num_rows > 0)
 {  
     $c=0 ;
    $content.= "</td></tr></table><br><table class='table table-hover table-striped table-bordered'><tr><td><p style='font-size: 40px;'><i class='fas fa-globe-europe'></i>&nbsp;SUBCONTRATOS ({$result->num_rows}):</p>" ;
    while($rs = $result->fetch_array(MYSQLI_ASSOC))    // cojo la de mayor usuarios permitidos 
    {
     $c++ ;   $g++ ;
     $content.= "</td></tr><tr><td><a id='a_link' style='font-size: 40px;' target='_blank' href='../obras/subcontrato.php?id_subcontrato={$rs["id_subcontrato"]}'>{$rs["leyenda"]}</a>...<font size=5 color=grey>({$rs["fecha_creacion"]})</font>"   ;
    }
    //if ($c==$limite) {$content.= ".....<a class='btn btn-link btn-xs' href='../obras/obras_prod_detalle.php?id_produccion={$rs["NOMBRE"]}' >Buscar más Obras</a> " ; }
    
 }
// buscamos UDOS
 $result=$Conn->query("SELECT ID_UDO,CONCAT_WS(' - ','@udo',MID(NOMBRE_OBRA,1,12),CAPITULO,PRECIO,' € <b>',UDO,'</b>','</td></tr><tr><td>',TEXTO_UDO) AS filtro "
         . "FROM Udos_View WHERE CONCAT('@udo',NOMBRE_OBRA,UDO,IFNULL(TEXTO_UDO,'')) LIKE '%$filtro%' AND $where_c_coste ORDER BY ID_OBRA DESC LIMIT $limite");
 
 if ($result->num_rows > 0)
 {  
     $c=0 ;
    $content.= "</td></tr></table><br><table class='table table-hover table-striped table-bordered'><tr><td><p style='font-size: 40px;'><i class='fas fa-globe-europe'></i>&nbsp;UDOS. Unidades de Obra</p>" ;
    while($rs = $result->fetch_array(MYSQLI_ASSOC))    // cojo la de mayor usuarios permitidos 
    {
     $c++ ;   $g++ ;
     $content.= "</td></tr><tr><td><a id='a_link' style='font-size: 40px;' target='_blank' href='../obras/udo_prod.php?id_udo={$rs["ID_UDO"]}'>{$rs["filtro"]} </a>...<font size=5 color=grey></font>"   ;
    }
    //if ($c==$limite) {$content.= ".....<a class='btn btn-link btn-xs' href='../obras/obras_prod_detalle.php?id_produccion={$rs["NOMBRE"]}' >Buscar más Obras</a> " ; }
    
 }

}
if ($_SESSION["permiso_administracion"])    
{
// buscamos REMESAS DE PAGOS
 $result=$Conn->query("SELECT *  FROM Remesas_View WHERE CONCAT('@REMESA ',remesa) LIKE '%$filtro%' AND $where_c_coste ORDER BY fecha_creacion DESC LIMIT $limite");
 
 if ($result->num_rows > 0)
 {  
     $c=0 ;
    $content.= "</td></tr></table><br><table class='table table-hover table-striped table-bordered'><tr><td><p style='font-size: 40px;'><i class='fas fa-euro-sign'></i>&nbsp;REMESAS DE PAGOS ({$result->num_rows}):</p>" ;
    while($rs = $result->fetch_array(MYSQLI_ASSOC))    // cojo la de mayor usuarios permitidos 
    {
     $c++ ;   $g++ ;
     $content.= "</td></tr><tr><td><a id='a_link' style='font-size: 40px;' target='_blank' href='../bancos/remesa_ficha.php?id_remesa={$rs["id_remesa"]}'>REMESA:{$rs["remesa"]}</a>...<font size=5 color=grey>({$rs["fecha_creacion"]})</font>"   ;
    }
    //if ($c==$limite) {$content.= ".....<a class='btn btn-link btn-xs' href='../obras/obras_prod_detalle.php?id_produccion={$rs["NOMBRE"]}' >Buscar más Obras</a> " ; }
    
 }
  // buscamos CLIENTES
 $result=$Conn->query("SELECT ID_CLIENTE AS ID,CLIENTE AS TEXTO1, NOMBRE_FISCAL AS TEXTO2,CIF AS TEXTO3  FROM Clientes WHERE  CONCAT_WS(' - ' ,'@CLIENTE',CLIENTE,NOMBRE_FISCAL, CIF) LIKE '%$filtro%' AND $where_c_coste ORDER BY ID_CLIENTE DESC LIMIT $limite");
 
 if ($result->num_rows > 0)
 {  
     $c=0 ;
    $content.= "</td></tr></table><br><table class='table table-hover table-striped table-bordered'><tr><td><p style='font-size: 40px;'><i class='fas fa-briefcase'></i>&nbsp;CLIENTES ({$result->num_rows}):</p>" ;
    while($rs = $result->fetch_array(MYSQLI_ASSOC))    // cojo la de mayor usuarios permitidos 
    {
     $c++ ;   $g++ ;
     $content.= "</td></tr><tr><td><a id='a_link' style='font-size: 40px;' target='_blank' href='../clientes/clientes_ficha.php?id_cliente={$rs["ID"]}'>{$rs["TEXTO1"]}</a> ,  {$rs["TEXTO2"]} <font size=5 color=grey>({$rs["TEXTO3"]})</font>"   ;
    }
    if ($c==$limite) {$content.= ".....<a class='btn btn-link btn-xs' href='../clientes/clientes_buscar.php' >Buscar más clientes</a> " ; }
    
 }
 
 // buscamos FRAS CLIENTES
 $result=$Conn->query("SELECT ID_FRA AS ID,CONCAT_WS(' - ','@fra_cli' ,NOMBRE_OBRA,CLIENTE,N_FRA,IMPORTE_IVA) AS TEXTO1, CLIENTE AS TEXTO2,CONCEPTO AS TEXTO3"
         . "  FROM Facturas_View WHERE  CONCAT_WS(' - ','@fra_cli' ,NOMBRE_OBRA,CLIENTE,N_FRA,IMPORTE_IVA) LIKE '%$filtro%' AND $where_c_coste ORDER BY fecha_emision DESC LIMIT $limite");
 
 if ($result->num_rows > 0)
 {  
     $c=0 ;
    $content.= "</td></tr></table><br><table class='table table-hover table-striped table-bordered'><tr><td><p style='font-size: 40px;'><i class='fas fa-globe-europe'></i>&nbsp;FACTURAS CLIENTES ({$result->num_rows}):</p>" ;
    while($rs = $result->fetch_array(MYSQLI_ASSOC))    // cojo la de mayor usuarios permitidos 
    {
     $c++ ;   $g++ ;
     $content.= "</td></tr><tr><td><a id='a_link' style='font-size: 40px;' target='_blank' href='../clientes/factura_cliente.php?id_fra={$rs["ID"]}'>{$rs["TEXTO1"]}</a> ,  {$rs["TEXTO2"]} <font size=5 color=grey>({$rs["TEXTO3"]})</font>"   ;
    }
    if ($c==$limite) {$content.= ".....<a class='btn btn-link btn-xs' href='../clientes/clientes_buscar.php' >Buscar más clientes</a> " ; }
    
 }
 
 if ($_SESSION["permiso_bancos"])    
{
 // buscamos BANCOS
 $result=$Conn->query("SELECT id_cta_banco AS ID,Banco AS TEXTO1, N_Cta AS TEXTO2,f_vto AS TEXTO3  FROM ctas_bancos WHERE  CONCAT_WS(' - ','@banco' ,Banco,N_Cta) LIKE '%$filtro%' AND $where_c_coste ORDER BY Banco LIMIT $limite");
 
 if ($result->num_rows > 0)
 {  
     $c=0 ;
    $content.= "</td></tr></table><br><table class='table table-hover table-striped table-bordered'><tr><td><p style='font-size: 40px;'><i class='fas fa-euro-sign'></i>&nbsp;BANCOS ({$result->num_rows}):</p>" ;
    while($rs = $result->fetch_array(MYSQLI_ASSOC))    
    {
     $c++ ;   $g++ ;
     $content.= "</td></tr><tr><td><a id='a_link' style='font-size: 40px;' target='_blank' href='../bancos/bancos_mov_bancarios.php?id_cta_banco={$rs["ID"]}'>{$rs["TEXTO1"]}</a> ,  {$rs["TEXTO2"]} <font size=5 color=grey>({$rs["TEXTO3"]})</font>"   ;
    }
    if ($c==$limite) {$content.= ".....<a class='btn btn-link btn-xs' href='../bancos/bancos_ctas_bancos.php' >Buscar más bancos</a> " ; }
    
 }
} 
 // buscamos PERSONAL
 $result=$Conn->query("SELECT ID_PERSONAL AS ID,NOMBRE AS TEXTO1, DNI AS TEXTO2,F_ALTA AS TEXTO3  FROM PERSONAL WHERE  CONCAT_WS(' - ','@PERSONAL' ,NOMBRE,DNI) LIKE '%$filtro%' AND $where_c_coste ORDER BY NOMBRE LIMIT $limite");
 
 if ($result->num_rows > 0)
 {  
     $c=0 ;
    $content.= "</td></tr></table><br><table class='table table-hover table-striped table-bordered'><tr><td><p style='font-size: 40px;'><i class='far fa-user'></i>&nbsp;PERSONAL ({$result->num_rows}):</p>" ;
    while($rs = $result->fetch_array(MYSQLI_ASSOC))    
    {
     $c++ ;   $g++ ;
     $content.= "</td></tr><tr><td><a id='a_link' style='font-size: 40px;' target='_blank' href='../personal/personal_ficha.php?id_personal={$rs["ID"]}'>{$rs["TEXTO1"]}</a> ,  {$rs["TEXTO2"]} <font size=5 color=grey>({$rs["TEXTO3"]})</font>"   ;
    }
    if ($c==$limite) {$content.= ".....<a class='btn btn-link btn-xs' href='../personal/personal_buscar.php' >Buscar más Fichas de personal</a> " ; }
    
 }
 // buscamos OTROS SUBCENTROS
 $result=$Conn->query("SELECT ID_OBRA AS ID,'' AS NUMERO, NOMBRE_OBRA AS NOMBRE,FECHA_INICIO AS FECHA  FROM OBRAS WHERE tipo_subcentro<>'O' AND tipo_subcentro<>'M' AND CONCAT(NOMBRE_OBRA,NOMBRE_COMPLETO) LIKE '%$filtro%' AND $where_c_coste ORDER BY NOMBRE_OBRA DESC LIMIT $limite");
 
 if ($result->num_rows > 0)
 {  
     $c=0 ;
    $content.= "</td></tr></table><br><table class='table table-hover table-striped table-bordered'><tr><td><p style='font-size: 40px;'><i class='fas fa-globe-europe'></i>&nbsp;OTROS SUBCENTROS ({$result->num_rows}):</p>" ;
    while($rs = $result->fetch_array(MYSQLI_ASSOC))    // cojo la de mayor usuarios permitidos 
    {
     $c++ ;   $g++ ;
     $content.= "</td></tr><tr><td><a id='a_link' style='font-size: 40px;' target='_blank' href='../obras/obras_ficha.php?id_obra={$rs["ID"]}'>{$rs["NOMBRE"]}</a>...<font size=5 color=grey>({$rs["FECHA"]})</font>"   ;
    }
    if ($c==$limite) {$content.= ".....<a class='btn btn-link btn-xs' href='../obras/obras_buscar.php' >Buscar más subcentros</a> " ; }
    
 }
 
}
 
 
 

 // buscamos Proveedores BD
 $result=$Conn->query("SELECT ID_PROVEEDOR AS ID,NOMBRE AS TEXTO1,Localidad  AS TEXTO3,TIPO AS TEXTO2  FROM ProveedoresBD WHERE  CONCAT_WS(' - ' ,'@bdproveedor',NOMBRE,TIPO,Localidad) LIKE '%$filtro%' AND $where_c_coste ORDER BY NOMBRE LIMIT $limite");
 
 if ($result->num_rows > 0)
 {  
     $c=0 ;
    $content.= "</td></tr></table><br><table class='table table-hover table-striped table-bordered'><tr><td><p style='font-size: 40px;'><i class='fas fa-globe-europe'></i>&nbsp;Páginas amarillas de Proveedores  ({$result->num_rows}):</p>" ;
    while($rs = $result->fetch_array(MYSQLI_ASSOC))    
    {
     $c++ ;   $g++ ;
     $content.= "</td></tr><tr><td><a id='a_link' style='font-size: 40px;' target='_blank' href='../proveedores/proveedoresBD_ficha.php?id_proveedor={$rs["ID"]}'>{$rs["TEXTO1"]}</a> ,  {$rs["TEXTO2"]} <font size=5 color=grey>({$rs["TEXTO3"]})</font>"   ;
    }
    if ($c==$limite) {$content.= ".....<a class='btn btn-link btn-xs' href='../proveedores/proveedoresBD_buscar.php' >Buscar más Fichas en Base Datos de proveedores </a> " ; }
    
 }
 
 
// buscamos CONCEPTOS  , CONCEPTO PROVEEDOR -> Concepto
 $result=$Conn->query("SELECT ID_CONCEPTO,CONCAT('@CONCEPTO ',MID(PROVEEDOR,1,12),' ',COSTE,' € <b>',CONCEPTO,'</b> ',MID(NOMBRE_OBRA,1,12),' (',FORMAT(SUM(IMPORTE),0),'€ en total)') AS filtro, "
         . "YEAR(Fecha_Creacion) as Anno  FROM ConsultaGastos_View WHERE CONCAT_WS('.','@CONCEPTO',PROVEEDOR,CONCEPTO) LIKE '%$filtro%' AND $where_c_coste GROUP BY ID_CONCEPTO ORDER BY Fecha_Creacion DESC LIMIT $limite");
 

 if ($result->num_rows > 0)
 {  
     $c=0 ;
    $content.= "</td></tr></table><br><table class='table table-hover table-striped table-bordered'><tr><td><p style='font-size: 40px;'><i class='fas fa-globe-europe'></i>&nbsp;CONCEPTOS DE PROVEEDOR</p>" ;
    while($rs = $result->fetch_array(MYSQLI_ASSOC))    // cojo la de mayor usuarios permitidos 
    {
     $c++ ;   $g++ ;
//     $content.= "<br><a id='a_link' style='font-size: 40px;' target='_blank' href='../include/ficha_general.php?tabla=CONCEPTOS&id_update=ID_CONCEPTO&id_valor={$rs["ID_CONCEPTO"]}'>{$rs["filtro"]} </a>...<font size=5 color=grey>(Año {$rs["Anno"]} )</font>"   ;
     $content.= "</td></tr><tr><td><a id='a_link' style='font-size: 40px;' target='_blank' href='../proveedores/concepto_ficha.php?id_concepto={$rs["ID_CONCEPTO"]}'>{$rs["filtro"]} </a>...<font size=5 color=grey>(Año {$rs["Anno"]} )</font>"   ;
    }
    //if ($c==$limite) {$content.= ".....<a class='btn btn-link btn-xs' href='../obras/obras_prod_detalle.php?id_produccion={$rs["NOMBRE"]}' >Buscar más Obras</a> " ; }
    
 }

// buscamos DOCUMENTOS
 $result=$Conn->query("SELECT id_documento,CONCAT_WS(' - ','@documento',tipo_entidad,nombre_archivo,documento) AS filtro "
         . "FROM Documentos WHERE CONCAT_WS(' - ','@documento',tipo_entidad,nombre_archivo,documento) LIKE '%$filtro%' AND $where_c_coste ORDER BY fecha_creacion DESC LIMIT $limite");
 
 if ($result->num_rows > 0)
 {  
     $c=0 ;
    $content.= "</td></tr></table><br><table class='table table-hover table-striped table-bordered'><tr><td><p style='font-size: 40px;'><span class='glyphicon glyphicon-globe'>"
     . "</span>&nbsp;Documentos ({$result->num_rows}):</p>" ;
    while($rs = $result->fetch_array(MYSQLI_ASSOC))    // cojo la de mayor usuarios permitidos 
    {
     $c++ ;   $g++ ;
     $content.= "</td></tr><tr><td><a id='a_link' style='font-size: 40px;' target='_blank' href='../documentos/documento_ficha.php?id_documento={$rs["id_documento"]}'>{$rs["filtro"]} </a>...<font size=5 color=grey></font>"   ;
    }
    //if ($c==$limite) {$content.= ".....<a class='btn btn-link btn-xs' href='../obras/obras_prod_detalle.php?id_produccion={$rs["NOMBRE"]}' >Buscar más Obras</a> " ; }
    
 }

 // buscamos VEHICULOS
 $result=$Conn->query("SELECT ID_VEHICULO AS ID,MATRICULA AS TEXTO1, MODELO AS TEXTO2,RENTACAR AS TEXTO3  FROM VEHICULOS WHERE  CONCAT_WS(' - ' ,'@vehiculo',MATRICULA,MODELO,RENTACAR) LIKE '%$filtro%' AND $where_c_coste ORDER BY MATRICULA LIMIT $limite");
 
 if ($result->num_rows > 0)
 {  
     $c=0 ;
    $content.= "</td></tr></table><br><table class='table table-hover table-striped table-bordered'><tr><td><p style='font-size: 40px;'><i class='fas fa-globe-europe'></i>&nbsp;VEHICULOS ({$result->num_rows}):</p>" ;
    while($rs = $result->fetch_array(MYSQLI_ASSOC))    
    {
     $c++ ;   $g++ ;
     $content.= "</td></tr><tr><td><a id='a_link' style='font-size: 40px;' target='_blank' href='../vehiculos/vehiculos_ficha.php?id_vehiculo={$rs["ID"]}'>{$rs["TEXTO1"]}</a> ,  {$rs["TEXTO2"]} <font size=5 color=grey>({$rs["TEXTO3"]})</font>"   ;
    }
    if ($c==$limite) {$content.= ".....<a class='btn btn-link btn-xs' href='../vehiculos/vehiculos_buscar.php' >Buscar más vehiculos</a> " ; }
    
 }
 
//  $content.= "Codigo de busqueda:<br>". encrypt($filtro) ;
$content.= "</td></tr></table>" ;
$content.= "<BR>Tiempo: ".number_format(microtime(true)-$time0,3)." segundos " ;
//$content.= "<script>$(#tiempo).val(' ".number_format(microtime(true)-$time0,3)." segundos ');</script> " ;
$content.= "<script>$('#tiempo').val(' ".number_format(microtime(true)-$time0,3)." segundos ');</script> " ;
//$content.= "<script>$('input:text').val(' juan ');alert('juan');</script> " ;
$content.= "<br><p><h1>Fin de la búsqueda</h1></p>" ;

 
}   
else
{
    $content.= "<br><p style='font-size: 40px;'><i class='fas fa-globe-europe'></i>&nbsp;Filtro vacío</p>" ;
}

if (!$ajax)
{  
     // si solo hay un link lo ejecutamos
      if ($g==1)
      {
          echo $content ;
         
          echo '<script>' ;
          echo "document.getElementById('a_link').click();"  ;      
    //      echo "window.close();"  ;      // anulado provisionalmente porque da problemas al abrir directamente el <a href>, parece SPAM  y necesita autorización para pagina nueva emergente
          echo '</script>' ;      
      }else
      {
          // imprimimos los links en pantalla
          echo $content ;
          
      }   
  
}else  // venimos con AJAX
{
    // PENDIENTE DE DESARROLLAR TRAS PROFUNDO CAMBIOEN EL PHP Y METER EN UN ARRAY TODAS LAS CONSULTAS SQL Y POSTERIORMENTE TODOS LOS LINKS
    
    
}    


}
?>    
   

    
    
</div>	
</div>
	

                </div>
                <!--****************** BUSQUEDA GLOBAL  *****************
            </div>
        </div>
        <!-- FIN Contenido principal -->

<?php 

//FIN
include_once('../templates/_inc_privado3_footer.php');
