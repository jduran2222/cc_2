<?php
// cambios
require_once("../include/session.php");
$where_c_coste = " id_c_coste={$_SESSION['id_c_coste']} ";
$id_c_coste = $_SESSION['id_c_coste'];

$banco_titulo= isset($_GET["id_cta_banco"]) ?  Dfirst("Banco","ctas_bancos", "id_cta_banco={$_GET["id_cta_banco"]} AND $where_c_coste"  ) : "GLOBAL" ;
$titulo_pagina="Cuenta banco $banco_titulo"  ;
$titulo = $titulo_pagina;

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

require_once("../bancos/bancos_menutop_r.php");


$iniciar_form=(!isset($_POST["agrupar"])) ;  // determinamos si debemos de inicializar el FORM con valores vacíos

if ($iniciar_form)    
    {
        $banco="" ;
        $concepto="" ;
        $fecha1="2017-01-01" ;  
        $fecha2="" ;  
        $importe1="" ;
        $importe2="" ;
        $ingreso1="" ;
        $ingreso2="" ;
        $conc="" ;
//        $cobrada="" ;
        $agrupar = 'ultimos_movs_reg' ;     
    }
    else
    {
//        $banco=$_POST["banco"] ;
        $concepto=$_POST["concepto"] ;
        $fecha1=$_POST["fecha1"] ;  
        $fecha2=$_POST["fecha2"] ;  
        $importe1=$_POST["importe1"] ;
        $importe2=$_POST["importe2"] ;
        $ingreso1=$_POST["ingreso1"] ;
        $ingreso2=$_POST["ingreso2"] ;
        $conc=$_POST["conc"] ;
//        $cobrada=$_POST["cobrada"] ;
        $agrupar =$_POST["agrupar"] ;     
    }   
  

// Comprobamos si es el listado de un único proveedor o un listado global

$listado_global= (!isset($_GET["id_cta_banco"])) ;

if (!$listado_global)                
  { 
    // FICHA DE CUENTA BANCARIA
    $id_cta_banco=$_GET["id_cta_banco"];         // Estamos viendo los MOV. BANCOS de un único proveedor
//    $banco=Dfirst("Banco", "ctas_bancos", "id_cta_banco=$id_cta_banco AND $where_c_coste" )  ;
//    $saldo1=Dfirst("SUM(ingreso)", "MOV_BANCOS_View", "id_cta_banco=$id_cta_banco AND $where_c_coste" )  ;
//    $saldo2=Dfirst("SUM(cargo)", "MOV_BANCOS_View", "id_cta_banco=$id_cta_banco AND $where_c_coste" )  ;
    $saldo=cc_format( Dfirst("SUM(ingreso-cargo)", "MOV_BANCOS_View", "id_cta_banco=$id_cta_banco AND $where_c_coste" ) , "moneda" ) ;
   


    // FICHA DE LA CUENTA BANCARIA

   $sql="SELECT * FROM ctas_bancos WHERE id_cta_banco=$id_cta_banco AND $where_c_coste ; " ;
    //echo $sql ;
    $result=$Conn->query($sql);                      // esta búsqueda tiene poca seguridad nececita confirmar lel id_c_coste
    $rs = $result->fetch_array(MYSQLI_ASSOC) ;

    $banco=$rs["Banco"]  ;
     $titulo= "Cuenta Bancaria <b>$banco</b>"; // quitamos las extension View, las _ y la ultima letra previsiblemente una S

    $tabla_update="ctas_bancos" ; 

    $updates=["*"] ;
    $id_update="id_cta_banco";
    $id_valor=$id_cta_banco ;
    $delete_boton=1;
         
    echo "  <div id='main' class='mainc_80'> ";
    require("../include/ficha.php");
    echo " </div> " ;
  ?>
    
    <div class="right2_20">

        <?php 


        
        //  WIDGET DOCUMENTOS 
        $tipo_entidad='cta_banco' ;
        $id_entidad=$id_cta_banco ;
        //$id_subdir=$id_cliente ;
        $id_subdir=0 ;
        $size='100px' ;
        $size_sec='100px' ;
        require("../include/widget_documentos.php");

         ?>

    </div>		
	
<?php           
    
    ////////////////// FIN FICHA CTA_BANCO


    
  }
  else
  { // si es listado_global añadimos  la variable del form 'cliente'
    if ($iniciar_form)    
    {  $banco="" ;$tipo="" ;}
    else
    { $banco=$_POST["banco"] ; $tipo=$_POST["tipo"] ; }
  } 

  // inicializamos las variables o cogemos su valor del _POST

 
  ?>
 
<div id="main" class="mainc_100" style="background-color:#fff">

<?php 

if ($listado_global)                // Estamos en pantalla de LISTADO GLOBALES (es decir, en toda la empres)
{ 
    echo "<h1>Movimientos Bancarios Global</h1>"  ;
    echo "<form action='bancos_mov_bancarios.php' method='post' id='form1' name='form1'>"    ;
    
    echo "<TABLE align='center'>"  ;
   
    echo "<TR><TD>Tipo Cuenta</TD><TD><INPUT type='text' id='tipo' name='tipo' value='$tipo'><button type='button' onclick=\"document.getElementById('tipo').value='' \" >*</button></TD></TR>" ;
    echo "<TR><TD>Cuenta banco</TD><TD><INPUT type='text' id='banco' name='banco' value='$banco'><button type='button' onclick=\"document.getElementById('banco').value='' \" >*</button></TD></TR>" ;
//    echo "<TR><TD>OBRA       </TD><TD><INPUT type='text' id='N_OBRA' name='N_OBRA' value='$N_OBRA'><button type='button' onclick=\"document.getElementById('N_OBRA').value='' \" >*</button></TD></TR>" ;
}
 else
{
    echo "<a class='btn btn-link noprint' href= '../bancos/bancos_mov_bancarios.php' title='pasa a la pantalla de Mov. Bancarios de todas las cuentas bancarias'><i class='fas fa-globe-europe'></i> Mov. bancarios global</a><br>" ;


    
     echo "<h1 style='text-align:left;'>Movimientos Bancarios de: <b>$banco</b></h1>"  ; 
    echo "<form action='bancos_mov_bancarios.php?id_cta_banco=$id_cta_banco' method='post' id='form1' name='form1'>"    ;
    
    echo "<TABLE align='center'>"  ;
}    

