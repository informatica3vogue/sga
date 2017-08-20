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
$sql = "SELECT us.id_usuario,DATE_FORMAT(des.fecha,'%m-%d-%Y %H:%i:%s') AS fecha, CONCAT(us.nombre, ' ', us.apellido) AS nombre,us.cargo as cargo,dab.cantidad,art.articulo,des.observacion as observacion FROM descargo_bodega des INNER JOIN usuario us on us.id_usuario=des.id_usuario INNER JOIN descargo_articulo_bodega dab ON des.id_descargo_bodega=dab.id_descargo_bodega INNER JOIN articulo art ON dab.id_articulo=art.id_articulo WHERE des.fecha BETWEEN :txtDesdes AND DATE_ADD(:txtHastas, INTERVAL 1 DAY)";
$param_list=array('txtDesdes','txtHastas');
$response = $data->query($sql, $params, $param_list);

$html.='<head><meta charset="utf-8"/></head><body style="margin:120px 0 25px 0; height:100%; position:center;"><header style="top:0; position:fixed;"><table style="width:100%; border:solid; font-size: 10pt;">
<tr><td rowspan="3" style="width:15%;"><img src="../img/CSJ_Logo.png" width="70" height="70" style="margin-left: 20%;"></td>
<td>CORTE SUPREMA DE JUSTICIA</td></tr>
<tr><td>' . $_SESSION['dependencia'] . '</td></tr>
<tr><td>Reporte de descargos de articulos de bodega.</td></tr>
</table><hr></header>';

$html.='<style type="text/css"> .normal { border: 1px solid #000; border-radius: 5px; border-collapse: collapse; width:100%; font-family: Arial, sans-serif; font-size:8pt; text-aling:center;} .normal tr, .normal td, .normal th { border: 1px solid #000; text-aling:center;} </style>';

$html.='<table class="normal">
			<thead>
				<tr>
					<th>Fecha</th>
					<th>Solicitante</th>
					<th>Cargo</th>
					<th>Cantidad</th>
					<th>Articulo</th>
					<th>Observacion</th>
				</tr>
			</thead>
			<tbody>';

				foreach ($response["items"] as $datos) {
					$i++;
					$estilos = ($i%2==0) ? "background-color:#EEEEEE;" : "background-color:#FFFFFF;";
				$html.='<tr style="'.$estilos.'">
							<td>'.$datos["fecha"].'</td>
							<td>'.$datos["nombre"].'</td>
							<td>'.$datos["cargo"].'</td>
							<td>'.$datos["cantidad"].'</td>
							<td>'.$datos["articulo"].'</td>
							<td>'.$datos["observacion"].'</td>
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

///echo $html;
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