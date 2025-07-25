<?php 
session_start();
require_once "../model/lib/config.php";
require_once "../model/lib/ConnDB.php";
require_once "../model/lib/ImgHandler.php";
require_once "../model/lib/Pagination.php";

$conn = new ConnDB();
$accion = $_GET['accion'] ?? '';
$id = intval($_GET['id'] ?? null);
$pagina = isset($_GET['pagina']) ? max(1, intval($_GET['pagina'])) : 1;

function mandarJSON($data) {
    header("Content-Type: application/json");
    echo json_encode($data);
    exit;
}

function renderizarHtml($mascota = []) {
    include "../view/cabecera.php";
    include "../view/formulario.php";
    include "../view/listado.php";
    include "../view/pie.php";
}

switch ($accion) {
    case 'agregar':
        if ($_SERVER["REQUEST_METHOD"] === 'POST') {
            $errores = [];
    
            // Sanitizar entradas
            $nombre = htmlspecialchars(trim($_POST['nombre'] ?? ''), ENT_QUOTES, 'UTF-8');
            $especie = htmlspecialchars(trim($_POST['especie'] ?? ''), ENT_QUOTES, 'UTF-8');
            $edad = $_POST['edad'] ?? '';
    
            // Validaciones
            if ($nombre === '' || strlen($nombre) > 100) {
                $errores[] = 'El nombre es obligatorio y debe tener menos de 100 caracteres.';
            }
    
            if ($especie === '' || strlen($especie) > 100) {
                $errores[] = 'La especie es obligatoria y debe tener menos de 100 caracteres.';
            }
    
            if (!ctype_digit(strval($edad)) || $edad < 0 || $edad > 100) {
                $errores[] = 'La edad debe ser un número entero entre 0 y 100.';
            }
    
            // Imagen
            $foto = '';
            if (!empty($_FILES['foto']['tmp_name'])) {
                try {
                    $foto = ImgHandler::guardar($_FILES['foto']);
                } catch (Exception $e) {
                    $errores[] = "Error al subir la imagen: " . $e->getMessage();
                }
            }
    
            if (count($errores) > 0) {
                $_SESSION['alerta'] = [
                    'status' => 'danger',
                    'msg' => implode('<br>', $errores)
                ];
                renderizarHtml();
                break;
            }
    
            $conn->agregar([
                'nombre' => $nombre,
                'especie' => $especie,
                'edad' => intval($edad),
                'foto' => $foto
            ]);
    
            $_SESSION['alert'] = [
                'status' => 'success',
                'msg' => 'Mascota agregada correctamente.'
            ];
    
            header('Location: index.php');
            exit;
        }
        renderizarHtml();
        break;
    
    case 'editar':
        if (!$id || !ctype_digit(strval($id))) {
            $_SESSION['alerta'] = [
                'status' => "danger",
                'msg' => "ID inválida"
            ];
            header('Location: index.php');
            exit;
        }
    
        if ($_SERVER["REQUEST_METHOD"] === 'POST') {
            $errores = [];
    
            $nombre = htmlspecialchars(trim($_POST['nombre'] ?? ''), ENT_QUOTES, 'UTF-8');
            $especie = htmlspecialchars(trim($_POST['especie'] ?? ''), ENT_QUOTES, 'UTF-8');
            $edad = $_POST['edad'] ?? '';
    
            if ($nombre === '' || strlen($nombre) > 100) {
                $errores[] = 'El nombre es obligatorio y debe tener menos de 100 caracteres.';
            }
    
            if ($especie === '' || strlen($especie) > 100) {
                $errores[] = 'La especie es obligatoria y debe tener menos de 100 caracteres.';
            }
    
            if (!ctype_digit(strval($edad)) || $edad < 0 || $edad > 100) {
                $errores[] = 'La edad debe ser un número entero entre 0 y 100.';
            }
    
            // Imagen
            if (!empty($_FILES['foto']['tmp_name'])) {
                try {
                    $foto = ImgHandler::guardar($_FILES['foto']);
                } catch (Exception $e) {
                    $errores[] = "Error al subir la imagen: " . $e->getMessage();
                }
            } else {
                $mascotaActual = $conn->conseguir($id);
                $foto = $mascotaActual['foto'] ?? '';
            }
    
            if (count($errores) > 0) {
                $_SESSION['alerta'] = [
                    'status' => 'danger',
                    'msg' => implode('<br>', $errores)
                ];
                $mascota = $conn->conseguir($id);
                renderizarHtml($mascota);
                break;
            }
    
            $conn->editar([
                'nombre' => $nombre,
                'especie' => $especie,
                'edad' => intval($edad),
                'foto' => $foto
            ], $id);
    
            $_SESSION['alert'] = [
                'type' => 'success',
                'message' => 'Mascota actualizada correctamente.'
            ];
    
            header('Location: index.php');
            exit;
        } else {
            $mascota = $conn->conseguir($id);
            renderizarHtml($mascota);
        }
        break;    
    case 'eliminar':
        if (!$id) { 
            $_SESSION['alerta'] = [
                'status' => "danger",
                'msg' => "No se encontro la ID"
            ];
            header('Location: index.php');
        }

        $conn->eliminar($id);

        $_SESSION['alert'] = [
            'status' => 'warning',
            'msg' => 'Mascota eliminada correctamente.'
        ];

        header('Location: index.php');
        exit;
        break;
    case 'eliminarTodo':
        $conn->eliminarTodo();

        $_SESSION['alert'] = [
            'status' => 'warning',
            'msg' => 'Se elimino todo correctamente.'
        ];

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
        } else {
            mandarJSON([
                'rows' => 0,
                'msg' => 'Registro no encontrado',
                'status' => 'error',
            ]);
        }
        break;
    case 'conseguirTodo':
        $data = $conn->conseguirTodos();
        if ($data) {    
            mandarJSON([
                'rows' => count($data),
                'data' => $data,
                'msg' => 'Registro encontrado',
                'status' => 'success',
            ]);
        } else {
            mandarJSON([
                'rows' => 0,
                'msg' => 'Registro no encontrado',
                'status' => 'error',
            ]);
        }
        break;
    case 'listar':
        default:
        renderizarHtml();
        break;
}