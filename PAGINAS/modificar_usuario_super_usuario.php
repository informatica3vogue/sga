<?php 
if (isset($_POST['id'])) {
    $params =  $_POST;
    $sql = "SELECT empleado.id_empleado, usuario.id_usuario, INITCAP(empleado.nombre) AS nombre, INITCAP(empleado.apellido) AS apellido, empleado.cargo, usuario.usuario, rol.id_rol, rol.rol, IF(usuario.estado!='', usuario.estado, 'Sin acceso') AS estado, seccion.id_seccion, seccion.seccion, seccion.id_dependencia
            FROM seccion INNER JOIN empleado_seccion ON seccion.id_seccion=empleado_seccion.id_seccion
            INNER JOIN empleado  ON empleado.id_empleado=empleado_seccion.id_empleado
            LEFT JOIN usuario ON empleado.id_empleado = usuario.id_empleado 
            LEFT JOIN rol  ON usuario.id_rol = rol.id_rol
            WHERE empleado.id_empleado = :id";
    $param_list = array("id");
    $result = $data->query($sql, $params, $param_list); 
    if ($result["total"] > 0) { ?>
<div class="span12">
    <ul class="breadcrumb">   
        <a href="?mod=usuario" class="icon-user" title="Usuarios">&nbsp;Catalogo usuarios</a>
    </ul>
    <div class="box">
        <div class="box-header">
            <h2><i class="halflings-icon white user"></i><span class="break"></span>Modificar usuario</h2>
            <div class="box-icon">
                <a href="#" data-rel="tooltip" title="Minimizar" class="btn-minimize"><i class="halflings-icon white chevron-up"></i></a>
            </div>
        </div>
        <div class="box-content">
            <form action="" role="form" name="frmModificar" id="frmModificar" enctype="multipart/form-data" autocomplete="off" onsubmit="return false">
                <div class="panel-body">
                    <div class="form-group">
                        <label>Nombres: </label>
                        <input type="text" class="form-control" name="nombres" id="nombres" placeholder="Escriba el o los nombres del empleado" data-validation="required" data-validation-error-msg="Rellene este campo" value="<?php echo($result['items'][0]['nombre']); ?>">
                    </div>
                    <div class="form-group">
                        <label>Apellidos: </label>
                        <input type="text" class="form-control" name="apellidos" id="apellidos" placeholder="Escriba el o los apellidos del empleado" data-validation="required" data-validation-error-msg="Rellene este campo" value="<?php echo($result['items'][0]['apellido']); ?>">
                    </div>
                    <div class="form-group">
                        <label>Cargo: </label>
                        <input type="text" class="form-control" name="cargo" id="cargo" placeholder="Escriba el cargo del empleado" value="<?php echo($result['items'][0]['cargo']); ?>">
                    </div>
                    <div class="form-group">
                        <label style="color: blue;">Desea que este empleado tenga acceso al sistema?</label>
                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                        <label>No
                            <input type="radio" class="form-control" name="acceso" id="acceso_no" value="No">
                        </label>
                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                        <label>Si
                            <input type="radio" class="form-control" name="acceso" id="acceso_si" value="Si">
                        </label>
                    </div>
                    <div class="form-group" id="div_usuario">
                        <label>Usuario: </label>
                        <input type="text" class="form-control" name="usuario" id="usuario" placeholder="Escriba usuario" data-validation="required" data-validation-error-msg="Rellene este campo" value="<?php echo($result['items'][0]['usuario']); ?>">
                    </div>
                    <div class="form-group" id="div_rol">
                        <label>Rol: </label>
                        <select class="form-control" name="id_rol" id="id_rol" data-validation="required" data-validation-error-msg="Rellene este campo"></select>
                    </div>
                    <div class="form-group">
                        <label>Dependencia: </label>
                        <select name="id_dependencia" id="id_dependencia" class="form-control" data-placeholder="Seleccione una dependencia" onchange="cargar_id_seccion(this.value)"></select>
                    </div>
                    <div class="form-group">
                        <label>Secci&oacute;n: </label>
                        <select name="id_seccion" id="id_seccion" class="form-control" data-placeholder="Seleccione una seccion" data-validation="required" data-validation-error-msg="Rellene este campo" style="width: 99.5%;"></select>        
                    </div>
                </div>
                <input type="hidden" id="id_usuario" name="id_usuario" value="<?php echo($result['items'][0]['id_usuario']); ?>">
                <input type="hidden" id="id_seccion_antigua" name="id_seccion_antigua" value="<?php echo($result['items'][0]['id_seccion']); ?>">
                <input type="hidden" id="id_empleado" name="id_empleado" value="<?php echo($result['items'][0]['id_empleado']); ?>">
                <div class="form-actions">
                    <button type="button" id="cancelar" name="cancelar" onClick="location.href='?mod=usuario'" class="btn btn-danger pull-left margin-right">Cancelar</button>
                    <button type="submit" id="guardar" name="guardar" class="btn btn-primary pull-right">Guardar</button>
                </div>
            </form>
        </div>
    </div>
</div>
<script type="text/javascript">
// para ocultar o mostrar los campos de usuario y rol
$(document).ready(function(){ 
    var id_usuario ='<?php echo($result["items"][0]["id_usuario"]) ?>';
    var estado = '<?php echo($result["items"][0]["estado"]) ?>';
    if(id_usuario > 0 && estado == 'Activo'){
        $('#acceso_si').prop('checked', true);
        $('#usuario').prop('disabled', false);
        $('#div_usuario').show();
        $('#id_rol').prop('disabled', false);
        $('#div_rol').show();  
    }else{
        $('#acceso_no').prop('checked', true);
        $('#div_usuario').hide();
        $('#usuario').prop('disabled', true);
        $('#div_rol').hide(); 
        $('#id_rol').prop('disabled', true); 
    }
    $('input[name="acceso"]').click(function () {
        if($('input:radio[name="acceso"]:checked').val() == 'Si'){
            $('#usuario').prop('disabled', false);
            $('#div_usuario').show();
            $('#id_rol').prop('disabled', false);
            $('#div_rol').show();  
        }else{
            $('#div_usuario').hide();
            $('#usuario').prop('disabled', true);
            $('#div_rol').hide(); 
            $('#id_rol').prop('disabled', true); 
        }
    });  
});

// Funcion que carga el combo del rol
$(document).ready(function(){    
    var id_rol ='<?php echo($result["items"][0]["id_rol"]) ?>';
    var miselect = $('#id_rol');
    $.post("procesos/usuario/store_rol.php",
    function (data) {
        miselect.empty();
        miselect.find('option').remove().end().append('<option value="">Seleccione rol</option>').val('');
        for (var i = 0; i < data.total; i++) {
            if (id_rol == data.items[i].id_rol) {
                miselect.append('<option selected value="' + data.items[i].id_rol + '">' + data.items[i].rol + '</option>');
            }else{
                miselect.append('<option value="' + data.items[i].id_rol + '">' + data.items[i].rol + '</option>'); 
            }
        }
    }, 'json'); 
});

// Funcion que nos permitira cargar el combo de la id_seccion dependiendo de la dependencia
$(document).ready(function () {
    var id_dependencia ='<?php echo($result["items"][0]["id_dependencia"]) ?>';
    $.post("procesos/store_dependencia.php", 
        function(data){
        var data=JSON.parse(data);
        var resultado=data.items;
        var total=resultado.length;
        var opciones='<option value="">Seleccione una dependencia</option>';
        for(var i=0; i<total; i++){
            if (id_dependencia == resultado[i].id_dependencia) {       
                opciones+="<option selected value='"+resultado[i].id_dependencia+"'>"+resultado[i].dependencia+"</option>";
                cargar_id_seccion(resultado[i].id_dependencia);
            }else{
                opciones+="<option value='"+resultado[i].id_dependencia+"'>"+resultado[i].dependencia+"</option>";   
            }
        }
        $('#id_dependencia').html(opciones);
        $('#id_dependencia').select2();
    });         
});

function cargar_id_seccion(id_dependencia){
/// Invocamos a nuestro script PHP
    var id_seccion ='<?php echo($result["items"][0]["id_seccion"]) ?>';
    $.post("procesos/store_seccion.php", { "id_dependencia": id_dependencia }, function(data){
        var data=JSON.parse(data);
        var resultado=data.items;
        var total=resultado.length;
        var opciones='<option value="">Seleccione una seccion</option>';
        for(var i=0; i<total; i++){
            if (id_seccion == resultado[i].id_seccion) {  
                opciones+="<option selected value='"+resultado[i].id_seccion+"'>"+resultado[i].seccion+"</option>";
            }else{
                opciones+="<option value='"+resultado[i].id_seccion+"'>"+resultado[i].seccion+"</option>";  
            }
        }
        $('#id_seccion').html(opciones);
        $('#id_seccion').select2();
    });         
}

// Funcion que nos permitira mandar los datos a ingresar
$(document).ready(function () {
    $('#guardar').click(function () {
        $.validate({
            onSuccess : function(form) {
                var formulario = $('#frmModificar').serializeArray();
                $.ajax({
                    data: formulario,
                    type: 'POST',
                    dataType: "Json",
                    url: 'procesos/usuario/modificar_usuario.php',
                    beforeSend: function () {
                        $.blockUI({ message: '<h1><img src="img/loading.gif"/> Espere un momento...</h1>' });
                    },
                    success: function(response){
                        if (response.success == true) {
                            $.alert(response.mensaje , { title: 'Operacion exitosa', icon: 'circle-check', buttons: { 'Aceptar': function () { $(this).dialog("close"); location.href = "?mod=usuario"; }}});
                        }else{
                            $.alert(response.error , { title: 'Verifique su informacion!', icon: 'circle-close', buttons: { 'Aceptar': function () { $(this).dialog("close"); }}});
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
</script>
<?php
    }else{
        header('Location:?mod=usuario');
    }
} else {
    header('Location:?mod=error');
}
?>