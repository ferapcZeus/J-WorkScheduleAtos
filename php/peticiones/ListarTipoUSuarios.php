<?php
include_once(__DIR__."/../conexion.php");
include_once(__DIR__."/../servicios/tipoUsarioServicios.php");
session_start();
$valido = $_POST['valido'];
$tipoUsuarioServicos = new tipoUsuarioServico();
$tipoUsuarios = $tipoUsuarioServicos->VisualizartipoUsuarios();
echo json_encode($tipoUsuarios);

?>