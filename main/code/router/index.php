<?php
// Inicia el buffer de salida para evitar problemas con headers
ob_start();
// Inicia sesión para manejar variables $_SESSION
session_start();

// Incluye archivos necesarios con clases y configuraciones
require_once "../model/lib/utils/config.php";
require_once "../model/lib/utils/functions.php";
require_once "../model/lib/ConnDB.php";
require_once "../model/lib/ImgHandler.php";
require_once "../model/lib/Pagination.php";

// Crea instancia de la clase para conexión y manejo de BD
$conn = new ConnDB();
// Obtiene la acción enviada vía GET o cadena vacía si no existe
$accion = $_GET['accion'] ?? '';
// Obtiene el id enviado vía GET y lo convierte a entero
$id = intval($_GET['id'] ?? null);
// Obtener el total de registros en la tabla para calcular la paginación
$totalRegistros = $conn->contar();
// Obtener la página actual desde GET, asegurando que sea al menos 1
$paginaActual = isset($_GET['pagina']) ? max(1, intval($_GET['pagina'])) : 1;
$paginaTope = 4;
// Crear objeto de paginación con total registros, página actual y límite de registros por página (5)
$paginacion = new Pagination($totalRegistros, $paginaActual, $paginaTope);
// Obtener los registros de mascotas correspondientes a la página actual, usando los métodos de paginación
$mascotas = $conn->conseguirPagina($paginacion->inicio(), $paginacion->getLimite());
// Bandera para los JSONS
$bandera = isset($_GET['guardar']) && $_GET['guardar'] == '1' ? true : false;
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8"> <!-- Define la codificación de caracteres del documento como UTF-8 -->
    <meta name="viewport" content="width=device-width, initial-scale=1.0"> <!-- Hace que la página sea responsiva para dispositivos móviles -->
    <title>Examen Final DW2</title> <!-- Título que aparece en la pestaña del navegador -->
    <link rel="stylesheet" href="../model/src/bootstrap-5.3.7-dist/css/bootstrap.min.css"> <!-- Incluye los estilos CSS de Bootstrap para el diseño -->
    <link rel="stylesheet" href="../model/src/bootstrap-5.3.7-dist/css/bootstrap-icons.css">
    <link rel="stylesheet" href="../model/src/css/style.css">
</head>
<body>
    <section class="card text-center shadow shadow-sm rounded-4">
        <?php include "../controller/mainController.php" ?>
    </section>
    <script src="../model/src/bootstrap-5.3.7-dist/js/bootstrap.min.js"></script>
    <script src="../model/src/bootstrap-5.3.7-dist/js/bootstrap.bundle.min.js"></script>
    <script src="../model/src/js/script.js"></script>
</body>
</html>

<!-- src = ext -->