<!-- start submenu -->
<ul class="breadcrumb">
<?php 
if ($_SESSION["id_rol"] == 2 || $_SESSION["id_rol"] == 3 || $_SESSION["id_rol"] == 7 || $_SESSION["id_rol"] == 8 || $_SESSION["id_rol"] == 9) {
?>  
&nbsp;
<?php
}else{
?>
    <a href="?mod=iactividad" class="icon-plus" title="Ingresar actividad">&nbsp;Ingresar actividad</a> &nbsp;&nbsp;&nbsp;|&nbsp;&nbsp;&nbsp;
    <a href="?mod=actividad" class="icon-list-alt" title="Actividades generales">&nbsp;Actividades generales</a> &nbsp;&nbsp;&nbsp;|&nbsp;&nbsp;&nbsp;
    <a href="?mod=repactividad" class="icon-file" title="Reportes actividad">&nbsp;Reportes actividad</a>
<?php 
}
 ?>
</ul>
<!-- end submenu-->
<div class="row-fluid">
    <div class="span6">
        <!-- Contenedor de acitividades pendientes -->
        <div class="row-fluid">
            <div class="box">
                <div class="box-header">
                    <h2><i class="icon-bar-chart white list"></i><span class="break"></span>Mis actividades asignadas</h2>
                    <div class="box-icon">
                        <a href="#" class="btn-setting" title="Actualizar" onclick="store_actividad(1, 'Pendiente')"><i class="halflings-icon white refresh"></i></a>
                        <a href="#" class="btn-minimize" title="Minimizar"><i class="halflings-icon white chevron-up"></i></a>
                    </div>
                </div>
                <div class="box-content">
                    <div class="input-append">
                        <form id="frmPendientes" name="frmPendientes" action="" onsubmit="busqueda_actividad_pend($('#txtBuscar').val()); return false;" autocomplete="off">
                            <input type="text" placeholder="Buscar actividad por..." name="txtBuscar" id="txtBuscar">
                            <button type="submit" class="btn btn-success" id="buscar" name="buscar"><span class="halflings-icon search white"></span></button>
                        </form>
                    </div>
                    <div class="priority high">
                        <span>Pendientes</span>
                    </div>
                    <div id="grid">
                        <!-- Llena actividades pendientes -->
                    </div>
                    <div id="paginador">
                    </div>
                </div>
            </div>
            <!--/span-->
        </div>
        <!--/row-->
        <!-- Contenedor de acitividades finalizadas -->
        <div class="row-fluid">
            <div class="box">
                <div class="box-header">
                    <h2><i class="icon-bar-chart white list"></i><span class="break"></span>Mis actividades finalizadas</h2>
                    <div class="box-icon">
                        <a href="#" class="btn-setting" title="Actualizar" onclick="store_actividad2(1, 'Finalizado')"><i class="halflings-icon white refresh"></i></a>
                        <a href="#" class="btn-minimize" title="Minimizar"><i class="halflings-icon white chevron-up"></i></a>
                    </div>
                </div>
                <div class="box-content">
                    <div class="input-append">
                        <form id="frmFinalizadas" name="frmFinalizadas" action="" onsubmit="busqueda_actividad_fin($('#txtBuscar2').val()); return false;" autocomplete="off">
                            <input type="text" placeholder="Buscar actividad por..." name="txtBuscar2" id="txtBuscar2">
                            <button type="submit" class="btn btn-success" id="buscar2" name="buscar2"><span class="halflings-icon search white"></span></button>
                        </form>
                    </div>
                    <div class="priority low">
                        <span>Finalizadas</span>
                    </div>
                    <div id="grid2">
                        <!-- Llena actividades finalizadas -->
                    </div>
                    <div id="paginador2">
                    </div>
                </div>
            <!--/span-->
            </div>
        </div>
        <!--/row-->
    </div>
    <!--Linea de tiempo-->
    <div class="span6">
        <div class="row-fluid">
            <div class="box">
                <div class="box-header">
                    <h2><i class="icon-bar-chart white list"></i><span class="break"></span>Seguimientos realizados&nbsp;&nbsp;<label id="refAct"></label></h2>
                    <div class="box-icon">
                        <a href="#" class="btn-minimize" title="Minimizar"><i class="halflings-icon white chevron-up"></i></a>
                    </div>
                </div>
                <div class="box-content" style="display: block; height: 1135px; overflow-x: auto;">
                    <div style="width: 90%; margin: auto;">
                        <div class="timeline" id="grid3">
                            <!-- Llena seguimiento de actividades -->
                        </div>
                    </div>
                </div>
            </div>
            <!--/span-->
        </div>
        <!--/row-->
    </div>
