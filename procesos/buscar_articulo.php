<?php

@session_start();
include("../sql/class.managerDB.php");
include("../sql/class.data.php");
$data = new data();

$params = $_POST;
$params["id_dependencia"] = $_SESSION["id_dependencia"];
$grid4 = "";
$sql = "SELECT art.id_articulo, art.articulo, art.existencia, art.descripcion, m.id_marca, m.marca, l.id_linea, l.linea, u.id_unidad, u.unidad_medida, c.id_categoria FROM articulo art INNER JOIN marca m ON art.id_marca = m.id_marca INNER JOIN linea l ON art.id_linea = l.id_linea INNER JOIN unidad u ON art.id_unidad = u.id_unidad INNER JOIN categoria c ON c.id_categoria = 1 WHERE art.id_dependencia = :id_dependencia AND art.caf LIKE :txtBuscar4 OR art.articulo LIKE :txtBuscar4 OR m.marca LIKE :txtBuscar4 OR l.linea LIKE :txtBuscar4 OR u.unidad_medida LIKE :txtBuscar4 OR c.categoria LIKE :txtBuscar4";
$param_list = array("id_dependencia","txtBuscar4");
$response4 = $data->query($sql, $params, $param_list);

if ($response4["total"] > 0) {
    //Grid de datos del usuario
    foreach($response4['items'] as $datos){
        $grid4 .= "
       <tr>
                        <td>".$datos['articulo']."</td>                    
                        <td>".$datos['marca']."</td>                  
                        <td>".$datos['linea']."</td>
                        <td>".$datos['unidad_medida']."</td>
                        <td class='center' id='center'><a title='Modificar articulo' href='#' onClick=\"modificar_articulo(".$datos['id_articulo'].", '".$datos['articulo']."', '".$datos['descripcion']."', ".$datos['id_marca'].", ".$datos['id_linea'].", ".$datos['id_unidad'].");\" ><img src='img/edit_user.png' width='16px' height='16px'/></a></td>
                    </tr>";
    }
}else{
   $grid4 = "
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
$response4=array('grid4'=> $grid4);
echo json_encode($response4);
?>