<?php
// cambios
require_once("../include/session.php");
$where_c_coste = " id_c_coste={$_SESSION['id_c_coste']} ";
$id_c_coste = $_SESSION['id_c_coste'];

$titulo_pagina="RVS " . Dfirst("NOMBRE_OBRA","OBRAS", "ID_OBRA={$_GET["id_obra"]} AND $where_c_coste"  ) ;
$titulo = $titulo_pagina;

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

$id_obra=$_GET["id_obra"];

require_once("../include/funciones_js.php");
require_once("../obras/obras_menutop_r.php");

  ?>			   	 
	   
<div id="main" class="mainc_100">
<br><br><br>
	
<h1>RELACIONES VALORADAS</h1>
<!--<div align=center class="mainc">PRODUCCIONES</div>-->

<a class="btn btn-link btn-lg" title="añadir una Relación Valorada nueva a la obra" href=# <?php echo "onclick=\"add_produccion($id_obra)\" " ;?> ><i class='fas fa-plus-circle'></i>  añadir Relación Valorada</a>

<script>
function add_produccion(id_obra) {
    var nuevo_valor=window.prompt("Título de la Rev. Valorada nueva: " );
//    alert("el nuevo valor es: "+valor) ;
   if (!(nuevo_valor === null || nuevo_valor === ""))
   { 
       
       var xhttp = new XMLHttpRequest();
     xhttp.onreadystatechange = function() {
    if (this.readyState == 4 && this.status == 200) {
        if (this.responseText.substr(0,5)=="ERROR")
        { alert(this.responseText) ;}
        else
        { // alert(this.responseText) ;     //debug
            location.reload(true); }  // refresco la pantalla con el n uevo caoítulo creado
      }
  };
  xhttp.open("GET", "../obras/add_produccion_ajax.php?id_obra="+id_obra+"&produccion="+nuevo_valor, true);
  xhttp.send();   
   }
   else
   {return;}
   
}

</script>

<table class='table table-bordered table-hover' width='80%' align="center">

 <tr bgcolor=PaleTurquoise>
  <td>nID_RV</td>
  <td>RELACION VALORADA</td>
  <td>Ejecucion Material</td>
  <td>Ej_Mat+GGBI-Baja </td>
  <td>Total IVA Incluido</td>
  <td>% contrato</td>
  <td>Gasto Estimado</td>
  <td>% margen</td>
  <td>Observaciones</td>
  <td>Acciones</td>
 </tr>



<?php 

// comprobamos si id_prod_estudio_coste está actualizado y en caso negativo lo actualizamos (hacemos un clon del Proyecto en la RV Estudio de Coste)
if (!cc_is_ESTUDIO_COSTE_actualizado($id_obra))  {  cc_actualiza_ESTUDIO_COSTE($id_obra); }



$result=$Conn->query($sql="SELECT * from prod_PEM_f_view WHERE ID_OBRA=$id_obra AND $where_c_coste ORDER BY PRODUCCION " );


