<?php 
// Función para enviar datos como JSON y terminar el script
function mandarJSON($data, $method, $flag = false) {
    ob_end_clean(); // Limpia buffer de salida
    header("Content-Type: application/json; charset=utf-8");
    // Convertir a JSON
    $json = json_encode($data, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);
    // Guardar archivo solo si $flag es true
    if ($flag) {
        // Crear carpeta si no existe
        if (!is_dir(SAVE_JSON)) {
            mkdir(SAVE_JSON, 0777, true);
        }
        // Nombre del archivo
        $nombreArchivo = $method . 'json_created_in--' . date('H_i_s--d_m_Y') . '.json';
        $rutaArchivo = rtrim(SAVE_JSON, '/') . '/' . $nombreArchivo;
        // Guardar archivo y comprobar éxito
        if (file_put_contents($rutaArchivo, $json) === false) {
            error_log("No se pudo guardar el archivo JSON en " . SAVE_JSON);
        }
    }


    header("../router/index.php");
    // Enviar JSON al cliente
    echo $json;
    exit;
}

// Función auxiliar para renderizar las vistas HTML
function renderizarHtml($mascotas = []) {
    include "../view/header.php";  // Incluye cabecera HTML
    include "../view/form.php"; // Incluye formulario para agregar/editar mascotas
    include "../view/footer.php";      // Incluye pie de página
}
?>