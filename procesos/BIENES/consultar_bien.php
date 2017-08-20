<?php
@session_start();
include("../../sql/class.data.php");
$data = new data();

$params = $_POST;
$cod = substr($params["caf"], 0, 2);
$correlativo = substr($params["caf"], 2, strlen($params["caf"])-2);

$sql = "SELECT MARCA, MODELO, SERIE, DATEDIFF('d', DATE(),FECHA_GARANTIA) AS fecha, IIF(fecha > 0, 'Si', 'No') AS GARANTIA, DESCRIP FROM CONSOL WHERE COD = :cod AND CORRELATIVO=:correlativo";
$param_caf = array('cod'=>$cod,'correlativo'=>$correlativo);
$response_bien = $data->query($sql, $param_caf, array(), false, false, 'access');
if (count($response_bien["items"]) > 0) {
    $descripcion = ($response_bien['items'][0]['DESCRIP'] != "") ? $response_bien['items'][0]['DESCRIP'] : 'No disponible';
    $marca = ($response_bien['items'][0]['MARCA'] != "") ? $response_bien['items'][0]['MARCA'] : 'No disponible';
    $modelo = ($response_bien['items'][0]['MODELO'] != "") ? $response_bien['items'][0]['MODELO'] : 'No disponible';
    $serie = ($response_bien['items'][0]['SERIE'] != "") ? $response_bien['items'][0]['SERIE'] : 'No disponible';
    $response = array('success' => true, 'descripcion'=>'Descripcion: '.$descripcion.', Marca: '.$marca.', Modelo: '.$modelo.', N° de serie: '.$serie);
}else{
    $response = array('success' => false, 'error'=>'No se encontro bien');
}

echo json_encode($response);
?>