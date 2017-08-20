<div class="span12">
    <ul class="breadcrumb">
        <a href="?mod=permisos" class="icon-folder-open" title="Registros de empleados">&nbsp;Registros de empleados</a>&nbsp;&nbsp;&nbsp;|&nbsp;&nbsp;&nbsp;
        <a href="?mod=vpermisos" class="icon-folder-close" title="Permisos registrados">&nbsp;Permisos registrados</a>&nbsp;&nbsp;&nbsp;|&nbsp;&nbsp;&nbsp;
        <a href="?mod=reportes_permiso" class="icon-file" title="Reportes permisos">&nbsp;Reportes permisos</a>
    </ul>
    <div class="box">
        <div class="box-header" data-original-title>
            <h2><i class="halflings-icon user white"></i><span class="break"></span>Ingresar nuevo Empleado</h2>
            <div class="box-icon">
                <a href="#" class="btn-minimize"><i class="halflings-icon white chevron-up"></i></a>
            </div>
        </div>
        <div class="box-content">
            <form role="form" method="POST" name="frmListaEmpleado" id="frmListaEmpleado" autocomplete="off" enctype="multipart/form-data" onsubmit="return false">
                <div class="panel-body">
                        <input type="hidden" id="txtId" name="txtId" value="" disabled="true">
                        <legend style="font-size: 12pt; color:blue;">Información Personal</legend>
                        <fieldset>
                            <div class="span4">
                                <div class="form-group ">
                                    <label>Nombres: </label>
                                    <input type="text" class="form-control" name="txtNombre" id="txtNombre" placeholder="Escriba nombres" data-validation="required" data-validation-error-msg="rellene este campo">
                                </div>
                            </div>
                            <div class="span4">
                                <div class="form-group">
                                    <label>Apellidos: </label>
                                    <input type="text" class="form-control" name="txtApellido" id="txtApellido" placeholder="Escriba apellidos" data-validation="required" data-validation-error-msg="rellene este campo">
                                </div>
                            </div>
                            <div class="span4">
                                <div class="form-group">
                                    <label>Código de Empleado:<span style="float:right; margin-left:20px;" id="comprobar"></span></label>
                                    <input type="text" class="form-control" name="txtCodigo" id="txtCodigo" placeholder="Escriba un código" data-validation="required" data-validation-error-msg="rellene este campo">
                                </div>
                            </div>
                        </fieldset>
                        <fieldset>
                            <div class="span4">
                                <div class="form-group">
                                    <label>ISSS: </label>
                                    <input type="text" class="form-control" name="txtIsss" id="txtIsss" placeholder="000000000" maxlength="9">
                                </div>
                            </div>
                            <div class="span4">
                                <div class="form-group ">
                                    <label>Número de tarjeta de marcación: </label>
                                    <input type="number" class="form-control" name="txtNumTarjeta" id="txtNumTarjeta" placeholder="000000" maxlength="10">
                                </div>
                            </div>
                            <div class="span4">
                                <div class="form-group">
                                    <label>Sección: </label>
                                    <select class="form-control" name="txtSeccion" id="txtSeccion" data-validation="required" data-validation-error-msg="rellene este campo">
                                        <option value="">Seleccione una sección</option>
                                    </select>
                                </div>
                            </div>
                        </fieldset>
                        <fieldset>
                            <div class="span4">
                                <div class="form-group ">
                                    <label>DUI: </label>
                                    <input type="text" class="form-control" name="txtDui" id="txtDui" placeholder="00000000-0" maxlength="10">
                                </div>
                            </div>
                            <div class="span4">
                                <div class="form-group">
                                    <label>NIT: </label>
                                    <input type="text" class="form-control" name="txtNit" id="txtNit" placeholder="0000-000000-000-0" maxlength="17">
                                </div>
                            </div>
                            <div class="span4">
                                <div class="form-group">
                                    <label>NUP : </label>
                                    <input type="text" class="form-control" name="txtNup" id="txtNup" placeholder="000000000000" maxlength="12" style="width: 96.4%;">
                                </div>
                            </div>
                        </fieldset>
                        <fieldset>
                            <div class="span4">
                                <div class="form-group">
                                    <label>Estado Civil: </label>
                                    <select name="txtTEcivil" id="txtTEcivil" class="form-control">
                                        <option value="">Selecione un estado civil </option>
                                        <option value="Soltero/a">Soltero/a</option>
                                        <option value="Casado/a">Casado/a</option>
                                        <option value="Viudo/a">Viudo/a</option>
                                        <option value="Divorciado/a">Divorciado/a</option>
                                    </select>
                                </div>
                            </div>
                            <div class="span4">
                                <div class="form-group">
                                    <label>Tipo de Sangre</label>
                                    <select name="txtTipoSangre" id="txtTipoSangre" class="form-control ">
                                        <option value="">Selecione un tipo de sangre </option>
                                        <option value="O-">O-</option>
                                        <option value="O+">O+</option>
                                        <option value="A-">A-</option>
                                        <option value="A+">A+</option>
                                        <option value="B-">B-</option>
                                        <option value="B+">B+</option>
                                        <option value="AB-">AB-</option>
                                        <option value="AB+">AB+</option>
                                    </select>
                                </div>
                            </div>
                            <div class="span4">
                                <div class="form-group">
                                    <label>Título Académico: </label>
                                    <input type="text" class="form-control " name="txtTitulo" id="txtTitulo" placeholder="Escriba un título academico" style="width: 96.4%;">
                                </div>
                            </div>
                        </fieldset>
                        <fieldset>
                            <div class="span4">
                                <div class="form-group">
                                    <label>Cargo: </label>
                                    <input type="text" class="form-control" name="txtCargo" id="txtCargo" placeholder="Escriba un cargo">
                                </div>
                            </div>
                            <div class="span4">
                                <div class="form-group">
                                    <label>Fecha de contratación: </label>
                                    <input type="text" class="form-control datepicker" name="dtFecha" id="dtFecha" placeholder="Seleccione una fecha" style="background: #fff;" readonly>
                                </div>
                            </div>
                            <div class="span4">
                                <div class="form-group">
                                    <label>Tipo de contratación: </label>
                                    <select name="txtTipoContrato" id="txtTipoContrato" class="form-control">
                                        <option value="">Selecione un tipo de contrato </option>
                                        <option value="Ley de Salario">Ley de Salario</option>
                                        <option value="Contrato">Contrato</option>
                                    </select>
                                </div>
                            </div>
                        </fieldset>
                        <legend style="font-size: 12pt; color:blue;">Información de Contacto</legend>
                        <fieldset>
                            <div class="span6">
                                <div class="form-group ">
                                    <label>Teléfono Fijo: </label>
                                    <input type="text" class="form-control" name="txtTelefono" id="txtTelefono" maxlength="9" placeholder="0000 - 0000">
                                </div>
                            </div>
                            <div class="span6">
                                <div class="form-group ">
                                    <label>Teléfono Móvil: </label>
                                    <input type="text" class="form-control" name="txtTelefono2" id="txtTelefono2" maxlength="9" placeholder="0000 - 0000" style="width: 97.5%;">
                                </div>
                            </div>
                        </fieldset>
                        <fieldset>
                            <div class="span12">
                                <div class="form-group">
                                    <label>Dirección: </label>
                                    <textarea class="form-control" name="txtDireccion" id="txtDireccion" placeholder="Escriba una dirección" style="width: 97.5%;"></textarea>
                                </div>
                            </div>
                        </fieldset>
                        <legend style="font-size: 12pt; color:blue;">Información de Encargado</legend>
                        <fieldset>
                            <div class="span6">
                                <div class="form-group ">
                                    <label>En caso de emergencia llamar a: </label>
                                    <input type="text" class="form-control" name="txtPersonaEncargada" id="txtPersonaEncargada" placeholder="Escriba un nombre">
                                </div>
                            </div>
                            <div class="span6">
                                <div class="form-group ">
                                    <label>Teléfono:</label>
                                    <input type="text" class="form-control" name="txtTelefonoPersonaEncargada" id="txtTelefonoPersonaEncargada" placeholder="0000 - 0000" style="width: 97.5%;">
                                </div>
                            </div>
                        </fieldset>
                </div>
            </div>
            <!--/span-->
            <div class="modal-footer">
                <a href="?mod=permisos" style="margin-left:20px;" class="btn btn-primary btn-danger pull-left">Cancelar</a>
                <button type="submit" id="guardar" name="guardar" class="btn btn-primary">Guardar</button>
            </div>
        </div>
    </form>
</div>
<!--/row-->