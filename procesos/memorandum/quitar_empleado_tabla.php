<?php
ob_start();
session_start();
$items=array();
if(count($_SESSION['detalle_empleado'])>1){
	foreach($_SESSION['detalle_empleado'] as $detalle){
		if($detalle['id_empleado']!=$_POST['id_empleado']){
			$items[]=$detalle;
		}
	}
}else{
	$_SESSION['detalle_empleado']=$items;
}
if(!empty($items)){
	$_SESSION['detalle_empleado']=$items;
}
echo json_encode($_SESSION['detalle_empleado']);
?>