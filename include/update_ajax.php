<?php 
//require_once("../include/session.php");   //ANULADO provisionalmente para evitar que se meta la página index.php (registro) en el div_edit al vencerla session, juand, mayo20

//simulacioon del SESSION.PHP
ini_set("session.use_trans_sid",true); 
session_start();
ini_set("display_errors", 1); 
error_reporting(E_ALL);

require_once("../../conexion.php");
require_once("../include/funciones.php");

$dir_raiz = "https://" . $_SERVER['SERVER_NAME'] . "/web/"; 
$_SESSION["dir_raiz"]=$dir_raiz ;
if (!isset($_SESSION["logs"])) { $_SESSION["logs"] = '' ; }      // inicializamos $_SESSION["logs"]
$admin= isset($_SESSION['admin']) ?  $_SESSION['admin'] : 0 ;   
$where_c_coste=" id_c_coste={$_SESSION['id_c_coste']} " ; 

// fin SESSION.php

 //echo "El filtro es:{$_GET["filtro"]}";

$tabla=($_GET["tabla"])  ;
$wherecond=$_GET["wherecond"]  ;
$field=$_GET["field"]  ;
$nuevo_valor=rawurldecode($_GET["nuevo_valor"] ) ;
$tipo_dato =   isset($_GET["tipo_dato"]) ? $_GET["tipo_dato"]  : "" ;

logs($_GET["nuevo_valor"])  ;
logs('tipo dato:'.$tipo_dato)  ;

