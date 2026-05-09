<?php session_start(); ?>
<link rel="stylesheet" href="estilos.css">

<h2>Ingreso al Sistema de Noticias</h2>

<?php
if(isset($_SESSION['mensaje_error'])) {
    echo "<div style='color: #a94442; background-color: #f2dede; border: 1px solid #ebccd1; padding: 15px; border-radius: 2px; margin-bottom: 20px; width: 100%; max-width: 450px; box-sizing: border-box;'>";
    echo "<b>Error:</b> " . $_SESSION['mensaje_error'];
    echo "</div>";
    unset($_SESSION['mensaje_error']); 
}
?>

<form action="../controladores/loginController.php" method="POST">
    Email: <input type="email" name="email" required><br><br>
    Clave: <input type="password" name="clave" required><br><br>
    <button type="submit">Entrar</button>
</form>
<br>
<a href="recuperar.php">¿Olvidaste tu contraseña?</a><br><br>
<a href="../index.php"><button type="button">Volver a Noticias Públicas</button></a>