<?php
include_once(__DIR__."/../conexion.php");
include_once(__DIR__."/../servicios/gruposServicios.php");
session_start();
$valido = $_POST['valido'];
$gruposServicios = new grupoServicio();
$grupos = $gruposServicios->visualizarGrupos();
echo json_encode($grupos);

?>