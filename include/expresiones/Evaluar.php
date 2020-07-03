<?php
/*  Autor: Rafael Alberto Moreno Parra
  Sitio Web:  http://darwin.50webs.com
  Correo:  enginelife@hotmail.com

  Evaluador de expresiones algebraicas por ejemplo, 57+1.87/84.89-(6.8*e+b+8769-4*b/8+b^2*4^e/f)+5.4-(d/9.6+0.2) con las siguientes funcionalidades:
  1. Ilimitado número de paréntesis
  2. Más rápido y más sencillo que el evaluador escrito para el primer libro: "Desarrollo de un evaluador de expresiones algebraicas"
  3. Manejo de 26 variables
  4. Manejo de 12 funciones
  5. Manejo de operadores +, -, *, /, ^ (potencia)
  6. Manejo del menos unario: lo reemplaza con (0-1)# donde # es la operación con mayor relevancia y equivale a la multiplicación

  Versión: 2.00 [Genera el libro "Desarrollo de un evaluador de expresiones algebraicas. Versión 2.0"]
  Fecha: Enero de 2013
  Licencia: LGPL

  Algoritmo:

  Se toma una expresión como 7*x+sen(12.8/y+9)-5*cos(9-(8.3/5.11^3-4.7)*7.12)+0.445
  Se agregan paréntesis de inicio y fin  (7*x+sen(12.8/y+9)-5*cos(9-(8.3/5.11^3-4.7)*7.12)+0.445)
  Se divide en piezas simples   | ( | 7 | * | x | + | sen( | 12.8 | / | y | + | 9 | ) | - | 5 | * | cos( | 9 | - | ( | 8.3 | / | 5.11 | ^ | 3 | - | 4.7 | ) | * | 7.12 | ) | + | 0.445 | ) |
  Esas piezas están clasificadas:
   Paréntesis que abre (
   Paréntesis que cierra )
   Números  7   12.8  9   5
   Variables  x  y
   Operadores + - * / ^
   Funciones  sen(  cos(
  Luego se convierte esa expresión larga en expresiones cortas de ejecución del tipo
  Acumula = operando(número/variable/acumula)  operador(+, -, *, /, ^)   operando(número/variable/acumula)
    [0]  5.11 ^ 3
    [1]  8.3  / [0]
    [2]  [1] - 4.7
    [3]  [2] + 0
    [4]  [3] * 7,12
    [5]  9   - [4]
    [6]  cos([5])
    [7]  12,8 / y
    [8]  [7] +  9
    [9]  sen([8])
    [10] 7 * x
    [11] 5 * [6]
    [12] [10] + [9]
    [13] [12] - [11]
    [14] [13] + 0.445
    [15] [14] + 0
  La expresión ya está analizada y lista para evaluar.
  Se evalúa yendo de [0] a [15], en [15] está el valor final.
*/

include("Pieza_Simple.php");
include("Pieza_Ejecuta.php");

class Evaluar
{
   /* Esta constante sirve para que se reste al carácter y se obtenga el número.  Ejemplo:  '7' - ASCIINUMERO =  7 */
   var $ASCIINUMERO = 48;
   
   /* Esta constante sirve para que se reste al carácter y se obtenga el número de la letra. Ejemplo:  'b' - ASCIILETRA =  1 */
   var $ASCIILETRA = 97;
   
   /* Las funciones que soporta este evaluador */
   var $TAMANOFUNCION = 39;
   var $listaFunciones = "sinsencostanabsasnacsatnlogceiexpsqrrcb";  
   
   /* Constantes de los diferentes tipos de datos que tendrán las piezas */
   var $ESFUNCION = 1;
   var $ESPARABRE = 2;
   var $ESPARCIERRA = 3;
   var $ESOPERADOR = 4;
   var $ESNUMERO = 5;
   var $ESVARIABLE = 6;
   
   //Listado de Piezas de análisis
   var $PiezaSimple = array();
   
   //Listado de Piezas de ejecución
   var $PiezaEjecuta = array();
   var $Contador_Acumula = 0;
   
   //Almacena los valores de las 26 diferentes variables que puede tener la expresión algebraica
   var $VariableAlgebra = array();

