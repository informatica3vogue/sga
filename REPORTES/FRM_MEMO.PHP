<script type="text/javascript">
   $(document).ready(function () {
      document.getElementById("repPendientes").style.display ="none";
      document.getElementById("repPorUsuario").style.display ="none";
      document.getElementById("repPorActi").style.display ="none";
      document.getElementById("repPorSec").style.display ="none";
   });
   //seleccionar ventana
   function actPorEmp(objOrigen){
   document.getElementById("repPendientes").style.display ="block";
   // document.getElementById("menu").style.display ="none";
    document.getElementById("repPorUsuario").style.display ="none";
     document.getElementById("repPorActi").style.display ="none";
       document.getElementById("repPorSec").style.display ="none";
   }
   //cerrar ventana 
   function closePorEmp(objOrigen){
    document.getElementById("repPendientes").style.display ="none";
   }
   function actPorUs(objOrigen){
   document.getElementById("repPorUsuario").style.display ="block";
     document.getElementById("repPendientes").style.display ="none";
    document.getElementById("repPorActi").style.display ="none";
    document.getElementById("repPorSec").style.display ="none";
   }
   //cerrar ventana 
   function closePorUs(objOrigen){
    document.getElementById("repPorUsuario").style.display ="none";
   }
   function actPorActi(objOrigen){
   document.getElementById("repPorActi").style.display ="block";
    document.getElementById("repPendientes").style.display ="none";
    document.getElementById("repPorUsuario").style.display ="none";
    document.getElementById("repPorSec").style.display ="none";
   // document.getElementById("menu").style.display ="none";
   }
   //cerrar ventana 
   function closePorActi(objOrigen){
    document.getElementById("repPorActi").style.display ="none";
   }

    function actPorSec(objOrigen){
   document.getElementById("repPorSec").style.display ="block";
    document.getElementById("repPendientes").style.display ="none";
    document.getElementById("repPorUsuario").style.display ="none";
    document.getElementById("repPorActi").style.display ="none";
   }
   //cerrar ventana 
   function closePorSec(objOrigen){
    document.getElementById("repPorSec").style.display ="none";
   }
    
   //Funcion para realizar la busqueda del empleado por nombre, apellido, usuario, dependencia
   function busqueda_empleado(txtBuscar) {
       document.getElementById('grid').innerHTML='';    
       var parametros = {
           'txtBuscar': txtBuscar
       };
       $.ajax({
           data: parametros,
           url: 'procesos/buscar_empleado_permiso_rep.php',
           type: 'POST',
           beforeSend: function () {
               document.getElementById('grid').innerHTML=('<br><br><center>Cargando datos, espere por favor...</center><br><br>');
           },
           success: function(response){
               var datos = JSON.parse(response);
               document.getElementById('grid').innerHTML=(datos.grid);
           }
       });
   }
   // Funcion que nos cargara la tabla de seguimientos realizados
   function verPermisos(pagina, id_empleado){   
   var parametros = {
       "pagina": pagina,
       "id_empleado": id_empleado
   };           
   $.ajax({
       type: 'POST',
       data: parametros,
       url: 'procesos/store_permiso_por_empleado.php',
       beforeSend: function () {
          document.getElementById('grid3').innerHTML=('<br><br><center>Cargando datos, espere por favor...</center><br><br>');
       },
       success: function(response3){
           var datos = JSON.parse(response3);
           document.getElementById('grid3').innerHTML=(datos.grid3);
           document.getElementById('txtnom').value=datos.nombre;
           document.getElementById('txtcod').value=datos.codigo;
           document.getElementById('paginador3').innerHTML=(datos.paginador3);
       }
   });
   }
   $(document).ready(function(){    
   $('.pagination_seg li#activo2').live('click',function(){
       var pagina = $(this).attr('p');
       var id_empleado = $(this).attr('act');
       verPermisos(pagina, id_empleado);
   });           
   });
   // Funcion que nos permitira cargar el combo de la secciones dependiendo de la dependencia
   $(document).ready(function () {
       var miselect = $('#txtSeccion');
       miselect.empty();
       miselect.find('option').remove().end().append('<option value="">Seleccione una sección</option>').val('');
       $.post("procesos/store_seccion.php?id_dependencia="+<?php echo $_SESSION["id_dependencia"]; ?>+"&id_seccion="+false,
           function (data) {
               for (var i = 0; i < data.length; i++) {
                   miselect.append('<option ' + data[i].selected + ' value="' + data[i].value + '">' + data[i].label + '</option>');
               }
       }, 'json');
   });
   // Funcion que nos permitira mandar los datos a ingresar
