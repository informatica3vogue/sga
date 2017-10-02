<?php
$_SESSION['detalle_descargo']= isset($_SESSION['detalle_descargo']) ? $_SESSION['detalle_descargo'] : array();
echo json_encode($_SESSION['detalle_descargo']);
?>