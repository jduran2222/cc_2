<?php 
//session_start(); // sustituyo el inicio 
require_once("../include/session.php");
//$where_c_coste = " id_c_coste={$_SESSION['id_c_coste']} ";
//$id_c_coste = $_SESSION['id_c_coste'];
?>
<!--<!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap-theme.min.css">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>-->
<!-- jQuery -->


<?php
//include('header.php');
//$loginError = '';
//if (!empty($_POST['username']) && !empty($_POST['pwd'])) {   //logue directamente al usuario
if (1) {
	include ('Chat.php');
	$chat = new Chat();
//	$user = $chat->loginUsers($_POST['username'], $_POST['pwd']); // sustituyo	
//	$user = $chat->loginUsers($_SESSION['user'], '');	
//	if(!empty($user)) {
//		$_SESSION['username'] = $user[0]['username'];
//		$_SESSION['userid'] = $user[0]['userid'];
//		$chat->updateUserOnline($user[0]['userid'], 1);
//		$lastInsertId = $chat->insertUserLoginDetails($user[0]['userid']);
//		$_SESSION['login_details_id'] = $lastInsertId;
//		header("Location:index.php");
//	} else {
//		$loginError = "Usuario y Contraseña invalida";
//	}

        
          // hacemos el LOGIN directamente
//                $_SESSION['username'] = $_SESSION["user"];
//		$_SESSION['userid'] = $_SESSION["id_usuario"];
//		$chat->updateUserOnline($_SESSION['userid'], 1);
//		$lastInsertId = $chat->insertUserLoginDetails($_SESSION['userid']);
//		$_SESSION['login_details_id'] = $lastInsertId;
		header("Location:chat_index.php");
	
}

?>
<!--<html> 
<head>
<title>Sistema de chat en vivo con Ajax, PHP y MySQL</title>
<?php // include('container.php');?>
<div class="container">		
	<h2>Sistema de chat en vivo con Ajax, PHP y MySQL</h1>		
	<div class="row">
		<div class="col-sm-4">
			<h4>Chat Login:</h4>		
			<form method="post">
				<div class="form-group">
				<?php // if ($loginError ) { ?>
					<div class="alert alert-warning"><?php // echo $loginError; ?></div>
				<?php // } ?>
				</div>
				<div class="form-group">
					<label for="username">Usuario:</label>
					<input type="username" class="form-control" name="username" required>
				</div>
				<div class="form-group">
					<label for="pwd">Contraseña:</label>
					<input type="password" class="form-control" name="pwd" required>
				</div>  
				<button type="submit" name="login" class="btn btn-info">Iniciar Sesion</button>
			</form>
			<br>
			<p><b>Usuario</b> : jorge<br><b>Password</b> : root</p>
			<p><b>Usuario</b> : maria<br><b>Password</b> : 12345</p>

		</div>
		
	</div>
</div>	
<?php // include('footer.php');?>

-->




