<span class="span12">
 <!-- start submenu -->
    <ul class="breadcrumb">
        <a href="?mod=insumos" class="icon-edit" title="Ingresar solicitud de insumos">&nbsp;&nbsp;Ingresar solicitud de insumos</a>&nbsp;&nbsp;&nbsp;|&nbsp;&nbsp;&nbsp;
        <a href="?mod=vinsumos" class="icon-edit" title="Ver solicitudes de insumos">&nbsp;&nbsp;Ver solicitudes de insumos</a>&nbsp;&nbsp;&nbsp;|&nbsp;&nbsp;&nbsp;
        <a href="?mod=articulo" class="icon-edit" title="Cargar articulos">&nbsp;&nbsp;Cargar articulos</a>&nbsp;&nbsp;&nbsp;|&nbsp;&nbsp;&nbsp;
        <a href="?mod=repinsumo" class="icon-file" title="Reportes insumos">&nbsp;&nbsp;Reportes insumos</a>
    </ul>
    <!-- end submenu-->
</span>
<div class="row-fluid">
    <div class="span12">
        <div class="box">
            <div class="box-header">
                <h2><i class="halflings-icon white shopping-cart"></i><span class="break"></span>Ingresar nuevo articulo a bodega de insumos</h2>
                <div class="box-icon">
                    <a href="#" data-rel="tooltip" title="Minimizar" class="btn-minimize"><i class="halflings-icon white chevron-up"></i></a>
                </div>
            </div>
            <div class="box-content">
                    <form method="POST" name="frmArticulo" id="frmArticulo" autocomplete="off" enctype="multipart/form-data" onSubmit="return false">
                    <fieldset>
                        <div class="form-group span11">
                            <label>Marca: </label>
                            <select class="form-control" name="txtMarcas" id="txtMarcas">
                                <option value="">Selecciona una marca</option>
                            </select>
                        </div>
                        <div class="form-group span1">
                            <label>&nbsp;</label>
                            <a href="#" class="btn btn-success btn-block" data-toggle="modal" data-target="#modal_marca" data-rel="tooltip" title="Ingresar nueva marca"><i class="halflings-icon white plus"></i></a>
                        </div> 
                    </fieldset>
                    <fieldset>
                        <div class="form-group span11">
                            <label>Linea: </label>
                            <select class="form-control" name="txtLineas" id="txtLineas">
                                <option value="">Selecciona una Linea</option>
                            </select>
                        </div>
                        <div class="form-group span1">
                            <label>&nbsp;</label>
                            <a href="#" class="btn btn-success btn-block" data-toggle="modal" data-target="#modal_linea" data-rel="tooltip" title="Ingresar nueva linea"><i class="halflings-icon white plus"></i></a>
                        </div>
                        
                    </fieldset>
                    <fieldset>
                        <div class="form-group span11">
                            <label>Unidad: </label>
                            <select class="form-control" name="txtUnidades" id="txtUnidades">
                                <option value="">Selecciona un unidad</option>
                            </select>
                        </div>
                        <div class="form-group span1">
                            <label>&nbsp;</label>
                            <a href="#" class="btn btn-success btn-block" data-toggle="modal" data-target="#modal_unidad" data-rel="tooltip" title="Ingresar nueva unidad de medida"><i class="halflings-icon white plus"></i></a>
                        </div>
                    </fieldset>
                    <div class="form-group">
                        <label>Articulo:</label>
                        <input type="text" class="form-control" name="txtArticulo" id="txtArticulo" onkeyup="javascript:this.value = this.value.toUpperCase();" placeholder="Escriba nombre de articulo" style="width: 97%;" data-validation="required" data-validation-error-msg="rellene este campo">
                    </div>
                    <div class="form-group">
                        <label>Descripción:</label>
                        <textarea class="form-control" name="txtDescripcion" id="txtDescripcion" placeholder="Escriba una descripcion" style="width: 94%;"></textarea>
                    </div>
                    <div>
                        <input type="hidden" id="txtId" name="txtId" disabled="true">
                        <div style="height: 47px;"></div>
                    </div>
                    <div class="form-actions">
                        <button type="reset" id="limpiar" name="limpiar" class="btn btn-primary pull-left">Limpiar</button>
                        <button type="submit" id="guardar" name="guardar" class="btn btn-primary pull-right">Guardar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<div class="modal hide fade" id="modal_marca">
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">×</button>
        <h3>Ingreso de nueva marca</h3>
    </div>
    <div class="modal-body">
        <form role="form" method="POST" autocomplete="off" name="frmMarca" id="frmMarca" onSubmit="return false">
            <div class="form-group">
                <label>Marca:</label>
                <input type="text" class="form-control" name="txtMarca" id="txtMarca" onkeyup="javascript:this.value = this.value.toUpperCase();" placeholder="Escriba una marca" data-validation="required" data-validation-error-msg="rellene este campo">
            </div>      
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-danger pull-left" data-dismiss="modal">Cancelar</button>
            <button type="submit" id="guardar_marca" name="guardar_marca" class="btn btn-primary">Guardar</button>
        </div>
    </form>
