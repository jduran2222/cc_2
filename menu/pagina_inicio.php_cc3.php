
<?php
require_once("../include/session.php");
$where_c_coste = " id_c_coste={$_SESSION['id_c_coste']} ";
$id_c_coste = $_SESSION['id_c_coste'];
//$_m='Inicio' ;

$titulo_pagina=$_SESSION["empresa"]." - ConstruCloud.es4";


?>
<style>

    
    .div_ppal_expand
    {
        width:90%;
        float:left;
        border:3px solid white;
    }
    .div_boton_expand
    {
        width:10%;
        float:left;
        border:3px solid white;
    }


</style>
<script>

function dfirst_ajax(id,field,tabla,wherecond)
{
 var xhttp = new XMLHttpRequest();
 xhttp.onreadystatechange = function() {
    if (this.readyState == 4 && this.status == 200) {
        if (this.responseText!="0"){$(id).text(this.responseText);}      // si el resultado es distinto de CERO, rellenamos el badget
      }
  };
  xhttp.open("GET", "../include/dfirst_ajax.php?field="+field+"&tabla="+tabla+"&wherecond="+wherecond+"", true);       //hacemos la consulta ajax
  xhttp.send();   
 }



function tour()
{
alert("prueba3"); 
  // Instance the tour
var tour = new Tour({
  steps: [
  {
    element: "#filtro",
    title: "Construcloud.es prueba Tour",
    content: "Aquí podemos buscar cualquier entidad: Obras, Proveedor, Persoanl..."
  },
  {
    element: "#buscar",
    title: "Construcloud.es prueba Tour",
    content: "Pulsar botón para proceder a la búsqueda"
  }
]});

// Initialize the tour
tour.init();

// Start the tour
tour.start();  
    
 }

</script>
         

<HTML>
    <HEAD>
        <META NAME="GENERATOR" Content="Microsoft FrontPage 5.0">
         <title><?php echo $titulo_pagina; ?></title> 

        <link rel='shortcut icon' type='image/x-icon' href='/favicon.ico' />
        

        <!--ANULADO 16JUNIO20<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">-->
        <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.6.3/css/all.css" integrity="sha384-UHRtZLI+pbxtHCWp1t77Bi1L4ZtiqrqD80Kn4Z8NTSRyMA2Fd33n5dQ8lWUE00s/" crossorigin="anonymous">

        <link href="../css/estilos.css<?php echo (isset($_SESSION["is_desarrollo"]) AND $_SESSION["is_desarrollo"])? "?d=".date("ts") : "" ; ?>" rel=stylesheet type="text/css" hreflang="es">

        <!--<link rel="stylesheet" href="../css/icons.css" type="text/css" />-->

        <!--#BOOTSTRAP_TOUR-->
        <!--<link href="bootstrap.min.css" rel="stylesheet">-->
        <!--<link href="../bootstrap_tour/src/docs/assets/vendor/bootstrap.min.css" rel="stylesheet" type="text/css"/>-->
        
         <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
         
         
         <!--ANULADO 16JUNIO20<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>-->
    
        <!--<script src="../bootstrap_tour/src/docs/assets/vendor/bootstrap.min.js" type="text/javascript"></script>-->
         <!--<link href="../bootstrap_tour/build/css/bootstrap-tour.min.css" rel="stylesheet" type="text/css"/>-->
       <!--<script src="../bootstrap_tour/build/js/bootstrap-tour.min.js" type="text/javascript"></script>-->
<!--         <link href="../bootstrap_tour/build/css/bootstrap-tour-standalone.min.css" rel="stylesheet" type="text/css"/>
         <script src="../bootstrap_tour/build/js/bootstrap-tour-standalone.min.js" type="text/javascript"></script>-->
       
        <!--FIN BOOTSTRAP_TOUR-->
        
        
        
        
     
        
        

    </HEAD>

<!--<body onload="setInterval('location.reload()',900000)">    ANULAMOS EL REFRESCO DE PANTALLA CADA 15 MINUTOS, por ajax refrescaremos los indices cada varios minutos, junio20   --> 
<body > 
<!--    <noscript>
<body >   -->
<noscript>
Para utilizar las funcionalidades completas de este sitio es necesario tener
JavaScript habilitado. Aquí están las <a href="https://www.enable-javascript.com/es/">
    instrucciones para habilitar JavaScript en tu navegador web</a>.
</noscript>


   
        

<?php
ini_set('memory_limit', '256M'); 


require_once("../menu/topbar.php"); 
 

// ACTUALIZACION DE PASWORD A NUEVO OPENSSL_ENCRYPT()
//
//$result=$Conn->query($sql="SELECT * FROM Usuarios WHERE password_free IS NOT NULL ") ;
//while($rst = $result->fetch_array(MYSQLI_ASSOC))               // 
//{
// $new_password_hash= cc_password_hash($rst["password_free"]) ;
// $sql_UPDATE="UPDATE `Usuarios` SET `password_hash` = '$new_password_hash' WHERE id_usuario='{$rst["id_usuario"]}' "  ;
// $result_UPDATE=$Conn->query($sql_UPDATE );
// echo $rst["usuario"] . ' cambiado<br>' ;
//}


// FIN ACTUALIZACIÓN







//require_once("../../conexion.php");
//require_once("../include/funciones.php");
// 


//echo "variable33:" . $nnnn222 ;

//require_once("../menu/topbar.php");
//if ($admin) {require_once("../menu/menu_sidenav2.php");}    // menu lateral solo para pruebas (admin)// anulamos por incorporaacion adminLTE, juand, junio2020
// set_error_handler('logs_system_error') ;
//
// if ($admin) {  trigger_error("Error trigger. entró Admin");}
// 
//        $dir_raiz = $_SESSION["dir_raiz"];

$dir_raiz = "../";   
 
         
//        echo "variable33:" . $nnnn222 ; 

//        logs(logs_db('prueba de error'));

//$id_proveedor= getVar('id_proveedor_auto');
// nos llevamos el cálculo de variamos de situacion a TOPBAR
//$num_proveedores=Dfirst("count(id_proveedores)","Proveedores", $where_c_coste	) ;
//$num_clientes=Dfirst("count(id_cliente)","Clientes", $where_c_coste	) ;
//$num_obras=Dfirst("count(id_obra)","OBRAS", " tipo_subcentro='O' AND $where_c_coste"	) ;
//$num_estudios=Dfirst("count(id_estudio)","Estudios_de_Obra", $where_c_coste	) ;
//$num_maquinaria=Dfirst("count(id_obra)","OBRAS", " tipo_subcentro='M' AND $where_c_coste"	) ;
//$num_usuarios=Dfirst("count(id_usuario)","Usuarios", $where_c_coste 	) ;
//$num_empleados=Dfirst("count(id_personal)","PERSONAL", $where_c_coste 	) ;
//$num_documentos=Dfirst("count(id_documento)","Documentos", $where_c_coste	) ;
//$num_documentos_pdte_clasif=Dfirst("count(id_documento)","Documentos", "tipo_entidad='pdte_clasif' AND $where_c_coste"	) ;
//$num_conceptos=Dfirst("count(id_concepto)","CONCEPTOS", "id_proveedor=" . getvar("id_proveedor_auto")) ;
//$num_fras_prov=Dfirst("count(ID_FRA_PROV)","Fras_Prov_View", "$where_c_coste"	) ;
//$num_fras_cli=Dfirst("count(ID_FRA)","Fras_Cli_Listado", $where_c_coste	) ;
//$num_remesa_pagos=Dfirst("count(id_remesa)","Remesas_listado", $where_c_coste ." AND activa=1 AND tipo_remesa='P'"	) ;
//$num_remesa_cobros=Dfirst("count(id_remesa)","Remesas_listado", $where_c_coste ." AND activa=1 AND tipo_remesa='C'"	) ;
//$num_ctas_bancos=Dfirst("count(id_cta_banco)","ctas_bancos", $where_c_coste 	) ;
//
//$num_avales_pdtes=Dfirst('count(ID_AVAL)','Avales',"$where_c_coste AND F_Recogida <= NOW() AND Recogido=0 AND Solicitado=0 ") ;
//$num_documentos_pdte_clasif = Dfirst("count(id_documento)", "Documentos", "tipo_entidad='pdte_clasif' AND $where_c_coste");
//$num_fras_prov_NR = Dfirst("count(ID_FRA_PROV)", "Fras_Prov_Listado", "ID_PROVEEDORES=$id_proveedor_auto AND $where_c_coste");
//$num_procedimientos = Dfirst("count(id_procedimiento)", "Procedimientos", " $where_c_coste AND Obsoleto=0 " );
//
//$fecha_inicio=date('Y-01-01') ;

