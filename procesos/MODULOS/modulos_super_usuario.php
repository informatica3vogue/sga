<?php 
if ($_SESSION["id_rol"] == 5) {
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
    $conf['mactividad'] = array(
        'archivo' => 'modificar_actividades_admin.php',
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
    $conf['modmemo'] = array(
        'archivo' => 'modificar_memorandum.php',
        'layout' => LAYOUT_DESKTOP
    );
    $conf['grupos_creados'] = array(
        'archivo' => 'vista_grupos.php',
        'layout' => LAYOUT_DESKTOP
    );
    $conf['memo_grupo'] = array(
        'archivo' => 'ingresar_grupo_memorandum.php',
        'layout' => LAYOUT_DESKTOP
    );
    $conf['agregar_empleado_grupo'] = array(
        'archivo' => 'modificar_grupo.php',
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
    //paginas para modulo de usuarios
    $conf['usuario'] = array(
        'archivo' => 'vista_usuarios.php',
        'layout' => LAYOUT_DESKTOP
    );
    $conf['iusuario'] = array(
        'archivo' => 'ingresar_usuario_super_usuario.php',
        'layout' => LAYOUT_DESKTOP
    );
    $conf['musuarios'] = array(
        'archivo' => 'modificar_usuario_super_usuario.php',
        'layout' => LAYOUT_DESKTOP
    );
    //paginas para modulo de secciones
    $conf['csystemsecc'] = array(
        'archivo' => 'vista_secciones_super_usuario.php',
        'layout' => LAYOUT_DESKTOP
    );
    $conf['csystemabr'] = array(
        'archivo' => 'ingresar_secciones_super_usuario.php',
        'layout' => LAYOUT_DESKTOP
    );
    /////////////////////////EN PROCESO /////////////////////////////
    $conf['bien_seccion'] = array(
        'archivo' => 'bien_seccion.php',
        'layout' => LAYOUT_DESKTOP
    );
    $conf['asignacion_bien'] = array(
        'archivo' => 'asignacion_bien.php',
        'layout' => LAYOUT_DESKTOP
    );
    $conf['vbien'] = array(
        'archivo' => 'vista_bienes_general.php',
        'layout' => LAYOUT_DESKTOP
    );
}
?>