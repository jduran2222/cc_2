<?php
// cambios
require_once("../include/session.php");
$where_c_coste = " id_c_coste={$_SESSION['id_c_coste']} ";
$id_c_coste = $_SESSION['id_c_coste'];

$titulo = 'Debug';

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






 //echo "<pre>";
 // print_r($rs);
 //echo "</pre>";


 (isset($_POST["reset_logs"])) ?  logs_reset() :'' ; 

logs(' Debug.php: Inicio ') ;

    
$filtro = isset($_POST["filtro"]) ? $_POST["filtro"] : '' ;



?>

    

<!--<div class="container-fluid">-->	
<div class="row">
<!--    <div class="col-sm-2">
        <img src="../img/construcloud128.jpg" >
        <a class="boton" title="" href="../menu/pagina_inicio.php" >Inicio</a>

    </div>
    -->
    
    <span class='badge progress-bar-danger'> PRUEBA DE BADGE</span>
  <div class="col-sm-12" style="background-color: lightblue">
    <form action="../configuracion/debug_ppal.php" method="post" id="form1" name="form1">
        <h1>STRING: <INPUT type="text" size='50' name="filtro" value="<?php echo $filtro ; ?>">
            <INPUT type="submit" class='btn btn-success btn-lg' value='Actualizar' id="submit" name="submit"></h1>
            <center> Reset logs <INPUT type="checkbox"  name="reset_logs" ></center>
    </form>
    </div>
    
</div>		
	
<div class="row">
    <h1>STRING: "<b><?php echo $filtro ?></b>"</h1> 
</DIV>   
<div class="row">    
<!--<div class="col-sm-2"></div>-->
<div class="col-sm-12">

<?php



//echo "<br>-----------------Encrypt------------------------------------------------------------";
//echo "</b><br>Encrypt:<b>". encrypt($filtro) ;
//echo "</b><br>Decrypt encrypt:<b>".  decrypt( encrypt($filtro) ) ;

echo "<br>----------------Encrypt2-------------------------------------------------------------";
echo "</b><br><br>Encrypt2:<b>". encrypt2($filtro) ;
//echo "</b><br>Decrypt2: <b>".  decrypt2( ($filtro) ) ;
echo "</b><br>Decrypt2 encrypt2:<b>".  decrypt2( encrypt2($filtro) ) ;
echo "<br>----------------cc_urlencode-------------------------------------------------------------";

echo "</b><br><br>cc_urlencode:<b>". cc_urlencode($filtro) ;
echo "</b><br>cc_urldecode cc_urlcode:<b>".  cc_urldecode( cc_urlencode($filtro) ) ;
echo "<br>----------------cc_password_hash-------------------------------------------------------------";

echo "</b><br><br>cc_password_hash:<b>  ". cc_password_hash($filtro) ;


echo "<br>--------------- FECHA HORA MODIFICACION encrypt.php  --------------------------------------------------------------";
echo "<b><br>". date ("d F Y H:i:s.", filemtime('encrypt.php') ) ;

echo "</b><br>--------------- GEO LOCALIZACION -------------------------------------------------";
//echo "<br>geoip_country_name_by_name()<b>". geoip_country_name_by_name($filtro)  ;
echo "<br>" ;
echo "<b>";


// set IP address and API access key
$ip = '161.185.160.93';
$access_key = '2cc3ac17c59e7be9495ada797e7ee53a';

// Initialize CURL:
$ch = curl_init('http://api.ipapi.com/'.$filtro.'?access_key='.$access_key.'');
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

// Store the data:
$json = curl_exec($ch);
curl_close($ch);

// Decode JSON response:
$api_result = json_decode($json, true);

// Output the "calling_code" object inside "location"

echo $api_result['location']['calling_code'];
echo $api_result['country_name'];

echo "<pre>" ;
echo print_r($api_result) ;
echo "</pre>" ;

echo "<br>--------------- S_SESSION_logs_  --------------------------------------------------------------";
echo "<b><br>".$_SESSION["logs"]  ;
echo "</b><br>" ;





$error_level=error_reporting();
error_reporting(0) ;

echo "</b<br>--------------- evalua_expresion --------------------------------------------------------------";
echo "><br>evalua_expresion:<b>". evalua_expresion($filtro) ;
//echo "</b><br>Decrypt: <b>".  decrypt( ($filtro) ) ;
//echo "</b><br>Decrypt encrypt:<b>".  decrypt( encrypt($filtro) ) ;

error_reporting($error_level) ;

?>    
   
 
    
    
</div>	
</div>
	
                </div>
                <!--****************** BUSQUEDA GLOBAL  *****************-->
            </div>
        </div>
        <!-- FIN Contenido principal -->

<?php 

//FIN
include_once('../templates/_inc_privado3_footer.php');