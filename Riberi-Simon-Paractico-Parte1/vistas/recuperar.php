<?php session_start(); ?>
<link rel="stylesheet" href="estilos.css">

<h2>Recuperar Contraseña</h2>
<p>Ingresá tu correo y te daremos una clave temporal.</p>

<?php

if(isset($_SESSION['mensaje_exito'])) {
    echo "<div style='color: #155724; background-color: #d4edda; border: 1px solid #c3e6cb; padding: 15px; border-radius: 8px; margin-bottom: 20px; width: 100%; max-width: 400px; box-sizing: border-box;'>";
    echo $_SESSION['mensaje_exito'];
    echo "</div>";
  
    unset($_SESSION['mensaje_exito']); 
}


if(isset($_SESSION['mensaje_error'])) {
    echo "<div style='color: #721c24; background-color: #f8d7da; border: 1px solid #f5c6cb; padding: 15px; border-radius: 8px; margin-bottom: 20px; width: 100%; max-width: 400px; box-sizing: border-box;'>";
    echo $_SESSION['mensaje_error'];
    echo "</div>";
    
    unset($_SESSION['mensaje_error']);
}
?>

<form action="../controladores/recuperarController.php" method="POST">
    Email: <input type="email" name="email" required><br><br>
    <button type="submit">Resetear mi clave</button>
</form>
<br>
<a href="login.php"><button type="button">Volver al login</button></a>