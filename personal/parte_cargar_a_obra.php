<?php
require_once("../include/session.php");
$where_c_coste=" id_c_coste={$_SESSION['id_c_coste']} " ;	


// registramos el documento en la bbdd
require_once("../../conexion.php"); 
require_once("../include/funciones.php"); 

		
$id_parte= $_GET["id_parte"];
$delete_vale = isset($_GET["delete_vale"]) ? 1 : 0 ;

//echo "DELETE_VALE ES: ". $delete_vale ;
//$id_obra= $_GET["id_obra"];
//$fecha=date('Y-m-d');

$result=$Conn->query("SELECT * FROM Partes_View WHERE id_parte=$id_parte AND $where_c_coste");
$rs = $result->fetch_array(MYSQLI_ASSOC) ;

$id_obra=$rs["ID_OBRA"] ;
$fecha=$rs["Fecha"];

// buscamos VARIABLES DE ENTORNO
$id_proveedor = getVar("id_proveedor_mo")  ;   // proveedor automatico para mano de obra
$id_fra_prov = getVar("id_fra_mo")  ;          //  factura automatica para conciliar mano de obra

$id_subobra_general = getVar("id_subobra_si") ;        // en esta SUBOBRA general registraremos los abonos
$id_subobra_si‌ = Dfirst("id_subobra_auto","OBRAS"," $where_c_coste AND ID_OBRA=$id_obra")  ;
$id_subobra_si‌ = $id_subobra_si‌ ? $id_subobra_si‌ :  getVar("id_subobra_si") ;  // en caso de que haya error usamos la predeterminada

$id_concepto_dc‌ = getVar("id_concepto_dc‌") ;  // concepto de Media Dieta 
$id_concepto_md‌ = getVar("id_concepto_md‌") ;  // concepto de Dieta Completa


