<?php
session_start();
if($_SESSION['es_admin'] != 1) {
    header("Location: ../vistas/panel.php");
    exit();
}
include '../modelos/bd.php';
include '../modelos/Usuario.php';
include '../modelos/Noticia.php';

$accion = isset($_POST['accion']) ? $_POST['accion'] : (isset($_GET['accion']) ? $_GET['accion'] : "");
$id = isset($_GET['id']) ? $_GET['id'] : "";

if($accion == 'eliminar_usuario') {
    if($id != $_SESSION['usuario_id']) {
        eliminarUsuario($conexion, $id);
    }
}

if($accion == 'eliminar_noticia') {
    eliminarNoticia($conexion, $id);
}

if($accion == 'actualizar_configuracion') {
    $dias = $_POST['dias_expiracion'];
    $limite_bytes = $_POST['max_peso_imagen'];
    
    $query = "UPDATE configuracion SET dias_expiracion = $dias, max_peso_imagen = $limite_bytes WHERE id = 1";
    mysqli_query($conexion, $query);
}

header("Location: ../vistas/vista_admin.php");
exit();
?>