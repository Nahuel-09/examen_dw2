<?php 
/*
En este punto, se desarrollo un controlador que maneja por medio de acciones GET, todos los recintos y descargas API, se cita las acciones que se hacen.. 
Agrega un nuevo recintos
Edita un recintos por medio de la ID
Elimina un recintos por medio de la ID
Consigue una fila con los datos de la base de datos para transformarlo en un json API
Consigue todos los datos de la base de datos para transformarlo en un json API
Elimina todos los datos de la base de datos 
*/
?>

<?php 
// Switch para manejar las distintas acciones enviadas por GET
// Switch para manejar las distintas acciones enviadas por GET
switch ($accion) {
    case 'agregar':
        // Solo procesa si el método es POST (formulario enviado)
        if ($_SERVER["REQUEST_METHOD"] === 'POST') {
            $errores = []; // Array para acumular errores de validación
    
            // Sanitiza y limpia entradas del formulario para evitar XSS
            $nombre = htmlspecialchars(trim($_POST['nombre'] ?? ''), ENT_QUOTES, 'UTF-8');
            $tipo = htmlspecialchars(trim($_POST['tipo'] ?? ''), ENT_QUOTES, 'UTF-8');
            $capacidad = $_POST['capacidad'] ?? '';
    
            // Validaciones del lado servidor
            // Verifica que nombre no esté vacío y no exceda 100 caracteres
            if ($nombre === '' || strlen($nombre) > 100) {
                $errores[] = 'El nombre es obligatorio y debe tener menos de 100 caracteres.';
            }
            
            // Verifica que tipo no esté vacío y no exceda 100 caracteres
            if ($tipo === '' || strlen($tipo) > 100) {
                $errores[] = 'La tipo es obligatoria y debe tener menos de 100 caracteres.';
            }
            
            // Verifica que capacidad sea un entero entre 0 y 100
            if (!ctype_digit(strval($capacidad)) || $capacidad < 0 || $capacidad > 100) {
                $errores[] = 'La capacidad debe ser un número entero entre 0 y 100.';
            }
            
            // Valida que se haya subido una imagen (es obligatoria aquí)
            if (empty($_FILES['imagen']['tmp_name'])) {
                $errores[] = "La imagen es obligatoria.";
            }
            $imagen = ''; // Inicializa variable para almacenar nombre de archivo
    
            // Si se subió una imagen, intenta guardarla usando ImgHandler
            if (!empty($_FILES['imagen']['tmp_name'])) {
                try {
                    $imagen = ImgHandler::guardar($_FILES['imagen']);
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
            
            // Agrega nuevo recintos en base de datos con los datos validados
            $conn->agregar([
                'nombre' => $nombre,
                'tipo' => $tipo,
                'capacidad' => intval($capacidad),
                'imagen' => $imagen
            ]);
            
            // Establece alerta positiva para notificar éxito
            $_SESSION['alerta'] = [
                'status' => 'success',
                'msg' => 'recintos agregado correctamente.'
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
            $tipo = htmlspecialchars(trim($_POST['tipo'] ?? ''), ENT_QUOTES, 'UTF-8');
            $capacidad = $_POST['capacidad'] ?? '';
    
            // Validaciones de campos
            if ($nombre === '' || strlen($nombre) > 100) {
                $errores[] = 'El nombre es obligatorio y debe tener menos de 100 caracteres.';
            }
    
            if ($tipo === '' || strlen($tipo) > 100) {
                $errores[] = 'La tipo es obligatoria y debe tener menos de 100 caracteres.';
            }
    
            if (!ctype_digit(strval($capacidad)) || $capacidad < 0 || $capacidad > 100) {
                $errores[] = 'La capacidad debe ser un número entero entre 0 y 100.';
            }
    
            // Si se sube una nueva imagen, intenta guardarla
            if (!empty($_FILES['imagen']['tmp_name'])) {
                try {
                    $imagen = ImgHandler::guardar($_FILES['imagen']);
                } catch (Exception $e) {
                    $errores[] = "Error al subir la imagen: " . $e->getMessage();
                }
            } else {
                // Si no se sube imagen nueva, conserva la anterior
                $recintosActual = $conn->conseguir($id);
                $imagen = $recintosActual['imagen'] ?? '';

                // Verifica si el usuario quiere cambiarle el nombre
                if (!empty($_POST['nombre_imagen']) && $imagen) {
                    $nuevoNombre = preg_replace('/[^a-zA-Z0-9_\-]/', '_', $_POST['nombre_imagen']); // Sanitiza
                    $extension = pathinfo($imagen, PATHINFO_EXTENSION);
                    $rutaActual = SAVE_IMG . $imagen;
                    $nuevaRuta = SAVE_IMG . $nuevoNombre . "." . $extension;

                    if (file_exists($rutaActual)) {
                        if (rename($rutaActual, $nuevaRuta)) {
                            $imagen = $nuevoNombre . "." . $extension; // Actualiza nombre en BD
                        } else {
                            $errores[] = "No se pudo renombrar la imagen.";
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
                $recintos = $conn->conseguir($id);
                renderizarHtml($recintos);
                break;
            }
    
            // Actualiza el recintos en la base de datos
            $conn->editar([
                'nombre' => $nombre,
                'tipo' => $tipo,
                'capacidad' => intval($capacidad),
                'imagen' => $imagen
            ], $id);
    
            // Establece alerta de éxito
            $_SESSION['alerta'] = [
                'status' => 'success',
                'msg' => 'recintos modificados correctamente.'
            ];
    
            // Redirige a index para evitar resubmisión
            header('Location: index.php?accion=listar');
            exit;
        } else {
            // Si no es POST, obtiene los datos actuales para mostrar en formulario
            $recintos = $conn->conseguir($id);
            renderizarHtml($recintos);
        }
        break;    

    case 'eliminar':
        // Verifica que exista un id válido
        if ($id) {
            // Borrar la imagen antes de eliminar el recintos
            $recintos = $conn->conseguir($id);
            if ($recintos && !empty($recintos['imagen'])) {
                $rutaImagen = SAVE_IMG . '/' . $recintos['imagen'];
                if (file_exists($rutaImagen)) {
                    unlink($rutaImagen); // Elimina la imagen del disco
                }
            }
            // Elimina el recintos con el id especificado
            $conn->eliminar($id);

            // Establece alerta de advertencia confirmando eliminación
            $_SESSION['alerta'] = ['status' => 'warning', 'msg' => 'recintos eliminado correctamente.'];
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
        // Obtener todos los recintos antes de eliminarlos
        $recintos = $conn->conseguirTodos();
    
        // Eliminar las imágenes asociadas a cada recintos
        foreach ($recintos as $recintos) {
            if (!empty($recintos['imagen'])) {
                $rutaImagen = SAVE_IMG . '/' . $recintos['imagen'];
                if (file_exists($rutaImagen)) {
                    unlink($rutaImagen);
                }
            }
        }
    
        // Elimina todos los recintos de la tabla
        $conn->eliminarTodo();
    
        // Establece alerta de advertencia confirmando eliminación masiva
        $_SESSION['alerta'] = [
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
                'msg' => 'ID no proporcionada',
                'status' => 'error'
            ],'conseguir-'); // no guarda archivo porque es error
        }
        // Obtiene el recintos solicitado
        $recintos = $conn->conseguir($id);
        
        // Si se encuentra, envía los datos en JSON con status success
        if ($recintos) {
            mandarJSON([
                'rows' => 1,
                'data' => $recintos,
                'msg' => 'recintos encontrado correctamente',
                'status' => 'success',
            ],'conseguir-', $bandera); // guarda archivo
        } else { // Si no se encuentra, envía mensaje de error
            mandarJSON([
                'rows' => 0,
                'msg' => 'recintos no encontrado',
                'status' => 'error',
            ],'conseguir-', false); // no guarda archivo
        }
        break;

    case 'conseguirTodo':
        // Obtiene todos los recintos de la tabla
        $data = $conn->conseguirTodos();

        // Si hay datos, los envía en JSON con éxito
        if ($data) {    
            mandarJSON([
                'rows' => count($data),
                'data' => $data,
                'msg' => 'recintos encontrado',
                'status' => 'success',
            ],'conseguir_Todo-', $bandera); // guarda archivo
        } else { // Si no hay datos, envía mensaje de error
            mandarJSON([
                'rows' => 0,
                'msg' => 'recintos no encontrados',
                'status' => 'error',
            ],'conseguir_Todo-', false); // no guarda archivo
        }
        break;
    case 'listar':
        include "../view/list.php";  // Incluye listado de recintos
        break;
    default:
        // Acción por defecto: renderiza las vistas HTML sin parámetros adicionales
        renderizarHtml();
        break;
}
?>
