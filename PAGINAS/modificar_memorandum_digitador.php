<?php 
if (isset($_GET['id'])) {
    $params =  $_GET;
    $sql = "SELECT memo.id_memorandum, memo.tipo_memorandum, IF(para='' OR para = null, '',para) AS para, memo.fecha_creacion, memo.de, memo.asunto, memo.descripcion, memo.con_copia FROM memorandum AS memo WHERE id_memorandum = :id";
    $param_list = array("id");
    $result = $data->query($sql, $params, $param_list);
    if ($result["total"] > 0) {
?>
<script type="text/javascript"> 
//cargar combo de con conocimiento 
$(document).ready(function () {
    var con_conocimiento = "<?php echo $result['items'][0]['con_copia'] ?>";
    $.post("procesos/memorandum/store_cargar_empleados.php", 
        function(data){
        var data=JSON.parse(data);
        var resultado=data.items;
        var total=resultado.length;
        var opciones='<option value="">Seleccione una opcion</option>';
        for(var i=0; i<total; i++){
            if (con_conocimiento == resultado[i].nombre_completo) {
                opciones+="<option selected='true' value='"+resultado[i].id_empleado+"'>"+resultado[i].nombre_completo+"</option>";
            }else{
                opciones+="<option value='"+resultado[i].nombre_completo+"'>"+resultado[i].nombre_completo+"</option>";
            }
        }
        $('#txtCopia').html(opciones);
        $('#txtCopia').select2();
    });         
});

//cargar combo de compartir
$(document).ready(function () {
    $.post("procesos/memorandum/store_empleados_seleccionados.php", 
        { "id_memorandum" : <?php echo $result['items'][0]['id_memorandum'] ?> }, 
        function(data){
        var data=JSON.parse(data);
        var resultado=data.items;
        var opciones='';
        for(var i=0; i<data.total; i++){
            opciones+="<option "+resultado[i].selected+" value='"+resultado[i].id_empleado+"'>"+resultado[i].nombre_completo+"</option>";
        }
        $('#txtPara_combo').html(opciones);+
        $('#txtPara_combo').select2();
    });    
});

// Funcion que nos permitira mandar los datos a ingresar 
$(document).ready(function () {
    $('#guardar').click(function () {
        $.validate({
            onSuccess : function(form) {
                var formulario = $('#frmMemo').serializeArray();
                $.ajax({
                    data: formulario,
                    type: 'POST',
                    dataType: "Json",
                    url: 'procesos/memorandum/guardar_memorandum.php',
                    beforeSend: function () {
                        $.blockUI({ message: '<h1><img src="img/loading.gif"/> Espere un momento...</h1>' });
                    },
                    success: function(response){
                        if (response.success == true) {
                            document.getElementById('titulo_modal').innerHTML=(response.mensaje);
                            $.post("reportes/memo_pdf.php", 
                            {'id' : response.id},
                            function(data){
                                var data=JSON.parse(data);
                                if(data.success == true) {
                                    document.getElementById('pdfMemorandum').src = data.url+'';
                                    document.getElementById('boton_modificar').innerHTML = ("<button type='button' class='btn btn-primary btn-movil pull-left' onClick=\"location.href='?mod=modmemo&id="+response.id+"'\" >Modificar</button>");
                                    $('#modal_memorandum').modal('show');
                                }else{
                                    document.getElementById('verMemorandum').innerHTML=(data.error);
                                }
                            });       
                        } else {
                            $.alert(response.mensaje,{ title: response.titulo, icon: 'circle-close', buttons: { 'Cerrar': function () { $(this).dialog("close"); }}});
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
<ul class="breadcrumb">
    <a href="?mod=memorandum" class="icon-folder-open" title="Permiso">&nbsp;Ir memorándum</a>
</ul>
<div class="row-fluid">
    <div class="box">
        <div class="box-header">
            <h2><i class="icon-bar-chart white list"></i><span class="break"></span>Memorándum Internos</h2>
            <div class="box-icon">
                <a href="#" class="btn-minimize" title="Minimizar"><i class="halflings-icon white chevron-up"></i></a>
            </div>
        </div>
        <div class="box-content">
            <div>
                <form role="form" method="POST" name="frmMemo" onsubmit="return false" id="frmMemo" autocomplete="off" enctype="multipart/form-data">
                    <input type="hidden" id="txtId" name="txtId" value="<?php echo($result['items'][0]['id_memorandum']); ?>">
                    <div class="form-group">
                        <input type="hidden" id="txtTipo" name="txtTipo" value="<?php echo ($result['items'][0]['tipo_memorandum'])?>" readonly>
                    </div>
                    <div class="form-group" id="mostrar">
                        <label>Para: </label>
                        <select style="width: 99%;" name="txtPara[]" id="txtPara_combo" multiple="multiple" class="form-control select2" data-placeholder="Seleccione un empleado" data-validation="required" data-validation-error-msg="rellene este campo">
                        </select>                        
                    </div>
                    <div class="form-group">
                        <input type="hidden" id="txtDe" name="txtDe" value="<?php echo ($result['items'][0]['de'])?>" readonly>
                    </div>
                    <div class="form-group">
                        <label>Asunto: </label>
                        <textarea type="text" rows="1" class="form-control" name="txtAsunto" id="txtAsunto" placeholder="Ingrese su asunto..." data-validation="required" data-validation-error-msg="rellene este campo"><?php echo($result['items'][0]['asunto']); ?>
                        </textarea>
                    </div>
                    <div class="form-group">
                        <label>Contenido:</label>
                        <textarea type="text" rows="5" class="cleditor" name="txtContenido" id="txtContenido" placeholder="Escriba el contenido del memorándum" data-validation="required" data-validation-error-msg="rellene este campo"><?php echo($result['items'][0]['descripcion']); ?>
                        </textarea>
                    </div>
                    <div class="form-group">
                            <label>C.C: </label>                                
                            <select class="form-control" style="width: 99.5%;" name="txtCopia" id="txtCopia" data-placeholder="Con conocimiento a" >
                            </select>                             
                        </div>
                    <div class="form-actions">
                        <button type="submit" id="guardar" name="guardar" class="btn btn-movil btn-primary pull-right">Guardar</button>
                        <button type="button" id="limpiar" onclick="window.location.reload(true);" name="limpiar" class="btn btn-movil btn-primary pull-left">Restablecer</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!--/span-->
</div>
<!-- Ventana Modal -->
<div class="modal hide fade" id="modal_memorandum" data-keyboard="false" data-backdrop="static">
    <div class="modal-header">
        <button type="button" onClick="location.href='?mod=memorandum'" class="close" data-dismiss="modal">×</button>
        <h3 id="titulo_modal"></h3>
    </div>
    <div class="modal-body" style="overflow: hidden;">
        <div id="verMemorandum"></div>
        <iframe id="pdfMemorandum" src="" frameborder="0" width="100%" height="425px" scrolling="no"></iframe>
    </div>
    <div class="modal-footer">
        <div id="boton_modificar"><!--boton para modificar memorandum--></div>
        <button type="button" onClick="location.href='?mod=memorandum'" class="btn btn-danger btn-movil pull-right" data-dismiss="modal">Cerrar</button>
    </div>
</div>
<?php
    }else{
        header('Location:?mod=memorandum');
    }
} else {
    header('Location:?mod=error');
}
?>