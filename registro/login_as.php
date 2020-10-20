<?php
ini_set("session.use_trans_sid",true);
//ini_set("session.gc_maxlifetime",180000);  // parece que no está funcionando
//ini_set('max_file_uploads', 50);

session_start();


require_once("../../conexion.php");
require_once("../include/funciones.php");



if ($_SESSION["admin"] and isset($_GET["id_empresa"]))     // viene el ADMIN a loguearse a una empresa
{
//    $id_empresa=$_GET["id_empresa"] ;
      $id_empresa=$_GET["id_empresa"] ;


      if ($_SESSION["empresa"]=Dfirst("C_Coste_Texto","C_COSTES"," id_c_coste=$id_empresa"))
      {        
       $_SESSION["id_c_coste"]=$id_empresa ;
       $where_c_coste=" id_c_coste={$_SESSION['id_c_coste']} " ;  
       $_SESSION["user"]='admin_log_as' ;  
       $_SESSION["cif"]='' ;
    //   $_SESSION["invitado"]=0 ;        
      }
    
}
//elseif ($result=Dfirst('id_usuario', 'Usuarios_view', "activo=1 AND email={$_SESSION["email"]} AND id_usuario={$_GET["id_usuario"]}" ))             // usuario estandar, admi o no admin
elseif ($result=$Conn->query("SELECT * FROM Usuarios_View WHERE email='{$_SESSION["email"]}' AND activo=1 AND id_usuario={$_GET["id_usuario"]}")) 
{
      // usuario estandar, admin o no admin
        $rs = $result->fetch_array(MYSQLI_ASSOC)      ;
//           $_SESSION["email"]=$rs["email"] ;
//       $_SESSION["id_c_coste"]=$rs["id_c_coste"] ;
//       $_SESSION["empresa"]=$rs["C_Coste_Texto"]  ;
//       $_SESSION["user"]=$rs["usuario"] ;
//       $_SESSION["id_usuario"]=$rs["id_usuario"] ; 
//       $_SESSION["admin"]=$rs["admin"] ;
//       $_SESSION["admin_chat"]=$rs["admin_chat"] ;
//       $_SESSION["autorizado"]=$rs["autorizado"] ;
//       $_SESSION["Moneda_simbolo"]=$rs["Moneda_simbolo"] ;
//       $_SESSION["cif"]=$rs["cif"] ;
//       $_SESSION["invitado"]=0 ;       

       registra_session($rs) ;
    
    
}
 // coletilla a añadir a todas las SQL para garantizar que nunca mezclamos datos de dos empresas
$where_c_coste=" id_c_coste={$_SESSION['id_c_coste']} " ;  

//echo "<script languaje='javascript' type='text/javascript'>window.close();</script>"; 

//header(($_SESSION['android'] ?  'Location: ../menu/menu_app.php' : 'Location: ../menu/pagina_inicio.php' ));         // TODO OK-> Entramos a pagina_inicio.php   
header( 'Location: ../menu/pagina_inicio.php' );         // TODO OK-> Entramos a pagina_inicio.php   
?>