<!-- start submenu -->
<ul class="breadcrumb">
    <a href="?mod=iactividad" class="icon-plus" title="Ingresar actividad">&nbsp;Ingresar actividad</a> &nbsp;&nbsp;&nbsp;|&nbsp;&nbsp;&nbsp; <a href="?mod=actividades" class="icon-list-alt" title="Mis actividades">&nbsp;Mis actividades</a> &nbsp;&nbsp;&nbsp;|&nbsp;&nbsp;&nbsp; <a href="?mod=repactividad" class="icon-file" title="Reportes actividad">&nbsp;Reportes actividades</a>
</ul>
<!-- end submenu-->
<div class="row-fluid">
    <div class="span6">
        <!-- Contenedor de acitividades pendientes -->
        <div class="row-fluid">
            <div class="box">
                <div class="box-header">
                    <h2><i class="icon-bar-chart white list"></i><span class="break"></span>Actividades generales pendientes</h2>
                    <div class="box-icon">
                        <a href="#" class="btn-setting" title="Actualizar" onclick="store_actividad(1, 'Pendiente')"><i class="halflings-icon white refresh"></i></a>
                        <a href="#" class="btn-minimize" title="Minimizar"><i class="halflings-icon white chevron-up"></i></a>
                    </div>
                </div>
                <div class="box-content">
                    <div class="input-append">
                        <form onsubmit="busqueda_actividad_pend($('#txtBuscar').val()); return false;" autocomplete="off">
                            <input type="text" placeholder="Buscar actividad por..." name="txtBuscar" id="txtBuscar">
                            <button title="Buscar" type="submit" class="btn btn-success" id="buscar"><span class="halflings-icon search white"></span></button>
                        </form>
                    </div>
                    <div class="priority high">
                        <span>Pendientes</span>
                    </div>
                    <div id="grid">
                        <!-- Llena actividades pendientes -->
                    </div>
                    <div id="paginador">
                    </div>
                </div>
            </div>
            <!--/span-->
        </div>
        <!--/row-->
        <!-- Contenedor de acitividades finalizadas -->
        <div class="row-fluid">
            <div class="box">
                <div class="box-header">
                    <h2><i class="icon-bar-chart white list"></i><span class="break"></span>Actividades generales finalizadas</h2>
                    <div class="box-icon">
                        <a href="#" class="btn-setting" title="Actualizar" onclick="store_actividad2(1, 'Finalizado')"><i class="halflings-icon white refresh"></i></a>
                        <a href="#" class="btn-minimize" title="Minimizar"><i class="halflings-icon white chevron-up"></i></a>
                    </div>
                </div>
                <div class="box-content">
                    <div class="input-append">
                        <form onsubmit="busqueda_actividad_fin($('#txtBuscar2').val()); return false;" autocomplete="off">
                            <input type="text" placeholder="Buscar actividad por..." name="txtBuscar2" id="txtBuscar2">
                            <button title="Buscar" type="submit" class="btn btn-success" id="buscar2"><span class="halflings-icon search white"></span></button>
                        </form>
                    </div>
                    <div class="priority low">
                        <span>Finalizadas</span>
                    </div>
                    <div id="grid2">
                        <!-- Llena actividades finalizadas -->
                    </div>
                    <div id="paginador2">
                    </div>
                </div>
            <!--/span-->
            </div>
        </div>
        <!--/row-->
    </div>
    <!--Linea de tiempo-->
    <div class="span6">
        <div class="row-fluid">
            <div class="box">
                <div class="box-header">
                    <h2><i class="icon-bar-chart white list"></i><span class="break"></span>Seguimientos realizados&nbsp;&nbsp;<label id="refAct"></label></h2>
                    <div class="box-icon">
                        <a href="#" class="btn-minimize" title="Minimizar"><i class="halflings-icon white chevron-up"></i></a>
                    </div>
                </div>
                <div class="box-content" style="display: block; height: 1135px; overflow-x: auto;">
                    <div style="width: 90%; margin: auto;">
                        <div class="timeline" id="grid3">
                            <!-- Llena seguimiento de actividades -->
                        </div>
                    </div>
                </div>
            </div>
            <!--/span-->
        </div>
        <!--/row-->
    </div>