echo "<TR><TD>Conceptos, observaciones, numero...</TD><TD><INPUT type='text' id='concepto'   name='concepto'  value='$concepto'><button type='button' onclick=\"document.getElementById('concepto').value='' \" >*</button></TD></TR>" ;
//echo "<TR><TD>Obra   </TD><TD><INPUT type='text' id='obra'   name='obra'  value='$obra'><button type='button' onclick=\"document.getElementById('obra').value='' \" >*</button></TD></TR>" ;
echo "<TR><TD>Fecha mín. </TD><TD><INPUT type='date' id='fecha1'     name='fecha1'    value='$fecha1'><button type='button' onclick=\"document.getElementById('fecha1').value='' \" >*</button></TD></TR>" ;
echo "<TR><TD>Fecha máx. </TD><TD><INPUT type='date' id='fecha2'     name='fecha2'    value='$fecha2'><button type='button' onclick=\"document.getElementById('fecha2').value='' \" >*</button></TD></TR>" ;
echo "<TR><TD>Importe cargo min. </TD><TD><INPUT type='text' id='importe1'     name='importe1'    value='$importe1'><button type='button' onclick=\"document.getElementById('importe1').value='' \" >*</button></TD></TR>" ;
echo "<TR><TD>importe cargo máx. </TD><TD><INPUT type='text' id='importe2'     name='importe2'    value='$importe2'><button type='button' onclick=\"document.getElementById('importe2').value='' \" >*</button></TD></TR>" ;
echo "<TR><TD>Importe Ingreso min. </TD><TD><INPUT type='text' id='ingreso1'     name='ingreso1'    value='$ingreso1'><button type='button' onclick=\"document.getElementById('ingreso1').value='' \" >*</button></TD></TR>" ;
echo "<TR><TD>importe Ingreso máx. </TD><TD><INPUT type='text' id='ingreso2'     name='ingreso2'    value='$ingreso2'><button type='button' onclick=\"document.getElementById('ingreso2').value='' \" >*</button></TD></TR>" ;
//echo "<TR><TD>Conciliados </TD><TD><INPUT type='text' id='conc' name='conc' value='$conc'><button type='button' onclick=\"document.getElementById('negociada').value='' \" >*</button></TD></TR>" ;

$radio=$conc ;
$chk_todos =  ['','']  ; $chk_on = ['','']  ; $chk_off =  ['','']  ;
if ($radio=="") { $chk_todos = ["active","checked"] ;} elseif ($radio==1) { $chk_on =  ["active","checked"]  ;} elseif ($radio==0)  { $chk_off =  ["active","checked"]  ;}
//echo "<br><input type='radio' id='activa' name='activa' value='' $chk_todos />Todas las obras      <input type='radio' id='activa' name='activa' value='1' $chk_on />Activas  <input type='radio' id='activa' name='activa' value='0' $chk_off  />No Activas" ;
echo "<TR><TD>Conciliados</td><td>"
     . "<div class='btn-group btn-group-toggle' data-toggle='buttons'>"
     . "<label class='btn btn-default {$chk_todos[0]}'><input type='radio' id='conc' name='conc' value='' {$chk_todos[1]} />Todos     </label> "
     . "<label class='btn btn-default {$chk_on[0]}'><input type='radio' id='conc1' name='conc' value='1'  {$chk_on[1]} />Conciliados   </label>"
     . "<label class='btn btn-default {$chk_off[0]}'><input type='radio' id='conc0' name='conc' value='0' {$chk_off[1]}  />No Conciliados</label>"
     . "</div>"
     . "</TD></TR>" ;





//echo "<TR><TD>Cobrada    </TD><TD><INPUT type='text' id='cobrada'    name='cobrada'   value='$cobrada'><button type='button' onclick=\"document.getElementById('cobrada').value='' \" >*</button></TD></TR>" ;

echo "<TR><TD colspan=2 ><center><INPUT type='submit' class='btn btn-success btn-xl' value='Actualizar' id='submit' name='submit'></center></TD></TR>" ;

echo "</TABLE>"  ;

?>



<button   onclick="getElementById('agrupar').value = 'ultimos_movs_reg'; document.getElementById('form1').submit();">ultimos_movs_reg</button>
<button   onclick="getElementById('agrupar').value = 'movimientos'; document.getElementById('form1').submit();">movimientos</button>
<?php
if ($listado_global)
{ ?>
        <button   onclick="getElementById('agrupar').value = 'bancos'; document.getElementById('form1').submit();">bancos</button>
        <button   onclick="getElementById('agrupar').value = 'tipos'; document.getElementById('form1').submit();">tipo cuenta</button>
<?php 
} 
?>
<button   onclick="getElementById('agrupar').value = 'conceptos'; document.getElementById('form1').submit();">conceptos</button>
<button   onclick="getElementById('agrupar').value = 'meses'; document.getElementById('form1').submit();">meses</button>
<button   onclick="getElementById('agrupar').value = 'trimestres'; document.getElementById('form1').submit();">trimestres</button>
<button   onclick="getElementById('agrupar').value = 'annos'; document.getElementById('form1').submit();">años</button>
--
<button   onclick="getElementById('agrupar').value = 'conc_unica'; document.getElementById('form1').submit();">Conc.pago único</button>
<button   onclick="getElementById('agrupar').value = 'conc_todas'; document.getElementById('form1').submit();">Conc.pago varios</button>
<button   onclick="getElementById('agrupar').value = 'conc_fra_unica'; document.getElementById('form1').submit();">Conc.factura unica</button>
<button   onclick="getElementById('agrupar').value = 'conc_fra_todas'; document.getElementById('form1').submit();">Conc.factura todas</button>
--
<button   onclick="getElementById('agrupar').value = 'edicion'; document.getElementById('form1').submit();">Edicion</button>


