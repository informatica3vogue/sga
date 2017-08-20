<?php

@session_start();
include("../sql/class.data.php");
include("../php/fecha_servidor.php");
require_once("../reportes/dompdf/dompdf_config.inc.php");
$dompdf = new DOMPDF();
$data = new data();

$html = '';
$params = $_POST;

$sql = "SELECT IF(memo.tipo_memorandum='Interno', CONCAT(memo.referencia,'-Int'), CONCAT(memo.referencia,'-Ext')) AS referencia, DATE_FORMAT(memo.fecha_creacion, '%d-%m-%Y') AS fecha_creacion, memo.de, IF(memo.tipo_memorandum='Interno', (SELECT GROUP_CONCAT(DISTINCT CONCAT(INITCAP(em.nombre), ' ', INITCAP(em.apellido), ' / ', IF(em.cargo!= '', INITCAP(em.cargo), ''))) FROM empleado em INNER JOIN memo_interno mi ON em.id_empleado=mi.id_empleado WHERE mi.id_memorandum=memo.id_memorandum), memo.para) AS para, memo.asunto, memo.descripcion, memo.con_copia FROM memorandum AS memo WHERE memo.id_memorandum=:id";
$param_list=array('id'); 
$response = $data->query($sql, $params, $param_list);

function header_memorandum(){
  $html="<header style='margin: 1em 0em 1em 0em;height:30mm;border:0px green solid;'>
            <div style='padding-top:5mm;float:left;width:100%;height:25mm;position:absolute;display:inline;border:0px red solid;text-align:center;font-weight:bold;margin-left:0;'>
                <h1>
                  Memorandum
                </h1>
                <h2>
                  Corte Suprema de Justicia<br>
                  [dependencia]
                </h2>
            </div>
            <div style='position:absolute;display:inline;margin-left:80%;float:right;width:20%;height:30mm;border:0px blue solid;'>
              <center>
              <img src='../img/CSJ_Logo.png' style='height:25mm;width:25mm;margin-top:2mm; '>
              </center>
            </div>
        </header>
        <br>";   
  $html=str_replace("[dependencia]", $_SESSION["dependencia"], $html);  
  return $html;
}

function informacion_memorandum($items){
  $data = new data();
  $html="<table style='padding: 0 15mm 0 15mm; text-align: justify; width:100%;'>
    <tr>
      <td style='vertical-align: top;'>Para:</td>
      <td style='background-color: #F2F2F2;'>[receptor]</td>
    </tr>
    <tr>
      <td>De:</td>
      <td>[emisor]</td>
    </tr>
    <tr>
      <td>Asunto:</td>
      <td>[asunto]</td>
    </tr>
    <tr>
      <td>Fecha:</td>
      <td>[fecha]</td>
    </tr>
    <tr>
      <td colspan='2' style='text-align:right;'><label><b>Ref-[referencia]</b></label></td>
    </tr>
  </table>"; 
  foreach ($items as $resultado) {
    $elementos=array(
      array('nombre' => '[receptor]', 'valor' => $data->format_string($resultado['para'])),
      array('nombre' => '[emisor]', 'valor' => $data->format_string($resultado['de'])),
      array('nombre' => '[asunto]', 'valor' => $resultado['asunto']),
      array('nombre' => '[fecha]', 'valor' => $resultado['fecha_creacion']),
      array('nombre' => '[referencia]', 'valor' => $resultado['referencia'])
    );
  }
  foreach($elementos as $elemento){
    $html=str_replace($elemento['nombre'], $elemento['valor'], $html);
  } 
  return $html;
}

function footer_memorandum(){
  $html="<script type=\"text/php\"> 
    if ( isset(\$pdf) ) { 
      @\$pdf->page_text(520,758,\"" . 'Pagina: {PAGE_NUM} de {PAGE_COUNT}' . "\", Font_Metrics::get_font(\"helvetica\"), 8, array(0,0,0));
    } 
  </script>";
  return $html;
}

function cuerpo_memorandum($descripcion){
  $html = "<div style='padding: 0 15mm 0 15mm; text-align: justify;'>[observacion]</div>";
  $html=str_replace("[observacion]", stripcslashes(nl2br(html_entity_decode($descripcion))), $html);  
  return $html;
}

$html='<html><head><meta http-equiv="Content-Type" content="text/html; charset=UTF-8" /><title>[titulo]</title><meta name="Description" content="[descripcion]" /><meta name="Author" content="[autor]" /></head><body style="border:0px green solid;margin:1mm 0em 3em 0em; font-family: Arial, Helvetica, sans-serif; text-align: justify; font-size: 9pt; line-height: 150%;">[header] <hr style="border-top: 2px solid #2E9AFE; border-bottom: 2px solid #2E9AFE; border-left:none; border-right:none; height: 6px; width: 90%;"><br> [informacion] <br><hr style="border-top: 2px solid #2E9AFE; border-bottom: 2px solid #2E9AFE; border-left:none; border-right:none; height: 6px; width: 90%;"><br>[contenido] <br><br> [copia] [footer] </body></html>';

if ($response["total"] > 0) {
 
  $copia = ($response['items'][0]['con_copia'] != "") ? "C.C  ".$data->format_string($response['items'][0]['con_copia']) : "";

  $elementos=array(
    array('nombre' => '[header]', 'valor' => header_memorandum()),
    array('nombre' => '[informacion]', 'valor' => informacion_memorandum($response["items"])),
    array('nombre' => '[contenido]', 'valor' => cuerpo_memorandum($response['items'][0]['descripcion'])),
    array('nombre' => '[copia]', 'valor' => $copia),
    array('nombre' => '[footer]', 'valor' => '')
  );
  foreach($elementos as $elemento){
    $html=str_replace($elemento['nombre'], $elemento['valor'], $html);
  }
}

$dompdf->load_html($html);
$dompdf->set_paper("letter", "portrait");
$dompdf->render();
if (file_put_contents("../reportes/pdfs/file".$_SESSION["id_usuario"].".pdf", $dompdf->output())){
  $response=array('success'=>true, 'link'=>"<iframe src='reportes/pdfs/file".$_SESSION["id_usuario"].".pdf?random=".md5(date('d-m-Y H:i:s'))."' style='width:100%;min-height:100%;'></iframe>", 'url'=>"reportes/pdfs/file".$_SESSION["id_usuario"].".pdf?random=".md5(date('d-m-Y H:i:s'))."");
} else {
  $response=array('success'=>false, 'error'=>'No se pudo generar el PDF');
}
echo json_encode($response);
?>