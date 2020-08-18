<?php
// cambios
require_once("../include/session.php");
$where_c_coste = " id_c_coste={$_SESSION['id_c_coste']} ";
$id_c_coste = $_SESSION['id_c_coste'];

$titulo = 'Búsqueda Global';

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


// cogemos el filtro a buscar, si el GET ht aparece, añadimos la almohadilla al principio (evitamos conflicos en el div_edit
$filtro = isset($_GET["filtro"]) ? (isset($_GET["ht"])? "#" : "") . trim(urldecode($_GET["filtro"])) : trim($_POST["filtro"]) ;

$filtro= str_replace(chr(194),'', $filtro) ;           // 
$filtro= str_replace(chr(160),'', $filtro) ;           // 
//$filtro= str_replace('\uC2A0','', $filtro) ;           // 


$fecha1   = isset($_GET["fecha1"]) ?  $_GET["fecha1"]     :    (isset($_POST["fecha1"]) ?  $_POST["fecha1"] :  "")  ;
$fecha2   = isset($_GET["fecha2"]) ?  $_GET["fecha2"]     :    (isset($_POST["fecha2"]) ?  $_POST["fecha2"] :  "") ;


//if ($debug)
//{    
//echo "<br>Encrypt:<br>". encrypt($filtro) ;
//echo "<br>Decrypt <br>".  decrypt( ($filtro) ) ;
//echo "<br>Decrypt encrypt:<br>".  decrypt( encrypt($filtro) ) ;
//
//echo "<br><br>Encrypt2:<br>". encrypt2($filtro) ;
//echo "<br>Decrypt2 <br>".  decrypt2( ($filtro) ) ;
//echo "<br>Decrypt2 encrypt2:<br>".  decrypt2( encrypt2($filtro) ) ;
//
//}
?>

    

<!--<div class="container-fluid">-->	
<div class="row">
<!--    <div class="col-sm-2">
        <img src="../img/construcloud128.jpg" >
        <a class="boton" title="" href="../menu/pagina_inicio.php" >Inicio</a>

    </div>
    --> 
  <div class="col-sm-12" style="background-color: lightyellow">
    <form action="../menu/busqueda_texto.php" method="post" id="form1" name="form1">
        <br><br><br><h1>Buscar texto:<INPUT type="text" size='10' name="filtro" value="<?php echo $filtro ; ?>"></h1>
   <?php
        echo "<h4><br>Fecha mín. <INPUT type='date' id='fecha1' name='fecha1' value='$fecha1'><button type='button' onclick=\"document.getElementById('fecha1').value='' \" >*</button>" ;
        echo "<br>Fecha máx. <INPUT type='date' id='fecha2' name='fecha2' value='$fecha2'><button type='button' onclick=\"document.getElementById('fecha2').value='' \" >*</button>" ;

   ?>
        <br><button type="submit" class="btn btn-success btn-lg">
                                <i class="fas fa-search"></i> 
                         </button></h4>
    </form>
    </div>
    
</div>		
	
<div class="row">
    <h1>Resultados de la búsqueda texto: "<b><?php echo $filtro ; ?></b>"</h1>
    <h4 style='color:silver'>Tiempo de búsqueda <input style='border:none;color:silver'  type="text" id="tiempo" name="tiempo" size="20"></h4>
</DIV>   
<div class="row">    
<!--<div class="col-sm-2"></div>-->
<div class="col-sm-12">
<?php

//echo "<h1 >Resultados de la búsqueda:<b> $filtro </b></h1>" ;
$array_filtro= explode (" ", trim($filtro) ) ;           // 
$where_like="1";
foreach ($array_filtro as $f) {
    $f_hex=bin2hex($f) ;
    $where_like .= " AND  __CAMPO__ LIKE '%$f%'  "   ;  // buscamos las dos versiones original y hex por COMPATIBILIDAD
//    $where_like .= " AND ( __CAMPO__ LIKE '%$f%'  OR __CAMPO__ LIKE '%$f_hex%' ) "   ;  // buscamos las dos versiones original y hex por COMPATIBILIDAD
    $array_filtro_pat[]="/($f)/" ;  // array de patterns para iluminar los filtros posteriormente 
    
}

$limite=9999999 ;



