<?php
// linea de tiempo, llamado desde: actividad.php
@session_start();
include("../../sql/class.data.php");
$data = new data();

$params=$_POST;
$params["id_usuario"] = $_SESSION["id_usuario"];
if(isset($params)) {  
    $paginador3 = "";
    $grid3 = "";
    $i = 0;
    $color = "";
    $referencia ="";
    $orientacion = "class='timeslot'";

    $sql = "SELECT actividad.id_actividad, IF(actividad.id_usuario_recepcion!='',CONCAT(INITCAP(empleado.nombre),' ', INITCAP(empleado.apellido)), '') AS usuario_recepcion, actividad.requerimiento, actividad.fecha_procesamiento, actividad.estado, actividad.referencia, IF(dependencia.tipo='Externa', dependencia.dependencia, (SELECT bddep.dependencia FROM bddependencias.dependencia bddep WHERE bddep.id_dependencia=actividad.id_dependencia_origen)) AS dependencia_origen 
            FROM actividad INNER JOIN seccion ON actividad.id_seccion = seccion.id_seccion 
            INNER JOIN dependencia ON dependencia.id_dependencia=actividad.id_dependencia_origen 
            LEFT JOIN usuario ON actividad.id_usuario_recepcion=usuario.id_usuario 
            LEFT JOIN empleado ON empleado.id_empleado=usuario.id_empleado
            WHERE actividad.id_actividad= :id_actividad";
    $param_list=array("id_actividad");
    $response_actividad = $data->query($sql, $params, $param_list);

    $sql = "SELECT act.id_actividad, seg.id_seguimiento, CONCAT(INITCAP(emp.nombre),' ', INITCAP(emp.apellido)) AS nombre_usuario, seg.accion_realizada, seg.fecha_seguimiento, DATE_FORMAT(act.fecha_finalizacion, '%d-%m-%Y  %h:%m:%s %p') AS fecha_finalizacion, act.estado, act.requerimiento, act.referencia, IF(dep.tipo='Externa', dep.dependencia, (SELECT bddep.dependencia FROM bddependencias.dependencia bddep WHERE bddep.id_dependencia=act.id_dependencia_origen)) AS dependencia_origen
            FROM empleado emp INNER JOIN usuario user ON emp.id_empleado = user.id_empleado
            INNER JOIN seguimiento seg ON user.id_usuario = seg.id_usuario 
            INNER JOIN actividad act ON seg.id_actividad = act.id_actividad
            INNER JOIN dependencia dep ON dep.id_dependencia=act.id_dependencia_origen
            WHERE act.id_actividad = :id_actividad 
            ORDER BY seg.fecha_seguimiento DESC";
    $param_list=array("id_actividad");
    $response_seguimiento = $data->query($sql, $params, $param_list);

    if ($response_actividad["total"] > 0) {
        if ($response_seguimiento["total"] > 0) {
            foreach($response_seguimiento['items'] as $datos){
                $i++;
                if ($datos["estado"]== "Finalizado") {
                    $color = ($i==1) ? "background: #EDF6FB; border-color: #51CD7D;":" ";
                }
                $orientacion = ($i%2==0) ? "class='timeslot alt'":"class='timeslot'";
                $grid3 .= "
                    <div ".$orientacion." style='height: 124px;'>
                        <div class='task'>
                            <span  style='".$color."''>
                                <span class='type'>".$datos['nombre_usuario']."</span>
                                <span class='details'>
                                   ".substr(htmlentities($datos['accion_realizada'], ENT_QUOTES,'UTF-8'), 0, 21)."...
                                </span>
                                <span>
                                    ".$datos['referencia']."
                                    <span class='remaining'>
                                        ".date('h:i:s a' ,strtotime($datos['fecha_seguimiento']))."&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href='return: false' class='label label-warning' onclick=\"detalle_seguimiento(".$datos['id_actividad'].", '".$datos['nombre_usuario']."', '".$datos['dependencia_origen']."', '".$datos['requerimiento']."', '".$datos['accion_realizada']."', '".$datos['estado']."', ".$datos['id_seguimiento'].")\" data-toggle='modal' data-target='#modal_detalle_seguimiento' title='Ver seguimiento completo'>Ver</a>
                                    </span>
                                </span>
                            </span>
                            <div class='arrow'></div>
                        </div>                          
                        <div class='icon'>
                            <i class='icon-user'></i>
                        </div>
                        <div class='time'>
                            ".date('M d, Y' ,strtotime($datos['fecha_seguimiento']))."
                        </div>  
                    </div>
                    <div class='clearfix'></div>
                ";
            }
            $referencia = "<label>".$response_seguimiento["items"][0]["referencia"]."</label>";
        }
        $orientacion = ($orientacion=="class='timeslot alt'") ? "class='timeslot'":"class='timeslot alt'";
        $grid3 .= "
            <div ".$orientacion." style='height: 124px;'>
                <div class='task'>
                    <span style='background:#EDF6FB; border-color:#E25A59;'>
                        <span class='type'>".$response_actividad['items'][0]['usuario_recepcion']."</span>
                        <span class='details'>
                           ".substr(htmlentities($response_actividad['items'][0]['requerimiento'], ENT_QUOTES,'UTF-8'), 0, 21)."...
                        </span>
                        <span>
                            ".$response_actividad['items'][0]['referencia']."
                            <span class='remaining'>
                                ".date('h:i:s a' ,strtotime($response_actividad['items'][0]['fecha_procesamiento']))."
                                &nbsp;
                                <label class='label label-info'><i class='halflings-icon white check'></i> Inicio</label>
                            </span>
                        </span>
                    </span>
                    <div class='arrow'></div>
                </div>                          
                <div class='icon'>
                    <i class='icon-user'></i>
                </div>
                <div class='time'>
                    ".date('M d, Y' ,strtotime($response_actividad['items'][0]['fecha_procesamiento']))."
                </div>  
            </div>
            <div class='clearfix'></div>
        ";
        $response=array('grid3'=> $grid3, "referencia" => $referencia);
    }else{
        $grid3 = "<br/>
        <div id='padding16'>
            <div class='alert alert-block alert alert-info'>
                <center>
                    <h4>No se encontraron seguimientos para esta actividad!</h4>
                    <br>
                    <p><!--<img src='img/pikachu.gif' alt='Cargando...' width='50px'>--></p>
                </center>                           
            </div>
        </div>
        ";
        $paginador3 = "<div style='height: 50px;'></div>";
        $response=array("grid3"=> $grid3, "referencia" => $referencia);
    }
    echo json_encode($response);
}
?>