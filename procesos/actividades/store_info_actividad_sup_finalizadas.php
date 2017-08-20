<?php

@session_start();
include("../../sql/class.managerDB.php");
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
    $paginador2 = "";
    $grid2 = "";
    $i = 0;
    
    $sql = "SELECT DISTINCT act.id_actividad, act.referencia, act.fecha_procesamiento, act.fecha_solicitud, act.solicitante, act.requerimiento, act.marginado, act.estado, act.referencia_origen, act.con_conocimiento, act.id_dependencia_origen, (SELECT GROUP_CONCAT(DISTINCT CONCAT(' ',INITCAP(empleado.nombre), ' ', INITCAP(empleado.apellido))) FROM empleado INNER JOIN usuario ON empleado.id_empleado=usuario.id_empleado INNER JOIN asignacion ON usuario.id_usuario = asignacion.id_usuario WHERE asignacion.id_actividad = act.id_actividad AND asignacion.estado = 2) AS asignados, IF(dep.tipo='Externa', dep.dependencia, (SELECT bddep.dependencia FROM bddependencias.dependencia bddep WHERE bddep.id_dependencia=act.id_dependencia_origen)) AS dependencia_origen
        FROM actividad act INNER JOIN asignacion asg ON act.id_actividad = asg.id_actividad 
        INNER JOIN seccion secc ON act.id_seccion = secc.id_seccion 
        INNER JOIN dependencia dep ON dep.id_dependencia=act.id_dependencia_origen 
        WHERE act.id_seccion = :id_seccion AND act.estado = 'Finalizado' 
        ORDER BY act.fecha_procesamiento DESC LIMIT :start, :limit";
    $param_list=array("id_seccion","start","limit");
    $response2 = $data->query($sql, $params, $param_list);

if ($response2["total"] > 0) {
                foreach($response2['items'] as $datos){
                    $grid2 .= "
                        <div class='task low'>
                        <div class='desc'>
                            <div class='title'>".$datos['referencia']."</div>
                            <div><h6>".substr($datos['dependencia_origen'], 0, 45)."</h6></div>
                            <div>".substr($datos['requerimiento'], 0, 46)."...</div>
                            <div>
                                <a href='#' class='label label-warning' onclick=\"actividad_detalle(".$datos['id_actividad'].", '".$datos['referencia']."', '".date('M d, Y h:i:s a', strtotime($datos['fecha_procesamiento']))."', '".date('M d, Y', strtotime($datos['fecha_solicitud']))."', '".$datos['dependencia_origen']."', '".$datos['solicitante']."', '".$datos['requerimiento']."', '".$datos['marginado']."', '".$datos['estado']."', '".$datos['referencia_origen']."', '".$datos['con_conocimiento']."', '".$datos['asignados']."')\" data-toggle='modal' data-target='#modal_detalle_actividad' title='Ver información de actividad'>Ver actividad</a>

                                <a href='#' class='label label-info' onclick=\"store_seguimiento(1, ".$datos['id_actividad'].");\" title='Ver seguimiento'>Linea de tiempo</a>
                            </div>
                        </div>
                        <div class='time'>
                            <div>".date('M d, Y' ,strtotime($datos['fecha_procesamiento']))."</div>
                            <div>".date('h:i:s a' ,strtotime($datos['fecha_procesamiento']))."</div>
                        </div>
                    </div>
                    ";
                }

    //Total de registros de la bd para obtener total de paginas
    $sql = "SELECT DISTINCT * FROM actividad WHERE id_seccion = :id_seccion AND actividad.estado = 'Finalizado'";
    $param_list=array("id_seccion");
    $response2 = $data->query($sql, $params, $param_list);
    $total = $response2["total"];
    $num_paginacion = ceil($total / $final);

    //Calculando el inicio y el fin evaluando este bucle
    if ($cur_pagina >= 4) {
        $comienzo = $cur_pagina - 1;
        if ($num_paginacion > $cur_pagina + 1){
            $fin = $cur_pagina + 1;
        } else if ($cur_pagina <= $num_paginacion && $cur_pagina > $num_paginacion - 1) {
            $comienzo = $num_paginacion - 1;
            $fin = $num_paginacion;
        } else {
            $fin = $num_paginacion;
        }
    } else {
        $comienzo = 1;
        if ($num_paginacion > 4){
            $fin = 4;
        } else {
            $fin = $num_paginacion;
        }
    }
    //paginador2 de la grid2
    $paginador2 = "<div class='dataTables_paginate paging_bootstrap pagination pagination_coo_fin'><ul>";

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
    $paginador2 = $paginador2 . "</div></div><div class='row-fluid'><div class='span12'><div class='dataTables_info' id='DataTables_Table_0_info'>" . $total_string . "</div></div>";

    $response2=array('grid2'=> $grid2, 'paginador2'=> $paginador2);
    
}else{
    $grid2 = "<br>
    <div id='padding16'>
        <div class='alert alert-block alert alert-info'>
            <h4>Resultado de la busqueda!</h4>
            <p>No hay registros</p>                         
        </div>
    </div>
    ";
$response2=array("grid2"=> $grid2, "paginador2" => $paginador2);
}
echo json_encode($response2);
}


