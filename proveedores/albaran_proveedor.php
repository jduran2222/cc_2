<?php
// cambios
require_once("../include/session.php");
$where_c_coste = " id_c_coste={$_SESSION['id_c_coste']} ";
$id_c_coste = $_SESSION['id_c_coste'];

$titulo = 'Albarán Proveedor';

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


$id_vale=$_GET["id_vale"];

//$id_vale=87288;
 //require("../proveedores/proveedores_menutop_r.php");

?>
	
<!--<div >	   -->
  <div id="main" class="mainc_60" > 
   
  <?php              // DATOS   FICHA . PHP
//echo "<pre>";
$sql="SELECT ID_VALE, ID_OBRA,ID_PARTE,id_subobra_auto, ID_PROVEEDORES, PROVEEDOR,FECHA, REF,  Observaciones, ID_FRA_PROV,importe, ID_FRA_PROV as conciliado, user, fecha_creacion ,guid "
        . "FROM  Vales_view WHERE id_vale=$id_vale AND $where_c_coste" ;

//echo $sql ; 
 $result=$Conn->query($sql);
 
 $rs = $result->fetch_array(MYSQLI_ASSOC) ;

$id_vale=$rs["ID_VALE"];         // garantizamos que hay un vale con ese ID_VALE para poner a CERO si no lo hay y evitar fuga de datos
$id_obra=$rs["ID_OBRA"];        
$fecha=$rs["FECHA"];        

//$id_subobra= getVar("id_subobra_si") ;
$id_subobra= $rs["id_subobra_auto"] ?  $rs["id_subobra_auto"]   : getVar("id_subobra_si") ;     // la segunda opcion palia las obras antiguas que no tengan id_subobra_auto
  
 if($id_parte=Dfirst("ID_PARTE", "PARTES", " ID_OBRA='$id_obra' AND Fecha='$fecha' "))
 {
  echo "<a class='btn btn-link' href= '../personal/parte.php?_m=$_m&id_parte=$id_parte' >Ver PARTE DIARIO</a><br>" ;
 }      

$content_crear_factura='';  //inicializo 
if (!$rs["conciliado"]) 
{
$guid =  guid(); // guid CASERO para localizar la nueva factura creada
//echo strlen($guid); // guid CASERO para localizar la nueva factura creada
//$guid =  "__PRUEBA_JUAN_DURAN__2"; // guid CASERO para localizar la nueva factura creada
$sql_insert_documento="" ;

if ($path_archivo=Dfirst("path_archivo", "Documentos", " $where_c_coste AND tipo_entidad='albaran' AND id_entidad='$id_vale' "))
{
   $metadatos=Dfirst("metadatos", "Documentos", " $where_c_coste AND tipo_entidad='albaran' AND id_entidad='$id_vale' ") ;
   $sql_insert_documento= "INSERT INTO `Documentos` (`id_c_coste`, `tipo_entidad`, `id_entidad`,`id_subdir`, `documento`, `metadatos`,   `path_archivo`, `tamano`, `Observaciones` , user) "
        . "VALUES ( '{$_SESSION['id_c_coste']}', 'fra_prov', (select ID_FRA_PROV from FACTURAS_PROV where guid='$guid' ), '0', 'link', '$metadatos','$path_archivo', '0', '', '{$_SESSION['user']}' );"   ;
}        
    
    
$importe_iva = $rs["importe"] * 1.21  ; // estimamos un IVA del 21% en 2019  
//$sql_facturar= "INSERT INTO FACTURAS_PROV ( ID_PROVEEDORES,N_FRA,FECHA,IMPORTE_IVA,guid, user ) "
//        . "     VALUES ( '{$rs["ID_PROVEEDORES"]}' ,'{$rs["REF"]}' ,'{$rs["FECHA"]}' ,'$importe_iva' ,'$guid' ,'{$_SESSION["user"]}'  );"
$sql_facturar= "INSERT INTO FACTURAS_PROV ( ID_PROVEEDORES,N_FRA,FECHA,IMPORTE_IVA,guid, user ) "
        . "     VALUES ( '{$rs["ID_PROVEEDORES"]}' ,'factura de albaran' ,'{$rs["FECHA"]}' ,'$importe_iva' ,'$guid' ,'{$_SESSION["user"]}'  );"
        . " _CC_NEW_SQL_ "
         . "UPDATE `VALES` SET `ID_FRA_PROV` = (select ID_FRA_PROV from FACTURAS_PROV where guid='$guid' )  WHERE ID_VALE={$rs["ID_VALE"]}; "
        . "  _CC_NEW_SQL_  "
        . "$sql_insert_documento "  ;
        
$href='../include/sql.php?sql=' . encrypt2($sql_facturar)  ;    
$content_crear_factura= "<div class='right2'>"
                            . "<a class='btn btn-primary btn-xs noprint ' href='#' "
                         . " onclick=\"js_href('$href')\"   "
                         . "title='Crea una factura de este Albarán' > Crear factura</a>"
                       . "</div>" ;
      
}

