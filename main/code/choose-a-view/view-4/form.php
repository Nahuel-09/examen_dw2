<?php
$accion = isset($_GET['accion']) && $_GET['accion'] === 'editar' ? 'editar' : 'agregar';
$mascotas = $mascotas ?? [
    'id' => '',
    'nombre' => '',
    'especie' => '',
    'edad' => '',
    'foto' => ''
];
?>

<main class="d-flex justify-content-center align-items-center my-5">
    <form action="?accion=<?= $accion ?><?= ($accion === 'editar' && !empty($mascotas['id'])) ? '&id=' . htmlspecialchars($mascotas['id']) : '' ?>"
        enctype="multipart/form-data" method="post"
        class="p-5 rounded-4 shadow-lg border border-light"
        style="max-width: 800px; width: 100%; background: linear-gradient(145deg, #ffffff, #f8f9fa);" novalidate>

        <!-- Encabezado con gradiente -->
        <h2 class="text-center mb-5 fw-bold text-white p-3 rounded"
            style="background: linear-gradient(to right, #0d6efd, #6610f2);">
            <?= $accion === 'editar' ? 'Editar mascotas' : 'Agregar mascotas' ?>
        </h2>

        <input type="hidden" name="id" value="<?= htmlspecialchars($mascotas['id'] ?? '', ENT_QUOTES) ?>">

        <!-- Nombre -->
        <div class="mb-4">
            <label for="nombre" class="form-label fw-semibold">Nombre</label>
            <input type="text" name="nombre" class="form-control form-control-lg rounded-pill shadow-sm border-primary"
                value="<?= htmlspecialchars($mascotas['nombre'] ?? '', ENT_QUOTES) ?>" maxlength="100">
            <small class="text-muted">Ingrese un nombre (máx. 100 caracteres).</small>
        </div>

        <!-- especie -->
        <div class="mb-4">
            <label for="especie" class="form-label fw-semibold">especie</label>
            <input type="text" name="especie" class="form-control form-control-lg rounded-pill shadow-sm border-info"
                value="<?= htmlspecialchars($mascotas['especie'] ?? '', ENT_QUOTES) ?>">
            <small class="text-muted">especie de mascotas (obligatorio).</small>
        </div>

        <!-- edad -->
        <div class="mb-4">
            <label for="edad" class="form-label fw-semibold">edad</label>
            <input type="number" name="edad" class="form-control form-control-lg rounded-pill shadow-sm border-success"
                value="<?= htmlspecialchars($mascotas['edad'] ?? '', ENT_QUOTES) ?>" min="0" max="100">
            <small class="text-muted">edad entre 0 y 100 personas.</small>
        </div>

        <!-- foto -->
        <div class="mb-4">
            <label for="foto" class="form-label fw-semibold">foto</label>
            <input type="file" name="foto" class="form-control form-control-lg rounded-pill shadow-sm border-warning">
            <small class="text-muted">Formatos aceptados: JPG, PNG, GIF, WEBP.</small>

            <?php if (!empty($mascotas['foto'])): ?>
                <div class="mt-4 text-center">
                    <img src="../model/images/<?= htmlspecialchars($mascotas['foto']) ?>" width="300"
                        alt="foto actual" class="img-thumbnail rounded shadow-sm">
                    <div class="mt-3">
                        <label for="nombre_foto" class="form-label fw-semibold">Cambiar nombre de la foto</label>
                        <input type="text" name="nombre_foto" class="form-control rounded-pill shadow-sm border-secondary"
                            value="<?= htmlspecialchars(pathinfo($mascotas['foto'], PATHINFO_FILENAME)) ?>">
                        <small class="text-muted">El nombre actual es: <strong><?= htmlspecialchars($mascotas['foto']) ?></strong></small>
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