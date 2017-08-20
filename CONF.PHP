<?php
$conf=array();
define('MODULO_DEFECTO', 'login');
define('LAYOUT_DEFECTO', 'login.php');
define('LAYOUT_DESKTOP', 'desktop.php');
define('MODULO_PATH', realpath('paginas'));
define('LAYOUT_PATH', realpath('plantillas'));

if (isset($_SESSION['actividades'])) {
    // start: Modulos por rol de usuario
    include_once('procesos/modulos/modulos_administrador.php');
    include_once('procesos/modulos/modulos_digitador.php');
    include_once('procesos/modulos/modulos_supervisor.php');
    include_once('procesos/modulos/modulos_super_usuario.php');
    include_once('procesos/modulos/modulos_supervisor_actividades.php');
    include_once('procesos/modulos/modulos_supervisor_insumos.php');
    include_once('procesos/modulos/modulos_supervisor_permisos.php');
    include_once('procesos/modulos/modulos_supervisor_bodega.php');
    include_once('procesos/modulos/modulos_supervisor_actividades_permisos.php');
    include_once('procesos/modulos/modulos_supervisor_actividades_insumos.php');
    include_once('procesos/modulos/modulos_supervisor_insumos_permisos.php');

    // end: Modulos por nivel de usuario
    // start: Modulos por defecto del sistema
    $conf['inicio'] = array(
        'archivo' => 'inicio.php',
        'layout' => LAYOUT_DESKTOP
    );
    $conf['logout'] = array(
        'archivo' => 'logout.php',
        'layout' => LAYOUT_DESKTOP
    );
    $conf['error'] = array(
        'archivo' => '404.php',
        'layout' => LAYOUT_DESKTOP
    );
    $conf['contrasena'] = array(
        'archivo' => 'contrasena.php',
        'layout' => LAYOUT_DESKTOP
    );
    $conf['repositorio'] = array(
        'archivo' => 'vista_repositorio.php',
        'layout' => LAYOUT_DESKTOP
    );
    $conf['irepositorio'] = array(
        'archivo' => 'ingresar_repositorio.php',
        'layout' => LAYOUT_DESKTOP
    );
    // end: Modulos por defecto del sistema
} else {
    // start: Modulos de inicio de sesion
    $conf['login'] = array(
        'archivo' => 'login.php',
        'layout' => LAYOUT_DEFECTO
    );
    // end: Modulos de inicio de sesion
}
?>