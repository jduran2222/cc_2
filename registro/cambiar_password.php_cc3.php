<?php
ini_set("session.use_trans_sid",true);
session_start();




require_once("../conexion.php");
require_once("../include/funciones.php"); 

?>


<html>
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-1">
	<link rel='shortcut icon' type='image/x-icon' href='/favicon.ico' />
	
         <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
        <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.6.3/css/all.css" integrity="sha384-UHRtZLI+pbxtHCWp1t77Bi1L4ZtiqrqD80Kn4Z8NTSRyMA2Fd33n5dQ8lWUE00s/" crossorigin="anonymous">
   <link rel="stylesheet" href="../css/estilos.css<?php echo (isset($_SESSION["is_desarrollo"]) AND $_SESSION["is_desarrollo"])? "?d=".date("ts") : "" ; ?>" type="text/css">

  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
<title>Cambiar password</title></head>


<body >
<?php   
    ini_set("display_errors", 1);
    error_reporting(E_ALL);
?>

<center>
<div >
    <p align=center style='font-size:30px ; text-align:center; color:lightskyblue; font-family:verdana '><br>ConstruCloud.es<br>
		<img width="200" src="../img/construcloud64.svg">
	</p>
   
</div>

	
<?php

// $id_usuario_get =isset($_GET["id_usuario"]) ? $_GET["id_usuario"]  : $_SESSION["id_usuario"] ;

 $href_get='';


if ( $_SESSION["admin"] AND isset($_GET["id_usuario"]) )
{
    
  $id_usuario_get=$_GET["id_usuario"] ;
  $usuario=  Dfirst("usuario","Usuarios","id_usuario='$id_usuario_get'")  ;
  $href_get="?id_usuario=$id_usuario_get";
  $id_usuario=$id_usuario_get;

}elseif($_SESSION["autorizado"] AND isset($_GET["id_usuario"])  )
 {
       $id_usuario_get=$_GET["id_usuario"] ;
       $id_empresa_get = Dfirst('id_c_coste','Usuarios' , " id_usuario=$id_usuario_get " ) ;
       $id_empresa_autorizado = Dfirst('id_c_coste','Usuarios' , " id_usuario={$_SESSION["id_usuario"]} " ) ;
       
       if ($id_empresa_get == $id_empresa_autorizado )
       {
//           $id_usuario=$_GET["id_usuario"] ;
           $usuario=  Dfirst("usuario","Usuarios","id_usuario='$id_usuario_get'")  ;
           $href_get="?id_usuario=$id_usuario_get";
           $id_usuario=$id_usuario_get;

       }

}
else
{
  $id_usuario=$_SESSION["id_usuario"] ;
  $usuario= $_SESSION["user"] ;
    
}    

if(!isset($_POST["new_password"])) 
{    
?> 

    <form action="../registro/cambiar_password.php<?php echo $href_get?>" method="post" name="form1"  >

      <table width="40%"  border="0" align="center" cellpadding="1" cellspacing="2">
          <tr><td colspan="2" align="center" >
            <span class="encabezadopagina2">Cambiar password de Usuario: <b><?php echo $usuario?></b></span><br><br></td></tr>
        <tr>
          <td><div align="right"><i class="fas fa-key"></i> New password </div></td>
          <td><span class="encabezadopagina2">
            <input class="form-control" name="new_password" required type="password" value=""  tabindex=""  >
          </span></td>
        </tr>
        <tr>
          <td><div align="right"><i class="fas fa-key"></i> Confirm new password </div></td>
          <td><span class="encabezadopagina2"><input class="form-control" name="new_password_confirm" required type="password" value=""  tabindex=""  ></span></td></tr>
        <tr><td colspan="2" align="right" ><input class="btn btn-success" width='200px' type="submit" name="Submit" value="aceptar"  ></td></tr>


      </table>


      </form>
   
  
<?php

}
else      // cambiamos pasword y enviamos email
{    
    $new_password=trim($_POST["new_password"]) ;
    $new_password_confirm=trim($_POST["new_password_confirm"]) ;
    
    if ($new_password===$new_password_confirm)
    {
//        echo 'debug'.__LINE__ ;  
//        $id_c_coste=Dfirst("id_c_coste","Usuarios","id_usuario='$id_usuario'")  ;
//        $empresa=Dfirst("C_Coste_Texto","C_COSTES","id_c_coste='$id_c_coste'")  ;
//        
////        echo 'debug'.__LINE__ ;  
//
//        $usuario=Dfirst("usuario","Usuarios","id_usuario='$id_usuario'")  ;
//
//        $new_password= 'New_password_'.trim(rand(1000000,10000000 ))  ;
        
        $new_password_hash= cc_password_hash($new_password) ;
        
        $sql="UPDATE `Usuarios` SET `password_hash` = '$new_password_hash' WHERE id_usuario='{$id_usuario}' "  ;
//        echo 'debug'.__LINE__ ;  

        // si no hay erroers en el cambio de password
        if ($Conn->query($sql))
        {
           
                    echo "<br/><br/><br/><br/><h1>OK, password cambiada a $usuario</h1>";
 
//                    echo "<br/>". $mail->Body;	

        } 
    }
    else
    {
                    echo "<br/><br/><br/><br/>ERROR, las contraseñas no coinciden, vuelva a intentarlo";
    }    
            
    echo  "<br><br><br><h1><a class='btn btn-success btn-lg' onclick='javascript:window.close();' title=''>Cerrar</a></h1>" ;
     
 
    
    
    
}
?> 

 </center>
<?php require '../include/footer.php'; ?>
</BODY>
</html>

