<div class="span12">
        <!-- start submenu -->
    <ul class="breadcrumb">
        <a href="?mod=articulo_bodega" class="icon-shopping-cart" title="Ingresar nuevo artículo">&nbsp;&nbsp;Ingresar nuevo artículo</a>&nbsp;&nbsp;&nbsp;|&nbsp;&nbsp;&nbsp;
        <a href="?mod=cbodega" class="icon-plus-sign" title="Cargar existencia de articulo">&nbsp;&nbsp;Cargar existencia de articulo</a>&nbsp;&nbsp;&nbsp;|&nbsp;&nbsp;&nbsp;
        <a href="?mod=ibodega" class="icon-minus-sign" title="Realizar descargo de articulo">&nbsp;Realizar descargo de articulo</a>&nbsp;&nbsp;&nbsp;|&nbsp;&nbsp;&nbsp;
        <a href="?mod=repbodegas" class="icon-file" title="Reportes de bodega">&nbsp;&nbsp;Reportes de bodega</a>
    </ul>
    <!-- end submenu-->
    <div class="box">
        <div class="box-header">
            <h2><i class="halflings-icon white plus-sign"></i><span class="break"></span>Cargos de articulos de bodega</h2>
            <div class="box-icon">
                <a href="#" data-rel="tooltip" title="Minimizar" class="btn-minimize"><i class="halflings-icon white chevron-up"></i></a>
            </div>
        </div>
        <div class="box-content">
            <div class="table-responsive">
                <table class="table table-striped table-bordered table-hover bootstrap-datatable datatable">
                <thead class="ticket blue">
                <tr>
                    <th>
                         N°
                    </th>
                    <th>
                         Fecha cargo
                    </th>
                    <th>
                         Articulo
                    </th>
                    <th>
                         Cantidad
                    </th>
                    <th>
                         Referencia
                    </th>
                    <th>
                         Observaci&oacute;n
                    </th>
                    <th>
                         Usuario
                    </th>
                </tr>
                </thead>
<?php
                $cont = 1;  
                $response = $dataTable->obtener_Cargos_Bodega($_SESSION["id_dependencia"]); 
?>
                <tbody>
                <?php    
                    foreach($response['items'] as $datos){?>
                <tr>
                    <td>
                        <?php echo $cont ?>
                    </td>
                    <td>
                        <?php echo $datos['fecha'] ?>
                    </td>
                    <td>
                        <?php echo $datos['articulo'] ?>
                    </td>
                    <td class="center">
                        <?php echo $datos['cantidad'] ?>
                    </td>
                    <td class="center">
                        <?php echo $datos['referencia'] ?>
                    </td>
                    <td class="center">
                        <?php echo $datos['observacion'] ?>
                    </td>
                    <td>
                        <?php echo $datos['nombre'] ?>
                    </td>
                </tr>
                <?php  
$cont ++;
} ?>
                </tbody>
                </table>
            </div>
        </div>
    </div>
     <div class="box">
        <div class="box-header">
            <h2><i class="halflings-icon white minus-sign"></i><span class="break"></span>Descargos de articulos de bodega</h2>
            <div class="box-icon">
                <a href="#" data-rel="tooltip" title="Minimizar" class="btn-minimize"><i class="halflings-icon white chevron-up"></i></a>
            </div>
        </div>
        <div class="box-content">
            <div class="table-responsive">
                <table class="table table-striped table-bordered table-hover bootstrap-datatable datatable">
                <thead class="ticket blue">
                <tr>
                    <th>
                         N°
                    </th>
                    <th>
                         Fecha descargo
                    </th>
                    <th>
                         Observaci&oacute;n
                    </th>
                    <th>
                         Adjunto
                    </th>
                    <th>
                         Usuario
                    </th>
                    <th>
                        Accion
                    </th>
                </tr>
                </thead>
<?php
                $cont = 1;  
                $response = $dataTable->obtener_Descargos_Bodega($_SESSION["id_dependencia"]); 