//  $updates=['REF','FECHA', 'Observaciones']  ;
//$links["NOMBRE_OBRA"]=["../obras/obras_ficha.php?id_obra=", "ID_OBRA"] ;
$links["PROVEEDOR"]=["../proveedores/proveedores_ficha.php?id_proveedor=", "ID_PROVEEDORES" ] ; 
//  
$formats["importe"]="moneda"  ;
//  $formats["importe"]=getVar("juanillo")  ;
$formats["conciliado"]="semaforo_txt_CONCILIADO";
$etiquetas["conciliado"]="Conciliado en factura";

  
$id_proveedor=$rs["ID_PROVEEDORES"] ;
//  $id_obra=$rs["ID_OBRA"] ;
$id_fra_prov=$rs["ID_FRA_PROV"] ;
$id_parte=$rs["ID_PARTE"] ;


// $rs["ID_FRA_PROV"]=is_null($rs["ID_FRA_PROV"])?  0 :  $rs["ID_FRA_PROV"] ;  // elimino el error que da foreach por usar valores NULL
// $id_fra_prov=$rs["ID_FRA_PROV"] ;
//  $tabla_update="VALES" ;
//  $id_update="id_vale" ;
//  $id=$id_vale;
//   
  
    $titulo="ALBARAN  PROVEEDOR" ;
  
//    $selects["ID_OBRA"]=["ID_OBRA","NOMBRE_OBRA","OBRAS"] ;   // datos para clave foránea
  
  $updates=['ID_PROVEEDORES','ID_OBRA','REF','FECHA', 'Observaciones']  ;
//  $id_proveedor=$rs["ID_PROVEEDORES"] ;
  $tabla_update="VALES" ;
  $id_update="ID_VALE" ;
  $id_valor=$id_vale ;
  
  
  
// $selects["ID_OBRA"]=["ID_OBRA","NOMBRE_OBRA","OBRAS"] ;   // datos para clave foránea
 $selects["ID_OBRA"]=["ID_OBRA","NOMBRE_OBRA","OBRAS","../obras/obras_anadir_form.php","../obras/obras_ficha.php?id_obra=","ID_OBRA"] ;   // datos para clave foránea Y PARA AÑADIR PROVEEDOR NUEVO
 $etiquetas["ID_OBRA"]='NOMBRE OBRA' ;
 
 

$delete_boton=1 ;

  
 
//  if (!$rs["importe"])    //  NO HAY DETALLES, podemos cambiar de Proveedor o borrrar el Vale (CAMBIAR A Dcount(id detalles)
  if (!$rs["importe"] OR $admin )    //  NO HAY DETALLES, podemos cambiar de Proveedor o borrrar el Vale (CAMBIAR A Dcount(id detalles)
  {
  $selects["ID_PROVEEDORES"]=["ID_PROVEEDORES","PROVEEDOR","Proveedores","../proveedores/proveedores_anadir.php","../proveedores/proveedores_ficha.php?id_proveedor=", "ID_PROVEEDORES"] ;   // datos para clave foránea Y PARA AÑADIR PROVEEDOR NUEVO
  $etiquetas["ID_PROVEEDORES"]='PROVEEDOR' ; 

  }
  else
  {
    $disabled_delete=1;
    $delete_title="Para eliminar el ALBARAN  debe eliminar previamente los detalles" ;

  }
  
  
  ?>
<!--   
  <div style="overflow:visible">	   
  <div id="main" class="mainc"> -->
      
  <?php require("../include/ficha.php"); ?>
   
 </div>	
 
  <!--</div>-->
   
   
    
              <!--BOTONERA PARA -LINK CON FRA_PROV,ver foto si hay,  AÑADIR DOCUMENTO, pdf, ... Y OTROS-->
<!--<div class="right2">-->      

  
  <?php
  
 echo $content_crear_factura ;
 
  // es un Vale de Parte diario?