<input type="hidden"  id="agrupar"  name="agrupar" value='<?php echo $agrupar ; ?>'>


</form>
			
<?php   // Iniciamos variables para tabla.php  background-color:#B4045


//$FECHA1= date_replace($FECHA1) ;
//$FECHA2= date_replace($FECHA2) ;
$where=$where_c_coste;

if ($listado_global)                // Estamos en pantalla de LISTADO GLOBAL (toda la empresa no solo en un proveedor concreto)
{    
// adaptamos todos los filtros, quitando espacios a ambos lados con trim() y sustituyendo espacios por '%' para el LIKE 
$where=$banco==""? $where : $where . " AND banco LIKE '%".str_replace(" ","%",trim($_POST["banco"]))."%'" ;
$where=$tipo==""? $where : $where . " AND tipo LIKE '%".str_replace(" ","%",trim($_POST["tipo"]))."%'" ;
}
else
{
$where= $where . " AND id_cta_banco=$id_cta_banco " ;    // Estamos en gastos de una Obra o Maquinaria específica
}    

//$where=$concepto==""? $where : $where . " AND CONCAT(Concepto,IFNULL(observaciones,''),cargo,ingreso) LIKE '%".str_replace(" ","%",trim($_POST["concepto"]))."%'" ;
$where=$concepto==""? $where : $where . " AND CONCAT(numero,Concepto,IFNULL(Concepto2,''),IFNULL(observaciones,'')) LIKE '%".str_replace(" ","%",trim($_POST["concepto"]))."%'" ;
//$where=$n_fra==""? $where : $where . " AND N_FRA LIKE '%".str_replace(" ","%",trim($_POST["n_fra"]))."%'" ;
$where=$fecha1==""? $where : $where . " AND fecha_banco >= '$fecha1' " ;
$where=$fecha2==""? $where : $where . " AND fecha_banco <= '$fecha2' " ;
$where=$importe1==""? $where : $where . " AND (cargo >= $importe1 )" ;
$where=$importe2==""? $where : $where . " AND (cargo <= $importe2 )" ;
$where=$ingreso1==""? $where : $where . " AND (ingreso >= $ingreso1 )" ;
$where=$ingreso2==""? $where : $where . " AND (ingreso <= $ingreso2 )" ;
$where=$conc==""? $where : $where . " AND conc=$conc " ;


// WHERE para limitar la busqueda de conciliaciones antes de la fecha del mov_banco (evita época anterior de Ingenop). SOLO PARA FACTURAS
$where_conc = '1=1' ;
$where_conc.= $fecha1==""? '' : " AND FECHA >= '$fecha1' " ;
$where_conc.=$fecha2==""? '' :  " AND FECHA <= '$fecha2' " ;


?>
<!--EXPAND SELECCION -->    
  
<br><button type='button' class='btn btn-default noprint' id='exp_seleccion' data-toggle='collapse' data-target='#div_seleccion'>Operar con movimientos seleccionados<span class="glyphicon glyphicon-chevron-down"></span></button>
<div id='div_seleccion' class='collapse'>
  
<div class="noprint" style="border-width:1px; border-style:solid;">
  <b>Acciones a realizar con Mov. bancarios seleccionados:</b>
    <div style="margin:10px">
          
 <?php

// eliminacion en grupo de seleccionados
$where_id_cta_banco= $listado_global ? "1=1" : "id_cta_banco=$id_cta_banco" ;      // permitimos borrar en listado global
$sql_delete= "DELETE FROM `MOV_BANCOS` WHERE  $where_id_cta_banco AND id_mov_banco IN _VARIABLE1_ ; "  ;
$href='../include/sql.php?sql=' . encrypt2($sql_delete)  ;    
echo "<a class='btn btn-danger btn-xs noprint ' href='#' "
     . " onclick=\"js_href('$href' ,'1','¿Borrar Movs. Bancos seleccionados?' ,'table_selection_IN()' )\"   "
     . "title='Borra los movimientos bancarios seleccionados' ><i class='far fa-trash-alt'></i> Borrar movs. bancos seleccionadas</a>" ;
      
      
      
// conciliar a factura proveedor 
      $url_sugerir= encrypt2( "javascript_code=js_href('../bancos/mov_bancos_conciliar_selection_fras.php?modo=MOVS_A_FRA_JS_AND_"
              . "id_fra_prov_unica=_ID_VALOR__JS_AND_array_str=_VARIABLE1_',1,'','table_selection_IN()')"
              . "&sql_sugerir=SELECT ID_FRA_PROV,CONCAT('Proveedor: ',PROVEEDOR,'<br>N.Factura: ',N_FRA) FROM Fras_Prov_Listado WHERE  $where_c_coste AND "
              . " filtro LIKE '%_FILTRO_%' LIMIT 10" );
      
      echo "<br>Buscar factura donde conciliar: <INPUT  style='font-size: 70% ;font-style: italic ;' id='input_fra_prov' size='13'  "
              . "  onkeyup=\"sugerir('$url_sugerir',this.value,'sugerir_fra_prov')\" placeholder='buscar Prov-factura...' value=''  >"
              . "<div class='sugerir' id='sugerir_fra_prov'></div>" ;

      echo "<button class='btn btn-xs btn-link' onclick=\"js_href('../bancos/mov_bancos_conciliar_selection_fras.php?modo=MOVS_A_FRA_JS_AND_"
              . "id_fra_prov_unica=FACTURA_NUEVA_JS_AND_array_str=_VARIABLE1_',1,'','table_selection_IN()' ) \"  >"
              . "Conciliar en una factura nueva</button> " ;
       
      
 ?>     
    </div>

