<?php
	include_once(__DIR__."/../servicios/usuarioServicios.php");
	include_once(__DIR__."/../modelos/Usuario.php");
	$usuarioServicios = new usuarioServicio();
	session_start();
	$usuarioActual = $usuarioServicios->buscarUsuarioPorDas($_SESSION['login_user']);
	$usuario = new Usuario();
	$usuario->setNombre($_POST['nombre']);
	$usuario->setApellidos($_POST['apellidos']);
	$usuario->setDas($_POST['das']);
	$usuario->setPassword($_POST['pass']);
	$usuario->setGrupo($_POST['grupoGestionUsuario2']);
	$usuario->setTipoUsuario($_POST['tusuario']);
	$usuario->setProvincia($_POST['provincia']);
	/***********************************************************************/
	$usuarioServicios->agregarUsuario($usuario,json_encode($usuarioActual[0]['cod_usuario']));
	echo json_encode($usuario->jsonSerialize());
	header("Location:".$_SERVER['HTTP_REFERER']);
?>