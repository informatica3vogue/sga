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

$sql = "SELECT id_actividad, referencia, DATE_FORMAT(fecha_procesamiento, '%d-%m-%Y %H:%i:%s') AS fecha_procesamiento, dependencia_origen, solicitante, requerimiento, DATE_FORMAT(fecha_finalizacion, '%d-%m-%Y %H:%i:%s') AS fecha_finalizacion FROM actividad WHERE id_seccion = :txtSeccion AND estado = :txtEstados AND fecha_procesamiento BETWEEN :txtDesde AND DATE_ADD(:txtHasta, INTERVAL 1 DAY) ORDER BY fecha_procesamiento DESC";
$param_list=array('txtSeccion', 'txtDesde', 'txtHasta', 'txtEstados');
$response = $data->query($sql, $params, $param_list);

$html.='<head><meta charset="utf-8"/></head><body style="margin:100px 0 25px 0; height:100%; position:center;"><header style="top:0; position:fixed;"><table style="width:100%; border:solid; font-size: 10pt;">
<tr><td rowspan="3" style="width: 10%;"><img src="../img/CSJ_Logo.png" width="65" height="65" style="margin-left: 15%;"></td>
<td>CORTE SUPREMA DE JUSTICIA</td></tr>
<tr><td>'.$_SESSION["dependencia"].'</td></tr>
<tr><td>Reporte actividades pendientes Desde: '.date("d-m-Y",strtotime($params["txtDesde"])).' Hasta: '.date("d-m-Y",strtotime($params["txtHasta"])).'.</td></tr>
</table><hr></header>';

$html.='<style type="text/css"> .normal { border: 1px solid #000; border-radius: 5px; border-collapse: collapse; width:100%; font-family: Arial, sans-serif; font-size:8pt; text-aling:center;} .normal tr, .normal td, .normal th { border: 1px solid #000; text-aling:center;} </style>';

$html.='<table class="normal">
			<thead>
				<tr>
					<th>Referencia</th>
					<th>Fecha procesamiento</th>
					<th>Dependencia solicitante</th>
					<th>Solicitante</th>
					<th>Requerimiento</th>
					<th>usuarios asignadas</th>
				</tr>
			</thead>
			<tbody>';

				foreach ($response["items"] as $datos) {
					$i++;
					$estilos = ($i%2==0) ? "background-color:#EEEEEE;" : "background-color:#FFFFFF;";
				$html.='<tr style="'.$estilos.'">
							<td>'.$datos["referencia"].'</td>
							<td>'.$datos["fecha_procesamiento"].'</td>
							<td>'.$datos["dependencia_origen"].'</td>
							<td>'.$datos["solicitante"].'</td>
							<td>'.$datos["requerimiento"].'</td>';
							$sql2 = "SELECT GROUP_CONCAT(CONCAT(' ', us.nombre, ' ', us.apellido)) AS usuarios FROM usuario us INNER JOIN asignacion asg ON us.id_usuario=asg.id_usuario WHERE asg.id_actividad = :id_actividad";
							$result = $data->query($sql2, array('id_actividad' => $datos["id_actividad"]));
							$html.='<td>'.$result['items'][0]['usuarios'].'</td>
						</tr>';
				}
				
		$html.='<tr>
					<th colspan="5" style="color: blue; text-align: right;">Total: </th>
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