if (!isset($_GET["id_vale"]))  // no hay ID_VALE, creamos uno y lo vinculamos a la obra
{ // EL PARTE NO TIENE VALE ASOCIADO. CREAMOS EL NUEVO VALE
  
  
  // vemos cual es el valor del último id_vale para comparar
  $id_vale0=Dfirst( "MAX(ID_VALE)", "Vales_list", $where_c_coste ) ; 
  
  // insertamos un VALE nuevo vacío
  $sql2 =  "INSERT INTO `VALES` ( ID_PROVEEDORES,ID_OBRA,Fecha,REF,ID_FRA_PROV,`user` ) ";
  $sql2 .= "VALUES ( '$id_proveedor', '$id_obra','$fecha' ,'PD-$id_parte' ,'$id_fra_prov', '{$_SESSION["user"]}' );" ;
  //  echo ($sql2)."<br>";
  
  if ($result2=$Conn->query($sql2))
    {
      // buscamos el nuevo id_vale
      $id_vale_cargo=Dfirst( "MAX(ID_VALE)", "Vales_list", " $where_c_coste AND ID_PROVEEDORES=$id_proveedor AND ID_OBRA=$id_obra " ) ; 
      // asociamos el nuevo ID_VALE al PARTE
      $result_a1=$Conn->query("UPDATE `PARTES` SET `ID_VALE` = $id_vale_cargo WHERE ID_PARTE=$id_parte;" );    
      
      //creamos el Vale ABONO de mano de obra
      $id_obra_mo= getVar("id_obra_mo")  ; // ID_OBRA 002-DESVIACION MANO DE OBRA
      $result_abono=$Conn->query("INSERT INTO `VALES` ( ID_PROVEEDORES,ID_OBRA,Fecha,REF,ID_FRA_PROV,`user` )"
                 . " VALUES ( '$id_proveedor', '$id_obra_mo','$fecha' ,'PD-ABONO-$id_parte' ,'$id_fra_prov', '{$_SESSION["user"]}' );  " );    

     // buscamos el nuevo id_vale 
     $id_vale_abono=Dfirst( "MAX(ID_VALE)", "Vales_list", " $where_c_coste AND ID_PROVEEDORES=$id_proveedor AND ID_OBRA=$id_obra_mo " ) ; 

     //registramos la relación vale_cargo, vale_abono
     $result_link=$Conn->query("INSERT INTO `Vales_cargo_abono` ( id_vale_cargo, id_vale_abono )"
                 . " VALUES ( '$id_vale_cargo', '$id_vale_abono' );  " );    
           
    }      
   else
    {    
    echo "<br>ERROR AL CREAR VALE. sql: $sql2 <br> ";      // ejecutamos la consulta y avisamos de posibles errores
    exit() ;
    }

}
else      // El PARTE tiene un VALE asociado, vamos a VACIAR los detalles del VALE para rellenarlo de nuevo
{ 
    // vaciamos el VALE_CARGO y eliminamos los VALES_ABONO
    $id_vale_cargo=$_GET["id_vale"] ;
    $result_a2=$Conn->query("DELETE FROM `GASTOS_T` WHERE ID_VALE=$id_vale_cargo;" );
    
    //BORRAMOS TAMBIEN LOS DETALLES Y VALES ABONO SI LOS HAY
    $result_a2=$Conn->query("DELETE FROM `GASTOS_T` WHERE ID_VALE IN (SELECT id_vale_abono FROM Vales_cargo_abono WHERE id_vale_cargo=$id_vale_cargo);" );
    $result_a2=$Conn->query("DELETE FROM `VALES` WHERE ID_VALE IN (SELECT id_vale_abono FROM Vales_cargo_abono WHERE id_vale_cargo=$id_vale_cargo);" );
    
    // borramos la relación
    $result_a2=$Conn->query("DELETE FROM `Vales_cargo_abono` WHERE  id_vale_cargo=$id_vale_cargo);" );
    
    
    // Creamos los VAles de Abono nuevos o ELIMINAMOS TODO?
    if (!$delete_vale)    
    {
//              echo "DELETE_VALE ES FALSO: " ;

        //creamos de nuevo el VALE ABONO y lo linkamos
        //creamos el Vale ABONO de mano de obra
          $id_obra_mo= getVar("id_obra_mo")  ; // ID_OBRA 002-DESVIACION MANO DE OBRA
          $result_abono=$Conn->query("INSERT INTO `VALES` ( ID_PROVEEDORES,ID_OBRA,Fecha,REF,ID_FRA_PROV,`user` )"
                     . " VALUES ( '$id_proveedor', '$id_obra_mo','$fecha' ,'PD-ABONO-MO-$id_parte' ,'$id_fra_prov', '{$_SESSION["user"]}' );  " );    

         // buscamos el nuevo id_vale 
         $id_vale_abono=Dfirst( "MAX(ID_VALE)", "Vales_list", " $where_c_coste AND ID_PROVEEDORES=$id_proveedor AND ID_OBRA=$id_obra_mo " ) ; 

         //registramos la relación vale_cargo, vale_abono
         $result_link=$Conn->query("INSERT INTO `Vales_cargo_abono` ( id_vale_cargo, id_vale_abono )"
                     . " VALUES ( '$id_vale_cargo', '$id_vale_abono' );  " );    
    }
    else   // ELIMINAMOS  TODO
    {
      
      $result_a2=$Conn->query( "UPDATE `PARTES` SET `ID_VALE` = NULL " 
                                    ."WHERE  ID_PARTE='$id_parte' AND ID_VALE='$id_vale_cargo'  ; " ) ;
//      echo "puesto a NULL ID_VALE del parte: " . $result_a2 ? "si" : "no" ;
      $result_a2=$Conn->query("DELETE FROM `VALES` WHERE ID_VALE=$id_vale_cargo ;" );
//      echo "borrado ID_VALE : " . $result_a2 ? "si" : "no" ;

    }    

    
}    


