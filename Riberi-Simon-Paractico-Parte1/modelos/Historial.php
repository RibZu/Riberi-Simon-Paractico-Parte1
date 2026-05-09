<?php
function registrarHistorial($conexion, $noticia_id, $nombre_usuario, $accion) {
    $query = "INSERT INTO historial (noticia_id, nombre_usuario, accion_realizada, fecha_hora) 
              VALUES ($noticia_id, '$nombre_usuario', '$accion', NOW())";
    mysqli_query($conexion, $query);
}
?>