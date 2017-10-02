<?php
@session_start();
include("../sql/class.managerDB.php");
include("../sql/class.data.php");
$data = new data();
 
$params = $_POST;

if (isset($params["txtotros"])) {
 $sql = "INSERT INTO permiso (num_permiso, telefono, fecha_dif, fecha_drh, hora_desde, hora_hasta, fecha_desde, fecha_hasta, anulacion, observacion, motivo_otros, codigo_rrhh, fecha_procesamiento, id_empleado, id_motivo) VALUES(:txtNumeroPermiso, :txtTelefono, :dtFechaDif, :dtFechaDrh, :hrDesde, :hrAsta, :dtFechaDesde, :dtFechaHasta, :txtAnulacion, :txtObservacion, :txtotros, :codigoDrh, NOW(), :txtNombreEmpleado, :txtmotivo)";
  $param_list = array("txtNumeroPermiso", "txtTelefono", "dtFechaDif", "dtFechaDrh", "hrDesde", "hrAsta", "dtFechaDesde", "dtFechaHasta", "txtAnulacion","txtObservacion", "txtotros","codigoDrh","txtNombreEmpleado" ,"txtmotivo");
}else{
  $sql = "INSERT INTO permiso (num_permiso, telefono, fecha_dif, fecha_drh, hora_desde, hora_hasta, fecha_desde, fecha_hasta, anulacion, observacion, codigo_rrhh, fecha_procesamiento, id_empleado, id_motivo) VALUES(:txtNumeroPermiso, :txtTelefono, :dtFechaDif, :dtFechaDrh, :hrDesde, :hrAsta, :dtFechaDesde, :dtFechaHasta, :txtAnulacion, :txtObservacion, :codigoDrh, NOW(), :txtNombreEmpleado, :txtmotivo)";
  $param_list = array("txtNumeroPermiso", "txtTelefono", "dtFechaDif", "dtFechaDrh", "hrDesde", "hrAsta", "dtFechaDesde", "dtFechaHasta", "txtAnulacion","txtObservacion", "codigoDrh","txtNombreEmpleado" ,"txtmotivo");
}
  $response = $data->query($sql, $params, $param_list, true);

  $target_path = "../upload/permisos/";
   if($response['insertId'] != 0){
  $total = count($_FILES["txtArchivo"]['size']);
  for ($i=0; $i < $total; $i++) { 
    $params['nombreDoc'] = $_FILES["txtArchivo"]["name"][$i];
                      $trozos = explode(".", $params['nombreDoc']);
                      $params['extension'] = end($trozos);
                      $params['id_permiso'] = intval($response['insertId']);
    $target_path = $target_path . basename( $_FILES['txtArchivo']['name'][$i]); 
    @move_uploaded_file($_FILES['txtArchivo']['tmp_name'][$i], $target_path);     
                      $sql = "INSERT INTO docu_permiso(documento, tipo, id_permiso) VALUES (:nombreDoc, :extension, :id_permiso)";
                      $param_list = array("nombreDoc","extension","id_permiso");
                      $response = $data->query($sql, $params, $param_list, true);

        }
      }
  if ($response['insertId'] > 0) {
           $response = array("success"=>true, 'titulo'=>'Operacion exitosa!', 'mensaje'=>'Se ha guardado el Permiso', 'tipo'=>'alert alert-success');
  } else {
           $response = array('success'=>false, 'titulo'=>'Verifique su informacion!', 'mensaje'=>'No se guardo el registro', 'tipo'=>'alert alert-danger');           
  } 

echo json_encode($response);
?>