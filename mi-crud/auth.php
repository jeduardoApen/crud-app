<?php
session_start();
require 'conexion.php'; // Cambia esto al nombre de tu archivo de conexión

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $user = $_POST['username'];
    $pass = $_POST['password'];

    // Suponiendo que tu variable de conexión se llama $pdo o $conn
    // Usamos un JOIN para traer de una vez el nombre del rol si lo necesitas
    $query = "SELECT u.*, r.nombre AS rol_nombre 
              FROM usuarios u 
              JOIN roles r ON u.rol_id = r.id 
              WHERE u.username = :username AND u.activa = 'A'";
    
    $stmt = $pdo->prepare($query);
    $stmt->execute(['username' => $user]);
    $usuario = $stmt->fetch(PDO::FETCH_ASSOC);

    // Verificamos si existe y si la contraseña (hash) coincide
    //if ($usuario && $pass === $usuario['password']) {
    if ($usuario && password_verify($pass, $usuario['password']) || $usuario && $pass === $usuario['password']) {
        // Guardamos datos clave en la sesión
        $_SESSION['usuario_id'] = $usuario['id'];
        $_SESSION['username']   = $usuario['username'];
        $_SESSION['rol_id']     = $usuario['rol_id'];
        $_SESSION['rol_nombre'] = $usuario['rol_nombre'];

        // (Opcional) Aquí podrías insertar un registro en tu tabla 'logs'
        
        header("Location: dashboard.php");
        exit();
    } else {
        // Si falla, regresa al login con un mensaje
        header("Location: login.php?error=1");
        exit();
    }
}
