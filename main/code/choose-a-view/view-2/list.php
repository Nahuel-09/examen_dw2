<div class="text-center my-4">
    <a href="../router/index.php" class="btn btn-outline-dark btn-lg shadow-sm">
        <i class="bi bi-arrow-left-circle-fill me-2"></i> Volver al formulario
    </a>
</div>

<section class="container">
    <div class="table-responsive shadow rounded">
        <table class="table table-striped table-hover table-bordered align-middle text-center">
            <thead class="table-dark">
                <tr>
                    <th>ID</th>
                    <th>Nombre</th>
                    <th>Tipo</th>
                    <th>Capacidad</th>
                    <th>Imagen</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php if (empty($recintos)): ?>
                    <tr>
                        <td colspan="6" class="text-muted">No hay recintos registrados</td>
                    </tr>
                <?php else: ?>
                    <?php foreach ($recintos as $m): ?>
                        <tr>
                            <th scope="row"><?= htmlspecialchars($m['id']) ?></th>
                            <td><?= htmlspecialchars($m['nombre']) ?></td>
                            <td><span class="badge bg-info text-dark"><?= htmlspecialchars($m['tipo']) ?></span></td>
                            <td><span class="badge bg-secondary"><?= htmlspecialchars($m['capacidad']) ?></span></td>
                            <td>
                                <?php if (!empty($m['imagen'])): ?>
                                    <img class="img-thumbnail rounded" src="../model/images/<?= htmlspecialchars($m['imagen']) ?>" style="height: 60px; width: 60px;" alt="imagen de recintos">
                                <?php else: ?>
                                    <span class="text-muted">Sin imagen</span>
                                <?php endif; ?>
                            </td>
                            <td class="d-flex justify-content-center flex-wrap gap-2">
                                <a href="?accion=editar&id=<?= $m['id'] ?>" class="btn btn-sm btn-primary">
                                    <i class="bi bi-pencil-square"></i>
                                </a>
                                <a href="?accion=eliminar&id=<?= $m['id'] ?>" class="btn btn-sm btn-danger" onclick="return confirm('¿Seguro que quieres eliminar este recintos?');">
                                    <i class="bi bi-trash3-fill"></i>
                                </a>
                                <button onclick="descargarFila(<?= $m['id'] ?>)" class="btn btn-sm btn-warning">
                                    <i class="bi bi-download"></i>
                                </button>
                                <a href="?accion=conseguir&id=<?= $m['id'] ?>" class="btn btn-sm btn-secondary">
                                    <i class="bi bi-eye-fill"></i>
                                </a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</section>

<?php if ($paginacion->totalPaginas() > 0): ?>
<section class="d-flex justify-content-center my-4">
    <nav aria-label="Page navigation">
        <ul class="pagination pagination-lg shadow-sm">
            <li class="page-item <?= ($paginaActual <= 1) ? 'disabled' : '' ?>">
                <a class="page-link" href="?accion=listar&pagina=<?= ($paginaActual - 1) ?>">&laquo;</a>
            </li>
            <?php for ($i = 1; $i <= $paginacion->totalPaginas(); $i++): ?>
                <li class="page-item <?= ($i == $paginaActual) ? 'active' : '' ?>">
                    <a class="page-link" href="?accion=listar&pagina=<?= $i ?>"><?= $i ?></a>
                </li>
            <?php endfor; ?>
            <li class="page-item <?= ($paginaActual >= $paginacion->totalPaginas()) ? 'disabled' : '' ?>">
                <a class="page-link" href="?accion=listar&pagina=<?= ($paginaActual + 1) ?>">&raquo;</a>
            </li>
        </ul>
    </nav>
</section>
<?php endif; ?>

<?php if ($totalRegistros > 0): ?>
<p class="text-center text-muted mb-5">
    Página <?= $paginaActual ?> — Mostrando <?= min($paginacion->inicio() + $paginacion->registrosPorPagina, $totalRegistros) ?> de <?= $totalRegistros ?> registros.
</p>
<?php endif; ?>