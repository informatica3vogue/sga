<?php 
// llenado de combo usuario mediante id_seccion, llamado desde: ingreso_actividades_admin                      
@session_start();
include("../../sql/class.data.php");
$data = new data();

$params = $_POST;

if ($_SESSION['id_rol']==5 OR $_SESSION["id_seccion"]==$params["id_seccion"] OR $_SESSION["id_seccion"]!=$params["id_seccion"] AND $_SESSION['id_rol']==1) {
    $sql = "SELECT usuario.id_usuario, CONCAT(INITCAP(LOWER(empleado.nombre)),' ', INITCAP(LOWER(empleado.apellido))) AS nombre_completo FROM seccion INNER JOIN empleado_seccion ON seccion.id_seccion=empleado_seccion.id_seccion INNER JOIN empleado ON empleado.id_empleado=empleado_seccion.id_empleado INNER JOIN usuario ON empleado.id_empleado=usuario.id_empleado WHERE empleado_seccion.id_seccion = :id_seccion ORDER BY nombre_completo ASC";
}else{
    $sql = "SELECT usuario.id_usuario, CONCAT(INITCAP(LOWER(empleado.nombre)),' ', INITCAP(LOWER(empleado.apellido))) AS nombre_completo FROM seccion INNER JOIN empleado_seccion ON seccion.id_seccion=empleado_seccion.id_seccion INNER JOIN empleado ON empleado.id_empleado=empleado_seccion.id_empleado INNER JOIN usuario ON empleado.id_empleado=usuario.id_empleado WHERE empleado_seccion.id_seccion = :id_seccion AND usuario.id_rol = 1 OR empleado_seccion.id_seccion = :id_seccion AND usuario.id_rol = 4 OR empleado_seccion.id_seccion = :id_seccion AND usuario.id_rol = 6 OR empleado_seccion.id_seccion = :id_seccion AND usuario.id_rol = 10 OR empleado_seccion.id_seccion = :id_seccion AND usuario.id_rol = 11 ORDER BY nombre_completo ASC";
}
$param_list = array("id_seccion");
$response = $data->query($sql, $params, $param_list);

echo json_encode($response);
?>