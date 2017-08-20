<?php
@session_start();

include("../../sql/class.data.php");
include("../../php/fecha_servidor.php");
$data = new data();

$params = $_POST;
$params["id_usuario"] = $_SESSION["id_usuario"];
$params["id_dependencia"] = $_SESSION["id_dependencia"];
$params["accion"] = 'se ha modificado  memorandum, fecha modificacion: '.date('d-m-y').', \n  tipo de memorandum: '.$params["txtTipo"].'.';

$sql1 = "UPDATE memorandum SET para=:txtPara, de=:txtDe, asunto=:txtAsunto, descripcion=:txtContenido, con_copia=:txtCopia, tipo_memorandum=:txtTipo  WHERE id_memorandum=:txtId";
$param_list = array("txtPara","txtDe","txtAsunto","txtContenido","txtCopia","txtTipo","txtId");
$response = $data->query($sql1, $params, $param_list, true);

if (!empty($params["txtPara"])) {
    if (!empty($params["txtDe"])) {

 		$sql_empleados = "SELECT id_empleado FROM memo_interno WHERE id_memorandum = :txtId";
        $param_list = array("txtId");
        $response_empleados = $data->query($sql_empleados, $params, $param_list);

        foreach ($response_empleados['items'] as $consulta_empleados) {
            $encontrado = false;
            $id_empleado = 0;
            foreach ($params['txtPara'] as $id) {
                if ($consulta_empleados['id_empleado'] == $id) {
                    $encontrado = true;
                    $id_empleado = $id;
                }
            }
            if ($encontrado == false) {
                $sql_delete = "DELETE FROM memo_interno WHERE id_memorandum = :id_memorandum AND id_empleado=:id_empleado";
                $params_delete = array("id_memorandum"=>$params["txtId"], "id_empleado"=>$consulta_empleados['id_empleado']);
                $response_delete = $data->query($sql_delete, $params_delete, array(), true);
            }
        }

        $id_empleado = 0;
        foreach ($params['txtPara'] as $id_empleado) {
			$sql_empleado = "SELECT id_empleado FROM memo_interno WHERE id_memorandum = :id_memorandum AND id_empleado= :id_empleado";
			$respuesta_empleado = $data->query($sql_empleado, array("id_memorandum"=>$params['txtId'], "id_empleado"=>$id_empleado));
		    if ($respuesta_empleado['total'] == 0) {
		        $sql_insert = "INSERT INTO memo_interno (id_empleado, id_memorandum) VALUES (:id_empleado, :id_memorandum)";
		        $params_insert = array("id_empleado"=>$id_empleado, "id_memorandum"=>$params['txtId']);
		        $response_insert = $data->query($sql_insert, $params_insert, array(), true);
		    }
		}
		if($response['total'] > 0){
			$response=array('success'=>true, 'titulo'=>'Operacion exitosa!', 'mensaje'=>'Se modifico el memorandum', "id"=>$params["txtId"]);
		}else{
		    $response=array('success'=>false, 'titulo'=>'Verifique su información!', 'mensaje'=>'No se actualizo el memorandum');
		}
	}else{
		$response=array('success'=>false, 'titulo'=>'Verifique su información!', 'mensaje'=>'El campo del emisor esta vacio');
	}
}else{
	$response=array('success'=>false, 'titulo'=>'Verifique su información!', 'mensaje'=>'El campo del receptor esta vacio');
}

echo json_encode($response);
?>