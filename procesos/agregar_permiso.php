<?php
@session_start();
include("../sql/class.managerDB.php");
include("../sql/class.data.php");
$data = new data();

$params = $_POST;

$params["hrAsta"] = ($params["hrAsta"] != "") ? $params["hrAsta"] : NULL;
$params["hrDesde"] = ($params["hrDesde"] != "") ? $params["hrDesde"] : NULL;
$params["dtFechaDesde"] = ($params["dtFechaDesde"] != "") ? $params["dtFechaDesde"] : NULL;
$params["dtFechaHasta"] = ($params["dtFechaHasta"] != "") ? $params["dtFechaHasta"] : NULL;

if (isset($params["txtId"])) {
    if (isset($params["txtotros"])) {
        $sql        = "UPDATE permiso SET num_permiso=:txtNumeroPermiso, fecha_dif=:dtFechaDif, fecha_drh=:dtFechaDrh, hora_desde=:hrDesde, hora_hasta=:hrAsta, fecha_desde=:dtFechaDesde, fecha_hasta=:dtFechaHasta, anulacion=:txtAnulacion, observacion=:txtObservacion, motivo_otros=:txtotros, codigo_rrhh=:codigoDrh, id_empleado=:txtNombreEmpleado, id_motivo=:txtmotivo WHERE id_permiso=:txtId";
        $param_list = array(
            "txtNumeroPermiso",
            "dtFechaDif",
            "dtFechaDrh",
            "hrDesde",
            "hrAsta",
            "dtFechaDesde",
            "dtFechaHasta",
            "txtAnulacion",
            "txtObservacion",
            "codigoDrh",
            "txtotros",
            "txtNombreEmpleado",
            "txtmotivo",
            "txtId"
        );
        
    } else {
      
        $sql        = "UPDATE permiso SET num_permiso=:txtNumeroPermiso, fecha_dif=:dtFechaDif, fecha_drh=:dtFechaDrh, hora_desde=:hrDesde, hora_hasta=:hrAsta, fecha_desde=:dtFechaDesde, fecha_hasta=:dtFechaHasta, anulacion=:txtAnulacion, observacion=:txtObservacion, codigo_rrhh=:codigoDrh, id_empleado=:txtNombreEmpleado, id_motivo=:txtmotivo WHERE id_permiso=:txtId";
        $param_list = array(
            "txtNumeroPermiso",
            "dtFechaDif",
            "dtFechaDrh",
            "hrDesde",
            "hrAsta",
            "dtFechaDesde",
            "dtFechaHasta",
            "txtAnulacion",
            "txtObservacion",
            "codigoDrh",
            "txtNombreEmpleado",
            "txtmotivo",
            "txtId"
        );
        
    }
    $response    = $data->query($sql, $params, $param_list);
    $target_path = "../upload/permisos/";
    if ($params['txtId'] != 0) {
        $total = count($_FILES["txtArchivo"]['size']);
        for ($i = 0; $i < $total; $i++) {
            $params['nombreDoc']  = $_FILES["txtArchivo"]["name"][$i];
            $trozos               = explode(".", $params['nombreDoc']);
            $params["extension"] = pathinfo($trozos, PATHINFO_EXTENSION);
            $params['id_permiso'] = intval($params['txtId']);
            $target_path          = $target_path . basename($_FILES['txtArchivo']['name'][$i]);
            @move_uploaded_file($_FILES['txtArchivo']['tmp_name'][$i], $target_path);
            $sql        = "UPDATE docu_permiso SET documento=:nombreDoc, tipo=:extension WHERE id_permiso=:txtId";
            $param_list = array(
                "nombreDoc",
                "extension",
                "txtId"
            );
            $response   = $data->query($sql, $params, $param_list, true);
            
        }
    }
    if ($response['total'] == 0) {
        $response = array(
            'success' => true,
            'titulo' => 'Operacion exitosa!',
            'mensaje' => 'Se ha modificado el permiso',
            'tipo' => 'alert alert-success'
        );
        
        
    } else {
        $response = array(
            'success' => false,
            'titulo' => 'Verifique su información!',
            'mensaje' => 'No se modifico el registro',
            'tipo' => 'alert alert-danger'
        );
        
    }
} else {   

    //Obteniendo los dias de permiso 
    $sql        = "SELECT id_empleado, fecha_hasta, fecha_desde, SEC_TO_TIME(SUM(TIME_TO_SEC(TIMEDIFF(hora_hasta, hora_desde)))) AS horas,  SUM(ABS(DATEDIFF(fecha_desde, DATE_ADD(fecha_hasta, INTERVAL 1 DAY)))) AS dias FROM permiso WHERE id_empleado=:txtNombreEmpleado AND id_motivo=:txtmotivo AND anulacion ='no'";
    $param_list = array(
        "txtNombreEmpleado",
        "txtmotivo"
    );
    $response   = $data->query($sql, $params, $param_list);
    foreach ($response['items'] as $datos) {
        //Conversion horas y minutos a dias
        $dlH     = $datos['horas'] * 0.04167;
        $dTotalH = round($dlH, 2);
        $dTotal  = $datos['dias'];
        
        //sumas Fechas
        $sumDH      = $dTotalH + $dTotal;
        //Captura de valores de formulario
        $inicio     = $_POST['dtFechaDesde'];
        $fin        = $_POST['dtFechaHasta'];
        $horaInicio = $_POST['hrDesde'];
        $horaHasta  = $_POST['hrAsta'];      
        $motivo     = $_POST['txtmotivo'];
        $anulado    = $_POST['txtAnulacion'];
        //Obteniendo dias de las fechas
        $fecha1     = new DateTime("$inicio");
        $fecha2     = new DateTime("$fin");
        $diff       = date_diff($fecha1, $fecha2);
        $fechas     = $diff->format("%a.");
        $fecha      = $fechas + 1;
        //obteniendo las horas y convirtiendolas a dias
        $hora1      = new DateTime("$horaInicio");
        $hora2      = new DateTime("$horaHasta");
        $diffHora   = date_diff($hora1, $hora2);
        $hora       = $diffHora->h;
        $min        = $diffHora->i;
        $conH       = $hora * 0.04167;
        $conM       = $min * 0.00069444;
        $ToH        = round($conH, 2);
        $toM        = round($conM, 2);
        $thoras     = $ToH + $toM;
        //suma fecha y hora de base y dias del formulario
        $diasT      = $sumDH + $fecha;
        //suma fecha y hora de base y horas del formulario
        $diasH      = $sumDH + $thoras;
        //validar que fecha solisitada no sea mayor a tres dias
        if ($fecha > 3 AND $motivo == 1 AND $anulado == "no") {
            $response = array(
                'success' => false,
                'titulo' => 'Verifique su informacion!',
                'mensaje' => '<b><center>Enfermedades sin certificado no se puede dar más de 3 dias consecutivos</center></b><h6>Desea guardar el registro</h6>'
            );
            //validar que la fecha solicitada no sea mayos a los 15 dias suma de dias y horas de base y dias del formulario
        } else if ($diasT > 15 AND $motivo == 1 AND $anulado == "no") {
            $response = array(
                'success' => false,
                'titulo' => 'Verifique su informacion!',
                'mensaje' => '<b>Ha exedido el limite de 15 dias</b><h6>Desea guardar el registro</h6>'
            );
            //validar que la fecha solicitada no sea mayos a los 15 dias suma de dias y horas de base y horas del formulario
        } else if ($diasH > 15 AND $motivo == 1 AND $anulado == "no") {
            $response = array(
                'success' => false,
                'titulo' => 'Verifique su informacion!',
                'mensaje' => '<b>Ha exedido el limite de 15 días</b><h6>Desea guardar el registro</h6>'
            );
            //validar que fecha solisitada no sea mayor a 90 dias
        } else if ($fecha > 90 AND $motivo == 2 AND $anulado == "no") {
            $response = array(
                'success' => false,
                'titulo' => 'Verifique su informacion!',
                'mensaje' => '<b>Enfermedades con certificado son 90 días maximos</b><h6>Desea guardar el registro</h6>'
            );
            //validar que la fecha solicitada no sea mayos a los 90 dias suma de dias y horas de base y dias del formulario
        } else if ($diasT > 90 AND $motivo == 2 AND $anulado == "no") {
            $response = array(
                'success' => false,
                'titulo' => 'Verifique su informacion!',
                'mensaje' => '<b>HA exedido los 90 dás permitidos</b><h6>Desea guardar el registro</h6>'
            );
            //validar que la fecha solicitada no sea mayos a los 15 dias suma de dias y horas de base y horas del formulario
        } else if ($diasH > 90 AND $motivo == 2 AND $anulado == "no") {
            $response = array(
                'success' => false,
                'titulo' => 'Verifique su informacion!',
                'mensaje' => '<b>HA exedido los 90 dás permitidos</b><h6>Desea guardar el registro</h6>'
            );
        } else if ($fecha > 90 AND $motivo == 3 AND $anulado == "no") {
            $response = array(
                'success' => false,
                'titulo' => 'Verifique su informacion!',
                'mensaje' => '<b>Exedio los 90 días permitidos por Alumbramiento</b><h6>Desea guardar el registro</h6>'
            );
            //validar que fecha solisitada no sea mayor a 20 dias
        } else if ($fecha > 20 AND $motivo == 4 AND $anulado == "no") {
            $response = array(
                'success' => false,
                'titulo' => 'Verifique su informacion!',
                'mensaje' => '<b>or duelo es un maximo de 20 días</b><h6>Desea guardar el registro</h6>'
            );
            //validar que la fecha solicitada no sea mayos a los 20 dias suma de dias y horas de base y dias del formulario
        } else if ($diasT > 20 AND $motivo == 4 AND $anulado == "no") {
            $response = array(
                'success' => false,
                'titulo' => 'Verifique su informacion!',
                'mensaje' => '<b>Ha exedido el limite de 20 dias</b><h6>Desea guardar el registro</h6>'
            );
            //validar que fecha solisitada no sea mayor a 5 dias
        } else if ($fecha > 5 AND $motivo == 6 AND $anulado == "no") {
            $response = array(
                'success' => false,
                'titulo' => 'Verifique su informacion!',
                'mensaje' => '<b>No se puede dar mas de 5 dias Personales al año</b><h6>Desea guardar el registro</h6>'
            );
        } else if ($diasT > 5 AND $motivo == 6 AND $anulado == "no") {
            $response = array(
                'success' => false,
                'titulo' => 'Verifique su informacion!',
                'mensaje' => '<b>No se puede dar mas de 5 dias Personales al año</b><h6>Desea guardar el registro</h6>'
            );
            //validar que la fecha solicitada no sea mayos a los 15 dias suma de dias y horas de base y horas del formulario
        } else if ($diasH > 5 AND $motivo == 6 AND $anulado == "no") {
            $response = array(
                'success' => false,
                'titulo' => 'Verifique su informacion!',
                'mensaje' => '<b>No se puede dar mas de 5 dias Personales al año</b><h6>Desea guardar el registro</h6>'
            );

        } else {
            
   $sql = "SELECT id_empleado, fecha_desde, fecha_hasta FROM permiso WHERE id_empleado=:txtNombreEmpleado AND (fecha_desde BETWEEN :dtFechaDesde AND :dtFechaHasta)";
    $param_list = array("dtFechaDesde","dtFechaHasta","txtNombreEmpleado");
    $response = $data->query($sql, $params, $param_list);

    if($response['total'] > 0){
       $response = array(
                    "success" => true,
                    'titulo' => 'Verifique su información!',
                    'mensaje' => 'Este empleado ya ha solicitado un permiso en esta fecha'
                );
     }else{
            if (isset($params["txtotros"])) {
                $sql        = "INSERT INTO permiso (num_permiso,  fecha_dif, fecha_drh, hora_desde, hora_hasta, fecha_desde, fecha_hasta, anulacion, observacion, motivo_otros, codigo_rrhh, fecha_procesamiento, id_empleado, id_motivo) VALUES(:txtNumeroPermiso, :dtFechaDif, :dtFechaDrh, :hrDesde, :hrAsta, :dtFechaDesde, :dtFechaHasta, :txtAnulacion, :txtObservacion, :txtotros, :codigoDrh, NOW(), :txtNombreEmpleado, :txtmotivo)";
                $param_list = array(
                    "txtNumeroPermiso",
                    "dtFechaDif",
                    "dtFechaDrh",
                    "hrDesde",
                    "hrAsta",
                    "dtFechaDesde",
                    "dtFechaHasta",
                    "txtAnulacion",
                    "txtObservacion",
                    "txtotros",
                    "codigoDrh",
                    "txtNombreEmpleado",
                    "txtmotivo"
                );
            } else {
                $sql        = "INSERT INTO permiso (num_permiso, fecha_dif, fecha_drh, hora_desde, hora_hasta, fecha_desde, fecha_hasta, anulacion, observacion, codigo_rrhh, fecha_procesamiento, id_empleado, id_motivo) VALUES(:txtNumeroPermiso, :dtFechaDif, :dtFechaDrh, :hrDesde, :hrAsta, :dtFechaDesde, :dtFechaHasta, :txtAnulacion, :txtObservacion, :codigoDrh, NOW(), :txtNombreEmpleado, :txtmotivo)";
                $param_list = array(
                    "txtNumeroPermiso",
                    "dtFechaDif",
                    "dtFechaDrh",
                    "hrDesde",
                    "hrAsta",
                    "dtFechaDesde",
                    "dtFechaHasta",
                    "txtAnulacion",
                    "txtObservacion",
                    "codigoDrh",
                    "txtNombreEmpleado",
                    "txtmotivo"
                );
            }
            $response    = $data->query($sql, $params, $param_list, true);
            $target_path = "../upload/permisos/";
            if ($response['insertId'] != 0) {
                $total = count($_FILES["txtArchivo"]['size']);
                for ($i = 0; $i < $total; $i++) {
                    $params['nombreDoc']  = $_FILES["txtArchivo"]["name"][$i];
                    $trozos               = explode(".", $params['nombreDoc']);
                    $params["extension"] = pathinfo($trozos, PATHINFO_EXTENSION);
                    $params['id_permiso'] = intval($response['insertId']);
                    $target_path          = $target_path . basename($_FILES['txtArchivo']['name'][$i]);
                    @move_uploaded_file($_FILES['txtArchivo']['tmp_name'][$i], $target_path);
                    $sql        = "INSERT INTO docu_permiso(documento, tipo, id_permiso) VALUES (:nombreDoc, :extension, :id_permiso)";
                    $param_list = array("nombreDoc","extension","id_permiso");
                    $response   = $data->query($sql, $params, $param_list, true);
                }
            }
            if ($response['insertId'] > 0) {
                $response = array(
                    "success" => true,
                    'titulo' => 'Operacion exitosa!',
                    'mensaje' => 'Se ha guardado el Permiso'
                );
            } else {
                $response = array(
                    'success' => true,
                    'titulo' => 'Verifique su informacion!',
                    'mensaje' => 'No se guardo el registro'
                );
            }
        }
    }

  }

}
echo json_encode($response);
?>