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
                <tbody>
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
                <tbody>
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