//
//$num_proveedores = 0;
//$num_clientes = 0;
//$num_obras = 0;
//$num_estudios = 0;
//$num_maquinaria = 0;
//$num_usuarios = 0;
//$num_empleados = 0;
//$num_documentos = 0;
//$num_conceptos = 0;
//$num_fras_prov = 0;

//$num_fras_prov_NR=Dfirst("count(ID_FRA_PROV)","Fras_Prov_View", "ID_PROVEEDORES=" . getvar("id_proveedor_auto"). " AND N_FRA='num_factura' AND YEAR(fecha_creacion)>=2017 AND  $where_c_coste"	) ;
//        $num_fras_prov_NR = Dfirst("count(ID_FRA_PROV)", "Fras_Prov_Listado", "ID_PROVEEDORES=$id_proveedor_auto AND FECHA>='2017-01-01' AND  $where_c_coste");
 
//debug
//$id_proveedor_auto = getvar("id_proveedor_auto");
//      //fras NO REGISTRADAS  

//        $num_fras_prov_NC = Dfirst("count(ID_FRA_PROV)", "Fras_Prov_View", "conc=0  AND  $where_c_coste");         //sustituido por Dfirst_ajax

//        $num_fras_prov_NP = Dfirst("count(ID_FRA_PROV)", "Fras_Prov_View", "pagada=0  AND  $where_c_coste");        //sustituido por Dfirst_ajax


//$num_fras_cli = 0;

$id_cta_banco_LRU = Dfirst("id_cta_banco", "MOV_BANCOS_View", $where_c_coste, "id_mov_banco DESC");      

//$tareas = Dfirst("count(id)", "Tareas_View", "$where_c_coste AND Terminada=0 AND usuarios LIKE '%{$_SESSION["user"]}%' " );
//$portafirmas = Dfirst("count(id_firma)", "Firmas_View", " $where_c_coste AND pdte AND id_usuario={$_SESSION["id_usuario"]} " );


//$fecha_tareas_vistas=Dfirst("fecha_tareas_vistas","Usuarios_View"," $where_c_coste AND id_usuario={$_SESSION["id_usuario"]} " ) ;

//$tareas_new = Dfirst("count(id)", "Tareas_View", "$where_c_coste AND Terminada=0 AND usuarios LIKE '%{$_SESSION["user"]}%' AND fecha_modificacion > '$fecha_tareas_vistas' " );

        
        

// fin debug
        
        
// buscamos licencia activa y registramos límites de entidades
// ANULAMOS GESTION LICENCIAS



$link_comprar_licencia = "<a href='../configuracion/comprar_licencia.php'>aquí</a>";

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

            $result = $Conn->query("SELECT * FROM Licencias WHERE not_free=0 AND fecha_contrato<=CURRENT_DATE() AND fecha_caducidad>=CURRENT_DATE() AND $where_c_coste ORDER BY fecha_contrato DESC");
            $rs = $result->fetch_array(MYSQLI_ASSOC); // cojo la última licencia FREE
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

        /////  FIN ANULACION GESTION DE LICENCIAS
        //
        //PARA ACTIVAR LAS LICENCIAS, BUSCAR TAMBIEN  TODOS LOS 'echo "($num_' Y DESCOMENTARLOS
// echo "<pre>";
////  print_r($rs);
//  print_r($limites);
// echo "</pre>";
// $doc_logo=Dfirst("doc_logo", "C_COSTES", "$where_c_coste") ;

//if (!$path_logo_empresa = Dfirst("path_logo", "Empresas_Listado", "$where_c_coste")) {$path_logo_empresa = "../img/no_logo.jpg";}  // lo calculamos en el adminLTE
        

// iniciamos MENUS        
//require_once("../adminlte/adminlte_header.php");
//require_once("../menu/topbar.php"); 
 
echo '<br><br><br><br>';

if ($_SESSION["is_desarrollo"])
{ echo "<br><br><br><br><br><a class='btn btn-xs btn-link noprint'  href='#'  onclick=\"tour()\"  title='Tour pruebas' >Tour (pruebas5)</a>" ;
}        
        
        
?>


        <div class="container-fluid">	
            <div class="row">
                <!--<div class="col-sm-12 col-md-4  col-lg-3"><img width="300" src="<?php echo $path_logo_empresa; ?>" >-->       
                <div class="col-sm-12 col-md-4  col-lg-3">
                    <img width="150" src="../img/construcloud64.svg" >       
                </div>
                <!--****************** BUSQUEDA GLOBAL  *****************
                <div class="col-sm-12 col-md-4  col-lg-6 " style="background-color: lightblue">
                    <form action="busqueda_global.php" method="post" id="form1" name="form1" target='_blank'>
                        <h2 title='Búsqueda de entidades (obras, empleados, provedores, clientes...) 
    También pueden buscarse #hashtag en los chat, observaciones, mensajes... '>
                            <i class="fas fa-globe-europe"></i> 
                            <INPUT placeholder="Búsqueda global" type="text" size='15' id="filtro" name="filtro" >
                            <!--<INPUT type="submit" value="Buscar" id="submit" name="submit">-->
                            <button  id="buscar" type="submit" class="btn btn-default btn-lg">
                                <i class="fas fa-search"></i> 
                            </button>  <?php echo span_wiki('Búsqueda_global'); ?>

                        </h2>
                    </form>
<!--                    <form action="busqueda_texto.php" method="post" id="form1" name="form1" target='_blank'>
                        <h1><i class="fas fa-hashtag"></i> Buscar texto:<INPUT type="text" size='5' name="filtro" >
                            <INPUT type="submit" value="Buscar" id="submit" name="submit">
                            <button type="submit" class="btn btn-default btn-lg">
                                <i class="fas fa-search"></i> 
                            </button>

                        </h1>
                    </form>-->
                
                
                </div>

                <!--****************** EMPRESA / USUARIO /CERRAR SESION  *****************-->


                <div class="col-sm-12 col-md-4  col-lg-3" >

<?php

//  ANTIGUO empresa/usuario  anulado en mayo20
//echo "<p><h4>$ICON-home$SPAN <a target='_blank' title='Abrir ficha de la Empresa' href='../configuracion/empresa_ficha.php' >"
//     ." {$_SESSION["empresa"]}</a> / $ICON-user$SPAN<a target='_blank' title='Abrir ficha del Usuario' href='../configuracion/usuario_ficha.php' >{$_SESSION["user"]}" ;
//if ($admin)
//{
//    echo " <small>(admin)</small>";
//} elseif ($_SESSION["autorizado"])
//{
//    echo " <small>(autorizado)</small>";
//}
//echo (isset($_SESSION['android']) ? (($_SESSION['android']) ? '<small>android </small>' : '<small> pc</small>' ) : '<small> pc</small>' );
//
//echo '</a>';



echo '<div>' ;
//echo "<a target='_blank'  href='../agenda/tareas.php' > Tareas". badge($tareas,'info') . badge($tareas_new) . " </a>" ;
//echo "<a target='_blank'  href='../agenda/tarea_anadir.php' title='añadir Tarea nueva' > <i class='fas fa-plus-circle'></i></a>" ;

//echo "<a target='_blank' class='btn btn-link btn-lg' href='../agenda/portafirmas.php' ><i class='fas fa-pen-nib'></i> PortaFirmas". badge($portafirmas) . "</a>" ;

