<?php                       
@session_start();
include("../sql/class.managerDB.php");
include("../sql/class.data.php");
$data = new data();

$sql = "SELECT id_motivo, motivo FROM motivo ORDER BY motivo ASC";
$response = $data->query($sql);

echo json_encode($response);
?>