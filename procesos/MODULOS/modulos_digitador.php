<?php 
if ($_SESSION["id_rol"] == 3) {
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
}
?>