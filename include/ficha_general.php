<?php
// cambios
require_once("../include/session.php");
$where_c_coste = " id_c_coste={$_SESSION['id_c_coste']} ";
$id_c_coste = $_SESSION['id_c_coste'];

$titulo = 'Configuración General';

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
 
 // primero cogemos el id_valor si no viene encriptado
if (isset($_GET["id_valor"]))  
    { $id_valor=$_GET["id_valor"];          // valor de la clave a buscar
      $valor_encriptado=False ;
    }else
    {
    $valor_encriptado=True ;     // id_valor viene dentro del encriptado

    }    

// si el url está encriptado lo desencriptamos y rellenamos de nuevo el $_GET[]
if (isset($_GET['url_enc']))         // venimos ENCRYPTADOS, desencriptamos, juntamos las dos url y metemos en GET las variables
{    
    $url_dec=decrypt2($_GET['url_enc']) ;
    $url_raw= isset($_GET['url_raw']) ? rawurldecode(($_GET['url_raw'])) : ""  ;

    parse_str( $url_dec.$url_raw , $_GET ) ;
    
    if ($valor_encriptado) {$id_valor=$_GET["id_valor"]; }        // si id_valor viene dentro del encriptado lo asignamos 
}


$tabla=$_GET["tabla"];                 // TABLA DONDE COGER EL REGISTRO-FICHA
$id_update=isset($_GET["id_update"])? $_GET["id_update"] : "" ;        // campo para hacer los update de la ficha
$no_update=isset($_GET["no_update"])? $_GET["no_update"] : "" ;        // hace que la ficha sea NO_UPDATE, no actualizable


$where= "`$id_update`=$id_valor" ;                // creo el where para la búsqueda del registro `ID_OBRA`=464

$sql="SELECT * FROM $tabla WHERE $where " ;
//echo $sql ;
$result=$Conn->query($sql);                      // esta búsqueda tiene poca seguridad nececita confirmar lel id_c_coste
$rs = $result->fetch_array(MYSQLI_ASSOC) ;
	
 $titulo= substr( preg_replace('/View/i', '',  str_replace('_', ' ', $tabla) ) , 0, -1); // quitamos las extension View, las _ y la ultima letra previsiblemente una S

// si está definido $no_update es que queremos editar los campos, en caso contrario no editamos nada 
$updates=[] ;
$tabla_update=$tabla ; 

if (!$no_update)         
{
 $updates=["*"] ;
  //$selects["ID_CLIENTE"]=["ID_CLIENTE","CLIENTE","Clientes"] ;   // datos para clave foránea
  //$id_obra=$rs["ID_PROVEEDORES"] ;

  $id_update=$id_update;
  $id_valor=$id_valor ;
  $delete_boton=1;
}   
  
    
  
                  
	   
echo "  <div id='main' class='mainc_100'> ";
      
require("../include/ficha.php");

echo " </div> " ;

?>

	
<?php  

$Conn->close();

?>
	 

</div>

                </div>
                <!--****************** BUSQUEDA GLOBAL  *****************-->
            </div>
        </div>
        <!-- FIN Contenido principal -->

<?php 

//FIN
include_once('../templates/_inc_privado3_footer.php');

