<?php  
ob_start();
@session_start();
include("../sql/class.data.php");
$data = new data();
$params = $_POST;

$sql = "SELECT id_articulo, cantidad FROM detalle_solicitud WHERE id_solicitud_articulo = :id_solicitud";
$parametros = array("id_solicitud");
$respuesta = $data->query($sql, $params, $parametros);

foreach ($respuesta['items'] as $consulta) {
    $encontrado = false;
    $id_articulo = 0;
    $cantidad = 0;
    foreach ($_SESSION['solicitud']['items'] as $detalle) {
        if ($consulta['id_articulo'] == $detalle["id_articulo"]) {
            $encontrado = true;
            $id_articulo = $detalle["id_articulo"];
            $cantidad = $detalle["cantidad"];
        }
    }
    if ($encontrado == true) {
        if ($consulta['cantidad'] != $cantidad) {
            $sql_update = "UPDATE detalle_solicitud SET cantidad = :cantidad WHERE id_solicitud_articulo = :id_solicitud AND id_articulo = :id_articulo";
            $params_update = array("id_solicitud"=>$params['id_solicitud'], "cantidad"=>$cantidad, "id_articulo"=>$consulta['id_articulo']);
            $response_update = $data->query($sql_update, $params_update, array(), true);
        }
    } else {
        $sql_delete = "DELETE FROM detalle_solicitud WHERE id_solicitud_articulo = :id_solicitud AND id_articulo = :id_articulo";
        $params_delete = array("id_solicitud"=>$params['id_solicitud'], "id_articulo"=>$consulta['id_articulo']);
        $response_delete = $data->query($sql_delete, $params_delete, array(), true);
    }
}

foreach ($_SESSION['solicitud']['items'] as $sesion) {
    $sql2 = "SELECT id_articulo FROM detalle_solicitud WHERE id_solicitud_articulo = :id_solicitud AND id_articulo = :id_articulo";
    $respuesta_insumos = $data->query($sql2, array("id_solicitud"=>$params['id_solicitud'], "id_articulo"=>$sesion["id_articulo"]));
    if ($respuesta_insumos['total'] == 0) {
        $sql_insert = "INSERT INTO detalle_solicitud(cantidad, id_articulo, id_solicitud_articulo) VALUES(:cantidad, :id_articulo, :id_solicitud)";
        $params_insert = array("cantidad"=>$sesion['cantidad'], "id_articulo"=>$sesion["id_articulo"], "id_solicitud"=>$params['id_solicitud']);
        $response_insert = $data->query($sql_insert, $params_insert, array(), true);
    }
}

if ($response_update['success'] == true || $response_delete['success'] == true || $response_insert['insertId'] > 0) {
    $response = array('success'=>true, 'mensaje'=>"Solicitud modificada", "id"=>$params['id_solicitud']);
} else {
    $response = array('success'=>false, 'mensaje'=>"Error en la operación");
}
echo json_encode($response);
?>