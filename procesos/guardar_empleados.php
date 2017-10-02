<?php

@session_start();
include("../sql/class.managerDB.php");
include("../sql/class.data.php");
$data = new data();

$params = $_POST;
$params["dtFecha"] = ($params["dtFecha"] != "") ? $params["dtFecha"] : NULL;
$params["txtNumTarjeta"] = ($params["txtNumTarjeta"] != "") ? $params["txtNumTarjeta"] : NULL;

if (isset($params["txtId"])) {
    $sql1 = "UPDATE empleado SET codigo=:txtCodigo, nombre=:txtNombre, apellido=:txtApellido, estado_civil=:txtTEcivil, DUI=:txtDui, NIT=:txtNit, NUP=:txtNup, ISSS=:txtIsss, direccion=:txtDireccion, fecha_contratacion=:dtFecha, titulo=:txtTitulo, cargo=:txtCargo, num_tarjeta_marcacion=:txtNumTarjeta, tipo_contratacion=:txtTipoContrato, tipo_sangre=:txtTipoSangre, persona_encargada=:txtPersonaEncargada WHERE id_empleado=:txtId ";
    $param_list = array("txtCodigo", "txtNombre", "txtApellido","txtTEcivil", "txtDui", "txtNit", "txtNup", "txtIsss", "txtDireccion", "dtFecha", "txtTitulo", "txtCargo", "txtNumTarjeta", "txtTipoContrato", "txtTipoSangre", "txtPersonaEncargada","txtId");
    $response = $data->query($sql1, $params, $param_list);
    
    $sql2 = "UPDATE telefono_emp SET telefono=:txtTelefono2 WHERE id_empleado=:txtId AND tipo='Movil'";
    $param_list = array("txtTelefono2","txtId");
    $response2 = $data->query($sql2, $params, $param_list);

    $sql3 = "UPDATE telefono_emp SET telefono=:txtTelefono WHERE id_empleado=:txtId AND tipo='Fijo'";
    $param_list = array("txtTelefono","txtId");
    $response3 = $data->query($sql3, $params, $param_list);
    
    $sql4 = "UPDATE telefono_emp SET telefono=:txtTelefonoPersonaEncargada WHERE id_empleado=:txtId AND tipo='Encargado'";
    $param_list = array("txtTelefonoPersonaEncargada","txtId");
    $response4 = $data->query($sql4, $params, $param_list);

    $sql5 = "SELECT id_seccion FROM empleado_seccion WHERE id_empleado=:txtId AND estado='Activo' AND fecha_final IS NULL";
    $param_list = array("txtId");
    $response5 = $data->query($sql5, $params, $param_list);

    if($response5['items'][0]['id_seccion'] != $params["txtSeccion"]){
        $sql6="UPDATE empleado_seccion SET estado='Inactivo', observacion='El empleado se cambio de sección', fecha_final=NOW() WHERE id_empleado=:txtId";
        $param_list = array("txtId");
        $response6 = $data->query($sql6, $params, $param_list);

        $sql7="INSERT INTO empleado_seccion (estado, id_empleado, id_seccion, fecha_procesamiento)  VALUES ('Activo', :txtId, :txtSeccion, NOW())";
        $param_list = array("txtId", "txtSeccion");
        $response = $data->query($sql7, $params, $param_list, true);
    }
    if ($response['success'] == true) {
        $response = array('success'=>true, 'titulo' => 'Operacion exitosa!', 'mensaje'=>'Se modifico el empleado');
    } else {
        $response = array('success'=>false, 'titulo'=>'Verifique su informacion!', 'mensaje'=>'No se modifico el registro');
    }
} else {
    $sql = "SELECT * FROM empleado WHERE codigo=:txtCodigo";
    $param_list = array("txtCodigo");
    $response = $data->query($sql, $params, $param_list);
    if ($response['total'] > 0) {
        $response = array('success'=>false, 'titulo'=>'Verifique su informacion!', 'mensaje'=>'Este codigo de empleado ya fue ingresado');
    } else {
        $sql = "INSERT INTO empleado (codigo, nombre, apellido, estado_civil, DUI, NIT, NUP, ISSS, direccion, fecha_contratacion, titulo, cargo, tipo_contratacion, tipo_sangre, persona_encargada, num_tarjeta_marcacion) VALUES (:txtCodigo, :txtNombre, :txtApellido,:txtTEcivil, :txtDui, :txtNit, :txtNup, :txtIsss, :txtDireccion, :dtFecha, :txtTitulo, :txtCargo, :txtTipoContrato, :txtTipoSangre, :txtPersonaEncargada, :txtNumTarjeta)";
        $param_list = array("txtCodigo", "txtNombre", "txtApellido", "txtTEcivil", "txtDui", "txtNit", "txtNup", "txtIsss", "txtDireccion", "dtFecha", "txtTitulo", "txtCargo", "txtTipoContrato", "txtTipoSangre", "txtPersonaEncargada", "txtNumTarjeta");
        $response = $data->query($sql, $params, $param_list, true);
        if ($response['insertId'] > 0) {

            $params["id_empleado"] = $response['insertId'];

            if ($params["txtTelefono"] != "") {
                $sql = "INSERT INTO telefono_emp (tipo, telefono, id_empleado) VALUES ('Fijo', :txtTelefono, :id_empleado)";
                $param_list = array("txtTelefono", "id_empleado");
                $response = $data->query($sql, $params, $param_list, true);

            }
            if($params["txtTelefono2"] != "") {
                $sql = "INSERT INTO telefono_emp (tipo, telefono, id_empleado) VALUES ('Movil', :txtTelefono2, :id_empleado)";
                $param_list = array("txtTelefono2", "id_empleado");
                $response = $data->query($sql, $params, $param_list, true);

            }
            if($params["txtTelefonoPersonaEncargada"] != "") {
                $sql = "INSERT INTO telefono_emp (tipo, telefono, id_empleado) VALUES ('Encargado', :txtTelefonoPersonaEncargada, :id_empleado)";
                $param_list = array("txtTelefonoPersonaEncargada", "id_empleado");
                $response = $data->query($sql, $params, $param_list, true);
            }

            $sql = "INSERT INTO empleado_seccion (estado, fecha_procesamiento, id_empleado, id_seccion) VALUES ('Activo', NOW(), :id_empleado, :txtSeccion )";
            $param_list = array("id_empleado", "txtSeccion");
            $response = $data->query($sql, $params, $param_list, true);

            if ($response['insertId'] > 0) {
                $response = array("success"=>true, 'titulo'=>'Operacion exitosa!', 'mensaje'=>'Se ha guardado el empleado');
            } else {
                $response = array('success'=>false, 'titulo'=>'Verifique su informacion!', 'mensaje'=>'No se guardo el registro');
            }
        }
    }
}

echo json_encode($response);
?>