
<?php
@session_start();
include("../sql/class.managerDB.php");
include("../sql/class.data.php");
require_once("../reportes/dompdf/dompdf_config.inc.php");
$data = new data();
$dompdf = new DOMPDF();

$html = '';
$i = 0;
$params = $_POST;

$sql = "SELECT per.id_permiso, per.num_permiso,per.fecha_procesamiento,CONCAT(emp.nombre, ' ',emp.apellido) AS nombre_completo, DATE_FORMAT(per.fecha_dif, '%d-%m-%Y') AS f_dif, DATE_FORMAT(per.fecha_desde, '%d-%m-%Y') AS f_desde, DATE_FORMAT(per.fecha_hasta, '%d-%m-%Y') AS f_hasta, DATEDIFF(per.fecha_hasta, DATE_ADD(per.fecha_desde, INTERVAL -1 DAY)) AS dias, SEC_TO_TIME(TIME_TO_SEC(TIMEDIFF(per.hora_hasta,per.hora_desde))) AS horas,mot.motivo FROM empleado emp INNER JOIN permiso per ON emp.id_empleado = per.id_empleado INNER JOIN motivo mot ON per.id_motivo = mot.id_motivo WHERE mot.id_motivo =:txtMotivo AND per.id_empleado  =:txtNombreEmpleado and per.fecha_procesamiento BETWEEN :txtDesdeDD AND DATE_ADD(:txtHastaDD, INTERVAL 1 DAY) ORDER BY per.fecha_desde DESC";


$param_list=array('txtMotivo','txtDesdeDD','txtHastaDD','txtNombreEmpleado');
$response = $data->query($sql, $params, $param_list);

$text = ($response["total"] > 0) ? $response["items"][0]["motivo"] : " ";
$text2 = ($response["total"] > 0) ? $response["items"][0]["nombre_completo"] : " ";

$html.='<head><meta charset="utf-8"/></head><body style="margin:100px 0 25px 0; height:100%; position:center;"><header style="top:0; position:fixed;"><table style="width:100%; border:solid; font-size: 10pt;">
<tr><td rowspan="3" style="width: 10%;"><img src="../img/CSJ_Logo.png" width="65" height="65" style="margin-left: 15%;"></td>
<td>CORTE SUPREMA DE JUSTICIA</td></tr>
<tr><td>'.$_SESSION["dependencia"].'</td></tr>
<tr><td>Reporte de permiso por: '.$text.', del empleado: '.$text2.'</td></tr>
</table><hr></header>';

$html.='<style type="text/css"> .normal { border: 1px solid #000; border-radius: 5px; border-collapse: collapse; width:100%; font-family: Arial, sans-serif; font-size:8pt; text-aling:center;} .normal tr, .normal td, .normal th { border: 1px solid #000; text-aling:center;} </style>';

$html.='<table class="normal">
            <thead>
                <tr>
                    <th># de permiso</th>
                    <th>Empleado</th>
                    <th>Feha de solicitud</th>
                    <th>Desde</th>
                    <th>Hasta</th>
                    <th>Dias solicitados</th>
                    <th>Horas solicitadas</th>
                </tr>
            </thead>
            <tbody>';

                foreach ($response["items"] as $datos) {
                    $i++;
                    $estilos = ($i%2==0) ? "background-color:#EEEEEE;" : "background-color:#FFFFFF;";
                $html.='<tr style="'.$estilos.'">
                            <td>'.$datos["num_permiso"].'</td>
                            <td>'.$datos["nombre_completo"].'</td>
                            <td>'.$datos["f_dif"].'</td>
                            <td>'.$datos["f_desde"].'</td>
                            <td>'.$datos["f_hasta"].'</td>
                            <td>'.$datos["dias"].'</td>
                            <td>'.$datos["horas"].'</td>
                        </tr>';
                }
                
        $html.='<tr>
                    <th colspan="6" style="color: blue; text-align: right;">Total: </th>
                    <th style="color: blue;">'.$response["total"].'</th>
                </tr>
            </tbody>
        </table>';

$html.='<footer>';

    $html.="<script type=\"text/php\"> 
      if ( isset(\$pdf) ) { 
        @\$pdf->page_text(40,550,\"" . '__________________________________________________________________________ Pagina: {PAGE_NUM} de {PAGE_COUNT}__________________________________________________________________________ ' . "\", Font_Metrics::get_font(\"helvetica\"), 8, array(0,0,0));
        @\$pdf->page_text(40,565, \"Generado por: \", Font_Metrics::get_font(\"helvetica\"), 8, array(0,0,0)); 
        @\$pdf->page_text(106,565,\"" . $_SESSION["nombre"] . "\");

        @\$pdf->page_text(40,580, \"Referente de: \", Font_Metrics::get_font(\"helvetica\"), 8, array(0,0,0));
        @\$pdf->page_text(106,580,\"" . $_SESSION["dependencia"] . "\");

        @\$pdf->page_text(645,565, \"Fecha Impresión: \", Font_Metrics::get_font(\"helvetica\"), 8, array(0,0,0)); 
        @\$pdf->page_text(710,565,\"" . date('d-m-Y') . "\");

        @\$pdf->page_text(645,580, \"Hora Impresión \", Font_Metrics::get_font(\"helvetica\"), 8, array(0,0,0)); 
        @\$pdf->page_text(720,580,\"" . date('H:i:s') . "\");

        } 
    </script>";

$html.='</footer></body>';

//echo $html;
$dompdf->load_html($html);
$dompdf->set_paper("letter", "landscape");
$dompdf->render();
if (file_put_contents('../reportes/pdfs/'. "file".$_SESSION["id_usuario"]."" . ".pdf", $dompdf->output())){
    $response=array('success'=>true, 'link'=>"<iframe src='reportes/pdfs/" . "file".$_SESSION["id_usuario"]."" . ".pdf?random=".md5(date('d-m-Y H:i:s'))."' style='width:100%;min-height:100%;'></iframe>");
} else {
    $response=array('success'=>false, 'error'=>'No se pudo generar el PDF');
}
echo json_encode($response);
?>
