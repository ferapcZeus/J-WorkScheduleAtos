<?php
include_once(__DIR__."/../conexion.php");
include_once(__DIR__."/../servicios/provinciaServicios.php");
session_start();
$valido = $_POST['valido'];
$provinciasServicios = new provinciaServicio();
$provincias = $provinciasServicios->visualizarProvincias();
echo json_encode($provincias);

?>