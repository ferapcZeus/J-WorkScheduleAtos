<?php
include_once(__DIR__."/../servicios/tipoUsarioServicios.php");
include_once(__DIR__."/../servicios/provinciaServicios.php");
include_once(__DIR__."/../servicios/gruposServicios.php");
include_once(__DIR__."/../servicios/usuarioServicios.php");
include_once(__DIR__."/../servicios/jornadaServicios.php");
include_once(__DIR__."/../servicios/realizaServicios.php");
include_once(__DIR__."/../servicios/calendarioFestivoServicios.php");
include_once(__DIR__."/../servicios/festividadServicios.php");
include_once(__DIR__."/../servicios/vacacionesServicios.php");
session_start();


if(isset($_POST['action']) && !empty($_POST['action'])) {
    $action = $_POST['action'];
    switch($action) {
		case 'jornadas' : listarJornadas(); break;
		case 'jornadasRealiza' : jornadasRealiza(); break;
        case 'provincias' : listarProvincias();break;
        case 'tUser' : listarTipoUsuarios();break;
		case 'grupos' : listarGrupos();break;		
		case 'buscador' : buscador(); break;
		case 'userPorGrupo' : listarUsuarioPorGrupo($_POST['codigoGrupo']); break;
		case 'grupoSelected' : grupoSeleccionado($_POST['codigoGrupo']); break;
		case 'coordinador' : coordinador($_POST['codigoCoordinador']); break;
		case 'administradores' : listarAdministradores(); break;
		case 'estandar' : listarUsuariosEstandar(); break;
		case 'usuarioPorId' : usuarioPorId($_POST['id']); break;
		case 'cargarGestionGrupos' : cargarGestionGrupos(); break;
		case 'grupoActual' : grupoActual(); break;
		case 'grupoAComparar' : grupoPorId($_POST['codGrupo']); break;
		case 'usuarioActual' : usuarioActual(); break;
		case 'comprobarCoordinador' : comprobarCoordinador(); break;
		case 'comprobarAdministrador' : comprobarAdministrador(); break;
		case 'grupoDeUsuarioActual' : grupoDeUSuarioActual($_SESSION['login_user']); break;
		case 'buscarUsuarioActual' : buscarUsuarioActual($_SESSION['login_user']); break;
		case 'diasFestivos' : diasFestivos($_POST['codUser']); break;
		case 'fiestas' : listarFestejos(); break;
		case 'vacaciones' : listarVacaciones($_POST['codUser']); break;

    }
}

function listarVacaciones($codUser)
{
	$vacacionesServicios = new vacacionesServicio();
	$vacaciones = $vacacionesServicios->buscarVacacionesPorUsuarios($codUser);
	echo json_encode($vacaciones);
}

function listarFestejos()
{
	$festividadServicios = new festividadServicio();
	$festejos = $festividadServicios->visualizarFestividad();
	echo json_encode($festejos);
}

function diasFestivos($codUsuario)
{
	$calendarioFestivoServices = new calendarioFestivoServicio();
	$festivos = $calendarioFestivoServices->festividadPorUsuarios($codUsuario);
	echo json_encode($festivos);
}

