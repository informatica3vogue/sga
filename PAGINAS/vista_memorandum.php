<!-- *********************************************************************************  -->
<!-- start submenu -->
<ul class="breadcrumb">
   <!-- <a href="#" class="icon-plus" data-toggle='modal' data-target='#modal_ingreso_actividad' title="Crear Memorándum">&nbsp;Crear Memorándum</a> &nbsp;&nbsp;&nbsp;|&nbsp;&nbsp;&nbsp;-->
    <a href="?mod=imemo" class="icon-folder-open" title="crear">&nbsp;Crear memorándum</a> &nbsp;&nbsp;&nbsp;|&nbsp;&nbsp;&nbsp;
    <a href="?mod=grupos_creados" class="icon-folder-open" title="crear">&nbsp;Ver grupos creados</a>&nbsp;&nbsp;&nbsp;|&nbsp;&nbsp;&nbsp;
    <a href="?mod=memo_grupo" class="icon-group" title="crear">&nbsp;Crear grupo para memorándum</a>&nbsp;&nbsp;&nbsp;
    <!--<a href="?mod=repmemorandum" class="icon-folder-open" title="reportes">&nbsp;Ir a Reportes</a>-->
</ul>
<div class="row-fluid sortable ui-sortable">
    <div class="span6">
        <!-- Contenedor de Memorándum Internos -->
        <div class="row-fluid">
            <div class="box">
                <div class="box-header">
                    <h2><i class="icon-bar-chart white list"></i><span class="break"></span>Memorándum Internos</h2>
                    <div class="box-icon">
                        <a href="#" class="btn-setting" data-rel="tooltip" title="Actualizar" onClick="store_memorandum(1, $('#txtMemorandum').val())"><i class="halflings-icon white refresh"></i></a>
                        <a href="#" class="btn-minimize" data-rel="tooltip" title="Minimizar"><i class="halflings-icon white chevron-up"></i></a>                        
                    </div>
                </div>
                <div class="box-content">
                <div class="input-append">
                    <form onSubmit="busqueda_memo($('#txtBuscar').val(), $('#txtMemorandum').val()); return false;" autocomplete="off">
                        <input type="text" size="16" placeholder="Buscar memor&aacute;ndum" id="txtBuscar" name="txtBuscar">
                        <button type="submit" class="btn btn-success" id="buscar"><span class="halflings-icon search white"></span></button>
                    </form>                                                       
                </div>
                    <div class="priority high">
                        <span>Internos</span>
                    </div>
                    <div id="grid">
                        <!-- Llena Memorándum Internos -->
                    </div>
                    <div id="paginador">
                    </div>
                </div>
            </div>
            <!--/span-->
        </div>
        <!--/row-->
        <!-- Contenedor de Memorándum Externos -->
        <div class="row-fluid">
            <div class="box">
                <div class="box-header">
                    <h2><i class="icon-bar-chart white list"></i><span class="break"></span>Memorándum Externos</h2>
                    <div class="box-icon">
                        <a href="#" class="btn-setting" data-rel="tooltip" title="Actualizar" onClick="store_memorandum_externo(1, $('#txtMemorandum').val())"><i class="halflings-icon white refresh"></i></a>
                        <a href="#" class="btn-minimize" data-rel="tooltip" title="Minimizar"><i class="halflings-icon white chevron-up"></i></a>
                    </div>
                </div>
                <div class="box-content">
                <div class="input-append">
                     <form onSubmit="busqueda_memo_externo($('#txtBuscar_externo').val(), $('#txtMemorandum').val()); return false;" autocomplete="off">
                        <input type="text" size="16" placeholder="Buscar memor&aacute;ndum" id="txtBuscar_externo" name="txtBuscar_externo">
                        <button type="submit" class="btn btn-success" id="buscar"><span class="halflings-icon search white"></span></button>
                    </form>
                </div>
                    <div class="priority low">
                        <span>Externos</span>
                    </div>
                    <div id="grid2">
                        <!-- Llena Memorándum Externos -->
                    </div>
                    <div id="paginador2">
                    </div>
                </div>
            </div>
            <!--/span-->
        </div>
        <!--/row-->
    </div>
    <!--Linea de tiempo-->
    <div class="span6">
        <div class="row-fluid sortable">
            <div class="box">
                <div class="box-header">
                    <h2><i class="icon-bar-chart white list"></i><span class="break"></span>PDF</h2>
                    <div class="box-icon">
                        <a href="#" class="btn-minimize" data-rel="tooltip" title="Minimizar"><i class="halflings-icon white chevron-up"></i></a>
                    </div>
                </div>
                <div class="box-content" style="display: block; height: 1010px; overflow-x: auto;">
                    <div style="width: 100%; margin: auto;">
                        <div id="verpdf" style="height:910px;">
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