  //Valida la expresión algebraica
  public function EvaluaSintaxis($expresion)
  {
    //Hace 25 pruebas de sintaxis
    if ($this->DobleTripleOperadorSeguido($expresion)) return 1;
    if ($this->OperadorParentesisCierra($expresion)) return 2;
    if ($this->ParentesisAbreOperador($expresion)) return 3;
    if ($this->ParentesisDesbalanceados($expresion)) return 4;
    if ($this->ParentesisVacio($expresion)) return 5;
    if ($this->ParentesisBalanceIncorrecto($expresion)) return 6;
    if ($this->ParentesisCierraNumero($expresion)) return 7;
    if ($this->NumeroParentesisAbre($expresion)) return 8;
    if ($this->DoblePuntoNumero($expresion)) return 9;
    if ($this->ParentesisCierraVariable($expresion)) return 10;
    if ($this->VariableluegoPunto($expresion)) return 11;
    if ($this->PuntoluegoVariable($expresion)) return 12;
    if ($this->NumeroAntesVariable($expresion)) return 13;
    if ($this->VariableDespuesNumero($expresion)) return 14;
    if ($this->Chequea4letras($expresion)) return 15;
    if ($this->FuncionInvalida($expresion)) return 16;
    if ($this->VariableInvalida($expresion)) return 17;
    if ($this->VariableParentesisAbre($expresion)) return 18;
    if ($this->ParCierraParAbre($expresion)) return 19;
    if ($this->OperadorPunto($expresion)) return 20;
    if ($this->ParAbrePunto($expresion)) return 21;
    if ($this->PuntoParAbre($expresion)) return 22;
    if ($this->ParCierraPunto($expresion)) return 23;
    if ($this->PuntoOperador($expresion)) return 24;
    if ($this->PuntoParCierra($expresion)) return 25;

    return 0; //No se detectó error de sintaxis
  }

  //Muestra mensaje de error sintáctico
  public function MensajeSintaxis($CodigoError)
  {
    switch($CodigoError)
    {
      case 0:  return "No se detectó error sintáctico en las 25 pruebas que se hicieron.";
      case 1:  return "1. Dos o más operadores estén seguidos. Ejemplo: 2++4, 5-*3"; 
      case 2:  return "2. Un operador seguido de un paréntesis que cierra. Ejemplo: 2-(4+)-7"; 
      case 3:  return "3. Un paréntesis que abre seguido de un operador. Ejemplo: 2-(*3)"; 
      case 4:  return "4. Que los paréntesis estén desbalanceados. Ejemplo: 3-(2*4))"; 
      case 5:  return "5. Que haya paréntesis vacío. Ejemplo: 2-()*3"; 
      case 6:  return "6. Paréntesis que abre no corresponde con el que cierra. Ejemplo: 2+3)-2*(4"; 
      case 7:  return "7. Un paréntesis que cierra y sigue un número. Ejemplo: (3-5)7-(1+2)"; 
      case 8:  return "8. Un número seguido de un paréntesis que abre. Ejemplo: 7-2(5-6)"; 
      case 9:  return "9. Doble punto en un número de tipo real. Ejemplo: 3-2..4+1  7-6.46.1+2"; 
      case 10: return "10. Un paréntesis que cierra seguido de una variable. Ejemplo: (12-4)y-1"; 
      case 11: return "11. Una variable seguida de un punto. Ejemplo: 4-z.1+3"; 
      case 12: return "12. Un punto seguido de una variable. Ejemplo: 7-2.p+1"; 
      case 13: return "13. Un número antes de una variable. Ejemplo: 3x+1"; 
      case 14: return "14. Un número después de una variable. Ejemplo: x21+4"; 
      case 15: return "15. Hay 4 o más letras seguidas. Ejemplo: 12+ramp+8.9"; 
      case 16: return "16. Función inexistente. Ejemplo: 5*alo(78)"; 
      case 17: return "17. Variable inválida (solo pueden tener una letra). Ejemplo: 5+tr-xc+5"; 
      case 18: return "18. Variable seguida de paréntesis que abre. Ejemplo: 5-a(7+3)";
      case 19: return "19. Después de paréntesis que cierra sigue paréntesis que abre. Ejemplo: (4-5)(2*x)";
      case 20: return "20. Después de operador sigue un punto. Ejemplo: -.3+7";
      case 21: return "21. Después de paréntesis que abre sigue un punto. Ejemplo: 3*(.5+4)";
      case 22: return "22. Un punto seguido de un paréntesis que abre. Ejemplo: 7+3.(2+6)";
      case 23: return "23. Paréntesis cierra y sigue punto. Ejemplo: (4+5).7-2";
      case 24: return "24. Punto seguido de operador. Ejemplo: 5.*9+1";   
      default: return "25. Punto seguido de paréntesis que cierra. Ejemplo: (3+2.)*5";
    }
  }
  
  //Retira caracteres inválidos. Pone la expresión entre paréntesis.
  public function TransformaExpresion($expr)
  {
    $validos = "abcdefghijklmnopqrstuvwxyz0123456789.+-*/^()";
    $expr2 = strtolower($expr);
    $nuevaExpr = "(";
    for($pos = 0; $pos < strlen($expr2); $pos++)
    {
      $letra = $expr2{$pos};
      for($valida = 0; $valida < strlen($validos); $valida++)
        if ($letra == $validos{$valida})
        {
          $nuevaExpr .= $letra;
          break;
        }
    }
    $nuevaExpr .= ')';
    return $nuevaExpr;
  }  
  
