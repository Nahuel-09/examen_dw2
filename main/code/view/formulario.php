<?php
// Determina la acción actual según el parámetro GET 'accion'
// Si 'accion' es 'editar', asigna 'editar'; si no, por defecto es 'agregar'
$accion = isset($_GET['accion']) && $_GET['accion'] === 'editar' ? 'editar' : 'agregar';

// Inicializa el arreglo $mascota con valores vacíos si no existe previamente
$mascota = $mascota ?? [
    'id' => '',         // ID vacío para nuevo registro
    'nombre' => '',     // Nombre vacío
    'especie' => '',    // Especie vacía
    'edad' => '',       // Edad vacía
    'foto' => ''        // Foto vacía
];
?>

<!-- Contenedor centrado usando flexbox de Bootstrap -->
<main class="d-flex justify-content-center align-items-center">

<!-- Formulario para agregar o editar mascota -->
<!--
  action: URL a la que se envía el formulario, construida dinámicamente
    - Si acción es 'editar' y hay id, agrega &id= con el id sanitizado
  enctype: multipart/form-data para subir archivos (imagen)
  method: POST para enviar datos
  clase y estilos Bootstrap para diseño responsivo y estética
  novalidate: deshabilita validación HTML5 para usar validación personalizada
-->
<form action="?accion=<?= $accion ?><?= ($accion === 'editar' && !empty($mascota['id'])) ? '&id=' . htmlspecialchars($mascota['id']) : '' ?>" enctype="multipart/form-data" method="post" class="p-4 border rounded" style="max-width: 800px; width: 100%;" novalidate>

    <!-- Título dinámico según acción -->
    <h2 class="text-center mb-4"> <?= $accion === 'editar' ? 'Editar Mascota' : 'Agregar Mascota' ?></h2>

    <!-- Campo oculto para el ID (necesario para editar registros) -->
    <input type="hidden" class="form-control" name="id" value="<?= htmlspecialchars($mascota['id'] ?? '', ENT_QUOTES) ?>">

    <!-- Campo para el nombre -->
    <div class="mb-3">
      <label for="nombre" class="form-label">Nombre: </label>
      <!-- Input tipo texto, valor recuperado y escapado para evitar XSS -->
      <input type="text" class="form-control" name="nombre" value="<?= htmlspecialchars($mascota['nombre'] ?? '', ENT_QUOTES) ?>">
      <p class="form-text text-muted">Ingrese un nombre (máx. 100 caracteres).</p> <!-- Ayuda al usuario -->
    </div>

    <!-- Campo para la especie -->
    <div class="mb-3">
      <label for="especie" class="form-label">Especie</label>
      <!-- Input tipo texto para la especie -->
      <input type="text" class="form-control" name="especie" value="<?= htmlspecialchars($mascota['especie'] ?? '', ENT_QUOTES) ?>"> <br>
      <p class="form-text text-muted">Especie de la mascota (obligatorio).</p>
    </div>

    <!-- Campo para la edad -->
    <div class="mb-3">
      <label for="edad" class="form-label">Edad</label>
      <!-- Input tipo number para limitar ingreso numérico -->
      <input type="number" class="form-control" name="edad" value="<?= htmlspecialchars($mascota['edad'] ?? '', ENT_QUOTES) ?>">
      <p class="form-text text-muted">Edad entre 0 y 100 años.</p>
    </div>

    <!-- Campo para la foto -->
    <div class="mb-3">
      <label for="foto" class="form-label">Foto</label>
      <!-- Input tipo file para subir imagen -->
      <input type="file" class="form-control" name="foto">
      <p class="form-text text-muted">Formatos aceptados: JPG, PNG, GIF, WEBP.</p>

      <!-- Si existe una foto previa, la muestra con estilo miniatura -->
      <?php if (!empty($mascota['foto'])): ?>
        <img src="../model/images/<?= $mascota['foto'] ?>" width="350" alt="Foto actual" class="img-thumbnail rounded">
      <?php endif;?>
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
