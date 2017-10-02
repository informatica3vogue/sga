<?php                       
include("../sql/class.managerDB.php");
include("../sql/class.data.php");
$data = new data();

$params = $_POST;
$sql = "SELECT num_permiso FROM permiso WHERE num_permiso = :txtNumeroPermiso "; 
$param_list = array("txtNumeroPermiso");
$response = $data->query($sql, $params, $param_list);

if($response['total'] > 0){
    echo "<font  color='#ff6666'>Este número ya a sido ingresado</font>";
}else{
    echo "<font color='#66cc66'>Número disponible!</font>";

}
?>
<?php 
/*

**Archivos de interfaz que alimenta**
- empleado.php

*/
?>

