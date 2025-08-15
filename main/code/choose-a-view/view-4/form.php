<?php
$accion = isset($_GET['accion']) && $_GET['accion'] === 'editar' ? 'editar' : 'agregar';
$recintos = $recintos ?? [
    'id' => '',
    'nombre' => '',
    'tipo' => '',
    'capacidad' => '',
    'imagen' => ''
];
?>

<main class="d-flex justify-content-center align-items-center my-5">
    <form action="?accion=<?= $accion ?><?= ($accion === 'editar' && !empty($recintos['id'])) ? '&id=' . htmlspecialchars($recintos['id']) : '' ?>"
        enctype="multipart/form-data" method="post"
        class="p-5 rounded-4 shadow-lg border border-light"
        style="max-width: 800px; width: 100%; background: linear-gradient(145deg, #ffffff, #f8f9fa);" novalidate>

        <!-- Encabezado con gradiente -->
        <h2 class="text-center mb-5 fw-bold text-white p-3 rounded"
            style="background: linear-gradient(to right, #0d6efd, #6610f2);">
            <?= $accion === 'editar' ? 'Editar recintos' : 'Agregar recintos' ?>
        </h2>

        <input type="hidden" name="id" value="<?= htmlspecialchars($recintos['id'] ?? '', ENT_QUOTES) ?>">

        <!-- Nombre -->
        <div class="mb-4">
            <label for="nombre" class="form-label fw-semibold">Nombre</label>
            <input type="text" name="nombre" class="form-control form-control-lg rounded-pill shadow-sm border-primary"
                value="<?= htmlspecialchars($recintos['nombre'] ?? '', ENT_QUOTES) ?>" maxlength="100">
            <small class="text-muted">Ingrese un nombre (máx. 100 caracteres).</small>
        </div>

        <!-- Tipo -->
        <div class="mb-4">
            <label for="tipo" class="form-label fw-semibold">Tipo</label>
            <input type="text" name="tipo" class="form-control form-control-lg rounded-pill shadow-sm border-info"
                value="<?= htmlspecialchars($recintos['tipo'] ?? '', ENT_QUOTES) ?>">
            <small class="text-muted">Tipo de recintos (obligatorio).</small>
        </div>

        <!-- Capacidad -->
        <div class="mb-4">
            <label for="capacidad" class="form-label fw-semibold">Capacidad</label>
            <input type="number" name="capacidad" class="form-control form-control-lg rounded-pill shadow-sm border-success"
                value="<?= htmlspecialchars($recintos['capacidad'] ?? '', ENT_QUOTES) ?>" min="0" max="100">
            <small class="text-muted">Capacidad entre 0 y 100 personas.</small>
        </div>

        <!-- Imagen -->
        <div class="mb-4">
            <label for="imagen" class="form-label fw-semibold">Imagen</label>
            <input type="file" name="imagen" class="form-control form-control-lg rounded-pill shadow-sm border-warning">
            <small class="text-muted">Formatos aceptados: JPG, PNG, GIF, WEBP.</small>

            <?php if (!empty($recintos['imagen'])): ?>
                <div class="mt-4 text-center">
                    <img src="../model/images/<?= htmlspecialchars($recintos['imagen']) ?>" width="300"
                        alt="imagen actual" class="img-thumbnail rounded shadow-sm">
                    <div class="mt-3">
                        <label for="nombre_imagen" class="form-label fw-semibold">Cambiar nombre de la imagen</label>
                        <input type="text" name="nombre_imagen" class="form-control rounded-pill shadow-sm border-secondary"
                            value="<?= htmlspecialchars(pathinfo($recintos['imagen'], PATHINFO_FILENAME)) ?>">
                        <small class="text-muted">El nombre actual es: <strong><?= htmlspecialchars($recintos['imagen']) ?></strong></small>
                    </div>
                </div>
            <?php endif; ?>
        </div>

        <!-- Botones -->
        <div class="d-flex justify-content-between mt-5">
            <button type="submit"
                class="btn btn-lg text-white fw-bold rounded-pill shadow-sm px-5"
                style="background: linear-gradient(to right, #0d6efd, #6610f2);">
                <?= $accion === 'editar' ? 'Actualizar' : 'Enviar' ?>
            </button>
            <a href="../controller/index.php"
                class="btn btn-outline-secondary btn-lg fw-bold rounded-pill shadow-sm px-5">
                Cancelar
            </a>
        </div>
    </form>
</main>