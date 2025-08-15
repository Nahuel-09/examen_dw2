<br>
<div class="container">
    <a href="../router/index.php" class="btn btn-light text-center">Volver al formulario</a>
</div>
<br>
<!-- Contenedor principal -->
<section class="container">
    <!-- Tabla Bootstrap con estilos para mostrar recintos -->
    <table class="table table-info table-striped-columns text-center justify-content-center align-items-center">
        <thead>
            <tr>
                <!-- Encabezados de columnas -->
                <th scope="col">ID</th>
                <th scope="col">Nombre</th>
                <th scope="col">Tipo</th>
                <th scope="col">Capacidad</th>
                <th scope="col">imagen</th>
                <th scope="col">Acciones</th>
            </tr>
        </thead>
        <tbody>
            <!-- Verifica si no hay recintos para mostrar -->
            <?php if (empty($recintos)): ?>
                <tr>
                    <td colspan="6" class="text-center">No hay recintos registradas</td>
                </tr>
            <?php else: ?>
                <!-- Recorre cada recintos para mostrar en filas -->
                <?php foreach ($recintos as $m): ?>
                    <tr class="container justify-content-center">
                        <!-- Mostrar cada campo con htmlspecialchars para evitar XSS -->
                        <th class="align-middle text-center" scope="row"><?= htmlspecialchars($m['id'] ?? '') ?></th>
                        <td class="align-middle text-center"><?= htmlspecialchars($m['nombre'] ?? '') ?></td>
                        <td class="align-middle text-center"><?= htmlspecialchars($m['tipo'] ?? '') ?></td>
                        <td class="align-middle text-center"><?= htmlspecialchars($m['capacidad'] ?? '') ?></td>
                        <td class="align-middle text-center">
                            <!-- Mostrar imagen miniatura si existe -->
                            <?php if (!empty($m['imagen'])): ?>
                                <img class="img-thumbnail rounded" src="../model/images/<?= htmlspecialchars($m['imagen']) ?>" style="height: 40px; width: 40px; min-height: 80px; min-width: 80px;" alt="imagen de recintos">
                            <?php endif; ?>
                        </td>
                        <td class="align-middle text-center">
                            <!-- Botones para editar, eliminar y descargar JSON de la recintos -->
                            <a href="?accion=editar&id=<?= $m['id'] ?>" class="btn btn-sm me-2 btn-primary">Editar</a>
                            <a href="?accion=eliminar&id=<?= $m['id'] ?>" class="btn btn-sm me-2 btn-danger" onclick="return confirm('¿Seguro que quieres eliminar esta recintos?');">Eliminar</a>
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