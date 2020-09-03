<?php
// cambios
require_once("../include/session.php");
$where_c_coste = " id_c_coste={$_SESSION['id_c_coste']} ";
$id_c_coste = $_SESSION['id_c_coste'];

$titulo = 'Clave';

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

	
<!-- recibo el parametro -->
<?php 
 //require("../proveedores/proveedores_menutop_r.php");


$tabla="Claves";                 // TABLA DONDE COGER EL REGISTRO-FICHA
$id_update="id_clave" ;        // campo index primary (clave) a utilizar en la búsqueda


// decidimos si abrimos la fecha o previamente, creamos la nueva clave en la base de datos
if (isset($_GET["id_clave"]))
{
    $id_valor=$_GET["id_clave"];          // valor de la clave a buscar
    
}elseif (isset($_GET["clave"]) AND isset($_GET["script_name"])) {   // no hay ID_CLAVE, buscamos clave heredada y si no hay la creamos
    // busco claves HEREDADAS
    if (!($id_valor =  Dfirst( "id_clave" , "Claves", "clave='{$_GET["clave"]}'  AND script_name='{$_GET["script_name"]}'   "))) 
    {
        // Creo la CLAVE
        $_GET["formato"]=trim($_GET["formato"]);  // por si viene con unn unico espacio para evitar error en el GET, lo pongo vacio
        DInsert_into("Claves", "(clave, script_name, etiqueta, tooltip,formato, user)", 
          "( '{$_GET["clave"]}' , '{$_GET["script_name"]}', '{$_GET["etiqueta"]}'  , '{$_GET["tooltip"]}', '{$_GET["formato"]}' , '{$_SESSION["user"]}'  )" ) ;
                
        $id_valor =  Dfirst( "MAX(id_clave)" , "Claves", "clave='{$_GET["clave"]}'  AND script_name='{$_GET["script_name"]}' ") ;
    }
}



$where= "`$id_update`=$id_valor" ;                // creo el where para la búsqueda del registro `ID_OBRA`=464

 
 
//$result=$Conn->query("SELECT * FROM $tabla WHERE $where AND $where_c_coste");

$sql="SELECT * FROM $tabla WHERE $where " ;
echo $sql ;
$result=$Conn->query($sql);                      // esta búsqueda tiene poca seguridad nececita confirmar lel id_c_coste
$rs = $result->fetch_array(MYSQLI_ASSOC) ;
	
 $titulo="$tabla" ;
  //$updates=['NOMBRE_OBRA','NOMBRE_COMPLETO','GRUPOS','EXPEDIENTE', 'NOMBRE' ,'Nombre Completo', 'LUGAR', 'PROVINCIA', 'Presupuesto Tipo', 'Plazo Proyecto' ,'Observaciones']  ;
 
// si está definido $no_update es que queremos editar los campos, en caso contrario no editamos nada 
$updates=[] ;
$tabla_update=$tabla ; 


// $updates= $admin? ["*"] : ["etiqueta","tooltip","wiki","tipo_dato","formato"] ; // los admin pueden editar todo
 $updates=  ["*"] ; // los admin pueden editar todo
 $no_updates =["clave","script_name"] ;
 $ocultos = ["columna_tabla","ocultar_en_ficha","ocultar_en_tabla"] ;
  //$selects["ID_CLIENTE"]=["ID_CLIENTE","CLIENTE","Clientes"] ;   // datos para clave foránea
  //$id_obra=$rs["ID_PROVEEDORES"] ;

  $id_update=$id_update;
  $id_valor=$id_valor ;
  $delete_boton=1;
  
  $formats["tooltip"]='text_edit';
  $formats["en_linea"]='boolean';

    
  
  
  ?>
  
                  
                    
  <div style="overflow:visible">	   
  <div id="main" class="mainc_100"> 
      
  <?PHP require("../include/ficha.php"); ?>
   
      <!--// FIN     **********    FICHA.PHP-->
 </div>

	
<?php  

// TABLA CLAVES PRIMAS

$sql="SELECT * FROM Claves "
        . "  WHERE clave='{$rs["clave"]}' AND id_clave<>{$rs["id_clave"]} ; ";
//$sql="SELECT * FROM GASTOS_T  WHERE ID_VALE=$id_vale   ";
//echo $sql;
$result=$Conn->query($sql );


//$formats["FECHA"]='fecha';
//$formats["importe"]='moneda';
////$formats["pdf"]='pdf_50';

$formats["tooltip"]='text_edit';

$updates=["etiqueta","tooltip","wiki","tipo_dato"] ;


$links["clave"] = ["../configuracion/clave_ficha.php?id_clave=", "id_clave", "ver Clave", "formato_sub"] ;
//$links["NOMBRE_OBRA"]=["../obras/obras_ficha.php?id_obra=", "ID_OBRA"] ;

//$aligns["importe"] = "right" ;
//$aligns["Pdte_conciliar"] = "right" ;
//$aligns["Importe_ejecutado"] = "right" ; 

//$tooltips["conc"] = "Factura conciliada. Los Vales (albaranes de proveedor) suman el importe de la factura" ;

//$titulo="<a href=\"proveedores_documentos.php?id_proveedor=$id_proveedor\">Documentos (ver todos...)</a> " ;
//$num_vales=Dfirst("COUNT(ID_VALE)","VALES", "ID_FRA_PROV=$id_fra_prov") ;
$num_vales= $result->num_rows;


$titulo="CLAVES PRIMAS ($num_vales )" ; 

$msg_tabla_vacia="";
$tabla_update="Claves" ;
$id_update="id_clave" ;

if ($num_vales>0)
{
   echo "<div class='mainc_100' >" ; 
   require("../include/tabla.php"); echo $TABLE ; //  VALES 
   echo "</div>" ; 

   
}


$Conn->close();

?>
	 

</div>
  <br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br>
  <br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br>
  <br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br>

                <!--</div>-->
                <!--****************** BUSQUEDA GLOBAL  *****************
            </div>
        </div>
        <!-- FIN Contenido principal -->

<?php 

//FIN
include_once('../templates/_inc_privado3_footer.php');