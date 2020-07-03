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
    $evaluadorExpresiones = new Evaluar();
    $evaluadorExpresiones2 = new Evaluar();
      
    //Estas expresiones presentan fallas sint�cticas. Sirve para probar el chequeador de sintaxis
    $exprAlgebraica[0] =  " 5 * 9 ";
    $exprAlgebraica[1] =  " 5.31-(4.6*)+3 ";
    $exprAlgebraica[2] =  " 7+3.4- ";
    $exprAlgebraica[3] =  "  5-(*9.4/2)+1 ";
    $exprAlgebraica[4] =  "  /5.67*12-6+4 ";
    $exprAlgebraica[5] =  "  3-(2*4) ) ";
    $exprAlgebraica[6] =  "  7+((4-3) ";
    $exprAlgebraica[7] =  "  7- 90.87 * (   ) +9.01";
    $exprAlgebraica[8] =  "  2+3)-2)*3+((4";
    $exprAlgebraica[9] =  " (3-5)7-(1+2)";
    $exprAlgebraica[10] =  " 7-2(5-6) + 8";
    $exprAlgebraica[11] =  "  3-2..4+1 ";
    $exprAlgebraica[12] =  "  2.5+78.23.1-4 ";
    $exprAlgebraica[13] =  "  (12-4)y-1 ";
    $exprAlgebraica[14] =  "  4-z.1+3 ";
    $exprAlgebraica[15] =  " 7-2.p+1 ";
    $exprAlgebraica[16] =  "  3x+1";
    $exprAlgebraica[17] =  "  x21+4 ";
    $exprAlgebraica[18] =  "  7+abrg-8";
    $exprAlgebraica[19] =  "  5*alo(78) ";
    $exprAlgebraica[20] =  "  5+tr-xc+5  ";
    $exprAlgebraica[21] = "  5-a(7+3)";
    $exprAlgebraica[22] = "  (4-5)(2*x) ";
    $exprAlgebraica[23] = " -.3+7  ";
    $exprAlgebraica[24] = " 3*(.5+4) ";
    $exprAlgebraica[25] = " 7+3.(2+6) ";
    $exprAlgebraica[26] = "  (4+5).7-2 ";
    $exprAlgebraica[27] = " 5.*9+1  ";
    $exprAlgebraica[28] = " (3+2.)*5 ";
     
    //Estas expresiones son correctas sint�cticamente
    $exprAlgebraica[29] = " --5 "; $resultado[29] = 5;
    $exprAlgebraica[30] = " -(-(-(-(-(-(-1^(-(-(-(-1))))))))))"; $resultado[30] = -1;
    $exprAlgebraica[31] = "  --(--(--(--(--(--(--1^(--(--(--(--1))))))))))"; $resultado[31] = 1;
    $exprAlgebraica[32] = " --1*-2*-3*(--4*-2/-4/-2)/-3^-1 "; $resultado[32] = 18;
    $exprAlgebraica[33] = " -1-(-2-(-3)) "; $resultado[33] = -2;
    $exprAlgebraica[34] = " -1^2-(-2^2-(-3^2)) "; $resultado[34] = 6;
    $exprAlgebraica[35] = " -1^-2-(-2^-2-(-3^-2)) "; $resultado[35] = 0.861111111111111;
    $exprAlgebraica[36] = " -1^-3-(-2^-3-(-3^-3)) "; $resultado[36] = -0.912037037037037;
    $exprAlgebraica[37] = " (--1) "; $resultado[37] = 1;
    $exprAlgebraica[38] = " --1 "; $resultado[38] = 1;
    $exprAlgebraica[39] = " --3--2--4--5--6 "; $resultado[39] = 20;
    $exprAlgebraica[40] = " --3^-2--2^-2--4^-2--5^-2--6^-2 "; $resultado[40] = -0.269166666666667;
    $exprAlgebraica[41] = " ((((-1)*-1)*-1)*-1) "; $resultado[41] = 1;
    $exprAlgebraica[42] = " 0/2/3/4/5/6/-7 "; $resultado[42] = 0;
    $exprAlgebraica[43] = " 0/-1 "; $resultado[43] = 0;
    $exprAlgebraica[44] = " --2 "; $resultado[44] = 2;
    $exprAlgebraica[45] = " --2^2 "; $resultado[45] = 4;
    $exprAlgebraica[46] = " -(-2^3) "; $resultado[46] = 8;
    $exprAlgebraica[47] = "  -(-2^-3)"; $resultado[47] = 0.125;
    $exprAlgebraica[48] = " X-(Y-(Z-(-1*X)*y)*z) "; $resultado[48] = 2084;
    $exprAlgebraica[49] = " ASN(-0.67)+ACS(-0.3*-0.11)+ATN(-4.5/-2.3)+EXP(-2)-SQR(9.7315)-RCB(7)+LOG(7.223) + CEI(10.1) "; $resultado[49] = 9.98202019592338;
    $exprAlgebraica[50] = " -SEN(-12.78)+COS(-SEN(7.1)+ABS(-4.09))+ TAN(-3.4*-5.7)+ LOG(9.12-5.89) "; $resultado[50] = 0.994984132031446;


    for ($cont=100; $cont < 51; $cont++)
    {
      echo "<br><br><" . $cont . "> Expresion inicial es: [" . $exprAlgebraica[$cont] . "]";
  
      //Quita espacios, tabuladores, encierra en par�ntesis, vuelve a min�sculas 
      $Transformado = $evaluadorExpresiones->TransformaExpresion($exprAlgebraica[$cont]);
      echo "<br>Transformada: [" . $Transformado . "]";
  
      //Chequea la sintaxis de la expresi�n
      $chequeoSintaxis = $evaluadorExpresiones->EvaluaSintaxis($Transformado);
      if ($chequeoSintaxis == 0)  //Si la sintaxis es correcta
      {
        //Transforma la expresi�n para aceptar los menos unarios agregando (0-1)#
        $ExprNegativos = $evaluadorExpresiones->ArreglaNegativos($Transformado);
        echo "<br>Negativos unarios: [" . $ExprNegativos . "]";
        
        //Analiza la expresi�n
        $evaluadorExpresiones->Analizar($ExprNegativos);
        
        //Da valor a las variables
        $evaluadorExpresiones->ValorVariable('x', 7);
        $evaluadorExpresiones->ValorVariable('y',  13);
        $evaluadorExpresiones->ValorVariable('z', 19);

        //Eval�a la expresi�n para retornar un valor
        $valor = $evaluadorExpresiones->Calcular();

        //Compara el valor retornado con el esperado. Si falla el evaluador, este si condicional avisa
        if (abs($valor - $resultado[$cont])>0.01)
            echo "<br>FALLA EN [" . $ExprNegativos . "] Calculado: " . $valor . " Esperado: " . $resultado[$cont];

        //Si hay un fallo matem�tico se captura con este si condicional
        if (is_nan($valor) || is_infinite($valor))
            echo "<br>Error matemático";
        else  //No hay fallo matem�tico, se muestra el valor
            echo "<br>Resultado es: " . $valor;
      }
      else
        echo "<br>La validación es: " . $evaluadorExpresiones->MensajeSintaxis($chequeoSintaxis);
    }
    
    echo "----------------------- JUAND ------------------<br>";
    $exp="50/0" ;
     $Transformado = $evaluadorExpresiones2->TransformaExpresion($exp);
     $ExprNegativos = $evaluadorExpresiones2->ArreglaNegativos($Transformado);

     
    $evaluadorExpresiones2->Analizar($ExprNegativos);

    echo  $evaluadorExpresiones2->Calcular();
    echo "----------------------- JUAND2 ------------------<br>";
    
     require_once("../../include/funciones.php");

    echo evalua_expresion($exp) ;
;
    
?>

           
        
        
        
</BODY>
</HTML>