?>
                <tbody>
                <?php    
                    foreach($response['items'] as $datos){
?>
                <tr>
                    <td>
                        <?php echo $cont ?>
                    </td>
                    <td>
                        <?php echo $datos['fecha'] ?>
                    </td>
                    <td class="center">
                        <?php echo $datos['observacion'] ?>
                    </td>
                    <td class="center">
                       <?php 
                        $sql = "SELECT documento, tipo FROM docu_bodega WHERE id_descargo_bodega = :id_descargo_bodega";
                        $result = $data->query($sql, array('id_descargo_bodega'=>$datos['id_descargo_bodega']));
                        if ($result["total"] > 0) {
                            foreach($result['items'] as $documentos){ 
                                $archivo = substr($documentos['documento'], 0, 20).'.'.$documentos['tipo'];
?>
                                <a href='upload/bodega/<?php echo $documentos['documento'] ?>' download data-rel="tooltip" title='<?php echo $archivo ?>'>
<?php                           if(file_exists('img/extensiones/'.$documentos['tipo'].'.png')){ 
?>
                                    <img src='img/extensiones/<?php echo $documentos['tipo'] ?>.png' width='25px' height='36px'> 
<?php                           }else{
?>   
                                    <img src='img/extensiones/none.png' width='25px' height='36px'> 
<?php                           } 
?>
                               </a>
<?php                       }  
                        } 
?>
                    </td>
                    <td>
                        <?php echo $datos['nombre'] ?>
                    </td>
                    <td class="center">
                        <a class="btn btn-info" data-rel="tooltip" title='Detalle de articulos descargados' data-toggle='modal' data-target='#modal_detalle' onClick="detalle_descargo(<?php echo $datos['id_descargo_bodega'] ?>)"> 
                            <i class="halflings-icon white search"></i>
                        </a>
                        <a class="btn btn-warning" data-rel="tooltip" title='Comprobante de descargo' onClick="comprobante(<?php echo $datos['id_descargo_bodega'] ?>)"> 
                            <i class="halflings-icon white print"></i>
                        </a>
                    </td>
                </tr>
                <?php  
$cont ++;
} ?>
                </tbody>
                </table>
            </div>
        </div>
    </div>

</div>

<!-- Ventana Modal -->
<div class="modal hide fade" id="modal_comprobante">
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">×</button>
        <h3>Comprobante de descargo de articulos</h3>
    </div>
    <div class="modal-body">
        <div id="versolicitud"></div>
        <iframe id="pdfSolicitud" src="" frameborder="0" width="100%" height="500px" scrolling="no"></iframe>
    </div>
    <div class="modal-footer">
        <button type="button" class="btn btn-danger pull-right" data-dismiss="modal">Cerrar</button>
    </div>
</div>
<!-- Ventana Modal -->
<div class="modal hide fade" id="modal_detalle">
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">×</button>
        <h3>Detalle de articulos descargados</h3>
    </div>
    <div class="modal-body">
        <table class="table table-striped table-bordered table-hover">
            <thead class="ticket blue">
                <tr>
                    <th>N°</th>
                    <th>Articulo</th>
                    <th>Marca</th>
                    <th>Cantidad</th>
                </tr>
            </thead>
            <tbody id="tdatos">
                
            </tbody>
        </table>
    </div>
    <div class="modal-footer">
        <button type="button" class="btn btn-danger pull-right" data-dismiss="modal">Cerrar</button>
    </div>
</div>
<script type="text/javascript">
// Funcion que nos permitira cargar el combo de la secciones dependiendo de la dependencia
function comprobante(id_descargo_bodega){
    $.post("reportes/rep_comp_descargo.php", 
    {'id' : id_descargo_bodega},
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

function detalle_descargo(id_descargo_bodega){
    $.ajax({
        type: "POST",
        dataType: 'json',
        data: {"id_descargo_bodega": id_descargo_bodega},
        url: "procesos/detalle_descargo_bodega.php"
    }).done(function (response) {
        if(response.total > 0) {
            document.getElementById('tdatos').innerHTML='';
            var array=response.items;
            for(i=0;i<response.total; i++){
                document.getElementById('tdatos').innerHTML +="<tr><td>"+(i+1)+"</td><td>"+array[i]['articulo']+"</td><td>"+array[i]['marca']+"</td><td>"+array[i]['cantidad']+"</td><tr>";
            }
        }else{
            document.getElementById('tdatos').innerHTML +="<tr><td></td><td></td><td></td><td></td><tr>";
        }
    });
}
</script>