function jornadasRealiza()
{
	$realizaServicios = new realizaServicio();
	$jornadasRealiza = $realizaServicios->visualizaRealiza();
	echo json_encode($jornadasRealiza);
}
function listarJornadas()
{
	$jornadaServicios = new jornadaServicio();
	$jornadas = $jornadaServicios->visualizarJornadas();
	echo json_encode($jornadas);
}
function usuarioActual()
{
	$usuarioServicios = new usuarioServicio();
	$usuarioActual = $_SESSION['login_user'];
	echo json_encode($usuarioActual);
}
function comprobarCoordinador()
{
	$usuarioServicios = new usuarioServicio();
	$esCoordinador = $usuarioServicios->comprobarCoordinador($_SESSION['login_user']);
	echo json_encode($esCoordinador);
}
function comprobarAdministrador()
{
	$usuarioServicios = new usuarioServicio();
	$esAdministrador = $usuarioServicios->comprobarAdministrador($_SESSION['login_user']);
	echo json_encode($esAdministrador);
}
function grupoPorId($codGrupo)
{
	$gruposServicios = new grupoServicio();
	$grupo = $gruposServicios->seleccionarGrupo($codGrupo);
	echo json_encode($grupo);
}
function grupoActual()
{
	$usuarioServicios = new usuarioServicio();
	$usuarioActual = $_SESSION['login_user'];
	$grupoActual = $usuarioServicios->cogerGrupoDeUnUsuario($usuarioActual);
	$usuariosGrupo = $usuarioServicios->visualizarUsuariosPorGrupo($grupoActual);
	echo json_encode($usuariosGrupo);
}
function listarTipoUsuarios()
{
	$tipoUsuarioServicos = new tipoUsuarioServico();
	$tipoUsuarios = $tipoUsuarioServicos->VisualizartipoUsuarios();
	echo json_encode($tipoUsuarios);
}
function listarProvincias()
{
	$provinciasServicios = new provinciaServicio();
	$provincias = $provinciasServicios->visualizarProvincias();
	echo json_encode($provincias);
}
function listarGrupos()
{
	$gruposServicios = new grupoServicio();
	$grupos = $gruposServicios->visualizarGrupos();
	echo json_encode($grupos);
}
function listarUsuarioPorGrupo($cod_grupo)
{
	$usuarioServicios = new usuarioServicio();
	$usuariosGrupo = $usuarioServicios->visualizarUsuariosPorGrupo($cod_grupo);
	echo json_encode($usuariosGrupo);
}
function grupoSeleccionado($cod_grupo)
{
	$gruposServicios = new grupoServicio();
	$grupoSeleccionado = $gruposServicios->seleccionarGrupo($cod_grupo);
	echo json_encode($grupoSeleccionado);
}
function grupoDeUSuarioActual($dasUser)
{
	$gruposServicios = new grupoServicio();
	$grupoActual = $gruposServicios->grupoDeUsuarioActual($dasUser);
	echo json_encode($grupoActual);
}
function cargarGestionGrupos()
{
	$usuarioServicios = new usuarioServicio();
	$usuarioActual = $usuarioServicios->buscarUsuarioPorDas($_SESSION['login_user']);
	$gruposServicios = new grupoServicio();
	$grupoActual = $gruposServicios->seleccionarGrupo($usuarioActual[0]['grupo']);
	echo json_encode($grupoActual);
}
function coordinador($cod_coordinador)
{
	$usuarioServicios = new usuarioServicio();
	$usuarioCoordinador = $usuarioServicios->buscarUsuarioPorCodigo($cod_coordinador);
	echo json_encode($usuarioCoordinador);
}
function listarAdministradores()
{
	$usuarioServicios = new usuarioServicio();
	$administradores = $usuarioServicios->visualizarUsuariosAdministradores();
	echo json_encode($administradores);
}
function listarUsuariosEstandar()
{
	$usuarioServicios = new usuarioServicio();
	$usuariosEstandar = $usuarioServicios->visualizarUsuariosEstandar();
	echo json_encode($usuariosEstandar);
}
function usuarioPorId($cod_user)
{
	$usuarioServicios = new usuarioServicio();
	$usuariosEstandar = $usuarioServicios->buscarUsuarioPorCodigo($cod_user);
	echo json_encode($usuariosEstandar);
}
function buscador()
{
	if ($_POST['queBuscar'] == 'nombre')
	{
		$usuarioServicios = new usuarioServicio();
		$usuarios = $usuarioServicios->visualizarUsuarioPorNombre($_POST['nombre']);
		echo json_encode($usuarios);	
	}
	else if ($_POST['queBuscar'] == 'grupo')
	{
		$gruposServicios = new grupoServicio();
		$grupoActual = $gruposServicios->buscarGruposPorNombre($_POST['nombre']);
		echo json_encode($grupoActual);
	}
	else if ($_POST['queBuscar'] == 'identificador')
	{
		$usuarioServicios = new usuarioServicio();
		$usuarios = $usuarioServicios->buscarUsuariosDasEmpiezaPor($_POST['nombre']);
		echo json_encode($usuarios);	
	}
}
function buscarUsuarioActual($dasUsurio)
{
	$usuarioServicios = new usuarioServicio();
	$usuarioActual = $usuarioServicios->buscarUsuarioPorDas($_SESSION['login_user']);
	echo json_encode($usuarioActual);
}

?>