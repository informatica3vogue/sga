<?php 
// llenado de combo usuario mediante id_seccion, llamado desde: ingreso_actividades_admin                      
@session_start();
include("../sql/class.data.php");
$data = new data();

$params = $_POST;

$sql = "SELECT id_usuario, CONCAT(nombre, ' ', apellido) AS nombre_completo FROM usuario WHERE id_seccion = :id_seccion ORDER BY nombre_completo ASC";
$param_list = array("id_seccion");
$response = $data->query($sql, $params, $param_list);

echo json_encode($response);
?>