</div>

<div class="modal hide fade" id="modal_linea">
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">×</button>
        <h3>Ingreso de nueva linea</h3>
    </div>
    <div class="modal-body">
        <form role="form" method="POST" autocomplete="off" name="frmLinea" id="frmLinea" onSubmit="return false">
            <div class="form-group">
                <label>Linea:</label>
                <input type="text" class="form-control" name="txtLinea" id="txtLinea" onkeyup="javascript:this.value = this.value.toUpperCase();" placeholder="Escriba una linea" data-validation="required" data-validation-error-msg="rellene este campo">
            </div>      
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-danger pull-left" data-dismiss="modal">Cancelar</button>
            <button type="submit" id="guardar_linea" name="guardar_linea" class="btn btn-primary">Guardar</button>
        </div>
    </form>
</div>

<div class="modal hide fade" id="modal_unidad">
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">×</button>
        <h3>Ingreso de nueva unidad de medida</h3>
    </div>
    <div class="modal-body">
        <form role="form" method="POST" autocomplete="off" name="frmUnidad" id="frmUnidad" onSubmit="return false">
            <div class="form-group">
                <label>Unidad de medida:</label>
                <input type="text" class="form-control" name="txtUnidad" id="txtUnidad" onkeyup="javascript:this.value = this.value.toUpperCase();" placeholder="Escriba una unidad de medida" data-validation="required" data-validation-error-msg="rellene este campo">
            </div>      
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-danger pull-left" data-dismiss="modal">Cancelar</button>
            <button type="submit" id="guardar_unidad" name="guardar_unidad" class="btn btn-primary">Guardar</button>
        </div>
    </form>
</div>
<script type="text/javascript">
//Funcion para cargar el formulario y modificar la linea
function modificar_articulo(id_articulo, articulo, descripcion, id_marca, id_linea, id_unidad) {
    document.getElementById('txtId').disabled = false;
    document.getElementById('txtId').value = id_articulo;     
    document.getElementById('txtArticulo').value = articulo;        
    document.getElementById('txtDescripcion').value = descripcion;
    document.getElementById('txtMarcas').value = id_marca;
    document.getElementById('txtLineas').value = id_linea;
    document.getElementById('txtUnidades').value = id_unidad;  
}

