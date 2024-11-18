<?php
// Archivo: classes/Usuario.php

class Usuario {
    private $db;

    public function __construct($db) {
        $this->db = $db; // Instancia de conexión a la base de datos
    }

    // Crear un nuevo usuario
    public function crearUsuario($nombre, $correo, $contrasena, $id_rol = null, $id_privilegio = null) {
        try {
            // Insertar usuario en la tabla Usuarios
            $query = "INSERT INTO Usuarios (nombre, correo, contrasena) 
                      VALUES (:nombre, :correo, :contrasena)";
            $stmt = $this->db->prepare($query);

            $stmt->bindParam(':nombre', $nombre);
            $stmt->bindParam(':correo', $correo);
            $stmt->bindParam(':contrasena', password_hash($contrasena, PASSWORD_BCRYPT)); // Encriptar contraseña

            $stmt->execute();
            $id_usuario = $this->db->lastInsertId(); // Obtener el ID del nuevo usuario

            // Si se proporciona un id_rol, insertarlo en la tabla UsuarioRol
            if ($id_rol !== null) {
                $queryRol = "INSERT INTO UsuarioRol (id_usuario, id_rol) VALUES (:id_usuario, :id_rol)";
                $stmtRol = $this->db->prepare($queryRol);
                $stmtRol->bindParam(':id_usuario', $id_usuario);
                $stmtRol->bindParam(':id_rol', $id_rol);
                $stmtRol->execute();
            }

            // Si se proporciona un id_privilegio, insertarlo en la tabla UsuarioPrivilegio
            if ($id_privilegio !== null) {
                $queryPrivilegio = "INSERT INTO UsuarioPrivilegio (id_usuario, id_privilegio) 
                                    VALUES (:id_usuario, :id_privilegio)";
                $stmtPrivilegio = $this->db->prepare($queryPrivilegio);
                $stmtPrivilegio->bindParam(':id_usuario', $id_usuario);
                $stmtPrivilegio->bindParam(':id_privilegio', $id_privilegio);
                $stmtPrivilegio->execute();
            }

            return true; // Usuario creado correctamente
        } catch (PDOException $e) {
            die("Error al crear usuario: " . $e->getMessage());
        }
    }

    // Leer todos los usuarios
    public function obtenerUsuarios() {
        try {
            $query = "SELECT * FROM Usuarios";
            $stmt = $this->db->query($query);
            return $stmt->fetchAll(PDO::FETCH_ASSOC); // Retorna un arreglo asociativo
        } catch (PDOException $e) {
            die("Error al obtener usuarios: " . $e->getMessage());
        }
    }

    // Leer un usuario por ID
    public function obtenerUsuarioPorId($id_usuario) {
        try {
            $query = "SELECT * FROM Usuarios WHERE id_usuario = :id_usuario";
            $stmt = $this->db->prepare($query);
            $stmt->bindParam(':id_usuario', $id_usuario);
            $stmt->execute();
            return $stmt->fetch(PDO::FETCH_ASSOC); // Retorna un registro o false si no existe
        } catch (PDOException $e) {
            die("Error al obtener usuario: " . $e->getMessage());
        }
    }

    // Actualizar un usuario
    public function actualizarUsuario($id_usuario, $nombre, $correo, $contrasena = null, $id_rol = null, $id_privilegio = null) {
        try {
            $query = "UPDATE Usuarios 
                      SET nombre = :nombre, correo = :correo";
            if ($contrasena) {
                $query .= ", contrasena = :contrasena"; // Solo actualizar contraseña si se proporciona
            }
            $query .= " WHERE id_usuario = :id_usuario";

            $stmt = $this->db->prepare($query);

            $stmt->bindParam(':id_usuario', $id_usuario);
            $stmt->bindParam(':nombre', $nombre);
            $stmt->bindParam(':correo', $correo);

            if ($contrasena) {
                $stmt->bindParam(':contrasena', password_hash($contrasena, PASSWORD_BCRYPT));
            }

            $stmt->execute();

            // Si se proporciona un id_rol, actualizarlo en la tabla UsuarioRol
            if ($id_rol !== null) {
                $queryRol = "UPDATE UsuarioRol SET id_rol = :id_rol WHERE id_usuario = :id_usuario";
                $stmtRol = $this->db->prepare($queryRol);
                $stmtRol->bindParam(':id_usuario', $id_usuario);
                $stmtRol->bindParam(':id_rol', $id_rol);
                $stmtRol->execute();
            }

            // Si se proporciona un id_privilegio, actualizarlo en la tabla UsuarioPrivilegio
            if ($id_privilegio !== null) {
                $queryPrivilegio = "UPDATE UsuarioPrivilegio SET id_privilegio = :id_privilegio WHERE id_usuario = :id_usuario";
                $stmtPrivilegio = $this->db->prepare($queryPrivilegio);
                $stmtPrivilegio->bindParam(':id_usuario', $id_usuario);
                $stmtPrivilegio->bindParam(':id_privilegio', $id_privilegio);
                $stmtPrivilegio->execute();
            }

            return true; // Usuario actualizado correctamente
        } catch (PDOException $e) {
            die("Error al actualizar usuario: " . $e->getMessage());
        }
    }

    // Eliminar un usuario
    public function eliminarUsuario($id_usuario) {
        try {
            $query = "DELETE FROM Usuarios WHERE id_usuario = :id_usuario";
            $stmt = $this->db->prepare($query);
            $stmt->bindParam(':id_usuario', $id_usuario);
            return $stmt->execute();
        } catch (PDOException $e) {
            die("Error al eliminar usuario: " . $e->getMessage());
        }
    }
}
?>
