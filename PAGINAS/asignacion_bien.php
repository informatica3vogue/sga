<!-- start submenu -->
<ul class="breadcrumb">
    <a href="?mod=bien_seccion" class="icon-shopping-cart" title="Ingresar nuevo artículo">&nbsp;&nbsp;Asignar bien a seccion</a>&nbsp;&nbsp;&nbsp;|&nbsp;&nbsp;&nbsp;
</ul>
<!-- end submenu-->
<div class="row-fluid">
    <div class="span12 ticket" style="padding: 10px; background: #E1F2F8;">
        <div class="form-group">
            <label>Seleccione una secci&oacute;n:</label>
            <select name="id_seccion" id="id_seccion" class="form-control" onChange="cargar_tablas(this.value);"></select>
        </div>
    </div>
</div>
<br>
<div class="row-fluid">
    <div class="span6">
        <!-- Contenedor de acitividades pendientes -->
        <div class="row-fluid">
            <div class="box">
                <div class="box-header">
                    <h2><i class="icon-bar-chart white list"></i><span class="break"></span>Bienes no asignados</h2>
                    <div class="box-icon">
                        <a href="#" class="btn-minimize" title="Minimizar"><i class="halflings-icon white chevron-up"></i></a>
                    </div>
                </div>
                <div class="box-content">
                    <div class="table-responsive">
                        <table class="table table-bordered table-striped table-hover table-condensed" id="tabla_bienes" style="margin-top: 3.5%;">
                            <thead class="ticket blue">
                                <tr>
                                    <th width="5%">N°</th>
                                    <th width="10%">CAF</th>
                                    <th width="80%">Descripci&oacute;n</th>
                                    <th width="5%">Acci&oacute;n</th>
                                </tr>
                            </thead>
                            <tbody id="tbody_bien">
                                
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <!--/span-->
        </div>
        <!--/row-->
    </div>
    <!--Linea de tiempo-->
    <div class="span6">
        <div class="row-fluid">
            <div class="box">
                <div class="box-header">
                    <h2><i class="icon-bar-chart white list"></i><span class="break"></span>Asignar bien a empleado<label id="refAct"></label></h2>
                    <div class="box-icon">
                        <a href="#" class="btn-minimize" title="Minimizar"><i class="halflings-icon white chevron-up"></i></a>
                    </div>
                </div>
                <div class="box-content">
                    <div class="form-group">
                        <label>Seleccione un empleado:</label>
                        <select name="id_empleado" id="id_empleado" class="form-control"></select>
                    </div>
                    <div style="clear: both;"></div>
                    <div class="table-responsive">
                        <table class="table table-bordered table-striped table-hover table-condensed" id="">
                            <thead class="ticket blue">
                                <tr>
                                    <th width="5%">N°</th>
                                    <th width="10%">CAF</th>
                                    <th width="80%">Descripci&oacute;n</th>
                                    <th width="5%">Acci&oacute;n</th>
                                </tr>
                            </thead>
                            <tbody id="tbody_empleado">
                                
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <!--/span-->
        </div>
        <!--/row-->
    </div>
</div>
<script type="text/javascript">
$(document).ready(function(){
    <?php unset($_SESSION['session_bien_empleado']); ?>
});

// carga el combo de seccion
$(document).ready(function(){
    $.post("procesos/store_seccion.php",
     { "id_dependencia": <?php echo $_SESSION["id_dependencia"] ?> }, 
     function(data){
        var data=JSON.parse(data);
        var resultado=data.items;
        var total=resultado.length;
        var opciones='<option value="">Seleccione una seccion</option>';
        for(var i=0; i<total; i++){
            opciones+="<option value='"+resultado[i].id_seccion+"'>"+resultado[i].seccion+"</option>";
        }
        $('#id_seccion').html(opciones);
        $('#id_seccion').select2();
    });         
});

function cargar_tablas(id_seccion){
    cargar_bienes(id_seccion);
    cargar_empleados(id_seccion);
}

