<?php
// Determina la acción actual según el parámetro GET 'accion'
// Si 'accion' es 'editar', asigna 'editar'; si no, por defecto es 'agregar'
$accion = isset($_GET['accion']) && $_GET['accion'] === 'editar' ? 'editar' : 'agregar';

// Inicializa el arreglo $recintos con valores vacíos si no existe previamente
$recintos = $recintos ?? [
    'id' => '',         // ID vacío para nuevo registro
    'nombre' => '',     // Nombre vacío
    'tipo' => '',    // Tipo vacía
    'capacidad' => '',       // Capacidad vacía
    'imagen' => ''        // Imagen vacía
];
?>

<!-- Contenedor centrado usando flexbox de Bootstrap -->
<main class="d-flex justify-content-center align-items-center">
    <form action="?accion=<?= $accion ?><?= ($accion === 'editar' && !empty($recintos['id'])) ? '&id=' . htmlspecialchars($recintos['id']) : '' ?>" enctype="multipart/form-data" method="post" class="p-4 border rounded" style="max-width: 800px; width: 100%;" novalidate>
        <!-- Título dinámico según acción -->
        <h2 class="text-center mb-4"> <?= $accion === 'editar' ? 'Editar recintos' : 'Agregar recintos' ?></h2>
        <!-- Campo oculto para el ID (necesario para editar registros) -->
        <input type="hidden" class="form-control" name="id" value="<?= htmlspecialchars($recintos['id'] ?? '', ENT_QUOTES) ?>">
        <!-- Campo para el nombre -->
        <div class="mb-3">
            <label for="nombre" class="form-label">Nombre: </label>
            <!-- Input tipo texto, valor recuperado y escapado para evitar XSS -->
            <input type="text" class="form-control" name="nombre" value="<?= htmlspecialchars($recintos['nombre'] ?? '', ENT_QUOTES) ?>">
            <p class="form-text text-muted">Ingrese un nombre (máx. 100 caracteres).</p> <!-- Ayuda al usuario -->
        </div>
        <!-- Campo para la tipo -->
        <div class="mb-3">
            <label for="tipo" class="form-label">Tipo:</label>
            <!-- Input tipo texto para la tipo -->
            <input type="text" class="form-control" name="tipo" value="<?= htmlspecialchars($recintos['tipo'] ?? '', ENT_QUOTES) ?>"> <br>
            <p class="form-text text-muted">Tipo del recintos (obligatorio).</p>
        </div>
        <!-- Campo para la capacidad -->
        <div class="mb-3">
            <label for="capacidad" class="form-label">Capacidad</label>
            <!-- Input tipo number para limitar ingreso numérico -->
            <input type="number" class="form-control" name="capacidad" value="<?= htmlspecialchars($recintos['capacidad'] ?? '', ENT_QUOTES) ?>">
            <p class="form-text text-muted">Capacidad entre 0 y 100 años.</p>
        </div>
        <!-- Campo para la imagen -->
        <div class="mb-3">
            <label for="imagen" class="form-label">Imagen:</label>
            <!-- Input tipo file para subir imagen -->
            <input type="file" class="form-control" name="imagen">
            <p class="form-text text-muted">Formatos aceptados: JPG, PNG, GIF, WEBP.</p>
            <!-- Si existe una imagen previa, la muestra con estilo miniatura -->
            <?php if (!empty($recintos['imagen'])): ?>
                <div class="mt-2">
                    <img src="../model/images/<?= $recintos['imagen'] ?>" width="350" alt="imagen actual" class="img-thumbnail rounded">
                    <br>
                    <!-- Campo para cambiar el nombre de la imagen -->
                    <label for="nombre_imagen" class="form-label mt-2">Cambiar nombre de la imagen:</label>
                    <input type="text" class="form-control" name="nombre_imagen" value="<?= pathinfo($recintos['imagen'], PATHINFO_FILENAME) ?>">
                    <small class="form-text text-muted">
                        El nombre actual es: <strong><?= htmlspecialchars($recintos['imagen']) ?></strong>
                    </small>
                </div>
            <?php endif; ?>
        </div>
        <!-- Botones para enviar o cancelar -->
        <div class="mb-3 ">
            <!-- Botón submit, texto dinámico según acción -->
            <button type="submit" class="btn btn-primary"><?= $accion === 'editar' ? 'Actualizar' : 'Enviar' ?></button>
            <!-- Botón para cancelar y regresar al listado -->
            <a href="../controller/index.php" class="btn btn-secondary">Cancelar</a>
        </div>
    </form>
</main>