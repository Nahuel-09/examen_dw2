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
        class="p-5 rounded-4 shadow-lg border border-2 border-light"
        style="max-width: 800px; width: 100%; background: linear-gradient(145deg, #ffffff, #f1f3f5);" novalidate>

        <h2 class="text-center mb-5 text-white fw-bold" style="background: linear-gradient(to right, #0d6efd, #6610f2); border-radius:10px; color: transparent;">
            <?= $accion === 'editar' ? 'Editar mascotas' : 'Agregar mascotas' ?>
        </h2>

        <input type="hidden" name="id" value="<?= htmlspecialchars($mascotas['id'] ?? '', ENT_QUOTES) ?>">

        <div class="mb-4">
            <label for="nombre" class="form-label fw-semibold">Nombre:</label>
            <input type="text" class="form-control form-control-lg border rounded-pill border-primary shadow-sm" name="nombre" value="<?= htmlspecialchars($mascotas['nombre'] ?? '', ENT_QUOTES) ?>">
            <small class="form-text text-muted">Ingrese un nombre (máx. 100 caracteres).</small>
        </div>

        <div class="mb-4">
            <label for="especie" class="form-label fw-semibold">especie:</label>
            <input type="text" class="form-control form-control-lg border rounded-pill border-info shadow-sm" name="especie" value="<?= htmlspecialchars($mascotas['especie'] ?? '', ENT_QUOTES) ?>">
            <small class="form-text text-muted">especie de mascotas (obligatorio).</small>
        </div>

        <div class="mb-4">
            <label for="edad" class="form-label fw-semibold">edad:</label>
            <input type="number" class="form-control form-control-lg border rounded-pill border-success shadow-sm" name="edad" value="<?= htmlspecialchars($mascotas['edad'] ?? '', ENT_QUOTES) ?>">
            <small class="form-text text-muted">edad entre 0 y 100 personas.</small>
        </div>

        <div class="mb-4">
            <label for="foto" class="form-label fw-semibold">foto:</label>
            <input type="file" class="form-control form-control-lg border rounded-pill border-warning shadow-sm" name="foto">
            <small class="form-text text-muted">Formatos aceptados: JPG, PNG, GIF, WEBP.</small>

            <?php if (!empty($mascotas['foto'])): ?>
                <div class="mt-3 text-center">
                    <img src="../model/images/<?= $mascotas['foto'] ?>" width="300" alt="foto actual" class="img-thumbnail rounded shadow-sm">
                    <div class="mt-3">
                        <label for="nombre_foto" class="form-label fw-semibold">Cambiar nombre de la foto:</label>
                        <input type="text" class="form-control border rounded-pill border-secondary shadow-sm" name="nombre_foto" value="<?= pathinfo($mascotas['foto'], PATHINFO_FILENAME) ?>">
                        <small class="form-text text-muted">El nombre actual es: <strong><?= htmlspecialchars($mascotas['foto']) ?></strong></small>
                    </div>
                </div>
            <?php endif; ?>
        </div>

        <div class="d-flex justify-content-between mt-5">
            <button type="submit" class="btn btn-lg text-white fw-bold" style="background: linear-gradient(to right, #0d6efd, #6610f2); box-shadow: 0 4px 15px rgba(0,0,0,0.2); border-radius: 50px;">
                <?= $accion === 'editar' ? 'Actualizar' : 'Enviar' ?>
            </button>
            <a href="../controller/index.php" class="btn btn-outline-secondary btn-lg fw-bold rounded-pill">Cancelar</a>
        </div>
    </form>
</main>
