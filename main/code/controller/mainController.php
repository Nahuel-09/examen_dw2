<?php 
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
            
            // Valida que se haya subido una foto (es obligatoria aquí)
            if (empty($_FILES['foto']['tmp_name'])) {
                $errores[] = "La foto es obligatoria.";
            }
            $foto = ''; // Inicializa variable para almacenar nombre de archivo
    
            // Si se subió una foto, intenta guardarla usando ImgHandler
            if (!empty($_FILES['foto']['tmp_name'])) {
                try {
                    $foto = ImgHandler::guardar($_FILES['foto']);
                } catch (Exception $e) {
                    // Captura error y agrega mensaje a errores
                    $errores[] = "Error al subir la foto: " . $e->getMessage();
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
            
            // Agrega nuevo mascotas en base de datos con los datos validados
            $conn->agregar([
                'nombre' => $nombre,
                'especie' => $especie,
                'edad' => intval($edad),
                'foto' => $foto
            ]);
            
            // Establece alerta positiva para notificar éxito
            $_SESSION['alerta'] = [
                'status' => 'success',
                'msg' => 'mascotas agregado correctamente.'
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
    
            // Si se sube una nueva foto, intenta guardarla
            if (!empty($_FILES['foto']['tmp_name'])) {
                try {
                    $foto = ImgHandler::guardar($_FILES['foto']);
                } catch (Exception $e) {
                    $errores[] = "Error al subir la foto: " . $e->getMessage();
                }
            } else {
                // Si no se sube foto nueva, conserva la anterior
                $mascotasActual = $conn->conseguir($id);
                $foto = $mascotasActual['foto'] ?? '';

                // Verifica si el usuario quiere cambiarle el nombre
                if (!empty($_POST['nombre_foto']) && $foto) {
                    $nuevoNombre = preg_replace('/[^a-zA-Z0-9_\-]/', '_', $_POST['nombre_foto']); // Sanitiza
                    $extension = pathinfo($foto, PATHINFO_EXTENSION);
                    $rutaActual = SAVE_IMG . $foto;
                    $nuevaRuta = SAVE_IMG . $nuevoNombre . "." . $extension;

                    if (file_exists($rutaActual)) {
                        if (rename($rutaActual, $nuevaRuta)) {
                            $foto = $nuevoNombre . "." . $extension; // Actualiza nombre en BD
                        } else {
                            $errores[] = "No se pudo renombrar la foto.";
                        }
                    }
                }
            }
            // Si hay errores, muestra alerta y recarga formulario con datos existentes
            if (count($errores) > 0) {
                $_SESSION['alerta'] = [
                    'status' => 'success',
                    'msg' => implode('<br>', $errores)
                ];
                $mascotas = $conn->conseguir($id);
                renderizarHtml($mascotas);
                break;
            }
    
            // Actualiza el mascotas en la base de datos
            $conn->editar([
                'nombre' => $nombre,
                'especie' => $especie,
                'edad' => intval($edad),
                'foto' => $foto
            ], $id);
    
            // Establece alerta de éxito
            $_SESSION['alerta'] = [
                'status' => 'success',
                'msg' => 'mascotas modificados correctamente.'
            ];
    
            // Redirige a index para evitar resubmisión
            header('Location: index.php?accion=listar');
            exit;
        } else {
            // Si no es POST, obtiene los datos actuales para mostrar en formulario
            $mascotas = $conn->conseguir($id);
            renderizarHtml($mascotas);
        }
        break;    

    case 'eliminar':
        // Verifica que exista un id válido
        if ($id) {
            // Borrar la foto antes de eliminar el mascotas
            $mascotas = $conn->conseguir($id);
            if ($mascotas && !empty($mascotas['foto'])) {
                $rutafoto = SAVE_IMG . '/' . $mascotas['foto'];
                if (file_exists($rutafoto)) {
                    unlink($rutafoto); // Elimina la foto del disco
                }
            }
            // Elimina el mascotas con el id especificado
            $conn->eliminar($id);

            // Establece alerta de advertencia confirmando eliminación
            $_SESSION['alerta'] = ['status' => 'warning', 'msg' => 'mascotas eliminado correctamente.'];
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
        // Obtener todos los mascotas antes de eliminarlos
        $mascotas = $conn->conseguirTodos();
    
        // Eliminar las imágenes asociadas a cada mascotas
        foreach ($mascotas as $mascotas) {
            if (!empty($mascotas['foto'])) {
                $rutafoto = SAVE_IMG . '/' . $mascotas['foto'];
                if (file_exists($rutafoto)) {
                    unlink($rutafoto);
                }
            }
        }
    
        // Elimina todos los mascotas de la tabla
        $conn->eliminarTodo();
    
        // Establece alerta de advertencia confirmando eliminación masiva
        $_SESSION['alerta'] = [
            'status' => 'warning',
            'msg' => 'Se eliminó todo correctamente.'
        ];

        header('Location: index.php?accion=listar');
        exit;
        break;
    case 'conseguir':
        // Valida que se haya proporcionado un id
        if (!$id) {
            mandarJSON([
                'msg' => 'ID no proporcionada',
                'status' => 'error'
            ],'conseguir-'); // no guarda archivo porque es error
        }
        // Obtiene el mascotas solicitado
        $mascotas = $conn->conseguir($id);
        
        // Si se encuentra, envía los datos en JSON con status success
        if ($mascotas) {
            mandarJSON([
                'rows' => 1,
                'data' => $mascotas,
                'msg' => 'mascotas encontrado correctamente',
                'status' => 'success',
            ],'conseguir-', $bandera); // guarda archivo
        } else { // Si no se encuentra, envía mensaje de error
            mandarJSON([
                'rows' => 0,
                'msg' => 'mascotas no encontrado',
                'status' => 'error',
            ],'conseguir-', false); // no guarda archivo
        }
        break;

    case 'conseguirTodo':
        // Obtiene todos los mascotas de la tabla
        $data = $conn->conseguirTodos();

        // Si hay datos, los envía en JSON con éxito
        if ($data) {    
            mandarJSON([
                'rows' => count($data),
                'data' => $data,
                'msg' => 'mascotas encontrado',
                'status' => 'success',
            ],'conseguir_Todo-', $bandera); // guarda archivo
        } else { // Si no hay datos, envía mensaje de error
            mandarJSON([
                'rows' => 0,
                'msg' => 'mascotas no encontrados',
                'status' => 'error',
            ],'conseguir_Todo-', false); // no guarda archivo
        }
        break;
    case 'listar':
        include "../view/list.php";  // Incluye listado de mascotas
        break;
    default:
        // Acción por defecto: renderiza las vistas HTML sin parámetros adicionales
        renderizarHtml();
        break;
}
?>
