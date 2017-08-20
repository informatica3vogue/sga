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
    $final = 4;
    $anterior = true;
    $siguiente = true;
    $primera = true;
    $ultima = true;
    $params['start'] = $pagina * $final;
    $params['limit'] = $final;
    $paginador2 = "";
    $grid2 = "";
    $i = 0;
    
    $sql = "SELECT id_linea, linea FROM linea  ORDER BY linea ASC LIMIT :start, :limit";
    $param_list=array("start", "limit");
    $response2 = $data->query($sql, $params, $param_list);
    


if ($response2["total"] > 0) {
    //Grid de datos de permiso
   
                foreach($response2['items'] as $datos){
       $grid2 .= "
        <tr>
            <td class='sorting_1'>".$datos['linea']."</td>
           
            <td class='center' id='center'><a title='Modificar Linea' href='#' onClick=\"modificar_linea(".$datos['id_linea'].", '".$datos['linea']."');\" ><img src='img/edit_user.png' width='16px' height='16px'/></a></td>
        </tr>";
    }

    //Total de registros de la bd para obtener total de paginas
    $sql = "SELECT * FROM linea";
    $response2 = $data->query($sql);
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

    //Paginador de la grid
    $paginador = "";

     //Paginador de la grid
    $paginador2 = "<div class='dataTables_paginate paging_bootstrap pagination'><ul>";

    // Habilita el boton PRIMERO
    if ($primera && $cur_pagina > 1) {
        $paginador2 .= "<li p='1' id='activo'><a>Primero</a></li>";
    } else if ($primera) {
        $paginador2 .= "<li p='1' class='disabled'><a>Primero</a></li>";
    }

    //Habilita el boton ANTERIOR
    if ($anterior && $cur_pagina > 1) {
        $pre = $cur_pagina - 1;
        $paginador2 .= "<li p='$pre' id='activo'><a>Anterior</a></li>";
    } else if ($anterior) {
        $paginador2 .= "<li class='disabled'><a>Anterior</a></li>";
    }

    for ($i = $comienzo; $i <= $fin; $i++) {
        if ($cur_pagina == $i) {
            $paginador2 .= "<li p='$i' id='activo' class='active'><a>{$i}</a></li>";
        } else {
            $paginador2 .= "<li p='$i' id='activo'><a>{$i}</a></li>";
        }
    }

    //Habilita el boton SIGUIENTE
    if ($siguiente && $cur_pagina < $num_paginacion) {
        $proxima = $cur_pagina + 1;
        $paginador2 .= "<li p='$proxima' id='activo'><a>Siguiente</a></li>";
    } else if ($siguiente) {
        $paginador2 .= "<li class='disabled'><a>Siguiente</a></li>";
    }

    // Habilita el boton ULTIMO
    if ($ultima && $cur_pagina < $num_paginacion) {
        $paginador2 .= "<li p='$num_paginacion' id='activo'><a>Ultimo</a></li>";
    } else if ($ultima) {
        $paginador2 .= "<li p='$num_paginacion' class='disabled'><a>Ultimo</a></li>";
    }

    $total_string = "<span class='total' a='$num_paginacion'>Pagina <b>" . $cur_pagina . "</b> de <b>$num_paginacion</b></span>";
    
    //Contenedor de paginacion
    $paginador2 = $paginador2 . "</ul></div><div>" . $total_string . "</div>";  

    $response2=array('grid2'=> $grid2, 'paginador2'=> $paginador2);
    
}else{
     $grid2 = "
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
$response2=array("grid2"=> $grid2, "paginador2" => $paginador2);
}
echo json_encode($response2);
}