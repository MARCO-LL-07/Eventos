<?php
include('ConexionDB.php');

$conexion = new ConexionDB();
$db = $conexion->conectar();

// Obtener datos del formulario
$username = $_POST['username'];
$correo = $_POST['email'];
$contraseña = $_POST['password'];

// Verificar si existe el usuario con ese correo y username
$sql_check = "SELECT * FROM users WHERE username = ? AND correo = ?";
$stmt = $db->prepare($sql_check);
$stmt->execute([$username, $correo]);
$usuario = $stmt->fetch(PDO::FETCH_ASSOC);

// Si se encontró el usuario
if ($usuario) {
    if ($usuario['contraseña'] === $contraseña) {
        echo "<div class='mensaje-exito'>
                <p>✅ Inicio de sesión exitoso.</p>
              </div>";

        echo "<script>
                setTimeout(function() {
                    window.location.href = 'panelcentral.html';
                }, 1000);
              </script>";
    } else {
        echo "❌ Contraseña incorrecta.";
    }
} else {
    echo "❌ Usuario no encontrado o correo incorrecto.";
}
?>
