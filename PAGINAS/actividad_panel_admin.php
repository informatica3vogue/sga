<!-- <script type="text/javascript">
$(document).ready(function () {
    $('#formulario1').show();
    $('#formulario2').hide();
    $('#formulario3').hide();
    $('#link1').click(function () {
      $('#formulario1').show();
      $('#formulario2').hide();
      $('#formulario3').hide();
    });
    $('#link2').click(function () {
      $('#formulario1').hide();
      $('#formulario2').show();
      $('#formulario3').hide();
    });
    $('#link3').click(function () {
      $('#formulario1').hide();
      $('#formulario2').hide();
      $('#formulario3').show();
    });
});

// Funcion que nos permitira cargar el combo de la secciones dependiendo de la dependencia
$(document).ready(function () {
   var miselect = $('#txtSeccion');
   miselect.empty();
   miselect.find('option').remove().end().append('<option value="">Seleccione una sección</option>').val('');
   $.post("procesos/store_seccion.php", 
    { "id_dependencia": <?php echo $_SESSION["id_dependencia"] ?> },
     function (data) {
      var datos = data.items;
       for (var i = 0; i < data.total; i++) {
           miselect.append('<option value="' + datos[i].id_seccion + '">' + datos[i].seccion + '</option>');
       }
 }, 'json');
});

//cargar combo de usuarios asignados 
$(document).ready(function () {
    $.post("procesos/actividades/store_usuarios_dependencia.php", 
        function(data){
        var data=JSON.parse(data);
        var resultado=data.items;
        var total=resultado.length;
        $('#txtUsuario').select2("val","");
        var opciones='<option value="">Seleccione una opcion</option>';
        for(var i=0; i<total; i++){
            opciones+="<option value='"+resultado[i].id_usuario+"'>"+resultado[i].nombre_completo+"</option>";
        }
        $('#txtUsuario').html(opciones);
    });         
});

// Funcion que nos permitira mandar los datos a ingresar
$(document).ready(function () {
    $('#guardar').click(function () {
      $.validate({
            onSuccess : function(form) {
              var formulario = $('#frmIngresadas').serializeArray();
              var tipo = $('#txtEstado').val();
              var seccion = $('#txtSeccion').val();
              if (seccion == '' && tipo == '') {
                  var ruta = 'reportes/actividades_generales_admin.php';
              }else{
                if (seccion != '') {
                  if (tipo != '') {
                    var ruta = 'reportes/actividades_seccion_estado.php';
                  }else{
                    var ruta = 'reportes/actividades_seccion_admin.php';
                  }
                }else{
                   var ruta = 'reportes/actividades_estado.php';
                }
              }
               $.ajax({
                  data: formulario,
                  dataType: 'json',
                  type: 'POST',
                  url: ruta,
                  beforeSend: function () {
                      document.getElementById('reporte1').innerHTML=('<br><br><center><br><p>Generando reporte...</p></center><br><br>');
                  },
                  success: function(response){
                    if(response.success == true) {
                        document.getElementById('reporte1').innerHTML=(''+response.link+'');
                    }else{
                        document.getElementById('reporte1').innerHTML=(response.error);
                    }
                  },
                  error: function() {
                      document.getElementById('reporte1').innerHTML=('<br><br><center><br><p>Lo sentimos... <br> Ocurrio un error al realizar la transaccion tiempo de espera agotado</p></center><br><br>');
                  }
              });
            }
        });
    });
});

// Funcion que nos permitira mandar los datos a ingresar
$(document).ready(function () {
    $('#guardar2').click(function () {
      $.validate({
            onSuccess : function(form) {
              var formulario = $('#frmIngresadasUs').serializeArray();
              var tipo = $('#txtEstados').val();
              var usuario = $('#txtUsuario').val();
              if (usuario == '' && tipo == '') {
                  var ruta = 'reportes/actividades_generales_admin.php';
              }else{
                if (usuario != '') {
                  if (tipo != '') {
                    var ruta = 'reportes/actividades_usuario_estado.php';
                  }else{
                    var ruta = 'reportes/actividades_usuario_admin.php';
                  }
                }else{
                   var ruta = 'reportes/actividades_estado.php';
                }
              }
             $.ajax({
                  data: formulario,
                  dataType: 'json',
                  type: 'POST',
                  url: ruta,
                  beforeSend: function () {
                      document.getElementById('reporte2').innerHTML=('<br><br><center><br><p>Generando reporte...</p></center><br><br>');
                  },
                  success: function(response){
                    if(response.success == true) {
                        document.getElementById('reporte2').innerHTML=(''+response.link+'');
                    }else{
                        document.getElementById('reporte2').innerHTML=(response.error);
                    }
                  },
                  error: function() {
                      document.getElementById('reporte2').innerHTML=('<br><br><center><br><p>Lo sentimos... <br> Ocurrio un error al realizar la transaccion tiempo de espera agotado</p></center><br><br>');
                  }
              });
            }
        });
    });
});

$(document).ready(function () {
    $('#guardar3').click(function () {
       $.validate({
            onSuccess : function(form) {
        var formulario = $('#frmActividad').serializeArray();
        $.ajax({
            data: formulario,
            dataType: 'json',
            type: 'POST',
            url: 'reportes/actividades_referencia.php',
            beforeSend: function () {
                document.getElementById('reporte3').innerHTML=('<br><br><center><br><p>Generando reporte...</p></center><br><br>');
            },
            success: function(response){
              if(response.success == true) {
                  document.getElementById('reporte3').innerHTML=(''+response.link+'');
              }else{
                  document.getElementById('reporte3').innerHTML=(response.error);
              }
            },
            error: function() {
                document.getElementById('reporte3').innerHTML=('<br><br><center><br><p>Lo sentimos... <br> Ocurrio un error al realizar la transaccion tiempo de espera agotado</p></center><br><br>');
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
            $('#txtHasta').datepicker('option', {dateFormat: 'yy-mm-dd'});
        }
    });
    $( "#txtHasta" ).datepicker({
        defaultDate: "+1w",
        changeMonth: true,
        numberOfMonths: 1,
        onClose: function( selectedDate ) {
            $( "#txtDesde" ).datepicker( "option", "maxDate", selectedDate );
            $('#txtDesde').datepicker('option', {dateFormat: 'yy-mm-dd'});
        }
    });
});



$(function() {
    $( "#txtDesdeUno" ).datepicker({
        defaultDate: "+1w",
        changeMonth: true,
        numberOfMonths: 1,
        onClose: function( selectedDate ) {
            $( "#txtHastaUno" ).datepicker( "option", "minDate", selectedDate );
            $('#txtHastaUno').datepicker('option', {dateFormat: 'yy-mm-dd'});
        }
    });
    $( "#txtHastaUno" ).datepicker({
        defaultDate: "+1w",
        changeMonth: true,
        numberOfMonths: 1,
        onClose: function( selectedDate ) {
            $( "#txtDesdeUno" ).datepicker( "option", "maxDate", selectedDate );
            $('#txtDesdeUno').datepicker('option', {dateFormat: 'yy-mm-dd'});
        }
    });
});
</script>
 --><!-- start submenu -->
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