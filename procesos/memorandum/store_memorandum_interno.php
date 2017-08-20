<?php
// vista de actividades pendientes generales, llamada desde: memorandum.php
@session_start();
include("../../php/fecha_servidor.php");
include("../../sql/class.data.php");
$data = new data();

$params=$_POST;
$params["id_dependencia"] = $_SESSION["id_dependencia"];
$params["id_usuario"] = $_SESSION["id_usuario"];
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
    $paginador = "";
    $grid = "";
    $i = 0;

$sql = "SELECT memo.id_memorandum, memo.tipo_memorandum, memo.referencia, memo.fecha_creacion, memo.de, (SELECT GROUP_CONCAT(CONCAT(em.nombre, ' ', em.apellido)) FROM empleado em INNER JOIN memo_interno mi ON em.id_empleado=mi.id_empleado WHERE mi.id_memorandum=memo.id_memorandum) AS para, memo.asunto, memo.descripcion, memo.con_copia FROM memorandum AS memo WHERE id_usuario=:id_usuario AND tipo_memorandum='Interno' AND id_dependencia=:id_dependencia  ORDER BY fecha_creacion DESC LIMIT :start, :limit";
$param_list=array('id_usuario', 'id_dependencia', 'start', 'limit');
$response = $data->query($sql, $params, $param_list);

if ($response["total"] > 0) {
    foreach($response['items'] as $datos){
            $grid .= "<div class='task high'>
                <div class='desc'>
                    <div class='title'>".$datos['referencia']."</div>
                    <div>".substr($datos['asunto'], 0, 46)."...</div>
                    <div>
                        <a class='label label-success' href='?mod=modmemo&id=".$datos['id_memorandum']."' title='Modificar'>Modificar</a>

                        <a class='label label-warning' target='_blank' onClick=\"verpdf(".$datos['id_memorandum'].", '".$datos['tipo_memorandum']."');\" title='Ver PDF'>Ver PDF</a>


                    </div>
                </div>
                <div class='time'>
                    <div>".date('M d, Y' ,strtotime($datos['fecha_creacion']))."</div>
                    <div>".date('h:i:s a' ,strtotime($datos['fecha_creacion']))."</div>
                     </div>
            </div>";
    }

    //Total de registros de la bd para obtener total de paginas
    $sql = "SELECT * FROM memorandum WHERE id_usuario=:id_usuario AND tipo_memorandum='Interno'";
    $response = $data->query($sql, array("id_usuario"=>$_SESSION["id_usuario"]));
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
    $paginador = "<div class='pagination pagination_act_pen'><ul>";

            // Habilita el boton PRIMERO
    if ($primera && $cur_pagina > 1) {
        $paginador .= "<li p='1' id='activo' data-rel='tooltip' title='Primero'><a><span aria-hidden='true'>←</span></a></li>";
    } else if ($primera) {
        $paginador .= "<li p='1' class='disabled' data-rel='tooltip' title='Primero'><a><span aria-hidden='true'>←</span></a></li>";
    }

    //Habilita el boton ANTERIOR
    if ($anterior && $cur_pagina > 1) {
        $pre = $cur_pagina - 1;
        $paginador .= "<li p='$pre' id='activo' data-rel='tooltip' title='Anterior'><a><span aria-hidden='true'>&laquo;</span></a></li>";
    } else if ($anterior) {
        $paginador .= "<li class='disabled' data-rel='tooltip' title='Anterior'><a><span aria-hidden='true'>&laquo;</span></a></li>";
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
        $paginador .= "<li p='$proxima' id='activo' data-rel='tooltip' title='Siguiente'><a><span aria-hidden='true'>&raquo;</span></a></li>";
    } else if ($siguiente) {
        $paginador .= "<li class='disabled' data-rel='tooltip' title='Siguiente'><a><span aria-hidden='true'>&raquo;</span></a></li>";
    }

    // Habilita el boton ULTIMO
    if ($ultima && $cur_pagina < $num_paginacion) {
        $paginador .= "<li p='$num_paginacion' id='activo' data-rel='tooltip' title='Ultimo'><a><span aria-hidden='true'>→</span></a></li>";
    } else if ($ultima) {
        $paginador .= "<li p='$num_paginacion' class='disabled' data-rel='tooltip' title='Ultimo'><a><span aria-hidden='true'>→</span></a></li>";
    }

    $paginador . "</ul></div>";

    $total_string = "<span class='total' a='$num_paginacion'>Pagina <b>" . $cur_pagina . "</b> de <b>$num_paginacion</b> de <b>$total</b> registros</span>";
    
    //Contenedor de paginacion
    $paginador = "<div class='row-fluid'><div class='span12'><div class='pull-left'>" . $paginador . "</div></div><div class='span12'><div class='pull-left'>" . $total_string . "</div></div></div>";

    $response=array('grid'=> $grid, 'paginador'=> $paginador);
    
}else{
    $grid = "<br>
    <div id='padding16'>
        <div class='alert alert-block alert alert-info'>
            <center>
                <h4>No hay actividades pendientes!</h4>
                <br>
                <p><!--<img src='img/yoshi-sleep.gif' alt='Cargando...' width='50px'>--></p>   
            </center>                      
        </div>
    </div>
    ";
$response=array("grid"=> $grid, "paginador" => $paginador);
}
echo json_encode($response);
}
?>