<div class="span12">
    <!-- start submenu -->
    <ul class="breadcrumb">
        <a href="?mod=iusuario" class="icon-plus" title="Ingresar usuarios">&nbsp;Ingresar nuevo usuario</a>
    </ul>
    <!-- end submenu-->
    <div class="box">
        <div class="box-header">
            <h2><i class="halflings-icon white user"></i><span class="break"></span>Registros de usuarios</h2>
            <div class="box-icon">
                <a href="#" data-rel="tooltip" title="Minimizar" class="btn-minimize"><i class="halflings-icon white chevron-up"></i></a>
            </div>
        </div>
        <div class="box-content">
            <div class="table-responsive">
                <table class="table table-striped table-bordered table-hover bootstrap-datatable datatable">
                <thead class="ticket blue">
                <tr>
                    <th><center>
                         N°
                    </center></th>
                    <th><center>
                         Nombre 
                    </center></th>
                    <th><center>
                         Usuario
                    </center></th>
                    <th><center>
                         Rol
                    </center></th>
                    <th><center>
                         Estado
                    </center></th>
                    <th><center>
                         Dependencia
                    </center></th>
                    <th><center>
                         Acciones
                    </center></th>
                </tr>
                </thead>
<?php
                $cont = 1;  
                if ($_SESSION["id_rol"] == 5) {
                    $response = $dataTable->obtener_Usuarios(); 
                }else{
                    $response = $dataTable->obtener_Usuarios($_SESSION["id_dependencia"]);
                }
?>
                <tbody>
<?php    
                    foreach($response['items'] as $datos){
?>
                <tr>
                    <td>
                        <?php echo $cont ?>
                    </td>
                    <td>
                        <?php echo $datos['nombre'].' '.$datos['apellido']; ?>
                    </td>
                    <td class="center">
                        <?php echo $datos['usuario'] ?>
                    </td>
                    <td class="center">
                        <?php echo $datos['rol'] ?>
                    </td>
                    <td class="center"><center>
                        <?php if ($datos['estado'] == 'Activo') { $clase = 'label label-success'; }elseif ($datos['estado'] == 'Inactivo') { $clase = 'label label-important'; }else{ $clase = 'label label-default'; } ?>
                        <span class="<?php echo $clase ?>"><?php echo $datos['estado'] ?>
                        </span>
                    </center></td>
                    <td class="center">
                        <?php echo $datos['dependencia'] ?>
                    </td>
                    <td class="center"><center>
                        <?php if ($datos['estado'] == 'Activo' OR $datos['estado'] == 'Inactivo') { ?>
                            <form action="?mod=musuarios" method="POST">
                                <a class="btn btn-success" data-rel="tooltip" title='Informacion de usuario' data-toggle='modal' data-target='#datos_usuario' onclick="datos_usuario('<?php echo $datos['nombre'] ?>','<?php echo $datos['apellido'] ?>','<?php echo $datos['dependencia'] ?>','<?php echo $datos['seccion'] ?>','<?php echo $datos['usuario'] ?>','<?php echo $datos['rol'] ?>','<?php echo $datos['estado'] ?>');"><i class="halflings-icon white info-sign"></i>
                                </a>
                                <a class="btn btn-warning" href="#" data-rel="tooltip" title='Reestablecer contraseña' onclick="reset_pass(<?php echo $datos['id_usuario'] ?>);"> <i class="halflings-icon white lock"></i>
                                </a>
                                <a class="btn btn-danger" href="#" data-rel="tooltip" title='Cambio de estado' data-toggle='modal' data-target='#modal_usuario' onclick="modificar_estado(<?php echo $datos['id_usuario'] ?>, '<?php echo $datos['nombre'] ?>','<?php echo $datos['apellido'] ?>','<?php echo $datos['estado'] ?>');"> <i class="halflings-icon white retweet"></i>
                                </a>
                                <input type="hidden" name="id" value="<?php echo $datos['id_empleado'] ?>">
                                <button type="submit" class="btn btn-info"><i class="halflings-icon white edit"></button>
                            </form>
                        <?php }else{ ?>
                            <form action="?mod=musuarios" method="POST">
                                <a class="btn btn-success" data-rel="tooltip" title='Informacion de usuario' data-toggle='modal' data-target='#datos_usuario' onclick="datos_usuario('<?php echo $datos['nombre'] ?>','<?php echo $datos['apellido'] ?>','<?php echo $datos['dependencia'] ?>','<?php echo $datos['seccion'] ?>','<?php echo $datos['usuario'] ?>','<?php echo $datos['rol'] ?>','<?php echo $datos['estado'] ?>');"><i class="halflings-icon white info-sign"></i>
                                </a>
                                <a class="btn btn-default" data-rel="tooltip" title='Dar acceso al sistema' data-toggle='modal' data-target='#modal_crear_usuario' onclick="cargar_usuario(<?php echo $datos['id_empleado'] ?>, '<?php echo $datos['nombre'] ?>','<?php echo $datos['apellido'] ?>');"><i class="halflings-icon user"></i>
                                </a>
                                <input type="hidden" name="id" value="<?php echo $datos['id_empleado'] ?>">
                                <button type="submit" class="btn btn-info"><i class="halflings-icon white edit"></button>
                            </form>
                        <?php } ?>
                    </center></td>
                </tr>
                <?php  
                $cont ++;
                } ?>
                </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<!-- Ventana Modal para el cambio de estado del usuario -->
