<?php
require_once('../../sql/class.data.php');
ob_start();
session_start();
$data = new data();
$items=array();
$encontrado=false;
$detalle['id_empleado']="";
$_SESSION['detalle_empleado']= isset($_SESSION['detalle_empleado']) ? $_SESSION['detalle_empleado'] : array();

if(!empty($_SESSION['detalle_empleado'])){
	foreach($_SESSION['detalle_empleado'] as $detalle){
		if($detalle['id_empleado']==$_POST['id_empleado']){
			$encontrado=true;
			break;
		}
	}
	if($encontrado==true){
		foreach($_SESSION['detalle_empleado'] as $detalle){
			if($detalle['id_empleado']!=$_POST['id_empleado']){
				$items[]=$detalle;
			}
		}	
		$_SESSION['detalle_empleado']=$items;
	}else{
		$_SESSION['detalle_empleado'][]=array('id_empleado'=>$_POST['id_empleado'], 'empleado'=>$_POST['empleado']);
	}
}else{
	$_SESSION['detalle_empleado'][]=array('id_empleado'=>$_POST['id_empleado'], 'empleado'=>$_POST['empleado']);
}
echo json_encode($_SESSION['detalle_empleado']);
?>