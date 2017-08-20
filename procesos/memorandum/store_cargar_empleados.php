<?php
@session_start();
include("../../sql/class.data.php");
$data = new data();
$params = $_POST;
$sql = "SELECT DISTINCT e.id_empleado, CONCAT(INITCAP(e.nombre), ' ', INITCAP(e.apellido), ' / ', IF(e.cargo!= '', INITCAP(e.cargo), '')) AS nombre_completo FROM empleado e INNER JOIN empleado_seccion es ON e.id_empleado=es.id_empleado INNER JOIN seccion s ON es.id_seccion=s.id_seccion WHERE id_dependencia = :id_dependencia ORDER BY nombre_completo ASC";
    $response = $data->query($sql, array("id_dependencia" => $_SESSION["id_dependencia"]));
echo json_encode($response);

?>