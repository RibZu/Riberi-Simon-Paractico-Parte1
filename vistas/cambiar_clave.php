<?php
session_start();
if(!isset($_SESSION['usuario_id'])) {
    header("Location: login.php");
    exit();
}
?>
<link rel="stylesheet" href="estilos.css">

<h2>Cambiar mi Contraseña</h2>

<?php
if(isset($_SESSION['mensaje_error'])) {
    echo "<div style='color: #721c24; background-color: #f8d7da; border: 1px solid #f5c6cb; padding: 15px; border-radius: 8px; margin-bottom: 20px; width: 100%; max-width: 450px; box-sizing: border-box;'>";
    echo "<b>Error:</b> " . $_SESSION['mensaje_error'];
    echo "</div>";
    unset($_SESSION['mensaje_error']); 
}

if(isset($_SESSION['mensaje_exito'])) {
    echo "<div style='color: #155724; background-color: #d4edda; border: 1px solid #c3e6cb; padding: 15px; border-radius: 8px; margin-bottom: 20px; width: 100%; max-width: 450px; box-sizing: border-box;'>";
    echo "<b>Éxito:</b> " . $_SESSION['mensaje_exito'];
    echo "</div>";
    unset($_SESSION['mensaje_exito']); 
}
?>

<form action="../controladores/cambiarContraController.php" method="POST">
    Nueva Contraseña: <br>
    <input type="password" name="nueva_clave" required><br><br>
    
    Repetir Nueva Contraseña: <br>
    <input type="password" name="nueva_clave_repetida" required><br><br>

    <button type="submit">Actualizar Contraseña</button>
</form>
<br>
<a href="panel.php"><button type="button">Volver al Panel</button></a>