<div class="modal hide fade" id="modal_usuario">
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">×</button>
        <h3>Cambio de estado</h3>
    </div>
    <div class="modal-body">
        <form role="form" method="POST" name="frmEstado" id="frmEstado" onSubmit="return false">
            <input type="hidden" id="txtId2" name="txtId2">
            <div class="form-group">
                <label>Nombre Completo:</label>
                <input type="text" class="form-control" name="txtNombre_Completo" id="txtNombre_Completo" disabled="disable" style="width: 95%;">
            </div>
            <div class="form-group">
                <label>Estado:</label>
                <select name="txtEstado" id="txtEstado" class="form-control" placeholder="Seleccione un Estado" required="true">
                    <option value="Activo">Activo</option>
                    <option value="Inactivo">Inactivo</option>
                </select>
            </div>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-danger pull-left" data-dismiss="modal">Cancelar</button>
            <button type="submit" id="modificar_estado" name="modificar_estado" class="btn btn-primary">Guardar</button>
        </div>
    </form>
</div>
<!-- Ventana Modal para el cambio de estado del usuario -->
<div class="modal hide fade" id="datos_usuario">
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">×</button>
        <h3>Informaci&oacute;n del usuario</h3>
    </div>
    <div class="modal-body">
        <div class="form-group">
            <label>Nombre Completo:</label>
            <input type="text" class="form-control" id="nombre" disabled="disable" style="width: 95%;">
        </div>
        <div class="form-group">
            <label>Usuario:</label>
            <input type="text" class="form-control" id="usuario" disabled="disable" style="width: 95%;">
        </div>
        <div class="form-group">
            <label>Rol:</label>
            <input type="text" class="form-control" id="rol" disabled="disable" style="width: 95%;">
        </div>
        <div class="form-group">
            <label>Estado:</label>
            <input type="text" class="form-control" id="estado" disabled="disable" style="width: 95%;">
        </div>
        <div class="form-group">
            <label>Seccion:</label>
            <input type="text" class="form-control" id="seccion" disabled="disable" style="width: 95%;">
        </div>
        <div class="form-group">
            <label>Dependencia:</label>
            <input type="text" class="form-control" id="dependencia" disabled="disable" style="width: 95%;">
        </div>
    </div>
    <div class="modal-footer">
        <button type="button" class="btn btn-danger pull-right" data-dismiss="modal">Cancelar</button>
    </div>
</div>
<!-- Ventana Modal para el cambio de estado del usuario -->
<form role="form" method="POST" name="frmUsuario" id="frmUsuario" onSubmit="return false">
    <div class="modal hide fade" id="modal_crear_usuario">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal">×</button>
            <h3>Crear usuario de sistema</h3>
        </div>
        <div class="modal-body">
            <input type="hidden" id="id_empleado" name="id_empleado">
            <div class="form-group">
                <label>Nombre Completo:</label>
                <input type="text" class="form-control" name="nombre_completo" id="nombre_completo" disabled="disable" style="width: 95%;">
            </div>
            <div class="form-group">
                <label>Usuario: </label>
                <input type="text" class="form-control" name="usuario" id="usuario" placeholder="Escriba usuario" data-validation="required" data-validation-error-msg="Rellene este campo">
            </div>
            <div class="form-group">
                <label>Rol: </label>
                <select class="form-control" name="id_rol" id="id_rol" data-validation="required" data-validation-error-msg="Rellene este campo"></select>
            </div>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-danger pull-left" data-dismiss="modal">Cancelar</button>
            <button type="submit" id="guardar" name="guardar" class="btn btn-primary">Guardar</button>
        </div>
    </div>