</div>
<!-- Modal seguimiento de las actividades -->
<form role="form" method="POST" name="frmSeguimiento" id="frmSeguimiento" onsubmit="return false">
    <div class="modal hide fade" id="modal_seguimiento">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal">×</button>
            <h3>Seguimiento de actividad</h3>
        </div>
        <div class="modal-body">
            <!--Formulario de modal-->
            <input type="hidden" id="txtId2" name="txtId2">
            <div class="form-group">
                <label>Solicitante:</label>
                <input class="form-control" type="text" id="txtSolic" name="txtSolic" disabled="disable">
            </div>
            <div class="form-group">
                <label>Dependencia:</label>
                <input type="text" class="form-control" name="txtDepen" id="txtDepen" disabled="disable">
            </div>
            <div class="form-group">
                <label>Requerimiento:</label>
                <textarea class="form-control" name="txtReque" id="txtReque" rows="3" disabled="disable"></textarea>
            </div>
            <div class="form-group">
                <label>Acción realizada:</label>
                <textarea class="form-control" name="txtAccion" id="txtAccion" cols="10" rows="3" data-validation="required" data-validation-error-msg="rellene este campo"></textarea>
            </div>
            <div class="form-group">
                <label>Estado:</label>
                <select class="form-control" name="txtEstado" id="txtEstado">
                    <option value="Pendiente">Pendiente</option>
                    <option value="Finalizado">Finalizado</option>
                </select>
            </div>
            <div class="form-group">
                <label>Adjunto:</label>
                <input type="file" name="txtAdd2[]" id="txtAdd2" multiple="true">
            </div>
            <div class="form-group">
                <label>&nbsp;</label>
                <input type="hidden" class="form-control" name="txtReferencia" id="txtReferencia" value="">
            </div>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-danger pull-left btn-movil" data-dismiss="modal">Cancelar</button>
            <button type="submit" id="guardar" name="guardar" class="btn btn-primary btn-movil pull-right">Guardar</button>
        </div>
    </div>
</form>
<!-- Modal detalle de las actividades -->
<div class="modal hide fade" id="modal_detalle_actividad">
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">×</button>
        <h3>Detalle actividad</h3>
    </div>
    <div class="modal-body">
        <!--Formulario de modal-->
        <input type="hidden" id="txtId3" name="txtId3">
        <div class="form-group">
            <label>Dependencia de origen</label>
            <input type="text" class="form-control" name="txtDep" id="txtDep" disabled="disable">
        </div>
        <div class="form-group">
            <label>Solicitante</label>
            <input class="form-control" type="text" id="txtSol" name="txtSol" disabled="disable">
        </div>
        <div class="form-group">
            <label>Fecha de solicitud</label>
            <input class="form-control" type="text" id="txtFSol" name="txtFSol" disabled="disable">
        </div>
        <div class="form-group">
            <label>Referencia de origen</label>
            <input class="form-control" type="text" id="txtOrigen" name="txtOrigen" disabled="disable">
        </div>
        <div class="form-group">
            <label>Requerimiento</label>
            <textarea class="form-control" name="txtReq" id="txtReq" cols="50" rows="3" disabled="disable"></textarea>
        </div>
        <div class="form-group">
            <label>Referencia de actividad</label>
            <input class="form-control" type="text" id="txtRef" name="txtRef" disabled="disable">
        </div>
        <div class="form-group">
            <label>Fecha procesamiento</label>
            <input class="form-control" type="text" id="txtFProc" name="txtFProc" disabled="disable">
        </div>
        <div class="form-group">
            <label>Marginado</label>
            <input class="form-control" type="text" id="txtMar" name="txtMar" disabled="disable">
        </div>
        <div class="form-group">
            <label>Estado de actividad</label>
            <input class="form-control" type="text" id="txtEst" name="txtEst" disabled="disable">
        </div>
        <!--<div class="form-group">
            <label>Con conocimiento</label>
            <textarea class="form-control" name="txtCC" id="txtCC" class="form-control" rows="2" disabled="disable"></textarea>
        </div>-->
        <div class="form-group">
            <label>Usuarios asignados</label>
            <textarea class="form-control" name="txtAsg" id="txtAsg" rows="2" disabled="disable"></textarea>
        </div>
        <div class="form-group">
            <label>Adjuntos</label>
            <div id="cargarDoc">
            </div>
        </div>
    </div>
    <div class="modal-footer">
        <a href="#" class="btn btn-danger btn-movil" data-dismiss="modal">Cerrar</a>
    </div>
