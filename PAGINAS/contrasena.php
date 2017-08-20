<script language="javaScript">
    $(document).ready(function () {
        $.validate({
            modules : 'security',
            onModulesLoaded : function() {
                var optionalConfig = {
                    fontSize: '9pt',
                    padding: '4px',
                    bad : 'Débil',
                    weak : 'Media',
                    good : 'Buena',
                    strong : 'Fuerte'
                };
                $('#txtPassword').displayPasswordStrength(optionalConfig);
            }
        });
    });

//funcion enviar datos a agregar
    $(document).ready(function () {
        $("#guardar").click(function () {
            $.validate({
                onSuccess: function(){
                    //Guardar en variables el valor que tengan las cajas de texto Por medio de los id's Y tener mejor manipulación de dichos valores
                    var formulario = $("#frmContrasena").serializeArray();
                    $.ajax({
                        type: "POST",
                        dataType: 'json',
                        url: "procesos/cambioContrasena.php",
                        data: formulario,
                    }).done(function (response) {
                        if (response.success == false) {
                            bootbox.alert(response.mensaje, function() { });
                        } else {
                            bootbox.alert(response.mensaje, function() {location.href = "?mod=logout"; });
                        }
                    });
                },
            });
        });//click
    });//ready 
</script>
<div class="row-fluid sortable">
    <div class="box span12">
        <div class="box-header" data-original-title>
            <h2><i class="halflings-icon exclamation-sign white"></i><span class="break"></span>Cambio de contraseña</h2>
            <div class="box-icon">
                <a href="#" class="btn-minimize"><i class="halflings-icon white chevron-up"></i></a>
            </div>
        </div>
        <div class="box-content">
            <section class="col-md-12">
            <div class="panel-body">
                <form id="frmContrasena" method="POST" name="frmContrasena" role="form" autocomplete="off" onsubmit="return false" >
                    <div class="form-group">
                        <div class="col-md-12">
                            <label class="control-label">Contraseña actual: </label>
                            <input type="password" name="txtActual" class="form-control" id="txtActual" placeholder="*******" data-validation="required" data-validation-error-msg="rellene este campo">
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-md-12">
                            <label class="control-label">Nueva contraseña: </label>
                            <input type="password" name="txtPassword" class="form-control" id="txtPassword" placeholder="*******" data-validation="length" data-validation-length="min5" data-validation-error-msg="La cantidad mínima de caracteres son 5">
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-md-12">
                            <label class="control-label">Repetir nueva contraseña: </label>
                            <input type="password" name="txtRePassword" class="form-control" id="txtRePassword" placeholder="*******" data-validation="confirmation" data-validation-confirm="txtPassword" data-validation-error-msg="Las contraseñas no coinciden">
                        </div>
                    </div>
                   
                    <div class="form-actions">
                        <button type="reset" class="btn btn-primary" id="limpiar" value='Limpiar'>Limpiar</button>
                        <button type='submit' class="btn btn-primary pull-right" id='guardar' value='Guardar'>Guardar</button>
                    </div>
                </form>
            </div>
            </section>
        </div>
    </div>
    <!--/span-->
</div>
                