</form>
<script type="text/javascript">
//restablecer contraseña
function reset_pass(id){
    $.confirm('Desea reestablecer la contraseña al usuario?', {title: 'Confirme Si/No', icon: 'help', 
        buttons: {
            "Si": function () {
                $(this).dialog("close");
                $.ajax({
                  type:"POST",
                  url:"procesos/usuario/restablecer_contrasena.php",
                  data: {'id': id},
                  dataType:"json",
                    success: function(response){
                        if(response.success){
                            $.alert(response.msg , { title: 'Operacion exitosa', icon: 'circle-check', buttons: { 'Aceptar': function () { $(this).dialog("close"); location.reload(); }}});
                        } else{
                            $.alert(response.msg , { title: response.titulo, icon: 'circle-check', buttons: { 'Aceptar': function () { $(this).dialog("close"); }}});
                        }
                    }
                });      
            }, "No": function () {
                    $(this).dialog("close");
            }, 
        }
    });
}

// Funcion que nos permitira cambiar el estado del usuario
$(document).ready(function () {
    $('#modificar_estado').click(function () {
        var formulario = $('#frmEstado').serializeArray();
        $.ajax({
            type: 'POST',
            dataType: 'json',
            url: 'procesos/usuario/modificar_estado_usuario.php',
            data: formulario,
        }).done(function (response) {
            if(response.success == false) {
                $.alert(response.mensaje , { title: 'Error', icon: 'circle-check', buttons: { 'Aceptar': function () { $(this).dialog("close"); }}});
            }else{
                $('#modal_usuario').modal('hide');
                $.alert(response.mensaje , { title: 'Operacion exitosa', icon: 'circle-check', buttons: { 'Aceptar': function () { $(this).dialog("close"); location.reload(); }}});
            }
        });
    });
});

// Funcion que nos permitira cambiar el estado del usuario
$(document).ready(function () {
    $('#guardar').click(function () {
        var formulario = $('#frmUsuario').serializeArray();
        $.ajax({
            type: 'POST',
            dataType: 'json',
            url: 'procesos/usuario/crear_usuario.php',
            data: formulario,
        }).done(function (response) {
            if(response.success == false) {
                $('#modal_crear_usuario').modal('hide');
                $.alert(response.error , { title: 'Error', icon: 'circle-check', buttons: { 'Aceptar': function () { $(this).dialog("close"); $('#modal_crear_usuario').modal('show'); }}});
            }else{
                $('#modal_crear_usuario').modal('hide');
                $.alert(response.mensaje , { title: 'Operacion exitosa', icon: 'circle-check', buttons: { 'Aceptar': function () { $(this).dialog("close"); location.reload(); }}});
            }
        });
    });
});

// Funcion que carga el combo del rol
$(document).ready(function(){    
    var miselect = $('#id_rol');
    $.post("procesos/usuario/store_rol.php",
    function (data) {
        miselect.empty();
        miselect.find('option').remove().end().append('<option value="">Seleccione rol</option>').val('');
        for (var i = 0; i < data.total; i++) {
            miselect.append('<option value="' + data.items[i].id_rol + '">' + data.items[i].rol + '</option>');
        }
    }, 'json'); 
});

//Funcion para cargar los campos de la ventana modal
function modificar_estado(id, nombre, apellido, estado) {
    document.getElementById('txtId2').value = id;
    document.getElementById('txtNombre_Completo').value = nombre+' '+apellido;
    document.getElementById('txtEstado').value = estado;
}

//Funcion para cargar los campos de la ventana modal
function cargar_usuario(id, nombre, apellido) {
    document.getElementById('id_empleado').value = id;
    document.getElementById('nombre_completo').value = nombre+' '+apellido;
}

//Funcion para cargar el formulario y modificar los datos
function datos_usuario(nombre, apellido, dependencia, seccion, usuario, rol, estado) {
    document.getElementById('nombre').value = nombre +' '+ apellido;
    document.getElementById('dependencia').value = dependencia;
    document.getElementById('seccion').value = seccion;
    document.getElementById('usuario').value = usuario;
    document.getElementById('estado').value = estado;
    document.getElementById('rol').value = rol;
}
</script>