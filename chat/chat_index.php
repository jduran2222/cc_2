<?php
// cambios
require_once("../include/session.php");
$where_c_coste = " id_c_coste={$_SESSION['id_c_coste']} ";
$id_c_coste = $_SESSION['id_c_coste'];

$titulo = 'Chat ';

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

                <!-- <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap-theme.min.css"> -->
                <!-- <link rel='stylesheet prefetch' href='https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.6.2/css/font-awesome.min.css'> -->
                <link href="chat_style.css<?php echo (isset($_SESSION["is_desarrollo"]) AND $_SESSION["is_desarrollo"])? "?d=".date("ts") : "" ; ?>" rel="stylesheet" id="bootstrap-css">
                <!-- <link href="../css/estilos.css<?php echo (isset($_SESSION["is_desarrollo"]) AND $_SESSION["is_desarrollo"])? "?d=".date("ts") : "" ; ?>" rel=stylesheet type="text/css"> -->
                <!-- <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.6.3/css/all.css" integrity="sha384-UHRtZLI+pbxtHCWp1t77Bi1L4ZtiqrqD80Kn4Z8NTSRyMA2Fd33n5dQ8lWUE00s/" crossorigin="anonymous"> -->
                <!-- <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script> -->

<?php
//include('container.php');
 

//         cc_email('juanduran@ingenop.com', "Construclud.es: Nuevo chat" , "Empresa/usuario: MENSAJE  " , '' );


require_once ('Chat.php');
$chat = new Chat(); 


//inicialización
$_SESSION['username'] = $_SESSION["user"];
$_SESSION['userid'] = $_SESSION["id_usuario"];
$chat->updateUserOnline($_SESSION['userid'], 1);
$lastInsertId = $chat->insertUserLoginDetails($_SESSION['userid']);
$_SESSION['login_details_id'] = $lastInsertId;

//$chat->insertChat(96, 96, 'HOLA PRUEBA') ; 
//echo "variable22: " . $nnnnn;       


?>
<div class="container" >
<div class=''>
</div>
<style>
    .modal-dialog {
        width: 400px;
        margin: 30px auto;	
    }
</style>

