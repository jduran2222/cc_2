<?php
//if (!$_SESSION["invitado"])     // NO MOSTRAMO MENUS A PERFILES INVITADOS
if (1)     // suspendemos lo de perfiles de Invitados
{

// VARIABLES DE SITUACION    
$id_proveedor_auto = getvar("id_proveedor_auto");
    
$num_proveedores=Dfirst("count(id_proveedores)","Proveedores", $where_c_coste	) ;
$num_clientes=Dfirst("count(id_cliente)","Clientes", $where_c_coste	) ;
$num_obras=Dfirst("count(id_obra)","OBRAS", " tipo_subcentro='O' AND $where_c_coste"	) ;
$num_estudios=Dfirst("count(id_estudio)","Estudios_de_Obra", $where_c_coste	) ;
$num_maquinaria=Dfirst("count(id_obra)","OBRAS", " tipo_subcentro='M' AND $where_c_coste"	) ;
$num_usuarios=Dfirst("count(id_usuario)","Usuarios", $where_c_coste 	) ;
$num_empleados=Dfirst("count(id_personal)","PERSONAL", $where_c_coste 	) ;
$num_documentos=Dfirst("count(id_documento)","Documentos", $where_c_coste	) ;
$num_documentos_pdte_clasif=Dfirst("count(id_documento)","Documentos", "tipo_entidad='pdte_clasif' AND $where_c_coste"	) ;
$num_conceptos=Dfirst("count(id_concepto)","CONCEPTOS", "id_proveedor=" . getvar("id_proveedor_auto")) ;
$num_fras_prov=Dfirst("count(ID_FRA_PROV)","Fras_Prov_Listado", "$where_c_coste"	) ;
$num_fras_cli=Dfirst("count(ID_FRA)","Fras_Cli_Listado", $where_c_coste	) ;
$num_remesa_pagos=Dfirst("count(id_remesa)","Remesas_listado", $where_c_coste ." AND activa=1 AND tipo_remesa='P'"	) ;
$num_remesa_cobros=Dfirst("count(id_remesa)","Remesas_listado", $where_c_coste ." AND activa=1 AND tipo_remesa='C'"	) ;
$num_ctas_bancos=Dfirst("count(id_cta_banco)","ctas_bancos", $where_c_coste 	) ;

$num_avales_pdtes=Dfirst('count(ID_AVAL)','Avales',"$where_c_coste AND F_Recogida <= NOW() AND Recogido=0 AND Solicitado=0 ") ;
$num_documentos_pdte_clasif = Dfirst("count(id_documento)", "Documentos", "tipo_entidad='pdte_clasif' AND $where_c_coste");
$num_fras_prov_NR = Dfirst("count(ID_FRA_PROV)", "Fras_Prov_Listado", "ID_PROVEEDORES=$id_proveedor_auto AND $where_c_coste");
$num_procedimientos = Dfirst("count(id_procedimiento)", "Procedimientos", " $where_c_coste AND Obsoleto=0 " );

$fecha_inicio=date('Y-01-01') ;

if (!$path_logo_empresa = Dfirst("path_logo", "Empresas_Listado", "$where_c_coste")) {$path_logo_empresa = "../img/no_logo_empresa.jpg";} ;

if (isset($_SESSION["adminlte"]) AND $_SESSION["adminlte"])
 {
    
    
    
    
    
    require_once("../adminlte/adminlte_header.php");}

     
    ?>
    <style>
#migas {
    
/*   height:35px;
   width:100%;*/
   position: fixed;
   top: 70px;
  
   /*float:left;*/
   background-color:lightblue ;
   z-index: 5;    

}    

#topbar {
    /*border:1px solid blue ;*/ 
    height:35px;
    width:100%;
    position: fixed;
    top: 0px;

    float:left;z-index: 3 ;
    background-color:lightgray ;
}    

@media only screen and (max-width:980px) {
    /* For mobile phones: antes 500px */
    /*   #tabla_ficha2 {
        font-size: 2.2vw; 
      }*/

    #topbar {
        height:100px;

    }   
