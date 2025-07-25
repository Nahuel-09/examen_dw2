<?php 
include "config.php";

class ImgHandler {
    public static function guardar($archivo, $destinoDir = SAVE_IMG, $anchoNuevo = 540, $calidad = 80) {
        if (!isset($archivo) || $archivo['error'] !== UPLOAD_ERR_OK) {
            throw new Exception("Error al subir la imagen.");
        }

        $maxTamano = 2 * 1024 * 1024; 
        if ($archivo['size'] > $maxTamano) {
            throw new Exception("La imagen es demasiado grande. Máximo permitido: 2MB.");
        }

        $tipoImagen = exif_imagetype($archivo['tmp_name']);
        $extensionesPermitidas = [
            IMAGETYPE_JPEG => ['ext' => '.jpg', 'create' => 'imagecreatefromjpeg', 'save' => 'imagejpeg'],
            IMAGETYPE_PNG  => ['ext' => '.png', 'create' => 'imagecreatefrompng',  'save' => 'imagepng'],
            IMAGETYPE_WEBP => ['ext' => '.webp','create' => 'imagecreatefromwebp', 'save' => 'imagewebp'],
            IMAGETYPE_GIF  => ['ext' => '.gif', 'create' => 'imagecreatefromgif',  'save' => 'imagegif'],
        ];

        if (!isset($extensionesPermitidas[$tipoImagen])) {
            throw new Exception("Tipo de imagen no soportado. Solo se permiten JPG, PNG, WEBP y GIF.");
        }

        $crearImagen = $extensionesPermitidas[$tipoImagen]['create'];
        $guardarImagen = $extensionesPermitidas[$tipoImagen]['save'];
        $extension = $extensionesPermitidas[$tipoImagen]['ext'];

        if (!is_dir($destinoDir)) {
            if (!mkdir($destinoDir, 0777, true)) {
                throw new Exception("No se pudo crear el directorio destino.");
            }
        }

        $nombreFinal = uniqid('img_', true) . $extension;
        $rutaFinal = rtrim($destinoDir, '/') . '/' . $nombreFinal;

        $imagenOriginal = @$crearImagen($archivo['tmp_name']);
        if (!$imagenOriginal) {
            throw new Exception("No se pudo cargar la imagen.");
        }

        $anchoOriginal = imagesx($imagenOriginal);
        $altoOriginal = imagesy($imagenOriginal);
        $altoNuevo = intval($anchoNuevo * $altoOriginal / $anchoOriginal);

        $imagenRedimensionada = imagecreatetruecolor($anchoNuevo, $altoNuevo);

        if ($tipoImagen === IMAGETYPE_PNG || $tipoImagen === IMAGETYPE_WEBP || $tipoImagen === IMAGETYPE_GIF) {
            imagealphablending($imagenRedimensionada, false);
            imagesavealpha($imagenRedimensionada, true);
        }

        imagecopyresampled(
            $imagenRedimensionada,
            $imagenOriginal,
            0, 0, 0, 0,
            $anchoNuevo, $altoNuevo,
            $anchoOriginal, $altoOriginal
        );

        $guardado = ($tipoImagen === IMAGETYPE_JPEG) 
            ? $guardarImagen($imagenRedimensionada, $rutaFinal, $calidad) 
            : $guardarImagen($imagenRedimensionada, $rutaFinal);

        if (!$guardado) {
            imagedestroy($imagenOriginal);
            imagedestroy($imagenRedimensionada);
            throw new Exception("No se pudo guardar la imagen.");
        }

        imagedestroy($imagenOriginal);
        imagedestroy($imagenRedimensionada);

        return $nombreFinal;
    }
}
