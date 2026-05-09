<?php
session_start();
include '../modelos/bd.php';

if(!isset($_SESSION['usuario_id'])) {
    header("Location: ../vistas/login.php");
    exit();
}

$clave1 = $_POST['nueva_clave'];
$clave2 = $_POST['nueva_clave_repetida'];

if($clave1 !== $clave2) {
    $_SESSION['mensaje_error'] = "Las contraseñas no coinciden.";
    header("Location: ../vistas/cambiar_clave.php");
    exit();
}

if(strlen($clave1) < 4) {
    $_SESSION['mensaje_error'] = "La clave es muy corta (mínimo 4 caracteres).";
    header("Location: ../vistas/cambiar_clave.php");
    exit();
}

$hash = password_hash($clave1, PASSWORD_DEFAULT);
$id_usuario = $_SESSION['usuario_id'];

$query = "UPDATE usuarios SET clave = '$hash' WHERE id = $id_usuario";

if(mysqli_query($conexion, $query)) {
    $_SESSION['mensaje_exito'] = "¡Contraseña actualizada con éxito!";
    header("Location: ../vistas/cambiar_clave.php");
    exit();
} else {
    $_SESSION['mensaje_error'] = "Error de base de datos al actualizar.";
    header("Location: ../vistas/cambiar_clave.php");
    exit();
}
?>