<?php
session_start();
require 'conexion.php';

// Seguridad: Solo Admin
if (!isset($_SESSION['usuario_id']) || $_SESSION['rol_nombre'] !== 'Admin') {
    die("Acceso denegado.");
}

$id = $_GET['id'] ?? null;

if ($id) {
    // Evitar que el admin se elimine a sí mismo
    if ($id == $_SESSION['usuario_id']) {
        die("No puedes eliminar tu propia cuenta.");
    }

    try {
        $stmt = $pdo->prepare("DELETE FROM usuarios WHERE id = ?");
        $stmt->execute([$id]);
        header("Location: usuarios.php?msg=Usuario eliminado");
    } catch (PDOException $e) {
        // Esto ocurrirá si el usuario tiene registros vinculados en otras tablas (FK)
        die("Error: No se puede eliminar el usuario porque tiene registros asociados.");
    }
} else {
    header("Location: usuarios.php");
}
?>
