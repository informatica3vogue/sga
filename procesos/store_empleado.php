<?php

@session_start();
include("../sql/class.managerDB.php");
include("../sql/class.data.php");
$data = new data();

$array = array();

$params = $_GET;
$sql = "SELECT e.id_empleado, CONCAT(e.nombre, ' ', e.apellido, ' / ', e.cargo) AS nombre_completo FROM empleado e INNER JOIN empleado_seccion es ON e.id_empleado = es.id_empleado WHERE es.id_seccion=:id_seccion ORDER BY nombre_completo ASC";
$response = $data->query($sql, array("id_seccion" => $_SESSION["id_seccion"]));
array_push($array, array("value" => "", "label" => "Seleccione un empleado"));
foreach($response['items'] as $datos){
	$selected = ($params["id_empleado"] == $datos['id_empleado']) ? true : false;
    array_push($array, array("value" => $datos['id_empleado'], "label" => $datos['nombre_completo'], "selected" => $selected));
}
echo json_encode($array);
?>
