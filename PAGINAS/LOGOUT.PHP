<?php
@ob_start();
@session_start();
$sql = "INSERT INTO bitacora(accion, tipo_accion, fecha_procesamiento, id_usuario) VALUES ('Cierre de sesion', 5, NOW(), :id_usuario)";
$response_bitacora = $data->query($sql, array('id_usuario' => $_SESSION["id_usuario"]), array(), true); 
session_destroy();
header('Location:?mod=login');
?>