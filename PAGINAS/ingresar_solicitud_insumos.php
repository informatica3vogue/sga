<span class="span12">
 <!-- start submenu -->
    <ul class="breadcrumb">
        <a href="?mod=vinsumos" class="icon-edit" title="Ver solicitudes de insumos">&nbsp;&nbsp;Ver solicitudes de insumos</a>&nbsp;&nbsp;&nbsp;|&nbsp;&nbsp;&nbsp;
        <a href="?mod=cinsumos" class="icon-edit" title="Ingresar articulos">&nbsp;&nbsp;Ingresar articulos</a>&nbsp;&nbsp;&nbsp;|&nbsp;&nbsp;&nbsp;
        <a href="?mod=articulo" class="icon-edit" title="Cargar articulos">&nbsp;&nbsp;Cargar articulos</a>&nbsp;&nbsp;&nbsp;|&nbsp;&nbsp;&nbsp;
        <a href="?mod=repinsumo" class="icon-file" title="Reportes insumos">&nbsp;&nbsp;Reportes insumos</a>
    </ul>
    <!-- end submenu-->
</span>
<div class="row-fluid">
<div class="span12">
    <div class="box">
        <div class="box-header">
            <h2><i class="halflings-icon white minus-sign"></i><span class="break"></span>Solicitud de articulos</h2>
            <div class="box-icon">
                <a href="#" data-rel="tooltip" title="Minimizar" class="btn-minimize"><i class="halflings-icon white chevron-up"></i></a>
            </div>
        </div>
        <div class="box-content">
        <form role="form" method="POST" name="frmInsumos" id="frmInsumos" autocomplete="off" enctype="multipart/form-data" onSubmit="return false">
                <div class="form-group span5">
                    <label>Articulo: </label>
                    <select class="form-control select2" name="txtArticulo" id="txtArticulo" data-placeholder="Seleccione un articulo" data-validation="required" data-validation-error-msg="rellene este campo">
                    </select>
                </div>
                <div class="form-group span5">
                    <label>Cantidad: </label>
                    <input type="number" class="form-control" min="0" max="10" name="txtCantidad" id="txtCantidad" placeholder="Escriba una cantidad" style="width: 94%;" data-validation="required" data-validation-error-msg="rellene este campo" onkeyup="limitar(this.value)">
                </div>
                <div class="form-group span2">
                    <label>&nbsp;</label>
                    <button type="button" class="btn btn-success btn-block" onclick="add()"><i class="halflings-icon white plus"></i> Agregar</button>
                </div>
                <div style="clear:both;"></div>
                <div class="table-responsive">
                    <table class='table table-striped table-bordered table-hover' style="margin-bottom:0;">
                    <thead class="ticket blue">
                    <tr>
                        <th width="8%">
                            N°
                        </th>
                        <th width="42%">
                            Articulo
                        </th>
                        <th width="42%">
                            Cantidad
                        </th>
                        <th width="10%">
                            Acción
                        </th>
                    </tr>
                    </thead>
                    </table>
                    <div style="height:200px; top: 0; overflow-y:scroll; overflow-x:hidden;">
                        <table class='table table-striped table-bordered table-hover'>
                        <tbody id="detalle_solicitud">
                        </tbody>
                        </table>
                    </div>
                </div>
                <div style="clear:both;"></div>
                <div class="form-group ">
                    <label>Observación:</label>
                    <textarea type="text" rows="2" class="form-control span12" name="txtDetalle" id="txtDetalle" placeholder="Escriba una observacion"></textarea>
                </div>
            <div class="form-actions">
                <button type="button" id="cancelar" name="cancelar" onClick="location.reload()" class="btn btn-danger pull-left">Cancelar</button>
                <button type="submit" id="guardar" name="guardar" class="btn btn-primary pull-right">Guardar</button>
            </div>
            </form>  
        </div>

    </div>
</div>
</div>

