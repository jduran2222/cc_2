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

<BR><BR>
        <div class="container-fluid">	
            <div class="row">

                <!--****************** ESPACIO LATERAL  *****************-->
                <div class="col-12 col-md-4 col-lg-3">
                    <!-- <img width="150" src="../img/construcloud64.svg" >        -->
                </div>

                <!--****************** BUSQUEDA GLOBAL  *****************-->
                <div class="col-12 col-md-4 col-lg-6 bg-light">
                    <form action="busqueda_global.php" method="post" id="form1" name="form1" target='_blank'>
                
                        <h2 title='Búsqueda de entidades (obras, empleados, provedores, clientes...) 
                                También pueden buscarse #hashtag en los chat, observaciones, mensajes... '>
                            <i class="fas fa-globe-europe"></i> 
                            <INPUT placeholder="Búsqueda global" type="text" size='15' id="filtro" name="filtro" >
                            <button  id="buscar" type="submit" class="btn btn-default btn-lg">
                                <i class="fas fa-search"></i> 
                            </button> 
                            <?php echo span_wiki('Búsqueda_global'); ?>
                        </h2>
                    </form>
                </div>
                
                <!--****************** ENLACES Y SALIDA  *****************-->
                <div class="col-12 col-md-4 col-lg-3 text-center">

<?php



echo '<div>' ;

// ESQUINA SUPERIOR DERECHA

//if ($_SESSION['autorizado'])
  // LOGO EMPRESA
 echo "<img style='max-width:250px; max-height:200px;' src='{$path_logo_empresa}_large.jpg' >";

//     // Actividad
//    $fecha_eventos_vistos=Dfirst("fecha_eventos_vistos","Usuarios_View"," $where_c_coste AND id_usuario={$_SESSION["id_usuario"]} " ) ;
//    echo "<a target='_blank' class='btn btn-link btn-xs' href='../agenda/eventos.php' ><i class='fas fa-chart-line'></i> Actividad"
//    . "<span id='badget_eventos' class='badge badge-danger' ></span></a>" ;
//    echo "<script>dfirst_ajax('#badget_eventos','count(id)','eventos','$where_c_coste AND Fecha_Creacion >= \'$fecha_eventos_vistos\'  ');</script>" ;



// Licencia
//$links["licencia"] = ["../include/ficha_general.php?url_enc=".encrypt2("tabla=Licencias&id_update=id_licencia&no_update=1")."&id_valor=", "id_licencia",'', 'formato_sub'] ;
//
//echo "<br><a class='btn btn-link btn-xs' target='_blank' href='../include/ficha_general.php?url_enc=".encrypt2("tabla=Licencias&id_update=id_licencia&no_update=1&id_valor=".$_SESSION["id_licencia"])."' >"
//                  . "<i class='fas fa-key'></i> $msg_licencia</a>" ;
//echo "<br> $msg_licencia " ;   {$_SESSION["id_licencia"]}

// cambio empresa
//if (is_multiempresa()) { 
//    echo "<br><a class='btn btn-link btn-xs' target='_blank' title='Cambiar a otra empresa a la que pertenezca el usuario' href='../menu/pagina_empresas.php' >"
//    . "<i class='fas fa-exchange-alt'></i> cambiar empresa</a>" ; 
//}

    
// cerrar sesion
//echo "<br><a class='btn btn-link btn-xs' href='../registro/cerrar_sesion.php' ><i class='fas fa-power-off'></i> Cerrar sesión</a><br>";
echo '</div>' ;




// calculo de variables AJAX de FACTURAS PDTES
echo "<script>dfirst_ajax('.num_fras_prov_NC','count(ID_FRA_PROV)','Fras_Prov_View','conc=0 AND fecha_creacion>=\'$fecha_inicio\'  AND  $where_c_coste');</script>" ;
echo "<script>dfirst_ajax('.num_fras_prov_NP','count(ID_FRA_PROV)','Fras_Prov_View','pagada=0 AND fecha_creacion>=\'$fecha_inicio\'  AND  $where_c_coste');</script>" ;

?>

                </div>
            </div>
        </div>


        <!-- MENU container-fluid -->
        <div class="container-fluid mt-5">   

            <!--****************** M E N U   P R I N C I P A L  *****************-->

            <!--****************** REGISTROS  *****************-->
            <div class="row">

                <!--****************** ESPACIO LATERAL  *****************-->
                <div class="col-12 col-md-4 col-lg-3"></div>
                <!--****************** ESPACIO LATERAL  *****************-->

                <!--****************** ESPACIO CENTRAL  *****************-->
                <div class="col-12 col-md-8 col-lg-9">
