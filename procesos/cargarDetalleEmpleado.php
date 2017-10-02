<?php

@session_start();
include("../sql/class.managerDB.php");
include("../sql/class.data.php");

$data = new data();

$params = $_POST;

$sql = "SELECT dep.dependencia, CONCAT(em.nombre, ' ', em.apellido) AS nombre_completo, sec.seccion, em.codigo, em.num_tarjeta_marcacion, tem.telefono FROM bddependencias.dependencia dep INNER JOIN control_actividades.seccion sec ON dep.id_dependencia = sec.id_dependencia INNER JOIN control_actividades.empleado_seccion es ON sec.id_seccion = es.id_seccion INNER JOIN control_actividades.empleado em ON es.id_empleado = em.id_empleado INNER JOIN control_actividades.telefono_emp tem ON em.id_empleado = tem.id_empleado WHERE control_actividades.em.id_empleado = :id_empleado";


$param_list=array('id_empleado');
$response = $data->query($sql, $params, $param_list);
if ($response['total'] > 0){

    $response = array('nombre' =>' &nbsp;'.$response['items'][0]['nombre_completo'].'',
        'codigo' => ' &nbsp;'.$response['items'][0]['codigo'].'',
        'num_tarjeta' => ' &nbsp;'.$response['items'][0]['num_tarjeta_marcacion'].'',
        'seccion' => ' &nbsp;'.$response['items'][0]['seccion'].' ',
        'dependencia' => ' &nbsp;'.$response['items'][0]['dependencia'].'',
        'telefono' => ' &nbsp;'.$response['items'][0]['telefono'].''       
    );
  } else {
    $response = array('nombre' => ' &nbsp;',
        'codigo' => ' &nbsp;',
        'num_tarjeta' => ' &nbsp;',
        'seccion' => ' &nbsp;',
        'dependencia' => ' &nbsp;',
        'telefono' => ' &nbsp;',

    );         
  } 

echo json_encode($response);
?>