$(document).ready(function () {
    $('#guardar').click(function () {
        var formulario = $('#frmrepmemoRangoFech').serializeArray();
        $.ajax({
            type: 'POST',
            dataType: 'json',
            url: 'reportes/rep_memo_rango.php',
            data: formulario,
        }).done(function (response) {
            if(response.success == true) {
                document.getElementById('reporte1').innerHTML=(''+response.link+'');
            }else{
                document.getElementById('reporte1').innerHTML=(response.error);
            }
        });
    });
});


// Funcion que nos permitira mandar los datos a ingresar
$(document).ready(function () {
    $('#guardar2').click(function () {
        var formulario = $('#FrmTipo').serializeArray();
        var tipo = $('#tipo_memorandum').val();
        if (tipo == 'Externo') {
          var ruta = 'reportes/rep_memo.php';
        }else{
          var ruta = 'reportes/rep_memo.php';
        }
        $.ajax({
            type: 'POST',
            dataType: 'json',
            url: ruta,
            data: formulario,
        }).done(function (response) {
            if(response.success == true) {
                document.getElementById('reportesMemo').innerHTML=(''+response.link+'');
            }else{
                document.getElementById('reportesMemo').innerHTML=(response.error);
            }
        });
    });
});
$(document).ready(function () {
    $('#guardar3').click(function () {
        var formulario = $('#frmtipoMemo').serializeArray();
        $.ajax({
            type: 'POST',
            dataType: 'json',
            url: 'reportes/rep_memo_tipo.php',
            data: formulario,
        }).done(function (response) {
            if(response.success == true) {
                document.getElementById('reporte3').innerHTML=(''+response.link+'');
            }else{
                document.getElementById('reporte3').innerHTML=(response.error);
            }
        });
    });
});

$(document).ready(function () {
    $('#guardar4').click(function () {
        var formulario = $('#frmtipoMemos').serializeArray();
        $.ajax({
            type: 'POST',
            dataType: 'json',
            url: 'reportes/rep_memo_tipo_dos.php',
            data: formulario,
        }).done(function (response) {
            if(response.success == true) {
                document.getElementById('reporte4').innerHTML=(''+response.link+'');
            }else{
                document.getElementById('reporte4').innerHTML=(response.error);
            }
        });
    });
});



$(function() {
    $( "#txtDesdeD" ).datepicker({
        defaultDate: "+1w",
        changeMonth: true,
        numberOfMonths: 1,
        onClose: function( selectedDate ) {
            $( "#txtHastaD" ).datepicker( "option", "minDate", selectedDate );
            $('#txtHastaD').datepicker('option', {dateFormat: 'yy/mm/dd'});
        }
    });
    $( "#txtHastaD" ).datepicker({
        defaultDate: "+1w",
        changeMonth: true,
        numberOfMonths: 1,
        onClose: function( selectedDate ) {
            $( "#txtDesdeD" ).datepicker( "option", "maxDate", selectedDate );
            $('#txtDesdeD').datepicker('option', {dateFormat: 'yy/mm/dd'});
        }
    });
});



</script>
<!-- start submenu -->
<ul class="breadcrumb">
    <a href="?mod=memorandum" class="icon-folder-open" title="Permiso">&nbsp;Ir a Memorandúm</a>
</ul>
<div class="row-fluid sortable ">
  <div id="menu">
    <div class="box blue span12">
      <div class="box-header">
        <h2><i class="halflings-icon white folder-open"></i><span class="break"></span>Reportes</h2>
        <div class="box-icon">
          <a href="#" class="btn-minimize"><i class="halflings-icon white chevron-up"></i></a>
        </div>
      </div>
      <div class="box-content">
        <!-- ////////////////////////////////////////////////////-->
        <div class="box-content center">
          <a onclick="actPorEmp(this)" class="quick-button span2">
          <i class="icon-calendar"></i>
          <p>
             Por rango de fechas
          </p>
          <!--<span class="notification blue">1.367</span>-->
          </a>
          <a onclick="actPorUs(this)" class="quick-button span2">
          <i class="icon-group"></i>
          <p>
             Por persona
          </p>
          </a>
          <a onclick="actPorActi(this)" class="quick-button span2">
           <i class="icon-list-ol"></i>
          <p>
             Por tipo
          </p>
          <!--<span class="notification red">68</span>-->
          </a>
            <a onclick="actPorSec(this)" class="quick-button span2">
          <i class="icon-th-list"></i>
          <p>
             Por seccion
         </p>
          <!--<span class="notification red">68</span>-->
          </a>
          <div class="clearfix">
          </div>
        </div>
      </div>
    </div>
  </div>
</div>