</div>
</div>
<!--FIN SELECCION DE REMESA -->     

<?php

//$where=$cobrada==""? $where : $where . " AND  Cobrada" ;

//$where=$FECHA2==""? $where : $where . " AND FECHA <= STR_TO_DATE('$FECHA2','%Y-%m-%d') " ;

 $select= ($listado_global)? "id_cta_banco, tipo, Banco," : "" ;
 $select_global_totales= ($listado_global)? "'' as a34,'' as a23," : "" ;
 $col_sel="id_mov_banco" ;

 
 switch ($agrupar) {
    case "ultimos_movs_reg":
    
     $sql="SELECT $select numero,id_mov_banco ,id_remesa,id_nota_gastos, fecha_banco,Concepto,Concepto2,cargo,ingreso,conc,observaciones, "
            . "id_proveedor,ID_CLIENTE, PROVEEDOR,ID_FRA_PROV,N_FRA_PROV,CLIENTE,ID_FRA_CLI,N_FRA_CLI,remesa, cuenta  "
            . " FROM MOV_BANCOS_View WHERE $where  ORDER BY fecha_creacion DESC LIMIT 50 " ;
     $sql_T="SELECT $select_global_totales   '' as a,'' as a2,'' as a33,'SUMA:' as a3, SUM(cargo) AS cargo, SUM(ingreso) AS ingreso FROM MOV_BANCOS_View WHERE $where LIMIT 50  " ;
     $actions_row["delete_link"]="1";

        //$sql_T="SELECT '' " ;
    break;
    case "movimientos":
     if ($listado_global)                // Estamos en pantalla de LISTADO GLOBAL (todas las cuentas CCC )
      { $sql="SELECT $select numero,id_mov_banco ,id_remesa,id_nota_gastos ,fecha_banco,Concepto,cargo,ingreso,conc,observaciones,"
              . " id_proveedor,ID_CLIENTE, PROVEEDOR,ID_FRA_PROV,N_FRA_PROV,CLIENTE,ID_FRA_CLI,N_FRA_CLI,remesa, cuenta "
              . " FROM MOV_BANCOS_View WHERE $where  ORDER BY fecha_banco ,numero  " ;}
      else
      { $sql="SELECT $select numero,id_mov_banco ,id_remesa,id_nota_gastos ,fecha_banco,Concepto,cargo,ingreso,conc,observaciones,"
              . "id_proveedor,ID_CLIENTE, PROVEEDOR,ID_FRA_PROV,N_FRA_PROV,CLIENTE,ID_FRA_CLI,N_FRA_CLI,remesa, cuenta "
              . " FROM MOV_BANCOS_View WHERE $where  ORDER BY fecha_banco ,numero  " ;}    
      
      $sql_T="SELECT '' as a,'' as a2,'SUMA:' as a3, SUM(cargo) AS cargo, SUM(ingreso) AS ingreso ,'Saldo en periodo:' , SUM(ingreso) - SUM(cargo) AS saldo FROM MOV_BANCOS_View WHERE $where   " ;
      $actions_row["delete_link"]="1";

    break;
    case "bancos":
     $sql="SELECT  id_cta_banco,id_mov_banco,numero,fecha_banco,Concepto,cargo ,ingreso,observaciones,conc FROM MOV_BANCOS_View WHERE $where  ORDER BY  id_cta_banco,fecha_banco  " ;      
     //$sql="SELECT ID_PROVEEDORES,PROVEEDOR,CIF,SUM(Base_Imponible) AS Base_Imponible,SUM(IMPORTE_IVA) AS IMPORTE_IVA, SUM(pdte_conciliar) AS pdte_conciliar  FROM Fras_Prov_View WHERE $where GROUP BY ID_PROVEEDORES  ORDER BY PROVEEDOR " ;
     $sql_T="SELECT 'Suma' as a,'' as b,,'' as b1, SUM(cargo) AS cargo, SUM(ingreso) AS ingreso  FROM MOV_BANCOS_View WHERE $where   " ;     
     $sql_S="SELECT id_cta_banco,tipo,banco, SUM(cargo) AS cargo, SUM(ingreso) AS ingreso  FROM MOV_BANCOS_View WHERE $where  GROUP BY id_cta_banco ORDER BY banco  " ;      
     $id_agrupamiento="id_cta_banco" ;
     break;
    case "tipos":
//     $sql="SELECT  tipo,id_cta_banco,banco,SUM(cargo) AS cargo, SUM(ingreso) AS ingreso  FROM MOV_BANCOS_View WHERE $where GROUP BY id_cta_banco  ORDER BY  tipo,banco  " ;      
     $sql="SELECT  tipo,SUM(cargo) AS cargo, SUM(ingreso) AS ingreso  FROM MOV_BANCOS_View WHERE $where GROUP BY tipo  ORDER BY  tipo  " ;      
     //$sql="SELECT ID_PROVEEDORES,PROVEEDOR,CIF,SUM(Base_Imponible) AS Base_Imponible,SUM(IMPORTE_IVA) AS IMPORTE_IVA, SUM(pdte_conciliar) AS pdte_conciliar  FROM Fras_Prov_View WHERE $where GROUP BY ID_PROVEEDORES  ORDER BY PROVEEDOR " ;
     $sql_T="SELECT '' as a,'' as b, SUM(cargo) AS cargo, SUM(ingreso) AS ingreso  FROM MOV_BANCOS_View WHERE $where   " ;     
//     $sql_S="SELECT tipo, SUM(cargo) AS cargo, SUM(ingreso) AS ingreso  FROM MOV_BANCOS_View WHERE $where  GROUP BY tipo ORDER BY tipo  " ;      
//     $id_agrupamiento="tipo" ;
      $col_sel="" ;
      unset($col_sel) ;

     break;
    case "conceptos":
     $sql="SELECT  id_mov_banco, Concepto,count(id_mov_banco) as movs, SUM(cargo) AS cargo, SUM(ingreso) AS ingreso FROM MOV_BANCOS_View WHERE $where  GROUP BY Concepto ORDER BY Concepto  " ;      
     //$sql="SELECT ID_PROVEEDORES,PROVEEDOR,CIF,SUM(Base_Imponible) AS Base_Imponible,SUM(IMPORTE_IVA) AS IMPORTE_IVA, SUM(pdte_conciliar) AS pdte_conciliar  FROM Fras_Prov_View WHERE $where GROUP BY ID_PROVEEDORES  ORDER BY PROVEEDOR " ;
     $sql_T="SELECT '' as b, SUM(cargo) AS cargo, SUM(ingreso) AS ingreso  FROM MOV_BANCOS_View WHERE $where   " ;     
//     $sql_S="SELECT id_cta_banco,banco, SUM(cargo) AS cargo, SUM(ingreso) AS ingreso  FROM MOV_BANCOS_View WHERE $where  GROUP BY Concepto ORDER BY Concepto  " ;      
//     $id_agrupamiento="Concepto" ; 
     break;
   
    case "clientes":
     $sql="SELECT ID_CLIENTE,CLIENTE, SUM(Base_Imponible) AS Base_Imponible, SUM(IMPORTE_IVA) AS IMPORTE_IVA,SUM(Pdte_Cobro) AS Pdte_Cobro  FROM MOV_BANCOS_View WHERE $where  GROUP BY ID_CLIENTE ORDER BY CLIENTE  " ;      
     //$sql="SELECT ID_PROVEEDORES,PROVEEDOR,CIF,SUM(Base_Imponible) AS Base_Imponible,SUM(IMPORTE_IVA) AS IMPORTE_IVA, SUM(pdte_conciliar) AS pdte_conciliar  FROM Fras_Prov_View WHERE $where GROUP BY ID_PROVEEDORES  ORDER BY PROVEEDOR " ;
     $sql_T="SELECT '' AS d,SUM(Base_Imponible) AS Base_Imponible, SUM(IMPORTE_IVA) AS IMPORTE_IVA,SUM(Pdte_Cobro) AS Pdte_Cobro  FROM MOV_BANCOS_View WHERE $where  " ;   
     break;
    case "meses":
//    $sql="SELECT  CONCAT('<small>(',DATE_FORMAT(fecha_banco, '%Y-%m'),')</small> ',DATE_FORMAT(fecha_banco, '%M-%Y')  ) as MES,SUM(cargo) AS cargo, SUM(ingreso) AS ingreso ,COUNT(id_mov_banco) as Num_movs FROM MOV_BANCOS_View WHERE $where  GROUP BY MES  ORDER BY MES  " ;
    $sql="SELECT  id_mov_banco,DATE_FORMAT(fecha_banco, '%Y-%m') as MES,SUM(cargo) AS cargo, SUM(ingreso) AS ingreso , 0 AS saldo"
            . " ,COUNT(id_mov_banco) as Num_movs FROM MOV_BANCOS_View WHERE $where  GROUP BY MES  ORDER BY MES  " ;
    $sql_T="SELECT 'SUMA:' AS D,SUM(cargo) AS cargo, SUM(ingreso) AS ingreso , SUM(ingreso) - SUM(cargo) AS saldo ,COUNT(id_mov_banco) as Num_movs  FROM MOV_BANCOS_View WHERE $where   " ;
    break;
    case "trimestres":
//    $sql="SELECT  CONCAT('<small>(',DATE_FORMAT(fecha_banco, '%Y-%m'),')</small> ',DATE_FORMAT(fecha_banco, '%M-%Y')  ) as MES,SUM(cargo) AS cargo, SUM(ingreso) AS ingreso ,COUNT(id_mov_banco) as Num_movs FROM MOV_BANCOS_View WHERE $where  GROUP BY MES  ORDER BY MES  " ;
    $sql="SELECT  id_mov_banco,CONCAT(YEAR(fecha_banco), '-', QUARTER(fecha_banco),'T') as Trimestre,SUM(cargo) AS cargo, SUM(ingreso) AS ingreso , 0 AS saldo"
            . " ,COUNT(id_mov_banco) as Num_movs FROM MOV_BANCOS_View WHERE $where  GROUP BY Trimestre  ORDER BY Trimestre  " ;
    $sql_T="SELECT 'SUMA:' AS D,SUM(cargo) AS cargo, SUM(ingreso) AS ingreso , SUM(ingreso) - SUM(cargo) AS saldo ,COUNT(id_mov_banco) as Num_movs  FROM MOV_BANCOS_View WHERE $where   " ;
    break;
   case "annos":
    $sql="SELECT  id_mov_banco,DATE_FORMAT(fecha_banco, '%Y') as anno,SUM(cargo) AS cargo, SUM(ingreso) AS ingreso , 0 AS saldo ,"
           . "COUNT(id_mov_banco) as Num_movs FROM MOV_BANCOS_View WHERE $where  GROUP BY anno  ORDER BY anno  " ;
    $sql_T="SELECT 'SUMA:' AS D,SUM(cargo) AS cargo, SUM(ingreso) AS ingreso , SUM(ingreso) - SUM(cargo) AS saldo ,COUNT(id_mov_banco) as Num_movs  FROM MOV_BANCOS_View WHERE $where   " ;
    break;
   case "conc_unica":
    $sql="SELECT $select numero,id_mov_banco ,CONCAT(id_mov_banco , '&' , id_pago  ) AS  id_values_mov_banco_pago , fecha_banco,Concepto,cargo,ingreso,Num_pagos, "
           . "id_proveedor,PROVEEDOR,obs_pago,FECHA, id_pago FROM MOV_BANCOS_conciliacion WHERE $where AND $where_conc  AND Num_pagos=1 ORDER BY fecha_banco DESC  " ;
//    $sql="SELECT *, $select numero,id_mov_banco , CONCAT('(',id_mov_banco , ',' , id_pago , ')'  ) AS  id_values_mov_banco_pago  FROM MOV_BANCOS_conciliacion WHERE $where AND Num_pagos=1 ORDER BY fecha_banco DESC  " ;
//     $sql_T="SELECT '' as a,'' as a2,'SUMA:' as a3, SUM(cargo) AS cargo, SUM(ingreso) AS ingreso FROM MOV_BANCOS_View WHERE $where LIMIT 300  " ;

        //$sql_T="SELECT '' " ;
    $col_sel="id_values_mov_banco_pago" ;
    
//    echo   "<a class='btn btn-warning' href='#' onclick='mov_bancos_conciliar_selection()' title='concilia los mov. bancarios y pados seleccionados' >CONCILIAR MOV. BANCARIOS <-> PAGOS</a><br>" ;  
    break;
   case "conc_todas":
    $sql="SELECT $select numero,id_mov_banco ,CONCAT( id_mov_banco , '&' , id_pago  ) AS  id_values_mov_banco_pago , fecha_banco,Concepto,cargo,ingreso,Num_pagos "
           . ",id_proveedor,PROVEEDOR,obs_pago,FECHA, id_pago "
           . " FROM MOV_BANCOS_conciliacion WHERE $where AND $where_conc  ORDER BY fecha_banco DESC  " ;
//     $sql_T="SELECT '' as a,'' as a2,'SUMA:' as a3, SUM(cargo) AS cargo, SUM(ingreso) AS ingreso FROM MOV_BANCOS_View WHERE $where LIMIT 300  " ;

        //$sql_T="SELECT '' " ;
    $col_sel="id_values_mov_banco_pago" ;
//    echo $sql ;
    
//    echo   "<a class='btn btn-warning' href='#' onclick='mov_bancos_conciliar_selection()' title='concilia los mov. bancarios y pados seleccionados' >CONCILIAR MOV. BANCARIOS <-> PAGOS</a><br>" ;  
    break;
   case "conc_fra_unica":
    $sql="SELECT $select numero,id_mov_banco ,CONCAT(id_mov_banco , '&' , ID_FRA_PROV ) AS id_values_mov_banco_fra , fecha_banco,Concepto,cargo,Num_pagos,id_proveedor,PROVEEDOR,FECHA,N_FRA, "
           . " ID_FRA_PROV FROM MOV_BANCOS_conc_fras WHERE $where AND $where_conc  AND Num_pagos=1 ORDER BY fecha_banco DESC, FECHA DESC " ;
//     $sql_T="SELECT '' as a,'' as a2,'SUMA:' as a3, SUM(cargo) AS cargo, SUM(ingreso) AS ingreso FROM MOV_BANCOS_View WHERE $where LIMIT 300  " ;

        //$sql_T="SELECT '' " ;
    $col_sel="id_values_mov_banco_fra" ;
    
//    echo   "<a class='btn btn-warning' href='#' onclick='mov_bancos_conciliar_selection()' title='concilia los mov. bancarios y pados seleccionados' >CONCILIAR MOV. BANCARIOS <-> PAGOS</a><br>" ;  
    break;
   case "conc_fra_todas":
//    $sql="SELECT $select numero,id_mov_banco ,CONCAT('id_mov_banco=',id_mov_banco , '&id_fra_prov=' , ID_FRA_PROV ) AS id_values_mov_banco_fra , fecha_banco,Concepto,cargo,Num_pagos,id_proveedor,PROVEEDOR,FECHA,N_FRA, ID_FRA_PROV FROM MOV_BANCOS_conc_fras WHERE $where  ORDER BY fecha_banco DESC, FECHA DESC " ;
    $sql="SELECT $select numero,id_mov_banco ,CONCAT(id_mov_banco , '&' , ID_FRA_PROV ) AS id_values_mov_banco_fra , fecha_banco,Concepto,cargo,Num_pagos,id_proveedor,PROVEEDOR, "
           . "FECHA,N_FRA, ID_FRA_PROV FROM MOV_BANCOS_conc_fras WHERE $where AND $where_conc   ORDER BY fecha_banco DESC, FECHA DESC " ;
//     $sql_T="SELECT '' as a,'' as a2,'SUMA:' as a3, SUM(cargo) AS cargo, SUM(ingreso) AS ingreso FROM MOV_BANCOS_View WHERE $where LIMIT 300  " ;

        //$sql_T="SELECT '' " ;
    $col_sel="id_values_mov_banco_fra" ;
    
//    echo   "<a class='btn btn-warning' href='#' onclick='mov_bancos_conciliar_selection()' title='concilia los mov. bancarios y pados seleccionados' >CONCILIAR MOV. BANCARIOS <-> PAGOS</a><br>" ;  
    break;
    case "edicion":
             
     $sql="SELECT $select numero,id_mov_banco ,fecha_banco,Concepto,cargo,ingreso,conc,observaciones FROM MOV_BANCOS_View WHERE $where  ORDER BY fecha_banco DESC,numero DESC  " ;
     $sql_T="SELECT '' as a,'' as a2,'SUMA:' as a3, SUM(cargo) AS cargo, SUM(ingreso) AS ingreso FROM MOV_BANCOS_View WHERE $where   " ;

     $col_sel="id_mov_banco" ;
     
        //$sql_T="SELECT '' " ;
    break;

   
 }


 