</div>
<!-- Modal de cambio de estado -->
<div class="modal hide fade" id="modal_cambio_estado">
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">×</button>
        <h3>Cambio de estado de actividad</h3>
    </div>
    <div class="modal-body" style="overflow-x: hidden; overflow-y: auto;">
        <!--Formulario de modal-->
        <form role="form" method="POST" name="frmCEstado" id="frmCEstado" onsubmit="return false">
            <input type="hidden" id="txtId_cestado" name="txtId_cestado">
            <div class="form-group">
                <label>Referencia actividad:</label>
                <input class="form-control" type="text" id="txtrefActividad" name="txtrefActividad" readonly="true">
            </div>
            <div class="form-group">
                <label>Requerimiento de actividad finalizada:</label>
                <textarea class="form-control" name="txtRequeFin" id="txtRequeFin" rows="3" disabled="disable"></textarea>
            </div>
            <div class="form-group">
                <label>Cambiar estado:</label>
                <select class="form-control" name="txtEstadoFin" id="txtEstadoFin" onChange="cargar_asignacion($('#txtEstadoFin').val())">
                    <option value="Finalizado">Finalizada</option>
                    <option value="Pendiente">Pendiente</option>
                </select>
            </div>
            <div id="divAsignacion">
                <div class="form-group">
                    <label>Sección: </label>
                    <select class="form-control" name="txtSeccion" id="txtSeccion" onchange="store_usuarios_seccion($('#txtSeccion').val())" data-validation="required" data-validation-error-msg="rellene este campo" disabled="true"></select>
                </div>
                <div class="form-group">
                    <label>Caso asignado a: </label>
                    <select class="form-control" name="txtAsignado[]" id="txtAsignado" multiple="true" data-placeholder="Seleccione usuarios a asignar actividad" data-validation="required" data-validation-error-msg="rellene este campo" disabled="true" style="width: 100%;"></select>
                </div>
            </div>    
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-danger pull-left btn-movil" data-dismiss="modal">Cancelar</button>
            <button type="submit" id="guardarEstado" name="guardarEstado" class="btn btn-primary btn-movil pull-right">Guardar</button>
        </div>
    </form>
</div>
<!-- Modal seguimiento de las actividades -->
<form role="form" method="POST" name="frmSeguimiento" id="frmSeguimiento" onsubmit="return false">
    <div class="modal hide fade" id="modal_seguimiento">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal">×</button>
            <h3>Seguimiento de actividad</h3>
        </div>
        <div class="modal-body">
            <!--Formulario de modal-->
            <input type="hidden" id="txtId2" name="txtId2">
            <div class="form-group">
                <label>Solicitante:</label>
                <input class="form-control" type="text" id="txtSolic" name="txtSolic" disabled="disable">
            </div>
            <div class="form-group">
                <label>Dependencia:</label>
                <input type="text" class="form-control" name="txtDepen" id="txtDepen" disabled="disable">
            </div>
            <div class="form-group">
                <label>Requerimiento:</label>
                <textarea class="form-control" name="txtReque" id="txtReque" rows="3" disabled="disable"></textarea>
            </div>
            <div class="form-group">
                <label>Acción realizada:</label>
                <textarea class="form-control" name="txtAccion" id="txtAccion" cols="10" rows="3" data-validation="required" data-validation-error-msg="rellene este campo"></textarea>
            </div>
            <div class="form-group">
                <label>Estado:</label>
                <select class="form-control" name="txtEstado" id="txtEstado">
                    <option value="Pendiente">Pendiente</option>
                    <option value="Finalizado">Finalizado</option>
                </select>
            </div>
            <div class="form-group">
                <label>Adjunto:</label>
                <input type="file" name="txtAdd2[]" id="txtAdd2" multiple="true">
            </div>
            <div class="form-group">
                <label>&nbsp;</label>
                <input type="hidden" class="form-control" name="txtReferencia" id="txtReferencia" value="">
            </div>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-danger pull-left btn-movil" data-dismiss="modal">Cancelar</button>
            <button type="submit" id="guardar2" name="guardar2" class="btn btn-primary btn-movil pull-right">Guardar</button>
        </div>
    </div>