<div id="repPendientes">
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
          <form role="form" method="POST" name="frmrepmemoRangoFech" id="frmrepmemoRangoFech" autocomplete="off" enctype="multipart/form-data" onsubmit="return false">
            <div style="height: 525px;">
              <div class="form-group col-md-3">
                <label>Fecha desde:</label>
                <input type="text" class="form-control datepicker" name="txtDesdeD" id="txtDesdeD" style="width:195px" placeholder="yyyy-mm-dd" readonly>
              </div>
              <div class="form-group col-md-3">
                <label>Fecha hasta:</label>
                <input type="text" class="form-control datepicker" name="txtHastaD" id="txtHastaD" style="width:195px" placeholder="yyyy-mm-dd" readonly>
              </div>
              </br> 
              </br> 
              <div class="form-group col-md-12">
                <button type="submit" id="guardar" name="guardar" class="btn btn-primary btn-block"><span class="glyphicon glyphicon-file"></span> Generar reporte</button>
              </div>
            </div>
          </form>
        </div>
      </div>
    </div>
    <!-- Ventana para Estadistica -->
    <div class="box span9">
      <div class="box-header" data-original-title="">
        <h2><i class="halflings-icon white list"></i><span class="break"></span>Reporte</h2>
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
<div id="repPorUsuario">
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
          <form role="form" method="POST" name="FrmTipo" id="FrmTipo" autocomplete="off" enctype="multipart/form-data" onsubmit="return false">
            <div style="height: 525px;">
              <div class="form-group col-md-3">
                <label>Empleado: </label>
                <div class="btn-group">
                  <select data-rel="chosen" name="txtUsuario" id="txtUsuario">
                    <option value="" >Seleccione usuarios </option>
                    <?php 
                        $sql = "SELECT id_usuario, CONCAT(nombre, ' ', apellido, ' / ', cargo) AS nombre_completo FROM usuario WHERE id_seccion = :id_seccion ORDER BY nombre_completo ASC";
                        $response = $data->query($sql, array("id_seccion" => $_SESSION["id_seccion"])); 
                        foreach($response['items'] as $datos){ 
                    ?>
                    <option value="<?php echo($datos['id_usuario']); ?>"><?php echo($datos['nombre_completo']); ?>
                    </option>
                    <?php } ?>
                  </select>
                </div>
              </div> 
              </br>
              </br>
              <div class="form-group col-md-4">
                        <label>Tipo:</label>
                        <select class="form-control" name="tipo_memorandum" id="tipo_memorandum" style="width:210px;" required>
                            <option value="">Seleccione un tipo</option>
                            <option value="Externo">Externo</option>
                            <option value="Interno">Interno</option>
                        </select>
                    </div>
                    <br>
                    <br>
              <div class="form-group col-md-12">
                <button type="submit" id="guardar2" name="guardar2" class="btn btn-primary btn-block"><span class="glyphicon glyphicon-file"></span> Generar reporte</button>
              </div>
            </div>
          </form>
      </div>
    </div>
    <!-- Ventana para Estadistica -->
    <div class="box span9">
      <div class="box-header" data-original-title="">
        <h2><i class="halflings-icon white list"></i><span class="break"></span>Reporte</h2>
        <div class="box-icon">
          <a href="#" class="btn-minimize"><i class="halflings-icon white chevron-up"></i></a>
          <!--<a href="#"  onclick="closePorEmp(this)"><i class="halflings-icon white remove"></i></a>-->
        </div>
      </div>
      <div class="box-content">
        <div class="tab-pane active" id="vist_per">
          <div class="box-content">
            <div id="reportesMemo" style="height: 545px;">
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
<div id="repPorActi">
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
          <form role="form" method="POST" name="frmtipoMemo" id="frmtipoMemo" autocomplete="off" enctype="multipart/form-data" onsubmit="return false">
            <div style="height: 525px;">
              <div class="form-group col-md-4">
                        <label>Tipo:</label>
                        <select class="form-control" name="tipo_memorandum" id="tipo_memorandum" style="width:190px;" required>
                            <option value="">Seleccione un tipo</option>
                            <option value="Externo">Externo</option>
                            <option value="Interno">Interno</option>
                        </select>
                    </div>
                  </br> 
                  </br> 
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
        <h2><i class="halflings-icon white list"></i><span class="break"></span>Reporte</h2>
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

<div id="repPorSec">
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
          <form role="form" method="POST" name="frmtipoMemos" id="frmtipoMemos" autocomplete="off" enctype="multipart/form-data" onsubmit="return false">
            <div style="height: 525px;">
              <div class="form-group col-md-4">
                <label>Sección: </label>
                <select class="form-control" name="txtSeccion" id="txtSeccion" style="width:200px">
                  <option value="">Seleccione una sección</option>
                </select>
              </div>
              </br>
              </br>
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
        <h2><i class="halflings-icon white list"></i><span class="break"></span>Reporte</h2>
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