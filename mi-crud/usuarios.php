<?php
session_start();
require 'conexion.php';

if (isset($es_respaldo) && $es_respaldo) {
    header("Location: dashboard.php?msg=acceso_restringido");
    exit();
}

// Verificar si el usuario está logueado y si es Admin
if (!isset($_SESSION['usuario_id']) || $_SESSION['rol_nombre'] !== 'Admin') {
    // Si no es admin, lo sacamos o mostramos error
    die("Acceso denegado: No tienes permisos de administrador para ver esta página.");
}

// 2. LÓGICA DE DATOS: Obtener la lista de usuarios
try {
    $query = "SELECT u.id, u.username, u.email, u.nombres, u.apellidos, r.nombre AS rol_nombre, u.activa 
              FROM usuarios u 
              JOIN roles r ON u.rol_id = r.id";
    $stmt = $pdo->query($query);
    $usuarios = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    die("Error al consultar usuarios: " . $e->getMessage());
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Gestión de Usuarios - Admin</title>
    <style>
        body { font-family: sans-serif; margin: 20px; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { border: 1px solid #ccc; padding: 10px; text-align: left; }
        th { background-color: #f4f4f4; }
        .btn { padding: 5px 10px; text-decoration: none; border-radius: 3px; font-size: 0.9em; }
        .btn-edit { background-color: #ffc107; color: black; }
        .btn-delete { background-color: #dc3545; color: white; }
        .alert { background: #d4edda; color: #155724; padding: 10px; margin-bottom: 20px; border: 1px solid #c3e6cb; }
        .status-active { color: green; font-weight: bold; }
        .status-inactive { color: red; }
    </style>
</head>
<body>

    <header>
        <h1>Panel de Gestión de Usuarios</h1>
        <p>Bienvenido, <strong><?php echo htmlspecialchars($_SESSION['username']); ?></strong> | <a href="dashboard.php">Volver al Panel</a></p>
    </header>

    <!-- 3. MENSAJES DE ÉXITO (Solo si existen en la URL) -->
    <?php if (isset($_GET['msg'])): ?>
        <div class="alert">
            <?php echo htmlspecialchars($_GET['msg']); ?>
        </div>
    <?php endif; ?>
<div style="margin-bottom: 20px;">
    <a href="crear_usuario.php" style="background: #007bff; color: white; padding: 10px 15px; text-decoration: none; border-radius: 4px;">
        + Agregar Nuevo Usuario
    </a>
</div>
    <!-- 4. TABLA DE USUARIOS -->
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Usuario</th>
                <th>Nombre Completo</th>
                <th>Email</th>
                <th>Rol</th>
                <th>Estado</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($usuarios as $u): ?>
            <tr>
                <td><?php echo $u['id']; ?></td>
                <td><?php echo htmlspecialchars($u['username']); ?></td>
                <td><?php echo htmlspecialchars($u['nombres'] . " " . $u['apellidos']); ?></td>
                <td><?php echo htmlspecialchars($u['email']); ?></td>
                <td><?php echo htmlspecialchars($u['rol_nombre']); ?></td>
                <td>
                    <span class="<?php echo ($u['activa'] == 'A') ? 'status-active' : 'status-inactive'; ?>">
                        <?php echo ($u['activa'] == 'A') ? 'Activo' : 'Inactivo'; ?>
                    </span>
                </td>
                <td>
                    <a href="editar_usuario.php?id=<?php echo $u['id']; ?>" class="btn btn-edit">Editar</a>
                    
                    <!-- Solo mostrar botón eliminar si no es el usuario actual -->
                    <?php if ($u['id'] != $_SESSION['usuario_id']): ?>
                        <a href="eliminar_usuario.php?id=<?php echo $u['id']; ?>" 
                           class="btn btn-delete" 
                           onclick="return confirm('¿Estás seguro de eliminar a este usuario?')">Eliminar</a>
                    <?php endif; ?>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

</body>
</html>
