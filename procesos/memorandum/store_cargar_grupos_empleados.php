<?php
@session_start();
include("../../sql/class.data.php");
$data = new data();
$empleados =  array();
$grupos =  array();

$empleados_sql = "SELECT DISTINCT e.id_empleado AS id, CONCAT(INITCAP(e.nombre), ' ', INITCAP(e.apellido), ' / ', IF(e.cargo!= '', INITCAP(e.cargo), '')) AS nombre, 'empleado' as tipo FROM empleado e INNER JOIN empleado_seccion es ON e.id_empleado=es.id_empleado INNER JOIN seccion s ON es.id_seccion=s.id_seccion WHERE s.id_dependencia = :id_dependencia AND e.id_empleado != :id_empleado ORDER BY nombre ASC";
$empleados = $data->query($empleados_sql, array("id_dependencia" => $_SESSION["id_dependencia"], 'id_empleado' => $_SESSION['id_empleado']));

$grupos_sql = "SELECT DISTINCT g.id_grupo as id, g.grupo as nombre, 'grupo' as tipo FROM grupo g INNER JOIN grupo_empleado ge ON ge.id_grupo = g.id_grupo INNER JOIN empleado e ON ge.id_empleado = e.id_empleado INNER JOIN empleado_seccion ec ON e.id_empleado = ec.id_empleado INNER JOIN seccion sc ON ec.id_seccion = sc.id_seccion WHERE g.id_usuario_propietario =:id_usuario";
$grupos = $data->query($grupos_sql, array("id_usuario" => $_SESSION["id_usuario"]));

$a=array();
if($grupos["total"] > 0){
    array_push($a, $grupos["items"]);
}
array_push($a, $empleados["items"]);
//echo $grupos["total"];

$response=$a;
//print_r($response);

echo json_encode($response);
?>