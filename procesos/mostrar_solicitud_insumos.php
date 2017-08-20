<?php
include("../sql/class.data.php");
session_start();
$data = new data();
$params=$_POST;
if (!isset($_SESSION['detalle_solicitud_articulo'])) {
    $_SESSION['detalle_solicitud_articulo']=array();
}
$sql = "SELECT ds.id_detalle_solicitud, s.id_solicitud_articulo, a.articulo, ds.cantidad, a.id_articulo FROM solicitud_articulo s INNER JOIN detalle_solicitud ds on s.id_solicitud_articulo=ds.id_solicitud_articulo INNER JOIN articulo a ON ds.id_articulo = a.id_articulo WHERE s.id_solicitud_articulo = :id_solicitud";
$params_list = array("id_solicitud");
$response = $data->query($sql, $params, $params_list);
if (isset($_SESSION['detalle_solicitud_articulo'])){
    $rowCount=intval($response['total']);
    foreach ($_SESSION['detalle_solicitud_articulo'] as $row) {
            $result=$data->query('select "" id_solicitud_articulo, id_articulo, articulo, :cantidad cantidad from articulo where id_articulo=:id_articulo', array('cantidad'=>$row['cantidad'], 'id_articulo'=>$row['id_articulo']));
            $response['items'][]=$result['items'][0];
            $rowCount++;
    }
    $response['total']=$rowCount;
}
$_SESSION["solicitud"]=$response;
echo json_encode($response);
?>