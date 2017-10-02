<?php                       
@session_start();
include("../sql/class.data.php");
$data = new data();

$params = $_POST;

if ($_SESSION["id_seccion"] == $params["id_seccion"]) {
    $sql = "SELECT id_usuario, CONCAT(nombre, ' ', apellido) AS nombre_completo FROM usuario WHERE id_seccion = :id_seccion ORDER BY nombre_completo ASC";
    $param_list = array("id_seccion");
    $response = $data->query($sql, $params, $param_list);
}else{
    $sql = "SELECT id_usuario, CONCAT(nombre, ' ', apellido) AS nombre_completo FROM usuario WHERE id_seccion = :id_seccion AND id_rol = 4 OR id_seccion = :id_seccion AND id_rol = 6 OR id_seccion = :id_seccion AND id_rol = 10 OR id_seccion = :id_seccion AND id_rol = 11 ORDER BY nombre_completo ASC";
    $param_list = array("id_seccion");
    $response = $data->query($sql, $params, $param_list);
}

echo json_encode($response);
?>