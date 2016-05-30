<?php
include_once(__DIR__."/../php/conexion.php");
include_once(__DIR__."/../php/servicios/usuarioServicios.php");
$link = new Conexion();
$usuarioServicios = new usuarioServicio();
session_start();
$usuariosGrupo = $usuarioServicios->visualizarUsuariosPorGrupo($_POST['codigoGrupo']);
echo json_encode($usuariosGrupo);
?>