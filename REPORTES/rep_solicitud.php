<?php
@session_start();
include("../sql/class.managerDB.php");
include("../sql/class.data.php");
require_once("../reportes/dompdf/dompdf_config.inc.php");
$data = new data();
$dompdf = new DOMPDF();

$params = $_POST;
$sql = "SELECT DATE_FORMAT(sa.fecha, '%d-%m-%Y %h:%i:%s %p') As fecha, CONCAT(us.nombre, ' ', us.apellido) AS nombre_completo, ds.cantidad, a.articulo, a.descripcion FROM solicitud_articulo sa INNER JOIN usuario us ON sa.id_usuario = us.id_usuario INNER JOIN detalle_solicitud ds ON sa.id_solicitud_articulo = ds.id_solicitud_articulo INNER JOIN articulo a ON ds.id_articulo = a.id_articulo WHERE sa.id_solicitud_articulo = :id";
$param_list=array("id");
$response = $data->query($sql, $params, $param_list);

$html='';
$html.='<head><meta charset="utf-8"/></head><body style="margin:120px 0 25px 0; height:100%; position:center;"><header style="top:0; position:fixed;"><table style="width:100%; border:solid; font-size: 10pt;">
<tr><td rowspan="3" style="width:15%;"><img src="../img/CSJ_Logo.png" width="70" height="70" style="margin-left: 20%;"></td>
<td>Corte Suprema de Justicia</td></tr>
<tr><td>'.$_SESSION["dependencia"].'</td></tr>
<tr><td>Comprobante de solicitud de insumos</td></tr>
</table></header>';

$html.='<style type="text/css"> .normal { border: 1px solid #000; border-radius: 5px; border-collapse: collapse; width:100%; font-family: Arial, sans-serif; font-size:8pt; text-aling:center;} .normal tr, .normal td, .normal th { border: 1px solid #000; text-aling:center;} </style>';

$html.='<label>Fecha: </label><label>'.$response["items"][0]["fecha"].'</label><br /><br />
		<label>Nombre: </label><label>'.$response["items"][0]["nombre_completo"].'</label><br /><br />
		<label>Articulos requeridos: </label><br>';

$html.='<table class="normal">
			<thead>
				<tr>
					<th width="30%">Articulo</th>
					<th width="15%">Cantidad</th>
					<th width="55%">Descripción</th>
				</tr>
			</thead>
			<tbody>';
if ($response['total'] > 0) {
			foreach ($response["items"] as $datos) {
			$html.='<tr>
						<td>'.$datos["articulo"].'</td>
						<td><center>'.$datos["cantidad"].'</center></td>
						<td>'.$datos["descripcion"].'</td>
					</tr>  ';
			}
}
			$html.='</tbody> </table><br><br><br><br><br><br>';

$html.='<center>Firma:_________________________________</center>
		<center>'.$response["items"][0]["nombre_completo"].'</center>';

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
	  	@\$pdf->page_text(540,758,\"" . date('h:i:s a') . "\");

	    } 
	</script>";

$html.='</footer>';

///echo $html;
$dompdf->load_html($html);
$dompdf->set_paper("letter", "portrait");
$dompdf->render();
if (file_put_contents('../reportes/pdfs/'. "comprobante".md5($_SESSION["id_usuario"])."" . ".pdf", $dompdf->output())){
  $response=array('success'=>true, 'link'=>"reportes/pdfs/" . "comprobante".md5($_SESSION["id_usuario"])."" . ".pdf?random=".md5(date('d-m-Y H:i:s'))."");
} else {
  $response=array('success'=>false, 'error'=>'Problemas con generar el PDF');
}
echo json_encode($response);
?>