<div class="text-center my-4">
    <a href="../router/index.php" class="btn btn-outline-secondary btn-lg shadow-sm rounded-pill px-4">
        <i class="bi bi-arrow-left-circle-fill me-2"></i> Volver al formulario
    </a>
</div>

<section class="container">
    <div class="table-responsive shadow-sm rounded-4 overflow-hidden">
        <table class="table table-hover table-borderless align-middle text-center mb-0">
            <thead class="bg-light text-dark fw-semibold">
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
                        <td colspan="6" class="text-muted py-4 fs-5">No hay recintos registrados</td>
                    </tr>
                <?php else: ?>
                    <?php foreach ($recintos as $m): ?>
                        <tr>
                            <th scope="row" class="fw-bold"><?= htmlspecialchars($m['id']) ?></th>
                            <td><?= htmlspecialchars($m['nombre']) ?></td>
                            <td>
                                <span class="badge bg-info text-dark px-3 py-2">
                                    <?= htmlspecialchars($m['tipo']) ?>
                                </span>
                            </td>
                            <td>
                                <span class="badge bg-secondary px-3 py-2">
                                    <?= htmlspecialchars($m['capacidad']) ?>
                                </span>
                            </td>
                            <td>
                                <?php if (!empty($m['imagen'])): ?>
                                    <img class="img-thumbnail rounded-circle shadow-sm border-0" 
                                         src="../model/images/<?= htmlspecialchars($m['imagen']) ?>" 
                                         style="height: 60px; width: 60px; object-fit: cover;" 
                                         alt="imagen de recintos">
                                <?php else: ?>
                                    <span class="text-muted fst-italic">Sin imagen</span>
                                <?php endif; ?>
                            </td>
                            <td>
                                <div class="btn-group btn-group-sm shadow-sm" role="group">
                                    <a href="?accion=editar&id=<?= $m['id'] ?>" 
                                       class="btn btn-outline-primary" title="Editar">
                                        <i class="bi bi-pencil-square"></i>
                                    </a>
                                    <a href="?accion=eliminar&id=<?= $m['id'] ?>" 
                                       class="btn btn-outline-danger" 
                                       onclick="return confirm('¿Seguro que quieres eliminar este recintos?');" 
                                       title="Eliminar">
                                        <i class="bi bi-trash3-fill"></i>
                                    </a>
                                    <button onclick="descargarFila(<?= $m['id'] ?>)" 
                                            class="btn btn-outline-warning" title="Descargar JSON">
                                        <i class="bi bi-download"></i>
                                    </button>
                                    <a href="?accion=conseguir&id=<?= $m['id'] ?>" 
                                       class="btn btn-outline-secondary" title="Ver">
                                        <i class="bi bi-eye-fill"></i>
                                    </a>
                                </div>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</section>

<!-- Paginación moderna -->
<?php if ($paginacion->totalPaginas() > 0): ?>
<section class="d-flex justify-content-center my-4">
    <nav aria-label="Page navigation">
        <ul class="pagination pagination-lg rounded-pill shadow-sm">
            <li class="page-item <?= ($paginaActual <= 1) ? 'disabled' : '' ?>">
                <a class="page-link" href="?accion=listar&pagina=<?= ($paginaActual - 1) ?>" aria-label="Anterior">
                    <span aria-hidden="true">&laquo;</span>
                </a>
            </li>
            <?php for ($i = 1; $i <= $paginacion->totalPaginas(); $i++): ?>
                <li class="page-item <?= ($i == $paginaActual) ? 'active' : '' ?>">
                    <a class="page-link" href="?accion=listar&pagina=<?= $i ?>"><?= $i ?></a>
                </li>
            <?php endfor; ?>
            <li class="page-item <?= ($paginaActual >= $paginacion->totalPaginas()) ? 'disabled' : '' ?>">
                <a class="page-link" href="?accion=listar&pagina=<?= ($paginaActual + 1) ?>" aria-label="Siguiente">
                    <span aria-hidden="true">&raquo;</span>
                </a>
            </li>
        </ul>
    </nav>
</section>
<?php endif; ?>

<?php if ($totalRegistros > 0): ?>
<p class="text-center text-muted mb-5 fw-light">
    Página <?= $paginaActual ?> — Mostrando 
    <?= min($paginacion->inicio() + $paginacion->registrosPorPagina, $totalRegistros) ?> 
    de <?= $totalRegistros ?> registros.
</p>
<?php endif; ?>
