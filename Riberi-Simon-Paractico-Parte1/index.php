<?php
include 'modelos/bd.php';
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Noticias Institucionales</title>
    <link rel="stylesheet" href="vistas/estilos.css">
</head>
<body>
    <div style="text-align: right; padding: 10px; background-color: #f1f1f1;">
        <a href="vistas/login.php">Ingresar al Sistema</a>
    </div>
    <div style="padding: 20px;">
        <h1>Noticias Públicas</h1>
        <hr>
        <?php
        $query = "SELECT * FROM noticias WHERE estado = 'Publicada' ORDER BY fecha_publicacion DESC";
        $resultado = mysqli_query($conexion, $query);
        while($n = mysqli_fetch_assoc($resultado)) {
            echo "<h2>".$n['titulo']."</h2>";
            echo "<p><i>Publicado el: ".$n['fecha_publicacion']."</i></p>";
            if($n['imagen'] != "") {
                echo "<img src='imagenes/".$n['imagen']."' width='300'><br><br>";
            }
            echo "<p>".$n['descripcion']."</p>";
            echo "<hr>";
        }
        ?>
    </div>
</body>
</html>