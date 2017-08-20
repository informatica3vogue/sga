<script type="text/javascript">
   $(document).ready(function () {
       document.getElementById("porCargoBodega").style.display ="block";
       document.getElementById("repPorDescargo").style.display ="none";
   });
   function actPorCargBo(objOrigen){
   document.getElementById("porCargoBodega").style.display ="block";
    document.getElementById("repPorDescargo").style.display ="none";
   }
   function actPorDescBo(objOrigen){
   document.getElementById("repPorDescargo").style.display ="block";
    document.getElementById("porCargoBodega").style.display ="none";
   // document.getElementById("menu").style.display ="none";
   }
  
$(document).ready(function () {
    $('#guardar2').click(function () {
            $.validate({
            onSuccess : function(form) {
        var formulario = $('#frmCargoBodega').serializeArray();
        var usuario = $('#txtUsuario').val();
        if (usuario == '') {
            ruta = 'reportes/rep_cargo_bodega_gral.php';
        }else{
            ruta = 'reportes/rep_cargo_bodega.php';
        }
        $.ajax({
            type: 'POST',
            dataType: 'json',
            url: ruta,
            data: formulario,
        }).done(function (response) {
            if(response.success == true) {
                document.getElementById('reporte2').innerHTML=(''+response.link+'');
            }else{
                document.getElementById('reporte2').innerHTML=(response.error);
            }
        });
      }
    });
    });
});

$(document).ready(function () {
    $('#guardar3').click(function () {
        var formulario = $('#frmporDesc').serializeArray();
          $.validate({
            onSuccess : function(form) {
        var usuario = $('#txtUsuarios').val();
        if (usuario == '') {
            ruta = 'reportes/rep_descargo_bodega_gral.php';
        }else{
            ruta = 'reportes/rep_descargo_bodega.php';
        }
        $.ajax({
            type: 'POST',
            dataType: 'json',
            url: ruta,
            data: formulario,
        }).done(function (response) {
            if(response.success == true) {
                document.getElementById('reporte3').innerHTML=(''+response.link+'');
            }else{
                document.getElementById('reporte3').innerHTML=(response.error);
            }
        });
      }
    });
    });
});



$(function() {
    $( "#txtDesde" ).datepicker({
        defaultDate: "+1w",
        changeMonth: true,
        numberOfMonths: 1,
        onClose: function( selectedDate ) {
            $( "#txtHasta" ).datepicker( "option", "minDate", selectedDate );
            $('#txtHasta').datepicker('option', {dateFormat: 'yy/mm/dd'});
        }
    });
    $( "#txtHasta" ).datepicker({
        defaultDate: "+1w",
        changeMonth: true,
        numberOfMonths: 1,
        onClose: function( selectedDate ) {
            $( "#txtDesde" ).datepicker( "option", "maxDate", selectedDate );
            $('#txtDesde').datepicker('option', {dateFormat: 'yy/mm/dd'});
        }
    });
});

$(function() {
    $( "#txtDesdes" ).datepicker({
        defaultDate: "+1w",
        changeMonth: true,
        numberOfMonths: 1,
        onClose: function( selectedDate ) {
            $( "#txtHastas" ).datepicker( "option", "minDate", selectedDate );
            $('#txtHastas').datepicker('option', {dateFormat: 'yy/mm/dd'});
        }
    });
    $( "#txtHastas" ).datepicker({
        defaultDate: "+1w",
        changeMonth: true,
        numberOfMonths: 1,
        onClose: function( selectedDate ) {
            $( "#txtDesdes" ).datepicker( "option", "maxDate", selectedDate );
            $('#txtDesdes').datepicker('option', {dateFormat: 'yy/mm/dd'});
        }
    });
});

</script>
<!-- start submenu -->
<ul class="breadcrumb">
  <a href="?mod=compdescargos_bod" class="icon-list-alt" title="Volver a bodega"><font color="#2E64FE">&nbsp;Volver a bodega</font></a> &nbsp;&nbsp;&nbsp;|&nbsp;&nbsp;&nbsp;
  <a href="#" onclick="actPorCargBo(this)"  class="icon-bar-chart" title="Reporte de cargos de articulos">&nbsp;Reporte de cargos de articulos</a> &nbsp;&nbsp;&nbsp;|&nbsp;&nbsp;&nbsp;
  <a href="#" onclick="actPorDescBo(this)" class="icon-group" title="Reporte de descargo de articulos">&nbsp;Reporte de descargo de articulos</a>
