<?php 
include "config.php"; // Incluye archivo de configuración con constantes como SAVE_IMG

class ImgHandler {
    // Método estático para guardar y redimensionar una imagen subida
    public static function guardar($archivo, $destinoDir = SAVE_IMG, $anchoNuevo = 540, $calidad = 80) {
        // Verifica que el archivo esté definido y que no haya errores en la subida
        if (!isset($archivo) || $archivo['error'] !== UPLOAD_ERR_OK) {
            throw new Exception("Error al subir la imagen.");
        }

        // Tamaño máximo permitido para la imagen (2MB)
        $maxTamano = 2 * 1024 * 1024; 
        if ($archivo['size'] > $maxTamano) {
            throw new Exception("La imagen es demasiado grande. Máximo permitido: 2MB.");
        }

        // Detecta el tipo de imagen usando exif_imagetype
        $tipoImagen = exif_imagetype($archivo['tmp_name']);
        // Define los tipos permitidos y las funciones asociadas para crear y guardar imagen
        $extensionesPermitidas = [
            IMAGETYPE_JPEG => ['ext' => '.jpg', 'create' => 'imagecreatefromjpeg', 'save' => 'imagejpeg'],
            IMAGETYPE_PNG  => ['ext' => '.png', 'create' => 'imagecreatefrompng',  'save' => 'imagepng'],
            IMAGETYPE_WEBP => ['ext' => '.webp','create' => 'imagecreatefromwebp', 'save' => 'imagewebp'],
            IMAGETYPE_GIF  => ['ext' => '.gif', 'create' => 'imagecreatefromgif',  'save' => 'imagegif'],
        ];

        // Valida que el tipo de imagen esté permitido
        if (!isset($extensionesPermitidas[$tipoImagen])) {
            throw new Exception("Tipo de imagen no soportado. Solo se permiten JPG, PNG, WEBP y GIF.");
        }

        // Obtiene las funciones y extensión para el tipo de imagen detectado
        $crearImagen = $extensionesPermitidas[$tipoImagen]['create'];
        $guardarImagen = $extensionesPermitidas[$tipoImagen]['save'];
        $extension = $extensionesPermitidas[$tipoImagen]['ext'];

        // Verifica si el directorio destino existe, si no intenta crearlo con permisos 0777 recursivamente
        if (!is_dir($destinoDir)) {
            if (!mkdir($destinoDir, 0777, true)) {
                throw new Exception("No se pudo crear el directorio destino.");
            }
        }

        // Genera un nombre único para la imagen con la extensión adecuada
        $nombreFinal = "Img_created_in--" . date('H_i_s--d_m_Y') . $extension;
        // Construye la ruta final donde se guardará la imagen
        $rutaFinal = rtrim($destinoDir, '/') . '/' . $nombreFinal;

        // Carga la imagen original usando la función correspondiente
        $imagenOriginal = @$crearImagen($archivo['tmp_name']);
        if (!$imagenOriginal) {
            throw new Exception("No se pudo cargar la imagen.");
        }

        // Obtiene las dimensiones originales de la imagen
        $anchoOriginal = imagesx($imagenOriginal);
        $altoOriginal = imagesy($imagenOriginal);
        // Calcula la altura proporcional para el nuevo ancho
        $altoNuevo = intval($anchoNuevo * $altoOriginal / $anchoOriginal);

        // Crea una nueva imagen en true color con las nuevas dimensiones
        $imagenRedimensionada = imagecreatetruecolor($anchoNuevo, $altoNuevo);

        // Si la imagen es PNG, WEBP o GIF se preserva la transparencia
        if ($tipoImagen === IMAGETYPE_PNG || $tipoImagen === IMAGETYPE_WEBP || $tipoImagen === IMAGETYPE_GIF) {
            imagealphablending($imagenRedimensionada, false); // Desactiva mezcla de canal alfa
            imagesavealpha($imagenRedimensionada, true);      // Guarda canal alfa (transparencia)
        }

        // Copia y redimensiona la imagen original sobre la nueva imagen creada
        imagecopyresampled(
            $imagenRedimensionada,
            $imagenOriginal,
            0, 0, 0, 0,
            $anchoNuevo, $altoNuevo,
            $anchoOriginal, $altoOriginal
        );

        // Guarda la imagen redimensionada usando la función apropiada
        // Para JPEG se usa calidad, para otros formatos no se usa ese parámetro
        $guardado = ($tipoImagen === IMAGETYPE_JPEG) 
            ? $guardarImagen($imagenRedimensionada, $rutaFinal, $calidad) 
            : $guardarImagen($imagenRedimensionada, $rutaFinal);

        // Si falla el guardado, libera memoria y lanza excepción
        if (!$guardado) {
            imagedestroy($imagenOriginal);
            imagedestroy($imagenRedimensionada);
            throw new Exception("No se pudo guardar la imagen.");
        }

        // Libera memoria de las imágenes en memoria
        imagedestroy($imagenOriginal);
        imagedestroy($imagenRedimensionada);

        // Retorna el nombre generado para la imagen guardada
        return $nombreFinal;
    }
}
