<br/>
<div class="container-fluid">
    <div class="row">
        <br><br>
        <div class="col-md-12">
            <div class="alert alert-block alert alert-success">
                <br>
                <font color="green"><h1>La página solicitada no existe.</h1></font>
                <br>
                Si usted tecleó el URL manualmente, por favor revise su ortografía,<br> 
                Compruebe que la dirección no tiene errores de escritura del tipo ww.ejmplo.com en lugar de www.ejemplo.com y vuélvalo a intentar<br>
                <h3><strong>ERROR 404.</strong></h3>                          
            </div>
        </div>
    </div>
</div>
<?php 
$data = new data();
$var = $data->format_string('Este es un texto con ñ , / &');
echo $var;
/*
$caf = 3312141;

$cod = substr($caf, 0, 2);
$correlativo = substr($caf, 2, strlen($caf)-2);

$sql = "SELECT * FROM CONSOL WHERE COD = :cod AND CORRELATIVO=:correlativo";
$param_caf = array('cod'=>$cod,'correlativo'=>$correlativo);
$response = $data->query($sql, $param_caf, array(), false, false, 'access');

print_r($response);



echo("<br>");
$dependencia = $data->nombre_dependencia(1250);
echo $dependencia;
//funcion mysql para iniciales mayusculas///////////////
DELIMITER $$

DROP FUNCTION IF EXISTS `control_actividades`.`INITCAP`$$

CREATE FUNCTION `INITCAP`(x char(30)) RETURNS char(30) CHARSET utf8
BEGIN
SET @str='';
SET @l_str='';
WHILE x REGEXP ' ' DO
SELECT SUBSTRING_INDEX(x, ' ', 1) INTO @l_str;
SELECT SUBSTRING(x, LOCATE(' ', x)+1) INTO x;
SELECT CONCAT(@str, ' ', CONCAT(UPPER(SUBSTRING(@l_str,1,1)),LOWER(SUBSTRING(@l_str,2)))) INTO @str;
END WHILE;
RETURN LTRIM(CONCAT(@str, ' ', CONCAT(UPPER(SUBSTRING(x,1,1)),LOWER(SUBSTRING(x,2)))));
END$$

DELIMITER ;

//////////////////////////////////////////////////////////

/*
$i = 0;
$k = 0;
$no_movidos = array();

$sql = "select ruta_modulo from modulos where plantilla = 'desktop.php'";
$response = $data->query($sql);
foreach ($response["items"] as $result) {
    $archivo = $result["ruta_modulo"];
    $origen = "paginas/".$archivo;  
    $destino = "modulos/".$archivo;
    if(@copy($origen, $destino)){
        $i++;
    }else{
        $k++;  
        $no_movidos[] = $archivo;  
    }
}

echo $i."<br>";
echo $k."<br>";
print_r($no_movidos);

$cont = 0;
$i = 600;
$params = array();
$data = new data();
$response = $data->query('select * from actividad where id_seccion = 7 order by id_seccion asc limit 600,800');
foreach ($response['items'] as $datos) {
    $params["referencia"] = 'ACJZ-'.($i+1).'-2016';
    $response_update = $data->query('update actividad set referencia = :referencia where id_actividad = :id_actividad', array('referencia'=>$params['referencia'], 'id_actividad'=>$datos['id_actividad']), array(), true);
    if ($response_update['success'] == true) {
        $cont++;
        $i++;
    }
}
echo $cont;
*/
?>