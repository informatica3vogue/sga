<ul class="breadcrumb">
    <a href="?mod=memorandum" class="icon-folder-open" title="crear">&nbsp;Ir a memorándum</a>&nbsp;&nbsp;&nbsp;|&nbsp;&nbsp;&nbsp;
    <a href="?mod=grupos_creados" class="icon-folder-open" title="crear">&nbsp;Ver grupos creados</a>&nbsp;&nbsp;&nbsp;
</ul> 
    <!-- end submenu-->
<div class="box">
        <div class="box-header">
            <h2><i class="halflings-icon white user"></i><span class="break"></span>Crear nuevo grupo</h2>
            <div class="box-icon">
                <a href="#" data-rel="tooltip" title="Minimizar" class="btn-minimize"><i class="halflings-icon white chevron-up"></i></a>
            </div>
        </div>
        <div class="box-content">
            <form role="form" method="POST" name="frmGrupoEmp" id="frmGrupoEmp" autocomplete="off" enctype="multipart/form-data" onSubmit="return false">
                <div class="span12">
                    <div class="form-group">
                        <label>Nombre grupo: </label>
                        <input type="text" class="form-control" name="txtNombreGrupo" id="txtNombreGrupo" data-validation="required" data-validation-error-msg="rellene este campo" placeholder="Escriba nombre del grupo">
                    </div>    
                </div>
                <div>
                    <div class="form-group span10 pull-left">
                        <label>Empleado: </label>
                        <select name="txtEmpleado" id="txtEmpleado" class="form-control select2" style="width: 99.5%;" data-placeholder="Seleccione un empleado">
                        </select>
                    </div>                              
                    <div class="span2">
                        <div class="form-group">
                            <button title="Agregar" type="button" style="margin-top: 25px;" class="btn btn-success btn-block pull-right" onclick="agregar()"><span class="icon-plus">&nbsp;Agregar</span></button>
                        </div>
                    </div>
                </div>
                <div style="clear:both;"></div>
                <div class="table-responsive">
                    <table class='table table-striped table-bordered table-hover' style="margin-bottom:0;">
                    <thead class="ticket blue">
                    <tr>
                        <th width="10%">
                             N°
                        </th>
                        <th width="75%">
                             Empleado
                        </th>                       
                        <th width="15%">
                             Acción
                        </th>
                    </tr>
                    </thead>
                    </table>
                    <div style="height:250px; top: 0; overflow-y:scroll; overflow-x:hidden;">
                        <table class='table table-striped table-bordered table-hover'>
                        <tbody id="detalle_empleado">
                        </tbody>
                        </table>
                    </div>
                </div>
                <div style="clear:both;"></div>
                <br>
                <br>
                <br>
                <br>
                <div class="form-actions">
                    <button type="button" id="cancelar" name="cancelar" onClick="location.href='?mod=memorandum'" class="btn btn-danger btn-movil pull-left margin-right">Cancelar</button>
                    <button type="submit" id="guardar" name="guardar" class="btn btn-movil btn-primary pull-right">Guardar</button>
                </div>
            </form>
        </div>
    </div>
<script type="text/javascript">

//funcion para llenar combo de empleados
$(document).ready(function () {
    $.post("procesos/memorandum/store_cargar_empleados.php",
        function(data){
        var data=JSON.parse(data);
        var resultado=data.items;
        var total=resultado.length;
         var opciones='<option value=""></option>';
        for(var i=0; i<total; i++){
            opciones+="<option value='"+resultado[i].id_empleado+"'>"+resultado[i].nombre_completo+"</option>";
        }
        $('#txtEmpleado').html(opciones);
        $('#txtEmpleado').select2();
    });
});

$(document).ready(function () {
    <?php unset($_SESSION["detalle_empleado"]); ?>
});

//añadir empleados a tabla
function agregar(){
    var id_empleado=$("#txtEmpleado").val();    
    var empleado= document.getElementById('txtEmpleado').options[document.getElementById('txtEmpleado').selectedIndex].text;
    if(id_empleado==""){
        $.alert('Seleccione un empleado, por favor', { title: 'Verifique su informacion', icon: 'circle-close', buttons: { 'Cerrar': function () { $(this).dialog("close"); }}});
    }else{
        $.ajax({
            url: "procesos/memorandum/agregar_empleados_tabla.php",
            type: "POST",
            dataType: "json",
            data: {"id_empleado": id_empleado, "empleado" : empleado}
        }).done(function(data){
            total=data.length;
            var opciones;
            var n=0;
            if(total>0){
                for(var i=0; i<total; i++){
                    n++;
                    opciones+="<tr><td width='10%'>"+n+"</td><td width='75%'>"+data[i].empleado+"</td><td width='14%'><a href='#' class='btn btn-danger' onclick=\"quitar('"+data[i].id_empleado+"');\"><i class='halflings-icon white trash'></a></td></tr>";
                }
                $('#detalle_empleado').html(opciones);
            }            
        });
    }
}

//qutias empleados de tabla
function quitar(id_empleado){
    if(id_empleado!=""){
        $.ajax({
            url: "procesos/memorandum/quitar_empleado_tabla.php",
            type: "POST",
            dataType: "json",
            data: {"id_empleado": id_empleado}
        }).done(function(data){
            total=data.length;
            var opciones;
            var n=0;
            if(total>0){
                for(var i=0; i<total; i++){
                    n++;
                     opciones+="<tr><td width='10%'>"+n+"</td><td width='75%'>"+data[i].empleado+"</td><td width='14%'><a href='#' class='btn btn-danger' onclick=\"quitar('"+data[i].id_empleado+"');\"><i class='halflings-icon white trash'></a></td></tr>";
                }
                $('#detalle_empleado').html(opciones);
            }else{
                $('#detalle_empleado').html("");
            }
        });
    }
}

// Funcion para almacenar los datos
$(document).ready(function () {
    $('#guardar').click(function () {
        $.validate({
            onSuccess : function(form) {
                var formulario = $('#frmGrupoEmp').serializeArray();
                $.ajax({
                    data: formulario,
                    type: 'POST',
                    dataType: "Json",
                    url: 'procesos/memorandum/guardar_empleado_grupo.php',
                    beforeSend: function () {
                        $.blockUI({ message: '<h1><img src="img/loading.gif"/> Espere un momento...</h1>' });
                    },
                    success: function(response){
                        if(response.success == true) {
                            $.alert(response.mensaje, { title: 'Operacion exitosa', icon: 'circle-check', buttons: { 'Aceptar': function () { $(this).dialog("close"); location.href = "?mod=grupos_creados"; }}});
                        }else{
                            $.alert(response.mensaje, { title: 'Verifique su informacion', icon: 'circle-close', buttons: { 'Cerrar': function () { $(this).dialog("close"); }}});
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