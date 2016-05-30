<?php
include_once(__DIR__."/../servicios/tipoUsarioServicios.php");
include_once(__DIR__."/../servicios/provinciaServicios.php");
include_once(__DIR__."/../servicios/usuarioServicios.php");
include_once(__DIR__."/../servicios/jornadaServicios.php");
include_once(__DIR__."/../servicios/realizaServicios.php");
include_once(__DIR__."/../servicios/vacacionesServicios.php");
include_once(__DIR__."/../modelos/R.php");

session_start();


if(isset($_POST['action']) && !empty($_POST['action'])) {
    $action = $_POST['action'];
    switch($action) {
		case 'jornadasRealiza' : jornadasRealiza(); break;
		case 'borrarJornada' : borrarJornada(); break;
		case 'buscarColor' : buscarColor($_POST['idJornada']); break;
		case 'vacaciones' : vacacionesRealiza(); break;

    }
}

function vacacionesRealiza()
{
	
	$realizaServicios = new realizaServicio();
	$realiza = new JRealiza();
	$realiza->setFecha($_POST['fecha']);
	$realiza->setCodUsuario($_POST['idUser']);
	$realizaServicios->eliminaRealiza($realiza,json_encode($usuarioActual[0]['cod_usuario']));
	
	$vacacionesServicios = new vacacionesServicio();
	$vacaciones = new Vacaciones();
	$vacaciones->setFecha($_POST['fecha']);
	$vacaciones->setCodUsuario($_POST['idUser']);
	$vacacionesServicios->agregarVacaciones($vacaciones,json_encode($usuarioActual[0]['cod_usuario']));
}

function jornadasRealiza()
{
	$usuarioServicios = new usuarioServicio();
	$usuarioActual = $usuarioServicios->buscarUsuarioPorDas($_SESSION['login_user']);
	$realizaServicios = new realizaServicio();
	
	$realiza = new JRealiza();
	$realiza->setFecha($_POST['fecha']);
	$realiza->setCodJornada($_POST['idJornada']);
	$realiza->setCodUsuario($_POST['idUser']);
	
	$jornadasRealizar = $realizaServicios->buscarRealiza($realiza);
	
	if (count($jornadasRealizar) > 0)
	{
		$realizaServicios->modificarRealiza($realiza,$usuarioActual);
	}
	else 
	{
		$realizaServicios->agregarRealiza($realiza,$usuarioActual);
	}
}

function borrarJornada()
{
	$usuarioServicios = new usuarioServicio();
	$usuarioActual = $usuarioServicios->buscarUsuarioPorDas($_SESSION['login_user']);
	$realizaServicios = new realizaServicio();
	$realiza = new JRealiza();
	$realiza->setFecha($_POST['fecha']);
	$realiza->setCodUsuario($_POST['idUser']);
	$realizaServicios->eliminaRealiza($realiza,json_encode($usuarioActual[0]['cod_usuario']));
	
	$vacacionesServicios = new vacacionesServicio();
	$vacaciones = new Vacaciones();
	$vacaciones->setFecha($_POST['fecha']);
	$vacaciones->setCodUsuario($_POST['idUser']);
	$vacacionesServicios->eliminarVacaciones($vacaciones,json_encode($usuarioActual[0]['cod_usuario']));
	
}
function buscarColor($idJornada)
{
	$jornadasServicio = new jornadaServicio();
	
	$jornadasRealizar = $jornadasServicio->jornadaPorID($idJornada);
	echo json_encode($jornadasRealizar);
}
?>