  //1. Dos o más operadores estén seguidos. Ejemplo: 2++4, 5-*3
  function DobleTripleOperadorSeguido($expr)
  {
    for($pos = 0; $pos < strlen($expr) - 1; $pos++)
    {
      $car1 = $expr{$pos};   //Extrae un carácter
      $car2 = $expr{$pos + 1}; //Extrae el siguiente carácter

      //Compara si el carácter y el siguiente son operadores, dado el caso retorna true
      if ($car1 == '+' || $car1 == '-' || $car1 == '*' || $car1 == '/' || $car1 == '^')
        if ($car2 == '+' || $car2 == '*' || $car2 == '/' || $car2 == '^')
          return true;
    }
    
    for ($pos = 0; $pos < strlen($expr) - 2; $pos++)
    {
      $car1 = $expr{$pos};   //Extrae un carácter
      $car2 = $expr{$pos + 1}; //Extrae el siguiente carácter
      $car3 = $expr{$pos + 2}; //Extrae el siguiente carácter


      //Compara si el carácter y el siguiente son operadores, dado el caso retorna true
      if ($car1 == '+' || $car1 == '-' || $car1 == '*' || $car1 == '/' || $car1 == '^')
        if ($car2 == '+' || $car2 == '-' || $car2 == '*' || $car2 == '/' || $car2 == '^')
          if ($car3 == '+' || $car3 == '-' || $car3 == '*' || $car3 == '/' || $car3 == '^')
            return true;
    }

    return false;  //No encontró doble/triple operador seguido
  }

  //2. Un operador seguido de un paréntesis que cierra. Ejemplo: 2-(4+)-7
  function OperadorParentesisCierra($expr)
  {
    for($pos = 0; $pos < strlen($expr) - 1; $pos++)
    {
      $car1 = $expr{$pos};   //Extrae un carácter

      //Compara si el primer carácter es operador y el siguiente es paréntesis que cierra
      if ($car1 == '+' || $car1 == '-' || $car1 == '*' || $car1 == '/' || $car1 == '^')
        if ($expr{$pos + 1} == ')') return true;
    }
    return false; //No encontró operador seguido de un paréntesis que cierra
  }

  //3. Un paréntesis que abre seguido de un operador. Ejemplo: 2-(*3)
  function ParentesisAbreOperador($expr)
  {
    for($pos = 0; $pos < strlen($expr) - 1; $pos++)
    {
      $car2 = $expr{$pos + 1}; //Extrae el siguiente carácter

      //Compara si el primer carácter es paréntesis que abre y el siguiente es operador
      if ($expr{$pos} == '(')
        if ($car2 == '+' || $car2 == '*' || $car2 == '/' || $car2 == '^') return true;
    }
    return false;  //No encontró paréntesis que abre seguido de un operador
  }

  //4. Que los paréntesis estén desbalanceados. Ejemplo: 3-(2*4))
  function ParentesisDesbalanceados($expr)
  {
    $parabre = 0; $parcierra = 0;
    for($pos = 0; $pos < strlen($expr); $pos++)
    {
      $car1 = $expr{$pos};
      if ($car1 == '(') $parabre++;
      if ($car1 == ')') $parcierra++;
    }
    return $parabre != $parcierra;
  }

  //5. Que haya paréntesis vacío. Ejemplo: 2-()*3
  function ParentesisVacio($expr)
  {
    //Compara si el primer carácter es paréntesis que abre y el siguiente es paréntesis que cierra
    for($pos = 0; $pos < strlen($expr) - 1; $pos++)
      if ($expr{$pos} == '(' && $expr{$pos + 1} == ')') return true;
    return false;
  }

  //6. Así estén balanceados los paréntesis no corresponde el que abre con el que cierra. Ejemplo: 2+3)-2*(4
  function ParentesisBalanceIncorrecto($expr)
  {
    $balance = 0;
    for($pos = 0; $pos < strlen($expr); $pos++)
    {
      $car1 = $expr{$pos};   //Extrae un carácter
      if ($car1 == '(') $balance++;
      if ($car1 == ')') $balance--;
      if ($balance < 0) return true; //Si cae por debajo de cero es que el balance es erróneo
    }
    return false;
  }

  //7. Un paréntesis que cierra y sigue un número o paréntesis que abre. Ejemplo: (3-5)7-(1+2)(3/6)
  function ParentesisCierraNumero($expr)
  {
    for($pos = 0; $pos < strlen($expr) - 1; $pos++)
    {
      $car2 = $expr{$pos + 1}; //Extrae el siguiente carácter

      //Compara si el primer carácter es paréntesis que cierra y el siguiente es número
      if ($expr{$pos} == ')')
        if ($car2 >= '0' && $car2 <= '9') return true;
    }
    return false;
  }

