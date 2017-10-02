<div class="span12">
 	<ul class="breadcrumb">
        <a href="?mod=csystemsecc" class="icon-sitemap" title="Secciones por dependencia">&nbsp;Secciones por dependencia</a>&nbsp;&nbsp;&nbsp;|&nbsp;&nbsp;&nbsp;
        <a href="#" class="icon-info-sign" data-toggle='modal' data-target='#modal_abreviatura' title="Creacion de referencia de dependencia">&nbsp;Creaci&oacute;n de referencia</a>
    </ul>
	<div class="box">
		<div class="box-header">
			<h2><i class=" halflings-icon tasks white"></i><span class="break"></span>Ingreso de secciones</h2>
			<div class="box-icon">
				<a href="#" class="btn-minimize" title="Minimizar"><i class="halflings-icon white chevron-up"></i></a>
			</div>
		</div>
		<div class="box-content">
			<form role="form" method="POST" name="frmSeccion" id="frmSeccion" autocomplete="off" enctype="multipart/form-data">
				<div class="form-group span5">
					<label>Dependencia: </label>
					<select class="form-control select2" name="txtDependencia" id="txtDependencia">
					</select>
				</div>
				<div class="form-group span5">
					<label>Secciones: </label>
					<input type="text" class="form-control" name="txtSecciones" id="txtSecciones">
				</div>
				<div class="form-group span2">
					<label>&nbsp;</label>
					<button type="button" class="btn btn-success btn-block" onclick="add()">+ Agregar</button>
				</div>
				<div style="clear:both;"></div>
                <div class="table-responsive">
                    <table class='table table-striped table-bordered table-hover' style="margin-bottom:0;">
                    <thead class="ticket blue">
                    <tr>
                        <th width="8%">
                             N°
                        </th>
                        <th width="84%">
                             Secci&oacute;n
                        </th>
                        <th width="8%">
                             Acción
                        </th>
                    </tr>
                    </thead>
                    </table>
                    <div style="height:300px; top: 0; overflow-y:scroll; overflow-x:hidden;">
                        <table class='table table-striped table-bordered table-hover'>
                        <tbody id="detalle_seccion">
                        </tbody>
                        </table>
                    </div>
                </div>
                <div style="clear:both;"></div>
			<div class="form-actions">
                <button type="button" id="cancelar" name="cancelar" onClick="location.href='?mod=csystemsecc'" class="btn btn-danger pull-left">Cancelar</button>
				<button type="button" id="guardar_seccion" name="guardar_seccion" class="btn btn-primary pull-right">Guardar</button>
			</div>
			</form>
		</div>
	</div>
	<!--/span-->
</div>
<!-- Ventana Modal para el cambio de estado del usuario -->
<div class="modal hide fade" id="modal_abreviatura">
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">×</button>
        <h3>Ingreso de Referencia de dependencia</h3>
    </div>
    <div class="modal-body">
        <form role="form" method="POST" name="frmAbreviatura" id="frmAbreviatura" autocomplete="off" enctype="multipart/form-data">
            <div class="form-group">
                <label>Dependencia:</label>
                <select class="form-control select2" name="txtDependencia" id="txtDependencias" style="width: 94%;">
                </select>
            </div>
            <div class="form-group">
                <label>Abreviatura: </label>
                <input type="text" class="form-control" name="txtAbreviatura" id="txtAbreviatura" placeholder="Escriba una abreviatura para la dependencia" style="width: 92%;">
                <p class="help-block">
                    Referencia para Generador de Memorándum y Seguimiento de Actividades
                </p>
            </div>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-danger pull-left" data-dismiss="modal">Cancelar</button>
            <button type="button" id="guardar_abreviatura" name="guardar_abreviatura" class="btn btn-primary pull-right">Guardar</button>
        </div>
    </form>
</div>
<script type="text/javascript">
// Funcion que nos permitira mandar los datos a ingresar de secciones
$(document).ready(function () {
    $('#guardar_seccion').click(function () {
        var formulario = $('#frmSeccion').serializeArray();
        $.ajax({
            type: 'POST',
            dataType: 'json',
            url: 'procesos/guardar_seccion.php',
            data: formulario,
        }).done(function (response) {                
            if(response.success == false) {
               bootbox.alert(response.mensaje, function() { });
            }else{
                bootbox.alert(response.mensaje, function() { location.href = "?mod=csystemsecc"; }); 
            }
        });
    });
});

//qutias articulos de tabla
function quitar(seccion){
    if(seccion!=""){
        $.ajax({
            url: "procesos/quitar_secciones.php",
            type: "POST",
            dataType: "json",
            data: {"seccion": seccion}
        }).done(function(data){
            total=data.length;
            var opciones;
            var n=0;
            if(total>0){
                for(var i=0; i<total; i++){
                    n++;
                     opciones+="<tr><td width='8%'>"+n+"</td><td width='84%'>"+data[i].seccion+"</td><td width='6.8%'><a href='#' class='btn btn-danger' onclick=\"quitar('"+data[i].seccion+"');\"><i class='halflings-icon white trash'></a></td></tr>";
                }
                $('#detalle_seccion').html(opciones);
            }else{
                $('#detalle_seccion').html("");
            }
        });
    }
}

//añadis articulos a tabla
function add(){
    var seccion=$("#txtSecciones").val();
    if(seccion==""){
        bootbox.alert('Digite una seccion, por favor', function() {  });
    }else{
        $.ajax({
            url: "procesos/agregar_secciones.php",
            type: "POST",
            dataType: "json",
            data: {"seccion": seccion}
        }).done(function(data){
            total=data.length;
            var opciones;
            var n=0;
            if(total>0){
                for(var i=0; i<total; i++){
                    n++;
                    opciones+="<tr><td width='8%'>"+n+"</td><td width='84%'>"+data[i].seccion+"</td><td width='6.8%'><a href='#' class='btn btn-danger' onclick=\"quitar('"+data[i].seccion+"');\"><i class='halflings-icon white trash'></a></td></tr>";
                }
                $('#detalle_seccion').html(opciones);
            }            
        });
    }
}

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

//cargar combo de dependencias 
$(document).ready(function () {
    $.post("procesos/store_dependencia.php", 
        function(data){
        var data=JSON.parse(data);
        var resultado=data.items;
        var total=resultado.length;
        $('#txtDependencias').select2("val","");
        var opciones='<option value="">Seleccione una opcion</option>';
        for(var i=0; i<total; i++){
            opciones+="<option value='"+resultado[i].id_dependencia+"'>"+resultado[i].dependencia+"</option>";
        }
        $('#txtDependencias').html(opciones);
    });         
});

// Funcion que nos permitira mandar los datos a ingresar de formulario de abreviatura
$(document).ready(function () {
    $('#guardar_abreviatura').click(function () {
        var formulario = $('#frmAbreviatura').serializeArray();
        $.ajax({
            type: 'POST',
            dataType: 'json',
            url: 'procesos/guardar_abreviatura.php',
            data: formulario,
        }).done(function (response) {               
            if(response.success == false) {
              bootbox.alert(response.mensaje, function(){});
            }else{
              bootbox.alert(response.mensaje, function() { location.href = "?mod=csystemabr"; });
            }
        });
    });
});
</script>