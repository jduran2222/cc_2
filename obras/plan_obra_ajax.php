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


$error_en_fecha= strtotime($F_Inicio_Plazo)==0 OR strtotime($F_Fin_Plazo)==0 ;
if ($ID_OBRA= Dfirst("ID_OBRA","OBRAS","$where_c_coste AND ID_OBRA=$ID_OBRA")  AND !$error_en_fecha)   // SEGURIDAD
{
//   $fecha_hoy=date('Y-m');
//   $fecha=date_create(date_format($fecha0,"Y")."-".date_format($fecha0,"m")."-01");          //primero de mes de la fecha0
//   $fecha_pmes=date_create_from_format("Y-m-d", date('Y-m')."-01");                //fecha pasada por referencia
//   $fecha_fin_obra=date_create_from_format("Y-m-d",$F_Fin_Plazo);             //primero de mes de la fecha0
    
    logs("entramos en plan_obra_ajax ID_OBRA");


   $fecha_pMes = date('Y-m',strtotime($F_Inicio_Plazo) )."-01";    // primer dia del mes del mes que empieza la obra
   $fecha_pMes_N = date('Y-m',strtotime($F_Fin_Plazo) )."-01";    //  primer dia del mes del ultimo mes
   
   
   $fecha_pMes2 = date('Y-m',strtotime($F_Inicio_Plazo)+3600*24*32 )."-01";    // primer dia del mes SIGUIENTE AL que empieza la obra
   $dias_diff_mes1=(strtotime($fecha_pMes2) - strtotime($F_Inicio_Plazo))/(60*60*24); // dias desde f_inicio hasta primeros del proximo mes
   $dias_diff_mes_ultimo=(strtotime($F_Fin_Plazo) - strtotime($fecha_pMes_N))/(60*60*24)+1; // dias desde f_inicio hasta primeros del proximo mes
   
   $dias_diff = (strtotime($F_Fin_Plazo) - strtotime($F_Inicio_Plazo))/(60*60*24);   //meses de 30 días
   $dias_diff = ($dias_diff <0) ? 30 : $dias_diff ;     // si sale negativo (es decir, si el plazo ha terminado) pongo toda la cartera pdte en un mes
   
   
   
   $meses_diff=($dias_diff-$dias_diff_mes1-$dias_diff_mes_ultimo)/30  ;
   
          logs("entramos en plan_obra_ajax  get_defined_vars". pre( get_defined_vars())  );
          logs("entramos en plan_obra_ajax meses $meses_diff"  );

   for ($m = 0; $m <= $meses_diff+1; $m+=1)
   {
       
       logs("entramos en plan_obra_ajax  FOR M: $m"  );
       
        $dias_trabajo = ($m == 0)? $dias_diff_mes1 : (  ($m+1 > $meses_diff+1) ?   $dias_diff_mes_ultimo  : 30 ) ;  

        $importe_mes =   $Cartera_pdte/$dias_diff * $dias_trabajo ;  
       
        if ($id = Dfirst("id","VENTAS","ID_OBRA=$ID_OBRA AND DATE_FORMAT(FECHA, '%Y-%m')=DATE_FORMAT('$fecha_pMes', '%Y-%m') "))    // SEGURIDAD
        {
          $sql="UPDATE VENTAS SET PLAN='$importe_mes' WHERE id='$id'  ;"  ;

        } else {

            $sql="INSERT INTO VENTAS ( ID_OBRA,FECHA,PLAN ) " . 
                       " VALUES ( '$ID_OBRA', '$fecha_pMes','$importe_mes' );"  ;
        }

        logs("SQL plan_obra_ajax $sql"  );
        echo ($Conn->query($sql))?  "" : "ERROR creando o actualizando VENTAS" ;

        $fecha_pMes=date('Y-m' , strtotime($fecha_pMes) + 3600*24*32)."-01";     //dia primero del siguiente mes (sumo 32 días)
   }

 
}else
{
    echo $error_en_fecha ? "ERROR, Fecha errónea" : "ERROR, obra desconocida";
}

 logs("SALIMOS en plan_obra_ajax "  );
?>