//$sqls[""]= tipo_entidad,  tabla , id_entidad,fecha,nombre_entidad, observaciones , otro_whare;
$sqls["partes"]= ["parte" , "Partes_View" , "ID_PARTE" , "Fecha" , "NOMBRE_OBRA" , "Observaciones" ]    ;
$sqls["partes_personal"]= ["parte" , "Partes_Personal_View" , "ID_PARTE" , "Fecha" , "CONCAT(NOMBRE_OBRA,'-',NOMBRE)" , "Observaciones" ]    ;
$sqls["partes_maquinas"]= ["parte" , "Partes_Maquinas_View" , "ID_PARTE" , "Fecha" , "CONCAT(NOMBRE_OBRA,'-',Maquinaria)" , "Observaciones" ]    ;
$sqls["albaran"]= ["albaran" , "Vales_list" , "ID_VALE" , "FECHA" , "CONCAT(NOMBRE_OBRA,'-',PROVEEDOR)" , "Observaciones" ]    ;
//$sqls["albaran_detalle"]= ["albaran" , "Partes_View" , "ID_PARTE" , "Fecha" , "NOMBRE_OBRA" , "Observaciones" ]    ;
//$sqls["obra_doc"]="../obras/obras_ficha.php?id_obra=";
//$sqls["obra_foto"]="../obras/obras_ficha.php?id_obra=";
//$sqls["obra_nueva"]="../obras/obras_ficha.php?id_obra=";
$sqls["fra_prov"]=["fra_prov" , "Fras_Prov_Listado" , "ID_FRA_PROV" , "FECHA" , "PROVEEDOR" , "Observaciones" ]    ;
$sqls["fra_cli"]=["fra_cli" , "Fras_Cli_Listado" , "ID_FRA" , "FECHA_EMISION" , "CONCAT(CLIENTE,'-',CONCEPTO)" , "observaciones" ]    ;
$sqls["estudios"]=["estudios" , "Estudios_de_Obra" , "ID_ESTUDIO" , "`PLAZO ENTREGA`" , "NOMBRE" , "observaciones" ]    ;
$sqls["pof"]=["pof" , "POF_lista" , "ID_POF" , "fecha_creacion" , "CONCAT(NOMBRE_OBRA,'-',NOMBRE_POF)" , "Observaciones" ]    ;
$sqls["pof_prov"]=["pof_prov" , "POF_prov_View" , "id" , "fecha_creacion" , "CONCAT(NOMBRE_OBRA,'-',NOMBRE_POF,'-',PROVEEDOR)" , "Observaciones" ]    ;
$sqls["tarea"]=["tarea" , "Tareas_View" , "id" , "fecha_creacion" , "Tarea" , "Texto" ]    ;
//$sqls["chat"]=["chat" , "Tareas_View" , "id" , "fecha_creacion" , "Tarea" , "Texto" ]    ;
//$sqls["pof_concepto"]="../pof/pof.php?id_pof=";
//$sqls["proveedores"]="../proveedores/proveedores_ficha.php?id_proveedor=";
//$sqls["subcontrato"]="";
//$sqls["tarea"]="";
//$sqls["udo"]="../obras/udo_prod.php?id_udo=";
//$sqls["remesa"]="../bancos/remesa_ficha.php?id_remesa=";
//$sqls["firmas"]=["tipo_entidad" , "Firmas_View" , "id_entidad" , "fecha_creacion" , "firma" , "observaciones" ]    ;
//$sqls["tareas"]="../bancos/pagos_y_cobros.php?cuenta=";
//$sqls["pago"]="../bancos/pago_ficha.php?id_pago=";
//$sqls["mov_banco"]="../bancos/pago_ficha.php?id_mov_banco=";
//$sqls["banco"]="../bancos/bancos_mov_bancarios.php?id_cta_banco=";
//$sqls["procedimiento"]="../agenda/procedimiento_ficha.php?id_procedimiento=";
//$sqls["doc_nuevo"]="../documentos/documento_ficha.php?id_documento=";
//$sqls["rel_valorada"]="../obras/obras_prod_detalle.php?id_produccion=";
//$sqls["rel_valorada_nueva"]="../obras/obras_prod_detalle.php?id_produccion=";
//$sqls["subcontrato"]="";
//$sqls["subcontrato"]="";
//$sqls["subcontrato"]="";
    
 


$time0=microtime(true);

