<?php
// busqueda de actividades pendientes generales, llamada desde: actividad.php
@session_start();
include("../../php/fecha_servidor.php");
include("../../sql/class.data.php");
$data = new data();

$params = $_POST;  
$grid = "";
$params["id_usuario"] = $_SESSION["id_usuario"];
$params["id_dependencia"] = $_SESSION["id_dependencia"];
$params['referencia']= isset($params['txtBuscar_externo']) ? "%-".$params['txtBuscar_externo']."-%" : "%";
$sql = "SELECT id_memorandum, tipo_memorandum, referencia, fecha_creacion, de, para, asunto, descripcion, con_copia FROM memorandum WHERE id_usuario= :id_usuario AND tipo_memorandum = 'Externo' AND MATCH(para, de, asunto) AGAINST(:txtBuscar_externo) OR id_usuario= :id_usuario AND tipo_memorandum = 'Externo' AND referencia LIKE :referencia ORDER BY fecha_creacion DESC";
$param_list=array("txtBuscar_externo","id_usuario", "referencia");
$response = $data->query($sql, $params, $param_list);

if ($response["total"] > 0) {
    $grid.="<div style='overflow-y: auto; overflow-x: hidden; height: 275px;'>";
    foreach($response['items'] as $datos){
            $grid .= "<div class='task low'>
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
    $grid.="</div>";
    $response = array('grid2'=> $grid);
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
$response = array("grid2"=> $grid);
}
echo json_encode($response);
?>