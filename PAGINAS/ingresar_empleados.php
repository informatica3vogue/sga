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
<script type="text/javascript">
// Funcion que permite tomar variables que vienen por metodo get
function getGET(){
    var loc = document.location.href;
    if(loc.indexOf('?')>0){
        var getString = loc.split('?')[1];
        var GET = getString.split('&');
        var get = {};
        for(var i = 0, l = GET.length; i < l; i++){
            var tmp = GET[i].split('=');
            get[tmp[0]] = unescape(decodeURI(tmp[1]));
        }
        return get;
    }
}

//Declaracion de variable global
var get = getGET();

//Funcion que nos permitira llenar el formulario con los datos del empleado para poder modificarlos
window.onload = function(){
    $.ajax({
        type: 'POST',
        dataType: 'json',
        url: 'procesos/store_info_empleado.php',
        data: { 'id_empleado' : get.id },
    }).done(function (response) {
        if(response.total > 0 && get.id > 0) {
            data = response.items;
            document.getElementById('txtId').disabled = false;
            document.getElementById('txtId').value = data[0].id_empleado;
            document.getElementById('txtCodigo').value = data[0].codigo;
            document.getElementById('txtNumTarjeta').value = data[0].num_tarjeta_marcacion;
            document.getElementById('txtNombre').value = data[0].nombre;
            document.getElementById('txtApellido').value = data[0].apellido;
            document.getElementById('txtTEcivil').value = data[0].estado_civil;
            document.getElementById('txtDui').value = data[0].DUI;
            document.getElementById('txtNit').value = data[0].NIT;
            document.getElementById('txtNup').value = data[0].NUP;
            document.getElementById('txtIsss').value = data[0].ISSS;
            document.getElementById('txtTipoSangre').value = data[0].tipo_sangre;
            document.getElementById('txtTitulo').value = data[0].titulo;
            document.getElementById('txtCargo').value = data[0].cargo;
            document.getElementById('dtFecha').value = data[0].fecha_contratacion;
            document.getElementById('txtTipoContrato').value = data[0].tipo_contratacion;
            document.getElementById('txtDireccion').value = data[0].direccion;        
            document.getElementById('txtTelefono').value = data[0].fijo;
            document.getElementById('txtTelefono2').value = data[0].movil;
            document.getElementById('txtPersonaEncargada').value = data[0].persona_encargada;
            document.getElementById('txtTelefonoPersonaEncargada').value = data[0].encargado;
            store_seccion(data[0].id_seccion);
        }
    });
}

$(document).ready(function () {
    $('#guardar').click(function () {
        $.validate({
            onSuccess : function(form) {
                var formulario = $('#frmListaEmpleado').serializeArray();
                $.ajax({
                    data: formulario,
                    type: 'POST',
                    dataType: "Json",
                    url: 'procesos/guardar_empleados.php',
                    beforeSend: function () {
                        $.blockUI({ message: '<h1><img src="img/loading.gif"/> Espere un momento...</h1>' });
                    },
                    success: function(response){
                        if(response.success == true) {
                            if (get.id > 0) {
                                $.alert(response.mensaje , { title: 'Operacion exitosa', icon: 'circle-check', buttons: { 'Aceptar': function () { $(this).dialog("close"); location.href = "?mod=permisos"; }}});
                            }else{
                                $.alert(response.mensaje , { title: 'Operacion exitosa', icon: 'circle-check', buttons: { 'Aceptar': function () { $(this).dialog("close"); location.href = "?mod=agregarempleado"; }}});
                            }
                        }else{
                            $.alert(response.mensaje , { title: 'Verifique su informacion!', icon: 'circle-close', buttons: { 'Aceptar': function () { $(this).dialog("close"); }}});
                        }
                    },
                    error: function() {
                        $.alert('Ocurrio un error al realizar la transaccion',{ title: 'Error!', icon: 'circle-close', buttons: { 'Cerrar': function () { $(this).dialog("close"); }}});
                    },
                    complete: function() {
                        $.unblockUI();
                    }
                });
            }
        });
    });
});

// Funcion que nos permitira cargar el combo de la secciones dependiendo de la dependencia
function store_seccion(id_seccion){
    var miselect = $('#txtSeccion');
    miselect.empty();
    miselect.find('option').remove().end().append('<option value="">Seleccione una sección</option>').val('');
    $.post("procesos/store_seccion.php", 
    function (data) {
        var datos = data.items;
        for (var i = 0; i < data.total; i++) {
            if (id_seccion == datos[i].id_seccion) {
                miselect.append('<option selected value="' + datos[i].id_seccion + '">' + datos[i].seccion + '</option>');
            }else{
                miselect.append('<option value="' + datos[i].id_seccion + '">' + datos[i].seccion + '</option>');
            }
        }
    }, 'json');
}
$(document).ready(function () {
    store_seccion(0);
});


//Limpiara los combobox al dar clic sobre el boton limpiar
$(document).ready(function () {
    $('#limpiar').click(function () {
        store_seccion(0);
        document.getElementById('txtId').disabled = true;
    });
});

//Mascara para el formato de campos Telefono, DUI, NIT
$(function () {
    $.mask.definitions['~'] = "[+-]";
    $("#txtTelefono").mask("9999-9999");
    $("#txtTelefono2").mask("9999-9999");
    $("#txtNup").mask("999999999999");
    $("#txtIsss").mask("999999999");
    $("#txtTelefonoPersonaEncargada").mask("9999-9999");
    $("#txtDui").mask("99999999-9");
    $("#txtNit").mask("9999-999999-999-9");
});

//Funcion para  validar el codigo
$(document).ready(function() {    
    $('#txtCodigo').blur(function(){   
         $('#comprobar').fadeOut(80);
        var Codigo = $(this).val();        
        var dataString = 'txtCodigo='+Codigo;
        $.ajax({
            type: "POST",
            url: "procesos/validar_codigo.php",
            data: dataString,
            success: function(data) {
                $('#comprobar').fadeIn(1000).html(data);
            }
        });
    });              
});
</script>