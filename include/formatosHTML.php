<?php

// Creación de un trozo de código para la gestión de encabezados generales.
function encabezadoPagina($titulo=null) {
    $html = '';
    $html .= '<div class="page-header my-5">';
    $html .= '    <h1 class="text-uppercase text-center border-bottom">'.$titulo.'</h1>';
    $html .= '</div>';
    return $html;
}
// Creación de un enlace para volver a página de orden superior (cabecera).
function enlaceVolverCabeceraPagina($enlace=null, $titulo=null) {
    $html = '';
    $html .= '<small><a class="text-muted small" href="'.$enlace.'">'.$titulo.'</a></small>';
    return $html;
}
// Creación de un trozo de código para la incorporación de un botón de agregar/crear información
function botonNuevo($enlace=null, $titulo=null) {
    $html = '';
    $html .= '<div class="text-right d-block">';
    $html .= '    <a class="btn btn-success noprint mx-3" href="'.$enlace.'" target="_blank">';
    $html .= '        <i class="fas fa-plus-circle"></i> ' . $titulo;
    $html .= '    </a>';
    $html .= '</div>';
    return $html;
}
// Creación de un trozo de código para la gestión de Fras. Proveedor.
function botonNuevaFacturaProveedor($enlace=null, $titulo=null) {
    $html = '';
    $auxEnlace = (!empty($enlace) ? $enlace :  '../proveedores/factura_proveedor_anadir.php');
    $auxTitulo = (!empty($titulo) ? $titulo :  'Nueva Fra.');
    $html = botonNuevo($auxEnlace, $auxTitulo);
    return $html;
}
// Creación de un trozo de código para la gestión de Fras. Proveedor.
function selectoresMenuFacturasProveedor($filtros=null, $operaciones=null, $agrupaciones=null, $resumen=null) {
    $html = '';

    $html .= '<div class="col">';
    $html .= '    <div class="d-flex align-content-center flex-wrap bg-secondary">';
    $html .= '    <a class="btn btn-secondary" data-toggle="collapse" href="#aplicarFiltros" role="button" aria-expanded="false" aria-controls="aplicarFiltros">Aplicar filtros</a>';
    $html .= '    <a class="btn btn-secondary" data-toggle="collapse" href="#operarFrasSeleccionadas" role="button" aria-expanded="false" aria-controls="operarFrasSeleccionadas">Operar con fras seleccionadas</a>';
    $html .= '    <a class="btn btn-secondary" data-toggle="collapse" href="#agruparResultados" role="button" aria-expanded="true" aria-controls="agruparResultados">Agrupar resultados</a>';
    $html .= '    <a class="btn btn-secondary" data-toggle="collapse" href="#verResumen" role="button" aria-expanded="false" aria-controls="verResumen">Ver resumen</a>';
    $html .= '    </div>';
    $html .= '    <div class="row mt-2">';
    $html .= '    <div class="col-12">';
    $html .= '        <div class="collapse" id="aplicarFiltros">';
    $html .= '        <div class="card card-body">';
    $html .= '            '.$filtros;
    $html .= '        </div>';
    $html .= '        </div>';
    $html .= '    </div>';
    $html .= '    <div class="col-12">';
    $html .= '        <div class="collapse" id="operarFrasSeleccionadas">';
    $html .= '        <div class="card card-body">';
    $html .= '            '.$operaciones;
    $html .= '        </div>';
    $html .= '        </div>';
    $html .= '    </div>';
    $html .= '    <div class="col-12">';
    $html .= '        <div class="collapse show" id="agruparResultados">';
    $html .= '        <div class="card card-body">';
    $html .= '            '.$agrupaciones;
    $html .= '        </div>';
    $html .= '        </div>';
    $html .= '    </div>';
    $html .= '    <div class="col-12">';
    $html .= '        <div class="collapse" id="verResumen">';
    $html .= '        <div class="card card-body">';
    $html .= '            '.$resumen;
    $html .= '        </div>';
    $html .= '        </div>';
    $html .= '    </div>';
    $html .= '    </div>';
    $html .= '</div>';

    return $html;
}
// Creación de un filtro
function filtroFormularioSimple($tipo=null, $nombre=null, $identificador=null, $clases=null, $label=null, $valor=null, $valores=null) {
    $html = '';

    $atributoFor = (!empty($identificador) ? ' for="'.$identificador.'"' : '');
    $atributoId = (!empty($identificador) ? ' id="'.$identificador.'"' : '');
    $atributoName = (!empty($nombre) ? ' name="'.$nombre.'"' : '');
    $atributoClass = (!empty($clases) ? ' class="'.$clases.'"' : '');
    $atributoValue = (!empty($valor) ? ' value="'.$valor.'"' : '');

    $html .= '<div class="col-12">';
    if ($tipo == 'radio') {

    }
    else if ($tipo == 'select') {

    }
    else {
        $html .=    '<label'.$atributoFor.'>'.$label.'</label> <br>';
        $html .=    '<input type="'.$tipo.'"'.$atributoId.$atributoName.$atributoClass.$atributoValue.'/>';
    }
    $html .= '</div>';

    return $html;
}
// Creación del panel de "Filtros" en facturas de proveedores
function panelFiltrosFacturasProveedor() {
    $html = '';

    $html .= '';

    return $html;
}
// Creación del panel de "Operaciones" en facturas de proveedores
function panelOperacionesFacturasProveedor($remesas=null, $cargas=null, $metalicos=null, $bancos=null, $grupos=null) {
    $html = '';

    $html .= '<div>';
    $html .= '  <strong>Acciones a realizar con facturas seleccionadas:</strong>';
    
    $html .= '  <div class="col-12 mt-2">';
    $html .= '      <div class="col-12 col-sm-4 pull-left">';
    $html .= '          <span>Añadir a remesa de pagos:</span>';
    $html .= '      </div>';
    $html .= '      <div class="col-12 col-sm-4 pull-left">';
    $html .= '          <select id="id_remesa" name="id_remesa" class="form-control form-control-sm">';
    $html .= '              <option value="0" selected>*crear remesa nueva*</option>';
    $html .= '              '.$remesas;
    $html .= '          </select>';
    $html .= '      </div>';
    $html .= '      <div class="col-12 col-sm-4 pull-right">';
    $html .= '          <a class="btn btn-warning btn-xs" href="#" onclick="genera_remesa();" title="Añade/Genera remesa con las facturas seleccionadas">Añadir a remesa</a>';
    $html .= '          <a class="btn btn-link btn-xs" href="#" onclick="window.open(\'../bancos/remesa_ficha.php?id_remesa=\'+document.getElementById(\'id_remesa\').value);" title="Abre la remesa seleccionada">(Ver remesa)</a>';
    $html .= '      </div>';
    $html .= '  </div>';
    $html .= '  <div class="clearfix"></div>';

    
    $html .= '  <div class="col-12 mt-2">';
    $html .= '      <div class="col-12 col-sm-4 pull-left">';
    $html .= '          <span>Cargar a obra:</span>';
    $html .= '      </div>';
    $html .= '      <div class="col-12 col-sm-4 pull-left">';
    $html .= '          <select id="id_obra" name="id_obra" class="form-control form-control-sm">';
    $html .= '              '.$cargas;
    $html .= '          </select>';
    $html .= '      </div>';
    $html .= '      <div class="col-12 col-sm-4 pull-right">';
    $html .= '          <a class="btn btn-warning btn-xs" href="#" onclick="cargar_a_obra_sel_href();" title="Carga las facturas seleccionadas a una obra">Cargar en obra</a>';
    $html .= '      </div>';
    $html .= '  </div>';
    $html .= '  <div class="clearfix"></div>';

    
    $html .= '  <div class="col-12 mt-2">';
    $html .= '      <div class="col-12 col-sm-4 pull-left">';
    $html .= '          <span>Registrar como pago en metálico:</span>';
    $html .= '      </div>';
    $html .= '      <div class="col-12 col-sm-4 pull-left">';
    $html .= '      </div>';
    $html .= '      <div class="col-12 col-sm-4 pull-right">';
    $html .= '          <a class="btn btn-warning btn-xs" href="#" onclick="mov_bancos_conciliar_fras_caja_metalico();" title="Registra las facturas como pagadas en metálico. Crea id_pago y un mov.banco en la Cuenta Metalico">Pagar con "Caja Metálico"</a>';
    $html .= '      </div>';
    $html .= '  </div>';
    $html .= '  <div class="clearfix"></div>';

    
    $html .= '  <div class="col-12 mt-2">';
    $html .= '      <div class="col-12 col-sm-4 pull-left">';
    $html .= '          <span>Pagar con cuenta:</span>';
    $html .= '      </div>';
    $html .= '      <div class="col-12 col-sm-4 pull-left">';
    $html .= '          <select id="id_cta_banco" name="id_cta_banco" class="form-control form-control-sm">';
    $html .= '              '.$bancos;
    $html .= '          </select>';
    $html .= '      </div>';
    $html .= '      <div class="col-12 col-sm-4 pull-right">';
    $html .= '          <a class="btn btn-warning btn-xs" href="#" onclick="mov_bancos_conciliar_fras_cta();" title="Pagar con el banco seleccionado">Realizar pago</a>';
    $html .= '      </div>';
    $html .= '  </div>';
    $html .= '  <div class="clearfix"></div>';

    
    $html .= '  <div class="col-12 mt-2">';
    $html .= '      <div class="col-12 col-sm-4 pull-left">';
    $html .= '          <span>Cambiar el grupo de las facturas seleccionadas:</span>';
    $html .= '      </div>';
    $html .= '      <div class="col-12 col-sm-4 pull-left">';
    $html .= '      </div>';
    $html .= '      <div class="col-12 col-sm-4 pull-right">';
    $html .= '          <a class="btn btn-warning btn-xs" href="#" onclick="js_href(\''.$grupos.'\' ,\'1\',\'\', \'PROMPT_Nombre_nuevo_grupo\' ,\'table_selection_IN()\' );" title="Cambia a otro grupo las facturas seleccionadas">Cambiar grupo</a>';
    $html .= '      </div>';
    $html .= '  </div>';
    $html .= '  <div class="clearfix"></div>';

    $html .= '</div>';

    return $html;
}
// Creación del panel de "Agrupaciones" en facturas de proveedores
function panelAgrupacionesFacturasProveedor($agrupaciones=array(), $seleccionado=null) {
    $html = '';

    $html .= '<input type="hidden" id="agrupar" name="agrupar" value="'.$seleccionado.'"/>';
    $html .= '<div id="myDIV" class="noprint">';
    foreach ($agrupaciones as $k => $v) {
        $activo = (($k==$seleccionado) ? ' bg-dark cc_active ' : '');  
        if (substr($k,0,5)!='vacio') {
            $html .= '<button class="cc_btnt'.$activo.'" title="'.$v[1].'" onclick="getElementById(\'agrupar\').value = \''.$k.'\'; document.getElementById(\'form1\').submit();\">';
            $html .=     ucwords($v[0]);
            $html .= '</button>';
        }
        else {
            $html .= '<span class="w50px"> </span>';
        }
        $html .= '';
    }
    $html .= '</div>';

    return $html;
}
// Creación del panel de "Resumen" en facturas de proveedores
function panelResumenFacturasProveedor($datos) {
    $html = '';
    
    $cabecera = array('Base Imponible','Importe de IVA','IMPORTE IVA','Importe Cargado','Importe Pagado','Importe Cobrado');
    $importes = array();
    foreach ($datos as $k => $v) {
        $importes[] = number_format($v, 2).' '.$_SESSION["Moneda_simbolo"];
    }
    $filas = array($importes);
    $html .= nCamposTablaResposive($cabecera, $filas); 

    return $html;
}
// Label para filtrar o generar PDFs
function labelVerPdf($fmt_pdf) {
    $html = '';

    $html .= '<div class="col">';
    $html .= '  <strong>Formato: </strong>';
    $html .= '  <div class="d-inline custom-control custom-checkbox mr-sm-2">';
    $html .= '      <input class="custom-control-input" type="checkbox" id="fmt_pdf" name="fmt_pdf" '.$fmt_pdf.'>';
    $html .= '      <label class="custom-control-label" for="fmt_pdf"><em>(Ver PDF)</em></label>';
    $html .= '  </div>';
    $html .= '</div>';

    return $html;
}
// Creación-apertura de un nuevo formulario
function iniciaForm($enlace=null, $metodo=null, $nombre=null, $identificador=null, $clases=null) {
    $html = '';
    
    $auxEnlace = (!empty($enlace) ? $enlace : 'POST');
    $auxMetodo = (!empty($metodo) ? $metodo : 'POST');
    $atributoId = (!empty($identificador) ? ' id="'.$identificador.'"' : '');
    $atributoName = (!empty($nombre) ? ' name="'.$nombre.'"' : '');
    $atributoClass = (!empty($clases) ? ' class="'.$clases.'"' : '');
    
    $html .= '<form method="'.$auxMetodo.'" action="'.$auxEnlace.'"'.$atributoId.$atributoName.$atributoClass.'>';

    return $html;
}
// Creación-cierre de un nuevo formulario
function finalizaForm() {
    $html = '';
    $html .= '</form>';
    return $html;
}
// Creación-inicio de una nueva tabla
function comentarioPrevioTabla($comentario) {
    $html = '';
    
    $html .= '<div class="col-12 text-muted">'.$comentario.'</div>';

    return $html;
}
// Creación-inicio de una nueva tabla
function iniciaTabla($nombre=null, $identificador=null, $clases=null) {
    $html = '';
    
    $atributoId = (!empty($identificador) ? ' id="'.$identificador.'"' : '');
    $atributoName = (!empty($nombre) ? ' name="'.$nombre.'"' : '');
    $atributoClass = (!empty($clases) ? ' class="'.$clases.'"' : '');
    
    $html .= '<table'.$atributoId.$atributoName.$atributoClass.'>';

    return $html;
}
// Creación-fin de una nueva tabla
function finalizaTabla() {
    $html = '';
    $html .= '</table>';
    return $html;
}
// Creación-inicio de una nueva tabla
function iniciaDivision($nombre=null, $identificador=null, $clases=null) {
    $html = '';
    
    $atributoId = (!empty($identificador) ? ' id="'.$identificador.'"' : '');
    $atributoName = (!empty($nombre) ? ' name="'.$nombre.'"' : '');
    $atributoClass = (!empty($clases) ? ' class="'.$clases.'"' : '');
    
    $html .= '<div'.$atributoId.$atributoName.$atributoClass.'>';

    return $html;
}
// Creación-fin de una nueva tabla
function finalizaDivision() {
    $html = '';
    $html .= '</div>';
    return $html;
}
// Creación de una tabla con N campos
function nCamposTablaResposive($tableHead=array(), $tableBody=array()) {
    $html = '';

    $html .= '<div class="table-responsive">';
    $html .= '  <table class="table table-striped table-hover">';
    $html .= '      <thead>';
    $html .= '          <tr>';
    foreach ($tableHead as $k => $v) {
        $html .= '           <th scope="col">'.$v.'</th>';
    }
    $html .= '          </tr>';
    $html .= '      </thead>';
    $html .= '      <tbody>';
    $html .= '          <tr></tr>';
    foreach ($tableBody as $k => $v) {
        $html .= '       <tr>';
        foreach ($v as $k2 => $v2) {
            $html .= '           <td>'.$v2.'</td>';
        }
        $html .= '       </tr>';
    }
    $html .= '      </tbody>';
    $html .= '  </table>';
    $html .= '</div>';

    return $html;
}