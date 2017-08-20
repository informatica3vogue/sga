<script>
	
	//Vista detalle solicitud por empleado
function getGET(){
        var loc = document.location.href;
        if(loc.indexOf('?')>0){
            var getString = loc.split('?')[1];
            var GET = getString.split('&');
            var get = {};
            for(var i = 0, l = GET.length; i < l; i++){
                var tmp = GET[i].split('=');
                get[tmp[0]] = unescape(decodeURI(tmp[1]));
            }
            return get;
        }
    }
    window.onload = function(){
        var get=getGET();
        $.ajax({
            type: 'POST',
            dataType: 'json',
            url: "reportes/rep_solicitud.php",
            data: get ,
        }).done(function (response) {
            if(response.success == true) {
                document.getElementById('versolicitud').innerHTML=(''+response.link+'');
            }else{
                document.getElementById('versolicitud').innerHTML=(response.error);
            }
        });
    }

</script>
<div class="row-fluid">
            <ul class="breadcrumb">
                <a href="?mod=insumos" class="icon-edit" title="Crear solicitud">&nbsp;&nbsp;Crear solicitud</a>
                &nbsp;&nbsp;&nbsp;|&nbsp;&nbsp;&nbsp;
                <a href="?mod=cinsumos" class="icon-edit" title="Catalogos">&nbsp;&nbsp;Ir a catalogos</a>
            </ul>
            <div class="box blue span12">
                <div class="box-header">
                    <h2><i class="halflings-icon white white tasks"></i><span class="break"></span>Comprobante</h2>
                </div>
<div class="box-content">
	<div style="height: 800px;" id="versolicitud">
		
	</div>

</div></div></div>