// CHAT ONLINE       
//if ($_SESSION["is_desarrollo"])    // actualmente solo para VERSION DESARROLLO 
if (1)    // actualmente probando en  PRODUCCION
{ 
     
//    if ($_SESSION["admin_chat"])   
//    {
////         $chat_users_online=Dfirst("COUNT(id_usuario)","Usuarios","online=1 AND admin_chat=0") ;
//         $chat_users_online=Dfirst("COUNT(id_usuario)","Usuarios","online=1") ;
//         $chat_pendientes=Dfirst("COUNT(chatid)","chat","reciever_userid='{$_SESSION["id_usuario"]}' AND status = '1' ") ;
//         echo "<a target='_blank' class='btn btn-link btn-lg' href='../chat/chat_index.php' >"
//                          . "<i class='far fa-comments'></i> Chat admin". badge($chat_users_online,'info') .badge($chat_pendientes)."</a>"  ;
//    }else
//    {
//         $chat_admin_online=Dfirst("COUNT(id_usuario)","Usuarios","online=1 AND admin_chat!=0") ;   
//         $chat_pendientes=Dfirst("COUNT(chatid)","chat","reciever_userid='{$_SESSION["id_usuario"]}' AND status = '1' ") ;
//         // hay administradores online?
//         if ($chat_admin_online)
//         {
//             echo "<a target='_blank' class='btn btn-link btn-lg' href='../chat/chat_index.php' title='Hay administradores online. En rojo, mensajes pdtes de leer (Chat en pruebas)' >"
//             . "<i class='far fa-comments'></i> Chat Online".badge($chat_pendientes)."</a>"  ;
//         }else
//         {
//             echo "<a target='_blank' class='btn btn-link btn-lg' href='../chat/chat_index.php' title='Ningún administrador online (Chat en pruebas)'>"
//             . "<i class='far fa-comments'></i> Chat Offline".badge($chat_pendientes)."</a>"  ;
//         }   
//    }    
}
 

// ESQUINA SUPERIOR DERECHA

//if ($_SESSION['autorizado'])
if (1)    // ACTIVIDAD lo ponemos para todos los usuarios  , juand, abril 2020
{
    // LOGO EMPRESA
     echo "<img width='150' src='{$path_logo_empresa}' >  ";     


     // Actividad
    $fecha_eventos_vistos=Dfirst("fecha_eventos_vistos","Usuarios_View"," $where_c_coste AND id_usuario={$_SESSION["id_usuario"]} " ) ;
    echo " <div>"
    . "<a target='_blank' class='btn btn-link btn-xs' href='../agenda/eventos.php' ><i class='fas fa-chart-line'></i> Actividad"
    . "<span id='badget_eventos' class='badge badge-danger' >...</span></a>" ;
    echo "<script>dfirst_ajax('#badget_eventos','count(id)','eventos','$where_c_coste AND Fecha_Creacion >= \'$fecha_eventos_vistos\'  ');</script>" ;

}

// Licencia
$links["licencia"] = ["../include/ficha_general.php?url_enc=".encrypt2("tabla=Licencias&id_update=id_licencia&no_update=1")."&id_valor=", "id_licencia",'', 'formato_sub'] ;

echo "<br><a class='btn btn-link btn-xs' target='_blank' href='../include/ficha_general.php?url_enc=".encrypt2("tabla=Licencias&id_update=id_licencia&no_update=1&id_valor=".$_SESSION["id_licencia"])."' >"
                  . "<i class='fas fa-key'></i> $msg_licencia</a>" ;
//echo "<br> $msg_licencia " ;   {$_SESSION["id_licencia"]}

// cambio empresa
if (is_multiempresa()) { echo "<br><a class='btn btn-link btn-xs' target='_blank' title='Cambiar a otra empresa a la que pertenezca el usuario' href='../menu/pagina_empresas.php' >"
    . "<i class='fas fa-exchange-alt'></i> cambiar empresa</a>" ; }

    
// cerrar sesion    
echo "<br><a class='btn btn-link btn-xs' href='../registro/cerrar_sesion.php' ><i class='fas fa-power-off'></i> Cerrar sesión</a>" ;
    
echo '</div>' ;




// calculo de variables AJAX de FACTURAS PDTES
echo "<script>dfirst_ajax('.num_fras_prov_NC','count(ID_FRA_PROV)','Fras_Prov_View','conc=0 AND fecha_creacion>=\'$fecha_inicio\'  AND  $where_c_coste');</script>" ;
echo "<script>dfirst_ajax('.num_fras_prov_NP','count(ID_FRA_PROV)','Fras_Prov_View','pagada=0 AND fecha_creacion>=\'$fecha_inicio\'  AND  $where_c_coste');</script>" ;

    
?>

                </div>
                </div>

            </div>		
            <!--****************** M E N U   P R I N C I P A L  *****************-->


            <!--****************** REGISTROS  *****************-->
            <div class="row">
<!--                <div class="col-sm-12 col-md-4  col-lg-3"> 
                    <div class='div_ppal_expand'><a target="_blank" class="btn btn-primary btn-block btn-lg"  href="../documentos/doc_upload_multiple_form.php"  ><span class="glyphicon glyphicon-pencil"></span> Registro Documentos</a>
                    </div>    
                    <div class='div_boton_expand'><button data-toggle='collapse' class="btn btn-primary btn-block btn-lg" data-target='#div_registro'></button></div>

                    <div id='div_registro' class='collapse in'>
                        <br><a target="_blank" class="btn btn-link btn-lg" href="../documentos/doc_upload_multiple_form.php" title='Permite subir documentos pdf, jpg, fotos... para su posterior clasificación' ><i class="fas fa-plus-circle"></i> SUBIR DOC. pdtes clasificar</a>
                        <br><a target="_blank" class="btn btn-link btn-lg" href="../documentos/doc_upload_multiple_form.php?_m=<?php echo $_m; ?>&tipo_entidad=fra_prov" title='Permite subir facturas de proveedores (pdf, jpg, fotos movil...) para su posterior registro en PROVEEDORES->Facturas Prov. PDTES REGISTRAR'  ><i class="fas fa-plus-circle"></i> SUBIR FRAS PROVEEDORES</a>

                        <br><a target="_blank" class="btn btn-link btn-lg" href="../proveedores/albaran_anadir.php"><i class="fas fa-plus-circle"></i> AÑADIR ALBARAN PROVEEDOR</a>
                        <br><a target="_blank" class="btn btn-link btn-lg" href="../proveedores/albaran_anadir_form.php"><i class="fas fa-plus-circle"></i> AÑADIR ALBARAN PROVEEDOR</a>
                        <br><a target="_blank" class="btn btn-link btn-lg"  href="../personal/parte_anadir_form_app.php"  ><i class="fas fa-plus-circle"></i> AÑADIR PARTE DIARIO</a>
                    </div>    
                </div>-->
<?php      
       
