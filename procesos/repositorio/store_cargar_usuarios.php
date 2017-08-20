<?php                       
@session_start();

include("../../sql/class.data.php");
$data = new data();

$params = $_POST;
$sql = "SELECT DISTINCT CONCAT(INITCAP(emp.nombre),' ', INITCAP(emp.apellido)) AS nombre_completo, us.id_usuario FROM empleado emp INNER JOIN usuario us ON emp.id_empleado = us.id_empleado INNER JOIN seccion sec ON us.id_seccion = sec.id_seccion WHERE us.id_usuario<>:id_usuario AND sec.id_dependencia =:id_dependencia ORDER BY nombre_completo ASC";
$response = $data->query($sql, array("id_dependencia" => $_SESSION["id_dependencia"], "id_usuario" => $_SESSION["id_usuario"]));

echo json_encode($response);
?>