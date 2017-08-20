<?php
@session_start();

include("../../sql/class.data.php");
$data = new data();

$array = array();
$params = $_POST;
$sql = "SELECT DISTINCT CONCAT(INITCAP(emp.nombre),' ', INITCAP(emp.apellido)) AS nombre_completo, us.id_usuario FROM empleado emp INNER JOIN usuario us ON emp.id_empleado = us.id_empleado INNER JOIN seccion sec ON us.id_seccion = sec.id_seccion WHERE us.id_usuario<>:id_usuario AND sec.id_dependencia =:id_dependencia ORDER BY nombre_completo ASC";
$response = $data->query($sql, array("id_dependencia" => $_SESSION["id_dependencia"], "id_usuario" => $_SESSION["id_usuario"]));

if ($response["total"] > 0) {
    foreach($response['items'] as $datos){ 
        $sql = "SELECT id_usuario FROM usuario_repositorio WHERE id_repositorio=:id_repositorio AND id_usuario=:id_usuario AND estado=1";
        $response_asignados = $data->query($sql, array("id_usuario" => $datos["id_usuario"], "id_repositorio" => $params["id_repositorio"])); 

         $selected = ( $response_asignados["total"] > 0 ) ? "selected" : "";
    array_push($array, array("id_usuario" => $datos['id_usuario'], "nombre_completo" => $datos['nombre_completo'], "selected" => $selected));
    }
    $response = array('success' => true, 'items' => $array, 'total' => $response["total"]);
}else{
    $response = array('success' => false, 'items' => $array, 'total' => 0);
}
echo json_encode($response);
?>