if (!$delete_vale)    
 {

        // iniciamos el registro en el ID_VALE_CARGO ya vacío, si es que existía previamente, de los conceptos correspondientes
        // Registramos el gasto de PARTES_PERSONAL
        //sacamos la lista de Personal del Parte
        $result=$Conn->query("SELECT * FROM Partes_Personal_View WHERE ID_PARTE=$id_parte AND $where_c_coste");

        //empezamos a registrar en el Vale los cargos de mano de obra de cada Personal, luego los abonos
        while ($rs = $result->fetch_array(MYSQLI_ASSOC) )
        {
            // registramos gasto de horas totales de cada personal
            $horas_total= $rs["HO"] + $rs["HX"]   ;        // sumamos horas ordinarias + horas extras
            $sql3  = "INSERT INTO `GASTOS_T` ( ID_VALE,ID_CONCEPTO,CANTIDAD,ID_SUBOBRA ) ";
            $sql3 .= "VALUES ( '$id_vale_cargo','{$rs["id_concepto_mo"]}' ,'$horas_total', '$id_subobra_si‌' );" ;
        //  echo ($sql3);
            $result3=$Conn->query($sql3);
            // registramos los ABONOS DE MANO DE OBRA
            $sql3  = "INSERT INTO `GASTOS_T` ( ID_VALE,ID_CONCEPTO,CANTIDAD,ID_SUBOBRA ) ";
            $sql3 .= "VALUES ( '$id_vale_abono','{$rs["id_concepto_mo"]}' ,'-$horas_total', '$id_subobra_general' );" ;
        //  echo ($sql3);
            $result3=$Conn->query($sql3);



            // sumamos una Media Dieta (MD) si la hay
            if ($rs["MD"])
            {
            $sql3  = "INSERT INTO `GASTOS_T` ( ID_VALE,ID_CONCEPTO,CANTIDAD,ID_SUBOBRA ) ";
            $sql3 .= "VALUES ( '$id_vale_cargo','$id_concepto_md‌' ,'1', '$id_subobra_si‌' );" ;
        //  echo ($sql3)."<br>";
            $result3=$Conn->query($sql3);    
            // ABONOS 
            $sql3  = "INSERT INTO `GASTOS_T` ( ID_VALE,ID_CONCEPTO,CANTIDAD,ID_SUBOBRA ) ";
            $sql3 .= "VALUES ( '$id_vale_abono','$id_concepto_md‌' ,'-1', '$id_subobra_general' );" ;
        //  echo ($sql3)."<br>";
            $result3=$Conn->query($sql3);    
            }

            // sumamos una Dieta Completa (DC) si la hay
            if ($rs["DC"])
            {
            $sql3  = "INSERT INTO `GASTOS_T` ( ID_VALE,ID_CONCEPTO,CANTIDAD,ID_SUBOBRA ) ";
            $sql3 .= "VALUES ( '$id_vale_cargo','$id_concepto_dc' ,'1', '$id_subobra_si‌' );" ;
        //  echo ($sql3)."<br>";
            $result3=$Conn->query($sql3);  
            // abono
            $sql3  = "INSERT INTO `GASTOS_T` ( ID_VALE,ID_CONCEPTO,CANTIDAD,ID_SUBOBRA ) ";
            $sql3 .= "VALUES ( '$id_vale_abono','$id_concepto_dc' ,'-1', '$id_subobra_general' );" ;
        //  echo ($sql3)."<br>";
            $result3=$Conn->query($sql3);  
            }


        }


        // Registramos el gasto de MAQUINARIA Partes_Maquinas

        $result=$Conn->query("SELECT * FROM Partes_Maquinas_View WHERE id_parte=$id_parte AND $where_c_coste");
        // cogemos las variables de entorno


        while ($rs = $result->fetch_array(MYSQLI_ASSOC) )
        {
            // registramos gasto de horas totales de cada personal
            $sql3  = "INSERT INTO `GASTOS_T` ( ID_VALE,ID_CONCEPTO,CANTIDAD,ID_SUBOBRA ) ";
            $sql3 .= "VALUES ( '$id_vale_cargo','{$rs["id_concepto_mq"]}' ,'{$rs["cantidad"]}', '$id_subobra_si‌' );" ;
        //  echo ($sql3)."<br>";
            $result3=$Conn->query($sql3);

            // registramos ABONO DE MAQUINARIA 
            //previamente creamos el VALE y lo linkamos como abono del id_vale_cargo
            $id_obra_mq=$rs["id_obra_mq"] ;
              $result_abono=$Conn->query("INSERT INTO `VALES` ( ID_PROVEEDORES,ID_OBRA,Fecha,REF,ID_FRA_PROV,`user` )"
                         . " VALUES ( '$id_proveedor', '$id_obra_mq','$fecha' ,'PD-ABONO-MQ-$id_parte' ,'$id_fra_prov', '{$_SESSION["user"]}' );  " );    

             // buscamos el nuevo id_vale 
             $id_vale_abono=Dfirst( "MAX(ID_VALE)", "Vales_list", " $where_c_coste AND ID_PROVEEDORES=$id_proveedor AND ID_OBRA=$id_obra_mq " ) ; 

             //registramos la relación vale_cargo, vale_abono
             $result_link=$Conn->query("INSERT INTO `Vales_cargo_abono` ( id_vale_cargo, id_vale_abono )"
                         . " VALUES ( '$id_vale_cargo', '$id_vale_abono' );  " );    

             //registramos el detalle GASTOS_T

            $sql3  = "INSERT INTO `GASTOS_T` ( ID_VALE,ID_CONCEPTO,CANTIDAD,ID_SUBOBRA ) ";
            $sql3 .= "VALUES ( '$id_vale_abono','{$rs["id_concepto_mq"]}' ,'-{$rs["cantidad"]}', '$id_subobra_general' );" ;
        //  echo ($sql3)."<br>";
            $result3=$Conn->query($sql3);



        }

 }
 
//echo "<script languaje='javascript' type='text/javascript'>window.close();</script>"; 
echo "<META HTTP-EQUIV='REFRESH' CONTENT='0;URL=../personal/parte.php?id_parte=$id_parte'>" ;   //DEBUG
//echo "TODO OK" ;   //DEBUG
       

?>