//        if($_SESSION["permiso_licitacion"])
//        echo "VALOR:". $_SESSION["permiso_licitacion"] ;
        if($_SESSION["permiso_licitacion"])
       { 
             ?>

            <!--****************** #LICITACIONES  *****************-->
                <div class="col-sm-12 col-md-4  col-lg-3"> 
                    <div class='div_ppal_expand'><a target="_blank" class="btn btn-primary btn-block btn-lg"  href="../estudios/estudios_calendar.php?_m=<?php echo $_m; ?>&fecha=<?php echo date("Y-m-d"); ?>"
                                                    title="Licitaciones de obra" ><i class="far fa-calendar-alt"></i> Licitaciones y Presupuestos <?php echo "($num_estudios)"; ?> </a></div>
                    <div class='div_boton_expand'><button data-toggle='collapse' class="btn btn-primary btn-block btn-lg" data-target='#div_estudios'></button></div>   
                    <div id='div_estudios' class='collapse in'>         

                        <!--<br><a target="_blank" class="btn btn-link btn-lg"  href="../estudios/estudios_nuevo.php"  ><i class="fas fa-plus-circle"></i> Añadir Estudio o Licitación</A>-->
                        <br><a target="_blank" class="btn btn-link btn-lg"  href="../estudios/estudios_calendar.php?_m=<?php echo $_m; ?>&fecha=<?php echo date("Y-m-d"); ?>" ><i class="far fa-calendar-alt"></i> Calendario Licitaciones</a>
                        <br><a target="_blank" class="btn btn-link btn-lg"  href="../estudios/estudios_buscar.php" ><i class="fas fa-list"></i> Listado Licitaciones</a>
                        <!--<br><a target="_blank" class="btn btn-link btn-lg"  href="../estudios/estudios_calendar.php?_m=<?php echo $_m; ?>&fecha=<?php echo date("Y-m-d"); ?>" ><i class="far fa-calendar-alt"></i> Calendario Licitaciones</a>-->
                        <br><a target="_blank" class="btn btn-link btn-lg"  href="../estudios/ofertas_clientes.php?_m=<?php echo $_m; ?>&fecha=<?php echo date("Y-m-d"); ?>" ><i class="fas fa-list"></i> Presupuestos a clientes</a>

                        <!--        <br><a target="_blank" class="btn btn-link btn-lg"  href="../estudios/ofertas_clientes.php" >Ofertas_Clientes</a>-->

                    </div>
                </div>
            
<?php       
       }
        if($_SESSION["permiso_obras"])
       { 
             ?>
            
                <!------------------------#OBRAS---------------------->    


<?php
// anulado sistema LRU ultima obra seleccionada, resulta engorroso y ocupa menu, juand mayo20
//$id_obra_LRU = Dfirst('ID_OBRA', 'Partes_View', $where_c_coste, 'Fecha DESC');
//$nombre_obra_LRU = Dfirst('NOMBRE_OBRA', 'OBRAS', 'ID_OBRA=' . $id_obra_LRU . ' AND ' . $where_c_coste);
?>

                <div class="col-sm-12 col-md-4  col-lg-3">
                    <div class='div_ppal_expand'> <a target="_blank" class="btn btn-primary btn-block btn-lg" href="../obras/obras_buscar.php?_m=<?php echo $_m; ?>&tipo_subcentro=OGA" >
                            <i class="fas fa-hard-hat"></i> Obras o Proyectos</a></div>
                    <div class='div_boton_expand'><button data-toggle='collapse' class="btn btn-primary btn-block btn-lg" data-target='#div_obras'></button></div>   
                    <div id='div_obras' class='collapse in'>         

                        <!--<br><a target="_blank" class="btn btn-link btn-lg" href="../obras/obras_anadir_form.php"  ><i class="fas fa-plus-circle"></i> Añadir Obra</a>-->
                        <!--<br><a target="_blank" class="btn btn-link btn-lg" href="../obras/obras_buscar.php?_m=<?php echo $_m; ?>&tipo_subcentro=O"  ><i class="fas fa-search"></i> Buscar Obra</a>-->
                        <br><a target="_blank" class="btn btn-link btn-lg"  href="../obras/obras_buscar.php?_m=<?php echo $_m; ?>&tipo_subcentro=OEGA" ><i class="fas fa-hard-hat"></i> Obras o Proyectos <?php echo "($num_obras)"; ?></a>
                        <br><a target="_blank" class="btn btn-link btn-lg"  href="../personal/partes.php" ><i class="far fa-calendar-alt"></i> Partes Diarios</a>
                        <br><a target="_blank" class="btn btn-link btn-lg"  href="../obras/gastos.php?_m=<?php echo $_m; ?>&fecha1=<?php echo $fecha_inicio; ?>" ><i class="fas fa-shopping-cart"></i> Gastos</a>

                        <br><a target="_blank" class="btn btn-link btn-lg"  href="../maquinaria/maquinaria_buscar.php?_m=<?php echo $_m; ?>&tipo_subcentro=M" ><i class="fas fa-truck-pickup"></i> Maquinaria <?php echo "($num_maquinaria)"; ?></a>
                        <br><a target="_blank" class="btn btn-link btn-lg" href="../obras/obras_view.php?_m=<?php echo $_m; ?>&tipo_subcentro=O&fecha1=<?php echo $fecha_inicio; ?>"  ><i class="fas fa-list"></i> Gestión Obras</a>
                        <!--      <br><a target="_blank" class="btn btn-link btn-lg" href="../obras/almacen_obras.php"  >Almacenes de obra</a>
                                <br><a target="_blank" class="btn btn-link btn-lg" href="../obras/obras_buscar.php?_m=<?php echo $_m; ?>&tipo_subcentro=O" >Obras</a>
                               <br><a target="_blank" class="btn btn-link btn-lg" href="../pof/menu_pof.php" >Peticion_Ofertas</a>-->
                        <!--       <br><a target="_blank" class="btn btn-link btn-lg" href="../obras/gastos.php" ><i class="fas fa-shopping-cart"></i> Gastos de Obra</a>-->
                               <!--<br><a target="_blank" class="btn btn-link btn-lg" href="../subcontratos.php" ><span class="glyphicon glyphicon-folder-open"></span> Subcontratos(pdte)</a>-->
                        <!--<br><a target="_blank" class="btn btn-link btn-lg" href="../obras/obras_fotos.php" ><span class="glyphicon glyphicon-camera"></span> Fotos</a>-->
                        <!--<br><a target="_blank" class="btn btn-link btn-lg" href="../obras/obras_prod_detalle.php?_m=<?php echo $_m; ?>&OBRA=SIN_OBRA" title='Permite buscar cualquier unidad de obra de Proyecto de cualquier obra ' >Unidades de Obra</a>-->
<!--                        <br><a target="_blank" class="btn btn-link btn-lg" href="../obras/obras_ficha.php?_m=<?php // echo $_m; ?>&id_obra=<?php // echo $id_obra_LRU; ?>"  ><i class="fas fa-hard-hat"></i> última: <?php // echo $nombre_obra_LRU; ?></a>-->

                        <!--       <br><a target="_blank" class="btn btn-link btn-lg" href="../o_prod_gasto.php" >Obras_Prod_Gasto</a>-->
                        <!--      <br><a target="_blank" class="btn btn-link btn-lg" href="file:\\server\cw\cw_ingenop\multi\diagrama_construwin.jpg"  >diagrama_construwin</a>
                              <br><a target="_blank" class="btn btn-link btn-lg" href="\\server\cw\cw_ingenop\multi\prueba.pdf" target="_blank" >prueba.pdf</a>-->
                    </div>
                </div>


<?php      
       }
        if($_SESSION["permiso_administracion"])
       { 
             ?>

                <div class="col-sm-12 col-md-4  col-lg-3"> 
                    <!------------------------#ADMINISTRACION---------------------->    

                    <div class='div_ppal_expand'><a target="_blank" class="btn btn-primary btn-block btn-lg"  href="../proveedores/proveedores_buscar.php"  >
                            <i class="fas fa-shopping-cart"></i> Administración <?php echo "($num_proveedores/{$limites["proveedores"]})"; ?></a></div>
                    <div class='div_boton_expand'><button data-toggle='collapse' class="btn btn-primary btn-block btn-lg" data-target='#div_proveedores'></button></div>   

                    <div id='div_proveedores' class='collapse in'>     
                        
                        
                        
<!--<div class="dropdown">
  <button class="btn btn-primary dropdown-toggle" type="button" data-toggle="dropdown">Dropdown Example
  <span class="caret"></span></button>
  <ul class="dropdown-menu">
    <li><a href="#">HTML</a></li>
    <li><a href="#">CSS</a></li>
    <li><a href="#">JavaScript</a></li>  
  </ul> 
</div>                        -->
                        <div class="dropdown"> 
                          <button class="btn btn-link btn-lg dropdown-toggle" type="button" data-toggle="dropdown"><i class="fas fa-shopping-cart"></i> Proveedores <?php echo "($num_proveedores/{$limites["proveedores"]})..."; ?>
                          </button>
                          <ul class="dropdown-menu">
                        
                        <li><a target="_blank"  href="../proveedores/proveedores_buscar.php"  ><i class="fas fa-shopping-cart"></i> Proveedores</a>
                        <!--<br><a target="_blank" class="btn btn-link btn-lg" href="../proveedores/proveedores_anadir_form.php"  ><i class="fas fa-plus-circle"></i> Añadir Proveedor</a>-->
                        <!--<br><a target="_blank" class="btn btn-link btn-lg" href="../proveedores/factura_proveedor_anadir.php"  ><i class="fas fa-plus-circle"></i> Añadir Factura Proveedor <?php echo "($num_fras_prov)"; ?></a>-->
                        </li><li><a target="_blank"  href="../documentos/doc_upload_multiple_form.php?_m=<?php echo $_m; ?>&tipo_entidad=fra_prov" title='Permite subir facturas de proveedores (pdf, jpg, fotos movil...) para su posterior registro en PROVEEDORES->Facturas Prov. PDTES REGISTRAR'  ><i class="fas fa-plus-circle"></i> Enviar fras. proveedor</a>
                        </li><li><a target="_blank"  href="../proveedores/facturas_proveedores.php?fecha1=<?php echo $fecha_inicio; ?>" title='Facturas de Proveedores' ><i class="fas fa-list"></i> Facturas Proveedores</a>
                        </li><li class="divider">
                        </li><li><a target="_blank"  href="../proveedores/facturas_proveedores.php?_m=<?php echo $_m; ?>&id_proveedor=<?php echo $id_proveedor_auto; ?>" title='Facturas subidas al sistema y pendientes de registrar sus datos ' >Fras prov. no registradas<?php echo badge($num_fras_prov_NR); ?></a>
                        </li><li><a target="_blank"  href="../proveedores/facturas_proveedores.php?_m=<?php echo $_m; ?>&conciliada=0&fecha1=<?php echo $fecha_inicio; ?>" title='Facturas registradas y pendientes de cargar el gasto a obra' >Fras prov. no cargadas<span class='num_fras_prov_NC badge badge-danger right' >...</span></a>
                        </li><li><a target="_blank"  href="../proveedores/facturas_proveedores.php?_m=<?php echo $_m; ?>&conciliada=1&pagada=0&fecha1=<?php echo $fecha_inicio; ?>" title='Facturas registradas, cargadas y pendiente de pago' >Fras prov. no pagadas<span class='num_fras_prov_NP badge badge-danger right' >...</span></a>
                        </li><li class="divider">
                        </li><li><a target="_blank"  href="../bancos/remesas_listado.php?tipo_remesa=tipo_remesa='P'&conc=activa=1" title='Gestión de Remesa de pagos a proveedores y nóminas' ><i class="fas fa-euro-sign"></i> Remesas de Pagos</a>  
                        </li>
                         </ul>
                        </div>
                        
                        <div class="dropdown"> 
                          <button class="btn btn-link btn-lg dropdown-toggle" type="button" data-toggle="dropdown"><i class="fas fa-shopping-cart"></i> Clientes <?php echo "($num_clientes/{$limites["clientes"]})..."; ?>
                          </button>
                          <ul class="dropdown-menu">
                        
                        <li><a target="_blank"   href="../clientes/clientes_buscar.php" ><i class="fas fa-briefcase"></i> Clientes </a>                        
                        </li><li><a target="_blank"  href="../clientes/facturas_clientes.php?fecha1=<?php echo $fecha_inicio; ?>"  ><i class="fas fa-list"></i> Facturas de Clientes <?php echo "($num_fras_cli)"; ?></a>
                        </li><li><a target="_blank"   href="../bancos/remesas_listado.php?tipo_remesa=tipo_remesa='C'&conc=activa=1" title='Gestión de Remesa de cobros a clientes' ><i class="fas fa-euro-sign"></i> Remesas de Cobros</a> 

                        </li>
                         </ul>
                        </div>
                        
<!--                        <br><a target="_blank" class="btn btn-link btn-lg"  href="../obras/gastos.php?_m=<?php echo $_m; ?>&fecha1=<?php echo $fecha_inicio; ?>" ><i class="fas fa-shopping-cart"></i> Gastos globales</a>-->
                        <!--<br><a target="_blank" class="btn btn-link btn-lg"  href="../proveedores/proveedores_importar_XLS.php" ><span class="glyphicon glyphicon-open-file"></span> Importar proveedores de XLS</a>-->
                  <!--      <br><a target="_blank" class="btn btn-link btn-lg"  href="../proveedores/fras_prov_importar_XLS.php" ><span class="glyphicon glyphicon-open-file"></span> Importar Facturas prov. de XLS (pdte)</a>-->
                        <br><a target="_blank" class="btn btn-link btn-lg"  href="../personal/personal_listado.php?baja=BAJA=0" ><i class="far fa-user"></i> Personal <?php echo "($num_empleados/{$limites["empleados"]})"; ?></a>
<?php      
       
        if($_SESSION["permiso_bancos"])
       { 
             ?>

                        <br><a target="_blank" class="btn btn-link btn-lg"  href="../bancos/bancos_ctas_bancos.php?_m=<?php echo $_m; ?>&activo=on" title="Cuentas bancarias" ><i class="fas fa-university"></i> Bancos </a>
                        <!--<br><a target="_blank" class="btn btn-link btn-lg"  href="../bancos/bancos_mov_bancarios.php?_m=<?php echo $_m; ?>" title="todos los movimientos bancarios de todas las cuentas" >Movimientos Bancarios </a>-->

                      
  <?php      
          }
          ?> 
                        <br><a target="_blank" class="btn btn-link btn-lg"  href="../bancos/pagos_y_cobros.php" title='Muestra los pagos y cobors, emitidos, pdte vencimiento,calendarios, previsión Tesorería, simulación Cash-flow.. ' ><i class="far fa-calendar-alt"></i> Pagos y Cobros</a>

                        <?php
                          // boton linea avales
//                            $num_avales_pdtes=Dfirst('count(ID_AVAL)','Avales',"$where_c_coste AND F_Recogida <= NOW() AND Recogido=0 AND Solicitado=0 ") ;
                            echo " <br><a target='_blank' class='btn btn-link btn-lg' href='../bancos/bancos_lineas_avales.php' "
                        . " title='Gestión de líneas de avales, avales depositados, saldo pendientes, aviso de cancelación, vencimiento de pólizas \n (en rojo los pendientes de Solicitar Devolución)...'  >"
                                    . "<i class='fas fa-stamp'></i> Avales"
                            . "<span id='avales_pdtes' class='badge badge-danger right' >".(($num_avales_pdtes<>0)?$num_avales_pdtes:'')."</span></a>" ;
                        //    echo "<script>dfirst_ajax('avales_pdtes','count(ID_AVAL)','Avales','$where_c_coste AND F_Recogida <= NOW() AND Recogido=0 AND Solicitado=0 ');</script>" ;

                        ?>

                       
                        
                    </div>	
                </div>	
                
   <?php      
          }
          ?>
              
                
            </div>	 
            <div class="row">
                <!------------------------CLIENTES---------------------->    

