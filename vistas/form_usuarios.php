<link rel="stylesheet" href="estilos.css">
<?php

session_start();
if($_SESSION['es_admin'] != 1) die("Solo Administradores. <br><br><button onclick='history.back()'>Volver para atrás</button>");
?>
<h2>Registrar Usuario</h2>
<form action="../controladores/usuarioController.php" method="POST">
    Nombre: <input type="text" name="nombre"><br><br>
    Email: <input type="text" name="email"><br><br>
    Clave: <input type="text" name="clave"><br><br>
    
    Roles:<br>
    <input type="checkbox" name="es_editor" value="1"> Editor<br>
    <input type="checkbox" name="es_validador" value="1"> Validador<br>
    <input type="checkbox" name="es_admin" value="1"> Administrador<br><br>

    <button type="submit">Crear Usuario</button>
</form>
<br><a href="panel.php">Volver</a>