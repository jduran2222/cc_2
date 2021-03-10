<?php


// VARIABLES DE SITUACION    
$id_proveedor_auto = getvar("id_proveedor_auto",0);
$fecha_inicio=(date('Y')-1)."-01-01" ;  // 1 de enero del año anterior

    
$num_proveedores=Dfirst("count(id_proveedores)","Proveedores", $where_c_coste ) ;
$num_clientes=Dfirst("count(id_cliente)","Clientes", $where_c_coste ) ;
$num_obras=Dfirst("count(id_obra)","OBRAS", " tipo_subcentro='O' AND $where_c_coste"  ) ;
$num_estudios=Dfirst("count(id_estudio)","Estudios_de_Obra", $where_c_coste ) ;
$num_maquinaria=Dfirst("count(id_obra)","OBRAS", " tipo_subcentro='M' AND $where_c_coste" ) ;
$num_usuarios=Dfirst("count(id_usuario)","Usuarios", $where_c_coste   ) ;
$num_empleados=Dfirst("count(id_personal)","PERSONAL","BAJA=0 AND $where_c_coste"   ) ;
$num_documentos=Dfirst("count(id_documento)","Documentos", $where_c_coste ) ;
$num_documentos_pdte_clasif=Dfirst("count(id_documento)","Documentos", "tipo_entidad='pdte_clasif' AND $where_c_coste"  ) ;
$num_conceptos=Dfirst("count(id_concepto)","CONCEPTOS", "id_proveedor=$id_proveedor_auto") ;
$num_fras_prov=Dfirst("count(ID_FRA_PROV)","Fras_Prov_Listado", "$where_c_coste"  ) - 2 ;  // restamos 2 por las facturas ocultas de mano obra y maquinaria
//$num_fras_prov=Dfirst("count(ID_FRA_PROV)","FACTURAS_PROV INNER JOIN Proveedores ON Proveedores.ID_PROVEEDORES=FACTURAS_PROV.ID_PROVEEDORES", "$where_c_coste"  ) - 2 ;  // restamos 2 por las facturas ocultas de mano obra y maquinaria
$num_fras_cli=Dfirst("count(ID_FRA)","Fras_Cli_Listado", $where_c_coste ) ;
$num_remesa_pagos=Dfirst("count(id_remesa)","Remesas_listado", $where_c_coste ." AND activa=1 AND tipo_remesa='P'"  ) ;
$num_remesa_cobros=Dfirst("count(id_remesa)","Remesas_listado", $where_c_coste ." AND activa=1 AND tipo_remesa='C'" ) ;
$num_ctas_bancos=Dfirst("count(id_cta_banco)","ctas_bancos", $where_c_coste   ) ;

$num_avales_pdtes=Dfirst('count(ID_AVAL)','Avales',"$where_c_coste AND F_Recogida <= NOW() AND Recogido=0 AND Solicitado=0 ") ;
$num_documentos_pdte_clasif = Dfirst("count(id_documento)", "Documentos", "tipo_entidad='pdte_clasif' AND $where_c_coste");
$num_fras_prov_NR = Dfirst("count(ID_FRA_PROV)", "Fras_Prov_Listado", "ID_PROVEEDORES=$id_proveedor_auto AND $where_c_coste");
$num_procedimientos = Dfirst("count(id_procedimiento)", "Procedimientos", " $where_c_coste AND Obsoleto=0 " );


$sql_num_fra_prov_NC=encrypt2( "SELECT count(ID_FRA_PROV) FROM Fras_Prov_View WHERE $where_c_coste AND ID_PROVEEDORES<>$id_proveedor_auto AND NOT conc AND FECHA>='$fecha_inicio'  ;  "     ) ;
$sql_num_fra_prov_NP=encrypt2( "SELECT count(ID_FRA_PROV) FROM Fras_Prov_View WHERE $where_c_coste AND ID_PROVEEDORES<>$id_proveedor_auto AND conc AND NOT pagada AND FECHA>='$fecha_inicio'  ;  "     ) ;



if (!$path_logo_empresa = Dfirst("path_logo", "Empresas_Listado", "$where_c_coste")) {$path_logo_empresa = "../img/no_logo_empresa.jpg";} ;

 

//tareas
$tareas = Dfirst("count(id)", "Tareas_View", "$where_c_coste AND Terminada=0 AND usuarios LIKE '%{$_SESSION["user"]}%' " );
$fecha_tareas_vistas=Dfirst("fecha_tareas_vistas","Usuarios"," $where_c_coste AND id_usuario={$_SESSION["id_usuario"]} " ) ;
$tareas_new = Dfirst("count(id)", "Tareas_View", "$where_c_coste AND Terminada=0 AND usuarios LIKE '%{$_SESSION["user"]}%' AND fecha_modificacion > '$fecha_tareas_vistas' " );

// portafirmas
$portafirmas = Dfirst("count(id_firma)", "Firmas_View", " $where_c_coste AND pdte AND id_usuario={$_SESSION["id_usuario"]} " );

$chat_pendientes=Dfirst("COUNT(chatid)","chat","reciever_userid='{$_SESSION["id_usuario"]}' AND status = '1' ") ;

if ($_SESSION["admin_chat"]) {
    $chat_users_online=Dfirst("COUNT(id_usuario)","Usuarios","online=1") ;
    $badge_txt=badge($chat_users_online,'info') .badge($chat_pendientes,'danger') ;
} else {
    $badge_txt=badge($chat_pendientes,'danger') ;    
}

