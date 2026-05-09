<?php
function crearNoticia($conexion, $titulo, $descripcion, $imagen, $autor_id) {
    $query = "INSERT INTO noticias (titulo, descripcion, imagen, estado, fecha_creacion, autor_id) VALUES ('$titulo', '$descripcion', '$imagen', 'Borrador', NOW(), $autor_id)";
    mysqli_query($conexion, $query);
    return mysqli_insert_id($conexion);
}
function actualizarNoticia($conexion, $id, $titulo, $descripcion, $imagen, $estado) {
    $query = "UPDATE noticias SET titulo='$titulo', descripcion='$descripcion', imagen='$imagen', estado='$estado' WHERE id=$id";
    mysqli_query($conexion, $query);
}
function cambiarEstadoNoticia($conexion, $id, $nuevo_estado, $es_publicada = false, $comentario = "") {
    if($es_publicada){
        
        $query = "UPDATE noticias SET estado='$nuevo_estado', fecha_publicacion=NOW(), comentario_correccion='' WHERE id=$id";
    } else {

        $query = "UPDATE noticias SET estado='$nuevo_estado', comentario_correccion='$comentario' WHERE id=$id";
    }
    mysqli_query($conexion, $query);
}
function eliminarNoticia($conexion, $id) {
    mysqli_query($conexion, "DELETE FROM historial WHERE noticia_id=$id");
    mysqli_query($conexion, "DELETE FROM noticias WHERE id=$id");
}
?>