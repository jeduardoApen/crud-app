<?php
session_start();
require 'conexion.php';

// Seguridad: Solo Admin
if (!isset($_SESSION['usuario_id']) || $_SESSION['rol_nombre'] !== 'Admin') {
    die("Acceso denegado.");
}

$id = $_GET['id'] ?? null;
if (!$id) { header("Location: usuarios.php"); exit; }

// Obtener datos actuales del usuario
$stmt = $pdo->prepare("SELECT * FROM usuarios WHERE id = ?");
$stmt->execute([$id]);
$u = $stmt->fetch();

// Procesar el formulario cuando se envía
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = $_POST['email'];
    $rol = $_POST['rol_id'];
    $estado = $_POST['activa'];

    $sql = "UPDATE usuarios SET email = ?, rol_id = ?, activa = ? WHERE id = ?";
    $pdo->prepare($sql)->execute([$email, $rol, $estado, $id]);

    header("Location: usuarios.php?msg=Usuario actualizado");
    exit();
}

// Obtener roles para el menú desplegable
$roles = $pdo->query("SELECT id, nombre FROM roles")->fetchAll();
?>

<h2>Editar Usuario: <?php echo htmlspecialchars($u['username']); ?></h2>
<form method="POST">
    <label>Email:</label><br>
    <input type="email" name="email" value="<?php echo htmlspecialchars($u['email']); ?>" required><br><br>

    <label>Rol:</label><br>
    <select name="rol_id">
        <?php foreach ($roles as $r): ?>
            <option value="<?php echo $r['id']; ?>" <?php if($r['id'] == $u['rol_id']) echo 'selected'; ?>>
                <?php echo $r['nombre']; ?>
            </option>
        <?php endforeach; ?>
    </select><br><br>

    <label>Estado:</label><br>
    <select name="activa">
        <option value="A" <?php if($u['activa'] == 'A') echo 'selected'; ?>>Activo</option>
        <option value="I" <?php if($u['activa'] == 'I') echo 'selected'; ?>>Inactivo</option>
    </select><br><br>

    <button type="submit">Guardar Cambios</button>
    <a href="usuarios.php">Cancelar</a>
</form>
