<?php

@session_start();
include("../sql/class.managerDB.php");
include("../sql/class.data.php");
$data = new data();

$params = $_POST;
$i = 0;
$sql = "SELECT usuario.id_usuario, usuario.nombre, usuario.apellido, usuario.usuario, usuario.cargo, rol.id_rol, rol.rol, usuario.estado, seccion.id_seccion, seccion.seccion, dependencia.id_dependencia, dependencia.dependencia, municipio.municipio, departamento.departamento FROM (((((control_actividades.seccion seccion INNER JOIN bddependencias.dependencia dependencia ON seccion.id_dependencia = dependencia.id_dependencia) INNER JOIN control_actividades.usuario usuario ON usuario.id_seccion = seccion.id_seccion) INNER JOIN control_actividades.rol rol ON rol.id_rol = usuario.id_rol) INNER JOIN bddependencias.municipio municipio ON municipio.id_municipio = dependencia.id_municipio) INNER JOIN bddependencias.departamento departamento ON departamento.id_departamento = municipio.id_departamento) WHERE MATCH(usuario.nombre, usuario.apellido, usuario.usuario, usuario.cargo) AGAINST(:txtBuscar) OR seccion.seccion LIKE :txtBuscar OR dependencia.dependencia LIKE :txtBuscar ORDER BY usuario.nombre, usuario.apellido, dependencia.dependencia";
    $param_list = array("txtBuscar");
	$response = $data->query($sql, $params, $param_list);
//Datos extraidos de nuestra bd
if ($response["total"] > 0) {
    $grid ="
    <div class='table-responsive'>
        <table class='table table-hover table-bordered table-condensed'>
            <thead>
                <tr>
                    <th>Nombres</th>
                    <th>Apellidos</th>
                    <th>Usuario</th>
                    <th>Rol</th>
                    <th>Estado</th>
                    <th>Sección</th>
                    <th>Dependencia</th>
                    <th colspan='2'>Acciones</th>
                </tr> 
            </thead>
            <tbody>"; 
                foreach($response['items'] as $datos){
                    $i++;
                    if($i%2==0){ $estilos="class='info'"; }else{ $estilos=" "; }
                    $grid .= "
                    <tr ".$estilos.">
                        <td>".$datos['nombre']."</td>
                        <td>".$datos['apellido']."</td>
                        <td>".$datos['usuario']."</td>
                        <td>".$datos['rol']."</td>
                        <td>".$datos['estado']."</td>
                        <td>".$datos['seccion']."</td>
                        <td>".$datos['dependencia']."</td>
                        <td id='center'><a href='#' onclick=\"modificar_usuario(".$datos['id_usuario'].", '".$datos['nombre']."','".$datos['apellido']."','".$datos['cargo']."', ".$datos['id_dependencia'].", ".$datos['id_seccion'].", '".$datos['usuario']."', '".$datos['id_rol']."');\" ><img src='img/edit_user.png' width='16px' height='16px'/></a></td>
                        <td id='center'><a href='#' data-toggle='modal' data-target='#modal_usuario' onclick=\"modificar_estado(".$datos['id_usuario'].", '".$datos['nombre']."','".$datos['apellido']."','".$datos['estado']."');\" ><img src='img/estado.png' width='16px' height='16px'/></a></td>
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