/*            #btn_empresa, #btn_usuario  {
        display:none
    }*/
    .btn_topbar {
        /*font-size: 180px; display: fixed;*/  
        /*width: 130px ;*/
        width: 10% ;
        /*height: 150px ;*/
        /*border-color: blue ;*/
        z-index: 2;    
    } 

    #cerrar_sesion {
        font-size: 3vw; 
    }
    .btn_topbar_cerrar {
        font-size: 20px; display: fixed;  
        /*color: infotext;*/
        /*width: 100px ;*/
        height: 20px ;
        z-index: 2;

    } 
/*            .btn_topbar .c_text {
        display: none;     
    } */
    .c_text {
        display: none;     
    } 
/*            a.dentro_tabla_ficha {
        font-size: 6vw; 
    }*/
/*            a.btn_topbar {
        font-size: 6vw; 
    }*/

}     


    </style>
    
<!-- MIGRACION A LTE  SISTEMA NAV NO FUNCIONA BIEN
<nav class="navbar navbar-inverse navbar-fixed-top">
  <div class="container-fluid">
    <div class="navbar-header">
      <a class="navbar-brand" href="#">WebSiteName</a>
    </div>
    <ul class="nav navbar-nav">
      <li class="active"><a href="#">Home</a></li>
      <li><a href="#">Page 1</a></li>
      <li><a href="#">Page 2</a></li>
      <li><a href="#">Page 3</a></li>
    </ul>
  </div>
</nav>-->
    
    <div  id='topbar'  >
        
        
        <button class='btn_topbar btn btn-link btn-lg noprint' data-widget="pushmenu" role="button" ><i class="fas fa-bars"></i></button>
<!--        <button  class='btn_topbar btn btn-link btn-xs noprint'  onclick="window.open('../menu/pagina_inicio.php')">
            <span class="glyphicon glyphicon-home"></span>
            <span class='c_text'> inicio</span>
        </button>-->
        <button  class='btn_topbar btn btn-link btn-xs noprint'  onclick='busqueda_global();'>
            <i class="fas fa-search"></i>
            <span class='c_text'> busqueda</span>
        </button>
        <button  class='btn_topbar btn btn-link btn-xs noprint' title='Imprimir'   onclick='window.print();'>
            <i class="fas fa-print"></i>
            <!--<span class='c_text'> imprimir</span>-->
        </button>
        <button  class='btn_topbar btn btn-success btn-xs noprint' onclick='javascript:window.location.reload();'>
            <i class="fas fa-redo"></i>
            <span class='c_text'> refrescar</span>
        </button>
        <button  class='btn_topbar btn btn-warning btn-xs noprint'  onclick='javascript:window.close();'>
            <i class='far fa-window-close'></i>
            <span class='c_text'> cerrar</span>
        </button>


    <?php
    if ($admin)
//    if (0)   // ANULADO PROVISIONALMENTE MIENTAS NO ESTÉ EN ÉPOCA DE DESARROLLO
    {

        // Botones Debug y Reset
        ?>

            <button  class='btn_topbar btn btn-link btn-xs noprint c_text'  onclick="window.open('../debug/debug_logs.php')">
                <i class="fab fa-dyalog"></i><span class='c_text'>ebug</span>
            </button>
            <button  class='btn_topbar btn btn-link btn-xs noprint c_text'  onclick="window.open('../debug/debug_reset.php')">
                <i class="fas fa-registered"></i><span class='c_text'>eset</span>
            </button>

        <?php
    }
    // fin botones Dbug y Reset
    // Inicio botones empresa / usuario
    ?>

        <button id='btn_empresa'  class='btn_topbar btn btn-link btn-xs  noprint'  onclick="window.open('../configuracion/empresa_ficha.php')" 
                 title='ver ficha Empresa'>
           <i class="fas fa-building"></i> <span class='c_text' > <?php echo $_SESSION["empresa"] ?></span>
        </button>
        <span class='noprint c_text'>/</span>
        <button id='btn_usuario'  class='btn_topbar btn btn-link btn-xs  noprint'  onclick="window.open('../configuracion/usuario_ficha.php')" 
                title='ver ficha Usuario'>
           <i class="far fa-user"></i> <span class='c_text' >  <?php echo $_SESSION["user"];
    if ($admin AND 0) { echo " <small>(admin)</small>";}
    echo (isset($_SESSION['android']) ? (($_SESSION['android']) ? '<small>android </small>' : '<small> pc</small>' ) : '<small> pc</small>' );
    ?></span>
        </button>





