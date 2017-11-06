<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" lang="es" xml:lang="es">
<?php  //include("paginas/tiempo.php");  ?>
<head>
<!-- start: Meta -->
<meta charset="utf-8">
<title>Sistema Gesti&oacute;n de Actividades</title>
<meta http-equiv="content-type" content="text/html; charset=UTF-8"/>
<meta name="description" content="Sistema Gestion de Actividades">
<meta name="author" content="">
<meta name="keyword" content="Metro, Metro UI, Dashboard, Bootstrap, Admin, Template, Theme, Responsive, Fluid, Retina">
<!-- end: Meta -->
<!-- start: Mobile Specific -->
<meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no">
<!-- end: Mobile Specific -->
<!-- start: CSS -->
<link rel="stylesheet" type="text/css" id="bootstrap-style" href="css/bootstrap.min.css">
<link rel="stylesheet" type="text/css" href="css/bootstrap-responsive.min.css">
<link rel="stylesheet" type="text/css" id="base-style" href="css/style.css">
<link rel="stylesheet" type="text/css" id="base-style-responsive" href="css/style-responsive.css">
<link rel="stylesheet" type="text/css" href="css/jquery-ui.min.css">
<link rel="stylesheet" type="text/css" href="js/select2/select2.min.css">
<link rel="stylesheet" type="text/css" href="css/design.css" media="all">
<script type="text/javascript" src="js/jquery-2.1.4.min.js"></script>
<!-- end: CSS -->
<!--<link href='css/fonts.css' rel='stylesheet' type='text/css'>-->
<!-- start: Favicon -->
<link rel="icon" type="image/png" href="img/CSJ_Favicon.png"/>
<!-- end: Favicon -->
</head>
<body>
<!-- start: Header -->
<div class="navbar">
    <div class="navbar-inner">
        <div class="container-fluid">
            <a class="btn btn-navbar" data-toggle="collapse" data-target=".top-nav.nav-collapse,.sidebar-nav.nav-collapse">
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            </a>
            <a class="brand" href="?mod=inicio" style="margin-top: 1px;"><span class="header-title"><img src="img/SGA1.png" alt="Inicio" class="img-circle" width="45" height="45"/>&nbsp;SGA&nbsp;&nbsp;<span class="dependencia"><?php echo $_SESSION["dependencia"]; ?></span></span></a>
            <!-- start: Header Menu -->
            <?php  include("paginas/header.php");  ?>
            <!-- end: Header Menu -->
        </div>
    </div>
</div>
<!-- start: Header -->
<div class="container-fluid-full">
    <div class="row-fluid">
        <!-- start: Main Menu -->
        <?php 
            if($_SESSION["id_rol"] == 5){
                include("paginas/nav_bar.php");
            } elseif($_SESSION["id_rol"] == 4){
                include("paginas/nav_bar_sup.php");
            } elseif($_SESSION["id_rol"] == 3){
                include("paginas/nav_bar_dig.php");
            } elseif($_SESSION["id_rol"] == 2){
                include("paginas/nav_bar_con.php");
            } elseif($_SESSION["id_rol"] == 1){
                include("paginas/nav_bar_admin.php");
            } elseif ($_SESSION["id_rol"] == 6) {
                include("paginas/nav_bar_sup_act.php");
            } elseif ($_SESSION["id_rol"] == 7) {
                include("paginas/nav_bar_sup_ins.php");
            } elseif ($_SESSION["id_rol"] == 8) {
                include("paginas/nav_bar_sup_per.php");
            } elseif ($_SESSION["id_rol"] == 9 ) {
                include("paginas/nav_bar_sup_bod.php");
            } elseif ($_SESSION["id_rol"] == 10 ) {
                include("paginas/nav_bar_sup_act_per.php");
            } elseif ($_SESSION["id_rol"] == 11 ) {
                include("paginas/nav_bar_sup_act_ins.php");
            }
                 ?>
        <!-- end: Main Menu -->
        <noscript>
        <div class="alert alert-block span10">
            <h4 class="alert-heading">Advertencia!</h4>
            <p>
                Necesitas tener <a href="return: false" target="_blank">JavaScript</a> activado, para utilizar este sitio.
            </p>
        </div>
        </noscript>
        <!-- start: Content -->
        <div id="content" class="span10">
            <?php
                    include(MODULO_PATH . "/" . $conf[$modulo]['archivo']);
            ?>
        </div>
        <!--/.fluid-container-->
        <!-- end: Content -->
    </div>
    <!--/#content.span10-->
</div>
<!--/fluid-row-->
<div class="clearfix">
</div>
<!-- start: Footer Menu -->
<?php  include("paginas/footer.php");  ?>
<!-- end: Footer Menu -->
<!-- start: JavaScript-->
<script type="text/javascript" src="js/jquery-1.8.2.min.js"></script>
<script type="text/javascript" src="js/jquery-ui.min.js"></script>
<script type="text/javascript" src="js/bootstrap.min.js"></script>
<script type="text/javascript" src="js/jquery.alerts.js"></script>
<!--<script type="text/javascript" src="js/jquery-migrate-1.0.0.min.js"></script>-->
<script type="text/javascript" src="js/jquery.blockUI.js"></script>
<!--<script src="js/jquery-ui-1.10.0.custom.min.js"></script>-->
<script type="text/javascript" src="js/jquery.ui.touch-punch.js"></script>
<script type="text/javascript" src="js/modernizr.js"></script>
<script type="text/javascript" src="js/bootbox.js"></script>
<script type="text/javascript" src="js/form-validator/jquery.form-validator.js"></script>
<script type="text/javascript" src="js/jquery.maskedinput.min.js"></script>
<script type="text/javascript" src="js/select2/select2.min.js" type="text/javascript"></script>
<script type="text/javascript" src="js/jquery.cookie.js"></script>
<script type="text/javascript" src='js/fullcalendar.min.js'></script>
<script type="text/javascript" src="js/excanvas.js"></script>
<script type="text/javascript" src="js/jquery.flot.js"></script>
<script type="text/javascript" src="js/jquery.flot.pie.js"></script>
<script type="text/javascript" src="js/jquery.flot.stack.js"></script>
<script type="text/javascript" src="js/jquery.flot.resize.min.js"></script>
<script type="text/javascript" src="js/jquery.chosen.min.js"></script>
<script type="text/javascript" src="js/jquery.uniform.min.js"></script>
<script type="text/javascript" src="js/jquery.cleditor.min.js"></script>
<script type="text/javascript" src="js/jquery.noty.js"></script>
<script type="text/javascript" src="js/jquery.elfinder.min.js"></script>
<script type="text/javascript" src="js/jquery.raty.min.js"></script>
<script type="text/javascript" src="js/jquery.iphone.toggle.js"></script>
<script type="text/javascript" src="js/jquery.uploadify-3.1.min.js"></script>
<script type="text/javascript" src="js/jquery.gritter.min.js"></script>
<script type="text/javascript" src="js/jquery.imagesloaded.js"></script>
<script type="text/javascript" src="js/jquery.masonry.min.js"></script>
<script type="text/javascript" src="js/jquery.knob.modified.js"></script>
<script type="text/javascript" src="js/jquery.sparkline.min.js"></script>
<script type="text/javascript" src="js/counter.js"></script>
<script type="text/javascript" src="js/retina.js"></script>
<script type="text/javascript" src='js/jquery.dataTables.min.js'></script>
<script type="text/javascript" src="js/custom.js"></script>
<!-- end: JavaScript-->

</body>
</html>