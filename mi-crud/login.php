<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Acceso al Sistema - CRUD App</title>
    <style>
        /* Estilos generales */
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f0f2f5;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }

        /* Tarjeta del Login */
        .login-container {
            background-color: #ffffff;
            padding: 40px;
            border-radius: 10px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
            width: 100%;
            max-width: 400px;
            text-align: center;
        }

        h2 {
            color: #1c1e21;
            margin-bottom: 25px;
            font-weight: 600;
        }

        /* Mensajes de error */
        .error-msg {
            background-color: #f8d7da;
            color: #721c24;
            padding: 10px;
            border-radius: 5px;
            margin-bottom: 20px;
            font-size: 0.9em;
            border: 1px solid #f5c6cb;
        }

        /* Formulario */
        .form-group {
            text-align: left;
            margin-bottom: 15px;
        }

        label {
            display: block;
            margin-bottom: 5px;
            color: #4b4f56;
            font-weight: bold;
            font-size: 0.9em;
        }

        input[type="text"],
        input[type="password"] {
            width: 100%;
            padding: 12px;
            border: 1px solid #dddfe2;
            border-radius: 6px;
            box-sizing: border-box; /* Importante para el ancho */
            font-size: 1em;
        }

        input:focus {
            outline: none;
            border-color: #1877f2;
            box-shadow: 0 0 0 2px #e7f3ff;
        }

        /* Botón */
        button {
            width: 100%;
            padding: 12px;
            background-color: #1877f2;
            border: none;
            border-radius: 6px;
            color: white;
            font-size: 1.1em;
            font-weight: bold;
            cursor: pointer;
            transition: background-color 0.2s;
            margin-top: 10px;
        }

        button:hover {
            background-color: #166fe5;
        }

        .footer-text {
            margin-top: 20px;
            font-size: 0.85em;
            color: #606770;
        }
    </style>
<?php 
  require_once 'conexion.php'; 
?>
</head>
<body>
<div class="login-container">
<?php if ($es_respaldo): ?>
    <div style="background-color: #ff9800; color: white; text-align: center; padding: 10px; font-family: sans-serif;">
        ⚠️ <strong>Modo Respaldo Activo:</strong> El servidor principal no está disponible. 
        Solo lectura disponible temporalmente.
    </div>
<?php endif; ?>
        <h2>Iniciar Sesión</h2>

        <!-- Mostrar error si las credenciales fallan -->
        <?php if (isset($_GET['error'])): ?>
            <div class="error-msg">
                Usuario o contraseña incorrectos. Por favor, intenta de nuevo.
            </div>
        <?php endif; ?>

        <form action="auth.php" method="POST">
            <div class="form-group">
                <label for="username">Nombre de Usuario</label>
                <input type="text" id="username" name="username" placeholder="Ingresa tu usuario" required autofocus>
            </div>

            <div class="form-group">
                <label for="password">Contraseña</label>
                <input type="password" id="password" name="password" placeholder="Ingresa tu contraseña" required>
            </div>

            <button type="submit">Entrar al Sistema</button>
        </form>

        <div class="footer-text">
            CRUD App v1.0 &copy; <?php echo date('Y'); ?>
        </div>
    </div>

</body>
</html>
