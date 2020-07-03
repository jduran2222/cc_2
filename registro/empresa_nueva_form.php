<html>
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-1">
	<link rel='shortcut icon' type='image/x-icon' href='/favicon.ico' />
	
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
        <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.6.3/css/all.css" integrity="sha384-UHRtZLI+pbxtHCWp1t77Bi1L4ZtiqrqD80Kn4Z8NTSRyMA2Fd33n5dQ8lWUE00s/" crossorigin="anonymous">
   <link rel="stylesheet" href="../css/estilos.css<?php echo (isset($_SESSION["is_desarrollo"]) AND $_SESSION["is_desarrollo"])? "?d=".date("ts") : "" ; ?>" type="text/css">

  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
<title>ConstruCloud 0.90</title>
</head>


<body >
    <style>
        
        td {font-size: 30px}
        
    </style>
<?php   
    ini_set("display_errors", 1);
    error_reporting(E_ALL); 


    
?>

<center>
<div >
	<p align=center style='text-align:center'>
            <img width="400" src="../img/construcloud64.svg"> 
	</p>
   
</div>
	
<div >    
<h1>Crear Nueva Empresa</h1>
<form action="empresa_nueva.php" method="post" name="form1" enctype="multipart/form-data" >

  <table style='width:60%'  align="center"   class="table table-bordered table-hover ">
	<tr>
      <td><div ><span class="glyphicon glyphicon-envelope"></span> Email *</div></td>
      <td><span >
        <input name="email" size='40' type="email" required style="background-color:#C8C8C8 ">
      </span></td>
	<tr>
    <tr>
      <td><div ><span class="glyphicon glyphicon-wrench"></span> Password *</div></td>
      <td><span >
        <input name="password" type="password" required style="background-color:#C8C8C8 ">
      </span></td>
    </tr>
      
    <tr>
        <td><div ><span class="glyphicon glyphicon-home"></span> Empresa<font size='2'> (opcional)</font></div></td>
      <td>
        <input name="empresa" type="text" style="background-color:#C8C8C8 ">
     </td>  
    </tr>
 
    <tr>    
      <td><div ><i class="far fa-user"></i> Usuario<font size='2'> (opcional)</font></div></td>
      <td><span >
        <input name="user" type="text"  style="background-color: #C8C8C8"  > 
      </span></td>
    </tr>
<!--    <tr>
      <td><div ><span class="glyphicon glyphicon-wrench"></span> Código *</div></td>
      <td><span >
        <input name="codigo" type="password" required style="background-color:#C8C8C8 "> 
      </span></td>
    </tr>-->

    <tr>    
      <td><div ><span class="glyphicon glyphicon-camera"></span> Logo empresa<font size='2'> (opcional)</font></div></td>
      <td><span >
        <input name="logo_file" type="file" style="background-color:#C8C8C8 ">
      </span></td>  
    </tr>
    <tr>    
      <td><div style='text-align:right;' > *</div></td>
      <td><span >
              <h5> <input name="acepto" type="checkbox" required style="background-color:#C8C8C8 "> He leído y acepto la <a href=# >Condiciones de uso</a>, <a href=# >Política de privacidad</a> y <a href=# >Aviso legal</a> </h5>
      </span></td>  
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td colspan="2"><div align="center">
        <input class="btn btn-success" style='width:50%;font-size:40px' type="submit" name="Submit" value="Aceptar"  >
      </div></td>
      
    </tr>
  </table>


  </form>
</div>

</center>
  

<?php require '../include/footer.php'; ?>
</BODY>
</html>

