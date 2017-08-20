<?php 
if ($_SESSION["id_rol"] == 11) {
    //paginas para modulo de actividades
    $conf['actividades'] = array(
        'archivo' => 'buzon_mis_actividades.php',
        'layout' => LAYOUT_DESKTOP
    );
    $conf['actividad'] = array(
        'archivo' => 'buzon_actividades_generales_sup.php',
        'layout' => LAYOUT_DESKTOP
    );
    $conf['iactividad'] = array(
        'archivo' => 'ingreso_actividades_sup.php',
        'layout' => LAYOUT_DESKTOP
    );
    $conf['mactividad'] = array(
        'archivo' => 'modificar_actividades_sup.php',
        'layout' => LAYOUT_DESKTOP
    );
    $conf['repactividad'] = array(
        'archivo' => 'actividad_panel_supervisor.php',
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
    $conf['insumos'] = array(
        'archivo' => 'ingresar_solicitud_insumos.php',
        'layout' => LAYOUT_DESKTOP
    );
    $conf['vinsumos'] = array(
        'archivo' => 'vista_solicitudes_insumos.php',
        'layout' => LAYOUT_DESKTOP
    );
    $conf['cinsumos'] = array(
        'archivo' => 'ingresar_articulos_insumos.php',
        'layout' => LAYOUT_DESKTOP
    );
    $conf['articulo'] = array(
        'archivo' => 'vista_bodega_insumos.php',
        'layout' => LAYOUT_DESKTOP
    );
    $conf['descargos_articulo'] = array(
        'archivo' => 'descargo_articulos_insumos.php',
        'layout' => LAYOUT_DESKTOP
    );
    $conf['msolicitud'] = array(
        'archivo' => 'modificar_solicitud.php',
        'layout' => LAYOUT_DESKTOP
    );
    $conf['repinsumo'] = array(
        'archivo' => 'insumos_panel_reportes.php',
        'layout' => LAYOUT_DESKTOP
    );
}
?>