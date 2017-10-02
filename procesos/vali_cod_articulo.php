<?php                       
include("../sql/class.managerDB.php");
include("../sql/class.data.php");
$data = new data();

$params = $_POST;

$sql = "SELECT caf FROM articulo WHERE caf = :txtAccion "; 
$param_list = array("txtAccion");
$response = $data->query($sql, $params, $param_list);

if($response['total'] > 0){
  echo "<font  color='#ff6666'>Código no disponible!</font>";
}else{
echo "<font color='#66cc66'>Código disponible!</font>";

}
?>
