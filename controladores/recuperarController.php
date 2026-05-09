<?php
session_start(); 
include '../modelos/bd.php';

$email = $_POST['email'];

$query = "SELECT * FROM usuarios WHERE email = '$email'";
$resultado = mysqli_query($conexion, $query);

if(mysqli_num_rows($resultado) > 0) {
    
    $clave_temporal = "123456";
    $clave_hasheada = password_hash($clave_temporal, PASSWORD_DEFAULT);
    
    $update = "UPDATE usuarios SET clave = '$clave_hasheada' WHERE email = '$email'";
    mysqli_query($conexion, $update);
    
    $_SESSION['mensaje_exito'] = "¡Éxito! Tu contraseña fue reseteada.<br>Tu nueva clave temporal es: <b>" . $clave_temporal . "</b><br>Ingresá al sistema y cambiala.";

} else {

    $_SESSION['mensaje_error'] = "Error: Ese email no existe en nuestro sistema.";
}


header("Location: ../vistas/recuperar.php");
exit(); 
?>