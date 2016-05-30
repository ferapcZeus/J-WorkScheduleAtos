<?php
include_once(__DIR__."/../servicios/usuarioServicios.php");
include_once(__DIR__."/../servicios/gruposServicios.php");
$link = new Conexion();
session_start();
	$action = $_POST['action'];
	switch($action) {
		case 'nombre' : buscarUsuarioPorID($_POST['codUser']); break;
		case 'grupo' : buscarGrupo($_POST['idGrupo']); break;
		case 'identificador' : buscarUsuarioPorID($_POST['codUser']); break;

    }
function buscarUsuarioPorID($codUser)
{
	$usuarioServicios = new usuarioServicio();
	$usuario = $usuarioServicios->buscarUsuarioPorCodigo($codUser);
	echo json_encode($usuario);
}
function buscarGrupo($grupo)
{
	$grupoServicios = new grupoServicio();
	$grupo = $grupoServicios->seleccionarGrupo($grupo);
	echo json_encode($grupo);
}
?>