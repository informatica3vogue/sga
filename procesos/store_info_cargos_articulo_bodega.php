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
    $final = 6;
    $anterior = true;
    $siguiente = true;
    $primera = true;
    $ultima = true;
    $params['start'] = $pagina * $final;
    $params['limit'] = $final;
    $paginador4 = "";
    $grid4 = "";
    $i = 0;
    
    $sql = "SELECT articulo.articulo, articulo.existencia, marca.marca FROM articulo INNER JOIN categoria ON categoria.id_categoria = articulo.id_categoria INNER JOIN marca ON marca.id_marca = articulo.id_marca WHERE articulo.id_dependencia = :id_dependencia AND categoria.id_categoria=2 ORDER BY existencia ASC";
    $param_list=array("id_dependencia");
    $response4 = $data->query($sql, $params, $param_list);

if ($response4["total"] > 0) {
    //Grid de datos del usuario     
                foreach($response4['items'] as $datos){
                    $grid4 .= "
                    <tr>
                        <td>".$datos['articulo']."</td>
                        <td>".$datos['marca']."</td>
                        <td>".$datos['existencia']."</td>                                             
                    </tr>";
                }
            
    //Total de registros de la bd para obtener total de paginas 
    $sql = "SELECT * FROM cargos";
    $response4 = $data->query($sql);
    $total = $response4["total"];
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
    $paginador4 = "<div class='dataTables_paginate paging_bootstrap pagination'><ul>";

    // Habilita el boton PRIMERO
    if ($primera && $cur_pagina > 1) {
        $paginador4 .= "<li p='1' id='activo'><a>Primero</a></li>";
    } else if ($primera) {
        $paginador4 .= "<li p='1' class='disabled'><a>Primero</a></li>";
    }

    //Habilita el boton ANTERIOR
    if ($anterior && $cur_pagina > 1) {
        $pre = $cur_pagina - 1;
        $paginador4 .= "<li p='$pre' id='activo'><a>Anterior</a></li>";
    } else if ($anterior) {
        $paginador4 .= "<li class='disabled'><a>Anterior</a></li>";
    }

    for ($i = $comienzo; $i <= $fin; $i++) {
        if ($cur_pagina == $i) {
            $paginador4 .= "<li p='$i' id='activo' class='active'><a>{$i}</a></li>";
        } else {
            $paginador4 .= "<li p='$i' id='activo'><a>{$i}</a></li>";
        }
    }

    //Habilita el boton SIGUIENTE
    if ($siguiente && $cur_pagina < $num_paginacion) {
        $proxima = $cur_pagina + 1;
        $paginador4 .= "<li p='$proxima' id='activo'><a>Siguiente</a></li>";
    } else if ($siguiente) {
        $paginador4 .= "<li class='disabled'><a>Siguiente</a></li>";
    }

    // Habilita el boton ULTIMO
    if ($ultima && $cur_pagina < $num_paginacion) {
        $paginador4 .= "<li p='$num_paginacion' id='activo'><a>Ultimo</a></li>";
    } else if ($ultima) {
        $paginador4 .= "<li p='$num_paginacion' class='disabled'><a>Ultimo</a></li>";
    }

    $total_string = "<span class='total' a='$num_paginacion'>Pagina <b>" . $cur_pagina . "</b> de <b>$num_paginacion</b></span>";
    
    //Contenedor de paginacion
    $paginador4 = $paginador4 . "</ul></nav><div id='left'>" . $total_string . "</div>";  

    $response4=array('grid4'=> $grid4, 'paginador4'=> $paginador4);
    
}else{
    $grid4 = "
    <tr>
        <td colspan='5'>
        <div id='padding16'>
            <div class='alert alert-block alert alert-info'>
                <h4>Resultado de la busqueda!</h4>
                <p>No hay registros</p>                         
            </div>
        </div>
        </td>
    </tr>
    ";
$response4=array("grid4"=> $grid4, "paginador4" => $paginador4);
}
echo json_encode($response4);
}