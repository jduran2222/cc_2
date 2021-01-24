 <!--HACEMOS EL REGISTRO DE SECSSION MAS ABAJO SEGUN QUERAMOS O NO-->
 
 
        <!-- Contenido principal 
        <div class="container-fluid bg-light">
            <div class="row">
                <!--****************** ESPACIO LATERAL  *****************
                <div class="col-12 col-md-4 col-lg-3"></div>
                <!--****************** ESPACIO LATERAL  *****************

                <!--****************** BUSQUEDA GLOBAL  *****************
                <!--<div class="col-12 col-md-4 col-lg-9">-->
 



<?php 
     
require_once("../../conexion.php");
require_once("../include/funciones.php");


//echo '<pre>';
//print_r($_GET);
//echo '</pre>';

$sin_inicio_session=0;
if (isset($_GET['url_enc']))         // Si venimos ENCRYPTADOS, desencriptamos, juntamos las dos url y metemos en GET las variables
{    
    $url_dec=decrypt2($_GET['url_enc']) ;
    $url_raw= isset($_GET['url_raw']) ? rawurldecode(($_GET['url_raw'])) : ""  ;

    parse_str( $url_dec.$url_raw , $_GET ) ;
    $sin_inicio_session= isset($_GET['sin_inicio_session']) ;   // ejecutamos el PHP sin INICIAR SESSION
}

if (!$sin_inicio_session)
{
    require_once("../include/session.php");
    $where_c_coste = " id_c_coste={$_SESSION['id_c_coste']} ";
    $id_c_coste = $_SESSION['id_c_coste'];

    $titulo = 'Tabla General';

    //INICIO
    include_once('../templates/_inc_privado1_header.php');
    include_once('../templates/_inc_privado2_navbar.php');

} else {
   
    include_once('../templates/_inc_registro1_header.php');
    
}   



$link= ''; 

if (isset($_GET["sql"]))
{
    $sql=$_GET["sql"];
    
}else
{    
    
$tabla=  is_encrypt2($_GET["tabla"]) ?  decrypt2($_GET["tabla"])  :  $_GET["tabla"] ;
$where=  is_encrypt2($_GET["where"]) ?  decrypt2($_GET["where"])  :  $_GET["where"] ;
//$where=$_GET["where"]  ;

$select= isset($_GET["select"])? ( is_encrypt2($_GET["select"]) ?  decrypt2($_GET["select"])  :  $_GET["select"] ) : "*" ;
$order_by= isset($_GET["order_by"])? (is_encrypt2($_GET["order_by"]) ?  " ORDER BY ".decrypt2($_GET["order_by"])  :  " ORDER BY ".$_GET["order_by"]): "" ;
$limit= isset($_GET["limit"])? ( is_encrypt2($_GET["limit"]) ? " LIMIT ". decrypt2($_GET["limit"])  : " LIMIT ". $_GET["limit"]) : "" ;


$sql="SELECT $select FROM $tabla WHERE  $where  $order_by $limit  " ;

}


$link= isset($_GET["link"])? ( is_encrypt2($_GET["link"]) ?  decrypt2($_GET["link"])  :  $_GET["link"] )  :  "" ;
$campo_id=  isset($_GET["campo_id"])? ( is_encrypt2($_GET["campo_id"]) ?  decrypt2($_GET["campo_id"])  :  $_GET["campo_id"] ) : "" ;
$campo=  isset($_GET["campo"])? ( is_encrypt2($_GET["campo"]) ?  decrypt2($_GET["campo"])  :  $_GET["campo"]) : "" ;


//if ($admin)
//{    
//echo $sql ;
//echo '<pre>';
//print_r($_GET);
//echo '</pre>';
//}

$titulo= isset($_GET["titulo"])? $_GET["titulo"] : ( isset($tabla) ? "$tabla" : "$titulo") ;
$titulo="<h1>$titulo</h1>";

//if ($admin)  {echo "<span class='c_text'>solo admin: $sql </span> "; } ;
//logs("Tabla general: $sql") ; 
$result=$Conn->query($sql) ;
//$result_T=$Conn->query($sql_T) ;

// AÑADE BOTON DE 'BORRAR' PARTE . SOLO BORRARÁ SI ESTÁ VACÍO DE PERSONAL 
// $updates=[]  ;
//  $tabla_update="PERSONAL" ;
//  $id_update="ID_PERSONAL" ;
//    $actions_row=[];
//    $actions_row["id"]="ID_PERSONAL";
//    $actions_row["delete_link"]="1";
//    
//    

if ($link)  
{   
   $links[$campo] = [str_replace("__AND__", "&", $link ), $campo_id,'', 'formato_sub'] ;  // cambiamos __AND__ por su simbolo & para compatibilizar con ficha_general
}

$scroll='';

//$titulo="$tabla <BR> $where";

$msg_tabla_vacia="No hay.";
?>
<div style="overflow:visible">	   
   
  <div id="main" class="mainc_100" style="background-color:#fff">
    <br><br><br><br>

<?php

    echo $sin_inicio_session?  boton_cerrar()
                               :"";

    if ($admin)  {echo "<span class='c_text'>solo admin: $sql </span> "; } ;

    require("../include/tabla.php"); echo $TABLE ;

?>

</div>

<!--************ FIN MOV. BANCO *************  -->
	
	

<?php  

$Conn->close();

?>
	 

</div>

	
                </div>
                <!--****************** BUSQUEDA GLOBAL  *****************
            </div>
        </div>
        <!-- FIN Contenido principal -->

<?php 

//FIN

if (!$sin_inicio_session)
{
   include_once('../templates/_inc_privado3_footer.php');

} else {
   
   echo boton_cerrar();
                               
 
   include_once('../templates/_inc_registro3_footer.php');
}   




