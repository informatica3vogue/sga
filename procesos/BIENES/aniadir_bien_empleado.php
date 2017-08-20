<?php
@ob_start();
@session_start();
include("../../sql/class.data.php");
$data = new data();

$params = $_POST;
$encontrado=false;
$_SESSION['session_bien_empleado'] = isset($_SESSION['session_bien_empleado']) ? $_SESSION['session_bien_empleado'] : array();

if(!empty($_SESSION['session_bien_empleado'])){
    foreach($_SESSION['session_bien_empleado'] as $detalle){
        if($detalle['caf']==$params['caf']){
            $encontrado=true;
            break;
        }
    }
    if($encontrado==false){
        $_SESSION['session_bien_empleado'][]=array('caf'=>$params['caf'], 'descripcion'=>$params['descripcion']);
        $response = array('success'=>true, 'items'=>$_SESSION['session_bien_empleado']);
    }else{
        $response = array('success'=>false, 'mensaje'=>'Este bien ya fue seleccionado');
    }
}else{
    $_SESSION['session_bien_empleado'][]=array('caf'=>$params['caf'], 'descripcion'=>$params['descripcion']);
    $response = array('success'=>true, 'items'=>$_SESSION['session_bien_empleado']);
}

echo json_encode($response);
?>