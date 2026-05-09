<?php
session_start();
include '../modelos/bd.php';
include '../modelos/Usuario.php';


if($_SESSION['es_admin'] != 1) die("No tienes permiso. <br><br><button onclick='history.back()'>Volver para atrás</button>");

$nombre = $_POST['nombre'];
$email = $_POST['email'];
$clave = $_POST['clave'];
$es_editor = isset($_POST['es_editor']) ? 1 : 0;
$es_validador = isset($_POST['es_validador']) ? 1 : 0;
$es_admin = isset($_POST['es_admin']) ? 1 : 0;

$clave_hasheada = password_hash($clave, PASSWORD_DEFAULT);

crearUsuario($conexion, $nombre, $email, $clave_hasheada, $es_editor, $es_validador, $es_admin);

header("Location: ../vistas/panel.php");
?>