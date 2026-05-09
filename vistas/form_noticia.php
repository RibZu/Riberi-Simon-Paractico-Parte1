<?php
session_start();
if($_SESSION['es_editor'] != 1) {
    header("Location: panel.php");
    exit();
}
include '../modelos/bd.php';

$accion = "crear";
$titulo = ""; $descripcion = ""; $estado = "Borrador"; $id = ""; $imagen = ""; $comentario_correccion = "";

if(isset($_GET['id'])){
    $accion = "editar";
    $id = $_GET['id'];
    $res = mysqli_query($conexion, "SELECT * FROM noticias WHERE id=$id");
    $noticia = mysqli_fetch_assoc($res);
    $titulo = $noticia['titulo'];
    $descripcion = $noticia['descripcion'];
    $estado = $noticia['estado'];
    $imagen = $noticia['imagen'];
    $comentario_correccion = $noticia['comentario_correccion'];
}

if(isset($_SESSION['datos_form'])) {
    $titulo = $_SESSION['datos_form']['titulo'];
    $descripcion = $_SESSION['datos_form']['descripcion'];
    unset($_SESSION['datos_form']);
}
?>
<link rel="stylesheet" href="estilos.css">

<h2><?= $accion == 'crear' ? 'Crear' : 'Editar' ?> Noticia</h2>

<?php
if(isset($_SESSION['mensaje_error'])) {
    echo "<div style='color: #721c24; background-color: #f8d7da; border: 1px solid #f5c6cb; padding: 15px; border-radius: 8px; margin-bottom: 20px; width: 100%; max-width: 500px; box-sizing: border-box;'>";
    echo "<b>Error:</b> " . $_SESSION['mensaje_error'];
    echo "</div>";
    unset($_SESSION['mensaje_error']); 
}

if($estado == 'Para Corrección' && $comentario_correccion != "") {
    echo "<div style='background-color: #fff3cd; color: #856404; border: 1px solid #ffeeba; padding: 15px; margin-bottom: 20px; font-weight: bold; border-radius: 4px;'>";
    echo "Instrucción del Validador: " . $comentario_correccion;
    echo "</div>";
}
?>

<form action="../controladores/noticiaController.php" method="POST" enctype="multipart/form-data">
    <input type="hidden" name="accion" value="<?= $accion ?>">
    <input type="hidden" name="id_noticia" value="<?= $id ?>">
    <input type="hidden" name="estado_actual" value="<?= $estado ?>">
    <input type="hidden" name="imagen_actual" value="<?= $imagen ?>">

    Título: <br><input type="text" name="titulo" value="<?= $titulo ?>" size="50"><br><br>
    Descripción: <br><textarea name="descripcion" rows="5" cols="50"><?= $descripcion ?></textarea><br><br>
    
    <?php if($imagen != "") { ?>
        Imagen Actual: <?= $imagen ?><br>
    <?php } ?>
    
    Subir Nueva Imagen: <input type="file" name="imagen"><br><br>
    
    <button type="submit">Guardar Noticia</button>
</form>
<br>
<a href="panel.php"><button type="button">Volver al Panel</button></a>