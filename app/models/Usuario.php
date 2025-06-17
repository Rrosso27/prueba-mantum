<?php
require_once  'Model.php';

class Usuario extends Model
{
    protected $table = 'usuarios';

    // Crear un nuevo usuario
    public function create($data)
    {

        $sql = "INSERT INTO {$this->table} (nombre, cedula, fecha_nacimiento, sexo) VALUES (:nombre, :cedula, :fecha_nacimiento, :sexo)";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':nombre', $data['nombre']);
        $stmt->bindParam(':cedula', $data['cedula']);
        $stmt->bindParam(':fecha_nacimiento', $data['fecha_nacimiento']);
        $stmt->bindParam(':sexo', $data['sexo']);
        return $stmt->execute();
    }

    // Actualizar un usuario
    public function update($id, $data)
    {
        $sql = "UPDATE {$this->table} SET nombre = :nombre, cedula = :cedula , fecha_nacimiento = :fecha_nacimiento, sexo = :sexo WHERE id = :id";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->bindParam(':nombre', $data['nombre']);
        $stmt->bindParam(':cedula', $data['cedula']);
        $stmt->bindParam(':fecha_nacimiento', $data['fecha_nacimiento']);
        $stmt->bindParam(':sexo', $data['sexo']);
        return $stmt->execute();
    }

    // validar si la cedula ya existe
    public function exists($cedula, $id = null)
    {
        $sql = "SELECT id , cedula  FROM {$this->table} WHERE cedula = :cedula";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':cedula', $cedula);
        $stmt->execute();
        return $stmt->fetch();
    }
}
