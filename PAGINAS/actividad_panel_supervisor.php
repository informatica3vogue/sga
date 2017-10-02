<script type="text/javascript">
   $(document).ready(function () {
       document.getElementById("repPorUsuario").style.display ="block";
       document.getElementById("repPorActi").style.display ="none";
   });
   function actPorUs(objOrigen){
   document.getElementById("repPorUsuario").style.display ="block";
    document.getElementById("repPorActi").style.display ="none";
   // document.getElementById("menu").style.display ="none";
   }
   //cerrar ventana 
   function closePorUs(objOrigen){
    document.getElementById("repPorUsuario").style.display ="none";
   }
   function actPorActi(objOrigen){
   document.getElementById("repPorActi").style.display ="block";
    document.getElementById("repPorUsuario").style.display ="none";
   // document.getElementById("menu").style.display ="none";
   }
   //cerrar ventana 
   function closePorActi(objOrigen){
    document.getElementById("repPorActi").style.display ="none";
   }

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

// Funcion que nos permitira mandar los datos a ingresar
$(document).ready(function () {
    $('#guardar').click(function () {
      $.validate({
            onSuccess : function(form) {
              var formulario = $('#frmIngresadas').serializeArray();
              var tipo = $('#txtEstados').val();
              var seccion = $('#txtSeccion').val();
              if (seccion == '' && tipo == '') {
                  var ruta = 'reportes/rep_generales_act.php';
              }else{
                if (seccion != '') {
                  if (tipo == 'Pendiente') {
                    var ruta = 'reportes/rep_pendientes.php';
                  }else if (tipo == 'Finalizado') {
                    var ruta = 'reportes/rep_finalizadas.php';
                  }
                  else{
                    var ruta = 'reportes/rep_act_global.php';
                  }
                }else{
                   var ruta = 'reportes/rep_estado_act.php';
                }
              }
              $.ajax({
                  type: 'POST',
                  dataType: 'json',
                  url: ruta,
                  data: formulario,
              }).done(function (response) {
                  if(response.success == true) {
                      document.getElementById('reporte1').innerHTML=(''+response.link+'');
                  }else{
                      document.getElementById('reporte1').innerHTML=(response.error);
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
              var tipo = $('#txtEstado').val();
              var usuario = $('#txtUsuario').val();
              if (usuario == '' && tipo == '') {
                  var ruta = 'reportes/rep_generales_act_sup.php';
              }else{
                if (usuario != '') {
                  if (tipo == 'Pendiente') {
                    var ruta = 'reportes/rep_aupendientes.php';
                  }else if (tipo == 'Finalizado') {
                    var ruta = 'reportes/rep_afpendientes.php';
                  }
                  else{
                    var ruta = 'reportes/rep_us_act_global.php';
                  }
                }else{
                   var ruta = 'reportes/rep_estado_seccion_act.php';
                }
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
       $.validate({
            onSuccess : function(form) {
        var formulario = $('#frmActividad').serializeArray();
        $.ajax({
            type: 'POST',
            dataType: 'json',
            url: 'reportes/rep_actividad_supervisor.php',
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
    $( "#txtDesdeUno" ).datepicker({
        defaultDate: "+1w",
        changeMonth: true,
        numberOfMonths: 1,
        onClose: function( selectedDate ) {
            $( "#txtHastaUno" ).datepicker( "option", "minDate", selectedDate );
            $('#txtHastaUno').datepicker('option', {dateFormat: 'yy/mm/dd'});
        }
    });
    $( "#txtHastaUno" ).datepicker({
        defaultDate: "+1w",
        changeMonth: true,
        numberOfMonths: 1,
        onClose: function( selectedDate ) {
            $( "#txtDesdeUno" ).datepicker( "option", "maxDate", selectedDate );
            $('#txtDesdeUno').datepicker('option', {dateFormat: 'yy/mm/dd'});
        }
    });
});

//cargar combo de usuarios asignados 
$(document).ready(function () {
    $.post("procesos/store_usuarios.php", 
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
</script>
<!-- start submenu -->
<ul class="breadcrumb">
  <a href="?mod=actividades" class="icon-list-alt" title="Ir a actividades"><font color="#2E64FE">&nbsp;Volver a actividades</font></a> &nbsp;&nbsp;&nbsp;|&nbsp;&nbsp;&nbsp;
  <a href="#" onclick="actPorUs(this)" class="icon-group" title="Reporte actividades por usuario">&nbsp;Reporte actividades por usuario</a> &nbsp;&nbsp;&nbsp;|&nbsp;&nbsp;&nbsp;
  <a href="#" onclick="actPorActi(this)" class="icon-font" title="Reporte por referencia de actividad">&nbsp;Reporte por referencia de actividad</a>
</ul>

<div id="repPorUsuario" style="display: none;">
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
                <input type="text" class="form-control datepicker" name="txtDesdeUno" id="txtDesdeUno" style="width: 95%; background: #fff;" data-validation="required" data-validation-error-msg="rellene este campo" placeholder="Seleccione una fecha" readonly>
              </div>
              <div class="form-group">
                <label>Fecha hasta:</label>
                <input type="text" class="form-control datepicker" name="txtHastaUno" id="txtHastaUno" style="width: 95%; background: #fff;" data-validation="required" data-validation-error-msg="rellene este campo" placeholder="Seleccione una fecha" readonly>
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
                <select class="form-control" name="txtEstado" id="txtEstado">
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
<div id="repPorActi" style="display: none;">
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