if ($filtro<>"")
{    
   $g=0;                // contador global de links
 
  echo "<table class='table table-hover table-striped table-bordered' >"  ;
  echo "<tr><td>RESULTADOS"  ;
 

foreach ($sqls as $clave => $sql) {
            $where_fecha="";  
            $where_fecha = $fecha1=="" ? $where_fecha : $where_fecha . " AND {$sql[3]} >= '$fecha1' " ;
            $where_fecha = $fecha2=="" ? $where_fecha : $where_fecha . " AND {$sql[3]} <= '$fecha2' " ;
            
            // sustituimos el mombre del campo  en su lugar
            $where_like_txt = str_replace("__CAMPO__", $sql[5] , $where_like )  ;
  
//          $sql_txt="SELECT {$sql[2]} as id_entidad,{$sql[3]} as fecha, {$sql[4]} as entidad,{$sql[5]} as Observaciones "
//                 . " FROM {$sql[1]}  WHERE {$sql[5]} LIKE '%$filtro%' AND $where_c_coste $where_fecha ORDER BY fecha DESC " ;
          $sql_txt="SELECT {$sql[2]} as id_entidad,{$sql[3]} as fecha, {$sql[4]} as entidad,{$sql[5]} as Observaciones "
                 . " FROM {$sql[1]}  WHERE $where_like_txt AND $where_c_coste $where_fecha ORDER BY fecha DESC " ;
//          $sql_txt="SELECT * "
//                 . " FROM OBRAS WHERE  $where_c_coste " ;
//          echo "<br>".$sql_txt; 
          $result=$Conn->query($sql_txt);

         if ($result->num_rows > 0)
         {  
             $c=0 ;
            echo "</td></tr></table><br><table class='table table-hover table-striped table-bordered'><tr>"
             . "<td><p style='font-size: 40px;'><i class='fas fa-shopping-cart'></i>&nbsp;$clave ({$result->num_rows})</p>" ;
            while($rs = $result->fetch_array(MYSQLI_ASSOC))    // cojo la de mayor usuarios permitidos 
            {
             $c++ ;   $g++ ;
             $observaciones_txt= str_replace( "\n" , "<br>", $rs["Observaciones"] ) ; 
//             $observaciones_txt= str_replace($filtro, "<b>$filtro</b>", $observaciones_txt ) ; 
//             $observaciones_txt= preg_replace("/($filtro)/i", "<b>$1</b>", $observaciones_txt ) ; 
             
             $observaciones_txt= preg_replace($array_filtro_pat, "<span style='color:darkred;font-weight:bold;'>$1</span>", $observaciones_txt ) ; 
             
             echo "</td></tr><tr><td><b>$clave</b> <a id='a_link' style='font-size: 20px;' target='_blank' "
             . "href='../include/ficha_entidad.php?tipo_entidad={$sql[0]}&id_entidad={$rs["id_entidad"]}'>{$rs["entidad"]}</a>"
             . "<p style='font-size:13px;color:grey;' ><br>".cc_format($rs["fecha"],"fecha")."<br>$observaciones_txt</font>"   ;
            }
//            if ($c==$limite) {echo ".....<a class='btn btn-link btn-xs' href='../include/ficha_entidad.php' >Buscar más proveedores</a> " ; }

         }
}

//  echo "Codigo de busqueda:<br>". encrypt($filtro) ;
echo "</td></tr></table>" ;
echo "<BR>Tiempo: ".number_format(microtime(true)-$time0,3)." segundos " ;
//echo "<script>$(#tiempo).val(' ".number_format(microtime(true)-$time0,3)." segundos ');</script> " ;
echo "<script>$('#tiempo').val(' ".number_format(microtime(true)-$time0,3)." sg ');</script> " ;
//echo "<script>$('input:text').val(' juan ');alert('juan');</script> " ;
echo "<br><p><h1>Fin de la búsqueda</h1></p>" ;

  
  
  
 // si solo hay un link lo ejecutamos
//  if ($g==1)
//  {
//      echo '<script>' ;
//      echo "document.getElementById('a_link').click();"  ;      
////      echo "window.close();"  ;      // anulado provisionalmente porque da problemas al abrir directamente el <a href>, parece SPAM  y necesita autorización para pagina nueva emergente
//      echo '</script>' ;      
//  }    
  
  
  
  
  
  
}   
else
{
    echo "<br><p style='font-size: 40px;'><i class='fas fa-globe-europe'></i>&nbsp;Filtro vacío</p>" ;
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