<ul class="breadcrumb">
    <a href="?mod=memorandum" class="icon-folder-open" title="crear">&nbsp;Ir a memorándum</a>&nbsp;&nbsp;&nbsp;|&nbsp;&nbsp;&nbsp;
    <a href="?mod=memo_grupo" class="icon-folder-open" title="crear">&nbsp;Crear grupo para memorándum</a>&nbsp;&nbsp;&nbsp;
</ul>
    <div class="box">
        <div class="box-header">
            <h2><i class="halflings-icon white folder-open"></i><span class="break"></span>Grupos creados</h2>
            <div class="box-icon">
                <a href="#" data-rel="tooltip" title="Minimizar" class="btn-minimize"><i class="halflings-icon white chevron-up"></i></a>
            </div>
        </div>
        <div class="box-content">
            <div class="table-responsive">
                <table id="grupo_tabla" class="table table-striped table-bordered table-hover">
                <thead class="ticket blue">
                <tr>
                    <th width="5%">
                         N°
                    </th>
                    <th width="80%">
                        Nombre del grupo
                    </th>
                    <th width="15%">
                         Acciones
                    </th>
                </tr>
                </thead>
                <tbody id="grupo_tbody">
                </tbody>
                </table>
            </div>       
        </div>
    </div>
<!-- Modal remover empleados grupo-->
<div class="modal hide fade" id="modal_empleados_grupo">
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" onclick="reset()">×</button>
        <h3>Intregantes del grupo: <label style="color:blue;" id="txtGrupo"></label></h3>
    </div>
    <div class="modal-body">
        <!--Formulario de modal-->
           <div class="table-responsive">
                <table id="empleado_tabla" class="table table-striped table-bordered table-hover">
                <thead class="ticket blue">
                <tr id="emp_emp">
                    <th>
                         N°
                    </th>
                    <th>
                         Nombre completo
                    </th>
                </tr>
                </thead>
                <tbody id="empleado_tbody">    
                </tbody>
                </table>
         </div>
    </div>
    <div class="modal-footer">
        <button type="button" class="btn btn-danger" onclick="reset()" data-dismiss="modal">Cerrar</button>
    </div>
</div>
<!-- modal cambio nombre grupo-->
<div class="modal hide fade" id="modal_nombre_grupo">
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">×</button>
        <h3>Modificar nombre del grupo</h3>
    </div>
    <div class="modal-body"  style="overflow-x: hidden; overflow-y: auto;">
       <form role="form" method="POST" autocomplete="off" name="frmNombreGrupo" id="frmNombreGrupo" onSubmit="return false">
        <!--Formulario de modal-->
        <input type="hidden" class="form-control" name="txtIdGrupo" id="txtIdGrupo" readonly>     
         <input type="text" class="form-control" name="txtNombreGrupo" id="txtNombreGrupo" data-validation="required" data-validation-error-msg="rellene este campo">
    </div>
    <div class="modal-footer">
        <button type="button" class="btn btn-danger pull-left" data-dismiss="modal">Cancelar</button>
        <button type="submit" id="modificar_nombre" name="modificar_nombre" class="btn btn-primary">Guardar</button>
    </div>
</form>
</div>
<!-- <script type="text/javascript">
//funcion para mostrar tabla con los grupos  
$(document).ready(function() {
    var cont =1;
  $.ajax({
      url : 'procesos/memorandum/obtener_grupos.php',
      type: 'POST',
      dataType: 'json',
      success: function(response){
        if(response.success){
            $.each(response.items, function(index, value){ 
            $("#grupo_tbody").append("<tr><td>"+cont+"</td><td>"+value.grupo+"</td><td><form action='?mod=agregar_empleado_grupo' method='POST'><a style='margin-right: 2px;' class='btn btn-warning' data-toggle='modal' data-rel='tooltip' title='ver integrantes grupo' href='#' data-target='#modal_empleados_grupo' onclick=\"listar_empleado("+value.id_grupo+");\"'><i class='halflings-icon white  eye-open'></i></a><a style='margin-right: 2px;'class='btn btn-info' data-toggle='modal' data-rel='tooltip' title='Modificar nombre grupo' href='#' data-target='#modal_nombre_grupo' onclick=\"modificarNombreGrupo("+value.id_grupo+",'"+value.grupo+"');\"'><i class='halflings-icon white edit'></i></a><input type='hidden' name='id' value="+value.id_grupo+"><button type='submit' class='btn btn-success'><i class='halflings-icon white plus-sign'></button></form></td></tr>");
              cont++;
          });
        }
        $('#grupo_tabla').dataTable({
          "sDom": "<'row-fluid'<'span6'f><'span6'<'pull-right'l>>r>t<'row-fluid'<'span6'i><'span6'<'pull-right'p>>>",
          "sPaginationType": "bootstrap",
          "oLanguage": {
          "sInfo":"Mostrando _START_ a _END_ de _TOTAL_ registros",
          "sZeroRecords":"No se encontraron registros",
          "sLoadingRecords":"Cargando...",
          "sProcessing": "Procesando...",
          "sSearch": "Buscar por:",
          "sLengthMenu": "_MENU_ registros por pagina"
          }
        } );
      },
      error: function(){
        alert('hubo un error al ejecutar la accion');
      }
  });
});

