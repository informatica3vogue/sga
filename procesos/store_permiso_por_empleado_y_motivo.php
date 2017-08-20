<?php

@session_start();
include("../sql/class.managerDB.php");
include("../sql/class.data.php");
$data = new data();

$params=$_POST;


if(isset($params)) {  
    $pagina = $params["pagina"];
    $id_empleado = $params["id_empleado"]; 
    $id_motivo = $params["id_motivo"]; 
    $cur_pagina = $pagina;
    $pagina -= 1;
    $final = 4;
    $anterior = true;
    $siguiente = true;
    $primera = true;
    $ultima = true;
    $params['start'] = $pagina * $final;
    $params['limit'] = $final;
    $paginador4 = "";
    $grid4 = "";
    $i = 0;
    
    $sql = "SELECT permiso.id_permiso, permiso.num_permiso, permiso.fecha_dif, permiso.fecha_drh, permiso.hora_desde, permiso.hora_hasta, permiso.fecha_desde, permiso.fecha_hasta, permiso.anulacion, permiso.observacion, permiso.codigo_rrhh, permiso.motivo_otros, permiso.id_empleado, docu_permiso.documento, empleado.codigo, empleado.nombre, motivo.motivo, motivo.id_motivo, DATE_FORMAT(permiso.fecha_dif, '%d-%m-%Y') AS f_dif, DATE_FORMAT(permiso.fecha_desde, '%d-%m-%Y') AS f_desde , DATE_FORMAT(permiso.fecha_hasta, '%d-%m-%Y') AS f_hasta , DATE_FORMAT(hora_desde, ' %h:%m:%s %p') AS hora_des, DATE_FORMAT(permiso.hora_hasta, ' %h:%m:%s %p') AS hora_ha, DATEDIFF(permiso.fecha_hasta, permiso.fecha_desde) AS dias, SEC_TO_TIME(TIME_TO_SEC(TIMEDIFF(permiso.hora_hasta, permiso.hora_desde)))AS horas, motivo.motivo, CONCAT(empleado.nombre, ' ', empleado.apellido) AS nombre_completo FROM (((permiso INNER JOIN motivo ON permiso.id_motivo= motivo.id_motivo ) INNER JOIN empleado ON empleado.id_empleado = permiso.id_empleado) INNER JOIN docu_permiso ON permiso.id_permiso = docu_permiso.id_permiso) WHERE permiso.id_motivo = :id_motivo  AND permiso.id_empleado= :id_empleado ORDER BY permiso.fecha_dif LIMIT :start, :limit";
    $param_list=array("id_motivo", "id_empleado","start", "limit");
    $response4 = $data->query($sql, $params, $param_list);
    

$motivo = (isset($response4["items"][0]["motivo"])) ? $response4["items"][0]["motivo"] : " "; 

if ($response4["total"] > 0) {
    //Grid de datos de permiso
   
                foreach($response4['items'] as $datos){
                      $Tdias = $datos['dias']+1;              
                    $grid4 .= "
                    <tr>               
                        <td class='center'>".$Tdias."</td>
                         <td class='center'>".$datos['horas']."</td> 
                             <td> 
                              <a href='#' class='label label-success' data-toggle='modal' data-target='#modal_detalle_permiso' title='Detalle permiso'  onClick=\"verPermiso(".$datos['id_permiso'].", '".$datos['num_permiso']."', '".$datos['nombre']."', '".$datos['motivo']."', '".$datos['motivo_otros']."', '".$datos['fecha_desde']."', '".$datos['fecha_hasta']."', '".$datos['hora_desde']."', '".$datos['hora_hasta']."', '".$datos['fecha_dif']."', '".$datos['anulacion']."', '".$datos['fecha_drh']."', '".$datos['codigo_rrhh']."', '".$datos['observacion']."');\">Ver Permiso</a></td>
              </tr>";
             "</td>
          
    </tr>";
                }
    $response4=array('grid4'=> $grid4, 'paginador4'=> $paginador4, 'motivo'=>$motivo);
    
}else{
    $grid4 = "<br/>
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
    $paginador4 = "<div style='height: 50px;'></div>";
$response4=array("grid4"=> $grid4, "paginador4" => $paginador4, 'motivo'=>$motivo);
}
echo json_encode($response4);
}