// Funcion que nos permitira mandar los datos a ingresar
$(document).ready(function () {
    $('#guardar').click(function () {
        $.validate({
            onSuccess : function(form) {
                var formulario = $('#frmArticulo').serializeArray();
                $.ajax({
                    data: formulario,
                    type: 'POST',
                    dataType: "Json",
                    url: 'procesos/insumos/guardar_articulo.php',
                    beforeSend: function () {
                        $.blockUI({ message: '<h1><img src="img/loading.gif"/> Espere un momento...</h1>' });
                    },
                    success: function(response){
                        if(response.success == true) {
                            $.alert(response.mensaje , { title: 'Operacion exitosa', icon: 'circle-check', buttons: { 'Aceptar': function () { $(this).dialog("close"); location.href = "?mod=cinsumos"; }}});
                        }else{   
                            $.alert(response.mensaje , { title: 'Verifique su informacion!', icon: 'circle-close', buttons: { 'Aceptar': function () { $(this).dialog("close"); }}});
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

// Funcion que nos guardar la linea
$(document).ready(function () {
    $('#guardar_unidad').click(function () {
        $.validate({
            onSuccess : function(form) {
                var formulario = $('#frmUnidad').serializeArray();
                $.ajax({
                    type: 'POST',
                    dataType: 'json',
                    url: 'procesos/insumos/guardar_unidad.php',
                    data: formulario,
                }).done(function (response) {
                    if(response.success == true) {
                        $('#modal_unidad').modal('hide');
                        $.alert(response.mensaje , { title: 'Operacion exitosa', icon: 'circle-check', buttons: { 'Aceptar': function () { $(this).dialog("close"); store_unidad(response.id_unidades); }}});
                    }else{   
                        $('#modal_unidad').modal('hide');
                        $.alert(response.mensaje , { title: 'Verifique su informacion!', icon: 'circle-close', buttons: { 'Aceptar': function () { $(this).dialog("close");  $('#modal_unidad').modal('show'); }}});
                    }
                });
            }
        });
    });
});

// Funcion que nos guardar la linea
$(document).ready(function () {
    $('#guardar_linea').click(function () {
        $.validate({
            onSuccess : function(form) {
                var formulario = $('#frmLinea').serializeArray();
                $.ajax({
                    type: 'POST',
                    dataType: 'json',
                    url: 'procesos/insumos/guardar_linea.php',
                    data: formulario,
                }).done(function (response) {
                    if(response.success == true) {
                        $('#modal_linea').modal('hide');
                        $.alert(response.mensaje , { title: 'Operacion exitosa', icon: 'circle-check', buttons: { 'Aceptar': function () { $(this).dialog("close"); store_linea(response.id_lineas); }}});
                    }else{   
                        $('#modal_linea').modal('hide');
                        $.alert(response.mensaje , { title: 'Verifique su informacion!', icon: 'circle-close', buttons: { 'Aceptar': function () { $(this).dialog("close"); $('#modal_linea').modal('show'); }}});
                    }
                });
            }
        });
    });
});

// Funcion que nos guardar la marca
$(document).ready(function () {
    $('#guardar_marca').click(function () {
        $.validate({
            onSuccess : function(form) {
                var formulario = $('#frmMarca').serializeArray();
                $.ajax({
                    type: 'POST',
                    dataType: 'json',
                    url: 'procesos/insumos/guardar_marca.php',
                    data: formulario,
                }).done(function (response) {
                    if(response.success == true) {
                        $('#modal_marca').modal('hide');
                        $.alert(response.mensaje , { title: 'Operacion exitosa', icon: 'circle-check', buttons: { 'Aceptar': function () { $(this).dialog("close"); store_marca(response.id_marcas); }}});
                    }else{   
                        $('#modal_marca').modal('hide');
                        $.alert(response.mensaje , { title: 'Verifique su informacion!', icon: 'circle-close', buttons: { 'Aceptar': function () { $(this).dialog("close"); $('#modal_marca').modal('show'); }}});
                    }
                });
            }
        });
    });
});

// Funcion que nos permitira cargar el combo
function store_marca(id_marcas) {
   var miselect = $('#txtMarcas');
   miselect.empty();
   miselect.find('option').remove().end().append('<option value="">Seleccione una marca</option>').val('');
   $.post("procesos/insumos/store_marca.php", 
     function (data) {
      var datos = data.items;
       for (var i = 0; i < data.total; i++) {
            if (id_marcas == datos[i].id_marca) {
                miselect.append('<option selected value="' + datos[i].id_marca + '">' + datos[i].marca + '</option>');
            }else{
               miselect.append('<option value="' + datos[i].id_marca + '">' + datos[i].marca + '</option>');
            }
       }
 }, 'json');
}
$(document).ready(function () {
    store_marca(0);
});

// Funcion que nos permitira cargar el combo de
function store_linea(id_lineas) {
   var miselect = $('#txtLineas');
   miselect.empty();
   miselect.find('option').remove().end().append('<option value="">Seleccione una linea</option>').val('');
   $.post("procesos/insumos/store_linea.php", 
     function (data) {
      var datos = data.items;
       for (var i = 0; i < data.total; i++) {
            if (id_lineas == datos[i].id_linea) {
                miselect.append('<option selected value="' + datos[i].id_linea + '">' + datos[i].linea + '</option>');
            }else{
               miselect.append('<option value="' + datos[i].id_linea + '">' + datos[i].linea + '</option>');
            }
       }
 }, 'json');
}
$(document).ready(function () {
    store_linea(0);
});

// Funcion que nos permitira cargar el combo de
function store_unidad(id_unidades) {
   var miselect = $('#txtUnidades');
   miselect.empty();
   miselect.find('option').remove().end().append('<option value="">Seleccione una unidad de medida</option>').val('');
   $.post("procesos/insumos/store_unidad.php", 
     function (data) {
      var datos = data.items;
       for (var i = 0; i < data.total; i++) {
            if (id_unidades == datos[i].id_unidad) {
                miselect.append('<option selected value="' + datos[i].id_unidad + '">' + datos[i].unidad_medida + '</option>');
            }else{
               miselect.append('<option value="' + datos[i].id_unidad + '">' + datos[i].unidad_medida + '</option>');
            }
       }
 }, 'json');
}
$(document).ready(function () {
    store_unidad(0);
});
</script>