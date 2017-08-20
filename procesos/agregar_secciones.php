<?php
ob_start();
session_start();
$items=array();
$encontrado=false;
$detalle['seccion']="";
$_SESSION['detalle_seccion']= isset($_SESSION['detalle_seccion']) ? $_SESSION['detalle_seccion'] : array();
if(!empty($_SESSION['detalle_seccion'])){
	foreach($_SESSION['detalle_seccion'] as $detalle){
		if($detalle['seccion']==$_POST['seccion']){
			$encontrado=true;
			break;
		}
	}
	if($encontrado==true){
		foreach($_SESSION['detalle_seccion'] as $detalle){
			if($detalle['seccion']!=$_POST['seccion']){
				$items[]=$detalle;
			}
		}	
		$_SESSION['detalle_seccion']=$items;
	}else{
		$_SESSION['detalle_seccion'][]=array('seccion'=>$_POST['seccion']);
	}
}else{
	$_SESSION['detalle_seccion'][]=array('seccion'=>$_POST['seccion']);
}
echo json_encode($_SESSION['detalle_seccion']);
?>