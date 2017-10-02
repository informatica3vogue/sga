<div class="span12">
    <!-- start submenu -->
    <ul class="breadcrumb">
        <!--<a href="?mod=agregarempleado" class="icon-plus" title="Ingresar nuevo empleado">&nbsp;Ingresar nuevo empleado</a> &nbsp;&nbsp;&nbsp;|&nbsp;&nbsp;&nbsp;-->
        <a href="?mod=vpermisos" class="icon-folder-close" title="Permisos registrados">&nbsp;Permisos registrados</a> &nbsp;&nbsp;&nbsp;|&nbsp;&nbsp;&nbsp;
        <a href="?mod=reportes_permiso" class="icon-file" title="Reportes permisos">&nbsp;Reportes permisos</a>
    </ul>
    <!-- end submenu-->
    <div class="box">
        <div class="box-header">
            <h2><i class="halflings-icon white folder-open"></i><span class="break"></span>Registros de empleados</h2>
            <div class="box-icon">
                <a href="#" data-rel="tooltip" title="Minimizar" class="btn-minimize"><i class="halflings-icon white chevron-up"></i></a>
            </div>
        </div>
        <div class="box-content">
            <div class="table-responsive">
                <table class="table table-striped table-bordered table-hover bootstrap-datatable datatable">
                <thead class="ticket blue">
                <tr>
                    <th>
                         N°
                    </th>
                    <th>
                         Codigo
                    </th>
                    <th>
                         Nombres
                    </th>
                    <th>
                         Apellidos
                    </th>
                    <th>
                         DUI
                    </th>
                    <th>
                         Cargo
                    </th>
                    <th>
                         Secci&oacute;n
                    </th>
                    <th>
                         Acciones
                    </th>
                </tr>
                </thead>
<?php
                $cont = 1;  
                $response = $dataTable->obtener_Empleados_Activos($_SESSION["id_dependencia"]); 
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
                        <?php echo $datos['codigo'] ?>
                    </td>
                    <td>
                        <?php echo $datos['nombre'] ?>
                    </td>
                    <td class="center">
                        <?php echo $datos['apellido'] ?>
                    </td>
                    <td class="center">
                        <?php echo $datos['DUI'] ?>
                    </td>
                    <td class="center">
                        <?php echo $datos['cargo'] ?>
                    </td>
                    <td class="center">
                        <?php echo $datos['seccion'] ?>
                    </td>
                    <td class="center">
                        <a class="btn btn-success" data-rel="tooltip" title='Informacion de usuario' data-toggle='modal' data-target='#datos_empleado' onclick="datos_empleado('<?php echo $datos['codigo'] ?>','<?php echo $datos['nombre'] ?>','<?php echo $datos['apellido'] ?>','<?php echo $datos['estado_civil'] ?>','<?php echo $datos['DUI'] ?>','<?php echo $datos['NIT'] ?>','<?php echo $datos['NUP'] ?>','<?php echo $datos['ISSS'] ?>','<?php echo $datos['tipo_sangre'] ?>','<?php echo $datos['titulo'] ?>','<?php echo $datos['cargo'] ?>','<?php echo $datos['fecha_contratacion'] ?>','<?php echo $datos['tipo_contratacion'] ?>','<?php echo $datos['direccion'] ?>','<?php echo $datos['movil'] ?>','<?php echo $datos['fijo'] ?>','<?php echo $datos['persona_encargada'] ?>','<?php echo $datos['encargado'] ?>','<?php echo $datos['seccion'] ?>');"> 
                            <i class="halflings-icon white info-sign"></i>
                        </a>
                        <a class="btn btn-info" data-rel="tooltip" title='Actualizar empleado' href="?mod=agregarempleado&id=<?php echo $datos['id_empleado'] ?>"> 
                            <i class="halflings-icon white edit"></i>
                        </a>
                        <a class="btn btn-warning" data-rel="tooltip" title='Asignar permiso' href="?mod=empleados&ida=<?php echo $datos['id_empleado'] ?>"> 
                            <i class="halflings-icon white file"></i>
                        </a>
                         <a class="btn btn-danger" href="#" data-rel="tooltip" title='Cambio de estado' data-toggle='modal' data-target='#modal_empleado' onclick="modificar_estado(<?php echo $datos['id_empleado'] ?>, '<?php echo $datos['nombre'] ?>','<?php echo $datos['apellido'] ?>','<?php echo $datos['estado'] ?>');">
                            <i class="halflings-icon white retweet"></i>
                        </a>
                    </td>
                </tr>
                <?php  
