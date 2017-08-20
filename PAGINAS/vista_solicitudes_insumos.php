<div class="span12">
    <!-- start submenu -->
    <ul class="breadcrumb">
        <a href="?mod=insumos" class="icon-edit" title="Ingresar solicitud de insumos">&nbsp;&nbsp;Ingresar solicitud de insumos</a>&nbsp;&nbsp;&nbsp;|&nbsp;&nbsp;&nbsp;
        <a href="?mod=cinsumos" class="icon-edit" title="Ingresar articulos">&nbsp;&nbsp;Ingresar articulos</a>&nbsp;&nbsp;&nbsp;|&nbsp;&nbsp;&nbsp;
        <a href="?mod=articulo" class="icon-edit" title="Cargar articulos">&nbsp;&nbsp;Cargar articulos</a>&nbsp;&nbsp;&nbsp;|&nbsp;&nbsp;&nbsp;
        <a href="?mod=repinsumo" class="icon-file" title="Reportes insumos">&nbsp;&nbsp;Reportes insumos</a>
    </ul>
    <!-- end submenu-->
    <div class="box">
        <div class="box-header">
            <h2><i class="halflings-icon white user"></i><span class="break"></span>Solicitudes de usuarios</h2>
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
                         Referencia
                    </th>
                    <th>
                         Fecha
                    </th>
                    <th>
                         Solicitante
                    </th>
                    <th>
                         Articulos
                    </th>
                    <th>
                         Estado
                    </th>
                    <th>
                         Acciones
                    </th>
                </tr>
                </thead>
                <?php
                    $cont = 1;  
                    $response = $dataTable->obtener_Solicitudes($_SESSION["id_dependencia"]);
                ?>
                <tbody>
                <?php    
                    foreach($response['items'] as $datos){?>
                <tr>
                    <td>
                        <?php echo $cont ?>
                    </td>
                    <td>
                        <?php echo $datos['referencia'] ?>
                    </td>
                    <td class="center">
                        <?php echo $datos['fecha'] ?>
                    </td>
                    <td class="center">
                        <?php echo $datos['nombre_completo'] ?>
                    </td>
                    <td class="center">
                    <?php                   
                        $sql = "SELECT GROUP_CONCAT(articulo) AS articulo FROM articulo a INNER JOIN detalle_solicitud de ON a.id_articulo = de.id_articulo WHERE de.id_solicitud_articulo = :id_solicitud_articulo";
                        $result = $data->query($sql, array('id_solicitud_articulo'=>$datos['id_solicitud_articulo'])); 
                        echo substr($result['items'][0]['articulo'], 0, 35)." ...";
                    ?>
                    </td>
                    <td class="center">
                        <?php $clase = ($datos['estado'] == 'Finalizado') ? 'label label-important': 'label label-success'; ?>
                        <span class="<?php echo $clase ?>"><?php echo $datos['estado'] ?>
                        </span>
                    </td>
                    <td class="center">
                        <form action="?mod=msolicitud" method="POST">
<?php  
                    if ($datos['estado'] == 'Finalizado') {
?>                  
                            <a class="btn btn-warning" data-rel="tooltip" title='Atender solicitud' href="#" disabled="true"> <i class="halflings-icon white minus"></i>
                            </a>
                            <input type="hidden" name="id" value="<?php echo $datos['id_solicitud_articulo'] ?>">
                            <button type="button" class="btn btn-info" data-rel="tooltip" title="Modificar solicitud" disabled="true"><i class="halflings-icon white edit"></button>
<?php  
                    }else{
?>
                            <a class="btn btn-warning" data-rel="tooltip" title='Atender solicitud' href="?mod=descargos_articulo&id=<?php echo $datos['id_solicitud_articulo'] ?>"> <i class="halflings-icon white minus"></i>
                            </a>
                            <input type="hidden" name="id" value="<?php echo $datos['id_solicitud_articulo'] ?>">
                            <button type="submit" class="btn btn-info" data-rel="tooltip" title="Modificar solicitud"><i class="halflings-icon white edit"></button>
<?php  
                    }
?>
                            <a class="btn btn-primary" data-rel="tooltip" title='Comprobante de descargo' onClick="comprobante(<?php echo $datos['id_solicitud_articulo'] ?>)" style="margin-left: 3px;"><i class="halflings-icon white print"></i>
                            </a>
                        </form>
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