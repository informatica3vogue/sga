<?php
// vista de actividades pendientes generales por seccion, llamada desde: actividad.php
@session_start();
include("../../php/fecha_servidor.php");
include("../../sql/class.data.php");
$data = new data();

$params=$_POST;
$params["id_usuario"] = $_SESSION["id_usuario"];
$params["id_seccion"] = $_SESSION["id_seccion"];
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
    $paginador = "";
    $grid = "";
    $i = 0;

$sql = "SELECT DISTINCT act.id_actividad, act.referencia, act.fecha_procesamiento, act.fecha_solicitud, act.solicitante, act.requerimiento, act.marginado, act.estado, act.referencia_origen, act.con_conocimiento, act.id_dependencia_origen, (SELECT GROUP_CONCAT(DISTINCT CONCAT(' ',INITCAP(empleado.nombre), ' ', INITCAP(empleado.apellido))) FROM empleado INNER JOIN usuario ON empleado.id_empleado=usuario.id_empleado INNER JOIN asignacion ON usuario.id_usuario = asignacion.id_usuario WHERE asignacion.id_actividad = act.id_actividad AND asignacion.estado = 1) AS asignados, IF(dep.tipo='Externa', dep.dependencia, (SELECT bddep.dependencia FROM bddependencias.dependencia bddep WHERE bddep.id_dependencia=act.id_dependencia_origen)) AS dependencia_origen
        FROM actividad act INNER JOIN asignacion asg ON act.id_actividad = asg.id_actividad 
        INNER JOIN seccion secc ON act.id_seccion = secc.id_seccion 
        INNER JOIN dependencia dep ON dep.id_dependencia=act.id_dependencia_origen
        WHERE act.id_seccion = :id_seccion AND act.estado = 'Pendiente' ORDER BY act.fecha_procesamiento DESC LIMIT :start, :limit";
$param_list=array("id_seccion","start","limit");
$response = $data->query($sql, $params, $param_list);

if ($response["total"] > 0) {
    foreach($response['items'] as $datos){
        $grid .= "<div class='task high'>
            <div class='desc'>
                <div class='title'>".$datos['referencia']."</div>
                <div><h6>".substr($datos['dependencia_origen'], 0, 45)."</h6></div>
                <div>".substr($datos['requerimiento'], 0, 46)."...</div>
                <div>
                    <form action='?mod=mactividad' method='POST'>
                        <a href='#' class='label label-success' data-toggle='modal' data-target='#modal_seguimiento' title='Dar seguimiento' onclick=\"seguimiento_act(".$datos['id_actividad'].", '".$datos['solicitante']."', '".$datos['dependencia_origen']."', '".$datos['requerimiento']."', '".$datos['referencia']."')\">Dar seguimiento</a>

                        <a href='#' class='label label-warning' onclick=\"actividad_detalle(".$datos['id_actividad'].", '".$datos['referencia']."', '".date('M d, Y h:i:s a', strtotime($datos['fecha_procesamiento']))."', '".date('M d, Y', strtotime($datos['fecha_solicitud']))."', '".$datos['dependencia_origen']."', '".$datos['solicitante']."', '".$datos['requerimiento']."', '".$datos['marginado']."', '".$datos['estado']."', '".$datos['referencia_origen']."', '".$datos['con_conocimiento']."', '".$datos['asignados']."')\" data-toggle='modal' data-target='#modal_detalle_actividad' title='Ver información de actividad'>Ver actividad</a>

                        <a href='#' class='label label-info' onclick=\"store_seguimiento(1, ".$datos['id_actividad'].");\" title='Linea de tiempo'>Linea de tiempo</a>
                
                        <input type='hidden' name='id' value='".$datos['id_actividad']."'>
                        <button type='submit' class='label label-default' title='Modificar' style='border:0;'>Modificar actividad</button>
                    </form>
                </div>
            </div>
            <div class='time'>
                <div>".ucfirst(strftime("%B %d %Y", date(strtotime($datos['fecha_procesamiento']))))."</div>
                <div>".date('h:i:s a' ,strtotime($datos['fecha_procesamiento']))."</div>
            </div>
        </div>";
    }

    //Total de registros de la bd para obtener total de paginas
    $sql = "SELECT DISTINCT * FROM actividad WHERE id_seccion = :id_seccion AND actividad.estado = 'Pendiente'";
    $param_list=array("id_seccion");
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