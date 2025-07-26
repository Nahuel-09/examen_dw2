<?php 
/*
En este punto, se desarrollo un controlador que maneja por medio de acciones GET, todos los registros y descargas API, se cita las acciones que se hacen.. 
Agrega un nuevo registro
Edita un registro por medio de la ID
Elimina un registro por medio de la ID
Consigue una fila con los datos de la base de datos para transformarlo en un json API
Consigue todos los datos de la base de datos para transformarlo en un json API
Elimina todos los datos de la base de datos 
*/
?>

<?php 
// Inicia el buffer de salida para evitar problemas con headers
ob_start(); 
// Inicia sesión para manejar variables $_SESSION
session_start();

// Incluye archivos necesarios con clases y configuraciones
require_once "../model/lib/config.php";
require_once "../model/lib/ConnDB.php";
require_once "../model/lib/ImgHandler.php";
require_once "../model/lib/Pagination.php";

// Crea instancia de la clase para conexión y manejo de BD
$conn = new ConnDB();
// Obtiene la acción enviada vía GET o cadena vacía si no existe
$accion = $_GET['accion'] ?? '';
// Obtiene el id enviado vía GET y lo convierte a entero
$id = intval($_GET['id'] ?? null);
// Obtiene la página actual enviada vía GET, mínimo 1
$pagina = isset($_GET['pagina']) ? max(1, intval($_GET['pagina'])) : 1;

// Función para enviar datos como JSON y terminar el script
function mandarJSON($data) {
    ob_end_clean(); // Limpia buffer de salida (más agresivo que ob_clean)
    header("Content-Type: application/json; charset=utf-8"); // Indica que la respuesta será JSON UTF-8
    echo json_encode($data, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT); // Codifica datos con formato legible y sin escapar unicode
    exit; // Finaliza ejecución del script
}

// Función auxiliar para renderizar las vistas HTML
function renderizarHtml($mascota = []) {
    include "../view/cabecera.php";  // Incluye cabecera HTML
    include "../view/formulario.php"; // Incluye formulario para agregar/editar mascota
    include "../view/listado.php";  // Incluye listado de mascotas
    include "../view/pie.php";      // Incluye pie de página
}

