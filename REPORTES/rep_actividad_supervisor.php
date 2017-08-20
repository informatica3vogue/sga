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
$params["id_seccion"] = $_SESSION["id_seccion"];
$sql = "SELECT act.id_actividad, act.referencia, DATE_FORMAT(act.fecha_procesamiento, '%d-%m-%Y %H:%i:%s') AS fecha_procesamiento, act.dependencia_origen, act.solicitante, act.requerimiento, if(act.fecha_finalizacion ='' OR act.fecha_finalizacion IS NULL,'No finalizada', DATE_FORMAT(act.fecha_finalizacion, '%d-%m-%Y %H:%i:%s')) AS fecha_finalizacion FROM seccion sec INNER JOIN actividad act ON sec.id_seccion = act.id_seccion WHERE act.referencia = :txtReferencia AND act.id_seccion = :id_seccion ORDER BY fecha_procesamiento DESC";
$param_list=array('id_seccion', 'txtReferencia');
$response = $data->query($sql, $params, $param_list);

if ($response['total'] > 0) {
	$sql2 = "SELECT GROUP_CONCAT(CONCAT(' ', us.nombre, ' ', us.apellido)) AS usuarios FROM usuario us INNER JOIN asignacion asg ON us.id_usuario=asg.id_usuario WHERE asg.id_actividad = :id_actividad";
	$result = $data->query($sql2, array('id_actividad' => $response['items'][0]['id_actividad']));

	$sql3 = "SELECT seg.fecha_seguimiento, seg.accion_realizada, CONCAT( us.nombre, ' ', us.apellido) AS usuario FROM usuario us INNER JOIN seguimiento seg ON us.id_usuario=seg.id_usuario WHERE seg.id_actividad = :id_actividad ORDER BY fecha_seguimiento DESC";
	$respuesta = $data->query($sql3, array('id_actividad' => $response['items'][0]['id_actividad']));
}

$html.='<head><meta charset="utf-8"/></head><body style="margin:120px 0 25px 0; height:100%; position:center;"><header style="top:0; position:fixed;"><table style="width:100%; border:solid; font-size: 10pt;">
<tr><td rowspan="3" style="width:15%;"><img src="../img/CSJ_Logo.png" width="70" height="70" style="margin-left: 20%;"></td>
<td>CORTE SUPREMA DE JUSTICIA</td></tr>
<tr><td>' . $_SESSION['dependencia'] . '</td></tr>
<tr><td>Reporte de actividad con numero de referencia: '.$params["txtReferencia"].'.</td></tr>
</table><hr></header>';

$html.='<style type="text/css"> .normal { border: 1px solid #000; border-radius: 5px; border-collapse: collapse; width:100%; font-family: Arial, sans-serif; font-size:8pt; text-aling:center;} .normal tr, .normal td, .normal th { border: 1px solid #000; text-aling:center;} </style>';

if ($response['total'] > 0) {
$html.='<table class="normal">
			<thead>
				<tr>
					<th>Referencia</th>
					<th>Fecha procesamiento</th>
					<th>Dependencia solicitante</th>
					<th>Solicitante</th>
					<th>Requerimiento</th>
					<th>usuarios asignadas</th>
					<th>Fecha Finalizacion</th>
				</tr>
			</thead>
			<tbody>';

				foreach ($response["items"] as $datos) {
				$html.='<tr>
							<td>'.$datos["referencia"].'</td>
							<td>'.$datos["fecha_procesamiento"].'</td>
							<td>'.$datos["dependencia_origen"].'</td>
							<td>'.$datos["solicitante"].'</td>
							<td>'.$datos["requerimiento"].'</td>
							<td>'.$result['items'][0]['usuarios'].'</td>
							<td>'.$datos["fecha_finalizacion"].'</td>
						</tr> 
					 </tbody>
					</table> 
		';
				}
		$html.='
						<table class="normal">
							<thead>
								<tr>
									<th colspan="3">Detalle de seguimientos</th>
								</tr>
							</thead>
							<tbody>
								<tr>
									<th>Usuario</th>
									<th>Accion</th>
									<th>Fecha</th>
								</tr>';
								foreach ($respuesta["items"] as $datos1) {
									$i++;
									$estilos = ($i%2==0) ? "background-color:#EEEEEE;" : "background-color:#FFFFFF;";
							$html.='<tr style="'.$estilos.'">
										<td>'.$datos1["usuario"].'</td>
										<td>'.$datos1["accion_realizada"].'</td>
										<td>'.$datos1["fecha_seguimiento"].'</td>
									</tr>';
								}
						$html.='<tr>
									<th colspan="2" style="color: blue; text-align: right;">Total de seguimientos: </th>
									<th style="color: blue;">'.$respuesta["total"].'</th>
								</tr>
							</tbody>
						</table>
			
			';

}else{
	$html.='<center><label>No se encontraron resultados</label></center>';
}

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