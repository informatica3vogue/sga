<div class="span12">
 <ul class="breadcrumb">   
        <a href="?mod=repositorio" class="icon-folder-open
        " data-toggle='modal'  title="Ir a repositorio">&nbsp;Ir a repositorio</a>
    </ul>

	    <div class="box">
        <div class="box-header">
            <h2><i class="halflings-icon white download-alt"></i><span class="break"></span>Ingresar repositorios</h2>
            <div class="box-icon">
                <a href="#" data-rel="tooltip" title="Minimizar" class="btn-minimize"><i class="halflings-icon white chevron-up"></i></a>
            </div>
        </div>
        <div class="box-content">
            <div class="table-responsive">
               <form action="" role="form" name="frmRepositorio" id="frmRepositorio" enctype="multipart/form-data" autocomplete="off" onsubmit="return false">

               	<div class="panel-body">
                <input type="hidden" id="txtId_Usuario" name="txtId_Usuario" disabled="true">
                <div class="form-group">
                    <label>Nombre repositorio: </label>
                    <input type="text" class="span12 form-control input-sm" name="txtAlias" id="txtAlias" placeholder="Escriba un alias para el o los adjuntos" data-validation="required" data-validation-error-msg="Rellene este campo">
                </div>
               <div class="form-group">
                    <label>Tipo de repositorio: </label>
                    <select class="form-control" name="txtTipo" id="txtTipo" style="width: 99%;">
                        <option selected value="Privado">Privado</option>
                        <option value="Compartido">Compartido</option>
                    </select>
                </div>

                    <div id="mostrar">
                  <label>Compartir con: </label>
                   <select style="width: 99%;" class="form-group" name="txtPara[]" id="txtPara"  multiple="true" data-placeholder="Seleccione usuarios a compartir archivos" data-validation="required" data-validation-error-msg="rellene este campo" ></select>
            </div>
                <div class="form-group">
                    <label>Descripción: </label>
                    <textarea rows="6" class="span12" name="txtDescripcion" id="txtDescripcion" placeholder="Escriba una descripcion"></textarea>
                </div>
                <div class="form-group">
                    <label>Adjuntos: </label>
                    <input type="file"  class="form-control file"  name="txtArchivo[]" id="txtArchivo" multiple="true" accept="application/msword, application/vnd.ms-excel, application/vnd.ms-powerpoint,text/plain, application/pdf, image/* " data-validation="required" data-overwrite-initial="false" data-validation-error-msg="rellene este campo"/>
                </div>
            </div>
            </div>
        </div>
             <div class="modal-footer">
                        <a href="?mod=irepositorio" class="btn btn-danger btn-movil pull-left" data-dismiss="modal">Cancelar</a>
                        <button type="submit" id="guardar" name="guardar" class="btn btn-primary btn-movil">Guardar</button>
                    </div>

               </form>
    </div>

</div>
<script type="text/javascript">
// Funcion para mostrar los campos de 'para' dependiendo del tipo de memorandum
$(document).ready(function () {
	 document.getElementById('mostrar').style.display = 'none'; 
    $('#txtTipo').click(function () {
        if (document.getElementById('txtTipo').value == 'Privado') {        
            document.getElementById('txtPara').value = '';
            document.getElementById('txtPara').disabled = true;
            document.getElementById('mostrar').style.display = 'none'; 

        } else if (document.getElementById('txtTipo').value == 'Compartido') {
            document.getElementById('txtPara').disabled = false;         
            document.getElementById('mostrar').style.display = 'block';  
          
        }
    });
});

// Funcion para almacenar los datos
$(document).ready(function () {
    $('#guardar').click(function () {
        $.validate({
            onSuccess : function(form) {
                var formulario = document.getElementById("frmRepositorio");
                var formData = new FormData(formulario);
                $.ajax({
                    url: "procesos/repositorio/agregar_repositorio.php",
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
                        if(response.success == true) {
                            $.alert(response.mensaje, { title: response.titulo, icon: 'circle-close', buttons: { 'Cerrar': function () { $(this).dialog("close"); location.href = "?mod=repositorio"; }}});  
                        }else{
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

//cargar combo de con conocimiento 
$(document).ready(function () {
    $.post("procesos/repositorio/store_cargar_usuarios.php", 
        function(data){
        var data=JSON.parse(data);
        var resultado=data.items;
        var total=resultado.length;
        var opciones;
        for(var i=0; i<total; i++){
            opciones+="<option value='"+resultado[i].id_usuario+"'>"+resultado[i].nombre_completo+"</option>";
        }
        $('#txtPara').html(opciones);
        $('#txtPara').select2();
    });         
});
</script>