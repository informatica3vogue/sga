<?php

@session_start();
include("../../sql/class.data.php");
$data = new data();

$params = $_GET;

if ($_SESSION["id_rol"] == 5) {
	$sql = "SELECT id_rol, rol FROM rol ORDER BY rol ASC";
}else{
	$sql = "SELECT id_rol, rol FROM rol WHERE id_rol <> 5 AND id_rol <> 2 ORDER BY rol ASC";
}
$response = $data->query($sql);

echo json_encode($response);
?>
