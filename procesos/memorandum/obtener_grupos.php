<?php
@session_start();
include("../../sql/class.data.php");
$data = new data();

$sql = "SELECT id_grupo, grupo FROM grupo WHERE id_usuario_propietario=:id_usuario";
$response = $data->query($sql, array("id_usuario" => $_SESSION["id_usuario"]));

echo json_encode($response);
?>