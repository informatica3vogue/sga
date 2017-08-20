<?php

@session_start();
include("../sql/class.managerDB.php");
include("../sql/class.data.php");
$data = new data();

$params = $_POST;
$sql = "SELECT art.articulo, marca.marca, dab.cantidad FROM descargo_articulo_bodega dab INNER JOIN articulo art ON dab.id_articulo=art.id_articulo INNER JOIN marca marca ON art.id_marca=marca.id_marca WHERE dab.id_descargo_bodega=:id_descargo_bodega ORDER BY articulo DESC";
$param_list = array("id_descargo_bodega");
$response = $data->query($sql, $params, $param_list);

echo json_encode($response);
?>
<?php 
/*

**Archivos de interfaz que alimenta**
- comp_descargos_bod.php

*/
?>
