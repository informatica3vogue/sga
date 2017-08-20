<!-- start submenu -->
<ul class="breadcrumb">
   <a href="?mod=insumos" class="icon-bar-chart" title="Ir a actividad">&nbsp;Ir a insumos</a>&nbsp;&nbsp;&nbsp;|&nbsp;&nbsp;&nbsp;
   <a href="#" id="link1" class="icon-list" title="Permiso">&nbsp;&nbsp;Existencia de articulos</a>&nbsp;&nbsp;&nbsp;|&nbsp;&nbsp;&nbsp;
   <a href="#" id="link2" class="icon-user" title="Permiso">&nbsp;&nbsp;Solicitudes de usuarios</a>&nbsp;&nbsp;&nbsp;|&nbsp;&nbsp;&nbsp;
   <!--<a href="#" id="link3" class="icon-plus-sign" title="Permiso">&nbsp;&nbsp;Por Cargo</a>&nbsp;&nbsp;&nbsp;|&nbsp;&nbsp;&nbsp;
   <a href="#" id="link4" class="icon-minus-sign" title="Permiso">&nbsp;&nbsp;Por descargo</a>&nbsp;&nbsp;&nbsp;|&nbsp;&nbsp;&nbsp;
   <a href="#" id="link5" class="icon-list-alt" title="Permiso">&nbsp;&nbsp;Por descargo general</a>-->
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
          <form role="form" method="POST" name="frmExistencia" id="frmExistencia" autocomplete="off" enctype="multipart/form-data" onsubmit="return false">
            <div style="height: 545px;">
              <div class="form-group col-md-3">
                <label>Existencia de articulos: </label>
              </div>
              <div class="form-group col-md-12">
                <button type="submit" id="guardar" name="guardar" class="btn btn-primary btn-block"><span class="glyphicon glyphicon-file"></span> Generar reporte</button>
              </div>
            </div>
          </form>
        </div>
    </div>
    <!-- Ventana para Estadistica -->
    <div class="box span9">
      <div class="box-header" data-original-title="">
        <h2><i class="halflings-icon white list"></i><span class="break"></span>Vista previa, reporte de existencia de articulos</h2>
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
        <div class="box-content">
          <form role="form" method="POST" name="c" id="frmSolicitudes" autocomplete="off" enctype="multipart/form-data" onsubmit="return false">
            <div style="height: 525px;">
              <div class="form-group">
                <label>Fecha desde: </label>
                <input type="text" class="form-control datepicker" name="desde" id="txtDesdeUno" style="width: 95%; background: #fff;" data-validation="required" data-validation-error-msg="rellene este campo" placeholder="Seleccione una fecha" readonly>
              </div>
              <div class="form-group">
                <label>Fecha hasta:</label>
                <input type="text" class="form-control datepicker" name="hasta" id="txtHastaUno" style="width: 95%; background: #fff;" data-validation="required" data-validation-error-msg="rellene este campo" placeholder="Seleccione una fecha" readonly>
              </div>
              <div class="form-group">
                <label>Seccion: </label>
                   <select name="id_seccion" id="id_seccion" class="form-control" onChange="store_usuarios_seccion(this.value)" data-validation="required" data-validation-error-msg="rellene este campo">
                  </select>
              </div>
              <div class="form-group">
                <label>Usuario: </label>
                   <select name="id_usuario" id="id_usuario" class="form-control">
                  </select>
              </div>
              <div class="form-group">
                <button type="submit" id="guardar2" name="guardar" class="btn btn-primary btn-block"><span class="glyphicon glyphicon-file"></span> Generar reporte</button>
              </div>
            </div>
          </form>
        </div>
      </div>
    </div>
    <!-- Ventana para Estadistica -->
    <div class="box span9">
      <div class="box-header" data-original-title="">
        <h2><i class="halflings-icon white list"></i><span class="break"></span>Reporte por usuario</h2>
        <div class="box-icon">
          <a href="#" class="btn-minimize"><i class="halflings-icon white chevron-up"></i></a>
          <!--<a href="#"  onclick="closePorEmp(this)"><i class="halflings-icon white remove"></i></a>-->
        </div>
      </div>
      <div class="box-content">
        <div class="tab-pane active" id="vist_per">
          <div class="box-content">
            <div id="reporte2" style="height: 545px;">
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
          <!--<a href="#"  onclick="closePorEmp(this)"><i class="halflings-icon white remove"></i></a>-->
        </div>
      </div>
        <div class="box-content">
        <div class="box-content">
          <form role="form" method="POST" name="frmcargo" id="frmcargo" autocomplete="off" enctype="multipart/form-data" onsubmit="return false">
            <div style="height: 525px;">
              <div class="form-group col-md-3">
                <label>Usuario: </label>
                <div class="btn-group">
                   <select data-rel="chosen" name="txtUsuariow" id="txtUsuariow" style="width:200px">
                    <option value="" >Seleccione usuarios </option>
                    <?php 
                        $sql = "SELECT us.id_usuario, CONCAT(us.nombre, ' ', us.apellido, ' / ', us.cargo) AS nombre_completo FROM usuario us INNER JOIN seccion se ON us.id_seccion=se.id_seccion WHERE se.id_dependencia =:id_dependencia ORDER BY nombre_completo ASC";
                        $response = $data->query($sql, array("id_dependencia" => $_SESSION["id_dependencia"])); 
                        foreach($response['items'] as $datos){ 
                    ?>
                    <option value="<?php echo($datos['id_usuario']); ?>"><?php echo($datos['nombre_completo']); ?>
                    </option>
                    <?php } ?>
                  </select>
                </div>
              </div>
             <div class="form-group col-md-3">
                <label>Fecha desde:</label>
                <input type="text" class="form-control datepicker" name="txtDesdeCS" id="txtDesdeCS" placeholder="yyyy-mm-dd" readonly>
              </div>
              <div class="form-group col-md-3">
                <label>Fecha hasta:</label>
                <input type="text" class="form-control datepicker" name="txtHastaCS" id="txtHastaCS" placeholder="yyyy-mm-dd" readonly>
              </div>
              <div class="form-group col-md-12">
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
        <h2><i class="halflings-icon white list"></i><span class="break"></span>Reporte por Cargo</h2>
        <div class="box-icon">
          <a href="#" class="btn-minimize"><i class="halflings-icon white chevron-up"></i></a>
          <!--<a href="#"  onclick="closePorEmp(this)"><i class="halflings-icon white remove"></i></a>-->
        </div>
      </div>
      <div class="box-content">
        <div class="tab-pane active" id="vist_per">
          <div class="box-content">
            <div id="reporte3" style="height: 545px;">
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
<div id="formulario4">
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
          <form role="form" method="POST" name="frmcargos" id="frmcargos" autocomplete="off" enctype="multipart/form-data" onsubmit="return false">
            <div style="height: 525px;">
              <div class="form-group col-md-3">
                <label>Usuario: </label>
                <div class="btn-group">
                  <!-- <select class="form-control btn-group" name="txtUsuarios" id="txtUsuarios"  data-rel="chosen" style="width:300px;"> -->

                    <select data-rel="chosen" name="txtUsuarios" id="txtUsuarios" style="width:200px">
                    <option value="" >Seleccione usuarios </option>
                    <?php 
                        $sql = "SELECT us.id_usuario, CONCAT(us.nombre, ' ', us.apellido, ' / ', us.cargo) AS nombre_completo FROM usuario us INNER JOIN seccion se ON us.id_seccion=se.id_seccion WHERE se.id_dependencia =:id_dependencia ORDER BY nombre_completo ASC";
                        $response = $data->query($sql, array("id_dependencia" => $_SESSION["id_dependencia"])); 
                        foreach($response['items'] as $datos){ 
                    ?>
                    <option value="<?php echo($datos['id_usuario']); ?>"><?php echo($datos['nombre_completo']); ?>
                    </option>
                    <?php } ?>
                  </select>

                </div>
              </div>
            <div class="form-group col-md-3">
                <label>Fecha desde:</label>
                <input type="text" class="form-control datepicker" name="txtDesdeUU" id="txtDesdeUU" placeholder="yyyy-mm-dd" readonly>
              </div>
              <div class="form-group col-md-3">
                <label>Fecha hasta:</label>
                <input type="text" class="form-control datepicker" name="txtHastaUU" id="txtHastaUU" placeholder="yyyy-mm-dd" readonly>
              </div>
              <div class="form-group col-md-12">
                <button type="submit" id="guardar4" name="guardar4" class="btn btn-primary btn-block"><span class="glyphicon glyphicon-file"></span> Generar reporte</button>
              </div>
            </div>
          </form>
        </div>
      </div>
    </div>
    <!-- Ventana para Estadistica -->
    <div class="box span9">
      <div class="box-header" data-original-title="">
        <h2><i class="halflings-icon white list"></i><span class="break"></span>Reporte por descargo</h2>
        <div class="box-icon">
          <a href="#" class="btn-minimize"><i class="halflings-icon white chevron-up"></i></a>
          <!--<a href="#"  onclick="closePorEmp(this)"><i class="halflings-icon white remove"></i></a>-->
        </div>
      </div>
      <div class="box-content">
        <div class="tab-pane active" id="vist_per">
          <div class="box-content">
            <div id="reporte4" style="height: 545px;">
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<div id="formulario5">
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
          <form role="form" method="POST" name="frmcargosgeneral" id="frmcargosgeneral" autocomplete="off" enctype="multipart/form-data" onsubmit="return false">
            <div style="height: 525px;">
               <div class="form-group col-md-3">
                <label>Fecha desde:</label>
                <input type="text" class="form-control datepicker" name="txtDesdeUUU" id="txtDesdeUUU" placeholder="yyyy-mm-dd" readonly>
              </div>
              <div class="form-group col-md-3">
                <label>Fecha hasta:</label>
                <input type="text" class="form-control datepicker" name="txtHastaUUU" id="txtHastaUUU" placeholder="yyyy-mm-dd" readonly>
              </div>
              <div class="form-group col-md-12">
                <button type="submit" id="guardar5" name="guardar5" class="btn btn-primary btn-block"><span class="glyphicon glyphicon-file"></span> Generar reporte</button>
              </div>
            </div>
          </form>
        </div>
        </div>
    </div>
    <!-- Ventana para Estadistica -->
    <div class="box span9">
      <div class="box-header" data-original-title="">
        <h2><i class="halflings-icon white list"></i><span class="break"></span>Reporte por descargo general</h2>
        <div class="box-icon">
          <a href="#" class="btn-minimize"><i class="halflings-icon white chevron-up"></i></a>
          <!--<a href="#"  onclick="closePorEmp(this)"><i class="halflings-icon white remove"></i></a>-->
        </div>
      </div>
      <div class="box-content">
        <div class="tab-pane active" id="vist_per">
          <div class="box-content">
            <div id="reporte5" style="height: 545px;">
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>