<div class="container">		

    <?php if (isset($_SESSION['userid']) && $_SESSION['userid']) { ?> 	
        <div class="chat">	
            <div id="frame">		
                <div id="sidepanel">
                    <div id="profile"> 
                        <?php
                        
                        // USUARIO PRINCIPAL
                        $loggedUser = $chat->getUserDetails($_SESSION['userid']);
                        echo '<div class="wrap">';
                        $currentSession = '';
                        foreach ($loggedUser as $user) {
                            $currentSession = $user['current_session'];
//						echo '<img id="profile-img" src="userpics/'.$user['avatar'].'" class="online" alt="" />'; //quito los avatar
//                            echo '<h1>' . $user['empresa'].'/'.$user['username'].'<i class="fa fa-chevron-down expand-button" aria-hidden="true"></i></h1>';
                            echo '<h2>' . $user['empresa'].'/'.$user['username'].'</h2>';
//                            echo '<div id="status-options">';
//                            echo '<ul>';
//                            echo '<li id="status-online" class="chat_active"><span class="status-circle"></span> <p>Online</p></li>';
//                            echo '<li id="status-away"><span class="status-circle"></span> <p>Ausente</p></li>';
//                            echo '<li id="status-busy"><span class="status-circle"></span> <p>Ocupado</p></li>';
//                            echo '<li id="status-offline"><span class="status-circle"></span> <p>Desconectado</p></li>';
//                            echo '</ul>';
//                            echo '</div>';
//                            echo '<div id="expanded">';
//                            echo '<a href="logout.php">Salir</a>';
//                            echo '</div>';
                        }
                        echo '</div>';
                        ?>
                    </div>
                    <div id="search">
                        <label for=""><i class="fa fa-search" aria-hidden="true"></i></label>
                        <input type="text" placeholder="Buscar Contactos..." />					
                        <h4><?php echo ($_SESSION["admin_chat"]? "Usuarios :" : "Administradores:" )   ; ?></h4>
                    </div>
                    <div id="contacts">	 
                        <?php
                        // USUARIOS DISPONIBLES  
                        echo '<ul>';
                        // decidemos que Users mostrar: 1) si se es chat admin los users online, si no, todos User admin 
                        $chatUsers = ($_SESSION["admin_chat"])? $chat->chatUsers_online($_SESSION['userid']) : $chat->chatUsers_admin($_SESSION['userid']);
                        foreach ($chatUsers as $user) {
                            $status = 'offline';
                            if ($user['online']) {
                                $status = 'online';
                            }
                            $activeUser = '';
                            if ($user['userid'] == $currentSession) {
                                $activeUser = "chat_active";
                            }
                            echo '<li id="' . $user['userid'] . '" class="contact ' . $activeUser . '" data-touserid="' . $user['userid'] . '" data-tousername="' . $user['username'] . '">';
                            echo '<div class="wrap">';
                            echo '<span id="status_' . $user['userid'] . '" class="contact-status ' . $status . '"></span>';
//						echo '<img src="userpics/'.$user['avatar'].'" alt="" />';  //quito avatar
                            echo '<div class="meta">';
                            echo '<p class="name">' .  $user['empresa'].'/'.$user['username'].$user['admin_txt'] . '<span id="unread_' . $user['userid'] . '" class="unread">' . $chat->getUnreadMessageCount($user['userid'], $_SESSION['userid']) . '</span></p>';
                            echo '<p class="preview"><span id="isTyping_' . $user['userid'] . '" class="isTyping"></span></p>';
                            echo '</div>';
                            echo '</div>';
                            echo '</li>';
                        }
                        echo '</ul>';
                        // fin USUARIOS DISPONIBLES
                        ?>
                    </div>
<!--                    <div id="bottom-bar">	
                        <button id="addcontact"><i class="fa fa-user-plus fa-fw" aria-hidden="true"></i> <span>Agregar Contactos</span></button>
                        <button id="settings"><i class="fa fa-cog fa-fw" aria-hidden="true"></i> <span>Configuracion</span></button>					
                    </div>-->
                </div>			
                <div class="content" id="content"> 
                    <div class="contact-profile" id="userSection">	
                        <?php
//                        $userDetails = $chat->getUserDetails($currentSession); 
//                        foreach ($userDetails as $user) {
////						echo '<img src="userpics/'.$user['avatar'].'" alt="" />';  //quito avatar
//                           if ($_SESSION["admin_chat"] )
//                           {
//                               $id_empresa=Dfirst("id_c_coste","Usuarios","id_usuario=".$user['userid']) ;
//                               echo "<p><a  href='../../configuracion/empresa_ficha.php?id_empresa=$id_empresa' target='_blank' >"
//                                       . "{$user['empresa']}/{$user['username']}</a></p>"; 
////                               echo '<p>' .  $user['empresa'].'/'.$user['username'] . '</p>'; 
//        
//                               
//                           }else    
//                           {  
//                              echo '<p>' .  $user['empresa'].'/'.$user['username'] . '</p>';
////							echo '<div class="social-media">'; // quito link a social nets
////								echo '<i class="fa fa-facebook" aria-hidden="true"></i>';
////								echo '<i class="fa fa-twitter" aria-hidden="true"></i>';
////								 echo '<i class="fa fa-instagram" aria-hidden="true"></i>';
////							echo '</div>';
//                           }  
//                        }
                        ?>						
                    </div>
                    <div class="messages" id="conversation">		
                        <?php
//                        echo $chat->getUserChat($_SESSION['userid'], $currentSession); 
                        ?>
                    </div>
                    <div class="message-input" id="replySection">				
                        <div class="message-input" id="replyContainer">
                            <div class="wrap">
                                <!--<input type="text" class="chatMessage"  id="chatMessage<?php echo $currentSession; ?>" placeholder="Escribe tu mensaje..." />-->
                                <textarea rows="3" cols="80" class="chatMessage"  id="chatMessage<?php echo $currentSession; ?>" placeholder="Escribe tu mensaje..." 
                                          onkeyup = "if(event.key == '&') alert('pulsado @ (PRUEBAS)') ; " ></textarea>
                                <button class="submit chatButton" id="chatButton<?php echo $currentSession; ?>"><i class="fa fa-paper-plane" aria-hidden="true"></i></button>	
                            </div>
                        </div>					
                    </div>
                </div>
            </div>
        </div>
    <?php } else { ?>
        <br>
        <br>
        <strong><a href="chat_index.php"><h3>Acceder al Chat</h3></a></strong>		
    <?php } ?>