<!--                <div class="col-sm-12 col-md-4  col-lg-3">

                    <div class='div_ppal_expand'><a target="_blank" class="btn btn-primary btn-block btn-lg"  href="../clientes/clientes_buscar.php" >
                            <i class="fas fa-briefcase"></i> Clientes <?php // echo "($num_clientes/{$limites["clientes"]})"; ?></a></div>
                    <div class='div_boton_expand'><button data-toggle='collapse' class="btn btn-primary btn-block btn-lg" data-target='#div_clientes'></button></div>   
                    <div id='div_clientes' class='collapse in'>         

                        <br><a target="_blank" class="btn btn-link btn-lg" href="../clientes/facturas_clientes.php?fecha1=<?php echo $fecha_inicio; ?>"  >Facturas de Clientes <?php echo "($num_fras_cli)"; ?></a>
                        <br><a target="_blank" class="btn btn-link btn-lg" href="../clientes/clientes_anadir_form.php"  ><i class="fas fa-plus-circle"></i> Añadir Cliente</a>
                       <br><a target="_blank" class="btn btn-link btn-lg"  href="../clientes/clientes_importar_clientes.php" ><span class="glyphicon glyphicon-open-file"></span> Importar Clientes de XLS (pdte)</a>
                     <br><a target="_blank" class="btn btn-link btn-lg"  href="../clientes/clientes_importar_fras_clientes.php" ><span class="glyphicon glyphicon-open-file"></span> Importar fra Clientes de XLS (pdte)</a>

                    </div>
                </div>
                ----------------------#MAQUINARIA--------------------    -->

