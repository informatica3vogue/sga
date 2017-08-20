<?php

@session_start();
include("../sql/class.managerDB.php");
include("../sql/class.data.php");
$data = new data();

$params=$_POST;
if(isset($params)) {  
    $pagina = $params["pagina"];
    $cur_pagina = $pagina;
    $pagina -= 1;
    $final = 10;
    $anterior = true;
    $siguiente = true;
    $primera = true;
    $ultima = true;
    $params['start'] = $pagina * $final;
    $params['limit'] = $final;
    $paginador = "";
    $grid = "";
    $i = 0;
    
    $sql = "SELECT usuario.id_usuario, usuario.nombre, usuario.apellido, usuario.usuario, usuario.cargo, rol.id_rol, rol.rol, usuario.estado, seccion.id_seccion, seccion.seccion, dependencia.id_dependencia, dependencia.dependencia, municipio.municipio, departamento.departamento FROM (((((control_actividades.seccion seccion INNER JOIN bddependencias.dependencia dependencia ON seccion.id_dependencia = dependencia.id_dependencia) INNER JOIN control_actividades.usuario usuario ON usuario.id_seccion = seccion.id_seccion) INNER JOIN control_actividades.rol rol ON rol.id_rol = usuario.id_rol) INNER JOIN bddependencias.municipio municipio ON municipio.id_municipio = dependencia.id_municipio) INNER JOIN bddependencias.departamento departamento ON departamento.id_departamento = municipio.id_departamento) ORDER BY usuario.nombre, usuario.apellido, dependencia.dependencia LIMIT :start, :limit";
    $param_list=array("start","limit");
    $response = $data->query($sql, $params, $param_list);

if ($response["total"] > 0) {
    //Grid de datos del usuario
    $grid ="
    <div class='table-responsive'>
        <table class='table table-hover table-bordered table-condensed'>
            <thead>
                <tr>
                    <th>Nombres</th>
                    <th>Apellidos</th>
                    <th>Usuario</th>
                    <th>Cargo</th>
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
                        <td>".$datos['cargo']."</td>
                        <td>".$datos['rol']."</td>
                        <td>".$datos['estado']."</td>
                        <td>".$datos['seccion']."</td>
                        <td>".$datos['dependencia']."</td>
                        <td id='center'><a href='return:false;' onClick=\"modificar_usuario(".$datos['id_usuario'].", '".$datos['nombre']."','".$datos['apellido']."','".$datos['cargo']."', ".$datos['id_dependencia'].", ".$datos['id_seccion'].", '".$datos['usuario']."', '".$datos['id_rol']."');\" ><img src='img/edit.png' width='16px' height='16px'/></a></td>
                        <td id='center'><a href='return:false;' data-toggle='modal' data-target='#modal_usuario' onClick=\"modificar_estado(".$datos['id_usuario'].", '".$datos['nombre']."','".$datos['apellido']."','".$datos['estado']."');\" ><img src='img/estado.png' width='16px' height='16px'/></a></td>
                    </tr>";
                }
             $grid = $grid.="
            </tbody>
        </table>
    </div>
    ";

    //Total de registros de la bd para obtener total de paginas
    $sql = "SELECT * FROM usuario";
    $response = $data->query($sql);
    $total = $response["total"];
    $num_paginacion = ceil($total / $final);

    //Calculando el inicio y el fin evaluando este bucle
    if ($cur_pagina >= 7) {
        $comienzo = $cur_pagina - 3;
        if ($num_paginacion > $cur_pagina + 3){
            $fin = $cur_pagina + 3;
        } else if ($cur_pagina <= $num_paginacion && $cur_pagina > $num_paginacion - 6) {
            $comienzo = $num_paginacion - 6;
            $fin = $num_paginacion;
        } else {
            $fin = $num_paginacion;
        }
    } else {
        $comienzo = 1;
        if ($num_paginacion > 7){
            $fin = 7;
        } else {
            $fin = $num_paginacion;
        }
    }

    //Paginador de la grid
    $paginador = "<nav id='right'><ul class='pagination pagination-sm'>";

    // Habilita el boton PRIMERO
    if ($primera && $cur_pagina > 1) {
        $paginador .= "<li p='1' id='activo'><a>Primero</a></li>";
    } else if ($primera) {
        $paginador .= "<li p='1' class='disabled'><a>Primero</a></li>";
    }

    //Habilita el boton ANTERIOR
    if ($anterior && $cur_pagina > 1) {
        $pre = $cur_pagina - 1;
        $paginador .= "<li p='$pre' id='activo'><a>Anterior</a></li>";
    } else if ($anterior) {
        $paginador .= "<li class='disabled'><a>Anterior</a></li>";
    }

    for ($i = $comienzo; $i <= $fin; $i++) {
        if ($cur_pagina == $i) {
            $paginador .= "<li p='$i' id='activo' class='active'><a>{$i}</a></li>";
        } else {
            $paginador .= "<li p='$i' id='activo'><a>{$i}</a></li>";
        }
    }

    //Habilita el boton SIGUIENTE
    if ($siguiente && $cur_pagina < $num_paginacion) {
        $proxima = $cur_pagina + 1;
        $paginador .= "<li p='$proxima' id='activo'><a>Siguiente</a></li>";
    } else if ($siguiente) {
        $paginador .= "<li class='disabled'><a>Siguiente</a></li>";
    }

    // Habilita el boton ULTIMO
    if ($ultima && $cur_pagina < $num_paginacion) {
        $paginador .= "<li p='$num_paginacion' id='activo'><a>Ultimo</a></li>";
    } else if ($ultima) {
        $paginador .= "<li p='$num_paginacion' class='disabled'><a>Ultimo</a></li>";
    }

    $total_string = "<span class='total' a='$num_paginacion'>Pagina <b>" . $cur_pagina . "</b> de <b>$num_paginacion</b></span>";
    
    //Contenedor de paginacion
    $paginador = $paginador . "</ul></nav><div id='left'>" . $total_string . "</div>";  

    $response=array('grid'=> $grid, 'paginador'=> $paginador);
    
}else{
    $grid = "
    <div id='padding16'>
        <div class='alert alert-block alert alert-info'>
            <h4>Resultado de la busqueda!</h4>
            <p>No hay regitros</p>                         
        </div>
    </div>
    ";
$response=array("grid"=> $grid, "paginador" => $paginador);
}
echo json_encode($response);
}