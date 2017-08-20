<div class="span12">
    <!-- start submenu -->
    <ul class="breadcrumb">
        <a href="?mod=asignacion_bien" class="icon-shopping-cart" title="Ingresar nuevo artículo">&nbsp;&nbsp;Asignar bien a empleados</a>&nbsp;&nbsp;&nbsp;|&nbsp;&nbsp;&nbsp;
    </ul>
    <!-- end submenu-->
    <div class="box">
        <div class="box-header">
            <h2><i class="halflings-icon white user"></i><span class="break"></span>Ingresar nuevos bienes a seccion</h2>
            <div class="box-icon">
                <a href="#" data-rel="tooltip" title="Minimizar" class="btn-minimize"><i class="halflings-icon white chevron-up"></i></a>
            </div>
        </div>
        <div class="box-content">
            <form role="form" method="POST" name="frmBienSeccion" id="frmBienSeccion" autocomplete="off" enctype="multipart/form-data" onSubmit="return false">
                <div class="span2">
                    <div class="form-group">
                        <label>CAF: </label>
                        <input type="text" class="form-control" name="txtCaf" id="txtCaf" placeholder="Escriba numero de CAF" onBlur="consultar_bien(this.value)">
                    </div>
                </div>
                <div class="span8">
                    <div class="form-group">
                        <label>Descripcion: </label>
                        <input type="text" class="form-control" name="txtDescripcion" id="txtDescripcion" placeholder="Descripcion del bien" readonly>
                    </div>
                </div>
                <div class="span2">
                    <div class="form-group">
                        <button title="Agregar" type="button" style="margin-top: 25px;" class="btn btn-success btn-block pull-right" onclick="aniadir_bien($('#txtCaf').val(), $('#txtDescripcion').val())"><span class="icon-plus">&nbsp;agregar</span></button>
                    </div>
                </div>
                <div style="clear:both;"></div>
                <div class="table-responsive">
                    <table class='table table-striped table-bordered table-hover' style="margin-bottom:0;">
                    <thead class="ticket blue">
                    <tr>
                        <th width="5%">
                             N°
                        </th>
                        <th width="15%">
                             CAF
                        </th>
                        <th width="70%">
                             Descripcion
                        </th>
                        <th width="10%">
                             Acción
                        </th>
                    </tr>
                    </thead>
                    </table>
                    <div style="height:250px; top: 0; overflow-y:scroll; overflow-x:hidden;">
                        <table class='table table-striped table-bordered table-hover'>
                        <tbody id="session_bienes">
                        </tbody>
                        </table>
                    </div>
                </div>
                <div style="clear:both;"></div>
                <div>
                    <div class="form-group span12">
                        <label>Secci&oacute;n: </label>
                        <select name="id_seccion" id="id_seccion" class="form-control select2" style="width: 99.5%;" data-validation="required" data-validation-error-msg="rellene este campo">
                        </select>
                    </div>
                </div>
                <br>
                <br>
                <br>
                <br>
                <div class="form-actions">
                    <button type="button" id="cancelar" name="cancelar" onClick="location.href='?mod=bien_seccion'" class="btn btn-danger pull-left margin-right">Cancelar</button>
                    <button type="submit" id="guardar" name="guardar" class="btn btn-primary pull-right">Guardar</button>
                </div>
            </form>
        </div>
    </div>
