<?php
// Configuración de la base de datos
$host    = 'mi-mysql';       // Servidor
$db      = 'crud_app';        // El nombre de tu base de datos
$user    = 'root';            // Tu usuario de MySQL (por defecto root en XAMPP)
$pass    = 'tu_contraseña';                // Tu contraseña de MySQL (vacío por defecto en XAMPP)
$charset = 'utf8mb4';         // Codificación recomendada para caracteres especiales

// Cadena de conexión (DSN)
$dsn = "mysql:host=$host;dbname=$db;charset=$charset";

// Opciones adicionales de PDO
$options = [
    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION, // Lanza excepciones en errores
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,       // Devuelve los datos como arreglos asociativos
    PDO::ATTR_EMULATE_PREPARES   => false,                  // Desactiva la emulación para mayor seguridad
];

try {
    // Se crea la instancia de conexión que usa el archivo auth.php
    $pdo = new PDO($dsn, $user, $pass, $options);
} catch (PDOException $e) {
    // Si hay un error, detiene la ejecución y muestra el mensaje
    die("Error de conexión: " . $e->getMessage());
}
?>