<?php      
       
        if($_SESSION["permiso_licitacion"])
       { 
             ?>

            <!--****************** #LICITACIONES  *****************-->
                <div class="col-sm-12 col-md-4 col-lg-3 float-left"> 
                    <div class='div_ppal_expand'>
                             
                   
                        <button data-toggle='collapse' class="btn btn-info btn-block btn-lg" data-target='#div_estudios'>
                           <i class="far fa-calendar-alt"></i>
                            Licitaciones y Presupuestos <i class="fa fa-angle-down" aria-hidden="true"></i>
                        </button>
                    </div>   
                    <div id='div_estudios' class='collapse in small'>
                        <br>
                        <a target="_blank" class="btn btn-link text-info text-left" href="../estudios/estudios_calendar.php?_m=<?php echo $_m; ?>&fecha=<?php echo date("Y-m-d"); ?>" >
                            <i class="far fa-calendar-alt"></i>
                            Calendario Licitaciones
                        </a>
                        <br>
                        <a target="_blank" class="btn btn-link text-info text-left" href="../estudios/estudios_buscar.php" >
                            <i class="fas fa-list"></i>
                            Listado Licitaciones <?php echo   "<sup class='bg-info small px-0 px-sm-1'>$num_estudios</sup>"; ?>
                        </a>
                        <br>
                        <a target="_blank" class="btn btn-link text-info text-left" href="../estudios/ofertas_clientes.php?_m=<?php echo $_m; ?>&fecha=<?php echo date("Y-m-d"); ?>" >
                            <i class="fas fa-list"></i>
                            Presupuestos a clientes
                        </a>
                    </div>
                </div>
            
<?php       
       }
        if($_SESSION["permiso_obras"])
       { 
             ?>
            
                <!------------------------#OBRAS---------------------->    
                <div class="col-sm-12 col-md-4 col-lg-3 float-left">
                    <div class='div_ppal_expand'>
                        <button data-toggle='collapse' class="btn btn-info btn-block btn-lg" data-target='#div_obras'>
                                   <i class="fas fa-hard-hat"></i> Obras o Proyectos <i class="fa fa-angle-down" aria-hidden="true"></i>
                        </button>
                    </div>   
                    <div id='div_obras' class='collapse in small'>
                        <br>
                        <a target="_blank" class="btn btn-link text-info text-left" href="../obras/obras_buscar.php?_m=<?php echo $_m; ?>&tipo_subcentro=OEGA" >
                            <i class="fas fa-hard-hat"></i>
                            Obras o Proyectos <?php echo   "<sup class='bg-info small px-0 px-sm-1'>$num_obras</sup>"; ?>
                        </a>
                        <br>
                        <a target="_blank" class="btn btn-link text-info text-left" href="../personal/partes.php" >
                            <i class="far fa-calendar-alt"></i>
                            Partes Diarios
                        </a>
                        <br>
                        <a target="_blank" class="btn btn-link text-info text-left" href="../obras/gastos.php?_m=<?php echo $_m; ?>&fecha1=<?php echo $fecha_inicio; ?>" >
                            <i class="fas fa-shopping-cart"></i>
                            Gastos
                        </a>
                        <br>
                        <a target="_blank" class="btn btn-link text-info text-left" href="../maquinaria/maquinaria_buscar.php?_m=<?php echo $_m; ?>&tipo_subcentro=M" >
                            <i class="fas fa-truck-pickup"></i>
                            Maquinaria <?php echo   "<sup class='bg-info small px-0 px-sm-1'>$num_maquinaria</sup>"; ?>
                        </a>
                        <br>
                        <a target="_blank" class="btn btn-link text-info text-left" href="../obras/obras_view.php?_m=<?php echo $_m; ?>&tipo_subcentro=O&fecha1=<?php echo $fecha_inicio; ?>"  >
                            <i class="fas fa-list"></i>
                            Gestión Obras
                        </a>

                    </div>
                </div>


<?php      
       }
        if($_SESSION["permiso_administracion"])
       { 
             ?>

                <div class="col-sm-12 col-md-4 col-lg-3 float-left"> 
                    <!------------------------#ADMINISTRACION---------------------->    

                    <div class='div_ppal_expand'>
                        <button data-toggle='collapse' class="btn btn-info btn-block btn-lg" data-target='#div_proveedores'>
                            <i class="fa fa-coins nav-icon"></i>
                            Administración <i class="fa fa-angle-down" aria-hidden="true"></i>
                        </button>
                    </div>   
                    <div id='div_proveedores' class='collapse in small'>
                        <div class="dropdown"> 
                            <button class="btn btn-link text-info text-left dropdown-toggle" type="button" data-toggle="dropdown"><i class="fas fa-shopping-cart"></i> Proveedores <?php echo "<sup class='bg-info small px-0 px-sm-1'>$num_proveedores</sup>"; ?>
                            </button>
                            <ul class="dropdown-menu p-3">
                                <li>
                                    <a target="_blank" class="text-info" href="../proveedores/proveedores_buscar.php"  >
                                        <i class="fas fa-shopping-cart"></i> 
                                        Proveedores 
                                    </a>
                                </li>
                                <li>
                                    <a target="_blank" class="text-info" href="../documentos/doc_upload_multiple_form.php?_m=<?php echo $_m; ?>&tipo_entidad=fra_prov" title='Permite subir facturas de proveedores (pdf, jpg, fotos movil...) para su posterior registro en PROVEEDORES->Facturas Prov. PDTES REGISTRAR'  >
                                        <i class='fas fa-cloud-upload-alt'></i>
                                        Enviar fras. proveedor
                                    </a>
                                </li>
                                <li>
                                    <a target="_blank" class="text-info" href="../proveedores/facturas_proveedores.php?fecha1=<?php echo $fecha_inicio; ?>" title='Facturas de Proveedores' >
                                        <i class="fas fa-list"></i> 
                                        Facturas Proveedores
                                    </a>
                                </li><li class="divider">
                                </li>
                                <li>
                                    <a target="_blank" class="text-info" href="../proveedores/facturas_proveedores.php?_m=<?php echo $_m; ?>&id_proveedor=<?php echo $id_proveedor_auto; ?>" title='Facturas subidas al sistema y pendientes de registrar sus datos ' >
                                        Fras prov. no registradas<?php echo badge($num_fras_prov_NR); ?>
                                    </a>
                                </li>
                                <li>
                                    <a target="_blank" class="text-info" href="../proveedores/facturas_proveedores.php?_m=<?php echo $_m; ?>&conciliada=0&fecha1=<?php echo $fecha_inicio; ?>" title='Facturas registradas y pendientes de cargar el gasto a obra' >
                                        Fras prov. no cargadas<span class='num_fras_prov_NC badge badge-danger right' >...</span>
                                    </a>
                                </li>
                                <li>
                                    <a target="_blank" class="text-info" href="../proveedores/facturas_proveedores.php?_m=<?php echo $_m; ?>&conciliada=1&pagada=0&fecha1=<?php echo $fecha_inicio; ?>" title='Facturas registradas, cargadas y pendiente de pago' >
                                        Fras prov. no pagadas<span class='num_fras_prov_NP badge badge-danger right' >...</span>
                                    </a>
                                </li><li class="divider">
                                </li>
                                <li>
                                    <a target="_blank" class="text-info" href="../bancos/remesas_listado.php?tipo_remesa=tipo_remesa='P'&conc=activa=1" title='Gestión de Remesa de pagos a proveedores y nóminas' >
                                        <i class="fas fa-euro-sign"></i> 
                                        Remesas de Pagos <?php echo   "<sup class='bg-info small px-0 px-sm-1'>$num_remesa_pagos</sup>"; ?>
                                    </a>  
                                </li>
                            </ul>
                        </div>
                        
                        <div class="dropdown"> 
                            <button class="btn btn-link text-info text-left dropdown-toggle" type="button" data-toggle="dropdown">
                                <i class="fas fa-shopping-cart"></i>
                                Clientes <?php echo   "<sup class='bg-info small px-0 px-sm-1'>$num_clientes</sup>"; ?>
                            </button>
                            <ul class="dropdown-menu p-3">
                                <li>
                                    <a target="_blank" class="text-info" href="../clientes/clientes_buscar.php" >
                                        <i class="fas fa-briefcase"></i> 
                                        Clientes 
                                    </a>
                                </li>
                                <li>
                                    <a target="_blank" class="text-info" href="../clientes/facturas_clientes.php?fecha1=<?php echo $fecha_inicio; ?>"  >
                                        <i class="fas fa-list"></i> 
                                        Facturas de Clientes <?php echo   "<sup class='bg-info small px-0 px-sm-1'>$num_fras_cli</sup>"; ?>
                                    </a>
                                </li>
                                <li>
                                    <a target="_blank" class="text-info" href="../bancos/remesas_listado.php?tipo_remesa=tipo_remesa='C'&conc=activa=1" title='Gestión de Remesa de cobros a clientes' >
                                        <i class="fas fa-euro-sign"></i> 
                                        Remesas de Cobros
                                    </a>
                                </li>
                            </ul>
                        </div>
                        
                        <a target="_blank" class="btn btn-link text-info text-left" href="../personal/personal_listado.php?baja=BAJA=0" >
                            <i class="far fa-user"></i> 
                            Personal <?php echo   "<sup class='bg-info small px-0 px-sm-1'>$num_empleados</sup>"; ?>
                        </a>
<?php      
       
        if($_SESSION["permiso_bancos"])
       { 
             ?>

                        <br>
                        <a target="_blank" class="btn btn-link text-info text-left" href="../bancos/bancos_ctas_bancos.php?_m=<?php echo $_m; ?>&activo=on" title="Cuentas bancarias" >
                            <i class="fas fa-university"></i> 
                            Bancos <?php echo   "<sup class='bg-info small px-0 px-sm-1'>$num_ctas_bancos</sup>"; ?>
                        </a>
                        
                      
  <?php      
          }
          ?> 
                        <br>
                        <a target="_blank" class="btn btn-link text-info text-left" href="../bancos/pagos_y_cobros.php" title='Muestra los pagos y cobors, emitidos, pdte vencimiento,calendarios, previsión Tesorería, simulación Cash-flow.. ' >
                            <i class="far fa-calendar-alt"></i>
                            Pagos y Cobros
                        </a>

                        <?php
                          // boton linea avales
                        echo " <br><a target='_blank' class='btn btn-link text-info text-left' href='../bancos/bancos_lineas_avales.php' "
                        . " title='Gestión de líneas de avales, avales depositados, saldo pendientes, aviso de cancelación, vencimiento de pólizas \n (en rojo los pendientes de Solicitar Devolución)...'  >"
                                    . "<i class='fas fa-stamp'></i> Avales"
                            . "<span id='avales_pdtes' class='badge badge-danger right' >".(($num_avales_pdtes<>0)?$num_avales_pdtes:'')."</span></a>" ;
                        
                        ?>

                       
                        
                    </div>  
                </div>  
                
   <?php      
          }
          ?>
              
                <!------------------------CLIENTES---------------------->    

