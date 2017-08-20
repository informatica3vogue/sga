<?php

include_once ("class.managerDB.php");

class dataTable {

    //constructor
    function dataTable() {
        
    }

    function obtener_Usuarios($id_dependencia="") { 
        $managerDB = new managerDB(); 
        $connection = $managerDB->conectar("mysql"); 
        if ($connection!=null) {
            $response=array('success'=>true);
            if ($id_dependencia != "") {
                $sql = "SELECT DISTINCT empleado.id_empleado, usuario.id_usuario, INITCAP(empleado.nombre) AS nombre, INITCAP(empleado.apellido) AS apellido, usuario.usuario, rol.id_rol, rol.rol, IF(usuario.estado!='', usuario.estado, 'Sin acceso') AS estado, seccion.id_seccion, seccion.seccion, seccion.id_dependencia, (SELECT bdd.dependencia FROM bddependencias.dependencia bdd WHERE bdd.id_dependencia=seccion.id_dependencia) AS dependencia
                FROM seccion INNER JOIN empleado_seccion ON seccion.id_seccion=empleado_seccion.id_seccion
                INNER JOIN empleado ON empleado.id_empleado=empleado_seccion.id_empleado
                LEFT JOIN usuario ON usuario.id_empleado = empleado.id_empleado 
                LEFT JOIN rol ON rol.id_rol = usuario.id_rol
                WHERE seccion.id_dependencia=:id_dependencia AND rol.id_rol <> 5 OR seccion.id_dependencia=:id_dependencia AND empleado_seccion.estado = 'Activo' 
                ORDER BY usuario.estado DESC";
            }else{
                $sql = "SELECT DISTINCT empleado.id_empleado, usuario.id_usuario, INITCAP(empleado.nombre) AS nombre, INITCAP(empleado.apellido) AS apellido, usuario.usuario, rol.id_rol, rol.rol, IF(usuario.estado!='', usuario.estado, 'Sin acceso') AS estado, seccion.id_seccion, seccion.seccion, seccion.id_dependencia, (SELECT bdd.dependencia FROM bddependencias.dependencia bdd WHERE bdd.id_dependencia=seccion.id_dependencia) AS dependencia
                FROM seccion INNER JOIN empleado_seccion ON seccion.id_seccion=empleado_seccion.id_seccion
                INNER JOIN empleado ON empleado.id_empleado=empleado_seccion.id_empleado
                LEFT JOIN usuario ON usuario.id_empleado = empleado.id_empleado 
                LEFT JOIN rol ON rol.id_rol = usuario.id_rol
                WHERE empleado_seccion.estado = 'Activo'
                ORDER BY usuario.estado DESC";
            }
            try {
                $query=$connection->prepare($sql);
                if ($id_dependencia != "") {
                    $query->execute(array('id_dependencia'=>intval($id_dependencia)));
                }else{
                    $query->execute();
                }
                $response['items']=$query->fetchAll(PDO::FETCH_ASSOC);
                $response['total']=$query->rowCount();
            } catch(PDOException $error) { 
                if ($transaction) $connection->rollback();
                $response= array('success'=>false, 'error'=>$error->getMessage());
            }
        } else {
            $response= array('success'=>false, 'error'=>'No está conectado al servidor de bases de datos.');
        }
        return $response;
        unset($connection);
        unset($query);
    }

    function obtener_Secciones($id_dependencia) { 
        $managerDB = new managerDB(); 
        $connection = $managerDB->conectar("mysql"); 
        if ($connection!=null) {
            $response=array('success'=>true);
            $sql = "SELECT sec.id_seccion, sec.seccion, sec.id_dependencia, dep.abreviatura FROM seccion sec INNER JOIN dependencia dep ON sec.id_dependencia = dep.id_dependencia WHERE sec.id_dependencia=:id_dependencia";
            try {
                $query=$connection->prepare($sql);
                $query->execute(array('id_dependencia'=>intval($id_dependencia)));
                $response['items']=$query->fetchAll(PDO::FETCH_ASSOC);
                $response['total']=$query->rowCount();
            } catch(PDOException $error) { 
                if ($transaction) $connection->rollback();
                $response= array('success'=>false, 'error'=>$error->getMessage());
            }
        } else {
            $response= array('success'=>false, 'error'=>'No está conectado al servidor de bases de datos.');
        }
        return $response;
        unset($connection);
        unset($query);
    }