</ul>
<div id="porCargoBodega">
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
        <div class="box-content" style="height: 560px;">
          <form role="form" method="POST" name="frmCargoBodega" id="frmCargoBodega" autocomplete="off" enctype="multipart/form-data" onsubmit="return false">
              <div class="form-group">
                <label>Fecha desde:</label>
                <input type="text" class="form-control datepicker" name="txtDesde" id="txtDesde" data-validation="required" data-validation-error-msg="rellene este campo" style="width: 95%; background: #fff;" placeholder="Seleccione una fecha" readonly>
              </div>
              <div class="form-group">
                <label>Fecha hasta:</label>
                <input type="text" class="form-control datepicker" name="txtHasta" id="txtHasta" data-validation="required" data-validation-error-msg="rellene este campo" style="width: 95%; background: #fff;" placeholder="Seleccione una fecha" readonly>
              </div>
              <div class="form-group">
                <label>Usuario: </label>
              <select class="form-control select2" name="txtUsuario" id="txtUsuario" style="width: 100%;" data-placeholder="Seleccione un usuario">
                    <option value="" >Seleccione usuarios </option>
                    <?php 
                        $sql = "SELECT us.id_usuario, CONCAT(us.nombre, ' ', us.apellido) AS nombre_completo FROM usuario us INNER JOIN seccion se ON us.id_seccion=se.id_seccion WHERE se.id_dependencia =:id_dependencia ORDER BY nombre_completo ASC";
                        $response = $data->query($sql, array("id_dependencia" => $_SESSION["id_dependencia"])); 
                        foreach($response['items'] as $datos){ 
                    ?>
                    <option value="<?php echo($datos['id_usuario']); ?>"><?php echo($datos['nombre_completo']); ?>
                    </option>
                    <?php } ?>
                  </select>
              </div>
              <br>
              <br>
              <div class="form-group">
                <button type="submit" id="guardar2" name="guardar2" class="btn btn-primary btn-block"><span class="glyphicon glyphicon-file"></span> Generar reporte</button>
              </div>
          </form>
        </div>
    </div>
    <!-- Ventana para Estadistica -->
    <div class="box span9">
      <div class="box-header" data-original-title="">
        <h2><i class="halflings-icon white list"></i><span class="break"></span>Vista previa, reporte de cargo de bodega</h2>
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
<div id="repPorDescargo">
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
        <div class="box-content" style="height: 560px;">
          <form role="form" method="POST" name="frmporDesc" id="frmporDesc" autocomplete="off" enctype="multipart/form-data" onsubmit="return false">
              <div class="form-group">
                <label>Fecha desde:</label>
                <input type="text" class="form-control datepicker" name="txtDesdes" id="txtDesdes" data-validation="required" data-validation-error-msg="rellene este campo" style="width: 95%; background: #fff;" placeholder="Seleccione una fecha" readonly>
              </div>
              <div class="form-group">
                <label>Fecha hasta:</label>
                <input type="text" class="form-control datepicker" name="txtHastas" id="txtHastas" data-validation="required" data-validation-error-msg="rellene este campo" style="width: 95%; background: #fff;" placeholder="Seleccione una fecha" readonly>
              </div>
              <div class="form-group">
                <label>Usuario: </label>
              <select class="form-control select2" name="txtUsuarios" id="txtUsuarios" style="width: 100%;" data-placeholder="Seleccione un usuario">
                    <option value="" >Seleccione usuarios </option>
                    <?php 
                        $sql = "SELECT us.id_usuario, CONCAT(us.nombre, ' ', us.apellido) AS nombre_completo FROM usuario us INNER JOIN seccion se ON us.id_seccion=se.id_seccion WHERE se.id_dependencia =:id_dependencia ORDER BY nombre_completo ASC";
                        $response = $data->query($sql, array("id_dependencia" => $_SESSION["id_dependencia"])); 
                        foreach($response['items'] as $datos){ 
                    ?>
                    <option value="<?php echo($datos['id_usuario']); ?>"><?php echo($datos['nombre_completo']); ?>
                    </option>
                    <?php } ?>
                  </select>
              </div>
              <br>
              <br>
              <div class="form-group">
                <button type="submit" id="guardar3" name="guardar3" class="btn btn-primary btn-block"><span class="glyphicon glyphicon-file"></span> Generar reporte</button>
              </div>
          </form>
        </div>
    </div>
    <!-- Ventana para Estadistica -->
    <div class="box span9">
      <div class="box-header" data-original-title="">
        <h2><i class="halflings-icon white list"></i><span class="break"></span>Vista previa, reporte de descargo de bodega</h2>
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