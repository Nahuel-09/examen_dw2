<?php
// Determina la acción actual según el parámetro GET 'accion'
// Si 'accion' es 'editar', asigna 'editar'; si no, por defecto es 'agregar'
$accion = isset($_GET['accion']) && $_GET['accion'] === 'editar' ? 'editar' : 'agregar';

// Inicializa el arreglo $mascotas con valores vacíos si no existe previamente
$mascotas = $mascotas ?? [
    'id' => '',         // ID vacío para nuevo registro
    'nombre' => '',     // Nombre vacío
    'especie' => '',    // especie vacía
    'edad' => '',       // edad vacía
    'foto' => ''        // foto vacía
];
?>

<!-- Contenedor centrado usando flexbox de Bootstrap -->
<main class="d-flex justify-content-center align-items-center">
    <form action="?accion=<?= $accion ?><?= ($accion === 'editar' && !empty($mascotas['id'])) ? '&id=' . htmlspecialchars($mascotas['id']) : '' ?>" enctype="multipart/form-data" method="post" class="p-4 border rounded" style="max-width: 800px; width: 100%;" novalidate>
        <!-- Título dinámico según acción -->
        <h2 class="text-center mb-4"> <?= $accion === 'editar' ? 'Editar mascotas' : 'Agregar mascotas' ?></h2>
        <!-- Campo oculto para el ID (necesario para editar registros) -->
        <input type="hidden" class="form-control" name="id" value="<?= htmlspecialchars($mascotas['id'] ?? '', ENT_QUOTES) ?>">
        <!-- Campo para el nombre -->
        <div class="mb-3">
            <label for="nombre" class="form-label">Nombre: </label>
            <!-- Input especie texto, valor recuperado y escapado para evitar XSS -->
            <input type="text" class="form-control" name="nombre" value="<?= htmlspecialchars($mascotas['nombre'] ?? '', ENT_QUOTES) ?>">
            <p class="form-text text-muted">Ingrese un nombre (máx. 100 caracteres).</p> <!-- Ayuda al usuario -->
        </div>
        <!-- Campo para la especie -->
        <div class="mb-3">
            <label for="especie" class="form-label">Especie:</label>
            <!-- Input especie texto para la especie -->
            <input type="text" class="form-control" name="especie" value="<?= htmlspecialchars($mascotas['especie'] ?? '', ENT_QUOTES) ?>"> <br>
            <p class="form-text text-muted">Especie de la mascotas (obligatorio).</p>
        </div>
        <!-- Campo para la edad -->
        <div class="mb-3">
            <label for="edad" class="form-label">Edad</label>
            <!-- Input especie number para limitar ingreso numérico -->
            <input type="number" class="form-control" name="edad" value="<?= htmlspecialchars($mascotas['edad'] ?? '', ENT_QUOTES) ?>">
            <p class="form-text text-muted">Edad entre 0 y 100.</p>
        </div>
        <!-- Campo para la foto -->
        <div class="mb-3">
            <label for="foto" class="form-label">Foto:</label>
            <!-- Input especie file para subir foto -->
            <input type="file" class="form-control" name="foto">
            <p class="form-text text-muted">Formatos aceptados: JPG, PNG, GIF, WEBP.</p>
            <!-- Si existe una foto previa, la muestra con estilo miniatura -->
            <?php if (!empty($mascotas['foto'])): ?>
                <div class="mt-2">
                    <img src="../model/images/<?= $mascotas['foto'] ?>" width="350" alt="foto actual" class="img-thumbnail rounded">
                    <br>
                    <!-- Campo para cambiar el nombre de la foto -->
                    <label for="nombre_foto" class="form-label mt-2">Cambiar nombre de la foto:</label>
                    <input type="text" class="form-control" name="nombre_foto" value="<?= pathinfo($mascotas['foto'], PATHINFO_FILENAME) ?>">
                    <small class="form-text text-muted">
                        El nombre actual es: <strong><?= htmlspecialchars($mascotas['foto']) ?></strong>
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