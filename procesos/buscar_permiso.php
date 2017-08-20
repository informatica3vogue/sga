<?php

@session_start();
include("../sql/class.managerDB.php");
include("../sql/class.data.php");
$data = new data();

$params=$_POST;
$grid = "";
    
    $sql = "SELECT permiso.id_permiso, permiso.num_permiso,permiso.fecha_dif, permiso.fecha_drh, permiso.hora_desde, permiso.hora_hasta, permiso.fecha_desde, permiso.fecha_hasta, permiso.anulacion, permiso.observacion, permiso.motivo_otros, permiso.id_empleado, permiso.codigo_rrhh, docu_permiso.documento, empleado.codigo, empleado.nombre, empleado.apellido, motivo.id_motivo, DATE_FORMAT(permiso.fecha_dif, '%d-%m-%Y') AS f_dif, DATE_FORMAT(permiso.fecha_desde, '%d-%m-%Y') AS f_desde , DATE_FORMAT(permiso.fecha_hasta, '%d-%m-%Y') AS f_hasta , DATE_FORMAT(hora_desde, ' %h:%m:%s %p') AS hora_des, DATE_FORMAT(permiso.hora_hasta, ' %h:%m:%s %p') AS hora_ha, DATEDIFF(permiso.fecha_hasta, permiso.fecha_desde) AS dias, SEC_TO_TIME(TIME_TO_SEC(TIMEDIFF(permiso.hora_hasta, permiso.hora_desde)))AS horas, motivo.motivo, CONCAT(empleado.nombre, ' ', empleado.apellido) AS nombre_completo FROM (((permiso INNER JOIN motivo ON permiso.id_motivo= motivo.id_motivo ) INNER JOIN empleado ON empleado.id_empleado = permiso.id_empleado) INNER JOIN docu_permiso ON permiso.id_permiso = docu_permiso.id_permiso) WHERE  motivo.motivo LIKE :txtBuscar OR empleado.nombre LIKE :txtBuscar OR empleado.apellido LIKE :txtBuscar OR empleado.codigo LIKE :txtBuscar OR CONCAT(empleado.nombre, ' ', empleado.apellido) LIKE :txtBuscar ORDER BY fecha_dif";
    $param_list = array("txtBuscar");
    $response = $data->query($sql, $params, $param_list);

if ($response["total"] > 0) {
    //Grid de datos de permiso
                foreach($response['items'] as $datos){
                    $grid .= "
                    <tr>
                    <td>".$datos['nombre_completo']."</td>
                        <td>".$datos['f_dif']."</td>
                        <td>".$datos['motivo']."</td>
                        <td>".$datos['f_desde']."</td>
                        <td>".$datos['f_hasta']."</td>
                        <td>".$datos['hora_desde']."</td>
                        <td>".$datos['hora_hasta']."</td>
                         <td>".$datos['anulacion']."</td>
                        <td>".$datos['dias']."</td>
                         <td>".$datos['horas']."</td>
                         <td><a href='upload/permisos/".$datos['documento']."', download>".$datos['documento']."</td>
                         <td id='center'><a href='#' onClick=\"modificar_permiso(".$datos['id_permiso'].", '".$datos['num_permiso']."', ".$datos['id_empleado'].", '".$datos['id_motivo']."', '".$datos['motivo_otros']."', '".$datos['fecha_desde']."', '".$datos['fecha_hasta']."', '".$datos['hora_desde']."', '".$datos['hora_hasta']."', '".$datos['fecha_dif']."', '".$datos['anulacion']."', '".$datos['fecha_drh']."', '".$datos['codigo_rrhh']."', '".$datos['observacion']."');\" ><img src='img/edit.png' width='16px' height='16px'/></a></td>                     
                    </tr>";
                }
}else{
   $grid = "
    <tr>
        <td colspan='12'>
        <div id='padding16'>
            <div class='alert alert-block alert alert-info'>
                <h4>Resultado de la busqueda!</h4>
                <p>No hay registros</p>                         
            </div>
        </div>
        </td>
    </tr>
    ";
}
$response=array('grid'=> $grid);
echo json_encode($response);
?>