</div>
<!-- Modal detalle de seguimientos -->
<div class="modal hide fade" id="modal_detalle_seguimiento">
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">×</button>
        <h3>Detalle seguimiento</h3>
    </div>
    <div class="modal-body">
        <!--Formulario de modal-->
        <input type="hidden" id="txtId4" name="txtId4">
        <div class="form-group">
            <label>Seguimiento hecho por</label>
            <input class="form-control" type="text" id="txtSoliSeguimiento" name="txtSoliSeguimiento" disabled="disable">
        </div>
        <div class="form-group">
            <label>Dependencia de origen</label>
            <input type="text" class="form-control" name="txtDepSeguimiento" id="txtDepSeguimiento" disabled="disable">
        </div>
        <div class="form-group">
            <label>Requerimiento</label>
            <textarea class="form-control" name="txtReqSeguimiento" id="txtReqSeguimiento" cols="10" rows="2" disabled="disable"></textarea>
        </div>
        <div class="form-group">
            <label>Acción realizada</label>
            <textarea class="form-control" name="txtAccSeguimiento" id="txtAccSeguimiento" cols="10" rows="3" disabled="disable"></textarea>
        </div>
        <div class="form-group">
            <label>Estado</label>
            <input class="form-control" type="text" id="txtEstSeguimiento" name="txtEstSeguimiento" disabled="disable">
        </div>
        <input type="hidden" id="txtId5" name="txtId5">
        <div class="form-group">
            <label>Adjuntos</label>
            <div id="cargarDocSeg">
            </div>
        </div>
    </div>
    <div class="modal-footer">
        <a href="#" class="btn btn-danger btn-movil" data-dismiss="modal">Cerrar</a>
    </div>
</div>
<!-- Modal formulario reasignar -->
<form role="form" method="POST" name="frmReasignacion" id="frmReasignacion" onsubmit="return false">
<div class="modal hide fade" id="modal_reasignacion">
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">×</button>
        <h3>Reasignacion de actividad</h3>
    </div>
    <div class="modal-body" style="overflow-x: hidden; overflow-y: auto;">
        <!--Formulario de modal-->
        <input type="hidden" id="txtId6" name="txtId6">
        <div class="form-group">
            <label>Referencia</label>
            <input type="text" class="form-control" id="txtReferencia_actividad" name="txtReferencia_actividad" readonly="true">
        </div>
        <div class="form-group">
            <label>Requerimiento</label>
            <textarea class="form-control" name="txtRequerimiento" id="txtRequerimiento" cols="10" rows="2" disabled="disable"></textarea>
        </div>
        <div class="form-group">
            <label>Reasignar actividad a: </label>
            <select class="form-control" name="txtAsignado" id="txtAsignado" data-placeholder="Seleccione usuario a reasignar actividad" data-validation="required" data-validation-error-msg="rellene este campo" style="width: 100%;"></select>
        </div>   
        <div class="form-group">
            <label>Seguimiento de actividad: </label>
            <textarea class="form-control" name="txtSeguimiento" id="txtSeguimiento" cols="10" rows="3" data-validation="required" data-validation-error-msg="rellene este campo"></textarea>
        </div>
        <div class="form-group">
            <label>Adjunto:</label>
            <input type="file" name="txtAdd[]" id="txtAdd" multiple="true">
        </div>
    </div>
    <div class="modal-footer">
        <button type="button" class="btn btn-danger pull-left btn-movil" data-dismiss="modal">Cancelar</button>
        <button type="submit" id="guardar_reasignacion" name="guardar_reasignacion" class="btn btn-primary btn-movil pull-right">Guardar</button>
    </div>
</div>
</form>