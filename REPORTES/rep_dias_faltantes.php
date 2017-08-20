
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



$sql = "SELECT DISTINCT p.id_motivo,m.motivo, p.id_empleado, p.id_motivo, (SELECT SUM(ABS(DATEDIFF(fecha_desde, DATE_ADD(fecha_hasta, INTERVAL 1 DAY)))) FROM permiso WHERE id_motivo=p.id_motivo AND id_empleado=p.id_empleado) AS dias_solicitados, SEC_TO_TIME(TIME_TO_SEC(TIMEDIFF(p.hora_hasta, p.hora_desde))) AS horas, CONCAT(e.nombre,' ',e.apellido) AS nombre, m.motivo FROM ((permiso p INNER JOIN empleado e on p.id_empleado = e.id_empleado) INNER JOIN motivo m ON p.id_motivo = m.id_motivo) WHERE p.id_empleado=:txtNombreEmp  ORDER BY  nombre DESC";

$param_list=array('txtNombreEmp');
$response = $data->query($sql, $params);

$text = ($response["total"] > 0) ? $response["items"][0]["nombre"] : " ";
$html.='<head><meta charset="utf-8"/></head><body style="margin:100px 0 25px 0; height:100%; position:center;"><header style="top:0; position:fixed;"><table style="width:100%; border:solid; font-size: 10pt;">
<tr><td rowspan="3" style="width: 10%;"><img src="../img/CSJ_Logo.png" width="65" height="65" style="margin-left: 15%;"></td>
<td>CORTE SUPREMA DE JUSTICIA</td></tr>
<tr><td>'.$_SESSION["dependencia"].'</td></tr>
<tr><td>Reporte de permiso por: '.$text.'</td></tr>
</table><hr></header>';

$html.='<style type="text/css"> .normal { border: 1px solid #000; border-radius: 5px; border-collapse: collapse; width:100%; font-family: Arial, sans-serif; font-size:8pt; text-aling:center;} .normal tr, .normal td, .normal th { border: 1px solid #000; text-aling:center;} </style>';

$html.='<table class="normal">
            <thead>
                <tr>
                    <th>Motivo</th>
                    <th>Dias solicitados</th>
                    <th>Horas solicitadas</th>
                    <th>Días restantes</th>
                    <th>Horas restantes</th>
                </tr>
            </thead>
            <tbody>';


                   if ($response["total"] > 0) {
                foreach($response['items'] as $datos){
               
                    $dias=$datos['dias_solicitados'];
                    $mot = $datos['id_motivo'];
                    $dlH = $datos['horas']*0.04167;
                    $diasH=$dias+$dlH;
                    
                    if($mot == 1){
                        $d= 15- $diasH;
                        $diast=intval(15-$diasH);
                        //conversion dias a horas
                         $h=$d-$diast;
                        $h2=$h*24;
                        $horast=round($h2,2);
                    } elseif ($mot == 2){
                        $d= 90- $diasH;
                        $diast=intval(90-$diasH);
                        //conversion dias a horas
                        $h=$d-$diast;
                        $h2=$h*24;
                        $horast=round($h2,2);
                    }elseif ($mot == 3) {
                        $d= 90- $diasH;
                        $diast=intval(90-$diasH);
                        //conversion dias a horas
                         $h=$d-$diast;
                        $h2=$h*24;
                        $horast=round($h2,2);
                    }elseif ($mot==4) {
                         $d= 20- $diasH;
                         $diast=intval(20-$diasH);
                         //conversion dias a horas
                         $h=$d-$diast;
                        $h2=$h*24;
                        $horast=round($h2,2);
                    }elseif ($mot==6) {
                        $d= 5- $diasH; 
                        $diast=intval(5-$diasH);
                        //conversion dias a horas
                         $h=$d-$diast;
                        $h2=$h*24;
                        $horast=round($h2,2);
                    }elseif ($mot==7) {
                        $d= 3- $diasH;
                           $diast=intval(3-$diasH);
                           //conversion dias a horas
                            $h=$d-$diast;
                        $h2=$h*24;
                        $horast=round($h2,2);
                    }elseif ($mot==8) {
                      $d= 3- $diasH;
                         $diast=intval(3-$diasH); 
                         //conversion dias a horas
                         $h=$d-$diast;
                        $h2=$h*24;
                        $horast=round($h2,2);            
                    }else{
                        $diast=$diasH;
                        $diast=$diasH;
                    }
                      $html.='<tr>   
                            <td>'.$datos['motivo'].'</td>             
                            <td>'.$datos['dias_solicitados'].'</td>
                            <td>'.$datos['horas'].'</td>
                            <td>'.$diast.'</td>
                            <td>'.$horast.'</td>
                        </tr>';                
                    }
    }
        $html.='<tr>
                    <th colspan="4" style="color: blue; text-align: right;">Total: </th>
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