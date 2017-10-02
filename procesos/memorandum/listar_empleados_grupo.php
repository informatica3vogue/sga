<?php
include("../../sql/class.data.php");
@session_start();
$data = new data();
$params=$_POST;
$_SESSION['detalle_empleado']=array();

$sql = "SELECT DISTINCT emp.id_empleado, CONCAT(INITCAP(emp.nombre), ' ', INITCAP(emp.apellido), ' / ', IF(emp.cargo!= '', INITCAP(emp.cargo), '')) AS empleado, g.id_grupo, g.grupo FROM empleado emp INNER JOIN grupo_empleado gemp ON emp.id_empleado = gemp.id_empleado  INNER JOIN empleado_seccion emsec ON emp.id_empleado = emsec.id_empleado INNER JOIN seccion sec ON emsec.id_seccion = sec.id_seccion INNER JOIN grupo g ON gemp.id_grupo = g.id_grupo WHERE gemp.id_grupo = :id_grupo";
$params_list = array("id_grupo");
$response = $data->query($sql, $params, $params_list);
if ($response["total"] > 0) {
    foreach ($response["items"] as $index) {
      $_SESSION['detalle_empleado'][] = $index;
    }
}
echo json_encode($response);
?>