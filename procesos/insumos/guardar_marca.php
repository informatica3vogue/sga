<?php
@session_start();

include("../../sql/class.data.php");
$data= new data();

$params=$_POST;
$params["id_dependencia"] = $_SESSION["id_dependencia"];

$sql = "SELECT * FROM marca WHERE id_categoria = 1 AND marca=:txtMarca AND id_dependencia=:id_dependencia";
$parametros = array("txtMarca","id_dependencia");
$result = $data->query($sql, $params, $parametros);
if ($result['total'] > 0) {
    $response = array('success'=>false, 'titulo'=>'Verifique su información!', 'mensaje'=>'Esta marca ya existe');
} else {
	$sql = "INSERT INTO marca (marca, id_dependencia, id_categoria) VALUES (:txtMarca, :id_dependencia, 1)";
	$param_list = array("txtMarca","id_dependencia");
	$response = $data->query($sql, $params, $param_list, true);
	if ($response['insertId'] == 0) {
	   $response=array('success'=>false, 'titulo'=>'Verifique su información!', 'mensaje'=>'No se guardo el registro');
	}else{
		$response=array('success'=>true, 'titulo'=>'Operación exitosa!', 'mensaje'=>'Se agrego marca', 'id_marcas'=>$response['insertId']);
	}
}
 
echo json_encode($response);
?>