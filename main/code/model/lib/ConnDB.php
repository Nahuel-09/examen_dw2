<?php
include "config.php"; // Incluye el archivo de configuración que define constantes como DB_HOST, DB_USER, etc.

/**
 *
 * @author "Tu nombre"
 */
class ConnDB {

/*
*   Clase ConnDB para manejar la conexión y operaciones básicas con la base de datos.   
*   Atributo privado:
*       - $conn: instancia de mysqli que representa la conexión a la base de datos.
*   Métodos principales:
*      - __construct(): inicializa la conexión a la base de datos y establece el charset utf8mb4.
*       - agregar(array $datos): inserta un nuevo registro en la tabla con los datos recibidos.
*      - editar(array $datos, int $id): actualiza el registro identificado por $id con los nuevos datos.
*       - eliminar(int $id): elimina el registro con el id indicado.
*      - eliminarTodo(): elimina todos los registros de la tabla.
*       - conseguir(int $id): obtiene un registro por su id, retorna un arreglo asociativo o null.
*      - conseguirTodos(): retorna todos los registros ordenados por id descendente.
*       - contar(): retorna la cantidad total de registros en la tabla.
*       - conseguirPagina(int $inicio, int $limite): obtiene registros limitados para paginación.
*      - __destruct(): cierra la conexión al destruir el objeto.
*   Uso de bind_param():
*       - Este método enlaza variables a los parámetros de la consulta SQL preparada.
*       - Recibe una cadena de tipos indicando el tipo de cada parámetro:
*       's' para string, 'i' para integer, 'd' para double, 'b' para blob.
*       - Ejemplo: "ssis" significa string, string, integer, string.
*/
    private $conn; // Propiedad privada para almacenar la conexión a la base de datos

    public function __construct() {
        // Se inicializa la conexión con la base de datos usando mysqli
        $this->conn = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);

        // Si hay un error de conexión, lanza una excepción con el mensaje de error
        if ($this->conn->connect_error) {
            throw new Exception("Error de conexión: " . $this->conn->connect_error);
        }
        // Se establece el conjunto de caracteres a utf8mb4 para manejar bien los caracteres especiales y emojis
        $this->conn->set_charset("utf8mb4");
    }

    // Método para agregar un nuevo registro. Recibe un arreglo con los datos.
    public function agregar(array $datos): bool {
        // Consulta SQL preparada para insertar los datos en la tabla definida en NAME_TABLE
        $sql = "INSERT INTO " . NAME_TABLE . " (nombre, especie, edad, foto) VALUES (?, ?, ?, ?)";
        $stmt = $this->conn->prepare($sql);

        // Si la preparación falla, retorna false
        if (!$stmt) return false;

        // Se enlazan los parámetros: dos strings, un entero y un string
        $stmt->bind_param("ssis", $datos['nombre'], $datos['especie'], $datos['edad'], $datos['foto']);
        // Se ejecuta la consulta
        $result = $stmt->execute();
        // Se cierra el statement para liberar recursos
        $stmt->close();
        // Retorna true o false según el éxito de la ejecución
        return $result;
    }

    // Método para editar un registro existente, recibe los datos y el id del registro a modificar
    public function editar(array $datos, int $id): bool {
        // Consulta SQL preparada para actualizar el registro con id dado
        $sql = "UPDATE " . NAME_TABLE . " SET nombre = ?, especie = ?, edad = ?, foto = ? WHERE id = ?";
        $stmt = $this->conn->prepare($sql);

        // Si la preparación falla, retorna false
        if (!$stmt) return false;

        // Se enlazan los parámetros: dos strings, un entero, un string y un entero (id)
        $stmt->bind_param("ssisi", $datos['nombre'], $datos['especie'], $datos['edad'], $datos['foto'], $id);
        // Se ejecuta la consulta
        $result = $stmt->execute();
        // Se cierra el statement
        $stmt->close();
        // Retorna el resultado de la ejecución
        return $result;
    }

    // Método para eliminar un registro por su id
    public function eliminar(int $id): bool {
        // Preparación de la consulta SQL para eliminar el registro
        $stmt = $this->conn->prepare("DELETE FROM " . NAME_TABLE . " WHERE id = ?");
        // Si falla la preparación, retorna false
        if (!$stmt) return false;

        // Se enlaza el parámetro id
        $stmt->bind_param("i", $id);
        // Se ejecuta la consulta
        $result = $stmt->execute();
        // Se cierra el statement
        $stmt->close();
        // Retorna resultado de la ejecución
        return $result;
    }

    // Método para eliminar todos los registros de la tabla
    public function eliminarTodo(): bool {
        // Ejecuta la consulta DELETE sin condición, elimina todo
        return $this->conn->query("DELETE FROM " . NAME_TABLE);
    }

    // Método para obtener un registro por su id, retorna un arreglo asociativo o null si no existe
    public function conseguir(int $id): null|array {
        // Preparación de la consulta SQL para obtener un registro
        $stmt = $this->conn->prepare("SELECT * FROM " . NAME_TABLE . " WHERE id = ?");
        // Si falla la preparación, retorna null
        if (!$stmt) return null;

        // Se enlaza el parámetro id
        $stmt->bind_param("i", $id);
        // Se ejecuta la consulta
        $stmt->execute();
        // Obtiene el resultado
        $res = $stmt->get_result();
        // Extrae la fila como arreglo asociativo
        $dato = $res->fetch_assoc();
        // Cierra el statement
        $stmt->close();
        // Retorna el dato o null si no se encontró
        return $dato ?: null;
    }

    // Método para obtener todos los registros ordenados por id descendente
    public function conseguirTodos(): array {
        // Consulta directa para obtener todos los registros
        $sql = "SELECT * FROM " . NAME_TABLE . " ORDER BY id DESC";
        $result = $this->conn->query($sql);

        // Si hay resultado, retorna todos como arreglo asociativo, sino arreglo vacío
        return $result ? $result->fetch_all(MYSQLI_ASSOC) : [];
    }

    // Método para contar la cantidad total de registros en la tabla
    public function contar(): int {
        // Ejecuta consulta COUNT
        $res = $this->conn->query("SELECT COUNT(*) AS total FROM " . NAME_TABLE);
        // Extrae el resultado o pone 0 si falla
        $data = $res ? $res->fetch_assoc() : ['total' => 0];
        // Retorna el total como entero
        return (int) $data['total'];
    }

    // Método para obtener registros paginados: desde un índice inicio, y un límite de cantidad
    public function conseguirPagina(int $inicio, int $limite): array {
        // Consulta preparada con LIMIT para paginación
        $sql = "SELECT * FROM " . NAME_TABLE . " LIMIT ?, ?";
        $stmt = $this->conn->prepare($sql);

        // Si falla la preparación, registra error y retorna arreglo vacío
        if (!$stmt) {
            error_log("Error en prepare(): " . $this->conn->error);
            return [];
        }

        // Enlaza parámetros (enteros) para LIMIT
        $stmt->bind_param("ii", $inicio, $limite);
        // Ejecuta la consulta
        $stmt->execute();
        // Obtiene resultado
        $result = $stmt->get_result();
        // Extrae todos los registros como arreglo asociativo
        $datos = $result->fetch_all(MYSQLI_ASSOC);
        // Cierra el statement
        $stmt->close();
        // Retorna el arreglo con los datos paginados
        return $datos;
    }

    // Destructor para cerrar la conexión cuando se destruya el objeto
    public function __destruct() {
        if ($this->conn) {
            $this->conn->close();
        }
    }
}
?>
