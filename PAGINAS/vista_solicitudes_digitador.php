<div class="span12">
    <!-- start submenu -->
    <ul class="breadcrumb">
        <a href="?mod=insumos_dig" class="icon-plus" title="Ingresar solicitud de insumos">&nbsp;Ingresar solicitud de insumos</a>
    </ul>
    <!-- end submenu-->
    <div class="box">
        <div class="box-header">
            <h2><i class="halflings-icon white user"></i><span class="break"></span>Solicitudes realizadas</h2>
            <div class="box-icon">
                <a href="#" data-rel="tooltip" title="Minimizar" class="btn-minimize"><i class="halflings-icon white chevron-up"></i></a>
            </div>
        </div>
        <div class="box-content">
            <div class="table-responsive">
                <table class="table table-striped table-bordered table-hover bootstrap-datatable datatable">
                <thead class="ticket blue">
                    <tr>
                        <th style="width:20%;">
                             Referencia
                        </th>
                        <th style="width:20%;">
                             Fecha solicitud
                        </th>
                        <th style="width:50%;">
                             Articulos
                        </th>
                        <th style="width:10%;">
                             Acción
                        </th>
                    </tr>
                    </thead>
<?php
                $cont = 1;  
                   $response = $dataTable->obtener_Solicitudes_Insumos($_SESSION["id_usuario"]);
?>
                <tbody>
<?php    
                    foreach($response['items'] as $datos){
?>
                <tr>
                        <td><?php echo $datos['referencia'] ?></td>
                        <td><?php echo $datos['fecha'] ?></td>
<?php
                        $params['id_solicitud_articulo'] = $datos['id_solicitud_articulo'];                     
                        $sql2 = "SELECT GROUP_CONCAT(' ', articulo) AS articulo FROM articulo a INNER JOIN detalle_solicitud de ON a.id_articulo = de.id_articulo WHERE de.id_solicitud_articulo = :id_solicitud_articulo";
                        $parametros=array("id_solicitud_articulo");
                        $result = $data->query($sql2, $params, $parametros);
?>
                       <td><?php echo $result['items'][0]['articulo'] ?></td>
                        <td id='center'>
                        	<a class="btn btn-warning" data-rel="tooltip" title='Comprobante de descargo' onClick="comprobante(<?php echo $datos['id_solicitud_articulo'] ?>)"> 
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
        <h3>Comprobante de solicitud de insumos</h3>
    </div>
    <div class="modal-body">
        <div id="versolicitud"></div>
        <iframe id="pdfSolicitud" src="" frameborder="0" width="100%" height="500px" scrolling="no"></iframe>
    </div>
    <div class="modal-footer">
        <button type="button" class="btn btn-danger pull-right" data-dismiss="modal">Cerrar</button>
    </div>
</div>
<script type="text/javascript">
	// Funcion que nos permitira cargar el combo de la secciones dependiendo de la dependencia
function comprobante(id_solicitud_articulo){
    $.post("reportes/rep_solicitud.php", 
    {'id' : id_solicitud_articulo},
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