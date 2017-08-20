<?php
ob_start();
session_start();
$items=array();
if(count($_SESSION['detalle_seccion'])>1){
	foreach($_SESSION['detalle_seccion'] as $detalle){
		if($detalle['seccion']!=$_POST['seccion']){
			$items[]=$detalle;
		}
	}
}else{
	$_SESSION['detalle_seccion']=$items;
}
if(!empty($items)){
	$_SESSION['detalle_seccion']=$items;
}
echo json_encode($_SESSION['detalle_seccion']);
?>