// $nuevo_valor= htmlspecialchars($nuevo_valor) ;  // desactivamos provisionalmente para ver si funciona el div_edit
 
 if($tipo_dato=='num')     // si el tipo de datos es num_exp podemos evaluar la expresion 
 {
     
   $nuevo_valor= str_replace('==', '=', $nuevo_valor) ; // por compatiblidad con anteriores versiones cambiamos == por = 2018 
//   if( substr($nuevo_valor, 0,1)=='=')                    // estamos en una EXPRESION a resolver

       $expresion=$nuevo_valor ;  
        logs('nuevo_valor inicial:' . $nuevo_valor) ;
      
       $nuevo_valor = quita_tildes( $nuevo_valor);         // quitamos todas las tildes y Ñ 
       $nuevo_valor = preg_replace("/([a-z]+)/i", "", $nuevo_valor);         // quitamos todas las letras 
       $nuevo_valor = preg_replace("/€|$| |'/", "", $nuevo_valor);         // quitamos simbolos moneda 
     
       $patrones_importe= "~(\d{1,3}?)\,(\d{1,2})~"  ;
       $replaces= "$1.$2"  ; 

       $nuevo_valor = preg_replace($patrones_importe,$replaces,$nuevo_valor); 

       
       
//       $nuevo_valor = preg_replace("~(\d{1,3}?)\s?\.?\s?(\d{1,3})\s?[,.]\s?(\d{2})~", "$1$2.$3", $nuevo_valor);  // quitamos todas las letras 
      
    // vemos si es un valor o una EXPRESION  a EVALUAR  = 3.45 + 6.70 * 3  
    if( !(substr($nuevo_valor, 0,1)=='=')) 
    {  // NO ES EXPRESION     
    //(ANULO PROVISIONALMENTE , DIC19)
//       $nuevo_valor= str_replace(',', '.', $nuevo_valor) ;
//       $count=substr_count ($nuevo_valor,'.') ;
//       $nuevo_valor = preg_replace("/\./", "", $nuevo_valor , $count-1);     
       
       $nuevo_valor=  dbNumero2($nuevo_valor);  //funcion en pruebas
       
//       logs('$count:' . $count) ;
//       logs('nuevo_valor:' . $nuevo_valor) ;
//       $nuevo_valor= $expresion ;   //DEBUG
  
    }else
    {
         // ES UNA EXPRESION A EVALUAR
       $nuevo_valor= str_replace('=', '', $nuevo_valor) ;  // quitamos el signo =

      if($result=$Conn->query("SELECT  ($nuevo_valor) AS valor  ; " ))
          { if ($rs = $result->fetch_array(MYSQLI_ASSOC) ) 
               {
                  $nuevo_valor = ROUND($rs["valor"],15) ;   
               } 
          }
        
          
    }
    
//      $nuevo_valor=evalua_expresion($nuevo_valor ) ;  // los datos numericos pueden meterse como formulas
//       
//       $nuevo_valor=evalua_expresion($nuevo_valor ) ;  // los datos numericos pueden meterse como formulas
     
//   $nuevo_valor=preg_match('/Notice|error|Evaluar/', $nuevo_valor) ? 'ERROR' : $nuevo_valor ; // controlamos que no se haya producido un error en la Evaluar.php
//   $nuevo_valor= eval($nuevo_valor)  ; // controlamos que no se haya producido un error en la Evaluar.php
    
   
   

   
   
 }elseif($tipo_dato=='date')    // tipo de dato FECHA 
 {
//      logs('inicial_valor:' . $nuevo_valor) ;
    //(ANULO PROVISIONALMENTE , DIC19)
   
//     $nuevo_valor = preg_replace("~(\d{1,2})\s?[- /.]\s?(\d{1,2})\s?[- /.]\s?(\d{4})~" 
//                         ,"$3-$2-$1"   
//                         ,$nuevo_valor);
     
     $nuevo_valor = dbDate($nuevo_valor);
     
     
//    logs('nuevo_valor:' . $nuevo_valor) ;

 }elseif($tipo_dato=='div_edit')    // tipo de dato FECHA 
 {
    // quitamos los <div>
    $nuevo_valor= str_replace("<div>", " <br> ", $nuevo_valor)   ;
    $nuevo_valor= str_replace("</div>", "", $nuevo_valor)   ;
    $nuevo_valor= str_replace("<br>", " <br> ", $nuevo_valor)   ;
    $nuevo_valor= str_replace("<br/>", " <br/> ", $nuevo_valor)   ;
    
    $nuevo_valor= texto_a_html_hex($nuevo_valor)   ;  // cambiamos las comillas simples por \' para textos
    
    //pasamos a binario  bin2hex 
//    $nuevo_valor= '__HEX__'.bin2hex($nuevo_valor)   ;  // cambiamos las comillas simples por \' para textos
    
    
 }else
 {
      $nuevo_valor= str_replace("'", "\'", $nuevo_valor)   ;  // cambiamos las comillas simples por \' para textos

 }    
 
 
 // guardamos en base de datos el nuevo valos
 $sql= "UPDATE `$tabla` SET `$field` = '$nuevo_valor' WHERE $wherecond  "  ;
 
 //$result = $Conn->query($sql);

 
 if ($Conn->query($sql)) // tras el UPDATE si este no da fallos, consulto el nuevo valor almacenado para confirmar que coincide con lo Update
  { 
       
         $valor_bd=Dfirst( "`$field`"  , "`$tabla`", $wherecond) ;              // metemos las comillas invertidas para compatibilidad con campos que usan espacios en el nombre: 'Estudios_de_Obra'
    //     $valor_bd=Dfirst( $field  , $tabla, $wherecond) ;              // metemos las comillas invertidas para compatibilidad con campos que usan espacios en el nombre: 'Estudios_de_Obra'
         if ( round($nuevo_valor,14)==$valor_bd)    // compruebo el valor enviado a la BBDD y el devuelto en la consulta
         {   echo $valor_bd ;            // Si coinciden, todo ok,     devuelvo el valor leyendolo de la BD tras el UPDATE 
         }
         else
          {                             // NO COINCIDEN EL VALOR ENVIADO CON EL CONSULTADO (Acortamiento de campo, cambio de character especial, erroes en puntos decimales...)
           //echo "___ERROR___" ;        //mando mensaje de ERROR, el valor de la BD tras el UPDATE no es el esperado
           echo "ERROR en valor de BBDD $nuevo_valor diferente a $valor_bd ,<br> SQL: $sql" ;
           $id_log_db= logs_db( "ERROR en UPDATE_AJAX.PHP. valor de BBDD $nuevo_valor diferente a $valor_bd ,SQL:  $sql" , 'cc_error');
           echo $_SESSION["admin"] ? "ERROR en UPDATE_AJAX.PHP. valor de BBDD $nuevo_valor diferente a $valor_bd ,id_log_db: $id_log_d, SQL:  $sql" : "ERROR en UPDATE_AJAX.PHP  valor de BBDD $nuevo_valor diferente a $valor_bd  avise administrador. LOG_DB $id_log_db" ;
           
          }	
       
  }  
   else
   { 
       //echo "___ERROR___" ;                           // mando mensaje de error posiblemente la sentencia UPDATE está errónea
       $id_log_db= logs_db( "ERROR en UPDATE_AJAX.PHP: $sql" , 'cc_error');
       echo $_SESSION["admin"] ? "ERROR en UPDATE_AJAX.PHP: id_log_db: $id_log_db, SQL: $sql" : "ERROR en UPDATE_AJAX.PHP avise administrador. LOG_DB $id_log_db" ;
      
   }	  
 $Conn->close();



?>