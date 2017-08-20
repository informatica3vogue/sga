<?php

@session_start();
include("../sql/class.managerDB.php");
include("../sql/class.data.php");
$data = new data();

$params=$_POST;
$params["id_usuario"] = $_SESSION["id_usuario"];
if(isset($params)) {  
    $pagina = $params["pagina"];
    $id_empleado = $params["id_empleado"]; 
    $cur_pagina = $pagina;
    $pagina -= 1;
    $final = 8;
    $anterior = true;
    $siguiente = true;
    $primera = true;
    $ultima = true;
    $params['start'] = $pagina * $final;
    $params['limit'] = $final;
    $paginador3 = "";
    $grid3 = "";
    $i = 0;



 $sql = "SELECT DISTINCT p.id_motivo, p.id_empleado, e.codigo, p.id_motivo, (SELECT SUM(ABS(DATEDIFF(fecha_desde, DATE_ADD(fecha_hasta, INTERVAL 1 DAY)))) FROM permiso WHERE id_motivo=p.id_motivo AND id_empleado=p.id_empleado) AS dias_solicitados, SEC_TO_TIME(TIME_TO_SEC(TIMEDIFF(p.hora_hasta, p.hora_desde))) AS horas, CONCAT(e.nombre,' ',e.apellido) AS nombre, m.motivo FROM ((permiso p INNER JOIN empleado e on p.id_empleado = e.id_empleado) INNER JOIN motivo m ON p.id_motivo = m.id_motivo) WHERE p.id_empleado= :id_empleado ORDER BY  nombre DESC";
$param_list=array("id_empleado");
$response3 = $data->query($sql, $params, $param_list);  


    $nombre = (isset($response3["items"][0]["nombre"])) ? $response3["items"][0]["nombre"] : " "; 
    $codigo = (isset($response3["items"][0]["codigo"])) ? $response3["items"][0]["codigo"] : " ";

   
   // print_r($mot);

if ($response3["total"] > 0) {
    //Grid de datos de permiso
   
                foreach($response3['items'] as $datos){                
//echo $datos['id_motivo'];
                    $dias=$datos['dias_solicitados'];
                    $mot = $datos['id_motivo'];
                    $dlH = $datos['horas']*0.04167;
                    $diasH=$dias+$dlH;
                    
                    if($mot == 1){
                        $d= 15- $diasH;
                        $diast=intval(15-$diasH);
                        //conversion dias a horas
                         $h=$d-$diast;
                        $h2=$h*24;
                        $horast=round($h2,2);
                    } elseif ($mot == 2){
                        $d= 90- $diasH;
                        $diast=intval(90-$diasH);
                        //conversion dias a horas
                        $h=$d-$diast;
                        $h2=$h*24;
                        $horast=round($h2,2);
                    }elseif ($mot == 3) {
                        $d= 90- $diasH;
                        $diast=intval(90-$diasH);
                        //conversion dias a horas
                         $h=$d-$diast;
                        $h2=$h*24;
                        $horast=round($h2,2);
                    }elseif ($mot==4) {
                         $d= 20- $diasH;
                         $diast=intval(20-$diasH);
                         //conversion dias a horas
                         $h=$d-$diast;
                        $h2=$h*24;
                        $horast=round($h2,2);
                    }elseif ($mot==6) {
                        $d= 5- $diasH; 
                        $diast=intval(5-$diasH);
                        //conversion dias a horas
                         $h=$d-$diast;
                        $h2=$h*24;
                        $horast=round($h2,2);
                    }elseif ($mot==7) {
                        $d= 3- $diasH;
                           $diast=intval(3-$diasH);
                           //conversion dias a horas
                            $h=$d-$diast;
                        $h2=$h*24;
                        $horast=round($h2,2);
                    }elseif ($mot==8) {
                      $d= 3- $diasH;
                         $diast=intval(3-$diasH); 
                         //conversion dias a horas
                         $h=$d-$diast;
                        $h2=$h*24;
                        $horast=round($h2,2);            
                    }else{
                        $diast=$diasH;
                        $diast=$diasH;
                    }
                    $grid3 .= "
                    <tr>
            <td class='sorting_1'>".$datos['motivo']."</td>
    
            <td class='center'>".$datos['dias_solicitados']."</td>
            <td class='center'>".$datos['horas']."</td>
            <td class='center'>".$diast."</td>
            <td class='center'>".$horast."</td>
            <td class='center' id='center'><a href='#' title='Ver Permisos' onclick=\"detallePermiso(1, ".$datos['id_empleado'].", ".$datos['id_motivo'].");\" ><img src='img/edit.png' width='23px' height='23px'/></a></td>
        </tr>";
             "</td>
          
    </tr>";


                   }
    $response3=array('grid3'=> $grid3, 'paginador3'=> $paginador3, 'nombre'=>$nombre, 'codigo'=>$codigo);
    
}else{
    $grid3 = "<br/>
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
    $paginador3 = "<div style='height: 50px;'></div>";
$response3=array("grid3"=> $grid3, "paginador3" => $paginador3, 'nombre'=>$nombre, 'codigo'=>$codigo);
}
echo json_encode($response3);
}