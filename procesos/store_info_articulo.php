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
    $final = 3;
    $anterior = true;
    $siguiente = true;
    $primera = true;
    $ultima = true;
    $params['start'] = $pagina * $final;
    $params['limit'] = $final;
    $paginador4 = "";
    $grid4 = "";
    $i = 0;
    
    $sql = "SELECT art.id_articulo, art.articulo, art.existencia, art.descripcion, m.id_marca, m.marca, l.id_linea, l.linea, u.id_unidad, u.unidad_medida, c.id_categoria FROM articulo art INNER JOIN marca m ON art.id_marca = m.id_marca INNER JOIN linea l ON art.id_linea = l.id_linea INNER JOIN unidad u ON art.id_unidad = u.id_unidad INNER JOIN categoria c ON c.id_categoria = 1 WHERE art.id_dependencia = :id_dependencia AND art.id_categoria=1 ORDER BY art.articulo ASC";
    $param_list=array("id_dependencia");
    $response4 = $data->query($sql, $params, $param_list);

if ($response4["total"] > 0) {
    //Grid de datos del articulo
   
                foreach($response4['items'] as $datos){
                    $grid4 .= "
                    <tr>
                        <td>".$datos['articulo']."</td>                    
                        <td>".$datos['marca']."</td>                  
                        <td>".$datos['linea']."</td>
                        <td>".$datos['unidad_medida']."</td>
                        <td class='center' id='center'><a title='Modificar articulo' href='#' onClick=\"modificar_articulo(".$datos['id_articulo'].", '".$datos['articulo']."', '".$datos['descripcion']."', ".$datos['id_marca'].", ".$datos['id_linea'].", ".$datos['id_unidad'].");\" ><img src='img/edit.png' width='16px' height='16px'/></a></td>
                    </tr>";
                }            

   //Total de registros de la bd para obtener total de paginas 
    $sql = "SELECT * FROM articulo";
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
    $paginador4 = $paginador4 . "</ul></div><div>" . $total_string . "</div>";  

    $response4=array('grid4'=> $grid4, 'paginador4'=> $paginador4);
    
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
$response4=array("grid4"=> $grid4, "paginador4" => $paginador4);
}
echo json_encode($response4);
}