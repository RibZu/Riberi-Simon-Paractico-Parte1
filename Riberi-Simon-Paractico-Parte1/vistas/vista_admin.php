<?php
session_start();
if($_SESSION['es_admin'] != 1) {
    header("Location: panel.php");
    exit();
}
include '../modelos/bd.php';

$resConfig = mysqli_query($conexion, "SELECT * FROM configuracion WHERE id = 1");
$config = mysqli_fetch_assoc($resConfig);
?>
<link rel="stylesheet" href="estilos.css">

<h2>Panel Exclusivo de Administrador</h2>
<a href="panel.php"><button type="button" style="background-color: #7f8c8d;">Volver al Panel General</button></a>

<div style="display: flex; flex-wrap: wrap; gap: 20px; justify-content: center; align-items: flex-start; margin-top: 30px;">

    <form action="../controladores/adminController.php" method="POST" style="border-top: 4px solid #2980b9;">
        <input type="hidden" name="accion" value="actualizar_configuracion">
        <h3>Configuración del Sistema</h3>
        
        <label>Días para que expire una noticia:</label>
        <input type="number" name="dias_expiracion" value="<?= $config['dias_expiracion'] ?>" min="1" step="1" required>

        <label>Tamaño máximo de imagen:</label>
        <select name="max_peso_imagen">
            <option value="1048576" <?= $config['max_peso_imagen'] == 1048576 ? 'selected' : '' ?>>1 MB</option>
            <option value="2097152" <?= $config['max_peso_imagen'] == 2097152 ? 'selected' : '' ?>>2 MB</option>
            <option value="5242880" <?= $config['max_peso_imagen'] == 5242880 ? 'selected' : '' ?>>5 MB</option>
            <option value="10485760" <?= $config['max_peso_imagen'] == 10485760 ? 'selected' : '' ?>>10 MB</option>
        </select>

        <button type="submit">Guardar Cambios</button>
    </form>

    <div style="flex: 1; min-width: 500px;">
        <h3>Gestión de Usuarios</h3>
        <table>
            <tr><th>ID</th><th>Nombre</th><th>Email</th><th>Acción</th></tr>
            <?php
            $resU = mysqli_query($conexion, "SELECT * FROM usuarios");
            while($u = mysqli_fetch_assoc($resU)) {
                echo "<tr>";
                echo "<td>".$u['id']."</td>";
                echo "<td>".$u['nombre']."</td>";
                echo "<td>".$u['email']."</td>";
                echo "<td><a href='../controladores/adminController.php?accion=eliminar_usuario&id=".$u['id']."' style='color:red;'>Eliminar</a></td>";
                echo "</tr>";
            }
            ?>
        </table>

        <h3>Gestión de Noticias</h3>
        <table>
            <tr><th>ID</th><th>Título</th><th>Estado</th><th>Acción</th></tr>
            <?php
            $resN = mysqli_query($conexion, "SELECT * FROM noticias");
            while($n = mysqli_fetch_assoc($resN)) {
                echo "<tr>";
                echo "<td>".$n['id']."</td>";
                echo "<td>".$n['titulo']."</td>";
                echo "<td>".$n['estado']."</td>";
                echo "<td><a href='../controladores/adminController.php?accion=eliminar_noticia&id=".$n['id']."' style='color:red;'>Eliminar</a></td>";
                echo "</tr>";
            }
            ?>
        </table>
    </div>
</div>