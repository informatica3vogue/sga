<?php

@session_start();
include("../sql/class.managerDB.php");
include("../sql/class.data.php");
$data = new data();

$params = $_POST;
$i = 0;
$params["id_dependencia"] = $_SESSION["id_dependencia"];
$sql = "SELECT empleado.id_empleado, empleado.codigo, empleado.nombre, empleado.apellido, empleado.estado_civil, empleado.DUI, empleado.NIT, empleado.NUP, empleado.ISSS, empleado.direccion, empleado.fecha_contratacion, empleado.titulo, empleado.cargo, empleado.tipo_contratacion, empleado.tipo_sangre, empleado.persona_encargada, empleado_seccion.estado,empleado_seccion.fecha_final, seccion.id_seccion, seccion.seccion, (SELECT GROUP_CONCAT(telefono) FROM telefono_emp WHERE tipo='Movil' AND telefono_emp.id_empleado=empleado.id_empleado) AS movil, (SELECT GROUP_CONCAT(telefono) FROM telefono_emp WHERE tipo='Fijo' AND telefono_emp.id_empleado=empleado.id_empleado) AS fijo, (SELECT GROUP_CONCAT(telefono) FROM telefono_emp WHERE tipo='Encargado' AND telefono_emp.id_empleado=empleado.id_empleado) AS encargado FROM empleado INNER JOIN empleado_seccion ON empleado_seccion.id_empleado=empleado.id_empleado INNER JOIN seccion ON seccion.id_seccion=empleado_seccion.id_seccion WHERE seccion.id_dependencia=:id_dependencia AND MATCH(empleado.codigo, empleado.nombre, empleado.apellido, empleado.DUI, empleado.NUP, empleado.NIT, empleado.ISSS) AGAINST(:txtBuscar) OR seccion.seccion LIKE :txtBuscar ORDER BY seccion.seccion, empleado.nombre, empleado_seccion.estado";
$param_list = array("id_dependencia", "txtBuscar");
$response = $data->query($sql, $params, $param_list);

if ($response["total"] > 0) {
    //Grid de datos del usuario
    $grid ="
    <div class='table-responsive'>
        <table class='table table-hover table-bordered table-condensed'>
            <thead>
                <tr>
                    <th>Codigo</th>
                    <th>Nombres</th>
                    <th>Apellidos</th>
                    <th>Cargo</th>
                    <th>DUI</th>     
                    <th>Estado</th>
                     <th>Fecha Modificación</th>
                    <th>Sección</th>                    
                    <th colspan='2'>Acciones</th>
                </tr> 
            </thead>
            <tbody>"; 
                foreach($response['items'] as $datos){
                    $i++;
                    if($i%2==0){ $estilos="class='info'"; }else{ $estilos=" "; }
                    $grid .= "
                    <tr ".$estilos.">
                        <td>".$datos['codigo']."</td>
                        <td>".$datos['nombre']."</td>
                        <td>".$datos['apellido']."</td>
                        <td>".$datos['cargo']."</td>
                        <td>".$datos['DUI']."</td> 
                        <td>".$datos['estado']."</td>
                        <td>".$datos['fecha_final']."</td>
                        <td>".$datos['seccion']."</td>
                        <td id='center'><a href='#' onclick=\"modificar_empleado(".$datos['id_empleado'].", '".$datos['codigo']."', '".$datos['nombre']."','".$datos['apellido']."','".$datos['estado_civil']."', '".$datos['DUI']."', '".$datos['NIT']."', '".$datos['NUP']."', '".$datos['ISSS']."', '".$datos['tipo_sangre']."', '".$datos['titulo']."', '".$datos['cargo']."', '".$datos['fecha_contratacion']."', '".$datos['tipo_contratacion']."','".$datos['id_seccion']."' ,'".$datos['direccion']."','".$datos['movil']."','".$datos['fijo']."', '".$datos['persona_encargada']."','".$datos['encargado']."');\" ><img src='img/edit_user.png' width='16px' height='16px'/></a></td>

                        <td id='center'><a href='#' data-toggle='modal' data-target='#modal_empleado'  onclick=\"modificar_estado(".$datos['id_empleado'].", '".$datos['nombre']."','".$datos['apellido']."','".$datos['estado']."');\" ><img src='img/estado.png' width='16px' height='16px'/></a></td>
                    </tr>";
                }
             $grid = $grid.="
            </tbody>
        </table>
    </div>
    ";
}else{
    $grid = "
    <div id='padding16'>
        <div class='alert alert-block alert alert-danger'>
            <h4>Resultado de la busqueda!</h4>
            <p>No se encontro ningun registro</p>                             
        </div>
    </div>
    ";
}
$response=array('grid'=> $grid);
echo json_encode($response);
?>