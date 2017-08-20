<?php

@session_start();
include("../sql/class.managerDB.php");
include("../sql/class.data.php");
$data = new data();

$params=$_POST;
$params["id_dependencia"] = $_SESSION["id_dependencia"];
    
$sql = "SELECT empleado.id_empleado, empleado.codigo, empleado.num_tarjeta_marcacion, INITCAP(empleado.nombre) AS nombre, INITCAP(empleado.apellido) AS apellido, empleado.estado_civil, empleado.DUI, empleado.NIT, empleado.NUP, empleado.ISSS, empleado.direccion, empleado.fecha_contratacion, empleado.titulo, empleado.cargo, empleado.tipo_contratacion, empleado.tipo_sangre, empleado.persona_encargada, empleado_seccion.estado,empleado_seccion.fecha_final, seccion.id_seccion, seccion.seccion, (SELECT GROUP_CONCAT(telefono) FROM telefono_emp WHERE tipo='Movil' AND telefono_emp.id_empleado=empleado.id_empleado) AS movil, (SELECT GROUP_CONCAT(telefono) FROM telefono_emp WHERE tipo='Fijo' AND telefono_emp.id_empleado=empleado.id_empleado) AS fijo, (SELECT GROUP_CONCAT(telefono) FROM telefono_emp WHERE tipo='Encargado' AND telefono_emp.id_empleado=empleado.id_empleado) AS encargado FROM empleado INNER JOIN empleado_seccion ON empleado_seccion.id_empleado=empleado.id_empleado INNER JOIN seccion ON seccion.id_seccion=empleado_seccion.id_seccion WHERE empleado.id_empleado=:id_empleado AND seccion.id_dependencia=:id_dependencia AND empleado_seccion.estado = 'Activo'";
$param_list=array("id_dependencia", "id_empleado");
$response = $data->query($sql, $params, $param_list);

echo json_encode($response);
?>