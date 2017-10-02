<?php

@session_start();
include("../../sql/class.managerDB.php");
include("../../sql/class.data.php");
$data = new data();
$array = array();
$total = 0;

$sql = "SELECT id_dependencia, dependencia FROM bddependencias.dependencia ORDER BY dependencia ASC";
$response = $data->query($sql);
if ($response["total"] > 0) {
    foreach($response['items'] as $datos){
        array_push($array, array("id_dependencia" => $datos['id_dependencia'], "dependencia" => $datos['dependencia']));
    }
    $total = $response["total"];
}

$sql = "SELECT id_dependencia, dependencia FROM dependencia WHERE tipo=2 ORDER BY dependencia ASC";
$result = $data->query($sql);
if ($result["total"] > 0) {
    foreach($result['items'] as $datos){
        array_push($array, array("id_dependencia" => $datos['id_dependencia'], "dependencia" => $datos['dependencia']));
    }
    $total = ($total + $result["total"]);
}

$response = array("success" => true, "items" => $array, "total" => $total);
echo json_encode($response);
?>