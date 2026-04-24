<?php
// Configuración
$db      = 'crud_app';
$user    = 'root';
$pass    = 'tu_contraseña'; 
$charset = 'utf8mb4';

$hosts = ['mi-mysql', 'mi-mysql-respaldo'];
$pdo = null;
$es_respaldo = false; // Variable para saber en qué servidor estamos

$options = [
    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    PDO::ATTR_EMULATE_PREPARES   => false,
    PDO::ATTR_TIMEOUT            => 2, 
];

foreach ($hosts as $host) {
    try {
        $dsn = "mysql:host=$host;dbname=$db;charset=$charset";
        $pdo = new PDO($dsn, $user, $pass, $options);
        
        // Si el host actual es el segundo de la lista, activamos el modo respaldo
        if ($host === 'mi-mysql-respaldo') {
            $es_respaldo = true;
        }
        break; 
    } catch (PDOException $e) {
        if ($host === end($hosts)) {
            die("Error crítico de conexión.");
        }
        continue;
    }
}
?>
