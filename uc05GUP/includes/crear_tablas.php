<?php
try {
    // Conexión a SQLite
    $db = new PDO('sqlite:' . __DIR__ . '/config/database.sqlite');
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Script para crear las tablas
    $queries = [
        "CREATE TABLE IF NOT EXISTS Usuarios (
            id_usuario INTEGER PRIMARY KEY AUTOINCREMENT,
            Nombre TEXT NOT NULL,
            Correo TEXT NOT NULL UNIQUE,
            Contrasena TEXT NOT NULL
        )",
        "CREATE TABLE IF NOT EXISTS Roles (
            id_rol INTEGER PRIMARY KEY AUTOINCREMENT,
            Tipo TEXT NOT NULL
        )",
        "CREATE TABLE IF NOT EXISTS Privilegios (
            id_privilegio INTEGER PRIMARY KEY AUTOINCREMENT,
            activo INTEGER DEFAULT 1
        )",
        "CREATE TABLE IF NOT EXISTS UsuarioRol (
            id_usuarioRol INTEGER PRIMARY KEY AUTOINCREMENT,
            id_usuario INTEGER,
            id_rol INTEGER,
            FOREIGN KEY (id_usuario) REFERENCES Usuarios (id_usuario),
            FOREIGN KEY (id_rol) REFERENCES Roles (id_rol)
        )",
        "CREATE TABLE IF NOT EXISTS UsuarioPrivilegio (
            id_rolPrivilegio INTEGER PRIMARY KEY AUTOINCREMENT,
            id_usuario INTEGER,
            id_privilegio INTEGER,
            FOREIGN KEY (id_usuario) REFERENCES Usuarios (id_usuario),
            FOREIGN KEY (id_privilegio) REFERENCES Privilegios (id_privilegio)
        )"
    ];

    // Ejecutar las consultas
    foreach ($queries as $query) {
        $db->exec($query);
    }

    echo "Tablas creadas correctamente en SQLite.";
} catch (PDOException $e) {
    die("Error al crear las tablas: " . $e->getMessage());
}