<!--                <div class="col-sm-12 col-md-4 col-lg-3 float-left">

                    <div class='div_ppal_expand'><a target="_blank" class="btn btn-info btn-block btn-lg"  href="../clientes/clientes_buscar.php" >
                            <i class="fas fa-briefcase"></i> Clientes <?php // echo "($num_clientes/{$limites["clientes"]})"; ?></a></div>
                    <div class='div_boton_expand small'><button data-toggle='collapse' class="btn btn-block btn-lg" data-target='#div_clientes'>
                    <small>
                    <small>
                    <i class="fa fa-angle-down" aria-hidden="true"></i>
                    </small>
                    </small>
                    </button>
                    </div>   
                    <div id='div_clientes' class='collapse in small'>

                        <br><a target="_blank" class="btn btn-link text-info text-left" href="../clientes/facturas_clientes.php?fecha1=<?php echo $fecha_inicio; ?>"  >Facturas de Clientes <?php echo "($num_fras_cli)"; ?></a>
                        <br><a target="_blank" class="btn btn-link text-info text-left" href="../clientes/clientes_anadir_form.php"  ><i class="fas fa-plus-circle"></i> Añadir Cliente</a>
                       <br><a target="_blank" class="btn btn-link text-info text-left" href="../clientes/clientes_importar_clientes.php" ><span class="glyphicon glyphicon-open-file"></span> Importar Clientes de XLS (pdte)</a>
                     <br><a target="_blank" class="btn btn-link text-info text-left" href="../clientes/clientes_importar_fras_clientes.php" ><span class="glyphicon glyphicon-open-file"></span> Importar fra Clientes de XLS (pdte)</a>

                    </div>
                </div>    -->
                <!-- ----------------------#MAQUINARIA-------------------- -->

