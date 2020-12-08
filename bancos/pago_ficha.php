<?php
// cambios
require_once("../include/session.php");
$where_c_coste = " id_c_coste={$_SESSION['id_c_coste']} ";
$id_c_coste = $_SESSION['id_c_coste'];

$titulo = 'Pago/cobro mov. banco';

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

 require_once("../include/funciones_js.php");
// require("../menu/general_menutop_r"); 
 //require("../proveedores/proveedores_menutop_r.php");

?>
	

<?php 



//  calculamos id_pago e id_mov_banco en funcion de os GET
if (isset($_GET["id_pago"]))     
{
   //tenemos el ID_PAGO  
  $id_pago=$_GET["id_pago"];
  $id_mov_banco=Dfirst("id_mov_banco", "PagosC"," id_pago=$id_pago AND $where_c_coste ");

}else
{
   //tenemos el ID_MOV_BANCO
    
    $id_mov_banco=$_GET["id_mov_banco"];   
    $id_pago = Dfirst("id_pago", "PagosC"," id_mov_banco=$id_mov_banco AND $where_c_coste ");

}
    


if ($id_pago)
{  

// DATOS   PAGOS  FICHA . PHP
//        PAGOS_VIEW
$sql="SELECT id_pago,id_pago as nid_pago,id_remesa,id_cta_banco,id_proveedor,PROVEEDOR,tipo_pago,observaciones,importe,ingreso,f_vto,id_mov_banco,conc,FProv "
     . ",importe_iva_FP  "
     . ",NG,FCli,user,fecha_creacion FROM Pagos_View WHERE id_pago=$id_pago AND $where_c_coste";

$result=$Conn->query($sql) ;
$rs = $result->fetch_array(MYSQLI_ASSOC) ; 

  
$importe=$rs["importe"] ;
$ingreso=$rs["ingreso"] ;

//while ($a = $result->fetch_field()) {

//print_r ($rs);
//}
//echo "</pre>";
 
//  $visibles=["id_remesa"] ;
$id_mov_banco=$rs["id_mov_banco"]  ;   // vemos si el ID_PAGO está pagado por banco

$selects["id_cta_banco"]=["id_cta_banco","banco","bancos_cuentas","../bancos/bancos_anadir_cta_banco_form.php","../bancos/bancos_mov_bancarios.php?id_cta_banco=","id_cta_banco"," AND Activo=1 " ] ;   // datos para clave foránea Y PARA AÑADIR PROVEEDOR NUEVO
$selects["id_remesa"]=["id_remesa","remesa","Remesas_View","../bancos/remesa_anadir.php","../bancos/remesa_ficha.php?id_remesa=","id_remesa"," AND activa=1 AND firmada=0 "] ;   // datos para clave foránea Y PARA AÑADIR PROVEEDOR NUEVO
$selects["id_remesa"]["valor_null"]=0;
$selects["id_remesa"]["valor_null_texto"]='sin remesa';

$links["remesa"] = ["../bancos/remesa_ficha.php?id_remesa=", "id_remesa"] ;
$links["PROVEEDOR"]=["../proveedores/proveedores_ficha.php?id_proveedor=", "id_proveedor","","formato_sub"] ;

$etiquetas["importe"]='cargo';

$formats["conc"]="semaforo_txt_COBRADO";
//$formats["importe_CUADRADO"]="semaforo_txt_COINCIDEN LOS IMPORTES";
$formats["tipo_pago"]="tipo_pago" ;                //FORMATO ESPECIAL PARA tipo_pago

//$titulo= ($rs["tipo_pago"]=='P')?  "PAGO" : (($rs["tipo_pago"]=='C')?  "COBRO" : ( ($rs["tipo_pago"]=='T')?  "TRASPASO" : "OTRO PAGO" )) ;
$titulo_txt= cc_format($rs["tipo_pago"],"tipo_pago") ;
$titulo= $titulo_txt ;
$updates=['id_cta_banco' , 'tipo_doc','Ref_Doc','f_vto','importe','ingreso', 'FECHA_ENTRADA' , 'observaciones', 'pagada', 'id_remesa']  ;
$id_pago=$rs["id_pago"] ;
$tabla_update="PAGOS" ;
$id_update="id_pago" ;
$id_valor=$id_pago ;

$delete_boton=1;

if ($rs["tipo_pago"]=='T')     // TRASPASO INTERNO ENTRE BANCOS
{
  
    
    
}
  



  ?>
  
                  
                    
  <div style="overflow:visible">	   
  <div id="main" class="mainc_30"> 
      
  <?PHP require("../include/ficha.php"); ?>
   
      <!--// FIN     **********    FICHA.PHP-->
 </div>
      
      
	

	
	
<?php            // ----- div facturas_prov   tabla.php   -----

if ($rs["tipo_pago"]=='P')         // PAGO
{
    $sql="SELECT id_fra_prov,ID_PROVEEDORES,PROVEEDOR,FECHA,N_FRA,IMPORTE_IVA,conc FROM Fras_Prov_Pagos_View WHERE  id_pago=$id_pago AND $where_c_coste ORDER BY FECHA";
    //echo $sql;
    $result=$Conn->query($sql );

    $sql="SELECT '' AS A,'' AS S,'' AS D,SUM(IMPORTE_IVA) AS IMPORTE_IVA,'' AS C FROM Fras_Prov_Pagos_View WHERE  id_pago=$id_pago AND $where_c_coste ";
    //echo $sql;
    $result_T=$Conn->query($sql );

    $formats["FECHA"]='fecha';
    $formats["IMPORTE_IVA"]='moneda';
    $formats["conc"]='semaforo_OK';

    $links["N_FRA"] = ["../proveedores/factura_proveedor.php?id_fra_prov=", "id_fra_prov", "", "formato_sub"] ;
    $links["PROVEEDOR"]=["../proveedores/proveedores_ficha.php?id_proveedor=", "ID_PROVEEDORES", "", "formato_sub"] ;


    //  $id_pago=$rs["id_pago"] ;
    //  $tabla_update="PAGOS" ;
    //  $id_update="id_pago" ;
    //  $id_valor=$id_pago ;
      $actions_row["id"]="id_fra_prov";


    // accion de DESCONCILIAR el PAGO de la FRA_PROV
    $onclick1_VARIABLE1_="id_fra_prov" ;           // paso de variables para dar instrucciones al boton 'add' para añadir un detalle a la udo
    //$onclick1_VARIABLE2_="" ;     // idem

    // $sql_update="UPDATE `VALES` SET `ID_FRA_PROV` = NULL  " 
    //         ."WHERE  ID_VALE=_VARIABLE1_ ; " ;

    // sql para desconciliar el PAGO de la FACTURA_PROV
    $sql_delete="DELETE FROM `FRAS_PROV_PAGOS`  " 
         ."WHERE id_fra_prov=_VARIABLE1_ AND id_pago=$id_pago ; " ;
    $sql_delete=encrypt2($sql_delete) ;
    $actions_row["onclick1_link"]="<a class='btn btn-warning btn-xs noprint' target='_blank' title='Desconcilia el Pago de la factura' "
                                   . " href=\"../include/sql.php?code=1&sql=$sql_delete&variable1=_VARIABLE1_ \" >desconciliar</a> ";



    $titulo="Facturas Prov. de este Pago" ;
    $msg_tabla_vacia="No hay facturas conciliados a este pago";
    $tabla_expandida=0; 

    echo "<div class='right2' style='background-color:orange'>" ;

    require("../include/tabla.php"); echo $TABLE ;

    echo "</div>" ;
  //<!--FIN WIDGET FACTURAS PROVEEDORES-->
    
    
}else if ($rs["tipo_pago"]=='C')         // COBRO
{ 
  
      //<!--INICIO FACTURAS CLIENTES-->      

    $sql="SELECT id_pago,ID_OBRA,ID_FRA_CLI,ID_CLIENTE,CLIENTE,N_FRA_CLI,FECHA_EMISION FROM Pagos_FCli WHERE  id_pago=$id_pago  ORDER BY FECHA_EMISION";
    //echo $sql;
    $result=$Conn->query($sql );

    //$sql_T="SELECT '' AS A,'' AS S,'' AS D,SUM(IMPORTE_IVA) AS IMPORTE_IVA,'' AS C FROM Fras_Prov_Pagos_View WHERE  id_pago=$id_pago AND $where_c_coste ";
    ////echo $sql;
    //$result_T=$Conn->query($sql_T );

//    $formats["FECHA_EMISION"]='fecha';
    //$formats["IMPORTE_IVA"]='moneda';
    //$formats["conc"]='semaforo_OK';

    $links["N_FRA_CLI"] = ["../clientes/factura_cliente.php?id_fra=", "ID_FRA_CLI", "", "formato_sub"] ;
    $links["CLIENTE"]=["../clientes/clientes_ficha.php?id_cliente=", "ID_CLIENTE", "", "formato_sub"] ;


    //  $id_pago=$rs["id_pago"] ;
    //  $tabla_update="PAGOS" ;
    //  $id_update="id_pago" ;
    //  $id_valor=$id_pago ;
      $actions_row["id"]="ID_FRA_CLI";

    //  $actions_row["delete_link"]="1";

      //////////////

    //   $updates=['REF']  ;
    //  $tabla_update="VALES" ;
    //  $id_update="ID_VALE" ;
    //    $actions_row=[];
    //    $actions_row["id"]="ID_VALE";
    //    $actions_row["delete_link"]="1";




    // accion de DESCONCILIAR el PAGO de la FRA_PROV
    $onclick1_VARIABLE1_="ID_FRA_CLI" ;           // paso de variables para dar instrucciones al boton 'add' para añadir un detalle a la udo
    //$onclick1_VARIABLE2_="" ;     // idem

    // $sql_update="UPDATE `VALES` SET `ID_FRA_PROV` = NULL  " 
    //         ."WHERE  ID_VALE=_VARIABLE1_ ; " ;

    // sql para desconciliar el PAGO de la FACTURA_PROV
    $sql_delete="DELETE FROM `FRAS_CLI_PAGOS` WHERE id_fra=_VARIABLE1_ AND id_pago=$id_pago ; " ;
    $sql_delete=encrypt2($sql_delete) ;
    $actions_row["onclick1_link"]="<a class='btn btn-warning btn-xs noprint' target='_blank' title='Desconcilia el Cobro de la factura' "
                                   . " href=\"../include/sql.php?code=1&sql=$sql_delete&variable1=_VARIABLE1_ \" >desconciliar</a> ";



    $titulo="Facturas Cliente de este Cobro" ;
    $msg_tabla_vacia="No hay facturas conciliados a este cobro";

    echo "<div class='right2' style='background-color:lightgreen'>" ;

    require("../include/tabla.php"); echo $TABLE ;

    echo "</div>" ;
// FIN FACTURAS CLIENTES

}  
    
    
echo  "<div class='right2_50' style='background-color:lightgreen' >" ;

  if ($id_mov_banco)
      {
      echo "<h3><font color='green'>$titulo_txt CONCILIADO</font></h3>" ;  //"../bancos/pago_ficha.php?id_mov_banco=", "id_mov_banco"
//      echo "<a class='btn btn-link' href='../bancos/pago_ficha.php?_m=$_m&id_mov_banco=$id_mov_banco' target='_blank'>ver mov. banco</a>" ;

      $sql="UPDATE PAGOS SET id_mov_banco='$id_mov_banco' WHERE id_pago=$id_pago ;"  ;

      $sql_desconcilia_mov_banco=encrypt2("UPDATE PAGOS SET id_mov_banco=0 WHERE id_pago=$id_pago ; ") ;
      $href="../include/sql.php?code=1&sql=$sql_desconcilia_mov_banco ";
//      echo "<a class='btn btn-link' href=\"$href\" target='_blank'>"
//                                                        . "<i class='fas fa-unlink'></i> desconciliar pago-mov.banco</a>" ;
      
      echo "<a class='btn btn-xs btn-link'  href='#'  onclick=\"js_href('$href' )\" >"
                                                        . "<i class='fas fa-unlink'></i> DESCONCILIAR $titulo_txt - MOV. BANCO</a>" ;
      echo "</div>" ;
      
      } 
 else
      {
        echo "<h3><font color='red'>$titulo_txt no cobrado</font></h3>" ;  //"../bancos/pago_ficha.php?id_mov_banco=", "id_mov_banco"   
//        echo "</div>" ;
       
           // MOV. BANCOS CONCILIABLES
        //$sql="SELECT id_pago,f_vto,PROVEEDOR,id_proveedor,observaciones,importe,ingreso FROM Pagos_View WHERE  id_cta_banco=$id_cta_banco AND conc=0 AND importe='$importe' AND ingreso='$ingreso') AND $where_c_coste ";
        $sql="SELECT id_mov_banco,id_cta_banco,doc_logo,Banco,fecha_banco,Concepto,cargo,ingreso,observaciones,fecha_creacion,user FROM MOV_BANCOS_View "
                . " WHERE conc=0 AND fecha_banco>='2017-01-01' AND ingreso='$ingreso' AND cargo='$importe' AND $where_c_coste ORDER BY fecha_banco DESC " ;

        //echo $sql;
        $result=$Conn->query($sql );

        $updates=[];

        $links["Concepto"] = ["../bancos/pago_ficha.php?id_mov_banco=", "id_mov_banco","ver movimiento bancario" ,"formato_sub"] ;
        $links["fecha_banco"] = ["../bancos/pago_ficha.php?id_mov_banco=", "id_mov_banco","ver movimiento bancario" ,"formato_sub"] ;


        // accion de CONCILIAR el MOV_BANCO con el ID_PAGO
        //$onclick1_VARIABLE1_="id_pago" ;           // paso de variables para dar instrucciones al boton 'add' para añadir un detalle a la udo
        ////$onclick1_VARIABLE2_="" ;     // idem
        //
        //$sql_insert="INSERT INTO PAGOS_MOV_BANCOS ( id_mov_banco,id_pago ) " . 
        //          " VALUES ( '$id_mov_banco', _VARIABLE1_ );" ;
        //
        //$actions_row["onclick1_link"]="<a class='btn btn-link btn-xs' title='concilia el mov.banco con el Pago' href=\"../include/sql.php?sql=base64_encode($sql_insert) \" >conciliar</a> ";
        //$actions_row["id"]="id_pago";
        //  

        //$tooltips["conc"] = "Factura conciliada. Los Vales (albaranes de proveedor) suman el importe de la factura" ;

        //$titulo="<a href=\"proveedores_documentos.php?id_proveedor=$id_proveedor\">Documentos (ver todos...)</a> " ;
        //$titulo="Posibles REMESAS, PAGOS, COBROS O TRASPASOS a conciliar " ;
        $titulo="Buscar conciliacion bancaria...($result->num_rows) " ;
        $tabla_expandida=0; 
        $msg_tabla_vacia="";

        //echo "<div id='main' class='mainc' style='background-color:orange'>" ;
//        echo "<div class='right2_50'  >" ;

        //echo "<a class='btn btn-primary' target='_blank' href= '../bancos/aval_anadir.php?id_linea_avales=$id_linea_avales' ><i class='fas fa-plus-circle'></i>Añadir Aval</a><br>" ;

        require("../include/tabla.php"); echo $TABLE ; 
        //echo "<br>"  ;
        echo "</div>" ;

      }    
      
}else
{
//    echo "<h1><br><br>NO HAY Pago/Cobro/Traspaso... conciliado al Movimiento banco</h1>" ;
}    