<!--    
ANULADO PROVISIONALMENTE POR ESTORBAR AL MENU OBRAS Y DEMÁS   (juand, agosto.19)
      <button id='cerrar_sesion' class='btn btn-link btn-xs noprint' style='float: right;color: grey ;' onclick="cerrar_sesion()"> 
            <span class="glyphicon glyphicon-off"></span>
            <span > cerrar sesion</span>
            <script language="javascript" type="text/javascript">

                document.writeln("<br>" + screen.width + "x" + screen.height);  // indicamos las dimensiones de pantalla

            </script>      
        </button>
--> 
<?php

//tareas
$tareas = Dfirst("count(id)", "Tareas_View", "$where_c_coste AND Terminada=0 AND usuarios LIKE '%{$_SESSION["user"]}%' " );
$fecha_tareas_vistas=Dfirst("fecha_tareas_vistas","Usuarios_View"," $where_c_coste AND id_usuario={$_SESSION["id_usuario"]} " ) ;
$tareas_new = Dfirst("count(id)", "Tareas_View", "$where_c_coste AND Terminada=0 AND usuarios LIKE '%{$_SESSION["user"]}%' AND fecha_modificacion > '$fecha_tareas_vistas' " );

echo "<a target='_blank' class='btn_topbar btn btn-link btn-xs noprint'  href='../agenda/tareas.php' >"
. "<i class='fab fa-tumblr'></i><span class='c_text'>areas</span>". badge($tareas,'info') . badge($tareas_new,'danger') . " </a>" ;




// portafirmas
$portafirmas = Dfirst("count(id_firma)", "Firmas_View", " $where_c_coste AND pdte AND id_usuario={$_SESSION["id_usuario"]} " );
 echo "<a target='_blank' class='btn_topbar btn btn-link btn-xs noprint' href='../agenda/portafirmas.php' ><i class='fas fa-pen-nib'></i>"
. "<span class='c_text'> PortaFirmas</span>". badge($portafirmas,'danger') . "</a>" ;


//    if ($_SESSION["admin_chat"])   
//    {
////         $chat_users_online=Dfirst("COUNT(id_usuario)","Usuarios","online=1 AND admin_chat=0") ;
//         $chat_users_online=Dfirst("COUNT(id_usuario)","Usuarios","online=1") ;
//         $chat_pendientes=Dfirst("COUNT(chatid)","chat","reciever_userid='{$_SESSION["id_usuario"]}' AND status = '1' ") ;
//         echo "<button style='float: right;' class='btn_topbar btn btn-link btn-xs noprint ' onclick=\"window.open('../chat/chat_index.php')\" > "
//                          . "<i class='far fa-comments'></i><span class='c_text'>"
//                 . " chat admin". badge($chat_users_online,'info') .badge($chat_pendientes)."</span></button>"  ;
//    }else
//    {
////         $chat_admin_online=Dfirst("COUNT(id_usuario)","Usuarios","online=1 AND admin_chat!=0") ;   
//         $chat_pendientes=Dfirst("COUNT(chatid)","chat","reciever_userid='{$_SESSION["id_usuario"]}' AND status = '1' ") ;
//         // hay administradores online?
//         echo "<button style='float: right;' class='btn_topbar btn btn-link btn-xs noprint' onclick=\"window.open('../chat/chat_index.php')\" "
//         . "title='' >"
//         . "<i class='far fa-comments'></i><span class='c_text'> chat".badge($chat_pendientes)."</span></button>"  ;
//    }    


$chat_pendientes=Dfirst("COUNT(chatid)","chat","reciever_userid='{$_SESSION["id_usuario"]}' AND status = '1' ") ;

if ($_SESSION["admin_chat"])   
{
    $chat_users_online=Dfirst("COUNT(id_usuario)","Usuarios","online=1") ;
    $badge_txt=badge($chat_users_online,'info') .badge($chat_pendientes,'danger') ;
} else
{
    $badge_txt=badge($chat_pendientes,'danger') ;    
}



 echo "<button  class='btn_topbar btn btn-link btn-xs noprint ' onclick=\"window.open('../chat/chat_index.php')\" > "
                  . "<i class='far fa-comments'></i><span class='c_text'>"
         . " chat </span>$badge_txt</button>"  ;
    
    

