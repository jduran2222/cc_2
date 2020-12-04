<?php
require_once("../include/session.php");
$where_c_coste=" id_c_coste={$_SESSION['id_c_coste']} " ;	


// registramos el documento en la bbdd
require_once("../../conexion.php"); 
require_once("../include/funciones.php"); 

logs("INICIO DE FRA_PROV_ABONO.PHP");

                
$id_fra_prov = $_GET["id_fra_prov"];



// comprobramos si son el mismo proveedor

//$id_fra_prov_abono=Difrst("id_fra_prov_abono", "Fras_Prov_View","$where_c_coste AND ID_FRA_PROV=$id_fra_prov") ;
$rs=Drow("Fras_Prov_View","$where_c_coste AND ID_FRA_PROV=$id_fra_prov") ;

$rs_abono=Drow("Fras_Prov_View","$where_c_coste AND ID_FRA_PROV={$rs["id_fra_prov_abono"]}" ) ;

$id_fra_prov_abono = $rs["id_fra_prov_abono"];    // lo cogemos del campo id_fra_prov_abono

// comprobaciones varias
if(!$rs OR !$rs_abono)  {cc_die('ERROR ENLAZANDO FACTURA DE ABONO A FACTURA PRINCIPAL');}
if($rs["ID_PROVEEDORES"]<>$rs_abono["ID_PROVEEDORES"])  {cc_die('ERROR ENLAZANDO FACTURA DE ABONO A FACTURA PRINCIPAL\n DIFERENTES PROVEEDORES');}
if($rs_abono["IMPORTE_IVA"]>=0)  {cc_die('ERROR: El Abono es positivo o de importe cero');}

logs("FRA_PROV_ABONO.PHP: pasamos los filtros no imprescindibles");


$fecha=date('Y-m-d');

// decidimos la obra de cargo, si fra_ppal tiene ya una obra l cogemos y si no, la obra por defecto
$id_obra=$rs["ID_OBRA"]? $rs["ID_OBRA"] : getvar("id_obra_gg");


//$sql="SELECT * FROM Fras_Prov_View WHERE $where AND $where_c_coste";
////echo $sql ;
//$result=$Conn->query($sql) ;
//$rs = $result->fetch_array(MYSQLI_ASSOC) ;

 $id_proveedor=$rs["ID_PROVEEDORES"] ;
// $base_imponible_abono=$rs["Base_Imponible"] ;
 
// $id_fra_prov=$rs["ID_FRA_PROV"] ;
// $fecha=$rs["FECHA"] ;
 
$guid =  guid(); 
$guid_abono =  guid(); 
 

$sql2 =  "INSERT INTO `VALES` ( ID_PROVEEDORES,ID_OBRA,Fecha,REF,ID_FRA_PROV,`user`,guid ) ";
$sql2 .= "VALUES ( '$id_proveedor', '$id_obra','$fecha' ,'Abono {$rs_abono["N_FRA"]}' ,'$id_fra_prov', '{$_SESSION["user"]}' ,'$guid');" ;
$result2=$Conn->query($sql2);

$sql2 =  "INSERT INTO `VALES` ( ID_PROVEEDORES,ID_OBRA,Fecha,REF,ID_FRA_PROV,`user`,guid ) ";
$sql2 .= "VALUES ( '$id_proveedor', '$id_obra','$fecha' ,'Abono {$rs_abono["N_FRA"]}' ,'$id_fra_prov_abono', '{$_SESSION["user"]}' ,'$guid_abono');" ;

$result2=$Conn->query($sql2);


// echo ($sql2);
//$result2=1;
          
