<?php

//require_once("../include/email_function.php");
//require_once("../include/funciones.php");
//require_once("../include/funciones_js.php");


class Chat{
//    private $host  = 'localhost';
//    private $user  = 'root';
//    private $password   = "";
//    private $database  = "php_chat";      
    private $chatTable = 'chat';
//	private $chatUsersTable = 'chat_users';
	private $chatUsersTable = 'Usuarios';
	private $chatUsersTable_View = 'Usuarios_View';
	private $chatLoginDetailsTable = 'chat_login_details';  
	private $dbConnect = false;
    public function __construct(){
        if(!$this->dbConnect){ 
            
            
    if (!isset($GLOBALS["Conn"]))
    {                          // si no hay conexion abierta la abro yo
        require_once("../../conexion.php");
//        $nueva_conn = true;
    } else
    {
        $Conn = $GLOBALS["Conn"];
//        $nueva_conn = false;
    }


            
//            $Conn = new mysqli($this->host, $this->user, $this->password, $this->database);
            if($Conn->connect_error){
                die("Error failed to connect to MySQL: " . $Conn->connect_error);
            }else{
                $this->dbConnect = $Conn;
            }
        }
    }
	private function getData($sqlQuery) {
		$result = mysqli_query($this->dbConnect, $sqlQuery);
		if(!$result){
//			die('Error in query: '. mysqli_error($Conn));
			die('Error in query: '.$sqlQuery);
		}
		$data= array();
		/*while ($row = mysqli_fetch_array($result, MYSQL_ASSOC)) {*/
		while ($row = mysqli_fetch_assoc ($result)) {
			$data[]=$row;            
		}
		return $data;
	}
	private function getNumRows($sqlQuery) {
		$result = mysqli_query($this->dbConnect, $sqlQuery);
		if(!$result){
			die('Error in query: '. mysqli_error($Conn));
		}
		$numRows = mysqli_num_rows($result);
		return $numRows;
	}
        // datos del usuario logueado
	public function loginUsers($username, $password){
//		$sqlQuery = "
//			SELECT id_usuario as userid, usuario as username 
//			FROM ".$this->chatUsersTable_View." 
//			WHERE username='".$username."' AND password='".$password."'";		
		$sqlQuery = "
			SELECT id_usuario as userid, usuario as username,empresa ,id_c_coste,IF(admin_chat>0,' (admin)','') as admin_txt
			FROM ".$this->chatUsersTable_View." 
			WHERE id_usuario=".$_SESSION['userid'];		
        return  $this->getData($sqlQuery);
	}
        // TODOS los usuarios distintos del logueado sin ordenar (OBSOLETO)
	public function chatUsers($userid){
//		$sqlQuery = "
//			SELECT * FROM ".$this->chatUsersTable_View." 
//			WHERE userid != '$userid'";
//		return  $this->getData($sqlQuery);
		$sqlQuery = "
			SELECT id_usuario as userid, usuario as username,empresa ,id_c_coste,IF(admin_chat>0,' (admin)','') as admin_txt 
                        ,'user1.jpg' as avatar, '' as password, current_session,online 
                        FROM ".$this->chatUsersTable_View." 
			WHERE id_usuario != '$userid' ORDER BY online DESC";
		return  $this->getData($sqlQuery);
	}
        //TODOS los usuarios distintos del logueado ORDENADOS tipo whassapp (para usuarios admin_chat)
	public function chatUsers_online($userid){ 
//		$sqlQuery = "
//			SELECT * FROM ".$this->chatUsersTable_View."  
//			WHERE userid != '$userid'";
//		return  $this->getData($sqlQuery);
//		$sqlQuery = " 
//			SELECT id_usuario as userid, usuario as username,empresa ,id_c_coste,IF(admin_chat>0,' (admin)','') as admin_txt,'user1.jpg' as avatar,
//                        '' as password, current_session,online  
//                        FROM ".$this->chatUsersTable_View." 
//			WHERE id_usuario!='$userid' ORDER BY chat_f_ultimo_recibido DESC, online DESC, fecha_creacion DESC ;";
		$sqlQuery = "
			SELECT id_usuario as userid, usuario as username,empresa ,id_c_coste,IF(admin_chat>0,' (admin)','') as admin_txt,'user1.jpg' as avatar,
                        '' as password, current_session,online  
                        FROM Usuarios_View_chat 
			WHERE id_usuario!='0' AND ( reciever_userid='$userid' OR reciever_userid IS NULL )  ORDER BY chat_f_ultimo_recibido DESC, online DESC, fecha_creacion DESC ;";
		return  $this->getData($sqlQuery);
	}
        // Usuarios ADMIN o de la misma empresa  (para usuarios user)
	public function chatUsers_admin($userid){
//		$sqlQuery = "
//			SELECT * FROM ".$this->chatUsersTable_View." 
//			WHERE userid != '$userid'";
//		return  $this->getData($sqlQuery);
		$sqlQuery = " 
			SELECT id_usuario as userid, usuario as username,empresa ,id_c_coste,IF(admin_chat>0,' (admin)','') as admin_txt  
                        ,'user1.jpg' as avatar, '' as password, current_session,online 
                        FROM Usuarios_View_chat
                        WHERE id_usuario!='$userid' AND  ( reciever_userid='$userid' OR reciever_userid IS NULL ) AND (admin_chat!=0 OR id_c_coste={$_SESSION["id_c_coste"]} )"
                        . " ORDER BY chat_f_ultimo_recibido DESC, online DESC, fecha_creacion DESC ";  
		return  $this->getData($sqlQuery);
	}
	public function getUserDetails($userid){
//		$sqlQuery = "
//			SELECT * FROM ".$this->chatUsersTable_View." 
//			WHERE userid = '$userid'";
//		return  $this->getData($sqlQuery);
		$sqlQuery = "
			SELECT id_usuario as userid, usuario as username,empresa ,id_c_coste,IF(admin_chat>0,' (admin)','') as admin_txt 
                        ,'user1.jpg' as avatar, '' as password, current_session,online 
                        FROM ".$this->chatUsersTable_View." 
			WHERE id_usuario = '$userid'";
		return  $this->getData($sqlQuery);
	}
	public function getUserAvatar($userid){
		$sqlQuery = "
			SELECT 'user1.jpg' as avatar 
			FROM ".$this->chatUsersTable_View." 
			WHERE id_usuario = '$userid'";
		$userResult = $this->getData($sqlQuery);
		$userAvatar = '';
		foreach ($userResult as $user) {
			$userAvatar = $user['avatar'];
		}	
		return $userAvatar;
	}	
	public function updateUserOnline($userId, $online) {		
		$sqlUserUpdate = "
			UPDATE ".$this->chatUsersTable." 
			SET online = '".$online."' 
			WHERE id_usuario = '".$userId."'";			
		mysqli_query($this->dbConnect, $sqlUserUpdate);		
	}
        // NUEVA FUNCION. ponemos a todos menos el user en OFFLINE (se hace cada 60segundos)
	public function all_offline($userId) {		
		$sqlUserUpdate = "
			UPDATE ".$this->chatUsersTable." 
			SET online = 0 
			WHERE id_usuario != '$userId'  AND online=1   ";			
		mysqli_query($this->dbConnect, $sqlUserUpdate);		
	}
	public function insertChat($reciever_userid, $user_id, $chat_message, $soporte=0) {	
            
            require_once("../include/email_function.php");
            require_once("../include/funciones.php");
           
//                // manipulamos el message
//                
////                $chat_message = preg_replace( '/\\n/' , '<br>'  , $chat_message );
//             //sustitución nuevas líneas
//             $chat_message =preg_replace("/\n|\r\n/", "<br/>", $chat_message);
//                
//                // sustitucion http 
//             $pattern = "/(?i)\b((?:https?:\/\/|www\d{0,3}[.]|[a-z0-9.\-]+[.][a-z]{2,4}\/)(?:[^\s()<>]+|\(([^\s()<>]+|(\([^\s()<>]+\)))*\))+(?:\(([^\s()<>]+|(\([^\s()<>]+\)))*\)|[^\s`!()\[\]{};:'\".,<>?«»“”‘’]))/";
//             $chat_message = preg_replace_callback($pattern, function ($S) {
//             return "<a href='$S[0]' target='_blank' title='$S[0]'>".substr($S[0],0,20)."...</a>";
//              }, $chat_message); 
//              
////             $chat_message = preg_replace($pattern, "$1", $chat_message); 
//            
//             $chat_message =preg_replace("/\'/", "\'", $chat_message); //corregimos las comillas 
//
            
            
            $sqlInsert = "
                    INSERT INTO ".$this->chatTable." 
                    (id_c_coste, reciever_userid, sender_userid, message, status) 
                    VALUES ( '{$_SESSION["id_c_coste"]}' ,   '".$reciever_userid."', '".$user_id."', '".texto_a_html_hex($chat_message)."', '1')";
            $result = mysqli_query($this->dbConnect, $sqlInsert);
            if(!$result){
                    return ('Error in query: '. mysqli_error($Conn));
            } else {
                    $conversation = $this->getUserChat($user_id, $reciever_userid);
//			$conversation = 'PRUEBA JUAN DURAN';
                    $data = array( 	"conversation" => $conversation	);
                    echo json_encode($data);
                    
                    
                   $soporte_txt = $soporte ? "(soporte)" : "" ;
                   $rs_rec_user=DRow('Usuarios',"id_usuario='$reciever_userid' " ) ; // mandamos los emails a todos los usuarios
                   
                   $empresa_user=Dfirst("CONCAT(empresa,'/', usuario )","Usuarios_View",   "id_usuario='$user_id' " ) ;

                   $msg_promo="<br><br>Acceda aquí:<h1><a  href='https://construcloud.es/web/registro/index.php' >www.construcloud.es</h1></a>   " ;

                   $texto_message= ($rs_rec_user["admin_chat"]) ? $chat_message : "" ; // a los usuarios no admin_chat no se le envía el msg para que accedan al sistema si quieren verlo
                   $msg_final= "<br> Mensaje:<br>  $soporte_txt $texto_message  " ;
                   cc_email($rs_rec_user["email"], "Construclud.es: Nuevo chat de $empresa_user "  
                                       , "Empresa/usuario: $empresa_user  $msg_final $msg_promo" , '' ) ;
//                         $conversation = $email_admin_chat.'----';
                                                                 
		}
	}
	public function getUserChat($from_user_id, $to_user_id) {
		$fromUserAvatar = $this->getUserAvatar($from_user_id);	
		$toUserAvatar = $this->getUserAvatar($to_user_id);			
		$sqlQuery = "
			SELECT *, DATE_FORMAT(timestamp, '%W, %d-%M-%Y') as fecha,DATE_FORMAT(timestamp, '%H:%i') as hora,
                        DATE_FORMAT(now(), '%W, %d-%M-%Y') as hoy 
                        FROM ".$this->chatTable." 
			WHERE (sender_userid = '".$from_user_id."' 
			AND reciever_userid = '".$to_user_id."') 
			OR (sender_userid = '".$to_user_id."' 
			AND reciever_userid = '".$from_user_id."') 
			ORDER BY timestamp ASC";
		$userChat = $this->getData($sqlQuery);	
		$conversation = '<ul>';
                $fecha0=''; // fecha inicial de todos los timestamp
                $no_leidos=0 ;
		foreach($userChat as $chat){
                        // deshacemos el registro en HEX si lo hay
                        if(preg_match("/__HEX__/", $chat["message"]) ){ $chat["message"] = hex2bin ( preg_replace("/__HEX__/", "", $chat["message"])) ; }

                        $user_name = '';
                        // metemos el cambio de fecha
                        $fecha1= ($chat["fecha"]==$chat["hoy"]) ? "HOY" : $chat["fecha"]; // fecha inicial de todos los timestamp

                        if (!($fecha0===$fecha1)) {$fecha0=$fecha1 ; $conversation .= "<li style='background:#34b7f1;text-align:center;'><p>$fecha1</p></li>"; }
                        if (!($chat["sender_userid"] == $from_user_id) AND ($chat["status"]==1) AND ($no_leidos==0)) {$no_leidos=1 ; $conversation .= "<li style='background:white;text-align:center;'><p>MENSAJES NO LEIDOS</p></li>"; }
//                         $conversation .= "<li class='sent'><p>{$chat["hoy"]}</p></li>";
                        $span_html='';
                        // metemos los mensajes
			if($chat["sender_userid"] == $from_user_id) {
				$conversation .= '<li class="sent">';
				$conversation .= '<img width="22px" height="22px" src="userpics/'.$fromUserAvatar.'" alt="" />';
//                                $status= $chat["status"] ? "<span style='font-size: 100%;color:black;'><b>pdte</b></span>" : "" ;
                                $status= !($chat["status"]) ? "<img width='16px' height='16px' src='userpics/wh_leido.jpg' alt='' title='leido el {$chat["ts_leido"]}'/>" : "" ;
                                $sql_delete="DELETE FROM chat WHERE chatid={$chat["chatid"]}  ;"  ;
                                $href='../include/sql.php?sql=' . encrypt2($sql_delete)  ;    
                                $span_html= "<a class='btn btn-link btn-xs noprint ' href='#' "
                                     . " onclick=\"js_href('$href' ,'1','¿Borrar chat?'  )\"   "
                                     . "title='borra el mensaje' ><i class='far fa-trash-alt'></i></a>" ;


			} else {
				$conversation .= '<li class="replies">';
				$conversation .= '<img width="22px" height="22px" src="userpics/'.$toUserAvatar.'" alt="" />';
                                $status= "";

			}
			$conversation .= "<p>{$chat["message"]}  &nbsp;&nbsp;<span style='font-size: 75%;color:grey;'> {$chat["hora"]} </span>$span_html $status</p>";			
			$conversation .= '</li>';
		}		
		$conversation .= '</ul>';
		return $conversation;
	}
        // pintamos la pantalla del chateo
	public function showUserChat($from_user_id, $to_user_id) {		
		$userDetails = $this->getUserDetails($to_user_id);
		$toUserAvatar = '';
		foreach ($userDetails as $user) {
			$toUserAvatar = $user['avatar'];
                        // calculo la ultima actividad de escritura y lectura
                        $last_activity_w=Dfirst("timestamp","chat","sender_userid={$user['userid']} "," timestamp DESC") ;
                        $last_activity_r=Dfirst("ts_leido","chat","reciever_userid={$user['userid']} AND status=0"," ts_leido DESC") ;
                        $last_activity= ($last_activity_w < $last_activity_r) ? $last_activity_r : $last_activity_w ;
                        
			$userSection = !($_SESSION["admin_chat"]) ? '<img src="userpics/'.$user['avatar'].'" alt="" />
				<span>'. $user['empresa'].'/'.$user['username'].'</span>'
                                . "<span  style='font-size: small;' >  (ult. vez $last_activity)</span>" :
                            
                                "<img src='userpics/{$user['avatar']}' alt='' />
				<span><a style='font-size: large;' href='../configuracion/empresa_ficha.php?id_empresa={$user['id_c_coste']}' target='_blank' >
                                {$user['empresa']}/{$user['username']}</a></span>"
                                . "<span  style='font-size: small;' >  (ult. vez $last_activity)</span>"   ;
		}		
		// get user conversation
		$conversation = $this->getUserChat($from_user_id, $to_user_id);	
		// update chat user read status	-  MARCAMOS COMO LEIDO TODO DE ESTE USER	
		$sqlUpdate = "
			UPDATE ".$this->chatTable." 
			SET status = '0' , ts_leido=NOW() "    // indicamos que están leidos los mensajes y la fecha y hora
			."WHERE sender_userid = '".$to_user_id."' AND reciever_userid = '".$from_user_id."' AND status = '1'";
		mysqli_query($this->dbConnect, $sqlUpdate);		
		// update users current chat session  -  MARCAMOS QUE ESTAMOS CHATEANDO CON to_user_id
		$sqlUserUpdate = "
			UPDATE ".$this->chatUsersTable." 
			SET current_session = '".$to_user_id."' 
			WHERE id_usuario = '".$from_user_id."'";
		mysqli_query($this->dbConnect, $sqlUserUpdate);		
		$data = array(
			"userSection" => $userSection,
			"conversation" => $conversation			
		 );
		 echo json_encode($data);		
	}	
	public function getUnreadMessageCount($senderUserid, $recieverUserid) {
		$sqlQuery = "
			SELECT * FROM ".$this->chatTable."  
			WHERE sender_userid = '$senderUserid' AND reciever_userid = '$recieverUserid' AND status = '1'";
		$numRows = $this->getNumRows($sqlQuery);
		$output = '';
		if($numRows > 0){
			$output = $numRows;
		}
		return $output;
	}	
	public function getUnreadMessageCount_all($recieverUserid) {
		$sqlQuery = "
			SELECT * FROM ".$this->chatTable."  
			WHERE  reciever_userid = '$recieverUserid' AND status = '1'";
		$numRows = $this->getNumRows($sqlQuery);
		$output = '';
		if($numRows > 0){
			$output = $numRows;
		}
		return $output;
	}	
	public function updateTypingStatus($is_type, $loginDetailsId) {		
		$sqlUpdate = "
			UPDATE ".$this->chatLoginDetailsTable." 
			SET is_typing = '".$is_type."' 
			WHERE id = '".$loginDetailsId."'";
		mysqli_query($this->dbConnect, $sqlUpdate);
	}		
	public function fetchIsTypeStatus($userId){
		$sqlQuery = "
		SELECT is_typing FROM ".$this->chatLoginDetailsTable." 
		WHERE id_usuario = '".$userId."' ORDER BY last_activity DESC LIMIT 1"; 
		$result =  $this->getData($sqlQuery);
		$output = '';
		foreach($result as $row) {
			if($row["is_typing"] == 'yes'){
				$output = ' - <small><em>Escribiendo...</em></small>';
			}
		}
		return $output;
	}		
	public function insertUserLoginDetails($userId) {		
		$sqlInsert = "
			INSERT INTO ".$this->chatLoginDetailsTable."(userid) 
			VALUES ('".$userId."')";
		mysqli_query($this->dbConnect, $sqlInsert);
		$lastInsertId = mysqli_insert_id($this->dbConnect);
        return $lastInsertId;		
	}	
	public function updateLastActivity($loginDetailsId) {		
		$sqlUpdate = "
			UPDATE ".$this->chatLoginDetailsTable." 
			SET last_activity = now() 
			WHERE id = '".$loginDetailsId."'";
		mysqli_query($this->dbConnect, $sqlUpdate);
	}	
	public function getUserLastActivity($userId) {
		$sqlQuery = "
			SELECT last_activity FROM ".$this->chatLoginDetailsTable." 
			WHERE id_usuario = '$userId' ORDER BY last_activity DESC LIMIT 1";
		$result =  $this->getData($sqlQuery);
		foreach($result as $row) {
			return $row['last_activity'];
		}
	}	
}
?>