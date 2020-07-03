<?php
ini_set("session.use_trans_sid",true);
session_start();
?>


<html>  
<head> 
<title>ConstruCloud</title>
    <meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-1">
    <link rel='shortcut icon' type='image/x-icon' href='/favicon.ico' />
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.6.3/css/all.css" integrity="sha384-UHRtZLI+pbxtHCWp1t77Bi1L4ZtiqrqD80Kn4Z8NTSRyMA2Fd33n5dQ8lWUE00s/" crossorigin="anonymous">
<link rel="stylesheet" href="../css/estilos.css<?php echo (isset($_SESSION["is_desarrollo"]) AND $_SESSION["is_desarrollo"])? "?d=".date("ts") : "" ; ?>" type="text/css">

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>

</head>


<body >
<?php   
    ini_set("display_errors", 1);
    error_reporting(E_ALL);
?>
 <style>

       td {font-size: 30px}
          @media only screen and (max-width:980px) {
            /* For mobile phones: antes 500px */
            /*   #tabla_ficha2 {
                font-size: 2.2vw; 
              }*/

/*            td p label {
                font-size: 6vw; 
            }
            .btn {
                font-size: 6vw; 
            }
           a.discreto {
                font-size: 4vw; 
            }
            a {
                font-size: 6vw; 
            }
            input[type=date] {
                transform: scale(3);
                font-size: 6vw;   
            }
            input[type=checkbox] {
                transform: scale(3);
                font-size: 6vw;   
            }
            input , h1, h2, h3, h4, h5 {
                transform: scale(1.5);
                font-size: 6vw;   
            }

 */

        }     


    </style>

    
<center>
<div >
    <h1 style='text-align:center; color:lightskyblue; font-family:verdana '>ConstruCloud.es</h1>
		<img width="300"    src="../img/construcloud64.svg">
                <h3 style='color:silver;'>Inicio sesión</h3><br><br><br><br>
   
</div>

	
<?php


$user=isset($_SESSION["user"])? $_SESSION["user"] : "" ; // estamos logados? es decir, hay SESSION abierta?
$empresa=isset($_SESSION["empresa"])? $_SESSION["empresa"] : "" ;

//if(isset($_GET["login_error"]))
//{   
//    echo "<h1 style='color:red'> ¡¡ERROR DE ACCESO, intentelo de nuevo!!</h1>" ;
//}  


?> 

<form action="../registro/registrar.php" method="post" name="form1"  >
 
  <table style='width:60%'  align="center"   class="table table-bordered table-hover ">
    
<!--    <tr>
      <td><div align="center"><span class="glyphicon glyphicon-home"></span> Empresa</div></td>
      <td><span class="encabezadopagina2">
        <input class="form-control" name="empresa" required type="text" value="<?php // echo $empresa ;?>"  tabindex=""  >
      </span></td>
    </tr>-->
	   <tr>
        <td><div ><span class="glyphicon glyphicon-envelope"></span> Email *</div></td>
      <td><span >
        <input name="email" size='40' type="email" required style="background-color:#C8C8C8 ">
      </span></td>
    </tr>
   
    <tr>
      <td><div ><span class="glyphicon glyphicon-wrench"></span> Password *</div></td>
      <td><span >
        <input name="password" type="password" required style="background-color:#C8C8C8 ">
      </span></td>
    </tr><tr>
        <td ></td><td>
        <div >  
            
              <br><p><input class="btn btn-success" style='width:50%;font-size:40px' type="submit" name="Submit" value="Aceptar"  ></p></div>
              <br><a class="discreto" href="../registro/olvide_password.php" >Olvidé mi password</a>    
      </td>
    </tr>
    
    <tr> <td> </td><td><div style='float:center;font-size:small;'><p>¿Aún no tienes empresa creada? <a  href="../registro/empresa_nueva_form.php" >Crear empresa GRATIS</a> </p>

        <br><br>
      </div></td>
      <!--<td ><input class="btn btn-primary btn-lg" name="Cancelar" type="reset" value="Cancelar"></td>-->
    </tr>
  </table>

    <!--<p align="center" ><br><br><br><a class="boton" href="../registro/empresa_demo.php" >VER CONSTRUCCIONES DEMO</a> </p>-->
  </form>
</center>
  
</div>
</body>
</html>

