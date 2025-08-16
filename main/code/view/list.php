<br>
<div class="container">
    <a href="../router/index.php" class="btn btn-light text-center">Volver al formulario</a>
</div>
<br>
<!-- Contenedor principal -->
<section class="container">
    <!-- Tabla Bootstrap con estilos para mostrar mascotas -->
    <table class="table table-info table-striped-columns text-center justify-content-center align-items-center">
        <thead>
            <tr>
                <!-- Encabezados de columnas -->
                <th scope="col">ID</th>
                <th scope="col">Nombre</th>
                <th scope="col">Especie</th>
                <th scope="col">Edad</th>
                <th scope="col">Foto</th>
                <th scope="col">Acciones</th>
            </tr>
        </thead>
        <tbody>
            <!-- Verifica si no hay mascotas para mostrar -->
            <?php if (empty($mascotas)): ?>
                <tr>
                    <td colspan="6" class="text-center">No hay mascotas registradas</td>
                </tr>
            <?php else: ?>
                <!-- Recorre cada mascotas para mostrar en filas -->
                <?php foreach ($mascotas as $m): ?>
                    <tr class="container justify-content-center">
                        <!-- Mostrar cada campo con htmlspecialchars para evitar XSS -->
                        <th class="align-middle text-center" scope="row"><?= htmlspecialchars($m['id'] ?? '') ?></th>
                        <td class="align-middle text-center"><?= htmlspecialchars($m['nombre'] ?? '') ?></td>
                        <td class="align-middle text-center"><?= htmlspecialchars($m['especie'] ?? '') ?></td>
                        <td class="align-middle text-center"><?= htmlspecialchars($m['edad'] ?? '') ?></td>
                        <td class="align-middle text-center">
                            <!-- Mostrar foto miniatura si existe -->
                            <?php if (!empty($m['foto'])): ?>
                                <img class="img-thumbnail rounded" src="../model/images/<?= htmlspecialchars($m['foto']) ?>" style="max-height: 80px;" alt="foto de mascotas">
                            <?php endif; ?>
                        </td>
                        <td class="align-middle text-center">
                            <!-- Botones para editar, eliminar y descargar JSON de la mascotas -->
                            <a href="?accion=editar&id=<?= $m['id'] ?>" class="btn btn-sm me-2 btn-primary">Editar</a>
                            <a href="?accion=eliminar&id=<?= $m['id'] ?>" class="btn btn-sm me-2 btn-danger" onclick="return confirm('¿Seguro que quieres eliminar esta mascotas?');">Eliminar</a>
                            <a onclick="descargarFila(<?= $m['id'] ?>)" class="btn btn-sm me-2 btn-warning">Descargar JSON</a>
                            <a href="?accion=conseguir&id=<?= $m['id'] ?>" class="btn btn-sm me-2 btn-secondary">Ver JSON</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php endif; ?>
        </tbody>
    </table>
</section>

<br>
<br>

<!-- Verifica si hay más de una página para mostrar la paginación -->
<section class="d-flex justify-content-center">
    <?php if ($paginacion->totalPaginas() > 0): ?>
        <nav aria-label="Page navigation">
            <ul class="pagination">
                <!-- Botón para página anterior, deshabilitado si estamos en la primera página -->
                <li class="page-item <?= ($paginaActual <= 1) ? 'disabled' : '' ?>">
                    <a class="page-link" href="?accion=listar&pagina=<?= ($paginaActual - 1) ?>">&larr;</a>
                </li>

                <!-- Genera enlaces para cada página -->
                <?php for ($i = 1; $i <= $paginacion->totalPaginas(); $i++): ?>
                    <li class="page-item <?= ($i == $paginaActual) ? 'active' : '' ?>">
                        <a class="page-link" href="?accion=listar&pagina=<?= $i ?>"><?= $i ?></a>
                    </li>
                <?php endfor; ?>

                <!-- Botón para página siguiente, deshabilitado si estamos en la última página -->
                <li class="page-item <?= ($paginaActual >= $paginacion->totalPaginas()) ? 'disabled' : '' ?>">
                    <a class="page-link" href="?accion=listar&pagina=<?= ($paginaActual + 1) ?>">&rarr;</a>
                </li>
            </ul>
        </nav>
    <?php endif; ?>
</section>

<!-- Muestra información sobre los registros mostrados y total -->
<?php if ($totalRegistros > 0): ?>
    <p class="text-center mt-3">
        Pagina: <?= $paginaActual ?>, Filas tope: <?= $paginaTope ?>, Filas totales: <?= $totalRegistros ?>.
    </p>
<?php endif; ?>