<!--                <div class="col-sm-12 col-md-4 col-lg-3 float-left">
                    <div class='div_ppal_expand'><a target="_blank" class="btn btn-info btn-block btn-lg"  href="../maquinaria/maquinaria_buscar.php?_m=<?php echo $_m; ?>&tipo_subcentro=M" >
                            <i class="fas fa-truck-pickup"></i> Maquinaria <?php echo "($num_maquinaria)"; ?></a></div>
                    <div class='div_boton_expand small'><button data-toggle='collapse' class="btn btn-block btn-lg" data-target='#div_maquinaria'>
                    <small>
                    <small>
                    <i class="fa fa-angle-down" aria-hidden="true"></i>
                    </small>
                    </small>
                    </button>
                    </div>   
                    <div id='div_maquinaria' class='collapse in small'>

                        <br><a target="_blank" class="btn btn-link text-info text-left" href="../obras/obras_buscar.php?_m=<?php echo $_m; ?>&tipo_subcentro=M" >Maquinaria <?php echo "($num_maquinaria)"; ?></a>                     PDTE MODIFICAR obras_buscar 
                          <br><a target="_blank" class="btn btn-link text-info text-left" href="../maquinaria/cuadro_maquinas.php" >Presencia_Mensual(pdte)</a>
                        <br><a target="_blank" class="btn btn-link text-info text-left" href="../explomaquinas.php" >Explomaquinas(pdte)</a>
                    </div>
                </div>    -->
                <!-- ----------------------#PERSONAL-------------------- -->
