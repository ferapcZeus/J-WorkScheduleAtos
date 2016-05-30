<?php
session_start();
if (!isset($_SESSION['login_user']))
{
   header('Refresh:0.01; URL = ../index.php');
}else{

include_once(__DIR__."/servicios/usuarioServicios.php");
include_once(__DIR__."/servicios/gruposServicios.php");
$usuarioServicios = new usuarioServicio();
$gruposServicio = new grupoServicio();
$usuarioActual = $_SESSION['login_user'];
}
?>
<!doctype html>
<html lang="en">
	<head>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1"> 
		<link rel="stylesheet" type="text/css" href="../css/bootstrap.min.css">
		<link rel="stylesheet" type="text/css" href="../css/estilos.css">
		<link rel="stylesheet" href="../css/animate.css">

		<!-----------------ELVI------------------------------------ -->
		<script src="../js/jquery.js"> </script>
		<link href="../css/TABLAS_DINAMICAS_JS.css" rel="stylesheet" type="text/css">
		<link href="../css/jornadas.css" rel="stylesheet" type="text/css">
		<script src="../js/ComboGrupos.js"> </script>
		<script src="../js/TABLAS_DINAMICAS_JS.js"> </script>
		<script src="//code.jquery.com/ui/1.11.4/jquery-ui.js"></script>
	</head>

	<body>
		<header>
			<div>
				<img class="Jwork animated fadeInLeftBig"src="../img/Screenshot_1.png" >
				<img  class="ideadelogo" src="../img/ideadelogo.png" width="15%" height="15%" />
			</div>
			
			<nav class="navbar navbar-inverse">
				<div class="container">
					<!-- Boton DISPOSITIVOS MOVILES Y TEXTO -->		
					<div class="navbar-header"> 
						<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navegacion-ferapc">
						<span class="sr-only">Desplegar / Ocultar Menu</span> <!--Para Dispositivos de lectura ebboks -->
						<span class="icon-bar"></span>
						<span class="icon-bar"></span>
						<span class="icon-bar"></span>
						</button>
						<a class="navbar-brand" href="#"></a>
					</div>	

				<!-- INICIA MENU-->
					<div class="collapse navbar-collapse" id="navegacion-ferapc">
						<ul class="nav navbar-nav ">
							<li class="active"><a href="TABLAS_DINAMICAS_JS.php">INICIO</a></li>
							<li class="dropdown">
								<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button">EXTRAER 
									<span class="caret"></span>
								</a>
								
								<ul class="dropdown-menu" role="menu">
									<li>
										<a data-toggle="modal" href="#exportarExcel"> EXCEL</a>
									</li>
									<li>
										<a href="#">  PDF</a>
									</li>
								</ul>	
							</li>

							
							<li id="administracionMenu" class="dropdown">
								<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button">ADMINISTRACIÓN <span class="caret"></span></a>    
									<ul class="dropdown-menu" role="menu">
										<li><a data-toggle="modal" href="#modalcrearuser"> Crear Usuario</a></li>
										<li role="separator" class="divider"></li>
										<li><a id="gestionGruposLink" data-toggle="modal" href="#";>Gestion Grupos</a></li>	
										<li><a data-toggle="modal" href="#modalmodjornada">Gestion Jornadas</a></li>										       
									</ul>	
							</li>
							<li><a data-toggle="modal" href="#modalacerca" class="">ACERCA DE</a></li>
						
						
							<!------------------ MODALES ADMIN -------------------->
							
							<div id="exportarExcel" class="modal fade">
								<div class="modal-dialog">   
									<div class="modal-content"> 
										<div class="modal-header">
											<button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
											<h3 class="text-center">Exportar a Excel</h3>
										</div>
										<form class="form-horizontal">
											<div class="modal-body">
												<div class="text-center">
													<label class="labelExport">
														Desde:
														<select id="mesesDesdeSelect" class="select" name="mesesDesdeSelect"></select>
													</label>
													<label class="labelExport">
														hasta:
														<select id="mesesHastaSelect" class="select" name="mesesHastaSelect"></select>
													</label>
													<div class="form-group">
														<label class="col-md-4 control-label" for="Nombre">Grupos</label>  
														<div class="col-md-5">
															<select id="comboGrupoExtraer" name="comboGrupoExtraer" class="form-control" > </select>
														</div>														
													</div>
													<div class="modal-footer active">
														<input id="exportarExcelButton" type="button" class="btn btn-success" value="exportar"/>
														<a href="#" data-dismiss="modal" class="btn">Cerrar</a>
													</div>
												</div>
											</div>
										</form>
									</div>		
								</div>
							</div>							
							
							<div id="modalcrearuser" class="modal fade">
								<div class="modal-dialog">   
									<div class="modal-content"> 
										<div class="modal-header">
											<button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
											<h3 class="text-center">Crear Usuario</h3>
										</div>
										<div class="modal-body">
											<form class="form-horizontal" action="gestion/crearUsuario.php" method = "post">
											<fieldset>
											<div class="form-group">
											  <label class="col-md-4 control-label" for="das">DAS</label>  
												<div class="col-md-5">
													<input id="das" name="das" type="text" placeholder="DAS" class="form-control input-md" required=""></input>
												</div>
											</div>
											
											<div class="form-group">
											  <label class="col-md-4 control-label" for="Nombre">Nombre</label>  
												<div class="col-md-5">
													<input id="nombre" name="nombre" type="text" placeholder="Nombre" class="form-control input-md" required=""></input>
												</div>
											</div>
											
											<div class="form-group">
											  <label class="col-md-4 control-label" for="Apellidos">Apellidos</label>  
											  <div class="col-md-5">
											  <input id="apellidos" name="apellidos" type="text" placeholder="Apellidos" class="form-control input-md" required=""></input>
											  </div>
											</div>
											
											<div class="form-group">
											  <label class="col-md-4 control-label" for="pass">Contraseña</label>
											  <div class="col-md-5">
												<input id="pass" name="pass" type="password" placeholder="Contraseña" class="form-control input-md" required=""></input>
												
											  </div>
											</div>
											<div class="form-group">
											  <label class="col-md-4 control-label" for="provincia">Provincia</label>
											  <div class="col-md-4">
												<select id="provincia" name="provincia" class="form-control">
												</select>
											  </div>
											</div>
											
											<div class="form-group">
											  <label class="col-md-4 control-label" for="provincia">Grupo</label>
											  <div class="col-md-4">
												<select id="grupoGestionUsuario" name="grupoGestionUsuario2" class="form-control">
												</select>
											  </div>
											</div>
											
											<div class="form-group">
											  <label class="col-md-4 control-label" for="provincia">Tipo de usuario</label>
											  <div class="col-md-4">
												<select id="tusuario" name="tusuario" class="form-control">
												</select>
											  </div>
											</div>
				
											<div class="modal-footer active">
												<input type="submit" class="btn btn-success" value="Crear"></input>
												<a href="#" data-dismiss="modal" class="btn">Cerrar</a>
											</div>
											</fieldset>
											</form>
										</div>
									</div>
							   </div>
							</div>
							
							<div id="modalcrearjornada" class="modal fade">
								<div class="modal-dialog">   
									<div class="modal-content"> 
										<div class="modal-header">
											<button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
											<h3 class="text-center">Crear Jornadas</h3>
										</div>
										<form class="form-horizontal" action="" method = "post">
											<fieldset>
											
											</fieldset>
										</form>
									</div>
							   </div>
							</div>
							
							<div id="modalmoduser" class="modal fade">
								<div class="modal-dialog">   
									<div class="modal-content"> 
										<div class="modal-header">
											<button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
											<h3 id="nombreUsuarioText" class="text-center">Gestionar USUARIO</h3>
										</div>
										<div class="modal-body">
											<form class="form-horizontal" action="gestion/Usuarios.php" method = "post">
											<fieldset>
											<div class="form-group">
											<input id="idUser" name="idUser" type="hidden"></input>
											  <label class="col-md-4 control-label" for="das">DAS</label>  
												<div class="col-md-5">
													<input id="dasGestionUsuario" name="das" type="text" placeholder="DAS" class="form-control input-md" required=""></input>
												</div>
											</div>
											
											<div class="form-group">
											  <label class="col-md-4 control-label" for="Nombre">Nombre</label>  
												<div class="col-md-5">
													<input id="nombreGestionUsuario" name="nombre" type="text" placeholder="Nombre" class="form-control input-md" required=""></input>
												</div>
											</div>
											
											<div class="form-group">
											  <label class="col-md-4 control-label" for="Apellidos">Apellidos</label>  
											  <div class="col-md-5">
											  <input id="apellidosGestionUsuario" name="apellidos" type="text" placeholder="Apellidos" class="form-control input-md" required=""></input>
											  </div>
											</div>
											
											<div class="form-group">
											  <label class="col-md-4 control-label" for="provincia">Provincia</label>
											  <div class="col-md-4">
												<select id="provinciaGestionCombo" name="provincia" class="form-control">
												</select>
											  </div>
											</div>
											
											<div class="form-group">
											  <label class="col-md-4 control-label" for="provincia">Grupo</label>
											  <div class="col-md-4">
												<select id="grupoGestionUsuarioCombo" name="grupo" class="form-control">
												</select>
											  </div>
											</div>
											
											<div class="form-group">
											  <label class="col-md-4 control-label" for="provincia">Tipo de usuario</label>
											  <div class="col-md-4">
												<select id="tipoUsuarioGestionCombo" name="tusuario" class="form-control">
												</select>
											  </div>
											</div>
				
											<div class="modal-footer active">
												<input type="submit" name="expulsar" class="btn btn-danger" value="expulsar"></input>
												<input type="submit" name="modificar" class="btn btn-success" value="Guardar"></input>
												<a href="#" data-dismiss="modal" class="btn">Cerrar</a>
											</div>
											</fieldset>
											</form>
										</div>
									</div>
							   </div>
							</div>
							
							<div id="modalmodgrupo" class="modal fade">
								<div class="modal-dialog">   
									<div class="modal-content"> 
										<div class="modal-header">
											<button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
											<h3 class="text-center">Gestionar Grupo</h3>
										</div>
										<div class="container-fluid text-center">
											<ul class="nav navbar-nav pestanas text-center">
											  <li id="modGrupoPestana"  class="pestana-relleno pestana-selected"><p class="pestana-texto">Modificar</p></li>
											  <li id="crearGrupoPestana"  class="pestana-relleno"><p class="pestana-texto">Crear</p></li>
											</ul>
										</div>
										<fieldset>
												<div class="modificarGrupoContenedor">
													<form class="form-horizontal" action="gestion/Grupos.php" method = "post">
														<div class="datosGrupo">
															<div class="form-group">
															  <label class="col-md-4 control-label" for="das">Grupos</label>  
																<div class="col-md-8">
																	<select id="comboGrupo" name="comboGrupo" class="form-control" > </select>
																</div>
															</div>
															

															<div class="form-group">
															  <label class="col-md-4 control-label" for="das">Grupo</label>  
																<div class="col-md-8">
																	<input id="nGrupoGestion" name="ngrupo" type="text" placeholder="Nombre Grupo" class="form-control input-md" required="">
																	</input>
																</div>
															</div>

															<div class="form-group">
															  <label class="col-md-4 control-label" for="das">Coordinador</label>  
																<div class="col-md-8">
																	<select id="coordinadorg" name="coordinadorg" class="form-control" > </select>
																</div>
															</div>
														</div>
														
														<div class="usuariosGestionGrupos">
														<select id="listaUsuarios" name="listaUsuarios" class="listaUsuarios" size="99">
														<select>
														</div>
														
														<div class="modal-footer active">
															<input id="expulsarDelGrupoButton" type="submit" name="expulsar" class="btn btn-danger" value="Expulsar"></input>
															<input id="eliminarGruposButton" type="submit" name="eliminar" class="btn btn-warning" value="Eliminar"></input>
															<input type="submit" name="modificar" class="btn btn-success" value="Guardar"></input>
															<a href="#" data-dismiss="modal" class="btn">Cerrar</a>
														</div>
													</form>
												</div>
												<div class="crearGrupoContenedor">
													<form class="form-horizontal" action="gestion/Grupos.php" method = "post">
														<div class="form-group">
														  <label class="col-md-4 control-label" for="das">Grupo</label>  
															<div class="col-md-5">
																<input id="ngrupo" name="ngrupo" type="text" placeholder="Nuevo Grupo" class="form-control input-md" required="">
																</input>
															</div>
														</div>
														
														<div class="form-group">
														  <label class="col-md-4 control-label" for="provincia">Coordinador</label>
														  <div class="col-md-4">
															<select id="coordinadorgrupocombo" name="coordinadorgrupocombo" class="form-control">
															</select>
														  </div>
														</div>
														
														<div class="modal-footer active">
															<input id="crearGrupoButton" type="submit" name="crear" class="btn btn-success" value="Crear"></input>
															<a href="#" data-dismiss="modal" class="btn">Cerrar</a>
														</div>
													</form>	
												</div>										
										</fieldset>
									</div>
							   </div>
							</div>
							
							<div id="modalmodjornada" class="modal fade">
								<div class="modal-dialog">   
									<div class="modal-content"> 
										<div class="modal-header">
											<button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
											<h3 class="text-center">Gestionar Jornadas</h3>
										</div>
										
										<div class="container-fluid text-center">
											<ul class="nav navbar-nav pestanas text-center">
											  <li id="modPestanaJornada" class="pestana-relleno pestana-selected"><p  class="pestana-texto">Modificar</p></li>
											  <li id="crearPestanaJornada" class="pestana-relleno"><p class="pestana-texto">Crear</p></li>
											</ul>
										</div>
										<form class="form-horizontal" action="" method = "post">
											<fieldset>
											<div class="modificarJornadaContenedor">
												<div class="form-group">
												  <label class="col-md-4 control-label" for="das">Jornadas</label>  
													<div class="col-md-5">
														<select id="comboJornada" name="comboJornada" class="form-control" > </select>
													</div>
												</div>
												
												<div class="form-group">
												  <label class="col-md-4 control-label">Colores</label>  
													<div class="col-md-5">
														<input id="color" type="color" class="form-control input-small">
													</div>
												</div>
												
												<div class="form-group">
												  <label class="col-md-4 control-label" for="das">Hora inicio: </label>
													<div class='col-md-5'>
														<input id="horainicio" type="time" class="form-control input-small">
													</div>
												</div>
												
												<div class="form-group">
												  <label class="col-md-4 control-label" for="das">Hora final: </label>
													<div class='col-md-5'>
														<input id="horafin" type="time" class="form-control input-small">
													</div>
												</div>
												
												<div class="modal-footer active">
													<input type="submit" id="eliminarJornada" name="eliminarJornada" class="btn btn-warning" value="Eliminar"></input>
													<input type="submit" id="modificarJornada" name="modificarJornada" class="btn btn-success" value="Guardar"></input>
													<a href="#" data-dismiss="modal" class="btn">Cerrar</a>
												</div>
											</div>
											<div class="crearJornadaContenedor">

												<div class="form-group">
													<label class="col-md-4 control-label">Colores</label>  
													<div class="col-md-5">
													<input id="ncolor" type="color" class="form-control input-small">
													</div>
												</div>

												<div class="form-group">
													<label class="col-md-4 control-label" for="das">Hora inicio: </label>
													<div class='col-md-5'>
													<input id="horainicio2" type="time" placeholder="EJ: 08:30" class="form-control input-small">
													</div>
												</div>

												<div class="form-group">
													<label class="col-md-4 control-label" for="das">Hora final: </label>
													<div class='col-md-5'>
													<input id="horafin2" type="time" placeholder="EJ: 16:30" class="form-control input-small">
													</div>
												</div>

												<div class="modal-footer active">
													<input type="submit" id="crearJornada" name="crearJornada" class="btn btn-success" value="Crear"></input>
													<a href="#" data-dismiss="modal" class="btn">Cerrar</a>
												</div>
											</div>
											</fieldset>
										</form>
									</div>
							   </div>
							</div>

						<!------------------ MODALES ADMIN FIN -------------------->

							<div id="modalacerca" class="modal fade">
								<div class="modal-dialog">   
									<div class="modal-content"> 
										<div class="modal-header">
										<button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
										<h3 class="text-center">J-WorkScheduleAtos</h3>
										</div>

										<div class="modal-body">
											<p id="FechaActualPruebas">Version 2.1 (28-05-2016) </p>
											<p >Equipo de Desarollo:</p>
											<p>Eduardo Pérez Guerrero [eduardo@gmail.com]</p>
											<p>Elvira Rodriguez Luis [elvira@gmail.com]</p>
											<p>Fernando Acosta Pérez-Cardona. [fernandoacostacardona@gmail.com]</p> 
											<p>Atos Canarias</p>
										</div>
										<div class="modal-footer active">
											<a href="#" data-dismiss="modal" class="btn">Cerrar</a>
										</div>
									</div>
								</div>
							</div>
						</ul>

						<form class="navbar-form navbar-right" onsubmit="return false">
							<div class="form-group">
								<input id="buscador" name="buscador" type="text" class="form-control" placeholder="" />
								<select id="selectBuscador" name="selectBuscador" class="form form-control" >
									<option value="nombre">Nombre o Apellido</option>
									<option  value="grupo">Grupo</option>
									<option  value="identificador">Das</option>
								</select> 
							</div>
						</form>
					</div><!-- //Cierra div Inicia menu -->
				</div> <!-- //Cierra div container -->
			</nav>
		</header>
		
		<section id="jumboTron" class="jumbotron"> 
			<p id="usuarioActual" class="text-logout">
				<a class="text-desconectar" href="logout.php"> (Desconectar)</a>
				<p id="fechaActual"></p>
			</p>
		</section>
		
		<div id="div-global" class="div-global">
			<div class="row">
				<div id="select-div" class="select-div col-md-2 col-lg-2 col-xs-2">

					<select  id="lista">

					</select>
					<table id="usuarios"></table>
				

				</div>

				<div id="div-tabla" class="div-tabla col-md-10 col-lg-10 col-xs-10">
					<table id="calendario"></table>
				</div>
			</div>
		</div>
		
	
		
		<div id="seccion">
		</div>
		<div id="Leyenda" class="Leyenda ">
				<h4>Leyenda de Turnos</h4>
		</div>
		

		<script src="../js/bootstrap.js"></script>
		
		
	</body>
</html>