  //8. Un número seguido de un paréntesis que abre. Ejemplo: 7-2(5-6)
  function NumeroParentesisAbre($expr)
  {
    for($pos = 0; $pos < strlen($expr) - 1; $pos++)
    {
      $car1 = $expr{$pos};   //Extrae un carácter

      //Compara si el primer carácter es número y el siguiente es paréntesis que abre
      if ($car1 >= '0' && $car1 <= '9')
        if ($expr{$pos + 1} == '(') return true;
    }
    return false;
  }

  //9. Doble punto en un número de tipo real. Ejemplo: 3-2..4+1  7-6.46.1+2
  function DoblePuntoNumero($expr)
  {
    $totalpuntos = 0;
    for($pos = 0; $pos < strlen($expr); $pos++)
    {
      $car1 = $expr{$pos};   //Extrae un carácter
      if (($car1 < '0' || $car1 > '9') && $car1 != '.') $totalpuntos = 0;
      if ($car1 == '.') $totalpuntos++;
      if ($totalpuntos > 1) return true;
    }
    return false;
  }

  //10. Un paréntesis que cierra seguido de una variable. Ejemplo: (12-4)y-1
  function ParentesisCierraVariable($expr)
  {
    for($pos = 0; $pos < strlen($expr) - 1; $pos++)
      if ($expr{$pos} == ')') //Compara si el primer carácter es paréntesis que cierra y el siguiente es letra
        if ($expr{$pos + 1} >= 'a' && $expr{$pos + 1} <= 'z')
          return true;
    return false;
  }

  //11. Una variable seguida de un punto. Ejemplo: 4-z.1+3
  function VariableluegoPunto($expr)
  {
    for($pos = 0; $pos < strlen($expr) - 1; $pos++)
      if ($expr{$pos} >= 'a' && $expr{$pos} <= 'z')
        if ($expr{$pos + 1} == '.') return true;
    return false;
  }

  //12. Un punto seguido de una variable. Ejemplo: 7-2.p+1
  function PuntoluegoVariable($expr)
  {
    for($pos = 0; $pos < strlen($expr) - 1; $pos++)
      if ($expr{$pos} == '.')
        if ($expr{$pos + 1} >= 'a' && $expr{$pos + 1} <= 'z')
          return true;
    return false;
  }

  //13. Un número antes de una variable. Ejemplo: 3x+1
  //Nota: Algebraicamente es aceptable 3x+1 pero entonces vuelve más complejo un evaluador porque debe saber que 3x+1 es en realidad 3*x+1
  function NumeroAntesVariable($expr)
  {
    for($pos = 0; $pos < strlen($expr) - 1; $pos++)
      if ($expr{$pos} >= '0' && $expr{$pos} <= '9')
        if ($expr{$pos + 1} >= 'a' && $expr{$pos + 1} <= 'z')
          return true;
    return false;
  }

  //14. Un número después de una variable. Ejemplo: x21+4
  function VariableDespuesNumero($expr)
  {
    for($pos = 0; $pos < strlen($expr) - 1; $pos++)
      if ($expr{$pos} >= 'a' && $expr{$pos} <= 'z')
        if ($expr{$pos + 1} >= '0' && $expr{$pos + 1} <= '9')
          return true;
    return false;
  }

  //15. Chequea si hay 4 o más letras seguidas
  function Chequea4letras($expr)
  {
    for($pos = 0; $pos < strlen($expr) - 3; $pos++)
    {
      $car1 = $expr{$pos};
      $car2 = $expr{$pos + 1};
      $car3 = $expr{$pos + 2};
      $car4 = $expr{$pos + 3};

      if ($car1 >= 'a' && $car1 <= 'z' && $car2 >= 'a' && $car2 <= 'z' && $car3 >= 'a' && $car3 <= 'z' && $car4 >= 'a' && $car4 <= 'z')
        return true;
    }
    return false;
  }

  //16. Si detecta tres letras seguidas y luego un paréntesis que abre, entonces verifica si es función o no
  function FuncionInvalida($expr)
  {
    for($pos = 0; $pos < strlen($expr) - 2; $pos++)
    {
      $car1 = $expr{$pos};
      $car2 = $expr{$pos + 1};
      $car3 = $expr{$pos + 2};

      //Si encuentra tres letras seguidas
      if ($car1 >= 'a' && $car1 <= 'z' && $car2 >= 'a' && $car2 <= 'z' && $car3 >= 'a' && $car3 <= 'z')
      {
        if ($pos >= strlen($expr) - 4) return true; //Hay un error porque no sigue paréntesis
        if ($expr{$pos + 3} != '(') return true; //Hay un error porque no hay paréntesis
        if ($this->EsFuncionInvalida($car1, $car2, $car3)) return true;
      }
    }
    return false;
  }

