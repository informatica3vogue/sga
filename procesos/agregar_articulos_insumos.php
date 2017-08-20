<?php
ob_start();
session_start();
$items=array();
$encontrado=false;
$_SESSION['detalle_solicitud']= isset($_SESSION['detalle_solicitud']) ? $_SESSION['detalle_solicitud'] : array();
if(!empty($_SESSION['detalle_solicitud'])){
	foreach($_SESSION['detalle_solicitud'] as $detalle){
		if($detalle['id_articulo']==$_POST['id_articulo']){
			$encontrado=true;
			break;
		}
	}
	if($encontrado==true){
		foreach($_SESSION['detalle_solicitud'] as $detalle){
			if($detalle['id_articulo']==$_POST['id_articulo']){
				$detalle['cantidad']=$_POST['cantidad'];
			}
			$items[]=$detalle;
		}	
		$_SESSION['detalle_solicitud']=$items;
	}else{
		$_SESSION['detalle_solicitud'][]=array('id_articulo'=>$_POST['id_articulo'], 'articulo'=>$_POST['articulo'], 'cantidad'=>$_POST['cantidad']);
	}
}else{
	$_SESSION['detalle_solicitud'][]=array('id_articulo'=>$_POST['id_articulo'], 'articulo'=>$_POST['articulo'], 'cantidad'=>$_POST['cantidad']);
}
echo json_encode($_SESSION['detalle_solicitud']);
?>