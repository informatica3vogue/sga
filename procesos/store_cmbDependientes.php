<?php                       
@session_start();
include("../sql/class.managerDB.php");
include("../sql/class.data.php");
$data = new data();
$array = array();

$params = $_GET;
if ($_SESSION["id_seccion"] == $params["id_seccion"]) {
	$sql = "SELECT id_usuario, CONCAT(nombre, ' ', apellido, ' / ', cargo) AS nombre_completo FROM usuario WHERE id_seccion = :id_seccion ORDER BY nombre_completo ASC";
	$param_list = array("id_seccion");
	$response = $data->query($sql, $params, $param_list);
	foreach($response['items'] as $datos){
	    array_push($array, array("id" => $datos['id_usuario'], "literal" => $datos['nombre_completo']));
	}
}else{
	$sql = "SELECT id_usuario, CONCAT(nombre, ' ', apellido, ' / ', cargo) AS nombre_completo FROM usuario WHERE id_seccion = :id_seccion AND id_rol = 4 ORDER BY nombre_completo ASC";
	$param_list = array("id_seccion");
	$response = $data->query($sql, $params, $param_list);
	foreach($response['items'] as $datos){
	    array_push($array, array("id" => $datos['id_usuario'], "literal" => $datos['nombre_completo']));
	}
}

echo json_encode($array);
?>