<script type="text/javascript"> 
// Funcion que nos cargara la tabla de memorandum tipo externo
function store_memorandum(pagina){   
    var parametros = {
        "pagina": pagina
    };           
    $.ajax({
        type: 'POST',
        data: parametros,
        url: 'procesos/memorandum/store_memorandum_interno.php',
        beforeSend: function () {
           document.getElementById('grid').innerHTML=('<br><br><center>Cargando datos, espere por favor...</center><br><br>');
        },
        success: function(response){
            var datos = JSON.parse(response);
            document.getElementById('grid').innerHTML=(datos.grid);
            document.getElementById('paginador').innerHTML=(datos.paginador);
        }
    });
}
$(document).ready(function(){    
    store_memorandum(1); //Cargar primera pagina por defecto
    $('#paginacion_interno li#activo2').live('click',function(){
        var pagina = $(this).attr('p');
        store_memorandum(pagina);
    });           
});
// Funcion que nos cargara la tabla de memorandum tipo externo
function store_memorandum_externo(pagina){   
    var parametros = {
        "pagina": pagina
    };           
    $.ajax({
        type: 'POST',
        data: parametros,
        url: 'procesos/memorandum/store_memorandum_externo.php',
        beforeSend: function () {
           document.getElementById('grid2').innerHTML=('<br><br><center>Cargando datos, espere por favor...</center><br><br>');
        },
        success: function(response2){
            var datos = JSON.parse(response2);
            document.getElementById('grid2').innerHTML=(datos.grid2);
            document.getElementById('paginador2').innerHTML=(datos.paginador2);
        }
    });
}
$(document).ready(function(){    
    store_memorandum_externo(1); //Cargar primera pagina por defecto
    $('#pagination_externo li#activo1').live('click',function(){
        var pagina = $(this).attr('p');
        store_memorandum_externo(pagina);
    });           
});