    function obtener_Repositorios($id_usuario, $id_dependencia) { 
        $managerDB = new managerDB(); 
        $connection = $managerDB->conectar("mysql"); 
        if ($connection!=null) {
            $response=array('success'=>true);
            $sql = "SELECT  DISTINCT r.id_repositorio, r.tipo_repositorio, (SELECT DISTINCT us_re.id_usuario FROM usuario_repositorio us_re WHERE us_re.tipo = 1 AND us_re.id_repositorio = r.id_repositorio) AS id_propietario, DATE_FORMAT(r.fecha_creacion,'%m-%d-%Y') AS fecha_creacion, r.alias, r.observacion, (SELECT GROUP_CONCAT(DISTINCT CONCAT(emp.nombre,' ', emp.apellido)) FROM empleado emp INNER JOIN usuario u ON emp.id_empleado = u.id_empleado INNER JOIN usuario_repositorio usr ON u.id_usuario = usr.id_usuario WHERE usr.id_repositorio=r.id_repositorio AND usr.tipo <> 1 AND usr.estado='Activo') AS compartido, (SELECT GROUP_CONCAT(DISTINCT CONCAT(empleado.nombre,' ', empleado.apellido)) FROM empleado INNER JOIN usuario  ON empleado.id_empleado = usuario.id_empleado INNER JOIN usuario_repositorio ON usuario.id_usuario = usuario_repositorio.id_usuario WHERE usuario_repositorio.id_repositorio=r.id_repositorio AND usuario_repositorio.tipo = 1) AS propietario FROM repositorio r INNER JOIN usuario_repositorio ur ON r.id_repositorio=ur.id_repositorio WHERE ur.id_usuario = :id_usuario AND id_dependencia = :id_dependencia AND ur.estado <> 2 ORDER BY r.fecha_creacion DESC";
            try {
                $query=$connection->prepare($sql);
                $query->execute(array('id_usuario'=>$id_usuario,'id_dependencia'=>intval($id_dependencia)));
                $response['items']=$query->fetchAll(PDO::FETCH_ASSOC);
                $response['total']=$query->rowCount();
            } catch(PDOException $error) { 
                if ($transaction) $connection->rollback();
                $response= array('success'=>false, 'error'=>$error->getMessage());
            }
        } else {
            $response= array('success'=>false, 'error'=>'No está conectado al servidor de bases de datos.');
        }
        return $response;
        unset($connection);
        unset($query);
    }

