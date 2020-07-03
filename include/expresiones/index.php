<HTML>
<HEAD>
     <title>Expresiones</title>

	<meta http-equiv="Content-type" content="text/html; charset=UTF-8" />
	<link rel='shortcut icon' type='image/x-icon' href='/favicon.ico' />
	
  <!--ANULADO 16JUNIO20<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">-->
        <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.6.3/css/all.css" integrity="sha384-UHRtZLI+pbxtHCWp1t77Bi1L4ZtiqrqD80Kn4Z8NTSRyMA2Fd33n5dQ8lWUE00s/" crossorigin="anonymous">
   <link rel="stylesheet" href="../css/estilos.css<?php echo (isset($_SESSION["is_desarrollo"]) AND $_SESSION["is_desarrollo"])? "?d=".date("ts") : "" ; ?>" type="text/css">

  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
  <!--ANULADO 16JUNIO20<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>-->
  <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>

</HEAD>
<BODY>

<?php
include("Evaluar.php");
    $evaluadorExpresiones2 = new Evaluar();
      
    $exp="50*.15" ;
     $Transformado = $evaluadorExpresiones2->TransformaExpresion($exp);
     $ExprNegativos = $evaluadorExpresiones2->ArreglaNegativos($Transformado);

     
    $evaluadorExpresiones2->Analizar($ExprNegativos);

    echo  $evaluadorExpresiones2->Calcular();
;
    
?>

           
        
        
        
<?php require '../include/footer.php'; ?>
</BODY>
</HTML>

