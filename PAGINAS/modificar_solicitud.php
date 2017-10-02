<span class="span12">
 <!-- start submenu -->
    <ul class="breadcrumb">
        <a href="?mod=vinsumos" class="icon-edit" title="Ver solicitudes de insumos">&nbsp;&nbsp;Ir a solicitudes de insumos</a>
    </ul>
    <!-- end submenu-->
</span>
<div class="row-fluid">
<div class="span12">
    <div class="box">
        <div class="box-header">
            <h2><i class="halflings-icon white minus-sign"></i><span class="break"></span>Solicitud a modificar</h2>
            <div class="box-icon">
                <a href="#" data-rel="tooltip" title="Minimizar" class="btn-minimize"><i class="halflings-icon white chevron-up"></i></a>
            </div>
        </div>
        <div class="box-content">
        <form role="form" method="POST" name="frmInsumos" id="frmInsumos" autocomplete="off" enctype="multipart/form-data" onSubmit="return false">
                <div class="form-group span5">
                    <label>Articulo: </label>
                    <select class="form-control select2" name="txtArticulo" id="txtArticulo" data-placeholder="Seleccione un articulo">
                    </select>
                </div>
                <div class="form-group span5">
                    <label>Cantidad: </label>
                    <input type="number" class="form-control" min="1" max="10" name="txtCantidad" id="txtCantidad" placeholder="Escriba una cantidad" style="width: 94%;" onkeyup="limitar(this.value)">
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
                    <div style="height:250px; top: 0; overflow-y:scroll; overflow-x:hidden;">
                        <table class='table table-striped table-bordered table-hover'>
                        <tbody id="detalle_solicitud_articulo" data-validation="required" data-validation-error-msg="No hay datos en la Tabla!">
                        </tbody>
                        </table>
                    </div>
                </div>
                <div style="clear:both;"></div>
                <br />
                <input type="hidden" name="id_solicitud" id="id_solicitud" value="<?php echo $_POST['id'] ?>" readonly>
                <div class="form-group ">
                    <label>Observación:</label>
                    <textarea type="text" rows="2" class="form-control span12" name="txtDetalle" id="txtDetalle" placeholder="Escriba una observacion"></textarea>
                </div>
            <div class="form-actions">
                <a href="?mod=vinsumos" class="btn btn-danger pull-left">Cancelar</a>
                <button type="submit" id="guargar_modificacion" name="guargar_modificacion" class="btn btn-primary pull-right">Guardar</button>
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
    $('#guargar_modificacion').click(function () {
        $.validate({
            onSuccess : function(form) {
                var formulario = document.getElementById("frmInsumos");
                var formData = new FormData(formulario);
                $.ajax({
                    url: "procesos/modificar_solicitud_insumos.php",
                    type: "POST",
                    dataType: "Json",
                    data: formData,
                    cache: false,
                    contentType: false,
                    processData: false
                }).done(function (response) {
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
                        bootbox.alert(data.mensaje, function() { });
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
            url: "procesos/quitar_detalle_solicitud.php",
            type: "POST",
            dataType: "json",
            data: {"id_articulo": id}
        }).done(function(response){
            $("#detalle_solicitud_articulo").html("");
            var i=1;
            var data=response.items;
            $.each(data, function(index, value){
                $("#detalle_solicitud_articulo").append("<tr><td width='8%'>"+i+"</td><td width='42.8%'>"+value.articulo+"</td><td width='42.7%'><input id='cantidad_solicitud' type='number' style='background-color: #33FFCC border:none;' min='0' max='10' value="+value.cantidad+" onblur='limitar_valor(this.value, "+value.id_articulo+")'></td><td width='10%'><a href='#' class='btn btn-danger' onsubmit='return false' onclick='quitar("+value.id_articulo+")'><i class='halflings-icon white trash'></i></a></td></tr>");
                i++;
            });
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
            url: "procesos/modificar_detalle_solicitud.php",
            type: "POST",
            dataType: "json",
            data: {"id_articulo": articulo, "articulo": nombre, "cantidad": cantidad, "id_solicitud": $("#id_solicitud").val()}
        }).done(function(response){
            $("#detalle_solicitud_articulo").html("");
            var i=1;
            var data=response.items;
            $.each(data, function(index, value){
                $("#detalle_solicitud_articulo").append("<tr><td width='8%'>"+i+"</td><td width='42.8%'>"+value.articulo+"</td><td width='42.7%'><input id='cantidad_solicitud' type='number' style='background-color: #33FFCC border:none;' min='0' max='10' value="+value.cantidad+" onblur='limitar_valor(this.value, "+value.id_articulo+")'></td><td width='10%'><a href='#' class='btn btn-danger' onsubmit='return false' onclick='quitar("+value.id_articulo+")'><i class='halflings-icon white trash'></i></a></td></tr>");
                i++;
            });
        });
    }
}

function limitar(cantidad){
    if (cantidad >= 11 || cantidad <= 0){
        document.getElementById("txtCantidad").value = '';
    }
}

function listar_articulos(){
    $.ajax({
        url: 'procesos/mostrar_solicitud_insumos.php',
        type: 'POST',
        dataType: 'json',
        data: {"id_solicitud": $("#id_solicitud").val()},
        success: function(response){
            $("#detalle_solicitud_articulo").html("");
            var i=1;
            var data=response.items;
            $.each(data, function(index, value){
                $("#detalle_solicitud_articulo").append("<tr><td width='8%'>"+i+"</td><td width='42.8%'>"+value.articulo+"</td><td width='42.7%'><input id='cantidad_solicitud' type='number' min='0' max='10' value="+value.cantidad+" onblur='limitar_valor(this.value, "+value.id_articulo+")'></td><td width='10%'><a href='#' class='btn btn-danger' onsubmit='return false' onclick='quitar("+value.id_articulo+")'><i class='halflings-icon white trash'></i></a></td></tr>");
                i++;
            });
        },
        error: function(){

        }
    });
}
$(document).ready(function () {
    listar_articulos();    
});

function limitar_valor(cantidad, id_articulo){
    if (cantidad >= 11 || cantidad <= 0){
        document.getElementById("cantidad_solicitud").value = '';
    } else {
        $.ajax({
            url: "procesos/modificar_detalle_solicitud.php",
            type: "POST",
            dataType: "json",
            data: {"id_articulo": id_articulo, "cantidad": cantidad}
        }).done(function(response){
            $("#detalle_solicitud_articulo").html("");
            var i=1;
            var data=response.items;
            $.each(data, function(index, value){
                $("#detalle_solicitud_articulo").append("<tr><td width='8%'>"+i+"</td><td width='42.8%'>"+value.articulo+"</td><td width='42.7%'><input id='cantidad_solicitud' type='number' style='background-color: #33FFCC border:none;' min='0' max='10' value="+value.cantidad+" onblur='limitar_valor(this.value, "+value.id_articulo+")'></td><td width='10%'><a href='#' class='btn btn-danger' onsubmit='return false' onclick='quitar("+value.id_articulo+")'><i class='halflings-icon white trash'></i></a></td></tr>");
                i++;
            });
        });
    }

}
</script>