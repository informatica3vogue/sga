<?php
ob_start();
if (!ini_get('display_errors')) {
    ini_set('display_errors', '1');
}
include_once ('../../DBManager.class.php'); //Clase de Conexión a las Base de Datos
include('../../sisnej.class.php');
include("../../conf.php");
include("../../paginas/num2letras.php");
include("../../conexion.php");
require_once("../dompdf_config.inc.php");
mysql_query("SET NAMES 'utf8'");
$dompdf = new DOMPDF();
?>
<?php 
$objSisnej=new Sisnej;
$id=$_GET["id"];
$njuzgado="";
//echo $id;
$consultarNot=$objSisnej->consultar_notificacion($id);
$resNot=$consultarNot->fetch(PDO::FETCH_OBJ);
if($consultarNot->rowCount()>0){
  $conNotificado=$objSisnej->consultar_notificado_especifico($resNot->CEU);
  $resceu=$conNotificado->fetch(PDO::FETCH_OBJ);
  $leido=0;
  $fecha="";
  $observacion="";
  $observacion.=strtoupper("El mensaje fue recibido en fecha ".$resNot->Fecha."<br>");
  $consultarSeguimiento=$objSisnej->consultar_seguimiento($id);
  while($res=$consultarSeguimiento->fetch(PDO::FETCH_OBJ)){
    if($res->Tipo=="1"){
      $leido++;
      $fecha=$res->Fecha;
    }else if($res->Tipo=="2"){
      $observacion.="Borrado: ".$res->Fecha;
    }
  }
  $vez="";
  if($consultarSeguimiento->rowCount()>0){
    if($leido==1){
      $vez="vez";
    }else{
      $vez="veces";
    }
    $observacion.=strtoupper("El mensaje ha sido leÍdo ".num2letras($leido,true)." ".$vez." y la ultima vez fue el ".$fecha."<br>");
  }
  $consultarIngreso=$objSisnej->consultar_ingreso($resNot->CEU,$resNot->FechaEnvio);
  $j=0;
  while($ingreso=$consultarIngreso->fetch(PDO::FETCH_OBJ)){
    $j++;
    //echo $ingreso->Fecha;
  }
  //if($consultarIngreso->rowCount>0){
    if($j==1){
      $vez="vez";
    }else{
      $vez="veces";
    }
    $observacion.=strtoupper("El usuario ingresÓ ".num2letras($j,true)." ".$vez);
  //}
}
$html="
<style type=\"text/css\">
  th{
    align:right;
  }
</style>
<table class='boleta' width=\"100%\" style=\"background-color:#FFF;font-family: 'Trebuchet MS';\">
  <tr>
    <td><img src=\"../../img/CSJ.png\" /></td>  
    <td colspan='3'><h1 style='padding-bottom:-30px;'>CORTE SUPREMA DE JUSTICIA</h1><br />
    <h2>BOLETA DE NOTIFICACION ELECTR&Oacute;NICA</h2></td>
  </tr>
  <tr>
    <td></td>
    <td><i><b>$resNot->Asunto</b></i></td>
  </tr>
  <tr>
    <th>Fecha de env&iacute;o:</th>
    <td>$resNot->Fecha</td>
  </tr>
  <tr>
    <th>Enviado a:</th>
    <td colspan='2'>".utf8_decode($resceu->Nombre)." (".$resceu->CEU.")</td>
  </tr>
  <tr>
    <th>Observaciones:</th>
    <td style='text-decoration:underline;' colspan='3'>".utf8_decode($observacion)."</td>
  </tr>
</table>";

//echo $consultarBoleta->rowCount();
/*$obj=new Sisnej;
$consultarBol=$obj->consultar_boleta($id);
  $row=$consultarBol->fetch(PDO::FETCH_OBJ);
  if($row->N==0){
    $boleta=array(date('Y-m-d H:i:s'),$_SESSION["usuario"],$html,$id);
    //$guardarBoleta=$objSisnej->guardar_boleta();
  }
*/
//echo $html;
$dompdf->load_html($html);
$dompdf->set_paper("letter", "landscape");
$dompdf->render();

$dompdf->stream("dompdf_out.pdf", array("Attachment" => true));
ob_end_flush();
exit(0);
?>