  //Chequea si las tres letras enviadas son una función
  function EsFuncionInvalida($car1, $car2, $car3)
  {
    $listafunciones = "sinsencostanabsasnacsatnlogceiexpsqrrcb";
    for($pos = 0; $pos <= strlen($listafunciones) - 3; $pos+=3)
    {
      $listfunc1 = $listafunciones{$pos};
      $listfunc2 = $listafunciones{$pos + 1};
      $listfunc3 = $listafunciones{$pos + 2};
      if ($car1 == $listfunc1 && $car2 == $listfunc2 && $car3 == $listfunc3) return false;
    }
    return true;
  }

  //17. Si detecta sólo dos letras seguidas es un error
  function VariableInvalida($expr)
  {
    $cuentaletras = 0;
    for($pos = 0; $pos < strlen($expr); $pos++)
    {
      if ($expr{$pos} >= 'a' && $expr{$pos} <= 'z')
        $cuentaletras++;
      else
      {
        if ($cuentaletras == 2) return true;
        $cuentaletras = 0;
      }
    }
    return $cuentaletras == 2;
  }

  //18. Antes de paréntesis que abre hay una letra
  function VariableParentesisAbre($expr)
  {
    $cuentaletras = 0;
    for($pos = 0; $pos < strlen($expr); $pos++)
    {
      $car1 = $expr{$pos};
      if ($car1 >= 'a' && $car1 <= 'z')
        $cuentaletras++;
      else if ($car1 == '(' && $cuentaletras == 1)
        return true;
      else
        $cuentaletras = 0;
    }
    return false;
  }
  
  //19. Después de paréntesis que cierra sigue paréntesis que abre. Ejemplo: (4-5)(2*x)
  function ParCierraParAbre($expr)
  {
      for ($pos = 0; $pos < strlen($expr)-1; $pos++)
          if ($expr{$pos}==')' && $expr{$pos+1}=='(')
              return true;
      return false;
  }
  
  //20. Después de operador sigue un punto. Ejemplo: -.3+7
  function OperadorPunto($expr)
  {
      for ($pos = 0; $pos < strlen($expr)-1; $pos++)
          if ($expr{$pos}=='+' || $expr{$pos}=='-' || $expr{$pos}=='*' || $expr{$pos}=='/' || $expr{$pos}=='^')
                  if ($expr{$pos+1}=='.')
                    return true;
      return false;
  }
  
  //21. Después de paréntesis que abre sigue un punto. Ejemplo: 3*(.5+4)
  function ParAbrePunto($expr)
  {
      for ($pos = 0; $pos < strlen($expr)-1; $pos++)
          if ($expr{$pos}=='(' && $expr{$pos+1}=='.')
              return true;
      return false;
  }  
  
  //22. Un punto seguido de un paréntesis que abre. Ejemplo: 7+3.(2+6)
  function PuntoParAbre($expr)
  {
      for ($pos = 0; $pos < strlen($expr)-1; $pos++)
          if ($expr{$pos}=='.' && $expr{$pos+1}=='(')
              return true;
      return false;
  }  
  
  //23. Paréntesis cierra y sigue punto. Ejemplo: (4+5).7-2
  function ParCierraPunto($expr)
  {
      for ($pos = 0; $pos < strlen($expr)-1; $pos++)
          if ($expr{$pos}==')' && $expr{$pos+1}=='.')
              return true;
      return false;
  }  
  
  //24. Punto seguido de operador. Ejemplo: 5.*9+1 
  function PuntoOperador($expr)
  {
      for ($pos = 0; $pos < strlen($expr)-1; $pos++)
          if ($expr{$pos}=='.')
            if ($expr{$pos+1}=='+' || $expr{$pos+1}=='-' || $expr{$pos+1}=='*' || $expr{$pos+1}=='/' || $expr{$pos+1}=='^')
                    return true;
      return false;
  }
  
  //25. Punto y sigue paréntesis que cierra. Ejemplo: (3+2.)*5
  function PuntoParCierra($expr)
  {
      for ($pos = 0; $pos < strlen($expr)-1; $pos++)
          if ($expr{$pos}=='.' && $expr{$pos+1}==')')
              return true;
      return false;
  }     

