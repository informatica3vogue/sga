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
    $final = 9;
    $anterior = true;
    $siguiente = true;
    $primera = true;
    $ultima = true;
    $params['start'] = $pagina * $final;
    $params['limit'] = $final;
    $paginador = "";
    $grid = "";
    $i = 0;
    
    
    $sql = "SELECT DISTINCT sa.id_solicitud_articulo, sa.referencia, sa.estado, sa.id_usuario, DATE_FORMAT(sa.fecha, '%d-%m-%Y %h:%m:%s %p') AS fecha, CONCAT(us.nombre, ' ', us.apellido) AS nombre_completo FROM solicitud_articulo sa INNER JOIN usuario us ON sa.id_usuario = us.id_usuario INNER JOIN detalle_solicitud ds ON sa.id_solicitud_articulo = ds.id_solicitud_articulo WHERE sa.estado= :estado ORDER BY fecha DESC LIMIT :start, :limit";
    $param_list=array("start","estado","limit");
    $response = $data->query($sql, $params, $param_list);
if ($response["total"] > 0) {
    //Grid de datos del usuario
                foreach($response['items'] as $datos){
                    $grid .= "
                    <tr>
                        <td>".$datos['referencia']."</td>
                        <td>".$datos['fecha']."</td>
                        <td>".$datos['nombre_completo']."</td>
                         ";
                        $params['id_solicitud_articulo'] = $datos['id_solicitud_articulo'];                     
                        $sql2 = "SELECT GROUP_CONCAT(' ', articulo) AS articulo FROM articulo a INNER JOIN detalle_solicitud de ON a.id_articulo = de.id_articulo WHERE de.id_solicitud_articulo = :id_solicitud_articulo";
                        $parametros=array("id_solicitud_articulo");
                        $result = $data->query($sql2, $params, $parametros);
                        $grid.="<td>".$result['items'][0]['articulo']."</td>";

                        if($datos['estado'] =='Pendiente'){
                        
                       $grid .=" <td id='center'><a href=\"?mod=descargos_articulo&id=".$params['id_solicitud_articulo']."\" title='Descargo de solicitud'><img src='img/edit.png' width='16px' height='16px'/></a></td>
                    </tr>";
                }else{
                    $grid .= "<td>Entregado</td>";
                }


                }

    //Total de registros de la bd para obtener total de paginas 
    $sql = "SELECT * FROM solicitud_articulo";
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
    $paginador = "";

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
    $paginador = $paginador . "</div></div><div class='row-fluid'><div class='span12'><div class='dataTables_info' id='DataTables_Table_0_info'>" . $total_string . "</div></div>"; 

    $response=array('grid'=> $grid, 'paginador'=> $paginador);
    
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
    $paginador = "<div style='height: 50px;'></div>";
$response=array("grid"=> $grid, "paginador" => $paginador);
}
echo json_encode($response);
}