?>
        
         
<!--        /// ANULADO TEMPORALMENTE, ESTORBA EN USO EN MOVIL, puesto en uso, ene20-->
<!--      <button style='float: right;' class='btn_topbar btn btn-link btn-xs noprint c_text' title='chat' onclick="window.open('../chat/chat_index.php')">
            <i class='far fa-comments'></i>
            <span class='c_text'> chat<?php //   $chat_pendientes=Dfirst("COUNT(chatid)","chat","reciever_userid='{$_SESSION["id_usuario"]}' AND status = '1' "); ;
//                                              echo badge($chat_pendientes)?></span>
          </button>
           <button style='float: right;' class='btn_topbar btn btn-link btn-xs noprint c_text'  onclick="window.open('../menu/contactar.php')">
            <i class="far fa-envelope"></i>
            <span class='c_text'> contactar</span>
        </button>-->




</div>   

<!--FIN TOPBAR-->

<?php

 ////////////// #MIGAS
 //
//ANULADO PROVISIONALENTE PARA QUE NO ESTORBE (juand, sep19), repuesto en abril20
echo "<div id='migas' class='noprint'>" ;
echo isset($_m)? str_replace("_", " ",$_m )  : ""      ;
echo "</div>" ;

?>





  <!--#CHAT #SOPORTE-->  
    
<div style="position:fixed; bottom:0; right:0;background-color: lightblue;z-index: 30 ;" class='noprint'>
    <div style="padding:5px;cursor:pointer;text-align:center;font-size:20px"   onclick="$('#chat_textarea').toggle(200);" >
        <p><i class='far fa-comments'></i><span class='c_text'> chat soporte </span> </p></div>
        
<div style='display:none;z-index: 3 ;' id='chat_textarea'>
    <br><textarea onfocus="$('#mensaje_enviado').hide();" row='10' cols='28'  id='chat_soporte' placeholder="Hola, bienvenido a ConstruCloud.es ¿en qué podemos ayudarte?"/></textarea>
<br><button style='float:right'  class='btn_topbar btn btn-link btn-xs noprint' onclick='chat_send_soporte()'>enviar</button>
<div id="mensaje_enviado" style='display: none;z-index: 3 ;'>Mensaje enviado, recibirá respuesta en su chat</div>
</div>
</div>

<script> 
function chat_send_soporte(){
            
	var message = $("#chat_soporte").val();
//	message = "Hola\nEsto es otra linea.\n\nSaludos" ;
//	var message = message1.replace(/\n/g,"<br>");   // lo hacemos en el servidor en PHP
//	
//        alert(message) ;
       
//	message = 'juan duran';
//	$('.message-input input').val('');
//                        alert('ALERT');

	$('#chat_textarea').val('');
	if($.trim(message) == '') {
		return false;
	}
        $('#mensaje_enviado').show();
	$.ajax({
		url:"../chat/chat_action.php",
		method:"POST",
		data:{chat_message:message, action:'insert_soporte'},
		dataType: "json",
		success:function(response) {
//                      $('#mensaje_enviado').show();
//			var resp = $.parseJSON(response);			
//			$('#conversation').html(resp.conversation);	
//			$('#conversation').html(response.conversation);	
//			$('#conversation').html('HOLA SOY JUAN');	
//                        alert('ALERT');
//			$(".messages").animate({ scrollTop: $('.messages').height() }, "fast");
//                        $("#conversation").scrollTop($("#conversation").scrollHeight);
//                        $("#conversation").scrollTop(50000);
//                        alert( $("#conversation").scrollHeight );
		}
	});    
            
        }
        
        
        function busqueda_global() {

            var nuevo_valor = window.prompt("Busqueda global de ");
    //    alert("el nuevo valor es: "+valor) ;
            if (!(nuevo_valor === null))
            {
                window.open("../menu/busqueda_global.php?filtro=" + encodeURIComponent(nuevo_valor), '_blank');
            }
            return;

        }
        function cerrar_sesion() {
            var nuevo_valor = window.confirm("¿Cerrar sesion? ");
    //    alert("el nuevo valor es: "+valor) ;
            if (!(nuevo_valor === null) && nuevo_valor)
            {
    //    window.open("../menu/busqueda_global.php?filtro=" + encodeURIComponent( nuevo_valor ) ,'_blank' )   ; 
                window.location.href = '../registro/cerrar_sesion.php';
            }
            return;

        }

    </script>    


    <?php
}
//require_once("../menu/menu_migas.php");

?>
  