//echo $sql ;    // DEBUG
$result=$Conn->query($sql) ;

if (isset($sql_T)) {$result_T=$Conn->query($sql_T) ; }    // consulta para los TOTALES
if (isset($sql_S)) {$result_S=$Conn->query($sql_S) ; }     // consulta para los SUBGRUPOS , agrupación de filas (Ej. CLIENTES o CAPITULOS en listado de udos)
//if (isset($sql_T2)) {$result_T2=$Conn->query($sql_T2) ; }    // consulta para los SALDOS

$is_conciliando= ( substr($agrupar,0,5)=='conc_')  ;       // indica que estamos en aprupacion de CONCILIACION

//if (!$listado_global AND !$is_conciliando)
if (!$listado_global )
    {

    
   $fecha=date('Y-m-d');
 
   $sql_insert_mov_banco= "INSERT INTO `MOV_BANCOS` (`id_cta_banco`, `numero`, `fecha_banco`, `Concepto` ,user)" 
             ." VALUES ( '$id_cta_banco', '0', '$fecha', '' , '{$_SESSION['user']}');" ;    
     
//   $sql_insert_mov_banco=base64_encode($sql_insert_mov_banco) ;
   $sql_insert_mov_banco= encrypt2($sql_insert_mov_banco) ;
   
   echo "<br><a class='btn btn-link bnt-lg noprint' target='_blank' title='añade nuevo movimiento bancario vacío' href=\"../include/sql.php?code=1&sql=$sql_insert_mov_banco \" >"
           . "<i class='fas fa-plus-circle'></i> añadir Movimiento Banco</a> ";
   
    echo "<a class='btn btn-link  noprint' target='_blank' href= '../bancos/mov_bancos_upload_form.php?id_cta_banco=$id_cta_banco' ><i class='fas fa-plus-circle'></i> Importar mov bancos desde .CSB</a>" ;
    echo "<a class='btn btn-link  noprint' target='_blank' href= '../bancos/mov_bancos_importar_XLS_caixabank.php?id_cta_banco=$id_cta_banco' ><i class='fas fa-plus-circle'></i> Importar mov bancos desde .XLS (Caixabank)</a>" ;
    echo "<a class='btn btn-link  noprint' target='_blank' href= '../bancos/mov_bancos_importar_XLS_unicaja.php?id_cta_banco=$id_cta_banco' ><i class='fas fa-plus-circle'></i> Importar mov bancos desde .XLS (Unicaja)</a>" ;
    echo "<a class='btn btn-link  noprint' target='_blank' href= '../bancos/mov_bancos_importar_XLS_cajasur.php?id_cta_banco=$id_cta_banco' ><i class='fas fa-plus-circle'></i> Importar mov bancos desde .XLS (Cajasur)</a>" ;
 
    echo "<h5>SALDO EN CUENTA: $saldo <br></h5> " ;

    }