</form>
<!-- Modal detalle de las actividades -->
<div class="modal hide fade" id="modal_detalle_actividad">
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">×</button>
        <h3>Detalle actividad</h3>
    </div>
    <div class="modal-body">
        <!--Formulario de modal-->
        <input type="hidden" id="txtId3" name="txtId3">
        <div class="form-group">
            <label>Dependencia de origen</label>
            <input type="text" class="form-control" name="txtDep" id="txtDep" disabled="disable">
        </div>
        <div class="form-group">
            <label>Solicitante</label>
            <input class="form-control" type="text" id="txtSol" name="txtSol" disabled="disable">
        </div>
        <div class="form-group">
            <label>Fecha de solicitud</label>
            <input class="form-control" type="text" id="txtFSol" name="txtFSol" disabled="disable">
        </div>
        <div class="form-group">
            <label>Referencia de origen</label>
            <input class="form-control" type="text" id="txtOrigen" name="txtOrigen" disabled="disable">
        </div>
        <div class="form-group">
            <label>Requerimiento</label>
            <textarea class="form-control" name="txtReq" id="txtReq" cols="50" rows="3" disabled="disable"></textarea>
        </div>
        <div class="form-group">
            <label>Referencia de actividad</label>
            <input class="form-control" type="text" id="txtRef" name="txtRef" disabled="disable">
        </div>
        <div class="form-group">
            <label>Fecha procesamiento</label>
            <input class="form-control" type="text" id="txtFProc" name="txtFProc" disabled="disable">
        </div>
        <div class="form-group">
            <label>Marginado</label>
            <input class="form-control" type="text" id="txtMar" name="txtMar" disabled="disable">
        </div>
        <div class="form-group">
            <label>Estado de actividad</label>
            <input class="form-control" type="text" id="txtEst" name="txtEst" disabled="disable">
        </div>
        <!--<div class="form-group">
            <label>Con conocimiento</label>
            <textarea class="form-control" name="txtCC" id="txtCC" class="form-control" rows="2" disabled="disable"></textarea>
        </div>-->
        <div class="form-group">
            <label>Usuarios asignados</label>
            <textarea class="form-control" name="txtAsg" id="txtAsg" rows="2" disabled="disable"></textarea>
        </div>
        <div class="form-group">
            <label>Adjuntos</label>
            <div id="cargarDoc">
            </div>
        </div>
    </div>
    <div class="modal-footer">
        <a href="#" class="btn btn-danger btn-movil" data-dismiss="modal">Cerrar</a>
    </div>
</div>
<!-- Modal detalle de seguimientos -->
<div class="modal hide fade" id="modal_detalle_seguimiento">
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">×</button>
        <h3>Detalle seguimiento</h3>
    </div>
    <div class="modal-body">
        <!--Formulario de modal-->
        <input type="hidden" id="txtId4" name="txtId4">
        <div class="form-group">
            <label>Seguimiento hecho por</label>
            <input class="form-control" type="text" id="txtSoliSeguimiento" name="txtSoliSeguimiento" disabled="disable">
        </div>
        <div class="form-group">
            <label>Dependencia de origen</label>
            <input type="text" class="form-control" name="txtDepSeguimiento" id="txtDepSeguimiento" disabled="disable">
        </div>
        <div class="form-group">
            <label>Requerimiento</label>
            <textarea class="form-control" name="txtReqSeguimiento" id="txtReqSeguimiento" cols="10" rows="2" disabled="disable"></textarea>
        </div>
        <div class="form-group">
            <label>Acción realizada</label>
            <textarea class="form-control" name="txtAccSeguimiento" id="txtAccSeguimiento" cols="10" rows="3" disabled="disable"></textarea>
        </div>
        <div class="form-group">
            <label>Estado</label>
            <input class="form-control" type="text" id="txtEstSeguimiento" name="txtEstSeguimiento" disabled="disable">
        </div>
        <input type="hidden" id="txtId5" name="txtId5">
        <div class="form-group">
            <label>Adjuntos</label>
            <div id="cargarDocSeg">
            </div>
        </div>
    </div>
    <div class="modal-footer">
        <a href="#" class="btn btn-danger btn-movil" data-dismiss="modal">Cerrar</a>
    </div>
