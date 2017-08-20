<?php 
if (isset($_POST['id'])) {
    $params =  $_POST;
    $sql = "SELECT id_actividad, referencia, fecha_procesamiento, fecha_solicitud, id_dependencia_origen, solicitante, requerimiento, marginado, estado, referencia_origen, con_conocimiento, id_seccion FROM actividad WHERE id_actividad = :id";
    $param_list = array("id");
    $result = $data->query($sql, $params, $param_list); 
    if ($result["total"] > 0) { 
?>
<ul class="breadcrumb">
    <a href="?mod=actividades" class="icon-bar-chart" data-rel="tooltip" title="Volver a actividades generales">&nbsp;Volver a actividades generales</a>
</ul>
<!-- end submenu-->
<div class="row-fluid">
    <!--Contenedor de ingreso de actividades-->
    <div class="span12">
        <div class="row-fluid">
            <div class="box">
                <div class="box-header">
                    <h2><i class="icon-bar-chart white list"></i><span class="break"></span>Modificar actividad</h2>
                    <div class="box-icon">
                        <a href="#" data-rel="tooltip" title="Minimizar" class="btn-minimize"><i class="halflings-icon white chevron-up"></i></a>
                    </div>
                </div>
                <form role="form" method="POST" name="frmActividad" id="frmActividad" autocomplete="off" onsubmit="return false">
                    <div class="box-content">
                        <div class="box-body">
                            <input type="hidden" id="txtId" name="txtId" value="<?php echo($result['items'][0]['id_actividad']); ?>">
                            <fieldset>
                                <div class="form-group span6">
                                    <label>Fecha de solicitud: </label>
                                    <input type="text" class="form-control datepicker" name="txtFechaSolicitud" id="txtFechaSolicitud" placeholder="Seleccione una fecha (año-mes-dia)" value="<?php echo($result['items'][0]['fecha_solicitud']) ?>" data-validation="required" data-validation-error-msg="rellene este campo" style="background: #fff;">
                                </div>
                                <div class="form-group span6">
                                    <label>Referencia de origen: </label>
                                    <input type="text" class="form-control" name="txtReferencia" id="txtReferencia" value="<?php echo($result['items'][0]['referencia_origen']) ?>" placeholder="Escriba numero de referencia CSJ-##-####" style="width: 96.8%;">
                                </div> 
                            </fieldset>                     
                            <div class="form-group">
                              <label>Persona solicitante: </label>
                              <input type="text" class="form-control" name="txtSolicitante" id="txtSolicitante" value="<?php echo($result['items'][0]['solicitante']) ?>" placeholder="Escriba nombre de solicitante" data-validation="required" data-validation-error-msg="rellene este campo">
                            </div>
                            <fieldset>
                                <div class="form-group span11">
                                    <label>Dependencia solicitante: </label>
                                    <select class="form-control" name="txtDependencia" id="txtDependencia" data-placeholder="Seleccione dependencia solicitante" data-validation="required" data-validation-error-msg="rellene este campo"></select>
                                </div>
                                <div class="form-group span1">
                                    <label>&nbsp;</label>
                                    <a href="#" class="btn btn-success btn-block" data-toggle="modal" data-target="#modal_dependencia" data-rel="tooltip" title="Ingresar nueva dependencia"><i class="halflings-icon white plus"></i></a>
                                </div>                
                            </fieldset>
                            <div class="form-group">
                                <label>Requerimiento: </label>
                                <textarea class="form-control" name="txtRequerimiento" id="txtRequerimiento" rows="5" placeholder="Escriba requerimiento para actividad" data-validation="required" data-validation-error-msg="rellene este campo" style="width: 97.5%;"><?php echo($result['items'][0]['requerimiento']) ?></textarea>
                            </div>

                            <div class="form-group">
                                <label>Sección: </label>
                                <select class="form-control" name="txtSeccion" id="txtSeccion" onchange="store_usuarios_seccion($('#txtSeccion').val())" data-validation="required" data-validation-error-msg="rellene este campo" ></select>
                            </div>
                            <div class="form-group">
                                <label>Caso asignado a: </label>
                                <select name="txtAsignado[]" class="form-control" id="txtAsignado" style="width: 99%;" data-validation="required" data-validation-error-msg="rellene este campo" data-placeholder="Seleccione usuarios a asignar actividad" multiple="true">
                                </select>
                            </div>
                            <div class="form-group">
                                <label>Con conocimiento a: </label>
                                <select class="form-control" name="txtConocimiento" id="txtConocimiento" data-placeholder="con conocimiento a" ></select>
                            </div>
                            <div class="form-group">
                                <label>Marginado de jefatura: </label>
                                <input type="text" class="form-control" name="txtMarginado" id="txtMarginado" value="<?php echo($result['items'][0]['marginado']) ?>" placeholder="Marginado">
                            </div>
                            <div class="form-group">
                                <label>Adjunto: </label>
                                <input type="file" class="form-control" name="txtAdd[]" id="txtAdd" multiple="true">
                            </div>
                        </div>
                        <div class="form-actions">
                            <button type="button" class="btn btn-danger btn-movil pull-left" id="cancelar" name="cancelar" onclick="location.href='?mod=actividad'">Cancelar</button>
                            <button type="submit" id="guardar" name="guardar" class="btn btn-primary pull-right">Guardar</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<div class="modal hide fade" id="modal_dependencia">
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">×</button>
        <h3>Ingreso de nueva dependencia</h3>
    </div>
    <div class="modal-body">
        <form role="form" method="POST" autocomplete="off" name="frmDependencia" id="frmDependencia" onSubmit="return false">
            <div class="form-group">
                <label>Dependencia:</label>
                <input type="text" class="form-control" name="txtNuevaDependencia" id="txtNuevaDependencia" onkeyup="javascript:this.value = this.value.toUpperCase();" placeholder="Escriba una dependencia" data-validation="required" data-validation-error-msg="rellene este campo">
            </div>      
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-danger btn-movil pull-left" data-dismiss="modal" id="cancelar_dependencia" name="cancelar_dependencia">Cancelar</button>
            <button type="submit" class="btn btn-primary btn-movil pull-right" id="guardar_dependencia" name="guardar_dependencia">Guardar</button>
        </div>
    </form>
</div> 
<script type="text/javascript">
$(document).ready(function () {
    $('#guardar_dependencia').click(function () {
        $.validate({
            onSuccess : function(form) {
                var formulario = $('#frmDependencia').serializeArray();
                $.ajax({
                    type: 'POST',
                    dataType: 'json',
                    url: 'procesos/actividades/agregar_dependencia.php',
                    data: formulario,
                }).done(function (response) {
                    if(response.success == true) {
                        $('#modal_dependencia').modal('hide');
                        $.alert(response.mensaje, { title: 'Operacion exitosa', icon: 'circle-check', buttons: { 'Aceptar': function () { $(this).dialog("close"); store_dependencia(response.id_dependencia); }}});
                    }else{   
                        $('#modal_dependencia').modal('hide');
                        $.alert(response.mensaje, { title: 'Verifique su informacion', icon: 'circle-close', buttons: { 'Cerrar': function () { $(this).dialog("close"); $('#modal_dependencia').modal('show'); }}});
                    }
                });
            }
        });
    });
});

$(document).ready(function () {
    $('#guardar').click(function () {
        $.validate({
            onSuccess : function(form) {
                var formulario = document.getElementById("frmActividad");
                var formData = new FormData(formulario);
                $.ajax({
                    url: "procesos/actividades/modificar_actividad.php",
                    type: "POST",
                    dataType: "Json",
                    data: formData,
                    cache: false,
                    contentType: false,
                    processData: false,
                    beforeSend: function () {
                        $.blockUI({ message: '<h1><img src="img/loading.gif"/> Espere un momento...</h1>' });
                    },
                    success: function(response){
                        if (response.success == true) {
                            $.alert(response.mensaje, { title: response.titulo, icon: 'circle-check', buttons: { 'Cerrar': function () { $(this).dialog("close"); location.href = "?mod=actividad"; }}});    
                        }else{
                            $.alert(response.mensaje, { title: 'Verifique su informacion!', icon: 'circle-close', buttons: { 'Aceptar': function () { $(this).dialog("close"); }}});
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

//cargar combo de dependencias 
function store_dependencia(id_dependencia){
    $.post("procesos/actividades/store_dependencia_solicitante.php", 
        function(data){
        var data=JSON.parse(data);
        var resultado=data.items;
        var opciones='<option value="">Seleccione una dependencia</option>';
        for(var i=0; i<data.total; i++){
            if (id_dependencia == resultado[i].id_dependencia) {
                opciones+="<option selected value='"+resultado[i].id_dependencia+"'>"+resultado[i].dependencia+"</option>";
            }else{
                opciones+="<option value='"+resultado[i].id_dependencia+"'>"+resultado[i].dependencia+"</option>";
            }
        }
        $('#txtDependencia').html(opciones);
        $('#txtDependencia').select2();
    }); 
}
$(document).ready(function () {
    store_dependencia(<?php echo $result['items'][0]['id_dependencia_origen'] ?>);
});

//cargar combo de con conocimiento 
$(document).ready(function () {
    var con_conocimiento = "<?php echo $result['items'][0]['con_conocimiento'] ?>";
    $.post("procesos/actividades/store_usuarios_nombres.php", 
        function(data){
        var data=JSON.parse(data);
        var resultado=data.items;
        var total=resultado.length;
        var opciones='<option value="">Seleccione una opcion</option>';
        for(var i=0; i<total; i++){
            if (con_conocimiento == resultado[i].nombre_completo) {
                opciones+="<option selected='true' value='"+resultado[i].nombre_completo+"'>"+resultado[i].nombre_completo+"</option>";
            }else{
                opciones+="<option value='"+resultado[i].nombre_completo+"'>"+resultado[i].nombre_completo+"</option>";
            }
        }
        $('#txtConocimiento').html(opciones);
        $('#txtConocimiento').select2();
    });         
});

$(document).ready(function () {
    var miselect = $('#txtSeccion');
    var id_seccion = <?php echo $result['items'][0]['id_seccion'] ?>;
    miselect.empty();
    miselect.find('option').remove().end().append('<option value="">Seleccione una sección</option>').val('');
    $.post("procesos/store_seccion.php", 
    { "id_dependencia": <?php echo $_SESSION["id_dependencia"] ?> },
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
});

function store_usuarios_seccion(id_seccion){
    $.post("procesos/actividades/store_seccion_usuario.php", 
        { "id_seccion": id_seccion }, 
        function(data){
        var data=JSON.parse(data);
        var resultado=data.items;
        var opciones='';
        for(var i=0; i<data.total; i++){
            opciones+="<option value='"+resultado[i].id_usuario+"'>"+resultado[i].nombre_completo+"</option>";
        }
        $('#txtAsignado').html(opciones);
        $('#txtAsignado').select2();
    });         
}

$(document).ready(function () {
    $.post("procesos/actividades/store_asignados_actividad.php", 
        { "id_actividad" : <?php echo $params["id"] ?>, "id_seccion" : <?php echo $result['items'][0]['id_seccion'] ?> }, 
        function(data){
        var data=JSON.parse(data);
        var resultado=data.items;
        var opciones='';
        for(var i=0; i<data.total; i++){
            opciones+="<option "+resultado[i].selected+" value='"+resultado[i].id_usuario+"'>"+resultado[i].nombre_completo+"</option>";
        }
        $('#txtAsignado').html(opciones);
        $('#txtAsignado').select2();
    });    
});
</script>               
<?php
    }else{
        header('Location:?mod=actividad');
    }
} else {
    header('Location:?mod=actividad');
}
?>