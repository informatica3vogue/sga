<ul class="breadcrumb">
  <a href="?mod=permisos" class="icon-edit" title="Ir a permisos"><font color="#2E64FE">&nbsp;Volver a permisos</font></a> &nbsp;&nbsp;&nbsp;|&nbsp;&nbsp;&nbsp;
  <a href="#" onclick="actPorMot(this)" class="icon-edit" title="Permiso">&nbsp;&nbsp;Por empleado y motivo</a>&nbsp;&nbsp;&nbsp;|&nbsp;&nbsp;&nbsp;
  <a href="#" onclick="actPorGrals(this)" class="icon-edit" title="Permiso">&nbsp;&nbsp;Por Empleado días faltantes</a>
</ul>

<!-- vista 2  -->
<div id="porMotivo">
  <div class="row-fluid sortable ">
    <!-- Ventana formulario reporte-->
    <div class="box span3" >
      <div class="box-header" data-original-title="">
        <h2><i class="halflings-icon white user"></i><span class="break"></span>Formulario</h2>
        <div class="box-icon">
          <a href="#" class="btn-minimize"><i class="halflings-icon white chevron-up"></i></a>
          <!--<a href="#"  onclick="closePorEmp(this)"><i class="halflings-icon white remove"></i></a>-->
        </div>
      </div>
      <div class="box-content">
        <div class="box-content">
          <form role="form" method="POST" name="frmMotivos" id="frmMotivos" autocomplete="off" enctype="multipart/form-data" onsubmit="return false">
            <div style="height: 525px;">
              <div class="form-group">
                <label>Fecha desde:</label>
                <input type="text" class="form-control datepicker" name="txtDesdeDD" id="txtDesdeDD" style="width: 95%; background: #fff;" data-validation="required" data-validation-error-msg="rellene este campo" placeholder="Seleccione una fecha" readonly>
              </div>
              <div class="form-group">
                <label>Fecha hasta:</label>
                <input type="text" class="form-control datepicker" name="txtHastaDD" id="txtHastaDD" style="width: 95%; background: #fff;" data-validation="required" data-validation-error-msg="rellene este campo" placeholder="Seleccione una fecha" readonly>
              </div>
              <div class="form-group">
                <label>Empleado: </label>
                 <select name="txtNombreEmpleado" id="txtNombreEmpleado" class="form-control select2" style="width: 100%;" data-placeholder="Seleccione un empleado">
                    <option value="" ></option>
                  </select>
              </div>
              <div class="form-group">
                  <label>Motivo: </label>
                    <select class="form-control" name="txtMotivo" id="txtMotivo">
                      <option selected value="">Seleccione un motivo</option>
                    </select>
              </div>
              <br> 
              <div class="form-group col-md-12">
                <button type="submit" id="guardar1" name="guardar1" class="btn btn-primary btn-block"><span class="glyphicon glyphicon-file"></span> Generar reporte</button>
              </div>
            </div>
          </form>
        </div>
    </div>
    </div>
    <!-- Ventana reporte -->
    <div class="box span9">
      <div class="box-header" data-original-title="">
        <h2><i class="halflings-icon white list"></i><span class="break"></span>Vista previa, reporte por empleado y motivo</h2>
        <div class="box-icon">
          <a href="#" class="btn-minimize"><i class="halflings-icon white chevron-up"></i></a>
          <!--<a href="#"  onclick="closePorEmp(this)"><i class="halflings-icon white remove"></i></a>-->
        </div>
      </div>
      <div class="box-content">
        <div class="tab-pane active" id="vist_per">
          <div class="box-content">
            <div id="reporte1" style="height: 545px;">
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>


<div id="porEmpleadoDiasF">
  <div class="row-fluid sortable ">
    <!-- Ventana formulario reporte-->
    <div class="box span3">
      <div class="box-header" data-original-title="">
        <h2><i class="halflings-icon white user"></i><span class="break"></span>Formulario</h2>
        <div class="box-icon">
          <a href="#" class="btn-minimize"><i class="halflings-icon white chevron-up"></i></a>
          <!--<a href="#"  onclick="closePorEmp(this)"><i class="halflings-icon white remove"></i></a>-->
        </div>
      </div>
      <div class="box-content" style="height: 545px;">
        <div class="box-content">
          <form role="form" method="POST"  name="porEmpleadoG" id="porEmpleadoG" autocomplete="off" enctype="multipart/form-data" onsubmit="return false">
            <div class="form-group">
              <label>Nombre Empleado: </label>
                <select name="txtNombreEmp" id="txtNombreEmp" class="form-control select2" style="width: 100%;" data-placeholder="Seleccione un empleado">
                    <option value="" ></option>
                  </select>
            </div>
            <br>
            <br>
            <div class="form-group col-md-12">
              <button type="submit" id="guardar6" name="guardar6" class="btn btn-primary btn-block"><span class="glyphicon glyphicon-file"></span> Generar reporte</button>
            </div>
        </form>
        </div> 
         </div>   
    </div>
    <!-- Ventana reporte dias faltantes -->
    <div class="box span9">
    <div class="box-header" data-original-title="">
      <h2><i class="halflings-icon white list"></i><span class="break"></span>Reporte</h2>
      <div class="box-icon">
        <a href="#" class="btn-minimize"><i class="halflings-icon white chevron-up"></i></a>
        <!--<a href="#"  onclick="closePorEmp(this)"><i class="halflings-icon white remove"></i></a>-->
      </div>
    </div>
    <div class="box-content">
      <div id="reporte6" style="height: 545px;"></div>
    </div>
   </div>
  </div>
</div>