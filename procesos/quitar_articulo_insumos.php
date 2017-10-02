<?php
ob_start();
session_start();
$items=array();
if(count($_SESSION['detalle_solicitud'])>1){
	foreach($_SESSION['detalle_solicitud'] as $detalle){
		if($detalle['id_articulo']!=$_POST['id_articulo']){
			$items[]=$detalle;
		}
	}
}else{
	$_SESSION['detalle_solicitud']=$items;
}
if(!empty($items)){
	$_SESSION['detalle_solicitud']=$items;
}
echo json_encode($_SESSION['detalle_solicitud']);
?>