// if($id_parte=Dfirst("ID_PARTE", "Partes_View", " ID_VALE=$id_vale AND $where_c_coste "))
 if($id_parte)
  {   
     echo "<div id='main' class='right2'>"  ;
      echo "<h1 style='font-weight: bold;color:green;'>CARGO A OBRA DE PARTE</h1>" ;
      echo "<a class='btn btn-link btn-xs' href='../personal/parte.php?_m=$_m&id_parte=$id_parte' target='_blank'>ver Parte</a>" ;
     echo "</div>"  ;
      
  }
  elseif ($id_fra_prov)    // conciliado en factura
  {   
     echo "<div id='main' class='right2' style='background-color:lightgreen;'>"  ;
     echo "<h1 style='font-weight: bold;color:green;'>CONCILIADO EN FACTURA</h1>" ;
     echo "<a class='btn btn-link btn-xs' href='../proveedores/factura_proveedor.php?_m=$_m&id_fra_prov=$id_fra_prov' target='_blank'>ver factura</a>" ;
     echo "</div>"  ;
      
  }
  
  ?>
    


	
<?php 



// listado de VALES_ABONO correspondientes a este VALE-ALBARAN

$sql="SELECT ID_VALE,FECHA, ID_OBRA, NOMBRE_OBRA, REF,importe FROM Vales_view "
        . "  WHERE $where_c_coste AND ID_VALE IN (SELECT id_vale_abono  FROM Vales_cargo_abono WHERE id_vale_cargo=$id_vale   ) ; ";
//$sql="SELECT * FROM GASTOS_T  WHERE ID_VALE=$id_vale   ";
//echo $sql;
$result=$Conn->query($sql );

$sql="SELECT '' as a,'' as b,'Suma' as c, SUM(importe) as importe FROM Vales_view "
        . " WHERE $where_c_coste AND ID_VALE IN (SELECT id_vale_abono  FROM Vales_cargo_abono WHERE id_vale_cargo=$id_vale   ) ";
//echo $sql;
$result_T=$Conn->query($sql );

$formats["FECHA"]='fecha';
$formats["importe"]='moneda';
//$formats["pdf"]='pdf_50';

$links["FECHA"] = ["albaran_proveedor.php?id_vale=", "ID_VALE", "ver Albarán", "formato_sub"] ;
$links["NOMBRE_OBRA"]=["../obras/obras_ficha.php?id_obra=", "ID_OBRA"] ;

//$aligns["importe"] = "right" ;
//$aligns["Pdte_conciliar"] = "right" ;
//$aligns["Importe_ejecutado"] = "right" ;

//$tooltips["conc"] = "Factura conciliada. Los Vales (albaranes de proveedor) suman el importe de la factura" ;

//$titulo="<a href=\"proveedores_documentos.php?id_proveedor=$id_proveedor\">Documentos (ver todos...)</a> " ;
//$num_vales=Dfirst("COUNT(ID_VALE)","VALES", "ID_FRA_PROV=$id_fra_prov") ;
$num_vales= $result->num_rows;


$titulo="<span>Albaranes Abono ($num_vales <span class='glyphicon glyphicon-tags'></span>):</span>" ; 

$msg_tabla_vacia="";

if ($num_vales>0)
{
   echo "<div class='right2' >" ; 
   require("../include/tabla.php"); echo $TABLE ; //  VALES 
   echo "</div>" ; 

   
}

echo "<div class='right2'>" ;
//  WIDGET DOCUMENTOS 

$tabla_expandida=1;

$tipo_entidad='albaran' ;
$id_entidad=$id_vale ;
$id_subdir=$id_proveedor ;
$size='200px' ;
require("../menu/LRU_registro.php"); require("../include/widget_documentos.php");  
echo "</div>" ;

 
     



///  DETALLES CONCEPTOS DEL ALBARAN

$sql="SELECT id,ID_CONCEPTO,id_usub, CONCEPTO,CANTIDAD,COSTE,IMPORTE,Obs,SUBOBRA,IF(id_usub,'uSub','') as Subc FROM ConsultaGastos_View  WHERE ID_VALE=$id_vale  AND $where_c_coste  ";
//$sql="SELECT * FROM GASTOS_T  WHERE ID_VALE=$id_vale   ";
//echo $sql;
$result=$Conn->query($sql );

$sql_T="SELECT 'Total' AS A,'' AS A1,'' AS A2, SUM(IMPORTE) AS IMPORTE,'' AS A3  FROM ConsultaGastos_View  WHERE ID_VALE=$id_vale  AND $where_c_coste  ";
//echo $sql;
$result_T=$Conn->query($sql_T );

  $updates=['CANTIDAD','Obs']  ;
//  $id_proveedor=$rs["ID_PROVEEDORES"] ;
  $tabla_update="GASTOS_T" ;
  $id_update="id" ;
