<span class="span12">
 <!-- start submenu -->
    <ul class="breadcrumb">
        <a href="?mod=insumos" class="icon-edit" title="Ingresar solicitud de insumos">&nbsp;&nbsp;Ingresar solicitud de insumos</a>&nbsp;&nbsp;&nbsp;|&nbsp;&nbsp;&nbsp;
        <a href="?mod=vinsumos" class="icon-edit" title="Ver solicitudes de insumos">&nbsp;&nbsp;Ver solicitudes de insumos</a>&nbsp;&nbsp;&nbsp;|&nbsp;&nbsp;&nbsp;
        <a href="?mod=cinsumos" class="icon-edit" title="Ingresar articulos">&nbsp;&nbsp;Ingresar articulos</a>&nbsp;&nbsp;&nbsp;|&nbsp;&nbsp;&nbsp;
        <a href="?mod=repinsumo" class="icon-file" title="Reportes insumos">&nbsp;&nbsp;Reportes insumos</a>
    </ul>
    <!-- end submenu-->
</span>
<div class="row-fluid">
    <div class="span12">
        <div class="box">
            <div class="box-header">
                <h2><i class="halflings-icon white plus"></i><span class="break"></span>Existencia de articulos de insumos</h2>
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
                            Acci&oacute;n
                        </th>
                    </tr>
                    </thead>
                    <tbody>
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
            <label>Observacion:</label>
            <textarea class="form-control" name="txObservacion" id="txObservacion" placeholder="Escriba una observacion" style="width: 94%;"></textarea>
        </div>   
    </div>   
    <div class="modal-footer">
        <button type="reset" id="limpiar" name="limpiar" class="btn btn-primary pull-left">Limpiar</button>
        <button type="submit" id="guardar" name="guardar" class="btn btn-primary pull-right">Guardar</button>
    </div>
</div>
</form>