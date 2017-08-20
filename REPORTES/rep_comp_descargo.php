<?php
@session_start();

include("../sql/class.managerDB.php");
include("../sql/class.data.php");
require_once("../reportes/dompdf/dompdf_config.inc.php");
$data = new data();
$dompdf = new DOMPDF();

$params1 = $_POST;

$sql1 = "SELECT des.cantidad, des_bod.id_dependencia, art.articulo, art.descripcion, CONCAT(us.nombre, ' ', us.apellido) AS nombre_completo, DATE_FORMAT(des_bod.fecha, '%d-%m-%Y %H:%i:%s') AS fecha, des_bod.id_dependencia FROM descargo_articulo_bodega des INNER JOIN articulo art ON des.id_articulo = art.id_articulo INNER JOIN descargo_bodega des_bod ON des_bod.id_descargo_bodega = des.id_descargo_bodega INNER JOIN usuario us ON us.id_usuario = des_bod.id_usuario WHERE  des_bod.id_descargo_bodega= :id";
$param_list1=array("id");
$response1 = $data->query($sql1, $params1, $param_list1);


$html='';
$html.='<head><meta charset="utf-8"/><style type="text/css">p{font-size: 70%;}label{font-size: 70%;}</style></head><body style="margin:120px 0 25px 0; height:100%; position:center;"><header style="top:0; position:fixed;"><table style="width:100%; border:solid; font-size: 10pt;">
<tr><td rowspan="3" style="width:15%;"><img src="../img/CSJ_Logo.png" width="70" height="70" style="margin-left: 20%;"></td>
<td>CORTE SUPREMA DE JUSTICIA</td></tr>
<tr><td>Administracion del Edifico Administrativo CSJ</td></tr>
<tr><td>Comprobante de descargo de articulos de bodega</td></tr>
</table></header>';

$html.='<style type="text/css"> .normal { border: 1px solid #000; border-radius: 5px; border-collapse: collapse; width:100%; font-family: Arial, sans-serif; font-size:8pt; text-aling:center;} .normal tr, .normal td, .normal th { border: 1px solid #000; text-aling:center;} </style>';

if(isset($response1["items"][0]["fecha"]) && isset($response1["items"][0]["nombre_completo"])) {
  $html.='<label>Fecha: '.$response1["items"][0]["fecha"].'</label><br />
    <label>Nombre: '.$response1["items"][0]["nombre_completo"].'</label><br />
    <label>Articulos requeridos: </label><br>';
}
else{
  $html.='<label>Fecha: </label><br><br>
    <label>Nombre: </label><br><br>
    <label>Articulos requeridos: </label><br><br>';
}

$html.='<table class="normal">
			<thead>
				<tr>
					<th width="15%">Cantidad</th>
					<th width="30%">Articulo</th>
					<th width="30%">Fecha de descargo</th>
					<th width="55%">Descripción</th>
				</tr>
			</thead>
			<tbody>';
if ($response1['total'] > 0) {
			foreach ($response1["items"] as $datos) {
			$html.='<tr>
						<td>'.$datos["cantidad"].'</td>
						<td>'.$datos["articulo"].'</td>
						<td>'.$datos["fecha"].'</td>
						<td>'.$datos["descripcion"].'</td>
					</tr>  ';
			}
}

      $html.='</tbody> </table>';

      if ((isset($response1["items"][0]["observacion"]))) {
        $html.='<label>Observación: '.$response1["items"][0]["observacion"].'</label></p><br>';
      }else{
        $html.='<label>Observación: </label></p><br><br><br><br><br>';
      }
      

$html.='<center><label>Firma:_________________________________</label></center><br>
    <center><label>'. $_SESSION['nombre'] .'</label></center>';



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
      @\$pdf->page_text(539,758,\"" . date('h:i:s a') . "\");

      } 
  </script>";

$html.='</footer>';

$dompdf->load_html($html);
$dompdf->set_paper("letter", "portrait");
$dompdf->render();
if (file_put_contents('../reportes/pdfs/'. "file".$_SESSION["id_usuario"]."" . ".pdf", $dompdf->output())){
  $response=array('success'=>true, 'link'=>"reportes/pdfs/" . "file".$_SESSION["id_usuario"]."" . ".pdf?random=".md5(date('d-m-Y H:i:s'))."");
} else {
  $response=array('success'=>false, 'error'=>'No se pudo generar el PDF');
}
echo json_encode($response);
?>