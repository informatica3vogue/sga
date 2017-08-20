<?php
ob_start();
@session_start();
include("../sql/class.managerDB.php");
include("../sql/class.data.php");


$data = new data();
$params = $_POST;
$errors=array();

/*
$fdoc="";
$fecha_hora="";
$carpetaDestino="../upload/bodega/";
$total=count($_FILES["txtArchivo"]['size']);
if(file_exists($carpetaDestino)){
    for($i=0;$i<$total;$i++){ 
        $origen=$_FILES["txtArchivo"]["tmp_name"][$i];
        $nombre_actual = str_replace(' ','-',$_FILES['txtArchivo']['name'][$i]); 
        $nombre_actual = str_replace('_','-',$nombre_actual); 
        $extension = end(explode('.',$nombre_actual)); 
        $nombre_temporal = substr($nombre_actual,0,strlen($nombre_actual)-(strlen($extension)+1));
        $nombre_nuevo = $nombre_temporal."-".md5($fecha_hora).".".$extension; 
        $destino=$carpetaDestino.$nombre_nuevo;
        # movemos el archivo
        if(@move_uploaded_file($origen, $destino)){         
            array_push($archivo, array('nombre_archivo'=>$nombre_nuevo, 'extension'=>$extension));
            $count++;
        }else{
            array_push($error, array('nombre_archivo'=>$nombre_nuevo));
            
        }
    }
}*/

$sql = "INSERT INTO descargo_bodega(fecha, observacion, id_usuario)  VALUES (NOW(), :txtDetalle, :txtUsuario)";
$param_list = array("txtDetalle","txtUsuario");
$response = $data->query($sql, $params, $param_list, true);

$params["id_descargo_bodega"]= $response['insertId'];
if($response['insertId'] != 0){
  foreach ($_SESSION['detalle_descargo'] as $articulo) {
      $params["cantidad"] = $articulo['cantidad'];
      $params["id_articulo"] = $articulo['id_articulo'];
      $sql = "INSERT INTO descargo_articulo_bodega (cantidad, id_articulo, id_descargo_bodega) VALUES (:cantidad, :id_articulo, :id_descargo_bodega)";
      $param_list = array("cantidad","id_articulo", "id_descargo_bodega");
      $result = $data->query($sql, $params, $param_list, true);
      if($result['insertId']>0){
        $sql = "UPDATE articulo SET existencia=(existencia-:cantidad) WHERE id_articulo=:id_articulo";
        $resultado = $data->query($sql, array('cantidad'=>$params["cantidad"], 'id_articulo'=>$params["id_articulo"]));
      }else{
      	$errors['articulo'][]="No se agregó el articulo ".$articulo['articulo'];

      }
    }
}
if ($result["total"] < 1) {
   $response=array('success'=>false, 'titulo'=>'Verifique su información!', 'mensaje'=>'No se guardo el registro', 'tipo'=>'alert alert-danger');
}else{
	$response=array('success'=>true, 'titulo'=>'Operación exitosa!', 'mensaje'=>'Se relizo el descargo', 'tipo'=>'alert alert-success', 'errors'=>$errors, 'id'=>$params['txtId']);
 }

//si los datos se guardan limpiar la session y el formulario
unset($_SESSION['detalle_descargo']);
echo json_encode($response);
?>