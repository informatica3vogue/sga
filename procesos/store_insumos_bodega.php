<?php

@session_start();
include("../sql/class.managerDB.php");
include("../sql/class.data.php");
$data = new data();
$array = array();

$params = $_GET;
$params["id_dependencia"] = $_SESSION["id_dependencia"];
if ($params["id_articulo"] != false) {
    $sql = "SELECT id_articulo, articulo, existencia FROM articulo WHERE id_categoria = 2 AND existencia > 0 AND id_dependencia=:id_dependencia ORDER BY articulo ASC";
    $param_list = array("id_dependencia");
$response = $data->query($sql, $params, $param_list);
    foreach($response['items'] as $datos){
        $selected = ($params["articulo"] == $datos["articulo"]) ? "selected":" ";
        $selected2 = ($params["existencia"] == $datos["existencia"]) ? "selected":" ";
        array_push($array, array("id" => $datos['id_articulo'], "literal" => $datos['articulo'], "selected" => $selected, "existencia" => $datos['existencia'], "selected" => $selected2));
    }
}else{
    $sql = "SELECT id_articulo, articulo, existencia FROM articulo WHERE id_categoria = 2 AND existencia > 0 AND id_dependencia=:id_dependencia ORDER BY articulo ASC";
    $param_list = array("id_dependencia");
$response = $data->query($sql, $params, $param_list);
    foreach($response['items'] as $datos){
        array_push($array, array("id" => $datos['id_articulo'], "literal" => $datos['articulo'], "existencia" => $datos['existencia']));
    }
}
echo json_encode($array);
?>