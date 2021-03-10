<?php 
require_once("../include/session.php"); 
$where_c_coste=" id_c_coste={$_SESSION['id_c_coste']} " ;

 //echo "El filtro es:{$_GET["filtro"]}";

$ID_OBRA=$_GET["ID_OBRA"]  ;
$Cartera_pdte=$_GET["Cartera_pdte"]  ;
$F_Inicio_Plazo=$_GET["F_Inicio_Plazo"]  ;
$F_Fin_Plazo=$_GET["F_Fin_Plazo"]  ;

//logs("entramos en plan_obra_ajax");

require_once("../../conexion.php");
require_once("../include/funciones.php");

$ts_Inicio_Plazo=strtotime($F_Inicio_Plazo);
$ts_Fin_Plazo=strtotime($F_Fin_Plazo);

$error_en_fecha= $ts_Inicio_Plazo==0 OR $ts_Fin_Plazo==0 ;   // al menos una fecha es errónea
if ($ID_OBRA= Dfirst("ID_OBRA","OBRAS","$where_c_coste AND ID_OBRA=$ID_OBRA")  AND !$error_en_fecha)   // SEGURIDAD
{
//   $fecha_hoy=date('Y-m');
//   $fecha=date_create(date_format($fecha0,"Y")."-".date_format($fecha0,"m")."-01");          //primero de mes de la fecha0
//   $fecha_pmes=date_create_from_format("Y-m-d", date('Y-m')."-01");                //fecha pasada por referencia
//   $fecha_fin_obra=date_create_from_format("Y-m-d",$F_Fin_Plazo);             //primero de mes de la fecha0
    
//    logs("entramos en plan_obra_ajax ID_OBRA");


//   $fecha_pMes = date('Y-m',strtotime($F_Inicio_Plazo) )."-01";    // primer dia del mes del mes que empieza la obra
//   $fecha_pMes_N = date('Y-m',strtotime($F_Fin_Plazo) )."-01";    //  primer dia del mes del ultimo mes
//   
//   
//   $fecha_pMes2 = date('Y-m',strtotime($F_Inicio_Plazo)+3600*24*32 )."-01";    // primer dia del mes SIGUIENTE AL que empieza la obra
//   $dias_diff_mes1=(strtotime($fecha_pMes2) - strtotime($F_Inicio_Plazo))/(60*60*24); // dias desde f_inicio hasta primeros del proximo mes
//   $dias_diff_mes_ultimo=(strtotime($F_Fin_Plazo) - strtotime($fecha_pMes_N))/(60*60*24)+1; // dias desde f_inicio hasta primeros del proximo mes
//   
//   $dias_diff = (strtotime($F_Fin_Plazo) - strtotime($F_Inicio_Plazo))/(60*60*24);   //meses de 30 días
//   $dias_diff = ($dias_diff <0) ? 30 : $dias_diff ;     // si sale negativo (es decir, si el plazo ha terminado) pongo toda la cartera pdte en un mes
//   
//   
//   
//   $meses_diff=($dias_diff-$dias_diff_mes1-$dias_diff_mes_ultimo)/30  ;
//   
//          logs("entramos en plan_obra_ajax  get_defined_vars". pre( get_defined_vars())  );
//          logs("entramos en plan_obra_ajax meses $meses_diff"  );

    $Conn->query("UPDATE VENTAS SET PLAN='0' WHERE ID_OBRA=$ID_OBRA  ;"  ) ;  // ponemos a cero toda la planificación de la obra
    $ts_Inicio_Plazo=strtotime($F_Inicio_Plazo);
    $ts_Fin_Plazo=strtotime($F_Fin_Plazo);
    
//   for ($m = 0; $m <= $meses_diff+1; $m+=1)
//   {
//       
//       logs("entramos en plan_obra_ajax  FOR M: $m"  );
//       
//        $dias_trabajo = ($m == 0)? $dias_diff_mes1 : (  ($m+1 > $meses_diff+1) ?   $dias_diff_mes_ultimo  : 30 ) ;  
//
//        $importe_mes =   $Cartera_pdte/$dias_diff * $dias_trabajo ;  
//       
//        if ($id = Dfirst("id","VENTAS","ID_OBRA=$ID_OBRA AND DATE_FORMAT(FECHA, '%Y-%m')=DATE_FORMAT('$fecha_pMes', '%Y-%m') "))    // SEGURIDAD
//        {
//          $sql="UPDATE VENTAS SET PLAN='$importe_mes' WHERE id='$id'  ;"  ;
//
//        } else {
//
//            $sql="INSERT INTO VENTAS ( ID_OBRA,FECHA,PLAN ) " . 
//                       " VALUES ( '$ID_OBRA', '$fecha_pMes','$importe_mes' );"  ;
//        }
//
//        logs("SQL plan_obra_ajax $sql"  );
//        echo ($Conn->query($sql))?  "" : "ERROR creando o actualizando VENTAS" ;
//
//        $fecha_pMes=date('Y-m' , strtotime($fecha_pMes) + 3600*24*32)."-01";     //dia primero del siguiente mes (sumo 32 días)
//   }
    
    $ts_Inicio_Plazo=strtotime($F_Inicio_Plazo);
    $ts_Fin_Plazo=strtotime($F_Fin_Plazo);
    $dias_plazo=($ts_Fin_Plazo-$ts_Inicio_Plazo)/(24*3600) ;
   $plan_diario= $Cartera_pdte/$dias_plazo ;
   $mes0=date("Y-m", $ts_Inicio_Plazo);
   $c=0;
   logs("entramos en plan_obra_ajax ts1 $ts_Fin_Plazo ts2 $ts_Inicio_Plazo dias $dias_plazo plan diario $plan_diario cartera $Cartera_pdte") ; //. pre( get_defined_vars())  );

  for ($ts = $ts_Inicio_Plazo; $ts <= $ts_Fin_Plazo; $ts+=24*3600)
   {
          $mes=  date("Y-m", $ts);    
    
         logs(" plan_obra_ajax dentro bucle ts $ts ts2 $mes dias $mes0 c $c   ") ; //. pre( get_defined_vars())  );

//       logs("entramos en plan_obra_ajax  FOR DIAS: "  );

        if ($mes<>$mes0 OR ($ts+24*3600 > $ts_Fin_Plazo))   // cambiamos de mes
        {
            
                $importe_mes=$c*$plan_diario ; 
                
              logs(" plan_obra_ajax dentro de IF ts $ts ts2 $mes dias $mes0 c $c  importe_mes $importe_mes ") ; //. pre( get_defined_vars())  );

            
                if ($id = Dfirst("id","VENTAS","ID_OBRA=$ID_OBRA AND DATE_FORMAT(FECHA, '%Y-%m')='$mes0' "))    // SEGURIDAD
                {
//                      $importe_mes=$c*$plan_diario ; 
                      $sql="UPDATE VENTAS SET PLAN='$importe_mes' WHERE id='$id'  ;"  ;

                } else {
                        $fecha=$mes0."-01" ;

                        $sql="INSERT INTO VENTAS ( ID_OBRA,FECHA,PLAN ) " . 
                                   " VALUES ( '$ID_OBRA', '$fecha','$importe_mes' );"  ;
                }
                echo ($result=$Conn->query($sql))?  "" : "ERROR creando o actualizando VENTAS" ;      
                logs("SQL plan_obra_ajax diario $sql  result: $result"  );
                 $c=0;
                 $mes0=$mes;

       }        

      
        
        $c++;
   }
   

 
}else
{
    echo $error_en_fecha ? "ERROR, Fecha errónea" : "ERROR, obra desconocida";
}

 logs("SALIMOS en plan_obra_ajax "  );
?>