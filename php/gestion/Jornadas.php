<?php
include_once(__DIR__."/../servicios/tipoUsarioServicios.php");
include_once(__DIR__."/../servicios/provinciaServicios.php");
include_once(__DIR__."/../servicios/gruposServicios.php");
include_once(__DIR__."/../servicios/usuarioServicios.php");
include_once(__DIR__."/../servicios/jornadaServicios.php");
include_once(__DIR__."/../servicios/realizaServicios.php");
include_once(__DIR__."/../modelos/Jornada.php");
session_start();


if(isset($_POST['action']) && !empty($_POST['action'])) {
    $action = $_POST['action'];
    switch($action) {
		case 'crearJornada' : crearJornada(); break;
		case 'modificarJornada' : modificarJornada(); break;
        case 'eliminarJornada' : eliminarJornada();break;

    }
}

function crearJornada()
{
	$usuarioServicios = new usuarioServicio();
	$usuarioActual = $usuarioServicios->buscarUsuarioPorDas($_SESSION['login_user']);
	$jornadaServicios = new jornadaServicio();
	$jornada = new Jornada();
	$jornada->setHoraInicio($_POST['horaInicio']);
	$jornada->setHoraFin($_POST['horaFin']);
	$jornada->setColor($_POST['color']);	
	
	$jornadaServicios->agregarJornada($jornada,json_encode($usuarioActual[0]['cod_usuario']));	
}
function modificarJornada()
{
	$usuarioServicios = new usuarioServicio();
	$usuarioActual = $usuarioServicios->buscarUsuarioPorDas($_SESSION['login_user']);
	$jornadaServicios = new jornadaServicio();
	
	$jornada = new Jornada();
	$jornada->setCodJornada($_POST['idJornada']);
	$jornada->setHoraInicio($_POST['horaInicio']);
	$jornada->setHoraFin($_POST['horaFin']);
	$jornada->setColor($_POST['color']);
	
	$jornadaServicios->modificarJornada($jornada,json_encode($usuarioActual[0]['cod_usuario']));	
}
function eliminarJornada()
{
	$usuarioServicios = new usuarioServicio();
	$usuarioActual = $usuarioServicios->buscarUsuarioPorDas($_SESSION['login_user']);
	$jornadaServicios = new jornadaServicio();
	$jornada = new Jornada();
	$jornada->setCodJornada($_POST['idJornada']);
	$jornada->setHoraInicio($_POST['horaInicio']);
	$jornada->setHoraFin($_POST['horaFin']);
	$jornada->setColor($_POST['color']);	
	
	$jornadaServicios->eliminarJornada($jornada,json_encode($usuarioActual[0]['cod_usuario']));	
}

?>