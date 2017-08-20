<?php

@session_start();
include("../sql/class.managerDB.php");
include("../sql/class.data.php");
$data = new data();

$params = $_GET;
$sql = "SELECT DISTINCT e.id_empleado, CONCAT(e.nombre, ' ', e.apellido) AS nombre_completo FROM empleado e INNER JOIN empleado_seccion es ON e.id_empleado = es.id_empleado INNER JOIN seccion secc ON es.id_seccion=secc.id_seccion WHERE secc.id_dependencia=:id_dependencia AND es.estado='Activo' ORDER BY nombre_completo ASC";
$response = $data->query($sql, array("id_dependencia" => $_SESSION["id_dependencia"]));

echo json_encode($response);
?>
