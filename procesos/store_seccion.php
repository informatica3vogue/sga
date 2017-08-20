<?php
@session_start();

include("../sql/class.managerDB.php");
include("../sql/class.data.php");
$data = new data();

$params = $_POST;

$params["id_dependencia"] = (isset($params["id_dependencia"])) ? $params["id_dependencia"] : $_SESSION["id_dependencia"];

$sql = "SELECT id_seccion, seccion FROM seccion WHERE id_dependencia=:id_dependencia ORDER BY seccion ASC";
$param_list = array("id_dependencia");
$response = $data->query($sql, $params, $param_list);

echo json_encode($response);
?>