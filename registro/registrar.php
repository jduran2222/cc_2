<?php

$titulo = 'Credenciales erróneas';

include_once('../templates/_inc_registro1_header.php');
  
require_once( "../../conexion.php") ;
require_once("../include/funciones.php"); 

  
 //Registramos en w_Accesos el acceso a la web
//function registrar_acceso($user,$pass,$resultado)
//{
//  //extract($GLOBALS);
//  
//   $sql="insert into w_accesos (ip, usuario, clave,  sistema, resultado) values  ('{$_SERVER["REMOTE_ADDR"]}','$user','$pass','$resultado')";
//         $result = $Conn->query($sql);
//
//  return $result;
//} 


//confirmo si es autologin para simular el logueado
if (isset($_GET["login"]))
{
     $login=decrypt2(($_GET["login"]))   ;
     parse_str( $login, $_POST ) ;     // reconstruimos $_GET[] tras desencriptar y continuamos como si nada
}    
    
 $error=0 ;


 $email=trim(strtolower($_POST["email"])); //recojo los valores del formulario y los convierto en miniscula
// $empresa=strtolower($_POST["empresa"]);

 $password=$_POST["password"];
 $where_empresa=isset($_POST["id_c_coste"])? "id_c_coste={$_POST["id_c_coste"]}" : "1=1" ;

 $_SESSION['android']= preg_match('/Android|iPhone|iPad/', $_SERVER['HTTP_USER_AGENT']) ;     // estamos en un movil o tablet

    // GEOLOCALIZACION DE LA IP
 $ip=$_SERVER['REMOTE_ADDR'] ;
 $json_geoip=json_geoip($ip) ;
 $pais= pais($json_geoip); 

 $login=0;   
        // INICIAMOS COMPROBACION DE IDENTIFICACION
// $sql="SELECT id_usuario,id_c_coste,usuario,password_hash,email,admin,admin_chat,autorizado FROM Usuarios_View WHERE email='$email' AND activo=1 AND $where_empresa " ;
 $sql="SELECT * FROM Usuarios_View WHERE email='$email' AND activo=1 AND $where_empresa " ;
 $result=$Conn->query($sql);

if (($num_empresas=$result->num_rows)>0)  
{ 
                  
//              if ($id_usuario=Dfirst("id_usuario","Usuarios","usuario='$user' AND id_c_coste=$id_c_coste")) //existe el usuario en esa empresa
             
              while ( $rs = $result->fetch_array(MYSQLI_ASSOC) )   
                { 
                   
//                       $password_hash_db= Dfirst("password_hash","Usuarios","id_usuario=$id_usuario AND id_c_coste=$id_c_coste") ;
                     $password_hash_db= $rs["password_hash"] ;
                     if (cc_password_verify_hash($password , $password_hash_db))          //  COMPROBACION DE PASSWORD PENDIENTE DE DESARROLLAR
                      {      
                         
//                         // PROVISIONALMENTE, GUARDAMOS LAS PASSWORD EN FREE PARA MIGRARLAS A OPENSSL, anulado JUAND, JULIO2020
//                              $sql_update= "UPDATE `Usuarios` SET password_free='$password'  WHERE  id_usuario={$rs["id_usuario"]}   ; "  ;
//                              $Conn->query($sql_update) ;
 
                  
                               $login=1;   
   
                               registra_session($rs) ;  //registra la variable $_SESSION[]
                               
                               
                               registrar_acceso($_SESSION["id_c_coste"],$_SESSION["user"],$_SESSION["empresa"],'Acceso OK',$ip, 0, $_SESSION['android'] ,$pais, $json_geoip) ;
                               

                               if ($num_empresas>1)    //tenemos más de una empresa
                               {
                                 header('Location: ../menu/pagina_empresas.php');         // TODO OK-> Entramos a pagina_inicio.php  
                               }
                               else
                               {    
                                 header( ($_SESSION['android'] ?  'Location: ../menu/menu_app.php' : 'Location: ../menu/pagina_inicio.php' )  );         // solo tenemos una empresa 
                               }

                               
               
                      }

               }   // salimos del bucle SIN ÉXITO, el email era correcto pero el password no

               if (!$login)   // fuerzo a no registrar acceso erroneo
               {  registrar_acceso(0,"$email","error_no_password","$email CORRECTO, password ERRONEO: $password ",$ip, 1, $_SESSION['android'] ,$pais, $json_geoip) ;
                  $error=1 ;
               }

}       // el email no tiene empresas, no está registrado
 else
{
                 registrar_acceso(0,$email,'error_no_email',"email INCORRECTO : $email",$ip, 1, $_SESSION['android'] ,$pais, $json_geoip) ;
                 $error=2 ;
 }
 
 if ($error)
 {
  
  $htmlError = '';
  $htmlError .= '<div class="login-box">';
  $htmlError .= '  <div class="login-logo">';
  $htmlError .= '    <img width="128px" src="../img/logo_cc_blanco.svg" alt="Logo ConstruCloud 2.0"/>';
  $htmlError .= '    <br>';
  $htmlError .= '    <a href="../"><strong>Constru</strong>Cloud 2.0</a>';
  $htmlError .= '  </div>';
  $htmlError .= '  <!-- /.login-logo -->';
  $htmlError .= '  <div class="card">';
  $htmlError .= '    <div class="card-body login-card-body">';
  $htmlError .= '      <p class="login-box-msg">';
  $htmlError .= '        Las credenciales no son correctas';
  $htmlError .= '      </p>';
  $htmlError .= '      <p class="mb-0">';
  $htmlError .= '        <strong>No hemos encontrado el usuario con estas credenciales.</strong>';
  $htmlError .= '        Por favor, vuelva a intentarlo con las credenciales correctas o contacte con nosotros para poder acceder a su cuenta.';
  $htmlError .= '      </p>';
  $htmlError .= '      <hr>';
  $htmlError .= '      <div class="row">';
  $htmlError .= '        <div class="col-8">';
  $htmlError .= '          <a class="btn btn-secondary small text-white" href="../">Volver</a>';
  $htmlError .= '        </div>';
  $htmlError .= '        <!-- /.col -->';
  $htmlError .= '        <div class="col-4">';
  $htmlError .= '        </div>';
  $htmlError .= '        <!-- /.col -->';
  $htmlError .= '      </div>';
  $htmlError .= '    </div>';
  $htmlError .= '    <!-- /.login-card-body -->';
  $htmlError .= '  </div>';
  $htmlError .= '</div>';
  $htmlError .= '<!-- /.login-box -->';

  echo $htmlError;
 }

$Conn->close();

include_once('../templates/_inc_registro3_footer.php');