<span class="span12">
    <!-- start submenu -->
 <ul class="breadcrumb">    
   <a href="?mod=vinsumos" class="icon-edit" title="Solicitudes">&nbsp;Solicitudes insumos</a>&nbsp;&nbsp;&nbsp;|&nbsp;&nbsp;&nbsp; 
    <a href="?mod=insumos" class="icon-edit" title="Ingresar solicitud de insumos">&nbsp;&nbsp;Ingresar solicitud de insumos</a>&nbsp;&nbsp;&nbsp;|&nbsp;&nbsp;&nbsp;
    <a href="?mod=cinsumos" class="icon-edit" title="Ingresar articulos">&nbsp;&nbsp;Ingresar articulos</a>&nbsp;&nbsp;&nbsp;|&nbsp;&nbsp;&nbsp;
    <a href="?mod=articulo" class="icon-edit" title="Cargar articulos">&nbsp;&nbsp;Cargar articulos</a>&nbsp;&nbsp;&nbsp;|&nbsp;&nbsp;&nbsp;
    <a href="?mod=repinsumo" class="icon-file" title="Reportes insumos">&nbsp;&nbsp;Reportes insumos</a>
</ul>
    <!-- end submenu-->
</span>
<div class="row-fluid">
<div class="span7">
    <div class="box">
        <div class="box-header">
            <h2><i class="halflings-icon white plus-sign"></i><span class="break"></span>Atender solicitud de usuario</h2>
            <div class="box-icon">
                <a href="#" data-rel="tooltip" title="Minimizar" class="btn-minimize"><i class="halflings-icon white chevron-up"></i></a>
            </div>
        </div>
        <div class="box-content">
               <form role="form" method="POST" name="frmInsumos" id="frmInsumos" autocomplete="off" enctype="multipart/form-data" onSubmit="return false">
                <div class="form-group span6">
                    <label>Articulo: </label>
                    <select class="form-control select2" name="txtArticulo" id="txtArticulo" data-placeholder="Seleccione un articulo" data-validation="required" data-validation-error-msg="rellene este campo" onchange="store_input($('#txtArticulo').val())">
                    </select>
                </div>
                <div class="form-group span2">
                    <label>Cantidad: </label>
                    <input type="number" class="form-control" min="0" name="txtCantidad" id="txtCantidad" placeholder="000000" style="width: 94%;" data-validation="required" data-validation-error-msg="rellene este campo" onkeyup="limitar(this.value)">
                </div>
                <div class="form-group span2">
                    <label>Existencia:</label>
                    <input type="text" class="form-control" name="existencia" id="existencia" placeholder="000000" style="width: 94%; color: blue;" readonly>
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
                <input type="hidden" id="txtId" name="txtId" value="<?php echo ($_GET['id']) ?>" hidden>
            <div class="form-actions">
                <button type="button" id="cancelar" name="cancelar" onClick="location.reload()" class="btn btn-danger pull-left">Cancelar</button>
                <button type="submit" id="guardar" name="guardar" class="btn btn-primary pull-right">Guardar</button>
            </div>
            </form>  
        </div>

    </div>
</div>
<div class="span5">
    <div class="box">
        <div class="box-header">
            <h2><i class="halflings-icon white signal"></i><span class="break"></span>Detalle solicitud</h2>
            <div class="box-icon">
                <a href="#" data-rel="tooltip" title="Minimizar" class="btn-minimize"><i class="halflings-icon white chevron-up"></i></a>
            </div>
        </div>
        <div class="box-content">
            <div class="span12"> 
                <label>Usuario: <span style="color: blue;" id="nombre"></span></label><br>      
                <label>Fecha solicitud: <span style="color: blue;" id="fecha"></span></label><br>
                <br>
            </div>
            <div class="table-responsive">
                <table class="table table-striped table-bordered table-hover">
                <thead class="ticket blue">
                <tr>
                    <th>
                         N°
                    </th>
                    <th>
                        Articulo
                    </th>
                    <th>
                        Cantidad
                    </th>
                </tr>
                </thead>
                <tbody id="detalle_descargos">
                </tbody>
                </table>
            </div>
        </div>
    </div>

</div>
</div>
<div class="modal hide fade" id="modal_comprobante">
    <div class="modal-header">
        <button type="button" onClick="location.href='?mod=vinsumos'" class="close" data-dismiss="modal">×</button>
        <h3>Comprobante de descargo de insumos</h3>
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
$(document).ready(function () {
    <?php unset($_SESSION["detalle_descargo"]) ?>
});

//Vista detalle solicitud por empleado
function getGET(){
    var loc = document.location.href;
    if(loc.indexOf('?')>0){
        var getString = loc.split('?')[1];
        var GET = getString.split('&');
        var get = {};
        for(var i = 0, l = GET.length; i < l; i++){
            var tmp = GET[i].split('=');
            get[tmp[0]] = unescape(decodeURI(tmp[1]));
        }
        return get;
    }
}

