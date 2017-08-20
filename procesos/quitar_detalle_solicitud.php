<?php  
ob_start();
session_start();
$params = $_POST;

$nuevo=array();
foreach ($_SESSION['solicitud']['items'] as $articulo) {
    if ($articulo['id_articulo'] != $params['id_articulo']) {
        array_push($nuevo, array("id_detalle_solicitud"=>$articulo["id_detalle_solicitud"], "id_solicitud_articulo"=>$articulo["id_solicitud_articulo"],"articulo"=>$articulo["articulo"],"cantidad"=>$articulo["cantidad"],"id_articulo"=>$articulo["id_articulo"]));
    }
}
$_SESSION['solicitud']=array("success"=>true,"items" => $nuevo, "total"=> count($nuevo));
echo json_encode($_SESSION['solicitud']);
?>