<?php
ob_start();
session_start();
$_SESSION['detalle_descargo']=array();
json_encode($_SESSION['detalle_descargo']);
?>