<?php                       

@session_start();
include("../sql/class.managerDB.php");
include("../sql/class.data.php");
$data = new data();

$params = $_GET;
$sql = "SELECT id_usuario, CONCAT(nombre, ' ', apellido) AS nombre_completo FROM usuario WHERE id_seccion = :id_seccion ORDER BY nombre_completo ASC";
$response = $data->query($sql, array("id_seccion" => $_SESSION["id_seccion"]));

echo json_encode($response);
?>