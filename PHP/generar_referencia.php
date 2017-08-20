<?php 

function generar_referencia_soli(){
  $data = new data();
  $referencia = "";
  $anio = date("Y");
  $abreviatura = $_SESSION["abreviatura"];
  $sql = "SELECT DISTINCT referencia FROM solicitud_articulo WHERE fecha = (SELECT MAX(sol.fecha) FROM solicitud_articulo sol INNER JOIN usuario user ON user.id_usuario=sol.id_usuario INNER JOIN seccion sec ON sec.id_seccion=user.id_seccion WHERE sec.id_dependencia=:id_dependencia)";
  $response = $data->query($sql, array("id_dependencia"=>$_SESSION["id_dependencia"]));

  $ref = ($response["total"]>0) ? $response["items"][0]["referencia"] : "";
  if ($ref != "") {
    $var = explode("-", $ref);
    $num_ref = (date("Y", strtotime($var[2]))==$anio) ? (intval($var[1])+1) : 1;
    $referencia = $abreviatura."-".$num_ref."-".$anio;
  }else{
    $referencia = $abreviatura."-1-".$anio;
  }

  return $referencia;
}
?>