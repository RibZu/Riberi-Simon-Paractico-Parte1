<?php
session_start();
if($_SESSION['es_validador'] != 1) {
    header("Location: panel.php");
    exit();
}
include '../modelos/bd.php';

$id = $_GET['id'];
$res = mysqli_query($conexion, "SELECT * FROM noticias WHERE id = $id");
$n = mysqli_fetch_assoc($res);

if(!$n) die("Noticia no encontrada.");
?>
<link rel="stylesheet" href="estilos.css">

<div style="max-width: 800px; margin: 0 auto;">
    <h2>Validación de Noticia #<?= $n['id'] ?></h2>
    
    <div style="background: white; padding: 30px; border: 1px solid #bdc3c7; margin-bottom: 20px;">
        <h1><?= $n['titulo'] ?></h1>
        <p><small>Estado actual: <b><?= $n['estado'] ?></b></small></p>
        <hr>
        
        <?php if($n['imagen'] != "") { ?>
            <div style="text-align: center; margin: 20px 0;">
                <img src="../imagenes/<?= $n['imagen'] ?>" style="max-width: 100%; border: 1px solid #ccc;">
            </div>
        <?php } ?>

        <div style="font-size: 16px; line-height: 1.8; text-align: justify;">
            <?= nl2br($n['descripcion']) ?>
        </div>
    </div>

    <h3>Decisión del Validador</h3>
    <form action="../controladores/noticiaController.php" method="POST" style="max-width: 100%; border-top: 4px solid #2c3e50;">
        <input type="hidden" name="accion" value="cambiar_estado">
        <input type="hidden" name="id_noticia" value="<?= $n['id'] ?>">
        <input type="hidden" name="autor_id" value="<?= $n['autor_id'] ?>">
        <input type="hidden" name="titulo" value="<?= $n['titulo'] ?>">

        <label>Comentario / Observaciones (Opcional):</label>
        <textarea name="comentario" rows="3" placeholder="Escribe aquí si solicitas correcciones..."></textarea>

        <label>Acción a realizar:</label>
        <select name="nuevo_estado" required>
            <option value="">-- Seleccionar Acción --</option>
            <option value="Publicada">Publicar</option>
            <option value="Para Corrección">Mandar a Corregir</option>
        </select>

        <button type="submit" style="margin-top: 15px;">Confirmar Decisión</button>
    </form>
    
    <br>
    <a href="panel.php"><button type="button" style="background-color: #7f8c8d;">Cancelar y Volver</button></a>
</div>