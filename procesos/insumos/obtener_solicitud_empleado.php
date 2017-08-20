<?php
@session_start();

include("../../sql/class.data.php");
$data = new data();

$params = $_POST;
$sql = "SELECT us.id_usuario, DATE_FORMAT(sa.fecha, '%d-%m-%Y / %h:%m:%s %p') AS fecha, (SELECT DISTINCT CONCAT(' ',INITCAP(empleado.nombre), ' ', INITCAP(empleado.apellido)) FROM empleado INNER JOIN usuario ON empleado.id_empleado=usuario.id_empleado WHERE usuario.id_usuario = us.id_usuario) AS nombre_completo, ds.cantidad, a.id_articulo, a.articulo FROM solicitud_articulo sa INNER JOIN usuario us ON sa.id_usuario = us.id_usuario INNER JOIN detalle_solicitud ds ON sa.id_solicitud_articulo = ds.id_solicitud_articulo INNER JOIN articulo a ON ds.id_articulo = a.id_articulo WHERE ds.id_solicitud_articulo = :id";
$param_list=array("id");
$response = $data->query($sql, $params, $param_list);
echo json_encode($response);
?>