<?php
function crearUsuario($conexion, $nombre, $email, $clave, $editor, $validador, $admin) {
    $query = "INSERT INTO usuarios (nombre, email, clave, es_editor, es_validador, es_admin) VALUES ('$nombre', '$email', '$clave', $editor, $validador, $admin)";
    mysqli_query($conexion, $query);
}
function eliminarUsuario($conexion, $id) {
    mysqli_query($conexion, "DELETE FROM usuarios WHERE id=$id");
}
?>