//  $id_valor=$id_vale ;
$actions_row=[];
$actions_row["id"]="id";
$actions_row["delete_link"]="1";
$actions_row["delete_confirm"]="0";



//$links["f_vto"] = ["fra_prov_pago.php?id_pago=", "id_pago"] ;
$links["CONCEPTO"] = ["../proveedores/concepto_ficha.php?id_concepto=", "ID_CONCEPTO","ver Ficha del Concepto de proveedor","formato_sub"]  ;
$links["Subc"] = ["../proveedores/usub_ficha.php?id=", "id_usub","ver Unidad subcontratada","formato_sub_vacio"]  ;

//
$tooltips["Subc"] = "Unidad de Obra perteneciente a un Subcontrato" ;
$aligns["Subc"] = "center" ;
$formats["IMPORTE"] = "moneda" ;
$formats["Obs"] = "text_edit" ;
$etiquetas["Obs"] = "Observaciones" ;
$formats["COSTE"] = "moneda" ;
$formats["CANTIDAD"] = "text_edit" ;
//$aligns["abonado"] = "center" ;
//$aligns["P_multiple"] = "center" ;
////$aligns["Importe_ejecutado"] = "right" ;
//
//$tooltips["abonado"] = "Pago abonado. Clickar para ver el movimiento bancario" ;
//$tooltips["P_multiple"] = "Pago múltiple. Pago para varias facturas" ;

//$titulo="<a href=\"proveedores_documentos.php?id_proveedor=$id_proveedor\">Documentos (ver todos...)</a> " ;
$titulo="" ;
$msg_tabla_vacia="No hay ";





?>
	

 <div class="mainc_100" style="background-color:Khaki;float:left;width:90%;padding:0px 0px;">
     

  <h2>Conceptos</h2>
    <div class="form-group" >
      <!--<label for="id_personal">Selecciona personal:</label>-->
    
      <button data-toggle='collapse' class="btn btn-default" data-target='#div_concepto_existente'>Añadir conceptos al albarán <i class="fas fa-chevron-down"></i></button>

          <div id='div_concepto_existente' class='collapse' style="background-color:white;border: 1px solid silver;padding:0px 0px;"> 

          <input type="text" id="filtro" size="5" value="" style="text-align:right;" placeholder="buscar" />
          <i class="fas fa-search"></i>
          <!--<select class="form-control" id="id_personal" style="width: 30%;">-->
          <select id="id_concepto"  onblur='this.size=1;' onchange='this.size=1; this.blur();document.getElementById("concepto_nuevo").value=$("#id_concepto :selected").text();' style="font-size: 15px; width: 30%;" size="1">


           <?php 

            $id_concepto_auto=Dfirst("id_concepto_auto","Proveedores","ID_PROVEEDORES=$id_proveedor")   ;
            echo DOptions_sql("SELECT ID_CONCEPTO,CONCAT(COSTE, ' €   ', CONCEPTO ) FROM Conceptos_View "
                    . " WHERE ID_CONCEPTO=$id_concepto_auto AND $where_c_coste ORDER BY COSTE ", "Selecciona concepto existente...") ;
            ?>

            <option value="">-------</option>
            <option value="">CONCEPTOS DE LA OBRA</option>

           <?php 
            echo DOptions_sql("SELECT ID_CONCEPTO,CONCAT(COSTE, ' € ', CONCEPTO ) FROM Conceptos_View WHERE ID_OBRA=$id_obra AND ID_PROVEEDOR=$id_proveedor AND $where_c_coste ORDER BY  COSTE ") ;
            ?>

            <option value="">-------</option>
            <option value="">OTROS CONCEPTOS</option>
           <?php echo DOptions_sql("SELECT ID_CONCEPTO,CONCAT(COSTE, ' € ', CONCEPTO ) FROM Conceptos_View WHERE ID_OBRA<>$id_obra AND ID_PROVEEDOR=$id_proveedor AND $where_c_coste ORDER BY  COSTE ") ?>
          </select>
           <input type="text" id="concepto_nuevo" size="40" value="" style="text-align:right;" placeholder="concepto nuevo" title="rellenar cuando no exista el concepto" />
          <input type="text" id="cantidad" size="5" value="" style="text-align:right;" placeholder="cantidad" />
          <input type="text" id="coste" size="5" value="" style="text-align:right;" placeholder="coste" title="rellenar solo para conceptos nuevos" />
          <input type="text" id="importe" size="5" value="" style="text-align:right;" placeholder="importe" title="rellenar solo para valorar el albarán por el total" />
          <a id='anadir_concepto'  class='btn btn-warning btn-xs' href='#'  onclick='add_vale_detalle(<?php echo " $id_vale , $id_subobra , $id_proveedor,$id_obra "  ; ?>);'>Añadir</a>
          <a class='btn btn-link btn-xs' href='#'  onclick='ver_concepto();'>ver concepto</a>
          <a class='btn btn-link btn-xs' href='../proveedores/concepto_anadir.php?id_proveedor=<?php echo $id_proveedor  ; ?>&id_obra=<?php echo $id_obra  ; ?>' target='_blank' ><i class='fas fa-plus-circle'></i> Nuevo concepto</a>

         </div>
    
    
