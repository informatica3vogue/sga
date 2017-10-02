<?php
// busqueda de actividades pendientes generales por seccion, llamada desde: actividad.php
@session_start();
include("../../php/fecha_servidor.php");
include("../../sql/class.data.php");
$data = new data();

$params = $_POST;  
$grid = "";
$params["id_seccion"] = $_SESSION["id_seccion"];
$params['txtBuscarRef']= isset($params['txtBuscar']) ? "%-".$params['txtBuscar']."-%" : "%";
$sql = "SELECT DISTINCT act.id_actividad, act.referencia, act.fecha_procesamiento, act.fecha_solicitud, act.solicitante, act.requerimiento, act.marginado, act.estado, act.referencia_origen, act.con_conocimiento, act.id_dependencia_origen, (SELECT GROUP_CONCAT(DISTINCT CONCAT(' ',INITCAP(empleado.nombre), ' ', INITCAP(empleado.apellido))) FROM empleado INNER JOIN usuario ON empleado.id_empleado=usuario.id_empleado INNER JOIN asignacion ON usuario.id_usuario = asignacion.id_usuario WHERE asignacion.id_actividad = act.id_actividad AND asignacion.estado = 1) AS asignados, IF(dep.tipo='Externa', dep.dependencia, (SELECT bddep.dependencia FROM bddependencias.dependencia bddep WHERE bddep.id_dependencia=act.id_dependencia_origen)) AS dependencia_origen
        FROM actividad act INNER JOIN asignacion asg ON act.id_actividad = asg.id_actividad 
        INNER JOIN seccion secc ON act.id_seccion = secc.id_seccion 
        INNER JOIN dependencia dep ON dep.id_dependencia=act.id_dependencia_origen 
        WHERE MATCH(act.requerimiento, act.solicitante) AGAINST(:txtBuscar) AND secc.id_seccion = :id_seccion AND act.estado='Pendiente' OR act.referencia LIKE :txtBuscarRef AND secc.id_seccion = :id_seccion AND act.estado='Pendiente' OR act.referencia_origen LIKE :txtBuscar AND secc.id_seccion = :id_seccion AND act.estado='Pendiente' ORDER BY act.fecha_procesamiento DESC";
$param_list=array("txtBuscar","id_seccion", "txtBuscarRef");
$response = $data->query($sql, $params, $param_list);

if ($response["total"] > 0) {
    $grid.="<div style='overflow-y: auto; overflow-x: hidden; height: 275px;'>";
    foreach($response['items'] as $datos){
        $grid .= "
        <div class='task high'>
            <div class='desc'>
                <div class='title'>".$datos['referencia']."</div>
                <div><h6>".substr($datos['dependencia_origen'], 0, 45)."</h6></div>
                <div>".substr($datos['requerimiento'], 0, 46)."...</div>
                <div>
                    <form action='?mod=mactividad' method='POST'>
                        <a href='#' class='label label-success' data-toggle='modal' data-target='#modal_seguimiento' title='Dar seguimiento' onclick=\"seguimiento_act(".$datos['id_actividad'].", '".$datos['solicitante']."', '".$datos['dependencia_origen']."', '".$datos['requerimiento']."')\">Dar seguimiento</a>

                        <a href='#' class='label label-warning' onclick=\"actividad_detalle(".$datos['id_actividad'].", '".$datos['referencia']."', '".date('M d, Y h:i:s a', strtotime($datos['fecha_procesamiento']))."', '".date('M d, Y', strtotime($datos['fecha_solicitud']))."', '".$datos['dependencia_origen']."', '".$datos['solicitante']."', '".$datos['requerimiento']."', '".$datos['marginado']."', '".$datos['estado']."', '".$datos['referencia_origen']."', '".$datos['con_conocimiento']."', '".$datos['asignados']."')\" data-toggle='modal' data-target='#modal_detalle_actividad' title='Ver información de actividad'>Ver actividad</a>

                        <a href='#' class='label label-info' onclick=\"store_seguimiento(1, ".$datos['id_actividad'].");\" title='Ver seguimiento'>Linea de tiempo</a>
                
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
    $grid.="</div>";
    $response=array('grid'=> $grid);
}else{
    $grid = "<br>
    <div id='padding16'>
        <div class='alert alert-block alert alert-info'>
            <center>
                <h4>No se encontraron resultados de la busqueda!</h4>
                <p></p>
            </center>                         
        </div>
    </div>
    ";
$response=array("grid"=> $grid);
}
echo json_encode($response);
?>