<!--                <div class="col-sm-12 col-md-4  col-lg-3">
                    <div class='div_ppal_expand'><a target="_blank" class="btn btn-primary btn-block btn-lg"  href="../maquinaria/maquinaria_buscar.php?_m=<?php echo $_m; ?>&tipo_subcentro=M" >
                            <i class="fas fa-truck-pickup"></i> Maquinaria <?php echo "($num_maquinaria)"; ?></a></div>
                    <div class='div_boton_expand'><button data-toggle='collapse' class="btn btn-primary btn-block btn-lg" data-target='#div_maquinaria'></button></div>   
                    <div id='div_maquinaria' class='collapse in'>  

                        <br><a target="_blank" class="btn btn-link btn-lg"  href="../obras/obras_buscar.php?_m=<?php echo $_m; ?>&tipo_subcentro=M" >Maquinaria <?php echo "($num_maquinaria)"; ?></a>                     PDTE MODIFICAR obras_buscar 
                          <br><a target="_blank" class="btn btn-link btn-lg"  href="../maquinaria/cuadro_maquinas.php" >Presencia_Mensual(pdte)</a>
                        <br><a target="_blank" class="btn btn-link btn-lg"  href="../explomaquinas.php" >Explomaquinas(pdte)</a>
                    </div>
                </div>
                ----------------------#PERSONAL--------------------    -->
<!--
                <div class="col-sm-12 col-md-4  col-lg-3">
                    <div class='div_ppal_expand'><a target="_blank" class="btn btn-primary btn-block btn-lg"  href="../personal/partes.php" >
                            <i class="far fa-user"></i> Partes y Personal <?php echo "($num_empleados/{$limites["empleados"]})"; ?></a></div>	
                    <div class='div_boton_expand'><button data-toggle='collapse' class="btn btn-primary btn-block btn-lg" data-target='#div_personal'></button></div>   
                    <div id='div_personal' class='collapse in'>  
                        <br><a target="_blank" class="btn btn-link btn-lg"  href="../personal/personal_listado.php?baja=BAJA=0" ><i class="far fa-calendar-alt"></i> Listado de Personal</a>
                        <br><a target="_blank" class="btn btn-link btn-lg"  href="../personal/personal_anadir.php" ><i class='fas fa-plus-circle'></i> Añadir Personal (empleado)</a>

                           <br><a target="_blank" class="btn btn-link btn-lg"  href="../personal/nominas.php" >Nóminas (pdte)</a>
                        <br><a target="_blank" class="btn btn-link btn-lg"  href="../personal/anuario_bajas.php" >Anuario Bajas (pdte)</a>
                              <br><a target="_blank" class="btn btn-link btn-lg"  href="../personal/personal_importar_personal.php" ><span class="glyphicon glyphicon-open-file"></span> Importar listado Personal de XLS (pdte)</a>

                    </div>
                </div>
            </div>-->
            <!------------------------ GASTOS GENERALES ---------------------->    

<?php
//$id_obra_gg = getVar('id_obra_gg');
//$nombre_obra_gg = Dfirst('NOMBRE_OBRA', 'OBRAS', 'ID_OBRA=' . $id_obra_gg . ' AND ' . $where_c_coste);
//
//$id_obra_mo = getVar('id_obra_mo');
//$nombre_obra_mo = Dfirst('NOMBRE_OBRA', 'OBRAS', 'ID_OBRA=' . $id_obra_mo . ' AND ' . $where_c_coste);
?>
<!--  <div class="row">

            <div class="col-sm-12 col-md-4  col-lg-3">
                <div class='div_ppal_expand'><a target="_blank" class="btn btn-primary btn-block btn-lg" 
                                                href="../obras/obras_buscar.php?_m=<?php echo $_m; ?>&tipo_subcentro=G" ><i class="fas fa-hard-hat"></i> Gastos Generales</a></div>
                <div class='div_boton_expand'><button data-toggle='collapse' class="btn btn-primary btn-block btn-lg" data-target='#div_gastos_generales'></button></div>   
                <div id='div_gastos_generales' class='collapse in'>   
                    <br><a target="_blank" class="btn btn-link btn-lg" title='Centro de coste GASTOS GENERALES donde se cargarán todos los gastos generales de la empresa. Alquileres oficinas, asesorías, telefonía, electricidad,  ' href="../obras/obras_ficha.php?_m=<?php echo $_m; ?>&id_obra=<?php echo $id_obra_gg; ?>"  ><?php echo $nombre_obra_gg; ?></a>
                    <br><a target="_blank" class="btn btn-link btn-lg" title='Centro de coste MANO DE OBRA donde se cargarán todos los gastos del Personal (nóminas, Seg. Social, Finiquitos...) y se abonará a este centro lo cargado por Personal Propio a las obras a través de los Partes Diarios' href="../obras/obras_ficha.php?_m=<?php echo $_m; ?>&id_obra=<?php echo $id_obra_mo; ?>"  ><?php echo $nombre_obra_mo; ?></a>
                    <br><a target="_blank" class="btn btn-link btn-lg" href="../obras/obras_anadir_form.php"  ><i class="fas fa-plus-circle"></i> Añadir Obra</a>
                    <br><a target="_blank" class="btn btn-link btn-lg" href="../obras/obras_buscar.php?_m=<?php echo $_m; ?>&tipo_subcentro=O"  ><i class="fas fa-search"></i> Buscar Obra</a>
                          <br><a target="_blank" class="btn btn-link btn-lg" href="../obras/almacen_obras.php"  >Almacenes de obra</a>
                            <br><a target="_blank" class="btn btn-link btn-lg" href="../obras/obras_buscar.php?_m=<?php echo $_m; ?>&tipo_subcentro=O" >Obras</a>
                           <br><a target="_blank" class="btn btn-link btn-lg" href="../pof/menu_pof.php" >Peticion_Ofertas</a>
                           <br><a target="_blank" class="btn btn-link btn-lg" href="../obras/gastos.php" ><i class="fas fa-shopping-cart"></i> Gastos de Obra</a>
                           <br><a target="_blank" class="btn btn-link btn-lg" href="../subcontratos.php" ><span class="glyphicon glyphicon-folder-open"></span> Subcontratos(pdte)</a>
                    <br><a target="_blank" class="btn btn-link btn-lg" href="../obras/obras_fotos.php" ><span class="glyphicon glyphicon-camera"></span> Fotos</a>
                    <br><a target="_blank" class="btn btn-link btn-lg" href="../obras/obras_prod_detalle.php?_m=<?php echo $_m; ?>&OBRA=SIN_OBRA" title='Permite buscar cualquier unidad de obra de Proyecto de cualquier obra ' >Unidades de Obra</a>

                           <br><a target="_blank" class="btn btn-link btn-lg" href="../o_prod_gasto.php" >Obras_Prod_Gasto</a>
                          <br><a target="_blank" class="btn btn-link btn-lg" href="file:\\server\cw\cw_ingenop\multi\diagrama_construwin.jpg"  >diagrama_construwin</a>
                          <br><a target="_blank" class="btn btn-link btn-lg" href="\\server\cw\cw_ingenop\multi\prueba.pdf" target="_blank" >prueba.pdf</a>
                </div>
            </div>-->

            <!--div_#FINANZAS-->  
                     