<!--    <br>
    <br>	-->
    <!--<div style="margin:50px 0px 0px 0px;">-->
        <!--<a class="btn btn-default read-more" style="background:#3399ff;color:white" href="http://www.baulphp.com/sistema-de-chat-en-vivo-con-ajax-php-y-mysql">Volver al Tutorial</a>-->		
<!--        <button  class='btn btn-warning btn-lg noprint' style='font-size:80px;'  onclick="window.close()"/><i class='far fa-window-close'></i> Cerrar Chat</button>-->
    <!--</div>-->	
</div>	
<?php // include('footer.php'); ?> 
<div class="insert-post-ads1" style="margin-top:20px;">

</div>
</div>
</body>



<script>
$(document).ready(function(){
	setInterval(function(){
		updateUserList();	
		updateUnreadMessageCount();	
	}, 20000);	
	setInterval(function(){
		showTypingStatus();
		updateUserChat();			
	}, 3000);    // debug cambiar a 2000
        
//	$(".messages").animate({ 
//		scrollTop: $(document).height() 
//	}, "fast");
//	
        // hacemos el scroll a nuestra forma
//        document.getElementById('conversation').scrollTop=document.getElementById('conversation').scrollHeight;
        showUserChat(<?php echo $currentSession ?>) ;   // forzamos a pintar el ultimo usuario que habiamos visitado (juand, mayo20)
//        
//        alert( $(document).height() );
	$(document).on("click", '#profile-img', function(event) { 	
		$("#status-options").toggleClass("chat_active");
	});
        
	$(document).on("click", '.expand-button', function(event) { 	
		$("#profile").toggleClass("expanded");
		$("#contacts").toggleClass("expanded");
	});	
//	$(document).on("click", '#status-options ul li', function(event) { 	
//		$("#profile-img").removeClass();
//		$("#status-online").removeClass("chat_active");
//		$("#status-away").removeClass("chat_active");
//		$("#status-busy").removeClass("chat_active");
//		$("#status-offline").removeClass("chat_active");
//		$(this).addClass("chat_active");
//		if($("#status-online").hasClass("chat_active")) {
//			$("#profile-img").addClass("online");
//		} else if ($("#status-away").hasClass("chat_active")) {
//			$("#profile-img").addClass("away");
//		} else if ($("#status-busy").hasClass("chat_active")) {
//			$("#profile-img").addClass("busy");
//		} else if ($("#status-offline").hasClass("chat_active")) {
//			$("#profile-img").addClass("offline");
//		} else {
//			$("#profile-img").removeClass();
//		};
//		$("#status-options").removeClass("chat_active"); 
//	});	
	$(document).on('click', '.contact', function(){		
		$('.contact').removeClass('chat_active');
		$(this).addClass('chat_active');
		var to_user_id = $(this).data('touserid');
		showUserChat(to_user_id);
		$(".chatMessage").attr('id', 'chatMessage'+to_user_id);
		$(".chatButton").attr('id', 'chatButton'+to_user_id);
	});	
	$(document).on("click", '.submit', function(event) { 
		var to_user_id = $(this).attr('id');
		to_user_id = to_user_id.replace(/chatButton/g, "");
		sendMessage(to_user_id);
	});
	$(document).on('focus', '.message-input', function(){
		var is_type = 'yes';
		$.ajax({
			url:"chat_action.php",
			method:"POST",
			data:{is_type:is_type, action:'update_typing_status'},
			success:function(){
			}
		});
	}); 
	$(document).on('blur', '.message-input', function(){
		var is_type = 'no';
		$.ajax({
			url:"chat_action.php",
			method:"POST",
			data:{is_type:is_type, action:'update_typing_status'},
			success:function() {
			}
		});
	}); 		
}); 

// FUNCIONES JAVASCRIPT

