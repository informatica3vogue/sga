<?php 
@session_start();
include("../sql/class.managerDB.php");
include("../sql/class.data.php");
$data = new data();

$params = $_POST;
$sql ="SELECT empleado.id_empleado,empleado.codigo, empleado.nombre,empleado.apellido,empleado.estado_civil, empleado.DUI, empleado.NIT, seccion.seccion, empleado.NUP, empleado.ISSS, empleado.direccion, empleado.fecha_contratacion, empleado.titulo, empleado.cargo, empleado.tipo_contratacion, empleado.tipo_sangre, empleado.persona_encargada, telefono_emp.telefono_encargado, telefono_emp.tipo, telefono_emp.telefono 
	FROM ((empleado 
	INNER JOIN seccion on seccion.id_seccion=empleado.id_seccion)
	INNER JOIN telefono_emp ON telefono_emp.id_empleado=empleado.id_empleado)
    WHERE id_telefono_emp=:id_empleado";

$param_list = array('id_empleado');
$response = $data->query($sql, $params, $param_list);
if($response['items'] == 0){
    $response=array("success"=>false); 
}
echo json_encode($response);
 ?>