<!--                <div class="col-sm-12 col-md-4  col-lg-3">
                    <div class='div_ppal_expand'><a target="_blank" class="btn btn-primary btn-block btn-lg"  href="../bancos/pagos_y_cobros.php" >
                            <i class="fas fa-euro-sign"></i> Finanzas</a></div>
                    <div class='div_boton_expand'><button data-toggle='collapse' class="btn btn-primary btn-block btn-lg" data-target='#div_finanzas'><i class="fas fa-chevron-down"></i></button></div>   
                    <div id='div_finanzas' class='collapse in'>  
                   <br><a target="_blank" class="btn btn-link btn-lg"  href="../bancos/bancos_mov_bancarios.php?_m=<?php echo $_m; ?>&id_cta_banco=<?php echo $id_cta_banco_LRU; ?>" >Cuentas corriente Habitual (xxx)</a>


                        
                        
                            <br><a target="_blank" class="btn btn-link btn-lg"  href="../avales_anuario.php" title='Calendario de la recogidas prevista de Avales depositados por Garantías de obras.' >Calendario Avales (pdte)</a>
                           <br><a target="_blank" class="btn btn-link btn-lg"  href="../pagos_anuario.php" title='Situación actual de saldos y cuentas bancarias, líneas de crédito, pólizas, total disponible y total dispuesto...' >Tesoreria</a>
                           <br><a target="_blank" class="btn btn-link btn-lg"  href="../pagos_anuario.php" title='Previsión de cash flow según pagos y cobros pendientes a futuros' >Cash-Flow</a>
                        <br><a target="_blank" class="btn btn-link btn-lg"  href="../cobros_anual.php" >Anuario de Pagos y Cobros (pdte)</a>
                          <br><a target="_blank" class="btn btn-link btn-lg"  href="../cobros_anual.php" title='Cuentas que recogen subvenciones, traspasos internos de fondos entre cuentas de la empresa, ajustes de inventario, Capital Social, préstamos de/a socios..., ' >Otras Cuentas (pdte)</a>
                        <br><a target="_blank" class="btn btn-link btn-lg"  href="../cobros_anual.php" title='Permite registrar y planificar en cuentas independientes  mov. bancarios diferentes a pagos y cobros. Capital social, subvenciones, ajustes de inventario...' >Otros mov. bancarios</a>
                        <br><a target="_blank" class="btn btn-link btn-lg" title='Cuentas bancarias. Valores del BIC almacenados según el IBAN'  href="../include/tabla_general.php?url_enc=<?php echo encrypt2("sql=select DISTINCT  SUBSTR( IBAN, 5,4) AS COD,  BIC from Proveedores WHERE BIC<>'' ORDER BY COD"); ?>" >Codigos Bancos/BIC</a>

                    </div>
                </div>-->

<!--                ----DOCUMENTOS --------------
                <div class="col-sm-12 col-md-4  col-lg-3"> 
                    <div class='div_ppal_expand'>  <a target="_blank" class="btn btn-primary btn-block btn-lg"  href="../documentos/documentos.php"  >
                            <i class="far fa-file-alt"></i> Documentos <?php echo "($num_documentos)"; ?></a></div>
                    <div class='div_boton_expand'><button data-toggle='collapse' class="btn btn-primary btn-block btn-lg" data-target='#div_documentos'><i class="fas fa-chevron-down"></i></button></div>   
                    <div id='div_documentos' class='collapse in'>  
                        <br><a target="_blank" class="btn btn-link btn-lg"  href="../documentos/documentos.php?_m=<?php echo $_m; ?>&clasificar=1" title='Documentación que se ha subido a la plataforma y aún no ha sido tramitada o archivada en su lugar. P. ej. la foto de albarán enviado opr movil desde la propia obra. '>Docs. Pendientes de Clasificar<?php echo badge($num_documentos_pdte_clasif); ?> </a>

                    </div>
                </div>-->


<!--<div class="col-sm-12 col-md-4  col-lg-3"><a target="_blank" class="btn btn-primary btn-block btn-lg" href="<?php // echo $dir_raiz;  ?>include/tabla_general.php?_m=<?php echo $_m; ?>&tabla=Usuarios&where=id_c_coste=<?php // echo $id_c_coste; ?>" ><i class="far fa-user"></i> Usuarios <?php echo "($num_usuarios/{$limites["usuarios"]})"; ?></a></div>-->	

<!--                     MENU   AGENDA

                <div class="col-sm-12 col-md-4  col-lg-3">
                    <div class='div_ppal_expand'><a target="_blank" class="btn btn-primary btn-block btn-lg"  href="../utilidades/configuracion.php" >
                            <i class="fas fa-project-diagram"></i> Networking</a></div>
                    <div class='div_boton_expand'><button data-toggle='collapse' class="btn btn-primary btn-block btn-lg" data-target='#div_herramientas'><i class="fas fa-chevron-down"></i></button></div>   
                    <div id='div_herramientas' class='collapse in'>  
                            <br><a target="_blank" class="btn btn-link btn-lg" href="" ><i class="fas fa-user-plus"></i> Mensajes (pdte)</a>
                            <br><a target="_blank" class="btn btn-link btn-lg" href="" ><i class="fas fa-user-plus"></i> Avisos (pdte)</a>
                            <br><a target="_blank" class="btn btn-link btn-lg" href="../agenda/tareas.php" ><i class="fas fa-user-plus"></i> Tareas<?php echo badge($tareas,'info').badge($tareas_new); ?></a>                       
                            <br><a target="_blank" class="btn btn-link btn-lg" href="../agenda/portafirmas.php" ><i class="fas fa-pen-nib"></i> Portafirmas<?php echo badge($portafirmas); ?> </a>

                            
    

                    </div>
                </div>
-->
                <!--     MENU   #HERRAMIENTAS/CONFIGURACION-->

                <div class="col-sm-12 col-md-4  col-lg-3">
                    <div class='div_ppal_expand'><a target="_blank" class="btn btn-primary btn-block btn-lg"  href="../utilidades/configuracion.php" >
                            <i class="fas fa-cogs"></i> Herramientas</a></div>
                    <div class='div_boton_expand'><button data-toggle='collapse' class="btn btn-primary btn-block btn-lg" data-target='#div_configuracion'></button></div>   
                    <div id='div_configuracion' class='collapse in'>  
                        <br><a target="_blank" class="btn btn-link btn-lg"  href="../documentos/documentos.php"  ><i class="far fa-file-alt"></i> Documentos <?php echo badge($num_documentos,"info"); ?></a>
                        <br><a target="_blank" class="btn btn-link btn-lg"  href="../documentos/documentos.php?_m=<?php echo $_m; ?>&clasificar=1" title='Documentación que se ha subido a la plataforma y aún no ha sido tramitada o archivada en su lugar. P. ej. la foto de albarán enviado opr movil desde la propia obra. '><i class="far fa-file-alt"></i>Docs. pdtes. Clasificar<?php echo badge($num_documentos_pdte_clasif); ?> </a>

                        <br><a target="_blank" class="btn btn-link btn-lg"  href="../configuracion/usuario_ficha.php" ><i class="far fa-user"></i> Ficha Usuario<?php echo " ({$_SESSION["user"]})"; ?></a>
                        

                           <br><a target="_blank" class="btn btn-link btn-lg" href="../configuracion/empresa_ficha.php" ><i class="fas fa-building"></i> Empresa <?php echo " ({$_SESSION["empresa"]})"; ?></a>


                            <br><a target="_blank" class="btn btn-link btn-lg" href="../configuracion/usuario_anadir.php" >
                                <i class="fas fa-user-plus"></i> añadir usuario</a>
                                <br><a target="_blank" class="btn btn-link btn-lg" href="../include/tabla_general.php?url_enc=<?php echo encrypt2("select=id_usuario,usuario,email,online,activo,autorizado,permiso_licitacion,permiso_obras,permiso_administracion,permiso_bancos,user,fecha_creacion&tabla=Usuarios_View&where=activo AND id_c_coste=$id_c_coste&link=../configuracion/usuario_ficha.php?id_usuario=&campo=usuario&campo_id=id_usuario") ; ?>" ><i class="far fa-user"></i> Usuarios empresa<?php echo "($num_usuarios/{$limites["usuarios"]})"; ?></a>
                       <br><a target="_blank" class="btn btn-link btn-lg" href="../menu/menu_app.php" >MENU APP</a>

