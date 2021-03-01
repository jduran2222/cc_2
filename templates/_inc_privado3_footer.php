<?php

if(!$modal_ajax)
{        

?>

  <!-- /.content-wrapper -->
  <footer class="main-footer noprint bg-secondary">
    <span> 
      <img width="32px" src="../img/logo_cc_blanco.svg"/>
      <a class="text-white" href="//construcloud.es" target="_blank">
        <strong>Constru</strong>Cloud.es
      </a>

    </span>
      <button style='color:white' class='btn btn-link  noprint'  onclick="window.open('../menu/contactar.php')">
            <i class="far fa-envelope"></i>
            <span class='c_text'> contactar </span>
           </button>  
    <div class="float-right d-none d-sm-inline-block">
      <b>Versión</b> D-2.0.1
      &copy; 2019-<?php echo date("y"); ?> 
    </div>
    <!--
    <hr/>
    <div class="text-center">
      <span class='h5 small px-5'>
        <img width="32px" src="../img/logo_cc_blanco.svg"/>
        ConstruCloud.es
      </span>
      <span class='h6 small'>
        No dude en consultar cuestiones, realizar sugerencias o notificar errores. Se lo agradeceremos.
        <a href="../menu/contactar.php" class='btn btn-link noprint text-white px-5'>
          <i class="far fa-envelope"></i>
          <span class='h6 small'> Contactar </span>
        </a>
        <a class="text-white" href="mailto:soporte@construcloud.es?Subject=Notificación ConstruCloud.es" target="_top">soporte@construcloud.es</a>
      </span>
    </div>
    -->
  </footer>


  <!-- Control Sidebar -->
  <aside class="control-sidebar control-sidebar-dark noprint">
    <!-- Control sidebar content goes here -->
  </aside>
  <!-- /.control-sidebar -->
</div>
<!-- ./wrapper -->
  
  <!--CHAT SOPORTE-->
  <div style="position:fixed; bottom:20px; right:20px;z-index: 99;" class="bg-info text-info noprint">
    <div class="p-2 h5 text-center m-0 noprint" style="cursor:pointer;" onclick="$('#chat_textarea').fadeToggle(500, 'swing');">
      <i class="far fa-comments noprint"></i>
      <p class="p-0 m-0 noprint">
        <span class="d-none d-sm-inline noprint">Chat Soporte</span> 
      </p>
    </div>
      
    <div class="mx-auto text-center noprint" style="display:none;z-index: 3;" id="chat_textarea">
      <textarea class="form-control col-11 mx-auto mb-2 noprint" onfocus="$('#mensaje_enviado').hide();" row='10' cols='28'  id="chat_soporte" placeholder="Hola, bienvenido a ConstruCloud.es ¿en qué podemos ayudarte?"/></textarea>
      <button class="btn_topbar col-11 btn btn-light btn-xs mb-2 noprint" onclick="chat_send_soporte()">Enviar</button>
      <div id="mensaje_enviado" class="small mb-2 noprint" style="display: none;">Mensaje enviado, recibirá respuesta en su chat</div>
    </div>
  </div>


<!--  FUNCION DEJADA DE UTILIZAR PROVISIONALMENTE, FALL EN SEGURIDAD, HAY QUE CODIFICARLA juand, feb2021
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
    }-->




  
  <!-- Script activo para las funcionalidades básicas de la web: debería ir en un main.js -->
  <script type="text/javascript">
    // COPIA LITERAL
    function tour()
    {
      alert("prueba3"); 
      // Instance the tour
      var tour = new Tour({
                          steps: [
                            {
                              element: "#filtro",
                              title: "Construcloud.es prueba Tour",
                              content: "Aquí podemos buscar cualquier entidad: Obras, Proveedor, Personal..."
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
    function chat_send_soporte(){
      var message = $("#chat_soporte").val();
      //  message = "Hola\nEsto es otra linea.\n\nSaludos" ;
      //  var message = message1.replace(/\n/g,"<br>");   // lo hacemos en el servidor en PHP
      //  
      //        alert(message) ;
      //  message = 'juan duran';
      //  $('.message-input input').val('');
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
        //          var resp = $.parseJSON(response);           
        //          $('#conversation').html(resp.conversation); 
        //          $('#conversation').html(response.conversation); 
        //          $('#conversation').html('HOLA SOY JUAN');   
        //                        alert('ALERT');
        //          $(".messages").animate({ scrollTop: $('.messages').height() }, "fast");
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
//        window.location.href = "../menu/busqueda_global.php?filtro=" + encodeURIComponent(nuevo_valor);
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


    // NUEVO
    function desplegarMenuActivo() {
      var activeNav = $('#left-navbar .active');
      var leftNavbar = $('#left-navbar');
      var checking = 20;
      var curNode = activeNav;
      while (checking != 0) {
        curNode = curNode.parent();
        curNode.addClass('active menu-open');
        checking=checking-1;
      }
    }

    //Cuando haya cargado todo ejecutar los elementos básicos
    $(function() {
      //Abrimos los menús activos
      desplegarMenuActivo();
    });
  </script>
</body>
</html>
<?php
}
//$content= "<BR>Tiempo carga: ".number_format(microtime(true)-$time_total0,3)." segundos " ;
$content= "<script>$('#tiempo_total').val(' ".number_format(microtime(true)-$time_total0,3)." s');</script> " ;
echo  $content;
?>
