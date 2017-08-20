<?php
@ob_start();
@session_start();
include("../sql/class.data.php");
$data = new data();
 
$params = $_POST;
$psw2 = 'csj2016';
$response=array('success'=>false, 'titulo'=>'Verifique su información!', 'mensaje'=>'Llene correctamente los campos');

if ($params["txtusuario"] === "" || $params["txtusuario"] === null || trim($params["txtusuario"]) === "" || $params["txtpassword"] === "" || $params["txtpassword"] === null || trim($params["txtpassword"]) === "") {
    $response=array('success'=>false, 'titulo'=>'Verifique su información!', 'mensaje'=>'Llene correctamente los campos');
} else {
    $sql="SELECT DISTINCT empleado.id_empleado, usuario.id_usuario, empleado.nombre, empleado.apellido, empleado.cargo, usuario.usuario, rol.id_rol, rol.rol, IF(usuario.estado!='', usuario.estado, 'Sin acceso') AS estado, seccion.id_seccion, seccion.seccion, seccion.id_dependencia, dependencia.abreviatura, (SELECT bdd.dependencia FROM bddependencias.dependencia bdd WHERE bdd.id_dependencia=seccion.id_dependencia) AS dependencia
        FROM dependencia INNER JOIN seccion ON dependencia.id_dependencia=seccion.id_dependencia 
        INNER JOIN empleado_seccion ON seccion.id_seccion=empleado_seccion.id_seccion
        INNER JOIN empleado ON empleado.id_empleado=empleado_seccion.id_empleado
        INNER JOIN usuario ON usuario.id_empleado = empleado.id_empleado 
        INNER JOIN rol ON rol.id_rol = usuario.id_rol
        WHERE usuario.usuario=:txtusuario AND usuario.contrasenia=md5(:txtpassword)";
    $param_list = array("txtusuario", "txtpassword");
    $response = $data->query($sql, $params, $param_list);
    if ($response["success"] == true) {
        if ($response["total"] > 0) {
            if ($response["items"][0]["estado"] == "Activo") {
                $_SESSION["actividades"] = true;
                $_SESSION["login"] = true;
                $_SESSION["id_usuario"] = $response["items"][0]["id_usuario"];
                $_SESSION["id_empleado"] = $response["items"][0]["id_empleado"];
                $_SESSION["nombre"] = $response["items"][0]["nombre"]." ".$response["items"][0]["apellido"];
                $_SESSION["id_rol"] = $response["items"][0]["id_rol"];
                $_SESSION["cargo"] = $response["items"][0]["cargo"];
                $_SESSION["id_seccion"] = $response["items"][0]["id_seccion"];
                $_SESSION["seccion"] = $response["items"][0]["seccion"];
                $_SESSION["id_dependencia"] = $response["items"][0]["id_dependencia"];
                $_SESSION["dependencia"] = $response["items"][0]["dependencia"];
                $_SESSION["abreviatura"] = $response["items"][0]["abreviatura"];
                $sql = "INSERT INTO bitacora(accion, tipo_accion, fecha_procesamiento, id_usuario) VALUES ('Inicio de sesion', 4, NOW(), :id_usuario)";
                $response_bitacora = $data->query($sql, array('id_usuario' => $_SESSION["id_usuario"]), array(), true); 
                if ($response_bitacora["insertId"] > 0) {
                    if ($params["txtpassword"] == $psw2) { 
                        $response=array('success'=>true, 'modulo'=>'?mod=contrasena', 'titulo'=>'Bienvenido', 'mensaje'=> 'Usuario: '.$_SESSION["nombre"]);
                    }else{ 
                        $response=array('success'=>true, 'modulo'=>'?mod=inicio', 'titulo'=>'Bienvenido', 'mensaje'=> 'Usuario: '.$_SESSION["nombre"]);
                    }
                }
            } else {
                $response=array('success'=>false, 'titulo'=>'comunicarse con administrador de sistema!', 'mensaje'=>'Su usuario ha sido dado de baja');
            }
        } else {
            $response=array('success'=>false, 'titulo'=>'Verifique su información!', 'mensaje'=>'Usuario o contrase&ntilde;a invalidos');
        }
    } else {
            $response=array('success'=>false, 'titulo'=>'Error!', 'mensaje'=>'No esta conectado a un servidor de base de datos');
    }
}
echo json_encode($response);
?>