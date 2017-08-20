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
                <tbody>
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