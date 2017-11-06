<div class="span12">
    <!-- start submenu -->
    <ul class="breadcrumb">
        <!--<a href="?mod=agregarempleado" class="icon-plus" title="Ingresar nuevo empleado">&nbsp;Ingresar nuevo empleado</a> &nbsp;&nbsp;&nbsp;|&nbsp;&nbsp;&nbsp;-->
        <a href="?mod=permisos" class="icon-folder-open" title="Registros de empleados">&nbsp;Registros de empleados</a>&nbsp;&nbsp;&nbsp;|&nbsp;&nbsp;&nbsp;
        <a href="?mod=reportes_permiso" class="icon-file" title="Reportes permisos">&nbsp;Reportes permisos</a>
    </ul>
    <!-- end submenu-->
    <div class="box">
        <div class="box-header">
            <h2><i class="halflings-icon white user"></i><span class="break"></span>Permisos registrados</h2>
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
                         N° permiso
                    </th>
                    <th>
                         Motivo
                    </th>
                    <th>
                         Fecha
                    </th>
                    <th>
                         Empleado
                    </th>
                    <th>
                         Dias solicitados
                    </th>
                    <th>
                         Horas solicitadas
                    </th>
                    <th>
                         Acci&oacute;n
                    </th>
                </tr>
                </thead>
<?php
                //$cont = 1;  
               // $response = $dataTable->obtener_Permisos($_SESSION["id_dependencia"]); 
?>
                <tbody>
                <?php    
                    //foreach($response['items'] as $datos){?>
                <!-- <tr>
                    <td>
                        <?php echo $cont ?>
                    </td>
                    <td>
                        <?php echo $datos['num_permiso'] ?>
                    </td>
                    <td class="center">
                        <?php echo $datos['motivo'] ?>
                    </td>
                    <td class="center">
                        <?php echo $datos['f_dif'] ?>
                    </td>
                    <td class="center">
                        <?php echo $datos['nombre_completo'] ?>
                    </td>
                    <td class="center">
                        <?php echo ($datos['dias']+1) ?>
                    </td>
                    <td class="center">
                        <?php echo $datos['horas'] ?>
                    </td>
                    <td class="center">
                          <a class="btn btn-info" data-rel="tooltip" title='Modificar permiso' href="?mod=empleados&idm=<?php echo $datos['id_permiso'] ?>"> 
                            <i class="halflings-icon white edit"></i>
                        </a>
                    </td>
                </tr> -->
                <?php  
//$cont ++;
//} ?>
                </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<!-- Ventana Modal para el cambio de estado del usuario -->
<div class="modal hide fade" id="modal_usuario">
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">×</button>
        <h3>Cambio de estado</h3>
    </div>
    <div class="modal-body">
        <form role="form" method="POST" name="frmEstado" id="frmEstado">
            <input type="hidden" id="txtId2" name="txtId2">
            <div class="form-group">
                <label>Nombre Completo:</label>
                <input type="text" class="form-control" name="txtNombre_Completo" id="txtNombre_Completo" disabled="disable" style="width: 95%;">
            </div>
            <div class="form-group">
                <label>Estado:</label>
                <select name="txtEstado" id="txtEstado" class="form-control" placeholder="Seleccione un Estado" required="true">
                    <option value="">Selecione un estado </option>
                    <option value="Activo">Activo</option>
                    <option value="Inactivo">Inactivo</option>
                </select>
            </div>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-danger pull-left" data-dismiss="modal">Cancelar</button>
            <button type="submit" id="modificar_estado" name="modificar_estado" class="btn btn-primary">Guardar</button>
        </div>
    </form>
</div>
<!-- Ventana Modal para el cambio de estado del usuario -->
<div class="modal hide fade" id="datos_usuario">
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">×</button>
        <h3>Informaci&oacute;n del usuario</h3>
    </div>
    <div class="modal-body">
        <div class="form-group">
            <label>Nombre Completo:</label>
            <input type="text" class="form-control" id="nombre" disabled="disable" style="width: 95%;">
        </div>
        <div class="form-group">
            <label>Usuario:</label>
            <input type="text" class="form-control" id="usuario" disabled="disable" style="width: 95%;">
        </div>
        <div class="form-group">
            <label>Cargo:</label>
            <input type="text" class="form-control" id="cargo" disabled="disable" style="width: 95%;">
        </div>
        <div class="form-group">
            <label>Rol:</label>
            <input type="text" class="form-control" id="rol" disabled="disable" style="width: 95%;">
        </div>
        <div class="form-group">
            <label>Estado:</label>
            <input type="text" class="form-control" id="estado" disabled="disable" style="width: 95%;">
        </div>
        <div class="form-group">
            <label>Seccion:</label>
            <input type="text" class="form-control" id="seccion" disabled="disable" style="width: 95%;">
        </div>
        <div class="form-group">
            <label>Dependencia:</label>
            <input type="text" class="form-control" id="dependencia" disabled="disable" style="width: 95%;">
        </div>
        <div class="form-group">
            <label>Municipio:</label>
            <input type="text" class="form-control" id="municipio" disabled="disable" style="width: 95%;">
        </div>
        <div class="form-group">
            <label>Departamento:</label>
            <input type="text" class="form-control" id="departamento" disabled="disable" style="width: 95%;">
        </div>
    </div>
    <div class="modal-footer">
        <button type="button" class="btn btn-danger pull-right" data-dismiss="modal">Cancelar</button>
    </div>
</div>