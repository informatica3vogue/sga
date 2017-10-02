<?php                       

@session_start();
include("../sql/class.managerDB.php");
include("../sql/class.data.php");
$data = new data();
$array = array();

$params = $_GET;
$sql = "SELECT CONCAT(e.nombre, ' ', e.apellido, ' / ', e.cargo) AS nombre FROM empleado e INNER JOIN empleado_seccion es ON e.id_empleado=es.id_empleado INNER JOIN seccion s ON es.id_seccion=s.id_seccion WHERE id_dependencia = :id_dependencia";
$response = $data->query($sql, array("id_dependencia" => $_SESSION["id_dependencia"]));
foreach($response['items'] as $datos){
    $selected = ($params["nombre"] == $datos['nombre']) ? true : false;
    array_push($array, array("value" => $datos['nombre'], "label" => $datos['nombre'], "selected"=>$selected));
}

echo json_encode($array);