logs("FRA_PROV_ABONO.PHP: creamos los VALES. resultado:". ($result2? "CORRECTO" : "ERROR EN INSERT INTO VALES:<br> $sql2" ));

 
 if ($result2) //compruebo si se han creado los vales
             { 	
//                 $result2->free_result();
//                $id_vale=Dfirst( "ID_VALE", "VALES", " ID_PROVEEDORES=$id_proveedor AND guid='cba01ae4bd76c62194352ebb72e23b61' " ) ; 
//                $id_vale=Dfirst( "`ID_VALE`", "`VALES`", " 1=1 " ) ; 
                $id_vale2=Dfirst( "ID_OBRA", "OBRAS", " 1=1 " ) ; 
     
//                $Conn->close(); 
                
                $id_vale=Dfirst( "ID_VALE", "VALES", " ID_PROVEEDORES=$id_proveedor AND guid='$guid' " ) ; 
                $id_vale_abono=Dfirst( "ID_VALE", "VALES", " ID_PROVEEDORES=$id_proveedor AND guid='$guid_abono' " ) ; 
             
                
                $id_subobra_si = Dfirst( "id_subobra_auto", "OBRAS", "$where_c_coste AND ID_OBRA=$id_obra" ) ; 
                $id_subobra_si = $id_subobra_si ? $id_subobra_si : getVar("id_subobra_si") ;         // por si alguna OBRA no tiene id_subobra_auto

                
//                $id_concepto_auto=Dfirst( "id_concepto_auto", "Proveedores", "ID_PROVEEDORES=$id_proveedor" ) ; 
                $id_concepto_auto=$rs["id_concepto_auto"] ; 
                
                if (!$id_concepto_auto)    // proveedor sin id_concepto_auto (concepto para cargo de gastos automático) CREAMOS UN CONCEPTO NUEVO A COSTE 1€
                {
                    $id_obra_gg = getVar("id_obra_gg") ;
                    $id_cuenta_auto = getVar("id_cuenta_auto") ;
                    
                    
                    
                    $sql4 =  "INSERT INTO `CONCEPTOS` ( ID_PROVEEDOR,ID_OBRA,ID_CUENTA,CONCEPTO,COSTE,`user` ) ";
                    $sql4 .= "VALUES ( '$id_proveedor', '$id_obra_gg','$id_cuenta_auto' ,'GASTOS DE {$rs["PROVEEDOR"]}' ,'1', '{$_SESSION["user"]}' );" ;

//                    echo ($sql4);
                    $result4=$Conn->query($sql4);
                    
                    logs("FRA_PROV_ABONO.PHP: insertamos CONCEPTO GASTOS.... resultado:".($result4? "CORRECTO <br> $sql4" : "ERROR :<br> $sql4" ));
                    
                    // rescato el nuevo id_concepto creado y lo asigno a la variable id_concepto_auto
                    $id_concepto_auto=Dfirst( "MAX(ID_CONCEPTO)", "CONCEPTOS", "ID_PROVEEDOR=$id_proveedor AND COSTE=1" ) ; 
                    
                    // registro su valor en su Proveedor
                    $result5=$Conn->query("UPDATE `Proveedores` SET `id_concepto_auto` = $id_concepto_auto WHERE ID_PROVEEDORES=$id_proveedor;" );

                     
                } 
                
                // GASTOS_T  detalle del VALE   
                $importe_negativo= $rs_abono["pdte_conciliar"] * (-1) ;
                $sql3 = "INSERT INTO `GASTOS_T` ( ID_VALE,ID_CONCEPTO,CANTIDAD,ID_SUBOBRA ) ";
                $sql3 .="VALUES ( '$id_vale', '$id_concepto_auto','$importe_negativo' ,'$id_subobra_si' );" ;
                $result3=$Conn->query($sql3);

                $sql3 = "INSERT INTO `GASTOS_T` ( ID_VALE,ID_CONCEPTO,CANTIDAD,ID_SUBOBRA ) ";
                $sql3 .="VALUES ( '$id_vale_abono', '$id_concepto_auto','{$rs_abono["pdte_conciliar"]}' ,'$id_subobra_si' );" ;

//                echo ($sql3);
                $result3=$Conn->query($sql3);

                 logs("FRA_PROV_ABONO.PHP: insertamos gastos_t .... resultado:".($result3? "CORRECTO<br> $sql3" : "ERROR EN INSERT INTO VALES:<br> $sql3" ));
             
             
	        // TODO OK-> Entramos a pagina_inicio.php
//	        echo "CARGO A OBRA creado satisfactoriamente." ;
//		echo  "Ir a Parte diario <a href='../personal/parte.php?id_parte=$id_parte' title='ver Parte Diario'> $id_parte</a>" ;
//                echo "<META HTTP-EQUIV='REFRESH' CONTENT='0;URL=../personal/parte.php?id_parte=$id_parte'>" ;
//               echo "<script languaje='javascript' type='text/javascript'>window.close();</script>"; 

                
               // FALTA CREAR PAGOS DE ABONO A CUENTA DE ABONOS (BIEN CTA CORRIENTE, BIEN CUENTA ESPECIAL) 
                
                // creamos MOV_BANCOS
                $id_cta_banco=getvar("id_cta_banco_abono_fras")   ;// CUENTA AUXILIAR ABONOS
                
                
                $importe_negativo_iva= $rs_abono["pdte_pago"] * (-1) ;
                $sql= "INSERT INTO `MOV_BANCOS` (`id_cta_banco`, `guid`, `fecha_banco`, `Concepto`,  cargo, user)" 
               ." VALUES ( '$id_cta_banco', '$guid', '$fecha', 'Abono {$rs_abono["N_FRA"]}',  '$importe_negativo_iva', '{$_SESSION['user']}');" ;    
               $result3=$Conn->query($sql);
               
                logs("FRA_PROV_ABONO.PHP: insertamos MOV_BANCOS .... resultado:".($result3? "CORRECTO<br> $sql" : "ERROR EN INSERT INTO VALES:<br> $sql" ));
                $sql= "INSERT INTO `MOV_BANCOS` (`id_cta_banco`, `guid`, `fecha_banco`, `Concepto`,  cargo, user)" 
               ." VALUES ( '$id_cta_banco', '$guid_abono', '$fecha', 'Abono {$rs_abono["N_FRA"]}',  '{$rs_abono["pdte_pago"]}' , '{$_SESSION['user']}');" ;    

               $result3=$Conn->query($sql);
                
                logs("FRA_PROV_ABONO.PHP: insertamos MOV_BANCOS .... resultado:".($result3? "CORRECTO<br> $sql" : "ERROR EN INSERT INTO VALES:<br> $sql" ));

                // CREAMOS PAGOS Y ENLAZAMOS A MOV_BANCOS Y FACTURAS PROV

               $id_mov_banco=Dfirst("id_mov_banco","MOV_BANCOS","guid='$guid'");
               $id_mov_banco_abono=Dfirst("id_mov_banco","MOV_BANCOS","guid='$guid_abono'");
               
               
               
                $sql="INSERT INTO `PAGOS` ( id_cta_banco,id_mov_banco,tipo_pago,guid,tipo_doc,f_vto,importe,observaciones,`user` ) "
                     . " VALUES (  '$id_cta_banco','$id_mov_banco','P','$guid','abono', '$fecha' ,'$importe_negativo_iva','ABONO {$rs_abono["N_FRA"]}', '{$_SESSION["user"]}' );" ;
                $result3=$Conn->query($sql);
                logs("FRA_PROV_ABONO.PHP: insertamos PAGOS .... resultado:".($result3? "CORRECTO<br> $sql" : "ERROR EN INSERT INTO pagos:<br> $sql" ));

                $sql="INSERT INTO `PAGOS` ( id_cta_banco,id_mov_banco,tipo_pago,guid,tipo_doc,f_vto,importe,observaciones,`user` ) "
                     . " VALUES (  '$id_cta_banco','$id_mov_banco_abono','P','$guid_abono','abono', '$fecha' ,'{$rs_abono["pdte_pago"]}','ABONO {$rs_abono["N_FRA"]}', '{$_SESSION["user"]}' );" ;
  
                $result3=$Conn->query($sql);
                logs("FRA_PROV_ABONO.PHP: insertamos PAGOS .... resultado:".($result3? "CORRECTO<br> $sql" : "ERROR EN INSERT INTO pagos:<br> $sql" ));
                
             // conciliamos pagos con facturas_prov
                
                $id_pago=Dfirst("id_pago","PAGOS","guid='$guid'");
                $id_pago_abono=Dfirst("id_pago","PAGOS","guid='$guid_abono'");
                
               $sql="INSERT INTO `FRAS_PROV_PAGOS` (id_fra_prov , id_pago) VALUES ( '$id_fra_prov','$id_pago' );" ;
               $result3=$Conn->query($sql);
                logs("FRA_PROV_ABONO.PHP: insertamos FRAS_PROV_PAGOS .... resultado:".($result3? "CORRECTO<br> $sql" : "ERROR EN INSERT INTO fra_pagos:<br> $sql" ));
               
               $sql="INSERT INTO `FRAS_PROV_PAGOS` (id_fra_prov , id_pago) VALUES ( '$id_fra_prov_abono','$id_pago_abono' );" ;
               $result3=$Conn->query($sql);
                logs("FRA_PROV_ABONO.PHP: insertamos FRAS_PROV_PAGOS .... resultado:".($result3? "CORRECTO<br> $sql" : "ERROR EN INSERT INTO fras_pagos:<br> $sql" ));
                
                // ENLAZAMOS EN LA bbdd  (NO ES NECESARIO, YA ESTA REALIZADO)
//                $result_UPDATE=$Conn->query("UPDATE `FACTURAS_PROV` SET `id_fra_prov_abono` = $id_fra_prov_abono "
//                        . " WHERE $where_c_coste AND ID_FRA_PROV=$id_fra_prov" );

	     }
	       else
	     {
		cc_die( "Error al CREAR VALES DE ABONO, inténtelo de nuevo ") ;
//		echo  "<a href='javascript:history.back(-1);' title='Ir la página anterior'>Volver</a>" ;
	     }
  
  
echo "<script languaje='javascript' type='text/javascript'>window.close();</script>"; 


?> 