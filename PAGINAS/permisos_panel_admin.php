<script type="text/javascript">
  $(document).ready(function () {     
     document.getElementById("porEmpleadoDiasF").style.display ="none";
     document.getElementById("porMotivo").style.display ="block";
  });
  
  
  //Seleccionar ventana motivo
  function actPorMot(objOrigen){
  document.getElementById("porMotivo").style.display ="block";
  document.getElementById("porEmpleadoDiasF").style.display ="none"; 
  
  } 

  function actPorGrals(objOrigen){
  document.getElementById("porEmpleadoDiasF").style.display ="block"; 
  document.getElementById("porMotivo").style.display ="none";
  
  }
  //cerrar ventana 
  function closePorGrals(objOrigen){
   document.getElementById("porEmpleadoDiasF").style.display ="none";
   
  }
  
  
  $(document).ready(function () {
  $('#guardar1').click(function () {
    $.validate({
            onSuccess : function(form) {
      var formulario = $('#frmMotivos').serializeArray();
      var empleado = $('#txtNombreEmpleado').val();
      var motivo = $('#txtMotivo').val();
       if (empleado == '' && motivo == '') {
            var ruta = 'reportes/rep_generales_per.php';
        }else{
          if (empleado == '') {
            var ruta = 'reportes/rep_omision_permisos.php';
          }else if (motivo == ''){
            var ruta = 'reportes/rep_empleados_permisos.php';
          }else{
            var ruta = 'reportes/rep_motivos_permisos.php';
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
  
  
   $(document).ready(function () {
  $('#guardar6').click(function () {
      var formulario = $('#porEmpleadoG').serializeArray();
      $.ajax({
          type: 'POST',
          dataType: 'json',
          url: 'reportes/rep_dias_faltantes.php',
          data: formulario,
      }).done(function (response) {
          if(response.success == true) {
              document.getElementById('reporte6').innerHTML=(''+response.link+'');
          }else{
              document.getElementById('reporte6').innerHTML=(response.error);
          }
      });
  });
  });

   // Funcion que nos permitira cargar el combo de motivos
function store_motivo(id_motivo){
    $.post("procesos/store_motivo.php", 
        function(data){
        var data=JSON.parse(data);
        var resultado=data.items;
        var total=resultado.length;
        var opciones='<option value="">Seleccione un motivo</option>';
        for(var i=0; i<total; i++){
            if (resultado[i].id_motivo == id_motivo) {
                opciones+="<option selected value='"+resultado[i].id_motivo+"'>"+resultado[i].motivo+"</option>";
            }else{
                opciones+="<option value='"+resultado[i].id_motivo+"'>"+resultado[i].motivo+"</option>";
            }
        }
        $('#txtMotivo').html(opciones);
    });  
}
$(document).ready(function () {
    store_motivo(0);
});

//cargar combo de usuarios asignados 
$(document).ready(function () {
    $.post("procesos/store_empleados.php", 
        function(data){
        var data=JSON.parse(data);
        var resultado=data.items;
        var total=resultado.length;
        $('#txtNombreEmpleado').select2("val","");
        var opciones='<option value="">Seleccione una opcion</option>';
        for(var i=0; i<total; i++){
            opciones+="<option value='"+resultado[i].id_empleado+"'>"+resultado[i].nombre_completo+"</option>";
        }
        $('#txtNombreEmpleado').html(opciones);
    });         
});
 
//cargar combo de usuarios asignados 
$(document).ready(function () {
    $.post("procesos/store_empleados.php", 
        function(data){
        var data=JSON.parse(data);
        var resultado=data.items;
        var total=resultado.length;
        $('#txtNombreEmp').select2("val","");
        var opciones='<option value="">Seleccione una opcion</option>';
        for(var i=0; i<total; i++){
            opciones+="<option value='"+resultado[i].id_empleado+"'>"+resultado[i].nombre_completo+"</option>";
        }
        $('#txtNombreEmp').html(opciones);
    });         
});

$(function() {
 $( "#txtDesdeDD" ).datepicker({
     defaultDate: "+1w",
     changeMonth: true,
     numberOfMonths: 1,
     onClose: function( selectedDate ) {
         $( "#txtHastaDD" ).datepicker( "option", "minDate", selectedDate );
         $('#txtHastaDD').datepicker('option', {dateFormat: 'yy/mm/dd'});
     }
 });
 $( "#txtHastaDD" ).datepicker({
     defaultDate: "+1w",
     changeMonth: true,
     numberOfMonths: 1,
     onClose: function( selectedDate ) {
         $( "#txtDesdeDD" ).datepicker( "option", "maxDate", selectedDate );
         $('#txtDesdeDD').datepicker('option', {dateFormat: 'yy/mm/dd'});
     }
 });
});
</script>
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