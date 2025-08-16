<div class="text-center my-3">
    <a href="../router/index.php" class="btn btn-outline-secondary btn-lg">
        <i class="bi bi-arrow-left"></i> Volver al formulario
    </a>
</div>

<section class="container">
    <div class="table-responsive shadow-sm rounded">
        <table class="table table-hover table-bordered align-middle text-center">
            <thead class="table-primary">
                <tr>
                    <th>ID</th>
                    <th>Nombre</th>
                    <th>especie</th>
                    <th>edad</th>
                    <th>foto</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php if (empty($mascotas)): ?>
                    <tr>
                        <td colspan="6" class="text-muted">No hay mascotas registrados</td>
                    </tr>
                <?php else: ?>
                    <?php foreach ($mascotas as $m): ?>
                        <tr>
                            <th scope="row"><?= htmlspecialchars($m['id']) ?></th>
                            <td><?= htmlspecialchars($m['nombre']) ?></td>
                            <td><span class="badge bg-info"><?= htmlspecialchars($m['especie']) ?></span></td>
                            <td><span class="badge bg-secondary"><?= htmlspecialchars($m['edad']) ?></span></td>
                            <td>
                                <?php if (!empty($m['foto'])): ?>
                                    <img class="img-thumbnail" src="../model/images/<?= htmlspecialchars($m['foto']) ?>" style="height: 60px; width: 60px;" alt="foto de mascotas">
                                <?php else: ?>
                                    <span class="text-muted">Sin foto</span>
                                <?php endif; ?>
                            </td>
                            <td>
                                <a href="?accion=editar&id=<?= $m['id'] ?>" class="btn btn-sm btn-primary"><i class="bi bi-pencil"></i> Editar</a>
                                <a href="?accion=eliminar&id=<?= $m['id'] ?>" class="btn btn-sm btn-danger" onclick="return confirm('¿Seguro que quieres eliminar este mascotas?');"><i class="bi bi-trash"></i> Eliminar</a>
                                <a onclick="descargarFila(<?= $m['id'] ?>)" class="btn btn-sm btn-warning"><i class="bi bi-download"></i> JSON</a>
                                <a href="?accion=conseguir&id=<?= $m['id'] ?>" class="btn btn-sm btn-secondary"><i class="bi bi-eye"></i> Ver</a>
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
        <ul class="pagination pagination-lg">
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
    <p class="text-center text-muted">
        Página <?= $paginaActual ?> — Mostrando <?= min($paginacion->inicio() + $paginacion->registrosPorPagina, $totalRegistros) ?> de <?= $totalRegistros ?> registros.
    </p>
<?php endif; ?>
