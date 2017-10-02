<div class="span12">
    <!-- start submenu -->
    <ul class="breadcrumb">   
        <a href="?mod=irepositorio" class="icon-plus" data-toggle='modal'  title="Ingresar repositorio">&nbsp;Ingresar repositorio</a>
    </ul>
    <!-- end submenu-->
    <div class="box">
        <div class="box-header">
            <h2><i class="halflings-icon white download-alt"></i><span class="break"></span>Mis repositorios</h2>
            <div class="box-icon">
                <a href="#" data-rel="tooltip" title="Minimizar" class="btn-minimize"><i class="halflings-icon white chevron-up"></i></a>
            </div>
        </div>
        <div class="box-content">
            <div class="table-responsive">
                <table class="table table-striped table-bordered table-hover bootstrap-datatable datatable">
                <thead class="ticket blue">
                <tr>
                    <th width="5%">
                         N°
                    </th>
                    <th width="15%">
                        Repositorio                       
                    </th>
                    <th width="10%">
                        Fecha de creaci&oacute;n
                    </th>
                    <th width="30%">
                         Descripci&oacute;n
                    </th>
                    <th width="15%">
                        tipo repositorio
                    </th>
                    <th width="15%">
                        Archivos
                    </th>
                    <th width="15%">
                        Acción
                    </th>
                    
                </tr>
                </thead>
<?php
                $cont = 1;  
                $response = $dataTable->obtener_Repositorios($_SESSION["id_usuario"], $_SESSION["id_dependencia"]); 
                if ($response["success"] != false) {
?>
                <tbody>
                <?php    
                    foreach($response['items'] as $datos){?>
                <tr>
                    <td>
                        <?php echo $cont ?>
                    </td>
                    <td>
                        <?php echo $datos['alias'] ?>
                    </td>
                    <td class="center">
                        <?php echo $datos['fecha_creacion'] ?>
                    </td>
                    <td class="center">
                        <?php echo $datos['observacion'] ?>
                    </td>
                    <td>
                        <?php                      
                        if ($datos["compartido"] != "") {
                            echo nl2br("<b>Compartido con:</b> \n ".$data->format_string($datos["compartido"]));
                        }else{
                            echo "<b>Privado</b>";
                        }
                        ?>
                    </td>
                    <td class="center">
<?php 
                        $sql = "SELECT documento, tipo FROM docu_repositorio WHERE id_repositorio = :id_repositorio";
                        $result = $data->query($sql, array('id_repositorio'=>$datos['id_repositorio']));
                        if ($result["total"] > 0) {
                            foreach($result['items'] as $documentos){ 
                                $archivo = substr($documentos['documento'], 0, 20).'.'.$documentos['tipo'];
?>
                                <a href='upload/repositorio/<?php echo $documentos['documento'] ?>' download data-rel="tooltip" title='<?php echo $archivo ?>'>
<?php                           if(file_exists('img/extensiones/'.$documentos['tipo'].'.png')){ 
?>
                                    <img src='img/extensiones/<?php echo $documentos['tipo'] ?>.png' width='36px' height='36px'> 
<?php                           }else{
?>   
                                    <img src='img/extensiones/none.png' width='36px' height='36px'> 
<?php                           } 
?>
                               </a>
<?php                       }  
                    }
                    ?>
                    <td>
                        <?php
                        if($datos['id_propietario']==$_SESSION["id_usuario"]){                           
                        ?>
                             <a class="btn btn-warning" href="#" data-rel="tooltip" title='Compartir con' data-toggle='modal' data-target='#modal_compartir' onclick="compartir_archivo(<?php echo $datos['id_repositorio'] ?>, '<?php echo $datos['alias'] ?>', '<?php echo $datos['tipo_repositorio'] ?>');">
                            <i class="halflings-icon white share-alt"></i>
                        </a>
                        <?php
                        }else{
                            echo nl2br("<b>Propietario:</b> \n ".$data->format_string($datos['propietario']));
                        }
                        ?>                   
                    </td>
<?php
    $cont ++;
}                     
                } 
?>
                    </td>                  
                </tr>
                </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<!-- Ventana Modal para compartir -->
