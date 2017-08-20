<?php

@session_start();
include("../sql/class.managerDB.php");
include("../sql/class.data.php");
$data = new data();

$params=$_POST;
$params["id_dependencia"] = $_SESSION["id_dependencia"];
$params["id_usuario"] = $_SESSION["id_usuario"];
if(isset($params)) {  
    $pagina = $params["pagina"];
    $cur_pagina = $pagina;
    $pagina -= 1;
    $final = 2;
    $anterior = true;
    $siguiente = true;
    $primera = true;
    $ultima = true;
    $params['start'] = $pagina * $final;
    $params['limit'] = $final;
    $paginador = "";
    $grid = "";
    $i = 0;
    
$sql = "SELECT DISTINCT act.id_actividad, act.referencia, act.fecha_procesamiento, act.fecha_solicitud, act.dependencia_origen, act.solicitante, act.requerimiento, act.marginado, act.estado, act.referencia_origen, act.con_conocimiento, asg.fecha_asignacion, (SELECT GROUP_CONCAT(CONCAT(' ',usuario.nombre, ' ', usuario.apellido,' / ', usuario.cargo)) FROM usuario INNER JOIN asignacion ON usuario.id_usuario = asignacion.id_usuario WHERE asignacion.id_actividad = act.id_actividad) AS us_asg FROM actividad act INNER JOIN asignacion asg ON act.id_actividad=asg.id_actividad INNER JOIN usuario us ON us.id_usuario=asg.id_usuario INNER JOIN seccion secc ON secc.id_seccion = us.id_seccion WHERE secc.id_dependencia = :id_dependencia AND act.estado = :estado ORDER BY act.fecha_procesamiento DESC LIMIT :start, :limit";
$param_list=array("id_dependencia","estado","start","limit");
$response = $data->query($sql, $params, $param_list);

if ($response["total"] > 0) {
    //Grid de actividad
    $grid ="
    <div class='table-responsive'>
        <table class='table table-hover table-bordered table-condensed' style='font-size: 9pt;'>
            <thead>
                <tr>
                    <th>Acción</th>
                    <th>Referencia</th>
                    <th>Fecha de procesamiento</th>
                    <th>Fecha de solicitud</th>
                    <th>Dependencia</th>
                    <th>Solicitante</th>
                    <th>Requerimiento</th>
                    <th>Marginado</th>
                    <th>Estado</th>
                    <th>Referencia origen</th>
                    <th>Con conocimiento</th>
                    <th>Fecha de asignación</th>
                    <th>Asignados</th>
                    <th>Adjuntos</th>
                </tr> 
            </thead>
            <tbody>"; 
                foreach($response['items'] as $datos){
                    $i++;
                    if($i%2==0){ $estilos="class='info'"; }else{ $estilos=" "; }
                    $grid .= "
                    <tr ".$estilos." ondblclick=\"store_seguimiento(1, ".$datos['id_actividad'].");\">";
                        if ($datos['estado']=='Pendiente') {
                            $grid .= "<td id='center'><a href='#' title='Dar seguimiento' data-toggle='modal' data-target='#modal_seguimiento' onClick=\"seguimiento_act(".$datos['id_actividad'].", '".$datos['solicitante']."', '".$datos['dependencia_origen']."', '".$datos['requerimiento']."');\" ><img src='img/seguimiento_icon.png' width='25px' height='25px'/><br />Seguimiento</a></td>";
                        }else{
                             $grid .= "<td></td>";
                        }
                        $grid .= "
                        <td>".$datos['referencia']."</td>
                        <td>".date('d-m-Y h:i:s A' ,strtotime($datos['fecha_procesamiento']))."</td>
                        <td>".date('d-m-Y',strtotime($datos['fecha_solicitud']))."</td>
                        <td>".$datos['dependencia_origen']."</td>
                        <td>".$datos['solicitante']."</td>
                        <td>".$datos['requerimiento']."</td>
                        <td>".$datos['marginado']."</td>
                        <td>".$datos['estado']."</td>
                        <td>".$datos['referencia_origen']."</td>
                        <td>".$datos['con_conocimiento']."</td>
                        <td>".date('d-m-Y',strtotime($datos['fecha_asignacion']))."</td>
                        <td>".$datos['us_asg']."</td>
                        <td>
                    ";
                        $params['id_actividad'] = $datos['id_actividad'];
                        $sql2 = "SELECT documento FROM docu_actividad WHERE id_actividad = :id_actividad";
                        $parametros=array("id_actividad");
                        $result = $data->query($sql2, $params, $parametros);
                        if ($result["total"] > 0) {
                            foreach($result['items'] as $documentos){
                                $grid .= "
                                <a href='upload/actividades/".$documentos['documento']."', download>".$documentos['documento'].",</a>
                                ";
                            }  
                        }
                        $grid .= "</td>";
        $grid .= "</tr>";
                }
             $grid = $grid.="
            </tbody>
        </table>
    </div>
    ";

    //Total de registros de la bd para obtener total de paginas
    $sql = "SELECT * FROM actividad act INNER JOIN seccion secc ON secc.id_seccion = act.id_seccion WHERE secc.id_dependencia = :id_dependencia AND act.estado = :estado";
    $param_list=array("id_dependencia", "estado");
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
    $paginador = "<nav id='right'><ul class='pagination pagination_act'>";

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
            <p>No hay registros</p>                         
        </div>
    </div>
    ";
$response=array("grid"=> $grid, "paginador" => $paginador);
}
echo json_encode($response);
}