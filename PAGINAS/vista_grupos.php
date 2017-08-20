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