    function obtener_Empleados_Activos($id_dependencia) { 
        $managerDB = new managerDB(); 
        $connection = $managerDB->conectar("mysql"); 
        if ($connection!=null) {
            $response=array('success'=>true);
            $sql = "SELECT empleado.id_empleado, empleado.codigo, empleado.num_tarjeta_marcacion, INITCAP(empleado.nombre) AS nombre, INITCAP(empleado.apellido) AS apellido, empleado.estado_civil, empleado.DUI, empleado.NIT, empleado.NUP, empleado.ISSS, empleado.direccion, DATE_FORMAT(empleado.fecha_contratacion,'%m-%d-%Y') AS fecha_contratacion, empleado.titulo, IF(empleado.cargo!= '', INITCAP(empleado.cargo), '') AS cargo, empleado.tipo_contratacion, empleado.tipo_sangre, empleado.persona_encargada, empleado_seccion.estado,empleado_seccion.fecha_final, seccion.id_seccion, seccion.seccion, (SELECT GROUP_CONCAT(telefono) FROM telefono_emp WHERE tipo='Movil' AND telefono_emp.id_empleado=empleado.id_empleado) AS movil, (SELECT GROUP_CONCAT(telefono) FROM telefono_emp WHERE tipo='Fijo' AND telefono_emp.id_empleado=empleado.id_empleado) AS fijo, (SELECT GROUP_CONCAT(telefono) FROM telefono_emp WHERE tipo='Encargado' AND telefono_emp.id_empleado=empleado.id_empleado) AS encargado FROM empleado INNER JOIN empleado_seccion ON empleado_seccion.id_empleado=empleado.id_empleado INNER JOIN seccion ON seccion.id_seccion=empleado_seccion.id_seccion WHERE seccion.id_dependencia=:id_dependencia AND empleado_seccion.estado='Activo' ORDER BY empleado_seccion.estado, seccion.seccion, empleado.nombre ASC";            
            try {
                $query=$connection->prepare($sql);
                $query->execute(array('id_dependencia'=>intval($id_dependencia)));
                $response['items']=$query->fetchAll(PDO::FETCH_ASSOC);
                $response['total']=$query->rowCount();
            } catch(PDOException $error) { 
                if ($transaction) $connection->rollback();
                $response= array('success'=>false, 'error'=>$error->getMessage());
            }
        } else {
            $response= array('success'=>false, 'error'=>'No está conectado al servidor de bases de datos.');
        }
        return $response;
        unset($connection);
        unset($query);
    }

    function obtener_Empleados_Inactivos($id_dependencia) { 
        $managerDB = new managerDB(); 
        $connection = $managerDB->conectar("mysql"); 
        if ($connection!=null) {
            $response=array('success'=>true);
            $sql = "SELECT empleado.id_empleado, empleado.codigo, empleado.num_tarjeta_marcacion, INITCAP(empleado.nombre) AS nombre, INITCAP(empleado.apellido) AS apellido, empleado.estado_civil, empleado.DUI, empleado.NIT, empleado.NUP, empleado.ISSS, empleado.direccion, DATE_FORMAT(empleado.fecha_contratacion,'%m-%d-%Y') AS fecha_contratacion, empleado.titulo, IF(empleado.cargo!= '', INITCAP(empleado.cargo), '') AS cargo, empleado.tipo_contratacion, empleado.tipo_sangre, empleado.persona_encargada, empleado_seccion.estado,DATE_FORMAT(empleado_seccion.fecha_final,'%m-%d-%Y') AS fecha_final, empleado_seccion.observacion, seccion.id_seccion, seccion.seccion, (SELECT GROUP_CONCAT(telefono) FROM telefono_emp WHERE tipo='Movil' AND telefono_emp.id_empleado=empleado.id_empleado) AS movil, (SELECT GROUP_CONCAT(telefono) FROM telefono_emp WHERE tipo='Fijo' AND telefono_emp.id_empleado=empleado.id_empleado) AS fijo, (SELECT GROUP_CONCAT(telefono) FROM telefono_emp WHERE tipo='Encargado' AND telefono_emp.id_empleado=empleado.id_empleado) AS encargado FROM empleado INNER JOIN empleado_seccion ON empleado_seccion.id_empleado=empleado.id_empleado INNER JOIN seccion ON seccion.id_seccion=empleado_seccion.id_seccion WHERE seccion.id_dependencia=:id_dependencia AND empleado_seccion.estado='Inactivo' ORDER BY empleado_seccion.estado, seccion.seccion, empleado.nombre ASC";            
            try {
                $query=$connection->prepare($sql);
                $query->execute(array('id_dependencia'=>intval($id_dependencia)));
                $response['items']=$query->fetchAll(PDO::FETCH_ASSOC);
                $response['total']=$query->rowCount();
            } catch(PDOException $error) { 
                if ($transaction) $connection->rollback();
                $response= array('success'=>false, 'error'=>$error->getMessage());
            }
        } else {
            $response= array('success'=>false, 'error'=>'No está conectado al servidor de bases de datos.');
        }
        return $response;
        unset($connection);
        unset($query);
    }

