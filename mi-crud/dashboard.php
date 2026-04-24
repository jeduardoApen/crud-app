<?php
session_start();
require 'conexion.php';

// Seguridad: Si no hay sesión, mandarlo al login
if (!isset($_SESSION['usuario_id'])) {
    header("Location: login.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Panel de Control - CRUD App</title>
    <style>
        * { box-sizing: border-box; margin: 0; padding: 0; }
        body { font-family: 'Segoe UI', sans-serif; background-color: #f4f7f6; display: flex; min-height: 100vh; }

        /* Barra Lateral */
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
        .top-bar { 
            display: flex; justify-content: space-between; align-items: center; 
            margin-bottom: 30px; background: white; padding: 15px 25px; border-radius: 8px; box-shadow: 0 2px 5px rgba(0,0,0,0.1);
        }

        /* Tarjetas de Resumen */
        .cards-container { display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 20px; }
        .card { background: white; padding: 20px; border-radius: 8px; box-shadow: 0 2px 5px rgba(0,0,0,0.1); border-top: 4px solid #3498db; }
        .card h3 { color: #7f8c8d; font-size: 0.9em; text-transform: uppercase; margin-bottom: 10px; }
        .card p { font-size: 1.5em; font-weight: bold; color: #2c3e50; }

        /* Botón Cerrar Sesión */
        .logout-btn { background-color: #e74c3c; color: white; padding: 8px 15px; border-radius: 5px; text-decoration: none; font-weight: bold; }
        .logout-btn:hover { background-color: #c0392b; }
        
        .badge { background: #3498db; color: white; padding: 3px 8px; border-radius: 12px; font-size: 0.8em; }
	.alert-respaldo {
            background-color: #e67e22;
            color: white;
            text-align: center;
            padding: 12px;
            font-weight: bold;
            box-shadow: 0 2px 5px rgba(0,0,0,0.2);
            position: sticky;
            top: 0;
            z-index: 1000;
        }
    </style>
</head>
<body>

    <!-- Barra Lateral -->
    <aside class="sidebar">
        <div class="sidebar-header">📦 CRUD System</div>
        <ul class="nav-links">
            <li><a href="dashboard.php">🏠 Inicio</a></li>
            <li><a href="perfil.php">👤 Mi Perfil</a></li>
            
            <!-- Menú solo para Admin -->
	<?php if ($_SESSION['rol_nombre'] === 'Admin'): ?>
    		<?php if (!$es_respaldo): ?>
        	<li><a href="usuarios.php">👥 Gestionar Usuarios</a></li>
    	<?php else: ?>
        	<li style="opacity: 0.5;"><a href="#" onclick="alert('Función deshabilitada en modo respaldo'); return false;">👥 			Gestionar Usuarios (Bloqueado)</a></li>
    	<?php endif; ?>
    		<li><a href="reportes.php">📊 Reportes</a></li>
	<?php endif; ?>

            
            <li style="margin-top: auto;"><a href="logout.php" style="color: #e74c3c;">🚪 Cerrar Sesión</a></li>
        </ul>
    </aside>

    <!-- Área de Contenido -->
    <main class="main-content">
        <?php if (isset($es_respaldo) && $es_respaldo): ?>
            <div class="alert-respaldo">
                ⚠️ MODO DE RESPALDO ACTIVO: El servidor principal no responde. 
                Algunas funciones de escritura podrían estar deshabilitadas.
            </div>
        <?php endif; ?>
        <header class="top-bar" style="margin-top: 20px;">
            <h2>Bienvenido, <?php echo htmlspecialchars($_SESSION['username']); ?></h2>
            <div>
                <span class="badge"><?php echo $_SESSION['rol_nombre']; ?></span>
            </div>
        </header>

        <section class="cards-container">
            <div class="card">
                <h3>Estado de Cuenta</h3>
                <p>Activa ✅</p>
            </div>
            <div class="card">
                <h3>Último Acceso</h3>
                <p><?php echo date('d/m/Y'); ?></p>
            </div>
            <div class="card">
                <h3>Rol Asignado</h3>
                <p><?php echo $_SESSION['rol_nombre']; ?></p>
            </div>
        </section>

        <div style="margin-top: 40px; background: white; padding: 25px; border-radius: 8px; box-shadow: 0 2px 5px rgba(0,0,0,0.1);">
            <h3>Notificaciones del sistema</h3>
            <p style="color: #7f8c8d; margin-top: 10px;">No tienes mensajes nuevos en este momento.</p>
        </div>
    </main>

</body>
</html>