<div class="modal hide fade" id="modal_compartir">
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">×</button>
        <h3>Compartir Archivo</h3>
    </div>
    <div class="modal-body"  style="overflow-x: hidden; overflow-y: auto;">
        <form role="form" method="POST" name="frmCompartir" id="frmCompartir" enctype="multipart/form-data" autocomplete="off" onsubmit="return false">
            <input type="hidden" id="txtId" name="txtId">
            <div class="form-group">
                <label>Nombre Repositorio:</label>
                <input type="text" class="form-control" name="txtNombreArchivo" id="txtNombreArchivo" readonly style="width: 95%;">
            </div>
           <div class="form-group">
                <label>Cambio de estado: </label>
                <select class="form-control" name="txtTipo" id="txtTipo" style="width: 99%;">
                    <option selected value="1">Privado</option>
                    <option value="2">Compartido</option>
                </select>
            </div>
           <div id="mostrar">
           <label>Compartir con: </label>
           <select style="width: 98%;" class="form-group" name="txtPara[]" id="txtPara"  multiple="true" data-placeholder="Seleccione usuarios a compartir archivos" data-validation="required" data-validation-error-msg="rellene este campo" ></select>
          </div>  
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-danger btn-movil pull-left" data-dismiss="modal">Cancelar</button>
            <button type="submit" id="modificar_estado" name="modificar_estado" class="btn btn-movil btn-primary">Guardar</button>
        </div>
    </form>
</div>
<script type="text/javascript">
// Funcion para almacenar los datos
$(document).ready(function () {
    $('#modificar_estado').click(function () {
        $.validate({
            onSuccess : function(form) {
                var formulario = document.getElementById("frmCompartir");
                var formData = new FormData(formulario);
                $.ajax({
                    url: "procesos/repositorio/agregar_archivos_compartidos.php",
                    type: "POST",
                    dataType: "Json",
                    data: formData,
                    cache: false,
                    contentType: false,
                    processData: false
                }).done(function (response) {
                    if(response.success == true) {                      
                        $('#modal_compartir').modal('hide');
                        $.alert(response.mensaje, { title: 'Operacion exitosa', icon: 'circle-check', buttons: { 'Aceptar': function () { $(this).dialog("close"); location.href = "?mod=repositorio"; }}});
                    }else{                   
                        $('#modal_compartir').modal('hide');
                        $.alert(response.mensaje, { title: response.titulo, icon: 'circle-close', buttons: { 'Cerrar': function () { $(this).dialog("close"); $('#modal_compartir').modal('show'); }}});
                    }
                });
            }
        });
    });
});

//Funcion para cargar los campos de la ventana modal
function compartir_archivo(id, titulo, tipo) {
    tipo = (tipo=='Privado') ? 1 : 2;
    cargar_usuarios(id);
    if (tipo==2) {
        document.getElementById('txtPara').disabled = false;         
        document.getElementById('mostrar').style.display = 'block';
    };
    document.getElementById('txtId').value = id;
    document.getElementById('txtTipo').value = tipo;
    document.getElementById('txtNombreArchivo').value =titulo;    
}

$(document).ready(function () {
    document.getElementById('mostrar').style.display = 'none';  
    $('#txtTipo').click(function () {
        if (document.getElementById('txtTipo').value == 1) {        
            document.getElementById('txtPara').value = '';
            document.getElementById('txtPara').disabled = true;
            document.getElementById('mostrar').style.display = 'none'; 

        } else if (document.getElementById('txtTipo').value == 2) {
            document.getElementById('txtPara').disabled = false;         
            document.getElementById('mostrar').style.display = 'block';
        }
    });
});

//cargar combo de compartir
function cargar_usuarios(id_repositorio){
    $.post("procesos/repositorio/store_usuarios_seleccionados.php",
        {'id_repositorio' : id_repositorio},
        function(data){
        var data=JSON.parse(data);
        var resultado=data.items;
        var total=resultado.length;
        var opciones;
        for(var i=0; i<total; i++){
            opciones+="<option "+resultado[i].selected+" value='"+resultado[i].id_usuario+"'>"+resultado[i].nombre_completo+"</option>";
        }
        $('#txtPara').html(opciones);
        $('#txtPara').select2();
    });         
}
</script>