<?php
require_once '../includes/app.php';
require_once '../classes/Usuario.php';

$usuarioModel = new Usuario($db);

// Crear usuario
//$usuarioModel->crearUsuario("Anderson Mancilla", "anderson@gmail.com", "1234", 1, 2);

// Leer usuarios
$usuarios = $usuarioModel->obtenerUsuarios();
echo "<pre>";
var_dump($usuarios);
echo "</pre>";
?>