    function obtener_Articulos_Existencia($id_dependencia) { 
        $managerDB = new managerDB(); 
        $connection = $managerDB->conectar("mysql"); 
        if ($connection!=null) {
            $response=array('success'=>true);
            $sql = "SELECT art.id_articulo, art.articulo, IF(art.existencia=0, 'Agotado', art.existencia) AS existencia, art.descripcion, m.id_marca, m.marca, l.id_linea, l.linea, u.id_unidad, u.unidad_medida, c.id_categoria FROM articulo art INNER JOIN marca m ON art.id_marca = m.id_marca INNER JOIN linea l ON art.id_linea = l.id_linea INNER JOIN unidad u ON art.id_unidad = u.id_unidad INNER JOIN categoria c ON c.id_categoria = art.id_categoria WHERE art.id_dependencia = :id_dependencia AND c.id_categoria=2 ORDER BY art.articulo ASC ";
            try {
                $query=$connection->prepare($sql);
                $query->execute(array('id_dependencia'=>intval($id_dependencia)));
                $response['items']=$query->fetchAll(PDO::FETCH_ASSOC);
                $response['total']=$query->rowCount();
            } catch(PDOException $error) { 
                if ($transaction) $connection->rollback();
                $response= array('success'=>false, 'error'=>$error->getMessage());
            }
        } else {
            $response= array('success'=>false, 'error'=>'No está conectado al servidor de bases de datos.');
        }
        return $response;
        unset($connection);
        unset($query);
    }

    function obtener_Descargos_Bodega($id_dependencia) { 
        $managerDB = new managerDB(); 
        $connection = $managerDB->conectar("mysql"); 
        if ($connection!=null) {
            $response=array('success'=>true);
            $sql = "SELECT DISTINCT CONCAT(INITCAP(emp.nombre),' ',INITCAP(emp.apellido)) AS nombre, desc_bod.id_descargo_bodega, desc_bod.observacion, DATE_FORMAT(desc_bod.fecha, '%d-%m-%Y %H:%i:%s') AS fecha FROM descargo_bodega desc_bod INNER JOIN usuario us ON us.id_usuario = desc_bod.id_usuario INNER JOIN empleado emp ON us.id_empleado = emp.id_empleado WHERE desc_bod.id_dependencia=:id_dependencia ORDER BY fecha ASC";
            try {
                $query=$connection->prepare($sql);
                $query->execute(array('id_dependencia'=>intval($id_dependencia)));
                $response['items']=$query->fetchAll(PDO::FETCH_ASSOC);
                $response['total']=$query->rowCount();
            } catch(PDOException $error) { 
                if ($transaction) $connection->rollback();
                $response= array('success'=>false, 'error'=>$error->getMessage());
            }
        } else {
            $response= array('success'=>false, 'error'=>'No está conectado al servidor de bases de datos.');
        }
        return $response;
        unset($connection);
        unset($query);
    }
    
    function obtener_Cargos_Bodega($id_dependencia) { 
        $managerDB = new managerDB(); 
        $connection = $managerDB->conectar("mysql"); 
        if ($connection!=null) {
            $response=array('success'=>true);
            $sql = "SELECT DISTINCT CONCAT(INITCAP(emp.nombre),' ',INITCAP(emp.apellido)) AS nombre, DATE_FORMAT(cargo.fecha, '%d-%m-%Y %H:%i:%s') AS fecha, art.articulo, cargo.cantidad, cargo.referencia, cargo.observacion FROM cargo_bodega cargo INNER JOIN usuario us ON us.id_usuario = cargo.id_usuario INNER JOIN empleado emp ON us.id_empleado = emp.id_empleado INNER JOIN articulo art ON cargo.id_articulo=art.id_articulo WHERE cargo.id_dependencia=:id_dependencia ORDER BY fecha ASC";
            try {
                $query=$connection->prepare($sql);
                $query->execute(array('id_dependencia'=>intval($id_dependencia)));
                $response['items']=$query->fetchAll(PDO::FETCH_ASSOC);
                $response['total']=$query->rowCount();
            } catch(PDOException $error) { 
                if ($transaction) $connection->rollback();
                $response= array('success'=>false, 'error'=>$error->getMessage());
            }
        } else {
            $response= array('success'=>false, 'error'=>'No está conectado al servidor de bases de datos.');
        }
        return $response;
        unset($connection);
        unset($query);
    }

