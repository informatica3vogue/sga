<?php

@session_start();
include("../sql/class.managerDB.php");
include("../sql/class.data.php");
$data = new data();

$params = $_POST;
$grid3 = "";
$sql = "SELECT id_unidad, unidad_medida FROM unidad WHERE unidad_medida=:txtBuscar3";
$param_list = array("txtBuscar3");
$response3 = $data->query($sql, $params, $param_list);

if ($response3["total"] > 0) {
    //Grid de datos del usuario
    foreach($response3['items'] as $datos){
        $grid3 .= "
           <tr>
            <td class='sorting_1'>".$datos['unidad_medida']."</td>
           
            <td class='center' id='center'><a title='Modificar unidad' href='#' onClick=\"modificar_unidad(".$datos['id_unidad'].", '".$datos['unidad_medida']."');\" ><img src='img/edit_user.png' width='16px' height='16px'/></a></td>
        </tr>";
    }
}else{
   $grid3 = "
    <tr>
        <td colspan='9'>
        <div id='padding16'>
            <div class='alert alert-block alert alert-info'>
                <h4>Resultado de la busqueda!</h4>
                <p>No hay registros</p>                         
            </div>
        </div>
        </td>
    </tr>
    ";
}
$response3=array('grid3'=> $grid3);
echo json_encode($response3);
?>