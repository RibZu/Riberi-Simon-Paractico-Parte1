<?php
session_start();
include '../modelos/bd.php';
include '../modelos/Noticia.php';
include '../modelos/Historial.php';

$accion = $_POST['accion'];

$resConfig = mysqli_query($conexion, "SELECT max_peso_imagen FROM configuracion WHERE id = 1");
$config = mysqli_fetch_assoc($resConfig);
$limite_bytes = $config['max_peso_imagen'];

if($accion == 'crear') {
    if($_SESSION['es_editor'] != 1) {
        $_SESSION['mensaje_error'] = "No tienes permisos de editor.";
        header("Location: ../vistas/form_noticia.php"); exit();
    }
    
    $titulo = $_POST['titulo'];
    $descripcion = $_POST['descripcion'];
    
    if(strlen($titulo) < 10 || strlen($titulo) > 100) {
        $_SESSION['mensaje_error'] = "El título debe tener entre 10 y 100 caracteres.";
        $_SESSION['datos_form'] = $_POST;
        header("Location: ../vistas/form_noticia.php"); exit();
    }
    if(strlen($descripcion) < 50) {
        $_SESSION['mensaje_error'] = "La descripción debe tener al menos 50 caracteres.";
        $_SESSION['datos_form'] = $_POST;
        header("Location: ../vistas/form_noticia.php"); exit();
    }
    
    $imagen = "";
    if($_FILES['imagen']['name'] != "") {
        if($_FILES['imagen']['size'] > $limite_bytes) {
            $_SESSION['mensaje_error'] = "La imagen supera el límite de peso permitido.";
            $_SESSION['datos_form'] = $_POST;
            header("Location: ../vistas/form_noticia.php"); exit();
        }
        $imagen = $_FILES['imagen']['name'];
        move_uploaded_file($_FILES['imagen']['tmp_name'], "../imagenes/".$imagen);
    }

    $id_nueva = crearNoticia($conexion, $titulo, $descripcion, $imagen, $_SESSION['usuario_id']);
    registrarHistorial($conexion, $id_nueva, $_SESSION['usuario_id'], "Creada");
    
    unset($_SESSION['datos_form']); 
    header("Location: ../vistas/panel.php");
    exit();
}

if($accion == 'editar') {
    $id_noticia = $_POST['id_noticia'];
    $titulo = $_POST['titulo'];
    $descripcion = $_POST['descripcion'];
    $estado_actual = $_POST['estado_actual'];
    $imagen = $_POST['imagen_actual'];

    if(strlen($titulo) < 10 || strlen($titulo) > 100) {
        $_SESSION['mensaje_error'] = "El título debe tener entre 10 y 100 caracteres.";
        $_SESSION['datos_form'] = $_POST;
        header("Location: ../vistas/form_noticia.php?id=" . $id_noticia); exit();
    }
    if(strlen($descripcion) < 50) {
        $_SESSION['mensaje_error'] = "La descripción debe tener al menos 50 caracteres.";
        $_SESSION['datos_form'] = $_POST;
        header("Location: ../vistas/form_noticia.php?id=" . $id_noticia); exit();
    }

    if($_FILES['imagen']['name'] != "") {
        if($_FILES['imagen']['size'] > $limite_bytes) {
            $_SESSION['mensaje_error'] = "La imagen supera el límite de peso permitido.";
            $_SESSION['datos_form'] = $_POST;
            header("Location: ../vistas/form_noticia.php?id=" . $id_noticia); exit();
        }
        $imagen = $_FILES['imagen']['name'];
        move_uploaded_file($_FILES['imagen']['tmp_name'], "../imagenes/".$imagen);
    }

    $nuevo_estado = ($estado_actual == 'Para Corrección') ? 'Borrador' : $estado_actual;

    actualizarNoticia($conexion, $id_noticia, $titulo, $descripcion, $imagen, $nuevo_estado);
    registrarHistorial($conexion, $id_noticia, $_SESSION['usuario_id'], "Modificada");

    unset($_SESSION['datos_form']);
    header("Location: ../vistas/panel.php");
    exit();
}

if($accion == 'cambiar_estado') {
    $id_noticia = $_POST['id_noticia'];
    $nuevo_estado = $_POST['nuevo_estado'];
    $autor_id = $_POST['autor_id'];
    $titulo = $_POST['titulo'];
    $comentario = isset($_POST['comentario']) ? $_POST['comentario'] : ""; 

    if($nuevo_estado == 'Publicada' || $nuevo_estado == 'Para Corrección') {
        if($_SESSION['es_validador'] != 1) {
            $_SESSION['mensaje_error'] = "No tienes permisos de validador.";
            header("Location: ../vistas/panel.php"); exit();
        }
        if($_SESSION['usuario_id'] == $autor_id) {
            $_SESSION['mensaje_error'] = "No puedes validar tus propias noticias.";
            header("Location: ../vistas/panel.php"); exit();
        }
    }

    $es_publicada = false;
    if($nuevo_estado == 'Publicada') {
        $check = mysqli_query($conexion, "SELECT id FROM noticias WHERE titulo='$titulo' AND estado='Publicada'");
        if(mysqli_num_rows($check) > 0) {
            $_SESSION['mensaje_error'] = "Ya existe una noticia publicada con ese título.";
            header("Location: ../vistas/panel.php"); exit();
        }
        $es_publicada = true;
    }

    cambiarEstadoNoticia($conexion, $id_noticia, $nuevo_estado, $es_publicada, $comentario);
    
    if($nuevo_estado == 'Para Corrección' && $comentario != "") {
        $texto_historial = "Enviada a corrección. Motivo: " . $comentario;
    } else {
        $texto_historial = "Cambio de estado a $nuevo_estado";
    }
    registrarHistorial($conexion, $id_noticia, $_SESSION['usuario_id'], $texto_historial);

    header("Location: ../vistas/panel.php");
    exit();
}
?>