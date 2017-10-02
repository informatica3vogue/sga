<?php
@session_start();

include("../../sql/class.data.php");
$data = new data();

$array = array();
$params = $_POST;
$sql = "SELECT DISTINCT e.id_empleado, CONCAT(e.nombre, ' ', e.apellido) AS nombre_completo FROM empleado e INNER JOIN empleado_seccion es ON e.id_empleado = es.id_empleado INNER JOIN seccion secc ON es.id_seccion=secc.id_seccion WHERE secc.id_dependencia=:id_dependencia ORDER BY nombre_completo ASC";
	   $response = $data->query($sql, array("id_dependencia" => $_SESSION["id_dependencia"]));

	   if ($response["total"] > 0) {
		foreach($response['items'] as $datos){ 
		    $sql = "SELECT id_empleado FROM memo_interno WHERE id_memorandum=:id_memorandum AND id_empleado=:id_empleado";
		    $response_asignados = $data->query($sql, array("id_empleado" => $datos["id_empleado"], "id_memorandum" => $params["id_memorandum"])); 

		     $selected = ( $response_asignados["total"] > 0 ) ? "selected" : "";
        array_push($array, array("id_empleado" => $datos['id_empleado'], "nombre_completo" => $datos['nombre_completo'], "selected" => $selected));
   }
    $response = array('success' => true, 'items' => $array, 'total' => $response["total"]);
}else{
    $response = array('success' => false, 'items' => $array, 'total' => 0);
}
echo json_encode($response);
?>