    function obtener_Permisos($id_dependencia) { 
        $managerDB = new managerDB(); 
        $connection = $managerDB->conectar("mysql"); 
        if ($connection!=null) {
            $response=array('success'=>true);
            $sql = "SELECT DISTINCT permiso.id_permiso, permiso.num_permiso, permiso.fecha_dif, permiso.fecha_drh, permiso.hora_desde, permiso.hora_hasta, permiso.fecha_desde, permiso.fecha_hasta, permiso.anulacion, permiso.observacion, permiso.codigo_rrhh, permiso.motivo_otros, permiso.id_empleado, docu_permiso.documento, empleado.codigo, motivo.id_motivo, DATE_FORMAT(permiso.fecha_dif, '%d-%m-%Y') AS f_dif, DATE_FORMAT(permiso.fecha_desde, '%d-%m-%Y') AS fecha_desde , DATE_FORMAT(permiso.fecha_hasta, '%d-%m-%Y') AS fecha_hasta , DATE_FORMAT(hora_desde, ' %h:%m:%s %p') AS hora_desde, DATE_FORMAT(permiso.hora_hasta, ' %h:%m:%s %p') AS hora_hasta, DATEDIFF(permiso.fecha_hasta, permiso.fecha_desde) AS dias, SEC_TO_TIME(TIME_TO_SEC(TIMEDIFF(permiso.hora_hasta, permiso.hora_desde)))AS horas, motivo.motivo, CONCAT(INITCAP(empleado.nombre), ' ', INITCAP(empleado.apellido)) AS nombre_completo FROM permiso INNER JOIN motivo ON permiso.id_motivo= motivo.id_motivo INNER JOIN empleado ON empleado.id_empleado = permiso.id_empleado INNER JOIN empleado_seccion es ON empleado.id_empleado = es.id_empleado INNER JOIN seccion sec ON sec.id_seccion = es.id_seccion LEFT JOIN docu_permiso ON permiso.id_permiso = docu_permiso.id_permiso WHERE sec.id_dependencia = :id_dependencia ORDER BY permiso.fecha_dif, motivo.motivo DESC";
            try {
                $query=$connection->prepare($sql);
                $query->execute(array('id_dependencia'=>intval($id_dependencia)));
                $response['items']=$query->fetchAll(PDO::FETCH_ASSOC);
                $response['total']=$query->rowCount();
            } catch(PDOException $error) { 
                if ($transaction) $connection->rollback();
                $response= array('success'=>false, 'error'=>$error->getMessage());
            }
        } else {
            $response= array('success'=>false, 'error'=>'No está conectado al servidor de bases de datos.');
        }
        return $response;
        unset($connection);
        unset($query);
    }

