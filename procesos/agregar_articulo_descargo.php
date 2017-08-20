<?php
ob_start();
@session_start();
include("../sql/class.managerDB.php");
include("../sql/class.data.php");
$data = new data();
$items=array();
$encontrado=false;
$_SESSION['detalle_descargo']= isset($_SESSION['detalle_descargo']) ? $_SESSION['detalle_descargo'] : array();
$subtotal=0;
$error="";
//consulta de la existencia
$consulta = $data->query("SELECT id_articulo, existencia FROM articulo WHERE id_articulo = :id_articulo", $_POST, array("id_articulo"));
if($consulta['total']>0){
	//verifica si el array esta vacio
	if(!empty($_SESSION['detalle_descargo'])){
		foreach($_SESSION['detalle_descargo'] as $detalle){
			if($detalle['id_articulo']==$_POST['id_articulo']){
				$encontrado=true;
				break;
			}
		}
		//verifica si un item existe
		if($encontrado==true){
			//añadir a detalle
			foreach($_SESSION['detalle_descargo'] as $detalle){
				if($detalle['id_articulo']==$_POST['id_articulo']){
					//realiza resta para que no guarde numeros negativos
					$resta=$detalle['cantidad']+$_POST['cantidad'];
					if($resta<0){
						$error="La cantidad de articulo no puede ser menor que la existencia.";
					}else{
						if($_POST['cantidad'] <= $consulta['items'][0]['existencia']){
							$detalle['cantidad']=$_POST['cantidad'];
						}else{
							$error="La cantidad de articulo excede a la existencia.";
						}
					}
				}
				$items[]=$detalle;
			}	
			$_SESSION['detalle_descargo']=$items;
			$items=array();
			//para quitar cualquier articulo que tenga de existencia 0 en la tabla
			foreach($_SESSION['detalle_descargo'] as $quitar){
				if($quitar['cantidad']!=0){
					$items[]=$quitar;
				}
			}
			//guardas resultado en la tabla
			$_SESSION['detalle_descargo']=$items;
		}else{
			//evita que guardes en session numeros negativos si un articulo no existe en la tabla
			if($_POST['cantidad']<0){
				$error="La cantidad de articulo no puede ser menor que la existencia.";
			}else{
				$_SESSION['detalle_descargo'][]=array('id_articulo'=>$_POST['id_articulo'], 'articulo'=>$_POST['articulo'], 'cantidad'=>$_POST['cantidad']);
			}
		}
	}else{
		//evita que guardes en session numeros negativos si un articulo no existe en la tabla
		if($_POST['cantidad']<0){
			$error="La cantidad de articulo no puede ser menor que la existencia.";
		}else{
			$_SESSION['detalle_descargo'][]=array('id_articulo'=>$_POST['id_articulo'], 'articulo'=>$_POST['articulo'], 'cantidad'=>$_POST['cantidad']);
		}
	}	
	$respuesta=array('success'=>true, 'items'=>$_SESSION['detalle_descargo'], 'error'=>$error);
}else{
	$respuesta=array('success'=>false, 'msg'=>"El articulo no existe");
}
echo json_encode($respuesta);
?>