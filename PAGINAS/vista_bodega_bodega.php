<span class="span12">
    <!-- start submenu -->
    <ul class="breadcrumb">
        <a href="?mod=compdescargos_bod" class="icon-check" title="Cargos y descargos de bodega">&nbsp;&nbsp;Cargos y descargos de bodega</a>&nbsp;&nbsp;&nbsp;|&nbsp;&nbsp;&nbsp;
        <a href="?mod=articulo_bodega" class="icon-shopping-cart" title="Ingresar nuevo artículo">&nbsp;&nbsp;Ingresar nuevo artículo</a>&nbsp;&nbsp;&nbsp;|&nbsp;&nbsp;&nbsp;
        <a href="?mod=ibodega" class="icon-minus-sign" title="Realizar descargo de articulo">&nbsp;Realizar descargo de articulo</a>&nbsp;&nbsp;&nbsp;|&nbsp;&nbsp;&nbsp;
        <a href="?mod=repbodegas" class="icon-file" title="Reportes de bodega">&nbsp;&nbsp;Reportes de bodega</a>
    </ul>
    <!-- end submenu-->
</span>
<div class="row-fluid">
<div class="span12">
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
                        Marca
                    </th>
                    <th>
                        Unidad de medida
                    </th>
                    <th>
                        Existencia
                    </th>
                    <th>
                        Accion
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
                        <?php echo $datos['articulo'] ?>
                    </td>
                    <td class="center">
                        <?php echo $datos['marca'] ?>
                    </td>
                    <td class="center">
                        <?php echo $datos['unidad_medida'] ?>
                    </td>
                    <td class="center">
                        <span <?php echo $color ?>><?php echo $datos['existencia'] ?></span>
                    </td>
                    <?php  $datos['articulo'] = $data->clearString($datos['articulo']);  ?>
                    <td class="center">
                        <a class="btn btn-warning" data-rel="tooltip" title='Agregar existencia al articulo' href="#" data-toggle='modal' data-target='#modal_existencia' onclick="cargar_articulo(<?php echo $datos['id_articulo'] ?>, '<?php echo $datos['articulo'] ?>');"> 
                            <i class="halflings-icon white plus"></i>
                        </a>
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


<form role="form" method="POST" name="frmExistencia" id="frmExistencia" onSubmit="return false" autocomplete="off">        
<div class="modal hide fade" id="modal_existencia">
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">×</button>
        <h3>Cargar existencia de: <span id="nombre_articulo" style="color:blue;"></span></h3>
    </div>
    <div class="modal-body">
        <div>                
            <input type="hidden" class="form-control" name="txtArticulo" id="txtArticulo" placeholder="" readonly="true">                       
        </div>
        <div class="form-group">
            <label>Cantidad: </label>
            <input type="number" min="0" max="100" class="form-control" name="txtCantidad" id="txtCantidad" placeholder="Escriba una cantidad" style="width: 97%;" data-validation="required" data-validation-error-msg="rellene este campo">
        </div>
        <div class="form-group">    
            <label>Referencia: </label>
            <input type="text" class="form-control" name="txtReferecia" id="txtReferecia" placeholder="Escriba una referencia" style="width: 97%;">
        </div>
        <div class="form-group">    
            <label>Observación:</label>
            <textarea class="form-control" name="txObservacion" id="txObservacion" placeholder="Escriba una observacion" style="width: 94%;"></textarea>
        </div>   
    </div>   
    <div class="modal-footer">
        <button type="reset" id="limpiar" name="limpiar" class="btn btn-primary pull-left">Limpiar</button>
        <button type="submit" id="guardar" name="guardar" class="btn btn-primary pull-right">Guardar</button>
    </div>
</div>
</form> 
<script type="text/javascript">
function cargar_articulo(id_articulo, articulo){
    $('#txtArticulo').val(id_articulo);
    $('#nombre_articulo').html(articulo);
}

// Funcion que nos permitira mandar los datos a ingresar
$(document).ready(function () {
    $('#guardar').click(function () {
        $.validate({
            onSuccess : function(form) {
                var formulario = $('#frmExistencia').serializeArray();
                $.ajax({
                    data: formulario,
                    type: 'POST',
                    dataType: "Json",
                    url: 'procesos/agregar_cargo_bodega.php',
                    beforeSend: function () {
                        $.blockUI({ message: '<h1><img src="img/loading.gif"/> Espere un momento...</h1>' });
                    },
                    success: function(response){
                        if(response.success == true) {
                            $('#modal_existencia').modal('hide');
                            $.alert(response.mensaje , { title: 'Operacion exitosa', icon: 'circle-check', buttons: { 'Aceptar': function () { $(this).dialog("close"); location.href ="?mod=cbodega"; }}});
                        }else{   
                            $('#modal_existencia').modal('hide');
                            $.alert(response.mensaje , { title: 'Verifique su informacion!', icon: 'circle-close', buttons: { 'Aceptar': function () { $(this).dialog("close"); $('#modal_existencia').modal('show'); }}});
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