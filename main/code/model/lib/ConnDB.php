<?php
include "config.php";

class ConnDB {
    private $conn;

    public function __construct() {
        $this->conn = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);

        if ($this->conn->connect_error) {
            throw new Exception("Error de conexión: " . $this->conn->connect_error);
        }

        $this->conn->set_charset("utf8mb4");
    }

    public function agregar(array $datos): bool {
        $sql = "INSERT INTO " . NAME_TABLE . " (nombre, especie, edad, foto) VALUES (?, ?, ?, ?)";
        $stmt = $this->conn->prepare($sql);

        if (!$stmt) return false;

        $stmt->bind_param("ssis", $datos['nombre'], $datos['especie'], $datos['edad'], $datos['foto']);
        $result = $stmt->execute();
        $stmt->close();
        return $result;
    }

    public function editar(array $datos, int $id): bool {
        $sql = "UPDATE " . NAME_TABLE . " SET nombre = ?, especie = ?, edad = ?, foto = ? WHERE id = ?";
        $stmt = $this->conn->prepare($sql);

        if (!$stmt) return false;

        $stmt->bind_param("ssisi", $datos['nombre'], $datos['especie'], $datos['edad'], $datos['foto'], $id);
        $result = $stmt->execute();
        $stmt->close();
        return $result;
    }

    public function eliminar(int $id): bool {
        $stmt = $this->conn->prepare("DELETE FROM " . NAME_TABLE . " WHERE id = ?");
        if (!$stmt) return false;

        $stmt->bind_param("i", $id);
        $result = $stmt->execute();
        $stmt->close();
        return $result;
    }

    public function eliminarTodo(): bool {
        return $this->conn->query("DELETE FROM " . NAME_TABLE);
    }

    public function conseguir(int $id): null|array {
        $stmt = $this->conn->prepare("SELECT * FROM " . NAME_TABLE . " WHERE id = ?");
        if (!$stmt) return null;

        $stmt->bind_param("i", $id);
        $stmt->execute();
        $res = $stmt->get_result();
        $dato = $res->fetch_assoc();
        $stmt->close();
        return $dato ?: null;
    }

    public function conseguirTodos(): array {
        $sql = "SELECT * FROM " . NAME_TABLE . " ORDER BY id DESC";
        $result = $this->conn->query($sql);

        return $result ? $result->fetch_all(MYSQLI_ASSOC) : [];
    }

    public function contar(): int {
        $res = $this->conn->query("SELECT COUNT(*) AS total FROM " . NAME_TABLE);
        $data = $res ? $res->fetch_assoc() : ['total' => 0];
        return (int) $data['total'];
    }

    public function conseguirPagina(int $inicio, int $limite): array {
        $sql = "SELECT * FROM " . NAME_TABLE . " LIMIT ?, ?";
        $stmt = $this->conn->prepare($sql);

        if (!$stmt) {
            error_log("Error en prepare(): " . $this->conn->error);
            return [];
        }

        $stmt->bind_param("ii", $inicio, $limite);
        $stmt->execute();
        $result = $stmt->get_result();
        $datos = $result->fetch_all(MYSQLI_ASSOC);
        $stmt->close();
        return $datos;
    }

    public function __destruct() {
        if ($this->conn) {
            $this->conn->close();
        }
    }
}
?>
