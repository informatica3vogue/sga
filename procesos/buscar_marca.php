<?php

@session_start();
include("../sql/class.managerDB.php");
include("../sql/class.data.php");
$data = new data();

$params = $_POST;
$grid = "";
$sql = "SELECT id_marca, marca FROM marca WHERE marca=:txtBuscar";
$param_list = array("txtBuscar");
$response = $data->query($sql, $params, $param_list);

if ($response["total"] > 0) {
    //Grid de datos del usuario
    foreach($response['items'] as $datos){
        $grid .= "
         <tr>
            <td class='sorting_1'>".$datos['marca']."</td>
           
            <td class='center' id='center'><a title='Modificar marca' href='#' onClick=\"modificar_marca(".$datos['id_marca'].", '".$datos['marca']."');\" ><img src='img/edit_user.png' width='16px' height='16px'/></a></td>
        </tr>";
    }
}else{
   $grid = "
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
$response=array('grid'=> $grid);
echo json_encode($response);
?>