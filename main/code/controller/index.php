<?php 
require_once "../model/lib/config.php";
require_once "../model/lib/ConnDB.php";
require_once "../model/lib/ImgHandler.php";
require_once "../model/lib/Pagination.php";

$conn = new ConnDB();
$accion = $_GET['accion'] ?? '';
$id = $_GET['id'] ?? null;
$pagina = isset($_GET['pagina']) ? max(1, intval($_GET['pagina'])) : 1;

function mandarJSON($data) {
    header("Content-Type: application/json");
    echo json_encode($data);
    exit;
}

function cargarVistas($mascota = []) {
    include "../view/cabecera.php";
    include "../view/formulario.php";
    include "../view/listado.php";
    include "../view/pie.php";
}

switch ($accion) {
    case 'agregar':
        if ($_SERVER["REQUEST_METHOD"] === 'POST') {
            $foto = '';
            if (!empty($_FILES['foto']['tmp_name'])) {
                try {
                    $foto = ImgHandler::guardar($_FILES['foto']);
                } catch (Exception $e) {
                    die("Hubo un error al subir la imagen: ". $e->getMessage());
                }
            }

            $conn->agregar([
                'nombre' => $_POST['nombre'] ?? '',
                'especie' => $_POST['especie'] ?? '',
                'edad' => $_POST['edad'] ?? '',
                'foto' => $foto
            ]);
            header('Location: index.php');
            exit;
        }
        cargarVistas();
        break;
    case 'editar':
        if (!$id) die("ID no especificada para editar.");

        if ($_SERVER["REQUEST_METHOD"] === 'POST') {
            $foto = '';
            if (!empty($_FILES['foto']['tmp_name'])) {
                try {
                    $foto = ImgHandler::guardar($_FILES['foto']);
                } catch (Exception $e) {
                    die("Hubo un error al subir la imagen: ". $e->getMessage());
                }
            } else {
                $mascotaActual = $conn->conseguir($id);
                $foto = $mascotaActual['foto'] ?? '';
            }

            $conn->editar([
                'nombre' => $_POST['nombre'] ?? '',
                'especie' => $_POST['especie'] ?? '',
                'edad' => $_POST['edad'] ?? '',
                'foto' => $foto
            ], $id);
            header('Location: index.php');
            exit;
        } else {
            $mascota = $conn->conseguir($id);
            cargarVistas($mascota);
        }
        break;
    case 'eliminar':
        if (!$id) die("ID no especificada para editar.");
        $conn->eliminar($id);
        header('Location: index.php');
        exit;
        break;
    case 'eliminarTodo':
        $conn->eliminarTodo();
        header('Location: index.php');
        exit;
        break;
    case 'conseguir':
        if (!$id) {
            mandarJSON([
                'data' => 'ID no proporcionada',
                'msg' => 'error'
            ]);
        }
        $registro = $conn->conseguir($id);
        if ($registro) {
            mandarJSON([
                'rows' => 1,
                'data' => $registro,
                'msg' => 'Datos Obtenidos Correctamente',
                'status' => 'success',
            ]);
        }
        break;
    case 'conseguirTodo':
        $data = $conn->conseguirTodos();
        mandarJSON([
            'rows' => count($data),
            'data' => $data,
            'msg' => 'Registro encontrado',
            'status' => 'success',
        ]);
        break;
    case 'listar':
        default:
        cargarVistas();
        break;
}