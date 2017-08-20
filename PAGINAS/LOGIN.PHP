<script type="text/javascript">
// Funcion que nos permitira mandar los datos a ingresar
$(document).ready(function () {
    $('#Ingresar').click(function () {
        var formulario = $('#frmLogin').serializeArray();
        $.ajax({
            type: 'POST',
            dataType: 'json',
            url: 'procesos/autenticar.php',
            data: formulario,
        }).done(function (response) {
            if(response.success == true) {
                $.alert(response.mensaje, { title: response.titulo, icon: 'circle-check', buttons: { 'Aceptar': function () { $(this).dialog("close"); }}});
                location.href =response.modulo;
            }else{
                $.alert(response.mensaje, { title: response.titulo, icon: 'circle-close', buttons: { 'Cerrar': function () { $(this).dialog("close"); }}});
            }
        });
    });
});
</script> 
<center><section class="position">   
   <section class="container1">
        <form name="frmLogin" id="frmLogin" method="POST" autocomplete="off" onSubmit="return false">
            <table class="container2">
                <tr>
                    <td colspan="3" class="header"> 
                        <label>Sistema de Gesti&oacute;n de Actividades</label>
                    </td>
                </tr>
                <tr style="background: #ffffff;">
                    <td colspan="3">
                        <center><img src="img/CSJ_login.png"></center>
                    </td>
                </tr>
                <tr>
                    <td  class="form">
                        <center>
                            <table>
                                <tr>
                                    <td><input type="text" id="txtusuario" name="txtusuario" placeholder="Usuario" required="true" autofocus="true"></td>
                                    <td><input type="password" id="txtpassword" name="txtpassword" placeholder="Contraseña" required="true"></td>
                                    <td><input type="image" src="img/boton_login.png" name="Ingresar" id="Ingresar"></td>
                                </tr>
                            </table>
                        </center>   
                    </td>
                </tr>
            </table>
        </form>
    </section>
</section></center>