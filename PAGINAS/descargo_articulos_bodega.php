<span class="span12">
    <!-- start submenu -->
    <ul class="breadcrumb">
        <a href="?mod=compdescargos_bod" class="icon-check" title="Cargos y descargos de bodega">&nbsp;&nbsp;Cargos y descargos de bodega</a>&nbsp;&nbsp;&nbsp;|&nbsp;&nbsp;&nbsp;
        <a href="?mod=articulo_bodega" class="icon-shopping-cart" title="Ingresar nuevo artículo">&nbsp;&nbsp;Ingresar nuevo artículo</a>&nbsp;&nbsp;&nbsp;|&nbsp;&nbsp;&nbsp;
        <a href="?mod=cbodega" class="icon-plus-sign" title="Cargar existencia de articulo">&nbsp;&nbsp;Cargar existencia de articulo</a>&nbsp;&nbsp;&nbsp;|&nbsp;&nbsp;&nbsp;
        <a href="?mod=repbodegas" class="icon-file" title="Reportes de bodega">&nbsp;&nbsp;Reportes de bodega</a>
    </ul>
    <!-- end submenu-->
</span>
<div class="row-fluid">
<div class="span7">
    <div class="box">
        <div class="box-header">
            <h2><i class="halflings-icon white minus-sign"></i><span class="break"></span>Descargo de articulos</h2>
            <div class="box-icon">
                <a href="#" data-rel="tooltip" title="Minimizar" class="btn-minimize"><i class="halflings-icon white chevron-up"></i></a>
            </div>
        </div>
        <div class="box-content">
        <form role="form" method="POST" name="frmBodega" id="frmBodega" autocomplete="off" enctype="multipart/form-data" onSubmit="return false">
                <div class="form-group span4">
                    <label>Articulo: </label>
                    <select class="form-control select2" name="txtArticulo" id="txtArticulo" data-placeholder="Seleccione un articulo" onchange="store_input($('#txtArticulo').val())" data-validation="required" data-validation-error-msg="rellene este campo">
                    </select>
                </div>
                <div class="form-group span3">
                    <label>Cantidad: </label>
                    <input type="number" class="form-control" min="0" name="txtCantidad" id="txtCantidad" style="width: 94%;" placeholder="Escriba una cantidad" onkeyup="limitar(this.value)" data-validation="required" data-validation-error-msg="rellene este campo">
                </div>
                <div class="form-group span3">
                    <label>Existencia:</label>
                    <input type="text" class="form-control" name="existencia" id="existencia"style="width: 94%;"  readonly>
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
                        <th width="42%">
                            Articulo
                        </th>
                        <th width="41%">
                            Cantidad
                        </th>
                        <th width="9%">
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
                <div class="form-group">
                    <label>Observación:</label>
                    <textarea type="text" rows="2" class="form-control span12" name="txtDetalle" id="txtDetalle" placeholder="Escriba una observacion"></textarea>
                </div>
                <div class="form-group">
                    <label>Adjuntos: </label>
                    <input type="file"  class="form-control file span12"  name="txtArchivo[]" id="txtArchivo" multiple="true"/>
                </div>
            <div class="form-actions">
                <button type="button" id="cancelar" name="cancelar" onClick="location.href='?mod=ibodega'" class="btn btn-danger pull-left">Cancelar</button>
                <button type="submit" id="guardar" name="guardar" class="btn btn-primary pull-right">Guardar</button>
            </div>
            </form>  
        </div>

    </div>
</div>
<div class="span5">
    <div class="box">
        <div class="box-header">
            <h2><i class="halflings-icon white signal"></i><span class="break"></span>Existencia de articulos en bodega</h2>
            <div class="box-icon">
                <a href="#" data-rel="tooltip" title="Minimizar" class="btn-minimize"><i class="halflings-icon white chevron-up"></i></a>
            </div>
        </div>
        <div class="box-content">
            <div class="table-responsive">
                <table class="table table-striped table-bordered table-hover bootstrap-datatable datatable-basic">
                <thead class="ticket blue">
                <tr>
                    <th>
                         N°
                    </th>
                    <th>
                        Articulo
                    </th>
                    <th>
                        Existencia
                    </th>
                </tr>
                </thead>
<?php
                $cont = 1;  
                $response = $dataTable->obtener_Articulos_Existencia($_SESSION["id_dependencia"]); 
?>
                <tbody>
<?php    
                foreach($response['items'] as $datos){
                    $color = ($datos['existencia'] == 'Agotado') ? 'class="text-red"':'class="text-blue"';
?>
                <tr>
                    <td>
                        <?php echo $cont ?>
                    </td>
                    <td>
                        <?php echo $datos['articulo'].' / '.$datos['marca'] ?>
                    </td>
                    <td class="center">
                        <span <?php echo $color ?>><?php echo $datos['existencia'] ?></span>
                    </td>
                </tr>
<?php  
                    $cont ++;
                } 
