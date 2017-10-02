<?php  
ob_start();
@session_start();
include("../../sql/class.data.php");
$data = new data();
$params = $_POST;
$response_update['success'] = false;
$response_delete['success'] = false;
$response_insert['insertId'] = 0;

$sql = "SELECT id_empleado FROM grupo_empleado WHERE id_grupo = :id_grupo";
$parametros = array("id_grupo");
$resultado = $data->query($sql, $params, $parametros);

foreach ($resultado['items'] as $consulta) {
    $encontrado = false;
    foreach ($_SESSION['detalle_empleado'] as $session) {
        if ($consulta['id_empleado'] == $session["id_empleado"]) {
            $encontrado = true;
        }
    }
    if ($encontrado == false) {
        $sql_delete = "DELETE FROM grupo_empleado WHERE id_grupo = :id_grupo AND id_empleado = :id_empleado";
        $params_delete = array("id_grupo"=>$params['id_grupo'], "id_empleado"=>$consulta['id_empleado']);
        $response_delete = $data->query($sql_delete, $params_delete, array(), true);
    }
}

$session = array();
foreach ($_SESSION['detalle_empleado'] as $session) {
    $sql2 = "SELECT id_empleado FROM grupo_empleado WHERE id_grupo = :id_grupo AND id_empleado = :id_empleado";
    $parametro = array("id_grupo"=>$params['id_grupo'], "id_empleado"=>$session["id_empleado"]);
    $respuesta = $data->query($sql2, $parametro);
    if ($respuesta['total'] == 0) {
        $sql_insert = "INSERT INTO grupo_empleado(id_empleado, id_grupo) VALUES(:id_empleado, :id_grupo)";
        $params_insert = array("id_empleado"=>$session["id_empleado"], "id_grupo"=>$params['id_grupo']);
        $response_insert = $data->query($sql_insert, $params_insert, array(), true);
    }
}

if ($params['nombre_grupo'] != $params['grupo']) {
    $sql="UPDATE grupo SET grupo=:grupo WHERE id_grupo=:id_grupo";
    $param_list = array("grupo","id_grupo");
    $response_update = $data->query($sql, $params, $param_list);
}

if ($response_update['success'] == true || $response_delete['success'] == true || $response_insert['insertId'] > 0) {
    $response = array('success'=>true, 'mensaje'=>"El grupo ha sido modificado");
    unset($_SESSION['detalle_empleado']);
} else {
    $response = array('success'=>false, 'mensaje'=>"Error en la operación");
}

echo json_encode($response);
?>