<?php 
if ($_SESSION["id_rol"] == 9) {
    //paginas para modulo de actividades
    $conf['actividades'] = array(
        'archivo' => 'buzon_mis_actividades.php',
        'layout' => LAYOUT_DESKTOP
    );
    //paginas para modulo de memorandum
    $conf['memorandum'] = array(
        'archivo' => 'vista_memorandum_digitador.php',
        'layout' => LAYOUT_DESKTOP
    );
    $conf['memodig'] = array(
        'archivo' => 'ingresar_memorandum_digitador.php',
        'layout' => LAYOUT_DESKTOP
    );
    $conf['modmemo'] = array(
        'archivo' => 'modificar_memorandum_digitador.php',
        'layout' => LAYOUT_DESKTOP
    );
    //paginas para modulo de insumos
    $conf['insumos_dig'] = array(
        'archivo' => 'ingresar_solicitud_insumos_digitador.php',
        'layout' => LAYOUT_DESKTOP
    );
    $conf['compinsumosdig'] = array(
        'archivo' => 'vista_solicitudes_digitador.php',
        'layout' => LAYOUT_DESKTOP
    );
    //paginas para modulo de bodega
    $conf['compdescargos_bod'] = array(
        'archivo' => 'vista_cargos_descargos_bodega.php',
        'layout' => LAYOUT_DESKTOP
    );
    $conf['articulo_bodega'] = array(
        'archivo' => 'ingresar_articulos_bodega.php',
        'layout' => LAYOUT_DESKTOP
    );
    $conf['cbodega'] = array(
        'archivo' => 'vista_bodega_bodega.php',
        'layout' => LAYOUT_DESKTOP
    );
    $conf['ibodega'] = array(
        'archivo' => 'descargo_articulos_bodega.php',
        'layout' => LAYOUT_DESKTOP
    );
    $conf['repbodegas'] = array(
        'archivo' => 'bodega_panel_reportes.php',
        'layout' => LAYOUT_DESKTOP
    );
}
?>