  /* Convierte una expresión con el menos unario en una expresión valida para el evaluador de expresiones */
  public function ArreglaNegativos($expresion)
  {
    $NuevaExpresion = "";
    $NuevaExpresion2 = "";

    //Si detecta un operador y luego un menos, entonces reemplaza el menos con un "(0-1)#"
    for ($pos=0; $pos<strlen($expresion); $pos++)
    {
      $letra1 = $expresion{$pos};
      if ($letra1=='+' || $letra1=='-' || $letra1=='*' || $letra1=='/' || $letra1=='^')
        if ($expresion{$pos+1}=='-')
        {
          $NuevaExpresion .= $letra1 . "(0-1)#";
          $pos++;
          continue;
        }
      $NuevaExpresion .= $letra1;
    }
    
    //Si detecta un paréntesis que abre y luego un menos, entonces reemplaza el menos con un "(0-1)#"
    for ($pos=0; $pos<strlen($NuevaExpresion); $pos++)
    {
      $letra1 = $NuevaExpresion{$pos};
      if ($letra1=='(')
        if ($NuevaExpresion{$pos+1}=='-')
        {
          $NuevaExpresion2 .= $letra1 . "(0-1)#";
          $pos++;
          continue;
        }
      $NuevaExpresion2 .= $letra1;
    }    
    
    return $NuevaExpresion2;
  }
 
 
   
   //Inicializa las listas, convierte la expresión en piezas simples y luego en piezas de ejecución
   function Analizar($expresion)
   {
      unset($this->PiezaSimple);
      unset($this->PiezaEjecuta);
      $this->Generar_Piezas_Simples($expresion);
      /*for ($cont=0; $cont< sizeof($this->PiezaSimple); $cont++)
         echo $this->PiezaSimple[$cont]->Imprime();
         echo "<br>";*/
      $this->Generar_Piezas_Ejecucion();
      /*for ($cont=0; $cont< sizeof($this->PiezaEjecuta); $cont++)
         echo $this->PiezaEjecuta[$cont]->Imprime($cont);
         echo "<br>";*/
   }
   
   //Convierte la expresión en piezas simples: números # paréntesis # variables # operadores # funciones
   function Generar_Piezas_Simples($expresion)
   {
      $longExpresion = strlen($expresion);

      //Variables requeridas para armar un número
      $parteentera = 0;
      $partedecimal = 0;
      $divide = 1;
      $entero = true;
      $armanumero = false;
   
      for ($cont = 0; $cont < $longExpresion; $cont++) //Va de letra en letra de la expresión
      {
         $letra = $expresion{$cont};
         
         if ($letra == '.')  //Si letra es . entonces el resto de digitos leídos son la parte decimal del número
          $entero = false;
         else if ($letra >= '0' && $letra <= '9')  //Si es un número, entonces lo va armando
         {
          $armanumero = true;
          if ($entero)
             $parteentera = $parteentera * 10 + ord($letra) - $this->ASCIINUMERO; //La parte entera del número
          else
          {
             $divide *= 10;
             $partedecimal = $partedecimal * 10 + ord($letra) - $this->ASCIINUMERO; //La parte decimal del número
          }
         }
         else
         {
          if ($armanumero) //Si tenía armado un número, entonces crea la pieza ESNUMERO
          {
             $objeto = new Pieza_Simple();
             $objeto->ConstructorPiezaSimple($this->ESNUMERO, 0, '0', $parteentera+$partedecimal/$divide, 0);
             $this->PiezaSimple[] = $objeto;
             $parteentera = 0;
             $partedecimal = 0;
             $divide = 1;
             $entero = true;
             $armanumero = false;
          }
   
          if ($letra == '+' || $letra == '-' || $letra == '*' || $letra == '/' || $letra == '^' || $letra == '#')
          {
             $objeto = new Pieza_Simple();
             $objeto->ConstructorPiezaSimple($this->ESOPERADOR, 0, $letra, 0, 0);
             $this->PiezaSimple[] = $objeto;
          }
          else if ($letra == '(')
          {
             $objeto = new Pieza_Simple();
             $objeto->ConstructorPiezaSimple($this->ESPARABRE, 0, '0', 0, 0); //¿Es paréntesis que abre?
             $this->PiezaSimple[] = $objeto;
          }
          else if ($letra == ')')
          {
             $objeto = new Pieza_Simple();
             $objeto->ConstructorPiezaSimple($this->ESPARCIERRA, 0, '0', 0, 0);//¿Es paréntesis que cierra?
             $this->PiezaSimple[] = $objeto;
          }
          else if ($letra >= 'a' && $letra <= 'z') //¿Es variable o función?
          {
             /* Detecta si es una función porque tiene dos letras seguidas */
             if ($cont < $longExpresion - 1)
             {
                $letra2 = $expresion{$cont + 1}; /* Chequea si el siguiente carácter es una letra, dado el caso es una función */
                if ($letra2 >= 'a' && $letra2 <= 'z')
                {
                   $letra3 = $expresion{$cont + 2};
                   $funcionDetectada = 1;  /* Identifica la función */
                   for ($funcion = 0; $funcion <= $this->TAMANOFUNCION; $funcion += 3)
                   {
                    if ($letra == $this->listaFunciones{$funcion}
                          && $letra2 == $this->listaFunciones{$funcion + 1}
                          && $letra3 == $this->listaFunciones{$funcion + 2})
                       break;
                    $funcionDetectada++;
                   }
                   $objeto = new Pieza_Simple();
                   $objeto->ConstructorPiezaSimple($this->ESFUNCION, $funcionDetectada, '0', 0, 0);  //Adiciona función a la lista
                   $this->PiezaSimple[] = $objeto;
                   $cont += 3; /* Mueve tres caracteres  sin(  [s][i][n][(] */
                }
                else /* Es una variable, no una función */
                {
                   $objeto = new Pieza_Simple();
                   $objeto->ConstructorPiezaSimple($this->ESVARIABLE, 0, '0', 0, ord($letra) - $this->ASCIILETRA);
                   $this->PiezaSimple[] = $objeto;
                }
             }
             else /* Es una variable, no una función */
             {
                $objeto = new Pieza_Simple();
                $objeto->ConstructorPiezaSimple($this->ESVARIABLE, 0, '0', 0, ord($letra) - $this->ASCIILETRA);
                $this->PiezaSimple[] = $objeto;
             }
          }
         }
      }
      if ($armanumero)
      {
         $objeto = new Pieza_Simple();
         $objeto->ConstructorPiezaSimple($this->ESNUMERO, 0, '0', $parteentera+$partedecimal/$divide, 0);
         $this->PiezaSimple[] = $objeto;
      }
   }
   
