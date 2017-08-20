<?php
@session_start();

include("../sql/class.data.php");
include("../php/fecha_servidor.php");
require_once("../reportes/dompdf/dompdf_config.inc.php");
$_POST["id_dependencia"] = $_SESSION['id_dependencia'];
$params = $_POST;
$dompdf = new DOMPDF();

$html='<html><head><meta http-equiv="Content-Type" content="text/html; charset=UTF-8" /><title>[titulo]</title><meta name="Description" content="[descripcion]" /><meta name="Author" content="[autor]" /></head><body style="border:0px green solid;margin:1mm 0em 3em 0em; font-family: Arial, Helvetica, sans-serif; text-align: justify; font-size: 9pt; line-height: 150%;">[header] <hr style="border-top: 2px solid #2E9AFE; border-bottom: 2px solid #2E9AFE; border-left:none; border-right:none; height: 6px; width: 100%;"><br>[style_css][contenido] <br><br> [footer] </body></html>';

$elementos=array(
    array('nombre' => '[header]', 'valor' => header_page()),
    array('nombre' => '[style_css]', 'valor' => style_css()),
    array('nombre' => '[footer]', 'valor' => footer_page())
);
if ($params['txtEstado'] == 'Pendiente') {
    array_push($elementos, array('nombre' => '[contenido]', 'valor' => contenido_pendiente()));
}else{
    array_push($elementos, array('nombre' => '[contenido]', 'valor' => contenido_finalizada()));
}

foreach($elementos as $elemento){
    $html=str_replace($elemento['nombre'], $elemento['valor'], $html);
}

$dompdf->load_html($html);
$dompdf->set_paper("letter", "landscape");
$dompdf->render();

if (file_put_contents("../reportes/pdfs/file".$_SESSION["id_usuario"].".pdf", $dompdf->output())){
  $response=array('success'=>true, 'link'=>"<iframe src='reportes/pdfs/file".$_SESSION["id_usuario"].".pdf?random=".md5(date('d-m-Y H:i:s'))."' style='width:100%;min-height:100%;'></iframe>", 'url'=>"reportes/pdfs/file".$_SESSION["id_usuario"].".pdf?random=".md5(date('d-m-Y H:i:s'))."");
} else {
  $response=array('success'=>false, 'error'=>'No se pudo generar el PDF');
}

echo json_encode($response);

/*---------------------------------------------FUNCIONES PARA LLENAR REPORTE-----------------------------------------------------------------------------*/

function header_page(){
    $params = $_POST;
    $params["txtEstado"] = ($params["txtEstado"] == 'Finalizado') ? 'Finalizada' : $params["txtEstado"];
    $html="
        <header style='height:25mm;border:0px green solid;'>
            <div style='float:left;width:100%;height:25mm;position:absolute;display:inline;border:0px red solid;text-align:center;font-weight:bold;margin-left:0;'>
                <h3>
                  Corte Suprema de Justicia<br>
                  [dependencia]<br>
                  Reporte de actividades ".strtolower($params['txtEstado'])."s Desde: ".date('d-m-Y',strtotime($params['desde']))." Hasta: ".date('d-m-Y',strtotime($params['hasta'])).".
                </h3>
            </div>
            <div style='position:absolute;display:inline;margin-right:90%;float:right;width:10%;height:25mm;border:0px blue solid;'>
              <center>
              <img src='../img/CSJ_Logo.png' style='height:20mm;width:20mm;margin-top:2mm; '>
              </center>
            </div>
        </header>
    ";   
    $html=str_replace("[dependencia]", $_SESSION["dependencia"], $html);  
    return $html;
}

//----------------------------------------------------- En caso que el estado sea pendiente se mandaran a llamar estas funciones -------------------------------------------------//

function contenido_pendiente(){
    $html='
        <table class="normal">
            <thead>
                <tr>
                    <th>Referencia</th>
                    <th>Fecha procesamiento</th>
                    <th>Dependencia solicitante</th>
                    <th>Solicitante</th>
                    <th>Requerimiento</th>
                    <th>usuarios asignados</th>
                </tr>
            </thead>
            <tbody>
                [registros]
            </tbody>
        </table>
    ';
    $html=str_replace("[registros]", registros_pendiente(), $html); 
    return $html;
}

function registros_pendiente(){
    $data = new data();
    $params = $_POST;
    $i = 0;
    $html = '';
    $sql = "SELECT a.id_actividad, a.referencia, DATE_FORMAT(a.fecha_procesamiento, '%d-%m-%Y %H:%i:%s') AS fecha_procesamiento, a.estado, a.solicitante, a.requerimiento, IF(a.fecha_finalizacion != NULL OR a.fecha_finalizacion!= '', DATE_FORMAT(a.fecha_finalizacion, '%d-%m-%Y %H:%i:%s'), 'No finalizada') AS fecha_finalizacion, (SELECT GROUP_CONCAT(DISTINCT CONCAT(' ',INITCAP(empleado.nombre), ' ', INITCAP(empleado.apellido))) FROM empleado INNER JOIN usuario ON empleado.id_empleado=usuario.id_empleado INNER JOIN asignacion ON usuario.id_usuario = asignacion.id_usuario WHERE asignacion.id_actividad = a.id_actividad) AS usuarios, IF(d.tipo='Externa', d.dependencia, (SELECT bddep.dependencia FROM bddependencias.dependencia bddep WHERE bddep.id_dependencia=a.id_dependencia_origen)) AS dependencia_origen 
        FROM actividad a INNER JOIN seccion s ON a.id_seccion = s.id_seccion 
        INNER JOIN dependencia d ON d.id_dependencia=a.id_dependencia_origen  
        WHERE a.fecha_procesamiento BETWEEN :desde AND DATE_ADD(:hasta, INTERVAL 1 DAY) AND s.id_dependencia = :id_dependencia AND a.estado = :txtEstado ORDER BY a.fecha_procesamiento DESC";
    $param_list=array('desde', 'hasta', 'id_dependencia', 'txtEstado');
    $response = $data->query($sql, $params, $param_list);
    if ($response["total"] > 0) {
        foreach ($response["items"] as $datos) {
            $i++;
            $estilos = ($i%2==0) ? "background-color:#EEEEEE;" : "background-color:#FFFFFF;";
            $html.='
                <tr style="'.$estilos.'">
                    <td>'.$datos["referencia"].'</td>
                    <td>'.$datos["fecha_procesamiento"].'</td>
                    <td>'.$datos["dependencia_origen"].'</td>
                    <td>'.$datos["solicitante"].'</td>
                    <td>'.$datos["requerimiento"].'</td>
                    <td>'.$datos['usuarios'].'</td>
                </tr>
            ';
        }
        $html.='
            <tr>
                <th colspan="6" style="color: black; text-align: right;"><center>Total de actividades: <span style="color: blue;">   <b>'.$response["total"].'</b></span></center></th>
            </tr>
        ';
    }
    return $html;
}

