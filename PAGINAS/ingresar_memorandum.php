<script type="text/javascript"> 
//cargar combo de compartir
$(document).ready(function () {
    var nombre_completo = "<?php echo $_SESSION['nombre'].' / '.$_SESSION['cargo'] ?>";
    $.post("procesos/memorandum/store_cargar_empleados.php",
        function(data){
        var data=JSON.parse(data);
        var resultado=data.items;
        var total=resultado.length;
        var opciones='<option value="">Seleccione empleado</option>';
        for(var i=0; i<total; i++){
            if (nombre_completo == resultado[i].nombre_completo) {
                opciones+="<option selected value='"+resultado[i].nombre_completo+"'>"+resultado[i].nombre_completo+"</option>";
            }else{
                opciones+="<option value='"+resultado[i].nombre_completo+"'>"+resultado[i].nombre_completo+"</option>";
            }
        }
        $('#txtDe').html(opciones);
        $('#txtDe').select2();
    });           
});

//cargar combo empleados y grupos
$(document).ready(function () {
    $.post("procesos/memorandum/store_cargar_grupos_empleados.php",
        function(data){
        var data=JSON.parse(data);     
        var resultado=data;
        var total=resultado.length;
        var opciones='<option value="">Seleccione Empleado</option>';
        for(var i=0; i<total; i++){
            for(var j=0; j < resultado[i].length; j++){
                if(j==0){
                    if(resultado[i][j].tipo=="empleado"){
                        opciones+="<optgroup label='Empleados'>";
                    }else if(resultado[i][j].tipo=="grupo"){
                        opciones+="<optgroup label='Grupos'>";
                    }
                        opciones+="</optgroup>";
                }
                opciones+="<option value='"+resultado[i][j].id+"-"+resultado[i][j].tipo+"'>"+resultado[i][j].nombre+"</option>";
            }
        }
         $('#txtPara_combo').html(opciones);
        $('#txtPara_combo').select2();
    });         
});

