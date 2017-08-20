<?php 
if ($_SESSION["id_rol"] == 1) {
    //paginas para modulo de actividades
    $conf['actividades'] = array(
        'archivo' => 'buzon_mis_actividades.php',
        'layout' => LAYOUT_DESKTOP
    );
    $conf['actividad'] = array(
        'archivo' => 'buzon_actividades_generales_admin.php',
        'layout' => LAYOUT_DESKTOP
    );
    $conf['iactividad'] = array(
        'archivo' => 'ingreso_actividades_admin.php',
        'layout' => LAYOUT_DESKTOP
    );
    $conf['repactividad'] = array(
        'archivo' => 'actividad_panel_admin.php',
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
        'archivo' => 'vista_memorandum.php',
        'layout' => LAYOUT_DESKTOP
    );
    $conf['imemo'] = array(
        'archivo' => 'ingresar_memorandum.php',
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
    $conf['repinsumo'] = array(
        'archivo' => 'insumos_panel_reportes.php',
        'layout' => LAYOUT_DESKTOP
    );
    //paginas para modulo de usuarios
    $conf['usuario'] = array(
        'archivo' => 'vista_usuarios.php',
        'layout' => LAYOUT_DESKTOP
    );
    $conf['iusuario'] = array(
        'archivo' => 'ingresar_usuario_admin.php',
        'layout' => LAYOUT_DESKTOP
    );
    $conf['musuarios'] = array(
        'archivo' => 'modificar_usuario_admin.php',
        'layout' => LAYOUT_DESKTOP
    );
    //paginas para modulo de secciones
    $conf['dependencia'] = array(
        'archivo' => 'vista_secciones_admin.php',
        'layout' => LAYOUT_DESKTOP
    );
    $conf['csystemabr'] = array(
        'archivo' => 'ingresar_secciones_super_usuario.php',
        'layout' => LAYOUT_DESKTOP
    );
}
?>