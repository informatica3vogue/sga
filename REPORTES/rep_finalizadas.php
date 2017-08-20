<?php
@session_start();

include("../sql/class.data.php");
include("../php/fecha_servidor.php");
require_once("../reportes/dompdf/dompdf_config.inc.php");
$dompdf = new DOMPDF();

$html='<html><head><meta http-equiv="Content-Type" content="text/html; charset=UTF-8" /><title>[titulo]</title><meta name="Description" content="[descripcion]" /><meta name="Author" content="[autor]" /></head><body style="border:0px green solid;margin:1mm 0em 3em 0em; font-family: Arial, Helvetica, sans-serif; text-align: justify; font-size: 9pt; line-height: 150%;">[header] <hr style="border-top: 2px solid #2E9AFE; border-bottom: 2px solid #2E9AFE; border-left:none; border-right:none; height: 6px; width: 100%;"><br>[style_css][contenido] <br><br> [footer] </body></html>';

$elementos=array(
    array('nombre' => '[header]', 'valor' => header_page()),
    array('nombre' => '[style_css]', 'valor' => style_css()),
    array('nombre' => '[contenido]', 'valor' => contenido()),
    array('nombre' => '[footer]', 'valor' => footer_page())
);

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
	$data = new data();
	$sql = "SELECT seccion FROM seccion WHERE id_seccion = :txtSeccion"; 
	$response = $data->query($sql, array("txtSeccion" => $params["txtSeccion"]));
	$html="
		<header style='height:25mm;border:0px green solid;'>
            <div style='float:left;width:100%;height:25mm;position:absolute;display:inline;border:0px red solid;text-align:center;font-weight:bold;margin-left:0;'>
                <h3>
                  Corte Suprema de Justicia<br>
                  [dependencia]<br>
                  Reporte de actividades finalizadas, Secci&oacute;n: ".$response["items"][0]['seccion'].", Desde: ".date('d-m-Y',strtotime($params['txtDesde']))." Hasta: ".date('d-m-Y',strtotime($params['txtHasta'])).".
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

function contenido(){
	$html='
		<table class="normal">
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
			<tbody>
				[registros]
			</tbody>
		</table>
	';
	$html=str_replace("[registros]", registros(), $html); 
	return $html;
}

function registros(){
	$i = 0;
	$params = $_POST;
	$html = '';
	$data = new data();
	$sql = "SELECT id_actividad, referencia, DATE_FORMAT(fecha_procesamiento, '%d-%m-%Y %H:%i:%s') AS fecha_procesamiento, id_dependencia_origen, solicitante, requerimiento, DATE_FORMAT(fecha_finalizacion, '%d-%m-%Y %H:%i:%s') AS fecha_finalizacion FROM actividad WHERE id_seccion = :txtSeccion AND estado = :txtEstados AND fecha_procesamiento BETWEEN :txtDesde AND DATE_ADD(:txtHasta, INTERVAL 1 DAY) ORDER BY fecha_procesamiento DESC";
	$param_list=array('txtSeccion', 'txtDesde', 'txtHasta', 'txtEstados');
	$response = $data->query($sql, $params, $param_list);
	if ($response["total"] > 0) {
		foreach ($response["items"] as $datos) {
			$i++;
			$estilos = ($i%2==0) ? "background-color:#EEEEEE;" : "background-color:#FFFFFF;";
			$datos['dependencia_origen'] = $data->nombre_dependencia($datos["id_dependencia_origen"]);	
			$html.='
				<tr style="'.$estilos.'">
					<td>'.$datos["referencia"].'</td>
					<td>'.$datos["fecha_procesamiento"].'</td>
					<td>'.$datos["dependencia_origen"].'</td>
					<td>'.$datos["solicitante"].'</td>
					<td>'.$datos["requerimiento"].'</td>';
					$sql2 = "SELECT GROUP_CONCAT(CONCAT(' ', us.nombre, ' ', us.apellido)) AS usuarios FROM usuario us INNER JOIN asignacion asg ON us.id_usuario=asg.id_usuario WHERE asg.id_actividad = :id_actividad";
					$result = $data->query($sql2, array('id_actividad' => $datos["id_actividad"]));
					$html.='<td>'.$result['items'][0]['usuarios'].'</td>
					<td>'.$datos["fecha_finalizacion"].'</td>
				</tr>
			';
		}
		$html.='
			<tr>
				<th colspan="6" style="color: blue; text-align: right;">Total: </th>
				<th style="color: blue;">'.$response["total"].'</th>
			</tr>
		';
	}
	return $html;
}

function footer_page(){
  	$html="
	  	<script type=\"text/php\"> 
		  if ( isset(\$pdf) ) { 
		    @\$pdf->page_text(40,550,\"" . '__________________________________________________________________________ Pagina: {PAGE_NUM} de {PAGE_COUNT}__________________________________________________________________________ ' . "\", Font_Metrics::get_font(\"helvetica\"), 8, array(0,0,0));
		    @\$pdf->page_text(40,565, \"Generado por: ". $_SESSION["nombre"] ."\", Font_Metrics::get_font(\"helvetica\"), 8, array(0,0,0)); 
		  	@\$pdf->page_text(40,580, \"Referente de: " . $_SESSION["dependencia"] . "\", Font_Metrics::get_font(\"helvetica\"), 8, array(0,0,0));
		  	@\$pdf->page_text(662,565, \"Hora Impresión " . date('H:i:s') . "\", Font_Metrics::get_font(\"helvetica\"), 8, array(0,0,0)); 
		  	@\$pdf->page_text(645,580, \"Fecha Impresión: " . date('d-m-Y') . "\", Font_Metrics::get_font(\"helvetica\"), 8, array(0,0,0)); 
		  } 
		</script>
	";
  return $html;
}
?>