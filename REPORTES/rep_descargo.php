<?php
@session_start();

include("../sql/class.managerDB.php");
include("../sql/class.data.php");
require_once("../reportes/dompdf/dompdf_config.inc.php");
$data = new data();
$dompdf = new DOMPDF();

$params1 = $_POST;
$sql1 = "SELECT sa.fecha, sa.observacion, CONCAT(us.nombre, ' ', us.apellido) AS nombre_completo, ds.cantidad, a.articulo, a.descripcion FROM solicitud_articulo sa INNER JOIN usuario us ON sa.id_usuario = us.id_usuario INNER JOIN detalle_solicitud ds ON sa.id_solicitud_articulo = ds.id_solicitud_articulo INNER JOIN articulo a ON ds.id_articulo = a.id_articulo WHERE sa.id_solicitud_articulo = :id";
$param_list1=array("id");
$response1 = $data->query($sql1, $params1, $param_list1);

$params2 = $_POST;
$sql2 = "SELECT d.fecha, d.observacion, CONCAT(us.nombre, ' ', us.apellido) AS nombre_completo, da.cantidad, a.articulo, a.descripcion FROM descargos d INNER JOIN usuario us ON d.id_usuario = us.id_usuario INNER JOIN descargos_articulos da ON d.id_descargos = da.id_descargos INNER JOIN articulo a ON da.id_articulo = a.id_articulo WHERE d.id_solicitud_articulo = :id";
$param_list2=array("id");
$response2 = $data->query($sql2, $params2, $param_list2);

$html='';
$html.='<head><meta charset="utf-8"/><style type="text/css">p{font-size: 70%;}label{font-size: 70%;}</style></head><body style="margin:120px 0 25px 0; height:100%; position:center;"><header style="top:0; position:fixed;"><table style="width:100%; border:solid; font-size: 10pt;">
<tr><td rowspan="3" style="width:15%;"><img src="../img/CSJ_Logo.png" width="70" height="70" style="margin-left: 20%;"></td>
<td>CORTE SUPREMA DE JUSTICIA</td></tr>
<tr><td>'.$_SESSION["dependencia"].'</td></tr>
<tr><td>Comprobante de descargo de articulos de insumos</td></tr>
</table></header>';

$html.='<style type="text/css"> .normal { border: 1px solid #000; border-radius: 5px; border-collapse: collapse; width:100%; font-family: Arial, sans-serif; font-size:8pt; text-aling:center;} .normal tr, .normal td, .normal th { border: 1px solid #000; text-aling:center;} </style>';

if(isset($response1["items"][0]["fecha"]) && isset($response1["items"][0]["nombre_completo"])) {
  $html.='<label>Fecha: '.$response1["items"][0]["fecha"].'</label><br />
    <label>Nombre: '.$response1["items"][0]["nombre_completo"].'</label><br />
    <label>Articulos requeridos: </label><br>';
}
else{
  $html.='<label>Fecha: </label><br />
    <label>Nombre: </label><br />
    <label>Articulos requeridos: </label><br>';
}

$html.='<table class="normal">
      <thead>
        <tr>
          <th width="15%">Cantidad</th>
          <th width="30%">Articulo</th>
          <th width="55%">Descripción</th>
        </tr>
      </thead>
      <tbody>';

      if ($response1['total'] > 0) {
        foreach ($response1["items"] as $datos) {
        $html.='<tr>
                  <td>'.$datos["cantidad"].'</td>
                  <td>'.$datos["articulo"].'</td>
                  <td>'.$datos["descripcion"].'</td>
                </tr>';
        }
      }

      $html.='</tbody> </table>';

      if ((isset($response1["items"][0]["observacion"]))) {
        $html.='<label>Observación: '.$response1["items"][0]["observacion"].'</label></p><br>';
      }else{
        $html.='<label>Observación: </label></p><br>';
      }
      

$html.='<center><label>Firma:_________________________________</label></center><br>
    <center><label>'. $_SESSION['nombre'] .'</label></center>';

$html.='<br><br><hr><br><br><center><p>ARTICULOS DE OFICINA ENTREGADOS</p></center>';

if (isset($response2["items"][0]["fecha"]) && isset($response2["items"][0]["nombre_completo"])) {
  $html.='<label>Fecha: '.$response2["items"][0]["fecha"].'</label><label></label><br />
    <label>Nombre: '.$response2["items"][0]["nombre_completo"].'</label><br />
    <label>Articulos entregados: </label><br>';
}else{
  $html.='<label>Fecha: </label><label></label><br />
    <label>Nombre: </label><label><br />
    <label>Articulos entregados: </label><br>';
}

$html.='<table class="normal">
      <thead>
        <tr>
          <th width="15%">Cantidad</th>
          <th width="30%">Articulo</th>
          <th width="55%">Descripción</th>
        </tr>
      </thead>
      <tbody>';

      if ($response2['total'] > 0) {
        foreach ($response2["items"] as $datos) {
        $html.='<tr>
                  <td>'.$datos["cantidad"].'</td>
                  <td>'.$datos["articulo"].'</td>
                  <td>'.$datos["descripcion"].'</td>
                </tr>';
        }
      }

      $html.='</tbody> </table>';

      $num_ultimo_descargo = $response2['total'] - 1;
      if(isset($response2["items"][$num_ultimo_descargo]["observacion"])){
        $html.='<label>Observación: '.$response2["items"][$num_ultimo_descargo]["observacion"].'</label></p><br>';
      }else{
        $html.='<label>Observación: '.$num_ultimo_descargo.'</label></p><br>';
      }
        

$html.='<center><label>Firma:_________________________________</label></center><br>
    <center><label></label></center>';

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