<?php
// vista de actividades finalizadas generales, llamada desde: actividad.php
@session_start();
include("../php/fecha_servidor.php");
include("../sql/class.data.php");
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
    
$sql = "SELECT DISTINCT act.id_actividad, act.referencia, act.fecha_procesamiento, act.fecha_solicitud, act.dependencia_origen, act.solicitante, act.requerimiento, act.marginado, act.estado, act.referencia_origen, act.con_conocimiento, asg.fecha_asignacion, (SELECT GROUP_CONCAT(CONCAT(' ',usuario.nombre, ' ', usuario.apellido,' / ', usuario.cargo)) FROM usuario INNER JOIN asignacion ON usuario.id_usuario = asignacion.id_usuario WHERE asignacion.id_actividad = act.id_actividad) AS us_asg FROM actividad act INNER JOIN asignacion asg ON act.id_actividad=asg.id_actividad INNER JOIN usuario us ON us.id_usuario=asg.id_usuario INNER JOIN seccion secc ON secc.id_seccion = us.id_seccion WHERE us.id_seccion = :id_seccion AND act.estado = 'Finalizado' ORDER BY act.fecha_procesamiento DESC LIMIT :start, :limit";
$param_list=array("id_seccion","start","limit");
$response = $data->query($sql, $params, $param_list);

if ($response["total"] > 0) {
    foreach($response['items'] as $datos){
        $datos['dependencia_origen'] = $data->nombre_dependencia($datos["id_dependencia_origen"]);
        $grid .= "<div class='task low' ondblclick=\"store_seguimiento(1, ".$datos['id_actividad'].");\">
            <div class='desc'>
                <div class='title'>".$datos['referencia']."</div>
                <div>".substr($datos['requerimiento'], 0, 46)."...</div>
                <div>
                    <a href='#' class='label label-warning' onclick=\"actividad_detalle(".$datos['id_actividad'].", '".$datos['referencia']."', '".date('M d, Y h:i:s a', strtotime($datos['fecha_procesamiento']))."', '".date('M d, Y', strtotime($datos['fecha_solicitud']))."', '".$datos['dependencia_origen']."', '".$datos['solicitante']."', '".$datos['requerimiento']."', '".$datos['marginado']."', '".$datos['estado']."', '".$datos['referencia_origen']."', '".$datos['con_conocimiento']."', '".$datos['asignados']."')\" data-toggle='modal' data-target='#modal_detalle_actividad' title='Ver información de actividad'>Ver actividad</a>
                    <a href='#' class='label label-important' onclick=\"cambio_estado(".$datos['id_actividad'].", '".$datos['referencia']."', '".$datos['requerimiento']."', '".$datos['estado']."')\" data-toggle='modal' data-target='#modal_cambio_estado' title='Cambiar estado a actividad'>Cambio de estado</a>
                    <a href='#' class='label label-info' onclick=\"store_seguimiento(1, ".$datos['id_actividad'].");\" title='Ver seguimiento'>Linea de tiempo</a>
                </div>
            </div>
            <div class='time'>
                <div>".ucfirst(strftime("%B %d %Y", date(strtotime($datos['fecha_procesamiento']))))."</div>
                <div>".date('h:i:s a' ,strtotime($datos['fecha_procesamiento']))."</div>
            </div>
        </div>";
    }

    //Total de registros de la bd para obtener total de paginas
    $sql = "SELECT DISTINCT * FROM actividad act INNER JOIN seccion secc ON secc.id_seccion = act.id_seccion WHERE secc.id_dependencia = :id_dependencia AND act.estado = 'Finalizado'";
    $param_list=array("id_dependencia");
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
    $paginador = "<div class='pagination pagination_act_fin'><ul>";

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

    $response=array('grid2'=> $grid, 'paginador2'=> $paginador);
    
}else{
    $grid = "<br>
    <div id='padding16'>
        <div class='alert alert-block alert alert-info'>
            <center>
                <h4>No se ha finalizado ninguna actividad!</h4>
                <br>
                <p><!--<img src='img/pikachu-sleep.gif' alt='Cargando...' width='35px'>--></p>   
            </center>                      
        </div>
    </div>
    ";
$response=array("grid2"=> $grid, "paginador2" => $paginador);
}
echo json_encode($response);
}