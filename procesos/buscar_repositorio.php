<?php

@session_start();
include("../sql/class.managerDB.php");
include("../sql/class.data.php");
$data = new data();

$params=$_POST;
$i = 0;

$sql = "SELECT id_repositorio, fecha_creacion, alias FROM repositorio WHERE MATCH(alias, observacion) AGAINST(:txtBuscar) ORDER BY fecha_creacion DESC";
$param_list=array("txtBuscar");
$response = $data->query($sql, $params, $param_list);

if ($response["total"] > 0) {
    //Grid de datos del usuario
    $grid ="
    <div class='table-responsive'>
        <table class='table table-hover table-bordered table-condensed'>
            <thead>
                <tr>
                    <th>Alias</th>
                    <th>Fecha</th>
                    <th>Nombre del Documento</th>
                </tr> 
            </thead>
            <tbody>"; 
                foreach($response['items'] as $datos){///
                    $i++;
                    if($i%2==0){ $estilos="class='info'"; }else{ $estilos=" "; }
                    $grid .= "
                    <tr ".$estilos.">
                        
                        <td>".$datos['alias']."</td>
                        <td>".$datos['fecha_creacion']."</td>                       
                        <td>";

                        $params['id_repositorio'] = $datos['id_repositorio'];
                        $sql2 = "SELECT documento FROM docu_repositorio WHERE id_repositorio = :id_repositorio";
                        $parametros=array("id_repositorio");
                        $result = $data->query($sql2, $params, $parametros);
                        if ($result["total"] > 0) {
                            foreach($result['items'] as $documentos){
                                $grid .= "
                                <a href='procesos/upload/".$documentos['documento']."', download>".$documentos['documento'].",</a>
                                ";
                            }  
                        }
                         $grid .= "</td>                                 

                    </tr>";
                }
             $grid = $grid.="
            </tbody>
        </table>
    </div>
    ";
$response=array("grid"=> $grid);
  }else{
    $grid = "
    <div id='padding16'>
        <div class='alert alert-block alert alert-info'>
            <h4>Resultado de la busqueda!</h4>
            <p>No hay regitros</p>                         
        </div>
    </div>
    ";
$response=array("grid"=> $grid);
}
echo json_encode($response);
?>