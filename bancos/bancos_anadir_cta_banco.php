<?php
require_once("../include/session.php");
?>
<?php



$tipo=($_POST["tipo"]) ;
$banco=($_POST["Banco"]) ;
$N_Cta=str_replace(' ','',$_POST["N_Cta"]) ;
$Linea_Dto=($_POST["Linea_Dto"]) ;
$Limite_Dto=($_POST["Limite_Dto"]) ;

// registramos el documento en la bbdd
require_once("../../conexion.php"); 
require_once("../include/funciones.php"); 

		

$id_cta_banco0=Dfirst( "MAX(id_cta_banco)", "ctas_bancos", "id_c_coste={$_SESSION["id_c_coste"]}" ) ;
$sql="INSERT INTO `ctas_bancos` ( `id_c_coste`,`tipo`, `banco`, `N_Cta`,`Linea_Dto`, `Limite_Dto`, `user` )    VALUES ( {$_SESSION["id_c_coste"]} , '$tipo', '$banco' ,'$N_Cta' ,$Linea_Dto ,$Limite_Dto , '{$_SESSION["user"]}' );" ;
//echo ($sql);
$result=$Conn->query($sql);
          
 if ($result) //compruebo si se ha insertado correctamente la nueva cuenta
     { 
	   if (($id_cta_banco=Dfirst( "MAX(id_cta_banco)", "ctas_bancos", "id_c_coste={$_SESSION['id_c_coste']} " )) <> $id_cta_banco0 )   // calculo el nuevo id_cta_banco y confirmo que es uno nuevo diferente al anterior
		  {
	             // TODO OK-> Entramos a la cuenta
	        echo "Cuenta bancaria creada satisfactoriamente." ;
		    echo  "Ir a la cuenta <a href=\"../bancos/bancos_mov_bancarios.php?_m=$_m&id_cta_banco=$id_cta_banco\" title='ver cuenta bancaria'> $tipo - $banco - $N_Cta </a>" ;
		  }
			else
		  {
			echo "Error al crear cuenta bancaria, inténtelo de nuevo " ;
			echo  "<a href='javascript:history.back(-1);' title='Ir la página anterior'>Volver</a>" ;
	      }
       
		}
     else
     {
	    echo "Error al insertar nueva cuenta bancaria, inténtelo de nuevo " ;
	    echo  "<a href='javascript:history.back(-1);' title='Ir la página anterior'>Volver</a>" ;
      }
       

?>