<?php

@session_start();
include("../sql/class.managerDB.php");
include("../sql/class.data.php");
$data = new data();

$params=$_POST;
$params["id_dependencia"] = $_SESSION["id_dependencia"];
    
$sql = "SELECT permiso.id_permiso, permiso.num_permiso, permiso.fecha_dif, permiso.fecha_drh, permiso.hora_desde, permiso.hora_hasta, permiso.fecha_desde, permiso.fecha_hasta, permiso.anulacion, permiso.observacion, permiso.codigo_rrhh, permiso.motivo_otros, permiso.id_empleado, docu_permiso.documento, empleado.codigo, motivo.id_motivo, permiso.fecha_dif, permiso.fecha_desde, permiso.fecha_hasta, permiso.hora_desde, permiso.hora_hasta, motivo.motivo, empleado.DUI, CONCAT(INITCAP(empleado.nombre), ' ', INITCAP(empleado.apellido)) AS nombre_completo FROM permiso INNER JOIN motivo ON permiso.id_motivo= motivo.id_motivo INNER JOIN empleado ON empleado.id_empleado = permiso.id_empleado INNER JOIN empleado_seccion ON empleado.id_empleado = empleado_seccion.id_empleado INNER JOIN seccion ON seccion.id_seccion = empleado_seccion.id_seccion LEFT JOIN docu_permiso ON permiso.id_permiso = docu_permiso.id_permiso WHERE seccion.id_dependencia = :id_dependencia AND permiso.id_permiso = :id_permiso";
$param_list=array("id_dependencia", "id_permiso");
$response = $data->query($sql, $params, $param_list);

echo json_encode($response);
?>