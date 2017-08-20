<?php 

/**
 * Description of data
 * Copyright(c) 2013 CSJ.OJ, EL SALVADOR
 * @author ING. GERMAN ALFONSO GARCIA GARCIA
 **/

include_once ("class.managerDB.php");

class data {

    #Constructor
    function data() {      
    }
    
    # Ejecuta consultas SQL
    # Parametros:
    #   sql: consulta sql  (requerido)
    #   params: Array asociativo GET o POST (sino se especifica params_list se utiliza el array completo)
    #   params_list: Lista de parametros para la consulta
    #   transaction: True o False para usar mysql con rollback
    #   strip_tags: True o False para eliminar las etiquetas HTML de la consulta sql
    function query ($sql, $params=array(), $param_list=array(), $transaction=false, $strip_tags=false, 
        $database="mysql") {
        $managerDB = new managerDB();
        $connection = $managerDB->conectar($database);
        if ($connection!=null) {
            $response=array('success'=>true);
            try {
                $query=$connection->prepare($sql);
                foreach ($param_list as $param) {
                    if ($param=='start' or $param=='limit') {
                        @$query->bindParam(':'.$param, intval($params[$param]), PDO::PARAM_INT);
                    } else {
                        if ($strip_tags)    $params[$param]=strip_tags($params[$param]);
                        @$query->bindParam(':'.$param, $params[$param]);
                    }
                }
                if ($transaction) $connection->beginTransaction();
                if (count($param_list)>0) {
                    $query->execute();
                } else {
                    $query->execute($params);
                }
                if ($transaction) {
                    $response['insertId']=intval($connection->lastInsertId());
                    $connection->commit();
                }
                $response['items']=$query->fetchAll(PDO::FETCH_ASSOC);
                $response['total']=$query->rowCount();
            } catch(PDOException $error) { 
                if ($transaction) $connection->rollback();
                $response= array('success'=>false, 'error'=>$error->getMessage());
            }
        } else {
            $response= array('success'=>false, 'error'=>'No está conectado al servidor de bases de datos.');
        }
        return $response;
        unset($connection);
        unset($query);
    }

    #Función para renombrar y subir adjuntos a un directorio
    function upload($name, $tmp_name, $destiny){
        $character =  array(' ', '_', '-', '(', ')', '[', ']');
        $actually_name = strtolower(str_replace($character,'',$name)); 
        $ext = pathinfo($actually_name, PATHINFO_EXTENSION);
        $name_clean = substr($actually_name,0,strlen($actually_name)-(strlen($ext)+1));
        $new_name = $name_clean."-".md5(date('d-m-Y H:i:s').rand(0, 100000)).".".$ext; 
        $destiny = $destiny.$new_name;
        if(@copy($tmp_name, $destiny)){
            $response = array('success' => true, 'file'=>$new_name);
        }else{
            $response = array('success' => false, 'file'=>$name, 'error'=> 'No se subio el archivo adjunto');
        }
        return $response;
    }

    function format_string($string) {
      $string = $this->clearAccents($string);
      $string =ucwords(strtolower($string));
      foreach (array(',', ' ') as $delimiter) {
        if (strpos($string, $delimiter)!==false) {
          $string =implode($delimiter, array_map('ucfirst', explode($delimiter, $string)));
        }
      }
      return $string;
    }

    function clearAccents($string) {
      $bad = array("á","é","í","ó","ú","Á","É","Í","Ó","Ú","ñ","À","Ã","Ì","Ò","Ù","Ã™","Ã ","Ã¨","Ã¬","Ã²","Ã¹","ç","Ç","Ã¢","ê","Ã®","Ã´","Ã»","Ã‚","ÃŠ","ÃŽ","Ã”","Ã›","ü","Ã¶","Ã–","Ã¯","Ã¤","«","Ò","Ã","Ã„","Ã‹","ñ","Ñ");
      $good = array("a","e","i","o","u","A","E","I","O","U","n","N","A","E","I","O","U","a","e","i","o","u","c","C","a","e","i","o","u","A","E","I","O","U","u","o","O","i","a","e","U","I","A","E","&ntilde;","&ntilde;");
      $string = str_replace($bad, $good ,$string);
      return $string;
    }

    function clearString($string) {
        $string = trim($string);
        $string = strtr($string, "ÀÁÂÃÄÅàáâãäåÒÓÔÕÖØòóôõöøÈÉÊËèéêëÇçÌÍÎÏìíîïÙÚÛÜùúûüÿÑñ", "aaaaaaaaaaaaooooooooooooeeeeeeeecciiiiiiiiuuuuuuuuynn");
        $string = strtr($string,"ABCDEFGHIJKLMNOPQRSTUVWXYZ","abcdefghijklmnopqrstuvwxyz");
        $string = preg_replace('#([^.a-z0-9]+)#i', ' ', $string);
        $string = preg_replace('#-{2,}#','-',$string);
        $string = preg_replace('#-$#','',$string);
        $string = preg_replace('#^-#','',$string);
        //$string = strtoupper($string);
        return $string;
    }

     #Función para generar referencia de actividad
    function generar_referencia_acti($abreviatura, $id_dependencia){
        $referencia = "";
        $anio = date("Y");
        $sql = "SELECT DISTINCT referencia FROM actividad WHERE id_actividad = (SELECT MAX(a.id_actividad) FROM actividad a INNER JOIN seccion s ON s.id_seccion=a.id_seccion WHERE s.id_dependencia = :id_dependencia)";
        $response = $this->query($sql, array("id_dependencia"=>$id_dependencia));
        $ref = ($response["total"] > 0) ? $response["items"][0]["referencia"] : "";
        if ($ref != "") {
            $var = explode("-", $ref);
            $num_ref = (date("Y", strtotime($var[2])) == $anio) ? (intval($var[1]) + 1) : 1;
            $referencia = $abreviatura."-".$num_ref."-".$anio;
        }else{
            $referencia = $abreviatura."-1-".$anio;
        }
        return $referencia;
    }

    #Función para generar referencia de memorandum
    function generar_referencia_memo($abreviatura, $id_dependencia, $tipo){
      $referencia = "";
      $anio = date("Y");
      $sql = "SELECT DISTINCT referencia FROM memorandum WHERE id_memorandum = (SELECT MAX(m.id_memorandum) FROM memorandum m WHERE m.id_dependencia=:id_dependencia AND m.tipo_memorandum = :tipo)";
      $response = $this->query($sql, array("id_dependencia"=>$id_dependencia, "tipo"=>$tipo));
      $ref = ($response["total"] > 0) ? $response["items"][0]["referencia"] : "";
      if ($ref != "") {
        $var = explode("-", $ref);
        $num_ref = (date("Y", strtotime($var[2])) == $anio) ? (intval($var[1]) + 1) : 1;
        $referencia = $abreviatura."-".$num_ref."-".$anio;
      }else{
        $referencia = $abreviatura."-1-".$anio;
      }
      return $referencia;
    }
    
    #Función para devolver nombre de dependencia mediante el id_dependencia
    function nombre_dependencia($id_dependencia){
        $sql = 'select dependencia from bddependencias.dependencia where id_dependencia=:id_dependencia';
        $response = $this->query($sql, array('id_dependencia'=>$id_dependencia), array());
        if ($response["total"] == 0) {
            $sql = 'select dependencia from dependencia where id_dependencia=:id_dependencia';
            $response = $this->query($sql, array('id_dependencia'=>$id_dependencia), array());
        }
        $dependencia = ($response["total"] > 0) ? $response["items"][0]["dependencia"] : '';
        return $dependencia;
    }
}    
?>        