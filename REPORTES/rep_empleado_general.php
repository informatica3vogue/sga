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
$sql = "SELECT DISTINCT p.id_motivo, p.id_empleado, e.codigo as codigo, p.id_motivo, (SELECT SUM(ABS(DATEDIFF(fecha_desde, DATE_ADD(fecha_hasta, INTERVAL 1 DAY)))) FROM permiso WHERE id_motivo=p.id_motivo AND id_empleado=p.id_empleado) AS dias_solicitados, SEC_TO_TIME(TIME_TO_SEC(TIMEDIFF(p.hora_hasta, p.hora_desde))) AS horas, CONCAT(e.nombre,' ',e.apellido) AS nombre, m.motivo as motivo FROM ((permiso p INNER JOIN empleado e on p.id_empleado = e.id_empleado) INNER JOIN motivo m ON p.id_motivo = m.id_motivo) WHERE p.id_empleado=:txtNombreEmp ORDER BY  nombre DESC";
$param_list=array('txtNombreEmp');
$response = $data->query($sql, $params, $param_list);

$html.='<head><meta charset="utf-8"/></head><body style="margin:120px 0 25px 0; height:100%; position:center;"><header style="top:0; position:fixed;"><table style="width:100%; border:solid; font-size: 10pt;">
<tr><td rowspan="3" style="width:15%;"><img src="../img/CSJ_Logo.png" width="70" height="70" style="margin-left: 20%;"></td>
<td>CORTE SUPREMA DE JUSTICIA</td></tr>
<tr><td>' . $_SESSION['dependencia'] . '</td></tr>
<tr><td>Reporte  por empleado</td></tr>
</table><hr></header>';

$html.='<style type="text/css"> .normal { border: 1px solid #000; border-radius: 5px; border-collapse: collapse; width:100%; font-family: Arial, sans-serif; font-size:8pt; text-aling:center;} .normal tr, .normal td, .normal th { border: 1px solid #000; text-aling:center;} </style>';

$html.='<table class="normal">
			<thead>
				<tr>
					<th>codigo</th>
					<th>Dias solicitados</th>
					<th>Horas</th>
					<th>Nombre</th>
					<th>Motivo</th>
				</tr>
			</thead>
			<tbody>';

				foreach ($response["items"] as $datos) {
					$i++;
					$estilos = ($i%2==0) ? "background-color:#EEEEEE;" : "background-color:#FFFFFF;";
				$html.='<tr style="'.$estilos.'">
							<td>'.$datos["codigo"].'</td>
							<td>'.$datos["dias_solicitados"].'</td>
							<td>'.$datos["horas"].'</td>
							<td>'.$datos["nombre"].'</td>
							<td>'.$datos["motivo"].'</td>
						</tr>';
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