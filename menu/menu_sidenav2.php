<style>

   

    .sidenav {
        height: 100%;
        width: 0;
        position: fixed;
        z-index: 1;
        top: 0;
        left: 0;
        background-color: #FFFFFF;  /* #111; */
        overflow-x: hidden;
        transition: 0.2s;
        padding-top: 60px;
    }
    .sidenav p {
        padding: 4px;
        text-decoration: none;
        font-size: 45px;
        color: #f1f1f1;       /* #818181; */
        display: block;
        transition: 0.3s;
    }

    .sidenav a {
        padding:  16px 16px 16px 32px;
        text-decoration: none;
        font-size: 40px;
        color: #818181;
        display: block;
        transition: 0.3s;
        border: 1px solid #f1f1f1;
    }

    .sidenav a:hover {
        /*color: #f1f1f1;*/
    }

    .sidenav .closebtn {
        position: absolute;
        top: 0;
        right: 25px;
        font-size: 90px;
        margin-left: 50px;
        border: none;
    }

    /* Caso pantalla Escritorio */
    @media screen and (min-width: 981px) {
        .sidenav {padding-top: 15px;
                  /*  width: 200px;  */
                  width: 0px; 
                  background-color: #FFFFFF;
        }
        /* .sidenav .closebtn {display: none;}    */

        .sidenav a {font-size: 18px;
                    color: #111 ;
                    padding: 4px;}
        .sidenav p {font-size: 18px;
                    border-style: dotted;
                    color: #111;
                    padding: 4px;
                    background-color: #f1f1f1; }

        
    }
</style>

<?php 


if (!$_SESSION["invitado"])     // NO MOSTRAMO MENUS A PERFILES INVITADOS

{

?>


<div id="mySidenav" class="sidenav" style='float:left'  >
    <a href="javascript:void(0)" class="closebtn" onclick="closeNav()">&times;</a>
    <a href="javascript:void(0)"  onclick="closeNav()">&#9776; Menu</a>	

    
    <a href="<?php echo $dir_raiz; ?>menu/pagina_inicio.php">Inicio</a>	
    <p>Empresa:  <font color=blue><?php echo $_SESSION["empresa"]; ?></font><br>
        id_c_coste:  <font color=blue><?php echo $_SESSION["id_c_coste"]; ?></font><br>
        Usuario:   <font color=blue><?php echo $_SESSION["user"]; ?></font>
     <a href="<?php echo $dir_raiz; ?>registro/cerrar_sesion.php" >Cerrar sesión</a></p>

  
        <p>REGISTROS</p>
        
        <a href="<?php echo $dir_raiz; ?>proveedores/albaran_anadir_form.php">Añadir Vale</a>
        <a href="<?php echo $dir_raiz; ?>partes/parte_nuevo.php" >Añadir Parte Diario</a>
        <a href="<?php echo $dir_raiz; ?>proveedores/fra_prov_anadir_form.php"  >Añadir Factura Proveedor</a>
        <a href="<?php echo $dir_raiz; ?>estudios/ofertas_clientes.php" >Ofertas_Clientes</a>

        <p>ESTUDIOS LICITACIONES</p>
        <A href="<?php echo $dir_raiz; ?>estudios/estudios_nuevo.php"  >Añadir estudio</A>
        <a href="<?php echo $dir_raiz; ?>estudios/estudios_buscar.php" >Buscar</a>
        <a href="<?php echo $dir_raiz; ?>estudios/estudios_calendar.php?fecha=<?php echo date("Y-m-d"); ?>" >Calendario Licitaciones</a>
        <a href="<?php echo $dir_raiz; ?>estudios/ofertas_clientes.php" >Ofertas_Clientes</a>

        <p>OBRAS</p>

        <a href="<?php echo $dir_raiz; ?>obras/obras_buscar.php?tipo_subcentro=O" >Obras</a>
        <a href="<?php echo $dir_raiz; ?>pof/menu_pof.php" >Peticion_Ofertas</a>
        <a href="<?php echo $dir_raiz; ?>obras/gastos.php" >Gastos</a>
        <a href="<?php echo $dir_raiz; ?>subcontratos.php" >Subcontratos</a>
        <a href="<?php echo $dir_raiz; ?>fotos_dias.php" >Fotos</a>
        <a href="<?php echo $dir_raiz; ?>o_prod_gasto.php" >Obras_Prod_Gasto</a>

        <p>MAQUINARIA</p>

        <a href="<?php echo $dir_raiz; ?>obras/obras_buscar.php?tipo_subcentro=M" >Maquinas</a>                    <!-- PDTE MODIFICAR obras_buscar -->
        <a href="<?php echo $dir_raiz; ?>maquinas/cuadro_maquinas.php" >Presencia_Mensual</a>
        <a href="<?php echo $dir_raiz; ?>explomaquinas.php" >Explomaquinas</a>

        <p>PERSONAL</p>

        <a href="<?php echo $dir_raiz; ?>fichas_personal.php" >Fichas_Personal</a>
        <a href="<?php echo $dir_raiz; ?>partes_personal.php" >Partes-Personal</a>
        <a href="<?php echo $dir_raiz; ?>anuario_bajas.php" >Anuario_Bajas</a>

        <p>TERCEROS</p>

        <a href="<?php echo $dir_raiz; ?>proveedores/proveedores_buscar.php"  >Proveedores</a>
        <a href="<?php echo $dir_raiz; ?>clientes/clientes_buscar.php" >Clientes</a>



        <p>BANCOS</p>

        <a href="<?php echo $dir_raiz; ?>bancos/bancos_ctas_bancos.php?activo=on" >Cuentas Bancarias</a>
        <a href="<?php echo $dir_raiz; ?>fras_clientes.php" >fras_clientes</a>

        <a href="<?php echo $dir_raiz; ?>tabla.php?tabla=bancos_avales&titulo=Lineas_de_Avales&wherecond=1=1&primarykey=id_linea_avales" >Lineas_Avales</a>
        <a href="<?php echo $dir_raiz; ?>avales_anuario.php" >avales_anuario</a>
        <a href="<?php echo $dir_raiz; ?>pagos_calendar.php" >pagos_calendario</a>
        <a href="<?php echo $dir_raiz; ?>pagos_anuario.php" >Tesoreria</a>
        <a href="<?php echo $dir_raiz; ?>cobros_anual.php" >Anuario_Cobros</a>

        <p>UTILIDADES</p>          

        <a href="<?php echo $dir_raiz; ?>utilidades/agenda.php" >Agenda</a>
        <a href="<?php echo $dir_raiz; ?>utilidades/mensaje_nuevo.php" >Mensaje_nuevo</a>
        <a href="<?php echo $dir_raiz; ?>tels.php" >Telefonos</a>
        <a href="<?php echo $dir_raiz; ?>eventos_calendar.php" >Eventos_Mes</a>
        <a href="<?php echo $dir_raiz; ?>eventos_anual.php" >Eventos_anno</a>
        <a href="<?php echo $dir_raiz; ?>Accesos.php" >Acceso_Escritorio</a>
        <a href="<?php echo $dir_raiz; ?>utilidades/accesos_web.php" >Acceso_Web</a>
        <a href="<?php echo $dir_raiz; ?>procedimientos.php" >Procedimientos</a>
        <a href="<?php echo $dir_raiz; ?>tabla.php?tabla=Clientes_comercial&wherecond=1=1&primarykey=id" >Clientes_Comercial</a>
        <a href="<?php echo $dir_raiz; ?>clientes/BDProveedores/provee_consulta.php" >BD_Proveedores</a>

        <p>CONFIGURACION</p>

        <a href="<?php echo $dir_raiz; ?>config/agenda.php"  title="(password,email notif., foto, )" >Mi perfil</a>
        <a href="<?php echo $dir_raiz; ?>config/agenda.php" >Usuarios</a>
        <a href="<?php echo $dir_raiz; ?>config/mensaje_nuevo.php" title="Datos de c.coste.perfil de empresa" >Centro de Coste</a><br>
        <a href="<?php echo $dir_raiz; ?>config/mensaje_nuevo.php" title="Licencia actual e historico.facturas.aumento lic.">Licencia de uso</a><br>
        <a href="<?php echo $dir_raiz; ?>configuracion/config_variables.php" title="Datos generales de la empresa" >Variables de entorno</a>
        
        <a href="<?php echo $dir_raiz; ?>registro/cerrar_sesion.php"  >Cerrar sesión</a><br><br>
  
        <p>PRUEBAS</p>  
        <a href="https://api.whatsapp.com/send?text=Contacto%20retirada%20de%20amianto%20https%3A%2F%2Fdesamiantado.net%2Fcontacto-retirada-de-amianto%2F">WHASSAP</a>
        <a href="<?php echo $dir_raiz; ?>pruebas/api_caixa.php">Api caixa</a>
        <a href="<?php echo $dir_raiz; ?>pruebas/expresiones/index.php">Evaluar expresiones</a>
        <a href="<?php echo $dir_raiz; ?>pruebas/tcpdf/examples/parte_pdf2.php">PDF_parte2 tcpdf</a>
        <a href="<?php echo $dir_raiz; ?>personal/parte_pdf2.php">PDF_parte2 tcpdf</a>
        <a href="<?php echo $dir_raiz; ?>pruebas/PDF_htmldoc_prueba.php">PDF_ htmldoc_prueba</a>
        <a href="<?php echo $dir_raiz; ?>pruebas/Facturae/tests/Facturae.php">Facturae iniciop</a>
        <a href="<?php echo $dir_raiz; ?>pruebas/bootstrap.pagina.inicio.php">bootstrapagina iniciop</a>	
   <a href="<?php echo $dir_raiz; ?>prueba_modal/index.php">preuba modal</a>	
    <a href="<?php echo $dir_raiz; ?>pruebas/tcpdf/examples/index.php">TCPDF free class</a>	
    <a href="<?php echo $dir_raiz; ?>pruebas/pdf2.php">prueba de descarga de PDF desde servidor a cliente pdf2</a>	
    <a href="<?php echo $dir_raiz; ?>pruebas/alert_notif.php">alert_notif</a>	
    <a href="<?php echo $dir_raiz; ?>pruebas/index.php">ventanas emergentes</a>	
    <a href="<?php echo $dir_raiz; ?>pruebas/toastr.php">toastr.php</a>	
    <a href="<?php echo $dir_raiz; ?>pruebas/c43_test.php">c43_test.php</a>	
    <a href="<?php echo $dir_raiz; ?>pruebas/bootstrap.php">bootstrap</a>	
    <a href="<?php echo $dir_raiz; ?>pruebas/sendemail.php">sendemail</a>	
    <a href="<?php echo $dir_raiz; ?>pruebas/phpmailer/test.php">phpmailer</a>	
    <a href="<?php echo $dir_raiz; ?>pruebas/zip.php">zip</a>	
    <a href="<?php echo $dir_raiz; ?>pruebas/upload_form.php">upload</a>	
    <a href="<?php echo $dir_raiz; ?>pruebas/tabla.php">tabla</a>	
    <a href="<?php echo $dir_raiz; ?>pruebas/s_server.php">$_SERVER</a>	
    <a href="<?php echo $dir_raiz; ?>pruebas/media.php">media</a>	
    <a href="<?php echo $dir_raiz; ?>pruebas/prueba_conexion.php" >prueba conexion</a>	
    <a href="<?php echo $dir_raiz; ?>pruebas/phpmysqlezedit.php" >ABRE TABLA phpmysqlezedit</a>	
    <a href="<?php echo $dir_raiz; ?>pruebas/mdb.php" >Apruebas Mdb</a>	
    <a href="<?php echo $dir_raiz; ?>pruebas/phpinfo.php" >phpinfo()</a>	
    <a href="<?php echo $dir_raiz; ?>pruebas/excel.php" >prueba excel</a>	
    <a href="<?php echo $dir_raiz; ?>pruebas/menu/menu_responsive.php" >menu_responsive</a>		
    <a href="<?php echo $dir_raiz; ?>pruebas/menu/menu_responsive2.php" >menu_responsive2</a>
    <a href="<?php echo $dir_raiz; ?>pruebas/menu/menu_responsive3.php" >menu_responsive3</a>
    <a href="<?php echo $dir_raiz; ?>pruebas/menu/menu_responsive4.php" >menu_responsive4</a>
        <a href="<?php echo $dir_raiz; ?>pruebas/menu/table_responsive.php" >menu sidenav y table_responsive</a>	

        </div>	

<div class='noprint'><span style="font-size:50px;cursor:pointer" onclick="openNav()">&#9776; Menu</span></div>

        <script>
            function openNav() {
                document.getElementById("mySidenav").style.width = "320px";
                document.getElementById("main").style.marginLeft = "320px";
            }

            function closeNav() {
                document.getElementById("mySidenav").style.width = "0";
                document.getElementById("main").style.marginLeft = "0";
            }
        </script>
        
        
 <?php
  require_once("../menu/topbar.php");

}

?>