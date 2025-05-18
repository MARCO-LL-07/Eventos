<?php
include('ConexionDB.php');
$conexion = new ConexionDB();
$db = $conexion->conectar();


    $username = $_POST['username'];
    $correo = $_POST['email'];
    $telefono = $_POST['telefono'];
    $password = $_POST['password'];

    // Validación básica
    if (empty($username) || empty($correo) || empty($telefono) || empty($password)) {
        echo "❌ Todos los campos son obligatorios.";
        exit;
    }

    // Hashear la contraseña para seguridad
    $passwordHash = password_hash($password, PASSWORD_DEFAULT);

    // Conectar a la base de datos
    
    if ($db) {
        // Verificar si el correo ya está registrado
        $sql_check = "SELECT COUNT(*) FROM users WHERE correo = ?";
        $stmt_check = $db->prepare($sql_check);
        $stmt_check->execute([$correo]);

        if ($stmt_check->fetchColumn() > 0) {
            echo "❌ El correo ya está registrado.";
        } else {
            // Insertar nuevo usuario
            $sql = "INSERT INTO users (username, telefono, correo, contraseña) VALUES (?, ?, ?, ?)";
            $stmt = $db->prepare($sql);

            if ($stmt->execute([$username, $telefono, $correo, $passwordHash])) {
                echo "<div class='mensaje-exito'>
               <p>¡Solicitud enviada exitosamente!</p>
             </div>";

        
        echo "<script>
                setTimeout(function() {
                    window.location.href = 'panelcentral.html';
                }, 1000);
              </script>";
            } else {
                echo "❌ Error al registrar usuario.";
            }
        }
    } else {
        echo "❌ Error de conexión a la base de datos.";
    }

?>
