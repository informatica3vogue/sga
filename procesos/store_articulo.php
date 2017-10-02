<?php

@session_start();
include("../sql/class.managerDB.php");
include("../sql/class.data.php");
$data = new data();
$array = array();

$params = $_GET;

$sql = "SELECT articulo.id_dependencia, articulo.id_categoria, articulo.id_articulo, articulo.articulo FROM articulo INNER JOIN marca ON articulo.id_marca = marca.id_marca WHERE articulo.id_dependencia= :id_dependencia AND articulo.id_categoria = 1 ORDER BY articulo ASC";
$response = $data->query($sql, array("id_dependencia" =>  $_SESSION["id_dependencia"]));

echo json_encode($response);
?>