<?php
if ($admin)  
{                 // MENU SOLO PARA #ADMIN
    ?>     

                            <br><a target="_blank" class="btn btn-link btn-lg" href="../include/tabla_general.php?_m=<?php echo $_m; ?>&url_enc=<?php echo encrypt2("tabla=w_Accesos&where=id_c_coste='$id_c_coste'&order_by=fecha_creacion DESC LIMIT 500") ?>"> Accesos empresa<span class='badge progress-bar-info'> admin</span></a>
                            <br><a target="_blank" class="btn btn-link btn-lg" href="../include/tabla_general.php?_m=<?php echo $_m; ?>&url_enc=<?php echo encrypt2("tabla=w_Accesos&where=id_c_coste='$id_c_coste' AND resultado LIKE '%Error%'&order_by=fecha_creacion DESC LIMIT 500") ?>" >Accesos empresa con Error<span class='badge progress-bar-info'> admin</span></a>
                            <br><a target="_blank" class="btn btn-link btn-lg" href="../include/tabla_general.php?_m=<?php echo $_m; ?>&tabla=w_Accesos&where=1&order_by=fecha_creacion DESC LIMIT 500" >
                                Accesos Global<span class='badge progress-bar-info'> admin</span></a>
                            <br><a target="_blank" class="btn btn-link btn-lg" href="../include/tabla_general.php?_m=<?php echo $_m; ?>&tabla=<?php echo encrypt2('w_Accesos'); ?>&where=
                                   resultado LIKE '%Erro%'&order_by=fecha_creacion DESC LIMIT 500" >Accesos Global con Error<span class='badge progress-bar-info'> admin</span></a>
                            <br><a target="_blank" class="btn btn-link btn-lg"  href="../include/tabla_debug.php" >Tabla DEBUG<span class='badge progress-bar-info'> admin</span></a>
                            <br><a target="_blank" class="btn btn-link btn-lg"  href="../configuracion/debug_ppal.php" >Debug_ppal</a><span class='badge progress-bar-info'> admin</span>
                            <br><a target="_blank" class="btn btn-link btn-lg"  href="../debug/debug_vars.php" >Debug_vars</a><span class='badge progress-bar-info'> admin</span>
                            <br><a target="_blank" class="btn btn-link btn-lg"  href="../debug/debug.php" >Debug</a><span class='badge progress-bar-info'> admin</span>
                            <br><a target="_blank" class="btn btn-link btn-lg"  href="../pruebas/phpinfo.php" >Php_info()</a><span class='badge progress-bar-info'> admin</span>
<!--                            <br><a target="_blank" class="btn btn-link btn-lg" href="../include/tabla_general.php?url_enc=<?php echo encrypt2("tabla=Usuarios&where=1&link=../configuracion/usuario_ficha.php?id_usuario=&campo=usuario&campo_id=id_usuario") ?>" >
                                <i class="far fa-user"></i><i class="fas fa-globe-europe"></i> Usuarios Global_OLD<span class='badge progress-bar-info'> admin</span></a>-->
                            <br><a target="_blank" class="btn btn-link btn-lg" href="../include/tabla_debug.php?url_enc=<?php echo encrypt2("sql=SELECT * FROM Usuarios WHERE 1=1 ORDER BY id_usuario&link=../configuracion/usuario_ficha.php?id_usuario=&link_campo=usuario&link_campo_id=id_usuario") ?>" >
                                <i class="far fa-user"></i><i class="fas fa-globe-europe"></i> Usuarios Global<span class='badge progress-bar-info'> admin</span></a>
                            <br><a target="_blank" class="btn btn-link btn-lg" href="../include/tabla_debug.php?url_enc=<?php echo encrypt2("sql=SELECT * FROM Empresas_View_ext ORDER BY ultimo_acceso DESC LIMIT 50&link=../configuracion/empresa_ficha.php?id_empresa=&link_campo=C_Coste_Texto&link_campo_id=id_c_coste") ?>" >
                                <span class="glyphicon glyphicon-home"></span><i class="fas fa-globe-europe"></i> Empresas Global<span class='badge progress-bar-info'> admin</span></a>
                            <br><a target="_blank" class="btn btn-link btn-lg" href="../include/tabla_debug.php?url_enc=<?php echo encrypt2("sql=SELECT * FROM tipos_licencia &tabla_update=tipos_licencia&id_update=id") ?>" >
                                Tipos de licencias<span class='badge progress-bar-info'> admin</span></a>
                            <br><a target="_blank" class="btn btn-link btn-lg"  href="../configuracion/config_variables.php" >Configuración Variables</a><span class='badge progress-bar-info'> admin</span>
                            <br><a target="_blank" class="btn btn-link btn-lg"  href="../include/tabla_debug.php?url_enc=<?php echo encrypt2("sql=SELECT * FROM logs_db ORDER BY id DESC LIMIT 200") ?>" >Logs_db<span class='badge progress-bar-info'> admin</span></a>
                            <br><a target="_blank" class="btn btn-link btn-lg"  href="../include/sign_src/my_sign.php" >Signature Pad<span class='badge progress-bar-info'> admin</span></a>


    <!--    <br>invitado <h6><?php echo $dir_raiz . "menu/menu_app.php?login=" . (encrypt("LOGIN_INVITADO")) ?></h6>
    juand <h6><?php echo $dir_raiz . "menu/menu_app.php?login=" . (encrypt("LOGIN_INVITADO2")) ?></h6>
    sergio <h6><?php echo $dir_raiz . "menu/menu_app.php?login=" . (encrypt("LOGIN_INVITADO_sergio")) ?></h6>
    <span class='badge progress-bar-info'> admin</span>-->
    <?php
}
?>
                    </div>
                </div>
                     <!--          #AYUDA           -->
                <div class="col-sm-12 col-md-4  col-lg-3">
                    <div class='div_ppal_expand'><a target="_blank" class="btn btn-primary btn-block btn-lg"  href="../img/diagrama_construwin.jpg" >
                            <span class="glyphicon glyphicon-question-sign"></span> Ayuda</a></div>
                    <div class='div_boton_expand'><button data-toggle='collapse' class="btn btn-primary btn-block btn-lg" data-target='#div_ayuda'></button></div>   
                    <div id='div_ayuda' class='collapse in'>                 
                        <br><a target="_blank" class="btn btn-link btn-lg" href="../img/diagrama_construwin.jpg" ><i class="fas fa-image"></i> Diagrama</a>
                        <br><a target="_blank" class="btn btn-link btn-lg" href="../agenda/procedimientos.php" ><i class="fas fa-book"></i> Procedimientos<?php echo badge($num_procedimientos,'info'); ?> </a>

                        <br><a target="_blank" class="btn btn-link btn-lg" href="https://www.youtube.com/channel/UCHnW4ZAPAYxWQ6rRzUmS_tw" ><i class="fab fa-youtube"></i> Video tutoriales Youtube</a>
                        <br><a target="_blank" class="btn btn-link btn-lg" title='Foro donde consultar dudas con los administradores y otros usuarios, informar de errores, sugerencias...' href="https://foro.construcloud.es" ><i class="fas fa-users"></i> ConstruCloud Community forum</a>
                        <br><a target="_blank" class="btn btn-link btn-lg" title='Wikipedia de ConstruCloud.es donde consultar definiciones, procedimientos, de todas las entidades...' href="https://wiki.construcloud.es" ><i class="fab fa-wikipedia-w"></i> ConstruWIKI </a> 
                        <br><a target="_blank" class="btn btn-link btn-lg" href="../include/tabla_general.php?url_enc=<?php echo encrypt2("tabla=historial&where=Tipo_cambio LIKE '%PHP%' &campo=titulo&campo_id=id&link=../include/ficha_general.php?tabla=historial__AND__id_update=id__AND__id_valor=") ?>" >
                           0.99 Versiones</a>

                    </div>			
                </div>			



            </div>

<?php echo "<h6 style='color:silver'>ultima modfificación fichero " . date("d F Y H:i:s.", filemtime('pagina_inicio.php')) . "</h6>" ?>

            <script>

                if (screen.width >= 980)
                {
                    $('.collapse').collapse('show');
                } else
                {
                    $('.collapse').collapse('hide');
                }

            //alert(screen.width);
            //$('.collapse').collapse('show');
            //$("#div_registro").collapse("show");

 </script>

        
<?php 
require '../include/footer.php'; 
//require '../adminlte/adminlte_footer.php'; 

?>
 
</BODY>

</HTML>
 