<!--
                <div class="col-sm-12 col-md-4 col-lg-3 float-left">
                    <div class='div_ppal_expand'><a target="_blank" class="btn btn-info btn-block btn-lg"  href="../personal/partes.php" >
                            <i class="far fa-user"></i> Partes y Personal <?php echo "($num_empleados/{$limites["empleados"]})"; ?></a></div>   
                    <div class='div_boton_expand small'><button data-toggle='collapse' class="btn btn-block btn-lg" data-target='#div_personal'>
                    <small>
                    <small>
                    <i class="fa fa-angle-down" aria-hidden="true"></i>
                    </small>
                    </small>
                    </button>
                    </div>   
                    <div id='div_personal' class='collapse in small'>
                        <br><a target="_blank" class="btn btn-link text-info text-left" href="../personal/personal_listado.php?baja=BAJA=0" ><i class="far fa-calendar-alt"></i> Listado de Personal</a>
                        <br><a target="_blank" class="btn btn-link text-info text-left" href="../personal/personal_anadir.php" ><i class='fas fa-plus-circle'></i> Añadir Personal (empleado)</a>

                           <br><a target="_blank" class="btn btn-link text-info text-left" href="../personal/nominas.php" >Nóminas (pdte)</a>
                        <br><a target="_blank" class="btn btn-link text-info text-left" href="../personal/anuario_bajas.php" >Anuario Bajas (pdte)</a>
                              <br><a target="_blank" class="btn btn-link text-info text-left" href="../personal/personal_importar_personal.php" ><span class="glyphicon glyphicon-open-file"></span> Importar listado Personal de XLS (pdte)</a>

                    </div>
                </div>
            </div>-->
            <!------------------------ GASTOS GENERALES ---------------------->    


            <!--div_#FINANZAS-->  
            <!--  <div class="row">

            <div class="col-sm-12 col-md-4 col-lg-3 float-left">
                <div class='div_ppal_expand'><a target="_blank" class="btn btn-info btn-block btn-lg" 
                                                href="../obras/obras_buscar.php?_m=<?php echo $_m; ?>&tipo_subcentro=G" ><i class="fas fa-hard-hat"></i> Gastos Generales</a></div>
                <div class='div_boton_expand small'><button data-toggle='collapse' class="btn btn-block btn-lg" data-target='#div_gastos_generales'>
                <small>
                <small>
                <i class="fa fa-angle-down" aria-hidden="true"></i>
                </small>
                </small>
                </button>
                </div>   
                <div id='div_gastos_generales' class='collapse in small'>
                    <br><a target="_blank" class="btn btn-link text-info text-left" title='Centro de coste GASTOS GENERALES donde se cargarán todos los gastos generales de la empresa. Alquileres oficinas, asesorías, telefonía, electricidad,  ' href="../obras/obras_ficha.php?_m=<?php echo $_m; ?>&id_obra=<?php echo $id_obra_gg; ?>"  ><?php echo $nombre_obra_gg; ?></a>
                    <br><a target="_blank" class="btn btn-link text-info text-left" title='Centro de coste MANO DE OBRA donde se cargarán todos los gastos del Personal (nóminas, Seg. Social, Finiquitos...) y se abonará a este centro lo cargado por Personal Propio a las obras a través de los Partes Diarios' href="../obras/obras_ficha.php?_m=<?php echo $_m; ?>&id_obra=<?php echo $id_obra_mo; ?>"  ><?php echo $nombre_obra_mo; ?></a>
                    <br><a target="_blank" class="btn btn-link text-info text-left" href="../obras/obras_anadir_form.php"  ><i class="fas fa-plus-circle"></i> Añadir Obra</a>
                    <br><a target="_blank" class="btn btn-link text-info text-left" href="../obras/obras_buscar.php?_m=<?php echo $_m; ?>&tipo_subcentro=O"  ><i class="fas fa-search"></i> Buscar Obra</a>
                          <br><a target="_blank" class="btn btn-link text-info text-left" href="../obras/almacen_obras.php"  >Almacenes de obra</a>
                            <br><a target="_blank" class="btn btn-link text-info text-left" href="../obras/obras_buscar.php?_m=<?php echo $_m; ?>&tipo_subcentro=O" >Obras</a>
                           <br><a target="_blank" class="btn btn-link text-info text-left" href="../pof/menu_pof.php" >Peticion_Ofertas</a>
                           <br><a target="_blank" class="btn btn-link text-info text-left" href="../obras/gastos.php" ><i class="fas fa-shopping-cart"></i> Gastos de Obra</a>
                           <br><a target="_blank" class="btn btn-link text-info text-left" href="../subcontratos.php" ><span class="glyphicon glyphicon-folder-open"></span> Subcontratos(pdte)</a>
                    <br><a target="_blank" class="btn btn-link text-info text-left" href="../obras/obras_fotos.php" ><span class="glyphicon glyphicon-camera"></span> Fotos</a>
                    <br><a target="_blank" class="btn btn-link text-info text-left" href="../obras/obras_prod_detalle.php?_m=<?php echo $_m; ?>&OBRA=SIN_OBRA" title='Permite buscar cualquier unidad de obra de Proyecto de cualquier obra ' >Unidades de Obra</a>

                           <br><a target="_blank" class="btn btn-link text-info text-left" href="../o_prod_gasto.php" >Obras_Prod_Gasto</a>
                          <br><a target="_blank" class="btn btn-link text-info text-left" href="file:\\server\cw\cw_ingenop\multi\diagrama_construwin.jpg"  >diagrama_construwin</a>
                          <br><a target="_blank" class="btn btn-link text-info text-left" href="\\server\cw\cw_ingenop\multi\prueba.pdf" target="_blank" >prueba.pdf</a>
                </div>
            </div>-->

            <!--div_#FINANZAS-->  

                <!--     MENU   #HERRAMIENTAS/CONFIGURACION-->

                <div class="col-sm-12 col-md-4 col-lg-3 float-left">
                    <div class='div_ppal_expand'>

                        <button data-toggle='collapse' class="btn btn-info btn-block btn-lg" data-target='#div_configuracion'>
                           <i class="fas fa-cogs"></i> 
                            Herramientas <i class="fa fa-angle-down" aria-hidden="true"></i>
                        </button>
                    </div>   
                    <div id='div_configuracion' class='collapse in small'>
                        <br>
                        <a target="_blank" class="btn btn-link text-info text-left" href="../documentos/documentos.php"  >
                            <i class="far fa-file-alt"></i> 
                            Documentos <?php echo   "<sup class='bg-info small px-0 px-sm-1'>$num_documentos</sup>"; ?></a>
                        <br>
                        <a target="_blank" class="btn btn-link text-info text-left" href="../documentos/documentos.php?_m=<?php echo $_m; ?>&clasificar=1" title='Documentación que se ha subido a la plataforma y aún no ha sido tramitada o archivada en su lugar. P. ej. la foto de albarán enviado opr movil desde la propia obra. '>
                            <i class="far fa-file-alt"></i>
                            Docs. pdtes. Clasificar<?php echo badge($num_documentos_pdte_clasif); ?> 
                        </a>
                        <br>
                        <a target="_blank" class="btn btn-link text-info text-left" href="../configuracion/usuario_ficha.php" >
                            <i class="far fa-user"></i> 
                            Mi Usuario <?php echo " ({$_SESSION["user"]})"; ?>
                        </a>
                        <br>
                        <a target="_blank" class="btn btn-link text-info text-left" href="../configuracion/empresa_ficha.php" >
                            <i class="fas fa-building"></i> 
                            Mi Empresa <?php echo " ({$_SESSION["empresa"]})"; ?></a>
                        <br>
                        <a target="_blank" class="btn btn-link text-info text-left" href="../configuracion/usuario_anadir.php" >
                            <i class="fas fa-user-plus"></i> 
                            añadir usuario
                        </a>
                        <br>
                        <a target="_blank" class="btn btn-link text-info text-left" href="../include/tabla_general.php?url_enc=<?php echo encrypt2("select=id_usuario,usuario,email,online,activo,autorizado,permiso_licitacion,permiso_obras,permiso_administracion,permiso_bancos,user,fecha_creacion&tabla=Usuarios_View&where=activo AND id_c_coste=$id_c_coste&link=../configuracion/usuario_ficha.php?id_usuario=&campo=usuario&campo_id=id_usuario") ; ?>" >
                            <i class="far fa-user"></i> 
                            Usuarios empresa<?php echo "($num_usuarios/{$limites["usuarios"]})"; ?>
                        </a>
                        <br>
                        <a target="_blank" class="btn btn-link text-info text-left" href="../menu/menu_app.php" >
                            MENU APP
                        </a>

