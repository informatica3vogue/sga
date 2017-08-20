<?php                       

@session_start();
include("../sql/class.managerDB.php");
include("../sql/class.data.php");
$data = new data();

$params = $_GET;
$sql = "SELECT CONCAT(us.nombre, ' ', us.apellido, ' / ', us.cargo) AS nombre_completo FROM seccion sec INNER JOIN usuario us ON sec.id_seccion=us.id_seccion WHERE sec.id_dependencia = :id_dependencia ORDER BY nombre_completo ASC";
$response = $data->query($sql, array("id_dependencia" => $_SESSION["id_dependencia"]));

echo json_encode($response);
?>