//----------------------------------------------------- En caso que el estado sea finalizada se mandaran a llamar estas funciones -------------------------------------------------//

function contenido_finalizada(){
    $html='
        <table class="normal">
            <thead>
                <tr>
                    <th>Referencia</th>
                    <th>Fecha procesamiento</th>
                    <th>Fecha finalizacion</th>
                    <th>Dependencia solicitante</th>
                    <th>Solicitante</th>
                    <th>Requerimiento</th>
                    <th>usuarios asignados</th>
                </tr>
            </thead>
            <tbody>
                [registros]
            </tbody>
        </table>
    ';
    $html=str_replace("[registros]", registros_finalizada(), $html); 
    return $html;
}

function registros_finalizada(){
    $data = new data();
    $params = $_POST;
    $i = 0;
    $html = '';
    $sql = "SELECT a.id_actividad, a.referencia, DATE_FORMAT(a.fecha_procesamiento, '%d-%m-%Y %H:%i:%s') AS fecha_procesamiento, a.estado, a.solicitante, a.requerimiento, IF(a.fecha_finalizacion != NULL OR a.fecha_finalizacion!= '', DATE_FORMAT(a.fecha_finalizacion, '%d-%m-%Y %H:%i:%s'), 'No finalizada') AS fecha_finalizacion, (SELECT GROUP_CONCAT(DISTINCT CONCAT(' ',INITCAP(empleado.nombre), ' ', INITCAP(empleado.apellido))) FROM empleado INNER JOIN usuario ON empleado.id_empleado=usuario.id_empleado INNER JOIN asignacion ON usuario.id_usuario = asignacion.id_usuario WHERE asignacion.id_actividad = a.id_actividad) AS usuarios, IF(d.tipo='Externa', d.dependencia, (SELECT bddep.dependencia FROM bddependencias.dependencia bddep WHERE bddep.id_dependencia=a.id_dependencia_origen)) AS dependencia_origen 
        FROM actividad a INNER JOIN seccion s ON a.id_seccion = s.id_seccion 
        INNER JOIN dependencia d ON d.id_dependencia=a.id_dependencia_origen  
        WHERE a.fecha_procesamiento BETWEEN :desde AND DATE_ADD(:hasta, INTERVAL 1 DAY) AND s.id_dependencia = :id_dependencia AND a.estado = :txtEstado ORDER BY a.fecha_procesamiento DESC";
    $param_list=array('desde', 'hasta', 'id_dependencia', 'txtEstado');
    $response = $data->query($sql, $params, $param_list);
    if ($response["total"] > 0) {
        foreach ($response["items"] as $datos) {
            $i++;
            $estilos = ($i%2==0) ? "background-color:#EEEEEE;" : "background-color:#FFFFFF;";
            $html.='
                <tr style="'.$estilos.'">
                    <td>'.$datos["referencia"].'</td>
                    <td>'.$datos["fecha_procesamiento"].'</td>
                    <td>'.$datos["fecha_finalizacion"].'</td>
                    <td>'.$datos["dependencia_origen"].'</td>
                    <td>'.$datos["solicitante"].'</td>
                    <td>'.$datos["requerimiento"].'</td>
                    <td>'.$datos['usuarios'].'</td>
                </tr>
            ';
        }
        $html.='
            <tr>
                <th colspan="5" style="color: black; text-align: right;"><center>Total de actividades: <span style="color: blue;">   <b>'.$response["total"].'</b></span></center></th>
            </tr>
        ';
    }
    return $html;
}
//------------------------------------------------------------------------- Estilos y pie de paginas -----------------------------------------------------------------------//

function style_css(){
    $html='
        <style type="text/css">
         .normal { 
            border: 1px solid #000; 
            border-radius: 5px; 
            border-collapse: collapse; 
            width:100%; font-family: Arial, sans-serif; 
            font-size:8pt; 
            text-aling:center;
         } 
         .normal tr, .normal td, .normal th { 
            border: 1px solid #000; 
            text-aling:center;
         } 
        </style>
    ';
    return $html;
}

function footer_page(){
    $html="
        <script type=\"text/php\"> 
          if ( isset(\$pdf) ) { 
            @\$pdf->page_text(300,580,\"" . ' Pagina: {PAGE_NUM} de {PAGE_COUNT}' . "  - - - -  Impreso el " . date('d-m-Y') . " a las " . date('H:i:s') . "\", Font_Metrics::get_font(\"helvetica\"), 8, array(0,0,0));
          } 
        </script>
    ";
  return $html;
}
?>