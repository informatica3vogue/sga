<?php
@session_start();
include("../../sql/class.data.php");
$data = new data();

$cont = 0;
$params = $_POST;
if (!empty($_SESSION["session_bienes"])) {
    $total_items = count($_SESSION["session_bienes"]);
    foreach ($_SESSION["session_bienes"] as $bien) {

      $cod = substr($bien["caf"], 0, 2);
      $correlativo = substr($bien["caf"], 2, strlen($bien["caf"])-2);

      $sql_caf = "SELECT SERIE, MARCA, MODELO, DESCRIP, FECHA_GARANTIA, FECHA_ADQ FROM CONSOL WHERE COD = :cod AND CORRELATIVO=:correlativo";
      $param_caf = array('cod'=>$cod,'correlativo'=>$correlativo);
      $response_caf = $data->query($sql_caf, $param_caf, array(), false, false, 'access');

      if (count($response_caf["items"]) > 0) {

        $serie = ($response_caf['items'][0]['SERIE'] != "") ? $response_caf['items'][0]['SERIE'] : 'No disponible';
        $marca = ($response_caf['items'][0]['MARCA'] != "") ? $response_caf['items'][0]['MARCA'] : 'No disponible';
        $modelo = ($response_caf['items'][0]['MODELO'] != "") ? $response_caf['items'][0]['MODELO'] : 'No disponible';
        $descripcion = ($response_caf['items'][0]['DESCRIP'] != "") ? $response_caf['items'][0]['DESCRIP'] : 'No disponible';
        $fecha_garantia = ($response_caf['items'][0]['FECHA_GARANTIA'] != "") ? $response_caf['items'][0]['FECHA_GARANTIA'] : NULL;
        $fecha_adquisicion = ($response_caf['items'][0]['FECHA_ADQ'] != "") ? $response_caf['items'][0]['FECHA_ADQ'] : NULL;

        $sql =  "INSERT INTO bien(caf, estado, serie, marca, modelo, descripcion, fecha_garantia, fecha_adquisicion, id_dependencia) VALUES (:caf, 1, :serie, :marca, :modelo, :descripcion, :fecha_garantia, :fecha_adquisicion, :id_dependencia)";
        $params_bien  = array('caf'=>$bien["caf"], 'serie'=>$serie, 'marca'=>$marca, 'modelo'=>$modelo, 'descripcion'=>$descripcion, 'fecha_garantia'=>$fecha_garantia, 'fecha_adquisicion'=>$fecha_adquisicion, 'id_dependencia'=>$_SESSION['id_dependencia']);
        $response_bien = $data->query($sql, $params_bien, array(), true);
        if ($response_bien["insertId"] > 0) {
          $sql =  "INSERT INTO seccion_bien(id_bien, id_seccion, fecha_procesamiento, estado) VALUES(:id_bien, :id_seccion, NOW(), 2)";
          $param_bien_seccion  = array('id_bien'=>$response_bien["insertId"], 'id_seccion'=>$params["id_seccion"]);
          $response_bien_seccion = $data->query($sql, $param_bien_seccion, array(), true);
        }
      }
       $cont++;
    } 
    if ($total_items == $cont) {
        unset($_SESSION["session_bienes"]);
        $response = array('success' => true, 'mensaje'=>'Se ingresaron los bienes con exito!');
    }else{
        $response = array('success' => false, 'error'=>'No se pudieron ingresar todos los bienes');
    }
}else{
    $response = array('success' => false, 'error'=>'Por favor ingrese al menos un bien');
}

echo json_encode($response);
?>