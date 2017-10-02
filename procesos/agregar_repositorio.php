<?php 
@session_start();
include("../sql/class.managerDB.php");
include("../sql/class.data.php");
include("../php/fecha_servidor.php");
$data = new data();

$params = $_POST;
$error=array();
$archivo=array();
$params["id_usuario"] = $_SESSION["id_usuario"];
$params["id_dependencia"] = $_SESSION["id_dependencia"];
$count = 0;
$fdoc="";
$fecha_hora="";
$carpetaDestino="../upload/repositorio/";
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
}

if($count == $total){
    $sql = "INSERT INTO repositorio(fecha_creacion, observacion, alias, id_dependencia, id_usuario) VALUES (NOW(), :txtDescripcion, :txtAlias, :id_dependencia, :id_usuario)";
    $param_list = array("txtDescripcion", "txtAlias", "id_dependencia" , "id_usuario");
    $response = $data->query($sql, $params, $param_list, true);
   
    if($response['insertId'] > 0){
        $params['id_repositorio'] = intval($response['insertId']);
        foreach ($archivo as $doc) {
            $params['nombre_archivo'] = $doc['nombre_archivo'];
            $params['extension'] = $doc['extension'];
            $sql = "INSERT INTO docu_repositorio(documento, tipo, id_repositorio) VALUES (:nombre_archivo, :extension, :id_repositorio)";
            $param_list = array("nombre_archivo", "extension", "id_repositorio");
            $response = $data->query($sql, $params, $param_list, true);
        }
    }else{ 
        foreach ($archivo as $doc) {
            @unlink($carpetaDestino.$doc['nombre_archivo']);
        }
        $response=array('success'=>false, 'titulo'=>'Operación no exitosa!', 'mensaje'=>'No se almaceno el archivo');
    }
    $response=array('success'=>true, 'titulo'=>'Operación exitosa!', 'mensaje'=>'Se subio el archivo', 'tipo'=>'alert alert-success');
}else{ 
    foreach ($archivo as $doc) {
        @unlink($carpetaDestino.$doc['nombre_archivo']);
    }

    foreach ($error as $ndoc ) {
       $fdoc.="".$ndoc['nombre_archivo']."";
    }
    $response=array('success'=>false, 'titulo'=>'Operación no exitosa!', 'mensaje'=>'No se subio el archivo: '.$fdoc);
}
echo json_encode($response);
?>