   //Toma las piezas simples y las convierte en piezas de ejecución de funciones
   //Acumula = función (operando(número/variable/acumula))
   function Generar_Piezas_Ejecucion()
   {
      $cont = sizeof($this->PiezaSimple)-1;
      $this->Contador_Acumula = 0;
      do
      {
         if ($this->PiezaSimple[$cont]->getTipo() == $this->ESPARABRE || $this->PiezaSimple[$cont]->getTipo() == $this->ESFUNCION)
         {
          $this->Generar_Piezas_Operador('#', '#', $cont);  //Primero evalúa los menos unarios
          $this->Generar_Piezas_Operador('^', '^', $cont);  //Luego evalúa las potencias
          $this->Generar_Piezas_Operador('*', '/', $cont);  //Luego evalúa multiplicar y dividir
          $this->Generar_Piezas_Operador('+', '-', $cont);  //Finalmente evalúa sumar y restar
   
          //Crea pieza de ejecución
          $objeto = new Pieza_Ejecuta();
          $objeto->ConstructorPiezaEjecuta($this->PiezaSimple[$cont]->getFuncion(),
                $this->PiezaSimple[$cont + 1]->getTipo(), $this->PiezaSimple[$cont + 1]->getNumero(), $this->PiezaSimple[$cont + 1]->getVariable(), $this->PiezaSimple[$cont + 1]->getAcumula(),
                '+', $this->ESNUMERO, 0, 0, 0);
          $this->PiezaEjecuta[] = $objeto;
   
          //La pieza pasa a ser de tipo Acumulador
          $this->PiezaSimple[$cont + 1]->setAcumula($this->Contador_Acumula++);
   
          //Quita el paréntesis/función que abre y el que cierra, dejando el centro
          unset($this->PiezaSimple[$cont]); $this->PiezaSimple = array_values($this->PiezaSimple);
          unset($this->PiezaSimple[$cont+1]); $this->PiezaSimple = array_values($this->PiezaSimple);
         }
         $cont--;
      }while ($cont>=0);
   }
   
   //Toma las piezas simples y las convierte en piezas de ejecución
   //Acumula = operando(número/variable/acumula)  operador(+, -, *, /, ^)   operando(número/variable/acumula)
   function Generar_Piezas_Operador($operA, $operB, $inicio)
   {
      $cont = $inicio + 1;
      do
      {
         if ($this->PiezaSimple[$cont]->getTipo() == $this->ESOPERADOR && ($this->PiezaSimple[$cont]->getOperador() == $operA || $this->PiezaSimple[$cont]->getOperador() == $operB))
         {
          //Crea pieza de ejecución
          $objeto = new Pieza_Ejecuta();
          $objeto->ConstructorPiezaEjecuta(0,
                $this->PiezaSimple[$cont - 1]->getTipo(),
                $this->PiezaSimple[$cont - 1]->getNumero(), $this->PiezaSimple[$cont - 1]->getVariable(), $this->PiezaSimple[$cont - 1]->getAcumula(),
                $this->PiezaSimple[$cont]->getOperador(),
                $this->PiezaSimple[$cont + 1]->getTipo(),
                $this->PiezaSimple[$cont + 1]->getNumero(), $this->PiezaSimple[$cont + 1]->getVariable(), $this->PiezaSimple[$cont + 1]->getAcumula());
          $this->PiezaEjecuta[] = $objeto;          
   
          //Elimina la pieza del operador y la siguiente
          unset($this->PiezaSimple[$cont]); $this->PiezaSimple = array_values($this->PiezaSimple);
          unset($this->PiezaSimple[$cont]); $this->PiezaSimple = array_values($this->PiezaSimple);
   
          //Retorna el contador en uno para tomar la siguiente operación
          $cont--;
   
          //Cambia la pieza anterior por pieza acumula
          $this->PiezaSimple[$cont]->setAcumula($this->Contador_Acumula++);
         }
         $cont++;
      } while ($cont < sizeof($this->PiezaSimple) && $this->PiezaSimple[$cont]->getTipo() != $this->ESPARCIERRA);
   }
   
