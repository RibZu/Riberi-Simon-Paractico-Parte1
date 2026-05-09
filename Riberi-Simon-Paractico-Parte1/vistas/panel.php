<?php
session_start();
if(!isset($_SESSION['usuario_id'])) header("Location: login.php");
include '../modelos/bd.php';
$query_expirar = "UPDATE noticias SET estado = 'Expirada' WHERE estado = 'Publicada' AND DATEDIFF(CURDATE(), fecha_publicacion) > (SELECT dias_expiracion FROM configuracion WHERE id = 1)";
mysqli_query($conexion, $query_expirar);
?>
<link rel="stylesheet" href="estilos.css">
<?php
echo "<h3>Bienvenido ".$_SESSION['nombre']."</h3>";
echo "<a href='../controladores/cerrarSesionController.php'>Salir</a> | ";
echo "<a href='cambiar_clave.php'>Cambiar mi contraseña</a><br><br>";

if($_SESSION['es_admin'] == 1) {
    echo "<a href='form_usuarios.php'><button>Registrar Nuevo Usuario</button></a> ";
    echo "<a href='vista_admin.php'><button>Panel de Administrador</button></a> ";
}
if($_SESSION['es_editor'] == 1) {
    echo "<a href='form_noticia.php'><button>Crear Nueva Noticia</button></a>";
}

if(isset($_SESSION['mensaje_error'])) {
    echo "<div style='color: #721c24; background-color: #f8d7da; border: 1px solid #f5c6cb; padding: 15px; border-radius: 4px; margin-bottom: 20px;'>";
    echo $_SESSION['mensaje_error'];
    echo "</div>";
    unset($_SESSION['mensaje_error']);
}

echo "<hr><h4>Lista de Noticias</h4>";
echo "<table><tr><th>ID</th><th>Título</th><th>Estado</th><th>Acciones</th></tr>";
$resultado = mysqli_query($conexion, "SELECT * FROM noticias");

while($n = mysqli_fetch_assoc($resultado)) {
    echo "<tr>";
    echo "<td>".$n['id']."</td>";
    echo "<td>".$n['titulo']."</td>";
    echo "<td><b>".$n['estado']."</b></td>";
    echo "<td>";
    

    if(($n['estado'] == 'Borrador' || $n['estado'] == 'Para Corrección') && $_SESSION['es_editor'] == 1) {
        echo "<a href='form_noticia.php?id=".$n['id']."'>Editar</a> | ";
    }


    if($_SESSION['es_validador'] == 1 && $n['estado'] == 'Lista para Validación') {
        echo "<a href='validar_noticia.php?id=".$n['id']."' style='color: #fff; background: #2980b9; padding: 5px 10px; border-radius: 2px; font-weight: bold;'>VALIDAR</a> | ";
    }

    echo "<a href='historial_vista.php?id=".$n['id']."'>Historial</a>";
    
    
    if($_SESSION['es_editor'] == 1 && $n['estado'] == 'Borrador') {
        echo " | <form action='../controladores/noticiaController.php' method='POST' style='display:inline; border:none; padding:0; background:none; box-shadow:none;'>
                <input type='hidden' name='accion' value='cambiar_estado'>
                <input type='hidden' name='id_noticia' value='".$n['id']."'>
                <input type='hidden' name='nuevo_estado' value='Lista para Validación'>
                <button type='submit' style='width:auto; padding:5px; font-size:12px; background:#27ae60;'>Enviar a Validar</button>
              </form>";
    }

    echo "</td></tr>";
}
echo "</table>";
?>