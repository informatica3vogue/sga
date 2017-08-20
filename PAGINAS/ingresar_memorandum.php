<ul class="breadcrumb"> 
    <a href="?mod=memorandum" class="icon-folder-open" title="Permiso">&nbsp;Ir memorándum</a> 
</ul>
<div class="row-fluid">
            <div class="box">
                <div class="box-header">
                    <h2><i class="icon-bar-chart white list"></i><span class="break"></span>Crear Memorándum</h2>
                    <div class="box-icon">                        
                        <a href="#" class="btn-minimize" title="Minimizar"><i class="halflings-icon white chevron-up"></i></a>
                    </div>
                </div>
                <div class="box-content">
                <div>
                        <form role="form" method="POST" name="frmMemo" onSubmit="return false" id="frmMemo" autocomplete="off" enctype="multipart/form-data">                  
                            <input type="hidden" id="txtId" name="txtId" disabled="true">
                            <div class="form-group">
                                <label>Tipo de memorándum: </label>
                                <select class="form-control" name="txtTipo" id="txtTipo" style="width: 99%;">
                                    <option selected value="Interno">Interno</option>
                                    <option value="Externo">Externo</option>
                                </select>
                            </div>    
                            <div class="form-group" id="mostrar">
                            <label>Para: </label>
                                <select class="form-control select2" style="width: 98%;" name="txtPara[]" id="txtPara_combo" multiple="true" data-placeholder="Seleccione empleado" data-validation="required" data-validation-error-msg="rellene este campo">
                                </select> 
                            </div>
                            <div class="form-group" id="ocultar">               
                                <label>Para:</label>
                                <textarea type="text" rows="2" class="form-control" name="txtPara" id="txtPara_text" placeholder="Ingrese destino..." data-validation="required" data-validation-error-msg="rellene este campo"></textarea>
                            </div>
                            <div class="form-group">
                                <label>De: </label>
                                <select  name="txtDe" id="txtDe" style="width: 99%;" class="form-control select2" data-placeholder="Seleccione un empleado" data-validation="required" data-validation-error-msg="rellene este campo">                             
                                    </select>                                    
                            </div>
                            <div class="form-group">
                                <label>Asunto: </label>
                                <textarea type="text" rows="1" class="form-control" style="width: 97.5%;" name="txtAsunto" id="txtAsunto" placeholder="Ingrese su asunto..." data-validation="required" data-validation-error-msg="rellene este campo"></textarea>
                           </div>
                           <div class="form-group">
                                <label>Contenido:</label>
                                <textarea class="cleditor" name="txtContenido" id="txtContenido" rows="3" data-validation="required" data-validation-error-msg="rellene este campo"></textarea>
                           </div>
                           <div class="form-group">
                                <label>C.C: </label>
                                <select class="form-control" style="width: 99.5%;" name="txtCopia" id="txtCopia" data-placeholder="Con conocimiento a">
                                </select>
                            </div>              
                           <div class="form-actions">
                            <button href="?mod=imemo"  class="btn btn-movil btn-primary">Limpiar</button>
                            <button type="submit" id="guardar" name="guardar" class="btn btn-primary pull-right">Guardar</button>
                           </div>
                        </form>                                                      
                </div>
                </div>
            </div>
            <!--/span-->
</div>
<!-- Ventana Modal -->
<div class="modal hide fade" id="modal_memorandum" data-keyboard="false" data-backdrop="static">
    <div class="modal-header">
        <button type="button" onClick="location.href='?mod=memorandum'" class="close" data-dismiss="modal">×</button>
        <h3 id="titulo_modal"></h3>
    </div>
    <div class="modal-body" style="overflow: hidden;">
        <div id="verMemorandum"></div>
        <iframe id="pdfMemorandum" src="" frameborder="0" width="100%" height="425px" scrolling="no"></iframe>
    </div>
    <div class="modal-footer">
        <div id="boton_modificar"><!--boton para modificar memorandum--></div>
        <button type="button" onClick="location.href='?mod=memorandum'" class="btn btn-danger pull-right" data-dismiss="modal">Cerrar</button>
    </div>
</div>