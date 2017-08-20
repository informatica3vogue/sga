<?php 
// llenado de combo usuario mediante id_seccion, llamado desde: modificar_actividades                      
@session_start();
include("../../sql/class.data.php");
$data = new data();
$array = array();

$params = $_POST;

$sql = "SELECT usuario.id_usuario, CONCAT(INITCAP(empleado.nombre), ' ', INITCAP(empleado.apellido)) AS nombre_completo FROM seccion INNER JOIN empleado_seccion ON seccion.id_seccion=empleado_seccion.id_seccion INNER JOIN empleado ON empleado.id_empleado=empleado_seccion.id_empleado INNER JOIN usuario ON empleado.id_empleado=usuario.id_empleado WHERE empleado_seccion.id_seccion = :id_seccion ORDER BY nombre_completo ASC";
$response = $data->query($sql, array('id_seccion'=>$params['id_seccion']));
if ($response["total"] > 0) {
    foreach ($response["items"] as $datos) {
        $sql = "SELECT id_usuario FROM asignacion WHERE id_usuario = :id_usuario AND id_actividad = :id_actividad AND estado = 1";
        $response_asignados = $data->query($sql, array('id_usuario'=>$datos['id_usuario'], 'id_actividad'=>$params['id_actividad']));

        $selected = ( $response_asignados["total"] > 0 ) ? "selected" : "";
        array_push($array, array("id_usuario" => $datos['id_usuario'], "nombre_completo" => $datos['nombre_completo'], "selected" => $selected));
    }
    $response = array('success' => true, 'items' => $array, 'total' => $response["total"]);
}else{
    $response = array('success' => false, 'items' => $array, 'total' => 0);
}

echo json_encode($response);
?>