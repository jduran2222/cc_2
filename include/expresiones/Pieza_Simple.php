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

class Pieza_Simple
{
	var $tipo; //Función, parentesis_abre, parentesis_cierra, operador, numero, variable, abreviación
	var $funcion; //Que función es seno/coseno/tangente/sqrt
	var $operador; // +, -, *, /, ^
	var $numero; //Número real de la expresión
	var $variableAlgebra; //Variable de la expresión
	var $acumula;  //Indice de la microexpresión
	
	public function getTipo() { return $this->tipo;	}
	public function getFuncion() { return $this->funcion; }
	public function getOperador() {	return $this->operador;	}
	public function getNumero() { return $this->numero;	}
	public function getVariable() {	return $this->variableAlgebra;	}
	public function getAcumula() { return $this->acumula; }
	public function setAcumula($acumula) { $this->tipo = 7; $this->acumula = $acumula;	}
	
	public function ConstructorPiezaSimple($tipo, $funcion, $operador, $numero, $variable)
	{
		$this->tipo = $tipo;
		$this->funcion = $funcion;
		$this->operador = $operador;
		$this->variableAlgebra = $variable;
		$this->acumula = 0;
		$this->numero = $numero;
	}
}
?>