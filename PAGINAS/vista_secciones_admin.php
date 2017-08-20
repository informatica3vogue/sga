<script type="text/javascript">
  $(document).ready(function () {     
     document.getElementById("ingreso").style.display ="none";
     document.getElementById("vista").style.display ="block";
  });
  
  
  //Seleccionar ventana motivo
  function vista(objOrigen){
  document.getElementById("vista").style.display ="block";
  document.getElementById("ingreso").style.display ="none"; 
  
  } 

  function ingreso(objOrigen){
  document.getElementById("ingreso").style.display ="block"; 
  document.getElementById("vista").style.display ="none";
  }
</script>
<ul class="breadcrumb">
  <a href="#" onclick="ingreso(this)" class="icon-edit" title="Ingresar nueva seccion">&nbsp;&nbsp;Ingresar nueva seccion</a>&nbsp;&nbsp;&nbsp;|&nbsp;&nbsp;&nbsp;
  <a href="#" onclick="vista(this)" class="icon-edit" title="Ver secciones ingresadas">&nbsp;&nbsp;Ver secciones ingresadas</a>
</ul>


<?php
                $cont = 1;  
                $response = $dataTable->obtener_Secciones($_SESSION["id_dependencia"]);
                $abreviatura = (isset($response["items"][0]["abreviatura"])) ? $response["items"][0]["abreviatura"] : "";
?>
<div id="vista" style="display: block;">
  <div class="row-fluid">
    <div class="box span12">
      <div class="box-header" data-original-title="">
        <h2><i class="halflings-icon white list"></i><span class="break"></span>Secciones</h2>
        <div class="box-icon">
          <a href="#" class="btn-minimize"><i class="halflings-icon white chevron-up"></i></a>
        </div>
      </div>
      <div class="box-content">
                    <div class="navbar-form navbar-left" role="search">
                <div class="form-group span12">
                    <label>Abreviatura de dependencia para referencia: </label>
                    <input type="text" class="form-control" name="txtAbreviatura2" value="<?php echo $abreviatura ?>" id="txtAbreviatura2" disabled="true">
                </div>
            </div>
            <div class='table-responsive' width='100%'>
            <table class='table table-hover table-bordered table-condensed bootstrap-datatable'>
                <thead class='ticket blue'>
                    <tr>
                        <th width='5%' style="padding: 8px;">N°</th>
                        <th width='85%' style="padding: 8px;">Sección</th>
                        <th width='10%' style="padding: 8px;">Acciones</th>
                    </tr> 
                </thead>
                <tbody>
                <?php    
                    foreach($response['items'] as $datos){?>
                <tr>
                    <td>
                        <?php echo $cont ?>
                    </td>
                    <td>
                        <?php echo $datos['seccion'] ?>
                    </td>
                    <td class="center">
                        <a class="btn btn-success" data-rel="tooltip" title='Editar seccion' data-toggle='modal' data-target='#modal_secc_mod' onclick="modificar(<?php echo $datos['id_seccion'] ?>, '<?php echo $datos['seccion'] ?>');"> <i class="halflings-icon white edit"></i>
                        </a>
                        <a class="btn btn-danger" data-rel="tooltip" title='Eliminar seccion' data-toggle='modal' data-target='#modal_dependencia' href="#" onclick="eliminar(<?php echo $datos['id_seccion'] ?>, '<?php echo $datos['seccion'] ?>');"> <i class="halflings-icon white trash"></i>
                        </a>
                    </td>
                </tr>
                <?php  
$cont ++;
} ?>
                </tbody>
            </table>
        </div>
      </div>
    </div>
  </div>
</div>


<div id="ingreso" style="display: none;">
  <div class="row-fluid">
    <div class="box span12">
    <div class="box-header" data-original-title="">
      <h2><i class="halflings-icon white list"></i><span class="break"></span>Ingreso de secciones</h2>
      <div class="box-icon">
        <a href="#" class="btn-minimize"><i class="halflings-icon white chevron-up"></i></a>
      </div>
    </div>
    <div class="box-content">
      <form role="form" method="POST" name="frmSeccion" id="frmSeccion" autocomplete="off" enctype="multipart/form-data">
                <div class="form-group span10">
                    <label>Secci&oacute;n: </label>
                    <input type="text" class="form-control" name="txtSecciones" id="txtSecciones" placeholder="Digite una seccion">
                </div>
                <div class="form-group span2">
                    <label>&nbsp;</label>
                    <button type="button" class="btn btn-success btn-block" onclick="add()">+ Agregar</button>
                </div>
                <div style="clear:both;"></div>
                <div class="table-responsive">
                    <table class='table table-striped table-bordered table-hover' style="margin-bottom:0;">
                    <thead class="ticket blue">
                    <tr>
                        <th width="8%">
                             N°
                        </th>
                        <th width="84%">
                             Secci&oacute;n
                        </th>
                        <th width="8%">
                             Acción
                        </th>
                    </tr>
                    </thead>
                    </table>
                    <div style="height:200px; top: 0; overflow-y:scroll; overflow-x:hidden;">
                        <table class='table table-striped table-bordered table-hover'>
                        <tbody id="detalle_seccion">
                        </tbody>
                        </table>
                    </div>
                </div>
                <div style="clear:both;"></div>
            <div class="form-actions">
                <button type="button" id="cancelar" name="cancelar" onClick="location.href='?mod=csystemsecc'" class="btn btn-danger pull-left">Cancelar</button>
                <button type="button" id="guardar_seccion" name="guardar_seccion" class="btn btn-primary pull-right">Guardar</button>
            </div>
            </form>
    </div>
   </div>
  </div>