///////// MOVIMIENTO BANCARIO   ///////////////////////////////////
?>



<div style="overflow:visible">	   
<div id="main" class="right2_50">     

<?php
          

if ($id_mov_banco)
{
    
        $result=$Conn->query($sql="SELECT id_mov_banco,id_remesa,id_pago,path_logo,id_cta_banco,numero,fecha_banco,Concepto,Concepto2,cargo,ingreso,observaciones,conc,fecha_creacion,user "
                    . " FROM MOV_BANCOS_View WHERE id_mov_banco=$id_mov_banco AND $where_c_coste");
        $rs = $result->fetch_array(MYSQLI_ASSOC) ;

        $titulo_pagina="Mov " . $rs["Concepto"] ;


         $id_cta_banco=$rs["id_cta_banco"] ;
         $importe=$rs["cargo"] ;
         $ingreso=$rs["ingreso"] ;

          $titulo="MOVIMIENTO BANCO" ;
          $updates=["id_cta_banco",'fecha_banco','numero',  'Concepto', 'Concepto2','cargo','ingreso','observaciones',]  ;

          $etiquetas["numero"]=["Número Mov.","Número Movimiento bancario (opcional)"];
          $formats["conc"]="semaforo_txt_CONCILIADO";
          $formats["cargo"]="moneda";
          $formats["ingreso"]="moneda";
          $selects["id_cta_banco"]=["id_cta_banco","banco","bancos_cuentas","../bancos/bancos_anadir_cta_banco_form.php","../bancos/bancos_mov_bancarios.php?id_cta_banco=","id_cta_banco" ] ;   // datos para clave foránea Y PARA AÑADIR PROVEEDOR NUEVO

        //  $id_pago=$rs["id_remesa"] ;
          $tabla_update="MOV_BANCOS" ;
          $id_update="id_mov_banco" ;
          $id_valor=$id_mov_banco ;

          $delete_boton=1;

         $sql_insert_mov_banco= "INSERT INTO `MOV_BANCOS` (`id_cta_banco`, `numero`, `fecha_banco`, `Concepto`, `Concepto2`, cargo, ingreso, observaciones, user)" 
                     ." VALUES ( '$id_cta_banco', '{$rs["numero"]}', '{$rs["fecha_banco"]}', '{$rs["Concepto"]}', '{$rs["Concepto2"]}', '{$rs["cargo"]}' "
                     . " ,'{$rs["ingreso"]}','{$rs["observaciones"]}', '{$_SESSION['user']}');" ;    

         $sql_insert_mov_banco_simetrico= "INSERT INTO `MOV_BANCOS` (`id_cta_banco`, `numero`, `fecha_banco`, `Concepto`, `Concepto2`, cargo, ingreso, observaciones, user)" 
                     ." VALUES ( '$id_cta_banco', '{$rs["numero"]}', '{$rs["fecha_banco"]}', '{$rs["Concepto"]}', '{$rs["Concepto2"]}', '{$rs["ingreso"]}' "
                     . " ,'{$rs["cargo"]}','{$rs["observaciones"]}', '{$_SESSION['user']}');" ;    


        // $sql_insert_mov_banco=base64_encode($sql_insert_mov_banco) ;
         $sql_insert_mov_banco= encrypt2($sql_insert_mov_banco) ;

           echo "<br><br><br><a class='btn btn-xs btn-link' target='_blank' title='Duplica un mov. banco para poder descomponerlo en varios pagos o cobros de suma el importe original' "
                   . " href=\"../include/sql.php?code=1&sql=$sql_insert_mov_banco \" >"
                   . "<i class='far fa-copy'></i> Duplicar Mov. Banco</a> ";

           echo "<a class='btn btn-xs btn-link' target='_blank' title='Duplica un mov. banco simetricamente, cambia cargo por importe y viceversa'"
                   . " href=\"../include/sql.php?code=1&sql=$sql_insert_mov_banco_simetrico \" >"
                   . "<i class='far fa-copy'></i> Duplicar Mov. Banco simétrico</a> ";

          require("../include/ficha.php"); ?>

              <!--// FIN     **********    FICHA.PHP-->
         </div>




        <div class="right2">

        <?php 
        //  WIDGET DOCUMENTOS 
        $tipo_entidad='mov_banco' ;
        $id_entidad=$id_mov_banco ;
        //$id_subdir=$id_cliente ;
        $id_subdir=0 ;
        $size='200px' ;
        require("../menu/LRU_registro.php"); require("../include/widget_documentos.php");  

         ?>

        </div>	      

              <!-- -->

        <div class="right2_50">

          <?php 

          //COMPROBAMOS SI EXISTE ID_PAGO, es decir, si está conciliado el MOV_BANCO con un ID_PAGO
          $id_pago=$rs["id_pago"] ;
          $id_remesa=$rs["id_remesa"] ;
          $conciliado = $rs["conc"] ;
          if ($conciliado)
          {
        //   $importe = Dfirst("importe","Vales_view","ID_VALE=$id_vale AND $where_c_coste" ) ;  

           $titulo = "<h1 style='font-weight: bold; color:green;'>CONCILIADO</h1>" ;

           if($id_pago)
           {    
//               $titulo .= "<a class='btn btn-link noprint' href='../bancos/pago_ficha.php?_m=$_m&id_pago=$id_pago' target='_blank'>ver Pago</a>" ;

               if($id_fra_prov=Dfirst("id_fra_prov","Fras_Prov_Pagos_View", "id_pago=$id_pago"))
               {
                   $titulo .= "<a class='btn btn-link noprint' href='../proveedores/factura_proveedor.php?_m=$_m&id_fra_prov=$id_fra_prov' target='_blank'>ver Factura Proveedor</a>" ;   
               }       
           }elseif ($id_remesa)
           {
              $titulo .= "<a class='btn btn-link noprint' href='../bancos/remesa_ficha.php?_m=$_m&id_remesa=$id_remesa' target='_blank'>ver REMESA</a>" ;   
           }
        //   $titulo .= "<a class='btn btn-link btn-xs' href='../personal/parte_cargar_a_obra.php?id_parte=$id_parte&id_vale=$id_vale' >actualizar cargo</a>" ;
          }
           else
          {
           $titulo="<h1 style='font-weight: bold;color:red;'>NO CONCILIADO</h1>" ;   
        //   $titulo .= "<a class='btn btn-primary' href='../personal/parte_cargar_a_obra.php?id_parte=$id_parte' >Cargar a obra</a>" ;
          }
           echo $titulo ;
         ?>

          </div>            



        <?php            // ----- div Pagos_View   tabla.php   -----

        //COMPROBAMOS SI EXISTE ID_PAGO, es decir, si está conciliada, PINTAMOS EL DIV Prosibles ID_PAGO
        if (!$conciliado)
        {

            echo "<div class='right2_50'  >" ;
            echo "<h3>POSIBLES CONCILIACIONES<h3>" ;
            
            
            // WIDGET DE PAGOS CONCILIABLES    
            //$sql="SELECT id_pago,f_vto,PROVEEDOR,id_proveedor,observaciones,importe,ingreso FROM Pagos_View "
            //        . " WHERE  id_cta_banco=$id_cta_banco AND conc=0 AND (importe='$importe' AND ingreso='$ingreso') AND $where_c_coste ORDER BY f_vto DESC ";

                // buscamos pagos en cualquier id_cta_banco y no solo en la del mov_banco en cuestion
            $sql="SELECT id_pago,f_vto,PROVEEDOR,id_proveedor,observaciones,importe,ingreso FROM Pagos_View "
                    . " WHERE  conc=0 AND (importe='$importe' AND ingreso='$ingreso') AND $where_c_coste ORDER BY f_vto DESC ";
            //echo $sql;
            $result=$Conn->query($sql );

            $updates=[];
            //$updates=['MOTIVO', 'F_solicitud', 'Observaciones'] ;
            //  $tabla_update="Avales" ;
            //  $id_update="ID_AVAL" ;

            //$formats["f_vto"]='fecha';
            $formats["importe"]='moneda';
            $formats["ingreso"]='moneda';

            $links["observaciones"] = ["../bancos/pago_ficha.php?id_pago=", "id_pago"] ;
            $links["PROVEEDOR"]=["../proveedores/proveedores_ficha.php?id_proveedor=", "id_proveedor"] ;

            // accion de CONCILIAR el MOV_BANCO con el ID_PAGO
            $onclick1_VARIABLE1_="id_pago" ;           // paso de variables para dar instrucciones al boton 'add' para añadir un detalle a la udo
            //$onclick1_VARIABLE2_="" ;     // idem

            // OBSOLETA TRAS EL CAMBIO DE BBDD ELIMINANDO PAGOS_MOV_BANCOS
            //$sql_insert="INSERT INTO PAGOS_MOV_BANCOS ( id_mov_banco,id_pago ) " . 
            //          " VALUES ( '$id_mov_banco', _VARIABLE1_ );"  ;
            $sql_insert="UPDATE PAGOS SET id_mov_banco='$id_mov_banco' WHERE id_pago=_VARIABLE1_ ;"  ;


             $sql_insert=encrypt2($sql_insert) ;

            $href="../include/sql.php?code=1&sql=$sql_insert&variable1=_VARIABLE1_";
            //$actions_row["onclick1_link"]="<a class='btn btn-warning btn-xs' target='_blank' title='concilia el mov.banco con el Pago' href=\"../include/sql.php?code=1&sql=$sql_insert&variable1=_VARIABLE1_ \" >conciliar</a> ";
            $actions_row["onclick1_link"]="<a class='btn btn-warning btn-xs' title='concilia el mov.banco con el Pago' href='#'  onclick=\"js_href('$href')\"   >conciliar</a> ";
            $actions_row["id"]="id_pago";


            //$tooltips["conc"] = "Factura conciliada. Los Vales (albaranes de proveedor) suman el importe de la factura" ;

            //$titulo="<a href=\"proveedores_documentos.php?id_proveedor=$id_proveedor\">Documentos (ver todos...)</a> " ;
            //$titulo="Posibles REMESAS, PAGOS, COBROS O TRASPASOS a conciliar " ;
            $num_pagos=$result->num_rows;
            $tabla_expandida= ($num_pagos>0) ;
            $titulo="PAGOS conciliables... ($num_pagos)" ;
            $msg_tabla_vacia="";

            //echo "<div id='main' class='mainc' style='background-color:orange'>" ;
            //echo "<div class='mainc'  >" ;

            //echo "<a class='btn btn-primary' target='_blank' href= '../bancos/aval_anadir.php?id_linea_avales=$id_linea_avales' ><i class='fas fa-plus-circle'></i>Añadir Aval</a><br>" ;

            require("../include/tabla.php"); echo $TABLE ; 
            //echo "<br>"  ;
            //echo "</div>" ;

            // WIDGET DE REMESAS CONCILIABLES    
            //$sql="SELECT id_pago,f_vto,PROVEEDOR,id_proveedor,observaciones,importe,ingreso FROM Pagos_View "
            //        . " WHERE  id_cta_banco=$id_cta_banco AND conc=0 AND (importe='$importe' AND ingreso='$ingreso') AND $where_c_coste ORDER BY f_vto DESC ";

                // buscamos pagos en cualquier id_cta_banco y no solo en la del mov_banco en cuestion
            //$sql="SELECT id_remesa,fecha_creacion,remesa,id_cta_banco,num_pagos FROM Remesas_View "
            //        . " WHERE cobrada=0 AND id_cta_banco=$id_cta_banco AND firmada=1 AND importe='$importe' AND $where_c_coste ORDER BY fecha_creacion DESC ";
            $sql="SELECT id_remesa,fecha_creacion,remesa,importe,id_cta_banco,num_pagos FROM Remesas_View "
                    . " WHERE cobrada=0 AND id_cta_banco=$id_cta_banco AND firmada=1 AND importe=$importe AND  $where_c_coste ORDER BY fecha_creacion DESC ";
            //echo $sql;
            $result=$Conn->query($sql );

            $updates=[];
            //$updates=['MOTIVO', 'F_solicitud', 'Observaciones'] ;
            //  $tabla_update="Avales" ;
            //  $id_update="ID_AVAL" ;

            //$formats["f_vto"]='fecha';
            //$formats["importe"]='moneda';
            //$formats["ingreso"]='moneda';

            //$links["observaciones"] = ["../bancos/pago_ficha.php?id_pago=", "id_pago"] ;
            $links["remesa"] = ["../bancos/remesa_ficha.php?id_remesa=", "id_remesa", "ver Remesa", "formato_sub"] ;

            // accion de CONCILIAR el MOV_BANCO con el ID_PAGO
            $onclick1_VARIABLE1_="id_remesa" ;           // paso de variables para dar instrucciones al boton 'add' para añadir un detalle a la udo
            //$onclick1_VARIABLE2_="" ;     // idem

            // OBSOLETA TRAS EL CAMBIO DE BBDD ELIMINANDO PAGOS_MOV_BANCOS
            //$sql_insert="INSERT INTO PAGOS_MOV_BANCOS ( id_mov_banco,id_pago ) " . 
            //          " VALUES ( '$id_mov_banco', _VARIABLE1_ );"  ;
            $sql_insert="UPDATE Remesas SET id_mov_banco_remesa='$id_mov_banco' WHERE id_remesa=_VARIABLE1_ ;"  ;


             $sql_insert=encrypt2($sql_insert) ;

            $href="../include/sql.php?code=1&sql=$sql_insert&variable1=_VARIABLE1_";
            //$actions_row["onclick1_link"]="<a class='btn btn-warning btn-xs' target='_blank' title='concilia el mov.banco con el Pago' href=\"../include/sql.php?code=1&sql=$sql_insert&variable1=_VARIABLE1_ \" >conciliar</a> ";
            $actions_row["onclick1_link"]="<a class='btn btn-warning btn-xs' title='concilia el mov.banco con la Remesa' href='#'  onclick=\"js_href('$href')\"   >conciliar</a> ";
            $actions_row["id"]="id_remesa";


            //$tooltips["conc"] = "Factura conciliada. Los Vales (albaranes de proveedor) suman el importe de la factura" ;

            //$titulo="<a href=\"proveedores_documentos.php?id_proveedor=$id_proveedor\">Documentos (ver todos...)</a> " ;
            //$titulo="Posibles REMESAS, PAGOS, COBROS O TRASPASOS a conciliar " ;
            $num_remesas=$result->num_rows;
            $tabla_expandida= ($num_remesas>0) ;        
            $titulo="REMESAS conciliables... ($num_remesas)" ;
            $msg_tabla_vacia="";

            //echo "<div id='main' class='mainc' style='background-color:orange'>" ;
            //echo "<div class='mainc' style='background-color:lightgrey ;width:60%;' >" ;
            //echo "<div class='mainc'  >" ;

            //echo "<a class='btn btn-primary' target='_blank' href= '../bancos/aval_anadir.php?id_linea_avales=$id_linea_avales' ><i class='fas fa-plus-circle'></i>Añadir Aval</a><br>" ;

            require("../include/tabla.php"); echo $TABLE ; 
            //echo "<br>"  ;
            //echo "</div>" ;






            // WIDGET DE FACTURAS PROVEEDOR CONCILIABLES    
            //$sql="SELECT id_pago,f_vto,PROVEEDOR,id_proveedor,observaciones,importe,ingreso FROM Pagos_View WHERE  id_cta_banco=$id_cta_banco AND conc=0 AND importe='$importe' AND ingreso='$ingreso') AND $where_c_coste ";
            $sql="SELECT ID_FRA_PROV,ID_PROVEEDORES,PROVEEDOR,N_FRA,FECHA,IMPORTE_IVA,Observaciones,conc,pagada "
                 . " FROM Fras_Prov_View WHERE pagada=0 AND $importe<>0 AND IMPORTE_IVA='$importe' AND $where_c_coste ORDER BY FECHA DESC " ;

            //echo $sql;
            $result=$Conn->query($sql );

            $updates=[];
            //$updates=['MOTIVO', 'F_solicitud', 'Observaciones'] ;
            //  $tabla_update="Avales" ;
            //  $id_update="ID_AVAL" ;

            //$formats["f_vto"]='fecha';
            $formats["IMPORTE_IVA"]='moneda';
            $formats["conc"]='boolean';
            $formats["pagada"]='boolean';

            $links["N_FRA"] = ["../proveedores/factura_proveedor.php?id_fra_prov=", "ID_FRA_PROV"] ;
            $links["PROVEEDOR"]=["../proveedores/proveedores_ficha.php?id_proveedor=", "ID_PROVEEDORES"] ;


            // accion de CONCILIAR el MOV_BANCO con el ID_PAGO
            $onclick1_VARIABLE1_="ID_FRA_PROV" ;           // paso de variables para dar instrucciones al boton 'add' para añadir un detalle a la udo
            //$onclick1_VARIABLE2_="" ;     // idem

            //$sql_insert="INSERT INTO PAGOS_MOV_BANCOS ( id_mov_banco,id_pago ) " . 
            //          " VALUES ( '$id_mov_banco', _VARIABLE1_ );"  ;

            //

            $href="../bancos/mov_bancos_conciliar_selection_fras.php?id_mov_banco=$id_mov_banco&id_fra_prov=_VARIABLE1_";
            //$actions_row["onclick1_link"]="<a class='btn btn-warning btn-xs' target='_blank' title='concilia el mov.banco con el Pago' href=\"../include/sql.php?code=1&sql=$sql_insert&variable1=_VARIABLE1_ \" >conciliar</a> ";
            $actions_row["onclick1_link"]="<a class='btn btn-warning btn-xs' title='concilia el mov.banco con la factura creando un id_pago' href='#'  onclick=\"js_href('$href')\"   >conciliar</a> ";
            //

            //$actions_row["onclick1_link"]="<a class='btn btn-warning btn-xs' target='_blank' title='concilia el mov.banco con la factura creando un id_pago ' "
            //                  . "href=\"../bancos/mov_bancos_conciliar_selection_fras.php?id_mov_banco=$id_mov_banco&id_fra_prov=_VARIABLE1_ \" >conciliar</a> ";
            $actions_row["id"]="ID_FRA_PROV";




            //$tooltips["conc"] = "Factura conciliada. Los Vales (albaranes de proveedor) suman el importe de la factura" ;

            //$titulo="<a href=\"proveedores_documentos.php?id_proveedor=$id_proveedor\">Documentos (ver todos...)</a> " ;
            //$titulo="Posibles REMESAS, PAGOS, COBROS O TRASPASOS a conciliar " ;
            $num_fras_prov=$result->num_rows;
            $tabla_expandida= ($num_fras_prov>0) ;
            $titulo="FACTURAS Proveedor conciliables...($num_fras_prov) " ;
            $msg_tabla_vacia="";

            //echo "<div id='main' class='mainc' style='background-color:orange'>" ;
            //echo "<div class='mainc' style='background-color:lightgrey ;width:60%;' >" ;

            //echo "<a class='btn btn-primary' target='_blank' href= '../bancos/aval_anadir.php?id_linea_avales=$id_linea_avales' ><i class='fas fa-plus-circle'></i>Añadir Aval</a><br>" ;

            require("../include/tabla.php"); echo $TABLE ; 
            //echo "<br>"  ;
            //echo "</div>" ;





            // WIDGET DE FACTURAS CLIENTES CONCILIABLES    
            //$sql="SELECT id_pago,f_vto,PROVEEDOR,id_proveedor,observaciones,importe,ingreso FROM Pagos_View WHERE  id_cta_banco=$id_cta_banco AND conc=0 AND importe='$importe' AND ingreso='$ingreso') AND $where_c_coste ";
            $sql="SELECT ID_FRA,ID_OBRA,ID_CLIENTE,NOMBRE_OBRA,CLIENTE,N_FRA,FECHA_EMISION,CONCEPTO,IMPORTE_IVA,Cobrada,Observaciones "
                    . " FROM Facturas_View WHERE Cobrada=0 AND $ingreso<>0 AND IMPORTE_IVA='$ingreso' AND $where_c_coste ORDER BY FECHA_EMISION " ;

            //echo $sql;
            $result=$Conn->query($sql);

            $updates=[];
            //$updates=['MOTIVO', 'F_solicitud', 'Observaciones'] ;
            //  $tabla_update="Avales" ;
            //  $id_update="ID_AVAL" ;

            //$formats["f_vto"]='fecha';
            $formats["IMPORTE_IVA"]='moneda';
            $formats["Cobrada"]='boolean';
            $formats["pagada"]='boolean';

            $links["N_FRA"] = ["../clientes/factura_cliente.php?id_fra=", "ID_FRA", '', 'formato_sub'] ;
            $links["FECHA_EMISION"] = ["../clientes/factura_cliente.php?id_fra=", "ID_FRA", '', 'formato_sub'] ;
            $links["NOMBRE_OBRA"]=["../obras/obras_ficha.php?id_obra=", "ID_OBRA"] ;
            $links["CLIENTE"] = ["../clientes/clientes_ficha.php?id_cliente=", "ID_CLIENTE"] ;


            // accion de CONCILIAR el MOV_BANCO con el ID_PAGO
            //$onclick1_VARIABLE1_="id_pago" ;           // paso de variables para dar instrucciones al boton 'add' para añadir un detalle a la udo
            ////$onclick1_VARIABLE2_="" ;     // idem
            //
            //$sql_insert="INSERT INTO PAGOS_MOV_BANCOS ( id_mov_banco,id_pago ) " . 
            //          " VALUES ( '$id_mov_banco', _VARIABLE1_ );" ;
            //
            //$actions_row["onclick1_link"]="<a class='btn btn-link btn-xs' title='concilia el mov.banco con el Pago' href=\"../include/sql.php?sql=base64_encode($sql_insert) \" >conciliar</a> ";
            //$actions_row["id"]="id_pago";
            //  

            //$tooltips["conc"] = "Factura conciliada. Los Vales (albaranes de proveedor) suman el importe de la factura" ;

            //$titulo="<a href=\"proveedores_documentos.php?id_proveedor=$id_proveedor\">Documentos (ver todos...)</a> " ;
            //$titulo="Posibles REMESAS, PAGOS, COBROS O TRASPASOS a conciliar " ;
            $num_fras_cli=$result->num_rows;
            $tabla_expandida= ($num_fras_cli>0) ;     
            $titulo="FACTURAS Clientes conciliables...($num_fras_cli) " ;
            $msg_tabla_vacia="";

            //echo "<div id='main' class='mainc' style='background-color:orange'>" ;
            //echo "<div class='mainc' style='background-color:lightgrey ;width:60%;' >" ;

            //echo "<a class='btn btn-primary' target='_blank' href= '../bancos/aval_anadir.php?id_linea_avales=$id_linea_avales' ><i class='fas fa-plus-circle'></i>Añadir Aval</a><br>" ;

            require("../include/tabla.php"); echo $TABLE ; 
            //echo "<br>"  ;
            //echo "</div>" ;



            // WIDGET DE TRASPASOS INTERNOS CONCILIABLES    
            //$sql="SELECT id_pago,f_vto,PROVEEDOR,id_proveedor,observaciones,importe,ingreso FROM Pagos_View WHERE  id_cta_banco=$id_cta_banco AND conc=0 AND importe='$importe' AND ingreso='$ingreso') AND $where_c_coste ";
            $sql="SELECT id_mov_banco,id_cta_banco,doc_logo,Banco,fecha_banco,Concepto,cargo,ingreso,observaciones,fecha_creacion,user "
                    . " FROM MOV_BANCOS_View WHERE conc=0 AND ingreso='$importe' AND cargo='$ingreso' AND $where_c_coste ORDER BY fecha_banco DESC " ;

            //echo $sql;
            $result=$Conn->query($sql );

            $updates=[];
            //$updates=['MOTIVO', 'F_solicitud', 'Observaciones'] ;
            //  $tabla_update="Avales" ;
            //  $id_update="ID_AVAL" ;

            //$formats["f_vto"]='fecha';
            //$formats["IMPORTE_IVA"]='moneda';
            //$formats["Cobrada"]='boolean';
            //$formats["pagada"]='boolean';
            $formats["cargo"]="moneda";


            $links["Banco"] = ["../bancos/bancos_mov_bancarios.php?id_cta_banco=", "id_cta_banco", "", "formato_sub"] ;
            $links["Concepto"] = ["../bancos/pago_ficha.php?id_mov_banco=", "id_mov_banco","ver movimiento bancario" ,"formato_sub"] ;
            $links["fecha_banco"] = ["../bancos/pago_ficha.php?id_mov_banco=", "id_mov_banco","ver movimiento bancario" ,"formato_sub"] ;
            //$links["CLIENTE"] = ["../clientes/clientes_ficha.php?id_cliente=", "ID_CLIENTE"] ;


            // accion de CONCILIAR el MOV_BANCO con el ID_PAGO
            $onclick1_VARIABLE1_="id_mov_banco" ;           // paso de variables para dar instrucciones al boton 'add' para añadir un detalle a la udo
            //$onclick1_VARIABLE2_="" ;     // idem

            //$sql_insert="INSERT INTO PAGOS_MOV_BANCOS ( id_mov_banco,id_pago ) " . 
            //          " VALUES ( '$id_mov_banco', _VARIABLE1_ );"  ;


            $href="../bancos/mov_bancos_conciliar_traspaso.php?id_mov_banco1=$id_mov_banco&id_mov_banco2=_VARIABLE1_";
            $actions_row["onclick1_link"]="<a class='btn btn-warning btn-xs' title='concilia el mov.banco como TRASPASO INTERNO entre cuentas' href='#'  onclick=\"js_href('$href')\"   >conciliar</a> ";

            //$actions_row["onclick1_link"]="<a class='btn btn-warning btn-xs' target='_blank' title='concilia el mov.banco como TRASPASO INTERNO entre cuentas ' "
            //                  . "href=\"../bancos/mov_bancos_conciliar_traspaso.php?id_mov_banco1=$id_mov_banco&id_mov_banco2=_VARIABLE1_ \" >conciliar</a> ";
            $actions_row["id"]="id_mov_banco";


            $num_traspasos=$result->num_rows;
            $tabla_expandida= ($num_traspasos>0) ;
            $titulo="TRASPASOS INTERNOS conciliables...($num_traspasos) " ;
            $msg_tabla_vacia="";

            //echo "<div id='main' class='mainc' style='background-color:orange'>" ;
            //echo "<div class='mainc' style='background-color:lightgrey ;width:60%;' >" ;

            //echo "<a class='btn btn-primary' target='_blank' href= '../bancos/aval_anadir.php?id_linea_avales=$id_linea_avales' ><i class='fas fa-plus-circle'></i>Añadir Aval</a><br>" ;

            require("../include/tabla.php"); echo $TABLE ; 
            //echo "<br>"  ;

        }
    
    
    
    
}else
    {
    echo "<h3>NO HAY Movimiento Banco</h3>" ;
}    
    
echo "</div>" ;



$Conn->close();

?>
	 

</div>


                </div>
                <!--****************** BUSQUEDA GLOBAL  *****************
            </div>
        </div>
        <!-- FIN Contenido principal -->
  <br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br>
  <br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br>
  <br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br>
  <br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br>

<?php 

//FIN
include_once('../templates/_inc_privado3_footer.php');