while($rs = $result->fetch_array())
{

//  $rs["IMPORTE"]= $rs["IMPORTE"] ? $rs["IMPORTE"] : 1 ;  // si rs importe es CERO lo ponemos a 1 para evitar el error
          
  $id_produccion=$rs["ID_PRODUCCION"];
  $produccion=$rs["PRODUCCION"];

  if (!isset($rs["Ej_Material"]))
  {

    $Ej_Material="";
    $Valoracion="";
    $Val_iva_incluido="";
    $porc_iva_incluido="";
    $Gasto_est="";
    $margen="";
  }
    else
  {

    $Ej_Material=cc_format($rs["Ej_Material"],'moneda');
    $Valoracion=cc_format($rs["Valoracion"],'moneda');
    $Val_iva_incluido=cc_format($rs["Val_iva_incluido"],'moneda');
    $Gasto_est=cc_format($rs["Gasto_est"],'moneda');
//    $porc_iva_incluido=number_format($rs["Val_iva_incluido"]*100/$rs["IMPORTE"],2)."%";
    $porc_iva_incluido=  $rs["IMPORTE"] ?  cc_format($rs["Val_iva_incluido"]/$rs["IMPORTE"], 'porcentaje')  :  '' ;   // si rs_importe es CERO no ponemos nada (evitamos el error div. cero
    $margen=  $rs["Valoracion"] ?  cc_format(1-$rs["Gasto_est"]/$rs["Valoracion"], 'porcentaje')  :  '' ;   // si rs_importe es CERO no ponemos nada (evitamos el error div. cero
  } 


?>

   
 <tr>
   <td align=center><?php   echo $id_produccion;?></td>
    <td><a class="enlaceTabla" target="_blank" title="ver Mediciones y relación valorada de la Producción" 
         href= "obras_prod_detalle.php?_m=<?php echo $_m;?>&id_obra=<?php echo $id_obra;?>&id_produccion=<?php echo $id_produccion;?>" ><?php echo $produccion;?></a></td>
  <td align=right><?php   echo $Ej_Material;?></td>
  <td align=right><?php   echo $Valoracion;?></td>
  <td align=right><?php   echo $Val_iva_incluido;?></td>
  <td align=right><font size=1><?php   echo $porc_iva_incluido;?></font></td>
  <td align=right><?php   echo $Gasto_est;?></td>
  <td align=right><font size=1><?php   echo $margen;?></font></td>
  <td align=left><font size=1><?php   echo cc_format($rs["Observaciones"],'textarea_30');?></font></td>
  <td align=right>
      <!--<a class="btn btn-link btn-xs" href=#  <?php // echo "onclick=\"edit_prod($id_produccion,'$produccion')\" " ;?> >edit nombre</a>-->
      <a class="btn btn-link btn-xs" href=# title="Anexa a la relación Valorada el Proyecto completo multiplicado por un factor (0 para Proyecto VACIO y 1 para Proyecto Completo)" 
                                   <?php echo "onclick=\"add_proyecto($id_obra,$id_produccion)\" " ;?> >añadir proyecto</a>
      <a class="btn btn-link btn-xs" href=# title="Anexa a la relación Valorada otra Relación Valorada multiplicado por un factor (1 para sumar, -1 para restar)" 
                                   <?php echo "onclick=\"add_RV($id_obra,$id_produccion)\" " ;?> >añadir otra Rel.Valorada</a>
      <a class="btn btn-link btn-xs" title="Crea una copia idéntica de la Relación Valorada" href=#  <?php echo "onclick=\"copy_prod($id_obra,$id_produccion)\" " ;?> >duplicar Rel. Val.</a>
      <a class="btn btn-link btn-xs" target="_blank" href= "../obras/prod_ficha.php?_m=<?php echo $_m;?>&id_obra=<?php echo $id_obra;?>&id_produccion=<?php echo $id_produccion;?>" ><span class="glyphicon glyphicon-th-list"></span> Ficha</a>
      <!--<a class="btn btn-danger btn-xs" target="_blank" href= "../obras/obras_prod_delete.php?id_obra=<?php echo $id_obra;?>&id_produccion=<?php echo $id_produccion;?>" ><i class="far fa-trash-alt"></i> Borrar</a>-->
      <a class="btn btn-danger btn-xs" target="_blank" href=# 
           onclick="js_href( '../obras/obras_prod_delete.php?id_obra=<?php echo $id_obra;?>&id_produccion=<?php echo $id_produccion;?>' 
               ,'1','¿Borrar Relacion Valorada? \n <?php echo $produccion;?>' )">
                    <i class="far fa-trash-alt"></i> Borrar</a>
  
  </td>
 </tr>
 
<?php } ?>

</table>

<script>
//function js_href(href,reload=1, msg='') {
////    alert("el nuevo valor es: "+valor) ;
//
//if (msg)    // si hay mensaje confirmo
//{
//      if (confirm(msg))
//      {    
//       var xhttp = new XMLHttpRequest();
//       xhttp.onreadystatechange = function() {
//       if (this.readyState == 4 && this.status == 200) {
//            if (this.responseText.substr(0,5)=="ERROR")
//            { alert(this.responseText) ;}
//            else
//            {  //alert(this.responseText) ;     //debug
//               if(reload){ location.reload(true);}       // si hay reload, refresco pantalla
//             }  // refresco la pantalla tras editar Producción
//       }
//      };
//      xhttp.open("GET", href, true);
//      xhttp.send();   
//      } 
//}
//}    