   //Calcula la expresión convertida en piezas de ejecución
   function Calcular()
   {
      $valorA=0;
      $valorB=0;
      $totalPiezaEjecuta = sizeof($this->PiezaEjecuta);
   
      for ($cont = 0; $cont < $totalPiezaEjecuta; $cont++)
      {
         switch ($this->PiezaEjecuta[$cont]->getTipoOperA())
         {
          case 5: $valorA = $this->PiezaEjecuta[$cont]->getNumeroA(); break; //¿Es un número?
          case 6: $valorA = $this->VariableAlgebra[$this->PiezaEjecuta[$cont]->getVariableA()]; break;  //¿Es una variable?
          case 7: $valorA = $this->PiezaEjecuta[$this->PiezaEjecuta[$cont]->getAcumulaA()]->getValorPieza(); break; //¿Es una expresión anterior?
         }
         if (is_nan($valorA) || is_infinite($valorA)) return $valorA;
   
         switch ($this->PiezaEjecuta[$cont]->getFuncion())
         {
          case 0:
             switch ($this->PiezaEjecuta[$cont]->getTipoOperB())
             {
                case 5: $valorB = $this->PiezaEjecuta[$cont]->getNumeroB(); break; //¿Es un número?
                case 6: $valorB = $this->VariableAlgebra[$this->PiezaEjecuta[$cont]->getVariableB()]; break;  //¿Es una variable?
                case 7: $valorB = $this->PiezaEjecuta[$this->PiezaEjecuta[$cont]->getAcumulaB()]->getValorPieza(); break; //¿Es una expresión anterior?
             }
             if (is_nan($valorB) || is_infinite($valorB)) return $valorB;
   
             switch ($this->PiezaEjecuta[$cont]->getOperador())
             {
                case '#': $this->PiezaEjecuta[$cont]->setValorPieza($valorA * $valorB); break;
                case '+': $this->PiezaEjecuta[$cont]->setValorPieza($valorA + $valorB); break;
                case '-': $this->PiezaEjecuta[$cont]->setValorPieza($valorA - $valorB); break;
                case '*': $this->PiezaEjecuta[$cont]->setValorPieza($valorA * $valorB); break;
                case '/': if ($valorB == 0) return NAN; else $this->PiezaEjecuta[$cont]->setValorPieza($valorA / $valorB); break;
                case '^': $this->PiezaEjecuta[$cont]->setValorPieza(pow($valorA, $valorB)); break;
             }
             break;
          case 1:
          case 2: $this->PiezaEjecuta[$cont]->setValorPieza(sin($valorA)); break;
          case 3: $this->PiezaEjecuta[$cont]->setValorPieza(cos($valorA)); break;
          case 4: $this->PiezaEjecuta[$cont]->setValorPieza(tan($valorA)); break;
          case 5: $this->PiezaEjecuta[$cont]->setValorPieza(abs($valorA)); break;
          case 6: $this->PiezaEjecuta[$cont]->setValorPieza(asin($valorA)); break;
          case 7: $this->PiezaEjecuta[$cont]->setValorPieza(acos($valorA)); break;
          case 8: $this->PiezaEjecuta[$cont]->setValorPieza(atan($valorA)); break;
          case 9: $this->PiezaEjecuta[$cont]->setValorPieza(log($valorA)); break;
          case 10: $this->PiezaEjecuta[$cont]->setValorPieza(ceil($valorA)); break;
          case 11: $this->PiezaEjecuta[$cont]->setValorPieza(exp($valorA)); break;
          case 12: $this->PiezaEjecuta[$cont]->setValorPieza(sqrt($valorA)); break;
          case 13: $this->PiezaEjecuta[$cont]->setValorPieza(pow($valorA, 0.333333333333)); break;
         }
      }
      return $this->PiezaEjecuta[$totalPiezaEjecuta - 1]->getValorPieza();
   }
   
   // Da valor a las variables que tendrá la expresión algebraica
   function ValorVariable($variableAlg, $valor)
   {
      $this->VariableAlgebra[ord($variableAlg) - $this->ASCIILETRA] = $valor;
   }
}

?>