if ( $is_conciliando)
    {
//    echo "<h5>SELECCIONAR CONCILIACIONES<br></h5> " ;
    
    echo   "<br><a class='btn btn-warning' href='#' onclick='mov_bancos_conciliar_selection(\"$agrupar\")' title='concilia los mov. bancarios y pagos o fras seleccionados' >CONCILIAR MOV. BANCARIOS <-> PAGOS o FRAS</a><br>" ;  
    }
if ( $agrupar=='edicion')
    {
//    echo "<h5>SELECCIONAR CONCILIACIONES<br></h5> " ;
    
    echo   "<br><a class='btn btn-danger' href='#' onclick='mov_bancos_delete_selection()' title='Elimina los mov. bancarios seleccionados' >Eliminar mov. banco seleccionados</a><br>" ;  
    }

    
    
echo "<br><font size=2 color=grey>Agrupar por : $agrupar <br> {$result->num_rows} filas </font> " ;


$updates=['observaciones']  ;
//$updates=['*']  ;
$tabla_update="MOV_BANCOS" ;
$id_update="id_mov_banco" ;
//$actions_row=[];
$actions_row["id"]="id_mov_banco";
//$actions_row["update_link"]="../include/update_row.php?tabla=Fra_Cli_Detalles&where=id=";
//$actions_row["delete_link"]="../include/delete_row.php?tabla=PARTES_PERSONAL&where=id=";
//$actions_row["delete_link"]="1";

    