function edit_prod(id_produccion,produccion) {
    var nuevo_valor=window.prompt("Producción ", produccion );
//    alert("el nuevo valor es: "+valor) ;
   if (!(nuevo_valor === null || nuevo_valor === ""))
   { 
       
       var xhttp = new XMLHttpRequest();
     xhttp.onreadystatechange = function() {
    if (this.readyState == 4 && this.status == 200) {
        if (this.responseText.substr(0,5)=="ERROR")
        { alert(this.responseText) ;}
        else
        {  //alert(this.responseText) ;     //debug
            location.reload(true); }  // refresco la pantalla tras editar Producción
      }
  };
  xhttp.open("GET", "../include/update_ajax.php?tabla=PRODUCCIONES&wherecond=ID_PRODUCCION="+id_produccion+"&field=PRODUCCION&nuevo_valor="+nuevo_valor, true);
  xhttp.send();   
   }
   else
   {return;}
   
}
function add_proyecto(id_obra,id_produccion) {
    var d = new Date();
    var f=d.getFullYear() + "-" + (d.getMonth()+1) + "-" + d.getDate() ;
    var nuevo_valor=window.prompt("Va a añadir el Proyecto completo a la producción con fecha: ", f );
      if (!(nuevo_valor === null || nuevo_valor === ""))
   { 
      var factor=window.prompt("FACTOR de multiplicación (Ej. 0=vacío , 1=Proyecto completo): ", 1 ); 
       var xhttp = new XMLHttpRequest();
     xhttp.onreadystatechange = function() {
    if (this.readyState == 4 && this.status == 200) {
        if (this.responseText.substr(0,5)=="ERROR")
        { alert(this.responseText) ;}
        else
        {  //alert(this.responseText) ;     //debug
            location.reload(true); }  // refresco la pantalla tras editar Producción
      }
  };
  xhttp.open("GET", "../obras/prod_add_proy_ajaax.php?id_obra="+id_obra+"&id_produccion="+id_produccion+"&fecha="+nuevo_valor+"&factor="+factor, true);
  xhttp.send();   
   }
   else
   {return;}
    
    //alert("el nuevo valor es: "+ fecha) ;
   
   
   
   
}

function add_RV(id_obra,id_produccion) {
//    var d = new Date();
//    var f=d.getFullYear() + "-" + (d.getMonth()+1) + "-" + d.getDate() ;
    var id_rv=window.prompt("Indicar el nID_RV de la Relación Valorada a añadir : " );
      if (!(id_rv === null || id_rv === ""))
   { 
      var factor=window.prompt("FACTOR de multiplicación (Ej. 1=suma , -1=resta): ", 1 ); 
       var xhttp = new XMLHttpRequest();
     xhttp.onreadystatechange = function() {
    if (this.readyState == 4 && this.status == 200) {
        if (this.responseText.substr(0,5)=="ERROR")
        { alert(this.responseText) ;}
        else
        {  //alert(this.responseText) ;     //debug
            location.reload(true); }  // refresco la pantalla tras editar Producción
      }
  };
  xhttp.open("GET", "../obras/prod_add_RV_ajax.php?id_obra="+id_obra+"&id_produccion="+id_produccion+"&id_produccion_a_sumar="+id_rv+"&factor="+factor, true);
  xhttp.send();   
   }
   else
   {return;}
    
    //alert("el nuevo valor es: "+ fecha) ;
   
   
   
   
}

function copy_prod(id_obra,id_produccion) {
//    var d = new Date();
//    var f=d.getFullYear() + "-" + (d.getMonth()+1) + "-" + d.getDate() ;
//    var nuevo_valor=window.prompt("Va a añadir el Proyecto completo a la producción con fecha: ", f );
     
    
       
       var xhttp = new XMLHttpRequest();
     xhttp.onreadystatechange = function() {
    if (this.readyState == 4 && this.status == 200) {
        if (this.responseText.substr(0,5)=="ERROR")
        { alert(this.responseText) ;}
        else
        {  //alert(this.responseText) ;     //debug
            location.reload(true); }  // refresco la pantalla tras editar Producción
      }
  };
  xhttp.open("GET", "../obras/prod_copy_ajax.php?id_obra="+id_obra+"&id_produccion="+id_produccion, true);
  xhttp.send();   
    
    //alert("el nuevo valor es: "+ fecha) ;
   
   
   
   
}

    


</script>


<?php 

$Conn->close();


?>
</div>
                </div>
     <br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br>
  <br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br>

                <!--****************** BUSQUEDA GLOBAL  *****************
            </div>
        </div>
        <!-- FIN Contenido principal -->

<?php 

//FIN
include_once('../templates/_inc_privado3_footer.php');