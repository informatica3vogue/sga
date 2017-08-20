<?php

@session_start();
include("../sql/class.managerDB.php");
include("../sql/class.data.php");
$data = new data();
$array = array();

$params = $_GET;
if ($params["id_categoria"] != false) {
    $sql = "SELECT id_categoria, categoria FROM categoria ORDER BY categoria ASC";
    $response = $data->query($sql);
    foreach($response['items'] as $datos){
        $selected = ($params["categoria"] == $datos["categoria"]) ? "selected":" ";
        array_push($array, array("id" => $datos['id_categoria'], "literal" => $datos['categoria'], "selected" => $selected));
    }
}else{
    $sql = "SELECT id_categoria, categoria FROM categoria ORDER BY categoria ASC";
    $response = $data->query($sql);
    foreach($response['items'] as $datos){
        array_push($array, array("id" => $datos['id_categoria'], "literal" => $datos['categoria']));
    }
}
echo json_encode($array);
?>