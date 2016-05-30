<?php
include_once("php/conexion.php");
include("php/servicios/usuarioServicios.php");
session_start();
$error ="";
$link = new Conexion();
$usuario = new usuarioServicio();
if($_SERVER["REQUEST_METHOD"] == "POST") {
	// AQUÍ RECOGEMOS EN LAS VARIABLES LA ID Y EL PASS PASADO POR EL FORMULARIO.
	$myusername = mysqli_real_escape_string($link->getConexion(),$_POST['username']);
	$mypassword = mysqli_real_escape_string($link->getConexion(),$_POST['password']); 
	// PREPARAMOS UNA SENTENCIA PARA SABER SÍ EL USUARIO CON LA ID Y EL PASS EXISTE Y ES CORRECTO.
	$resultado = $usuario->comprobrarUsuario($myusername, $mypassword);
	$usuarioActual =  $usuario->buscarUsuarioPorDas($_POST['username']);
	// COMPROBAMOS EL RESULTADO Y DAMOS ACCESO O NO.
	
	if($resultado == true)
	{
		if ($usuarioActual[0]['activo'] >0)
		{
			$_SESSION['login_user'] = $myusername;
			header("location: php/TABLAS_DINAMICAS_JS.php");			
		}
		else
		{
			$error = "El usuario actual no está disponible";
			header('URL = index.php');
		}
	}
	else
	{
		$error = "Los datos introducidos no son correctos";
		header('URL = index.php');
	}
}
$link->desconectar();


?>
<!DOCTYPE html>
<html lang="es">
	<!-- ENCABEZADO DE LA WEB -->
	<head>
		<meta charset="UTF-8">
		<title>index</title>
		<!-- //VIWEPOR DE BOOTSTRAP IMPRESCINDIBLE (para moviles) -->
		<meta name="viewport" content="width=device-width, initial-scale=1"> 
		<!-- CSS DE BOOTSTRAP -->	
		<link rel="stylesheet" type="text/css" href="css/bootstrap.css">
		<!-- CSS PROPIO -->	
		<link rel="stylesheet" type="text/css" href="css/estilos.css">
		<link rel="stylesheet" href="css/animate.css">
	</head>
	<!-- CUERPO DE LA WEB -->
	<body>
		<div class="col-md-6 center-block text-center quitar-float   padding-arriba   pulse">


<div class="row ">
 
 
    <!-- normal -->
        <div class="img"><img class="col-xs-6 col-md-6 col-lg-6" src="img/ideadelogo.png" alt="img"></div>
   
    <!-- end normal -->
 
  </div>

	</div>
		</div>

		<aside>
		</aside>
		<section class="col-md-3 col-xs-6 col-lg-3 center-block text-center quitar-float ">
			<form class="form-horizontal" action = "" method = "post">
				<div class="form-group">
					<label class="sr-only" for="inputEmail"> Usuario</label>
					<div class="input-group">
					<span class="input-group-addon"><span class="glyphicon glyphicon-user"></span></span>
					<input  type="text" 	id="username" name="username"class="form-control"  placeholder ="Usuario"> 
					</input>
				</div>
				</div>
				<div class="form-group input-group">
					<label class="sr-only" for="inputPassword">Password</label>
					<span class="input-group-addon"><span class="glyphicon glyphicon-lock"></span></span>
					<input type="password"   class="form-control"  placeholder="Password" name= "password" id="password">
				</div>
				<div class="checkbox">
					<label><input type="checkbox">Recuerdame</label>
				</div>
				<button  type="submit" class="btn btn-primary bt-acceder" >Acceder</button>
			</form>
			<div class=" col-xs-12 col-md-12 col-lg-12" style = "font-size:11px; color:#cc0000; margin-top:10px"><?php echo $error;?></div>
			<div class="animated pulse retraso2 ">	
				<article class=" logoatos001 " >
				<img  class=" col-xs-12 col-md-12 col-lg-12"src="img/Screenshot_1.png">
				</article>
			</div>
		</section>
		<footer></footer>
		<!-- CSS DE jQUERY -->	
		<script src="js/jquery.js"></script>
		<!-- /CDN DE JS de bootstrap -->
		<script src="js/bootstrap.js"></script>
	</body>
</html>
			