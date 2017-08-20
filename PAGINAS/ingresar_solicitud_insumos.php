<span class="span12">
 <!-- start submenu -->
    <ul class="breadcrumb">
        <a href="?mod=vinsumos" class="icon-edit" title="Ver solicitudes de insumos">&nbsp;&nbsp;Ver solicitudes de insumos</a>&nbsp;&nbsp;&nbsp;|&nbsp;&nbsp;&nbsp;
        <a href="?mod=cinsumos" class="icon-edit" title="Ingresar articulos">&nbsp;&nbsp;Ingresar articulos</a>&nbsp;&nbsp;&nbsp;|&nbsp;&nbsp;&nbsp;
        <a href="?mod=articulo" class="icon-edit" title="Cargar articulos">&nbsp;&nbsp;Cargar articulos</a>&nbsp;&nbsp;&nbsp;|&nbsp;&nbsp;&nbsp;
        <a href="?mod=repinsumo" class="icon-file" title="Reportes insumos">&nbsp;&nbsp;Reportes insumos</a>
    </ul>
    <!-- end submenu-->
</span>
<div class="row-fluid">
<div class="span12">
    <div class="box">
        <div class="box-header">
            <h2><i class="halflings-icon white minus-sign"></i><span class="break"></span>Solicitud de articulos</h2>
            <div class="box-icon">
                <a href="#" data-rel="tooltip" title="Minimizar" class="btn-minimize"><i class="halflings-icon white chevron-up"></i></a>
            </div>
        </div>
        <div class="box-content">
        <form role="form" method="POST" name="frmInsumos" id="frmInsumos" autocomplete="off" enctype="multipart/form-data" onSubmit="return false">
                <div class="form-group span5">
                    <label>Articulo: </label>
                    <select class="form-control select2" name="txtArticulo" id="txtArticulo" data-placeholder="Seleccione un articulo" data-validation="required" data-validation-error-msg="rellene este campo">
                    </select>
                </div>
                <div class="form-group span5">
                    <label>Cantidad: </label>
                    <input type="number" class="form-control" min="0" max="10" name="txtCantidad" id="txtCantidad" placeholder="Escriba una cantidad" style="width: 94%;" data-validation="required" data-validation-error-msg="rellene este campo" onkeyup="limitar(this.value)">
                </div>
                <div class="form-group span2">
                    <label>&nbsp;</label>
                    <button type="button" class="btn btn-success btn-block" onclick="add()"><i class="halflings-icon white plus"></i> Agregar</button>
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
            <div class="form-actions">
                <button type="button" id="cancelar" name="cancelar" onClick="location.reload()" class="btn btn-danger pull-left">Cancelar</button>
                <button type="submit" id="guardar" name="guardar" class="btn btn-primary pull-right">Guardar</button>
            </div>
            </form>  
        </div>

    </div>
</div>
</div>

<!-- Ventana Modal -->
<div class="modal hide fade" id="modal_comprobante">
    <div class="modal-header">
        <button type="button" onClick="location.href='?mod=vinsumos'" class="close" data-dismiss="modal">×</button>
        <h3>Comprobante de solicitud de insumos</h3>
    </div>
    <div class="modal-body">
        <div id="versolicitud"></div>
        <iframe id="pdfSolicitud" src="" frameborder="0" width="100%" height="400px" scrolling="no"></iframe>
    </div>
    <div class="modal-footer">
        <button type="button" onClick="location.href='?mod=vinsumos'" class="btn btn-danger pull-right" data-dismiss="modal">Cerrar</button>
    </div>
</div>