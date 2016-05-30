<?php
	include_once(__DIR__."/../servicios/usuarioServicios.php");
	include_once(__DIR__."/../servicios/gruposServicios.php");
	$usuarioServicios = new usuarioServicio();
	session_start();
	$usuarioActual = $usuarioServicios->buscarUsuarioPorDas($_SESSION['login_user']);
	
	if (isset($_POST['modificar'])) {
		modificarUsuario($usuarioActual);
		if ($_POST['idUser'] == $usuarioActual[0]['cod_usuario'])
		{
			$_SESSION['login_user'] = $_POST['das'];
		}
		
	}
	else if (isset($_POST['expulsar']))
	{
		expulsarUsuario($usuarioActual);
	}
	
	function modificarUsuario($usuarioActual)
	{
		$usuarioServicios = new usuarioServicio(); 
		$usuario = new Usuario();
		$usuario->setCodUsuario($_POST['idUser']);
		$usuario->setNombre($_POST['nombre']);
		$usuario->setApellidos($_POST['apellidos']);
		$usuario->setDas($_POST['das']);
		$usuario->setGrupo($_POST['grupo']);
		$usuario->setTipoUsuario($_POST['tusuario']);
		$usuario->setProvincia($_POST['provincia']);
		$usuarioServicios->modificarUsuario($usuario,json_encode($usuarioActual[0]['cod_usuario']));
		header("Location:".$_SERVER['HTTP_REFERER']);
	}
	function expulsarUsuario($usuarioActual)
	{
		$usuarioServicios = new usuarioServicio(); 
		$usuario = new Usuario();
		$usuario->setCodUsuario($_POST['idUser']);
		$usuario->setNombre($_POST['nombre']);
		$usuario->setApellidos($_POST['apellidos']);
		$usuario->setDas($_POST['das']);
		$usuario->setGrupo($_POST['grupo']);
		$usuario->setTipoUsuario($_POST['tusuario']);
		$usuario->setProvincia($_POST['provincia']);
		$usuarioServicios->expulsarDelGrupo($usuario,json_encode($usuarioActual[0]['cod_usuario']));
		header("Location:".$_SERVER['HTTP_REFERER']);
	}
?>