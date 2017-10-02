<?php
ob_start();
@session_start();

include("../sql/class.data.php");
$data = new data();
$params = $_POST;

$params["id_usuario"] = $_SESSION["id_usuario"];
$params["id_dependencia"] = $_SESSION["id_dependencia"];
$carpetaDestino="../upload/bodega/";
if (isset($_SESSION['detalle_descargo'])) {
  if(count($_FILES) > 0 && $_FILES['txtArchivo']['size'][0] > 0) {
      for ($i=0; $i <count($_FILES["txtArchivo"]["size"]) ; $i++) { 
          $name = $_FILES['txtArchivo']["name"][$i];
          $tmp_name = $_FILES['txtArchivo']['tmp_name'][$i];
          $envio = $data->upload($name, $tmp_name, $carpetaDestino);
          if($envio['success'] == true) {
              $adjuntos[] = $envio['file'];
          } else {
              $no_adjuntos[] = $envio['file'];
          }
      } 
      if (empty($no_adjuntos)) {
          $sql = "INSERT INTO descargo_bodega(fecha, observacion, id_dependencia ,id_usuario) VALUES (NOW(), :txtDetalle, :id_dependencia, :id_usuario)";
          $param_list = array("txtDetalle","id_dependencia", "id_usuario");
          $response = $data->query($sql, $params, $param_list, true);
          if ($response["insertId"] > 0) {
            $params["id_descargo_bodega"]= intval($response['insertId']);
            foreach ($adjuntos as $adjunto) {
                $params["adjunto"] = $adjunto;
                $params["extension"] = pathinfo($adjunto, PATHINFO_EXTENSION);
                $sql = "INSERT INTO docu_bodega(documento, tipo, id_descargo_bodega) VALUES (:adjunto, :extension, :id_descargo_bodega)";
                $param_list = array("adjunto","extension","id_descargo_bodega");
                $response_adjunto = $data->query($sql, $params, $param_list, true);
            }
            foreach ($_SESSION['detalle_descargo'] as $articulo) {
              $params["cantidad"] = $articulo['cantidad'];
              $params["id_articulo"] = $articulo['id_articulo'];
              $sql = "INSERT INTO descargo_articulo_bodega(cantidad, id_articulo, id_descargo_bodega) VALUES (:cantidad, :id_articulo, :id_descargo_bodega)";
              $param_list = array("cantidad","id_articulo","id_descargo_bodega");
              $result = $data->query($sql, $params, $param_list, true);
              if($result['insertId']>0){
                $sql = "UPDATE articulo SET existencia=(existencia-:cantidad) WHERE id_articulo=:id_articulo";
                $resultado = $data->query($sql, array('cantidad'=>$params["cantidad"], 'id_articulo'=>$params["id_articulo"]));
              }
            }
          }
          if ($response_adjunto["insertId"] > 0) { 
              $sql = "INSERT INTO bitacora(accion, tipo_accion, fecha_procesamiento, id_usuario) VALUES (:accion, 1, NOW(), :id_usuario)";
              $param_bitacora = array("accion","id_usuario");
              $response_bitacora = $data->query($sql, $params, $param_bitacora, true); 
          }
          if ($response["total"] > 0 &&  $result["total"] > 0) {
              $response = array('success'=>true, 'titulo'=>"Operacion exitosa!", 'mensaje'=>"Se ingresaron los datos correctamente");
              unset($_SESSION['detalle_descargo']);
          }else{
            $response = array('success'=>false, 'titulo'=>"Verifique su informacion!", 'mensaje'=>"Ocurrio un error al ingresar los datos");
          }
      } else {
          foreach ($adjuntos as $adjunto) {
              $eliminar_adjunto = $destiny.$adjunto;
              @unlink($eliminar_adjunto);
          }
          $total = count($no_adjuntos);
          foreach ($no_adjuntos as $cadena){
              $cont ++;
              $error_docs .= ($cont == $total) ? $cadena : $cadena.', ';
          }
          $texto = (count($error_docs) > 1) ? 'los archivos' : 'el archivo';
          $response=array('success'=>false, 'mensaje'=>"Hubo un problema al subir ".$texto.": ".$error_docs);
      }
  }else{
      $sql = "INSERT INTO descargo_bodega(fecha, observacion, id_dependencia ,id_usuario) VALUES (NOW(), :txtDetalle, :id_dependencia, :id_usuario)";
      $param_list = array("txtDetalle","id_dependencia", "id_usuario");
      $response = $data->query($sql, $params, $param_list, true);
      if($response['insertId'] > 0){
          $params["id_descargo_bodega"]= intval($response['insertId']);
          foreach ($_SESSION['detalle_descargo'] as $articulo) {
            $params["cantidad"] = $articulo['cantidad'];
            $params["id_articulo"] = $articulo['id_articulo'];
            $sql = "INSERT INTO descargo_articulo_bodega(cantidad, id_articulo, id_descargo_bodega) VALUES (:cantidad, :id_articulo, :id_descargo_bodega)";
            $param_list = array("cantidad","id_articulo","id_descargo_bodega");
            $result = $data->query($sql, $params, $param_list, true);
            if($result['insertId']>0){
              $sql = "UPDATE articulo SET existencia=(existencia-:cantidad) WHERE id_articulo=:id_articulo";
              $response_existencia = $data->query($sql, array('cantidad'=>$params["cantidad"], 'id_articulo'=>$params["id_articulo"]), array(), true);
            }
          }
          $sql = "INSERT INTO bitacora(accion, tipo_accion, fecha_procesamiento, id_usuario) VALUES (:accion, 1, NOW(), :id_usuario)";
          $param_bitacora = array("accion","id_usuario");
          $response_bitacora = $data->query($sql, $params, $param_bitacora, true); 
      }
      if ($response["total"] > 0 &&  $result["total"] > 0) {
          $response = array('success'=>true, 'titulo'=>"Operacion exitosa!", 'mensaje'=>"Se ingresaron los datos correctamente");
          unset($_SESSION['detalle_descargo']);
      }else{
        $response = array('success'=>false, 'titulo'=>"Verifique su informacion!", 'mensaje'=>"Ocurrio un error al ingresar los datos");
      }
  }
}
echo json_encode($response);
?>