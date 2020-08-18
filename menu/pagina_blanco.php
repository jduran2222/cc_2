<?php
// cambios
require_once("../include/session.php");
$where_c_coste = " id_c_coste={$_SESSION['id_c_coste']} ";
$id_c_coste = $_SESSION['id_c_coste'];
//$_m='Inicio' ;

// $titulo_pagina=$_SESSION["empresa"]." - ConstruCloud.es4";
$titulo_pagina=$_SESSION["empresa"];

$titulo = $titulo_pagina;

//INICIO
include_once('../templates/_inc_privado1_header.php');
include_once('../templates/_inc_privado2_navbar.php');



//CONTENIDO
//...

echo '<noscript>
    Para utilizar las funcionalidades completas de este sitio es necesario tener JavaScript habilitado. 
    Aquí están las <a href="https://www.enable-javascript.com/es/">instrucciones para habilitar JavaScript en tu navegador web</a>.
</noscript>';

$dir_raiz = "../";   
$id_cta_banco_LRU = Dfirst("id_cta_banco", "MOV_BANCOS_View", $where_c_coste, "id_mov_banco DESC");      

$link_comprar_licencia = "<br><a class=\"btn btn-info btn-xs text-uppercase\" href='../configuracion/comprar_licencia.php'>Comprar aquí</a>";

// // ANULACION SISTEMA LICENCIAS  relenamos artificialmente los limites para evitar el sistema de licencias
$limites['usuarios'] = 99;
$limites['obras'] = 99;
$limites['proveedores'] = 99;
$limites['clientes'] = 99;
$limites['empleados'] = 99;
$limites['espacio_disco'] = 99;

//$sql = "SELECT * FROM Licencias WHERE not_free AND fecha_contrato<=CURRENT_DATE() AND fecha_caducidad>=CURRENT_DATE() AND $where_c_coste ORDER BY lim_usuarios DESC";
$sql = "SELECT * FROM Licencias WHERE fecha_contrato<=CURRENT_DATE() AND fecha_caducidad>=CURRENT_DATE() AND $where_c_coste ORDER BY lim_usuarios DESC";
//echo $sql ;
$result=$Conn->query($sql);        // ANULACION SISTEMA LICENCIAS
//echo "RESULTADOS LICENCIAS: ". $result->num_rows ;   //debug
 if ($result->num_rows > 0)        // ANULACION SISTEMA LICENCIAS
//        if (0)                              // ANULACION SISTEMA LICENCIAS
        {
            $rs = $result->fetch_array(MYSQLI_ASSOC);    // cojo la de mayor usuarios permitidos 
            $licencia_actual = $rs["licencia"];
            $fecha_caducidad = $rs["fecha_caducidad"];
            $dias = (int) ((strtotime($fecha_caducidad) - strtotime("now")) / 86400);
            $aviso_plazo = ($dias < 30) ? "¡¡ATENCION!! " : "";
            $limites = [];                      // declaramos o vaciamos el array 
            foreach ($rs as $key => $value)
            {
                if (substr($key, 0, 4) == "lim_")                //pasamos los límites de cada entidad de la licencia al array $limites que irá a $_SESSION
                {
                    $limites[substr($key, 4)] = $value;
                }
            }
            $_SESSION["limites"] = $limites;
            $_SESSION["is_licencia_free"] = 0;
            $_SESSION["id_licencia"] = $rs["id_licencia"];
            
//            $msg_licencia = "Licencia actual: <b>$licencia_actual</b> <br>Válida hasta: <b>$fecha_caducidad</b> <br>$aviso_plazo Quedan <b>$dias</b> días de uso. Amplíe el plazo $link_comprar_licencia";
            $msg_licencia = "Licencia <b>$licencia_actual</b> ";
//            $msg_licencia = "Licencia actual: <b>$licencia_actual</b> Quedan <b>$dias</b> días de uso. Amplíe $link_comprar_licencia";  // ANULADO PROVISIONALMENTE HASTA TERMINAR SMODULO LICENCIAS
        }
 else           // ANULACION SISTEMA LICENCIAS
//        elseif (0)        // ANULACION SISTEMA LICENCIAS
        {

            // $result = $Conn->query("SELECT * FROM Licencias WHERE not_free=0 AND fecha_contrato<=CURRENT_DATE() AND fecha_caducidad>=CURRENT_DATE() AND $where_c_coste ORDER BY fecha_contrato DESC");
            $result = $Conn->query("SELECT * FROM Licencias WHERE not_free=0 AND fecha_contrato<=CURRENT_DATE() AND fecha_caducidad>=CURRENT_DATE() ORDER BY fecha_contrato DESC");
            $rs = array(); // cojo la última licencia FREE
            if( ($rs = $result->fetch_array(MYSQLI_ASSOC)) ){
                //para comprobar si hay elementos, si no listado vacío
            }
            if ($result->num_rows > 0)
            {
                $limites = [];                      // declaramos o vaciamos el array 
                foreach ($rs as $key => $value)
                {
                    if (substr($key, 0, 4) == "lim_")                //pasamos los límites de cada entidad de la licencia al array $limites que irá a $_SESSION
                    {
                        $limites[substr($key, 4)] = $value;
                    }
                }
                $_SESSION["limites"] = $limites;
                $_SESSION["is_licencia_free"] = 1;
                $_SESSION["id_licencia"] = $rs["id_licencia"];

                $precio_XS = Dfirst("precio", "tipos_licencia", "tipo_licencia='XS'");
                $msg_licencia = "Licencia actual: FREE <br>Aumente a Licencia XS por solo $precio_XS euros al mes $link_comprar_licencia";
            } else
            {
                $msg_licencia = "ATENCIÓN, no dispone de licencias actualmente, compre una nueva licencia o registre una licencia FREE $link_comprar_licencia";
            }
        }

 

if ($_SESSION["is_desarrollo"]) { 
    $htmlDesarrollo = "<br><br><br><br><br><a class=\"btn btn-xs btn-link noprint\"  href=\"#\"  onclick=\"tour()\"  title=\"Tour pruebas\" >Tour (pruebas5)</a>";
}       
?>

 <div class="content-wrapper">
 
PAGINA EN BLANCO 0123456789 - QWERTYUIOPASDFGHJKLÑZXCVBNM

 </div>

<?php 

//FIN
include_once('../templates/_inc_privado3_footer.php');
