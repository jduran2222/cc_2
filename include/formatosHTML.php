<?php

include_once('../include/formatosHTML_jd.php');


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
    $html .= '    <a class="btn btn-primary noprint mx-3" href="'.$enlace.'" target="_blank">';
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
function selectoresMenuFacturasProveedor($filtros=null, $operaciones=null, $agrupaciones=null, $resumen=null, $formatos=null) {
    $html = '';

    $html .= '<div class="col">';
    // $html .= '    <div class="d-flex align-content-center flex-wrap bg-secondary">';
    // $html .= '          <a class="btn btn-secondary" data-toggle="collapse" href="#aplicarFiltros" role="button" aria-expanded="false" aria-controls="aplicarFiltros">Aplicar filtros</a>';
    // $html .= '          <a class="btn btn-secondary" data-toggle="collapse" href="#operarFrasSeleccionadas" role="button" aria-expanded="false" aria-controls="operarFrasSeleccionadas">Operar con facturas seleccionadas</a>';
    // $html .= '          <a class="btn btn-secondary" data-toggle="collapse" href="#agruparResultados" role="button" aria-expanded="true" aria-controls="agruparResultados">Agrupar resultados</a>';
    // $html .= '          <a class="btn btn-secondary" data-toggle="collapse" href="#verResumen" role="button" aria-expanded="false" aria-controls="verResumen">Ver resumen</a>';
    // $html .= '          <a class="btn btn-secondary" data-toggle="collapse" href="#formatos" role="button" aria-expanded="false" aria-controls="formatos">Formatos</a>';
    // $html .= '    </div>';
    $html .= '    <div class="row mt-2 mb-4">';

    $html .= '          <div class="col-12 align-content-center">';
    $html .= '              <a class="mt-2 col-12 btn btn-secondary" data-toggle="collapse" href="#aplicarFiltros" role="button" aria-expanded="false" aria-controls="aplicarFiltros">FILTRO</a>';
    $html .= '          </div>';
    $html .= '          <div class="col-12">';
    $html .= '              <div class="collapse" id="aplicarFiltros">';
    $html .= '              <div class="card card-body d-block">';
    $html .= '                  '.$filtros;
    $html .= '              </div>';
    $html .= '              </div>';
    $html .= '          </div>';
    
    $html .= '          <div class="col-12 align-content-center">';
    $html .= '              <a class="mt-2 col-12 btn btn-secondary" data-toggle="collapse" href="#agruparResultados" role="button" aria-expanded="false" aria-controls="agruparResultados">AGRUPAR</a>';
    $html .= '          </div>';
    $html .= '          <div class="col-12">';
    $html .= '              <div class="collapse" id="agruparResultados">';
    $html .= '              <div class="card card-body">';
    $html .= '                  '.$agrupaciones;
    $html .= '              </div>';
    $html .= '              </div>';
    $html .= '          </div>';


    $html .= '          <div class="col-12 align-content-center">';
    $html .= '              <a class="mt-2 col-12 btn btn-secondary" data-toggle="collapse" href="#operarFrasSeleccionadas" role="button" aria-expanded="false" aria-controls="operarFrasSeleccionadas">Operar con facturas seleccionadas</a>';
    $html .= '          </div>';
    $html .= '          <div class="col-12">';
    $html .= '              <div class="collapse" id="operarFrasSeleccionadas">';
    $html .= '              <div class="card card-body">';
    $html .= '                  '.$operaciones;
    $html .= '              </div>';
    $html .= '              </div>';
    $html .= '          </div>';

//    $html .= '          <div class="col-12 align-content-center">';
//    $html .= '              <a class="mt-2 col-12 btn btn-secondary" data-toggle="collapse" href="#verResumen" role="button" aria-expanded="false" aria-controls="verResumen">Ver resumen</a>';
//    $html .= '          </div>';
//    $html .= '          <div class="col-12">';
//    $html .= '              <div class="collapse" id="verResumen">';
//    $html .= '              <div class="card card-body">';
//    $html .= '                  '.$resumen;
//    $html .= '              </div>';
//    $html .= '              </div>';
//    $html .= '          </div>';

    $html .= '          <div class="col-12 align-content-center">';
    $html .= '              <a class="mt-2 col-12 btn btn-secondary" data-toggle="collapse" href="#formatos" role="button" aria-expanded="false" aria-controls="formatos">Formatos</a>';
    $html .= '          </div>';
    $html .= '          <div class="col-12">';
    $html .= '              <div class="collapse" id="formatos">';
    $html .= '              <div class="card card-body">';
    $html .= '                  '.$formatos;
    $html .= '              </div>';
    $html .= '              </div>';
    $html .= '          </div>';
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
    $atributoClass = (!empty($clases) ? ' class="'.$clases.'"' :  ' class="form-control form-control-sm"');
    $atributoValue = (!empty($valor) ? ' value="'.$valor.'"' : '');

    $html .= '<div class="col-12 col-sm-4 float-left mt-2">';
    if ($tipo == 'radio') {
        //nada
    }
    else if ($tipo == 'select') {
        $html .=    '<div class="col-12">';
        $html .=        '<label'.$atributoFor.'>'.$label.'</label> <br>';
        $html .=    '</div>';
        $html .=    '<div class="col-12 input-group">';
        $html .=        '<select'.$atributoId.$atributoName.$atributoClass.$atributoValue.'/>';
        foreach ($valores as $k => $v) {
            $checked = '';
            if ($v['value'] == $valor){
                $checked = ' checked="checked"';
            }
            $atributoIdOpt = (!empty($v['id']) ? ' id="'.$v['id'].'"' : '');
            $atributoValueOpt = (!empty($v['value']) ? ' value="'.$v['value'].'"' : '');
            $atributoTextoOpt = (!empty($v['texto']) ? ''.$v['texto'].'' : '');
            $html .=    '<option'.$checked.$atributoIdOpt.$atributoValueOpt.'>'.(!empty($atributoTextoOpt) ? $atributoTextoOpt : $atributoValueOpt).'</option>';
        }
        $html .=        '</select>';
        $html .=        '<div class="input-group-append">';
        $html .=            '<span class="input-group-text small" onclick="document.getElementById(\''.$nombre.'\').value=\'\';"><i title="Limpiar filtro asociado" class="fas fa-xs fa-backspace"></i></span>';
        $html .=        '</div>';
        $html .=    '</div>';
    }
    else {
        $html .=    '<div class="col-12">';
        $html .=        '<label'.$atributoFor.'>'.$label.'</label> <br>';
        $html .=    '</div>';
        $html .=    '<div class="col-12 input-group">';
        $html .=        '<input type="'.$tipo.'"'.$atributoId.$atributoName.$atributoClass.$atributoValue.'/>';
        $html .=        '<div class="input-group-append">';
        $html .=            '<span class="input-group-text small" onclick="document.getElementById(\''.$nombre.'\').value=\'\';"><i title="Limpiar filtro asociado" class="fas fa-xs fa-backspace"></i></span>';
        $html .=        '</div>';
        $html .=    '</div>';
    }
    $html .= '</div>';

    // // En caso de querer el formulario más limpio y condensado unir los elementos por label+input
    // $html .= '<div class="col-12 col-sm-4 float-left mt-2">';
    // if ($tipo == 'radio') {
    //     //nada
    // }
    // else if ($tipo == 'select') {
    //     $html .=    '<div class="col-6 float-left">';
    //     $html .=        '<label'.$atributoFor.'>'.$label.'</label> <br>';
    //     $html .=    '</div>';
    //     $html .=    '<div class="col-6 float-left input-group">';
    //     $html .=        '<select'.$atributoId.$atributoName.$atributoClass.$atributoValue.'/>';
    //     foreach ($valores as $k => $v) {
    //         $checked = '';
    //         if ($v['value'] == $valor){
    //             $checked = ' checked="checked"';
    //         }
    //         $atributoIdOpt = (!empty($v['id']) ? ' id="'.$v['id'].'"' : '');
    //         $atributoValueOpt = (!empty($v['value']) ? ' value="'.$v['value'].'"' : '');
    //         $atributoTextoOpt = (!empty($v['texto']) ? ''.$v['texto'].'' : '');
    //         $html .=    '<option'.$checked.$atributoIdOpt.$atributoValueOpt.'>'.(!empty($atributoTextoOpt) ? $atributoTextoOpt : $atributoValueOpt).'</option>';
    //     }
    //     $html .=        '</select>';
    //     $html .=        '<div class="input-group-append">';
    //     $html .=            '<span class="input-group-text small" onclick="document.getElementById(\''.$nombre.'\').value=\'\';"><i class="fas fa-backspace"></i></span>';
    //     $html .=        '</div>';
    //     $html .=    '</div>';
    //     $html .=    '<div class="clearfix"></div>';
    // }
    // else {
    //     $html .=    '<div class="col-6 float-left">';
    //     $html .=        '<label'.$atributoFor.'>'.$label.'</label> <br>';
    //     $html .=    '</div>';
    //     $html .=    '<div class="col-6 float-left input-group">';
    //     $html .=        '<input type="'.$tipo.'"'.$atributoId.$atributoName.$atributoClass.$atributoValue.'/>';
    //     $html .=        '<div class="input-group-append">';
    //     $html .=            '<span class="input-group-text small" onclick="document.getElementById(\''.$nombre.'\').value=\'\';"><i class="fas fa-backspace"></i></span>';
    //     $html .=        '</div>';
    //     $html .=    '</div>';
    //     $html .=    '<div class="clearfix"></div>';
    // }
    // $html .= '</div>';

    return $html;
}
// Creación del panel de "Filtros" en facturas de proveedores
function panelFiltrosFacturasProveedor($listado_global, $params) {
    $html = '';

    $html .= '<div class="col-12 small">';
    if ($listado_global) {
        // <TR><TD>Proveedor o Cif</TD><TD><INPUT type='text' id='proveedor' name='proveedor' value='$proveedor'><button type='button' onclick=\"document.getElementById('proveedor').value='' \" >*</button></TD></TR>
        $html .= filtroFormularioSimple('text', 'proveedor', 'proveedor', '', 'Proveedor o CIF', $params['proveedor'], $params['proveedor']);
        // // <TR><TD>OBRA       </TD><TD><INPUT type='text' id='N_OBRA' name='N_OBRA' value='$N_OBRA'><button type='button' onclick=\"document.getElementById('N_OBRA').value='' \" >*</button></TD></TR>
        // $html .= filtroFormularioSimple('text', 'N_OBRA', 'N_OBRA', '', 'OBRA', $params['N_OBRA'], $params['N_OBRA']);
    }
    else {
        //no aplica filtros adicionales
    }

    // <TR><TD class='seleccion' >Núm. Factura/ID_FRA_PROV   </TD><TD class='seleccion' ><INPUT type='text' id='n_fra'   name='n_fra'  value='$n_fra'><button type='button' onclick=\"document.getElementById('n_fra').value='' \" >*</button></TD></TR>
    $html .= filtroFormularioSimple('text', 'n_fra', 'n_fra', '', 'Núm. Factura/ID_FRA_PROV', $params['n_fra'], $params['n_fra']);
    // <TR><TD>Obra            </TD><TD><INPUT type='text' id='NOMBRE_OBRA'   name='NOMBRE_OBRA'  value='$NOMBRE_OBRA'><button type='button' onclick=\"document.getElementById('NOMBRE_OBRA').value='' \" >*</button></TD></TR>
    $html .= filtroFormularioSimple('text', 'NOMBRE_OBRA', 'NOMBRE_OBRA', '', 'Obra', $params['NOMBRE_OBRA'], $params['NOMBRE_OBRA']);
    // <TR><TD>Fecha mín.     </TD><TD><INPUT type='date' id='fecha1'     name='fecha1'    value='$fecha1'><button type='button' onclick=\"document.getElementById('fecha1').value='' \" >*</button></TD></TR>
    $html .= filtroFormularioSimple('date', 'fecha1', 'fecha1', '', 'Fecha mín.', $params['fecha1'], $params['fecha1']);
    // <TR><TD>Fecha máx.     </TD><TD><INPUT type='date' id='fecha2'     name='fecha2'    value='$fecha2'><button type='button' onclick=\"document.getElementById('fecha2').value='' \" >*</button></TD></TR>
    $html .= filtroFormularioSimple('date', 'fecha2', 'fecha2', '', 'Fecha máx.', $params['fecha2'], $params['fecha2']);
    // <TR><TD>MES     </TD><TD><INPUT type='text' id='MES'     name='MES'    value='$MES'><button type='button' onclick=\"document.getElementById('MES').value='' \" >*</button></TD></TR>
    $html .= filtroFormularioSimple('text', 'MES', 'MES', '', 'MES', $params['MES'], $params['MES']);
    // <TR><TD>Trimestre     </TD><TD><INPUT type='text' id='Trimestre'     name='Trimestre'    value='$Trimestre'><button type='button' onclick=\"document.getElementById('Trimestre').value='' \" >*</button></TD></TR>
    $html .= filtroFormularioSimple('text', 'Trimestre', 'Trimestre', '', 'Trimestre', $params['Trimestre'], $params['Trimestre']);
    // <TR><TD>Año     </TD><TD><INPUT type='text' id='Anno'     name='Anno'    value='$Anno'><button type='button' onclick=\"document.getElementById('Anno').value='' \" >*</button></TD></TR>
    $html .= filtroFormularioSimple('text', 'Anno', 'Anno', '', 'Año', $params['Anno'], $params['Anno']);
    // <TR><TD>Importe min     </TD><TD><INPUT type='text' id='importe1'     name='importe1'    value='$importe1'><button type='button' onclick=\"document.getElementById('importe1').value='' \" >*</button></TD></TR>
    $html .= filtroFormularioSimple('text', 'importe1', 'importe1', '', 'Importe min.', $params['importe1'], $params['importe1']);
    // <TR><TD>importe máx     </TD><TD><INPUT type='text' id='importe2'     name='importe2'    value='$importe2'><button type='button' onclick=\"document.getElementById('importe2').value='' \" >*</button></TD></TR>
    $html .= filtroFormularioSimple('text', 'importe2', 'importe2', '', 'Importe máx.', $params['importe2'], $params['importe2']);
    // <TR><TD>grupo   </TD><TD><INPUT type='text' id='grupo'   name='grupo'  value='$grupo'><button type='button' onclick=\"document.getElementById('grupo').value='' \" >*</button></TD></TR>
    $html .= filtroFormularioSimple('text', 'grupo', 'grupo', '', 'Grupo', $params['grupo'], $params['grupo']);
    // <TR><TD>observaciones   </TD><TD><INPUT type='text' id='observaciones'   name='observaciones'  value='$observaciones'><button type='button' onclick=\"document.getElementById('observaciones').value='' \" >*</button></TD></TR>
    $html .= filtroFormularioSimple('text', 'observaciones', 'observaciones', '', 'Observaciones', $params['observaciones'], $params['observaciones']);
    // <TR><TD>Metadatos   </TD><TD><INPUT type='text' id='metadatos'   name='metadatos'  value='$metadatos'><button type='button' onclick=\"document.getElementById('metadatos').value='' \" >*</button></TD></TR>
    $html .= filtroFormularioSimple('text', 'metadatos', 'metadatos', '', 'Metadatos', $params['metadatos'], $params['metadatos']);
    // <TR><TD>path archivo </TD><TD><INPUT type='text' id='path_archivo'   name='path_archivo'  value='$path_archivo' title='Filtra por el nombre del archivo PDF original'><button type='button' onclick=\"document.getElementById('path_archivo').value='' \" >*</button></TD></TR>
    $html .= filtroFormularioSimple('text', 'path_archivo', 'path_archivo', '', 'Path Archivo', $params['path_archivo'], $params['path_archivo']);
    // <TR><TD>firmado </TD><TD><INPUT type='text' id='firmado'   name='firmado'  value='$firmado' title='Estado de las Firmas. Filtrar por CONFORME, NO_CONF, PDTE...' ><button type='button' onclick=\"document.getElementById('firmado').value='' \" >*</button></TD></TR>
    $html .= filtroFormularioSimple('text', 'firmado', 'firmado', '', 'Firmado', $params['firmado'], $params['firmado']);
    
    // $valores = array (['id'], ['value'], ['texto']);

    //pdf
    $valores = array();
    $valores[] = array('id' => 'pdf', 'value' => '', 'texto' => 'Todas');
    $valores[] = array('id' => 'pdf1', 'value' => '1', 'texto' => 'Con PDF');
    $valores[] = array('id' => 'pdf0', 'value' => '0', 'texto' => 'Sin PDF');
    $html .= filtroFormularioSimple('select', 'pdf', 'pdf', '', 'PDF', $params['pdf'], $valores);

    //iva
    $valores = array();
    $valores[] = array('id' => 'iva', 'value' => '', 'texto' => 'Todas');
    $valores[] = array('id' => 'iva1', 'value' => '1', 'texto' => 'Con IVA');
    $valores[] = array('id' => 'iva0', 'value' => '0', 'texto' => 'Sin IVA');
    $html .= filtroFormularioSimple('select', 'iva', 'iva', '', 'IVA', $params['iva'], $valores);

    //conciliada
    $valores = array();
    $valores[] = array('id' => 'conciliada', 'value' => '', 'texto' => 'Todas');
    $valores[] = array('id' => 'conciliada1', 'value' => '1', 'texto' => 'Nóminas');
    $valores[] = array('id' => 'conciliada0', 'value' => '0', 'texto' => 'Proveedores');
    $html .= filtroFormularioSimple('select', 'conciliada', 'conciliada', '', 'Tipo proveedor', $params['nomina'], $valores);

    //nomina
    $valores = array();
    $valores[] = array('id' => 'nomina', 'value' => '', 'texto' => 'Todas');
    $valores[] = array('id' => 'nomina1', 'value' => '1', 'texto' => 'Cargadas');
    $valores[] = array('id' => 'nomina0', 'value' => '0', 'texto' => 'No cargadas');
    $html .= filtroFormularioSimple('select', 'nomina', 'nomina', '', 'Conciliada', $params['conciliada'], $valores);

    //pagada
    $valores = array();
    $valores[] = array('id' => 'pagada', 'value' => '', 'texto' => 'Todas');
    $valores[] = array('id' => 'pagada1', 'value' => '1', 'texto' => 'Pagadas');
    $valores[] = array('id' => 'pagada0', 'value' => '0', 'texto' => 'No pagadas');
    $html .= filtroFormularioSimple('select', 'pagada', 'pagada', '', 'Estado pago', $params['pagada'], $valores);

    //cobrada
    $valores = array();
    $valores[] = array('id' => 'cobrada', 'value' => '', 'texto' => 'Todas');
    $valores[] = array('id' => 'cobrada1', 'value' => '1', 'texto' => 'Cobradas');
    $valores[] = array('id' => 'cobrada0', 'value' => '0', 'texto' => 'No cobradas');
    $html .= filtroFormularioSimple('select', 'cobrada', 'cobrada', '', 'Estado cobro', $params['cobrada'], $valores);



    $html .=    '<div class="clearfix"></div>';
    $html .=    '<div class="col-12 m-auto mt-3 pt-3 text-center">';
    $html .=       '<input class="btn btn-link" type="reset" value="Limpiar filtros"/> ';
    $html .=       '<input type="submit" class="btn btn-success noprint" value="Actualizar" id="submit" name="submit">';
    $html .=    '</div>';
    $html .= '</div>';

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
    $html .= '  <div class="clearfix"></div>'
            . '<hr>';

    
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
   $html .= '  <div class="clearfix"></div>'
            . '<hr>';

    
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
   $html .= '  <div class="clearfix"></div>'
            . '<hr>';

    
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
   $html .= '  <div class="clearfix"></div>'
            . '<hr>';

    
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
            $html .= "<button class='cc_btnt $activo' title='{$v[1]}' onclick=\"getElementById('agrupar').value = '$k' ; document.getElementById('form1').submit();\"> ";
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
    // $html .= '  <strong>Formato: </strong>';
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
