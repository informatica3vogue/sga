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

$sql = "SELECT act.referencia, DATE_FORMAT(act.fecha_procesamiento, '%d-%m-%Y %H:%i:%s') AS fecha_procesamiento, act.dependencia_origen, act.solicitante, act.requerimiento, DATE_FORMAT(act.fecha_finalizacion, '%d-%m-%Y %H:%i:%s') AS fecha_finalizacion FROM actividad act INNER JOIN asignacion asg ON act.id_actividad=asg.id_actividad WHERE asg.id_usuario=:txtUsuario AND act.estado = :txtEstado AND fecha_procesamiento BETWEEN :txtDesdeCCF AND DATE_ADD(:txtHastaCCF, INTERVAL 1 DAY) ORDER BY act.fecha_procesamiento DESC";
$param_list=array('txtUsuario', 'txtDesdeCCF', 'txtHastaCCF', 'txtEstado');
$response = $data->query($sql, $params, $param_list);

$sql1 = "SELECT CONCAT(nombre, ' ', apellido) AS nombre_usuario FROM usuario WHERE id_usuario = :txtUsuario"; 
$result = $data->query($sql1, array("txtUsuario" => $params["txtUsuario"]));

$html.='<head><meta charset="utf-8"/></head><body style="margin:120px 0 25px 0; height:100%; position:center;"><header style="top:0; position:fixed;"><table style="width:100%; border:solid; font-size: 10pt;">
<tr><td rowspan="3" style="width:15%;"><img src="../img/CSJ_Logo.png" width="70" height="70" style="margin-left: 20%;"></td>
<td>CORTE SUPREMA DE JUSTICIA</td></tr>
<tr><td>' . $_SESSION['dependencia'] . '</td></tr>
<tr><td>Reporte de actividades finalizadas del usuario: '.$result["items"][0]["nombre_usuario"].'.</td></tr>
</table><hr></header>';

$html.='<style type="text/css"> .normal { border: 1px solid #000; border-radius: 5px; border-collapse: collapse; width:100%; font-family: Arial, sans-serif; font-size:8pt; text-aling:center;} .normal tr, .normal td, .normal th { border: 1px solid #000; text-aling:center;} </style>';

$html.='<table class="normal">
			<thead>
				<tr>
					<th>Referencia</th>
					<th>Fecha procesamiento</th>
					<th>Dependencia </th>
					<th>Solicitante</th>
					<th>Requerimiento</th>
					<th>Fecha Finalizacion</th>
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
							<td>'.$datos["requerimiento"].'</td>
							<td>'.$datos["fecha_finalizacion"].'</td>
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

		@\$pdf->page_text(34,740,\"" . '_______________________________________________________ Pagina: {PAGE_NUM} de {PAGE_COUNT}_________________________________________________________' . "\", Font_Metrics::get_font(\"helvetica\"), 8, array(0,0,0));

	  
	  	@\$pdf->page_text(34,749, \"Generado por: \", Font_Metrics::get_font(\"helvetica\"), 8, array(0,0,0)); 
	  	@\$pdf->page_text(92,749,\"" . $_SESSION['nombre'] . "\");

	  	@\$pdf->page_text(34,758, \"Referente de: \", Font_Metrics::get_font(\"helvetica\"), 8, array(0,0,0));
	  	@\$pdf->page_text(92,758,\"" . $_SESSION['dependencia'] . "\");

	  	@\$pdf->page_text(475,749, \"Fecha Impresión: \", Font_Metrics::get_font(\"helvetica\"), 8, array(0,0,0)); 
	  	@\$pdf->page_text(542,749,\"" . date('d-m-Y') . "\");

	 	@\$pdf->page_text(475,758, \"Hora Impresión: \", Font_Metrics::get_font(\"helvetica\"), 8, array(0,0,0)); 
	  	@\$pdf->page_text(552,758,\"" . date('H:i:s') . "\");

	    } 
	</script>";

$html.='</footer>';

///echo $html;
$dompdf->load_html($html);
$dompdf->set_paper("letter", "landscape");
$dompdf->render();
if (file_put_contents('../reportes/pdfs/'. "usuarioFinalizadas" . ".pdf", $dompdf->output())){
	$response=array('success'=>true, 'link'=>"<iframe src='reportes/pdfs/" . "usuarioFinalizadas" . ".pdf' style='width:100%;min-height:100%;'></iframe>");
} else {
	$response=array('success'=>false, 'error'=>'No se pudo generar el PDF');
}
echo json_encode($response);
?>