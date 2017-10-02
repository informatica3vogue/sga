<?php

@session_start();
include("../sql/class.managerDB.php");
include("../sql/class.data.php");
$data = new data();

$params = $_POST;
$grid = "";
$params["id_dependencia"] = $_SESSION["id_dependencia"];
$sql = "SELECT empleado.id_empleado, empleado.codigo, empleado.nombre, empleado.apellido, empleado.estado_civil, empleado.DUI, empleado.NIT, empleado.NUP, empleado.ISSS, empleado.direccion, empleado.fecha_contratacion, empleado.titulo, empleado.cargo, empleado.tipo_contratacion, empleado.tipo_sangre, empleado.persona_encargada, empleado_seccion.estado,empleado_seccion.fecha_final, seccion.id_seccion, seccion.seccion, (SELECT GROUP_CONCAT(telefono) FROM telefono_emp WHERE tipo='Movil' AND telefono_emp.id_empleado=empleado.id_empleado) AS movil, (SELECT GROUP_CONCAT(telefono) FROM telefono_emp WHERE tipo='Fijo' AND telefono_emp.id_empleado=empleado.id_empleado) AS fijo, (SELECT GROUP_CONCAT(telefono) FROM telefono_emp WHERE tipo='Encargado' AND telefono_emp.id_empleado=empleado.id_empleado) AS encargado FROM empleado INNER JOIN empleado_seccion ON empleado_seccion.id_empleado=empleado.id_empleado INNER JOIN seccion ON seccion.id_seccion=empleado_seccion.id_seccion WHERE seccion.id_dependencia=:id_dependencia AND MATCH(empleado.codigo, empleado.nombre, empleado.apellido, empleado.DUI, empleado.NUP, empleado.NIT, empleado.ISSS) AGAINST(:txtBuscar) AND empleado_seccion.estado = 'Activo' AND empleado_seccion.fecha_final IS NULL OR seccion.seccion LIKE :txtBuscar AND seccion.id_dependencia=:id_dependencia AND empleado_seccion.estado = 'Activo' AND empleado_seccion.fecha_final IS NULL ORDER BY seccion.seccion, empleado.nombre, empleado_seccion.estado";
$param_list = array("id_dependencia", "txtBuscar");
$response = $data->query($sql, $params, $param_list);

if ($response["total"] > 0) {
    //Grid de datos del usuario
    foreach($response['items'] as $datos){
        $grid .= "
        <tr>
            <td class='sorting_1'>".$datos['codigo']."</td>
            <td class='center'>".$datos['nombre']."</td>
            <td class='center'>".$datos['apellido']."</td>            
            <td class='center' id='center'><a href='#' title='Ver Permisos' onclick=\"verPermisos(1, ".$datos['id_empleado'].");\" ><img src='img/edit.png' width='16px' height='16px'/></a></td>

        </tr>";
    }
}else{
   $grid = "
    <tr>
        <td colspan='9'>
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