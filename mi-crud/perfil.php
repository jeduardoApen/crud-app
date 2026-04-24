<?php
session_start();
require 'conexion.php';

// Seguridad: Si no hay sesión, mandarlo al login
if (!isset($_SESSION['usuario_id'])) {
    header("Location: login.php");
    exit();
}

// Obtener datos actualizados del usuario desde la BD
$id = $_SESSION['usuario_id'];
$stmt = $pdo->prepare("SELECT u.*, r.nombre AS rol_nombre FROM usuarios u JOIN roles r ON u.rol_id = r.id WHERE u.id = ?");
$stmt->execute([$id]);
$perfil = $stmt->fetch();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mi Perfil - CRUD App</title>
    <style>
        /* Reutilizamos la base del Dashboard para que sea uniforme */
        * { box-sizing: border-box; margin: 0; padding: 0; }
        body { font-family: 'Segoe UI', sans-serif; background-color: #f4f7f6; display: flex; min-height: 100vh; }

        /* Barra Lateral (Mismo estilo que Dashboard) */
        .sidebar { width: 250px; background-color: #2c3e50; color: white; display: flex; flex-direction: column; }
        .sidebar-header { padding: 20px; text-align: center; background-color: #1a252f; font-size: 1.2em; font-weight: bold; }
        .nav-links { list-style: none; flex-grow: 1; margin-top: 20px; }
        .nav-links li a { 
            display: block; padding: 15px 20px; color: #bdc3c7; text-decoration: none; 
            transition: all 0.3s; border-left: 4px solid transparent;
        }
        .nav-links li a:hover { background-color: #34495e; color: white; border-left: 4px solid #3498db; }

        /* Contenido Principal */
        .main-content { flex-grow: 1; padding: 30px; }
        
        /* Tarjeta de Perfil */
        .profile-card {
            max-width: 600px;
            background: white;
            padding: 40px;
            border-radius: 12px;
            box-shadow: 0 4px 15px rgba(0,0,0,0.05);
            margin: 0 auto; /* Centrar la tarjeta */
        }

        .profile-header {
            text-align: center;
            margin-bottom: 30px;
        }

        .profile-header .avatar {
            width: 100px;
            height: 100px;
            background: #3498db;
            color: white;
            font-size: 3em;
            line-height: 100px;
            border-radius: 50%;
            margin: 0 auto 15px;
            text-transform: uppercase;
        }

        .info-group {
            border-bottom: 1px solid #eee;
            padding: 15px 0;
            display: flex;
            justify-content: space-between;
        }

        .info-group:last-child { border-bottom: none; }

        .label { font-weight: bold; color: #7f8c8d; text-transform: uppercase; font-size: 0.8em; }
        .value { color: #2c3e50; font-weight: 500; }

        .status-pill {
            background: #d4edda;
            color: #155724;
            padding: 4px 12px;
            border-radius: 20px;
            font-size: 0.85em;
            font-weight: bold;
        }
    </style>
</head>
<body>

    <!-- Barra Lateral -->
    <aside class="sidebar">
        <div class="sidebar-header">📦 CRUD System</div>
        <ul class="nav-links">
            <li><a href="dashboard.php">🏠 Inicio</a></li>
            <li><a href="perfil.php" style="background-color: #34495e; color: white; border-left-color: #3498db;">👤 Mi Perfil</a></li>
            
            <?php if ($_SESSION['rol_nombre'] === 'Admin'): ?>
                <li><a href="usuarios.php">👥 Gestionar Usuarios</a></li>
            <?php endif; ?>
            
            <li style="margin-top: auto;"><a href="logout.php" style="color: #e74c3c;">🚪 Cerrar Sesión</a></li>
        </ul>
    </aside>

    <!-- Área de Contenido -->
    <main class="main-content">
        <div class="profile-card">
            <div class="profile-header">
                <!-- Mostramos la inicial del nombre como avatar -->
                <div class="avatar"><?php echo substr($perfil['nombres'], 0, 1); ?></div>
                <h2>Mi Información Personal</h2>
                <p style="color: #7f8c8d;">Gestiona los datos de tu cuenta</p>
            </div>

            <div class="info-group">
                <span class="label">Nombre de Usuario</span>
                <span class="value">@<?php echo htmlspecialchars($perfil['username']); ?></span>
            </div>

            <div class="info-group">
                <span class="label">Nombre Completo</span>
                <span class="value"><?php echo htmlspecialchars($perfil['nombres'] . " " . $perfil['apellidos']); ?></span>
            </div>

            <div class="info-group">
                <span class="label">Correo Electrónico</span>
                <span class="value"><?php echo htmlspecialchars($perfil['email']); ?></span>
            </div>

            <div class="info-group">
                <span class="label">Rol del Sistema</span>
                <span class="value"><?php echo htmlspecialchars($perfil['rol_nombre']); ?></span>
            </div>

            <div class="info-group">
                <span class="label">Estado</span>
                <span class="value">
                    <span class="status-pill"><?php echo ($perfil['activa'] == 'A') ? 'Activo' : 'Inactivo'; ?></span>
                </span>
            </div>
            
            <div style="margin-top: 30px; text-align: center;">
                <a href="dashboard.php" style="color: #3498db; text-decoration: none; font-weight: bold;">← Volver al inicio</a>
            </div>
        </div>
    </main>

</body>
</html>