</div>     
	
<?php require("../include/tabla.php"); echo $TABLE ; ?>
     <br><br>	
</div>	 
<!--              FIN pagos   -->	
	
	 


      
	<!-- WIDGET DOCUMENTOS  -->
	

        
 <?php  

$Conn->close();

?>
     
<!--</div>-->
<!--</div>-->
<!--</div>-->
<script>  
    
// PULSAR BUTON 'AÑADIR' TRAS 'ENTER' en los 3 INPUT (cantidad, coste e importe) al añadir un concepto al albarán
var input_cantidad = document.getElementById("cantidad");
// Execute a function when the user releases a key on the keyboard
input_cantidad.addEventListener("keyup", function(event) {
  // Cancel the default action, if needed
  event.preventDefault();
  // Number 13 is the "Enter" key on the keyboard
  if (event.keyCode === 13) {
    // Trigger the button element with a click
    document.getElementById("anadir_concepto").click();
  }
});

var input_coste = document.getElementById("coste");
input_coste.addEventListener("keyup", function(event) {
  event.preventDefault();
  if (event.keyCode === 13) {
    document.getElementById("anadir_concepto").click();
  }
});

var input_importe = document.getElementById("importe");
input_importe.addEventListener("keyup", function(event) {
  event.preventDefault();
  if (event.keyCode === 13) {
    document.getElementById("anadir_concepto").click();
  }
});




//////////////////

// filtro del <SELECT>    
$(document).ready(function() {
  $('#filtro').change(function() {
    var filter = $(this).val();
    filter=filter.replace(/ /g,".*")  ;
//    alert(filter) ;
//    var re = new RegExp('rebu', 'gi');
    var re = new RegExp(filter, 'gi');

    $('option').each(function() {
//      if ($(this).text().includes('SADA')) {
      if ($(this).text().match(re)) {
        $(this).show();
//        alert($(this).text()) ;
      } else {
        $(this).hide();
      }
//      $('select').val(filter);
//        $('select').selectedIndex = "1";
//        $('select').size = "4";
    })
//        $('select').selectedIndex = "1";
//        $('#id_concepto').size = 20;
//        $("#id_concepto").prop("selectedIndex", 2);
        $("#id_concepto").prop("size", 10);
//        $('select').size(20);

  })
})



    
function add_vale_detalle(id_vale, id_subobra, id_proveedor, id_obra) {
    
    //var valor0 = valor0_encode;
    //var valor0 = JSON.parse(valor0_encode);
   // var nuevo_valor=window.prompt("Nuevo valor de "+prompt , valor0);
//    alert("el nuevo valor es: "+valor) ;
//   alert('debug') ;
   var id_concepto=document.getElementById("id_concepto").value ;
   var cantidad=document.getElementById("cantidad").value ;
   var concepto_nuevo=document.getElementById("concepto_nuevo").value ;
   var coste=document.getElementById("coste").value ;
   var importe=document.getElementById("importe").value ;
//   var sql="INSERT INTO GASTOS_T (ID_VALE,ID_CONCEPTO,ID_SUBOBRA,CANTIDAD ) VALUES ('"+id_vale+"','"+ id_concepto +"','"+ id_subobra +"','"+ cantidad +"' )"    ;   
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
      
    }
    }
     xhttp.open("GET", "../proveedores/albaran_anadir.php?id_vale="+id_vale+"&id_proveedor="+id_proveedor+"&id_obra="+id_obra+"&id_concepto="+id_concepto+"&cantidad=" 
                     +cantidad+"&concepto_nuevo="+concepto_nuevo+"&coste="+coste+"&importe="+importe, true);
     xhttp.send();   
    
    
    return ;
 }
 function ver_concepto() {
    
  var id_concepto=document.getElementById("id_concepto").value ;
  
  window.open('../proveedores/concepto_ficha.php?id_concepto='+id_concepto, '_blank');

    
    return ;
 }
    

</script>
             
                <!--</div>-->
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