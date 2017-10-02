<?php                       

@session_start();

include("../../sql/class.data.php");
$data = new data();

$params = $_GET;
$sql = "SELECT usuario.id_usuario, CONCAT(INITCAP(LOWER(empleado.nombre)),' ', INITCAP(LOWER(empleado.apellido))) AS nombre_completo FROM seccion INNER JOIN empleado_seccion ON seccion.id_seccion=empleado_seccion.id_seccion INNER JOIN empleado ON empleado.id_empleado=empleado_seccion.id_empleado INNER JOIN usuario ON empleado.id_empleado=usuario.id_empleado  WHERE seccion.id_dependencia = :id_dependencia";
$response = $data->query($sql, array("id_dependencia" => $_SESSION["id_dependencia"]));

echo json_encode($response);
?>