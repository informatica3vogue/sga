<?php

@session_start();
include("../sql/class.managerDB.php");
include("../sql/class.data.php");
$data = new data();

$params = $_POST;
$grid2 = "";
$sql = "SELECT id_linea, linea FROM linea WHERE linea=:txtBuscar2";
$param_list = array("txtBuscar2");
$response2 = $data->query($sql, $params, $param_list);

if ($response2["total"] > 0) {
    //Grid de datos del usuario
    foreach($response2['items'] as $datos){
        $grid2 .= "
            <tr>
            <td class='sorting_1'>".$datos['linea']."</td>
           
            <td class='center' id='center'><a title='Modificar Linea' href='#' onClick=\"descripcion(".$datos['id_linea'].", '".$datos['linea']."');\" ><img src='img/edit_user.png' width='16px' height='16px'/></a></td>
        </tr>";
    }
}else{
   $grid2 = "
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
$response2=array('grid2'=> $grid2);
echo json_encode($response2);
?>