<?php 
 //Funcion para cerra sesion luego de 600 milisegundos equivalentes a 10 minutos
$timeout = 600; 
    if (isset($_SESSION['start_time'])) {
        $elapsed_time = time() - $_SESSION['start_time'];
        if ($elapsed_time >= $timeout) {
            header('Location:?mod=logout');
        }
    }
    $_SESSION['start_time'] = time();  
?> 