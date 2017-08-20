<div class="nav-no-collapse header-nav">
	<ul class="nav pull-right">
		<!-- start: User Dropdown -->
		<li class="dropdown">
			<a class="btn dropdown-toggle" data-toggle="dropdown" href="#">
				<i class="halflings-icon white user"></i><span class="header-user"><?php echo $_SESSION["nombre"]; ?></span>
				<span class="caret"></span>
			</a>
			<ul class="dropdown-menu">
				<li class="dropdown-menu-title">
						<span>Configuraciones</span>
				</li>
				<li><a href="?mod=contrasena"><i class="halflings-icon user"></i> Cambio de contrase&ntilde;a</a></li>
				<li><a href="?mod=logout"><i class="halflings-icon off"></i> Cerrar sesi&oacute;n</a></li>
			</ul>
		</li>
		<!-- end: User Dropdown -->
	</ul>
</div>