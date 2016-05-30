<?php
	include_once(__DIR__."/../servicios/usuarioServicios.php");
	include_once(__DIR__."/../servicios/gruposServicios.php");
	include_once(__DIR__."/../modelos/Grupo.php");
	$usuarioServicios = new usuarioServicio();
	session_start();
	$usuarioActual = $usuarioServicios->buscarUsuarioPorDas($_SESSION['login_user']);

	if (isset($_POST['crear'])) {
		crearGrupo($usuarioActual);
	}
	else if (isset($_POST['eliminar'])) {
		eliminarGrupo($usuarioActual);
	}
	else if (isset($_POST['modificar'])) {
		modificarGrupo($usuarioActual);
	}	
	else if (isset($_POST['expulsar'])) {
		expulsarUsuario($usuarioActual);
	}
	
	function crearGrupo($usuarioActual){
		$gruposServicio = new grupoServicio();
		$grupo = new Grupo();
		$grupo->setNombre($_POST['ngrupo']);
		$grupo->setCoordinador($_POST['coordinadorgrupocombo']);
		$gruposServicio->agregarGrupo($grupo,json_encode($usuarioActual[0]['cod_usuario']));
		header("Location:".$_SERVER['HTTP_REFERER']);
	}
	
	function eliminarGrupo($usuarioActual){
		$gruposServicio = new grupoServicio();
		$gruposServicio->eliminarGrupo($_POST['comboGrupo'],json_encode($usuarioActual[0]['cod_usuario']));
		header("Location:".$_SERVER['HTTP_REFERER']);
	}
	
	function modificarGrupo($usuarioActual){
		$gruposServicio = new grupoServicio();
		$grupo = new Grupo();
		$grupo->setCodGrupo($_POST['comboGrupo']);
		$grupo->setNombre($_POST['ngrupo']);
		if ($_POST['coordinadorg'] == "null"){}
		else
		{
			$grupo->setCoordinador($_POST['coordinadorg']);
		}
		$gruposServicio->modificarGrupo($grupo,json_encode($usuarioActual[0]['cod_usuario']));
		header("Location:".$_SERVER['HTTP_REFERER']);
	}
	function expulsarUsuario($usuarioActual)
	{
		$usuarioServicios = new usuarioServicio(); 
		$usuario = new Usuario();
		$usuario->setCodUsuario($_POST['listaUsuarios']);
		$usuarioServicios->expulsarDelGrupo($usuario,json_encode($usuarioActual[0]['cod_usuario']));
		header("Location:".$_SERVER['HTTP_REFERER']);
	}
?>