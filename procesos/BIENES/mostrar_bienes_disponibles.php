<?php
@session_start();
include("../../sql/class.data.php");
$data = new data();

$params = $_POST;

$sql = "SELECT * FROM bien INNER JOIN seccion_bien ON bien.id_bien=seccion_bien.id_bien WHERE seccion_bien.id_seccion=:id_seccion AND  seccion_bien.estado=2";
$param_list = array('id_seccion');
$response = $data->query($sql, $params, $param_list);

echo json_encode($response);
?>