$dblclicks=[];
$dblclicks["Banco"]="Banco" ;
$dblclicks["tipo"]="tipo" ;
$dblclicks["Concepto"]="concepto" ;
//$dblclicks["CIF"]="proveedor" ;
$dblclicks["meses"]="fecha1" ;
//$dblclicks["CONCEPTO"]="CONCEPTO" ;
//$dblclicks["TIPO_GASTO"]="TIPO_GASTO" ;

//$links["NOMBRE_OBRA"] = ["../obras/obras_ficha.php?id_obra=", "ID_OBRA"] ;
$links["Banco"] = ["../bancos/bancos_mov_bancarios.php?id_cta_banco=", "id_cta_banco"] ;

$links["Concepto"] = ["../bancos/pago_ficha.php?id_mov_banco=", "id_mov_banco","ver movimiento bancario" ,"formato_sub"] ;
$links["fecha_banco"] = ["../bancos/pago_ficha.php?id_mov_banco=", "id_mov_banco","ver movimiento bancario" ,"formato_sub"] ;
$links["PROVEEDOR"]=["../proveedores/proveedores_ficha.php?id_proveedor=", "id_proveedor"] ;
$links["obs_pago"] = ["../bancos/pago_ficha.php?id_pago=", "id_pago","ver pago coincidente con mov. bancario" ,"formato_sub"] ;

