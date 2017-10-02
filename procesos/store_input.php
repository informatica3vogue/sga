<?php

@session_start();
include("../sql/class.managerDB.php");
include("../sql/class.data.php");
$data = new data();
$array = array();

$params = $_GET;
if ($params["id_articulo"] != false) {
    $sql = "SELECT existencia FROM articulo WHERE id_articulo = :id_articulo";
    $response = $data->query($sql);
    foreach($response['items'] as $datos){
        $selected = ($params["existencia"] == $datos["existencia"]) ? "selected":" ";
        array_push($array, array("id" => $datos['existencia'], "literal" => $datos['existencia'], "selected" => $selected));
    }
}else{
    $sql = "SELECT existencia FROM articulo WHERE id_articulo = :id_articulo";
    $response = $data->query($sql);
    foreach($response['items'] as $datos){
        array_push($array, array($datos['existencia'], "selected" => $selected));
    }
}
echo json_encode($array);
?>