</div>
<script type="text/javascript">
//Funcion que permitira mandar los datos del seguimiento a nuestra bd
$(document).ready(function () {
    $("#guardar2").click(function () {
        $.validate({
            onSuccess : function(form) {
                if ($('#txtAccion').val().length > 0) {
                    var formulario = document.getElementById("frmSeguimiento");
                    var formData = new FormData(formulario);
                    var id_actividad = $('#txtId2').val();
                    $.ajax({
                        type: "POST",
                        dataType: 'json',
                        url: "procesos/actividades/agregar_seguimiento.php",
                        data: formData,
                        cache: false,
                        contentType: false,
                        processData: false
                    }).done(function (response) {
                        if(response.success == false) {
                            $('#modal_seguimiento').modal('hide');
                            $.alert(response.mensaje, { title: 'Verifique su informacion', icon: 'circle-close', buttons: { 'Cerrar': function () { $(this).dialog("close"); $('#modal_seguimiento').modal('show'); }}});
                        }else{
                            $('#modal_seguimiento').modal('hide');
                            document.getElementById('txtId2').disable = false;
                            document.getElementById("frmSeguimiento").reset();
                            store_actividad(1, 'Pendiente');
                            store_actividad2(1, 'Finalizado');
                            $.alert(response.mensaje, { title: 'Operacion exitosa', icon: 'circle-check', buttons: { 'Aceptar': function () { $(this).dialog("close"); store_seguimiento(0, id_actividad); }}});
                        }
                    });
                }
            }
        });
    });
});
// Funcion que nos permitira mandar los datos a ingresar
$(document).ready(function () {
    $("#guardarEstado").click(function () {
        $.validate({
            onSuccess : function(form) {
                var formulario = $('#frmCEstado').serializeArray();
                $.ajax({
                    type: "POST",
                    dataType: 'json',
                    url: "procesos/actividades/cambiar_estado_actividad.php",
                    data: formulario
                }).done(function (response) {
                    if (response.success == false) {
                        $('#modal_cambio_estado').modal('hide');
                        $.alert(response.mensaje, { title: response.titulo, icon: 'circle-close', buttons: { 'Cerrar': function () { $(this).dialog("close"); $('#modal_cambio_estado').modal('show'); }}});
                    } else {
                        $('#modal_cambio_estado').modal('hide');
                        $.alert(response.mensaje, { title: response.titulo, icon: 'circle-check', buttons: { 'Aceptar': function () { $(this).dialog("close"); location.href = "?mod=actividad"; }}});
                    }
                });
            }
        });
    });
});
//Limpiara los combobox al dar clic sobre el boton limpiar
$(document).ready(function () {
    $('#limpiar').click(function () {
        $('#validar_depen').hide();
        $('#validar_asig').hide();
        $('#validar_conocim').hide();
    });
});
// Funcion que nos cargara la tabla de actividades asignadas
function store_actividad(pagina, estado){
    var parametros = {
        "pagina": pagina,
        "estado": estado
    };           
    $.ajax({
        type: 'POST',
        data: parametros,
        url: 'procesos/actividades/store_info_actividad_admin_pendientes.php',
        beforeSend: function () {
           document.getElementById('grid').innerHTML=('<br><br><center><br><p>Cargando datos, espere por favor...</p></center><br><br>');
        },
        success: function(response){
            var datos = JSON.parse(response);
            document.getElementById('grid').innerHTML=(datos.grid);
            document.getElementById('paginador').innerHTML=(datos.paginador);
        }
    });
}
$(document).ready(function(){    
    store_actividad(1, 'Pendiente'); //Cargar primera pagina por defecto
    $('.pagination_act_pen li#activo').live('click',function(){
        var pagina = $(this).attr('p');
        store_actividad(pagina);
    });
});
// Funcion que nos cargara la tabla de actividades finalizadas
function store_actividad2(pagina, estado){   
    var parametros = {
        "pagina": pagina,
        "estado": estado
    };           
    $.ajax({
        type: 'POST',
        data: parametros,
        url: 'procesos/actividades/store_info_actividad_admin_finalizadas.php',
        beforeSend: function () {
           document.getElementById('grid2').innerHTML=('<br><br><center><br><p>Cargando datos, espere por favor...</p></center><br><br>');
        },
        success: function(response2){
            var datos = JSON.parse(response2);
            document.getElementById('grid2').innerHTML=(datos.grid2);
            document.getElementById('paginador2').innerHTML=(datos.paginador2);
        }
    });
}
$(document).ready(function(){    
    store_actividad2(1, 'Finalizado'); //Cargar primera pagina por defecto
    $('.pagination_act_fin li#activo').live('click',function(){
        var pagina = $(this).attr('p');
        store_actividad2(pagina);
    });
});
// Funcion para realizar la busqueda del usuario por nombre, apellido, usuario, dependencia
function busqueda_actividad_pend(txtBuscar) {
    document.getElementById('grid').innerHTML='';    
    var parametros = {
        'txtBuscar': txtBuscar
    };
    $.ajax({
        data: parametros,
        url: 'procesos/actividades/buscar_actividad_admin_pendiente.php',
        type: 'POST',
        beforeSend: function () {
            document.getElementById('grid').innerHTML=('<br><br><center><br><p>Cargando datos, espere por favor...</p></center><br><br>');
        },
        success: function(response){
            var datos = JSON.parse(response);
            document.getElementById('grid').innerHTML=(datos.grid);
        }
    });
}
// Funcion para realizar la busqueda del usuario por nombre, apellido, usuario, dependencia
function busqueda_actividad_fin(txtBuscar2) {
    document.getElementById('grid2').innerHTML='';    
    var parametros = {
        'txtBuscar2': txtBuscar2
    };
    $.ajax({
        data: parametros,
        url: 'procesos/actividades/buscar_actividad_admin_finalizada.php',
        type: 'POST',
        beforeSend: function () {
            document.getElementById('grid2').innerHTML=('<br><br><center>Cargando datos, espere por favor...</center><br><br>');
        },
        success: function(response2){
            var datos = JSON.parse(response2);
            document.getElementById('grid2').innerHTML=(datos.grid2);
        }
    });
}
// Funcion que nos cargara la tabla de seguimientos realizados
function store_seguimiento(pagina, id_actividad){   
    var parametros = {
        "pagina": pagina,
        "id_actividad": id_actividad
    };           
    $.ajax({
        type: 'POST',
        data: parametros,
        url: 'procesos/actividades/store_info_seguimientos_realizados.php',
        beforeSend: function () {
           document.getElementById('grid3').innerHTML=('<br><br><center>Cargando datos, espere por favor...</center><br><br>');
        },
        success: function(response3){
            var datos = JSON.parse(response3);
            document.getElementById('grid3').innerHTML=(datos.grid3);
            document.getElementById("refAct").innerHTML=(datos.referencia);
        }
    });
}
$(document).ready(function(){    
    store_seguimiento(0, 0);         
});
//Funcion cargar documentos de actividad
function cargarDocumento(id_actividad){
     $.ajax({
            type: "POST",
            dataType: 'json',
            data: {"id_actividad" : id_actividad},
            url: "procesos/actividades/mostrar_documentos.php"
        }).done(function (result) {
            document.getElementById('cargarDoc').innerHTML='';
            if(result.total > 0) {
                var array=result.items;
                for(i=0;i<result.total; i++){
                    if (result.total > 1) {
                        document.getElementById('cargarDoc').innerHTML +="<a href='upload/actividades/"+array[i]['documento']+"', download>"+array[i]['documento'].slice(0, -37)+array[i]['documento'].slice(-4)+",</a>";
                    }else{
                        document.getElementById('cargarDoc').innerHTML +="<a href='upload/actividades/"+array[i]['documento']+"' download>"+array[i]['documento'].slice(0, -37)+array[i]['documento'].slice(-4)+"</a>";
                    }
                }
            }
    });
}
//Funcion cargar documentos de actividad
function cargarDocumentoSeguimiento(id_seguimiento){
     $.ajax({
            type: "POST",
            dataType: 'json',
            data: {"id_seguimiento" : id_seguimiento},
            url: "procesos/actividades/mostrar_documentos_seguimiento.php"
        }).done(function (result) {
            document.getElementById('cargarDocSeg').innerHTML='';
            if(result.total > 0) {
                var array=result.items;
                for(i=0;i<result.total; i++){
                    if (result.total > 1) {
                        document.getElementById('cargarDocSeg').innerHTML +="<a href='upload/actividades/"+array[i]['documento']+"', download>"+array[i]['documento'].slice(0, -37)+array[i]['documento'].slice(-4)+",</a>";
                    }else{
                        document.getElementById('cargarDocSeg').innerHTML +="<a href='upload/actividades/"+array[i]['documento']+"' download>"+array[i]['documento'].slice(0, -37)+array[i]['documento'].slice(-4)+"</a>";
                    }
                }
            }
    });
}
// Funcion para cargar el formulario de detalle de la actividad
function actividad_detalle(id, referencia, fecha_procesamiento, fecha_solicitud, dependencia_origen, solicitante, requerimiento, marginado, estado, referencia_origen, con_conocimiento, asignados) {
    document.getElementById('txtId3').value = id;
    document.getElementById('txtRef').value = referencia;
    document.getElementById('txtFProc').value = fecha_procesamiento;
    document.getElementById('txtFSol').value = fecha_solicitud;
    document.getElementById('txtDep').value = dependencia_origen;
    document.getElementById('txtSol').value = solicitante;
    document.getElementById('txtReq').value = requerimiento;
    document.getElementById('txtMar').value = marginado;
    document.getElementById('txtEst').value = estado;
    document.getElementById('txtOrigen').value = referencia_origen;
    //document.getElementById('txtCC').value = con_conocimiento;
    document.getElementById('txtAsg').value = asignados;
    cargarDocumento(id);
}
// Funcion para cargar el formulario de seguimiento
function seguimiento_act(id, solicitante, dependencia_origen, requerimiento, referencia) {
    document.getElementById('txtId2').value = id;
    document.getElementById('txtSolic').value = solicitante;
    document.getElementById('txtDepen').value = dependencia_origen;
    document.getElementById('txtReque').value = requerimiento;
    document.getElementById('txtReferencia').value = referencia;
}
// Funcion para cargar el formulario de seguimiento
function detalle_seguimiento(id, solicitante, dependencia_origen, requerimiento, accion_realizada, estado, id_seguimiento) {
    document.getElementById('txtId4').value = id;
    document.getElementById('txtSoliSeguimiento').value = solicitante;
    document.getElementById('txtDepSeguimiento').value = dependencia_origen;
    document.getElementById('txtReqSeguimiento').value = requerimiento;
    document.getElementById('txtAccSeguimiento').value = accion_realizada;
    document.getElementById('txtEstSeguimiento').value = estado;
    document.getElementById('txtId5').value = id_seguimiento;
    cargarDocumentoSeguimiento(id_seguimiento);
}
// Funcion para cargar el formulario de seguimiento
function cambio_estado(id, referencia, requerimiento, estado) {
    document.getElementById('txtId_cestado').value = id;
    document.getElementById('txtrefActividad').value = referencia;
    document.getElementById('txtRequeFin').value = requerimiento;
    document.getElementById('txtEstadoFin').value = estado;
}

