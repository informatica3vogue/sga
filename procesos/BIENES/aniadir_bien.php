<?php
@ob_start();
@session_start();
include("../../sql/class.data.php");
$data = new data();

$items=array();
$params = $_POST;
$encontrado=false;
$_SESSION['session_bienes']= isset($_SESSION['session_bienes']) ? $_SESSION['session_bienes'] : array();

$sql = "SELECT * FROM bien INNER JOIN seccion_bien ON bien.id_bien=seccion_bien.id_bien INNER JOIN seccion ON seccion_bien.id_seccion=seccion.id_seccion WHERE bien.caf = :caf AND bien.estado = 1";
$param_list = array('caf');
$response = $data->query($sql, $params, $param_list);
if ($response['total'] == 0) {
    $cod = substr($params["caf"], 0, 2);
    $correlativo = substr($params["caf"], 2, strlen($params["caf"])-2);
    $sql_caf = "SELECT * FROM CONSOL WHERE COD = :cod AND CORRELATIVO=:correlativo";
    $param_caf = array('cod'=>$cod,'correlativo'=>$correlativo);
    $response_caf = $data->query($sql_caf, $param_caf, array(), false, false, 'access');
    if (count($response_caf["items"]) > 0) {
        if(!empty($_SESSION['session_bienes'])){
            foreach($_SESSION['session_bienes'] as $detalle){
                if($detalle['caf']==$params['caf']){
                    $encontrado=true;
                    break;
                }
            }
            if($encontrado==false){
                $_SESSION['session_bienes'][]=array('caf'=>$params['caf'], 'descripcion'=>$params['descripcion']);
                $response = array('success'=>true, 'items'=>$_SESSION['session_bienes']);
            }
        }else{
            $_SESSION['session_bienes'][]=array('caf'=>$params['caf'], 'descripcion'=>$params['descripcion']);
            $response = array('success'=>true, 'items'=>$_SESSION['session_bienes']);
        }
    }else{
        $response = array('success'=>false, 'error'=>'No se encontro bien con ese numero de CAF');
    }
}else{
    $response = array('success'=>false, 'error'=>'Este bien ya fue ingresado');
}
echo json_encode($response);
?>