function updateUserList() {
    
//        alert('refrescamos lista users');
	$.ajax({
		url:"chat_action.php",
		method:"POST",
		dataType: "json",
		data:{action:'update_user_list'},
		success:function(response){		
			var obj = response.profileHTML;
			Object.keys(obj).forEach(function(key) {
				// update user online/offline status
				if($("#"+obj[key].userid).length) {
					if(obj[key].online == 1 && !$("#status_"+obj[key].userid).hasClass('online')) {
						$("#status_"+obj[key].userid).addClass('online');
					} else if(obj[key].online == 0){
						$("#status_"+obj[key].userid).removeClass('online');
					}
				}				
			});			
		}
	});
}
function sendMessage(to_user_id) {
//	message = $(".message-input input").val();
	var message = $(".message-input textarea").val();
//	message = "Hola\nEsto es otra linea.\n\nSaludos" ;
//	var message = message1.replace(/\n/g,"<br>");   // lo hacemos en el servidor en PHP
//	
//        alert(message) ;
        
//	message = 'juan duran';
//	$('.message-input input').val('');
//                        alert('ALERT');

	$('.message-input textarea').val('');
	if($.trim(message) == '') {
		return false;
	}
	$.ajax({
		url:"chat_action.php",
		method:"POST",
		data:{to_user_id:to_user_id, chat_message:message, action:'insert_chat'},
		dataType: "json",
		success:function(response) {
//			var resp = $.parseJSON(response);			
//			$('#conversation').html(resp.conversation);	
			$('#conversation').html(response.conversation);	
//			$('#conversation').html('HOLA SOY JUAN');	
//                        alert('ALERT');
//			$(".messages").animate({ scrollTop: $('.messages').height() }, "fast");
//                        $("#conversation").scrollTop($("#conversation").scrollHeight);
//                        $("#conversation").scrollTop(50000);
//                        alert( $("#conversation").scrollHeight );
		}
	});	
}
function showUserChat(to_user_id){
	$.ajax({
		url:"chat_action.php",
		method:"POST",
		data:{to_user_id:to_user_id, action:'show_chat'},
		dataType: "json",
		success:function(response){
			$('#userSection').html(response.userSection);
			$('#conversation').html(response.conversation);	
			$('#unread_'+to_user_id).html('');
                        document.getElementById('conversation').scrollTop=document.getElementById('conversation').scrollHeight; //JUAND
//                        $("#conversation").scrollTop(50000);
//                        alert($("#conversation").height());
		}
	});
}
// actualiza la pantalla de chat y reafirmamos que seguimos online, se activa cada pocos segundos
function updateUserChat() {
	$('li.contact.chat_active').each(function(){
		var to_user_id = $(this).attr('data-touserid');
		$.ajax({
			url:"chat_action.php",
			method:"POST",
			data:{to_user_id:to_user_id, action:'update_user_chat'},
			dataType: "json",
			success:function(response){				
				$('#conversation').html(response.conversation);			
			}
		});
	});
}
function updateUnreadMessageCount() {
	$('li.contact').each(function(){
		if(!$(this).hasClass('chat_active')) {
			var to_user_id = $(this).attr('data-touserid');
			$.ajax({
				url:"chat_action.php",
				method:"POST",
				data:{to_user_id:to_user_id, action:'update_unread_message'},
				dataType: "json",
				success:function(response){		
					if(response.count) {
						$('#unread_'+to_user_id).html(response.count);	
					}					
				}
			});
		}
	});
}
function showTypingStatus() {
	$('li.contact.chat_active').each(function(){
		var to_user_id = $(this).attr('data-touserid');
		$.ajax({
			url:"chat_action.php",
			method:"POST",
			data:{to_user_id:to_user_id, action:'show_typing_status'},
			dataType: "json",
			success:function(response){				
				$('#isTyping_'+to_user_id).html(response.message);			
			}
		});
	});
}    
</script>    
                </div>
                <!--****************** BUSQUEDA GLOBAL  *****************-->
            </div>
        </div>
        <!-- FIN Contenido principal -->

<?php 

//FIN
include_once('../templates/_inc_privado3_footer.php');