?>
                </tbody>
                </table>
            </div>
        </div>
    </div>

</div>
</div>

<!-- Ventana Modal para el cambio de estado del usuario -->
<div class="modal hide fade" id="modal_comprobante">
    <div class="modal-header">
        <button type="button" onClick="location.href='?mod=ibodega'" class="close" data-dismiss="modal">×</button>
        <h3>Comprobante de descargo de articulos</h3>
    </div>
    <div class="modal-body">
        <div id="versolicitud"></div>
        <iframe id="pdfSolicitud" src="" frameborder="0" width="100%" height="500px" scrolling="no"></iframe>
    </div>
    <div class="modal-footer">
        <button type="button" onClick="location.href='?mod=ibodega'" class="btn btn-danger pull-right" data-dismiss="modal">Cerrar</button>
    </div>
</div>
<script type="text/javascript">
// Funcion para almacenar los datos
$(document).ready(function () {
    $('#guardar').click(function () {
        $.validate({
            onSuccess : function(form) {
                var formulario = document.getElementById("frmBodega");
                var formData = new FormData(formulario);
                $.ajax({
                    url: "procesos/descargo_solicitud_bodega.php",
                    type: "POST",
                    dataType: "Json",
                    data: formData,
                    cache: false,
                    contentType: false,
                    processData: false
                }).done(function (response) {
                    if (response.success == true) {
                        $.post("reportes/rep_comp_descargo.php", 
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

// Cargar combo de usuarios asignados 
$(document).ready(function () {
    $.post("procesos/store_articulo_bodega_existencia.php", 
        function(data){
        var data=JSON.parse(data);
        var datos=data.items;
        var total=datos.length;
        $('#txtArticulo').select2("val","");
        var opciones='<option value="">Seleccione una opcion</option>';
        for(var i=0; i<total; i++){
            opciones+="<option value='"+datos[i].id_articulo+"'>"+datos[i].articulo+"</option>";
        }
        $('#txtArticulo').html(opciones);
    });         
});

// Funcion que nos permitira cargar el combo de la secciones dependiendo de la dependencia
function store_input(id_articulo){
    $.post("procesos/store_existencia_articulo.php", 
        {'id_articulo' : id_articulo},
        function(data){
        var existencia = JSON.parse(data);
        document.getElementById('existencia').value=existencia + " En existencia";
        $('#txtCantidad').attr('max',''+existencia+'');
    }); 
}

// Funcion para limitar cantidad de existencia
function limitar(cantidad){
    var existencia = document.getElementById("existencia").value;
    if (cantidad > parseInt(existencia)){
        document.getElementById("txtCantidad").value = '';
    }
}

// quitar articulos de tabla
function quitar(id){
    if(id!=""){
        $.ajax({
            url: "procesos/quitar_articulo_descargo_bodega.php",
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
                    opciones+="<tr><td width='8%'>"+n+"</td><td width='42%'>"+datos[i].articulo+"</td><td width='41%'>"+datos[i].cantidad+"</td><td width='6.8%'><a href='#' class='btn btn-danger' onclick='quitar("+datos[i].id_articulo+")'><i class='halflings-icon white trash'></i></a></td></tr>";
                }
                $('#detalle_solicitud').html(opciones);
            }else{
                $('#detalle_solicitud').html("");
            }
        });
    }
}

// añadir articulos a tabla
function add(){
    var articulo=$("#txtArticulo").val();
    var cantidad=$("#txtCantidad").val();
    var nombre= document.getElementById('txtArticulo').options[document.getElementById('txtArticulo').selectedIndex].text;
    if (articulo != '' && cantidad != '') {
        $.ajax({
            url: "procesos/agregar_articulo_descargo_bodega.php",
            type: "POST",
            dataType: "json",
            data: {"id_articulo": articulo, "articulo": nombre, "cantidad": cantidad}
        }).done(function(data){
            if(data.success){
                if(data.error==""){
                    total=data.items.length;
                    var datos=data.items;
                    var opciones;
                    var n=0;
                    if(total>0){
                        for(var i=0; i<total; i++){
                            n++;
                            opciones+="<tr><td width='8%'>"+n+"</td><td width='42%'>"+datos[i].articulo+"</td><td width='41%'>"+datos[i].cantidad+"</td><td width='6.8%'><a href='#' class='btn btn-danger' onclick='quitar("+datos[i].id_articulo+")'><i class='halflings-icon white trash'></i></a></td></tr>";
                        }
                        $('#detalle_solicitud').html(opciones);
                    }else{
                         $('#detalle_solicitud').html("");
                    }            
                }else{
                    alert(data.error);
                }
            }else{
                alert(data.msg);
            }
        });
    }else{
        bootbox.alert('Ingrese articulos y cantidad a agregar', function() { });
    }
}
</script>