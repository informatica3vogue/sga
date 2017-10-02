<?php
ob_start();
session_start();
include("../sql/class.data.php");
$data = new data();
$params = $_POST;
//print_r($params);
$items  = array();
$encontrado = false;
$sql="SELECT id_detalle_solicitud, id_solicitud_articulo, id_articulo FROM detalle_solicitud WHERE id_articulo = :id_articulo AND id_solicitud_articulo = :id_solicitud";
$params_list = array("id_articulo", "id_solicitud");
$respuesta = $data->query($sql, $params, $params_list);
foreach($_SESSION['solicitud']["items"] as $detalle){
    if($detalle['id_articulo']==$_POST['id_articulo']){
        $encontrado=true;
        break;
    }
}
if($encontrado==true){
    foreach($_SESSION['solicitud']["items"] as $detalle){
        if($detalle['id_articulo']==$_POST['id_articulo']){
            $detalle['cantidad']=$_POST['cantidad'];
        }
        $items[]=$detalle;
    }   
    $_SESSION['solicitud']["items"]=$items;
}else{
    $items=$_SESSION['solicitud']["items"];
    if ($respuesta['total'] > 0) {
        $params["detalle"] = $respuesta['items'][0]['id_detalle_solicitud'];
        array_push($items, array("id_detalle_solicitud"=>$params["detalle"], "id_solicitud_articulo"=>$params["id_solicitud"],"articulo"=>$params["articulo"],"cantidad"=>$params["cantidad"],"id_articulo"=>$params["id_articulo"]));
    } else {
        array_push($items, array("id_detalle_solicitud"=>"", "id_solicitud_articulo"=>$params["id_solicitud"],"articulo"=>$params["articulo"],"cantidad"=>$params["cantidad"],"id_articulo"=>$params["id_articulo"]));
    }
}
$_SESSION['solicitud']=array("success"=>true, "items"=>$items, "total"=>count($items));
echo json_encode($_SESSION['solicitud']);
?>