function cargar_bienes(id_seccion){
    var cont =1;
    $.ajax({
        url : 'procesos/bienes/mostrar_bienes_disponibles.php',
        type: 'POST',
        dataType: 'json',
        data: { 'id_seccion' : id_seccion },
        success: function(response){
            $('#tabla_bienes').dataTable().fnClearTable();
            $('#tabla_bienes').dataTable().fnDestroy();
            if(response.success){
                $("#tbody_bien").html('');
                $.each(response.items, function(index, value){ 
                    var descripcion = 'Descripcion: '+clearString(value.descripcion)+', Marca: '+value.marca+', Modelo: '+value.modelo+', N° de serie: '+value.serie+'.';
                    $("#tbody_bien").append("<tr><td>"+cont+"</td><td>"+value.caf+"</td><td>"+descripcion+"</td><td><a href='#' class='btn btn-success' onsubmit='return false' onClick=\"aniadir_session_empleado("+value.caf+", '"+descripcion+"');\"><i class='halflings-icon white hand-right'></i></a></td></tr>");
                    cont++;
                });
                $('#tabla_bienes').dataTable({
                  "sDom": "<'row-fluid'<'span6'f><'span6'<'pull-right'l>>r>t<'row-fluid'<'span6'i><'span6'<'pull-right'p>>>",
                  "sPaginationType": "bootstrap",
                  "oLanguage": {
                  "sInfo":"Mostrando _START_ a _END_ de _TOTAL_ registros",
                  "sZeroRecords":"No se encontraron registros",
                  "sLoadingRecords":"Cargando...",
                  "sProcessing": "Procesando...",
                  "sSearch": "Buscar por:",
                  "sLengthMenu": "_MENU_ registros por pagina"
                  }
                } );
            }else{
                $("#tbody_bien").html('');
            }
        },
      error: function(){
        alert('hubo un error al ejecutar la accion');
      }
  });
}

function cargar_empleados(id_seccion){
    $.post("procesos/bienes/store_cargar_empleados.php",
    { 'id_seccion' : id_seccion },
        function(data){
        var data=JSON.parse(data);
        var resultado=data.items;
        var total=resultado.length;
        var opciones='<option value="">Seleccione empleado</option>';
        for(var i=0; i<total; i++){
            opciones+="<option value='"+resultado[i].id_empleado+"'>"+resultado[i].nombre_completo+"</option>";
        }
        $('#id_empleado').html(opciones);
        $('#id_empleado').select2();
    });           
}

function aniadir_session_empleado(caf, descripcion){
    var cont = 1;
    $.ajax({
        type: 'POST',
        dataType: 'json',
        url: 'procesos/bienes/aniadir_bien_empleado.php',
        data: {'caf' : caf, 'descripcion' : descripcion},
    }).done(function (response) {
        if (response.success == true) {
            $("#tbody_empleado").html('');
            $.each(response.items, function(index, value){ 
                $("#tbody_empleado").append("<tr><td>"+cont+"</td><td>"+value.caf+"</td><td>"+descripcion+"</td><td><a href='#' class='btn btn-danger' onsubmit='return false' onClick=\"quitar_session_empleado("+value.caf+");\"><i class='halflings-icon white trash'></i></a></td></tr>");
                cont++;
            });
        }else {
            $.alert(response.mensaje, { title: 'Verifique su informacion', icon: 'circle-close', buttons: { 'Cerrar': function () { $(this).dialog("close"); }}});
        }      
    });
}

function quitar_session_empleado(caf){
    var cont = 1;
    $.ajax({
        type: "POST",
        dataType: "json",
        url: 'procesos/bienes/quitar_bien_empleado.php',
        data: {'caf' : caf},
    }).done(function(response){
        if(response.length>0){
            $("#tbody_empleado").html('');
            $.each(response, function(index, value){ 
                $("#tbody_empleado").append("<tr><td>"+cont+"</td><td>"+value.caf+"</td><td>"+value.descripcion+"</td><td><a href='#' class='btn btn-danger' onsubmit='return false' onClick=\"quitar_session_empleado("+value.caf+");\"><i class='halflings-icon white trash'></i></a></td></tr>");
                cont++;
            });
        } else {
            $("#tbody_empleado").html('');
        }
    });
}

</script>