<?php
// Archivo: includes/app.php
require_once __DIR__ . '/config/database.php';

// Instancia de conexión global
$dbInstance = new Database();
$db = $dbInstance->getConnection();
?>
