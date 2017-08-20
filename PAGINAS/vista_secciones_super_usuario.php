<div class="span12">
    <ul class="breadcrumb">
        <a href="?mod=csystemabr" class="icon-sitemap" title="Ingresar nuevas secciones">&nbsp;Ingresar nuevas secciones</a>
    </ul>
	<div class="box">
		<div class="box-header">
			<h2><i class=" halflings-icon tasks white"></i><span class="break"></span>Secciones por dependencia</h2>
			<div class="box-icon">
				<a href="#" class="btn-setting" onclick="store_seccion(1, $('#txtDependencia').val())"><i class="halflings-icon refresh white"></i></a>
				<a href="#" class="btn-minimize" title="Minimizar"><i class="halflings-icon white chevron-up"></i></a>
			</div>
		</div>
		<div class="box-content">
			<div class="navbar-form navbar-left" role="search">
				<div class="form-group span6" style="margin-top: 6px;">
					<label>Dependencia: </label>
					<select class="form-control select2" name="txtDependencia" id="txtDependencia" onChange="store_seccion(1, $('#txtDependencia').val())">
					</select>
				</div>
				<div class="form-group span6">
					<label>Abreviatura de dependencia: </label>
					<input type="text" class="form-control" name="txtAbreviatura2" style="width: 97%;" id="txtAbreviatura2" disabled="disable">
				</div>
			</div>
            <div class='table-responsive' width='100%'>
            <table class='table table-hover table-bordered table-condensed bootstrap-datatable'>
                <thead class='ticket blue'>
                    <tr>
                        <th width='5%' style="padding: 8px;">N°</th>
                        <th width='85%' style="padding: 8px;">Sección</th>
                        <th width='10%' style="padding: 8px;">Acciones</th>
                    </tr> 
                </thead>
                <tbody id="grid">
                </tbody>
            </table>
        </div>
			<div id="paginador">
			</div>
		</div>
	</div>
	<!--/span-->
</div>
<!-- Ventana Modal para el cambio de estado del usuario -->
<div class="modal hide fade" id="modal_dependencia">
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">×</button>
        <h3>Confirme eliminar</h3>
    </div>
    <div class="modal-body">
        <!--Formulario de modal-->
        <form role="form" method="POST" name="frmEliminar" id="frmEliminar">
	            <input type="hidden" id="txtId3" name="txtId3">
	            <div class="form-group">
	                <label>Desea eliminar la sección:</label>
	                <input type="text" id="seccion" name="seccion" class="form-control" disabled="true">
	            </div>
    	</form>
    </div>
    <div class="modal-footer">
        <button type="button" class="btn btn-danger pull-left" data-dismiss="modal">Cancelar</button>
        <button type="submit" id="eliminar" name="eliminar" class="btn btn-primary">Eliminar</button>
    </div>
</div>
<!-- Ventana Modal para el cambio de estado del usuario -->
<div class="modal hide fade" id="modal_secc_mod">
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">×</button>
        <h3>Modificar sección</h3>
    </div>
    <div class="modal-body">
        <!--Formulario de modal-->
        <form role="form" method="POST" name="frmModificar" id="frmModificar">
	            <input type="hidden" id="txtId4" name="txtId4">
	            <div class="form-group">
	                <label>Sección actual</label>
	                <input type="text" id="txtSeccionActual" name="txtSeccionActual" class="form-control">
	            </div>
    	</form>
    </div>
    <div class="modal-footer">
        <button type="button" class="btn btn-danger pull-left" data-dismiss="modal">Cancelar</button>
        <button type="submit" id="guardar_mod" name="guardar_mod" class="btn btn-primary">Guardar</button>
    </div>
</div>
<script type="text/javascript">
// Funcion que nos cargara la tabla de memorandum tipo externo
function store_seccion(pagina, id_dependencia){
    var parametros = {
        "pagina": pagina,
        "id_dependencia": id_dependencia
    };
    $.ajax({
        type: 'POST',
        data: parametros,
        url: 'procesos/store_info_seccion.php',
        beforeSend: function () {
           document.getElementById('grid').innerHTML=('<tr><td colspan="3">Cargando datos, espere por favor...</td></tr>');
        },
        success: function(response){
            var datos = JSON.parse(response);
            document.getElementById('grid').innerHTML=(datos.grid);
            document.getElementById('paginador').innerHTML=(datos.paginador);
            document.getElementById('txtAbreviatura2').value=datos.abreviatura;
        }
    });
}
$(document).ready(function(){    
    store_seccion(1, ""); //Cargar primera pagina por defecto
    $('.pagination_sec li#activo').live('click',function(){
        var pagina = $(this).attr('p');
        var id_dependencia = $('#txtDependencia').val();
        store_seccion(pagina, id_dependencia);
    });           
});

//Funcion para cargar ventana modal 
function eliminar(id_seccion, seccion){
    document.getElementById("txtId3").value=id_seccion;
    document.getElementById("seccion").value=seccion;
}

// Funcion que nos permitira cambiar el estado del usuario
$(document).ready(function () {
    $('#eliminar').click(function () {
        var formulario = $('#frmEliminar').serializeArray();
        $.ajax({
            type: 'POST',
            dataType: 'json',
            url: 'procesos/eliminar_seccion.php',
            data: formulario,
        }).done(function (response) {
            if(response.success == true) {
                bootbox.alert(response.mensaje, function() { location.href = "?mod=csystemsecc"; });
            }else{
                bootbox.alert(response.mensaje, function() { });
            }
        });
    });
});

//Funcion para cargar ventana modal 
function modificar(id, seccion){
    document.getElementById('txtId4').value = id;
    document.getElementById("txtSeccionActual").value=seccion;
}

// Funcion que nos permitira cambiar el estado del usuario
$(document).ready(function () {
    $('#guardar_mod').click(function () {
        var formulario = $('#frmModificar').serializeArray();
        $.ajax({
            type: 'POST',
            dataType: 'json',
            url: 'procesos/modificar_seccion.php',
            data: formulario,
        }).done(function (response) {
            if(response.success == true) {
                bootbox.alert(response.mensaje, function() { location.href = "?mod=csystemsecc"; });
            }else{
                bootbox.alert(response.mensaje, function() { });
            }
        });
    });
});

//cargar combo de dependencias 
$(document).ready(function () {
    $.post("procesos/store_dependencia.php", 
        function(data){
        var data=JSON.parse(data);
        var resultado=data.items;
        var total=resultado.length;
        $('#txtDependencia').select2("val","");
        var opciones='<option value="">Seleccione una opcion</option>';
        for(var i=0; i<total; i++){
            opciones+="<option value='"+resultado[i].id_dependencia+"'>"+resultado[i].dependencia+"</option>";
        }
        $('#txtDependencia').html(opciones);
    });         
});
</script>