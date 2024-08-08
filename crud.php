<?php

class CrudController
{
    private $conn;

    public function __construct($host, $dbname, $username, $password, $endpoint)
    {
        try {
            $dsn = "pgsql:host=$host;dbname=$dbname;options=endpoint=$endpoint;sslmode=require";
            $this->conn = new PDO($dsn, $username, $password);
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            echo "Error de conexión: " . $e->getMessage();
            exit();
        }
    }

    public function create($nombre, $apellidocompleto, $dni)
    {
        $sql = "INSERT INTO usuarios (nombre, apellidocompleto, dni) VALUES (:nombre, :apellidocompleto, :dni)";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(":nombre", $nombre);
        $stmt->bindParam(":apellidocompleto", $apellidocompleto);
        $stmt->bindParam(":dni", $dni);
        $stmt->execute();
        echo " ";
    }

    public function read()
    {
        $sql = "SELECT * FROM usuarios";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function update($id, $nombre, $apellidocompleto, $dni)
    {
        $sql = "UPDATE usuarios SET nombre = :nombre, apellidocompleto = :apellidocompleto, dni = :dni WHERE id = :id";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(":id", $id);
        $stmt->bindParam(":nombre", $nombre);
        $stmt->bindParam(":apellidocompleto", $apellidocompleto);
        $stmt->bindParam(":dni", $dni);
        if ($stmt->execute()) {
            echo " ";
        } else {
            echo "Error al actualizar el usuario.";
        }
    }

    public function delete($id)
    {
        $sql = "DELETE FROM usuarios WHERE id = :id";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(":id", $id);
        $stmt->execute();
        echo "Usuario eliminado correctamente.";
    }
}