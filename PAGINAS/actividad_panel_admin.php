<!-- start submenu -->
<ul class="breadcrumb">
  <a href="?mod=actividades" class="icon-list-alt" title="Ir a actividades"><font color="#2E64FE">&nbsp;Volver a actividades</font></a> &nbsp;&nbsp;&nbsp;|&nbsp;&nbsp;&nbsp;
  <a href="#" id="link1" class="icon-bar-chart" title="Reporte actividades por secci&oacute;n">&nbsp;Reporte actividades por secci&oacute;n</a> &nbsp;&nbsp;&nbsp;|&nbsp;&nbsp;&nbsp;
  <a href="#" id="link2" class="icon-group" title="Reporte actividades por usuario">&nbsp;Reporte actividades por usuario</a> &nbsp;&nbsp;&nbsp;|&nbsp;&nbsp;&nbsp;
  <a href="#" id="link3" class="icon-font" title="Reporte por referencia de actividad">&nbsp;Reporte por referencia de actividad</a>
</ul>

<div id="formulario1">
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
      <div class="box-content">
        <div class="box-content">
          <form role="form" method="POST" name="frmIngresadas" id="frmIngresadas" autocomplete="off" enctype="multipart/form-data" onsubmit="return false">
            <div style="height: 650px;">
                <div class="form-group">
                <label>Fecha desde:</label>
                <input type="text" class="form-control datepicker" name="desde" id="txtDesde" style="width: 95%; background: #fff;" data-validation="required" data-validation-error-msg="rellene este campo" placeholder="Seleccione una fecha" readonly>
              </div>
              <div class="form-group">
                <label>Fecha hasta:</label>
                <input type="text" class="form-control datepicker" name="hasta" id="txtHasta" style="width: 95%; background: #fff;" data-validation="required" data-validation-error-msg="rellene este campo" placeholder="Seleccione una fecha" readonly>
              </div>
              <div class="form-group">
                <label>Sección: </label>
                <select class="form-control" name="txtSeccion" id="txtSeccion">
                  <option value="">Seleccione una sección</option>
                </select>
              </div>
              <div class="form-group">
                <label>Estado:</label>
                <select class="form-control" name="txtEstado" id="txtEstado">
                  <option value="">Seleccione un tipo</option>
                  <option value="Pendiente">Pendientes</option>
                  <option value="Finalizado">Finalizadas</option>
                </select>
              </div>
              <div class="form-group col-md-12">
                <br>
                <br>
                <button type="submit" id="guardar" name="guardar" class="btn btn-primary btn-block">Generar reporte</button>
              </div>
            </div>
          </form>
        </div>
      </div>
    </div>
    <!-- Ventana para Estadistica -->
    <div class="box span9">
      <div class="box-header" data-original-title="">
        <h2><i class="halflings-icon white list"></i><span class="break"></span>Vista previa, reporte por secci&oacute;n</h2>
        <div class="box-icon">
          <a href="#" class="btn-minimize"><i class="halflings-icon white chevron-up"></i></a>
          <!--<a href="#"  onclick="closePorEmp(this)"><i class="halflings-icon white remove"></i></a>-->
        </div>
      </div>
      <div class="box-content">
        <div class="tab-pane active" id="vist_per">
          <div class="box-content">
            <div id="reporte1" style="height: 670px;">
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
<div id="formulario2">
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
        <div class="box-content">
        <div class="box-content" style="height: 670px;">
          <form role="form" method="POST" name="frmIngresadasUs" id="frmIngresadasUs" autocomplete="off" enctype="multipart/form-data" onsubmit="return false">
              <div class="form-group">
                <label>Fecha desde: </label>
                <input type="text" class="form-control datepicker" name="desde" id="txtDesdeUno" style="width: 95%; background: #fff;" data-validation="required" data-validation-error-msg="rellene este campo" placeholder="Seleccione una fecha" readonly>
              </div>
              <div class="form-group">
                <label>Fecha hasta:</label>
                <input type="text" class="form-control datepicker" name="hasta" id="txtHastaUno" style="width: 95%; background: #fff;" data-validation="required" data-validation-error-msg="rellene este campo" placeholder="Seleccione una fecha" readonly>
              </div>
              <div class="form-group">
                <label>Usuario: </label>
                <div class="form-group">
                  <select name="txtUsuario" id="txtUsuario" class="form-control select2" style="width:100%;" data-placeholder="Seleccione un usuario">
                  </select>
                </div>
              </div>
              <div class="form-group">
                <label>Estado:</label>
                <select class="form-control" name="txtEstado" id="txtEstados">
                  <option value="">Seleccione un tipo</option>
                  <option value="Pendiente">Pendientes</option>
                  <option value="Finalizado">Finalizadas</option>
                </select>
              </div>
              <div class="form-group">
                <br>
                <br>
                <button type="submit" id="guardar2" name="guardar2" class="btn btn-primary btn-block"><span class="glyphicon glyphicon-file"></span>Generar reporte</button>
              </div>
          </form>
        </div>
         </div>
    </div>
    <!-- Ventana para Estadistica -->
    <div class="box span9">
      <div class="box-header" data-original-title="">
        <h2><i class="halflings-icon white list"></i><span class="break"></span>Vista previa, reporte por usuario</h2>
        <div class="box-icon">
          <a href="#" class="btn-minimize"><i class="halflings-icon white chevron-up"></i></a>
          <!--<a href="#"  onclick="closePorEmp(this)"><i class="halflings-icon white remove"></i></a>-->
        </div>
      </div>
      <div class="box-content">
        <div class="tab-pane active" id="vist_per">
          <div class="box-content">
            <div id="reporte2" style="height: 670px;">
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
<div id="formulario3">
  <div class="row-fluid sortable ">
    <!-- Ventana formulario reporte-->
    <div class="box span3">
      <div class="box-header" data-original-title="">
        <h2><i class="halflings-icon white user"></i><span class="break"></span>Formulario</h2>
        <div class="box-icon">
          <a href="#" class="btn-minimize"><i class="halflings-icon white chevron-up"></i></a>
        </div>
      </div>
      <div class="box-content">
        <div class="box-content">
          <form role="form" method="POST" name="frmActividad" id="frmActividad" autocomplete="off" enctype="multipart/form-data" onsubmit="return false">
            <div style="height: 650px;">
              <div class="form-group col-md-12">
                <label>Referencia:</label>
                <input type="text" class="form-control" name="txtReferencia" id="txtReferencia" placeholder="Digite referencia de actividad" style="width:95%;" data-validation="required" data-validation-error-msg="rellene este campo">
              </div>
              <div class="form-group col-md-12">
                <br>
                <br>
                <button type="submit" id="guardar3" name="guardar3" class="btn btn-primary btn-block"><span class="glyphicon glyphicon-file"></span> Generar reporte</button>
              </div>
            </div>
          </form>
        </div>
      </div>
    </div>
    <!-- Ventana para Estadistica -->
    <div class="box span9">
      <div class="box-header" data-original-title="">
        <h2><i class="halflings-icon white list"></i><span class="break"></span>Vista previa, reporte por referencia</h2>
        <div class="box-icon">
          <a href="#" class="btn-minimize"><i class="halflings-icon white chevron-up"></i></a>
        </div>
      </div>
      <div class="box-content">
        <div class="tab-pane active" id="vist_per">
          <div class="box-content">
            <div id="reporte3" style="height: 670px;">
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>