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
    $final = 6;
    $anterior = true;
    $siguiente = true;
    $primera = true;
    $ultima = true;
    $params['start'] = $pagina * $final;
    $params['limit'] = $final;
    $paginador_mdescargo = "";
    $grid_mdescargo = "";
    $i = 0;
    
    $params['id_usuario'] = $_SESSION['id_usuario'];
    $sql = "SELECT DISTINCT d.id_solicitud_articulo, sa.referencia, d.id_usuario, DATE_FORMAT(sa.fecha, '%d-%m-%Y / %h:%m:%s %p') AS fecha FROM descargos d INNER JOIN solicitud_articulo sa ON sa.id_solicitud_articulo = d.id_solicitud_articulo INNER JOIN usuario us ON d.id_usuario = us.id_usuario INNER JOIN detalle_solicitud ds ON sa.id_solicitud_articulo = ds.id_solicitud_articulo ORDER BY fecha DESC";
    $param_list=array("id_usuario","start","limit");
    $response2 = $data->query($sql, $params, $param_list);
if ($response2["total"] > 0) {
    //grid_mdescargo de datos del usuario
                foreach($response2['items'] as $datos){
                    $grid_mdescargo .= "
                    <tr>
                        <td>".$datos['referencia']."</td>
                        <td>".$datos['fecha']."</td>
                         ";
                        $params['id_solicitud_articulo'] = $datos['id_solicitud_articulo'];                     
                        $sql2 = "SELECT GROUP_CONCAT(' ', articulo) AS articulo FROM articulo a INNER JOIN detalle_solicitud de ON a.id_articulo = de.id_articulo WHERE de.id_solicitud_articulo = :id_solicitud_articulo";
                        $parametros=array("id_solicitud_articulo");
                        $result = $data->query($sql2, $params, $parametros);
                        $grid_mdescargo.="<td>".$result['items'][0]['articulo']."</td>
                        <td id='center'><a href=\"?mod=compdescargos&id=".$params['id_solicitud_articulo']."\" title='PDF'><img src='img/pdf.png' width='16px' height='16px'/></a></td>
                    </tr>";
                }

    //Total de registros de la bd para obtener total de paginas 
    $sql = "SELECT * FROM descargos d WHERE d.id_usuario = :id_usuario";
    $param_list=array("id_usuario");
    $response2 = $data->query($sql, $params, $param_list);
    $total = $response2["total"];
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

    //paginador_mdescargo de la grid_mdescargo
    $paginador_mdescargo = "<div class='dataTables_paginate paging_bootstrap pagination pagination_mdescargo'><ul>";

    // Habilita el boton PRIMERO
    if ($primera && $cur_pagina > 1) {
        $paginador_mdescargo .= "<li p='1' id='activo'><a>Primero</a></li>";
    } else if ($primera) {
        $paginador_mdescargo .= "<li p='1' class='disabled'><a>Primero</a></li>";
    }

    //Habilita el boton ANTERIOR
    if ($anterior && $cur_pagina > 1) {
        $pre = $cur_pagina - 1;
        $paginador_mdescargo .= "<li p='$pre' id='activo'><a>Anterior</a></li>";
    } else if ($anterior) {
        $paginador_mdescargo .= "<li class='disabled'><a>Anterior</a></li>";
    }

    for ($i = $comienzo; $i <= $fin; $i++) {
        if ($cur_pagina == $i) {
            $paginador_mdescargo .= "<li p='$i' id='activo' class='active'><a>{$i}</a></li>";
        } else {
            $paginador_mdescargo .= "<li p='$i' id='activo'><a>{$i}</a></li>";
        }
    }

    //Habilita el boton SIGUIENTE
    if ($siguiente && $cur_pagina < $num_paginacion) {
        $proxima = $cur_pagina + 1;
        $paginador_mdescargo .= "<li p='$proxima' id='activo'><a>Siguiente</a></li>";
    } else if ($siguiente) {
        $paginador_mdescargo .= "<li class='disabled'><a>Siguiente</a></li>";
    }

    // Habilita el boton ULTIMO
    if ($ultima && $cur_pagina < $num_paginacion) {
        $paginador_mdescargo .= "<li p='$num_paginacion' id='activo'><a>Ultimo</a></li>";
    } else if ($ultima) {
        $paginador_mdescargo .= "<li p='$num_paginacion' class='disabled'><a>Ultimo</a></li>";
    }

    $total_string = "<span class='total' a='$num_paginacion'>Pagina <b>" . $cur_pagina . "</b> de <b>$num_paginacion</b></span>";
    
    //Contenedor de paginacion
    $paginador_mdescargo = $paginador_mdescargo . "</div></div><div class='row-fluid'><div class='span12'><div class='dataTables_info' id='DataTables_Table_0_info'>" . $total_string . "</div></div>"; 

    $response2=array('grid_mdescargo'=> $grid_mdescargo, 'paginador_mdescargo'=> $paginador_mdescargo);
    
}else{
    $grid_mdescargo = "
    <div id='padding16'>
        <div class='alert alert-block alert alert-info'>
            <h4>Resultado de la busqueda!</h4>
            <p>No hay registros</p>                         
        </div>
    </div>
    ";
    $paginador_mdescargo = "<div style='height: 50px;'></div>";
$response2=array("grid_mdescargo"=> $grid_mdescargo, "paginador_mdescargo" => $paginador_mdescargo);
}
echo json_encode($response2);
}