function cargar_asignacion(estado){
    if (estado == 'Pendiente') {
        $('#divAsignacion').show();
        $('#txtSeccion').attr('disabled', false);
        $('#txtAsignado').attr('disabled', false);
    }else{
        $('#divAsignacion').hide();
        $('#txtSeccion').attr('disabled', true);
        $('#txtAsignado').attr('disabled', true);
    }
}
$(document).ready(function(){    
    $('#divAsignacion').hide();         
});

$(document).ready(function () {
    var miselect = $('#txtSeccion');
    var id_seccion = <?php echo $_SESSION["id_seccion"] ?>;
    miselect.empty();
    miselect.find('option').remove().end().append('').val('');
    $.post("procesos/store_seccion.php", 
    { "id_dependencia": <?php echo $_SESSION["id_dependencia"] ?> },
    function (data) {
        var datos = data.items;
        for (var i = 0; i < data.total; i++) {
            if (id_seccion == datos[i].id_seccion) {
                miselect.append('<option selected value="' + datos[i].id_seccion + '">' + datos[i].seccion + '</option>');
                store_usuarios_seccion(datos[i].id_seccion);
            }else{
                miselect.append('<option value="' + datos[i].id_seccion + '">' + datos[i].seccion + '</option>');
            }
        }
    }, 'json');
});

function store_usuarios_seccion(id_seccion){
    $.post("procesos/actividades/store_seccion_usuario.php", 
        { "id_seccion": id_seccion }, 
        function(data){
        var data=JSON.parse(data);
        var resultado=data.items;
        var opciones='<option value="">Seleccione un usuario</option>';
        for(var i=0; i<data.total; i++){
            opciones+="<option value='"+resultado[i].id_usuario+"'>"+resultado[i].nombre_completo+"</option>";
        }
        $('#txtAsignado').html(opciones);
        $('#txtAsignado').select2();
    });         
}
</script>