$links["N_FRA_PROV"]=["../proveedores/factura_proveedor.php?id_fra_prov=", "ID_FRA_PROV" , "ver Factura Proveedor", "formato_sub_vacio"] ;

$links["CLIENTE"] = ["../clientes/clientes_ficha.php?id_cliente=","ID_CLIENTE", "ver Cliente", "formato_sub_vacio"] ;
$links["N_FRA_CLI"]=["../clientes/factura_cliente.php?id_fra=", "ID_FRA_CLI" , "ver Factura Ciente", "formato_sub_vacio"] ;
$links["remesa"] = ["../bancos/remesa_ficha.php?id_remesa=", "id_remesa", "ver Remesa", "formato_sub_vacio"] ;

$links["cuenta"] = ["../bancos/pagos_y_cobros.php?cuenta=", "cuenta", "", "formato_sub_vacio"] ;


//$links["N_FRA"] = ["../proveedores/factura_proveedor.php?id_fra_prov=", "ID_FRA_PROV", "ver factura proveedor coincidente con Mov. bancario", "formato_sub"] ;

//$links["NOMBRE_OBRA"]=["../obras/obras_ficha.php?id_obra=", "ID_OBRA"] ; 

//$formats["observaciones"] = "textarea" ;
//$formats["CONCEPTO"] = "textarea" ;
$formats["cargo"] = "moneda" ;
//$formats["fecha_banco"] = "fecha" ;
$formats["ingreso"] = "moneda" ;
$formats["saldo"] = "moneda" ;
$formats["conc"] = "boolean" ;
$formats["MES"] = "mes" ;

$formats["Num_pagos"] = "conciliacion" ;

//$aligns["Pagada"] = "center" ;
$tooltips["conc"] = "El movimiento bancario está conciliado con un pago, cobro o traspaso interno" ;
//$tooltips["Cobrada"] = "factura cliente cobrada completamente" ;


$titulo="";
$msg_tabla_vacia="No hay.";

if (isset($id_agrupamiento))
{ require("../include/tabla_group.php"); }
else
{ require("../include/tabla.php"); echo $TABLE ; }




?>



</div>

<!--************ FIN  *************  -->
	
	

<?php  

$Conn->close();

?>
	 



 
<script>
function sugerir(url_sugerir, filtro,  id_div_sugerir) {
//    var nuevo_valor=window.prompt("Filtre la búsqueda y seleccione en la lista el nuevo "+prompt , valor0);
//    var nuevo_valor=str;
    
    if (filtro.length < 3) { 
      document.getElementById(pcont).innerHTML = "";
    return;
    }

    
//    alert("el nuevo valor es: ") ;
         
     var xhttp = new XMLHttpRequest();
     xhttp.onreadystatechange = function() {
    if (this.readyState == 4 && this.status == 200) {
        if (this.responseText.substr(0,5)=="ERROR")
        { alert(this.responseText) ;}                    // hay un error y lo muestro en pantalla
        else
        {   
//            alert(this.responseText) ;                                // debug
//            document.getElementById("sugerir").innerHTML = this.responseText;
            document.getElementById(id_div_sugerir).innerHTML = this.responseText ; }  // "pinto" en el <div> el select options
//           alert(pcont) ;
//            var ul_id="ul_" + pcont.substr(1) ;
//            document.getElementById("ul_id").getElementsByTagName ("li")[1].getElementsByTagName ("a").click() ;
//            alert(document.getElementById(pcont).getElementsByTagName("ul")[0].getElementsByTagName("li")[0].getElementsByTagName("a")[0]) ;
            //
//            document.getElementById(pcont).getElementsByTagName("ul")[0].getElementsByTagName("li")[0].getElementsByTagName("a")[0].click() ;
//            document.getElementById("ul_id").getElementsByTagName("li")[0].getElementsByTagName("a").click() ;
            
      //document.getElementById("sugerir_obra").innerHTML = this.responseText;
      }
  };
  
  xhttp.open("GET", "../include/select_ajax_showhint.php?url_enc="+url_sugerir+"&url_raw="+encodeURIComponent("&filtro="+filtro) , true);
//  xhttp.open("GET", "../include/select_ajax_showhint.php?url_enc="+cadena_select_enc+"&url_raw="+encodeURIComponent( nuevo_valor+"&otro_where="+otro_where) , true);

  xhttp.send();   
 
}   

function sugerir_ENTER(id_ul) {

document.getElementById(id_ul).getElementsByTagName("ul")[0].getElementsByTagName("li")[0].getElementsByTagName("a")[0].click() ;

}   

    
function mov_bancos_delete_selection()
 { 

    var nuevo_valor=window.confirm("¿Eliminar movimientos bancarios seleccionados? ");
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

  xhttp.open("GET", "../include/delete_row_ajax.php?tabla=MOV_BANCOS&wherecond=id_mov_banco IN " + table_selection_IN() , true);
  xhttp.send();   
   }
   else
   {return;}
 
}
    
function mov_bancos_conciliar_selection(agrupar)
{
    
// var id_remesa=document.getElementById("id_remesa").value ;

  //  alert( table_selection() ) ;
  
 if (agrupar=='conc_fra_unica') 
 {
 window.open("../bancos/mov_bancos_conciliar_selection_fras.php?array_str=" + encodeURIComponent( table_selection() ) ,'_blank' )   ;     
 }
 else
 {    
 window.open("../bancos/mov_bancos_conciliar_selection.php?array_str=" + encodeURIComponent( table_selection() ),'_blank' )   ;
 }
     
 //window.open("../menu/pagina_inicio.php")   ;
    
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