    function obtener_Articulos_Insumos($id_dependencia) { 
        $managerDB = new managerDB(); 
        $connection = $managerDB->conectar("mysql"); 
        if ($connection!=null) {
            $response=array('success'=>true);
            $sql = "SELECT art.id_articulo, art.articulo, IF(art.existencia=0, 'Agotado', art.existencia) AS existencia, art.descripcion, m.id_marca, m.marca, l.id_linea, l.linea, u.id_unidad, u.unidad_medida, c.id_categoria FROM articulo art INNER JOIN marca m ON art.id_marca = m.id_marca INNER JOIN linea l ON art.id_linea = l.id_linea INNER JOIN unidad u ON art.id_unidad = u.id_unidad INNER JOIN categoria c ON c.id_categoria = art.id_categoria WHERE art.id_dependencia = :id_dependencia AND c.id_categoria=1 ORDER BY art.articulo ASC ";
            try {
                $query=$connection->prepare($sql);
                $query->execute(array('id_dependencia'=>intval($id_dependencia)));
                $response['items']=$query->fetchAll(PDO::FETCH_ASSOC);
                $response['total']=$query->rowCount();
            } catch(PDOException $error) { 
                if ($transaction) $connection->rollback();
                $response= array('success'=>false, 'error'=>$error->getMessage());
            }
        } else {
            $response= array('success'=>false, 'error'=>'No está conectado al servidor de bases de datos.');
        }
        return $response;
        unset($connection);
        unset($query);
    }

    function obtener_Solicitudes_Insumos($id_usuario) { 
        $managerDB = new managerDB(); 
        $connection = $managerDB->conectar("mysql"); 
        if ($connection!=null) {
            $response=array('success'=>true);
            $sql = "SELECT DISTINCT sa.id_solicitud_articulo, sa.referencia, sa.id_usuario, DATE_FORMAT(sa.fecha, '%d-%m-%Y %h:%m:%s %p') AS fecha FROM solicitud_articulo sa INNER JOIN usuario us ON sa.id_usuario = us.id_usuario INNER JOIN detalle_solicitud ds ON sa.id_solicitud_articulo = ds.id_solicitud_articulo WHERE sa.id_usuario = :id_usuario ORDER BY sa.fecha DESC";
            try {
                $query=$connection->prepare($sql);
                $query->execute(array('id_usuario'=>intval($id_usuario)));
                $response['items']=$query->fetchAll(PDO::FETCH_ASSOC);
                $response['total']=$query->rowCount();
            } catch(PDOException $error) { 
                if ($transaction) $connection->rollback();
                $response= array('success'=>false, 'error'=>$error->getMessage());
            }
        } else {
            $response= array('success'=>false, 'error'=>'No está conectado al servidor de bases de datos.');
        }
        return $response;
        unset($connection);
        unset($query);
    }

    function obtener_Solicitudes($id_dependencia) { 
        $managerDB = new managerDB(); 
        $connection = $managerDB->conectar("mysql"); 
        if ($connection!=null) {
            $response=array('success'=>true);
            $sql = "SELECT DISTINCT sa.id_solicitud_articulo, sa.referencia, sa.estado, sa.id_usuario, DATE_FORMAT(sa.fecha, '%d-%m-%Y %h:%m:%s %p') AS fecha, CONCAT(INITCAP(emp.nombre), ' ', INITCAP(emp.apellido)) AS nombre_completo FROM solicitud_articulo sa INNER JOIN detalle_solicitud ds ON sa.id_solicitud_articulo = ds.id_solicitud_articulo INNER JOIN usuario us ON sa.id_usuario = us.id_usuario INNER JOIN empleado emp ON emp.id_empleado=us.id_empleado INNER JOIN empleado_seccion es ON emp.id_empleado=es.id_empleado INNER JOIN seccion sec ON sec.id_seccion=es.id_seccion LEFT JOIN descargos des ON ds.id_solicitud_articulo=des.id_solicitud_articulo  WHERE sec.id_dependencia=:id_dependencia ORDER BY sa.estado DESC";
            try {
                $query=$connection->prepare($sql);
                $query->execute(array('id_dependencia'=>intval($id_dependencia)));
                $response['items']=$query->fetchAll(PDO::FETCH_ASSOC);
                $response['total']=$query->rowCount();
            } catch(PDOException $error) { 
                if ($transaction) $connection->rollback();
                $response= array('success'=>false, 'error'=>$error->getMessage());
            }
        } else {
            $response= array('success'=>false, 'error'=>'No está conectado al servidor de bases de datos.');
        }
        return $response;
        unset($connection);
        unset($query);
    }
}
?>