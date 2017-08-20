<?php

@session_start();
include("../sql/class.managerDB.php");
include("../sql/class.data.php");
$data = new data();

$params=$_POST;
if(isset($params)) {
    $pagina = $params['pagina'];
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
    
    $sql = "SELECT sec.id_seccion, sec.seccion, sec.id_dependencia, dep.abreviatura FROM seccion sec INNER JOIN dependencia dep ON sec.id_dependencia = dep.id_dependencia WHERE sec.id_dependencia=:id_dependencia LIMIT :start, :limit";
    $param_list=array('id_dependencia', 'start', 'limit');
    $response = $data->query($sql, $params, $param_list);

    $abreviatura = (isset($response["items"][0]["abreviatura"])) ? $response["items"][0]["abreviatura"] : " "; 
    if ($response["total"] > 0) {
        //Grid de datos del memorandum
        foreach($response['items'] as $datos){
            $i++;
            $grid .= "
            <tr>
                <td style='padding: 8px;'>".$i."</td>
                <td class='center' style='padding: 8px;'>".$datos['seccion']."</td>
                <td id='center' style='padding: 8px;'><a href='#' class='btn btn-info' data-toggle='modal' data-target='#modal_secc_mod' onClick=\"modificar(".$datos['id_seccion'].", '".$datos['seccion']."');\" ><i class='halflings-icon white edit'></i></a>
                <a href='#' class='btn btn-danger' data-toggle='modal' data-target='#modal_dependencia' onClick=\"eliminar(".$datos['id_seccion'].", '".$datos['seccion']."');\" ><i class='halflings-icon white trash'></i></a></td>
            </tr>";
        }

        //Total de registros de la bd para obtener total de paginas
        $sql = "SELECT * FROM seccion WHERE id_dependencia=:id_dependencia";
        $param_list=array('id_dependencia');
        $response = $data->query($sql, $params, $param_list);
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
        $paginador = "<div class='pagination'><ul>";

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

        $paginador . "</ul></div>";

        $total_string = "<span class='total' a='$num_paginacion'>Pagina <b>" . $cur_pagina . "</b> de <b>$num_paginacion</b> de <b>$total</b> registros</span>";
        
        //Contenedor de paginacion
        $paginador = "<div class='row-fluid'><div class='span6'><div class='pull-left'>" . $total_string . "</div></div><div class='span6'><div class='pull-right'>" . $paginador . "</div></div></div>";

        $response=array('grid'=> $grid, 'paginador'=> $paginador, "abreviatura" => $abreviatura);
        
    }else{
        $grid = "
        <tr>
            <td colspan='3'>
                <div id='padding16'>
                    No se encontraron registros
                </div>
            </td>
        </tr>
        ";
        $response=array("grid"=> $grid, "paginador" => $paginador, "abreviatura" => $abreviatura);
    }
echo json_encode($response);
}