$cont ++;
} ?>
                </tbody>
                </table>
            </div>
        </div>
    </div>

    <div class="box">
        <div class="box-header">
            <h2><i class="halflings-icon white user"></i><span class="break"></span>Registros de empleados inactivos</h2>
            <div class="box-icon">
                <a href="#" data-rel="tooltip" title="Minimizar" class="btn-minimize"><i class="halflings-icon white chevron-up"></i></a>
            </div>
        </div>
        <div class="box-content" style="display: none;">
            <div class="table-responsive">
                <table class="table table-striped table-bordered table-hover bootstrap-datatable datatable">
                <thead class="ticket blue">
                <tr>
                    <th>
                         N°
                    </th>
                    <th>
                         Codigo
                    </th>
                    <th>
                         Nombres
                    </th>
                    <th>
                         Apellidos
                    </th>
                    <th>
                         DUI
                    </th>
                    <th>
                         Fecha final
                    </th>
                    <th>
                         Observaci&oacute;n
                    </th>
                    <th>
                         Accion
                    </th>
                </tr>
                </thead>
<?php
                $cont = 1;  
                $response = $dataTable->obtener_Empleados_Inactivos($_SESSION["id_dependencia"]); 
?>
                <tbody>
                <?php    
                    foreach($response['items'] as $datos){?>
                <tr>
                    <td>
                        <?php echo $cont ?>
                    </td>
                    <td>
                        <?php echo $datos['codigo'] ?>
                    </td>
                    <td>
                        <?php echo $datos['nombre'] ?>
                    </td>
                    <td class="center">
                        <?php echo $datos['apellido'] ?>
                    </td>
                    <td class="center">
                        <?php echo $datos['DUI'] ?>
                    </td>
                    <td class="center">
                        <?php echo $datos['fecha_final'] ?>
                    </td>
                    <td class="center">
                        <?php echo $datos['observacion'] ?>
                    </td>
                    <td class="center">
                        <a class="btn btn-danger" href="#" data-rel="tooltip" title='Cambio de estado' data-toggle='modal' data-target='#modal_empleado' onclick="modificar_estado(<?php echo $datos['id_empleado'] ?>, '<?php echo $datos['nombre'] ?>','<?php echo $datos['apellido'] ?>','<?php echo $datos['estado'] ?>');">
                            <i class="halflings-icon white user"></i>
                        </a>
                    </td>
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
<div class="modal hide fade" id="modal_empleado">
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">×</button>
        <h3>Cambio de estado</h3>
    </div>
    <div class="modal-body">
        <form role="form" method="POST" name="frmEstado" id="frmEstado">
            <input type="hidden" id="txtId" name="txtId">
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
            <div class="form-group">
                <label>Descripción: </label>
                <textarea type="text" rows="3" class="form-control" name="txtDescripcion" id="txtDescripcion" placeholder="Escriba una dirección"></textarea>
            </div>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-danger pull-left" data-dismiss="modal">Cancelar</button>
            <button type="button" id="modificar_estado" name="modificar_estado" class="btn btn-primary">Guardar</button>
        </div>
    </form>
</div>
<!-- Ventana Modal para el cambio de estado del usuario -->
<div class="modal hide fade" id="datos_empleado">
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">×</button>
        <h3>Información Personal</h3>
    </div>
    <div class="modal-body">
        <fieldset>
            <div>
                <div class="form-group span6">
                    <label>Nombres:</label>
                    <input type="text" class="form-control" name="txtNombre" id="txtNombre" disabled="disable" style="width: 95%;">
                </div>
                <div class="form-group span6">
                    <label>Apellidos:</label>
                    <input type="text" class="form-control" name="txtApellido" id="txtApellido" disabled="disable" style="width: 95%;">
                </div>
            </div>
            <div>
                <div class="form-group span6">
                    <label>DUI:</label>
                    <input type="text" class="form-control" name="txtDui" id="txtDui" disabled="disable" style="width: 95%;">
                </div>
                <div class="form-group span6">
                    <label>NIT:</label>
                    <input type="text" class="form-control" name="txtNit" id="txtNit" disabled="disable" style="width: 95%;">
                </div>
            </div>
            <div>
                <div class="form-group span6">
                    <label>NUP:</label>
                    <input type="text" class="form-control" name="txtNup" id="txtNup" disabled="disable" style="width: 95%;">
                </div>
                <div class="form-group span6">
                    <label>ISSS:</label>
                    <input type="text" class="form-control" name="txtIsss" id="txtIsss" disabled="disable" style="width: 95%;">
                </div>
            </div>
            <div>
                <div class="form-group span6">
                    <label>Estado civil:</label>
                    <input type="text" class="form-control" name="txtEstadoCivil" id="txtEstadoCivil" disabled="disable" style="width: 95%;">
                </div>
                <div class="form-group span6">
                    <label>Tipo de sangre:</label>
                    <input type="text" class="form-control" name="txtSangre" id="txtSangre" disabled="disable" style="width: 95%;">
                </div>
            </div>
        </fieldset>
        <fieldset>
            <legend></legend>
            <div>
                <div class="form-group span6">
                    <label>Codigo:</label>
                    <input type="text" class="form-control" name="txtCodigo" id="txtCodigo" disabled="disable" style="width: 95%;">
                </div>
                <div class="form-group span6">
                    <label>Secci&oacute;n:</label>
                    <input type="text" class="form-control" name="txtSeccion" id="txtSeccion" disabled="disable" style="width: 95%;">
                </div>
            </div>
            <div>
                <div class="form-group span6">
                    <label>T&iacute;tulo:</label>
                    <input type="text" class="form-control" name="txtTitulo" id="txtTitulo" disabled="disable" style="width: 95%;">
                </div>
                <div class="form-group span6">
                    <label>Cargo:</label>
                    <input type="text" class="form-control" name="txtCargo" id="txtCargo" disabled="disable" style="width: 95%;">
                </div>
            </div>
            <div>
                <div class="form-group span6">
                    <label>Tipo contrataci&oacute;n:</label>
                    <input type="text" class="form-control" name="txtTipo" id="txtTipo" disabled="disable" style="width: 95%;">
                </div>
                <div class="form-group span6">
                    <label>Fecha contrataci&oacute;n:</label>
                    <input type="text" class="form-control" name="txtFecha" id="txtFecha" disabled="disable" style="width: 95%;">
                </div>
            </div>
        </fieldset>
        <fieldset>
            <legend style="font-size: 12pt; color:blue;">Informaci&oacute;n de contacto</legend>
            <div>
                <div class="form-group span6">
                    <label>Tel&eacute;fono m&oacute;vil:</label>
                    <input type="text" class="form-control" name="txtMovil" id="txtMovil" disabled="disable" style="width: 95%;">
                </div>
                <div class="form-group span6">
                    <label>Tel&eacute;fono fijo:</label>
                    <input type="text" class="form-control" name="txtFijo" id="txtFijo" disabled="disable" style="width: 95%;">
                </div>
            </div>
            <div>
                <div class="form-group span12">
                    <label>Direcci&oacute;n:</label>
                    <textarea name="txtDireccion" id="txtDireccion" class="form-control" disabled="disable"></textarea>
                </div>
            </div>
            <div>
                <div class="form-group span7">
                    <label>Persona encargada:</label>
                    <input type="text" class="form-control" name="txtEncargado" id="txtEncargado" disabled="disable" style="width: 95%;">
                </div>
                <div class="form-group span5">
                    <label>Tel&eacute;fono encargado:</label>
                    <input type="text" class="form-control" name="txtTelefono" id="txtTelefono" disabled="disable" style="width: 95%;">
                </div>
            </div>
        </fieldset>
    </div>
    <div class="modal-footer">
        <button type="button" class="btn btn-danger pull-right" data-dismiss="modal">Cancelar</button>
    </div>
</div>
<script type="text/javascript">
//Funcion para cargar el formulario y modificar los datos
function datos_empleado(codigo, nombre, apellido, estado_civil, DUI, NIT, NUP, ISSS, tipo_sangre, titulo,  cargo, fecha_contratacion, tipo_contratacion, direccion, fijo, movil, persona_encargada, encargado, seccion) {
    document.getElementById('txtCodigo').value = codigo;
    document.getElementById('txtNombre').value = nombre;
    document.getElementById('txtApellido').value = apellido;
    document.getElementById('txtEstadoCivil').value = estado_civil;
    document.getElementById('txtDui').value = DUI;
    document.getElementById('txtNit').value = NIT;
    document.getElementById('txtNup').value = NUP;
    document.getElementById('txtIsss').value = ISSS;
    document.getElementById('txtSangre').value = tipo_sangre;
    document.getElementById('txtTitulo').value = titulo;
    document.getElementById('txtCargo').value = cargo;
    document.getElementById('txtFecha').value = fecha_contratacion;
    document.getElementById('txtTipo').value = tipo_contratacion;
    document.getElementById('txtDireccion').value = direccion;        
    document.getElementById('txtMovil').value = movil;
    document.getElementById('txtFijo').value = fijo;
    document.getElementById('txtEncargado').value = persona_encargada;
    document.getElementById('txtTelefono').value = encargado;
    document.getElementById('txtSeccion').value = seccion;
}

//Funcion para cargar los campos de la ventana modal
function modificar_estado(id, nombre, apellido, estado) {
    document.getElementById('txtId').value = id;
    document.getElementById('txtNombre_Completo').value = nombre+' '+apellido;
    document.getElementById('txtEstado').value = estado;
}

// Funcion que nos permitira cambiar el estado del usuario
$(document).ready(function () {
    $('#modificar_estado').click(function () {
        var formulario = $('#frmEstado').serializeArray();
        $.ajax({
            type: 'POST',
            dataType: 'json',
            url: 'procesos/modificar_estado_empleado.php',
            data: formulario,
        }).done(function (response) {
            if(response.success == true) {
                $('#modal_empleado').modal('hide');
                bootbox.alert(response.mensaje, function() { location.reload(); });
            }else{
                bootbox.alert(response.mensaje, function() {  });
            }
        });
    });
});
</script>