//Declaracion de variable global
var get = getGET();


window.onload = function(){
    $.ajax({
        type: "POST",
        dataType: 'json',
        url: "procesos/insumos/obtener_solicitud_empleado.php",
        data: get,
    }).done(function (response) {
        if(response.total > 0) {
            var array=response.items;
            document.getElementById('nombre').innerHTML = array[0]['nombre_completo'];
            document.getElementById('fecha').innerHTML = array[0]['fecha'];
            for(i=0; i<response.total; i++){
                document.getElementById('detalle_descargos').innerHTML +="<tr><td>"+(i+1)+"</td><td>"+array[i]['articulo']+"</td><td>"+array[i]['cantidad']+"</td><tr>";
            }  
        }else{
            
        }
    });
}


// Funcion que nos permitira cargar el combo 
function store_input(id_articulo){
    $.post("procesos/store_existencia_solicitud.php", 
        {'id_articulo' : id_articulo, 'id_solicitud_articulo' : get.id},
        function(data){
        var datos = JSON.parse(data);
        if (datos.existencia > 0) {
            document.getElementById('existencia').style.color='blue';
        }else{
            document.getElementById('existencia').style.color='red'; 
        }
        $('#txtCantidad').attr('max',''+datos.existencia+'');
        document.getElementById('txtCantidad').value=datos.cantidad;
        document.getElementById('existencia').value=datos.existencia;
    }); 
}

// Funcion para limitar cantidad de existencia
function limitar(cantidad){
    var existencia = document.getElementById("existencia").value;
    if (cantidad > parseInt(existencia)){
        document.getElementById("txtCantidad").value = '';
    }
}

//cargar 
$(document).ready(function () {
    $.post("procesos/store_articulo_solicitud.php", 
        {'id_solicitud_articulo':get.id},
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

//qutias articulos de tabla
function quitar(id){
    //incluir alert confirm y hacer accion en caso de YES
    if(id!=""){
        $.ajax({
            url: "procesos/quitar_articulo_descargo.php",
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
                    opciones+="<tr><td width='8%'>"+n+"</td><td width='42%'>"+data[i].articulo+"</td><td width='41%'>"+data[i].cantidad+"</td><td width='6.8%'><a href='#' onsubmit='return false' onclick='quitar("+data[i].id_articulo+")' class='btn btn-danger'><i class='halflings-icon white trash'></i></a></td></tr>";
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
    }else if(cantidad=="" || cantidad==0){
        alert('Ingrese una cantidad');
        $("#txtCantidad").focus();
    }else{
        $.ajax({
            url: "procesos/agregar_articulo_descargo.php",
            type: "POST",
            dataType: "json",
            data: {"id_articulo": articulo, "articulo": nombre, "cantidad": cantidad}
        }).done(function(data){
            //data=success = false ? msg : items
            if(data.success){
                if(data.error==""){
                    //longitud de arreglo
                    total=data.items.length;
                    //items
                    var datos=data.items;
                    var opciones;
                    var n=0;
                    if(total>0){
                        for(var i=0; i<total; i++){
                            n++;
                            opciones+="<tr><td width='8%'>"+n+"</td><td width='42%'>"+datos[i].articulo+"</td><td width='41%'>"+datos[i].cantidad+"</td><td width='6.8%'><a href='#' onsubmit='return false' onclick='quitar("+datos[i].id_articulo+")' class='btn btn-danger'><i class='halflings-icon white trash'></i></a></td></tr>";
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
    }
}

var datos= new Array();
// Funcion que nos permitira mandar los datos a ingresar
$(document).ready(function () {
    $('#guardar').click(function () {
        $.validate({
            onSuccess : function(form) {
                var formulario = $('#frmInsumos').serializeArray();
                $.ajax({
                    data: formulario,
                    type: 'POST',
                    dataType: "Json",
                    url: 'procesos/descargo_solicitud.php',
                    beforeSend: function () {
                        $.blockUI({ message: '<h1><img src="img/loading.gif"/> Espere un momento...</h1>' });
                    },
                    success: function(response){
                        if(response.success == true) {
                            $.alert(response.mensaje , { title: 'Operacion exitosa', icon: 'circle-check', buttons: { 'Aceptar': function () { $(this).dialog("close"); comprobante(response.id); document.getElementById('txtId').disabled = true; }}});
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

function comprobante(id){
    $.post("reportes/rep_descargo.php", 
    {'id' : id},
    function(data){
        var data=JSON.parse(data);
        if(data.success == true) {
            document.getElementById("pdfSolicitud").src = data.link;
            $('#modal_comprobante').modal('show');
        }else{
            document.getElementById('versolicitud').innerHTML=(data.error);
        }
    });       
}
</script>