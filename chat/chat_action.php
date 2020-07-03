<?php
//session_start();  
require_once("../include/session.php"); 
//$where_c_coste=" id_c_coste={$_SESSION['id_c_coste']} " ;


//require_once("../include/email_function.php");
require_once("../../conexion.php");
require_once("../include/funciones.php");

//logs("CHAT_ACTION"); 



include ('Chat.php');
$chat = new Chat();
if($_POST['action'] == 'update_user_list') {
//	$chatUsers = $chat->chatUsers($_SESSION['userid']);
        $chatUsers = ($_SESSION["admin_chat"])? $chat->chatUsers_online($_SESSION['userid']) : $chat->chatUsers_admin($_SESSION['userid']);
	$data = array(
		"profileHTML" => $chatUsers,	
	);
        $chat->all_offline($_SESSION['userid']);  // despues de refrescar los online, los pongo todos offline para por si alguno se ha desconectado sin logout
	echo json_encode($data);	
}
if($_POST['action'] == 'insert_chat') {
    
//         cc_email('juanduran@ingenop.com', "Construclud.es: Nuevo chat" , "Empresa/usuario: MENSAJE  " , '' );
    
	$chat->insertChat($_POST['to_user_id'], $_SESSION['userid'], $_POST['chat_message']); 
}
if($_POST['action'] == 'insert_soporte') {
    
        logs("insert_soporte");
        $users_admin_chat=  DArray("id_usuario", "Usuarios", "admin_chat>0 AND activo=1") ;
        foreach ($users_admin_chat as $to_user_id) {
              logs("insert_mesagge"); 
  	    $chat->insertChat($to_user_id[0], $_SESSION['id_usuario'], $_POST['chat_message'], 1);      // mando el  mensaje a cada admin_chat
        }
        $data = array( 	"conversation" => "juan"	);
        echo json_encode($data);

        
}
if($_POST['action'] == 'show_chat') {
	$chat->showUserChat($_SESSION['userid'], $_POST['to_user_id']);
}
if($_POST['action'] == 'update_user_chat') {
    	$chat->updateUserOnline($_SESSION['userid'], 1); // actualizamos el estar ONLINE
	$conversation = $chat->getUserChat($_SESSION['userid'], $_POST['to_user_id']);
	$data = array(
		"conversation" => $conversation			
	);
	echo json_encode($data);
}
if($_POST['action'] == 'update_unread_message') {
	$count = $chat->getUnreadMessageCount($_POST['to_user_id'], $_SESSION['userid']);
	$data = array(
		"count" => $count			
	);
	echo json_encode($data);
}
if($_POST['action'] == 'update_typing_status') {
	$chat->updateTypingStatus($_POST["is_type"], $_SESSION["login_details_id"]);
}
if($_POST['action'] == 'show_typing_status') {
	$message = $chat->fetchIsTypeStatus($_POST['to_user_id']);
	$data = array(
		"message" => $message			
	);
	echo json_encode($data);
}
?>