<link rel="stylesheet" href="estilos.css">
<?php
include '../modelos/bd.php';
$id = $_GET['id'];
$res = mysqli_query($conexion, "SELECT * FROM historial WHERE noticia_id = $id ORDER BY fecha_hora DESC");
?>
<h2>Historial de la Noticia #<?= $id ?></h2>
<table border="1">
    <tr>
        <th>Fecha y Hora</th>
        <th>Usuario</th>
        <th>Acción Realizada</th>
    </tr>
    <?php while($h = mysqli_fetch_assoc($res)) { ?>
    <tr>
        <td><?= $h['fecha_hora'] ?></td>
        <td><?= $h['nombre_usuario'] ?></td>
        <td><?= $h['accion_realizada'] ?></td>
    </tr>
    <?php } ?>
</table>
<br><a href="panel.php">Volver</a>