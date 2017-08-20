<?php
@ob_start();
@session_start();

$items=array();
$params = $_POST;

if(count($_SESSION['session_bienes']) > 1){
    foreach($_SESSION['session_bienes'] as $detalle){
        if($detalle['caf']!=$params['caf']){
            $items[]=$detalle;
        }
    }
}else{
    $_SESSION['session_bienes']=$items;
}
if(!empty($items)){
    $_SESSION['session_bienes']=$items;
}

echo json_encode($_SESSION['session_bienes']);
?>