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
      class="p-5 bg-light shadow-lg rounded-4 border border-secondary" style="max-width: 800px; width: 100%;" novalidate>

    <h2 class="text-center mb-4 text-primary"><?= $accion === 'editar' ? 'Editar recintos' : 'Agregar recintos' ?></h2>

    <input type="hidden" name="id" value="<?= htmlspecialchars($recintos['id'] ?? '', ENT_QUOTES) ?>">

    <div class="mb-4">
      <label for="nombre" class="form-label fw-bold">Nombre:</label>
      <input type="text" class="form-control form-control-lg" name="nombre" value="<?= htmlspecialchars($recintos['nombre'] ?? '', ENT_QUOTES) ?>">
      <small class="form-text text-muted">Ingrese un nombre (máx. 100 caracteres).</small>
    </div>

    <div class="mb-4">
      <label for="tipo" class="form-label fw-bold">Tipo:</label>
      <input type="text" class="form-control form-control-lg" name="tipo" value="<?= htmlspecialchars($recintos['tipo'] ?? '', ENT_QUOTES) ?>">
      <small class="form-text text-muted">Tipo de recintos (obligatorio).</small>
    </div>

    <div class="mb-4">
      <label for="capacidad" class="form-label fw-bold">Capacidad:</label>
      <input type="number" class="form-control form-control-lg" name="capacidad" value="<?= htmlspecialchars($recintos['capacidad'] ?? '', ENT_QUOTES) ?>">
      <small class="form-text text-muted">Capacidad entre 0 y 100 personas.</small>
    </div>

    <div class="mb-4">
      <label for="imagen" class="form-label fw-bold">Imagen:</label>
      <input type="file" class="form-control form-control-lg" name="imagen">
      <small class="form-text text-muted">Formatos aceptados: JPG, PNG, GIF, WEBP.</small>

      <?php if (!empty($recintos['imagen'])): ?>
        <div class="mt-3 text-center">
            <img src="../model/images/<?= $recintos['imagen'] ?>" width="300" alt="imagen actual" class="img-thumbnail rounded">
            <div class="mt-2">
                <label for="nombre_imagen" class="form-label fw-bold">Cambiar nombre de la imagen:</label>
                <input type="text" class="form-control" name="nombre_imagen" value="<?= pathinfo($recintos['imagen'], PATHINFO_FILENAME) ?>">
                <small class="form-text text-muted">El nombre actual es: <strong><?= htmlspecialchars($recintos['imagen']) ?></strong></small>
            </div>
        </div>
      <?php endif; ?>
    </div>

    <div class="d-flex justify-content-between mt-4">
      <button type="submit" class="btn btn-success btn-lg"><?= $accion === 'editar' ? 'Actualizar' : 'Enviar' ?></button>
      <a href="../controller/index.php" class="btn btn-outline-secondary btn-lg">Cancelar</a>
    </div>
</form>
</main>