</div>

<!-- Ventana Modal para el cambio de estado del usuario -->
<div class="modal hide fade" id="modal_dependencia">
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">×</button>
        <h3>Confirme eliminar</h3>
    </div>
    <div class="modal-body">
        <!--Formulario de modal-->
        <form role="form" method="POST" name="frmEliminar" id="frmEliminar">
                <input type="hidden" id="txtId3" name="txtId3">
                <div class="form-group">
                    <label>Desea eliminar la sección:</label>
                    <input type="text" id="seccion" name="seccion" class="form-control" disabled="true">
                </div>
        </form>
    </div>
    <div class="modal-footer">
        <button type="button" class="btn btn-danger pull-left" data-dismiss="modal">Cancelar</button>
        <button type="submit" id="eliminar" name="eliminar" class="btn btn-primary">Eliminar</button>
    </div>
</div>
<!-- Ventana Modal para el cambio de estado del usuario -->
<div class="modal hide fade" id="modal_secc_mod">
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">×</button>
        <h3>Modificar sección</h3>
    </div>
    <div class="modal-body">
        <!--Formulario de modal-->
        <form role="form" method="POST" name="frmModificar" id="frmModificar">
                <input type="hidden" id="txtId4" name="txtId4">
                <div class="form-group">
                    <label>Sección:</label>
                    <input type="text" id="txtSeccionActual" name="txtSeccionActual" class="form-control">
                </div>
        </form>
    </div>
    <div class="modal-footer">
        <button type="button" class="btn btn-danger pull-left" data-dismiss="modal">Cancelar</button>
        <button type="submit" id="guardar_mod" name="guardar_mod" class="btn btn-primary">Guardar</button>
    </div>
</div>
<script type="text/javascript">
// Funcion que nos permitira mandar los datos a ingresar de secciones
$(document).ready(function () {
    $('#guardar_seccion').click(function () {
        var formulario = $('#frmSeccion').serializeArray();
        $.ajax({
            type: 'POST',
            dataType: 'json',
            url: 'procesos/guardar_seccion.php',
            data: formulario,
        }).done(function (response) {                
            if(response.success == false) {
               bootbox.alert(response.mensaje, function() { });
            }else{
                bootbox.alert(response.mensaje, function() { location.href = "?mod=dependencia"; }); 
            }
        });
    });
});

//qutias articulos de tabla
function quitar(seccion){
    if(seccion!=""){
        $.ajax({
            url: "procesos/quitar_secciones.php",
            type: "POST",
            dataType: "json",
            data: {"seccion": seccion}
        }).done(function(data){
            total=data.length;
            var opciones;
            var n=0;
            if(total>0){
                for(var i=0; i<total; i++){
                    n++;
                     opciones+="<tr><td width='8%'>"+n+"</td><td width='84%'>"+data[i].seccion+"</td><td width='6.8%'><a href='#' class='btn btn-danger' onclick=\"quitar('"+data[i].seccion+"');\"><i class='halflings-icon white trash'></a></td></tr>";
                }
                $('#detalle_seccion').html(opciones);
            }else{
                $('#detalle_seccion').html("");
            }
        });
    }
}

//añadis articulos a tabla
function add(){
    var seccion=$("#txtSecciones").val();
    if(seccion==""){
        bootbox.alert('Digite una seccion, por favor', function() {  });
    }else{
        $.ajax({
            url: "procesos/agregar_secciones.php",
            type: "POST",
            dataType: "json",
            data: {"seccion": seccion}
        }).done(function(data){
            total=data.length;
            var opciones;
            var n=0;
            if(total>0){
                for(var i=0; i<total; i++){
                    n++;
                    opciones+="<tr><td width='8%'>"+n+"</td><td width='84%'>"+data[i].seccion+"</td><td width='6.8%'><a href='#' class='btn btn-danger' onclick=\"quitar('"+data[i].seccion+"');\"><i class='halflings-icon white trash'></a></td></tr>";
                }
                $('#detalle_seccion').html(opciones);
            }            
        });
    }
}

//Funcion para cargar ventana modal 
function eliminar(id_seccion, seccion){
    document.getElementById("txtId3").value=id_seccion;
    document.getElementById("seccion").value=seccion;
}

// Funcion que nos permitira cambiar el estado del usuario
$(document).ready(function () {
    $('#eliminar').click(function () {
        var formulario = $('#frmEliminar').serializeArray();
        $.ajax({
            type: 'POST',
            dataType: 'json',
            url: 'procesos/eliminar_seccion.php',
            data: formulario,
        }).done(function (response) {
            if(response.success == true) {
                bootbox.alert(response.mensaje, function() { location.href = "?mod=dependencia"; });
            }else{
                bootbox.alert(response.mensaje, function() { });
            }
        });
    });
});

//Funcion para cargar ventana modal 
function modificar(id, seccion){
    document.getElementById('txtId4').value = id;
    document.getElementById("txtSeccionActual").value=seccion;
}

// Funcion que nos permitira cambiar el estado del usuario
$(document).ready(function () {
    $('#guardar_mod').click(function () {
        var formulario = $('#frmModificar').serializeArray();
        $.ajax({
            type: 'POST',
            dataType: 'json',
            url: 'procesos/modificar_seccion.php',
            data: formulario,
        }).done(function (response) {
            if(response.success == true) {
                bootbox.alert(response.mensaje, function() { location.href = "?mod=dependencia"; });
            }else{
                bootbox.alert(response.mensaje, function() { });
            }
        });
    });
});

</script>