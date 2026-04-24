<?php
session_start();
require 'conexion.php';

// Seguridad: Solo el Admin puede crear usuarios
if (!isset($_SESSION['usuario_id']) || $_SESSION['rol_nombre'] !== 'Admin') {
    die("Acceso denegado.");
}

// 1. Obtener los roles de la base de datos para el desplegable
$roles = $pdo->query("SELECT id, nombre FROM roles")->fetchAll();

// 2. Procesar el formulario cuando se envía (POST)
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT); // ¡Encriptación clave!
    $email    = $_POST['email'];
    $nombres  = $_POST['nombres'];
    $apellidos = $_POST['apellidos'];
    $rol_id   = $_POST['rol_id'];

    try {
        $sql = "INSERT INTO usuarios (username, password, email, nombres, apellidos, rol_id, activa) 
                VALUES (?, ?, ?, ?, ?, ?, 'A')";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$username, $password, $email, $nombres, $apellidos, $rol_id]);
        
        header("Location: usuarios.php?msg=Usuario creado exitosamente");
        exit();
    } catch (PDOException $e) {
        $error = "Error al crear usuario: " . $e->getMessage();
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Crear Nuevo Usuario</title>
    <style>
        body { font-family: sans-serif; margin: 30px; }
        .form-group { margin-bottom: 15px; }
        label { display: block; margin-bottom: 5px; font-weight: bold; }
        input, select { width: 300px; padding: 8px; border: 1px solid #ccc; border-radius: 4px; }
        .btn-save { background: #28a745; color: white; padding: 10px 20px; border: none; cursor: pointer; border-radius: 4px; }
        .error { color: red; margin-bottom: 15px; }
    </style>
</head>
<body>

    <h2>Crear Nuevo Usuario</h2>

    <?php if (isset($error)): ?>
        <p class="error"><?php echo $error; ?></p>
    <?php endif; ?>

    <form method="POST">
        <div class="form-group">
            <label>Username:</label>
            <input type="text" name="username" required>
        </div>

        <div class="form-group">
            <label>Contraseña:</label>
            <input type="password" name="password" required>
        </div>

        <div class="form-group">
            <label>Email:</label>
            <input type="email" name="email">
        </div>

        <div class="form-group">
            <label>Nombres:</label>
            <input type="text" name="nombres">
        </div>

        <div class="form-group">
            <label>Apellidos:</label>
            <input type="text" name="apellidos">
        </div>

        <div class="form-group">
            <label>Rol:</label>
            <select name="rol_id" required>
                <option value="">Seleccione un rol...</option>
                <?php foreach ($roles as $r): ?>
                    <option value="<?php echo $r['id']; ?>"><?php echo $r['nombre']; ?></option>
                <?php endforeach; ?>
            </select>
        </div>

        <button type="submit" class="btn-save">Registrar Usuario</button>
        <a href="usuarios.php">Cancelar</a>
    </form>

</body>
</html>
