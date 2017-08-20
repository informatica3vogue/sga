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
    $sql = "SELECT seccion FROM seccion WHERE id_seccion = :id_seccion"; 
    $response = $data->query($sql, array("id_seccion" => $params["id_seccion"]));
    $html="
        <header style='height:25mm;border:0px green solid;'>
            <div style='float:left;width:100%;height:25mm;position:absolute;display:inline;border:0px red solid;text-align:center;font-weight:bold;margin-left:0;'>
                <h3>
                  Corte Suprema de Justicia<br>
                  [dependencia]<br>
                  Reporte de insumos, Secci&oacute;n: ".$response['items'][0]['seccion']." Desde: ".date('d-m-Y',strtotime($params['desde']))." Hasta: ".date('d-m-Y',strtotime($params['hasta'])).".
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

function contenido(){
    $html='
        <table class="normal">
            <thead>
                <tr>
                    <th>N</th>
                    <th>Usuario</th>
                    <th>Referencia</th>
                    <th>Estado</th>
                    <th>Articulos</th>
                    <th>Observacion</th>
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
    $data = new data();
    $params = $_POST;
    $i = 0;
    $html = '';
    $params["id_dependencia"] = $_SESSION["id_dependencia"];
    $sql = "SELECT sa.id_solicitud_articulo, sa.estado, sa.observacion, CONCAT(INITCAP(e.nombre),' ',INITCAP(e.apellido)) AS usuario, sa.referencia FROM seccion s INNER JOIN empleado_seccion es ON s.id_seccion=es.id_seccion INNER JOIN empleado e ON e.id_empleado=es.id_empleado INNER JOIN usuario u ON e.id_empleado=u.id_empleado INNER JOIN solicitud_articulo sa ON u.id_usuario=sa.id_usuario
        WHERE sa.fecha BETWEEN :desde AND DATE_ADD(:hasta, INTERVAL 1 DAY) AND s.id_seccion = :id_seccion ORDER BY sa.fecha DESC";
    $param_list=array('desde', 'hasta', 'id_seccion');
    $response = $data->query($sql, $params, $param_list);
    if ($response["total"] > 0) {
        foreach ($response["items"] as $datos) {
            $i++;
            $estilos = ($i%2==0) ? "background-color:#EEEEEE;" : "background-color:#FFFFFF;";
            $html.='
                <tr style="'.$estilos.'">
                    <td><center>'.$i.'</center></td>
                    <td><center>'.$datos["usuario"].'</center></td>
                    <td><center>'.$datos["referencia"].'</center></td>
                    <td><center>'.$datos["estado"].'</center></td>
                    <td><center>';
                    $response_articulo = $data->query('select a.articulo, ds.cantidad from articulo a inner join detalle_solicitud ds on a.id_articulo=ds.id_articulo where ds.id_solicitud_articulo=:id_solicitud_articulo order by ds.cantidad',array('id_solicitud_articulo'=>$datos["id_solicitud_articulo"]));
                    if ($response_articulo['total'] > 0) {
                        foreach ($response_articulo['items'] as $articulo) {
                           $html.='Articulo: '.$articulo['articulo'].',   Cantidad: '.$articulo['cantidad'].'<br>';
                        }
                    }
            $html.='</center></td>
                    <td><center>'.$datos["observacion"].'</center></td>
                </tr>
            ';
        }
        $html.='
            <tr>
                <th colspan="6" style="color: black; text-align: right;"><center>Total de solicitudes de insumos: <span style="color: blue;">   <b>'.$response["total"].'</b></span></center></th>
            </tr>
        ';
    }
    return $html;
}

//-------------------------------------------------------------------------------------------------------------------------------------------------//

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

function footer_page(){
    $html="
        <script type=\"text/php\"> 
          if ( isset(\$pdf) ) { 
            @\$pdf->page_text(300,580,\"" . ' Pagina: {PAGE_NUM} de {PAGE_COUNT}' . "  - - - -  Impreso el " . date('d-m-Y') . " a las " . date('H:i:s') . "\", Font_Metrics::get_font(\"helvetica\"), 8, array(0,0,0));
          } 
        </script>
    ";
  return $html;
}
?>