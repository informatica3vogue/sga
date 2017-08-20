<?php
@session_start();
include("../../sql/class.data.php");
$data = new data();
$params = $_POST;
$sql = "SELECT DISTINCT e.id_empleado, CONCAT(INITCAP(e.nombre), ' ', INITCAP(e.apellido)) AS nombre_completo FROM empleado e INNER JOIN empleado_seccion es ON e.id_empleado=es.id_empleado WHERE es.id_seccion = :id_seccion AND es.estado='Activo' ORDER BY nombre_completo ASC";
    $response = $data->query($sql, array("id_seccion" => $params["id_seccion"]));
echo json_encode($response);

?>