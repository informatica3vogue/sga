<div class="span12">        <!-- start submenu -->    <ul class="breadcrumb">        <!--<a href="?mod=agregarempleado" class="icon-plus" title="Ingresar nuevo empleado">&nbsp;Ingresar nuevo empleado</a> &nbsp;&nbsp;&nbsp;|&nbsp;&nbsp;&nbsp;-->        <a href="?mod=permisos" class="icon-folder-open" title="Registros de empleados">&nbsp;Registros de empleados</a>&nbsp;&nbsp;&nbsp;|&nbsp;&nbsp;&nbsp;        <a href="?mod=vpermisos" class="icon-folder-close" title="Permisos registrados">&nbsp;Permisos registrados</a> &nbsp;&nbsp;&nbsp;|&nbsp;&nbsp;&nbsp;        <a href="?mod=reportes_permiso" class="icon-file" title="Reportes permisos">&nbsp;Reportes permisos</a>    </ul>    <!-- end submenu-->    <div class="box">        <div class="box-header" data-original-title="">            <h2><i class="halflings-icon white edit"></i><span class="break"></span>Ingreso de Permiso</h2>            <div class="box-icon">                <a href="#" class="btn-minimize"><i class="halflings-icon white chevron-up"></i></a>            </div>        </div>        <div class="box-content">            <form role="form" method="POST" name="frmPermisos" id="frmPermisos" autocomplete="off" enctype="multipart/form-data" onsubmit="return false">                <fieldset>                <div class="form-group span6">                    <label>Nombre completo:</label>                    <input type="text" class="form-control" name="txtNombre" id="txtNombre" readonly>                </div>                <div class="form-group span6">                    <label>DUI: </label>                    <input type="text" class="form-control" name="txtDui" id="txtDui" style="width: 97%;" readonly>                </div>                 </fieldset>                <fieldset>                    <div class="form-group span6">                        <label>N&uacute;mero de permiso:<span style="float:right; margin-left:50px;" id="comprobar"></span></label>                        <input type="number" class="form-control" min="0" name="txtNumeroPermiso" id="txtNumeroPermiso" placeholder="Escriba el número de permiso" data-validation="required" data-validation-error-msg="rellene este campo" data-validation="number">                    </div>                    <div class="form-group span6">                        <label>Motivo: </label>                        <select class="form-control" name="txtmotivo" id="txtmotivo" onchange="tipo_motivo( $('#txtmotivo').val())" style="width: 99.5%;"></select>                    </div>                </fieldset>                <fieldset>                    <div class="form-group span12" id="descripcion_otros" style="display: none;">                        <label>Especificar solo en seleccionar opcion de motivo (otros):</label>                        <input type="text" name="txtotros" id="txtotros" class="form-control" disabled="true">                    </div>                </fieldset>                <fieldset>                    <div class="form-group span6">                        <label>Fecha desde:</label>                        <input type="text" class="form-control" name="dtFechaDesde" id="dtFechaDesde" placeholder="Seleccione una fecha" style="background: #fff;" readonly>                    </div>                    <div class="form-group span6">                        <label>Fecha hasta:</label>                        <input type="text" class="form-control" name="dtFechaHasta" id="dtFechaHasta" placeholder="Seleccione una fecha" style="width: 97%; background: #fff;" readonly>                    </div>                </fieldset>                <fieldset>                <div class="form-group span6">                    <label>Horario desde:</label>                    <input type="text" class="form-control" name="hrDesde" id="hrDesde">                </div>                <div class="form-group span6">                    <label>Horario hasta:</label>                    <input type="text" class="form-control" name="hrAsta" id="hrAsta" style="width: 97%;">                </div>                </fieldset>                <br>                <fieldset>                <div class="form-group span6">                    <label>Fecha de entrega de permiso:</label>                    <input type="text" class="form-control datepicker" name="dtFechaDif" id="dtFechaDif" placeholder="Seleccione una fecha" style="background: #fff;" readonly>                </div>               <div class="form-group span6">                    <label>Permiso anulado:</label>                    <select name="txtAnulacion" id="txtAnulacion" class="form-control" title="Selecciones estado del permiso" style="width: 99.5%;">                        <option value="no">No</option>                        <option value="si">Si</option>                    </select>                </div>                </fieldset>                <fieldset>                <div class="form-group span4">                    <label>Fecha de entrega a RR.HH:</label>                    <input type="text" class="form-control datepicker" name="dtFechaDrh" id="dtFechaDrh" style="background: #fff;" placeholder="Seleccione una fecha" readonly>                </div>                <div class="form-group span4">                    <label>Codigo RR.HH:</label>                    <input type="number" class="form-control" name="codigoDrh" id="codigoDrh" placeholder="Ingrese codígo">                </div>                <div class="form-group span4">                    <label>Documento:</label><br>                    <input type="file" class="form-control" name="txtArchivo[]" id="txtArchivo">                </div>                </fieldset>                <fieldset>                <div class="form-group span12">                    <label>Observación:</label>                    <textarea class="form-control" style="width: 97.5%;" name="txtObservacion" id="txtObservacion" placeholder="Escriba la observación"></textarea>                </div>                </fieldset>                <input type="hidden" id="txtNombreEmpleado" name="txtNombreEmpleado" value="" readonly>                <input type="hidden" id="txtId" name="txtId" value="" disabled="true">                <div class="form-actions">                    <button type="button" id="cancelar" name="cancelar" style="margin-right: 5px;" class="btn btn-primary btn-danger pull-left" onClick='location.href="?mod=permisos"'>Cancelar</button>                    <button type="reset" id="limpiar" name="limpiar" class="btn btn-primary pull-left">Limpiar</button>                    <button type="submit" id="guardar" name="guardar" class="btn btn-primary pull-right">Guardar</button>                </div>            </form>            <!--/span-->        </div>    </div></div>