<?php
if ($admin)  
{                 // MENU SOLO PARA #ADMIN
    ?>     

                            <br>
                            <a target="_blank" class="btn btn-link text-info text-left" href="../include/tabla_general.php?_m=<?php echo $_m; ?>&url_enc=<?php echo encrypt2("tabla=w_Accesos&where=id_c_coste='$id_c_coste'&order_by=fecha_creacion DESC LIMIT 500") ?>"> 
                                Accesos empresa<span class='badge progress-bar-info'> admin</span>
                            </a>
                            <br>
                            <a target="_blank" class="btn btn-link text-info text-left" href="../include/tabla_general.php?_m=<?php echo $_m; ?>&url_enc=<?php echo encrypt2("tabla=w_Accesos&where=id_c_coste='$id_c_coste' AND resultado LIKE '%Error%'&order_by=fecha_creacion DESC LIMIT 500") ?>" >
                                Accesos empresa con Error<span class='badge progress-bar-info'> admin</span>
                            </a>
                            <br>
                            <a target="_blank" class="btn btn-link text-info text-left" href="../include/tabla_general.php?_m=<?php echo $_m; ?>&tabla=w_Accesos&where=1&order_by=fecha_creacion DESC LIMIT 500" >
                                Accesos Global<span class='badge progress-bar-info'> admin</span>
                            </a>
                            <br>
                            <a target="_blank" class="btn btn-link text-info text-left" href="../include/tabla_general.php?_m=<?php echo $_m; ?>&tabla=<?php echo encrypt2('w_Accesos'); ?>&where= resultado LIKE '%Erro%'&order_by=fecha_creacion DESC LIMIT 500" >
                                Accesos Global con Error<span class='badge progress-bar-info'> admin</span>
                            </a>
                            <br>
                            <a target="_blank" class="btn btn-link text-info text-left" href="../include/tabla_debug.php" >
                                Tabla DEBUG<span class='badge progress-bar-info'> admin</span>
                            </a>
                            <br>
                            <a target="_blank" class="btn btn-link text-info text-left" href="../configuracion/debug_ppal.php" >
                                Debug_ppal<span class='badge progress-bar-info'> admin</span>
                            </a>
                            <br>
                            <a target="_blank" class="btn btn-link text-info text-left" href="../debug/debug_vars.php" >
                                Debug_vars<span class='badge progress-bar-info'> admin</span>
                            </a>
                            <br>
                            <a target="_blank" class="btn btn-link text-info text-left" href="../debug/debug.php" >
                                Debug<span class='badge progress-bar-info'> admin</span>
                            </a>
                            <br>
                            <a target="_blank" class="btn btn-link text-info text-left" href="../pruebas/phpinfo.php" >
                                Php_info()<span class='badge progress-bar-info'> admin</span>
                            </a>
                            <br>
                            <a target="_blank" class="btn btn-link text-info text-left" href="../include/tabla_debug.php?url_enc=<?php echo encrypt2("sql=SELECT * FROM Usuarios WHERE 1=1 ORDER BY id_usuario&link=../configuracion/usuario_ficha.php?id_usuario=&link_campo=usuario&link_campo_id=id_usuario") ?>" >
                                <i class="far fa-user"></i><i class="fas fa-globe-europe"></i>
                                Usuarios Global<span class='badge progress-bar-info'> admin</span>
                            </a>
                            <br>
                            <a target="_blank" class="btn btn-link text-info text-left" href="../include/tabla_debug.php?url_enc=<?php echo encrypt2("sql=SELECT * FROM Empresas_View_ext ORDER BY ultimo_acceso DESC LIMIT 50&link=../configuracion/empresa_ficha.php?id_empresa=&link_campo=C_Coste_Texto&link_campo_id=id_c_coste") ?>" >
                                <span class="glyphicon glyphicon-home"></span>
                                <i class="fas fa-globe-europe"></i>
                                Empresas Global<span class='badge progress-bar-info'> admin</span>
                            </a>
                            <br>
                            <a target="_blank" class="btn btn-link text-info text-left" href="../include/tabla_debug.php?url_enc=<?php echo encrypt2("sql=SELECT * FROM tipos_licencia &tabla_update=tipos_licencia&id_update=id") ?>" >
                                Tipos de licencias<span class='badge progress-bar-info'> admin</span>
                            </a>
                            <br>
                            <a target="_blank" class="btn btn-link text-info text-left" href="../configuracion/config_variables.php" >
                                Configuración Variables<span class='badge progress-bar-info'> admin</span>
                            </a>
                            <br>
                            <a target="_blank" class="btn btn-link text-info text-left" href="../include/tabla_debug.php?url_enc=<?php echo encrypt2("sql=SELECT * FROM logs_db ORDER BY id DESC LIMIT 200") ?>" >
                                Logs_db<span class='badge progress-bar-info'> admin</span>
                            </a>
                            <br>
                            <a target="_blank" class="btn btn-link text-info text-left" href="../include/sign_src/my_sign.php" >
                                Signature Pad<span class='badge progress-bar-info'> admin</span>
                            </a>


    <?php
}
?>
                    </div>
                </div>
                
                <!--          SALTA LINEA POR CUMPLIR CON 4 COLs           -->
                <div class="clearfix"></div>
                <!--          SALTA LINEA POR CUMPLIR CON 4 COLs           -->
                
                <!--          #AYUDA           -->
                <div class="col-sm-12 col-md-4 col-lg-3 float-left">
                    <div class='div_ppal_expand'>
                      
                        <button data-toggle='collapse' class="btn btn-info btn-block btn-lg" data-target='#div_ayuda'>
                            <span class="glyphicon glyphicon-question-sign"></span>
                            Ayuda <i class="fa fa-angle-down" aria-hidden="true"></i>
                        </button>
                    </div>   
                    <div id='div_ayuda' class='collapse in small'>
                        <br>
                        <a target="_blank" class="btn btn-link text-info text-left" href="../img/diagrama_construwin.jpg" >
                            <i class="fas fa-image"></i>
                            Diagrama
                        </a>
                        <br>
                        <a target="_blank" class="btn btn-link text-info text-left" href="../agenda/procedimientos.php" >
                            <i class="fas fa-book"></i>
                            Procedimientos<?php echo badge($num_procedimientos,'info'); ?> 
                        </a>
                        <br>
                        <a target="_blank" class="btn btn-link text-info text-left" href="https://www.youtube.com/channel/UCHnW4ZAPAYxWQ6rRzUmS_tw" >
                            <i class="fab fa-youtube"></i>
                            Video tutoriales Youtube
                        </a>
                        <br>
                        <a target="_blank" class="btn btn-link text-info text-left" title='Foro donde consultar dudas con los administradores y otros usuarios, informar de errores, sugerencias...' href="https://foro.construcloud.es" >
                            <i class="fas fa-users"></i>
                            ConstruCloud Forum
                        </a>
                        <br>
                        <a target="_blank" class="btn btn-link text-info text-left" title='Wikipedia de ConstruCloud.es donde consultar definiciones, procedimientos, de todas las entidades...' href="https://wiki.construcloud.es" >
                            <i class="fab fa-wikipedia-w"></i>
                            ConstruWIKI 
                        </a> 
                        <br>
<!--                        <a target="_blank" class="btn btn-link text-info text-left" href="../include/tabla_general.php?url_enc=<?php echo encrypt2("tabla=historial&where=Tipo_cambio LIKE '%PHP%' &campo=titulo&campo_id=id&link=../include/ficha_general.php?tabla=historial__AND__id_update=id__AND__id_valor=") ?>" >
                             Versiones
                        </a>-->

                    </div>          
                </div>  

                    
            </div>
            <!--****************** ESPACIO CENTRAL  *****************-->
        </div>
        <!-- MENU container-fluid -->
<?php 

//FIN
include_once('../templates/_inc_privado3_footer.php');
