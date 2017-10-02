<?php                       
include("../sql/class.managerDB.php");
include("../sql/class.data.php");
$data = new data();

$params = $_POST;

$sql = "SELECT codigo FROM empleado WHERE codigo = :txtCodigo "; 
$param_list = array("txtCodigo");
$response = $data->query($sql, $params, $param_list);

if($response['total'] > 0){
  echo "<font  color='#ff6666'>Código no disponible!</font>";
}else{
echo "<font color='#66cc66'>Código disponible!</font>";

}
?>