//funcion para limpiar atabla
function reset(){
var Table = document.getElementById("empleado_tbody");
Table.innerHTML = "";
}

//funcion para mostrar tabla con los empleados de grupo
function listar_empleado(id_grupo){
    var cont =1;
      $.ajax({
          url : 'procesos/memorandum/obtener_empleados_grupo.php',
          type: 'POST',
          dataType: 'json',
          data: {"id_grupo": id_grupo},
          success: function(response){
            if(response.success){
                $('#empleado_tbody').html("");
                document.getElementById('txtGrupo').innerHTML = response.items[0]['grupo'];
                $.each(response.items, function(index, value){
                $("#empleado_tbody").append("<tr><td>"+cont+"</td><td>"+value.nombre_completo+"</td></tr>");
                cont++;
              });
            }
            /*
            $('#empleado_tabla').dataTable({
              "sDom": "<'row-fluid'<'span6'f><'span6'<'pull-right'l>>r>t<'row-fluid'<'span6'i><'span6'<'pull-right'p>>>",
              "sPaginationType": "bootstrap",
              "oLanguage": {
              "sInfo":"Mostrando _START_ a _END_ de _TOTAL_ registros",
              "sZeroRecords":"No se encontraron registros",
              "sLoadingRecords":"Cargando...",
              "sProcessing": "Procesando...",
              "sSearch": "Buscar por:",
              "sLengthMenu": "_MENU_ registros por pagina"
              }
            } );
          */
          },
          error: function(){
            alert('hubo un error al ejecutar la accion');
          }
      }); 
}

//Funcion para agregar id_grupo a modal cambio de nombre
function modificarNombreGrupo(id_grupo, grupo){
  document.getElementById('txtIdGrupo').value=id_grupo;
  document.getElementById('txtNombreGrupo').value = grupo;
}

//Funcion para modificar el nombre del grupo
$(document).ready(function() {   
       $('#modificar_nombre').click(function () {
        $.validate({
            onSuccess : function(form) {
                var formulario = $('#frmNombreGrupo').serializeArray();
                $.ajax({
                    type: 'POST',
                    dataType: 'json',
                    url: 'procesos/memorandum/modificar_nombre_grupo.php',
                    data: formulario,
                 }).done(function (response) {
                    if(response.success == true) {                        
                        $('#modal_nombre_grupo').modal('hide');
                        $.alert(response.mensaje,{ title: response.titulo, icon: 'circle-close', buttons: { 'Cerrar': function () { $(this).dialog("close"); location.href = "?mod=grupos_creados"; }}});
                    }else{   
                        $('#modal_nombre_grupo').modal('hide');
                        $.alert(response.mensaje,{ title: response.titulo, icon: 'circle-close', buttons: { 'Cerrar': function () { $(this).dialog("close"); }}});
                    }
                });
            }
        });
    });
}); 

//Funcion para cargar ventana modal 
function eliminar(id_empleado, id_grupo){
var parametros = {      
       "id_empleado": id_empleado,
       "id_grupo": id_grupo
   };      
        $.ajax({
            type: 'POST',
            dataType: 'json',
            data: parametros,
            url: 'procesos/memorandum/eliminar_empleado_grupo.php',
        }).done(function (response) {
            if(response.success == true) {
                 $('#modal_empleados_grupo').modal('hide');
                $.alert(response.mensaje,{ title: response.titulo, icon: 'circle-close', buttons: { 'Cerrar': function () { $(this).dialog("close"); location.href = "?mod=grupos_creados"; }}});                                            
            }else{
                $.alert(response.mensaje,{ title: response.titulo, icon: 'circle-close', buttons: { 'Cerrar': function () { $(this).dialog("close"); }}});
            }
        });    
};
</script> -->