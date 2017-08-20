<?php

@session_start();
include("../sql/class.managerDB.php");
include("../sql/class.data.php");
$data = new data();

$params=$_POST;
$params["id_dependencia"] = $_SESSION["id_dependencia"];
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
    
    $sql = "SELECT empleado.id_empleado, empleado.codigo, empleado.num_tarjeta_marcacion, empleado.nombre, empleado.apellido, empleado_seccion.estado,empleado_seccion.fecha_final, seccion.id_seccion, seccion.seccion FROM empleado INNER JOIN empleado_seccion ON empleado_seccion.id_empleado=empleado.id_empleado INNER JOIN seccion ON seccion.id_seccion=empleado_seccion.id_seccion WHERE seccion.id_dependencia=:id_dependencia AND empleado_seccion.estado = 'Activo' AND empleado_seccion.fecha_final IS NULL ORDER BY empleado_seccion.estado, seccion.seccion, empleado.nombre ASC LIMIT :start, :limit";
    $param_list=array("id_dependencia", "start","limit");
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

    //Total de registros de la bd para obtener total de paginas 
    $sql = "SELECT * FROM empleado";
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
    $paginador = "<div class='dataTables_paginate paging_bootstrap pagination'><ul>";

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
    $paginador = $paginador . "</ul></div><div>" . $total_string . "</div>";  

    $response=array('grid'=> $grid, 'paginador'=> $paginador);
    
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
$response=array("grid"=> $grid, "paginador" => $paginador);
}
echo json_encode($response);
}