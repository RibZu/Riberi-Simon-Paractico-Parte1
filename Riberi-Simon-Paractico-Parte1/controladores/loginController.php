<?php
session_start();
include '../modelos/bd.php';

$email = $_POST['email'];
$clave = $_POST['clave'];

$query = "SELECT * FROM usuarios WHERE email = '$email'";
$resultado = mysqli_query($conexion, $query);

if($row = mysqli_fetch_assoc($resultado)){
    
    if(password_verify($clave, $row['clave'])) {
        $_SESSION['usuario_id'] = $row['id'];
        $_SESSION['nombre'] = $row['nombre'];
        $_SESSION['es_editor'] = $row['es_editor'];
        $_SESSION['es_validador'] = $row['es_validador'];
        $_SESSION['es_admin'] = $row['es_admin'];
        header("Location: ../vistas/panel.php");
        exit();
    } else {
        $_SESSION['mensaje_error'] = "Contraseña incorrecta.";
        header("Location: ../vistas/login.php");
        exit();
    }

} else {
    $_SESSION['mensaje_error'] = "El email no existe en el sistema.";
    header("Location: ../vistas/login.php");
    exit();
}
?>