//cargar combo de C.C
$(document).ready(function () {
    $.post("procesos/memorandum/store_cargar_empleados.php",
        function(data){
        var data=JSON.parse(data);
        var resultado=data.items;
        var total=resultado.length;
         var opciones='<option value="">Seleccione Empleado</option>';
        for(var i=0; i<total; i++){
            opciones+="<option value='"+resultado[i].nombre_completo+"'>"+resultado[i].nombre_completo+"</option>";
        }
        $('#txtCopia').html(opciones);
        $('#txtCopia').select2();
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
                    url: 'procesos/memorandum/agregar_memorandum.php',
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
                                document.getElementById('boton_modificar').innerHTML = ("<button type='button' class='btn btn-primary pull-left' onClick=\"location.href='?mod=modmemo&id="+response.id+"'\" >Modificar</button>");
                                $('#modal_memorandum').modal('show');
                            }else{
                                document.getElementById('verMemorandum').innerHTML=(data.error);
                            }
                        });       
                    } else {
                        $.alert(response.mensaje,{ title: response.titulo, icon: 'circle-close', buttons: { 'Cerrar': function () { $(this).dialog("close"); location.href = "?mod=memorandum"; }}});
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

//Limpiara los combobox al dar clic sobre el boton limpiar
$(document).ready(function () {
    $('#limpiar').click(function () {
        combo_de(false);
        $('#validar_de').hide();
        $('#validar_para').hide();
        document.getElementById('txtId').disabled = true;
        document.getElementById('txtPara_text').disabled = true;
        document.getElementById('txtPara_combo').disabled = false;
        document.getElementById('txtPara_combo').disabled = false;
        document.getElementById('mostrar').style.display = 'block';  
        document.getElementById('ocultar').style.display = 'none';   
    });
});

// Funcion para mostrar los campos de 'para' dependiendo del tipo de memorandum
$(document).ready(function () {
    $('#txtPara_text').attr("disabled", "disabled");
    $('#txtTipo').click(function () {
        if (document.getElementById('txtTipo').value == 'Interno') {
            document.getElementById('txtPara_text').value = '';
            document.getElementById('txtPara_text').disabled = true;
            document.getElementById('txtPara_combo').disabled = false;
            document.getElementById('mostrar').style.display = 'block';  
            document.getElementById('ocultar').style.display = 'none';   
        } else if (document.getElementById('txtTipo').value == 'Externo') {
            document.getElementById('txtPara_combo').value = '';
            document.getElementById('txtPara_combo').disabled = true;
            document.getElementById('txtPara_text').disabled = false;
            document.getElementById('mostrar').style.display = 'none';  
            document.getElementById('ocultar').style.display = 'block';  
        }
    });
});

</script> 
<ul class="breadcrumb"> 
    <a href="?mod=memorandum" class="icon-folder-open" title="Permiso">&nbsp;Ir memorándum</a> 
</ul>
<div class="row-fluid">
            <div class="box">
                <div class="box-header">
                    <h2><i class="icon-bar-chart white list"></i><span class="break"></span>Crear Memorándum</h2>
                    <div class="box-icon">                        
                        <a href="#" class="btn-minimize" title="Minimizar"><i class="halflings-icon white chevron-up"></i></a>
                    </div>
                </div>
                <div class="box-content">
                <div>
                        <form role="form" method="POST" name="frmMemo" onSubmit="return false" id="frmMemo" autocomplete="off" enctype="multipart/form-data">                  
                            <input type="hidden" id="txtId" name="txtId" disabled="true">
                            <div class="form-group">
                                <label>Tipo de memorándum: </label>
                                <select class="form-control" name="txtTipo" id="txtTipo" style="width: 99%;">
                                    <option selected value="Interno">Interno</option>
                                    <option value="Externo">Externo</option>
                                </select>
                            </div>    
                            <div class="form-group" id="mostrar">
                            <label>Para: </label>
                                <select class="form-control select2" style="width: 98%;" name="txtPara[]" id="txtPara_combo" multiple="true" data-placeholder="Seleccione empleado" data-validation="required" data-validation-error-msg="rellene este campo">
                                </select> 
                            </div>
                            <div class="form-group" id="ocultar">               
                                <label>Para:</label>
                                <textarea type="text" rows="2" class="form-control" name="txtPara" id="txtPara_text" placeholder="Ingrese destino..." data-validation="required" data-validation-error-msg="rellene este campo"></textarea>
                            </div>
                            <div class="form-group">
                                <label>De: </label>
                                <select  name="txtDe" id="txtDe" style="width: 99%;" class="form-control select2" data-placeholder="Seleccione un empleado" data-validation="required" data-validation-error-msg="rellene este campo">                             
                                    </select>                                    
                            </div>
                            <div class="form-group">
                                <label>Asunto: </label>
                                <textarea type="text" rows="1" class="form-control" style="width: 97.5%;" name="txtAsunto" id="txtAsunto" placeholder="Ingrese su asunto..." data-validation="required" data-validation-error-msg="rellene este campo"></textarea>
                           </div>
                           <div class="form-group">
                                <label>Contenido:</label>
                                <textarea class="cleditor" name="txtContenido" id="txtContenido" rows="3" data-validation="required" data-validation-error-msg="rellene este campo"></textarea>
                           </div>
                           <div class="form-group">
                                <label>C.C: </label>
                                <select class="form-control" style="width: 99.5%;" name="txtCopia" id="txtCopia" data-placeholder="Con conocimiento a">
                                </select>
                            </div>              
                           <div class="form-actions">
                            <button href="?mod=imemo"  class="btn btn-movil btn-primary">Limpiar</button>
                            <button type="submit" id="guardar" name="guardar" class="btn btn-primary pull-right">Guardar</button>
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
        <button type="button" onClick="location.href='?mod=memorandum'" class="btn btn-danger pull-right" data-dismiss="modal">Cerrar</button>
    </div>
</div>