//Funcion para realizar la busqueda del usuario por nombre, apellido, usuario, dependencia
function busqueda_memo(txtBuscar) {
    document.getElementById('grid').innerHTML='';    
    var parametros = {
        'txtBuscar': txtBuscar       
    };
    $.ajax({
        data: parametros,
        url: 'procesos/memorandum/buscar_memorandum_interno.php',
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
//Funcion para realizar la busqueda del usuario por nombre, apellido, usuario, dependencia
function busqueda_memo_externo(txtBuscar_externo) {
    document.getElementById('grid2').innerHTML='';    
    var parametros = {
        'txtBuscar_externo': txtBuscar_externo       
    };
    $.ajax({
        data: parametros,
        url: 'procesos/memorandum/buscar_memorandum_externo.php',
        type: 'POST',
        beforeSend: function () {
            document.getElementById('grid2').innerHTML=('<br><br><center>Cargando datos, espere por favor...</center><br><br>');
        },
        success: function(response2){
            var datos = JSON.parse(response2);
            document.getElementById('grid2').innerHTML=(datos.grid2);
        }
    });
}

// Funcion que nos permitira mandar los datos a ingresar
function verpdf(id_memorandum, tipo){ 
        $.ajax({
            type: 'POST',
            dataType: 'json',
            url: "reportes/memo_pdf.php",
            data: {id:id_memorandum, tipo:tipo} ,
        }).done(function (response) {
            document.getElementById('verpdf').innerHTML=" ";
            if(response.success == true) {
                document.getElementById('verpdf').innerHTML=(''+response.link+'');
            }else{
                document.getElementById('verpdf').innerHTML=(response.error);
            }
        });
 }

</script>
<!-- *********************************************************************************  -->
<!-- start submenu -->
<ul class="breadcrumb">
   <!-- <a href="#" class="icon-plus" data-toggle='modal' data-target='#modal_ingreso_actividad' title="Crear Memorándum">&nbsp;Crear Memorándum</a> &nbsp;&nbsp;&nbsp;|&nbsp;&nbsp;&nbsp;-->
    <a href="?mod=imemo" class="icon-folder-open" title="crear">&nbsp;Crear memorándum</a> &nbsp;&nbsp;&nbsp;|&nbsp;&nbsp;&nbsp;
    <a href="?mod=grupos_creados" class="icon-folder-open" title="crear">&nbsp;Ver grupos creados</a>&nbsp;&nbsp;&nbsp;|&nbsp;&nbsp;&nbsp;
    <a href="?mod=memo_grupo" class="icon-group" title="crear">&nbsp;Crear grupo para memorándum</a>&nbsp;&nbsp;&nbsp;
    <!--<a href="?mod=repmemorandum" class="icon-folder-open" title="reportes">&nbsp;Ir a Reportes</a>-->
</ul>
<div class="row-fluid sortable ui-sortable">
    <div class="span6">
        <!-- Contenedor de Memorándum Internos -->
        <div class="row-fluid">
            <div class="box">
                <div class="box-header">
                    <h2><i class="icon-bar-chart white list"></i><span class="break"></span>Memorándum Internos</h2>
                    <div class="box-icon">
                        <a href="#" class="btn-setting" data-rel="tooltip" title="Actualizar" onClick="store_memorandum(1, $('#txtMemorandum').val())"><i class="halflings-icon white refresh"></i></a>
                        <a href="#" class="btn-minimize" data-rel="tooltip" title="Minimizar"><i class="halflings-icon white chevron-up"></i></a>                        
                    </div>
                </div>
                <div class="box-content">
                <div class="input-append">
                    <form onSubmit="busqueda_memo($('#txtBuscar').val(), $('#txtMemorandum').val()); return false;" autocomplete="off">
                        <input type="text" size="16" placeholder="Buscar memor&aacute;ndum" id="txtBuscar" name="txtBuscar">
                        <button type="submit" class="btn btn-success" id="buscar"><span class="halflings-icon search white"></span></button>
                    </form>                                                       
                </div>
                    <div class="priority high">
                        <span>Internos</span>
                    </div>
                    <div id="grid">
                        <!-- Llena Memorándum Internos -->
                    </div>
                    <div id="paginador">
                    </div>
                </div>
            </div>
            <!--/span-->
        </div>
        <!--/row-->
        <!-- Contenedor de Memorándum Externos -->
        <div class="row-fluid">
            <div class="box">
                <div class="box-header">
                    <h2><i class="icon-bar-chart white list"></i><span class="break"></span>Memorándum Externos</h2>
                    <div class="box-icon">
                        <a href="#" class="btn-setting" data-rel="tooltip" title="Actualizar" onClick="store_memorandum_externo(1, $('#txtMemorandum').val())"><i class="halflings-icon white refresh"></i></a>
                        <a href="#" class="btn-minimize" data-rel="tooltip" title="Minimizar"><i class="halflings-icon white chevron-up"></i></a>
                    </div>
                </div>
                <div class="box-content">
                <div class="input-append">
                     <form onSubmit="busqueda_memo_externo($('#txtBuscar_externo').val(), $('#txtMemorandum').val()); return false;" autocomplete="off">
                        <input type="text" size="16" placeholder="Buscar memor&aacute;ndum" id="txtBuscar_externo" name="txtBuscar_externo">
                        <button type="submit" class="btn btn-success" id="buscar"><span class="halflings-icon search white"></span></button>
                    </form>
                </div>
                    <div class="priority low">
                        <span>Externos</span>
                    </div>
                    <div id="grid2">
                        <!-- Llena Memorándum Externos -->
                    </div>
                    <div id="paginador2">
                    </div>
                </div>
            </div>
            <!--/span-->
        </div>
        <!--/row-->
    </div>
    <!--Linea de tiempo-->
    <div class="span6">
        <div class="row-fluid sortable">
            <div class="box">
                <div class="box-header">
                    <h2><i class="icon-bar-chart white list"></i><span class="break"></span>PDF</h2>
                    <div class="box-icon">
                        <a href="#" class="btn-minimize" data-rel="tooltip" title="Minimizar"><i class="halflings-icon white chevron-up"></i></a>
                    </div>
                </div>
                <div class="box-content" style="display: block; height: 1010px; overflow-x: auto;">
                    <div style="width: 100%; margin: auto;">
                        <div id="verpdf" style="height:910px;">
                            <!-- Llena seguimiento de actividades -->
                        </div>
                    </div>
                </div>
            </div>
            <!--/span-->
        </div>
        <!--/row-->
    </div>
</div>