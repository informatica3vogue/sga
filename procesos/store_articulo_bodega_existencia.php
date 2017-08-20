<?php
@session_start();

include("../sql/class.managerDB.php");
include("../sql/class.data.php");
$data = new data();

$params = $_GET;

$sql = "SELECT articulo.id_articulo, CONCAT(articulo.articulo,' /', marca.marca) AS articulo FROM articulo INNER JOIN marca ON articulo.id_marca = marca.id_marca WHERE articulo.id_dependencia= :id_dependencia AND articulo.existencia > 0 AND articulo.id_categoria = 2 ORDER BY articulo ASC";
$response = $data->query($sql, array("id_dependencia" => $_SESSION["id_dependencia"]));

echo json_encode($response);
?>