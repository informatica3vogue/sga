<?php 
if ($_SESSION["id_rol"] == 10) {
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
    //paginas para modulo de permisos
    $conf['vpermisos'] = array(
        'archivo' => 'vista_permisos.php',
        'layout' => LAYOUT_DESKTOP
    );
    $conf['permisos'] = array(
        'archivo' => 'vista_empleados.php',
        'layout' => LAYOUT_DESKTOP
    );
    $conf['agregarempleado'] = array(
        'archivo' => 'ingresar_empleados.php',
        'layout' => LAYOUT_DESKTOP
    );
    $conf['empleados'] = array(
        'archivo' => 'ingresar_permisos.php',
        'layout' => LAYOUT_DESKTOP
    );
    $conf['reportes_permiso'] = array(
        'archivo' => 'permisos_panel_admin.php',
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