<!-- Ventana Modal -->
<div class="modal hide fade" id="modal_comprobante">
    <div class="modal-header">
        <button type="button" onClick="location.href='?mod=vinsumos'" class="close" data-dismiss="modal">×</button>
        <h3>Comprobante de solicitud de insumos</h3>
    </div>
    <div class="modal-body">
        <div id="versolicitud"></div>
        <iframe id="pdfSolicitud" src="" frameborder="0" width="100%" height="400px" scrolling="no"></iframe>
    </div>
    <div class="modal-footer">
        <button type="button" onClick="location.href='?mod=vinsumos'" class="btn btn-danger pull-right" data-dismiss="modal">Cerrar</button>
    </div>
</div>
<script type="text/javascript">
// Funcion para almacenar los datos
$(document).ready(function () {
    $('#guardar').click(function () {
        $.validate({
            onSuccess : function(form) {
                var formulario = document.getElementById("frmInsumos");
                var formData = new FormData(formulario);
                $.ajax({
                    url: "procesos/guardar_solicitud.php",
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
                        $.post("reportes/rep_solicitud.php", 
                        {'id' : response.id},
                        function(data){
                            var data=JSON.parse(data);
                            if(data.success == true) {
                                document.getElementById('pdfSolicitud').src = data.link+'';
                                $('#modal_comprobante').modal('show');
                            }else{
                                document.getElementById('versolicitud').innerHTML=(data.error);
                            }
                        });       
                    } else {
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

//cargar combo de usuarios asignados 
$(document).ready(function () {
    $.post("procesos/store_articulo.php", 
        function(data){
        var data=JSON.parse(data);
        var resultado=data.items;
        var total=resultado.length;
        $('#txtArticulo').select2("val","");
        var opciones='<option value="">Seleccione una opcion</option>';
        for(var i=0; i<total; i++){
            opciones+="<option value='"+resultado[i].id_articulo+"'>"+resultado[i].articulo+"</option>";
        }
        $('#txtArticulo').html(opciones);
    });         
});

// quitar articulos de tabla
function quitar(id){
    //incluir alert confirm y hacer accion en caso de YES
    if(id!=""){
        $.ajax({
            url: "procesos/quitar_articulo_insumos.php",
            type: "POST",
            dataType: "json",
            data: {"id_articulo": id}
        }).done(function(data){
            total=data.length;
            var opciones;
            var n=0;
            if(total>0){
                for(var i=0; i<total; i++){
                    n++;
                    opciones+="<tr><td width='8%'>"+n+"</td><td width='42%'>"+data[i].articulo+"</td><td width='41%'>"+data[i].cantidad+"</td><td width='6.8%'><a href='#' class='btn btn-danger' onsubmit='return false' onclick='quitar("+data[i].id_articulo+")'><i class='halflings-icon white trash'></i></a></td></tr>";
                }
                $('#detalle_solicitud').html(opciones);
            }else{
                $('#detalle_solicitud').html("");
            }
        });
    }
}

//añadis articulos a tabla
function add(){
    var articulo=$("#txtArticulo").val();
    var cantidad=$("#txtCantidad").val();
    var nombre= document.getElementById('txtArticulo').options[document.getElementById('txtArticulo').selectedIndex].text;
    if(articulo==""){
        alert('seleccione un articulo');
        $("#txtArticulo").focus();
    }else if(cantidad==""){
        alert('Ingrese una cantidad');
        $("#txtCantidad").focus();
    }else{
        $.ajax({
            url: "procesos/agregar_articulos_insumos.php",
            type: "POST",
            dataType: "json",
            data: {"id_articulo": articulo, "articulo": nombre, "cantidad": cantidad}
        }).done(function(data){
            total=data.length;
            var opciones;
            var n=0;
            if(total>0){
                for(var i=0; i<total; i++){
                    n++;
                    opciones+="<tr><td width='8%'>"+n+"</td><td width='42%'>"+data[i].articulo+"</td><td width='41%'>"+data[i].cantidad+"</td><td width='6.8%'><a href='#' class='btn btn-danger' onsubmit='return false' onclick='quitar("+data[i].id_articulo+")'><i class='halflings-icon white trash'></i></a></td></tr>";
                }
                $('#detalle_solicitud').html(opciones);
            }            
        });
    }
}

function limitar(cantidad){
    if (cantidad >= 11 || cantidad < 0){
        document.getElementById("txtCantidad").value = '';
    }
}
</script>