// Switch para manejar las distintas acciones enviadas por GET
switch ($accion) {
    case 'agregar':
        // Solo procesa si el método es POST (formulario enviado)
        if ($_SERVER["REQUEST_METHOD"] === 'POST') {
            $errores = []; // Array para acumular errores de validación
    
            // Sanitiza y limpia entradas del formulario para evitar XSS
            $nombre = htmlspecialchars(trim($_POST['nombre'] ?? ''), ENT_QUOTES, 'UTF-8');
            $especie = htmlspecialchars(trim($_POST['especie'] ?? ''), ENT_QUOTES, 'UTF-8');
            $edad = $_POST['edad'] ?? '';
    
            // Validaciones del lado servidor
            // Verifica que nombre no esté vacío y no exceda 100 caracteres
            if ($nombre === '' || strlen($nombre) > 100) {
                $errores[] = 'El nombre es obligatorio y debe tener menos de 100 caracteres.';
            }
            
            // Verifica que especie no esté vacío y no exceda 100 caracteres
            if ($especie === '' || strlen($especie) > 100) {
                $errores[] = 'La especie es obligatoria y debe tener menos de 100 caracteres.';
            }
            
            // Verifica que edad sea un entero entre 0 y 100
            if (!ctype_digit(strval($edad)) || $edad < 0 || $edad > 100) {
                $errores[] = 'La edad debe ser un número entero entre 0 y 100.';
            }
            
            // Valida que se haya subido una imagen (es obligatoria aquí)
            if (empty($_FILES['foto']['tmp_name'])) {
                $errores[] = "La imagen es obligatoria.";
            }
            $foto = ''; // Inicializa variable para almacenar nombre de archivo
    
            // Si se subió una imagen, intenta guardarla usando ImgHandler
            if (!empty($_FILES['foto']['tmp_name'])) {
                try {
                    $foto = ImgHandler::guardar($_FILES['foto']);
                } catch (Exception $e) {
                    // Captura error y agrega mensaje a errores
                    $errores[] = "Error al subir la imagen: " . $e->getMessage();
                }
            }
    
            // Si hay errores, muestra alerta y renderiza HTML de nuevo
            if (count($errores) > 0) {
                $_SESSION['alerta'] = [
                    'status' => 'danger',
                    'msg' => implode('<br>', $errores)
                ];
                renderizarHtml();
                break;
            }
            
            // Agrega nuevo registro en base de datos con los datos validados
            $conn->agregar([
                'nombre' => $nombre,
                'especie' => $especie,
                'edad' => intval($edad),
                'foto' => $foto
            ]);
            
            // Establece alerta positiva para notificar éxito
            $_SESSION['alert'] = [
                'status' => 'success',
                'msg' => 'Mascota agregada correctamente.'
            ];
    
            // Redirige a index para evitar resubmisión de formulario
            header('Location: index.php?accion=listar');
            exit;
        }
        renderizarHtml(); // Si no es POST, muestra formulario vacío
        break;
    
    case 'editar':
        // Valida que el id sea válido (exista y sea entero)
        if (!$id || !ctype_digit(strval($id))) {
            $_SESSION['alerta'] = [
                'status' => "danger",
                'msg' => "ID inválida"
            ];
            header('Location: index.php?accion=listar');
            exit;
        }
        
        // Si es POST, procesa los datos enviados para actualizar
        if ($_SERVER["REQUEST_METHOD"] === 'POST') {
            $errores = [];
            
            // Limpia y sanitiza los datos recibidos
            $nombre = htmlspecialchars(trim($_POST['nombre'] ?? ''), ENT_QUOTES, 'UTF-8');
            $especie = htmlspecialchars(trim($_POST['especie'] ?? ''), ENT_QUOTES, 'UTF-8');
            $edad = $_POST['edad'] ?? '';
    
            // Validaciones de campos
            if ($nombre === '' || strlen($nombre) > 100) {
                $errores[] = 'El nombre es obligatorio y debe tener menos de 100 caracteres.';
            }
    
            if ($especie === '' || strlen($especie) > 100) {
                $errores[] = 'La especie es obligatoria y debe tener menos de 100 caracteres.';
            }
    
            if (!ctype_digit(strval($edad)) || $edad < 0 || $edad > 100) {
                $errores[] = 'La edad debe ser un número entero entre 0 y 100.';
            }
    
            // Si se sube una nueva imagen, intenta guardarla
            if (!empty($_FILES['foto']['tmp_name'])) {
                try {
                    $foto = ImgHandler::guardar($_FILES['foto']);
                } catch (Exception $e) {
                    $errores[] = "Error al subir la imagen: " . $e->getMessage();
                }
            } else {
                // Si no se sube imagen nueva, conserva la anterior
                $mascotaActual = $conn->conseguir($id);
                $foto = $mascotaActual['foto'] ?? '';
            }
    
            // Si hay errores, muestra alerta y recarga formulario con datos existentes
            if (count($errores) > 0) {
                $_SESSION['alerta'] = [
                    'status' => 'danger',
                    'msg' => implode('<br>', $errores)
                ];
                $mascota = $conn->conseguir($id);
                renderizarHtml($mascota);
                break;
            }
    
            // Actualiza el registro en la base de datos
            $conn->editar([
                'nombre' => $nombre,
                'especie' => $especie,
                'edad' => intval($edad),
                'foto' => $foto
            ], $id);
    
            // Establece alerta de éxito
            $_SESSION['alert'] = [
                'type' => 'success',
                'message' => 'Mascota actualizada correctamente.'
            ];
    
            // Redirige a index para evitar resubmisión
            header('Location: index.php?accion=listar');
            exit;
        } else {
            // Si no es POST, obtiene los datos actuales para mostrar en formulario
            $mascota = $conn->conseguir($id);
            renderizarHtml($mascota);
        }
        break;    

    case 'eliminar':
        // Verifica que exista un id válido
        if ($id) {
            // Borrar la imagen antes de eliminar el registro
            $mascota = $conn->conseguir($id);
            if ($mascota && !empty($mascota['foto'])) {
                $rutaImagen = SAVE_IMG . '/' . $mascota['foto'];
                if (file_exists($rutaImagen)) {
                    unlink($rutaImagen); // Elimina la imagen del disco
                }
            }
            // Elimina el registro con el id especificado
            $conn->eliminar($id);

            // Establece alerta de advertencia confirmando eliminación
            $_SESSION['alert'] = ['status' => 'warning', 'msg' => 'Mascota eliminada correctamente.'];
        } else { // en caso de no existir sucede esto
            $_SESSION['alerta'] = [
                'status' => "danger",
                'msg' => "No se encontro la ID"
            ];
            header('Location: index.php?accion=listar');
        }
        // Redirige a index
        header('Location: index.php?accion=listar');
        exit;
        break;

    case 'eliminarTodo':
        case 'eliminarTodo':
            // Obtener todos los registros antes de eliminarlos
            $mascotas = $conn->conseguirTodos();
        
            // Eliminar las imágenes asociadas a cada mascota
            foreach ($mascotas as $mascota) {
                if (!empty($mascota['foto'])) {
                    $rutaImagen = SAVE_IMG . '/' . $mascota['foto'];
                    if (file_exists($rutaImagen)) {
                        unlink($rutaImagen);
                    }
                }
            }
        
            // Elimina todos los registros de la tabla
            $conn->eliminarTodo();
        
            // Establece alerta de advertencia confirmando eliminación masiva
            $_SESSION['alert'] = [
                'status' => 'warning',
                'msg' => 'Se eliminó todo correctamente.'
            ];

        // Redirige a index
        header('Location: index.php?accion=listar');
        exit;
        break;
    case 'conseguir':
        // Valida que se haya proporcionado un id
        if (!$id) {
            mandarJSON([
                'data' => 'ID no proporcionada',
                'msg' => 'error'
            ]);
        }
        // Obtiene el registro solicitado
        $registro = $conn->conseguir($id);
        
        // Si se encuentra, envía los datos en JSON con status success
        if ($registro) {
            mandarJSON([
                'rows' => 1,
                'data' => $registro,
                'msg' => 'Datos Obtenidos Correctamente',
                'status' => 'success',
            ]);
        } else { // Si no se encuentra, envía mensaje de error
            mandarJSON([
                'rows' => 0,
                'msg' => 'Registro no encontrado',
                'status' => 'error',
            ]);
        }
        break;

    case 'conseguirTodo':
        // Obtiene todos los registros de la tabla
        $data = $conn->conseguirTodos();

        // Si hay datos, los envía en JSON con éxito
        if ($data) {    
            mandarJSON([
                'rows' => count($data),
                'data' => $data,
                'msg' => 'Registro encontrado',
                'status' => 'success',
            ]);
        } else { // Si no hay datos, envía mensaje de error
            mandarJSON([
                'rows' => 0,
                'msg' => 'Registro no encontrado',
                'status' => 'error',
            ]);
        }
        break;

    case 'listar':
    default:
        // Acción por defecto: renderiza las vistas HTML sin parámetros adicionales
        renderizarHtml();
        break;
}
?>