</div>
<script type="text/javascript">
// Funcion que nos permitira mandar los datos a ingresar
$(document).ready(function () {
    $('#guardar').click(function () {
        $.validate({
            onSuccess : function(form) {
                var formulario = $('#frmBienSeccion').serializeArray();
                $.ajax({
                    data: formulario,
                    dataType: 'Json',
                    url: 'procesos/bienes/guardar_bien_seccion.php',
                    type: 'POST',
                    beforeSend: function () {
                        //$.blockUI(); block ui simple
                        $.blockUI({ message: '<h1><img src="img/loading.gif"/> Espere un momento...</h1>' });
                    },
                    success: function(response){
                        if (response.success == true) {
                            $.alert(response.mensaje , { title: 'Operacion exitosa', icon: 'circle-check', buttons: { 'Aceptar': function () { $(this).dialog("close"); location.reload(); }}});
                        }else{
                            $.alert(response.error , { title: 'Verifique su informacion!', icon: 'circle-close', buttons: { 'Aceptar': function () { $(this).dialog("close"); }}});
                        }
                    },
                    error: function(response) {
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

function consultar_bien(caf){
    $.ajax({
        type: 'POST',
        dataType: 'json',
        url: 'procesos/bienes/consultar_bien.php',
        data: {'caf' : caf},
    }).done(function (response) {
        if (response.success == true) {
            $('#txtDescripcion').val(response.descripcion);
        } else {
            $('#txtDescripcion').val('');
            $.alert('No se encontro bien con ese numero de CAF',{ title: 'Verifique su informacion!', icon: 'circle-close', buttons: { 'Cerrar': function () { $(this).dialog("close"); }}});
        }
    });
}

$(document).ready(function(){
    <?php $_SESSION['session_bienes']= isset($_SESSION['session_bienes']) ? $_SESSION['session_bienes'] : array(); ?>
    var n = 0;
    var opciones;
    var response = <?php echo json_encode($_SESSION['session_bienes']) ?>;
    if(response.length>0){
        for(var i=0; i<response.length; i++){
            n++;
            opciones+="<tr><td width='5%'>"+n+"</td><td width='15%'>"+response[i].caf+"</td><td width='70%'>"+response[i].descripcion+"</td><td width='8.5%'><a class='btn btn-danger' href='#' onclick=\"quitar_bien("+response[i].caf+")\"><i class='halflings-icon white trash'></i></a></td></tr>";
        }
        $('#session_bienes').html(opciones);
    }  
});

function aniadir_bien(caf, descripcion){
    consultar_bien(caf);
    var descripcion = (descripcion != "") ? descripcion : $("#txtDescripcion").val();
    if (caf != "") {
        $.ajax({
            type: 'POST',
            dataType: 'json',
            url: 'procesos/bienes/aniadir_bien.php',
            data: {'caf' : caf, 'descripcion' : descripcion},
        }).done(function (response) {
            if (response.success == true) {
                var response = response.items;
                var n = 0;
                var opciones;
                if(response.length>0){
                    for(var i=0; i<response.length; i++){
                        n++;
                        opciones+="<tr><td width='5%'>"+n+"</td><td width='15%'>"+response[i].caf+"</td><td width='70%'>"+response[i].descripcion+"</td><td width='10%'><a class='btn btn-danger' href='#' onclick=\"quitar_bien("+response[i].caf+")\"><i class='halflings-icon white trash'></i></a></td></tr>";
                    }
                    $('#session_bienes').html(opciones);
                }  
            }else{
                $.alert(response.error,{ title: 'Verifique su informacion!', icon: 'circle-close', buttons: { 'Cerrar': function () { $(this).dialog("close"); }}}); 
            }          
        });
    }else{
        $.alert('Rellene el campo de numero de CAF por favor',{ title: 'Verifique su informacion!', icon: 'circle-close', buttons: { 'Cerrar': function () { $(this).dialog("close"); }}});
    }
}

function quitar_bien(caf){
    $.ajax({
        type: "POST",
        dataType: "json",
        url: 'procesos/bienes/quitar_bien.php',
        data: {'caf' : caf},
    }).done(function(response){
        var n = 0;
        var opciones;
        if(response.length>0){
            for(var i=0; i<response.length; i++){
                n++;
                opciones+="<tr><td width='5%'>"+n+"</td><td width='15%'>"+response[i].caf+"</td><td width='70%'>"+response[i].descripcion+"</td><td width='10%'><a class='btn btn-danger' href='#' onclick=\"quitar_bien("+response[i].caf+")\"><i class='halflings-icon white trash'></i></a></td></tr>";
            }
            $('#session_bienes').html(opciones);
        } else{
            $('#session_bienes').html("");
        }
    });
}

$(document).ready(function(){
    $.post("procesos/store_seccion.php",
     { "id_dependencia": <?php echo $_SESSION["id_dependencia"] ?> }, 
     function(data){
        var data=JSON.parse(data);
        var resultado=data.items;
        var total=resultado.length;
        $('#id_seccion').select2("val","");
        var opciones='<option value="">Seleccione una opcion</option>';
        for(var i=0; i<total; i++){
            opciones+="<option value='"+resultado[i].id_seccion+"'>"+resultado[i].seccion+"</option>";
        }
        $('#id_seccion').html(opciones);
    });         
});
</script>