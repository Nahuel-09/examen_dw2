<?php
$accion = isset($_GET['accion']) && $_GET['accion'] === 'editar' ? 'editar' : 'agregar';
$mascota = $mascota ?? [
    'id' => '',
    'nombre' => '',
    'especie' => '',
    'edad' => '',
    'foto' => ''
];
?>

<div class="d-flex justify-content-center align-items-center">
<form action="?accion=<?= $accion ?><?= ($accion === 'editar' && !empty($mascota['id'])) ? '&id=' . htmlspecialchars($mascota['id']) : '' ?>" enctype="multipart/form-data" method="post" class="p-4 border rounded" style="max-width: 800px; width: 100%;">
    <h2 class="text-center mb-4"> <?= $accion === 'editar' ? 'Editar Mascota' : 'Agregar Mascota' ?></h2>
    <input type="hidden" class="form-control" name="id" value="<?= htmlspecialchars($mascota['id'] ?? '', ENT_QUOTES) ?>">
    <div class="mb-3">
      <label for="nombre" class="form-label">Nombre: </label>
      <input type="text" class="form-control" name="nombre" value="<?= htmlspecialchars($mascota['nombre'] ?? '', ENT_QUOTES) ?>">
    </div>
    <div class="mb-3">
      <label for="especie" class="form-label">Especie</label>
      <input type="text" class="form-control" name="especie" value="<?= htmlspecialchars($mascota['especie'] ?? '', ENT_QUOTES) ?>">
    </div>
    <div class="mb-3">
      <label for="edad" class="form-label">Edad</label>
      <input type="number" class="form-control" name="edad" value="<?= htmlspecialchars($mascota['edad'] ?? '', ENT_QUOTES) ?>">
    </div>
    <div class="mb-3">
      <label for="foto" class="form-label">Foto</label>
      <input type="file" class="form-control" name="foto">
      <?php if (!empty($mascota['foto'])): ?>
        <img src="../model/images/<?= $mascota['foto'] ?>" width="350" alt="Foto actual" class="img-thumbnail rounded">
      <?php endif;?>
    </div>
    <div class="mb-3">
      <button type="submit" class="btn btn-primary"><?= $accion === 'editar' ? 'Actualizar' : 'Enviar' ?></button>
      <a href="../controller/index.php" class="btn btn-secondary">Cancelar</a>
    </div>
</form>
</div>