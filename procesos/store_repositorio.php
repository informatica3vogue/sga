<?php

@session_start();
include("../sql/class.managerDB.php");
include("../sql/class.data.php");
$data = new data();

$params=$_POST;
$params["id_usuario"] = $_SESSION["id_usuario"];
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

$sql = "SELECT r.id_repositorio, r.fecha_creacion,r.alias FROM repositorio r WHERE r.id_usuario = :id_usuario ORDER BY r.fecha_creacion DESC LIMIT :start, :limit ";
$param_list=array("id_usuario", "start","limit");
$response = $data->query($sql, $params, $param_list);

if ($response["total"] > 0) {
    //Grid de datos del usuario
    $grid ="
    <div class='table-responsive'>
        <table class='table table-hover table-bordered table-condensed'>
            <thead>
                <tr>
                    <th>Alias</th>
                    <th>Fecha de procesamiento</th>
                    <th>Archivos adjuntos</th>
                </tr> 
            </thead>
            <tbody>"; 
                foreach($response['items'] as $datos){
                    $i++;
                    if($i%2==0){ $estilos="class='info'"; }else{ $estilos=" "; }
                    $grid .= "
                    <tr ".$estilos.">
                        
                        <td>".$datos['alias']."</td>
                        <td>".date('d-m-Y',strtotime($datos['fecha_creacion']))."</td>                       
                        <td>";

                        $params['id_repositorio'] = $datos['id_repositorio'];
                        $sql2 = "SELECT documento FROM docu_repositorio WHERE id_repositorio = :id_repositorio";
                        $parametros=array("id_repositorio");
                        $result = $data->query($sql2, $params, $parametros);
                        if ($result["total"] > 0) {
                            foreach($result['items'] as $documentos){
                                $grid .= "
                                <a href='upload/repositorio/".$documentos['documento']."', download>".$documentos['documento'].",</a>
                                ";
                            }  
                        }
                         $grid .= "</td>                                 

                    </tr>";
                }
             $grid = $grid.="
            </tbody>
        </table>
    </div>
    ";

    //Total de registros de la bd para obtener total de paginas 
    $sql = "SELECT * FROM repositorio WHERE id_usuario = :id_usuario";
    $param_list=array("id_usuario");
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
    $paginador = "<nav id='right'><ul class='pagination'>";

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