<?php
@session_start();
include("../../sql/class.data.php");
include("../../php/fecha_servidor.php");
$data = new data();
$params = $_POST;
$params["id_usuario"] = $_SESSION["id_usuario"];
$params["accion"] ='Se ha creado un nuevo grupo, fecha de cracion: '.date('d-m-y').', \n nombre del grupo: '.$params["txtNombreGrupo"].'';

$sql = "INSERT INTO grupo(grupo, id_usuario_propietario) VALUES (:txtNombreGrupo, :id_usuario)";
$param_list = array("txtNombreGrupo", "id_usuario");
$response = $data->query($sql, $params, $param_list, true);
if (!empty($_SESSION['detalle_empleado'])) {
  if($response['insertId'] != 0){
    foreach ($_SESSION['detalle_empleado'] as $em) {
        $params['id_grupo'] = intval($response['insertId']);
        $params['id_empleado'] = intval($em['id_empleado']);
        $sql = "INSERT INTO grupo_empleado(id_grupo, id_empleado) VALUES (:id_grupo, :id_empleado)";
        $parametros = array("id_grupo", "id_empleado");
        $result = $data->query($sql, $params, $parametros, true);
      }
    if($response["insertId"]>0){
      $sql = "INSERT INTO bitacora(accion, tipo_accion, fecha_procesamiento, id_usuario) VALUES (:accion, 1, NOW(), :id_usuario)";
      $param_bitacora = array("accion","id_usuario");
      $response_bitacora = $data->query($sql, $params, $param_bitacora, true);
    }
  }
}
if ($response["total"] > 0) {
       $response=array('success'=>true, 'titulo'=>'Operación exitosa!', 'mensaje'=>'Se ha creado el grupo');
       unset($_SESSION['detalle_empleado']);
   }else{
       $response=array('success'=>false, 'titulo'=>'Verifique su información!', 'mensaje'=>'No se guardo el registro');
}
//si los datos se guardan limpiar la session y el formulario

echo json_encode($response);
?>